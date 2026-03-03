                <div class="widgets-area category-outcome">
                    <div class="widgets-container">

                        <div class="widget-card d-flex" data-widget-id="last-login">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Last Login & Last Update</p>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="last-login"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#lastLoginModal">View</h6>

                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="contact-rate">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Contact Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Percentage calculated as: (Contacted Leads / Total Leads) × 100"></i>

                                        </p>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="contact-rate"></i>
                                        </div>
                                    </div>

                                    <!-- Clickable View -->
                                    <h6 class="fs-16 fw-semibold mb-0 text-primary" id="viewContactRate"
                                        style="cursor:pointer;" data-bs-toggle="modal"
                                        data-bs-target="#contactRateModal">
                                        —
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="contactRateModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Contact Rate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                        <!-- Ratio Display -->
                                        <div class="text-center mb-4">
                                            <h5>Contact Rate</h5>
                                            <p class="fs-3 fw-bold mb-1"><span id="contactPercentage">0</span>%</p>
                                            <small><span id="contactedLeads">0</span> Contacted / <span
                                                    id="totalLeads">0</span> Total
                                                Leads</small>
                                        </div>

                                        <div class="text-center mb-3">
                                            <button class="btn btn-light border border-1 btn-sm"
                                                id="showContactTableBtn">Show
                                                Details</button>
                                        </div>

                                        <!-- Table Section -->
                                        <div id="contactTableSection" class="mt-4" style="display:none;">
                                            <h6 class="fw-semibold mb-2">Lead Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Contacted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contactRateDetailsBody">
                                                        <!-- JS fills this -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="appointments-showed-rate">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Appointments
                                            Showed Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Appointment Showed % = (Completed Appointments/Total Appointments) x 100"></i>

                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle"
                                                data-widget-id="appointments-showed-rate"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="apptsShowedRateValue" data-bs-toggle="modal"
                                        data-bs-target="#appointmentsShowedRateModal">—</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="appointmentsShowedRateModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Appointments Showed Rate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                        <div id="appointmentsShowedRateChart"></div>

                                        <!-- Table -->
                                        <div class="mt-4">
                                            <h6 class="fw-semibold mb-2">Appointment Showed Details</h6>
                                            <div class="table-responsive table-nowrap ">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Task Type</th>
                                                            <th>Status</th>
                                                            <th>Due Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Cell Number</th>
                                                            <th>Work Number</th>
                                                            <th>Home Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="appointmentsShowedRateBody">
                                                        <!-- Filled by JS -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex widget-list-card" data-widget-id="appts-per-rep">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-0">
                                        <div>
                                            <p class="mb-0">Completed Appointments<br>Per Rep</p>

                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="appts-per-rep"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-2 fs-16 fw-semibold text-center cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#repListModal">Top 5</h6>
                                    <!-- Top 5 list -->
                                    <ul class="list-group" id="topRepList"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="widget-card d-flex widget-list-card" data-widget-id="lost-lead-reasons">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-0">Sub-Lost Lead Reasons</p>

                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="lost-lead-reasons"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-2 fs-16 fw-semibold text-center cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#lostListModal">Top 5</h6>
                                    <!-- Top 5 list -->
                                    <ul class="list-group list-group-flush" id="lostReasonWidgetList">
                                </div>
                            </div>
                        </div>
                        <div class="widget-card d-flex" data-widget-id="task-completion-rate">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Task Completion
                                            Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Task Completion % = (Completed Tasks/Total Tasks) x 100"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="task-completion-rate"></i>
                                        </div>
                                    </div>
                                    <!-- Clickable View -->
                                    <h6 class="fs-16 fw-semibold mb-0 text-primary" id="viewTaskCompletion"
                                        style="cursor:pointer;" data-bs-toggle="modal"
                                        data-bs-target="#taskCompletionRateModal">
                                        —
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="taskCompletionRateModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Task Completion Rate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ratio section -->
                                        <div class="text-center mb-4">
                                            <h5>Task Completion Rate</h5>
                                            <p class="fs-3 fw-bold mb-1"><span id="completionPercentage">0</span>%</p>
                                            <small><span id="completedTasks">0</span> Completed Tasks / <span
                                                    id="openTasks">0</span> Open
                                                Tasks</small>
                                        </div>

                                        <div class="text-center mb-3">
                                            <button class="btn btn-light border border-1 btn-sm" id="showTableBtn">Show
                                                Details</button>
                                        </div>

                                        <!-- Table Section -->
                                        <div id="taskTableSection" class="mt-4" style="display:none;">
                                            <h6 class="fw-semibold mb-2">Task Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Task Type</th>
                                                            <th>Assigned To</th>
                                                            <th>Status Type</th>
                                                            <th>Due Date</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Contacted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="taskCompletionRateDetailsBody">
                                                        <!-- JS will fill this -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="speedToSaleModal" tabindex="-1"
                            aria-labelledby="speedToSaleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div
                                        class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                                        Speed-to-Sale Tracker
                                        <button type="button" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="isax isax-close-circle"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dealflow-card">
                                            <div class="">
                                                <!-- Metrics row -->
                                                <div id="speedMetrics"
                                                    class="d-flex flex-wrap align-items-stretch gap-2">

                                                    <!-- Metric: Speed-to-Lead -->
                                                    <div class="stage-wrapper">
                                                        <div class="stage card p-3 clickable-assigned"
                                                            data-stage="speedToLead">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <div class="count" data-key="speedToLead">75 min
                                                                    </div>
                                                                    <div class="label">Speed to Lead</div>
                                                                </div>
                                                                <span class="badge conv-badge"
                                                                    data-from="speedToLead">—</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        data-bar="speedToLead"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-text-below" style="margin-left: 8px;">
                                                            Lead Received → First Response to Customer
                                                        </div>
                                                    </div>

                                                    <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                                                    <!-- Metric: Response Time -->
                                                    <div class="stage-wrapper">
                                                        <div class="stage card p-3 clickable-assigned"
                                                            data-stage="responseTime">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <div class="count" data-key="responseTime">320 min
                                                                    </div>
                                                                    <div class="label">Response Time</div>
                                                                </div>
                                                                <span class="badge conv-badge"
                                                                    data-from="responseTime">—</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        data-bar="responseTime"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-text-below" style="margin-left: 8px;">
                                                            First Response to Customer → First Appointment Open
                                                        </div>
                                                    </div>

                                                    <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                                                    <!-- Metric: Conversion Time -->
                                                    <div class="stage-wrapper">
                                                        <div class="stage card p-3 clickable-assigned"
                                                            data-stage="conversionTime">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <div class="count" data-key="conversionTime">1240
                                                                        min</div>
                                                                    <div class="label">Conversion Time</div>
                                                                </div>
                                                                <span class="badge conv-badge"
                                                                    data-from="conversionTime">—</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        data-bar="conversionTime"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-text-below" style="margin-left: 8px;">
                                                            Appointment Booked (Open) → Sold
                                                        </div>
                                                    </div>

                                                    <div class="flow-arrow"><i class="bi bi-arrow-right"></i></div>

                                                    <!-- Metric: Average Conversion Rate -->
                                                    <div class="stage-wrapper">
                                                        <div class="stage card p-3 clickable-assigned"
                                                            data-stage="conversionRate">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <div class="count" data-key="conversionRate">6.2
                                                                        Days</div>
                                                                    <div class="label">Average Conversion Rate</div>
                                                                </div>
                                                                <span class="badge conv-badge"
                                                                    data-from="conversionRate">—</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        data-bar="conversionRate"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-text-below" style="margin-left: 8px;">
                                                            Lead Received → Sold (in Days)
                                                        </div>
                                                    </div>

                                                </div>

                                                <style>
                                                    .stage-wrapper .stage {
                                                        flex: 1;
                                                    }

                                                    .stage-wrapper {
                                                        flex: 0 0 15%;
                                                        max-width: 15%;
                                                    }

                                                    /* Cards styling */
                                                    .stage .count {
                                                        font-size: 18px;
                                                        font-weight: 700;
                                                        line-height: 1;
                                                    }

                                                    .stage .label {
                                                        font-size: 12px;
                                                        color: #6c757d;
                                                    }

                                                    .flow-arrow {
                                                        flex: 0 0 auto;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        width: 44px;
                                                    }

                                                    .flow-arrow i {
                                                        font-size: 1.25rem;
                                                        color: #adb5bd;
                                                    }

                                                    .conv-badge {
                                                        font-size: 10px;
                                                        background: rgb(0, 33, 64);
                                                        border: 1px solid #e9ecef;
                                                        color: white;
                                                    }

                                                    .progress {
                                                        height: .4rem;
                                                        background: #f1f3f5;
                                                    }

                                                    .progress-bar {
                                                        transition: width .4s ease;
                                                    }

                                                    /* Text below card */
                                                    .card-text-below {
                                                        margin-top: 0.35rem;
                                                        text-align: center;
                                                        font-size: 10px;
                                                        font-weight: 500;
                                                        color: #6c757d;
                                                        width: 100%;
                                                    }

                                                    /* Stack arrows vertically on very small screens */
                                                    @media (max-width: 575.98px) {
                                                        .flow-arrow {
                                                            width: 100%;
                                                            padding: .25rem 0;
                                                        }

                                                        .flow-arrow i {
                                                            transform: rotate(90deg);
                                                        }

                                                        .card-text-below {
                                                            font-size: 0.8rem;
                                                        }
                                                    }

                                                    .clickable-assigned {
                                                        cursor: pointer;
                                                    }

                                                    .clickable-assigned:hover {
                                                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                                                    }

                                                    .time-column {
                                                        font-weight: 600;
                                                    }
                                                </style>

                                                <!-- Footer stats -->
                                                <div class="mt-3 d-flex flex-wrap gap-3">
                                                    <div class="small text-secondary">
                                                        Time metrics show average duration for each phase. Bars visualize
                                                        performance vs target.
                                                    </div>
                                                    <div class="ms-auto small">
                                                        <span class="me-3">Avg Sales Cycle: <strong>3.0 Days (72
                                                                hours/4320
                                                                minutes)</strong></span>
                                                    </div>
                                                </div>

                                                <!-- Table (hidden by default, placed inside modal-body, below your dealflow-card) -->
                                                <div id="stageDetails" class="mt-4" style="display: none;">
                                                    <h6 id="stageTitle" class="mb-2"></h6>
                                                    <div class="table-responsive table-nowrap">
                                                        <table class="table border">
                                                            <thead class="table-light">
                                                                <tr id="tableHeaderRow">
                                                                    <!-- Base columns -->
                                                                    <th>Lead Status</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Created Appointment Date/Time</th>
                                                                    <th>Customer Name</th>
                                                                    <!-- Time column will be inserted here dynamically -->
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
                                                            <tbody id="stageTableBody"></tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="speed-to-sale">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <p class="mb-1">Speed-to-Sale Tracker</p>
                                            <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                                data-bs-target="#speedToSaleModal">View
                                            </h6>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="speed-to-sale"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="finance-penetration">
                            <div class="card flex-fill" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Finance Contact
                                            Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Finance Deals / Total Deals"></i>
                                        </p>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="finance-penetration"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="financeRateValue" data-bs-toggle="modal"
                                        data-bs-target="#financePenetrationModal">—
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="financePenetrationModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Finance Contact Rate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ratio Display -->
                                        <div class="text-center mb-4">
                                            <h5>Finance Penetration</h5>
                                            <p class="fs-3 fw-bold mb-1"><span
                                                    id="financePenetrationPercentage">0</span>%</p>
                                            <small><span id="contactedLeadsFinancePenetration">0</span> Finance Deals /
                                                <span id="financePenetrationTotalLeads">0</span> Total Deals</small>
                                        </div>

                                        <div class="text-center mb-3">
                                            <button class="btn btn-light border border-1 btn-sm"
                                                id="showFinancePenetrationTableBtn">Show
                                                Details</button>
                                        </div>

                                        <!-- Table Section -->
                                        <div id="financePenetrationTableSection" class="mt-4" style="display:none;">
                                            <h6 class="fw-semibold mb-2">Deals Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Contacted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="financePenetrationDetailsBody">
                                                        <!-- JS fills this -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Store Visit Closing Ratio Widget -->
                        <div class="widget-card d-flex" data-widget-id="store-visit-closing-ratio">
                            <div class="card flex-fill" data-bs-toggle="modal"
                                data-bs-target="#storeVisitClosingRatioModal">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Store Visit
                                            Closing Ratio
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Closed Store Visits / Total Store Visits"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle"
                                                data-widget-id="store-visit-closing-ratio"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#storeVisitClosingRatioModal" id="storeVisitClosingRatioPercentageCount">0%</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Store Visit Closing Ratio Modal -->
                        <div class="modal fade" id="storeVisitClosingRatioModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Store Visit Closing Ratio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ratio Display -->
                                        <div class="text-center mb-4">
                                            <h5>Store Visit Closing Ratio</h5>
                                            <p class="fs-3 fw-bold mb-1"><span
                                                    id="storeVisitClosingRatioPercentage">0</span>%</p>
                                            <small><span id="closedStoreVisits">0</span> Closed Store Visits / <span
                                                    id="totalStoreVisits">0</span> Total Store Visits</small>
                                        </div>

                                        <div class="text-center mb-3">
                                            <button class="btn btn-light border border-1 btn-sm"
                                                id="showStoreVisitClosingRatioTableBtn">Show Details</button>
                                        </div>

                                        <!-- Table Section -->
                                        <div id="storeVisitClosingRatioTableSection" class="mt-4"
                                            style="display:none;">
                                            <h6 class="fw-semibold mb-2">Store Visits Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Task Type</th>
                                                            <th>Status</th>
                                                            <th>Due Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Date</th>
                                                            <th>Closed</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="storeVisitClosingRatioDetailsBody">
                                                        <!-- JS fills this -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lease Contact Rate Widget -->
                        <div class="widget-card d-flex" data-widget-id="lease-penetration">
                            <div class="card flex-fill" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Lease Contact
                                            Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lease Deals / Total Deals"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="lease-penetration"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#leasePenetrationModal" id="leasePenetrationPercentageCount">--
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Lease Penetration Modal -->
                        <div class="modal fade" id="leasePenetrationModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Lease Contact Rate</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
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
                                                        <li><a class="dropdown-item" href="#">Excel (XLSX)</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ratio Display -->
                                        <div class="text-center mb-4">
                                            <h5>Lease Contact Rate</h5>
                                            <p class="fs-3 fw-bold mb-1"><span id="leasePenetrationPercentage">0</span>%
                                            </p>
                                            <small><span id="contactedLeadsLeasePenetration">0</span> Lease Deals / <span
                                                    id="leasePenetrationTotalLeads">0</span> Total Deals</small>
                                        </div>

                                        <div class="text-center mb-3">
                                            <button class="btn btn-light border border-1 btn-sm"
                                                id="showLeasePenetrationTableBtn">Show
                                                Details</button>
                                        </div>

                                        <!-- Table Section -->
                                        <div id="leasePenetrationTableSection" class="mt-4" style="display:none;">
                                            <h6 class="fw-semibold mb-2">Deals Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Contacted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="leasePenetrationDetailsBody">
                                                        <!-- JS fills this -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="beback-customer">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Beback Customer</p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="beback-customer"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="bebackCount" data-bs-toggle="modal"
                                        data-bs-target="#bebackCustomerModal">—</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Beback Customer Modal -->
                        <div class="modal fade" id="bebackCustomerModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Beback Customers</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
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

                                        <!-- Table Section -->
                                        <div class="table-responsive table-nowrap mt-3">
                                            <table class="table border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Lead Status</th>
                                                        <th>Sales Status</th>
                                                        <th>Created Lead Date/Time</th>
                                                        <th>Customer Name</th>
                                                        <th>Assigned To</th>
                                                        <th>Assigned By</th>
                                                        <th>Created By</th>
                                                        <th>Email Address</th>
                                                        <th>Cell Number</th>
                                                        <th>Home Number</th>
                                                        <th>Work Number</th>
                                                        <th>Year/Make/Model</th>
                                                        <th>Lead Type</th>
                                                        <th>Deal Type</th>
                                                        <th>Source</th>
                                                        <th>Inventory Type</th>
                                                        <th>Sales Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bebackCustomerDetailsBody">
                                                    <!-- Data will be populated by JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex widget-list-card" data-widget-id="sold-deal-sources">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-0">Sold Deal Sources</p>

                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="sold-deal-sources"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-2 fs-16 fw-semibold cursor-pointer text-center" data-bs-toggle="modal"
                                        data-bs-target="#soldDealSourcesModal">Top 5</h6>
                                    <table class="table table-sm mt-2">
                                        <tbody id="sdsWidgetTable"><!-- JS fills Top 5 here --></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Sold Deal Sources Modal -->
                        <div class="modal fade" id="soldDealSourcesModal" tabindex="-1"
                            aria-labelledby="soldDealSourcesModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sold Deal Sources</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
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
                                        <div class="table-responsive table-nowrap mt-2">
                                            <table class="table border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Source</th>
                                                        <th>Conversion %</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sdsModalTable"><!-- JS fills all items here --></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sold Deal Sources Drill-Down Modal -->
                        <div class="modal fade" id="soldDealSourcesDrillDownModal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Conversion Breakdown - <span
                                                id="sdsDrillDownSourceTitle"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
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

                                        <div class="table-responsive table-nowrap mt-3">
                                            <table class="table border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Lead Status</th>
                                                        <th>Sales Status</th>
                                                        <th>Created Lead Date/Time</th>
                                                        <th>Customer Name</th>
                                                        <th>Assigned To</th>
                                                        <th>Assigned By</th>
                                                        <th>Created By</th>
                                                        <th>Email Address</th>
                                                        <th>Cell Number</th>
                                                        <th>Home Number</th>
                                                        <th>Work Number</th>
                                                        <th>Year/Make/Model</th>
                                                        <th>Lead Type</th>
                                                        <th>Deal Type</th>
                                                        <th>Source</th>
                                                        <th>Inventory Type</th>
                                                        <th>Sales Type</th>
                                                        <th>Conversion %</th>
                                                        <th>Actual Number</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sdsDrillDownTable">
                                                    <!-- JS fills this -->
                                                </tbody>
                                                <tfoot class="table-info">
                                                    <tr>
                                                        <td colspan="17" class="text-end fw-bold">Total Conversion
                                                        </td>
                                                        <td class="fw-bold">100%</td>
                                                        <td class="fw-bold" id="sdsTotalActualNumber">0</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex widget-list-card" data-widget-id="pending-fi-deals-aging">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-0">Pending F&I Leads Aging</p>

                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle"
                                                data-widget-id="pending-fi-deals-aging"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-2 fs-16 fw-semibold text-center cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#pendingFIDealsModal">Top 5 </h6>
                                    <div class="table-responsive table-nowrap">
                                        <table class="table table-sm mb-0 border">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Days</th>
                                                    <th>Vehicle</th>

                                                </tr>
                                            </thead>
                                            <tbody id="pendingFIDealsWidget">
                                                <!-- Top 5 will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending F&I Deals Modal -->
                        <div class="modal fade" id="pendingFIDealsModal" tabindex="-1"
                            aria-labelledby="pendingFIDealsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pending F&I Leads Aging</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
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

                                        <div class="table-responsive table-nowrap mt-2">
                                            <table class="table border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Vehicle</th>
                                                        <th>Days Pending</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pendingFIDealsTable">
                                                    <!-- All deals will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Store Visit Leads Aging Widget -->
                        <div class="widget-card d-flex widget-list-card" data-widget-id="store-visit-deals-aging">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <p class="mb-0">Store Visit Leads Aging</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle"
                                                data-widget-id="store-visit-deals-aging"></i>
                                        </div>
                                    </div>
                                    <h6 class="mb-2 fs-16 fw-semibold text-center cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#storeVisitDealsModal">Top 5</h6>
                                    <div class="table-responsive table-nowrap">
                                        <table class="table table-sm mb-0 border">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Days</th>
                                                    <th>Vehicle</th>
                                                </tr>
                                            </thead>
                                            <tbody id="storeVisitDealsWidget">
                                                <!-- Top 5 will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Store Visit Leads Aging Modal -->
                        <div class="modal fade" id="storeVisitDealsModal" tabindex="-1"
                            aria-labelledby="storeVisitDealsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Store Visit Leads Aging</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                                            <a href="javascript:void(0);" onclick="window.printStoreVisitDeals()"
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
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="exportStoreVisitDeals('pdf')">PDF</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="exportStoreVisitDeals('xlsx')">Excel (XLSX)</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="exportStoreVisitDeals('csv')">Excel (CSV)</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="table-responsive table-nowrap mt-2">
                                            <table class="table border">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Vehicle</th>
                                                        <th>Days Pending</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="storeVisitDealsTable">
                                                    <!-- All deals will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Favourites Category -->
                <div class="widgets-area category-favourites">
                    <div class="widgets-container col-md-12" id="favorites-container">

                    </div>
                </div>
            </div>
        </div>

        <!-- end row -->

        <!-- start row -->

        <!-- end row -->

        <!-- start row -->

        <!-- end row -->
    </div>

</div>
</div>
<!-- Favourites Category -->
<div class="widgets-area category-favourites">
    <div class="widgets-container col-md-12" id="favorites-container">

    </div>
</div>
</div>
</div>

</div>
