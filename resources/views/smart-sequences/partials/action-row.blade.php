@php
    $actionIndex = $actionIndex ?? 0;
    $action = $action ?? null;
    $actionTypes = \App\Models\SequenceAction::getActionTypes();
    $delayUnits = \App\Models\SequenceAction::getDelayUnits();
@endphp

<div class="action-card">
    <span class="action-number">{{ $actionIndex + 1 }}</span>
    <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeAction(this)">
        <i class="ti ti-x"></i>
    </button>
    
    <div class="row g-2">
        <div class="col-md-3">
            <label class="form-label small">Action Type</label>
            <select name="actions[{{ $actionIndex }}][action_type]" 
                    class="form-select form-select-sm" 
                    required 
                    onchange="handleActionTypeChange(this)">
                <option value="">Select Action</option>
                @foreach($actionTypes as $value => $label)
                    <option value="{{ $value }}" {{ ($action['action_type'] ?? '') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small">Delay Value</label>
            <input type="number" 
                   name="actions[{{ $actionIndex }}][delay_value]" 
                   class="form-control form-control-sm" 
                   value="{{ $action['delay_value'] ?? 0 }}" 
                   min="0">
        </div>
        <div class="col-md-2">
            <label class="form-label small">Delay Unit</label>
            <select name="actions[{{ $actionIndex }}][delay_unit]" class="form-select form-select-sm">
                @foreach($delayUnits as $value => $label)
                    <option value="{{ $value }}" {{ ($action['delay_unit'] ?? 'days') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label small">Parameters</label>
            <div class="action-params">
                {{-- Parameters will be populated by JavaScript based on action type --}}
            </div>
        </div>
    </div>
    <input type="hidden" name="actions[{{ $actionIndex }}][sort_order]" value="{{ $actionIndex }}">
</div>