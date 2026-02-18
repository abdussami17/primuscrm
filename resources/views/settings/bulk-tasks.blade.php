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
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select">
                                                                <option value="">All Users</option>
                                                                <option value="David Johnson">David Johnson</option>
                                                                <option value="Amanda Lee">Amanda Lee</option>
                                                                <option value="Steven Clark">Steven Clark</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="taskAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="taskSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="taskBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Task Type</label>
                                                            <select class="form-select" id="taskTypeFilter">
                                                                <option value="">All Task Types</option>
                                                                <option value="call">Call</option>
                                                                <option value="email">Email</option>
                                                                <option value="meeting">Meeting</option>
                                                                <option value="follow_up">Follow-up</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="salesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="cancelled">Cancelled</option>
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
                                                                    <th>Sales Status</th>
                                                                    <th>Task Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tasksTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Follow up on quote</td>
                                                                    <td>Call</td>
                                                                    <td>In Progress</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>John Carter</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Send proposal email</td>
                                                                    <td>Email</td>
                                                                    <td>Pending</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Emma Wilson</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Mike Brown</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Schedule test drive</td>
                                                                    <td>Meeting</td>
                                                                    <td>Completed</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>John Doe</td>
                                                                    <td>Bob Johnson</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Final negotiation call</td>
                                                                    <td>Call</td>
                                                                    <td>In Progress</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Olivia Davis</td>
                                                                    <td>John Doe</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Jane Smith</td>
                                                                </tr>
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
                                                                <option value="undo1">Dec 23, 2025; 4:59 AM - John
                                                                    Doe</option>
                                                                <option value="undo2">Dec 22, 2025; 3:30 PM - Jane
                                                                    Smith</option>
                                                                <option value="undo3">Dec 21, 2025; 11:15 AM - Bob
                                                                    Johnson</option>
                                                                <option value="undo4">Dec 20, 2025; 2:45 PM - Sarah
                                                                    Williams</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select">
                                                                <option value="">All Users</option>
                                                                <option value="David Johnson">David Johnson</option>
                                                                <option value="Amanda Lee">Amanda Lee</option>
                                                                <option value="Steven Clark">Steven Clark</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select"
                                                                id="undeleteTaskAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="undeleteTaskSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select"
                                                                id="undeleteTaskBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Task Type</label>
                                                            <select class="form-select" id="undeleteTaskTypeFilter">
                                                                <option value="">All Task Types</option>
                                                                <option value="call">Call</option>
                                                                <option value="email">Email</option>
                                                                <option value="meeting">Meeting</option>
                                                                <option value="follow_up">Follow-up</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select"
                                                                id="undeleteSalesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="cancelled">Cancelled</option>
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
                                                                    <th>Sales Status</th>
                                                                    <th>Task Date</th>
                                                                    <th>Customer</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                    <th>Deleted Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="deletedTasksTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Old follow-up call</td>
                                                                    <td>Call</td>
                                                                    <td>Cancelled</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>David Lee</td>
                                                                    <td>John Doe</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>2025-12-01</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Cancelled meeting</td>
                                                                    <td>Meeting</td>
                                                                    <td>Cancelled</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Lisa Anderson</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>2025-12-05</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Outdated email task</td>
                                                                    <td>Email</td>
                                                                    <td>Completed</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Tom Harris</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>2025-12-08</td>
                                                                </tr>
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