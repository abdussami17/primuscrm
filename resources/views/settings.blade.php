@extends('layouts.app')


@section('title','Settings')


@section('content')
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4" id="confirmationModalBody">
                <!-- Dynamic content -->
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" id="confirmActionBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4" id="successModalBody">
                Operation completed successfully.
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <!-- Merge comparison modal moved to partial: resources/views/settings/merge-sold-deals.blade.php -->


        {{-- Setting Code main Start --}}

        <div class="content">

            <!-- start row -->
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="primus-crm-container">
                        <div class="primus-crm-layout">
                            <aside class="primus-crm-sidebar">
                                <div class="primus-crm-search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="primusCrmSearchInput" placeholder="Search settings...">
                                </div>

                                <!-- Bootstrap Tabs Navigation -->
                                <ul class="nav nav-tabs flex-column" id="primusCrmSettingsNav" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="contact-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#contact-info" type="button" role="tab"
                                            aria-controls="contact-info" aria-selected="true">
                                            <i class="fas fa-cog me-2"></i>Dealership Contact Information
                                        </button>
                                    </li>


                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="ip-restrictions-tab" data-bs-toggle="tab"
                                            data-bs-target="#ip-restrictions" type="button" role="tab"
                                            aria-controls="ip-restrictions" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>IP Restrictions
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab"
                                            data-bs-target="#notifications" type="button" role="tab"
                                            aria-controls="notifications" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>Notification Center
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="store-hours-tab" data-bs-toggle="tab"
                                            data-bs-target="#store-hours" type="button" role="tab"
                                            aria-controls="store-hours" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>Store Hours
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                            data-bs-target="#security" type="button" role="tab"
                                            aria-controls="security" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>Store Security
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="merge-sold-deals-tab" data-bs-toggle="tab"
                                            data-bs-target="#mergesolddeals" type="button" role="tab"
                                            aria-controls="mergesolddeals" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>Merge Sold Deals
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab"
                                            data-bs-target="#permissions" type="button" role="tab"
                                            aria-controls="permissions" aria-selected="false">
                                            <i class="fas fa-cog me-2"></i>Team/Role Based Permissions
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="email-account-tab" data-bs-toggle="tab"
                                            data-bs-target="#email-account" type="button" role="tab"
                                            aria-controls="email-account" aria-selected="false">
                                            <i class="fas fa-envelope me-2"></i>Email/Lead Account Setup
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex justify-content-between align-items-start"
                                            id="email-footer-tab" data-bs-toggle="tab"
                                            data-bs-target="#email-footer-configuration-tab" type="button"
                                            role="tab" aria-controls="email-account" aria-selected="false">
                                            <i class="fas fa-envelope me-2 mt-1"></i><span>Email Header/Footer
                                                Configuration</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="bulk-delete" data-bs-toggle="tab"
                                            data-bs-target="#bulk-task-tab" type="button" role="tab"
                                            aria-controls="bulk-delete" aria-selected="false">
                                            <i class="fas fa-user me-2 mt-1"></i><span>Bulk Task
                                                Delete/Undelete</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="bulklead-delete" data-bs-toggle="tab"
                                            data-bs-target="#bulk-leads-tab" type="button" role="tab"
                                            aria-controls="bulk-delete" aria-selected="false">
                                            <i class="fas fa-user me-2 mt-1"></i><span>Bulk Lead Delete/Undelete
                                            </span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="bulkreassign-delete" data-bs-toggle="tab"
                                            data-bs-target="#customer-reassignment-tab" type="button" role="tab"
                                            aria-controls="bulk-delete" aria-selected="false">
                                            <i class="fas fa-user me-2 mt-1"></i><span>Customer Reassignment
                                            </span>
                                        </button>
                                    </li>
                                </ul>
                            </aside>

                            <main class="primus-crm-main-content">
                                <!-- Bootstrap Tab Content -->
                                <div class="tab-content" id="primusCrmContentArea">


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

                                    <!-- Bulk Leads & Deals Delete/Undelete Tab -->
                                    <div class="tab-pane fade" id="bulk-leads-tab" role="tabpanel"
                                        aria-labelledby="bulk-leads-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Bulk Leads Delete/Undelete</h2>
                                            <p class="primus-crm-content-description">Select leads to delete or
                                                restore deleted items.</p>
                                        </div>

                                        <!-- Tabs for Delete and Undelete -->
                                        <ul class="nav nav-tabs mb-4" id="leadsTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="leads-delete-tab"
                                                    data-bs-toggle="tab" data-bs-target="#leads-delete"
                                                    type="button" role="tab" aria-controls="leads-delete"
                                                    aria-selected="true">
                                                    <i class="fas fa-trash me-1"></i> Delete Leads
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="leads-undelete-tab"
                                                    data-bs-toggle="tab" data-bs-target="#leads-undelete"
                                                    type="button" role="tab" aria-controls="leads-undelete"
                                                    aria-selected="false">
                                                    <i class="fas fa-trash-restore me-1"></i> Undelete Leads
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Delete Leads & Deals Content -->
                                        <div class="tab-content" id="leadsTabContent">
                                            <div class="tab-pane fade show active" id="leads-delete" role="tabpanel"
                                                aria-labelledby="leads-delete-tab">
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
                                                            <select class="form-select" id="leadAssignedToFilter">
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
                                                                id="leadSecondaryAssignedFilter">
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
                                                            <select class="form-select" id="leadBDCAgentFilter">
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
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="salesTypeFilter">
                                                                <option value="">All Sales Types</option>
                                                                <option value="direct_sale">Direct Sale</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="leadTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="new">New</option>
                                                                <option value="existing">Existing</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="walk_in">Walk-in</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select" id="leadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="new">New</option>
                                                                <option value="contacted">Contacted</option>
                                                                <option value="qualified">Qualified</option>
                                                                <option value="proposal">Proposal</option>
                                                                <option value="closed">Closed</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select" id="inventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="sedan">Sedan</option>
                                                                <option value="suv">SUV</option>
                                                                <option value="truck">Truck</option>
                                                                <option value="convertible">Convertible</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="leadSalesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="negotiation">Negotiation</option>
                                                                <option value="closed_won">Closed Won</option>
                                                                <option value="closed_lost">Closed Lost</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="sourcesFilter">
                                                                <option value="">All Sources</option>
                                                                <option value="website">Website</option>
                                                                <option value="walk_in">Walk-in</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="phone">Phone</option>
                                                                <option value="email">Email</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="dealTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="retail">Retail</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="leadSalesTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="finance">Finance</option>
                                                                <option value="lease">Lease</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Start Lead Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="startLeadCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">End Lead Created Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="endLeadCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-users"></i></span>
                                                            Leads
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="deleteLeadsBtn" class="btn btn-danger"
                                                                disabled>
                                                                <i class="fas fa-trash me-1"></i> <span
                                                                    class="d-none d-md-inline">Delete
                                                                    Selected</span>
                                                            </button>
                                                            <button id="refreshLeadsBtn"
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
                                                    <style>
                                                        .table {
                                                            table-layout: auto;
                                                            width: max-content;
                                                            /* KEY */
                                                            white-space: nowrap;
                                                        }

                                                        .table th,
                                                        .table td {
                                                            white-space: nowrap;
                                                            vertical-align: middle;
                                                        }


                                                        /* Optional: allow horizontal scrolling instead of breaking layout */
                                                        .table-responsive {
                                                            overflow-x: auto;
                                                        }

                                                        .leads-table-wrapper {
                                                            width: 100%;
                                                            max-width: 100%;
                                                            overflow-x: auto;
                                                        }
                                                    </style>
                                                    <div class="table-responsive leads-table-wrapper">
                                                        <table class="table border ">

                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="50"><input type="checkbox"
                                                                            id="selectAllLeads"
                                                                            class="form-check-input"></th>
                                                                    <th>Customer Name</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Lead Created Date</th>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="leadsTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Robert Miller</td>
                                                                    <td>Direct Sale</td>
                                                                    <td>New</td>
                                                                    <td>New</td>
                                                                    <td>SUV</td>
                                                                    <td>In Progress</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Website</td>
                                                                    <td>Retail</td>
                                                                    <td>John Doe</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Anna Taylor</td>
                                                                    <td>Lease</td>
                                                                    <td>Existing</td>
                                                                    <td>Contacted</td>
                                                                    <td>Sedan</td>
                                                                    <td>Pending</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Referral</td>
                                                                    <td>Lease</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>James Wilson</td>
                                                                    <td>Finance</td>
                                                                    <td>Referral</td>
                                                                    <td>Qualified</td>
                                                                    <td>Truck</td>
                                                                    <td>Negotiation</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Ad Campaign</td>
                                                                    <td>Finance</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Sophia Martinez</td>
                                                                    <td>Direct Sale</td>
                                                                    <td>Walk-in</td>
                                                                    <td>Proposal</td>
                                                                    <td>Convertible</td>
                                                                    <td>Closed Won</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Walk-in</td>
                                                                    <td>Retail</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>John Doe</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="leadsSelectionInfo" class="text-muted small">0
                                                            leads selected</div>
                                                        <div class="text-muted small" id="leadsCount">Showing 4
                                                            leads</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Undelete Leads & Deals Content -->
                                            <div class="tab-pane fade" id="leads-undelete" role="tabpanel"
                                                aria-labelledby="leads-undelete-tab">
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
                                                            <select class="form-select" id="leadUndoHistory">
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
                                                                id="undeleteLeadAssignedToFilter">
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
                                                                id="undeleteLeadSecondaryAssignedFilter">
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
                                                                id="undeleteLeadBDCAgentFilter">
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
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select"
                                                                id="undeleteSalesTypeFilter">
                                                                <option value="">All Sales Types</option>
                                                                <option value="direct_sale">Direct Sale</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="undeleteLeadTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="new">New</option>
                                                                <option value="existing">Existing</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="walk_in">Walk-in</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="new">New</option>
                                                                <option value="contacted">Contacted</option>
                                                                <option value="qualified">Qualified</option>
                                                                <option value="proposal">Proposal</option>
                                                                <option value="closed">Closed</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select"
                                                                id="undeleteInventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="sedan">Sedan</option>
                                                                <option value="suv">SUV</option>
                                                                <option value="truck">Truck</option>
                                                                <option value="convertible">Convertible</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadSalesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="negotiation">Negotiation</option>
                                                                <option value="closed_won">Closed Won</option>
                                                                <option value="closed_lost">Closed Lost</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="undeleteSourcesFilter">
                                                                <option value="">All Sources</option>
                                                                <option value="website">Website</option>
                                                                <option value="walk_in">Walk-in</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="phone">Phone</option>
                                                                <option value="email">Email</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="undeleteDealTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="retail">Retail</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadSalesTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="finance">Finance</option>
                                                                <option value="lease">Lease</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Start Lead Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="undeleteStartLeadCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">End Lead Created Date</label>
                                                            <div class="input-group">
                                                                <input type="text" placeholder="Click To Enter"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    id="undeleteEndLeadCreatedDate">
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
                                                            Deleted Leads
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="undeleteLeadsBtn" class="btn btn-success"
                                                                disabled>
                                                                <i class="fas fa-trash-restore me-1"></i> <span
                                                                    class="d-none d-md-inline">Restore
                                                                    Selected</span>
                                                            </button>
                                                            <button id="refreshDeletedLeadsBtn"
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
                                                                            id="selectAllDeletedLeads"
                                                                            class="form-check-input"></th>
                                                                    <th>Customer Name</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <td>Dec 12, 2025</td>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                    <th>Deleted Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="deletedLeadsTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Peter Johnson</td>
                                                                    <td>Lease</td>
                                                                    <td>Existing</td>
                                                                    <td>Closed</td>
                                                                    <td>Sedan</td>
                                                                    <td>Closed Lost</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Website</td>
                                                                    <td>Lease</td>
                                                                    <td>John Doe</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Dec 12, 2025</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Laura Clark</td>
                                                                    <td>Direct Sale</td>
                                                                    <td>New</td>
                                                                    <td>New</td>
                                                                    <td>SUV</td>
                                                                    <td>Pending</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Walk-in</td>
                                                                    <td>Retail</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Dec 12, 2025</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Mark Evans</td>
                                                                    <td>Finance</td>
                                                                    <td>Referral</td>
                                                                    <td>Qualified</td>
                                                                    <td>Truck</td>
                                                                    <td>Negotiation</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Referral</td>
                                                                    <td>Finance</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>Dec 12, 2025</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="deletedLeadsSelectionInfo"
                                                            class="text-muted small">0 leads selected</div>
                                                        <div class="text-muted small" id="deletedLeadsCount">Showing
                                                            3 deleted leads</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Customer Reassignment Tab -->
                                    <div class="tab-pane fade" id="customer-reassignment-tab" role="tabpanel"
                                        aria-labelledby="customer-reassignment-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Customer Reassignment</h2>
                                            <p class="primus-crm-content-description">Reassign customers to
                                                different sales representatives or teams.</p>
                                        </div>

                                        <!-- Tabs for Reassignment and Undo Reassignment -->
                                        <ul class="nav nav-tabs mb-4" id="reassignmentTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="reassignment-tab"
                                                    data-bs-toggle="tab" data-bs-target="#reassignment"
                                                    type="button" role="tab" aria-controls="reassignment"
                                                    aria-selected="true">
                                                    <i class="fas fa-user-check me-1"></i> Customer Reassignment
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="undo-reassignment-tab"
                                                    data-bs-toggle="tab" data-bs-target="#undo-reassignment"
                                                    type="button" role="tab" aria-controls="undo-reassignment"
                                                    aria-selected="false">
                                                    <i class="fas fa-undo me-1"></i> Undo Reassignment
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Customer Reassignment Content -->
                                        <div class="tab-content" id="reassignmentTabContent">
                                            <div class="tab-pane fade show active" id="reassignment" role="tabpanel"
                                                aria-labelledby="reassignment-tab">
                                                <div class="primus-crm-settings-section">
                                                    <h3 class="primus-crm-section-title">
                                                        <span class="primus-crm-section-icon"><i
                                                                class="fas fa-filter"></i></span>
                                                        Filters & Options
                                                    </h3>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select">
                                                                <option value="">All Users</option>
                                                                <option value="David Johnson">David Johnson</option>
                                                                <option value="Amanda Lee">Amanda Lee</option>
                                                                <option value="Steven Clark">Steven Clark</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select"
                                                                id="customerAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="customerSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="customerBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select" id="leadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="new">New</option>
                                                                <option value="qualified">Qualified</option>
                                                                <option value="prospect">Prospect</option>
                                                                <option value="customer">Customer</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="leadTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="inbound">Inbound</option>
                                                                <option value="outbound">Outbound</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="website">Website</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select" id="inventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="sedan">Sedan</option>
                                                                <option value="suv">SUV</option>
                                                                <option value="truck">Truck</option>
                                                                <option value="convertible">Convertible</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="salesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="negotiation">Negotiation</option>
                                                                <option value="closed_won">Closed Won</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="sourcesFilter">
                                                                <option value="">All Sources</option>
                                                                <option value="website">Website</option>
                                                                <option value="walk_in">Walk-in</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="phone">Phone</option>
                                                                <option value="email">Email</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="dealTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="retail">Retail</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="salesTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="finance">Finance</option>
                                                                <option value="lease">Lease</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">Start Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="startCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">End Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="endCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Reassign To User</label>
                                                            <select class="" id="reassignSalesRep" multiple>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                new TomSelect('#reassignSalesRep', {
                                                                    plugins: ['checkbox_options', 'clear_button'],
                                                                    placeholder: 'Select Users',
                                                                    persist: false,
                                                                    hideSelected: false,
                                                                    closeAfterSelect: false,
                                                                    allowEmptyOption: true
                                                                });
                                                            });
                                                        </script>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Reassign To Team</label>
                                                            <select class="form-select" id="reassignTeam">
                                                                <option value="">-- Select Team --</option>
                                                                <option value="sales-rep">Sales Rep</option>
                                                                <option value="bdc-agent">BDC Agent</option>
                                                                <option value="fi">F&I</option>
                                                                <option value="sales-manager">Sales Manager</option>
                                                                <option value="bdc-manager">BDC Manager</option>
                                                                <option value="finance-director">Finance Director
                                                                </option>
                                                                <option value="general-sales-manager">General Sales
                                                                    Manager
                                                                </option>
                                                                <option value="general-manager">General Manager
                                                                </option>
                                                                <option value="dealer-principal">Dealer Principal
                                                                </option>
                                                                <option value="admin">Admin</option>
                                                                <option value="reception">Reception</option>
                                                                <option value="service-advisor">Service Advisor
                                                                </option>
                                                                <option value="service-manager">Service Manager
                                                                </option>
                                                                <option value="inventory-manager">Inventory Manager
                                                                </option>
                                                                <option value="fixed-operations-manager">Fixed
                                                                    Operations
                                                                    Manager</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-user-friends"></i></span>
                                                            Customers
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="reassignCustomersBtn"
                                                                class="btn btn-success" disabled
                                                                onclick="handleReassignSelected()">
                                                                <i class="fas fa-user-check me-1"></i> <span
                                                                    class="d-none d-md-inline">Complete
                                                                    Reassignment</span>
                                                            </button>
                                                            <button id="refreshCustomersBtn"
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
                                                                    <th width="50">
                                                                        <input type="checkbox"
                                                                            id="selectAllCustomers"
                                                                            class="form-check-input">
                                                                    </th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Year / Make / Model</th>
                                                                    <th>Email(s)</th>
                                                                    <th>Work Number</th>
                                                                    <th>Cell Number</th>
                                                                    <th>Home Number</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Created Date</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="customersTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Chris</td>
                                                                    <td>Thompson</td>
                                                                    <td>2024 Toyota Camry</td>
                                                                    <td>chris@example.com</td>
                                                                    <td>+1 555-0201</td>
                                                                    <td>+1 555-0101</td>
                                                                    <td>+1 555-0301</td>
                                                                    <td>Qualified</td>
                                                                    <td>Inbound</td>
                                                                    <td>Sedan</td>
                                                                    <td>In Progress</td>
                                                                    <td>Website</td>
                                                                    <td>Retail</td>
                                                                    <td>Finance</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>John Doe</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Amy</td>
                                                                    <td>Roberts</td>
                                                                    <td>2023 Honda CR-V</td>
                                                                    <td>amy@example.com</td>
                                                                    <td>+1 555-0202</td>
                                                                    <td>+1 555-0102</td>
                                                                    <td>-</td>
                                                                    <td>New</td>
                                                                    <td>Referral</td>
                                                                    <td>SUV</td>
                                                                    <td>Pending</td>
                                                                    <td>Walk-in</td>
                                                                    <td>Lease</td>
                                                                    <td>Lease</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Daniel</td>
                                                                    <td>White</td>
                                                                    <td>2022 Ford F-150</td>
                                                                    <td>daniel@example.com</td>
                                                                    <td>-</td>
                                                                    <td>+1 555-0103</td>
                                                                    <td>-</td>
                                                                    <td>Prospect</td>
                                                                    <td>Outbound</td>
                                                                    <td>Truck</td>
                                                                    <td>Negotiation</td>
                                                                    <td>Referral</td>
                                                                    <td>Retail</td>
                                                                    <td>Cash</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Emily</td>
                                                                    <td>Green</td>
                                                                    <td>2025 BMW X5</td>
                                                                    <td>emily@example.com</td>
                                                                    <td>+1 555-0204</td>
                                                                    <td>+1 555-0104</td>
                                                                    <td>+1 555-0304</td>
                                                                    <td>Customer</td>
                                                                    <td>Website</td>
                                                                    <td>SUV</td>
                                                                    <td>Closed Won</td>
                                                                    <td>Email</td>
                                                                    <td>Retail</td>
                                                                    <td>Finance</td>
                                                                    <td>Dec 12, 2025</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>John Doe</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="customersSelectionInfo" class="text-muted small">0
                                                            customers selected</div>
                                                        <div class="text-muted small" id="customersCount">Showing 4
                                                            customers</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Undo Reassignment Content -->
                                            <div class="tab-pane fade" id="undo-reassignment" role="tabpanel"
                                                aria-labelledby="undo-reassignment-tab">
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
                                                            <select class="form-select"
                                                                id="reassignmentUndoHistory">
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
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select">
                                                                <option value="">All Users</option>
                                                                <option value="David Johnson">David Johnson</option>
                                                                <option value="Amanda Lee">Amanda Lee</option>
                                                                <option value="Steven Clark">Steven Clark</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="undoAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="undoSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="undoBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select" id="undoLeadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="new">New</option>
                                                                <option value="qualified">Qualified</option>
                                                                <option value="prospect">Prospect</option>
                                                                <option value="customer">Customer</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="undoLeadTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="inbound">Inbound</option>
                                                                <option value="outbound">Outbound</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="website">Website</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select"
                                                                id="undoInventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="sedan">Sedan</option>
                                                                <option value="suv">SUV</option>
                                                                <option value="truck">Truck</option>
                                                                <option value="convertible">Convertible</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="undoSalesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="negotiation">Negotiation</option>
                                                                <option value="closed_won">Closed Won</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="undoSourcesFilter">
                                                                <option value="">All Sources</option>
                                                                <option value="website">Website</option>
                                                                <option value="walk_in">Walk-in</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="phone">Phone</option>
                                                                <option value="email">Email</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="undoDealTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="retail">Retail</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="undoSalesTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="finance">Finance</option>
                                                                <option value="lease">Lease</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">Start Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="undoStartCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">End Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="undoEndCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-undo"></i></span>
                                                            Previous Reassignments
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="undoReassignBtn" class="btn btn-danger"
                                                                disabled>
                                                                <i class="fas fa-undo me-1"></i> <span
                                                                    class="d-none d-md-inline">Undo Selected
                                                                    Reassignment</span>
                                                            </button>
                                                            <button id="refreshUndoReassignBtn"
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
                                                                    <th width="50">
                                                                        <input type="checkbox"
                                                                            id="selectAllUndoReassignments"
                                                                            class="form-check-input">
                                                                    </th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Year / Make / Model</th>
                                                                    <th>Email(s)</th>
                                                                    <th>Work Number</th>
                                                                    <th>Cell Number</th>
                                                                    <th>Home Number</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Created Date</th>
                                                                    <th>Previous Assigned To</th>
                                                                    <th>Reassigned To</th>
                                                                    <th>Reassignment Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="undoReassignmentsTableBody">
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Chris</td>
                                                                    <td>Thompson</td>
                                                                    <td>2024 Toyota Camry</td>
                                                                    <td>chris@example.com</td>
                                                                    <td>+1 555-0201</td>
                                                                    <td>+1 555-0101</td>
                                                                    <td>+1 555-0301</td>
                                                                    <td>Qualified</td>
                                                                    <td>Inbound</td>
                                                                    <td>Sedan</td>
                                                                    <td>In Progress</td>
                                                                    <td>Website</td>
                                                                    <td>Retail</td>
                                                                    <td>Finance</td>
                                                                    <td>2025-12-01</td>
                                                                    <td>John Doe</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>2025-12-20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Amy</td>
                                                                    <td>Roberts</td>
                                                                    <td>2023 Honda CR-V</td>
                                                                    <td>amy@example.com</td>
                                                                    <td>+1 555-0202</td>
                                                                    <td>+1 555-0102</td>
                                                                    <td>-</td>
                                                                    <td>New</td>
                                                                    <td>Referral</td>
                                                                    <td>SUV</td>
                                                                    <td>Pending</td>
                                                                    <td>Walk-in</td>
                                                                    <td>Lease</td>
                                                                    <td>Lease</td>
                                                                    <td>2025-11-28</td>
                                                                    <td>Jane Smith</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>2025-12-19</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Daniel</td>
                                                                    <td>White</td>
                                                                    <td>2022 Ford F-150</td>
                                                                    <td>daniel@example.com</td>
                                                                    <td>-</td>
                                                                    <td>+1 555-0103</td>
                                                                    <td>-</td>
                                                                    <td>Prospect</td>
                                                                    <td>Outbound</td>
                                                                    <td>Truck</td>
                                                                    <td>Negotiation</td>
                                                                    <td>Referral</td>
                                                                    <td>Retail</td>
                                                                    <td>Cash</td>
                                                                    <td>2025-11-20</td>
                                                                    <td>Bob Johnson</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>2025-12-18</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox"
                                                                            class="form-check-input row-checkbox">
                                                                    </td>
                                                                    <td>Emily</td>
                                                                    <td>Green</td>
                                                                    <td>2025 BMW X5</td>
                                                                    <td>emily@example.com</td>
                                                                    <td>+1 555-0204</td>
                                                                    <td>+1 555-0104</td>
                                                                    <td>+1 555-0304</td>
                                                                    <td>Customer</td>
                                                                    <td>Website</td>
                                                                    <td>SUV</td>
                                                                    <td>Closed Won</td>
                                                                    <td>Email</td>
                                                                    <td>Retail</td>
                                                                    <td>Finance</td>
                                                                    <td>2025-11-15</td>
                                                                    <td>Sarah Williams</td>
                                                                    <td>Mike Brown</td>
                                                                    <td>2025-12-17</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="undoReassignmentsSelectionInfo"
                                                            class="text-muted small">0 reassignments selected</div>
                                                        <div class="text-muted small" id="undoReassignmentsCount">
                                                            Showing 4 previous reassignments</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modals (keep existing modals) -->
                                    <div class="modal fade" id="confirmationModal" tabindex="-1"
                                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="confirmationModalBody">
                                                    <!-- Content will be inserted here -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn"
                                                        id="confirmActionBtn">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="successModal" tabindex="-1"
                                        aria-labelledby="successModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="successModalBody">
                                                    Action completed successfully.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-dismiss="modal">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                                            const successModal = new bootstrap.Modal(document.getElementById('successModal'));

                                            // Generic function to handle checkbox selection and button enable/disable
                                            function setupTableSelection(tableBodyId, selectAllId, selectionInfoId, actionBtnId) {
                                                const tableBody = document.getElementById(tableBodyId);
                                                const selectAll = document.getElementById(selectAllId);
                                                const selectionInfo = document.getElementById(selectionInfoId);
                                                const actionBtn = document.getElementById(actionBtnId);

                                                function updateSelection() {
                                                    const checkboxes = tableBody.querySelectorAll('.row-checkbox');
                                                    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                                                    selectionInfo.textContent = `${checkedCount} selected`;
                                                    actionBtn.disabled = checkedCount === 0;
                                                    selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
                                                }

                                                tableBody.addEventListener('change', function (e) {
                                                    if (e.target.classList.contains('row-checkbox')) updateSelection();
                                                });

                                                selectAll.addEventListener('change', function () {
                                                    const checkboxes = tableBody.querySelectorAll('.row-checkbox');
                                                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                                                    updateSelection();
                                                });

                                                updateSelection(); // initial
                                            }

                                            // Task Delete
                                            setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo', 'deleteTasksBtn');

                                            document.getElementById('deleteTasksBtn').addEventListener('click', function () {
                                                const checkedCount = document.querySelectorAll('#tasksTableBody .row-checkbox:checked').length;
                                                document.getElementById('confirmationModalBody').innerHTML = `Are you sure you want to <strong>delete</strong> ${checkedCount} selected task(s)?`;
                                                document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                                confirmationModal.show();

                                                document.getElementById('confirmActionBtn').onclick = function () {
                                                    document.querySelectorAll('#tasksTableBody .row-checkbox:checked').forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                    confirmationModal.hide();
                                                    successModal.show();
                                                    setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo', 'deleteTasksBtn');
                                                    document.getElementById('tasksCount').textContent = `Showing ${document.querySelectorAll('#tasksTableBody tr').length} tasks`;
                                                };
                                            });

                                            // Task Undelete
                                            setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks', 'deletedTasksSelectionInfo', 'undeleteTasksBtn');

                                            document.getElementById('undeleteTasksBtn').addEventListener('click', function () {
                                                const checkedCount = document.querySelectorAll('#deletedTasksTableBody .row-checkbox:checked').length;
                                                document.getElementById('confirmationModalBody').innerHTML = `Are you sure you want to <strong>restore</strong> ${checkedCount} selected task(s)?`;
                                                document.getElementById('confirmActionBtn').className = 'btn btn-success';
                                                confirmationModal.show();

                                                document.getElementById('confirmActionBtn').onclick = function () {
                                                    document.querySelectorAll('#deletedTasksTableBody .row-checkbox:checked').forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                    confirmationModal.hide();
                                                    successModal.show();
                                                    setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks', 'deletedTasksSelectionInfo', 'undeleteTasksBtn');
                                                    document.getElementById('deletedTasksCount').textContent = `Showing ${document.querySelectorAll('#deletedTasksTableBody tr').length} deleted tasks`;
                                                };
                                            });

                                            // Leads Delete
                                            setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo', 'deleteLeadsBtn');

                                            document.getElementById('deleteLeadsBtn').addEventListener('click', function () {
                                                const checkedCount = document.querySelectorAll('#leadsTableBody .row-checkbox:checked').length;
                                                document.getElementById('confirmationModalBody').innerHTML = `Are you sure you want to <strong>delete</strong> ${checkedCount} selected lead(s)/deal(s)?`;
                                                document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                                confirmationModal.show();

                                                document.getElementById('confirmActionBtn').onclick = function () {
                                                    document.querySelectorAll('#leadsTableBody .row-checkbox:checked').forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                    confirmationModal.hide();
                                                    successModal.show();
                                                    setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo', 'deleteLeadsBtn');
                                                    document.getElementById('leadsCount').textContent = `Showing ${document.querySelectorAll('#leadsTableBody tr').length} leads`;
                                                };
                                            });

                                            // Leads Undelete
                                            setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads', 'deletedLeadsSelectionInfo', 'undeleteLeadsBtn');

                                            document.getElementById('undeleteLeadsBtn').addEventListener('click', function () {
                                                const checkedCount = document.querySelectorAll('#deletedLeadsTableBody .row-checkbox:checked').length;
                                                document.getElementById('confirmationModalBody').innerHTML = `Are you sure you want to <strong>restore</strong> ${checkedCount} selected lead(s)/deal(s)?`;
                                                document.getElementById('confirmActionBtn').className = 'btn btn-success';
                                                confirmationModal.show();

                                                document.getElementById('confirmActionBtn').onclick = function () {
                                                    document.querySelectorAll('#deletedLeadsTableBody .row-checkbox:checked').forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                    confirmationModal.hide();
                                                    successModal.show();
                                                    setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads', 'deletedLeadsSelectionInfo', 'undeleteLeadsBtn');
                                                    document.getElementById('deletedLeadsCount').textContent = `Showing ${document.querySelectorAll('#deletedLeadsTableBody tr').length} deleted leads`;
                                                };
                                            });

                                            // Customer Reassignment
                                            setupTableSelection('customersTableBody', 'selectAllCustomers', 'customersSelectionInfo', 'reassignCustomersBtn');

                                            // Undo Reassignment
                                            setupTableSelection('undoReassignmentsTableBody', 'selectAllUndoReassignments', 'undoReassignmentsSelectionInfo', 'undoReassignBtn');

                                            document.getElementById('undoReassignBtn').addEventListener('click', function () {
                                                const checkedCount = document.querySelectorAll('#undoReassignmentsTableBody .row-checkbox:checked').length;
                                                document.getElementById('confirmationModalBody').innerHTML = `Are you sure you want to <strong>undo</strong> ${checkedCount} selected reassignment(s)?`;
                                                document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                                confirmationModal.show();

                                                document.getElementById('confirmActionBtn').onclick = function () {
                                                    document.querySelectorAll('#undoReassignmentsTableBody .row-checkbox:checked').forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                    confirmationModal.hide();
                                                    successModal.show();
                                                    setupTableSelection('undoReassignmentsTableBody', 'selectAllUndoReassignments', 'undoReassignmentsSelectionInfo', 'undoReassignBtn');
                                                    document.getElementById('undoReassignmentsCount').textContent = `Showing ${document.querySelectorAll('#undoReassignmentsTableBody tr').length} previous reassignments`;
                                                };
                                            });

                                            // Refresh buttons (just reset selection)
                                            document.querySelectorAll('[id^="refresh"]').forEach(btn => {
                                                btn.addEventListener('click', function () {
                                                    const tableId = this.id.replace('refresh', '').replace('Btn', '').toLowerCase();
                                                    const checkboxes = document.querySelectorAll(`#${tableId}TableBody .row-checkbox, #selectAll${tableId.charAt(0).toUpperCase() + tableId.slice(1)}`);
                                                    checkboxes.forEach(cb => cb.checked = false);
                                                    const actionBtn = document.querySelector(`#${this.id.replace('refresh', '').replace('Btn', '').toLowerCase()}Btn`) || this;
                                                    if (actionBtn.id.includes('delete') || actionBtn.id.includes('undelete') || actionBtn.id.includes('reassign')) {
                                                        actionBtn.disabled = true;
                                                    }
                                                    document.querySelectorAll('[id$="SelectionInfo"]').forEach(el => el.textContent = '0 selected');
                                                });
                                            });

                                            // Undo History dropdown functionality
                                            document.querySelectorAll('#taskUndoHistory, #leadUndoHistory, #reassignmentUndoHistory').forEach(dropdown => {
                                                dropdown.addEventListener('change', function () {
                                                    if (this.value) {
                                                        // In a real application, this would fetch the previous undo data
                                                        // For this demo, we'll just show a message
                                                        const modalBody = `This would load the data from the selected undo: "${this.options[this.selectedIndex].text}"`;
                                                        document.getElementById('successModalBody').textContent = modalBody;
                                                        successModal.show();
                                                    }
                                                });
                                            });
                                        });

                                        // Dummy function for reassign selected button
                                        function handleReassignSelected() {
                                            const checkedCount = document.querySelectorAll('#customersTableBody .row-checkbox:checked').length;
                                            const newRep = document.getElementById('reassignSalesRep').selectedOptions[0]?.textContent || 'selected rep';
                                            const newTeam = document.getElementById('reassignTeam').selectedOptions[0]?.textContent || 'selected team';

                                            if (!document.getElementById('reassignSalesRep').value && !document.getElementById('reassignTeam').value) {
                                                alert('Please select at least one reassignment option (Sales Rep or Team).');
                                                return;
                                            }

                                            if (checkedCount === 0) {
                                                alert('Please select at least one customer to reassign.');
                                                return;
                                            }

                                            // Show success message
                                            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                            document.getElementById('successModalBody').textContent = `${checkedCount} customer(s) would be reassigned to ${newRep} (${newTeam}) in a real backend implementation. This is a frontend dummy action.`;
                                            successModal.show();
                                        }
                                    </script>



                                    <div class="tab-pane fade show active" id="contact-info" role="tabpanel"
                                        aria-labelledby="contact-info-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Dealership Contact Information</h2>
                                            <p class="primus-crm-content-description">Configure your dealership's
                                                primary contact details and business information.</p>
                                        </div>
                                        <div class="primus-crm-form-grid">
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Dealership Name</label>
                                                <input type="text" class="primus-crm-form-control"
                                                    value="Primus Motors">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Email Address</label>
                                                <input type="email" class="primus-crm-form-control"
                                                    value="contact@primusmotors.com">
                                                <span class="primus-crm-form-help">Primary email for customer
                                                    communications</span>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Phone Number</label>
                                                <input type="tel" class="primus-crm-form-control"
                                                    value="+1 (555) 123-4567">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Language</label>
                                                <select class="primus-crm-form-control">
                                                    <option selected>English</option>
                                                    <option>French</option>
                                                    <option>Spanish</option>
                                                </select>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Timezone</label>
                                                <select class="primus-crm-form-control">
                                                    <option selected>Eastern Time (ET)</option>
                                                    <option>Central Time (CT)</option>
                                                    <option>Mountain Time (MT)</option>
                                                    <option>Pacific Time (PT)</option>
                                                </select>
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">Business Address</label>
                                                <textarea class="primus-crm-form-control"
                                                    rows="3">123 Main Street, City, State 12345</textarea>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Website URL</label>
                                                <input type="url" class="primus-crm-form-control"
                                                    value="https://primusmotors.com">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Tax ID / EIN</label>
                                                <input type="text" class="primus-crm-form-control"
                                                    value="XX-XXXXXXX">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">License Number</label>
                                                <input type="text" class="primus-crm-form-control"
                                                    value="DLR-123456">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="mergesolddeals" role="tabpanel"
                                        aria-labelledby="mergesolddeals-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Merge Sold Deals</h2>
                                            <p class="primus-crm-content-description">Select exactly two deals to
                                                merge. After selection, you can choose which fields to keep from
                                                each deal.</p>
                                        </div>

                                        <!-- Instructions moved to top -->
                                        <div class="alert alert-info border-info mb-2">
                                            <div class="d-flex">
                                                <div class="me-2">
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                                <div>
                                                    <strong>Instructions:</strong> Select exactly two deals to
                                                    merge. After selection, you can choose which fields to keep from
                                                    each deal.
                                                    <strong>Important:</strong> The DMS ID # field determines which
                                                    deal will be kept as the primary record. Typically, one deal has
                                                    a DMS ID # (the correct lead) and the other is blank (merged
                                                    into the one with DMS ID #).
                                                </div>
                                            </div>
                                        </div>

                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-network-wired"></i></span>
                                                Merge Sold Deals
                                            </h3>

                                            <!-- Merge Button (Initially Disabled) -->
                                            <div class="d-flex justify-content-end">
                                                <button id="mergeDealsBtn"
                                                    class="btn btn-light border border-1 mb-2" disabled>
                                                    <i class="fas fa-merge me-1"></i> Merge Deals
                                                </button>
                                            </div>

                                            <!-- Deals Table -->
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th><input type="checkbox" id="selectAllCheckbox"
                                                                    class="form-check-input"></th>
                                                            <th>DMS ID #</th>
                                                            <th>Customer Info</th>

                                                            <th>Vehicle Info</th>
                                                            <th>Lead Type</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dealsTableBody">
                                                        <!-- Deals will be dynamically populated -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Merge comparison modal moved to partial: resources/views/settings/merge-sold-deals.blade.php -->
                                                        </div>

                                                        <div id="fieldsComparison">
                                                            <!-- Comparison fields will be dynamically populated -->
                                                        </div>
                                                    </div>

                                                    <!-- Loading State -->
                                                    <div id="loadingState" class="text-center py-5"
                                                        style="display: none;">
                                                        <div class="spinner-border text-primary mb-3" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <p>Merging deals, please wait...</p>
                                                    </div>

                                                    <!-- Success State -->
                                                    <div id="successState" class="text-center py-5"
                                                        style="display: none;">
                                                        <div class="text-success mb-3">
                                                            <i class="fas fa-check-circle fa-3x"></i>
                                                        </div>
                                                        <h5>Deals Merged Successfully!</h5>
                                                        <p>The selected deals have been merged into a single record.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="confirmMergeBtn">
                                                        <i class="fas fa-merge me-1"></i> Confirm Merge
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // Updated sample deals data with some having empty DMS IDs
                                        const dealsData = [
                                            {
                                                id: 1,
                                                dmsNumber: "DMS-1001", // Has DMS ID
                                                customerName: "John Smith",
                                                physicalAddress: "123 Main St, New York, NY 10001",
                                                mobileNumber: "+1 (555) 123-4567",
                                                homeNumber: "+1 (555) 987-6543",
                                                workNumber: "+1 (555) 456-7890",
                                                email: "john.smith@example.com",
                                                leadType: "Hot Lead",
                                                source: "Website Inquiry",
                                                salesType: "Direct Sale",
                                                dealType: "New Purchase",
                                                inventoryType: "SUV",
                                                leadStatus: "Closed Won",
                                                vehicleInfo: {
                                                    year: "2023",
                                                    make: "Toyota",
                                                    model: "RAV4",
                                                    stockNumber: "STK-78901",
                                                    vin: "1HGBH41JXMN109186"
                                                },
                                                salesStatus: "Delivered"
                                            },
                                            {
                                                id: 2,
                                                dmsNumber: "", // No DMS ID - will be merged into deal with DMS ID
                                                customerName: "John Smith", // Same customer, duplicate deal
                                                physicalAddress: "123 Main St, New York, NY 10001",
                                                mobileNumber: "+1 (555) 123-4567",
                                                homeNumber: "+1 (555) 987-6543",
                                                workNumber: "+1 (555) 456-7890",
                                                email: "john.smith@example.com",
                                                leadType: "Hot Lead",
                                                source: "Phone Call",
                                                salesType: "Direct Sale",
                                                dealType: "New Purchase",
                                                inventoryType: "SUV",
                                                leadStatus: "Closed Won",
                                                vehicleInfo: {
                                                    year: "2023",
                                                    make: "Toyota",
                                                    model: "RAV4",
                                                    stockNumber: "STK-78901",
                                                    vin: "1HGBH41JXMN109186"
                                                },
                                                salesStatus: "Delivered"
                                            },
                                            {
                                                id: 3,
                                                dmsNumber: "DMS-1003",
                                                customerName: "Sarah Williams",
                                                physicalAddress: "789 Pine Rd, Chicago, IL 60601",
                                                mobileNumber: "+1 (555) 345-6789",
                                                homeNumber: "+1 (555) 765-4321",
                                                workNumber: "+1 (555) 456-7890",
                                                email: "sarah.w@example.com",
                                                leadType: "Cold Lead",
                                                source: "Walk-in",
                                                salesType: "Finance",
                                                dealType: "New Purchase",
                                                inventoryType: "Truck",
                                                leadStatus: "Closed Won",
                                                vehicleInfo: {
                                                    year: "2024",
                                                    make: "Ford",
                                                    model: "F-150",
                                                    stockNumber: "STK-12345",
                                                    vin: "1FTFW1RG5LFC56789"
                                                },
                                                salesStatus: "Pending Delivery"
                                            },
                                            {
                                                id: 4,
                                                dmsNumber: "", // No DMS ID
                                                customerName: "Michael Brown",
                                                physicalAddress: "321 Elm St, Houston, TX 77001",
                                                mobileNumber: "+1 (555) 456-7890",
                                                homeNumber: "+1 (555) 654-3210",
                                                workNumber: "+1 (555) 567-8901",
                                                email: "michael.b@example.com",
                                                leadType: "Hot Lead",
                                                source: "Phone Call",
                                                salesType: "Direct Sale",
                                                dealType: "First-time Buyer",
                                                inventoryType: "Coupe",
                                                leadStatus: "Closed Won",
                                                vehicleInfo: {
                                                    year: "2023",
                                                    make: "BMW",
                                                    model: "M4",
                                                    stockNumber: "STK-98765",
                                                    vin: "WBS3R9C50J7K12345"
                                                },
                                                salesStatus: "Delivered"
                                            }
                                        ];

                                        // State management
                                        let selectedDeals = [];
                                        let mergeModal = null;

                                        // Initialize when DOM is ready
                                        document.addEventListener('DOMContentLoaded', function () {
                                            initializeTable();
                                            setupEventListeners();

                                            // Initialize Bootstrap Modal (guarded)
                                            const modalElement = document.getElementById('mergeComparisonModal');
                                            if (modalElement && window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                                                mergeModal = new bootstrap.Modal(modalElement);
                                                // Reset modal when hidden
                                                modalElement.addEventListener('hidden.bs.modal', function () {
                                                    resetModal();
                                                });
                                            }
                                        });

                                        // Populate table with deals data
                                        function initializeTable() {
                                            const tableBody = document.getElementById('dealsTableBody');
                                            tableBody.innerHTML = '';

                                            dealsData.forEach(deal => {
                                                const row = document.createElement('tr');
                                                row.id = `deal-row-${deal.id}`;

                                                // Format DMS ID display
                                                const hasDmsId = deal.dmsNumber && deal.dmsNumber.trim() !== '';
                                                const dmsCellClass = hasDmsId ? ' fw-bold' : 'text-danger fw-bold';
                                                const dmsDisplay = hasDmsId ? deal.dmsNumber : 'No DMS ID';

                                                // Format customer info as a single reference box (without DMS ID)
                                                const customerInfo = `
            <div class="customer-info-box">
                <div class="fw-bold">${deal.customerName}</div>
                <div class="small text-muted">${deal.physicalAddress}</div>
                <div class="small">Mobile: ${deal.mobileNumber}</div>
                <div class="small">Home: ${deal.homeNumber || 'N/A'}</div>
                <div class="small">Work: ${deal.workNumber || 'N/A'}</div>
                <div class="small">Email: ${deal.email}</div>
            </div>
        `;

                                                // Format vehicle info in two lines
                                                const vehicleInfo = `
            <div class="vehicle-info-box">
                <div class="fw-bold">${deal.vehicleInfo.year} ${deal.vehicleInfo.make} ${deal.vehicleInfo.model}</div>
                <div class="small text-muted">Stock: ${deal.vehicleInfo.stockNumber} | VIN: ${deal.vehicleInfo.vin}</div>
            </div>
        `;

                                                row.innerHTML = `
            <td>
                <input type="checkbox" class="form-check-input deal-checkbox" data-deal-id="${deal.id}" data-dms-id="${deal.dmsNumber}">
            </td>
             <td class="${dmsCellClass}"><strong>${dmsDisplay}</strong></td>
            <td>${customerInfo}</td>
           
            <td>${vehicleInfo}</td>
            <td>${deal.leadType}</td>
            <td>${deal.leadStatus}</td>
            <td>${deal.salesStatus}</td>
        `;
                                                tableBody.appendChild(row);
                                            });
                                        }

                                        // Set up event listeners
                                        function setupEventListeners() {
                                            // Select all checkbox
                                            document.getElementById('selectAllCheckbox').addEventListener('change', function (e) {
                                                const checkboxes = document.querySelectorAll('.deal-checkbox');
                                                checkboxes.forEach(checkbox => {
                                                    checkbox.checked = e.target.checked;
                                                    toggleDealSelection(checkbox);
                                                });
                                                updateMergeButtonState();
                                            });

                                            // Individual deal checkboxes
                                            document.addEventListener('change', function (e) {
                                                if (e.target.classList.contains('deal-checkbox')) {
                                                    toggleDealSelection(e.target);
                                                    updateMergeButtonState();
                                                }
                                            });

                                            // Merge button click
                                            document.getElementById('mergeDealsBtn').addEventListener('click', showMergeComparison);

                                            // Confirm merge button
                                            document.getElementById('confirmMergeBtn').addEventListener('click', performMerge);
                                        }

                                        // Toggle deal selection
                                        function toggleDealSelection(checkbox) {
                                            const dealId = parseInt(checkbox.getAttribute('data-deal-id'));
                                            const row = document.getElementById(`deal-row-${dealId}`);

                                            if (checkbox.checked) {
                                                if (selectedDeals.length >= 2 && !selectedDeals.includes(dealId)) {
                                                    checkbox.checked = false;
                                                    alert('You can only select two deals to merge.');
                                                    return;
                                                }

                                                if (!selectedDeals.includes(dealId)) {
                                                    selectedDeals.push(dealId);
                                                }
                                            } else {
                                                const index = selectedDeals.indexOf(dealId);
                                                if (index > -1) {
                                                    selectedDeals.splice(index, 1);
                                                }
                                            }

                                            // Update select all checkbox
                                            updateSelectAllCheckbox();
                                        }

                                        // Update select all checkbox state
                                        function updateSelectAllCheckbox() {
                                            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                                            const allCheckboxes = document.querySelectorAll('.deal-checkbox');
                                            const checkedCheckboxes = document.querySelectorAll('.deal-checkbox:checked');

                                            selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
                                            selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
                                        }

                                        // Update merge button state
                                        function updateMergeButtonState() {
                                            const mergeBtn = document.getElementById('mergeDealsBtn');
                                            const isEnabled = selectedDeals.length === 2;
                                            mergeBtn.disabled = !isEnabled;

                                            if (isEnabled) {
                                                mergeBtn.innerHTML = `<i class="fas fa-merge me-1"></i> Merge Selected Deals (${selectedDeals.length})`;
                                                mergeBtn.classList.add('btn-primary');
                                                mergeBtn.classList.remove('btn-light');
                                            } else {
                                                mergeBtn.innerHTML = `<i class="fas fa-merge me-1"></i> Merge Deals`;
                                                mergeBtn.classList.remove('btn-primary');
                                                mergeBtn.classList.add('btn-light');
                                            }
                                        }

                                        // Show merge comparison modal
                                        function showMergeComparison() {
                                            if (selectedDeals.length !== 2) return;

                                            const deal1 = dealsData.find(d => d.id === selectedDeals[0]);
                                            const deal2 = dealsData.find(d => d.id === selectedDeals[1]);

                                            if (!deal1 || !deal2) return;

                                            // Update modal titles
                                            const deal1Dms = deal1.dmsNumber ? deal1.dmsNumber : 'No DMS ID';
                                            const deal2Dms = deal2.dmsNumber ? deal2.dmsNumber : 'No DMS ID';

                                            document.getElementById('deal1Title').textContent = `${deal1Dms} - ${deal1.customerName}`;
                                            document.getElementById('deal2Title').textContent = `${deal2Dms} - ${deal2.customerName}`;

                                            // Populate customer sections with DMS ID underneath
                                            document.getElementById('deal1CustomerSection').innerHTML = `
        <div class="customer-info-display mb-2">
            <div class="fw-bold">${deal1.customerName}</div>
            <div class="small text-muted">${deal1.physicalAddress}</div>
            <div class="small">Mobile: ${deal1.mobileNumber}</div>
            <div class="small">Home: ${deal1.homeNumber || 'N/A'}</div>
            <div class="small">Work: ${deal1.workNumber || 'N/A'}</div>
            <div class="small">Email: ${deal1.email}</div>
        </div>
        <div class="dms-id-display mt-2 pt-2 border-top">
            <div class="small fw-bold">DMS ID #:</div>
            <div class=" fw-bold">${deal1Dms}</div>
        </div>
    `;

                                            document.getElementById('deal2CustomerSection').innerHTML = `
        <div class="customer-info-display mb-2">
            <div class="fw-bold">${deal2.customerName}</div>
            <div class="small text-muted">${deal2.physicalAddress}</div>
            <div class="small">Mobile: ${deal2.mobileNumber}</div>
            <div class="small">Home: ${deal2.homeNumber || 'N/A'}</div>
            <div class="small">Work: ${deal2.workNumber || 'N/A'}</div>
            <div class="small">Email: ${deal2.email}</div>
        </div>
        <div class="dms-id-display mt-2 pt-2 border-top">
            <div class="small fw-bold">DMS ID #:</div>
            <div class=" fw-bold">${deal2Dms}</div>
        </div>
    `;

                                            // Populate vehicle info
                                            document.getElementById('deal1VehicleInfo').innerHTML = `
        <div class="fw-bold">${deal1.vehicleInfo.year} ${deal1.vehicleInfo.make} ${deal1.vehicleInfo.model}</div>
        <div class="small text-muted">Stock: ${deal1.vehicleInfo.stockNumber} | VIN: ${deal1.vehicleInfo.vin}</div>
    `;

                                            document.getElementById('deal2VehicleInfo').innerHTML = `
        <div class="fw-bold">${deal2.vehicleInfo.year} ${deal2.vehicleInfo.make} ${deal2.vehicleInfo.model}</div>
        <div class="small text-muted">Stock: ${deal2.vehicleInfo.stockNumber} | VIN: ${deal2.vehicleInfo.vin}</div>
    `;

                                            // Build comparison fields
                                            const fieldsComparison = document.getElementById('fieldsComparison');
                                            fieldsComparison.innerHTML = '';

                                            // Define fields to compare
                                            const fields = [
                                                { key: 'customerInfo', label: 'Customer Information', note: 'All customer info fields will be merged together from selected deal', mergeable: false },
                                                { key: 'dmsNumber', label: 'DMS ID #', mergeable: false, special: 'dms' },
                                                { key: 'vehicleInfo', label: 'Vehicle Information', mergeable: true },
                                                { key: 'leadType', label: 'Lead Type', mergeable: true },
                                                { key: 'source', label: 'Source', mergeable: true },
                                                { key: 'salesType', label: 'Sales Type', mergeable: true },
                                                { key: 'dealType', label: 'Deal Type', mergeable: true },
                                                { key: 'inventoryType', label: 'Inventory Type', mergeable: true },
                                                { key: 'leadStatus', label: 'Lead Status', mergeable: true },
                                                { key: 'salesStatus', label: 'Sales Status', mergeable: true }
                                            ];

                                            fields.forEach(field => {
                                                const row = document.createElement('div');
                                                row.className = 'row align-items-center mb-3 pb-2 border-bottom';

                                                // Format display values
                                                let deal1Value = 'N/A';
                                                let deal2Value = 'N/A';

                                                if (field.key === 'dmsNumber') {
                                                    deal1Value = deal1.dmsNumber ? `<span class=" fw-bold">${deal1.dmsNumber}</span>` : '<span class="text-danger fw-bold">No DMS ID</span>';
                                                    deal2Value = deal2.dmsNumber ? `<span class=" fw-bold">${deal2.dmsNumber}</span>` : '<span class="text-danger fw-bold">No DMS ID</span>';
                                                } else if (field.key === 'customerInfo') {
                                                    deal1Value = `${deal1.customerName}<br><small class="text-muted">${deal1.physicalAddress}</small><br><small class="text-muted">Mobile: ${deal1.mobileNumber}</small><br><small class="text-muted">Home: ${deal1.homeNumber}</small><br><small class="text-muted">Work: ${deal1.workNumber}</small><br><small class="text-muted">Email: ${deal1.email}</small>`;
                                                    deal2Value = `${deal2.customerName}<br><small class="text-muted">${deal2.physicalAddress}</small><br><small class="text-muted">Mobile: ${deal2.mobileNumber}</small><br><small class="text-muted">Home: ${deal2.homeNumber}</small><br><small class="text-muted">Work: ${deal2.workNumber}</small><br><small class="text-muted">Email: ${deal2.email}</small>`;
                                                } else if (field.key === 'vehicleInfo') {
                                                    deal1Value = `${deal1.vehicleInfo.year} ${deal1.vehicleInfo.make} ${deal1.vehicleInfo.model}<br><small class="text-muted">Stock: ${deal1.vehicleInfo.stockNumber}</small>`;
                                                    deal2Value = `${deal2.vehicleInfo.year} ${deal2.vehicleInfo.make} ${deal2.vehicleInfo.model}<br><small class="text-muted">Stock: ${deal2.vehicleInfo.stockNumber}</small>`;
                                                } else {
                                                    deal1Value = deal1[field.key] || 'N/A';
                                                    deal2Value = deal2[field.key] || 'N/A';
                                                }

                                                // Customer information - no radio buttons (only display)
                                                if (field.key === 'customerInfo') {
                                                    row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="p-2 border rounded bg-light">
                        ${deal1Value}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-2 border rounded bg-light">
                        ${deal2Value}
                    </div>
                </div>
            `;
                                                }
                                                // DMS ID field - special handling with radio buttons
                                                else if (field.key === 'dmsNumber') {
                                                    // Determine which deal has DMS ID
                                                    const deal1HasDms = deal1.dmsNumber && deal1.dmsNumber.trim() !== '';
                                                    const deal2HasDms = deal2.dmsNumber && deal2.dmsNumber.trim() !== '';

                                                    // Set default selection
                                                    let defaultDeal1 = false;
                                                    let defaultDeal2 = false;

                                                    if (deal1HasDms && !deal2HasDms) {
                                                        defaultDeal1 = true;
                                                    } else if (!deal1HasDms && deal2HasDms) {
                                                        defaultDeal2 = true;
                                                    } else {
                                                        // If both have DMS IDs or both don't have DMS IDs, default to Deal 1
                                                        defaultDeal1 = true;
                                                    }

                                                    row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal1" 
                               value="deal1" 
                               ${defaultDeal1 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal1">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal1').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal1Value}
                                ${deal1HasDms && !deal2HasDms ? '<div class="mt-1"><small class=" fw-bold">✓ Has DMS ID</small></div>' : ''}
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal2" 
                               value="deal2"
                               ${defaultDeal2 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal2">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal2').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal2Value}
                                ${!deal1HasDms && deal2HasDms ? '<div class="mt-1"><small class=" fw-bold">✓ Has DMS ID</small></div>' : ''}
                            </div>
                        </label>
                    </div>
                </div>
            `;
                                                }
                                                // Mergeable fields - with radio buttons (same style as DMS ID and Vehicle Info)
                                                else {
                                                    // Determine default selection based on DMS ID logic
                                                    const dmsRadio = document.querySelector('input[name="dmsNumber"]:checked');
                                                    const dmsSelected = dmsRadio ? dmsRadio.value : 'deal1';

                                                    let defaultCheckedDeal1 = false;
                                                    let defaultCheckedDeal2 = false;

                                                    if (field.key === 'vehicleInfo') {
                                                        // For vehicle info, default to the same deal as DMS ID
                                                        defaultCheckedDeal1 = dmsSelected === 'deal1';
                                                        defaultCheckedDeal2 = dmsSelected === 'deal2';
                                                    } else {
                                                        // For other fields, follow the DMS ID selection
                                                        defaultCheckedDeal1 = dmsSelected === 'deal1';
                                                        defaultCheckedDeal2 = dmsSelected === 'deal2';
                                                    }

                                                    row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal1" 
                               value="deal1" 
                               ${defaultCheckedDeal1 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal1">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal1').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal1Value}
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal2" 
                               value="deal2"
                               ${defaultCheckedDeal2 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal2">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal2').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal2Value}
                            </div>
                        </label>
                    </div>
                </div>
            `;
                                                }

                                                fieldsComparison.appendChild(row);
                                            });

                                            // Show modal
                                            mergeModal.show();
                                        }

                                        // Highlight selection when field is clicked
                                        window.highlightSelection = function (element, fieldName) {
                                            // Remove highlight from all options in this field group
                                            const row = element.closest('.row');
                                            row.querySelectorAll('.border-primary').forEach(el => {
                                                el.classList.remove('bg-primary', 'bg-opacity-10', 'border-primary');
                                                el.classList.add('bg-light', 'border');
                                            });

                                            // Add highlight to selected option
                                            element.classList.add('bg-primary', 'bg-opacity-10', 'border-primary');
                                            element.classList.remove('bg-light', 'border');
                                        };

                                        // Perform the merge operation
                                        function performMerge() {
                                            // Show loading state
                                            document.getElementById('comparisonContent').style.display = 'none';
                                            document.getElementById('loadingState').style.display = 'block';
                                            document.getElementById('confirmMergeBtn').disabled = true;

                                            // Simulate API call delay (2 seconds)
                                            setTimeout(() => {
                                                // Hide loading state
                                                document.getElementById('loadingState').style.display = 'none';

                                                // Show success state
                                                document.getElementById('successState').style.display = 'block';
                                                document.getElementById('confirmMergeBtn').style.display = 'none';

                                                // Collect selected values for logging/demo
                                                const selectedValues = {};
                                                const mergeableFields = ['dmsNumber', 'vehicleInfo', 'leadType', 'source', 'salesType',
                                                    'dealType', 'inventoryType', 'leadStatus', 'salesStatus'];

                                                mergeableFields.forEach(field => {
                                                    const selectedRadio = document.querySelector(`input[name="${field}"]:checked`);
                                                    if (selectedRadio) {
                                                        selectedValues[field] = selectedRadio.value;
                                                    }
                                                });

                                                // Customer info is always from the same deal as DMS ID
                                                const dmsSelected = selectedValues['dmsNumber'] || 'deal1';
                                                selectedValues['customerInfo'] = dmsSelected;

                                                console.log('Merge completed with selected values:', selectedValues);

                                                // Determine which deal is being kept (the one with DMS ID)
                                                const deal1 = dealsData.find(d => d.id === selectedDeals[0]);
                                                const deal2 = dealsData.find(d => d.id === selectedDeals[1]);
                                                const keptDealId = dmsSelected === 'deal1' ? deal1.id : deal2.id;
                                                const mergedDealId = dmsSelected === 'deal1' ? deal2.id : deal1.id;

                                                console.log(`Deal ${keptDealId} kept (selected for DMS ID), Deal ${mergedDealId} merged into it`);

                                                // Reset table selection after successful merge
                                                setTimeout(() => {
                                                    // Clear checkboxes
                                                    document.querySelectorAll('.deal-checkbox:checked').forEach(cb => {
                                                        cb.checked = false;
                                                        const dealId = parseInt(cb.getAttribute('data-deal-id'));
                                                        const row = document.getElementById(`deal-row-${dealId}`);
                                                    });

                                                    // Reset selectedDeals array
                                                    selectedDeals = [];

                                                    // Update button state
                                                    updateMergeButtonState();

                                                    // Reset select all checkbox
                                                    document.getElementById('selectAllCheckbox').checked = false;
                                                    document.getElementById('selectAllCheckbox').indeterminate = false;

                                                    // Close modal after 2 seconds
                                                    setTimeout(() => {
                                                        mergeModal.hide();
                                                    }, 2000);
                                                }, 1000);
                                            }, 2000);
                                        }

                                        // Reset modal to initial state
                                        function resetModal() {
                                            // Reset all states
                                            document.getElementById('comparisonContent').style.display = 'block';
                                            document.getElementById('loadingState').style.display = 'none';
                                            document.getElementById('successState').style.display = 'none';
                                            document.getElementById('confirmMergeBtn').disabled = false;
                                            document.getElementById('confirmMergeBtn').style.display = 'block';

                                            // Clear customer info displays
                                            document.getElementById('deal1CustomerSection').innerHTML = '';
                                            document.getElementById('deal2CustomerSection').innerHTML = '';
                                            document.getElementById('deal1VehicleInfo').innerHTML = '';
                                            document.getElementById('deal2VehicleInfo').innerHTML = '';

                                            // Clear modal titles
                                            document.getElementById('deal1Title').textContent = 'Deal 1';
                                            document.getElementById('deal2Title').textContent = 'Deal 2';
                                        }
                                    </script>

                                    <style>
                                        /* Minimal custom styles for better UX */
                                        .deal-checkbox:checked {
                                            background-color: var(--cf-primary);
                                            border-color: var(--cf-primary);
                                        }

                                        #mergeDealsBtn:disabled {
                                            opacity: 0.5;
                                            cursor: not-allowed;
                                        }

                                        .form-check-input:checked {
                                            background-color: var(--cf-primary);
                                            border-color: var(--cf-primary);
                                        }

                                        .border-primary {
                                            border-color: var(--cf-primary) !important;
                                        }

                                        .form-check-label div {
                                            cursor: pointer;
                                            transition: all 0.2s;
                                        }

                                        .form-check-label div:hover {
                                            background-color: #e9ecef !important;
                                        }

                                        /* Customer info box styling */
                                        .customer-info-box {
                                            background-color: #f8f9fa;
                                            border-radius: 4px;
                                            padding: 8px;
                                            border: 1px solid #dee2e6;
                                            font-size: 0.875rem;
                                        }

                                        .customer-info-box .fw-bold {
                                            font-size: 0.9rem;
                                            margin-bottom: 2px;
                                        }

                                        /* Vehicle info box styling */
                                        .vehicle-info-box {
                                            font-size: 0.875rem;
                                        }

                                        /* Modal styling */
                                        .modal-body .card {
                                            background-color: #f8f9fa;
                                        }

                                        .modal-body .card-header {
                                            background-color: #e9ecef !important;
                                            border-bottom: 1px solid #dee2e6;
                                        }

                                        /* Customer info display in modal */
                                        .customer-info-display {
                                            font-size: 0.875rem;
                                        }

                                        .dms-id-display {
                                            font-size: 0.875rem;
                                        }
                                    </style>
                                    <!-- IP Restrictions Tab -->
                                    <div class="tab-pane fade" id="ip-restrictions" role="tabpanel"
                                        aria-labelledby="ip-restrictions-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">IP Access Restrictions</h2>
                                            <p class="primus-crm-content-description">Configure IP-based access
                                                control settings.</p>
                                        </div>
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-network-wired"></i></span>
                                                IP Filtering Settings
                                            </h3>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">IP Restriction Mode</label>
                                                <select class="primus-crm-form-control">
                                                    <option selected>Disabled</option>
                                                    <option>Whitelist Only (Allow Listed IPs)</option>
                                                    <option>Blacklist (Block Listed IPs)</option>
                                                </select>
                                                <span class="primus-crm-form-help">Control how IP restrictions are
                                                    applied</span>
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">Allowed IP Addresses (one per
                                                    line)</label>
                                                <textarea class="primus-crm-form-control" rows="6"
                                                    placeholder="192.168.1.100&#10;10.0.0.0/24&#10;172.16.0.1">192.168.1.100&#10;192.168.1.101&#10;10.0.0.0/24</textarea>
                                                <span class="primus-crm-form-help">Supports individual IPs and CIDR
                                                    notation</span>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Enable IP restriction
                                                        bypass for admins</div>
                                                    <div class="primus-crm-setting-desc">Allow administrators to
                                                        access from any IP</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Log blocked access attempts
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Record all attempts from
                                                        restricted IPs</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Notifications Tab -->
                                    <div class="tab-pane fade" id="notifications" role="tabpanel"
                                        aria-labelledby="notifications-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Notification Preferences</h2>
                                            <p class="primus-crm-content-description">Configure system notification
                                                settings and delivery channels for real-time alerts and reminders.
                                            </p>
                                        </div>

                                        <!-- Customer Notifications -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-user"></i></span>
                                                Customer Notifications
                                            </h3>

                                            <!-- Lead Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">New Internet Lead Received
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Alert when a new internet
                                                        lead is received in the system</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Lead Assigned to You</div>
                                                    <div class="primus-crm-setting-desc">Notify when a lead is
                                                        assigned to you</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Lead Reassigned to You
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Alert when a lead is
                                                        reassigned to you from another user</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Communication Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">New Chat Deal</div>
                                                    <div class="primus-crm-setting-desc">Notify when a new chat deal
                                                        is initiated</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Incoming Call (Assigned
                                                        Lead)</div>
                                                    <div class="primus-crm-setting-desc">Alert for incoming calls
                                                        from assigned leads</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item" data-channel="email"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Incoming Text</div>
                                                    <div class="primus-crm-setting-desc">Notify when a new text
                                                        message is received</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Incoming Email</div>
                                                    <div class="primus-crm-setting-desc">Alert when a new email is
                                                        received</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Email Engagement Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Customer Viewed Your Email
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify when a customer
                                                        views your sent email</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Customer Replied to Your
                                                        Email</div>
                                                    <div class="primus-crm-setting-desc">Alert when a customer
                                                        replies to your email</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Customer Clicked Link in
                                                        Email</div>
                                                    <div class="primus-crm-setting-desc">Notify when a customer
                                                        clicks a link in your email</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Delivery Failure Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Text Message Delivery
                                                        Failure</div>
                                                    <div class="primus-crm-setting-desc">Alert when a text message
                                                        fails to deliver</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Email Delivery
                                                        Failure/Bounce</div>
                                                    <div class="primus-crm-setting-desc">Notify when an email fails
                                                        to deliver or bounces</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Appointment Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">New Appointment Assigned
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify when a new
                                                        appointment is assigned to you</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Starting Now
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Alert when an appointment
                                                        is starting immediately</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item" data-channel="email"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Task Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">New Task Assigned</div>
                                                    <div class="primus-crm-setting-desc">Notify when a new task is
                                                        assigned to you</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Sales Status Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Lead Moved to New Sales
                                                        Status</div>
                                                    <div class="primus-crm-setting-desc">Alert when lead status
                                                        changes (Uncontacted, Attempted, Contacted, Demo, Write-Up,
                                                        etc.)</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Lead Moved to Pending F&I
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify when a lead is moved
                                                        to Pending F&I status</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Deal Status Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Deal Moved to Sold</div>
                                                    <div class="primus-crm-setting-desc">Alert when a deal is marked
                                                        as Sold</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Deal Moved to Delivered
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify when a deal is
                                                        marked as Delivered</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Deal Moved to Lost</div>
                                                    <div class="primus-crm-setting-desc">Alert when a deal is marked
                                                        as Lost</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Service Appointment Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Service Appointment Booked
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify when a service
                                                        appointment is booked</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Service Appointment Closed
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Alert when a service
                                                        appointment is closed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- AI & System Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Wishlist</div>
                                                    <div class="primus-crm-setting-desc">Notify about wishlist
                                                        activities</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">AI Recommendation Available
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Alert when AI
                                                        recommendations are ready for review</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Duplicate Deal</div>
                                                    <div class="primus-crm-setting-desc">Notify when a potential
                                                        duplicate deal is detected</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>
                                        </div>

                                        <!-- Manager Notifications -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-user-tie"></i></span>
                                                Manager Notifications
                                            </h3>

                                            <!-- Appointment Status Notifications for Managers -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Cancelled</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when
                                                        appointments are cancelled</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Rescheduled
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify managers when
                                                        appointments are rescheduled</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Missed</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when
                                                        appointments are missed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment No Show</div>
                                                    <div class="primus-crm-setting-desc">Notify managers when
                                                        customers don't show for appointments</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Completed</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when
                                                        appointments are completed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Updated</div>
                                                    <div class="primus-crm-setting-desc">Notify managers when
                                                        appointments are updated (time/date/vehicle/etc.)</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">New Appointment Assigned
                                                        (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Notify managers when new
                                                        appointments are assigned</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Starting Now
                                                        (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when
                                                        appointments are starting immediately</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item" data-channel="email"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Sales Status Deal Moved
                                                        Backwards in the Funnel</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when deals
                                                        regress in the sales funnel</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Service Appointment Booked
                                                        (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Notify managers when
                                                        service appointments are booked</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Service Appointment Closed
                                                        (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when service
                                                        appointments are closed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Inventory Notifications -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Vehicle Added to Inventory
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify managers when new
                                                        vehicles are added to inventory</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Vehicle Price Change</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when vehicle
                                                        prices are changed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Wishlist for Managers -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Wishlist (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Notify managers about
                                                        wishlist activities</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Automation Failed -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Automation Failed (Error)
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify managers when
                                                        automation processes fail</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- AI Recommendation for Managers -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">AI Recommendation Available
                                                        (Manager)</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when AI
                                                        recommendations are ready for review</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Duplicate Deal for Managers -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Duplicate Deal (Manager)
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Notify managers when a
                                                        potential duplicate deal is detected</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <!-- Campaign Completed -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Campaign Completed</div>
                                                    <div class="primus-crm-setting-desc">Alert managers when
                                                        marketing campaigns are completed</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>
                                        </div>

                                        <!-- Reminder Settings -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-clock"></i></span>
                                                Reminder Settings
                                            </h3>

                                            <!-- Sales Appointment Reminder -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Reminder
                                                        (Sales)</div>
                                                    <div class="primus-crm-setting-desc">Get reminders before sales
                                                        appointments</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Sales Appointment Reminder
                                                    Time</label>
                                                <select class="primus-crm-form-control">
                                                    <option value="15">15 Minutes before appointment</option>
                                                    <option value="30" selected>30 Minutes before appointment
                                                    </option>
                                                    <option value="45">45 Minutes before appointment</option>
                                                    <option value="60">60 Minutes before appointment</option>
                                                    <option value="120">120 Minutes before appointment</option>
                                                </select>
                                            </div>

                                            <!-- Service Appointment Reminder -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Appointment Reminder
                                                        (Service)</div>
                                                    <div class="primus-crm-setting-desc">Get reminders before
                                                        service appointments</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="text" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Service Appointment Reminder
                                                    Time</label>
                                                <select class="primus-crm-form-control">
                                                    <option value="15">15 Minutes before appointment</option>
                                                    <option value="30" selected>30 Minutes before appointment
                                                    </option>
                                                    <option value="45">45 Minutes before appointment</option>
                                                    <option value="60">60 Minutes before appointment</option>
                                                    <option value="120">120 Minutes before appointment</option>
                                                </select>
                                            </div>

                                            <!-- Task Overdue Reminder -->
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Task Overdue Reminder</div>
                                                    <div class="primus-crm-setting-desc">Get reminders for overdue
                                                        tasks (excludes appointment tasks)</div>
                                                    <div class="primus-crm-delivery-channels">
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="email" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-envelope"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Email</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="app" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">App</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item" data-channel="text"
                                                            onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-sms"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Text</div>
                                                        </div>
                                                        <div class="primus-crm-channel-item active"
                                                            data-channel="desktop" onclick="toggleChannel(this)">
                                                            <div class="primus-crm-channel-icon">
                                                                <i class="fas fa-desktop"></i>
                                                            </div>
                                                            <div class="primus-crm-channel-label">Desktop</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="toggleNotification(this)"></div>
                                            </div>

                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Task Overdue Reminder
                                                    Time</label>
                                                <select class="primus-crm-form-control">
                                                    <option value="15">15 Minutes after overdue</option>
                                                    <option value="30" selected>30 Minutes after overdue</option>
                                                    <option value="45">45 Minutes after overdue</option>
                                                    <option value="60">60 Minutes after overdue</option>
                                                    <option value="120">120 Minutes after overdue</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Save Button -->
                                        <div class="primus-crm-settings-actions">
                                            <button class="primus-crm-btn primus-crm-btn-primary"
                                                onclick="savePreferences()">Save Notification Preferences</button>
                                            <button class="primus-crm-btn primus-crm-btn-secondary"
                                                onclick="resetToDefaults()">Reset to Defaults</button>
                                        </div>
                                    </div>

                                    <style>
                                        .primus-crm-delivery-channels {
                                            display: flex;
                                            flex-wrap: wrap;
                                            gap: 10px;
                                            margin-top: 12px;
                                            padding-top: 12px;
                                            border-top: 1px solid #e8eaed;
                                        }

                                        .primus-crm-channel-item {
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            justify-content: center;
                                            width: 60px;
                                            height: 60px;
                                            padding: 8px;
                                            border-radius: 10px;
                                            border: 2px solid #d1d9e6;
                                            background: #ffffff;
                                            cursor: pointer;
                                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                            position: relative;
                                            overflow: hidden;
                                        }

                                        .primus-crm-channel-item:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                                            border-color: #666;
                                        }

                                        .primus-crm-channel-item.active {
                                            background: rgb(0, 33, 64);
                                            border-color: #1a1a1a;
                                        }

                                        .primus-crm-channel-item.active:hover {
                                            border-color: rgb(0, 33, 64);
                                            box-shadow: 0 4px 12px rgba(26, 26, 26, 0.15);
                                        }

                                        .primus-crm-channel-icon {
                                            width: 20px;
                                            height: 20px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 8px;
                                            background: #f8f9fa;
                                            margin-bottom: 6px;
                                            transition: all 0.3s ease;
                                        }

                                        .primus-crm-channel-item.active .primus-crm-channel-icon {
                                            background: #2c2c2c;
                                        }

                                        .primus-crm-channel-icon i {
                                            font-size: 13px;
                                            color: #666;
                                            transition: all 0.3s ease;
                                        }

                                        .primus-crm-channel-item.active .primus-crm-channel-icon i {
                                            color: #ffffff;
                                        }

                                        .primus-crm-channel-label {
                                            font-size: 11px;
                                            font-weight: 600;
                                            color: #444;
                                            text-align: center;
                                            transition: all 0.3s ease;
                                        }

                                        .primus-crm-channel-item.active .primus-crm-channel-label {
                                            color: #ffffff;
                                        }

                                        /* Consistent color for all channels */
                                        .primus-crm-channel-item .primus-crm-channel-icon {
                                            background: #f0f2f5;
                                        }

                                        .primus-crm-channel-item .primus-crm-channel-icon i {
                                            color: #666;
                                        }

                                        .primus-crm-channel-item.active .primus-crm-channel-icon {
                                            background: #2c2c2c;
                                        }

                                        .primus-crm-channel-item.active .primus-crm-channel-icon i {
                                            color: #ffffff;
                                        }

                                        /* Checkmark indicator */
                                        .primus-crm-channel-item::after {
                                            content: '';
                                            position: absolute;
                                            top: 6px;
                                            right: 6px;
                                            width: 14px;
                                            height: 14px;
                                            border-radius: 50%;
                                            background: #ffffff;
                                            border: 2px solid #d1d9e6;
                                            transition: all 0.3s ease;
                                        }

                                        .primus-crm-channel-item.active::after {
                                            background: #4CAF50;
                                            border-color: #4CAF50;
                                            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");
                                            background-size: 9px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                        }

                                        /* Disabled state when notification is off */
                                        .primus-crm-setting-row:not(.notification-enabled) .primus-crm-channel-item {
                                            opacity: 0.5;
                                            pointer-events: none;
                                        }

                                        /* Animation for toggle */
                                        @keyframes channelToggle {
                                            0% {
                                                transform: scale(0.95);
                                            }

                                            50% {
                                                transform: scale(1.05);
                                            }

                                            100% {
                                                transform: scale(1);
                                            }
                                        }

                                        .primus-crm-channel-item.active {
                                            animation: channelToggle 0.3s ease;
                                        }

                                        /* Enhanced toggle switch */
                                        .primus-crm-toggle-switch {
                                            width: 50px;
                                            height: 26px;
                                            background: #ccc;
                                            border-radius: 13px;
                                            position: relative;
                                            cursor: pointer;
                                            transition: background 0.3s ease;
                                        }

                                        .primus-crm-toggle-switch.active {
                                            background: #4CAF50;
                                        }

                                        .primus-crm-toggle-switch::after {
                                            content: '';
                                            position: absolute;
                                            top: 3px;
                                            left: 3px;
                                            width: 20px;
                                            height: 20px;
                                            background: white;
                                            border-radius: 50%;
                                            transition: transform 0.3s ease;
                                        }

                                        .primus-crm-toggle-switch.active::after {
                                            transform: translateX(24px);
                                        }
                                    </style>

                                    <script>
                                        // JavaScript for interactive functionality
                                        function toggleChannel(element) {
                                            element.classList.toggle('active');

                                            // Add animation effect
                                            element.style.animation = 'none';
                                            setTimeout(() => {
                                                element.style.animation = 'channelToggle 0.3s ease';
                                            }, 10);
                                        }

                                        function toggleNotification(element) {
                                            const row = element.closest('.primus-crm-setting-row');
                                            element.classList.toggle('active');
                                            row.classList.toggle('notification-enabled');
                                        }

                                        function savePreferences() {
                                            // Collect all notification preferences
                                            const preferences = [];
                                            const notificationRows = document.querySelectorAll('.primus-crm-setting-row');

                                            notificationRows.forEach(row => {
                                                const notificationName = row.querySelector('.primus-crm-setting-name').textContent;
                                                const isEnabled = row.querySelector('.primus-crm-toggle-switch').classList.contains('active');
                                                const channels = Array.from(row.querySelectorAll('.primus-crm-channel-item')).map(channel => ({
                                                    type: channel.getAttribute('data-channel'),
                                                    enabled: channel.classList.contains('active')
                                                }));

                                                preferences.push({
                                                    name: notificationName,
                                                    enabled: isEnabled,
                                                    channels: channels
                                                });
                                            });

                                            // Collect reminder settings
                                            const salesReminderTime = document.querySelector('.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(2)').value;
                                            const serviceReminderTime = document.querySelector('.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(5)').value;
                                            const taskReminderTime = document.querySelector('.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(8)').value;

                                            const reminderSettings = {
                                                salesAppointmentReminder: salesReminderTime,
                                                serviceAppointmentReminder: serviceReminderTime,
                                                taskOverdueReminder: taskReminderTime
                                            };

                                            const allSettings = {
                                                notifications: preferences,
                                                reminders: reminderSettings
                                            };

                                            // In a real application, you would send this data to your server
                                            console.log('Saving preferences:', allSettings);
                                            alert('Notification preferences saved successfully!');
                                        }

                                        function resetToDefaults() {
                                            if (confirm('Are you sure you want to reset all notification preferences to defaults?')) {
                                                // Reset all toggles
                                                document.querySelectorAll('.primus-crm-toggle-switch').forEach(toggle => {
                                                    toggle.classList.add('active');
                                                    toggle.closest('.primus-crm-setting-row').classList.add('notification-enabled');
                                                });

                                                // Reset all channels to default states
                                                document.querySelectorAll('.primus-crm-channel-item').forEach(channel => {
                                                    const channelType = channel.getAttribute('data-channel');
                                                    // Default settings based on your original logic
                                                    const shouldBeActive = (channelType === 'email' || channelType === 'app' || channelType === 'desktop');
                                                    channel.classList.toggle('active', shouldBeActive);
                                                });

                                                // Reset reminder dropdowns to default values
                                                document.querySelectorAll('.primus-crm-form-control').forEach((select, index) => {
                                                    if (index === 1 || index === 4 || index === 7) { // Reminder dropdowns
                                                        select.value = '30';
                                                    }
                                                });

                                                alert('Preferences reset to defaults!');
                                            }
                                        }

                                        // Initialize on page load
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Add notification-enabled class to all active rows initially
                                            document.querySelectorAll('.primus-crm-toggle-switch.active').forEach(toggle => {
                                                toggle.closest('.primus-crm-setting-row').classList.add('notification-enabled');
                                            });
                                        });
                                    </script>

                                    <!-- Store Hours Tab -->
                                    <div class="tab-pane fade" id="store-hours" role="tabpanel"
                                        aria-labelledby="store-hours-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Store Operating Hours</h2>
                                            <p class="primus-crm-content-description">Set your dealership's
                                                operating hours for each day of the week.</p>
                                        </div>

                                        <!-- Quick Apply Section -->
                                        <div class="primus-crm-quick-apply-section">
                                            <div class="primus-crm-quick-apply-header">

                                                <span>Quick Apply Hours</span>
                                            </div>
                                            <div class="primus-crm-quick-apply-controls">
                                                <select class="primus-crm-time-dropdown" id="quickStartTime">
                                                    <option value="">Start Time</option>
                                                    <option value="00:00">12:00 AM</option>
                                                    <option value="00:30">12:30 AM</option>
                                                    <option value="01:00">1:00 AM</option>
                                                    <option value="01:30">1:30 AM</option>
                                                    <option value="02:00">2:00 AM</option>
                                                    <option value="02:30">2:30 AM</option>
                                                    <option value="03:00">3:00 AM</option>
                                                    <option value="03:30">3:30 AM</option>
                                                    <option value="04:00">4:00 AM</option>
                                                    <option value="04:30">4:30 AM</option>
                                                    <option value="05:00">5:00 AM</option>
                                                    <option value="05:30">5:30 AM</option>
                                                    <option value="06:00">6:00 AM</option>
                                                    <option value="06:30">6:30 AM</option>
                                                    <option value="07:00">7:00 AM</option>
                                                    <option value="07:30">7:30 AM</option>
                                                    <option value="08:00">8:00 AM</option>
                                                    <option value="08:30">8:30 AM</option>
                                                    <option value="09:00" selected>9:00 AM</option>
                                                    <option value="09:30">9:30 AM</option>
                                                    <option value="10:00">10:00 AM</option>
                                                    <option value="10:30">10:30 AM</option>
                                                    <option value="11:00">11:00 AM</option>
                                                    <option value="11:30">11:30 AM</option>
                                                    <option value="12:00">12:00 PM</option>
                                                    <option value="12:30">12:30 PM</option>
                                                    <option value="13:00">1:00 PM</option>
                                                    <option value="13:30">1:30 PM</option>
                                                    <option value="14:00">2:00 PM</option>
                                                    <option value="14:30">2:30 PM</option>
                                                    <option value="15:00">3:00 PM</option>
                                                    <option value="15:30">3:30 PM</option>
                                                    <option value="16:00">4:00 PM</option>
                                                    <option value="16:30">4:30 PM</option>
                                                    <option value="17:00">5:00 PM</option>
                                                    <option value="17:30">5:30 PM</option>
                                                    <option value="18:00">6:00 PM</option>
                                                    <option value="18:30">6:30 PM</option>
                                                    <option value="19:00">7:00 PM</option>
                                                    <option value="19:30">7:30 PM</option>
                                                    <option value="20:00">8:00 PM</option>
                                                    <option value="20:30">8:30 PM</option>
                                                    <option value="21:00">9:00 PM</option>
                                                    <option value="21:30">9:30 PM</option>
                                                    <option value="22:00">10:00 PM</option>
                                                    <option value="22:30">10:30 PM</option>
                                                    <option value="23:00">11:00 PM</option>
                                                    <option value="23:30">11:30 PM</option>
                                                </select>
                                                <span
                                                    style="color: var(--text-secondary); margin: 0 10px;">to</span>
                                                <select class="primus-crm-time-dropdown" id="quickEndTime">
                                                    <option value="">End Time</option>
                                                    <option value="00:00">12:00 AM</option>
                                                    <option value="00:30">12:30 AM</option>
                                                    <option value="01:00">1:00 AM</option>
                                                    <option value="01:30">1:30 AM</option>
                                                    <option value="02:00">2:00 AM</option>
                                                    <option value="02:30">2:30 AM</option>
                                                    <option value="03:00">3:00 AM</option>
                                                    <option value="03:30">3:30 AM</option>
                                                    <option value="04:00">4:00 AM</option>
                                                    <option value="04:30">4:30 AM</option>
                                                    <option value="05:00">5:00 AM</option>
                                                    <option value="05:30">5:30 AM</option>
                                                    <option value="06:00">6:00 AM</option>
                                                    <option value="06:30">6:30 AM</option>
                                                    <option value="07:00">7:00 AM</option>
                                                    <option value="07:30">7:30 AM</option>
                                                    <option value="08:00">8:00 AM</option>
                                                    <option value="08:30">8:30 AM</option>
                                                    <option value="09:00">9:00 AM</option>
                                                    <option value="09:30">9:30 AM</option>
                                                    <option value="10:00">10:00 AM</option>
                                                    <option value="10:30">10:30 AM</option>
                                                    <option value="11:00">11:00 AM</option>
                                                    <option value="11:30">11:30 AM</option>
                                                    <option value="12:00">12:00 PM</option>
                                                    <option value="12:30">12:30 PM</option>
                                                    <option value="13:00">1:00 PM</option>
                                                    <option value="13:30">1:30 PM</option>
                                                    <option value="14:00">2:00 PM</option>
                                                    <option value="14:30">2:30 PM</option>
                                                    <option value="15:00">3:00 PM</option>
                                                    <option value="15:30">3:30 PM</option>
                                                    <option value="16:00">4:00 PM</option>
                                                    <option value="16:30">4:30 PM</option>
                                                    <option value="17:00">5:00 PM</option>
                                                    <option value="17:30">5:30 PM</option>
                                                    <option value="18:00" selected>6:00 PM</option>
                                                    <option value="18:30">6:30 PM</option>
                                                    <option value="19:00">7:00 PM</option>
                                                    <option value="19:30">7:30 PM</option>
                                                    <option value="20:00">8:00 PM</option>
                                                    <option value="20:30">8:30 PM</option>
                                                    <option value="21:00">9:00 PM</option>
                                                    <option value="21:30">9:30 PM</option>
                                                    <option value="22:00">10:00 PM</option>
                                                    <option value="22:30">10:30 PM</option>
                                                    <option value="23:00">11:00 PM</option>
                                                    <option value="23:30">11:30 PM</option>
                                                </select>
                                                <button type="button" class="primus-crm-btn-apply-all"
                                                    onclick="applyToAllDays()">
                                                    <i class="fas fa-check-double"></i> Apply to All Days
                                                </button>
                                                <button type="button" class="primus-crm-btn-apply-weekdays"
                                                    onclick="applyToWeekdays()">
                                                    <i class="fas fa-briefcase"></i> Apply to Weekdays
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Days of Week -->
                                        <div class="primus-crm-hours-row" data-day="monday">
                                            <div class="primus-crm-day-name">Monday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="09:00" selected>9:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="18:00" selected>6:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="tuesday">
                                            <div class="primus-crm-day-name">Tuesday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="09:00" selected>9:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="18:00" selected>6:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="wednesday">
                                            <div class="primus-crm-day-name">Wednesday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="09:00" selected>9:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="18:00" selected>6:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="thursday">
                                            <div class="primus-crm-day-name">Thursday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="09:00" selected>9:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="18:00" selected>6:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="friday">
                                            <div class="primus-crm-day-name">Friday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="09:00" selected>9:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="18:00" selected>6:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="saturday">
                                            <div class="primus-crm-day-name">Saturday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" checked onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <select class="primus-crm-time-dropdown day-start-time">
                                                <option value="10:00" selected>10:00 AM</option>
                                            </select>
                                            <span style="color: var(--text-secondary);">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time">
                                                <option value="16:00" selected>4:00 PM</option>
                                            </select>
                                        </div>

                                        <div class="primus-crm-hours-row" data-day="sunday">
                                            <div class="primus-crm-day-name">Sunday</div>
                                            <label class="primus-crm-custom-checkbox">
                                                <input type="checkbox" onchange="toggleDayHours(this)">
                                                <span>Open</span>
                                            </label>
                                            <span class="primus-crm-closed-label">Closed</span>
                                            <select class="primus-crm-time-dropdown day-start-time"
                                                style="display: none;">
                                            </select>
                                            <span style="color: var(--text-secondary); display: none;">to</span>
                                            <select class="primus-crm-time-dropdown day-end-time"
                                                style="display: none;">
                                            </select>
                                        </div>

                                        <!-- Additional Settings -->
                                        <div class="primus-crm-settings-section" style="margin-top: 2rem;">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-clock"></i></span>
                                                Additional Settings
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Show hours on website</div>
                                                    <div class="primus-crm-setting-desc">Display operating hours on
                                                        your public website</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Holiday hours override
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Allow temporary hours
                                                        changes for holidays</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active" id="holidayToggle"
                                                    onclick="toggleHolidaySection(this)"></div>
                                            </div>

                                            <!-- Holiday Override Section -->
                                            <div id="holidayOverrideSection" class="primus-crm-holiday-section">
                                                <div class="primus-crm-holiday-add-button"
                                                    onclick="openHolidayModal()">
                                                    <i class="fas fa-plus-circle"></i> Add Holiday Override
                                                </div>

                                                <!-- Holiday List -->
                                                <div id="holidayList" class="primus-crm-holiday-list">
                                                    <!-- Dynamic holiday items will appear here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <script>
                                        // Generate time options for all dropdowns
                                        const timeOptions = [
                                            '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30',
                                            '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30',
                                            '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                                            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
                                            '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
                                            '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'
                                        ];

                                        function formatTime(time) {
                                            if (!time) return '';
                                            const parts = String(time).split(':');
                                            const hours = parseInt(parts[0], 10) || 0;
                                            const minutes = parts[1] ? parts[1].slice(0,2) : '00';
                                            const ampm = hours >= 12 ? 'PM' : 'AM';
                                            const displayHour = hours === 0 ? 12 : hours > 12 ? hours - 12 : hours;
                                            return `${displayHour}:${minutes} ${ampm}`;
                                        }

                                        // Populate all time dropdowns
                                        function populateTimeDropdowns() {
                                            document.querySelectorAll('.primus-crm-time-dropdown').forEach(select => {
                                                if (select.options.length <= 1) { // Only populate if empty
                                                    timeOptions.forEach(time => {
                                                        const option = document.createElement('option');
                                                        option.value = time;
                                                        option.textContent = formatTime(time);
                                                        select.appendChild(option);
                                                    });
                                                }
                                            });
                                        }

                                        // Toggle day hours visibility
                                        function toggleDayHours(checkbox) {
                                            const row = checkbox.closest('.primus-crm-hours-row');
                                            const selects = row.querySelectorAll('.primus-crm-time-dropdown');
                                            const toText = row.querySelectorAll('span')[1];
                                            const closedLabel = row.querySelector('.primus-crm-closed-label');

                                            if (checkbox.checked) {
                                                selects.forEach(s => s.style.display = 'block');
                                                if (toText) toText.style.display = 'inline';
                                                if (closedLabel) closedLabel.style.display = 'none';
                                            } else {
                                                selects.forEach(s => s.style.display = 'none');
                                                if (toText) toText.style.display = 'none';
                                                if (closedLabel) closedLabel.style.display = 'inline';
                                            }
                                        }

                                        // Apply to all days
                                        function applyToAllDays() {
                                            const startTime = document.getElementById('quickStartTime').value;
                                            const endTime = document.getElementById('quickEndTime').value;

                                            if (!startTime || !endTime) {
                                                alert('Please select both start and end times');
                                                return;
                                            }

                                            document.querySelectorAll('.primus-crm-hours-row').forEach(row => {
                                                const checkbox = row.querySelector('input[type="checkbox"]');
                                                const startSelect = row.querySelector('.day-start-time');
                                                const endSelect = row.querySelector('.day-end-time');

                                                if (checkbox && startSelect && endSelect) {
                                                    checkbox.checked = true;
                                                    startSelect.value = startTime;
                                                    endSelect.value = endTime;
                                                    toggleDayHours(checkbox);
                                                }
                                            });
                                        }

                                        // Apply to weekdays only
                                        function applyToWeekdays() {
                                            const startTime = document.getElementById('quickStartTime').value;
                                            const endTime = document.getElementById('quickEndTime').value;

                                            if (!startTime || !endTime) {
                                                alert('Please select both start and end times');
                                                return;
                                            }

                                            const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

                                            document.querySelectorAll('.primus-crm-hours-row').forEach(row => {
                                                const day = row.getAttribute('data-day');

                                                if (weekdays.includes(day)) {
                                                    const checkbox = row.querySelector('input[type="checkbox"]');
                                                    const startSelect = row.querySelector('.day-start-time');
                                                    const endSelect = row.querySelector('.day-end-time');

                                                    if (checkbox && startSelect && endSelect) {
                                                        checkbox.checked = true;
                                                        startSelect.value = startTime;
                                                        endSelect.value = endTime;
                                                        toggleDayHours(checkbox);
                                                    }
                                                }
                                            });
                                        }

                                        // Holiday Management
                                        let holidays = [];
                                        let editingHolidayIndex = null;

                                        function toggleHolidaySection(toggle) {
                                            toggle.classList.toggle('active');
                                            const section = document.getElementById('holidayOverrideSection');

                                            if (toggle.classList.contains('active')) {
                                                section.style.display = 'block';
                                            } else {
                                                section.style.display = 'none';
                                            }
                                        }

                                        function openHolidayModal() {
                                            editingHolidayIndex = null;
                                            document.getElementById('holidayName').value = '';
                                            document.getElementById('holidayDate').value = '';
                                            document.getElementById('holidayClosed').checked = false;
                                            document.getElementById('holidayStartTime').value = '';
                                            document.getElementById('holidayEndTime').value = '';
                                            document.getElementById('holidayHoursSection').style.display = 'block';
                                            document.getElementById('holidayModal').style.display = 'flex';
                                        }

                                        function closeHolidayModal() {
                                            document.getElementById('holidayModal').style.display = 'none';
                                        }

                                        function toggleHolidayHours(checkbox) {
                                            const hoursSection = document.getElementById('holidayHoursSection');
                                            hoursSection.style.display = checkbox.checked ? 'none' : 'block';
                                        }

                                        function saveHoliday() {
                                            const name = document.getElementById('holidayName').value.trim();
                                            const date = document.getElementById('holidayDate').value;
                                            const isClosed = document.getElementById('holidayClosed').checked;
                                            const startTime = document.getElementById('holidayStartTime').value;
                                            const endTime = document.getElementById('holidayEndTime').value;

                                            if (!name || !date) {
                                                alert('Please enter holiday name and date');
                                                return;
                                            }

                                            if (!isClosed && (!startTime || !endTime)) {
                                                alert('Please select custom hours or mark as closed');
                                                return;
                                            }

                                            const holiday = {
                                                name,
                                                date,
                                                isClosed,
                                                startTime: isClosed ? null : startTime,
                                                endTime: isClosed ? null : endTime
                                            };

                                            if (editingHolidayIndex !== null) {
                                                holidays[editingHolidayIndex] = holiday;
                                            } else {
                                                holidays.push(holiday);
                                            }

                                            renderHolidayList();
                                            closeHolidayModal();
                                        }

                                        function renderHolidayList() {
                                            const list = document.getElementById('holidayList');

                                            if (holidays.length === 0) {
                                                list.innerHTML = '<p style="color: #94a3b8; text-align: center; padding: 20px;">No holiday overrides added yet</p>';
                                                return;
                                            }

                                            list.innerHTML = holidays.map((holiday, index) => {
                                                const formattedDate = new Date(holiday.date).toLocaleDateString('en-US', {
                                                    weekday: 'long',
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric'
                                                });

                                                const hoursText = holiday.isClosed
                                                    ? 'Closed'
                                                    : `${formatTime(holiday.startTime)} - ${formatTime(holiday.endTime)}`;

                                                return `
        <div class="primus-crm-holiday-item">
            <div class="primus-crm-holiday-info">
                <h4>${holiday.name}</h4>
                <p>${formattedDate} • ${hoursText}</p>
            </div>
            <div class="primus-crm-holiday-actions">
                <div class="primus-crm-holiday-edit" onclick="editHoliday(${index})" title="Edit">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="primus-crm-holiday-delete" onclick="deleteHoliday(${index})" title="Delete">
                    <i class="fas fa-trash"></i>
                </div>
            </div>
        </div>
    `;
                                            }).join('');
                                        }

                                        function editHoliday(index) {
                                            editingHolidayIndex = index;
                                            const holiday = holidays[index];

                                            document.getElementById('holidayName').value = holiday.name;
                                            document.getElementById('holidayDate').value = holiday.date;
                                            document.getElementById('holidayClosed').checked = holiday.isClosed;
                                            document.getElementById('holidayStartTime').value = holiday.startTime || '';
                                            document.getElementById('holidayEndTime').value = holiday.endTime || '';

                                            toggleHolidayHours(document.getElementById('holidayClosed'));
                                            document.getElementById('holidayModal').style.display = 'flex';
                                        }

                                        function deleteHoliday(index) {
                                            if (confirm('Are you sure you want to delete this holiday override?')) {
                                                holidays.splice(index, 1);
                                                renderHolidayList();
                                            }
                                        }

                                        // Close modal on outside click
                                        window.onclick = function (event) {
                                            const modal = document.getElementById('holidayModal');
                                            if (event.target === modal) {
                                                closeHolidayModal();
                                            }
                                        }

                                        // Initialize on page load
                                        document.addEventListener('DOMContentLoaded', function () {
                                            populateTimeDropdowns();

                                            // Show holiday section by default if toggle is active
                                            const holidayToggle = document.getElementById('holidayToggle');
                                            if (holidayToggle && holidayToggle.classList.contains('active')) {
                                                document.getElementById('holidayOverrideSection').style.display = 'block';
                                            }
                                        });
                                    </script>

                                    <!-- Security Tab -->
                                    <div class="tab-pane fade" id="security" role="tabpanel"
                                        aria-labelledby="security-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Security Settings</h2>
                                            <p class="primus-crm-content-description">Configure security policies
                                                and authentication requirements.</p>
                                        </div>
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-lock"></i></span>
                                                Password Policy
                                            </h3>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Minimum Password Length</label>
                                                <div class="primus-crm-slider-container">
                                                    <input type="range" class="primus-crm-slider" min="6" max="20"
                                                        value="8"
                                                        oninput="this.nextElementSibling.textContent = this.value + ' characters'">
                                                    <span class="primus-crm-slider-value">8 characters</span>
                                                </div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Require uppercase letters
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Password must contain at
                                                        least one uppercase letter</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Require numbers</div>
                                                    <div class="primus-crm-setting-desc">Password must contain at
                                                        least one number</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Require special characters
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Password must contain
                                                        special characters (!@#$%)</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Password Expiry (days)</label>
                                                <input type="number" class="primus-crm-form-control" value="90"
                                                    min="0" max="365">
                                                <span class="primus-crm-form-help">Set to 0 to disable password
                                                    expiration</span>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Password History</label>
                                                <input type="number" class="primus-crm-form-control" value="5"
                                                    min="0" max="24">
                                                <span class="primus-crm-form-help">Prevent reuse of last "X"
                                                    passwords</span>
                                            </div>
                                        </div>
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-shield-alt"></i></span>
                                                Two-Factor Authentication
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Require 2FA for all users
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Mandatory two-factor
                                                        authentication for all accounts</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Preferred 2FA Method</label>
                                                <select class="primus-crm-form-control">
                                                    <option>Authenticator App (Recommended)</option>
                                                    <option selected>SMS Code</option>
                                                    <option>Email Code</option>
                                                </select>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Remember device for 30 days
                                                    </div>
                                                    <div class="primus-crm-setting-desc">Skip 2FA on trusted devices
                                                    </div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                        </div>
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-user-clock"></i></span>
                                                Session Management
                                            </h3>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Session Timeout
                                                    (minutes)</label>
                                                <input type="number" class="primus-crm-form-control" value="30"
                                                    min="5" max="480">
                                                <span class="primus-crm-form-help">Automatically log out inactive
                                                    users</span>
                                            </div>


                                        </div>
                                    </div>

                                    <!-- Permissions Tab -->
                                    <div class="tab-pane fade" id="permissions" role="tabpanel"
                                        aria-labelledby="permissions-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Role-Based Permissions</h2>
                                            <p class="primus-crm-content-description">Configure default permissions
                                                for user roles.</p>
                                        </div>
                                        <div class="primus-crm-form-group border-2 border rounded-3 p-3 mb-4">
                                            <label class="primus-crm-form-label">Configure Permissions For</label>
                                            <select class="primus-crm-form-control mb-3">
                                                <option value="">-- Select Team --</option>
                                                <option value="sales-rep" selected>Sales Rep</option>
                                                <option value="bdc-agent">BDC Agent</option>
                                                <option value="fi">F&I</option>
                                                <option value="sales-manager">Sales Manager</option>
                                                <option value="bdc-manager">BDC Manager</option>
                                                <option value="finance-director">Finance Director</option>
                                                <option value="general-sales-manager">General Sales Manager</option>
                                                <option value="general-manager">General Manager</option>
                                                <option value="dealer-principal">Dealer Principal</option>
                                                <option value="admin">Admin</option>
                                                <option value="reception">Reception</option>
                                                <option value="service-advisor">Service Advisor</option>
                                                <option value="service-manager">Service Manager</option>
                                                <option value="inventory-manager">Inventory Manager</option>
                                                <option value="fixed-operations-manager">Fixed Operations Manager
                                                </option>
                                            </select>




                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-users"></i></span>
                                                    Customer Management
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View all customers
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Access to view customer
                                                            records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Allow users to view
                                                            other team members</div>
                                                        <div class="primus-crm-setting-desc">Team members can see
                                                            profiles of colleagues in their team</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Create new customers
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Permission to add new
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Edit customer
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">Modify existing
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Delete customers</div>
                                                        <div class="primus-crm-setting-desc">Remove customer records
                                                            from system</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                            </div>
                                            <!-- ================= Showroom Visits Section ================= -->
                                            <div class="primus-crm-settings-section">
                                                <!-- Section Title -->
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-users"></i></span>
                                                    Showroom Visits
                                                </h3>

                                                <!-- Sub-Section: Ability To Close Showroom Visit -->
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <!-- Sub-section Name -->
                                                        <div class="primus-crm-setting-name">Ability To Close
                                                            Showroom Visit</div>
                                                        <!-- Sub-section Description -->
                                                        <div class="primus-crm-setting-desc">

                                                            Controls visibility and access to showroom visit
                                                            records.
                                                        </div>
                                                    </div>
                                                    <!-- Toggle Switch -->
                                                    <div class="primus-crm-toggle-switch"
                                                        id="ability-close-showroom"></div>
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // ===== Roles with default permission OFF =====
                                                    const rolesWithOffDefault = ["Sales Rep", "BDC Agent", "F&I", "Reception"];

                                                    // ===== Current User Role =====
                                                    // Replace this with your actual dynamic user role from backend or JS
                                                    const currentUserRole = window.currentUserRole || "Sales Manager";

                                                    // ===== Toggle Element =====
                                                    const toggle = document.getElementById("ability-close-showroom");

                                                    // ===== Set Default State Based on Role =====
                                                    // OFF for roles in rolesWithOffDefault, ON for others
                                                    if (rolesWithOffDefault.includes(currentUserRole)) {
                                                        toggle.classList.remove('active'); // OFF
                                                    } else {
                                                        toggle.classList.add('active'); // ON
                                                    }

                                                    // ===== Toggle Functionality on Click =====
                                                    toggle.addEventListener('click', function () {
                                                        this.classList.toggle('active');
                                                    });
                                                });
                                            </script>
                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-warehouse"></i></span>
                                                    Inventory Management
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View inventory</div>
                                                        <div class="primus-crm-setting-desc">Access to browse
                                                            inventory listings</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Modify inventory</div>
                                                        <div class="primus-crm-setting-desc">Edit vehicle details
                                                            and pricing</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Access pricing
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">View cost and profit
                                                            margins</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                            </div>
                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-chart-bar"></i></span>
                                                    Reports & Analytics
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View reports</div>
                                                        <div class="primus-crm-setting-desc">Access to standard
                                                            reports and dashboards</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Export reports</div>
                                                        <div class="primus-crm-setting-desc">Download reports as
                                                            PDF/Excel</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View financial data
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Access to revenue and
                                                            financial reports</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Lost Reasons Management Section -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-ban"></i></span>
                                                Sub-Lost Lead Reasons Management
                                            </h3>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Manage Lost Reasons</div>
                                                    <div class="primus-crm-setting-desc">Add, edit, or remove
                                                        reasons for lost sales opportunities</div>
                                                </div>
                                                <button class="primus-crm-btn primus-crm-btn-primary"
                                                    id="addLostReasonBtn">
                                                    <i class="fas fa-plus"></i> Add New Reason
                                                </button>
                                            </div>

                                            <div class="primus-crm-lost-reasons-list">
                                                <!-- Lost reasons will be dynamically populated here -->
                                            </div>
                                        </div>

                                        <!-- Add/Edit Lost Reason Modal -->
                                        <div class="modal" id="lostReasonModal" tabindex="-1"
                                            aria-labelledby="lostReasonModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="lostReasonModalLabel">Add Lost
                                                            Reason</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="primus-crm-form-group">
                                                            <label class="primus-crm-form-label">Lost Reason</label>
                                                            <input type="text" class="primus-crm-form-control"
                                                                id="lostReasonInput"
                                                                placeholder="Enter lost reason">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-primary"
                                                            id="saveLostReasonBtn">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal" id="deleteLostReasonModal" tabindex="-1"
                                            aria-labelledby="deleteLostReasonModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteLostReasonModalLabel">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete "<span
                                                                id="lostReasonToDelete"></span>"?</p>
                                                        <p class="text-danger">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-danger"
                                                            id="confirmDeleteBtn">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                // Create custom modal instances without backdrop
                                                const lostReasonModal = new bootstrap.Modal(document.getElementById('lostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                const deleteLostReasonModal = new bootstrap.Modal(document.getElementById('deleteLostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                // Modal elements
                                                const addLostReasonBtn = document.getElementById('addLostReasonBtn');
                                                const saveLostReasonBtn = document.getElementById('saveLostReasonBtn');
                                                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                                                const lostReasonInput = document.getElementById('lostReasonInput');
                                                const lostReasonModalLabel = document.getElementById('lostReasonModalLabel');
                                                const lostReasonToDelete = document.getElementById('lostReasonToDelete');

                                                // State variables
                                                let currentEditId = null;
                                                let currentDeleteId = null;

                                                // Initialize lost reasons
                                                initializeLostReasons();

                                                // Event listeners
                                                addLostReasonBtn.addEventListener('click', openAddModal);
                                                saveLostReasonBtn.addEventListener('click', saveLostReason);
                                                confirmDeleteBtn.addEventListener('click', confirmDelete);

                                                // Reset modal when hidden
                                                document.getElementById('lostReasonModal').addEventListener('hidden.bs.modal', function () {
                                                    currentEditId = null;
                                                    lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                    lostReasonInput.value = '';
                                                });

                                                // Close modals when clicking outside (since no backdrop)
                                                document.addEventListener('click', function (event) {
                                                    const lostReasonModalEl = document.getElementById('lostReasonModal');
                                                    const deleteLostReasonModalEl = document.getElementById('deleteLostReasonModal');

                                                    if (lostReasonModalEl.classList.contains('show') &&
                                                        !lostReasonModalEl.contains(event.target) &&
                                                        event.target !== addLostReasonBtn &&
                                                        !event.target.closest('.edit-lost-reason')) {
                                                        lostReasonModal.hide();
                                                    }

                                                    if (deleteLostReasonModalEl.classList.contains('show') &&
                                                        !deleteLostReasonModalEl.contains(event.target) &&
                                                        !event.target.closest('.delete-lost-reason')) {
                                                        deleteLostReasonModal.hide();
                                                    }
                                                });

                                                // Initialize lost reasons from localStorage or default values
                                                function initializeLostReasons() {
                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (!lostReasons) {
                                                        // Set default lost reasons
                                                        lostReasons = [
                                                            "Bad Credit",
                                                            "Bad Email",
                                                            "Bad Phone Number",
                                                            "Did Not Respond",
                                                            "Diff Dealer, Diff Brand",
                                                            "Diff Dealer, Same Brand",
                                                            "Diff Dealer, Same Group",
                                                            "Import Lead",
                                                            "No Agreement Reached",
                                                            "No Credit",
                                                            "No Longer Owns",
                                                            "Other Salesperson Lead",
                                                            "Out of Market",
                                                            "Requested No More Contact",
                                                            "Service Lead",
                                                            "Sold Privately"
                                                        ];
                                                        localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                    }

                                                    renderLostReasons(lostReasons);
                                                }

                                                // Render lost reasons list
                                                function renderLostReasons(reasons) {
                                                    const container = document.querySelector('.primus-crm-lost-reasons-list');
                                                    container.innerHTML = '';

                                                    if (reasons.length === 0) {
                                                        container.innerHTML = '<p class="primus-crm-no-data">No lost reasons configured</p>';
                                                        return;
                                                    }

                                                    reasons.forEach((reason, index) => {
                                                        const reasonElement = document.createElement('div');
                                                        reasonElement.className = 'primus-crm-lost-reason-item';
                                                        reasonElement.innerHTML = `
            <div class="primus-crm-lost-reason-text">${reason}</div>
            <div class="primus-crm-lost-reason-actions">
                <button class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline edit-lost-reason" data-id="${index}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline-danger delete-lost-reason" data-id="${index}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;
                                                        container.appendChild(reasonElement);
                                                    });

                                                    // Add event listeners to edit and delete buttons
                                                    document.querySelectorAll('.edit-lost-reason').forEach(button => {
                                                        button.addEventListener('click', function () {
                                                            const id = parseInt(this.getAttribute('data-id'));
                                                            openEditModal(id);
                                                        });
                                                    });

                                                    document.querySelectorAll('.delete-lost-reason').forEach(button => {
                                                        button.addEventListener('click', function () {
                                                            const id = parseInt(this.getAttribute('data-id'));
                                                            openDeleteModal(id);
                                                        });
                                                    });
                                                }

                                                // Open modal for adding a new reason
                                                function openAddModal() {
                                                    currentEditId = null;
                                                    lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                    lostReasonInput.value = '';
                                                    lostReasonModal.show();
                                                    setTimeout(() => lostReasonInput.focus(), 100);
                                                }

                                                // Open modal for editing an existing reason
                                                function openEditModal(id) {
                                                    const lostReasons = JSON.parse(localStorage.getItem('lostReasons'));
                                                    currentEditId = id;
                                                    lostReasonModalLabel.textContent = 'Edit Lost Reason';
                                                    lostReasonInput.value = lostReasons[id];
                                                    lostReasonModal.show();
                                                    setTimeout(() => lostReasonInput.focus(), 100);
                                                }

                                                // Open modal for deleting a reason
                                                function openDeleteModal(id) {
                                                    const lostReasons = JSON.parse(localStorage.getItem('lostReasons'));
                                                    currentDeleteId = id;
                                                    lostReasonToDelete.textContent = lostReasons[id];
                                                    deleteLostReasonModal.show();
                                                }

                                                // Save a new or edited lost reason
                                                function saveLostReason() {
                                                    const reason = lostReasonInput.value.trim();

                                                    if (!reason) {
                                                        alert('Please enter a lost reason');
                                                        return;
                                                    }

                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (currentEditId === null) {
                                                        // Add new reason
                                                        lostReasons.push(reason);
                                                    } else {
                                                        // Edit existing reason
                                                        lostReasons[currentEditId] = reason;
                                                    }

                                                    localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                    renderLostReasons(lostReasons);
                                                    lostReasonModal.hide();
                                                }

                                                // Confirm deletion of a lost reason
                                                function confirmDelete() {
                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (currentDeleteId !== null) {
                                                        lostReasons.splice(currentDeleteId, 1);
                                                        localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                        renderLostReasons(lostReasons);
                                                    }

                                                    deleteLostReasonModal.hide();
                                                    currentDeleteId = null;
                                                }
                                            });
                                        </script>

                                        <style>
                                            .primus-crm-lost-reasons-list {
                                                margin-top: 20px;
                                                border: 1px solid #e0e0e0;
                                                border-radius: 8px;
                                                overflow: hidden;
                                            }

                                            .primus-crm-lost-reason-item {
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: center;
                                                padding: 12px 16px;
                                                border-bottom: 1px solid #f0f0f0;
                                                transition: background-color 0.2s;
                                            }

                                            .primus-crm-lost-reason-item:hover {
                                                background-color: #f9f9f9;
                                            }

                                            .primus-crm-lost-reason-item:last-child {
                                                border-bottom: none;
                                            }

                                            .primus-crm-lost-reason-text {
                                                flex: 1;
                                                font-weight: 500;
                                            }

                                            .primus-crm-lost-reason-actions {
                                                display: flex;
                                                gap: 8px;
                                            }

                                            .primus-crm-no-data {
                                                text-align: center;
                                                padding: 20px;
                                                color: #6c757d;
                                                font-style: italic;
                                            }

                                            /* Button Styles */
                                            .primus-crm-btn {
                                                display: inline-flex;
                                                align-items: center;
                                                justify-content: center;
                                                gap: 6px;
                                                padding: 8px 16px;
                                                border: none;
                                                border-radius: 4px;
                                                font-size: 0.875rem;
                                                font-weight: 500;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                                text-decoration: none;
                                            }

                                            .primus-crm-btn-primary {
                                                background-color: #007bff;
                                                color: white;
                                            }

                                            .primus-crm-btn-primary:hover {
                                                background-color: #0069d9;
                                            }

                                            .primus-crm-btn-secondary {
                                                background-color: #6c757d;
                                                color: white;
                                            }

                                            .primus-crm-btn-secondary:hover {
                                                background-color: #5a6268;
                                            }

                                            .primus-crm-btn-danger {
                                                background-color: #dc3545;
                                                color: white;
                                            }

                                            .primus-crm-btn-danger:hover {
                                                background-color: #c82333;
                                            }

                                            .primus-crm-btn-outline {
                                                background-color: transparent;
                                                border: 1px solid #007bff;
                                                color: #007bff;
                                            }

                                            .primus-crm-btn-outline:hover {
                                                background-color: #007bff;
                                                color: white;
                                            }

                                            .primus-crm-btn-outline-danger {
                                                background-color: transparent;
                                                border: 1px solid #dc3545;
                                                color: #dc3545;
                                            }

                                            .primus-crm-btn-outline-danger:hover {
                                                background-color: #dc3545;
                                                color: white;
                                            }

                                            .primus-crm-btn-sm {
                                                padding: 6px 12px;
                                                font-size: 0.8rem;
                                            }

                                            .text-danger {
                                                color: #dc3545;
                                            }
                                        </style>


                                        <!-- Speed to Sale Settings Section -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-bolt"></i></span>
                                                Speed to Sale
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Speed to Lead Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from lead
                                                        received to first response</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="speedToLead" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Follow-up Time Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from first
                                                        response to appointment booked</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="followUpTime" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Conversion Time Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from
                                                        appointment booked to sold</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="conversionTime" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Save Changes Button -->

                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            // Load saved targets
                                            function loadSavedTargets() {
                                                const savedTargets = JSON.parse(localStorage.getItem('speedSaleTargets') || '{}');

                                                document.querySelectorAll('.speed-target-input').forEach(input => {
                                                    const targetType = input.getAttribute('data-target');
                                                    if (savedTargets[targetType]) {
                                                        input.value = savedTargets[targetType];
                                                    }
                                                });

                                                // Update frontend display if modal is open
                                                updateFrontendTargets(savedTargets);
                                            }

                                            // Update frontend targets display
                                            function updateFrontendTargets(targets) {
                                                const order = ["speedToLead", "followUpTime", "conversionTime"];

                                                order.forEach((k, idx) => {
                                                    const badge = document.querySelector(`[data-from="${k}"]`);
                                                    if (!badge) return;

                                                    if (targets[k] && targets[k] !== '') {
                                                        badge.textContent = `Target: ${targets[k]} min`;
                                                    } else {
                                                        badge.textContent = "N/A";
                                                    }
                                                });
                                            }

                                            // Save targets
                                            document.getElementById('saveSpeedTargets').addEventListener('click', function () {
                                                const targets = {};

                                                document.querySelectorAll('.speed-target-input').forEach(input => {
                                                    const targetType = input.getAttribute('data-target');
                                                    const value = input.value.trim();

                                                    if (value === '') {
                                                        targets[targetType] = '';
                                                    } else {
                                                        targets[targetType] = parseInt(value) || 0;
                                                    }
                                                });

                                                // Save to localStorage (in real app, this would be API call)
                                                localStorage.setItem('speedSaleTargets', JSON.stringify(targets));

                                                // Update frontend display
                                                updateFrontendTargets(targets);

                                                // Show success message
                                                alert('Speed to Sale targets saved successfully!');
                                            });

                                            // Initialize
                                            loadSavedTargets();
                                        });

                                        // Update the existing Speed to Sale calculation function
                                        document.addEventListener("DOMContentLoaded", function () {
                                            const order = ["speedToLead", "followUpTime", "conversionTime"];

                                            function calcAndRender() {
                                                // Load saved targets
                                                const savedTargets = JSON.parse(localStorage.getItem('speedSaleTargets') || '{}');

                                                // Compute performance vs target and progress bars
                                                order.forEach((k, idx) => {
                                                    const badge = document.querySelector(`[data-from="${k}"]`);
                                                    const bar = document.querySelector(`[data-bar="${k}"]`);
                                                    if (!badge || !bar) return;

                                                    const currentTarget = savedTargets[k];

                                                    if (currentTarget && currentTarget !== '') {
                                                        badge.textContent = `Target: ${currentTarget} min`;

                                                        // Calculate progress percentage (example logic)
                                                        let progressPercentage = 0;
                                                        if (idx === 0) {
                                                            progressPercentage = Math.min(100, (75 / currentTarget) * 100);
                                                        } else if (idx === 1) {
                                                            progressPercentage = Math.min(100, (320 / currentTarget) * 100);
                                                        } else if (idx === 2) {
                                                            progressPercentage = Math.min(100, (1240 / currentTarget) * 100);
                                                        }

                                                        bar.style.width = `${progressPercentage}%`;
                                                        bar.setAttribute('aria-valuenow', progressPercentage);
                                                    } else {
                                                        badge.textContent = "N/A";
                                                        // Set default progress if no target
                                                        if (idx === 0) {
                                                            bar.style.width = "85%";
                                                            bar.setAttribute('aria-valuenow', 85);
                                                        } else if (idx === 1) {
                                                            bar.style.width = "93%";
                                                            bar.setAttribute('aria-valuenow', 93);
                                                        } else if (idx === 2) {
                                                            bar.style.width = "97%";
                                                            bar.setAttribute('aria-valuenow', 97);
                                                        }
                                                    }
                                                });
                                            }

                                            // Initialize from saved values
                                            calcAndRender();
                                        });
                                    </script>

                                    <div class="tab-pane fade" id="email-account" role="tabpanel"
                                        aria-labelledby="email-account-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Email Account Configuration</h2>
                                            <p class="primus-crm-content-description">Configure SMTP settings and
                                                email delivery options.</p>
                                        </div>

                                        <div class="primus-crm-form-grid">
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">SMTP Host</label>
                                                <input id="smtpHost" type="text" class="primus-crm-form-control"
                                                    value="smtp.gmail.com">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">SMTP Port</label>
                                                <input id="smtpPort" type="number" class="primus-crm-form-control"
                                                    value="587" min="1" max="65535">
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">SMTP Username</label>
                                                <input id="smtpUser" type="email" class="primus-crm-form-control"
                                                    value="crm@primusmotors.com">
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">SMTP Password</label>
                                                <input id="smtpPass" type="password" class="primus-crm-form-control"
                                                    value="••••••••">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Encryption Method</label>
                                                <select id="smtpEnc" class="primus-crm-form-control">
                                                    <option selected>TLS</option>
                                                    <option>SSL</option>
                                                    <option>None</option>
                                                </select>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">From Name</label>
                                                <input id="smtpFrom" type="text" class="primus-crm-form-control"
                                                    value="Primus Motors">
                                            </div>
                                        </div>

                                        <!-- Lead Process Configuration Section -->
                                        <div class="primus-crm-settings-section mt-5">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-users-cog"></i></span>
                                                Lead Process Configuration
                                            </h3>

                                            <!-- 1️⃣ Lead Distribution Logic -->
                                            <div class="primus-crm-form-grid">
                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Distribution Type</label>
                                                    <select id="distType" class="primus-crm-form-control">
                                                        <option value="individual" selected>Individual</option>
                                                        <option value="team">Team</option>
                                                        <option value="custom">Custom Team / Individuals</option>
                                                        <option value="performance" class="performance-option">⚡
                                                            Performance-Based Distribution (AI-Powered)</option>
                                                    </select>
                                                    <span class="primus-crm-form-help" id="distTypeHelp">Select how
                                                        leads should be distributed to your team.</span>
                                                </div>

                                                <!-- Individual Selection -->
                                                <div id="individualSection" class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Select Individual</label>
                                                    <select id="individualSelect" class="primus-crm-form-control">
                                                        <option value="">-- Select Team Member --</option>
                                                        <option value="1">Ali Khan</option>
                                                        <option value="2">Sara Ali</option>
                                                        <option value="3">Omar Rehman</option>
                                                        <option value="4">Fatima Noor</option>
                                                        <option value="5">Bilal Hussain</option>
                                                        <option value="6">Hassan Raza</option>
                                                        <option value="7">Nadia Aslam</option>
                                                        <option value="8">Usman Tariq</option>
                                                        <option value="9">Ayesha Malik</option>
                                                        <option value="10">Zain Ahmed</option>
                                                        <option value="11">Tariq Mehmood</option>
                                                    </select>
                                                    <span class="primus-crm-form-help">Select a single user for lead
                                                        assignment.</span>
                                                </div>

                                                <!-- Team Selection -->
                                                <div id="teamSection" class="primus-crm-form-group"
                                                    style="display: none;">
                                                    <label class="primus-crm-form-label">Select Team</label>
                                                    <select id="teamSelect" class="primus-crm-form-control">
                                                        c
                                                        <option value="sales-rep">Sales Rep</option>
                                                        <option value="bdc-agent">BDC Agent</option>
                                                        <option value="fi">F&I</option>
                                                        <option value="sales-manager">Sales Manager</option>
                                                        <option value="bdc-manager">BDC Manager</option>
                                                        <option value="finance-director">Finance Director</option>
                                                        <option value="general-sales-manager">General Sales Manager
                                                        </option>
                                                        <option value="general-manager">General Manager</option>
                                                        <option value="dealer-principal">Dealer Principal</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="reception">Reception</option>
                                                        <option value="service-advisor">Service Advisor</option>
                                                        <option value="service-manager">Service Manager</option>
                                                        <option value="inventory-manager">Inventory Manager</option>
                                                        <option value="fixed-operations-manager">Fixed Operations
                                                            Manager</option>
                                                    </select>
                                                    <span class="primus-crm-form-help">All members of this team will
                                                        be included in round robin.</span>
                                                </div>

                                                <!-- Custom Team / Individuals Selection -->
                                                <div id="customSection"
                                                    class="primus-crm-form-group primus-crm-form-group-full-width"
                                                    style="display: none;">
                                                    <label class="primus-crm-form-label">Select Individuals &
                                                        Teams</label>
                                                    <div class="primus-crm-checkbox-list"
                                                        style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 4px;">
                                                        <div
                                                            style="margin-bottom: 10px; font-weight: 600; color: #333;">
                                                            Individuals:</div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="ayesha-malik" id="member1">
                                                            <label class="form-check-label" for="member1">Ayesha
                                                                Malik</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="ali-khan" id="member2">
                                                            <label class="form-check-label" for="member2">Ali
                                                                Khan</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="bilal-hussain" id="member3">
                                                            <label class="form-check-label" for="member3">Bilal
                                                                Hussain</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="fatima-noor" id="member4">
                                                            <label class="form-check-label" for="member4">Fatima
                                                                Noor</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="hassan-raza" id="member5">
                                                            <label class="form-check-label" for="member5">Hassan
                                                                Raza</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="nadia-aslam" id="member6">
                                                            <label class="form-check-label" for="member6">Nadia
                                                                Aslam</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="omar-rehman" id="member7">
                                                            <label class="form-check-label" for="member7">Omar
                                                                Rehman</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="sara-ali" id="member8">
                                                            <label class="form-check-label" for="member8">Sara
                                                                Ali</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="tariq-mehmood" id="member9">
                                                            <label class="form-check-label" for="member9">Tariq
                                                                Mehmood</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="usman-tariq" id="member10">
                                                            <label class="form-check-label" for="member10">Usman
                                                                Tariq</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="zain-ahmed" id="member11">
                                                            <label class="form-check-label" for="member11">Zain
                                                                Ahmed</label>
                                                        </div>

                                                        <hr style="margin: 15px 0;">

                                                        <div
                                                            style="margin-bottom: 10px; font-weight: 600; color: #333;">
                                                            Teams:</div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="sales-rep" id="team1">
                                                            <label class="form-check-label" for="team1">Sales
                                                                Rep</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="bdc-agent" id="team2">
                                                            <label class="form-check-label" for="team2">BDC
                                                                Agent</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="fi" id="team3">
                                                            <label class="form-check-label" for="team3">F&I</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="sales-manager" id="team4">
                                                            <label class="form-check-label" for="team4">Sales
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="bdc-manager" id="team5">
                                                            <label class="form-check-label" for="team5">BDC
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="finance-director" id="team6">
                                                            <label class="form-check-label" for="team6">Finance
                                                                Director</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="general-sales-manager"
                                                                id="team7">
                                                            <label class="form-check-label" for="team7">General
                                                                Sales Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="general-manager" id="team8">
                                                            <label class="form-check-label" for="team8">General
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="dealer-principal" id="team9">
                                                            <label class="form-check-label" for="team9">Dealer
                                                                Principal</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="admin" id="team10">
                                                            <label class="form-check-label"
                                                                for="team10">Admin</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="reception" id="team11">
                                                            <label class="form-check-label"
                                                                for="team11">Reception</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="service-advisor" id="team12">
                                                            <label class="form-check-label" for="team12">Service
                                                                Advisor</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="service-manager" id="team13">
                                                            <label class="form-check-label" for="team13">Service
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="inventory-manager"
                                                                id="team14">
                                                            <label class="form-check-label" for="team14">Inventory
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="fixed-operations-manager"
                                                                id="team15">
                                                            <label class="form-check-label" for="team15">Fixed
                                                                Operations Manager</label>
                                                        </div>
                                                    </div>
                                                    <span class="primus-crm-form-help">Select individuals and/or
                                                        teams for custom distribution.</span>
                                                </div>

                                                <!-- Performance-Based Distribution Section -->
                                                <div id="performanceSection"
                                                    class="primus-crm-form-group primus-crm-form-group-full-width"
                                                    style="display: none;">
                                                    <div class="performance-ai-banner">
                                                        <div class="ai-badge">
                                                            <i class="fas fa-brain"></i>
                                                            <span>AI-POWERED</span>
                                                        </div>
                                                        <h4 class="performance-title">
                                                            <i class="fas fa-chart-line me-2"></i>
                                                            Performance-Based Distribution
                                                        </h4>
                                                        <p class="performance-description">
                                                            Revolutionary AI technology that analyzes historical
                                                            data to automatically route leads to your
                                                            highest-performing team members based on real-time
                                                            metrics and behavioral patterns.
                                                        </p>
                                                    </div>

                                                    <!-- AI Learning Status -->
                                                    <div class="ai-learning-status mb-4">
                                                        <div class="learning-header">
                                                            <i class="fas fa-graduation-cap me-2"></i>
                                                            <strong>AI Learning Status</strong>
                                                        </div>
                                                        <div class="learning-progress-bar">
                                                            <div class="learning-progress" id="aiLearningProgress"
                                                                style="width: 35%;">
                                                                <span class="progress-text">35% Trained</span>
                                                            </div>
                                                        </div>
                                                        <div class="learning-info">
                                                            <div class="info-item">
                                                                <i class="fas fa-calendar-check text-primary"></i>
                                                                <span><strong>Active Since:</strong> <span
                                                                        id="aiActiveDate">Jan 15, 2025</span></span>
                                                            </div>
                                                            <div class="info-item">
                                                                <i class="fas fa-database text-success"></i>
                                                                <span><strong>Leads Analyzed:</strong> <span
                                                                        id="aiLeadsAnalyzed">1,247</span></span>
                                                            </div>
                                                            <div class="info-item">
                                                                <i class="fas fa-clock text-warning"></i>
                                                                <span><strong>Est. Full Training:</strong> <span
                                                                        id="aiTrainingTime">45 days</span></span>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-info mt-3">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Learning Period:</strong> The AI requires 60-90
                                                            days of data to reach optimal accuracy. During this
                                                            period, it analyzes close rates, response times,
                                                            lead-to-sale conversions, and team member availability
                                                            patterns. You can enable it now, and it will improve
                                                            automatically as it learns.
                                                        </div>
                                                    </div>

                                                    <!-- Distribution Strategy Selection -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-bullseye me-2"></i>
                                                            Primary Distribution Strategy
                                                        </label>
                                                        <select id="performanceStrategy"
                                                            class="primus-crm-form-control performance-select">
                                                            <option value="">-- Select Strategy --</option>
                                                            <option value="close_rate">🏆 Highest Close Rate (Assign
                                                                to best converter)</option>
                                                            <option value="response_time">⚡ Fastest Response Time
                                                                (Speed-to-contact)</option>
                                                            <option value="workload">⚖️ Balanced Workload (Lowest
                                                                current leads)</option>
                                                            <option value="revenue">💰 Highest Revenue Per Sale
                                                            </option>
                                                            <option value="satisfaction">⭐ Best Customer
                                                                Satisfaction Score</option>
                                                            <option value="hybrid">🎯 Hybrid AI Model (Multi-factor
                                                                optimization)</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Choose how AI should
                                                            prioritize lead assignment.</span>
                                                    </div>

                                                    <!-- Strategy Details Panel -->
                                                    <div id="strategyDetails" class="strategy-details-panel"
                                                        style="display: none;">
                                                        <!-- Close Rate Strategy -->
                                                        <div class="strategy-detail" data-strategy="close_rate"
                                                            style="display: none;">
                                                            <div class="strategy-icon">🏆</div>
                                                            <h5>Highest Close Rate Strategy</h5>
                                                            <p><strong>How it works:</strong> AI tracks each team
                                                                member's lead-to-sale conversion rate over time and
                                                                assigns new leads to the person with the best
                                                                closing percentage.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Total leads assigned vs. sales closed</li>
                                                                    <li>Close rate by lead source</li>
                                                                    <li>Close rate by vehicle type</li>
                                                                    <li>Historical performance trends</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Teams focused on
                                                                maximizing conversion rates and ROI from every lead.
                                                            </div>
                                                        </div>

                                                        <!-- Response Time Strategy -->
                                                        <div class="strategy-detail" data-strategy="response_time"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⚡</div>
                                                            <h5>Fastest Response Time Strategy</h5>
                                                            <p><strong>How it works:</strong> Routes leads to team
                                                                members who consistently respond fastest, ensuring
                                                                hot leads get immediate attention.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Average time from lead assignment to first
                                                                        contact</li>
                                                                    <li>Response time by time of day/day of week
                                                                    </li>
                                                                    <li>Current availability and activity status
                                                                    </li>
                                                                    <li>Peak performance hours per team member</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Internet leads and
                                                                time-sensitive inquiries where speed is critical.
                                                            </div>
                                                        </div>

                                                        <!-- Workload Strategy -->
                                                        <div class="strategy-detail" data-strategy="workload"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⚖️</div>
                                                            <h5>Balanced Workload Strategy</h5>
                                                            <p><strong>How it works:</strong> Ensures fair
                                                                distribution by routing leads to team members with
                                                                the fewest active opportunities, preventing burnout.
                                                            </p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Current active leads per team member</li>
                                                                    <li>Open tasks and pending follow-ups</li>
                                                                    <li>Scheduled appointments and time commitments
                                                                    </li>
                                                                    <li>Historical capacity handling</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Teams prioritizing
                                                                fairness and preventing individual overload.
                                                            </div>
                                                        </div>

                                                        <!-- Revenue Strategy -->
                                                        <div class="strategy-detail" data-strategy="revenue"
                                                            style="display: none;">
                                                            <div class="strategy-icon">💰</div>
                                                            <h5>Highest Revenue Per Sale Strategy</h5>
                                                            <p><strong>How it works:</strong> Assigns leads to team
                                                                members who historically generate the highest
                                                                average sale value and profit margins.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Average deal value per salesperson</li>
                                                                    <li>Product mix and upsell success rates</li>
                                                                    <li>F&I product penetration</li>
                                                                    <li>Profit per unit trends</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Maximizing profit per
                                                                lead and overall dealership revenue.
                                                            </div>
                                                        </div>

                                                        <!-- Satisfaction Strategy -->
                                                        <div class="strategy-detail" data-strategy="satisfaction"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⭐</div>
                                                            <h5>Best Customer Satisfaction Strategy</h5>
                                                            <p><strong>How it works:</strong> Routes leads to team
                                                                members with the highest customer satisfaction
                                                                ratings and positive reviews.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Customer survey scores and feedback</li>
                                                                    <li>Online review ratings per salesperson</li>
                                                                    <li>Repeat customer rate</li>
                                                                    <li>Referral generation patterns</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Building long-term
                                                                customer relationships and brand reputation.
                                                            </div>
                                                        </div>

                                                        <!-- Hybrid Strategy -->
                                                        <div class="strategy-detail" data-strategy="hybrid"
                                                            style="display: none;">
                                                            <div class="strategy-icon">🎯</div>
                                                            <h5>Hybrid AI Model (Recommended)</h5>
                                                            <p><strong>How it works:</strong> Advanced multi-factor
                                                                algorithm that weighs multiple performance metrics
                                                                simultaneously for optimal lead placement.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>All metrics from above strategies</li>
                                                                    <li>Dynamic weighting based on lead type/source
                                                                    </li>
                                                                    <li>Real-time team availability</li>
                                                                    <li>Predictive success probability scoring</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Maximum ROI - combines
                                                                all factors for the smartest possible assignment.
                                                            </div>

                                                            <!-- Custom Weighting for Hybrid -->
                                                            <div class="hybrid-weights mt-3">
                                                                <h6><i class="fas fa-sliders-h me-2"></i>Custom
                                                                    Factor Weights (Optional)</h6>
                                                                <div class="weight-slider">
                                                                    <label>Close Rate Importance: <span
                                                                            id="closeRateValue">40%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="closeRateWeight" min="0" max="100"
                                                                        value="40">
                                                                </div>
                                                                <div class="weight-slider">
                                                                    <label>Response Time Importance: <span
                                                                            id="responseTimeValue">30%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="responseTimeWeight" min="0" max="100"
                                                                        value="30">
                                                                </div>
                                                                <div class="weight-slider">
                                                                    <label>Workload Balance Importance: <span
                                                                            id="workloadValue">30%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="workloadWeight" min="0" max="100"
                                                                        value="30">
                                                                </div>
                                                                <small class="text-muted">Adjust these values to
                                                                    customize how the AI prioritizes different
                                                                    factors.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Team Member Pool Selection -->
                                                    <div class="primus-crm-form-group mt-4">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-users me-2"></i>
                                                            Select Team Members for AI Distribution Pool
                                                        </label>
                                                        <select id="performanceTeamMembers"
                                                            class="primus-crm-form-control" multiple size="8">
                                                            <option value="1">Ali Khan</option>
                                                            <option value="2">Sara Ali</option>
                                                            <option value="3">Omar Rehman</option>
                                                            <option value="4">Fatima Noor</option>
                                                            <option value="5">Bilal Hussain</option>
                                                            <option value="6">Hassan Raza</option>
                                                            <option value="7">Nadia Aslam</option>
                                                            <option value="8">Usman Tariq</option>
                                                            <option value="9">Ayesha Malik</option>
                                                            <option value="10">Zain Ahmed</option>
                                                            <option value="11">Tariq Mehmood</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Hold Ctrl (Cmd on Mac) to
                                                            select multiple team members. Only selected members will
                                                            be included in AI-powered distribution.</span>
                                                    </div>

                                                    <!-- Performance Threshold -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-filter me-2"></i>
                                                            Minimum Performance Threshold
                                                        </label>
                                                        <select id="performanceThreshold"
                                                            class="primus-crm-form-control">
                                                            <option value="none">No Minimum (Include all selected
                                                                members)</option>
                                                            <option value="low">Low (Include members with >10% close
                                                                rate)</option>
                                                            <option value="medium" selected>Medium (Include members
                                                                with >20% close rate)</option>
                                                            <option value="high">High (Include members with >30%
                                                                close rate)</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Set minimum performance
                                                            criteria. Members below threshold will be excluded from
                                                            AI distribution.</span>
                                                    </div>

                                                    <!-- AI Override Options -->
                                                    <div class="primus-crm-setting-row mt-3">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-name">
                                                                <i class="fas fa-hand-paper me-2"></i>
                                                                Allow Manual Override
                                                            </div>
                                                            <div class="primus-crm-setting-desc">Managers can
                                                                manually reassign AI-distributed leads if needed
                                                            </div>
                                                        </div>
                                                        <div id="manualOverrideToggle"
                                                            class="primus-crm-toggle-switch active"
                                                            onclick="this.classList.toggle('active')"></div>
                                                    </div>

                                                    <div class="primus-crm-setting-row">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-name">
                                                                <i class="fas fa-chart-bar me-2"></i>
                                                                Show AI Reasoning
                                                            </div>
                                                            <div class="primus-crm-setting-desc">Display why AI
                                                                chose specific team member (for transparency)</div>
                                                        </div>
                                                        <div id="showReasoningToggle"
                                                            class="primus-crm-toggle-switch active"
                                                            onclick="this.classList.toggle('active')"></div>
                                                    </div>
                                                </div>

                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Round Robin Enabled</label>
                                                    <select id="roundRobin" class="primus-crm-form-control">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- 2️⃣ Lead Timeout & Reassignment -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-clock me-2"></i>Lead Response Timeout &
                                                    Auto-Reassign</h4>
                                                <p class="primus-crm-form-help mb-2">Define how long selected
                                                    users/teams have to respond before lead reassignment occurs.</p>
                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Response Time
                                                            (minutes)</label>
                                                        <input id="responseTime" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="5">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Reassignment Count
                                                            (cycles)</label>
                                                        <input id="reassignmentCount" type="number"
                                                            class="primus-crm-form-control" min="1" max="10"
                                                            value="3">
                                                        <span class="primus-crm-form-help">Number of times to cycle
                                                            through selected members before fallback.</span>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Fallback
                                                            Manager</label>
                                                        <select id="fallbackUser" class="primus-crm-form-control">
                                                            <option value="">-- Select Fallback Manager --</option>
                                                            <option value="m1">Adnan Malik</option>
                                                            <option value="m2">Sana Khan</option>
                                                            <option value="m3">Farhan Ahmed</option>
                                                            <option value="m4">Hira Qureshi</option>
                                                            <option value="m5">Imran Raza</option>
                                                            <option value="m6">Kiran Fatima</option>
                                                            <option value="m7">Taimoor Shah</option>
                                                            <option value="m8">Ayesha Zafar</option>
                                                            <option value="m9">Usman Javed</option>
                                                            <option value="m10">Nadia Rehman</option>
                                                            <option value="m11">Bilal Khan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Manager Notification
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Notify manager when
                                                            user fails to respond (bell + optional email)</div>
                                                    </div>
                                                    <div id="managerNotifToggle"
                                                        class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                            </div>

                                            <!-- 3️⃣ Lead Alerts & Reminders -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-bell me-2"></i>Pending Lead Alerts</h4>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Enable Alerts</div>
                                                        <div class="primus-crm-setting-desc">Toggle to remind users
                                                            about unanswered leads</div>
                                                    </div>
                                                    <div id="alertsToggle" class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-form-grid mt-3">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Alert Frequency
                                                            (minutes)</label>
                                                        <input id="alertFrequency" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="5">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Repeat Count</label>
                                                        <input id="alertRepeat" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="4">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 4️⃣ After Hours Handling -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-moon me-2"></i>After Hours Process</h4>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Enable After Hours
                                                            Process</div>
                                                        <div class="primus-crm-setting-desc">Trigger dedicated
                                                            off-hours Smart Sequence</div>
                                                    </div>
                                                    <div id="afterHoursToggle" class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-form-group mt-3">
                                                    <label class="primus-crm-form-label">After Hours Smart
                                                        Sequence</label>
                                                    <select id="afterHoursSequence" class="primus-crm-form-control">
                                                        <option selected>Select Smart Sequence</option>
                                                        <option>Off-Hours Follow Up</option>
                                                        <option>Night Response Automation</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- 5️⃣ Lead Stop Conditions -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-stop-circle me-2"></i>Smart Sequence Stop
                                                    Rules</h4>
                                                <p class="primus-crm-form-help mb-2">Smart Sequence process
                                                    continues unless marked Sold, Lost, or Pending F&I.</p>
                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Stop On:</label>
                                                    <select id="smartSequenceStopRule"
                                                        class="primus-crm-form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Sold">Sold</option>
                                                        <option value="Lost">Lost</option>
                                                        <option value="Pending F&I">Pending F&I</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-code-branch me-2"></i>Custom Lead Assignment
                                                    Rules</h4>
                                                <p class="primus-crm-form-help mb-2">Create rules for assigning
                                                    leads based on source, vehicle type, or other filters.</p>

                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Rule Name</label>
                                                        <input id="ruleName" type="text"
                                                            class="primus-crm-form-control"
                                                            placeholder="e.g. Facebook Leads Rule">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Enable Rule</label>
                                                        <select id="ruleEnable" class="primus-crm-form-control">
                                                            <option value="yes">Yes</option>
                                                            <option value="no" selected>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Inventory Type</label>
                                                        <select id="ruleVehicle" class="primus-crm-form-control">
                                                            <option value="new">New</option>
                                                            <option value="pre-owned">Pre-Owned</option>
                                                            <option value="cpo">CPO</option>
                                                            <option value="demo">Demo</option>
                                                            <option value="wholesale">Wholesale</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Make</label>
                                                        <select id="ruleMakeModel" class="primus-crm-form-control">
                                                            <option value="">Select Vehicle Make</option>
                                                            <option value="Toyota">Toyota</option>
                                                            <option value="Honda">Honda</option>
                                                            <option value="Suzuki">Suzuki</option>
                                                            <option value="Hyundai">Hyundai</option>
                                                            <option value="Kia">Kia</option>
                                                            <option value="Ford">Ford</option>
                                                            <option value="Chevrolet">Chevrolet</option>
                                                            <option value="Nissan">Nissan</option>
                                                            <option value="BMW">BMW</option>
                                                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                            <option value="Audi">Audi</option>
                                                            <option value="Volkswagen">Volkswagen</option>
                                                            <option value="Lexus">Lexus</option>
                                                            <option value="Mitsubishi">Mitsubishi</option>
                                                            <option value="Jeep">Jeep</option>
                                                        </select>
                                                    </div>

                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Model</label>
                                                        <select name="" id="" class="primus-crm-form-control">
                                                            <option value="">Select Vehicle Model</option>
                                                            <option value="">Camry</option>
                                                            <option value="">Corolla</option>
                                                            <option value="">Mustang</option>
                                                            <option value="">Santa Fe</option>
                                                            <option value="">E-Class</option>
                                                            <option value="">Sonata</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Lead Source</label>
                                                        <select id="ruleSource" class="primus-crm-form-control">
                                                            <option value="facebook" selected>Facebook</option>
                                                            <option value="google">Google Ads</option>
                                                            <option value="kijiji">Kijiji</option>
                                                            <option value="referral">Referral</option>
                                                            <option value="website">Website</option>
                                                        </select>
                                                    </div>

                                                    <!-- NEW: Smart Sequence Assignment Dropdown -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Add This Lead
                                                            Assignment to Smart Sequence</label>
                                                        <select id="smartSequenceSelect"
                                                            class="primus-crm-form-control">
                                                            <option value="">Select Smart Sequence</option>
                                                            <option value="seq1">Follow-Up Sequence A</option>
                                                            <option value="seq2">VIP Customer Sequence</option>
                                                            <option value="seq3">New Lead Nurturing</option>
                                                            <option value="seq4">Service Reminder Sequence</option>
                                                            <option value="seq5">Trade-In Follow Up</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">
                                                            Selected users will be assigned to the chosen Smart
                                                            Sequence
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- User Assignment Area -->
                                                <div class="primus-crm-settings-subsection mt-3">
                                                    <h5 class="primus-crm-subtitle"><i
                                                            class="fas fa-users me-2"></i>Assign To Users / Teams
                                                    </h5>
                                                    <div class="primus-crm-form-grid">
                                                        <div class="primus-crm-form-group">
                                                            <label class="primus-crm-form-label">Team</label>
                                                            <select id="ruleTeam" class="primus-crm-form-control"
                                                                onchange="updateMembersDropdown()">
                                                                <option value="all_teams" selected>All User Teams
                                                                </option>
                                                                <option value="sales">Sales Team</option>
                                                                <option value="support">Support Team</option>
                                                                <option value="marketing">Marketing Team</option>
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="primus-crm-form-group primus-crm-form-group-full-width">
                                                            <label class="primus-crm-form-label">Select
                                                                Member</label>
                                                            <select id="ruleMembers" class="form-select" multiple
                                                                placeholder="Search and select members...">
                                                                <!-- Options will be populated dynamically -->
                                                            </select>
                                                            <span class="primus-crm-form-help">
                                                                Type to search for members. Use backspace to remove
                                                                selections.
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="primus-crm-setting-row mt-2 d-none">
                                                        <div id="selectAllToggle" class="primus-crm-toggle-switch"
                                                            onclick="toggleSelectAllUsers(this)"></div>
                                                    </div>
                                                </div>

                                                <div class="text-end mt-4">
                                                    <button id="addRuleBtn"
                                                        class="primus-crm-btn primus-crm-btn-primary btn btn-primary"
                                                        onclick="addCustomRule()">
                                                        <i class="fas fa-plus-circle me-1"></i> Add Custom Rule
                                                    </button>
                                                </div>

                                                <div id="rulesList" class="mt-3"></div>
                                            </div>

                                            <!-- Add TomSelect CSS -->
                                            <link
                                                href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css"
                                                rel="stylesheet">

                                            <script
                                                src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

                                            <script>
                                                // Global variable to store rules
                                                let customRules = [];
                                                let tomSelectInstance = null;



                                                // Team and user data structure
                                                const teamData = {
                                                    all_teams: [
                                                        { id: "u1", name: "John Carter", team: "sales" },
                                                        { id: "u2", name: "Emily Johnson", team: "sales" },
                                                        { id: "u3", name: "Michael Smith", team: "sales" },
                                                        { id: "u4", name: "Olivia Brown", team: "support" },
                                                        { id: "u5", name: "James Wilson", team: "support" },
                                                        { id: "u6", name: "Sophia Davis", team: "marketing" },
                                                        { id: "u7", name: "Daniel Miller", team: "marketing" },
                                                        { id: "u8", name: "Ava Thompson", team: "sales" },
                                                        { id: "u9", name: "Liam Anderson", team: "support" },
                                                        { id: "u10", name: "Isabella Martinez", team: "marketing" },
                                                        { id: "u11", name: "Ethan Roberts", team: "sales" }
                                                    ]
                                                };

                                                // Filtering function
                                                function getMembersByTeam(team) {
                                                    if (team === "all_teams") {
                                                        return teamData.all_teams;
                                                    }
                                                    return teamData.all_teams.filter(member => member.team === team);
                                                }

                                                // Initialize TomSelect with options
                                                function initializeTomSelect(options = []) {
                                                    const selectElement = document.getElementById('ruleMembers');
                                                    selectElement.innerHTML = '';

                                                    options.forEach(option => {
                                                        const opt = document.createElement('option');
                                                        opt.value = option.value;
                                                        opt.textContent = option.text;
                                                        selectElement.appendChild(opt);
                                                    });

                                                    // Destroy previous instance
                                                    if (tomSelectInstance) {
                                                        tomSelectInstance.destroy();
                                                    }

                                                    // Initialize new TomSelect
                                                    tomSelectInstance = new TomSelect(selectElement, {
                                                        plugins: ['remove_button', 'checkbox_options'],
                                                        maxItems: null,
                                                        placeholder: 'Search and select members...',
                                                        searchField: ['text'],
                                                        render: {
                                                            option: (data, escape) =>
                                                                `<div class="d-flex align-items-center">
                <span class="flex-grow-1">${escape(data.text)}</span>
             </div>`,
                                                            item: (data, escape) =>
                                                                `<div class="ts-item">${escape(data.text)}</div>`,
                                                            no_results: (data, escape) =>
                                                                `<div class="no-results">No members found for "${escape(data.input)}"</div>`
                                                        },
                                                        onInitialize() {
                                                            this.setValue([]);
                                                        }
                                                    });
                                                }

                                                // Update members dropdown
                                                function updateMembersDropdown() {
                                                    const selectedTeam = document.getElementById('ruleTeam').value;

                                                    let filteredMembers = getMembersByTeam(selectedTeam);

                                                    let options = [];

                                                    // Add "All Users" only for All Teams
                                                    if (selectedTeam === "all_teams") {
                                                        options.push({ value: "all_users", text: "All Users" });
                                                    }

                                                    filteredMembers.forEach(m => {
                                                        options.push({
                                                            value: m.id,
                                                            text: m.name
                                                        });
                                                    });

                                                    // Update TomSelect
                                                    initializeTomSelect(options);
                                                }

                                                // Initialize default
                                                document.addEventListener("DOMContentLoaded", () => {
                                                    updateMembersDropdown();
                                                });

                                                // Distribution Type Logic - Auto show/hide sections and set Round Robin defaults
                                                document.getElementById('distType').addEventListener('change', function () {
                                                    const distType = this.value;
                                                    const individualSection = document.getElementById('individualSection');
                                                    const teamSection = document.getElementById('teamSection');
                                                    const customSection = document.getElementById('customSection');
                                                    const performanceSection = document.getElementById('performanceSection');
                                                    const roundRobinSelect = document.getElementById('roundRobin');
                                                    const distTypeHelp = document.getElementById('distTypeHelp');

                                                    // Hide all sections first
                                                    individualSection.style.display = 'none';
                                                    teamSection.style.display = 'none';
                                                    customSection.style.display = 'none';
                                                    performanceSection.style.display = 'none';

                                                    // Show relevant section and set Round Robin default
                                                    if (distType === 'individual') {
                                                        individualSection.style.display = 'block';
                                                        roundRobinSelect.value = 'no';
                                                        distTypeHelp.textContent = 'Select a single user for lead assignment.';
                                                    } else if (distType === 'team') {
                                                        teamSection.style.display = 'block';
                                                        roundRobinSelect.value = 'yes';
                                                        distTypeHelp.textContent = 'All members of this team will be included in round robin.';
                                                    } else if (distType === 'custom') {
                                                        customSection.style.display = 'block';
                                                        roundRobinSelect.value = 'yes';
                                                        distTypeHelp.textContent = 'Select individuals and/or teams for custom distribution.';
                                                    } else if (distType === 'performance') {
                                                        performanceSection.style.display = 'block';
                                                        roundRobinSelect.value = 'no';
                                                        distTypeHelp.innerHTML = '<strong>AI-Powered Distribution:</strong> Leads are automatically assigned based on performance metrics and AI analysis.';
                                                    }
                                                });

                                                // Performance Strategy Change Handler
                                                document.getElementById('performanceStrategy').addEventListener('change', function () {
                                                    const strategy = this.value;
                                                    const strategyDetails = document.getElementById('strategyDetails');
                                                    const allDetails = document.querySelectorAll('.strategy-detail');

                                                    // Hide all strategy details
                                                    allDetails.forEach(detail => {
                                                        detail.style.display = 'none';
                                                    });

                                                    if (strategy) {
                                                        strategyDetails.style.display = 'block';
                                                        const selectedDetail = document.querySelector(`.strategy-detail[data-strategy="${strategy}"]`);
                                                        if (selectedDetail) {
                                                            selectedDetail.style.display = 'block';
                                                        }
                                                    } else {
                                                        strategyDetails.style.display = 'none';
                                                    }
                                                });

                                                // Hybrid Weight Sliders
                                                ['closeRateWeight', 'responseTimeWeight', 'workloadWeight'].forEach(id => {
                                                    const slider = document.getElementById(id);
                                                    if (slider) {
                                                        slider.addEventListener('input', function () {
                                                            const valueId = id.replace('Weight', 'Value');
                                                            document.getElementById(valueId).textContent = this.value + '%';
                                                        });
                                                    }
                                                });

                                                // Toggle Select All Users functionality
                                                function toggleSelectAllUsers(toggleElement) {
                                                    toggleElement.classList.toggle('active');
                                                    const isActive = toggleElement.classList.contains('active');

                                                    if (tomSelectInstance) {
                                                        if (isActive) {
                                                            // Select all available options
                                                            const allValues = Object.values(tomSelectInstance.options).map(opt => opt.value);
                                                            tomSelectInstance.setValue(allValues);
                                                        } else {
                                                            // Clear all selections
                                                            tomSelectInstance.setValue([]);
                                                        }
                                                    }
                                                }

                                                // Add Custom Rule functionality
                                                function addCustomRule() {
                                                    const ruleName = document.getElementById('ruleName').value.trim();
                                                    const ruleEnable = document.getElementById('ruleEnable').value;
                                                    const ruleVehicle = document.getElementById('ruleVehicle').value;
                                                    const ruleMakeModel = document.getElementById('ruleMakeModel').value.trim();
                                                    const ruleSource = document.getElementById('ruleSource').value;
                                                    const ruleTeam = document.getElementById('ruleTeam').value;
                                                    const smartSequence = document.getElementById('smartSequenceSelect').value;
                                                    const selectAllActive = document.getElementById('selectAllToggle').classList.contains('active');

                                                    // Get selected members from TomSelect
                                                    let selectedMembers = [];
                                                    if (tomSelectInstance) {
                                                        const selectedValues = tomSelectInstance.getValue();
                                                        selectedMembers = selectedValues.map(value => {
                                                            const option = tomSelectInstance.options[value];
                                                            return option ? option.text : value;
                                                        });
                                                    }

                                                    // Validation
                                                    if (!ruleName) {
                                                        showNotification('Please enter a rule name', 'danger');
                                                        return;
                                                    }

                                                    if (!selectedMembers.length && !selectAllActive) {
                                                        showNotification('Please select at least one member or enable "Select All Users"', 'danger');
                                                        return;
                                                    }

                                                    // Create rule object
                                                    const rule = {
                                                        id: Date.now(),
                                                        name: ruleName,
                                                        enabled: ruleEnable,
                                                        vehicleType: ruleVehicle,
                                                        makeModel: ruleMakeModel || 'Any',
                                                        source: ruleSource,
                                                        team: ruleTeam,
                                                        smartSequence: smartSequence,
                                                        members: selectAllActive ? 'All Users' : selectedMembers.join(', '),
                                                        selectAll: selectAllActive
                                                    };

                                                    // Add to rules array
                                                    customRules.push(rule);

                                                    // Display the rule
                                                    displayRules();

                                                    // Clear form
                                                    document.getElementById('ruleName').value = '';
                                                    document.getElementById('ruleEnable').value = 'yes';
                                                    document.getElementById('ruleVehicle').value = 'new';
                                                    document.getElementById('ruleMakeModel').value = '';
                                                    document.getElementById('ruleSource').value = 'facebook';
                                                    document.getElementById('ruleTeam').value = 'sales';
                                                    document.getElementById('smartSequenceSelect').value = '';

                                                    // Clear TomSelect selections but keep options
                                                    if (tomSelectInstance) {
                                                        tomSelectInstance.setValue([]);
                                                    }

                                                    document.getElementById('selectAllToggle').classList.remove('active');

                                                    showNotification('Custom rule added successfully!', 'success');
                                                }

                                                // Display all rules
                                                function displayRules() {
                                                    const rulesList = document.getElementById('rulesList');

                                                    if (customRules.length === 0) {
                                                        rulesList.innerHTML = '<p class="text-muted">No custom rules created yet.</p>';
                                                        return;
                                                    }

                                                    let html = '<div class="list-group">';

                                                    customRules.forEach(rule => {
                                                        const statusBadge = rule.enabled === 'yes'
                                                            ? '<span class="badge bg-success">Enabled</span>'
                                                            : '<span class="badge bg-secondary">Disabled</span>';

                                                        // Get Smart Sequence name
                                                        const smartSequenceSelect = document.getElementById('smartSequenceSelect');
                                                        const smartSequenceOption = smartSequenceSelect.querySelector(`option[value="${rule.smartSequence}"]`);
                                                        const smartSequenceName = smartSequenceOption ? smartSequenceOption.textContent : 'Not assigned';

                                                        html += `
                                                            <div class="list-group-item" id="rule-${rule.id}">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1">
                                                                            <i class="fas fa-filter me-2"></i>${rule.name} 
                                                                            ${statusBadge}
                                                                        </h6>
                                                                        <p class="mb-1 small">
                                                                            <strong>Source:</strong> ${rule.source.charAt(0).toUpperCase() + rule.source.slice(1)} | 
                                                                            <strong>Vehicle:</strong> ${rule.vehicleType.charAt(0).toUpperCase() + rule.vehicleType.slice(1)} | 
                                                                            <strong>Make/Model:</strong> ${rule.makeModel}
                                                                        </p>
                                                                        <p class="mb-1 small">
                                                                            <strong>Team:</strong> ${rule.team.charAt(0).toUpperCase() + rule.team.slice(1)} Team | 
                                                                            <strong>Assigned To:</strong> ${rule.members}
                                                                        </p>
                                                                        ${rule.smartSequence ? `<p class="mb-1 small"><strong>Smart Sequence:</strong> ${smartSequenceName}</p>` : ''}
                                                                    </div>
                                                                    <div class="btn-group btn-group-sm ms-3">
                                                                        <button class="btn btn-outline-danger" onclick="deleteRule(${rule.id})" title="Delete Rule">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                                    });

                                                    html += '</div>';
                                                    rulesList.innerHTML = html;
                                                }

                                                // Delete rule
                                                function deleteRule(ruleId) {
                                                    if (confirm('Are you sure you want to delete this rule?')) {
                                                        customRules = customRules.filter(rule => rule.id !== ruleId);
                                                        displayRules();
                                                        showNotification('Rule deleted successfully!', 'success');
                                                    }
                                                }

                                                // Simulate Lead functionality
                                                function simulateLead() {
                                                    const simSource = document.getElementById('simSource').value;
                                                    const simVehicle = document.getElementById('simVehicle').value;
                                                    const simMakeModel = document.getElementById('simMakeModel').value.trim();
                                                    const demoMode = document.getElementById('demoMode').checked;

                                                    // Validation
                                                    if (!simMakeModel) {
                                                        showNotification('Please enter Make/Model for simulation', 'warning');
                                                        return;
                                                    }

                                                    // Get distribution settings
                                                    const distType = document.getElementById('distType').value;
                                                    const roundRobin = document.getElementById('roundRobin').value;
                                                    const responseTime = document.getElementById('responseTime').value;
                                                    const reassignmentCount = document.getElementById('reassignmentCount').value;
                                                    const fallbackUser = document.getElementById('fallbackUser').value;

                                                    let assignedTo = 'Not assigned';
                                                    let distributionMethod = 'Default';

                                                    // Check if Performance-Based Distribution is selected
                                                    if (distType === 'performance') {
                                                        const strategy = document.getElementById('performanceStrategy').value;
                                                        const performanceTeamMembers = document.getElementById('performanceTeamMembers');
                                                        const selectedMembers = Array.from(performanceTeamMembers.selectedOptions).map(opt => opt.text);

                                                        if (!strategy) {
                                                            showNotification('Please select a Performance Strategy', 'warning');
                                                            return;
                                                        }

                                                        if (selectedMembers.length === 0) {
                                                            showNotification('Please select team members for AI distribution pool', 'warning');
                                                            return;
                                                        }

                                                        // Simulate AI decision
                                                        const strategyNames = {
                                                            'close_rate': 'Highest Close Rate',
                                                            'response_time': 'Fastest Response Time',
                                                            'workload': 'Balanced Workload',
                                                            'revenue': 'Highest Revenue Per Sale',
                                                            'satisfaction': 'Best Customer Satisfaction',
                                                            'hybrid': 'Hybrid AI Model'
                                                        };

                                                        // Randomly pick a member for simulation (in production, this would be AI-calculated)
                                                        const randomMember = selectedMembers[Math.floor(Math.random() * selectedMembers.length)];
                                                        assignedTo = randomMember;
                                                        distributionMethod = `AI-Powered (${strategyNames[strategy]})`;

                                                        // Show AI reasoning
                                                        const showReasoning = document.getElementById('showReasoningToggle').classList.contains('active');
                                                        if (showReasoning) {
                                                            let reasoning = '';
                                                            switch (strategy) {
                                                                case 'close_rate':
                                                                    reasoning = `${randomMember} has a 32% close rate (highest in pool)`;
                                                                    break;
                                                                case 'response_time':
                                                                    reasoning = `${randomMember} average response time: 2.3 minutes (fastest)`;
                                                                    break;
                                                                case 'workload':
                                                                    reasoning = `${randomMember} has 5 active leads (lowest workload)`;
                                                                    break;
                                                                case 'revenue':
                                                                    reasoning = `${randomMember} average deal value: $45,200 (highest)`;
                                                                    break;
                                                                case 'satisfaction':
                                                                    reasoning = `${randomMember} customer satisfaction: 4.8/5 stars (highest)`;
                                                                    break;
                                                                case 'hybrid':
                                                                    reasoning = `${randomMember} scored 94/100 on multi-factor analysis (close rate: 28%, response: 3.1 min, workload: 7 leads)`;
                                                                    break;
                                                            }
                                                            distributionMethod += `<br><small class="text-muted">AI Reasoning: ${reasoning}</small>`;
                                                        }
                                                    } else {
                                                        // Check if any custom rules match
                                                        let matchedRule = null;
                                                        for (let rule of customRules) {
                                                            if (rule.enabled === 'yes' && rule.source === simSource) {
                                                                if (rule.vehicleType === 'any' || rule.vehicleType === simVehicle) {
                                                                    if (!rule.makeModel || rule.makeModel === 'Any' ||
                                                                        simMakeModel.toLowerCase().includes(rule.makeModel.toLowerCase())) {
                                                                        matchedRule = rule;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        // Determine assignment
                                                        if (matchedRule) {
                                                            assignedTo = matchedRule.members;
                                                            distributionMethod = `Custom Rule: ${matchedRule.name}`;
                                                        } else {
                                                            // Use default distribution
                                                            if (distType === 'individual') {
                                                                const individual = document.getElementById('individualSelect');
                                                                assignedTo = individual.options[individual.selectedIndex]?.text || 'Not selected';
                                                                distributionMethod = 'Individual Assignment';
                                                            } else if (distType === 'team') {
                                                                const team = document.getElementById('teamSelect');
                                                                assignedTo = team.options[team.selectedIndex]?.text || 'Not selected';
                                                                distributionMethod = `Team Assignment (Round Robin: ${roundRobin})`;
                                                            } else if (distType === 'custom') {
                                                                const selectedMembers = [];
                                                                document.querySelectorAll('.custom-member-check:checked').forEach(cb => {
                                                                    selectedMembers.push(cb.nextElementSibling.textContent);
                                                                });
                                                                document.querySelectorAll('.custom-team-check:checked').forEach(cb => {
                                                                    selectedMembers.push(cb.nextElementSibling.textContent + ' Team');
                                                                });
                                                                assignedTo = selectedMembers.length > 0 ? selectedMembers.join(', ') : 'None selected';
                                                                distributionMethod = `Custom Assignment (Round Robin: ${roundRobin})`;
                                                            }
                                                        }
                                                    }

                                                    // Build simulation result
                                                    const timeUnit = demoMode ? 'seconds' : 'minutes';
                                                    const timeValue = demoMode ? responseTime : responseTime;

                                                    let resultHTML = `
                                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                            <h6 class="alert-heading"><i class="fas fa-vial me-2"></i>Lead Simulation Result</h6>
                                                            <hr>
                                                            <p class="mb-1"><strong>Source:</strong> ${simSource.charAt(0).toUpperCase() + simSource.slice(1)}</p>
                                                            <p class="mb-1"><strong>Vehicle:</strong> ${simVehicle.charAt(0).toUpperCase() + simVehicle.slice(1)} - ${simMakeModel}</p>
                                                            <p class="mb-1"><strong>Distribution Method:</strong> ${distributionMethod}</p>
                                                            <p class="mb-1"><strong>Assigned To:</strong> ${assignedTo}</p>
                                                            <p class="mb-1"><strong>Response Timeout:</strong> ${timeValue} ${timeUnit}</p>
                                                            <p class="mb-1"><strong>Reassignment Cycles:</strong> ${reassignmentCount}</p>
                                                            <p class="mb-1"><strong>Fallback Manager:</strong> ${document.getElementById('fallbackUser').options[document.getElementById('fallbackUser').selectedIndex]?.text || 'Not selected'}</p>
                                                            ${demoMode ? '<p class="mb-0 mt-2"><span class="badge bg-warning text-dark">Demo Mode Active</span></p>' : ''}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    `;

                                                    document.getElementById('notifications').innerHTML = resultHTML;

                                                    showNotification('Lead simulation completed!', 'success');
                                                }

                                                // Show notification helper
                                                function showNotification(message, type = 'info') {
                                                    const notification = document.createElement('div');
                                                    notification.className = `alert alert-${type} alert-dismissible fade show`;
                                                    notification.style.position = 'fixed';
                                                    notification.style.top = '20px';
                                                    notification.style.right = '20px';
                                                    notification.style.zIndex = '9999';
                                                    notification.style.minWidth = '300px';
                                                    notification.style.maxWidth = '500px';
                                                    notification.innerHTML = `
                                                        ${message}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    `;

                                                    document.body.appendChild(notification);

                                                    // Auto remove after 4 seconds
                                                    setTimeout(() => {
                                                        notification.classList.remove('show');
                                                        setTimeout(() => notification.remove(), 150);
                                                    }, 4000);
                                                }

                                                // Initialize on page load
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // Trigger the change event to set initial state
                                                    document.getElementById('distType').dispatchEvent(new Event('change'));

                                                    // Initialize team dropdown with default options
                                                    updateMembersDropdown();

                                                    // Backend-controlled email settings (hidden from UI)
                                                    const emailSettings = {
                                                        dailyLimit: 100,
                                                        retryAttempts: 3,
                                                        trackOpens: true,
                                                        trackClicks: true
                                                    };

                                                    console.log('Email settings (backend-controlled):', emailSettings);

                                                    // Initialize rules display
                                                    displayRules();
                                                });
                                            </script>

                                            <!-- Simulation & Testing -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-vial me-2"></i>Simulate Incoming Lead (Test
                                                    Rules)</h4>
                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Lead Source</label>
                                                        <select id="simSource" class="primus-crm-form-control">
                                                            <option value="facebook">Facebook</option>
                                                            <option value="google">Google Ads</option>
                                                            <option value="kijiji">Kijiji</option>
                                                            <option value="website">Website</option>
                                                            <option value="referral">Referral</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Vehicle Type</label>
                                                        <select id="simVehicle" class="primus-crm-form-control">
                                                            <option value="new">New</option>
                                                            <option value="used">Used</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Make / Model</label>
                                                        <input id="simMakeModel" type="text"
                                                            class="primus-crm-form-control"
                                                            placeholder="e.g. Honda Civic">
                                                    </div>
                                                </div>

                                                <!-- <div class="primus-crm-form-group mt-2">
                                                    <label class="primus-crm-form-label">Demo Mode (minutes →
                                                        seconds)</label>
                                                    <div class="primus-crm-setting-row">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-desc">Enable for quick
                                                                testing</div>
                                                        </div>
                                                        <input id="demoMode" type="checkbox" />
                                                    </div>
                                                </div> -->

                                                <div class="text-end mt-3">
                                                    <button id="simulateLeadBtn"
                                                        class="primus-crm-btn primus-crm-btn-secondary btn btn-primary"
                                                        onclick="simulateLead()">
                                                        Simulate Lead
                                                    </button>
                                                </div>

                                                <div id="notifications" class="mt-3"></div>
                                            </div>
                                        </div>
                                    </div>



                                    <style>
                                        /* Additional styles for better UI */


                                        .primus-crm-checkbox-list .form-check:hover {
                                            background-color: #f8f9fa;
                                        }

                                        #rulesList .list-group-item {
                                            margin-bottom: 10px;
                                            border-radius: 8px;
                                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                                        }

                                        #rulesList .list-group-item:hover {
                                            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                                        }

                                        .primus-crm-toggle-switch {
                                            width: 50px;
                                            height: 26px;
                                            background-color: #ccc;
                                            border-radius: 13px;
                                            position: relative;
                                            cursor: pointer;
                                            transition: background-color 0.3s;
                                        }

                                        .primus-crm-toggle-switch::after {
                                            content: '';
                                            position: absolute;
                                            width: 22px;
                                            height: 22px;
                                            background-color: white;
                                            border-radius: 50%;
                                            top: 2px;
                                            left: 2px;
                                            transition: left 0.3s;
                                        }

                                        .primus-crm-toggle-switch.active {
                                            background-color: var(--cf-primary);
                                        }


                                        #ruleMembers {
                                            min-height: 150px;
                                        }
                                    </style>
                                    <!-- Email footer Tab -->

                                    <div class="tab-pane fade" id="email-footer-configuration-tab" role="tabpanel"
                                        aria-labelledby="email-footer-configuration-tab">

                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Email Header/Footer Configuration
                                            </h2>
                                            <p class="primus-crm-content-description">Configure the header and
                                                footer that appear in all outgoing emails.</p>
                                        </div>

                                        <!-- HEADER LOGO SECTION -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-image"></i></span>
                                                Email Header
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Include company logo in
                                                        header</div>
                                                    <div class="primus-crm-setting-desc">Add dealership logo to
                                                        email header</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch active" id="headerLogoToggle"
                                                    onclick="toggleHeaderLogo(this)"></div>
                                            </div>

                                            <!-- Header Logo Upload (visible when toggle is ON) -->
                                            <div id="headerLogoUploadSection" class="primus-crm-logo-upload-section"
                                                style="margin-top: 20px;">
                                                <label class="primus-crm-form-label">Upload Header Logo</label>
                                                <div class="primus-crm-file-upload-wrapper">
                                                    <input type="file" id="headerLogoInput" accept="image/*"
                                                        onchange="previewHeaderLogo(event)" style="display: none;">
                                                    <button type="button"
                                                        class="primus-crm-btn primus-crm-btn-secondary"
                                                        onclick="document.getElementById('headerLogoInput').click()">
                                                        <i class="fas fa-upload"></i> Browse
                                                    </button>
                                                    <span id="headerLogoFileName"
                                                        style="margin-left: 10px; color: #64748b;">No file
                                                        chosen</span>
                                                </div>
                                                <div id="headerLogoPreview"
                                                    style="margin-top: 15px; display: none;">
                                                    <img id="headerLogoPreviewImg" src="" alt="Header Logo Preview"
                                                        style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FOOTER LOGO SECTION -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-image"></i></span>
                                                Email Footer
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Include company logo in
                                                        footer</div>
                                                    <div class="primus-crm-setting-desc">Add dealership logo to
                                                        email footer</div>
                                                </div>
                                                <div class="primus-crm-toggle-switch" id="footerLogoToggle"
                                                    onclick="this.classList.toggle('active')"></div>
                                            </div>
                                            <!-- Header Logo Upload (visible when toggle is ON) -->
                                            <div id="FooterLogoUploadSection" class="primus-crm-logo-upload-section"
                                                style="margin-top: 20px;">
                                                <label class="primus-crm-form-label">Upload Footer Logo</label>
                                                <div class="primus-crm-file-upload-wrapper">
                                                    <input type="file" id="FooterLogoInput" accept="image/*"
                                                        onchange="previewFooterLogo(event)" style="display: none;">
                                                    <button type="button"
                                                        class="primus-crm-btn primus-crm-btn-secondary"
                                                        onclick="document.getElementById('FooterLogoInput').click()">
                                                        <i class="fas fa-upload"></i> Browse
                                                    </button>
                                                    <span id="FooterLogoFileName"
                                                        style="margin-left: 10px; color: #64748b;">No file
                                                        chosen</span>
                                                </div>
                                                <div id="FooterLogoPreview"
                                                    style="margin-top: 15px; display: none;">
                                                    <img id="FooterLogoPreviewImg" src="" alt="Footer Logo Preview"
                                                        style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SOCIAL MEDIA SECTION -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-share-alt"></i></span>
                                                Social Media Links
                                            </h3>
                                            <div class="primus-crm-social-media-grid">
                                                <div class="primus-crm-social-icon" data-platform="facebook"
                                                    onclick="openSocialModal('facebook')" title="Facebook">
                                                    <i class="fab fa-facebook-f"></i>
                                                </div>
                                                <div class="primus-crm-social-icon" data-platform="instagram"
                                                    onclick="openSocialModal('instagram')" title="Instagram">
                                                    <i class="fab fa-instagram"></i>
                                                </div>
                                                <div class="primus-crm-social-icon" data-platform="twitter"
                                                    onclick="openSocialModal('twitter')" title="Twitter/X">
                                                    <i class="fab fa-x-twitter"></i>
                                                </div>
                                                <div class="primus-crm-social-icon" data-platform="youtube"
                                                    onclick="openSocialModal('youtube')" title="YouTube">
                                                    <i class="fab fa-youtube"></i>
                                                </div>
                                                <div class="primus-crm-social-icon" data-platform="reddit"
                                                    onclick="openSocialModal('reddit')" title="Reddit">
                                                    <i class="fab fa-reddit-alien"></i>
                                                </div>
                                            </div>
                                        </div>









                                        <!-- CONFIDENTIALITY NOTICE -->
                                        <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                            <label class="primus-crm-form-label">Confidentiality Notice</label>
                                            <textarea
                                                class="primus-crm-form-control primus-crm-confidentiality-text"
                                                rows="4"
                                                style="font-size: 10px; color: #000000;">CONFIDENTIALITY NOTICE: This email and any attachments are for the exclusive and confidential use of the intended recipient. If you are not the intended recipient, please do not read, distribute, or take action based on this message. If you have received this in error, please notify us immediately and delete this email.</textarea>
                                        </div>

                                    </div>

                                    <!-- SOCIAL MEDIA MODAL -->
                                    <div id="socialMediaModal" class="primus-crm-modal" style="display: none;">
                                        <div class="primus-crm-modal-content" style="max-width: 500px;">
                                            <div class="primus-crm-modal-header">
                                                <h3 id="socialModalTitle">Add Social Media Link</h3>
                                                <span class="primus-crm-modal-close"
                                                    onclick="closeSocialModal()">&times;</span>
                                            </div>
                                            <div class="primus-crm-modal-body">
                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label"
                                                        id="socialModalLabel">Facebook URL</label>
                                                    <input type="url" id="socialMediaUrl"
                                                        class="primus-crm-form-control"
                                                        placeholder="https://facebook.com/yourpage">
                                                </div>
                                            </div>
                                            <div class="primus-crm-modal-footer">
                                                <button type="button"
                                                    class="primus-crm-btn primus-crm-btn-secondary"
                                                    onclick="closeSocialModal()">Cancel</button>
                                                <button type="button" class="primus-crm-btn primus-crm-btn-primary"
                                                    onclick="saveSocialLink()">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Holiday Modal -->

                                    <style>
                                        /* Social Media Grid Styles */
                                        .primus-crm-social-media-grid {
                                            display: flex;
                                            gap: 15px;
                                            flex-wrap: wrap;
                                            margin-top: 15px;
                                        }

                                        .primus-crm-social-icon {
                                            width: 50px;
                                            height: 50px;
                                            border-radius: 8px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 24px;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            border: 2px solid #e2e8f0;
                                            background: #f8f9fa;
                                            color: #cbd5e1;
                                            position: relative;
                                        }

                                        .primus-crm-social-icon:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                        }

                                        .primus-crm-social-icon.active {
                                            border-color: #3b82f6;
                                        }

                                        .primus-crm-social-icon[data-platform="facebook"].active {
                                            color: #1877f2;
                                            background: #e7f3ff;
                                        }

                                        .primus-crm-social-icon[data-platform="instagram"].active {
                                            color: #e4405f;
                                            background: #ffe7ec;
                                        }

                                        .primus-crm-social-icon[data-platform="twitter"].active {
                                            color: #000000;
                                            background: #e7e7e7;
                                        }

                                        .primus-crm-social-icon[data-platform="youtube"].active {
                                            color: #ff0000;
                                            background: #ffe7e7;
                                        }

                                        .primus-crm-social-icon[data-platform="reddit"].active {
                                            color: #ff4500;
                                            background: #fff0e7;
                                        }

                                        /* Modal Styles */
                                        .primus-crm-modal {
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background: rgba(0, 0, 0, 0.5);
                                            z-index: 10000;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }

                                        .primus-crm-modal-content {
                                            background: white;
                                            border-radius: 8px;
                                            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                                            width: 90%;
                                            max-width: 500px;
                                        }

                                        .primus-crm-modal-header {
                                            padding: 20px;
                                            border-bottom: 1px solid #e2e8f0;
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                        }

                                        .primus-crm-modal-header h3 {
                                            margin: 0;
                                            font-size: 18px;
                                            font-weight: 600;
                                        }

                                        .primus-crm-modal-close {
                                            font-size: 28px;
                                            cursor: pointer;
                                            color: #64748b;
                                            line-height: 1;
                                        }

                                        .primus-crm-modal-close:hover {
                                            color: #1e293b;
                                        }

                                        .primus-crm-modal-body {
                                            padding: 20px;
                                        }

                                        .primus-crm-modal-footer {
                                            padding: 20px;
                                            border-top: 1px solid #e2e8f0;
                                            display: flex;
                                            justify-content: flex-end;
                                            gap: 10px;
                                        }

                                        /* Logo Upload Section */
                                        .primus-crm-logo-upload-section {
                                            padding: 15px;
                                            background: #f8f9fa;
                                            border-radius: 6px;
                                            border: 1px solid #e2e8f0;
                                        }

                                        .primus-crm-file-upload-wrapper {
                                            display: flex;
                                            align-items: center;
                                        }

                                        .primus-crm-btn {
                                            padding: 8px 16px;
                                            border-radius: 6px;
                                            border: none;
                                            cursor: pointer;
                                            font-size: 14px;
                                            font-weight: 500;
                                            transition: all 0.2s;
                                        }

                                        .primus-crm-btn-secondary {
                                            background: #f1f5f9;
                                            color: #475569;
                                            border: 1px solid #cbd5e1;
                                        }

                                        .primus-crm-btn-secondary:hover {
                                            background: #e2e8f0;
                                        }

                                        .primus-crm-btn-primary {
                                            background: #3b82f6;
                                            color: white;
                                        }

                                        .primus-crm-btn-primary:hover {
                                            background: #2563eb;
                                        }

                                        /* Confidentiality Text Styling */
                                        .primus-crm-confidentiality-text {
                                            font-size: 10px !important;
                                            color: #000000 !important;
                                            line-height: 1.4;
                                        }
                                    </style>

                                    <script>
                                        // Store social media links
                                        const socialMediaLinks = {
                                            facebook: '',
                                            instagram: '',
                                            twitter: '',
                                            youtube: '',
                                            reddit: ''
                                        };

                                        let currentSocialPlatform = '';

                                        // Toggle Header Logo Upload Section
                                        function toggleHeaderLogo(element) {
                                            element.classList.toggle('active');
                                            const uploadSection = document.getElementById('headerLogoUploadSection');

                                            if (element.classList.contains('active')) {
                                                uploadSection.style.display = 'block';
                                            } else {
                                                uploadSection.style.display = 'none';
                                            }
                                        }

                                        // Preview Header Logo
                                        function previewHeaderLogo(event) {
                                            const file = event.target.files[0];
                                            if (file) {
                                                document.getElementById('headerLogoFileName').textContent = file.name;

                                                const reader = new FileReader();
                                                reader.onload = function (e) {
                                                    const preview = document.getElementById('headerLogoPreview');
                                                    const img = document.getElementById('headerLogoPreviewImg');
                                                    img.src = e.target.result;
                                                    preview.style.display = 'block';
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        }

                                        // Open Social Media Modal
                                        function openSocialModal(platform) {
                                            currentSocialPlatform = platform;
                                            const modal = document.getElementById('socialMediaModal');
                                            const title = document.getElementById('socialModalTitle');
                                            const label = document.getElementById('socialModalLabel');
                                            const input = document.getElementById('socialMediaUrl');

                                            // Capitalize platform name
                                            const platformName = platform.charAt(0).toUpperCase() + platform.slice(1);
                                            if (platform === 'twitter') {
                                                title.textContent = 'Twitter/X URL';
                                                label.textContent = 'Twitter/X URL';
                                            } else {
                                                title.textContent = platformName + ' URL';
                                                label.textContent = platformName + ' URL';
                                            }

                                            // Set current value
                                            input.value = socialMediaLinks[platform] || '';

                                            modal.style.display = 'flex';
                                        }

                                        // Close Social Media Modal
                                        function closeSocialModal() {
                                            document.getElementById('socialMediaModal').style.display = 'none';
                                            currentSocialPlatform = '';
                                        }

                                        // Save Social Media Link
                                        function saveSocialLink() {
                                            const url = document.getElementById('socialMediaUrl').value.trim();
                                            const icon = document.querySelector(`.primus-crm-social-icon[data-platform="${currentSocialPlatform}"]`);

                                            socialMediaLinks[currentSocialPlatform] = url;

                                            if (url) {
                                                icon.classList.add('active');
                                            } else {
                                                icon.classList.remove('active');
                                            }

                                            closeSocialModal();
                                        }

                                        // Close modal on outside click
                                        window.onclick = function (event) {
                                            const modal = document.getElementById('socialMediaModal');
                                            if (event.target === modal) {
                                                closeSocialModal();
                                            }
                                        }

                                        // Initialize: Show header logo upload section by default (toggle is ON)
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const headerLogoSection = document.getElementById('headerLogoUploadSection');
                                            if (headerLogoSection) {
                                                headerLogoSection.style.display = 'block';
                                            }
                                        });
                                    </script>
                                </div>
                        </div>

                        <div class="primus-crm-actions-footer">
                            <div id="primusCrmSuccessMessage" class="primus-crm-success-alert primus-crm-hidden">
                                <i class="fas fa-check-circle"></i>
                                <span>Settings saved successfully!</span>
                            </div>
                            <button class="primus-crm-btn-save" id="primusCrmSaveBtn">
                                <i class="fas fa-save"></i>
                                <span id="primusCrmSaveBtnText">Save Changes</span>
                            </button>
                        </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
        {{-- Setting end --}}


<script>
    // Initialize Bootstrap tabs and basic functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tabs if available
        if (typeof bootstrap !== 'undefined') {
            var triggerTabList = [].slice.call(document.querySelectorAll('#primusCrmSettingsNav button'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        }

        // Save button functionality
        document.getElementById('primusCrmSaveBtn').addEventListener('click', function () {
            const saveBtn = document.getElementById('primusCrmSaveBtn');
            const saveBtnText = document.getElementById('primusCrmSaveBtnText');
            const successMessage = document.getElementById('primusCrmSuccessMessage');

            saveBtn.disabled = true;
            saveBtnText.textContent = 'Saving...';

            setTimeout(() => {
                saveBtn.disabled = false;
                saveBtnText.textContent = 'Save Changes';
                successMessage.classList.remove('primus-crm-hidden');

                setTimeout(() => {
                    successMessage.classList.add('primus-crm-hidden');
                }, 3000);
            }, 1000);
        });

        // Search functionality
        document.getElementById('primusCrmSearchInput').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const navItems = document.querySelectorAll('#primusCrmSettingsNav .nav-item');

            navItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Toggle switch functionality
        document.querySelectorAll('.primus-crm-toggle-switch').forEach(toggle => {
            toggle.addEventListener('click', function () {
                this.classList.toggle('active');
            });
        });
    });

    // Lead Process Management System
    (function () {
        // ---------- sample users (replace by real data in backend) ----------
        const USERS = [
            { id: 'u1', name: 'Ali Khan', team: 'sales', managerId: 'm1' },
            { id: 'u2', name: 'Sara Ali', team: 'sales', managerId: 'm1' },
            { id: 'u3', name: 'Omar Rehman', team: 'sales', managerId: 'm1' },
            { id: 'u4', name: 'Nadia Noor', team: 'support', managerId: 'm2' },
        ];
        const MANAGERS = [
            { id: 'm1', name: 'Manager - John Smith' },
            { id: 'm2', name: 'Manager - Sarah Khan' },
        ];

        // ---------- persistent storage helpers ----------
        const STORAGE_KEYS = { RULES: 'primus_rules_v1', ROTATIONS: 'primus_rotations_v1' };
        const readJSON = (k) => JSON.parse(localStorage.getItem(k) || '[]');
        const saveJSON = (k, v) => localStorage.setItem(k, JSON.stringify(v));

        // ---------- UI elements ----------
        const teamMembersEl = document.getElementById('teamMembers');
        const ruleMembersEl = document.getElementById('ruleMembers');
        const fallbackUserEl = document.getElementById('fallbackUser');
        const addRuleBtn = document.getElementById('addRuleBtn');
        const rulesListEl = document.getElementById('rulesList');
        const simulateBtn = document.getElementById('simulateLeadBtn');
        const notificationsEl = document.getElementById('notifications');
        const distTypeEl = document.getElementById('distType');
        const roundRobinEl = document.getElementById('roundRobin');
        const selectAllToggle = document.getElementById('selectAllToggle');

        // ---------- initialize UI lists ----------
        function populateUserSelects() {
            // teamMembers & ruleMembers
            [teamMembersEl, ruleMembersEl].forEach(sel => {
                sel.innerHTML = '';
                USERS.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name + ' (' + u.team + ')';
                    sel.appendChild(opt);
                });
            });

            // fallback managers
            fallbackUserEl.innerHTML = '';
            const choose = document.createElement('option');
            choose.textContent = 'Choose Fallback User';
            choose.value = '';
            choose.selected = true;
            fallbackUserEl.appendChild(choose);
            MANAGERS.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.id;
                opt.textContent = m.name;
                fallbackUserEl.appendChild(opt);
            });
        }

        // ---------- rules management ----------
        function loadRules() { return readJSON(STORAGE_KEYS.RULES) || []; }
        function saveRules(rules) { saveJSON(STORAGE_KEYS.RULES, rules); }
        function loadRotations() { return JSON.parse(localStorage.getItem(STORAGE_KEYS.ROTATIONS) || '{}'); }
        function saveRotations(rot) { localStorage.setItem(STORAGE_KEYS.ROTATIONS, JSON.stringify(rot)); }

        function renderRules() {
            const rules = loadRules();
            rulesListEl.innerHTML = '';
            if (!rules.length) {
                rulesListEl.innerHTML = '<div class="primus-crm-form-help">No rules yet</div>';
                return;
            }
            rules.forEach((r, idx) => {
                const wrap = document.createElement('div');
                wrap.className = 'border p-2 mb-2';
                wrap.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong>${r.name}</strong> <small>[${r.enabled ? 'Enabled' : 'Disabled'}]</small><br>
                            <small>${r.source} • ${r.vehicle || 'Any'} • members: ${(r.members || []).map(id => userName(id)).join(', ') || '—'}</small>
                        </div>
                        <div>
                            <button data-idx="${idx}" class="primus-crm-btn primus-crm-btn-secondary btn-test">Test</button>
                            <button data-idx="${idx}" class="primus-crm-btn primus-crm-btn-tertiary btn-delete">Delete</button>
                        </div>
                    </div>
                `;
                rulesListEl.appendChild(wrap);
            });

            // attach listeners
            rulesListEl.querySelectorAll('.btn-delete').forEach(b => {
                b.addEventListener('click', () => {
                    const idx = +b.getAttribute('data-idx');
                    const rules = loadRules();
                    rules.splice(idx, 1);
                    saveRules(rules);
                    renderRules();
                    notify('Rule deleted');
                });
            });
            rulesListEl.querySelectorAll('.btn-test').forEach(b => {
                b.addEventListener('click', () => {
                    const idx = +b.getAttribute('data-idx');
                    const rules = loadRules();
                    const r = rules[idx];
                    simulateLead({ source: r.source, vehicle: r.vehicle === 'any' ? 'new' : r.vehicle, makeModel: r.makeModel || '' }, true);
                });
            });
        }

        function userName(id) {
            const u = USERS.find(x => x.id === id);
            return u ? u.name : id;
        }

        // ---------- add rule handler ----------
        addRuleBtn.addEventListener('click', () => {
            const name = document.getElementById('ruleName').value.trim();
            if (!name) {
                return notify('Please provide a rule name', true);
            }
            const rule = {
                id: 'r_' + Date.now(),
                name,
                enabled: document.getElementById('ruleEnable').value === 'yes',
                vehicle: document.getElementById('ruleVehicle').value,
                makeModel: document.getElementById('ruleMakeModel').value.trim(),
                source: document.getElementById('ruleSource').value,
                team: document.getElementById('ruleTeam').value,
                members: Array.from(document.getElementById('ruleMembers').selectedOptions).map(o => o.value)
            };

            // if select-all toggle active, assign all users of that team
            if (selectAllToggle.classList.contains('active')) {
                rule.members = USERS.filter(u => u.team === rule.team).map(u => u.id);
            }

            const rules = loadRules();
            rules.unshift(rule);
            saveRules(rules);
            renderRules();
            notify('Rule added');
            // clear some inputs
            document.getElementById('ruleName').value = '';
            document.getElementById('ruleMakeModel').value = '';
        });

        // ---------- simulations / matching ----------
        document.getElementById('simulateLeadBtn').addEventListener('click', () => {
            const lead = {
                source: document.getElementById('simSource').value,
                vehicle: document.getElementById('simVehicle').value,
                makeModel: document.getElementById('simMakeModel').value.trim()
            };
            simulateLead(lead, false);
        });

        function simulateLead(lead, isTest) {
            notify(`Incoming lead — source: ${lead.source}, vehicle: ${lead.vehicle}, make/model: "${lead.makeModel}"`);
            // find first matching rule
            const rules = loadRules();
            const matched = rules.find(r => {
                if (!r.enabled) return false;
                if (r.source && r.source !== lead.source) return false;
                if (r.vehicle && r.vehicle !== 'any' && r.vehicle !== lead.vehicle) return false;
                if (r.makeModel && r.makeModel.length) {
                    return lead.makeModel.toLowerCase().includes(r.makeModel.toLowerCase());
                }
                return true;
            });

            if (matched) {
                notify('Rule matched: ' + matched.name);
                assignByRule(lead, matched);
            } else {
                notify('No custom rule matched — using default distribution settings');
                const distType = distTypeEl.value;
                const members = Array.from(teamMembersEl.selectedOptions).map(o => o.value);
                const tempRule = {
                    id: 'fallback_rule',
                    name: 'Default distribution',
                    members,
                    roundRobin: roundRobinEl.value === 'yes'
                };
                assignByRule(lead, tempRule);
            }
        }

        // ---------- assignment & round-robin ----------
        function assignByRule(lead, rule) {
            // rule may be a saved rule object or temp with members
            const members = rule.members || [];
            if (!members.length && (distTypeEl.value === 'individual' || distTypeEl.value === 'custom')) {
                notify('No members selected to assign to!', true);
                return;
            }

            const isRoundRobin = (roundRobinEl.value === 'yes') || (rule.roundRobin === true);
            if (distTypeEl.value === 'team') {
                // Team: mark assigned to team (all members notified)
                members.forEach(id => createAssignment(lead, id, rule, false));
                notify('Assigned to team members: ' + members.map(userName).join(', '));
                return;
            }

            if (!isRoundRobin) {
                // Individual or custom but no RR: assign to first member
                const assignee = members[0];
                createAssignment(lead, assignee, rule, true);
                return;
            }

            // Round robin path
            const rotations = loadRotations();
            const rotKey = rule.id;
            const list = members.slice(); // copy
            if (!rotations[rotKey]) rotations[rotKey] = { index: 0 };
            const idx = rotations[rotKey].index % list.length;
            const assignee = list[idx];
            // advance rotation for next time
            rotations[rotKey].index = (rotations[rotKey].index + 1) % list.length;
            saveRotations(rotations);
            createAssignment(lead, assignee, rule, true);
            notify('Round-robin assigned to ' + userName(assignee));
        }

        // ---------- create assignment + response-time handling ----------
        function createAssignment(lead, assigneeId, rule, startTimer) {
            const assignId = 'a_' + Date.now();
            const assignment = {
                id: assignId,
                lead,
                assigneeId,
                ruleId: rule.id || 'default',
                assignedAt: Date.now(),
                responded: false,
                cycleCount: 0
            };
            // show assignment in notifications
            notify(`Assigned lead to ${userName(assigneeId)} (rule: ${rule.name || rule.id})`);
            // start timeout timer if required (simulate demo scaling)
            if (startTimer) {
                const responseMinutes = Number(document.getElementById('responseTime').value) || 5;
                const demo = document.getElementById('demoMode').checked;
                const ms = demo ? (responseMinutes * 1000) : (responseMinutes * 60000);
                // store assignment in memory (simple)
                assignment.timeoutId = setTimeout(() => {
                    if (!assignment.responded) {
                        notify(`${userName(assigneeId)} did not respond within ${responseMinutes} minute(s). Auto-reassigning...`);
                        handleReassign(assignment, rule);
                    }
                }, ms);
            }
            // setup reminders if enabled
            if (document.getElementById('alertsToggle').classList.contains('active')) {
                startReminders(assignment);
            }
            // display an actionable button for debugging (respond)
            showAssignmentAction(assignment);
        }

        function showAssignmentAction(assignment) {
            const el = document.createElement('div');
            el.className = 'border p-2 mb-2';
            el.innerHTML = `
                <div><strong>Assignment:</strong> ${userName(assignment.assigneeId)} — ${assignment.lead.source} / ${assignment.lead.vehicle} ${assignment.lead.makeModel ? ' / ' + assignment.lead.makeModel : ''}</div>
                <div style="margin-top:6px;">
                    <button class="primus-crm-btn primus-crm-btn-primary btn-respond">Mark Responded</button>
                    <button class="primus-crm-btn primus-crm-btn-tertiary btn-escalate">Escalate Now</button>
                </div>
            `;
            notificationsEl.prepend(el);
            el.querySelector('.btn-respond').addEventListener('click', () => {
                assignment.responded = true;
                if (assignment.timeoutId) clearTimeout(assignment.timeoutId);
                notify(`${userName(assignment.assigneeId)} marked as responded — assignment closed.`);
            });
            el.querySelector('.btn-escalate').addEventListener('click', () => {
                if (assignment.timeoutId) clearTimeout(assignment.timeoutId);
                notify('Manually escalating assignment to fallback user.');
                escalateToFallback(assignment);
            });
        }

        // ---------- reassign logic ----------
        function handleReassign(assignment, rule) {
            const cyclesAllowed = Number(document.getElementById('reassignmentCount').value) || 3;
            const demo = document.getElementById('demoMode').checked;
            // pick next user in members (if round-robin) else rotate index by cycleCount
            const members = rule.members || Array.from(teamMembersEl.selectedOptions).map(o => o.value);
            if (!members || !members.length) {
                notify('No members to reassign to. Escalating to fallback.');
                escalateToFallback(assignment);
                return;
            }

            // maintain a counter in assignment
            assignment.cycleCount = (assignment.cycleCount || 0) + 1;
            // determine if cycles exhausted: cyclesAllowed means full cycles through members
            const rotations = loadRotations();
            // if rule has rotation state use it, else shift to next
            const rotKey = rule.id || 'default';
            if (!rotations[rotKey]) rotations[rotKey] = { index: 0, cycles: 0 };
            // advance index to next
            rotations[rotKey].index = (rotations[rotKey].index + 1) % members.length;
            if (rotations[rotKey].index === 0) rotations[rotKey].cycles = (rotations[rotKey].cycles || 0) + 1;
            saveRotations(rotations);

            if ((rotations[rotKey].cycles || 0) >= cyclesAllowed) {
                // escalate to fallback
                notify('Reassignment cycles exhausted. Triggering fallback/escalation.');
                escalateToFallback(assignment);
                return;
            }

            // assign to next member
            const nextAssignee = members[rotations[rotKey].index];
            notify('Auto-reassigned to ' + userName(nextAssignee));
            createAssignment(assignment.lead, nextAssignee, rule, true);
        }

        function escalateToFallback(assignment) {
            const fallbackId = document.getElementById('fallbackUser').value;
            if (!fallbackId) {
                notify('No fallback user selected; please configure one.', true);
                return;
            }
            // notify manager
            notify('Escalated to fallback manager: ' + MANAGERS.find(m => m.id === fallbackId).name);
            if (document.getElementById('managerNotifToggle').classList.contains('active')) {
                // show explicit manager notification
                notify('Manager notified via bell. (Email simulation not implemented here)');
            }
        }

        // ---------- reminders ----------
        function startReminders(assignment) {
            const freq = Number(document.getElementById('alertFrequency').value) || 5;
            const repeat = Number(document.getElementById('alertRepeat').value) || 4;
            const demo = document.getElementById('demoMode').checked;
            const ms = demo ? (freq * 1000) : (freq * 60000);
            let sent = 0;
            const reminderId = setInterval(() => {
                if (assignment.responded || sent >= repeat) {
                    clearInterval(reminderId);
                    return;
                }
                sent++;
                notify(`Reminder #${sent} → ${userName(assignment.assigneeId)} to respond to lead.`);
            }, ms);
        }

        // ---------- small helpers ----------
        function notify(msg, isError) {
            const d = document.createElement('div');
            d.style.padding = '6px';
            d.style.marginBottom = '6px';
            d.style.borderRadius = '6px';
            d.style.background = isError ? '#fdecea' : '#f1f6ff';
            d.textContent = '[' + new Date().toLocaleTimeString() + '] ' + msg;
            notificationsEl.prepend(d);
        }

        // ---------- team selection update ----------
        document.getElementById('ruleTeam').addEventListener('change', (e) => {
            const team = e.target.value;
            // auto-select members of team in ruleMembers
            Array.from(ruleMembersEl.options).forEach(opt => {
                opt.selected = (team && USERS.find(u => u.id === opt.value && u.team === team) != null);
            });
        });

        // select all toggle functionality
        selectAllToggle.addEventListener('click', () => {
            selectAllToggle.classList.toggle('active');
            if (selectAllToggle.classList.contains('active')) {
                // select all members of currently selected team
                const team = document.getElementById('ruleTeam').value;
                Array.from(ruleMembersEl.options).forEach(opt => {
                    opt.selected = (team ? USERS.find(u => u.id === opt.value && u.team === team) != null : true);
                });
            } else {
                Array.from(ruleMembersEl.options).forEach(opt => opt.selected = false);
            }
        });

        // ---------- initial population ----------
        populateUserSelects();
        renderRules();

        // expose some helpers for console debug (optional)
        window.__primus_debug = { loadRules, saveRules, loadRotations, saveRotations };

    })();
