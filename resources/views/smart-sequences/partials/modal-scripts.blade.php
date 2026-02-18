@push('scripts')
@verbatim
<script>
function replaceTokens(content, values) {
    return content.replace(/{{\s*(.*?)\s*}}/g, function(match, token) {
        var key = token.trim();
        return values.hasOwnProperty(key) ? values[key] : match;
    });
}
</script>
@endverbatim
<script>
        (function() {
            // Inject component styles for vertical action controls
            try {
                const _css = `
    .ss-action-controls{display:flex;flex-direction:column;align-items:center;gap:10px}
    .ss-action-btn{background:transparent;border:0;display:flex;flex-direction:column;align-items:center;color:#0b1f3a}
    .ss-action-btn .icon{font-size:18px}
    .ss-action-label{font-size:12px;color:#6c757d;margin-top:4px}
    .ss-check-btn.invalid .icon{color:red}
    .ss-check-btn.valid .icon{color:rgb(0,33,64)}
    .ss-clone-btn{color:#0b1f3a;padding:6px;}
    .ss-delete-btn{color:#dc3545;border:0;background:transparent}
    /* Unsaved modal custom styles to match site look and feel */
    #unsavedConfirmModal .modal-content{border-radius:12px;background:linear-gradient(180deg,#ffffff,#f7fbff);box-shadow:0 12px 30px rgba(2,6,23,0.08);border:1px solid rgba(13,110,253,0.06);}
    #unsavedConfirmModal .modal-header{border-bottom:none;padding-bottom:0}
    #unsavedConfirmModal .modal-body{padding-top:4px;padding-bottom:10px}
    #unsavedConfirmModal .unsaved-icon{font-size:40px;color:#0d6efd;margin-bottom:6px}
    #unsavedConfirmModal .unsaved-title{font-weight:700;color:#073b6b;margin-bottom:4px}
    #unsavedConfirmModal .unsaved-desc{color:#495057;margin-bottom:10px}
    #unsavedConfirmModal .modal-footer{border-top:none;display:flex;justify-content:center;gap:8px;padding-top:6px}
    #unsavedConfirmModal .btn{min-width:110px}
    `;
                const __style = document.createElement('style');
                __style.type = 'text/css';
                __style.appendChild(document.createTextNode(_css));
                document.head.appendChild(__style);
            } catch (e) {
                console.debug('style inject failed', e);
            }
            // Extra styles for drag & drop
            try {
                const _dnd = `
        .action-delay-container-row.dragging{opacity:0.5}
        .action-delay-container-row.drag-over{outline:2px dashed #0d6efd}
        `;
                const __dnd = document.createElement('style');
                __dnd.type = 'text/css';
                __dnd.appendChild(document.createTextNode(_dnd));
                document.head.appendChild(__dnd);
            } catch (e) {}
            // Ensure floating button visibility helper exists globally
            try {
                window.updateFloatingAddVisibility = function() {
                    try {
                        const btn = document.getElementById('addActionFloatBtn');
                        if (!btn) return;
                        const cnt = document.querySelectorAll('.action-delay-container-row').length;
                        btn.style.display = cnt > 3 ? 'block' : 'none';
                    } catch (e) {
                        /* ignore */ }
                };
            } catch (e) {}
            // Field Configuration
            const FIELD_CONFIG = @json(\App\Models\SequenceCriteria::getFieldConfig());
            const DROPDOWN_OPTIONS = @json(\App\Models\SequenceCriteria::getDropdownOptions());
            const ALL_FIELDS = @json(\App\Models\SequenceCriteria::getAllFields());
            const OPERATOR_LABELS = @json(\App\Models\SequenceCriteria::getOperatorLabels());
            const ACTION_TYPES = @json(\App\Models\SequenceAction::getActionTypes());
            const DELAY_UNITS = @json(\App\Models\SequenceAction::getDelayUnits());
            const TASK_TYPES = @json(\App\Models\SequenceAction::getTaskTypes());
            const SALES_STATUS_OPTIONS = @json(\App\Models\SequenceAction::getSalesStatusOptions());
            const STATUS_TYPE_OPTIONS = @json(\App\Models\SequenceAction::getStatusTypeOptions());
            const LEAD_STATUS_OPTIONS = @json(\App\Models\SequenceAction::getLeadStatusOptions());
            const LEAD_TYPE_OPTIONS = @json(\App\Models\SequenceAction::getLeadTypeOptions());
            const LOST_REASONS = @json(\App\Models\SequenceAction::getLostReasons());
            const SUB_LOST_STATUS = ['Sold', 'Lost', 'Pending', 'Active', 'Invalid'];

            const USERS = @json($users ?? []);
            const TEMPLATES = @json($templates ?? []);
            const ROLES = @json($roles ?? []);

            const USER_FIELDS = ['createdby', 'assignedby', 'assignedto', 'assignedmanager', 'bdcagent', 'bdcmanager',
                'financemanager', 'generalmanger', 'inventorymanager', 'salesmanager', 'secondaryassigned',
                'serviceadvisor', 'updatedby'
            ];

            const DATE_FIELDS_WITHIN_LAST = ['appointmentcreationdate', 'createddate', 'appointmentdate',
                'assigneddate', 'birthday', 'deliverydate', 'demodate', 'financematuritydate',
                'financestartdate', 'firstcontactdate', 'lastcontacteddate', 'leasematuritydate',
                'leasestartdate', 'solddate', 'taskcompleteddate', 'taskduedate', 'updated', 'showroomvisitdate'
            ];

            let groupCounter = 0;
            let actionCounter = 0;
            let tomSelectInstances = [];
            window.isEditMode = false;

            function waitForTomSelect(callback) {
                if (typeof TomSelect !== 'undefined') {
                    callback();
                } else {
                    setTimeout(() => waitForTomSelect(callback), 100);
                }
            }
            // update floating button visibility if helper exists
            try {
                if (typeof window.updateFloatingAddVisibility === 'function') window.updateFloatingAddVisibility();
            } catch (e) {}

            function getFieldType(fieldName) {
                for (let type in FIELD_CONFIG) {
                    if (FIELD_CONFIG[type].fields && FIELD_CONFIG[type].fields.includes(fieldName)) {
                        return type;
                    }
                }
                return 'text';
            }

            function addCriteriaGroup(isOrGroup = false, criteriaCount = 1) {
                console.count('addCriteriaGroup called');
                groupCounter++;
                const groupId = `group-${groupCounter}`;

                const group = document.createElement('div');
                group.className = `criteria-group ${isOrGroup ? 'or-group' : ''}`;
                group.id = groupId;
                group.dataset.isOr = isOrGroup;

                group.innerHTML = `
            <span class="criteria-group-label">${isOrGroup ? 'OR' : 'AND'}</span>
            <button type="button" class="remove-group-btn" data-group-id="${groupId}"><i class="ti ti-x"></i></button>
            <input type="hidden" name="criteria_groups[${groupCounter}][logic_type]" value="${isOrGroup ? 'OR' : 'AND'}">
            <input type="hidden" name="criteria_groups[${groupCounter}][sort_order]" value="${groupCounter}">
            <div class="criteria-rows-container"></div>
        `;

                document.getElementById('criteria-container').appendChild(group);

                group.querySelector('.remove-group-btn').addEventListener('click', function() {
                    removeGroup(this.dataset.groupId);
                });

                // If an add-row button exists (older markup), attach handler; otherwise rows are added programmatically
                const addRowBtn = group.querySelector('.add-row-btn');
                if (addRowBtn) {
                    addRowBtn.addEventListener('click', function() {
                        addCriteriaToGroup(groupId);
                    });
                }

                for (let i = 0; i < criteriaCount; i++) {
                    addCriteriaToGroup(groupId);
                }

                return groupId;
            }

            function addCriteriaToGroup(groupId) {
                const group = document.getElementById(groupId);
                if (!group) return;

                const container = group.querySelector('.criteria-rows-container');
                const groupIndex = groupId.split('-')[1];
                const criteriaIndex = container.children.length;

                const rowId = `criteria-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
                const row = document.createElement('div');
                row.className = 'criteria-row row align-items-end g-2';
                row.id = rowId;

                row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label small">Field</label>
                <select class="form-select field-select" name="criteria_groups[${groupIndex}][criteria][${criteriaIndex}][field_name]"></select>
            </div>
            <div class="col-md-3 operator-col" style="display: none;">
                <label class="form-label small">Operator</label>
                <select class="form-select operator-select" name="criteria_groups[${groupIndex}][criteria][${criteriaIndex}][operator]"></select>
            </div>
            <div class="col-md-4 value-col" style="display: none;">
                <label class="form-label small">Value</label>
                <div class="value-input-container"></div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-icon-only remove-row-btn"><i class="ti ti-trash"></i></button>
            </div>
            <input type="hidden" name="criteria_groups[${groupIndex}][criteria][${criteriaIndex}][sort_order]" value="${criteriaIndex}">
        `;

                container.appendChild(row);

                row.querySelector('.remove-row-btn').addEventListener('click', function() {
                    removeCriteriaRow(rowId, groupId);
                });

                const fieldSelect = row.querySelector('.field-select');
                const fieldTs = new TomSelect(fieldSelect, {
                    options: ALL_FIELDS,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: ['text', 'value'],
                    create: false,
                    maxOptions: null,
                    placeholder: '-- Select Field --',
                    onChange: function(value) {
                        handleFieldChange(rowId, value, groupIndex, criteriaIndex);
                    }
                });
                tomSelectInstances.push(fieldTs);

                return rowId;
            }

            function handleFieldChange(rowId, fieldValue, groupIndex, criteriaIndex) {
                const row = document.getElementById(rowId);
                if (!row) return;

                const operatorCol = row.querySelector('.operator-col');
                const operatorSelect = row.querySelector('.operator-select');
                const valueCol = row.querySelector('.value-col');

                if (!fieldValue) {
                    operatorCol.style.display = 'none';
                    valueCol.style.display = 'none';
                    return;
                }

                const fieldType = getFieldType(fieldValue);
                const config = FIELD_CONFIG[fieldType];

                operatorCol.style.display = 'block';

                if (operatorSelect.tomselect) {
                    operatorSelect.tomselect.destroy();
                }

                operatorSelect.innerHTML = '<option value="">-- Select Operator --</option>';
                if (config && config.operators) {
                    config.operators.forEach(op => {
                        const option = document.createElement('option');
                        option.value = op;
                        option.textContent = OPERATOR_LABELS[op] || op;
                        operatorSelect.appendChild(option);
                    });
                }

                const operatorTs = new TomSelect(operatorSelect, {
                    create: false,
                    onChange: function(value) {
                        handleOperatorChange(rowId, fieldValue, value, groupIndex, criteriaIndex);
                    }
                });
                tomSelectInstances.push(operatorTs);

                return operatorTs;
            }

            function handleOperatorChange(rowId, fieldValue, operatorValue, groupIndex, criteriaIndex) {
                const row = document.getElementById(rowId);
                if (!row) return;

                const valueCol = row.querySelector('.value-col');
                const valueContainer = row.querySelector('.value-input-container');

                if (!operatorValue) {
                    valueCol.style.display = 'none';
                    valueContainer.innerHTML = '';
                    return;
                }

                const fieldType = getFieldType(fieldValue);

                if (operatorValue === 'is_blank' || operatorValue === 'is_not_blank') {
                    valueCol.style.display = 'none';
                    valueContainer.innerHTML = '';
                    return;
                }

                valueCol.style.display = 'block';
                valueContainer.innerHTML = '';

                const baseName = `criteria_groups[${groupIndex}][criteria][${criteriaIndex}][values][]`;

                // ============================================
                // FIXED: Multi-select with TomSelect for specified fields
                // ============================================
                const MULTISELECT_FIELDS = [
                    'leadtype', 'leadstatus', 'inventorytype', 'source',
                    'salestatus', 'salestype', 'dealtype', 'tasktype', 'statustype'
                ];

                // Check if this field should use multi-select with TomSelect
                if (MULTISELECT_FIELDS.includes(fieldValue) &&
                    (operatorValue === 'is' || operatorValue === 'is_not') &&
                    DROPDOWN_OPTIONS[fieldValue]) {

                    // Create a multi-select element
                    let html =
                        `<select class="form-select multi-select-tom" name="${baseName}" multiple placeholder="Select options...">`;

                    // Add all options
                    DROPDOWN_OPTIONS[fieldValue].forEach(opt => {
                        html += `<option value="${opt}">${opt}</option>`;
                    });

                    html += `</select>`;

                    valueContainer.innerHTML = html;

                    // Initialize TomSelect on the multi-select
                    const select = valueContainer.querySelector('select');
                    if (select && typeof TomSelect !== 'undefined') {
                        // Destroy any existing TomSelect instance
                        if (select.tomselect) {
                            select.tomselect.destroy();
                        }

                        // Create new TomSelect with multi-select plugins
                        const ts = new TomSelect(select, {
                            plugins: {
                                'remove_button': {
                                    title: 'Remove selected option',
                                },
                                'checkbox_options': {
                                    // Using the built-in checkbox plugin
                                }
                            },
                            create: false,
                            placeholder: '-- Select Options --',
                            maxItems: null, // Allow unlimited selections
                            hideSelected: true, // Hide selected items from dropdown
                            // REMOVED the custom render that was adding duplicate checkboxes
                            onItemAdd: function() {
                                this.refreshOptions();
                            },
                            onItemRemove: function() {
                                this.refreshOptions();
                            }
                        });

                        tomSelectInstances.push(ts);

                        // If we're in edit mode and have values, set them
                        if (row.dataset.editValues) {
                            try {
                                const values = JSON.parse(row.dataset.editValues);
                                if (Array.isArray(values) && values.length > 0) {
                                    ts.setValue(values);
                                }
                            } catch (e) {}
                        }
                    }

                    return;
                }
                // ============================================
                // End of TomSelect multi-select code
                // ============================================


                // Special handling for priority field
                if (fieldValue === 'priority' && (operatorValue === 'is' || operatorValue === 'is_not')) {
                    // Create a select with truly blank option and High
                    let html = `<select class="form-select" name="${baseName}">`;
                    html += `<option value=""></option>`; // Truly blank option
                    html += `<option value="High">High</option>`;
                    html += `</select>`;
                    valueContainer.innerHTML = html;

                    // Initialize TomSelect with custom settings
                    const select = valueContainer.querySelector('select');
                    if (select && typeof TomSelect !== 'undefined') {
                        // Destroy any existing TomSelect instance
                        if (select.tomselect) {
                            select.tomselect.destroy();
                        }

                        // Create new TomSelect with allowEmptyOption: true
                        const ts = new TomSelect(select, {
                            create: false,
                            placeholder: '', // Empty placeholder
                            allowEmptyOption: true,
                            render: {
                                option: function(data, escape) {
                                    if (data.value === '') {
                                        return '<div class="option">&nbsp;</div>'; // Non-breaking space for blank option
                                    }
                                    return '<div class="option">' + escape(data.text) + '</div>';
                                },
                                item: function(data, escape) {
                                    if (data.value === '') {
                                        return '<div class="item">&nbsp;</div>'; // Non-breaking space for selected blank
                                    }
                                    return '<div class="item">' + escape(data.text) + '</div>';
                                }
                            }
                        });
                        tomSelectInstances.push(ts);
                    }

                    return;
                }
                if (operatorValue === 'is_within_the_last' || operatorValue === 'is_not_within_the_last') {
                    valueContainer.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <input type="number" min="0" class="form-control" name="${baseName}" placeholder="0" style="width: 80px;">
                    <select class="form-select" name="${baseName}" style="width: 120px;">
                        <option value="minutes">Minutes</option>
                        <option value="hours">Hours</option>
                        <option value="days" selected>Days</option>
                        <option value="months">Months</option>
                        <option value="years">Years</option>
                    </select>
                </div>
            `;
                } else if (USER_FIELDS.includes(fieldValue) && (operatorValue === 'is' || operatorValue === 'is_not')) {
                    let html = `<select class="form-select user-multi-select" name="${baseName}" multiple>`;
                    // Team Roles optgroup
                    html += `<optgroup label="Team Roles">` + ROLES.map(r =>
                        `<option value="role:${r.name}">${r.name}</option>`).join('') + `</optgroup>`;
                    // Individual users
                    USERS.forEach(user => {
                        html += `<option value="${user.id}">${user.name}</option>`;
                    });
                    html += '</select>';
                    valueContainer.innerHTML = html;

                    const sel = valueContainer.querySelector('select');
                    const userTs = new TomSelect(sel, {
                        plugins: ['remove_button'],
                        create: false,
                        placeholder: 'Select users...'
                    });
                    tomSelectInstances.push(userTs);

                    // when a role is selected, show a secondary select listing users in that role
                    sel.dataset._roleAware = '1';
                    sel.addEventListener('change', function() {
                        // remove existing wrapper and destroy its TomSelect instance if present
                        const existing = valueContainer.querySelector('.role-users-wrapper');
                        if (existing) {
                            try {
                                const tsEl = existing.querySelector('.role-users-select');
                                if (tsEl && tsEl.tomselect && typeof tsEl.tomselect.destroy === 'function') {
                                    try {
                                        tsEl.tomselect.destroy();
                                    } catch (e) {}
                                }
                            } catch (e) {}
                            existing.remove();
                        }

                        const selectedRole = Array.from(sel.selectedOptions).map(o => o.value).find(v => v && v
                            .startsWith && v.startsWith('role:'));
                        if (!selectedRole) return;
                        const roleName = selectedRole.replace(/^role:/, '');
                        const roleUsers = usersForRole(roleName);
                        if (!roleUsers || roleUsers.length === 0) return;

                        const wrapper = document.createElement('div');
                        wrapper.className = 'role-users-wrapper mt-2';
                        wrapper.innerHTML =
                            `<label class="form-label small">Select user from ${roleName}</label>`;
                        const userSel = document.createElement('select');
                        userSel.className = 'form-select role-users-select';
                        userSel.setAttribute('multiple', 'multiple');
                        try {
                            userSel.setAttribute('name', baseName);
                        } catch (e) {}
                        userSel.style.minWidth = '200px';
                        userSel.innerHTML = roleUsers.map(u => `<option value="${u.id}">${u.name}</option>`)
                            .join('');
                        wrapper.appendChild(userSel);
                        valueContainer.appendChild(wrapper);
                        try {
                            if (typeof TomSelect !== 'undefined') new TomSelect(userSel, {
                                plugins: ['remove_button'],
                                create: false
                            });
                        } catch (e) {}
                    });

                    return userTs;
                } else if (fieldValue === 'language' && (operatorValue === 'is' || operatorValue === 'is_not')) {
                    let html = `<select class="form-select" name="${baseName}">`;
                    DROPDOWN_OPTIONS.language.forEach(lang => {
                        html += `<option value="${lang}">${lang}</option>`;
                    });
                    html += '</select>';
                    valueContainer.innerHTML = html;
                } else if (operatorValue === 'is_between' || operatorValue === 'is_not_between') {
                    if (fieldType === 'date') {
                        valueContainer.innerHTML = `
                    <div class="date-input-container">
                        <input type="date" class="form-control" name="${baseName}">
                        <span>to</span>
                        <input type="date" class="form-control" name="${baseName}">
                    </div>
                `;
                    } else {
                        valueContainer.innerHTML = `
                    <div class="date-input-container">
                        <input type="number" class="form-control" name="${baseName}" placeholder="From">
                        <span>to</span>
                        <input type="number" class="form-control" name="${baseName}" placeholder="To">
                    </div>
                `;
                    }
                } else if (fieldType === 'dropdown' && DROPDOWN_OPTIONS[fieldValue]) {
                    let html = `<select class="form-select" name="${baseName}">`;
                    DROPDOWN_OPTIONS[fieldValue].forEach(opt => {
                        html += `<option value="${opt}">${opt}</option>`;
                    });
                    html += '</select>';
                    valueContainer.innerHTML = html;
                } else if (fieldType === 'date') {
                    valueContainer.innerHTML = `<input type="date" class="form-control" name="${baseName}">`;
                } else if (fieldType === 'number' || fieldType === 'year' || fieldType === 'interestrate') {
                    valueContainer.innerHTML =
                        `<input type="number" class="form-control" name="${baseName}" placeholder="Enter value">`;
                } else {
                    valueContainer.innerHTML =
                        `<input type="text" class="form-control" name="${baseName}" placeholder="Enter value">`;
                }
            }

            function removeCriteriaRow(rowId, groupId) {
                const row = document.getElementById(rowId);
                if (row) row.remove();

                const group = document.getElementById(groupId);
                if (group) {
                    const container = group.querySelector('.criteria-rows-container');
                    if (container && container.children.length === 0) {
                        group.remove();
                    }
                }
            }

            function removeGroup(groupId) {
                const group = document.getElementById(groupId);
                if (group) group.remove();
            }

            function addAction(actionData = null) {
                // Use current visible count + 1 for display index so deleted rows don't create gaps
                actionCounter++;
                const tempId = `action-temp-${Date.now()}-${actionCounter}`;
                const displayIndex = document.querySelectorAll('.action-delay-container-row').length + 1;

                const actionRow = document.createElement('div');
                actionRow.className = 'action-delay-container-row row g-2 p-3 mb-3';
                actionRow.id = tempId;

                actionRow.innerHTML = `
            <div class="col-md-11 rounded-3 border border-1 p-3 position-relative d-flex align-items-center flex-wrap gap-2">
                <span class="badge bg-primary action-sequence position-absolute" style="top: -10px; left: -10px;">${displayIndex}</span>
                
                <div class="me-2">
                    <select class="form-select action-type bg-white" name="actions[${displayIndex}][action_type]" required>
                        <option value="" hidden>-- Select Action --</option>
                        ${Object.entries(ACTION_TYPES).map(([value, label]) => `<option value="${value}">${label}</option>`).join('')}
                    </select>
                </div>
                
                <div class="d-flex align-items-center me-2">
                    <label class="me-1 small">Delay:</label>
                    <input type="number" min="0" class="form-control bg-white me-1 delay-value" name="actions[${displayIndex}][delay_value]" style="width:90px;" placeholder="0" value="0">
                    <select class="form-select bg-white delay-unit" name="actions[${displayIndex}][delay_unit]" style="width:120px;">
                        ${Object.entries(DELAY_UNITS).map(([value, label]) => `<option value="${value}">${label}</option>`).join('')}
                    </select>
                </div>
                <div class="me-2 d-flex align-items-center">
                    <label class="me-1 small">Time:</label>
                    <input type="time" class="form-control bg-white time-of-day" name="actions[${displayIndex}][parameters][time_of_day]" style="width:140px;" />
                </div>
                
                <div class="dynamic-fields d-flex flex-wrap gap-2 flex-grow-1"></div>
                <input type="hidden" name="actions[${displayIndex}][sort_order]" value="${displayIndex}">
            </div>
            
            <div class="col-md-1 d-flex justify-content-center align-items-start">
                <div class="ss-action-controls">
                    <button type="button" class="ss-action-btn ss-check-btn check-btn invalid" title="Status"><i class="ti ti-circle-check-filled icon"></i></button>
                    <button type="button" class="ss-action-btn ss-clone-btn clone-btn" title="Clone"><i class="ti ti-copy icon"></i><span class="ss-action-label">Clone</span></button>
                    <button type="button" class="ss-action-btn ss-delete-btn delete-btn" title="Delete"><i class="ti ti-trash icon"></i><span class="ss-action-label">Delete</span></button>
                </div>
            </div>
        `;

                document.getElementById('actionContainer').appendChild(actionRow);

                // normalize numbering immediately so new row gets a numeric id/name before any prefill
                updateActionNumbers();

                const actionSelect = actionRow.querySelector('.action-type');
                actionSelect.addEventListener('change', function() {
                    const id = this.closest('.action-delay-container-row')?.id;
                    handleActionTypeChange(id, this.value);
                });

                const checkBtn = actionRow.querySelector('.check-btn');
                checkBtn.addEventListener('click', function() {
                    validateAction(this.closest('.action-delay-container-row')?.id);
                });

                const deleteBtn = actionRow.querySelector('.delete-btn');
                deleteBtn.addEventListener('click', function() {
                    const row = this.closest('.action-delay-container-row');
                    if (row) row.remove();
                    updateActionNumbers();
                });

                const cloneBtn = actionRow.querySelector('.clone-btn');
                if (cloneBtn) {
                    cloneBtn.addEventListener('click', function() {
                        const row = this.closest('.action-delay-container-row');
                        // collect current action's configuration
                        const srcActionType = row.querySelector('.action-type')?.value || '';
                        const delayValue = row.querySelector('.delay-value')?.value || 0;
                        const delayUnit = row.querySelector('.delay-unit')?.value || '';
                        const dynamic = row.querySelector('.dynamic-fields');
                        const params = {};
                        if (dynamic) {
                            dynamic.querySelectorAll('select, input, textarea').forEach(f => {
                                const name = f.getAttribute('name');
                                if (!name) return;
                                const m = name.match(/\[([^\]]+)\]$/);
                                if (!m) return;
                                const key = m[1];
                                if (f.tagName === 'SELECT' && f.multiple) {
                                    params[key] = Array.from(f.selectedOptions).map(o => o.value);
                                } else {
                                    params[key] = f.value;
                                }
                            });
                            // also capture time-of-day input if present
                            const timeInput = row.querySelector('.time-of-day');
                            if (timeInput && timeInput.value) {
                                params['time_of_day'] = timeInput.value;
                            }
                        }
                        // create a new action prefilled with this data
                        addAction({
                            action_type: srcActionType,
                            delay_value: delayValue,
                            delay_unit: delayUnit,
                            parameters: params
                        });
                    });
                }

                // make row draggable and attach drag handlers
                actionRow.setAttribute('draggable', 'true');
                attachDragHandlers(actionRow);
                const actionId = actionRow.id;

                // If actionData was provided, prefill the row
                if (actionData) {
                    try {
                        if (actionData.delay_value !== undefined) actionRow.querySelector('.delay-value').value =
                            actionData.delay_value;
                        if (actionData.delay_unit !== undefined) actionRow.querySelector('.delay-unit').value =
                            actionData.delay_unit;
                        if (actionData.action_type) {
                            actionSelect.value = actionData.action_type;
                            // trigger population of dynamic fields
                            actionSelect.dispatchEvent(new Event('change'));
                            // After dynamic fields are created, set their values
                            setTimeout(() => {
                                const dynamic = actionRow.querySelector('.dynamic-fields');
                                if (dynamic && actionData.parameters) {
                                    Object.keys(actionData.parameters).forEach(key => {
                                        const selector = `[name*="[${key}]"]`;
                                        // try dynamic area first
                                        let field = dynamic.querySelector(selector);
                                        // fallback to the whole row (e.g., time-of-day input)
                                        if (!field) field = actionRow.querySelector(selector) ||
                                            actionRow.querySelector(`.time-of-day`);
                                        if (!field) return;
                                        const val = actionData.parameters[key];
                                        if (field.tagName === 'SELECT' && field.multiple) {
                                            try {
                                                if (field.tomselect && typeof field.tomselect
                                                    .setValue === 'function') {
                                                    field.tomselect.setValue(Array.isArray(val) ? val :
                                                        [val]);
                                                } else {
                                                    Array.from(field.options).forEach(o => {
                                                        o.selected = Array.isArray(val) ? val
                                                            .includes(o.value) : (o.value ==
                                                                val);
                                                    });
                                                }
                                            } catch (e) {}
                                        } else {
                                            field.value = val;
                                        }
                                        field.dispatchEvent(new Event('change'));
                                    });
                                    // ensure time_of_day specifically is set if provided
                                    if (actionData.parameters.time_of_day) {
                                        const t = actionRow.querySelector('.time-of-day');
                                        if (t) t.value = actionData.parameters.time_of_day;
                                    }
                                }
                                validateAction(actionId);
                            }, 60);
                        }
                    } catch (e) {
                        console.debug('prefill action failed', e);
                    }
                }
                // normalize names/indexes after adding
                updateActionNumbers();

                return actionId;
            }

            function handleActionTypeChange(actionId, actionType) {
                const actionRow = document.getElementById(actionId);
                if (!actionRow) return;

                const dynamicFields = actionRow.querySelector('.dynamic-fields');
                const checkBtn = actionRow.querySelector('.check-btn');
                const actionIndex = actionId.split('-')[1];

                checkBtn.classList.remove('valid', 'invalid');
                checkBtn.classList.add('invalid');
                dynamicFields.innerHTML = '';

                if (!actionType) return;

                const baseName = `actions[${actionIndex}][parameters]`;
                let html = '';

                switch (actionType) {
                    case 'task':
                        html = `
                    <select class="form-select bg-white" name="${baseName}[task_type]" required style="min-width: 150px;">
                        <option value="" hidden>-- Select Task --</option>
                        ${TASK_TYPES.map(t => `<option value="${t}">${t}</option>`).join('')}
                    </select>
                    <select class="form-select bg-white" name="${baseName}[assigned_to]" required style="min-width: 200px;">
                        <option value="bdc_agent">Assigned BDC Agent</option>
                        <option value="finance_manager">Assigned Finance Manager</option>
                        <option value="" hidden>-- Select Assigned To --</option>
                        <option value="assigned_to">Assigned To</option>
                        <option value="secondary_assigned">Secondary Assigned To</option>
                        <option value="assigned_manager">Assigned Manager</option>
                       
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <select class="form-select bg-white" name="${baseName}[fallback]" required style="min-width: 200px;">
                        <option value="" hidden>-- Fallback Manager --</option>
                        <option value="bdc_agent">Assigned BDC Agent</option>
                        <option value="finance_manager">Assigned Finance Manager</option>
                        <option value="" hidden>-- Select Assigned To --</option>
                        <option value="assigned_to">Assigned To</option>
                        <option value="secondary_assigned">Secondary Assigned To</option>
                        <option value="assigned_manager">Assigned Manager</option>
                       
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <input type="text" class="form-control bg-white" name="${baseName}[description]" placeholder="Description..." required style="min-width: 200px;">

                    <!-- Hidden template UI for outbound call task_type (populated/shown when task_type === 'Outbound Call') -->
                    <div class="task-template-container d-none d-inline-flex align-items-center gap-2">
                        <select class="form-select bg-white template-select" name="${baseName}[template]" style="min-width: 150px; height: 38px;">
                            <option value="">-- Select Template --</option>
                        </select>
                        <button type="button" class="btn btn-light preview-btn d-inline-flex align-items-center justify-content-center" style="height: 38px; padding: 0 10px; border:1px solid #dee2e6;">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                `;
                        break;

                    case 'ai-draft-email':
                    case 'ai-draft-text':
                        html = `
                    <select class="form-select bg-white" name="${baseName}[task_type]" required style="min-width: 150px;">
                        <option value="" hidden>-- Select Task Type --</option>
                        ${TASK_TYPES.map(t => `<option value="${t}">${t}</option>`).join('')}
                    </select>
                    <select class="form-select bg-white" name="${baseName}[assigned_to]" required style="min-width: 200px;">
                        <option value="" hidden>-- Select Assigned To --</option>
                        <option value="bdc_agent">Assigned BDC Agent</option>
                        <option value="finance_manager">Assigned Finance Manager</option>
                        <option value="assigned_to">Assigned To</option>
                        <option value="secondary_assigned">Secondary Assigned To</option>
                        <option value="assigned_manager">Assigned Manager</option>
                        
                      
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <select class="form-select bg-white" name="${baseName}[fallback]" required style="min-width: 200px;">
                        <option value="" hidden>-- Fallback Manager --</option>
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <input type="text" class="form-control bg-white" name="${baseName}[description]" placeholder="AI will generate description when lead re-engages" readonly style="min-width: 200px; background-color: #f8f9fa !important;">
                `;
                        break;

                    case 'notify':
                        html = `
                    <select class="form-select bg-white" name="${baseName}[user]" required style="min-width: 150px;">
                        <option value="" hidden>-- Select User --</option>
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <input type="text" class="form-control bg-white" name="${baseName}[message]" placeholder="Type Notification Here.." required style="min-width: 250px;">
                `;
                        break;

                    case 'change-status-lost':
                        html = `
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select bg-white" name="${baseName}[status]" hidden style="min-width: 200px;">
                            <option value="Lost" selected>Lost</option>
                            ${SALES_STATUS_OPTIONS.filter(s => s !== 'Lost').map(s => `<option value="${s}">${s}</option>`).join('')}
                        </select>
                        <select id="lost-reason-select" class="form-select bg-white" name="${baseName}[lost_reason]" required style="min-width: 260px;">
                            <option value="" hidden>-- Select Sub-Lost Reason --</option>
                            ${LOST_REASONS.map(r => `<option value="${r}">${r}</option>`).join('')}
                        </select>
                    </div>
                `;
                        break;

                    case 'email':
                    case 'text':
                        // Strict template matching: only include templates whose `type` exactly matches the action type (case-insensitive)
                        const requestedType = (actionType || '').toLowerCase();
                        const filteredTemplates = TEMPLATES.filter(t => ((t.type || '').toLowerCase() ===
                            requestedType));

                        // Debug if none found
                        if ((filteredTemplates || []).length === 0) {
                            try {
                                console.debug('SmartSequence: no templates of type', requestedType,
                                    'found. TEMPLATES sample:', TEMPLATES.slice(0, 10));
                            } catch (e) {}
                        }

                        html = `
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select bg-white template-select" name="${baseName}[template]" required style="min-width: 150px;">
                            <option value="">-- Select Template --</option>
                            ${filteredTemplates.map(t => `<option value="${t.id}">${t.name}</option>`).join('')}
                        </select>
                        <button type="button" class="btn btn-sm btn-light border border-1 preview-btn" style="height: 38px;">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                    <select class="form-select bg-white" name="${baseName}[from_address]" required style="min-width: 150px;">
                        <option value="" hidden>-- From Address --</option>
                        <option value="assigned_to">Assigned To</option>
                        <option value="secondary_assigned">Secondary Assigned To</option>
                        <option value="assigned_manager">Assigned Manager</option>
                        <option value="bdc_agent">BDC Agent</option>
                        <option value="finance_manager">Assigned Finance Manager</option>
                        <optgroup label="Team Roles">
                            ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        </optgroup>
                        <optgroup label="Individual Users">
                            ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                        </optgroup>
                    </select>
                    <select class="form-select bg-white" name="${baseName}[fallback]" required style="min-width: 150px;">
                        <option value="" hidden>-- Fallback --</option>
                        <option value="bdc_agent">Assigned BDC Agent</option>
                        <option value="finance_manager">Assigned Finance Manager</option>
                        <option value="" hidden>-- Select Assigned To --</option>
                        <option value="assigned_to">Assigned To</option>
                        <option value="secondary_assigned">Secondary Assigned To</option>
                        <option value="assigned_manager">Assigned Manager</option>
                       
                            <optgroup label="Team Roles">
                                ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                            </optgroup>
                            <optgroup label="Individual Users">
                                ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                            </optgroup>
                    </select>
                `;
                        break;

                    case 'change-sales-status':
                        html = `<select class="form-select bg-white" name="${baseName}[status]" required style="min-width: 200px;">
                    <option value="">-- Select Status --</option>
                    ${SALES_STATUS_OPTIONS.map(s => `<option value="${s}">${s}</option>`).join('')}
                </select>`;
                        break;

                    case 'change-lead-status':
                        html = `<select class="form-select bg-white" name="${baseName}[status]" required style="min-width: 200px;">
                    <option value="">-- Select Status --</option>
                    ${LEAD_STATUS_OPTIONS.map(s => `<option value="${s}">${s}</option>`).join('')}
                </select>`;
                        break;

                    case 'change-status-type':
                        html = `<select class="form-select bg-white" name="${baseName}[status]" required style="min-width: 200px;">
                    <option value="">-- Select Status --</option>
                    ${STATUS_TYPE_OPTIONS.map(s => `<option value="${s}">${s}</option>`).join('')}
                </select>`;
                        break;

                    case 'change-lead-type':
                        html = `<select class="form-select bg-white" name="${baseName}[status]" required style="min-width: 200px;">
                    <option value="">-- Select Lead Type --</option>
                    ${LEAD_TYPE_OPTIONS.map(s => `<option value="${s}">${s}</option>`).join('')}
                </select>`;
                        break;

                    case 'change-assigned-to':
                    case 'change-assigned-manager':
                    case 'change-bdc-agent':
                    case 'change-finance-manager':
                    case 'change-secondary-assigned-to':
                    case 'reassign-lead':
                        html = `<select class="form-select bg-white" name="${baseName}[user]" required style="min-width: 200px;">
                    <option value="">-- Select User --</option>
              
                    <optgroup label="Individual Users">
                        ${USERS.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                    </optgroup>
                </select>`;
                        break;
                        //Hide After Client Ask!
                        // <optgroup label="Team Roles">
                        //     ${ROLES.map(r => `<option value="role:${r.name}">${r.name}</option>`).join('')}
                        // </optgroup>
                }

                dynamicFields.innerHTML = html;
                try {
                    initRoleAwareSelects(dynamicFields);
                } catch (e) {
                    console.debug('initRoleAwareSelects failed', e);
                }

                // Special handling for task -> outbound call: show template selector (text templates) and preview
                try {
                    if ((actionType || '').toString().toLowerCase() === 'task') {
                        const taskTypeSel = dynamicFields.querySelector('select[name$="[task_type]"]');
                        const tplContainer = dynamicFields.querySelector('.task-template-container');
                        const tplSelect = tplContainer ? tplContainer.querySelector('.template-select') : null;
                        const tplPreviewBtn = tplContainer ? tplContainer.querySelector('.preview-btn') : null;

                        const populateTemplatesForText = () => {
                            if (!tplSelect) return;
                            const filtered = (TEMPLATES || []).filter(t => ((t.type || '').toString()
                            .toLowerCase() === 'text'));
                            tplSelect.innerHTML = `<option value="">-- Select Template --</option>` + filtered.map(
                                t => `<option value="${t.id}">${t.name}</option>`).join('');
                            try {
                                if (tplSelect.tomselect && typeof tplSelect.tomselect.destroy === 'function')
                                    tplSelect.tomselect.destroy();
                            } catch (e) {}
                            try {
                                if (typeof TomSelect !== 'undefined') new TomSelect(tplSelect, {
                                    create: false
                                });
                            } catch (e) {}
                        };

                        const updateTaskTemplateUI = () => {
                            try {
                                if (!taskTypeSel || !tplContainer) return;
                                const val = (taskTypeSel.value || '').toString().toLowerCase();
                                const isOutbound = (val === 'outbound call' || val === 'outbound-call' || val ===
                                    'outbound text' || val === 'outbound-text' || val === 'outbound email' ||
                                    val === 'outbound-email');
                                if (isOutbound) {
                                    tplContainer.classList.remove('d-none');
                                    populateTemplatesForText();
                                } else {
                                    tplContainer.classList.add('d-none');
                                }
                            } catch (e) {
                                console.debug('updateTaskTemplateUI error', e);
                            }
                        };

                        if (taskTypeSel) {
                            taskTypeSel.addEventListener('change', updateTaskTemplateUI);
                            // initialize state
                            updateTaskTemplateUI();
                        }

                        if (tplPreviewBtn && tplSelect) {
                            tplPreviewBtn.addEventListener('click', function() {
                                if (tplSelect && tplSelect.value) {
                                    // preview as text-type template
                                    showTemplatePreview(tplSelect.value, 'text');
                                } else {
                                    alert('Please select a template first');
                                }
                            });
                        }
                    }
                } catch (e) {
                    console.debug('task outbound-template init failed', e);
                }

                // Special-case: if the action type is explicitly 'change-status-lost', ensure the sub-lost select is present and initialized
                try {
                    if ((actionType || '').toString().toLowerCase() === 'change-status-lost') {
                        const existingLost = dynamicFields.querySelector('select[name$="[lost_reason]"]');
                        if (!existingLost) {
                            const lostHtml =
                                `<select class="form-select bg-white" name="${baseName}[lost_reason]" required style="min-width: 150px;"><option value="" hidden>-- Select Sub-Lost Reason --</option>${LOST_REASONS.map(r => `<option value="${r}">${r}</option>`).join('')}</select>`;
                            try {
                                dynamicFields.insertAdjacentHTML('beforeend', lostHtml);
                            } catch (e) {
                                dynamicFields.innerHTML += lostHtml;
                            }
                        }
                        const lostEl = dynamicFields.querySelector('select[name$="[lost_reason]"]');
                        if (lostEl && typeof TomSelect !== 'undefined') {
                            try {
                                new TomSelect(lostEl, {
                                    create: false
                                });
                            } catch (e) {
                                console.debug('TomSelect init failed for lost_reason', e);
                            }
                        }
                        try {
                            validateAction(actionId);
                        } catch (e) {}
                    }
                } catch (e) {
                    console.debug('ensure change-status-lost handling failed', e);
                }

                // If a status select was rendered, toggle a sub-lost reason select when status == 'Lost'
                try {
                    const statusSelect = dynamicFields.querySelector('select[name$="[status]"]');
                    if (statusSelect) {
                        console.debug('SmartSequences: status select found for action', actionId);
                        const ensureLostSelect = () => {
                            try {
                                const val = (statusSelect.value || '').toString().toLowerCase();
                                let lostEl = dynamicFields.querySelector('select[name$="[lost_reason]"]');
                                if (val === 'lost') {
                                    if (!lostEl) {
                                        console.debug('SmartSequences: inserting lost_reason select for', actionId);
                                        const lostHtml =
                                            ` <select class="form-select bg-white" name="${baseName}[lost_reason]" required style="min-width: 150px;"><option value="" hidden>-- Select Sub-Lost Reason --</option>${LOST_REASONS.map(r => `<option value="${r}">${r}</option>`).join('')}</select>`;
                                        // Try to insert after the status select; if that fails, append to dynamicFields
                                        try {
                                            statusSelect.insertAdjacentHTML('afterend', lostHtml);
                                        } catch (ie) {
                                            dynamicFields.insertAdjacentHTML('beforeend', lostHtml);
                                        }
                                        lostEl = dynamicFields.querySelector('select[name$="[lost_reason]"]');
                                        // initialize TomSelect if available
                                        if (lostEl && typeof TomSelect !== 'undefined') {
                                            try {
                                                new TomSelect(lostEl, {
                                                    create: false
                                                });
                                            } catch (e) {
                                                console.debug('TomSelect init failed for lost_reason', e);
                                            }
                                        }
                                        // re-validate the action now that the new required field exists
                                        try {
                                            validateAction(actionId);
                                        } catch (e) {}
                                    }
                                } else {
                                    if (lostEl) {
                                        console.debug('SmartSequences: removing lost_reason select for', actionId);
                                        lostEl.remove();
                                        try {
                                            validateAction(actionId);
                                        } catch (e) {}
                                    }
                                }
                            } catch (e) {
                                console.debug('ensureLostSelect error', e);
                            }
                        };
                        statusSelect.addEventListener('change', ensureLostSelect);
                        // call once to set initial state
                        ensureLostSelect();
                    }
                } catch (e) {
                    console.debug('lost reason attach failed', e);
                }

                // Add preview button listener
                const previewBtn = dynamicFields.querySelector('.preview-btn');
                if (previewBtn) {
                    previewBtn.addEventListener('click', function() {
                        const templateSelect = dynamicFields.querySelector('.template-select');
                        if (templateSelect && templateSelect.value) {
                            showTemplatePreview(templateSelect.value, actionType);
                        } else {
                            alert('Please select a template first');
                        }
                    });
                }

                // Ensure lost-related selects use the settings-managed list (localStorage) if present
                try {
                    const lostReasonsFromStorage = (() => {
                        try {
                            const v = JSON.parse(localStorage.getItem('lostReasons'));
                            if (Array.isArray(v) && v.length) return v;
                        } catch (e) {}
                        return LOST_REASONS;
                    })();

                    // Populate any lost-related selects rendered in this dynamicFields block
                    const lostReasonSelectors = dynamicFields.querySelectorAll('select[name$="[lost_reason]"]');
                    lostReasonSelectors.forEach(sel => {
                        const placeholder = sel.querySelector('option[hidden]') ? sel.querySelector(
                            'option[hidden]').outerHTML : '<option value="" hidden>-- Select --</option>';
                        sel.innerHTML = placeholder + lostReasonsFromStorage.map(r =>
                            `<option value="${r}">${r}</option>`).join('');
                        if (typeof TomSelect !== 'undefined') {
                            try {
                                new TomSelect(sel, {
                                    create: false
                                });
                            } catch (e) {
                                /* ignore */ }
                        }
                    });

                    // Populate sub-lost status selects from the fixed SUB_LOST_STATUS list (do not override with settings)
                    const subLostSelectors = dynamicFields.querySelectorAll('select[name$="[sub_lost_status]"]');
                    subLostSelectors.forEach(sel => {
                        const placeholder = sel.querySelector('option[hidden]') ? sel.querySelector(
                            'option[hidden]').outerHTML : '<option value="" hidden>-- Select --</option>';
                        sel.innerHTML = placeholder + SUB_LOST_STATUS.map(s =>
                            `<option value="${s}">${s}</option>`).join('');
                        if (typeof TomSelect !== 'undefined') {
                            try {
                                new TomSelect(sel, {
                                    create: false
                                });
                            } catch (e) {
                                /* ignore */ }
                        }
                    });
                } catch (e) {
                    console.debug('populate lost selectors failed', e);
                }

                // Add change listeners for validation
                dynamicFields.querySelectorAll('select, input').forEach(field => {
                    field.addEventListener('change', () => validateAction(actionId));
                    field.addEventListener('input', () => validateAction(actionId));
                });

                validateAction(actionId);
            }

            function validateAction(actionId) {
                const actionRow = document.getElementById(actionId);
                if (!actionRow) return false;

                const actionType = actionRow.querySelector('.action-type').value;
                const checkBtn = actionRow.querySelector('.check-btn');
                const dynamicFields = actionRow.querySelector('.dynamic-fields');

                if (!actionType) {
                    checkBtn.classList.remove('valid');
                    checkBtn.classList.add('invalid');
                    return false;
                }

                const requiredFields = dynamicFields.querySelectorAll('[required]');
                let allValid = true;

                requiredFields.forEach(field => {
                    if (field.tagName === 'SELECT' && (!field.value || field.value === '')) {
                        allValid = false;
                    } else if ((field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') && !field.value
                        .trim()) {
                        allValid = false;
                    }
                });

                if (allValid) {
                    checkBtn.classList.remove('invalid');
                    checkBtn.classList.add('valid');
                    return true;
                } else {
                    checkBtn.classList.remove('valid');
                    checkBtn.classList.add('invalid');
                    return false;
                }
            }

            function updateActionNumbers() {
                const actions = Array.from(document.querySelectorAll('.action-delay-container-row'));
                actions.forEach((action, index) => {
                    const newIndex = index + 1;
                    // Update badge
                    const sequenceBadge = action.querySelector('.action-sequence');
                    if (sequenceBadge) sequenceBadge.textContent = newIndex;

                    // Update row id
                    action.id = `action-${newIndex}`;

                    // Update hidden sort_order input
                    const sortInput = action.querySelector('input[type="hidden"][name*="[sort_order]"]');
                    if (sortInput) {
                        sortInput.name = `actions[${newIndex}][sort_order]`;
                        sortInput.value = newIndex;
                    }

                    // Rename all inputs/selects/textareas names to match new index
                    action.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                        const name = el.getAttribute('name');
                        if (!name) return;
                        const newName = name.replace(/^actions\[\d+\]/, `actions[${newIndex}]`);
                        if (newName !== name) el.setAttribute('name', newName);
                    });
                });
            }

               // -------------------------
    // Unsaved changes handling
    // -------------------------

    // serialize only user-editable fields
    function serializeForm(form) {
        if (!form) return '';
        try {
            const fd = new FormData(form);
            const arr = [];
            for (const pair of fd.entries()) {
                const el = form.elements[pair[0]];
                // ignore hidden, readonly, disabled
                if (el && (el.type === 'hidden' || el.readOnly || el.disabled)) continue;
                arr.push(`${pair[0]}=${pair[1]}`);
            }
            arr.sort();
            return arr.join('&');
        } catch (e) {
            return '';
        }
    }

    function isSequenceFormDirty() {
        const form = document.getElementById('sequenceForm');
        if (!form || !window._initialSequenceFormState) return false;
        return serializeForm(form) !== window._initialSequenceFormState;
    }

    // capture initial state AFTER modal fully shown
    $('#addSmartSequenceModal').on('shown.bs.modal', function () {
        const form = document.getElementById('sequenceForm');
        if (!form) return;
        window._initialSequenceFormState = serializeForm(form);
        window._closeAfterSave = false;
        window._forceClose = false;
        window._isSavingSequence = false;
    });

    // Unsaved modal creation (once)
    function ensureUnsavedModalExists() {
        if ($('#unsavedConfirmModal').length) return;

        const tpl = `
        <div class="modal fade" id="unsavedConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="text-center">
                            <div class="unsaved-icon"><i class="ti ti-alert-circle text-danger"></i></div>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <div class="unsaved-title">Unsaved Changes</div>
                        <div class="unsaved-desc">You have unsaved changes in this area. Review and Save before exiting to avoid losing any changes.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="unsavedSaveBtn"><i class="ti ti-check me-1"></i> Save</button>
                        <button type="button" class="btn btn-outline-danger" id="unsavedDiscardBtn"><i class="ti ti-trash me-1"></i> Discard</button>
                        <button type="button" class="btn btn-light" id="unsavedCancelBtn"><i class="ti ti-x me-1"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>`;

        $('body').append(tpl);

        const $unsavedModal = $('#unsavedConfirmModal');

        // Save
        $('#unsavedSaveBtn').on('click', function () {
            window._closeAfterSave = true;
            window._forceClose = true;
            window._isSavingSequence = true;

            $unsavedModal.modal('hide');

            const form = document.getElementById('sequenceForm');
            form.requestSubmit?.() || form.submit();
        });

        // Discard
        $('#unsavedDiscardBtn').on('click', function () {
            window._forceClose = true;
            $unsavedModal.modal('hide');

            // Close main modal
            $('#addSmartSequenceModal').modal('hide');
        });

        // Cancel
        $('#unsavedCancelBtn').on('click', function () {
            $unsavedModal.modal('hide');
        });

        // Reset transient flags after unsaved modal hidden
        $unsavedModal.on('hidden.bs.modal', function () {
            setTimeout(() => {
                if (!window._isSavingSequence) {
                    window._closeAfterSave = false;
                    window._forceClose = false;
                }
            }, 300);
        });
    }

    ensureUnsavedModalExists();

    // Warn on main modal close if form dirty
    $('#addSmartSequenceModal').on('hide.bs.modal', function (e) {
        if (!window._forceClose && isSequenceFormDirty()) {
            e.preventDefault(); // stop modal from closing
            const $unsavedModal = $('#unsavedConfirmModal');
            $unsavedModal.modal('show');
        }
    });

    // Warn on full-page unload if editing and dirty
    window.addEventListener('beforeunload', function (e) {
        if (window.isEditMode && isSequenceFormDirty()) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });
            // Given a role name, return users that have that role
            function usersForRole(roleName) {
                if (!Array.isArray(USERS) || !roleName) return [];
                return USERS.filter(u => {
                    try {
                        if (!u.roles) return false;
                        return u.roles.some(r => (r.name || r) && (r.name || r).toString() === roleName
                            .toString());
                    } catch (e) {
                        return false;
                    }
                });
            }

            // Initialize role-aware selects inside a container: when a role option is chosen, show a second select with users in that role
            function initRoleAwareSelects(container) {
                if (!container) return;
                const selects = Array.from(container.querySelectorAll('select'));
                selects.forEach(sel => {
                    // skip if already initialized
                    if (sel.dataset._roleAware === '1') return;
                    sel.dataset._roleAware = '1';

                    // Role-change handler (works for native selects and TomSelect instances)
                    const handleRoleChange = function() {
                        try {
                            // remove existing wrapper if present
                            const existingWrapper = sel.parentNode.querySelector('.role-users-wrapper');
                            if (existingWrapper) {
                                try {
                                    const tsEl = existingWrapper.querySelector('.role-users-select');
                                    if (tsEl && tsEl.tomselect && typeof tsEl.tomselect.destroy ===
                                        'function') {
                                        try {
                                            tsEl.tomselect.destroy();
                                        } catch (e) {}
                                    }
                                } catch (e) {}
                                existingWrapper.remove();
                            }

                            // detect role selection (support multi-selects)
                            let roleVal = '';
                            try {
                                if (sel.multiple) {
                                    roleVal = Array.from(sel.selectedOptions).map(o => o.value).find(v =>
                                        v && v.startsWith && v.startsWith('role:')) || '';
                                } else {
                                    roleVal = sel.value || '';
                                }
                            } catch (e) {
                                roleVal = sel.value || '';
                            }
                            if (!roleVal || !roleVal.startsWith || !roleVal.startsWith('role:')) return;
                            const roleName = roleVal.replace(/^role:/, '');
                            const users = usersForRole(roleName);
                            if (!users || users.length === 0) return;

                            // create wrapper and select
                            const wrapper = document.createElement('div');
                            wrapper.className = 'ms-2 role-users-wrapper';
                            wrapper.style.display = 'inline-block';
                            wrapper.style.verticalAlign = 'middle';

                            const userSel = document.createElement('select');
                            userSel.className = 'form-select role-users-select';
                            userSel.style.minWidth = '160px';
                            userSel.innerHTML =
                                `<option value="">-- Select User from ${roleName} --</option>` + users.map(
                                    u => `<option value="${u.id}">${u.name}</option>`).join('');

                            // keep bracket structure on name so PHP parses it
                            try {
                                const origName = sel.getAttribute('name') || 'role_user';
                                userSel.setAttribute('name', origName.replace(/\]$/, '_user]'));
                            } catch (e) {}

                            wrapper.appendChild(userSel);
                            sel.parentNode.insertBefore(wrapper, sel.nextSibling);

                            // Initialize TomSelect if available and bind events
                            try {
                                if (typeof TomSelect !== 'undefined') {
                                    const inst = new TomSelect(userSel, {
                                        create: false
                                    });
                                    // ensure tomselect instance is usable
                                    try {
                                        if (inst && typeof inst.on === 'function') inst.on('change', () =>
                                            validateAction(sel.closest('.action-delay-container-row')
                                                ?.id));
                                    } catch (e) {}
                                }
                            } catch (e) {}
                        } catch (err) {
                            console.debug('handleRoleChange error', err);
                        }
                    };

                    sel.addEventListener('change', handleRoleChange);
                    // if a TomSelect instance exists, bind to its change as well
                    try {
                        if (sel.tomselect && typeof sel.tomselect.on === 'function') {
                            sel.tomselect.on('change', handleRoleChange);
                        }
                    } catch (e) {}
                    // try binding again shortly after in case TomSelect is initialized after this
                    setTimeout(() => {
                        try {
                            if (sel.tomselect && typeof sel.tomselect.on === 'function') sel.tomselect
                                .on('change', handleRoleChange);
                        } catch (e) {}
                    }, 200);
                });
            }

            // Attach drag handlers to a row
            function attachDragHandlers(row) {
                if (!row) return;

                row.addEventListener('dragstart', function(e) {
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', row.id);
                    row.classList.add('dragging');
                });

                row.addEventListener('dragend', function() {
                    row.classList.remove('dragging');
                    // remove any drag-over classes
                    document.querySelectorAll('.action-delay-container-row.drag-over').forEach(el => el
                        .classList.remove('drag-over'));
                });

                row.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    const target = e.currentTarget;
                    target.classList.add('drag-over');
                });

                row.addEventListener('dragleave', function() {
                    this.classList.remove('drag-over');
                });

                row.addEventListener('drop', function(e) {
                    e.preventDefault();
                    const draggedId = e.dataTransfer.getData('text/plain');
                    const dragged = document.getElementById(draggedId);
                    const target = this;
                    if (!dragged || dragged === target) return;

                    const targetRect = target.getBoundingClientRect();
                    const insertBefore = (e.clientY < (targetRect.top + targetRect.height / 2));

                    if (insertBefore) {
                        target.parentNode.insertBefore(dragged, target);
                    } else {
                        target.parentNode.insertBefore(dragged, target.nextSibling);
                    }

                    // cleanup classes
                    document.querySelectorAll('.action-delay-container-row.drag-over').forEach(el => el
                        .classList.remove('drag-over'));

                    // reindex rows
                    updateActionNumbers();
                });
            }

    // ✅ Token values (your sample data)
    const tokenValues = {
        first_name: 'Michael',
        last_name: 'Smith',
        email: 'michael.smith@email.com',
        alt_email: 'm.smith@work.com',
        cell_phone: '(555) 123-4567',
        work_phone: '(555) 890-1234',
        home_phone: '(555) 567-8901',
        street_address: '611 Padget Lane',
        city: 'Saskatoon',
        province: 'Saskatchewan',
        postal_code: 'S7W 0H3',
        country: 'Canada',
        assigned_to: 'MC Cerda',
        assigned_to_full_name: 'John Williams',
        assigned_to_email: 'johnwilliams@hotmail.com',
        assigned_manager: 'Marie-Amy Mazuzu',
        secondary_assigned: 'John Doe',
        dealer_name: 'Primus Motors',
        dealer_phone: '222-333-4444',
        dealer_address: '123 Main Street, Vancouver, BC, V5K 2X8',
        dealer_email: 'dealer@dealer.com',
        dealer_website: 'www.primusmotors.ca',
        year: '2025',
        make: 'Ferrari',
        model: 'F80',
        vin: '12345678ABCDEFGHI',
        stock_number: '10101',
        selling_price: '$50,000',
        internet_price: '$49,000',
        kms: '35,000',
        tradein_year: '2011',
        tradein_make: 'Dodge',
        tradein_model: 'Calibre',
        tradein_vin: 'ABCDEFGHI12345678',
        tradein_kms: '100,000',
        tradein_price: '$10,000',
        finance_manager: 'Robert Wilson',
        bdc_agent: 'Emily Davis',
        bdc_manager: 'David Brown',
        general_manager: 'Jennifer Martinez',
        sales_manager: 'Kevin Anderson',
        service_advisor: 'Lisa Thompson',
        advisor_name: 'Ben Dover',
        source: 'Website Inquiry',
        appointment_datetime: 'Oct 14, 2025 10:00AM',
        inventory_manager: 'Mark Robinson',
        warranty_expiration: 'Oct 14, 2025'
    };




    // ✅ Main preview function
    function showTemplatePreview(templateId, actionType) {
        const modalEl = document.getElementById('emailPreviewModal');
        const modal = new bootstrap.Modal(modalEl);
        const previewContent = document.getElementById('emailPreviewContent');

        try {
            const sideList = modalEl.querySelector('.template-list, .template-list-container, .template-list-wrap');
            if (sideList) sideList.remove();
        } catch (e) {}

        try {
            const at = (actionType || '').toString().trim().toLowerCase();
            const hasActionType = at.length > 0;
            const isTextAction = hasActionType && (at.indexOf('text') !== -1 || at.indexOf('sms') !== -1);

            const titleEl = modalEl.querySelector('.modal-title');
            if (titleEl && hasActionType) {
                titleEl.textContent = isTextAction ? 'SMS Template Preview' : 'Email Template Preview';
            }

            document.querySelectorAll('.template-list-item').forEach(btn => {
                try {
                    if (!hasActionType) { btn.style.display = ''; return; }
                    const t = (btn.getAttribute('data-template-type') || '').toString().toLowerCase();
                    let show = false;
                    if (isTextAction) {
                        show = t.indexOf('text') !== -1 || t.indexOf('sms') !== -1;
                    } else {
                        show = t.indexOf('email') !== -1 || t === '';
                    }
                    btn.style.display = show ? '' : 'none';
                } catch (e) {}
            });
        } catch (e) {}

        // ✅ Fetch template preview
        fetch(`{{ url('templates') }}/${templateId}/preview`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => {
                const ct = response.headers.get('content-type') || '';
                if (ct.indexOf('application/json') !== -1) {
                    return response.json().then(data => ({ json: data }));
                }
                return response.text().then(text => ({ text }));
            })
            .then(result => {
                if (result.json) {
                    const data = result.json;
                    if (data.html) {
                        previewContent.innerHTML = replaceTokens(data.html, tokenValues);
                        return;
                    }
                    if (data.preview) {
                        if (typeof data.preview === 'string') {
                            previewContent.innerHTML = replaceTokens(data.preview, tokenValues);
                            return;
                        }
                        previewContent.innerHTML = replaceTokens(
                            data.preview.body_html || data.preview.body_text || data.html || 'No preview available',
                            tokenValues
                        );
                        return;
                    }
                    if (data.success && data.preview) {
                        previewContent.innerHTML = replaceTokens(
                            data.preview.body_html || data.preview.body_text || 'No preview available',
                            tokenValues
                        );
                        return;
                    }
                    previewContent.innerHTML = replaceTokens(data.html || '<p>Unable to load preview</p>', tokenValues);
                } else if (result.text) {
                    previewContent.innerHTML = replaceTokens(result.text || '<p>No preview available</p>', tokenValues);
                } else {
                    previewContent.innerHTML = '<p>Unable to load preview</p>';
                }
            })
            .catch(error => {
                previewContent.innerHTML = '<p>Error loading preview</p>';
            });

        modal.show();
    }





            function resetModal() {
                tomSelectInstances.forEach(ts => {
                    if (ts && ts.destroy) {
                        try {
                            ts.destroy();
                        } catch (e) {}
                    }
                });
                tomSelectInstances = [];
                groupCounter = 0;
                actionCounter = 0;

                const criteriaContainer = document.getElementById('criteria-container');
                if (criteriaContainer) criteriaContainer.innerHTML = '';

                const actionContainer = document.getElementById('actionContainer');
                if (actionContainer) actionContainer.innerHTML = '';

                const titleInput = document.getElementById('sequence-title');
                if (titleInput) titleInput.value = '';

                window.isEditMode = false;
            }

            // function createDefaultCriteriaStructure() {
            //     addCriteriaGroup(false, 1);
            //     addCriteriaGroup(true, 2);
            // }

            function initializeModal() {
                resetModal();
                // createDefaultCriteriaStructure();
            }

            // ========================================
            // EXPOSE FUNCTIONS TO WINDOW FOR EDIT MODE
            // ========================================

            window.addCriteriaGroup = addCriteriaGroup;
            window.addCriteriaToGroup = addCriteriaToGroup;
            window.addAction = addAction;
            window.resetModal = resetModal;
            window.setEditMode = function(value) {
                window.isEditMode = value;
            };

            // Function to populate criteria with data for edit mode
            window.populateCriteriaWithData = function(criteriaGroups) {
                // Clear existing and reset counters
                const criteriaContainer = document.getElementById('criteria-container');
                if (criteriaContainer) criteriaContainer.innerHTML = '';

                tomSelectInstances.forEach(ts => {
                    if (ts && ts.destroy) {
                        try {
                            ts.destroy();
                        } catch (e) {}
                    }
                });
                tomSelectInstances = [];
                groupCounter = 0;

                if (!criteriaGroups || criteriaGroups.length === 0) {
                    return;
                }

                criteriaGroups.forEach(function(group, groupIdx) {
                    const isOrGroup = group.logic_type === 'OR';
                    const groupId = addCriteriaGroup(isOrGroup, 0); // Add group without default rows

                    const groupEl = document.getElementById(groupId);
                    if (!groupEl || !group.criteria || group.criteria.length === 0) return;

                    // Add criteria rows with data
                    group.criteria.forEach(function(criteria, criteriaIdx) {
                        const rowId = addCriteriaToGroup(groupId);

                        // Get the row element
                        const container = groupEl.querySelector('.criteria-rows-container');
                        const rows = container.querySelectorAll('.criteria-row');
                        const row = rows[rows.length - 1]; // Get the last added row

                        if (!row) return;

                        // Set field value using TomSelect
                        const fieldSelect = row.querySelector('.field-select');
                        if (fieldSelect && fieldSelect.tomselect && criteria.field_name) {
                            // Set field value
                            fieldSelect.tomselect.setValue(criteria.field_name, true);

                            // Get group and criteria indices from the row's input names
                            const groupIndex = groupId.split('-')[1];
                            const criteriaIndex = criteriaIdx;

                            // Manually trigger field change handler
                            const operatorTs = handleFieldChange(row.id, criteria.field_name,
                                groupIndex, criteriaIndex);

                            // Wait a bit for operator field to be ready, then set operator
                            setTimeout(function() {
                                const operatorSelect = row.querySelector(
                                '.operator-select');
                                if (operatorSelect && operatorSelect.tomselect && criteria
                                    .operator) {
                                    operatorSelect.tomselect.setValue(criteria.operator,
                                        true);

                                    // Manually trigger operator change handler
                                    handleOperatorChange(row.id, criteria.field_name,
                                        criteria.operator, groupIndex, criteriaIndex);

                                    // Wait for value fields to be ready, then populate values
                                    setTimeout(function() {
                                        populateCriteriaValues(row, criteria);
                                    }, 50);
                                }
                            }, 50);
                        }
                    });
                });
            };

            // Helper function to populate criteria values
            function populateCriteriaValues(row, criteria) {
                const valueContainer = row.querySelector('.value-input-container');
                if (!valueContainer || !criteria.values) return;

                const values = Array.isArray(criteria.values) ? criteria.values : [criteria.values];

                // Handle different input types
                const inputs = valueContainer.querySelectorAll('input');
                const selects = valueContainer.querySelectorAll('select');
                const checkboxes = valueContainer.querySelectorAll('.multi-checkbox'); //New Added



                // ============================================
                // UPDATED: Handle TomSelect multi-selects
                // ============================================
                if (selects.length > 0) {
                    selects.forEach(function(select) {
                        if (select.tomselect) {
                            // For multi-select TomSelect
                            if (select.multiple) {
                                // Filter values to only include valid options
                                const validValues = values.filter(v => {
                                    return Array.from(select.options).some(opt => opt.value === v);
                                });
                                select.tomselect.setValue(validValues);
                            } else {
                                // For single-select TomSelect
                                if (values[0] !== undefined) {
                                    select.tomselect.setValue(values[0]);
                                }
                            }
                        } else {
                            // Regular selects (non-TomSelect)
                            if (select.multiple) {
                                // Multi-select without TomSelect
                                Array.from(select.options).forEach(option => {
                                    option.selected = values.includes(option.value);
                                });
                            } else {
                                // Single select
                                if (values[0] !== undefined) {
                                    select.value = values[0];
                                }
                            }
                        }
                    });
                }
                // ============================================
                // End of TomSelect handling
                // ============================================ 



                if (inputs.length > 0) {
                    inputs.forEach(function(input, idx) {
                        if (values[idx] !== undefined) {
                            input.value = values[idx];
                        }
                    });
                }

                if (selects.length > 0) {
                    const selectOffset = inputs.length || 0;
                    selects.forEach(function(select, idx) {
                        const valueIndex = selectOffset + idx;
                        if (select.tomselect) {
                            // For TomSelect (multi-select)
                            if (select.multiple) {
                                // pass the full values array for multi-selects
                                select.tomselect.setValue(values);
                            } else if (values[valueIndex] !== undefined) {
                                select.tomselect.setValue(values[valueIndex]);
                            }
                        } else if (values[valueIndex] !== undefined) {
                            select.value = values[valueIndex];
                        }
                    });
                }
            }

            // Function to populate actions with data for edit mode
            window.populateActionsWithData = function(actions) {
                const actionContainer = document.getElementById('actionContainer');
                if (actionContainer) {
                    actionContainer.innerHTML = '';
                }
                actionCounter = 0;

                if (!actions || actions.length === 0) {
                    return;
                }

                actions.forEach(function(action, idx) {
                    const actionId = addAction();
                    const actionRow = document.getElementById(actionId);

                    if (!actionRow) return;

                    // Set delay values
                    const delayValue = actionRow.querySelector('.delay-value');
                    const delayUnit = actionRow.querySelector('.delay-unit');

                    if (delayValue && action.delay_value !== undefined) {
                        delayValue.value = action.delay_value;
                    }

                    if (delayUnit && action.delay_unit) {
                        delayUnit.value = action.delay_unit;
                    }

                    // Set action type
                    const actionTypeSelect = actionRow.querySelector('.action-type');
                    if (actionTypeSelect && action.action_type) {
                        actionTypeSelect.value = action.action_type;

                        // Manually call the handler to populate dynamic fields
                        handleActionTypeChange(actionId, action.action_type);

                        // Wait for dynamic fields to be created, then populate parameters
                        setTimeout(function() {
                            const parameters = action.parameters || action.action_parameters || {};
                            populateActionParameters(actionRow, parameters);
                        }, 50);
                    }
                });
            };

            // Helper function to populate action parameters
            function populateActionParameters(actionRow, parameters) {
                const dynamicFields = actionRow.querySelector('.dynamic-fields');
                if (!dynamicFields || !parameters) return;

                // Populate each parameter field
                Object.keys(parameters).forEach(function(key) {
                    const value = parameters[key];

                    // Find input/select by name containing the key
                    let input = dynamicFields.querySelector(`[name*="[${key}]"]`);
                    // fallback to row (for time-of-day or inputs placed outside dynamic-fields)
                    if (!input) {
                        input = actionRow.querySelector(`[name*="[${key}]"]`) || actionRow.querySelector(
                            '.time-of-day');
                    }

                    if (input) {
                        const tag = input.tagName;
                        if (tag === 'SELECT') {
                            try {
                                if (input.tomselect && typeof input.tomselect.setValue === 'function') {
                                    input.tomselect.setValue(value);
                                } else {
                                    input.value = value;
                                }
                            } catch (e) {
                                input.value = value;
                            }
                            try {
                                input.dispatchEvent(new Event('change'));
                            } catch (e) {}
                        } else if (tag === 'INPUT' || tag === 'TEXTAREA') {
                            input.value = value;
                            try {
                                input.dispatchEvent(new Event('change'));
                            } catch (e) {}
                        } else {
                            // generic fallback
                            input.value = value;
                            try {
                                input.dispatchEvent(new Event('change'));
                            } catch (e) {}
                        }
                    }
                });

                // Re-validate the action
                const actionId = actionRow.id;
                validateAction(actionId);
            }

            document.addEventListener('DOMContentLoaded', function() {
                const addCriteriaBtn = document.getElementById('addCriteriaBtn');
                const addOrGroupBtn = document.getElementById('addOrGroupBtn');
                const addActionBtn = document.getElementById('addActionBtn');

                if (addCriteriaBtn) {
                    addCriteriaBtn.onclick = () => addCriteriaGroup(false, 1);
                }

                if (addOrGroupBtn) {
                    addOrGroupBtn.onclick = () => addCriteriaGroup(true, 2);
                }

                if (addActionBtn) {
                    addActionBtn.onclick = addAction;
                }

                const modal = document.getElementById('addSmartSequenceModal');
                if (modal) {
                    modal.addEventListener('show.bs.modal', function(event) {
                        // Check if we're in edit mode (sequenceId is set)
                        const sequenceIdEl = document.getElementById('sequenceId');
                        const currentIsEditMode = sequenceIdEl && sequenceIdEl.value && sequenceIdEl
                            .value !== '';

                        // Update save button text depending on mode and set edit mode flag
                        const saveBtn = document.getElementById('saveSequenceBtn');
                        if (saveBtn) saveBtn.textContent = currentIsEditMode ? 'Update Follow-Up' :
                            'Save Sequence';
                        window.isEditMode = !!currentIsEditMode;

                        // capture initial state for edit-mode so we can detect unsaved changes
                        if (currentIsEditMode) {
                            captureInitialFormState();
                            ensureUnsavedModalExists();
                            // capture again shortly after in case external population completes asynchronously
                            setTimeout(captureInitialFormState, 300);
                        }

                        // Only initialize with defaults if NOT in edit mode
                        if (!currentIsEditMode) {
                            waitForTomSelect(initializeModal);
                        }
                    });

                    // Intercept hide to warn about unsaved changes when editing
                    modal.addEventListener('hide.bs.modal', function(e) {
                        try {
                            if (window.isEditMode && isSequenceFormDirty() && !window._forceClose) {
                                e.preventDefault();
                                ensureUnsavedModalExists();
                                new bootstrap.Modal(document.getElementById('unsavedConfirmModal'))
                                    .show();
                            }
                        } catch (err) {
                            /* ignore */ }
                    });

                    modal.addEventListener('hidden.bs.modal', function() {
                        resetModal();
                        // Reset form for next use
                        const sequenceIdEl = document.getElementById('sequenceId');
                        if (sequenceIdEl) sequenceIdEl.value = '';

                        const modalTitleEl = document.getElementById('modalTitle');
                        if (modalTitleEl) modalTitleEl.textContent = 'Create Smart Sequence';

                        const saveBtn = document.getElementById('saveSequenceBtn');
                        if (saveBtn) saveBtn.textContent = 'Save Sequence';

                        const sequenceForm = document.getElementById('sequenceForm');
                        if (sequenceForm) {
                            sequenceForm.action = '{{ route('smart-sequences.store') }}';
                            const methodField = sequenceForm.querySelector('input[name="_method"]');
                            if (methodField) methodField.remove();
                        }
                    });
                    // Attach drag handlers to any pre-rendered rows and normalize numbering
                    document.querySelectorAll('.action-delay-container-row').forEach(r => attachDragHandlers(
                    r));
                    updateActionNumbers();
                }
            });
        })();

        // AJAX submit handler: submit sequence form via fetch, close modal and show toast on success
        // prevent installing multiple handlers
        if (!window._sequenceFormSubmitInstalled) {
            window._sequenceFormSubmitInstalled = true;
            // install capture-phase submit handler so we can preempt jQuery/global handlers and avoid double-posts
            document.addEventListener('submit', function(e) {
                // run in capture phase and stop propagation immediately so other handlers (like the global jQuery one) don't also submit
                try {
                    e.stopImmediatePropagation();
                } catch (err) {}
                try {
                    e.stopPropagation();
                } catch (err) {}

                const form = e.target && (e.target.id === 'sequenceForm' ? e.target : (e.target.closest ? e.target
                    .closest('#sequenceForm') : null));
                if (!form) return;
                e.preventDefault();

                // guard against re-entry
                if (form.dataset._ssSubmitting === '1') {
                    console.debug('SmartSequence: form already submitting, ignoring duplicate submit');
                    return;
                }
                form.dataset._ssSubmitting = '1';

                console.debug('SmartSequence: intercepted submit for #sequenceForm (capture)');

                const submitBtn = form.querySelector('#saveSequenceBtn') || form.querySelector(
                    'button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;

                const fd = new FormData(form);


                // ============================================
                // NEW: Process JSON hidden inputs for multi-select checkboxes
                // ============================================
                const jsonInputs = form.querySelectorAll('.selected-values-json');
                jsonInputs.forEach(input => {
                    if (input.value) {
                        try {
                            const values = JSON.parse(input.value);
                            // Get the field name pattern from the input name
                            const nameMatch = input.name.match(
                                /criteria_groups\[(\d+)\]\[criteria\]\[(\d+)\]\[values_json\]/);
                            if (nameMatch) {
                                const groupIndex = nameMatch[1];
                                const criteriaIndex = nameMatch[2];

                                // Remove the JSON input from FormData
                                fd.delete(input.name);

                                // Add each value individually with the correct array syntax
                                values.forEach(val => {
                                    fd.append(
                                        `criteria_groups[${groupIndex}][criteria][${criteriaIndex}][values][]`,
                                        val);
                                });

                                // If no values selected, add an empty value to ensure the array exists
                                if (values.length === 0) {
                                    fd.append(
                                        `criteria_groups[${groupIndex}][criteria][${criteriaIndex}][values][]`,
                                        '');
                                }
                            }
                        } catch (e) {
                            console.debug('Error parsing JSON values', e);
                        }
                    }
                });
                // ============================================
                // End of JSON processing
                // ============================================



                try {
                    // debug: list form data keys to help diagnose missing fields
                    const entries = [];
                    for (const pair of fd.entries()) {
                        entries.push(`${pair[0]}=${pair[1]}`);
                    }
                    console.debug('SmartSequence: FormData entries before submit', entries.slice(0, 200));
                } catch (e) {
                    console.debug('SmartSequence: failed to enumerate FormData', e);
                }

                fetch(form.action, {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        redirect: 'follow'
                    })
                    .then(response => {
                        console.debug('SmartSequence: fetch response', response.status, response.headers.get(
                            'content-type'));
                        const ct = (response.headers.get('content-type') || '').toLowerCase();
                        if (ct.indexOf('application/json') !== -1) {
                            return response.json().then(j => ({
                                type: 'json',
                                body: j
                            }));
                        }
                        return response.text().then(t => ({
                            type: 'text',
                            body: t,
                            status: response.status
                        }));
                    })
                    .then(res => {
                        if (submitBtn) submitBtn.disabled = false;
                        form.dataset._ssSubmitting = '0';

                        if (res.type === 'json') {
                            const json = res.body;
                            if (json && json.success) {
                                // If in edit mode, either save-and-close (if requested) or show a toast and stay open
                                if (window.isEditMode) {
                                    if (window._closeAfterSave) {
                                        try {
                                            const modalEl = document.getElementById('addSmartSequenceModal');
                                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap
                                                .Modal(modalEl);
                                            modal.hide();
                                        } catch (e) {}
                                        if (typeof Swal !== 'undefined') Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: json.message || 'Saved',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        else if (typeof toastr !== 'undefined') toastr.success(json.message ||
                                            'Saved');
                                        else try {
                                            window.alert(json.message || 'Saved')
                                        } catch (e) {}
                                        setTimeout(() => {
                                            try {
                                                location.reload();
                                            } catch (e) {}
                                        }, 700);
                                        window._closeAfterSave = false;
                                    } else {
                                        if (typeof Swal !== 'undefined') Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: json.message || 'Updated',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        else if (typeof toastr !== 'undefined') toastr.success(json.message ||
                                            'Updated');
                                        else try {
                                            window.alert(json.message || 'Updated')
                                        } catch (e) {}
                                        // optionally update form action or UI here, but keep modal open
                                        // update baseline so subsequent "close" doesn't trigger unsaved prompt
                                        try {
                                            captureInitialFormState();
                                        } catch (e) {}
                                    }
                                } else {
                                    try {
                                        const modalEl = document.getElementById('addSmartSequenceModal');
                                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap
                                            .Modal(modalEl);
                                        modal.hide();
                                    } catch (e) {}
                                    if (typeof Swal !== 'undefined') Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: json.message || 'Saved',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    else if (typeof toastr !== 'undefined') toastr.success(json.message ||
                                        'Saved');
                                    else try {
                                        window.alert(json.message || 'Saved')
                                    } catch (e) {}
                                    setTimeout(() => {
                                        try {
                                            location.reload();
                                        } catch (e) {}
                                    }, 700);
                                }
                            } else {
                                const msg = (json && (json.message || (json.errors && Object.values(json.errors)
                                    .flat()[0]))) || 'Unable to save';
                                console.warn('SmartSequence: server returned JSON but indicated failure', json);
                                if (typeof Swal !== 'undefined') Swal.fire({
                                    icon: 'error',
                                    title: msg
                                });
                                else if (typeof toastr !== 'undefined') toastr.error(msg);
                                else try {
                                    window.alert(msg)
                                } catch (e) {}
                            }
                            return;
                        }

                        // res.type === 'text' (likely HTML). Log for debugging and treat 2xx as success.
                        console.debug('SmartSequence: non-JSON response body preview:', res.body && res.body
                            .slice ? res.body.slice(0, 500) : res.body);
                        if (res.status >= 200 && res.status < 300) {
                            if (window.isEditMode) {
                                if (window._closeAfterSave) {
                                    try {
                                        const modalEl = document.getElementById('addSmartSequenceModal');
                                        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap
                                            .Modal(modalEl);
                                        modal.hide();
                                    } catch (e) {}
                                    if (typeof Swal !== 'undefined') Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Saved',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    else if (typeof toastr !== 'undefined') toastr.success('Saved');
                                    else try {
                                        window.alert('Saved')
                                    } catch (e) {}
                                    setTimeout(() => {
                                        try {
                                            location.reload();
                                        } catch (e) {}
                                    }, 700);
                                    window._closeAfterSave = false;
                                } else {
                                    // editing: show a toast and stay on the modal
                                    if (typeof Swal !== 'undefined') Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Updated',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    else if (typeof toastr !== 'undefined') toastr.success('Updated');
                                    else try {
                                        window.alert('Updated')
                                    } catch (e) {}
                                    // update baseline so subsequent "close" doesn't trigger unsaved prompt
                                    try {
                                        captureInitialFormState();
                                    } catch (e) {}
                                }
                            } else {
                                try {
                                    const modalEl = document.getElementById('addSmartSequenceModal');
                                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(
                                        modalEl);
                                    modal.hide();
                                } catch (e) {}
                                if (typeof Swal !== 'undefined') Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Saved',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                else if (typeof toastr !== 'undefined') toastr.success('Saved');
                                else try {
                                    window.alert('Saved')
                                } catch (e) {}
                                setTimeout(() => {
                                    try {
                                        location.reload();
                                    } catch (e) {}
                                }, 700);
                            }
                        } else {
                            console.error('SmartSequence: non-JSON response with error status', res.status);
                            if (typeof Swal !== 'undefined') Swal.fire({
                                icon: 'error',
                                title: 'Error saving sequence'
                            });
                            else try {
                                window.alert('Error saving sequence')
                            } catch (e) {}
                        }
                    })
                    .catch(err => {
                        if (submitBtn) submitBtn.disabled = false;
                        form.dataset._ssSubmitting = '0';
                        console.error('SmartSequence: fetch error', err);
                        if (typeof Swal !== 'undefined') Swal.fire({
                            icon: 'error',
                            title: 'Error saving sequence'
                        });
                        else try {
                            window.alert('Error saving sequence')
                        } catch (e) {}
                    })
                    // always clear the saving flag when the network call completes (success or error)
                    .finally(() => {
                        try {
                            window._isSavingSequence = false;
                        } catch (e) {}
                    });
            }, true);
        }
    </script>
@endpush
