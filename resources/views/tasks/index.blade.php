@extends('layouts.app')



@section('title', 'Task')

@section('content')

    <div class="content content-two pt-0">

        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
            style="min-height: 80px;">

            <!-- Left: Title -->
            <div>
                <h6 class="mb-0">Tasks</h6>
            </div>

            <!-- Center: Logo -->
            <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" class="logo-img mobile-logo-no"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <!-- Right: Buttons -->
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="javascript:void(0);" class="btn btn-light border border-1 d-flex align-items-center"
                    data-bs-toggle="modal" data-bs-target="#add_modal">
                    <i class="isax isax-printer me-1"></i>Print
                </a>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="isax isax-export-1 me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>

                    </ul>
                </div>
         <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#add_modal"><i class="isax isax-add-circle5 me-1"></i>Add Task</button>
            </div>

        </div>

        <!-- End Page Header -->
        <!-- AI Priority Button -->
        <div class=" d-flex justify-content-between align-items-center mb-1">
            <!-- Priority Legend -->
            <div class="priority-legend">

                <div>
                    <span class="priority-legend-item">
                        <span class="status-dot overdue"></span> Overdue Tasks
                    </span>
                    <span class="priority-legend-item">
                        <span class="status-dot today"></span> Due Today
                    </span>
                    <span class="priority-legend-item">
                        <span class="status-dot future"></span> Future Tasks
                    </span>
                </div>
            </div>
            <button id="aiBtn" class="btn btn-lg shadow-sm"
                style="background-color: rgb(0, 33, 64); color: #fff; border: none; padding: 10px 20px; border-radius: 6px;">
                Primus AI Priority Suggestion
            </button>
        </div>

        <!-- AI Modal -->
        <div class="modal fade" id="aiModal" tabindex="-1" aria-labelledby="aiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:10px; border:none; overflow:hidden;">

                    <div class="modal-header" style="background-color: rgb(0, 33, 64); color:#fff; border:none;">
                        <h5 class="modal-title text-white" id="aiModalLabel">AI Priority Suggestion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="padding:25px;">
                        <!-- Loading -->
                        <div id="aiLoader" style="text-align:center; padding:40px 0;">
                            <div class="spinner-border" role="status"
                                style="color: rgb(0, 33, 64); width: 3rem; height: 3rem;"></div>
                            <p class="mt-3 mb-0" style="font-size:15px; color:#555;">Analyzing recent leads & activities...
                            </p>
                        </div>

                        <!-- Results -->
                        <div id="aiResults" class="d-none">


                            <p style="color:#555; font-size:15px; margin-bottom:20px;">
                                Primus AI has analyzed your tasks and will reorder them by priority.
                            </p>

                            <div class="alert alert-info" style="font-size:14px;">
                                Click "Apply AI Sorting" to reorder tasks. Click on the "Tasks" tab again to restore default
                                order.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e0e0e0;">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            style="border-radius:5px; padding:8px 16px;">Close</button>
                        <button id="applyAI" type="button" class="btn d-none"
                            style="background-color: rgb(0, 33, 64); color:#fff; border:none; border-radius:5px; padding:8px 16px;">
                            Apply AI Sorting
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Notes Modal -->
        <div class="modal fade" id="viewfullnote" tabindex="-1" aria-labelledby="viewfullnoteLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(0, 33, 64); color:#fff; border:none;">
                        <h5 class="modal-title text-white" id="viewfullnoteLabel">Notes History & Add Note</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                        <!-- Notes History Section -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Notes History</h6>
                            <div class="note-history" id="noteHistoryContainer">
                                <!-- Notes will be populated here -->
                            </div>
                        </div>

                        <hr>

                        <!-- Add New Note Section -->
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Add New Note</h6>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Note</label>
                                <textarea class="form-control" id="noteInput" rows="4" placeholder="Write your note here..."></textarea>
                            </div>

                            <div class="mb-3 d-flex gap-2">
                                <button type="button" class="btn btn-light border-1 border" id="recordAudioBtn"><i
                                        class="fas fa-microphone me-1"></i>Record Audio</button>
                                <button type="button" class="btn btn-light border-1 border" id="recordVideoBtn"><i
                                        class="fas fa-camera me-1"></i>Record Video</button>
                            </div>

                            <div id="mediaPreview" class="mb-3"></div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="privateNote">
                                <label class="form-check-label" for="privateNote">Private Note (only visible to
                                    you)</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tag Users</label>
          <select id="tagUsers" multiple style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            @if(isset($users) && $users->isNotEmpty())
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            @else
              <option value="">No users available</option>
            @endif
                                </select>
                            </div>

                            <div class="mt-3" id="taggedUsersInitials"></div>

                        </div>

                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
  <button class="btn btn-primary" id="saveNoteBtn" style="background-color: rgb(0, 33, 64); border: none;">Save Note</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-nowrap datatable" id="filterTable">
                <thead class="thead-light">
                    <tr>
  <th class="no-sort"><div class="form-check form-check-md"><input class="form-check-input" type="checkbox" id="select-all"></div></th>
  <th><span class="header-text">Priority</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Task Type</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Assigned To</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Lead Type</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Customer Name</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Year / Make / Model</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Source</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Sales Status</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Status Type</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Original Assigned By</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Original Assigned Date</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Original Assigned To</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Due Date/Time</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Created Date</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Created By</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Assigned By</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th><span class="header-text">Assigned Date</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
  <th style="text-align: center !important;"><span class="header-text " style="text-align: center !important;">Notes</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip" data-bs-title="Move Column"></i></th>
                        <th class="no-sort"><span class="header-text">Actions</span></th>
                    </tr>
                    <tr id="filtersRow" class="filter-row">
                        <th class="no-sort"></th>