</script>



<div id="holidayModal" class="primus-crm-holiday-modal" style="display: none;">
    <div class="primus-crm-holiday-modal-content">
        <div class="primus-crm-holiday-modal-header">
            <h3>Add Holiday Override</h3>
            <span class="primus-crm-holiday-modal-close" onclick="closeHolidayModal()">&times;</span>
        </div>
        <div class="primus-crm-holiday-modal-body">
            <div class="primus-crm-form-group">
                <label>Holiday Name</label>
                <input type="text" id="holidayName" class="primus-crm-form-control"
                    placeholder="e.g., Christmas Day, Store Event">
            </div>
            <div class="primus-crm-form-group">
                <label>Select Date</label>
                <input type="text" id="holidayDate" class="form-control mb-2 cf-datepicker"
                    placeholder="Click to select date" readonly>
            </div>
            <div class="primus-crm-form-group">
                <label class="primus-crm-custom-checkbox">
                    <input type="checkbox" id="holidayClosed" onchange="toggleHolidayHours(this)">
                    <span>Store Closed</span>
                </label>
            </div>
            <div id="holidayHoursSection">
                <div class="primus-crm-form-group">
                    <label>Custom Hours</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <select class="primus-crm-time-dropdown" id="holidayStartTime">
                            <option value="">Start Time</option>
                        </select>
                        <span>to</span>
                        <select class="primus-crm-time-dropdown" id="holidayEndTime">
                            <option value="">End Time</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="primus-crm-holiday-modal-footer">
            <button type="button" class="primus-crm-btn primus-crm-btn-secondary"
                onclick="closeHolidayModal()">Cancel</button>
            <button type="button" class="primus-crm-btn primus-crm-btn-primary" onclick="saveHoliday()">Save
                Holiday</button>
        </div>
    </div>
