<?php

namespace App\Http\Requests;

use App\Models\SequenceAction;
use App\Models\SequenceCriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSmartSequenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            
            // Criteria Groups (optional for partial updates)
            'criteria_groups' => ['sometimes', 'array', 'min:1'],
            'criteria_groups.*.id' => ['nullable', 'integer', 'exists:sequence_criteria_groups,id'],
            'criteria_groups.*.logic_type' => ['required_with:criteria_groups', Rule::in(['AND', 'OR'])],
            'criteria_groups.*.sort_order' => ['integer', 'min:0'],
            'criteria_groups.*.criteria' => ['required_with:criteria_groups', 'array', 'min:1'],
            
            // Individual Criteria
            'criteria_groups.*.criteria.*.id' => ['nullable', 'integer', 'exists:sequence_criteria,id'],
            'criteria_groups.*.criteria.*.field_name' => ['required_with:criteria_groups', 'string'],
            'criteria_groups.*.criteria.*.operator' => ['required_with:criteria_groups', 'string', Rule::in(array_keys(SequenceCriteria::getOperatorLabels()))],
            'criteria_groups.*.criteria.*.values' => ['nullable', 'array'],
            'criteria_groups.*.criteria.*.sort_order' => ['integer', 'min:0'],
            
            // Actions (optional for partial updates)
            'actions' => ['sometimes', 'array', 'min:1'],
            'actions.*.id' => ['nullable', 'integer', 'exists:sequence_actions,id'],
            'actions.*.action_type' => ['required_with:actions', 'string', Rule::in(array_keys(SequenceAction::getActionTypes()))],
            'actions.*.delay_value' => ['required_with:actions', 'integer', 'min:0'],
            'actions.*.delay_unit' => ['required_with:actions', Rule::in(array_keys(SequenceAction::getDelayUnits()))],
            'actions.*.parameters' => ['nullable', 'array'],
            'actions.*.sort_order' => ['integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
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