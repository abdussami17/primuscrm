                                    <!-- Bulk Task Delete/Undelete Tab -->
                                    <div class="tab-pane fade" id="bulk-task-tab" role="tabpanel"
                                        aria-labelledby="bulk-task-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Bulk Task Delete/Undelete</h2>
                                            <p class="primus-crm-content-description">Select tasks to delete or
                                                restore deleted tasks.</p>
                                        </div>

                                        <!-- Tabs for Delete and Undelete -->
                                        <ul class="nav nav-tabs mb-4" id="taskTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="task-delete-tab"
                                                    data-bs-toggle="tab" data-bs-target="#task-delete" type="button"
                                                    role="tab" aria-controls="task-delete" aria-selected="true">
                                                    <i class="fas fa-trash me-1"></i> Delete Tasks
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="task-undelete-tab" data-bs-toggle="tab"
                                                    data-bs-target="#task-undelete" type="button" role="tab"
                                                    aria-controls="task-undelete" aria-selected="false">
                                                    <i class="fas fa-trash-restore me-1"></i> Undelete Tasks
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Delete Tasks Content -->
                                        <div class="tab-content" id="taskTabContent">
                                            <div class="tab-pane fade show active" id="task-delete" role="tabpanel"
                                                aria-labelledby="task-delete-tab">
                                                <div class="primus-crm-settings-section">
                                                    <h3 class="primus-crm-section-title">
                                                        <span class="primus-crm-section-icon"><i
                                                                class="fas fa-filter"></i></span>
                                                        Filters & Options
                                                    </h3>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Created By</label>
                                                            <select class="form-select" id="taskCreatedByFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="taskAssignedToFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Priority</label>
                                                            <select class="form-select" id="taskPriorityFilter">
                                                                <option value="">All Priorities</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-select" id="taskStatusFilter">
                                                                <option value="">All Statuses</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Task Type</label>
                                                            <select class="form-select" id="taskTypeFilter">
                                                                <option value="">All Task Types</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Start Task Due Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="startTaskDueDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">End Task Due Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="endTaskDueDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-tasks"></i></span>
                                                            Tasks
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="deleteTasksBtn" class="btn btn-danger"
                                                                disabled>
                                                                <i class="fas fa-trash me-1"></i> <span
                                                                    class="d-none d-md-inline">Delete
                                                                    Selected</span>
                                                            </button>
                                                            <button id="refreshTasksBtn"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                            <div
                                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                                                                <a href="javascript:void(0);"
                                                                    onclick="window.print()"
                                                                    class="btn btn-light border border-1 d-flex align-items-center">
                                                                    <i class="isax isax-printer me-1"></i>Print
                                                                </a>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-outline-white d-inline-flex align-items-center"
                                                                        data-bs-toggle="dropdown">
                                                                        <i
                                                                            class="isax isax-export-1 me-1"></i>Export
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="#">PDF</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (XLSX)</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (CSV)</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-hover border">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="50"><input type="checkbox"
                                                                            id="selectAllTasks"
                                                                            class="form-check-input"></th>
                                                                    <th>Task Name</th>
                                                                    <th>Task Type</th>
                                                                    <th>Priority</th>
                                                                    <th>Status</th>
                                                                    <th>Due Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Created By</th>
                                                                    <th>Deal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tasksTableBody">
                                                                <tr><td colspan="10" class="text-center">Loading data...</td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="tasksSelectionInfo" class="text-muted small">0
                                                            tasks selected</div>
                                                        <div class="text-muted small" id="tasksCount">Showing 4
                                                            tasks</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Undelete Tasks Content -->
                                            <div class="tab-pane fade" id="task-undelete" role="tabpanel"
                                                aria-labelledby="task-undelete-tab">
                                                <div class="primus-crm-settings-section">
                                                    <h3 class="primus-crm-section-title">
                                                        <span class="primus-crm-section-icon"><i
                                                                class="fas fa-filter"></i></span>
                                                        Filters & Options
                                                    </h3>

                                                    <!-- Undo History Dropdown -->
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Previous Undo History</label>
                                                            <select class="form-select" id="taskUndoHistory">
                                                                <option value="">-- Select Previous Undo --</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Created By</label>
                                                            <select class="form-select" id="undeleteTaskCreatedByFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select"
                                                                id="undeleteTaskAssignedToFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Priority</label>
                                                            <select class="form-select" id="undeleteTaskPriorityFilter">
                                                                <option value="">All Priorities</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-select" id="undeleteTaskStatusFilter">
                                                                <option value="">All Statuses</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Task Type</label>
                                                            <select class="form-select" id="undeleteTaskTypeFilter">
                                                                <option value="">All Task Types</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Start Task Due Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="undeleteStartTaskDueDate"
                                                                    placeholder="Click To Enter">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">End Task Due Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="undeleteEndTaskDueDate"
                                                                    placeholder="Click To Enter">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-trash-restore"></i></span>
                                                            Deleted Tasks
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="undeleteTasksBtn" class="btn btn-success"
                                                                disabled>
                                                                <i class="fas fa-trash-restore me-1"></i> <span
                                                                    class="d-none d-md-inline">Restore
                                                                    Selected</span>
                                                            </button>
                                                            <button id="refreshDeletedTasksBtn"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                            <div
                                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                                                                <a href="javascript:void(0);"
                                                                    onclick="window.print()"
                                                                    class="btn btn-light border border-1 d-flex align-items-center">
                                                                    <i class="isax isax-printer me-1"></i>Print
                                                                </a>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-outline-white d-inline-flex align-items-center"
                                                                        data-bs-toggle="dropdown">
                                                                        <i
                                                                            class="isax isax-export-1 me-1"></i>Export
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="#">PDF</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (XLSX)</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (CSV)</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-hover border">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="50"><input type="checkbox"
                                                                            id="selectAllDeletedTasks"
                                                                            class="form-check-input"></th>
                                                                    <th>Task Name</th>
                                                                    <th>Task Type</th>
                                                                    <th>Priority</th>
                                                                    <th>Status</th>
                                                                    <th>Due Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Created By</th>
                                                                    <th>Deal</th>
                                                                    <th>Deleted Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="deletedTasksTableBody">
                                                                <tr><td colspan="11" class="text-center">Loading data...</td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="deletedTasksSelectionInfo"
                                                            class="text-muted small">0 tasks selected</div>
                                                        <div class="text-muted small" id="deletedTasksCount">Showing
                                                            3 deleted tasks</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Bulk Task Delete page loaded - Initializing...');
    
    // Load filters
    loadFilters();
    loadDeletionHistory();
    
    // Load initial data
    loadTasks();
    loadDeletedTasks();
    
    // Setup table selections
    setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo', 'deleteTasksBtn');
    setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks', 'deletedTasksSelectionInfo', 'undeleteTasksBtn');
    
    // Filter change listeners - Active Tasks
    const activeFilters = document.querySelectorAll('#task-delete select, #task-delete input.cf-datepicker');
    activeFilters.forEach(filter => {
        filter.addEventListener('change', loadTasks);
    });
    
    // Filter change listeners - Deleted Tasks
    const deletedFilters = document.querySelectorAll('#task-undelete select, #task-undelete input.cf-datepicker');
    deletedFilters.forEach(filter => {
        filter.addEventListener('change', loadDeletedTasks);
    });
    
    // Refresh buttons
    document.getElementById('refreshTasksBtn').addEventListener('click', loadTasks);
    document.getElementById('refreshDeletedTasksBtn').addEventListener('click', loadDeletedTasks);
    
    // Delete button
    document.getElementById('deleteTasksBtn').addEventListener('click', handleDelete);
    
    // Restore button
    document.getElementById('undeleteTasksBtn').addEventListener('click', handleRestore);
});

