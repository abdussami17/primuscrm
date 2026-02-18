@php
    $allFields = \App\Models\SequenceCriteria::getAllFields();
@endphp

<div class="criteria-row">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small">Field</label>
            <select name="criteria_groups[__GROUP__][criteria][__CRITERIA__][field_name]" 
                    class="form-select form-select-sm field-select" 
                    onchange="handleFieldChange(this)">
                <option value="">Select Field</option>
                @foreach($allFields as $field)
                    <option value="{{ $field['value'] }}">{{ $field['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">Operator</label>
            <select name="criteria_groups[__GROUP__][criteria][__CRITERIA__][operator]" 
                    class="form-select form-select-sm operator-select"
                    onchange="handleOperatorChange(this)" disabled>
                <option value="">Select Operator</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small">Value</label>
            <div class="value-container"></div>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCriteriaRow(this)">
                <i class="ti ti-trash"></i>
            </button>
        </div>
    </div>
    <input type="hidden" name="criteria_groups[__GROUP__][criteria][__CRITERIA__][sort_order]" value="0">
</div>