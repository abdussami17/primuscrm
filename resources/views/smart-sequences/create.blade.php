@extends('layouts.app')

@section('title', 'Create Smart Sequence')

@push('styles')
  <style>
    .criteria-group {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      position: relative;
      padding-top: 35px;
    }

    .criteria-group.or-group {
      background: #fff3cd;
      border: 1px solid #ffc107;

    }

    .criteria-group-label {
      position: absolute;
      top: -10px;
      left: 15px;
      background: #0d6efd;
      color: white;
      padding: 2px 10px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: bold;
    }

    .criteria-group.or-group .criteria-group-label {
      background: #ffc107;
      color: #000;
    }

    .criteria-rows-container {
      margin-top: 10px;
    }

    .criteria-row {
      background: white;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 10px;
      border: 1px solid #e9ecef;
    }

    .remove-group-btn {
      position: absolute;
      top: 5px;
      right: 5px;
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      cursor: pointer;
    }

    .remove-group-btn:hover {
      background: #c82333;
    }

    .add-criteria-button {
      background: #28a745;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      margin-right: 4px;
    }

    .add-criteria-button:hover {
      background: #218838;
    }

    .add-or-button {
      background: #ffc107;
      color: #000;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .add-or-button:hover {
      background: #e0a800;
    }

    .btn-icon-only {
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-icon-only:hover {
      background: #c82333;
    }

    .date-input-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .date-input-container span {
      color: #6c757d;
      font-size: 14px;
    }

    .action-delay-container-row {
      margin-bottom: 15px;
    }

    .action-sequence {
      font-size: 12px;
      padding: 3px 8px;
    }

    .check-btn {
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      margin-bottom: 5px;
    }

    .check-btn.valid {
      background: #28a745;
    }

    .check-btn.invalid {
      background: #dc3545;
    }

    /* .delete-btn {
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
    }

    .delete-btn:hover {
      background: #c82333;
    } */

    .add-action-button {
      background: #0d6efd;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      margin-bottom: 15px;
    }

    .add-action-button:hover {
      background: #0b5ed7;
    }
  </style>
@endpush

@section('content')
<form method="POST" action="{{ route('smart-sequences.store') }}" id="sequenceForm">
    @csrf
    
    <div class="content">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('smart-sequences.index') }}" class="text-decoration-none text-muted">
                    <i class="ti ti-arrow-left me-1"></i> Back to Sequences
                </a>
                <h4 class="mb-0 mt-2">Create Smart Sequence</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('smart-sequences.index') }}" class="btn btn-light border">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i> Save Sequence
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Configuration Section -->
        <div class="card mb-4">
            <div class="crm-header">
                <i class="ti ti-settings me-1"></i> Smart Configuration
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Sequence Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required placeholder="Enter sequence title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Criteria Section -->
        <div class="card mb-4">
            <div class="crm-header">
                <i class="ti ti-list-check me-1"></i> Smart Criteria
            </div>
            <div class="card-body">
                <div id="criteriaContainer">
                    @include('smart-sequences.partials.criteria-group', [
                        'groupIndex' => 0,
                        'logicType' => 'AND',
                        'criteria' => [['field_name' => '', 'operator' => '', 'values' => []]]
                    ])
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-success btn-sm" onclick="addCriteriaGroup('AND')">
                        <i class="ti ti-plus me-1"></i> Add AND Criteria
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="addCriteriaGroup('OR')">
                        <i class="ti ti-plus me-1"></i> Add OR Criteria
                    </button>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="card mb-4">
            <div class="crm-header">
                <i class="ti ti-repeat me-1"></i> Smart Actions & Delays
            </div>
            <div class="card-body">
                <div id="actionsContainer">
                    @include('smart-sequences.partials.action-row', [
                        'actionIndex' => 0,
                        'action' => null
                    ])
                </div>
                
                <button type="button" class="btn btn-primary btn-sm mt-3" onclick="addAction()">
                    <i class="ti ti-plus me-1"></i> Add Action
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Configuration data from backend
const fieldConfig = @json($fieldConfig);
const actionConfig = @json($actionConfig);
const users = @json($users);
const templates = @json($templates);

let groupCounter = {{ old('criteria_groups') ? count(old('criteria_groups')) : 1 }};
let actionCounter = {{ old('actions') ? count(old('actions')) : 1 }};

