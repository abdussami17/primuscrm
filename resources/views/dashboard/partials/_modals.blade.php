{{-- Modals Area --}}

<div class="modal fade" id="internetresponsetimeModal" tabindex="-1"
    aria-labelledby="sentreceivedtextViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                Internet Response Time
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select w-auto widgetdateFilter">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" id="includePrimus" />
                            <label class="form-check-label" for="includePrimus">Include Primus CRM</label>
                        </div>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-5 align-items-center ">
                    <div class="legend">
                        <div class="legend-item clickable-legend" data-filter="under5">
                            <div class="legend-color" style="background:#28a745;"></div>&nbsp; Responded in 0–5 Mins
                            – <span id="irt-legend-05">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under10">
                            <div class="legend-color" style="background:#6c757d;"></div>&nbsp; Responded in 6–10
                            Mins – <span id="irt-legend-10">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under15">
                            <div class="legend-color" style="background:rgb(0, 33, 64);"></div>&nbsp; Responded in
                            11–15 Mins – <span id="irt-legend-15">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under30">
                            <div class="legend-color" style="background:#ffc107;"></div>&nbsp; Responded in 16–30
                            Mins – <span id="irt-legend-30">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under60">
                            <div class="legend-color" style="background:#17a2b8;"></div>&nbsp; Responded in 31–60
                            Mins – <span id="irt-legend-60">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="over60">
                            <div class="legend-color" style="background:#6f42c1;"></div>&nbsp; Responded in 61+ Mins
                            – <span id="irt-legend-61plus">—</span>
                        </div>
                        <div class="legend-item clickable-legend" data-filter="nocontact">
                            <div class="legend-color" style="background:#dc3545;"></div>&nbsp; No Contact Made – <span id="irt-legend-nc">—</span>
                        </div>
                    </div>

                    <div id="internetResponseTimeChart"></div>

                </div>

                <div id="filter-details" class="mt-2" style="display: none;">
                    <div class="table-responsive table-nowrap">
                        <table class="table border  datatable dataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>Response Time</th>
                                    <th>Assigned To</th>
                                    <th>Assigned By</th>
                                    <th>Customer Name</th>
                                    <th>Year/Make/Model</th>
                                    <th>Deal Type</th>
                                    <th>Source</th>
                                    <th>Lead Status</th>
                                </tr>
                            </thead>

                            <tbody id="filter-details-body">
                                <!-- Filled dynamically -->
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Lead Flow Modal -->
<div class="modal fade" id="dealflowModal" tabindex="-1" aria-labelledby="dealflowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-white" id="dealflowModalLabel">Lead Flow</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select w-auto widgetdateFilter">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" id="includePrimus" />
                            <label class="form-check-label" for="includePrimus">Include Primus CRM</label>
                        </div>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div id="statusTimeline"></div>

                <!-- Legend (below chart) -->
                <div id="chartLegend" class="d-flex justify-content-center gap-3 mt-3 flex-wrap"></div>

                <!-- Table - Hidden by default, click a bar to show -->
                <div id="dealflowTableContainer" class="table-responsive table-nowrap mt-3"
                    style="display: none;">
                    <h6 id="leadFlowTableTitle" class="fw-semibold mb-2">Lead Details</h6>
                    <table class="table border">
                        <thead class="table-light">
                            <tr>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Email</th>
                                <th>Cell #</th>
                                <th>Home #</th>
                                <th>Work #</th>
                                <th>Assigned By</th>
                                <th>Year/Make/Model</th>
                                <th>Lead Type</th>
                                <th>Deal Type</th>
                                <th>Created Date</th>
                                <th>Lead Status</th>
                                <th>Sales Status</th>
                                <th>Source</th>
                                <th>Inventory Type</th>
                                <th>Sales Type</th>
                            </tr>
                        </thead>
                        <tbody id="dealflowDetailsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Funnel Modal -->