// Load filter options
async function loadFilters() {
    try {
        console.log('Fetching filters from /settings/bulk-task-delete/filters...');
        
        const res = await fetch('/settings/bulk-task-delete/filters', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        
        console.log('Response status:', res.status);
        
        if (!res.ok) {
            const errorText = await res.text();
            console.error('Response not OK:', errorText);
            throw new Error('Failed to load filters: ' + res.status);
        }
        
        const data = await res.json();
        
        console.log('Filters loaded from backend:', data);
        console.log('Users count:', data.users?.length || 0);
        console.log('Task types count:', data.task_types?.length || 0);
        console.log('Statuses count:', data.statuses?.length || 0);
        console.log('Priorities count:', data.priorities?.length || 0);
        
        // Ensure data properties exist and are arrays
        const users = Array.isArray(data.users) ? data.users : [];
        const taskTypes = Array.isArray(data.task_types) ? data.task_types : [];
        const statuses = Array.isArray(data.statuses) ? data.statuses : [];
        const priorities = Array.isArray(data.priorities) ? data.priorities : [];
        
        // Populate user dropdowns (both tabs)
        populateUserDropdowns(users);
        
        // Populate other filter dropdowns
        populateSelect('taskTypeFilter', taskTypes);
        populateSelect('undeleteTaskTypeFilter', taskTypes);
        populateSelect('taskStatusFilter', statuses);
        populateSelect('undeleteTaskStatusFilter', statuses);
        populateSelect('taskPriorityFilter', priorities);
        populateSelect('undeleteTaskPriorityFilter', priorities);
        
        console.log('All filters populated successfully');
        
    } catch (err) {
        console.error('Error loading filters:', err);
        console.error('Error stack:', err.stack);
        alert('Failed to load filter options: ' + err.message + '. Check console for details.');
    }
}

// Load deletion history
async function loadDeletionHistory() {
    try {
        const res = await fetch('/settings/bulk-task-delete/deletion-history', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load deletion history');
        const history = await res.json();
        
        console.log(`Loaded ${history.length} deletion history entries`);
        
        const select = document.getElementById('taskUndoHistory');
        if (select) {
            // Clear existing options except first
            while (select.options.length > 1) {
                select.remove(1);
            }
            // Add history options
            history.forEach(item => {
                const option = document.createElement('option');
                option.value = item.value;
                option.textContent = item.label;
                select.appendChild(option);
            });
            console.log('✓ Deletion history populated');
        } else {
            console.warn('✗ taskUndoHistory element not found');
        }
        
    } catch (err) {
        console.error('Error loading deletion history:', err);
    }
}

function populateUserDropdowns(users) {
    const userSelects = [
        'taskCreatedByFilter',
        'taskAssignedToFilter',
        'undeleteTaskCreatedByFilter',
        'undeleteTaskAssignedToFilter'
    ];
    
    console.log(`Populating ${userSelects.length} user dropdowns with ${users.length} users:`, users);
    
    userSelects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (select) {
            console.log(`Found element: ${selectId}, current options: ${select.options.length}`);
            
            // Clear existing options except first
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Add user options
            let added = 0;
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                select.appendChild(option);
                added++;
            });
            console.log(`✓ ${selectId}: ${added} users added (total options now: ${select.options.length})`);
        } else {
            console.error(`✗ ${selectId}: Element not found!`);
        }
    });
}