// Add criteria group
function addCriteriaGroup(logicType = 'AND') {
    const container = document.getElementById('criteriaContainer');
    const template = document.getElementById('criteriaGroupTemplate').content.cloneNode(true);
    
    const group = template.querySelector('.criteria-group');
    group.classList.toggle('or-group', logicType === 'OR');
    group.querySelector('.criteria-group-label').textContent = logicType;
    group.querySelector('[name*="logic_type"]').value = logicType;
    
    // Update names
    group.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace('__GROUP__', groupCounter);
    });
    
    container.appendChild(template);
    groupCounter++;
    
    // Initialize selects in new group
    initializeSelects(group);
}

// Add criteria row to group
function addCriteriaRow(groupElement) {
    const container = groupElement.querySelector('.criteria-rows');
    const groupIndex = groupElement.dataset.groupIndex;
    const criteriaIndex = container.children.length;
    
    const template = document.getElementById('criteriaRowTemplate').content.cloneNode(true);
    const row = template.querySelector('.criteria-row');
    
    row.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace('__GROUP__', groupIndex).replace('__CRITERIA__', criteriaIndex);
    });
    
    container.appendChild(template);
    initializeSelects(row);
}

// Remove criteria row
function removeCriteriaRow(button) {
    const row = button.closest('.criteria-row');
    const group = row.closest('.criteria-group');
    row.remove();
    
    // If no rows left, remove the group
    if (group.querySelectorAll('.criteria-row').length === 0) {
        group.remove();
    }
}

// Remove criteria group
function removeCriteriaGroup(button) {
    button.closest('.criteria-group').remove();
}

// Add action row
function addAction() {
    const container = document.getElementById('actionsContainer');
    const template = document.getElementById('actionTemplate').content.cloneNode(true);
    
    template.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace('__ACTION__', actionCounter);
    });
    
    template.querySelector('.action-number').textContent = actionCounter + 1;
    
    container.appendChild(template);
    actionCounter++;
    
    initializeSelects(container.lastElementChild);
    updateActionNumbers();
}

// Remove action
function removeAction(button) {
    button.closest('.action-card').remove();
    updateActionNumbers();
}

// Update action numbers
function updateActionNumbers() {
    document.querySelectorAll('.action-card').forEach((card, index) => {
        card.querySelector('.action-number').textContent = index + 1;
    });
}

// Handle field change - update operators
function handleFieldChange(selectElement) {
    const row = selectElement.closest('.criteria-row');
    const operatorSelect = row.querySelector('.operator-select');
    const valueContainer = row.querySelector('.value-container');
    
    const fieldName = selectElement.value;
    if (!fieldName) {
        operatorSelect.innerHTML = '<option value="">Select Operator</option>';
        operatorSelect.disabled = true;
        valueContainer.innerHTML = '';
        return;
    }
    
    // Find field type
    let fieldType = 'text';
    for (const [type, config] of Object.entries(fieldConfig.field_config)) {
        if (config.fields.includes(fieldName)) {
            fieldType = type;
            break;
        }
    }
    
    // Update operators
    const operators = fieldConfig.field_config[fieldType]?.operators || [];
    operatorSelect.innerHTML = '<option value="">Select Operator</option>';
    operators.forEach(op => {
        const option = document.createElement('option');
        option.value = op;
        option.textContent = fieldConfig.operators[op] || op;
        operatorSelect.appendChild(option);
    });
    operatorSelect.disabled = false;
    
    // Store field type for value handling
    row.dataset.fieldType = fieldType;
    row.dataset.fieldName = fieldName;
}