<div class="modal fade" id="salesfunnelModal" tabindex="-1" aria-labelledby="sentreceivedtextViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                Leads Funnel
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select w-auto widgetdateFilter">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" id="includePrimus" />
                            <label class="form-check-label" for="includePrimus">Include Primus CRM</label>
                        </div>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dealflow-card">
                    <div class="">
                        <!-- Flow row -->
                        <div id="dealFlow" class="d-flex flex-wrap align-items-stretch gap-2">
                            <!-- Stage: Customers -->
                            <div class="stage-wrapper">
                                <div class="stage card p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="count" id="funnel-customers" data-key="customers">0</div>
                                            <div class="label">Customers</div>
                                        </div>
                                        <span class="badge conv-badge" data-from="customers">—</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-bar="customers">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                            <!-- Stage: Contacted -->
                            <div class="stage-wrapper">
                                <div class="stage card p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="count" id="funnel-contacted" data-key="contacted">0</div>
                                            <div class="label">Contacted</div>
                                        </div>
                                        <span class="badge conv-badge" data-from="contacted">—</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-bar="contacted">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                            <!-- Stage: Appt Set -->
                            <div class="stage-wrapper">
                                <div class="stage card p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="count" id="funnel-apptSet" data-key="apptSet">0</div>
                                            <div class="label">Appt Set</div>
                                        </div>
                                        <span class="badge conv-badge" data-from="apptSet">—</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-bar="apptSet"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-text-below">
                                    Appt Set = Open Appt
                                </div>
                            </div>

                            <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                            <!-- Stage: Appt Shown -->
                            <div class="stage-wrapper">
                                <div class="stage card p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="count" id="funnel-apptShown" data-key="apptShown">0</div>
                                            <div class="label">Appt Shown</div>
                                        </div>
                                        <span class="badge conv-badge" data-from="apptShown">—</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-bar="apptShown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-text-below">
                                    Appt Shown = Completed Appt
                                </div>
                            </div>

                            <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                            <!-- Stage: Sold -->
                            <div class="stage-wrapper">
                                <div class="stage card p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="count" id="funnel-sold" data-key="sold">0</div>
                                            <div class="label">Sold</div>
                                        </div>
                                        <span class="badge conv-badge" data-from="sold">—</span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" data-bar="sold"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer stats -->
                        <div class="mt-3 d-flex justify-content-between align-items-start flex-wrap gap-3">

                            <!-- LEFT: Stage paragraph -->
                            <div class="small text-secondary">
                                Stage → stage conversion shown on badges. Bars visualize % vs previous stage.
                            </div>

                            <!-- RIGHT: Ratios stacked in a column -->
                            <div class="d-flex flex-column text-end">

                                <div class="small d-flex justify-content-end align-items-center gap-1 mt-1">
                                    <i style="cursor: pointer;font-size: 16px !important;"
                                        class="ti ti-info-circle text-black" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Sold / Store Visit"></i>
                                    <span> Store Visit Closing Ratio: <strong id="funnelStoreVisitPct">—</strong></span>
                                </div>
                                <div class="small d-flex justify-content-end align-items-center gap-1">
                                    <i style="cursor: pointer;font-size: 16px !important;"
                                        class="ti ti-info-circle text-black" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Sold / Customers"></i>
                                    <span> Overall Conv: <strong id="overallConv">—</strong></span>
                                </div>

                            </div>
                        </div>

                        <!-- Table (hidden by default, placed inside modal-body, below your dealflow-card) -->
                        <div id="DealstageDetails" class="mt-4" style="display: none;">
                            <h6 id="DealstageTitle" class="mb-2"></h6>
                            <div class="table-responsive table-nowrap">
                                <table class="table border">
                                    <thead class="table-light">
                                        <tr>

                                            <th>Customer Name</th>
                                            <th>Assigned To</th>
                                            <th>Assigned By </th>
                                            <th>Year/Make/Model</th>
                                            <th>Lead Type</th>
                                            <th>Deal Type</th>
                                            <th>Source</th>
                                            <th>Inventory Type</th>
                                            <!-- Additional columns for Appt Set and Appt Shown stages -->
                                            <th id="apptCreationUserHeader" style="display:none;">Appointment
                                                Creation User</th>
                                            <th id="apptCreationDateHeader" style="display:none;">Appointment
                                                Creation Date/Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="DealstageTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Prevent dropdown icon click from opening modal
    document.querySelectorAll('.dropdown [data-bs-toggle="dropdown"]').forEach(el => {
        el.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
<!-- Email Report Modal -->
<div class="modal fade" id="emailReportModal" tabindex="-1" aria-labelledby="emailReportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Date Filter Buttons -->
                <div class="mb-3">
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="today">Today</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn"
                        data-period="yesterday">Yesterday</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="thisMonth">This
                        Month</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="lastMonth">Last
                        Month</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="all">All</button>
                </div>

                <!-- Email Table -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody id="emailTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sentreceivedtextViewModal" tabindex="-1"
    aria-labelledby="sentreceivedtextViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Text Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Date Filter Buttons -->
                <div class="mb-3">
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="today">Today</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn"
                        data-period="yesterday">Yesterday</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="thisMonth">This
                        Month</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="lastMonth">Last
                        Month</button>
                    <button class="btn btn-outline-primary btn-sm filter-btn" data-period="all">All</button>
                </div>

                <!-- Email Table -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody id="textTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="leadDetailModal" tabindex="-1" aria-labelledby="leadDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="leadDetailsContent">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="lastLoginModal" tabindex="-1" aria-labelledby="lastLoginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="lastLoginModalLabel">Last Login & Last Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>

                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Login Table -->
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>User Full Name</th>
                                <th>Last Login</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody id="lastLoginBody">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Rep List Modal -->
<div class="modal fade" id="repListModal" tabindex="-1" aria-labelledby="repListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Completed Appointments Per Rep</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <select class="form-select w-auto widgetdateFilter">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7">Last 7 Days</option>
                        <option value="thisMonth">This Month</option>
                        <option value="lastMonth">Last Month</option>
                        <option value="custom">Custom Date</option>
                    </select>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>

                            </ul>
                        </div>

                    </div>
                </div>
                <ul class="list-group" id="fullRepList"></ul>

                <!-- Drill-down task table (shown when a rep is clicked) -->
                <div id="repTaskTableContainer" class="mt-4" style="display:none;">
                    <h6 class="fw-semibold mb-2" id="repTaskTableTitle">Task Details</h6>
                    <div class="table-responsive table-nowrap">
                        <table class="table border align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Task Type</th><th>Status</th><th>Due Date</th>
                                    <th>Customer Name</th><th>Assigned To</th><th>Assigned By</th>
                                    <th>Created By</th><th>Email</th>
                                    <th>Cell</th><th>Home</th><th>Work</th>
                                    <th>Vehicle</th><th>Lead Type</th><th>Deal Type</th>
                                    <th>Source</th><th>Inventory Type</th>
                                    <th>Lead Status</th><th>Sales Status</th><th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody id="repTaskDetailsBody">
                                <tr><td colspan="19" class="text-center text-muted">Click a rep above to view their tasks</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rep Detail Modal -->
<div class="modal fade" id="repDetailModal" tabindex="-1" aria-labelledby="repDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Completed Appointments - <span id="repNameTitle"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select w-auto widgetdateFilter">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" id="includePrimus" />
                            <label class="form-check-label" for="includePrimus">Include Primus CRM</label>
                        </div>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-nowrap mt-2">
                    <table class="table border">
                        <thead class="table-light">
                            <tr>
                                <th>Lead Status</th>
                                <th>Sales Status</th>
                                <th>Completed Appointment Date/Time</th>
                                <th>Created Appointment Date/Time</th>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Created By</th>
                                <th>Email Address</th>
                                <th>Cell Number</th>
                                <th>Home Number</th>
                                <th>Work Number</th>
                                <th>Vehicle</th>
                                <th>Lead Type</th>
                                <th>Deal Type</th>
                                <th>Source</th>
                                <th>Inventory Type</th>
                                <th>Sales Type</th>
                            </tr>
                        </thead>
                        <tbody id="repCustomerTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lost Reasons Modal -->
<div class="modal fade" id="lostListModal" tabindex="-1" aria-labelledby="lostListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All Sub-Lost Lead Reasons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <a href="javascript:void(0);" onclick="window.print()"
                        class="btn btn-light border border-1 d-flex align-items-center">
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

                </div>
                <ul class="list-group mt-3" id="lostReasonList">
                    <!-- JS will populate this -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Lost Reason Details Modal -->
<div class="modal fade" id="lostReasonDetailModal" tabindex="-1" aria-labelledby="lostReasonDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lostReasonDetailTitle">Sub-Lost Lead Reason Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <select class="form-select w-auto widgetdateFilter">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Date</option>
                        </select>
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" id="includePrimus" />
                            <label class="form-check-label" for="includePrimus">Include Primus CRM</label>
                        </div>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                        <a href="javascript:void(0);" onclick="window.print()"
                            class="btn btn-light border border-1 d-flex align-items-center">
                            <i class="isax isax-printer me-1"></i>Print
                        </a>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="btn btn-outline-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="isax isax-export-1 me-1"></i>Export
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
                                <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3 table-nowrap">
                    <table class="table border">
                        <thead class="table-light">
                            <tr>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Created By</th>
                                <th>Email</th>
                                <th>Cell Number</th>
                                <th>Home Number</th>
                                <th>Work Number</th>
                                <th>Vehicle</th>
                                <th>Lead Type</th>
                                <th>Deal Type</th>
                                <th>Source</th>
                                <th>Inventory Type</th>
                                <th>Sales Type</th>
                                <th>Sub-Lost Lead Reason</th>
                                <th>Lead Status</th>
                                <th>Sales Status</th>
                                <th>Created Date</th>
                                <th>Lost Date/Time</th>
                            </tr>
                        </thead>
                        <tbody id="lostReasonDetailTable">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="lostReasonModal" class="lost-modal-backdrop" style="display:none;">
    <div class="lost-modal">
        <h6 class="mb-2 text-center">Why are we marking this lead lost?</h6>
        <select id="lostReasonSelect" class="form-select form-select-sm mb-3">
            <option value="" disabled selected hidden>-- Select Reason --</option>
            <option value="Bad Credit">Bad Credit</option>
            <option value="Bad Email">Bad Email</option>
            <option value="Bad Phone Number">Bad Phone Number</option>
            <option value="Did Not Respond">Did Not Respond</option>
            <option value="Diff Dealer, Diff Brand">Diff Dealer, Diff Brand</option>
            <option value="Diff Dealer, Same Brand">Diff Dealer, Same Brand</option>
            <option value="Diff Dealer, Same Group">Diff Dealer, Same Group</option>
            <option value="Import Lead">Import Lead</option>
            <option value="No Agreement Reached">No Agreement Reached</option>
            <option value="No Credit">No Credit</option>
            <option value="No Longer Owns">No Longer Owns</option>
            <option value="Other Salesperson Lead">Other Salesperson Lead</option>
            <option value="Out of Market">Out of Market</option>
            <option value="Requested No More Contact">Requested No More Contact</option>
            <option value="Service Lead">Service Lead</option>
            <option value="Sold Privately">Sold Privately</option>
        </select>

        <div class="text-center">
            <button class="btn btn-primary btn-sm" id="saveLostReason">Save</button>
            <button class="btn btn-light btn-sm" id="cancelLostReason">Cancel</button>
        </div>
    </div>
</div>
<div id="customDateContainer" class="d-none border p-3 bg-white shadow position-absolute" style="z-index: 9999;">
    <!-- Add data-datepicker-id attributes and makatadob-datepicker class -->
    <input type="text" class="form-control custom-from mb-2 cf-datepicker" placeholder="From Date" readonly>
    <input type="text" class="form-control custom-to mb-2 cf-datepicker " placeholder="To Date" readonly>
    <button class="btn btn-primary w-100 applyCustomDate">Apply</button>
</div>