function populateSelect(selectId, items) {
    const select = document.getElementById(selectId);
    if (!select) {
        console.error(`✗ ${selectId}: Element not found!`);
        return;
    }
    
    console.log(`Populating ${selectId} with ${items.length} items:`, items);
    
    // Clear existing options except first
    const firstOption = select.options[0];
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Add items
    let added = 0;
    items.forEach(item => {
        if (item) {
            const option = document.createElement('option');
            option.value = item;
            option.textContent = item;
            select.appendChild(option);
            added++;
        }
    });
    
    console.log(`✓ ${selectId}: ${added} options added (total options now: ${select.options.length})`);
}

// Load active tasks
async function loadTasks() {
    const filters = {
        created_by: document.getElementById('taskCreatedByFilter')?.value || '',
        assigned_to: document.getElementById('taskAssignedToFilter')?.value || '',
        task_type: document.getElementById('taskTypeFilter')?.value || '',
        status: document.getElementById('taskStatusFilter')?.value || '',
        priority: document.getElementById('taskPriorityFilter')?.value || '',
        start_date: document.getElementById('startTaskDueDate')?.value || '',
        end_date: document.getElementById('endTaskDueDate')?.value || ''
    };
    
    console.log('Loading tasks with filters:', filters);
    const params = new URLSearchParams(filters);
    
    try {
        const res = await fetch('/settings/bulk-task-delete/tasks?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load tasks');
        const data = await res.json();
        
        console.log(`Loaded ${data.count} active tasks`);
        renderTasksTable(data.items);
        document.getElementById('tasksCount').textContent = `Showing ${data.count} tasks`;
        setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo', 'deleteTasksBtn');
    } catch (err) {
        console.error('Error loading tasks:', err);
        document.getElementById('tasksTableBody').innerHTML = '<tr><td colspan="10" class="text-center text-danger">Error loading data. Please check console for details.</td></tr>';
    }
}