// Handle operator change - update value input
function handleOperatorChange(selectElement) {
    const row = selectElement.closest('.criteria-row');
    const valueContainer = row.querySelector('.value-container');
    const operator = selectElement.value;
    const fieldType = row.dataset.fieldType;
    const fieldName = row.dataset.fieldName;
    const baseName = row.querySelector('.field-select').name.replace('[field_name]', '[values][]');
    
    valueContainer.innerHTML = '';
    
    if (!operator || operator === 'is_blank' || operator === 'is_not_blank') {
        return;
    }
    
    // Create appropriate input based on field type and operator
    if (operator.includes('between')) {
        if (fieldType === 'date') {
            valueContainer.innerHTML = `
                <div class="d-flex gap-2 align-items-center">
                    <input type="date" name="${baseName}" class="form-control form-control-sm">
                    <span>to</span>
                    <input type="date" name="${baseName}" class="form-control form-control-sm">
                </div>`;
        } else {
            valueContainer.innerHTML = `
                <div class="d-flex gap-2 align-items-center">
                    <input type="number" name="${baseName}" class="form-control form-control-sm" placeholder="From">
                    <span>to</span>
                    <input type="number" name="${baseName}" class="form-control form-control-sm" placeholder="To">
                </div>`;
        }
    } else if (operator.includes('within_the_last')) {
        valueContainer.innerHTML = `
            <div class="d-flex gap-2 align-items-center">
                <input type="number" name="${baseName}" class="form-control form-control-sm" style="width:80px" min="0">
                <select name="${baseName}" class="form-select form-select-sm" style="width:120px">
                    <option value="minutes">Minutes</option>
                    <option value="hours">Hours</option>
                    <option value="days" selected>Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>`;
    } else if (fieldType === 'dropdown' && fieldConfig.dropdown_options[fieldName]) {
        const options = fieldConfig.dropdown_options[fieldName];
        let html = `<select name="${baseName}" class="form-select form-select-sm"><option value="">Select...</option>`;
        options.forEach(opt => {
            html += `<option value="${opt}">${opt}</option>`;
        });
        html += '</select>';
        valueContainer.innerHTML = html;
    } else if (fieldType === 'user') {
        let html = `<select name="${baseName}" class="form-select form-select-sm" multiple>`;
        users.forEach(user => {
            html += `<option value="${user.id}">${user.name}</option>`;
        });
        html += '</select>';
        valueContainer.innerHTML = html;
    } else if (fieldType === 'date') {
        valueContainer.innerHTML = `<input type="date" name="${baseName}" class="form-control form-control-sm">`;
    } else if (fieldType === 'number' || fieldType === 'year' || fieldType === 'interestrate') {
        valueContainer.innerHTML = `<input type="number" name="${baseName}" class="form-control form-control-sm" placeholder="Enter value">`;
    } else {
        valueContainer.innerHTML = `<input type="text" name="${baseName}" class="form-control form-control-sm" placeholder="Enter value">`;
    }
}

