@php
    $groupIndex = $groupIndex ?? 0;
    $logicType = $logicType ?? 'AND';
    $criteria = $criteria ?? [['field_name' => '', 'operator' => '', 'values' => []]];
@endphp

<div class="criteria-group {{ $logicType === 'OR' ? 'or-group' : '' }}" data-group-index="{{ $groupIndex }}">
    <span class="criteria-group-label">{{ $logicType }}</span>
    <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeCriteriaGroup(this)">
        <i class="ti ti-x"></i>
    </button>
    
    <input type="hidden" name="criteria_groups[{{ $groupIndex }}][logic_type]" value="{{ $logicType }}">
    <input type="hidden" name="criteria_groups[{{ $groupIndex }}][sort_order]" value="{{ $groupIndex }}">
    
    <div class="criteria-rows">
        @foreach($criteria as $criteriaIndex => $criterion)
            @include('smart-sequences.partials.criteria-row', [
                'groupIndex' => $groupIndex,
                'criteriaIndex' => $criteriaIndex,
                'criterion' => $criterion
            ])
        @endforeach
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addCriteriaRow(this.closest('.criteria-group'))">
        <i class="ti ti-plus me-1"></i> Add Criteria
    </button>
</div>