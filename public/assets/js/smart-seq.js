 // Field Configuration with proper operators
 const FIELD_CONFIG = {
    // Text fields - can type, is/is not, blank/not blank
    text: {
        fields: ['firstname', 'middlename', 'lastname', 'customername', 'cobuyer', 'email', 'alternateemail', 
                'cellphone', 'workphone', 'homephone', 'address', 'streetaddress', 'city', 'province', 
                'postalcode', 'country', 'make', 'model', 'bodystyle', 'exteriorcolor', 'interiorcolor', 
                'fueltype', 'engine', 'drivetype', 'transmission', 'franchise', 'lotlocation', 
                'dealershipname', 'dealershipphone', 'dealershipaddress', 'dealershipwebsite', 
                'assignedto', 'assignedby', 'assignedmanager', 'secondaryassigned', 'financemanager', 
                'bdcagent', 'bdcmanager', 'generalmanger', 'salesmanager', 'serviceadvisor', 
                'inventorymanager', 'createdby', 'lost', 'sold', 'notes', 'csi', 'consent', 
                'optout', 'language', 'businessname', 'updatedby', 'trim', 'wishlist'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'text'
    },
    
    // VIN and Stock - only blank checks
    identifier: {
        fields: ['vin', 'stocknumber'],
        operators: ['is_blank', 'is_not_blank'],
        inputType: null
    },
    
    // Year field - special number operators
    year: {
        fields: ['year', 'tradeinyear'],
        operators: ['is', 'is_between', 'is_greater_equal', 'is_less_equal', 'is_blank', 'is_not_blank'],
        inputType: 'number'
    },
    
    // Number fields with full operators
    number: {
        fields: ['odometer', 'doors', 'saleprice', 'sellingprice', 'internetprice', 'equity', 
                'tradeinsellingprice', 'buyout'],
        operators: ['is', 'is_not', 'is_between', 'is_not_between', 'is_greater_equal', 'is_less_equal', 'is_blank', 'is_not_blank'],
        inputType: 'number'
    },
    
    // Date fields
    date: {
        fields: ['appointmentcreationdate', 'appointmentdate', 'createddate', 'deliverydate', 
                'demodate', 'lastcontacteddate', 'leasematuritydate', 'solddate', 'taskcompleteddate', 
                'taskduedate', 'financematuritydate', 'firstcontactdate', 'financestartdate', 
                'leasestartdate', 'warrantyexpiration', 'assigneddate', 'date', 'birthday', 'updated'],
        operators: ['is', 'is_between', 'is_greater_equal', 'is_less_equal', 'is_not', 'is_not_between', 'is_blank', 'is_not_blank'],
        inputType: 'date'
    },
    
    // Dropdown fields
    dropdown: {
        fields: ['leadtype', 'salestatus', 'statustype', 'tasktype', 'dealtype', 'salestype', 
                'source', 'priority', 'leadsource'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'dropdown'
    }
};

// Dropdown options
const DROPDOWN_OPTIONS = {
    leadtype: ['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Service', 'Import', 'Wholesale', 'Lease Renewal', 'Unknown', 'None'],
    salestatus: ['Uncontacted', 'Contacted', 'Appointment Set', 'Showed', 'Lost', 'Sold', 'None'],
    statustype: ['Open', 'Confirmed', 'Cancelled', 'Completed', 'Rescheduled', 'None'],
    tasktype: ['Call', 'Email', 'Follow Up', 'Meeting', 'Demo', 'None'],
    dealtype: ['New', 'Used', 'Lease', 'Finance', 'Cash', 'None'],
    salestype: ['Retail', 'Fleet', 'Wholesale', 'None'],
    source: ['Website', 'Referral', 'Walk-in', 'Phone', 'Email', 'Social Media', 'None'],
    priority: ['Low', 'Medium', 'High', 'Urgent', 'None'],
    leadsource: ['Website', 'Referral', 'Advertisement', 'Social Media', 'Event', 'None']
};

// All fields list
const ALL_FIELDS = [
    {value: 'firstname', text: 'First Name'},
    {value: 'middlename', text: 'Middle Name'},
    {value: 'lastname', text: 'Last Name'},
    {value: 'customername', text: 'Customer Name'},
    {value: 'cobuyer', text: 'Co-Buyer'},
    {value: 'email', text: 'Email'},
    {value: 'alternateemail', text: 'Alternative Email'},
    {value: 'cellphone', text: 'Cell Phone'},
    {value: 'workphone', text: 'Work Phone'},
    {value: 'homephone', text: 'Home Phone'},
    {value: 'address', text: 'Full Address'},
    {value: 'streetaddress', text: 'Street Address'},
    {value: 'city', text: 'City'},
    {value: 'province', text: 'Province'},
    {value: 'postalcode', text: 'Postal Code'},
    {value: 'country', text: 'Country'},
    {value: 'year', text: 'Year'},
    {value: 'make', text: 'Make'},
    {value: 'model', text: 'Model'},
    {value: 'vin', text: 'VIN'},
    {value: 'stocknumber', text: 'Stock Number'},
    {value: 'odometer', text: 'Odometer'},
    {value: 'bodystyle', text: 'Body Style'},
    {value: 'exteriorcolor', text: 'Exterior Color'},
    {value: 'interiorcolor', text: 'Interior Color'},
    {value: 'fueltype', text: 'Fuel Type'},
    {value: 'engine', text: 'Engine'},
    {value: 'drivetype', text: 'Drive Type'},
    {value: 'doors', text: 'Doors'},
    {value: 'transmission', text: 'Transmission'},
    {value: 'franchise', text: 'Franchise'},
    {value: 'lotlocation', text: 'Lot Location'},
    {value: 'saleprice', text: 'Sale Price'},
    {value: 'sellingprice', text: 'Selling Price'},
    {value: 'internetprice', text: 'Internet Price'},
    {value: 'equity', text: 'Equity'},
    {value: 'dealershipname', text: 'Dealership Name'},
    {value: 'dealershipphone', text: 'Dealership Phone'},
    {value: 'dealershipaddress', text: 'Dealership Address'},
    {value: 'dealershipwebsite', text: 'Dealership Website'},
    {value: 'tradeinyear', text: 'Trade-in Year'},
    {value: 'tradeinsellingprice', text: 'Trade-in Selling Price'},
    {value: 'assignedto', text: 'Assigned To'},
    {value: 'assignedby', text: 'Assigned By'},
    {value: 'assignedmanager', text: 'Assigned Manager'},
    {value: 'secondaryassigned', text: 'Secondary Assigned'},
    {value: 'financemanager', text: 'Finance Manager'},
    {value: 'bdcagent', text: 'BDC Agent'},
    {value: 'bdcmanager', text: 'BDC Manager'},
    {value: 'generalmanger', text: 'General Manager'},
    {value: 'salesmanager', text: 'Sales Manager'},
    {value: 'serviceadvisor', text: 'Service Advisor'},
    {value: 'inventorymanager', text: 'Inventory Manager'},
    {value: 'createdby', text: 'Created By'},
    {value: 'appointmentcreationdate', text: 'Appointment Creation Date'},
    {value: 'appointmentdate', text: 'Appointment Date'},
    {value: 'createddate', text: 'Created Date'},
    {value: 'deliverydate', text: 'Delivery Date'},
    {value: 'demodate', text: 'Demo Date'},
    {value: 'lastcontacteddate', text: 'Last Contacted Date'},
    {value: 'leasematuritydate', text: 'Lease Maturity Date'},
    {value: 'solddate', text: 'Sold Date'},
    {value: 'taskcompleteddate', text: 'Task Completed Date'},
    {value: 'taskduedate', text: 'Task Due Date'},
    {value: 'financematuritydate', text: 'Finance Maturity Date'},
    {value: 'firstcontactdate', text: 'First Contact Date'},
    {value: 'financestartdate', text: 'Finance Start Date'},
    {value: 'leasestartdate', text: 'Lease Start Date'},
    {value: 'warrantyexpiration', text: 'Warranty Expiration'},
    {value: 'assigneddate', text: 'Assigned Date'},
    {value: 'date', text: 'Date'},
    {value: 'birthday', text: 'Birthday'},
    {value: 'updated', text: 'Updated'},
    {value: 'leadtype', text: 'Lead Type'},
    {value: 'salestatus', text: 'Sales Status'},
    {value: 'statustype', text: 'Status Type'},
    {value: 'tasktype', text: 'Task Type'},
    {value: 'dealtype', text: 'Deal Type'},
    {value: 'salestype', text: 'Sales Type'},
    {value: 'source', text: 'Source'},
    {value: 'priority', text: 'Priority'},
    {value: 'leadsource', text: 'Lead Source'},
    {value: 'lost', text: 'Lost'},
    {value: 'sold', text: 'Sold'},
    {value: 'notes', text: 'Notes'},
    {value: 'csi', text: 'CSI'},
    {value: 'consent', text: 'Consent'},
    {value: 'optout', text: 'Opt-Out'},
    {value: 'language', text: 'Language'},
    {value: 'businessname', text: 'Business Name'},
    {value: 'buyout', text: 'Buyout'},
    {value: 'wishlist', text: 'Wishlist'},
    {value: 'updatedby', text: 'Updated By'},
    {value: 'trim', text: 'Trim'}
].sort((a, b) => a.text.localeCompare(b.text));

// Operator labels
const OPERATOR_LABELS = {
    'is': 'is',
    'is_not': 'is not',
    'is_between': 'is between',
    'is_not_between': 'is not between',
    'is_greater_equal': 'is greater than or equal to',
    'is_less_equal': 'is less than or equal to',
    'is_blank': 'is blank',
    'is_not_blank': 'is not blank'
};

// Global state
let criteriaGroups = [];
let groupCounter = 0;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeCriteria();
    initializeActions();
    addCriteriaGroup(false); // Add default AND group
});