// Handle action type change
function handleActionTypeChange(selectElement) {
    const card = selectElement.closest('.action-card');
    const paramsContainer = card.querySelector('.action-params');
    const actionType = selectElement.value;
    const baseName = selectElement.name.replace('[action_type]', '[parameters]');
    
    paramsContainer.innerHTML = '';
    
    if (!actionType) return;
    
    let html = '';
    
    switch(actionType) {
        case 'task':
        case 'ai-draft-email':
        case 'ai-draft-text':
            html = `
                <select name="${baseName}[task_type]" class="form-select form-select-sm" required>
                    <option value="">Select Task Type</option>
                    ${actionConfig.task_types.map(t => `<option value="${t}">${t}</option>`).join('')}
                </select>
                <select name="${baseName}[assigned_to]" class="form-select form-select-sm" required>
                    <option value="">Assigned To</option>
                    <option value="assigned_to">Assigned To (Lead)</option>
                    <option value="secondary_assigned">Secondary Assigned</option>
                    <option value="bdc_agent">BDC Agent</option>
                    ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                </select>
                <select name="${baseName}[fallback]" class="form-select form-select-sm" required>
                    <option value="">Fallback Manager</option>
                    ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                </select>
                ${actionType === 'task' ? `<input type="text" name="${baseName}[description]" class="form-control form-control-sm" placeholder="Task description..." required>` : ''}
            `;
            break;
            
        case 'email':
        case 'text':
            html = `
                <select name="${baseName}[template]" class="form-select form-select-sm" required>
                    <option value="">Select Template</option>
                    ${templates.filter(t => t.type === actionType).map(t => `<option value="${t.id}">${t.name}</option>`).join('')}
                </select>
                <select name="${baseName}[from_address]" class="form-select form-select-sm" required>
                    <option value="">From Address</option>
                    <option value="assigned_to">Assigned To</option>
                    <option value="secondary_assigned">Secondary Assigned To</option>
                    <option value="bdc_agent">BDC Agent</option>
                    ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                </select>
                <select name="${baseName}[fallback]" class="form-select form-select-sm" required>
                    <option value="">Fallback</option>
                    ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                </select>
            `;
            break;
            
        case 'notify':
            html = `
                <select name="${baseName}[user]" class="form-select form-select-sm" required>
                    <option value="">Select User</option>
                    ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                </select>
                <input type="text" name="${baseName}[message]" class="form-control form-control-sm" placeholder="Notification message..." required>
            `;
            break;
            
        case 'change-status-lost':
            html = `
                <input type="hidden" name="${baseName}[status]" value="Lost">
                <select name="${baseName}[lost_reason]" class="form-select form-select-sm" required>
                    <option value="">Select Lost Reason</option>
                    ${actionConfig.lost_reasons.map(r => `<option value="${r}">${r}</option>`).join('')}
                </select>
            `;
            break;
            
        case 'change-sales-status':
            html = `<select name="${baseName}[status]" class="form-select form-select-sm" required>
                <option value="">Select Status</option>
                ${actionConfig.sales_status_options.map(s => `<option value="${s}">${s}</option>`).join('')}
            </select>`;
            break;
            
        case 'change-lead-status':
            html = `<select name="${baseName}[status]" class="form-select form-select-sm" required>
                <option value="">Select Status</option>
                ${actionConfig.lead_status_options.map(s => `<option value="${s}">${s}</option>`).join('')}
            </select>`;
            break;
            
        case 'change-status-type':
            html = `<select name="${baseName}[status]" class="form-select form-select-sm" required>
                <option value="">Select Status</option>
                ${actionConfig.status_type_options.map(s => `<option value="${s}">${s}</option>`).join('')}
            </select>`;
            break;
            
        case 'change-lead-type':
            html = `<select name="${baseName}[status]" class="form-select form-select-sm" required>
                <option value="">Select Lead Type</option>
                ${actionConfig.lead_type_options.map(s => `<option value="${s}">${s}</option>`).join('')}
            </select>`;
            break;
            
        case 'change-assigned-to':
        case 'change-assigned-manager':
        case 'change-bdc-agent':
        case 'change-finance-manager':
        case 'change-secondary-assigned-to':
        case 'reassign-lead':
            html = `<select name="${baseName}[user]" class="form-select form-select-sm" required>
                <option value="">Select User</option>
                ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
            </select>`;
            break;
    }
    
    paramsContainer.innerHTML = `<div class="d-flex flex-wrap gap-2 mt-2">${html}</div>`;
}

// Initialize TomSelect on elements
function initializeSelects(container) {
    container.querySelectorAll('select.field-select:not(.tomselected)').forEach(select => {
        new TomSelect(select, {
            create: false,
            sortField: { field: 'text', direction: 'asc' }
        });
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeSelects(document);
});
</script>

<!-- Templates -->
<template id="criteriaGroupTemplate">
    <div class="criteria-group" data-group-index="__GROUP__">
        <span class="criteria-group-label">AND</span>
        <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeCriteriaGroup(this)">
            <i class="ti ti-x"></i>
        </button>
        <input type="hidden" name="criteria_groups[__GROUP__][logic_type]" value="AND">
        <input type="hidden" name="criteria_groups[__GROUP__][sort_order]" value="__GROUP__">
        
        <div class="criteria-rows">
            @include('smart-sequences.partials.criteria-row-template')
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addCriteriaRow(this.closest('.criteria-group'))">
            <i class="ti ti-plus me-1"></i> Add Criteria
        </button>
    </div>
</template>

<template id="criteriaRowTemplate">
    @include('smart-sequences.partials.criteria-row-template')
</template>

<template id="actionTemplate">
    <div class="action-card">
        <span class="action-number">1</span>
        <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeAction(this)">
            <i class="ti ti-x"></i>
        </button>
        
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small">Action Type</label>
                <select name="actions[__ACTION__][action_type]" class="form-select form-select-sm" required onchange="handleActionTypeChange(this)">
                    <option value="">Select Action</option>
                    @foreach($actionConfig['action_types'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Delay Value</label>
                <input type="number" name="actions[__ACTION__][delay_value]" class="form-control form-control-sm" value="0" min="0">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Delay Unit</label>
                <select name="actions[__ACTION__][delay_unit]" class="form-select form-select-sm">
                    @foreach($actionConfig['delay_units'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small">Parameters</label>
                <div class="action-params"></div>
            </div>
        </div>
        <input type="hidden" name="actions[__ACTION__][sort_order]" value="__ACTION__">
    </div>
</template>
@endpush