</div>

@endsection



@push('styles')


<style>
    .primus-crm-main-content,
   .tab-content,
   .tab-pane,
   .primus-crm-settings-section {
       min-width: 0;
   }
   
   </style>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: rgb(0, 33, 64);
            /* Deep blue */
            --primary-dark: rgb(0, 28, 51);
            /* Darker blue */
            --primary-light: rgb(102, 132, 175);
            /* Light muted blue */
            --secondary: rgb(36, 123, 160);
            /* Muted blue-gray */
            --success: rgb(40, 167, 69);
            /* Soft green */
            --danger: rgb(220, 53, 69);
            /* Soft red */
            --warning: rgb(255, 193, 7);
            /* Warm yellow */
            --bg-light: #f1f5f9;
            /* Light grayish background */
            --bg-card: #ffffff;
            /* White for cards */
            --text-primary: #1e293b;
            /* Dark grayish blue for text */
            --text-secondary: #475569;
            /* Muted grayish blue */
            --border: #d1d5db;
            /* Light gray border */
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .search-area button {
            width: 40px
        }

        .nav-tabs .nav-link {
            width: 100%;
            border: none !important;
            border-top-left-radius: 8px !important;
            border-top-right-radius: 8px !important;

            text-align: left;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--cf-primary) !important;
            color: #fff !important;
        }

        .nav-tabs .nav-link.active i {
            color: #fff !important;
        }

        body.dark-mode {
            --bg-light: #0f172a;
            --bg-card: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: #334155;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .primus-crm-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .dark-mode .primus-crm-header {
            background: rgba(30, 41, 59, 0.95);
            border-bottom-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-logo {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .primus-crm-header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .primus-crm-icon-btn {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--bg-light);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .primus-crm-icon-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .primus-crm-notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--bg-card);
            animation: primus-crm-pulse 2s infinite;
        }

        @keyframes primus-crm-pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .primus-crm-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--bg-light);
            border-radius: 12px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .primus-crm-user-info:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .primus-crm-user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .primus-crm-user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .primus-crm-container {
            max-width: 100%;
            margin: 1rem auto;
            padding: 0 2rem;
        }

        .primus-crm-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2rem;
            animation: primus-crm-fadeIn 0.5s ease;
        }

        @keyframes primus-crm-fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .primus-crm-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-xl);
            position: sticky;
            top: 0;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            border: 1px solid #ddd;
        }