// Get field type
function getFieldType(fieldName) {
    for (let type in FIELD_CONFIG) {
        if (FIELD_CONFIG[type].fields.includes(fieldName)) {
            return type;
        }
    }
    return 'text';
}

// Create criteria group
function addCriteriaGroup(isOrGroup = false) {
    groupCounter++;
    const groupId = `group-${groupCounter}`;
    
    const group = document.createElement('div');
    group.className = `criteria-group ${isOrGroup ? 'or-group' : ''}`;
    group.id = groupId;
    group.dataset.isOr = isOrGroup;
    
    group.innerHTML = `
        <span class="criteria-group-label">${isOrGroup ? 'OR' : 'AND'}</span>
        ${isOrGroup ? '<button class="remove-group-btn" onclick="removeGroup(\'' + groupId + '\')"><i class="ti ti-x"></i></button>' : ''}
        <div class="criteria-rows-container"></div>
        <button class="add-criteria-button mt-2" onclick="addCriteriaToGroup('${groupId}')">+ Criteria</button>
    `;
    
    document.getElementById('criteria-container').appendChild(group);
    
    // Add first criteria row
    addCriteriaToGroup(groupId);
    
    return groupId;
}

// Add criteria to specific group
function addCriteriaToGroup(groupId) {
    const group = document.getElementById(groupId);
    const container = group.querySelector('.criteria-rows-container');
    
    const rowId = `criteria-${Date.now()}-${Math.random()}`;
    const row = document.createElement('div');
    row.className = 'criteria-row row align-items-end';
    row.id = rowId;
    
    row.innerHTML = `
        <div class="col-md-3">
            <label class="form-label small">Field</label>
            <select class="form-select field-select"></select>
        </div>
        <div class="col-md-3 operator-col" style="display: none;">
            <label class="form-label small">Operator</label>
            <select class="form-select operator-select"></select>
        </div>
        <div class="col-md-4 value-col" style="display: none;">
            <label class="form-label small">Value</label>
            <div class="value-input-container"></div>
        </div>
        <div class="col-md-2 text-end">
            <button class="btn-icon-only" onclick="removeCriteria('${rowId}')">
                <i class="ti ti-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(row);
    
    // Initialize field select
    const fieldSelect = row.querySelector('.field-select');
    new TomSelect(fieldSelect, {
        options: ALL_FIELDS,
        create: false,
        placeholder: '-- Select Field --',
        onChange: (value) => handleFieldChange(rowId, value)
    });
}

// Handle field selection
function handleFieldChange(rowId, fieldValue) {
    const row = document.getElementById(rowId);
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
    
    // Show operator column
    operatorCol.style.display = 'block';
    
    // Populate operators
    operatorSelect.innerHTML = '<option value="">-- Select Operator --</option>';
    config.operators.forEach(op => {
        const option = document.createElement('option');
        option.value = op;
        option.textContent = OPERATOR_LABELS[op];
        operatorSelect.appendChild(option);
    });
    
    // Initialize operator select
    if (operatorSelect.tomselect) {
        operatorSelect.tomselect.destroy();
    }
    new TomSelect(operatorSelect, {
        create: false,
        onChange: (value) => handleOperatorChange(rowId, fieldValue, value)
    });
}

// Handle operator selection
function handleOperatorChange(rowId, fieldValue, operatorValue) {
    const row = document.getElementById(rowId);
    const valueCol = row.querySelector('.value-col');
    const valueContainer = row.querySelector('.value-input-container');
    
    if (!operatorValue || operatorValue === 'is_blank' || operatorValue === 'is_not_blank') {
        valueCol.style.display = 'none';
        return;
    }
    
    valueCol.style.display = 'block';
    valueContainer.innerHTML = '';
    
    const fieldType = getFieldType(fieldValue);
    const config = FIELD_CONFIG[fieldType];
    
    // Create appropriate input based on operator and field type
    if (operatorValue === 'is_between' || operatorValue === 'is_not_between') {
        // Two inputs for between
        if (config.inputType === 'date') {
            valueContainer.innerHTML = `
                <div class="date-input-container">
                    <input type="date" class="form-control" placeholder="Start">
                    <span>to</span>
                    <input type="date" class="form-control" placeholder="End">
                </div>
            `;
        } else if (config.inputType === 'number') {
            valueContainer.innerHTML = `
                <div class="date-input-container">
                    <input type="number" class="form-control" placeholder="From">
                    <span>to</span>
                    <input type="number" class="form-control" placeholder="To">
                </div>
            `;
        }
    } else if (operatorValue === 'is' || operatorValue === 'is_not') {
        if (config.inputType === 'dropdown') {
            // Create dropdown with search
            const select = document.createElement('select');
            select.className = 'form-select';
            
            const options = DROPDOWN_OPTIONS[fieldValue] || ['None'];
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                select.appendChild(option);
            });
            
            valueContainer.appendChild(select);
            new TomSelect(select, {
                create: false,
                placeholder: '-- Select Option --'
            });
        } else if (config.inputType === 'date') {
            valueContainer.innerHTML = '<input type="date" class="form-control">';
        } else if (config.inputType === 'number' || config.inputType === 'text') {
            valueContainer.innerHTML = `<input type="${config.inputType}" class="form-control" placeholder="Enter value">`;
        }
    } else if (operatorValue === 'is_greater_equal' || operatorValue === 'is_less_equal') {
        if (config.inputType === 'date') {
            valueContainer.innerHTML = '<input type="date" class="form-control">';
        } else {
            valueContainer.innerHTML = '<input type="number" class="form-control" placeholder="Enter value">';
        }
    }
}

// Remove criteria
function removeCriteria(rowId) {
    const row = document.getElementById(rowId);
    const container = row.closest('.criteria-rows-container');
    row.remove();
    
    // If no criteria left in group, remove group (except first AND group)
    if (container.children.length === 0) {
        const group = container.closest('.criteria-group');
        if (group.dataset.isOr === 'true') {
            group.remove();
        }
    }
}

// Remove group
function removeGroup(groupId) {
    document.getElementById(groupId).remove();
}

// Initialize criteria
function initializeCriteria() {
    document.getElementById('addCriteriaBtn').addEventListener('click', () => {
        const firstGroup = document.querySelector('.criteria-group:not(.or-group)');
        if (firstGroup) {
            addCriteriaToGroup(firstGroup.id);
        }
    });
    
    document.getElementById('addOrGroupBtn').addEventListener('click', () => {
        addCriteriaGroup(true);
    });
}

// Action Management
let actionCounter = 0;

function initializeActions() {
    document.getElementById('addActionBtn').addEventListener('click', addAction);
}

function addAction() {
    actionCounter++;
    const actionId = `action-${actionCounter}`;
    
    const actionRow = document.createElement('div');
    actionRow.className = 'action-delay-container-row row g-2 p-3 mb-3';
    actionRow.id = actionId;
    
    actionRow.innerHTML = `
        <div class="col-md-11 rounded-3 border border-1 p-3 position-relative d-flex align-items-center flex-wrap gap-2">
            <span class="badge bg-primary action-sequence position-absolute" style="top: -10px; left: -10px;">${actionCounter}</span>
            
            <div class="me-2">
                <select class="form-select action-type bg-white" required>
                    <option value="" hidden>-- Select Action --</option>
                    <option value="task">Create Task</option>
                    <option value="notify">Send Notification</option>
                    <option value="email">Send Email to Customer</option>
                    <option value="text">Send Text to Customer</option>
                    <option value="change-sales-status">Change Sales Status</option>
                    <option value="change-lead-type">Change Lead Type</option>
                    <option value="reassign-lead">Reassign Lead</option>
                    <option value="change-lead-status">Change Lead Status</option>
                    <option value="change-status-type">Change Status Type</option>
                    <option value="change-assigned-to">Change Assigned To</option>
                    <option value="change-secondary-assigned-to">Change Secondary Assigned To</option>
                    <option value="change-finance-manager">Change Finance Manager To</option>
                    <option value="change-bdc-agent">Change BDC Agent To</option>
                    <option value="ai-draft-email">AI Draft Email</option>
                    <option value="ai-draft-text">AI Draft Text</option>
                </select>
            </div>
            
            <div class="d-flex align-items-center me-2">
                <label class="me-1 small">Delay:</label>
                <select class="form-select bg-white me-1 delay-hours" style="width:80px;">
                    <option value="0">0h</option>
                    <option value="1">1h</option>
                    <option value="2">2h</option>
                    <option value="3">3h</option>
                    <option value="6">6h</option>
                    <option value="12">12h</option>
                    <option value="24">24h</option>
                </select>
                <select class="form-select bg-white delay-minutes" style="width:80px;">
                    <option value="0">0m</option>
                    <option value="5">5m</option>
                    <option value="10">10m</option>
                    <option value="15">15m</option>
                    <option value="30">30m</option>
                    <option value="45">45m</option>
                </select>
            </div>
            
            <div class="dynamic-fields d-flex flex-wrap gap-2 flex-grow-1"></div>
            
            <div class="ms-2 trigger-buttons">
                <i class="ti ti-adjustments-alt" style="font-size: 20px; cursor: pointer;" title="Execution Settings"></i>
            </div>
        </div>
        
        <div class="col-md-1 text-center d-flex flex-column gap-2">
            <button type="button" class="check-btn"><i class="ti ti-circle-check-filled"></i></button>
            <button type="button" class="delete-btn"><i class="ti ti-trash-x-filled"></i></button>
        </div>
    `;
    
    document.getElementById('actionContainer').appendChild(actionRow);
    
    // Setup action type change
    const actionSelect = actionRow.querySelector('.action-type');
    actionSelect.addEventListener('change', function() {
        handleActionTypeChange(actionId, this.value);
    });
    
    // Setup check button
    const checkBtn = actionRow.querySelector('.check-btn');
    checkBtn.addEventListener('click', () => validateAction(actionId));
    
    // Setup delete button
    const deleteBtn = actionRow.querySelector('.delete-btn');
    deleteBtn.addEventListener('click', () => {
        actionRow.remove();
        updateActionNumbers();
    });
}

function handleActionTypeChange(actionId, actionType) {
    const actionRow = document.getElementById(actionId);
    const dynamicFields = actionRow.querySelector('.dynamic-fields');
    const checkBtn = actionRow.querySelector('.check-btn');
    
    checkBtn.classList.remove('valid', 'invalid');
    dynamicFields.innerHTML = '';
    
    if (!actionType) return;
    
    switch(actionType) {
        case 'task':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Task --</option>
                    <option>Email Follow-up</option>
                    <option>Schedule Test Drive</option>
                    <option>Call Customer</option>
                    <option>Send Quote</option>
                    <option>Service Reminder</option>
                    <option>Finance Application</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Owner --</option>
                    <option>John Smith</option>
                    <option>Emma Johnson</option>
                    <option>Michael Brown</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Team --</option>
                    <option>Sales Team</option>
                    <option>Support Team</option>
                    <option>Round Robin</option>
                </select>
                <input type="text" class="form-control bg-white" placeholder="Description..." required style="min-width: 200px;">
            `;
            break;
            
        case 'notify':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Team --</option>
                    <option>Sales Team</option>
                    <option>Support Team</option>
                    <option>Round Robin</option>
                </select>
                <input type="text" class="form-control bg-white" placeholder="Notification text..." required style="min-width: 250px;">
            `;
            break;
            
        case 'email':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Template --</option>
                    <option>Book Dream Car</option>
                    <option>Marketing Email</option>
                    <option>New Year</option>
                    <option>Follow Up</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- From Address --</option>
                    <option>noreply@dealer.com</option>
                    <option>sales@dealer.com</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Fallback --</option>
                    <option>Manager</option>
                    <option>Assistant</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Team --</option>
                    <option>Sales Team</option>
                    <option>Support Team</option>
                    <option>Round Robin</option>
                </select>
            `;
            break;
            
        case 'text':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- From Number --</option>
                    <option>+1234567890</option>
                    <option>+0987654321</option>
                </select>
                <select class="form-select bg-white" required style="min-width: 150px;">
                    <option value="">-- Select Team --</option>
                    <option>Sales Team</option>
                    <option>Support Team</option>
                    <option>Round Robin</option>
                </select>
                <textarea class="form-control bg-white" placeholder="Message text..." required rows="2" style="min-width: 250px;"></textarea>
            `;
            break;
            
        case 'change-sales-status':
        case 'change-lead-status':
        case 'change-status-type':
            const statusOptions = actionType === 'change-sales-status' 
                ? ['Uncontacted', 'Contacted', 'Appointment Set', 'Showed', 'Lost', 'Sold']
                : actionType === 'change-status-type'
                ? ['Open', 'Confirmed', 'Cancelled', 'Completed', 'Rescheduled']
                : ['Active', 'Inactive', 'Duplicate', 'Dead'];
            
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 200px;">
                    <option value="">-- Select Status --</option>
                    ${statusOptions.map(opt => `<option>${opt}</option>`).join('')}
                </select>
            `;
            break;
            
        case 'change-lead-type':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 200px;">
                    <option value="">-- Select Lead Type --</option>
                    <option>Internet</option>
                    <option>Walk-In</option>
                    <option>Phone Up</option>
                    <option>Text Up</option>
                    <option>Website Chat</option>
                    <option>Service</option>
                    <option>Import</option>
                    <option>Wholesale</option>
                    <option>Lease Renewal</option>
                </select>
            `;
            break;
            
        case 'reassign-lead':
        case 'change-assigned-to':
        case 'change-secondary-assigned-to':
        case 'change-finance-manager':
        case 'change-bdc-agent':
            dynamicFields.innerHTML = `
                <select class="form-select bg-white" required style="min-width: 200px;">
                    <option value="">-- Select User --</option>
                    <option>John Smith</option>
                    <option>Emma Johnson</option>
                    <option>Michael Brown</option>
                    <option>Sarah Davis</option>
                    <option>James Wilson</option>
                </select>
            `;
            break;
            
        case 'ai-draft-email':
        case 'ai-draft-text':
            dynamicFields.innerHTML = `
                <div class="alert alert-info mb-0" style="min-width: 300px;">
                    <i class="ti ti-info-circle me-1"></i>
                    AI will automatically generate a ${actionType === 'ai-draft-email' ? 'email' : 'text'} draft when the lead re-engages.
                    The suggestion will be displayed in the task description.
                </div>
            `;
            break;
    }
    
    // Add validation listeners to new fields
    dynamicFields.querySelectorAll('select, input, textarea').forEach(field => {
        field.addEventListener('change', () => validateAction(actionId));
        field.addEventListener('input', () => validateAction(actionId));
    });
}

function validateAction(actionId) {
    const actionRow = document.getElementById(actionId);
    const actionType = actionRow.querySelector('.action-type').value;
    const checkBtn = actionRow.querySelector('.check-btn');
    const dynamicFields = actionRow.querySelector('.dynamic-fields');
    
    if (!actionType) {
        checkBtn.classList.remove('valid');
        checkBtn.classList.add('invalid');
        return false;
    }
    
    // For AI actions, no additional validation needed
    if (actionType === 'ai-draft-email' || actionType === 'ai-draft-text') {
        checkBtn.classList.remove('invalid');
        checkBtn.classList.add('valid');
        return true;
    }
    
    // Check all required fields
    const requiredFields = dynamicFields.querySelectorAll('[required]');
    let allValid = true;
    
    requiredFields.forEach(field => {
        if (field.tagName === 'SELECT' && (!field.value || field.value === '')) {
            allValid = false;
        } else if ((field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') && !field.value.trim()) {
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
    const actions = document.querySelectorAll('.action-delay-container-row');
    actions.forEach((action, index) => {
        action.querySelector('.action-sequence').textContent = index + 1;
    });
}

// Save sequence
document.getElementById('saveSequenceBtn').addEventListener('click', function() {
    const title = document.getElementById('sequence-title').value;
    
    if (!title.trim()) {
        alert('Please enter a sequence title');
        return;
    }
    
    // Collect criteria data
    const criteriaData = [];
    document.querySelectorAll('.criteria-group').forEach(group => {
        const groupType = group.dataset.isOr === 'true' ? 'OR' : 'AND';
        const criteria = [];
        
        group.querySelectorAll('.criteria-row').forEach(row => {
            const fieldSelect = row.querySelector('.field-select');
            const operatorSelect = row.querySelector('.operator-select');
            const valueInputs = row.querySelectorAll('.value-input-container input, .value-input-container select');
            
            if (fieldSelect.value && operatorSelect.value) {
                const criteriaItem = {
                    field: fieldSelect.value,
                    operator: operatorSelect.value,
                    values: Array.from(valueInputs).map(input => input.value).filter(v => v)
                };
                criteria.push(criteriaItem);
            }
        });
        
        if (criteria.length > 0) {
            criteriaData.push({
                type: groupType,
                criteria: criteria
            });
        }
    });
    
    // Collect action data
    const actionsData = [];
    document.querySelectorAll('.action-delay-container-row').forEach(action => {
        const actionType = action.querySelector('.action-type').value;
        const delayHours = action.querySelector('.delay-hours').value;
        const delayMinutes = action.querySelector('.delay-minutes').value;
        const dynamicInputs = action.querySelectorAll('.dynamic-fields select, .dynamic-fields input, .dynamic-fields textarea');
        
        if (actionType) {
            actionsData.push({
                type: actionType,
                delay: {
                    hours: parseInt(delayHours),
                    minutes: parseInt(delayMinutes)
                },
                parameters: Array.from(dynamicInputs).map(input => input.value).filter(v => v)
            });
        }
    });
    
    const sequenceData = {
        title: title,
        criteria: criteriaData,
        actions: actionsData,
        createdAt: new Date().toISOString()
    };
    
    console.log('Sequence Data:', JSON.stringify(sequenceData, null, 2));
    alert('Sequence saved successfully! Check console for data.');
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('addSmartSequenceModal'));
    modal.hide();
});