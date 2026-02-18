@extends('layouts.app')


@section('title', "Manager's Desklog")
@section('content')
    <div class="content content-two p-0 ps-3 pe-3" id="showroom-page">
        <div id="alert-box-container">

        </div>
        <!-- Page Header -->
        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
            style="min-height: 80px;">

            <!-- Left: Title -->
            <div>
                <h6 class="mb-0">Manager's Desklog</h6>
            </div>

            <!-- Center: Logo -->
            <img src="assets/light_logo.png" alt="Logo" class="logo-img mobile-logo-no"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <!-- Right: Buttons -->
            <div class="d-flex my-xl-auto right-content align-items-center  gap-2">
                <select class="form-select form-select-sm" id="savedFiltersDropdown">
                    <option value="" selected>Select Saved Filter</option>
                </select>
                <button style="min-width: 100px;" class="btn btn-primary " id="saveFilterBtn">Save Filters</button>
            </div>

        </div>
        <!-- End Page Header -->


        <div class="split-container">
            <!-- View 1 -->
            <div class="split-view">
                <div class="crm-box">
                    <div class="crm-header">Desk Log (29)</div>
                    <form class="row g-2" id="filterForm">

                        <div class="col-md-3 mb-2">
                            <label class="form-label">From</label>
                            <input type="text" id="fromDate" class="form-control cf-datepicker"
                                placeholder="Select From Date" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">To</label>
                            <input type="text" id="toDate" class="form-control cf-datepicker"
                                placeholder="Select To Date" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Users</label>
                            <select class="form-select" id="usersFilter">
                                <option selected value="">--ALL--</option>
                                <option>Aaron Burgess</option>
                                <option>Brad Nakuckyj</option>
                                <option>Brandon Henderson</option>
                                <option>Emily Chan</option>
                                <option>Jake Thomson</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">Teams</label>
                            <select class="form-select" id="teamsFilter">
                                <option value="">--ALL--</option>
                                <option value="">-- Select Team --</option>
                                <option value="sales-rep">Sales Rep</option>
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
                                <option value="fixed-operations-manager">Fixed Operations Manager</option>
                            </select>
                        </div>

                        <div class="col-md-5 dates-option">
                            <span class="me-2" data-preset="ytd">YTD</span>
                            <span class="me-2" data-preset="thisWeek">This Week</span>
                            <span class="me-2" data-preset="lastWeek">Last Week</span>
                            <span class="me-2" data-preset="lastMonth">LM</span>
                            <span class="me-2" data-preset="mtd">MTD</span>
                            <span class="me-2" data-preset="last7Days">Last 7 Days</span>
                            <span class="me-2" data-preset="yesterday">Yesterday</span>
                            <span class="me-2" data-preset="today">Today</span>
                        </div>

                        <div class="col-6 mt-2 d-flex gap-2 button-group mb-3">
                            <button type="button" class="btn btn-secondary" id="refreshBtn">Refresh</button>
                            <button type="button" class="btn btn-outline-primary">Export</button>
                            <button type="button" class="btn btn-outline-dark">Print</button>
                        </div>

                        <!-- Show More Filters Button -->
                        <div class="col-12" id="toggleFiltersBtn">
                            <button type="button" class="float-end btn btn-sm btn-outline-primary border-2">View More
                                Filters</button>
                        </div>

                        <!-- All remaining fields wrapped here -->
                        <div class="extra-filters row" style="display: none;">

                            <!-- Lead Type -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Type</label>
                                <select class="form-select" id="leadTypeFilter">
                                    <option selected value="">--ALL--</option>
                                    <option>Internet</option>
                                    <option>Walk-In</option>
                                    <option>Phone Up</option>
                                    <option>Text Up</option>
                                    <option>Website Chat</option>
                                    <option>Import</option>
                                    <option>Wholesale</option>
                                    <option>Lease Renewal</option>
                                </select>
                            </div>

                            <!-- Lead Status -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Status</label>
                                <select class="form-select" id="leadStatusFilter">
                                    <option selected value="">--ALL--</option>
                                    <option>Active</option>
                                    <option>Duplicate</option>
                                    <option>Invalid</option>
                                    <option>Lost</option>
                                    <option>Sold</option>
                                    <option>Wishlist</option>
                                </select>
                            </div>

                            <!-- Source -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Source</label>
                                <select class="form-select" id="sourceFilter">
                                    <option selected value="">--ALL--</option>
                                    <option>Walk-In</option>
                                    <option>Phone Up</option>
                                    <option>Text</option>
                                    <option>Repeat Customer</option>
                                    <option>Referral</option>
                                    <option>Service to Sales</option>
                                    <option>Lease Renewal</option>
                                    <option>Drive By</option>
                                    <option>Dealer Website</option>
                                </select>
                            </div>

                            <!-- Visits -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Visits</label>
                                <select class="form-select" id="visitsFilter">
                                    <option hidden value="">--ALL--</option>
                                    <option>Closed Visits</option>
                                    <option>Open Visits</option>
                                </select>
                            </div>

                            <!-- Inventory Type -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Inventory Type</label>
                                <select class="form-select" id="inventoryTypeFilter">
                                    <option value="">--ALL--</option>
                                    <option>New</option>
                                    <option>Pre-Owned</option>
                                    <option>CPO</option>
                                    <option>Demo</option>
                                    <option>Wholesale</option>
                                    <option>Unknown</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Dealership</label>
                                <select class="form-select" id="dealershipFilter">
                                    <option value="">--ALL--</option>
                                    <option>#18874 Bannister GM Vernon</option>
                                    <option selected>Twin Motors Thompson</option>
                                    <option>#19234 Bannister Ford</option>
                                    <option>#19345 Bannister Nissan</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Sales Status</label>
                                <select class="form-select" id="salesStatusFilter">
                                    <option selected value="">--ALL--</option>
                                    <option>Uncontacted</option>
                                    <option>Attempted</option>
                                    <option>Contacted</option>
                                    <option>Dealer Visit</option>
                                    <option>Demo</option>
                                    <option>Write-Up</option>
                                    <option>Pending F&I</option>
                                    <option>Sold</option>
                                    <option>Delivered</option>
                                    <option>Lost</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Deal Type</label>
                                <select class="form-select" id="dealTypeFilter">
                                    <option value="">--ALL--</option>
                                    <option>Finance</option>
                                    <option>Lease</option>
                                    <option>Cash</option>
                                    <option>Unknown</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- View 2 -->

        </div>
        <!-- Save Filter Modal -->
        <div class="modal fade" id="saveFilterModal" tabindex="-1" aria-labelledby="saveFilterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saveFilterModalLabel">Save Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="filterName" class="form-label">Filter Name</label>
                            <input type="text" class="form-control" id="filterName" placeholder="Enter filter name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border border-1"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSaveFilter">Save</button>
                    </div>
                </div>
            </div>
        </div>




        <div class="table-responsive table-nowrap mb-4">
            <table id="filterTable" class="table border   datatable dataTable no-footer">
                <thead class="table-light">
                    <tr>
                        <th>Lead Type <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Lead Contacted Within <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Assigned To <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Assigned By <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Created Date/Time <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Customer/Vehicle Information <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th> <!-- Combined Column -->

                        <th>Sales Status <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Source <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Notes <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Phone <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Sold <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Delivered <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Credit Score <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th>Created By <i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <td>Walk In</td>
                        <td>2h 05m</td>
                        <td>M.Zainn</td>
                        <td>M. Kelly</td>
                        <td id="current-date-time">Aug 27, 2025 10:45 AM</td>
                        <td>

                            <a data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                class="text-black text-decoration-underline fw-semibold" href="#">
                                Harinder Dalam
                            </a>


                            <div class=" text-muted">
                                2022 <a data-bs-toggle="offcanvas" href="#" data-bs-target="#editvehicleinfo"
                                    class="text-decoration-underline">Toyota Camry</a> (34892A) (U)<br>
                                4TIC11AK0NU123456
                            </div>
                        </td>

                        <td><span class="text-success fw-semibold">Sold</span></td>
                        <td>Referral</td>
                        <td style="white-space:normal;">
                            <div class="note-area">
                                🔥 Customer showed strong interest in financing approved options. Requested test drive for
                                Friday. Mentioned possible trade-in of current vehicle.
                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewfullnote">
                                    <i class="ti ti-edit" data-bs-toggle="tooltip" title="View Full History"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div>Work: <a href="tel:+123456789" class="edit-vehicle-link">+1 234 56789</a></div>
                                <div>Cell: <a href="tel:+123456789" class="edit-vehicle-link">+1 234 56789</a></div>
                                <div>Home: <a href="tel:+123456789" class="edit-vehicle-link">+1 234 56789</a></div>
                            </div>
                        </td>
                        <td><span class="text-success fw-semibold">06-10-2025</span></td>
                        <td><span class="text-success fw-semibold">06-12-2025</span></td>
                        <td>🔥 720</td>
                        <td id="current-date">Primus CRM</td>
                    </tr>

                    <!-- Example for others (same pattern applied) -->

                    <tr>
                        <td>Walk In</td>
                        <td>1h 30m</td>
                        <td>Sarah L.</td>
                        <td>James Wolk</td>
                        <td id="current-date-time2">Aug 10, 2025 9:30 AM</td>
                        <td>

                            <a data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                class="text-black text-decoration-underline fw-semibold" href="#">
                                Jason Torres
                            </a>

                            <div class=" text-muted">
                                2022 <a data-bs-toggle="offcanvas" href="#" data-bs-target="#editvehicleinfo"
                                    class="text-decoration-underline">Toyota Camry</a> (34892A) (U)<br>
                                4TIC11AK0NU123456
                            </div>
                        </td>

                        <td><span class="text-danger fw-semibold">Lost</span></td>
                        <td>Drive By</td>
                        <td style="white-space:normal;">
                            <div class="note-area">
                                Customer browsed inventory but undecided. Needs time to consider options.
                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewfullnote">
                                    <i class="ti ti-edit" data-bs-toggle="tooltip" title="View Full History"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div>Work: <a href="tel:+123456780" class="edit-vehicle-link">+1 234 56780</a></div>
                                <div>Cell: <a href="tel:+123456780" class="edit-vehicle-link">+1 234 56780</a></div>
                            </div>
                        </td>
                        <td><span class="sell-date text-muted"><i class="fa-solid fa-xmark text-danger"></i></span></td>
                        <td><span class="sell-date text-muted"><i class="fa-solid fa-xmark text-danger"></i></span></td>
                        <td>620</td>
                        <td id="current-date2">Primus CRM</td>
                    </tr>



                    <!-- Repeat same structure for all rows (Website Chat, Internet Lead, etc.) -->
                </tbody>
            </table>
            <style>
                .table th.dragging {
                    opacity: 0.6;
                    background-color: #e9ecef;
                }

                .table th.drag-over {
                    background-color: #d1ecf1;
                }

                .table th .drag-handle {
                    position: relative;
                    left: 2px;
                    top: 0px;
                    color: #fff;
                    opacity: 0.5;
                    transition: opacity 0.2s;
                }

                .table th:hover .drag-handle {
                    opacity: 1;
                }

                .no-sort {
                    cursor: default !important;
                }

                .no-sort .drag-handle {
                    display: none;
                }

                @media (max-width: 768px) {
                    .table th {
                        cursor: default;
                    }

                    .table th .drag-handle {
                        display: none;
                    }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const table = document.getElementById('filterTable');
                    const headers = table.querySelectorAll('thead tr:first-child th:not(.no-sort)');
                    let draggingHeader = null;
                    let draggingIndex = null;

                    headers.forEach(th => {
                        th.setAttribute('draggable', true);

                        th.addEventListener('dragstart', function(e) {
                            draggingHeader = this;
                            draggingIndex = [...this.parentNode.children].indexOf(this);
                            this.classList.add('dragging');
                            e.dataTransfer.effectAllowed = 'move';
                        });

                        th.addEventListener('dragover', function(e) {
                            e.preventDefault();
                            e.dataTransfer.dropEffect = 'move';
                            if (this !== draggingHeader) this.classList.add('drag-over');
                        });

                        th.addEventListener('dragleave', function() {
                            this.classList.remove('drag-over');
                        });

                        th.addEventListener('drop', function(e) {
                            e.preventDefault();
                            if (this !== draggingHeader) {
                                const targetIndex = [...this.parentNode.children].indexOf(this);
                                moveColumn(draggingIndex, targetIndex);
                            }
                            this.classList.remove('drag-over');
                        });

                        th.addEventListener('dragend', function() {
                            this.classList.remove('dragging');
                            headers.forEach(h => h.classList.remove('drag-over'));
                        });
                    });

                    function moveColumn(from, to) {
                        const rows = table.querySelectorAll('tr');
                        rows.forEach(row => {
                            const cells = [...row.children];
                            const movingCell = cells[from];
                            if (from < to) {
                                row.insertBefore(movingCell, cells[to].nextSibling);
                            } else {
                                row.insertBefore(movingCell, cells[to]);
                            }
                        });
                    }

                    // Initialize Bootstrap tooltips
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
                });
            </script>

        </div>

    </div>
    
  <div class="modal fade" id="viewfullnote" tabindex="-1" aria-labelledby="viewfullnote" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">View Full History</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="note-history">
            <div class="note-entry mb-4">
              <div class="fw-bold">July 15, 2025 - 2:45 PM <span class="text-muted">by Sarah Johnson</span></div>
              <div>Customer called to <strong>request a quote</strong> for the new Ford Escape model. Interested in financing options.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">July 13, 2025 - 11:15 AM <span class="text-muted">by Mike Reynolds</span></div>
              <div>Follow-up done via email. No response yet. Set reminder for 2 days.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">July 10, 2025 - 4:30 PM <span class="text-muted">by Sarah Johnson</span></div>
              <div>Initial contact made. Customer very engaged and seems ready to <strong>purchase now</strong> if terms are good.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">July 09, 2025 - 9:00 AM <span class="text-muted">by Admin</span></div>
              <div>Lead assigned to Sarah Johnson.</div>
            </div>
          </div>
          <div class="crm-header">
            Add Note
          </div>
          
     
        
        <!-- Note -->
        <div class="mb-3">
          <label class="form-label fw-bold">Note</label>
          <textarea class="form-control" id="noteInput" rows="4" placeholder="Write your note here..."></textarea>
        </div>

        <!-- Audio/Video Buttons -->
        <div class="mb-3 d-flex gap-2">
          <button type="button" class="btn btn-light border-1 border" id="recordAudioBtn"><i class="ti ti-microphone me-1"></i>Record Audio</button>
          <button type="button" class="btn btn-light border-1 border" id="recordVideoBtn"><i class="ti ti-camera me-1"></i>Record Video</button>
        </div>

        <!-- Audio/Video Preview -->
        <div id="mediaPreview" class="mb-3"></div>

        <!-- Private Note -->
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="privateNote">
          <label class="form-check-label" for="privateNote">Private Note (only visible to you)</label>
        </div>

        <!-- Tag Users -->
        <div class="mb-3">
          <label class="form-label fw-bold">Tag Users</label>
          <select id="tagUsers" multiple>
            <option value="1">John Smith</option>
            <option value="2">Sarah Johnson</option>
            <option value="3">David Brown</option>
            <option value="4">Emily Davis</option>
          </select>
        </div>

        <!-- Tagged Users Initials Example -->
        <div class="mt-3" id="taggedUsersInitials"></div>

      </div>
       
        <div class="modal-footer d-flex justify-content-between">
          <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="saveNoteBtn">Add Note</button>
        </div>
      </div>
    </div>
  </div>
 <!-- Date Picker Modal -->
 <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title" id="datePickerModalLabel">Select Date</h6>
          <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
  
          <input type="text" id="modalDateInput" class="form-control cf-datepicker" 
   placeholder="Select date" readonly>
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-sm btn-primary" id="saveDateBtn">Save</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
    {{-- Saved Filter & Expand Filters Logic --}}
    <script>
        console.log("Script loaded"); // Check if script is running

        // Toggle extra filters
        const toggleBtn = document.querySelector("#toggleFiltersBtn button");
        const extraFilters = document.querySelector(".extra-filters");

        if (!toggleBtn) console.error("Toggle button not found");
        if (!extraFilters) console.error("Extra filters container not found");

        toggleBtn?.addEventListener("click", function() {
            console.log("Toggle button clicked");
            extraFilters.classList.toggle('active');
            if (extraFilters.classList.contains('active')) {
                extraFilters.style.display = 'flex';
                toggleBtn.textContent = 'Hide Filters';
            } else {
                extraFilters.style.display = 'none';
                toggleBtn.textContent = 'View More Filters';
            }
        });

        // Date presets
        const datePresets = document.querySelectorAll('.dates-option span');
        if (!datePresets.length) console.warn("No date preset elements found");

        datePresets.forEach(preset => {
            preset.addEventListener('click', function() {
                const presetType = this.getAttribute('data-preset');
                console.log("Date preset clicked:", presetType);
                const today = new Date();
                let fromDate, toDate;

                switch (presetType) {
                    case 'today':
                        fromDate = today;
                        toDate = today;
                        break;
                    case 'yesterday':
                        fromDate = new Date(today);
                        fromDate.setDate(today.getDate() - 1);
                        toDate = fromDate;
                        break;
                    case 'last7Days':
                        fromDate = new Date(today);
                        fromDate.setDate(today.getDate() - 6);
                        toDate = today;
                        break;
                    case 'thisWeek':
                        fromDate = new Date(today);
                        fromDate.setDate(today.getDate() - today.getDay());
                        toDate = new Date(today);
                        toDate.setDate(today.getDate() + (6 - today.getDay()));
                        break;
                    case 'lastWeek':
                        fromDate = new Date(today);
                        fromDate.setDate(today.getDate() - today.getDay() - 7);
                        toDate = new Date(today);
                        toDate.setDate(today.getDate() - today.getDay() - 1);
                        break;
                    case 'mtd':
                        fromDate = new Date(today.getFullYear(), today.getMonth(), 1);
                        toDate = today;
                        break;
                    case 'lastMonth':
                        fromDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        toDate = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;
                    case 'ytd':
                        fromDate = new Date(today.getFullYear(), 0, 1);
                        toDate = today;
                        break;
                    default:
                        console.warn("Unknown preset type:", presetType);
                }

                document.getElementById('fromDate').value = formatDate(fromDate);
                document.getElementById('toDate').value = formatDate(toDate);
            });
        });

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Saved Filters Functionality
        const savedFiltersDropdown = document.getElementById('savedFiltersDropdown');
        const saveFilterBtn = document.getElementById('saveFilterBtn');
        const filterNameInput = document.getElementById('filterName');
        const confirmSaveFilter = document.getElementById('confirmSaveFilter');

        if (!savedFiltersDropdown) console.error("Saved filters dropdown not found");
        if (!saveFilterBtn) console.error("Save Filter button not found");
        if (!confirmSaveFilter) console.error("Confirm Save button not found");

        let saveFilterModal;
        try {
            saveFilterModal = new bootstrap.Modal(document.getElementById('saveFilterModal'));
            console.log("Bootstrap modal initialized successfully");
        } catch (e) {
            console.error("Bootstrap modal could not be initialized:", e);
        }

        // Load saved filters from localStorage
        function loadSavedFilters() {
            console.log("Loading saved filters...");
            const savedFilters = JSON.parse(localStorage.getItem('savedFilters')) || [];
            savedFiltersDropdown.innerHTML = '<option value="" selected>Select Saved Filter</option>';

            savedFilters.forEach((filter, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = filter.name;
                savedFiltersDropdown.appendChild(option);
            });
        }

        // Save current filter state
        function saveFilterState(name) {
            console.log("Saving filter with name:", name);
            const filterState = {
                name: name,
                fromDate: document.getElementById('fromDate').value,
                toDate: document.getElementById('toDate').value,
                users: document.getElementById('usersFilter').value,
                teams: document.getElementById('teamsFilter').value,
                leadType: document.getElementById('leadTypeFilter').value,
                leadStatus: document.getElementById('leadStatusFilter').value,
                source: document.getElementById('sourceFilter').value,
                visits: document.getElementById('visitsFilter').value,
                inventoryType: document.getElementById('inventoryTypeFilter').value,
                dealership: document.getElementById('dealershipFilter').value,
                salesStatus: document.getElementById('salesStatusFilter').value,
                dealType: document.getElementById('dealTypeFilter').value
            };

            const savedFilters = JSON.parse(localStorage.getItem('savedFilters')) || [];
            savedFilters.push(filterState);
            localStorage.setItem('savedFilters', JSON.stringify(savedFilters));

            console.log("Filter saved to localStorage");
            loadSavedFilters();
            saveFilterModal?.hide();
            filterNameInput.value = '';
        }

        // Apply saved filter
        function applySavedFilter(index) {
            console.log("Applying saved filter index:", index);
            const savedFilters = JSON.parse(localStorage.getItem('savedFilters')) || [];
            if (savedFilters[index]) {
                const filter = savedFilters[index];

                document.getElementById('fromDate').value = filter.fromDate || '';
                document.getElementById('toDate').value = filter.toDate || '';
                document.getElementById('usersFilter').value = filter.users || '';
                document.getElementById('teamsFilter').value = filter.teams || '';
                document.getElementById('leadTypeFilter').value = filter.leadType || '';
                document.getElementById('leadStatusFilter').value = filter.leadStatus || '';
                document.getElementById('sourceFilter').value = filter.source || '';
                document.getElementById('visitsFilter').value = filter.visits || '';
                document.getElementById('inventoryTypeFilter').value = filter.inventoryType || '';
                document.getElementById('dealershipFilter').value = filter.dealership || '';
                document.getElementById('salesStatusFilter').value = filter.salesStatus || '';
                document.getElementById('dealTypeFilter').value = filter.dealType || '';

                console.log("Filters applied to form");
                document.getElementById('refreshBtn').click();
            } else {
                console.warn("No saved filter found at index:", index);
            }
        }

        // Event Listeners
        saveFilterBtn?.addEventListener('click', function() {
            console.log("Save Filter button clicked");
            if (saveFilterModal) {
                saveFilterModal.show();
            } else {
                console.error("saveFilterModal is undefined");
            }
        });

        if (typeof bootstrap !== 'undefined') {
            saveFilterModal = new bootstrap.Modal(document.getElementById('saveFilterModal'));
            console.log("Bootstrap modal initialized successfully");
        } else {
            console.error("Bootstrap JS not loaded! Modal cannot be initialized.");
        }

        confirmSaveFilter?.addEventListener('click', function() {
            const name = filterNameInput.value.trim();
            if (name) {
                saveFilterState(name);
            } else {
                alert('Please enter a filter name');
            }
        });

        savedFiltersDropdown?.addEventListener('change', function() {
            if (this.value !== '') {
                applySavedFilter(parseInt(this.value));
            }
        });

        // Refresh button functionality
        document.getElementById('refreshBtn')?.addEventListener('click', function() {
            console.log("Refresh button clicked");
            alert('Refreshing data with current filters...');
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM fully loaded");
            loadSavedFilters();
        });
    </script>


{{-- Date Sold Delivered Logic --}}
<script>
    let targetCell = null; // Track which cell is being edited
  
    document.querySelectorAll(".sell-date i, .delivered-date i").forEach(function(icon) {
      icon.style.cursor = "pointer";
      icon.addEventListener("click", function () {
        targetCell = icon.closest("span");
        document.getElementById("modalDateInput").value = ''; // clear previous
        new bootstrap.Modal(document.getElementById('datePickerModal')).show();
      });
    });
  
    document.getElementById("saveDateBtn").addEventListener("click", function () {
      const dateVal = document.getElementById("modalDateInput").value;
      if (dateVal && targetCell) {
        targetCell.innerHTML = `<span class="text-success">${dateVal}</span>`;
        // Optional: Send AJAX to save in backend
        bootstrap.Modal.getInstance(document.getElementById('datePickerModal')).hide();
      }
    });
  </script> 

@endpush
