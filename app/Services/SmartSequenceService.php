<?php

namespace App\Services;

use App\Models\SmartSequence;
use App\Models\SequenceCriteriaGroup;
use App\Models\SequenceCriteria;
use App\Models\SequenceAction;
use App\Models\SequenceExecutionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SmartSequenceService
{
    /**
     * Create a new smart sequence with all related data
     */
    public function create(array $data, int $userId): SmartSequence
    {
        return DB::transaction(function () use ($data, $userId) {
            // Create the main sequence
            $sequence = SmartSequence::create([
                'title' => $data['title'],
                'is_active' => $data['is_active'] ?? false,
                'created_by' => $userId,
            ]);

            // Create criteria groups and criteria
            $this->syncCriteriaGroups($sequence, $data['criteria_groups'] ?? []);

            // Create actions
            $this->syncActions($sequence, $data['actions'] ?? []);

            return $sequence->load(['criteriaGroups.criteria', 'actions']);
        });
    }

    /**
     * Update an existing smart sequence
     */
    public function update(SmartSequence $sequence, array $data): SmartSequence
    {
        return DB::transaction(function () use ($sequence, $data) {
            // Update main sequence
            $sequence->update([
                'title' => $data['title'] ?? $sequence->title,
                'is_active' => $data['is_active'] ?? $sequence->is_active,
            ]);

            // Sync criteria groups if provided
            if (isset($data['criteria_groups'])) {
                $this->syncCriteriaGroups($sequence, $data['criteria_groups']);
            }

            // Sync actions if provided
            if (isset($data['actions'])) {
                $this->syncActions($sequence, $data['actions']);
            }

            return $sequence->fresh(['criteriaGroups.criteria', 'actions']);
        });
    }

    /**
     * Sync criteria groups and their criteria
     */
    protected function syncCriteriaGroups(SmartSequence $sequence, array $groups): void
    {
        $existingGroupIds = [];

        foreach ($groups as $index => $groupData) {
            if (!empty($groupData['id'])) {
                // Update existing group
                $group = SequenceCriteriaGroup::find($groupData['id']);
                if ($group && $group->smart_sequence_id === $sequence->id) {
                    $group->update([
                        'logic_type' => $groupData['logic_type'],
                        'sort_order' => $groupData['sort_order'] ?? $index,
                    ]);
                    $existingGroupIds[] = $group->id;
                }
            } else {
                // Create new group
                $group = $sequence->criteriaGroups()->create([
                    'logic_type' => $groupData['logic_type'],
                    'sort_order' => $groupData['sort_order'] ?? $index,
                ]);
                $existingGroupIds[] = $group->id;
            }

            // Sync criteria for this group
            if (isset($groupData['criteria'])) {
                $this->syncCriteria($group, $groupData['criteria']);
            }
        }

        // Delete groups not in the update
        $sequence->criteriaGroups()
            ->whereNotIn('id', $existingGroupIds)
            ->delete();
    }

    /**
     * Sync criteria for a group
     */
    protected function syncCriteria(SequenceCriteriaGroup $group, array $criteria): void
    {
        $existingCriteriaIds = [];

        foreach ($criteria as $index => $criterionData) {
            $fieldType = SequenceCriteria::getFieldType($criterionData['field_name']);
            
            $criterionValues = [
                'field_name' => $criterionData['field_name'],
                'field_type' => $fieldType,
                'operator' => $criterionData['operator'],
                'values' => $criterionData['values'] ?? null,
                'sort_order' => $criterionData['sort_order'] ?? $index,
            ];

            if (!empty($criterionData['id'])) {
                $criterion = SequenceCriteria::find($criterionData['id']);
                if ($criterion && $criterion->criteria_group_id === $group->id) {
                    $criterion->update($criterionValues);
                    $existingCriteriaIds[] = $criterion->id;
                }
            } else {
                $criterion = $group->criteria()->create($criterionValues);
                $existingCriteriaIds[] = $criterion->id;
            }
        }

        // Delete criteria not in the update
        $group->criteria()
            ->whereNotIn('id', $existingCriteriaIds)
            ->delete();
    }

    /**
     * Sync actions for a sequence
     */
    protected function syncActions(SmartSequence $sequence, array $actions): void
    {
        $existingActionIds = [];

        foreach ($actions as $index => $actionData) {
            $actionValues = [
                'action_type' => $actionData['action_type'],
                'delay_value' => $actionData['delay_value'] ?? 0,
                'delay_unit' => $actionData['delay_unit'] ?? 'days',
                'parameters' => $actionData['parameters'] ?? null,
                'sort_order' => $actionData['sort_order'] ?? $index,
            ];

            if (!empty($actionData['id'])) {
                $action = SequenceAction::find($actionData['id']);
                if ($action && $action->smart_sequence_id === $sequence->id) {
                    $action->update($actionValues);
                    $action->validate();
                    $action->save();
                    $existingActionIds[] = $action->id;
                }
            } else {
                $action = $sequence->actions()->create($actionValues);
                $action->validate();
                $action->save();
                $existingActionIds[] = $action->id;
            }
        }

        // Delete actions not in the update
        $sequence->actions()
            ->whereNotIn('id', $existingActionIds)
            ->delete();
    }

    /**
     * Delete a sequence and all related data
     */
    public function delete(SmartSequence $sequence): bool
    {
        return DB::transaction(function () use ($sequence) {
            // Cancel any pending execution logs
            $sequence->executionLogs()
                ->where('status', SequenceExecutionLog::STATUS_PENDING)
                ->update(['status' => SequenceExecutionLog::STATUS_CANCELLED]);

            return $sequence->delete();
        });
    }

    /**
     * Duplicate a sequence
     */
    public function duplicate(SmartSequence $sequence): SmartSequence
    {
        return $sequence->duplicateSequence();
    }

    /**
     * Toggle sequence active status
     */
    public function toggleStatus(SmartSequence $sequence): SmartSequence
    {
        $sequence->is_active = !$sequence->is_active;
        $sequence->save();
        return $sequence;
    }

    /**
     * Get sequences with filters and pagination
     */
    public function getSequences(array $filters = [], int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = SmartSequence::with(['creator', 'criteriaGroups.criteria', 'actions']);

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';
        $query->orderBy($sortField, $sortDir);

        return $query->paginate($perPage);
    }

    /**
     * Get field configuration for frontend
     */
    public function getFieldConfiguration(): array
    {
        return [
            'fields' => SequenceCriteria::getAllFields(),
            'field_config' => SequenceCriteria::getFieldConfig(),
            'operators' => SequenceCriteria::getOperatorLabels(),
            'dropdown_options' => SequenceCriteria::getDropdownOptions(),
        ];
    }

    /**
     * Get action configuration for frontend
     */
    public function getActionConfiguration(): array
    {
        return [
            'action_types' => SequenceAction::getActionTypes(),
            'delay_units' => SequenceAction::getDelayUnits(),
            'task_types' => SequenceAction::getTaskTypes(),
            'sales_status_options' => SequenceAction::getSalesStatusOptions(),
            'status_type_options' => SequenceAction::getStatusTypeOptions(),
            'lead_status_options' => SequenceAction::getLeadStatusOptions(),
            'lead_type_options' => SequenceAction::getLeadTypeOptions(),
            'lost_reasons' => SequenceAction::getLostReasons(),
        ];
    }

    /**
     * Validate all actions in a sequence
     */
    public function validateSequenceActions(SmartSequence $sequence): array
    {
        $results = [];
        foreach ($sequence->actions as $action) {
            $isValid = $action->validate();
            $action->save();
            $results[$action->id] = $isValid;
        }
        return $results;
    }
}