@media only screen and (min-width:1600px){
    .primus-crm-sidebar {
        max-height: calc(100vh - 120px) !important;

    }
}
        .dark-mode .primus-crm-sidebar {
            background: rgba(30, 41, 59, 0.95);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-sidebar::-webkit-scrollbar {
            width: 6px;

        }

        .primus-crm-sidebar::-webkit-scrollbar-track {
            background: transparent;
            margin-top: 30px;

        }

        .primus-crm-sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .primus-crm-search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .primus-crm-search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 0.875rem;
            background: var(--bg-light);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .primus-crm-search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .primus-crm-menu-section {
            margin-bottom: 0.5rem;
        }

        .primus-crm-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1rem;
            background: transparent;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .primus-crm-menu-header:hover {
            background: var(--bg-light);
        }

        .primus-crm-menu-header-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .primus-crm-menu-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .primus-crm-menu-arrow {
            transition: transform 0.3s ease;
            color: var(--text-secondary);
        }

        .primus-crm-menu-header.expanded .primus-crm-menu-arrow {
            transform: rotate(90deg);
        }

        .primus-crm-submenu {
            /* margin-left: 3rem; */
            margin-top: 0.25rem;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .primus-crm-submenu.show {
            max-height: 1000px;
        }

        .primus-crm-submenu-item {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-align: left;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }

        .primus-crm-submenu-item:hover {
            background: var(--primary);
            color: #fff;
            transform: translateX(4px);
        }

        .primus-crm-submenu-item.active {
            background: var(--primary);
            color: white;
            font-weight: 500;

        }
        .primus-crm-main-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-xl);
    border: 1px solid #ddd;

    min-height: 600px;

    
    max-width: 100%;
    overflow: hidden;
}

        .dark-mode .primus-crm-main-content {
            background: rgba(30, 41, 59, 0.95);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-content-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }

        .primus-crm-content-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .primus-crm-content-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .primus-crm-settings-section {
            margin-bottom: 2rem;
        }

        .primus-crm-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .primus-crm-section-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
        }

        .primus-crm-subtitle {
            font-size: 18px;
            margin-bottom: 14px !important;
        }

        .primus-crm-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .primus-crm-form-group {
            margin-bottom: 1.5rem;
        }

        .primus-crm-form-group.full-width {
            grid-column: 1 / -1;
        }

        .primus-crm-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .primus-crm-form-help {
            display: block;
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .primus-crm-form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.875rem;
            background: #fff;
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .primus-crm-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background: var(--bg-card);
        }

        .primus-crm-form-control:hover {
            border-color: var(--primary-light);
        }

        textarea.primus-crm-form-control {
            resize: vertical;
            min-height: 100px;
        }

        .primus-crm-toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
            background: var(--border);
            border-radius: 13px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .primus-crm-toggle-switch.active {
            background: var(--primary);
        }

        .primus-crm-toggle-switch::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .primus-crm-toggle-switch.active::after {
            transform: translateX(24px);
        }

        .primus-crm-setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--bg-light);
            border: 2px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .primus-crm-setting-row:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-setting-info {
            flex: 1;
        }

        .primus-crm-setting-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .primus-crm-setting-desc {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .primus-crm-hours-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: var(--bg-light);
            border: 2px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .primus-crm-hours-row:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-day-name {
            font-weight: 600;
            min-width: 120px;
            text-transform: capitalize;
            color: var(--text-primary);
        }

        .primus-crm-custom-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
        }

        .primus-crm-custom-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            position: relative;
        }

        .primus-crm-custom-checkbox input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .primus-crm-custom-checkbox input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.875rem;
        }

        .primus-crm-time-input {
            padding: 0.625rem 0.875rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            background: var(--bg-card);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .primus-crm-time-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .primus-crm-color-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--border);
        }

        .primus-crm-slider-container {
            width: 100%;
        }

        .primus-crm-slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: var(--border);
            outline: none;
            -webkit-appearance: none;
        }

        .primus-crm-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
        }

        .primus-crm-slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            border: none;
        }

        .primus-crm-slider-value {
            display: inline-block;
            margin-left: 1rem;
            font-weight: 600;
            color: var(--primary);
        }

        .primus-crm-actions-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border);
        }

        .primus-crm-btn-save {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.875rem 2rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            /* box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); */
        }

        .primus-crm-btn-save:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 8px 20px rgba(99, 102, 241, 0.5); */
        }

        .primus-crm-btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .primus-crm-success-alert {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1.5rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            animation: primus-crm-slideIn 0.3s ease;
        }

        @keyframes primus-crm-slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .primus-crm-notification-panel {
            position: fixed;
            right: 2rem;
            top: 100px;
            width: 420px;
            max-height: 600px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(226, 232, 240, 0.5);
            overflow: hidden;
            z-index: 200;
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark-mode .primus-crm-notification-panel {
            background: rgba(30, 41, 59, 0.98);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-notification-panel.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .primus-crm-notification-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-notification-title {
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--text-primary);
        }

        .primus-crm-notification-list {
            max-height: 480px;
            overflow-y: auto;
        }

        .primus-crm-notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .primus-crm-notification-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .primus-crm-notification-list::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .primus-crm-notification-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .primus-crm-notification-item:hover {
            background: var(--bg-light);
        }

        .primus-crm-notification-content {
            display: flex;
            gap: 1rem;
        }

        .primus-crm-notification-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .primus-crm-notification-body {
            flex: 1;
        }

        .primus-crm-notification-user {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .primus-crm-notification-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .primus-crm-notification-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-notification-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .primus-crm-btn-dismiss {
            background: transparent;
            border: none;
            color: var(--danger);
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .primus-crm-btn-dismiss:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .primus-crm-hidden {
            display: none !important;
        }

        @media (max-width: 1024px) {
            /* .primus-crm-layout {
              grid-template-columns: 1fr;
          } */

            .primus-crm-sidebar {
                position: static;
                max-height: none;
            }

            .primus-crm-notification-panel {
                width: calc(100% - 4rem);
                right: 2rem;
            }
        }

        @media (max-width: 768px) {
            .primus-crm-header-content {
                padding: 1rem;
            }

            .primus-crm-user-name {
                display: none;
            }

            .primus-crm-container {
                padding: 0 1rem;
            }

            .primus-crm-main-content {
                padding: 1.5rem;
            }

            .primus-crm-form-grid {
                grid-template-columns: 1fr;
            }

            .primus-crm-hours-row {
                flex-wrap: wrap;
            }
        }
    </style>
    


    <style>
        .compare-col {
            border: 1px solid rgb(0, 33, 64);
        }

        .col-title {
            background: rgb(0, 33, 64);
            color: #fff;
            padding: 8px;
            font-weight: 600;
        }

        .compare-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px dashed #e9ecef;
        }

        .compare-field {
            font-size: .85rem;
            color: #6c757d;
        }

        .toast-container {
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 1200;
        }

        .btn-merge {
            margin-bottom: 12px;
        }
    </style>
@endpush