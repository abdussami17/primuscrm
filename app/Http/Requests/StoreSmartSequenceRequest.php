<?php

namespace App\Http\Requests;

use App\Models\SequenceAction;
use App\Models\SequenceCriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSmartSequenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
            
            // Criteria Groups
            'criteria_groups' => ['required', 'array', 'min:1'],
            'criteria_groups.*.logic_type' => ['required', Rule::in(['AND', 'OR'])],
            'criteria_groups.*.sort_order' => ['integer', 'min:0'],
            'criteria_groups.*.criteria' => ['required', 'array', 'min:1'],
            
            // Individual Criteria
            'criteria_groups.*.criteria.*.field_name' => ['required', 'string'],
            'criteria_groups.*.criteria.*.operator' => ['required', 'string', Rule::in(array_keys(SequenceCriteria::getOperatorLabels()))],
            'criteria_groups.*.criteria.*.values' => ['nullable', 'array'],
            'criteria_groups.*.criteria.*.sort_order' => ['integer', 'min:0'],
            
            // Actions
            'actions' => ['required', 'array', 'min:1'],
            'actions.*.action_type' => ['required', 'string', Rule::in(array_keys(SequenceAction::getActionTypes()))],
            'actions.*.delay_value' => ['required', 'integer', 'min:0'],
            'actions.*.delay_unit' => ['required', Rule::in(array_keys(SequenceAction::getDelayUnits()))],
            'actions.*.parameters' => ['nullable', 'array'],
            'actions.*.sort_order' => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Sequence title is required.',
            'criteria_groups.required' => 'At least one criteria group is required.',
            'criteria_groups.*.criteria.required' => 'Each criteria group must have at least one criterion.',
            'actions.required' => 'At least one action is required.',
            'actions.*.action_type.required' => 'Action type is required.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set default sort orders if not provided
        if ($this->has('criteria_groups')) {
            $groups = $this->criteria_groups;
            foreach ($groups as $index => &$group) {
                $group['sort_order'] = $group['sort_order'] ?? $index;
                if (isset($group['criteria'])) {
                    foreach ($group['criteria'] as $cIndex => &$criterion) {
                        $criterion['sort_order'] = $criterion['sort_order'] ?? $cIndex;
                        $criterion['field_type'] = SequenceCriteria::getFieldType($criterion['field_name'] ?? '');
                    }
                }
            }
            $this->merge(['criteria_groups' => $groups]);
        }

        if ($this->has('actions')) {
            $actions = $this->actions;
            foreach ($actions as $index => &$action) {
                $action['sort_order'] = $action['sort_order'] ?? $index;
            }
            $this->merge(['actions' => $actions]);
        }
    }
}