// Load deleted tasks
async function loadDeletedTasks() {
    const filters = {
        deletion_date: document.getElementById('taskUndoHistory')?.value || '',
        created_by: document.getElementById('undeleteTaskCreatedByFilter')?.value || '',
        assigned_to: document.getElementById('undeleteTaskAssignedToFilter')?.value || '',
        task_type: document.getElementById('undeleteTaskTypeFilter')?.value || '',
        status: document.getElementById('undeleteTaskStatusFilter')?.value || '',
        priority: document.getElementById('undeleteTaskPriorityFilter')?.value || '',
        start_date: document.getElementById('undeleteStartTaskDueDate')?.value || '',
        end_date: document.getElementById('undeleteEndTaskDueDate')?.value || ''
    };
    
    console.log('Loading deleted tasks with filters:', filters);
    const params = new URLSearchParams(filters);
    
    try {
        const res = await fetch('/settings/bulk-task-delete/deleted-tasks?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load deleted tasks');
        const data = await res.json();
        
        console.log(`Loaded ${data.count} deleted tasks`);
        renderDeletedTasksTable(data.items);
        document.getElementById('deletedTasksCount').textContent = `Showing ${data.count} deleted tasks`;
        setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks', 'deletedTasksSelectionInfo', 'undeleteTasksBtn');
    } catch (err) {
        console.error('Error loading deleted tasks:', err);
        document.getElementById('deletedTasksTableBody').innerHTML = '<tr><td colspan="11" class="text-center text-danger">Error loading data. Please check console for details.</td></tr>';
    }
}

// Render tasks table
function renderTasksTable(items) {
    const tbody = document.getElementById('tasksTableBody');
    tbody.innerHTML = '';
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-center">No tasks found</td></tr>';
        return;
    }
    
    items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${item.id}"></td>
            <td>${item.task_name}</td>
            <td>${item.task_type}</td>
            <td>${item.priority}</td>
            <td>${item.status}</td>
            <td>${item.due_date}</td>
            <td>${item.customer}</td>
            <td>${item.assigned_to}</td>
            <td>${item.created_by}</td>
            <td>${item.deal}</td>
        `;
        tbody.appendChild(tr);
    });
}

// Render deleted tasks table
function renderDeletedTasksTable(items) {
    const tbody = document.getElementById('deletedTasksTableBody');
    tbody.innerHTML = '';
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="11" class="text-center">No deleted tasks found</td></tr>';
        return;
    }
    
    items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${item.id}"></td>
            <td>${item.task_name}</td>
            <td>${item.task_type}</td>
            <td>${item.priority}</td>
            <td>${item.status}</td>
            <td>${item.due_date}</td>
            <td>${item.customer}</td>
            <td>${item.assigned_to}</td>
            <td>${item.created_by}</td>
            <td>${item.deal}</td>
            <td>${item.deleted_date}</td>
        `;
        tbody.appendChild(tr);
    });
}

// Setup table selection
function setupTableSelection(bodyId, selectAllId, infoId, btnId) {
    const tbody = document.getElementById(bodyId);
    const selectAll = document.getElementById(selectAllId);
    const info = document.getElementById(infoId);
    const btn = document.getElementById(btnId);
    
    if (!tbody || !selectAll || !info || !btn) return;
    
    // Select all checkbox
    selectAll.addEventListener('change', function() {
        const checkboxes = tbody.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelection();
    });
    
    // Individual checkboxes
    tbody.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateSelection();
        }
    });
    
    function updateSelection() {
        const checkboxes = tbody.querySelectorAll('.row-checkbox');
        const checkedBoxes = tbody.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectAll.checked = checkboxes.length > 0 && count === checkboxes.length;
        info.textContent = `${count} tasks selected`;
        btn.disabled = count === 0;
    }
    
    // Initial update
    updateSelection();
}

// Handle delete
async function handleDelete() {
    const checkedBoxes = document.querySelectorAll('#tasksTableBody .row-checkbox:checked');
    const taskIds = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-id'));
    
    if (taskIds.length === 0) {
        alert('Please select at least one task to delete');
        return;
    }
    
    if (!confirm(`Are you sure you want to delete ${taskIds.length} task(s)? This action can be undone from the Undelete tab.`)) {
        return;
    }
    
    try {
        const res = await fetch('/settings/bulk-task-delete/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify({ task_ids: taskIds })
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert(data.message);
            loadTasks();
            loadDeletedTasks();
            loadDeletionHistory();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (err) {
        console.error('Error deleting tasks:', err);
        alert('Failed to delete tasks. Please try again.');
    }
}

// Handle restore
async function handleRestore() {
    const checkedBoxes = document.querySelectorAll('#deletedTasksTableBody .row-checkbox:checked');
    const taskIds = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-id'));
    
    if (taskIds.length === 0) {
        alert('Please select at least one task to restore');
        return;
    }
    
    if (!confirm(`Are you sure you want to restore ${taskIds.length} task(s)?`)) {
        return;
    }
    
    try {
        const res = await fetch('/settings/bulk-task-delete/restore', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify({ task_ids: taskIds })
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert(data.message);
            loadTasks();
            loadDeletedTasks();
            loadDeletionHistory();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (err) {
        console.error('Error restoring tasks:', err);
        alert('Failed to restore tasks. Please try again.');
    }
}
</script>