<th ><div class="filter-wrapper" data-col="1"></div></th>
<th><div class="filter-wrapper" data-col="2"></div></th>
<th><div class="filter-wrapper" data-col="3"></div></th>
<th><div class="filter-wrapper" data-col="4"></div></th>
<th><div class="filter-wrapper" data-col="5"></div></th>
<th><div class="filter-wrapper" data-col="6"></div></th>
<th><div class="filter-wrapper" data-col="7"></div></th>
<th><div class="filter-wrapper" data-col="8"></div></th>
<th><div class="filter-wrapper" data-col="9"></div></th>
                        <!-- New Filter Columns -->
<th><div class="filter-wrapper" data-col="10"></div></th>
<th><div class="filter-wrapper" data-col="11"></div></th>
<th><div class="filter-wrapper" data-col="12"></div></th>
                        <!-- End New Filter Columns -->
<th><div class="filter-wrapper" data-col="13"></div></th>
<th><div class="filter-wrapper" data-col="14"></div></th>
<th><div class="filter-wrapper" data-col="15"></div></th>
<th><div class="filter-wrapper" data-col="16"></div></th>
<th><div class="filter-wrapper" data-col="17"></div></th>
<th><div class="filter-wrapper" data-col="18"></div></th>
                        <th class="no-sort"></th>
                        {{-- </tr>
</thead>
<tbody>
<tr data-due-date="2025-07-05T14:30:00" data-created-date="2025-01-10T09:00:00" data-assigned-date="2025-01-12T10:00:00" data-priority-reason="Due today with high customer engagement" data-notes='[{"text":"Initial task creation","date":"2025-01-15T10:30:00","by":"Admin"}]'>
<td><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
<td>High</td>
<td>
  <span class="status-dot today"></span>
  Outbound Call
    <span class="priority-info-icon">i</span>
</td>
<td>John Doe</td>
<td>Walk-In</td>
<td><a class="fw-semibold text-decoration-underline customer-link" style="cursor: pointer;"  data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">Michael Smith</a></td>
<td>
    <div class="vehicle-info">
        <div  data-bs-toggle="offcanvas" class="text-decoration-underline text-primary fw-semibold" style="cursor: pointer;" data-bs-target="#editvehicleinfo">2023 Honda Civic</div>

    </div>
</td>
<td>Referral</td>
<td>Not Completed</td>
<td><span class="badge bg-warning">Pending</span></td>
<!-- New Data Columns for Row 1 -->
<td>System Auto-Assign</td>
<td>January 10, 2025</td>
<td></td>
<!-- End New Data Columns -->
<td>July 5, 2025 — 2:30 PM</td>
<td>January 10, 2025</td>
<td>Admin User</td>
<td>Manager John</td>
<td>January 12, 2025</td>
<td style="white-space:normal;">
    <div class="note-area">
        Customer requested follow-up next week.
        <a href="#" class="view-notes-link" data-bs-toggle="modal" data-bs-target="#viewfullnote">
            <i class="fas fa-edit" data-bs-toggle="tooltip" title="View & Edit Notes"></i>
        </a>
    </div>
</td>
<td>
    <a href="#" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Add Task</a></li>
        <li><a class="dropdown-item" href="#">Edit Task</a></li>
        <li><a class="dropdown-item" href="#">Delete Task</a></li>
    </ul>
</td>
</tr> --}}
                        </tbody>
            </table>
        </div>
    </div>

    {{-- Add task Modal --}}
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="taskFormModal" action="javascript:void(0);">
                    <div class="modal-body pb-2">
                        <div class="row g-2">

                            <!-- Due Date -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Due Date</label>
                                <input type="text" value="" name="dueDatePickerModal" id="dueDatePickerModal"
                                    class="bg-light form-control cf-datepicker" placeholder="Select Due Date">
                                <input type="hidden" id="taskIdModal" name="task_id">

                            </div>

                            <!-- Customer Search -->
                            <div class="col-md-6 mb-4 position-relative">
                                <label class="form-label">Customer</label>
                                <input type="text" name="customerSearchModal" class="form-control"
                                    id="customerSearchModal" placeholder="Enter name, email, or phone">
                                <div id="customerSuggestionsModal" class="list-group position-absolute w-100 mt-1 "
                                    style="z-index: 1050;"></div>
                            </div>

                                <!-- Deal List -->
                            <div class="col-md-12 mb-4 d-none" id="dealSectionModal">
                                <label class="form-label deal-section-header">Select Event</label>
                                <div class="list-group" id="dealListModal"></div>
                            </div>

                            <!-- Assigned To -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Assigned To</label>
                                <select class="form-select" id="assignedToModal" name="assignedToModal">
                                    <option value="" hidden>-- Select --</option>
                                    @if ($users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No record found</option>
                                    @endif

                                </select>
                            </div>

                            <!-- Status Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Status Type</label>
                                <select class="form-select" id="statusTypeModal" name="statusTypeModal">
                                    <option value="" hidden>-- Select --</option>
                                    <option value="open">Open</option>
                                    <option value="completed">Completed</option>
                                    <option value="missed">Missed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="walkin">Walk-In</option>
                                    <option value="noresponse">No Response</option>
                                    <option value="noshow">No Show</option>
                                </select>
                            </div>

                            <!-- Task Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Task Type</label>
                                <select class="form-select" id="taskTypeModal" name="taskTypeModal">
                                    <option value="" hidden>-- Select --</option>
                                    <option value="call">Inbound Call</option>
                                    <option value="call_outbound">Outbound Call</option>
                                    <option value="text_inbound">Inbound Text</option>
                                    <option value="text_outbound">Outbound Text</option>
                                    <option value="email_inbound">Inbound Email</option>
                                    <option value="email_outbound">Outbound Email</option>
                                    <option value="csi">CSI</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Phone Scripts with Tom Select -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Phone Scripts</label>
                                <select id="phoneScriptSelectModal" name="phoneScriptSelectModal"
                                    placeholder="Search & select script..."></select>
                            </div>

                            <!-- Priority -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Priority</label>
                                <select class="form-select" id="priorityModal" name="priorityModal">
                                    <option value="" hidden>-- Select --</option>
                  <option value="High">High</option>
                  <option value="Medium">Medium</option>
                  <option value="Low">Low</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="descriptionFieldModal" id="descriptionFieldModal" rows="3"
                                    placeholder="Enter task description (max 140 characters)"></textarea>
                                <div class="description-counter"><span id="charCountModal">0</span>/140</div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-end gap-1">
                        <button type="button" class="btn btn-light border border-1"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="assets/img/icons/delete.svg" alt="img">
                </div>
                <h6 class="mb-1">Delete Task</h6>
                <p class="mb-3">Are you sure you want to delete this Task?</p>
                <div class="d-flex justify-content-center gap-2 align-items-center">
                    <button type="button" class="btn btn-light border-1 border" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm_delete_btn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('styles')
    @include('tasks.style')
@endpush


@push('scripts')
    @include('tasks.script')
@endpush
