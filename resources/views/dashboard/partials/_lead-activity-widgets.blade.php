                    <div id="widgets-container" class="widgets-container">
                        <!-- WIDGETS -->
                        <div class="widget-card d-flex widget-list-card" data-widget-id="internet-response">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start ">
                                        <p class="mb-1">Internet Response Time</p>
                                        <div class="d-flex gap-2">

                                            <!-- star icon with toggle -->
                                            <i class="ti ti-star star-toggle" data-widget-id="internet-response"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#internetresponsetimeModal">
                                        View</h6>
                                    <div class="mt-2 internet-response-card-span">
                                        <ul>
                                            <li>Responded in 0–5 Mins – <span id="irt-0-5">—</span></li>
                                            <li>Responded in 6–10 Mins – <span id="irt-6-10">—</span></li>
                                            <li>Responded in 11–15 Mins – <span id="irt-11-15">—</span></li>
                                            <li>Responded in 16–30 Mins – <span id="irt-16-30">—</span></li>
                                            <li>Responded in 31–60 Mins – <span id="irt-31-60">—</span></li>
                                            <li>Responded in 61+ Mins – <span id="irt-61plus">—</span></li>
                                            <li>No Contact Made – <span id="irt-no-contact">—</span></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="deal-flow">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>

                                            <p class="mb-1 d-flex justify-content-normal align-items-center">Lead Flow
                                                <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Uncontacted → Lost"></i>

                                            </p>

                                            <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                                data-bs-target="#dealflowModal">View</h6>
                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="deal-flow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="sales-funnel">
                            <div class="card overflow-hidden z-1 flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <p class="mb-1 d-flex justify-content-normal align-items-center">Leads Funnel
                                                <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Customers → Contacted → Appt Set → Appt Shown → Sold"></i>
                                            </p>
                                            <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                                data-bs-target="#salesfunnelModal">View
                                            </h6>
                                        </div>
                                        <div class="d-flex gap-2">

                                            <i class="ti ti-star star-toggle" data-widget-id="sales-funnel"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Widget -->
                        <div class="widget-card d-flex" data-widget-id="new-leads">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Uncontacted Leads
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Uncontacted Sales Status Leads"></i>

                                        </p>
                                        <i class="ti ti-star star-toggle"></i>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="newLeadsCount" data-bs-toggle="modal" data-bs-target="#newLeadsModal">
                                        —</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="newLeadsModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Uncontacted Leads</h5>
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
                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="newLeadsChart"></div>
                                        </div>

                                        <div id="newLeadsTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2" id="leadTableTitle">Lead Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <!-- Most Important Info - Left Side -->
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Email Address</th>

                                                            <!-- Secondary Info - Middle -->
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Assigned By</th>

                                                            <!-- Less Important Info - Right Side -->
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="newLeadsDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .apexcharts-tooltip {
                                background: #fff;
                                border: 1px solid #e3e3e3;
                                border-radius: 4px;
                                color: #000;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            }

                            .custom-tooltip {
                                background: white;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                padding: 10px;
                                min-width: 200px !important;

                                color: #000 !important;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            }

                            .custom-tooltip-title {
                                font-weight: bold;
                                margin-bottom: 8px;
                                text-align: center !important;
                                color: #000 !important;
                                border-bottom: 1px solid #eee;
                                padding-bottom: 5px;
                            }

                            .custom-tooltip-item span {
                                color: #000 !important;
                            }

                            .custom-tooltip-item {
                                display: flex;
                                color: #000 !important;
                                justify-content: space-between;
                                margin-bottom: 3px;
                            }
                        </style>

                        <!-- Internet Leads Widget -->
                        <div class="widget-card d-flex" data-widget-id="internet-leads">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Internet Leads</p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="internet-leads"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="internetLeadsCount" data-bs-toggle="modal"
                                        data-bs-target="#internetLeadsModal">—
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <!-- Internet Leads Modal -->
                        <div class="modal fade" id="internetLeadsModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Internet Leads</h5>
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

                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="internetLeadsChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="internetLeadsTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2" id="internetLeadTableTitle">Lead Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="internetLeadsDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Walk-Ins Widget -->
                        <div class="widget-card d-flex" data-widget-id="walk-in">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Walk-In Leads</p>
                                        <i class="ti ti-star star-toggle" data-widget-id="walk-in"></i>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="walkInCount" data-bs-toggle="modal"
                                        data-bs-target="#walkInModal">50</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Walk-Ins Modal -->
                        <div class="modal fade" id="walkInModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Walk-In Leads</h5>
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

                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="walkInChart" style="height: 420px;"></div>
                                        </div>

                                        <!-- Breakdown Table -->
                                        <div id="walkInDetailsTable" class="mt-4" style="display:none;">
                                            <h6 class="mb-3" id="walkInTableTitle">Lead Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Deal Type</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="walkInDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            /* force ApexCharts bars to stay solid color */
                            #walkInChart .apexcharts-bar-series path {
                                fill: rgb(0, 33, 64) !important;
                                fill-opacity: 1 !important;
                            }

                            #walkInChart .apexcharts-bar-series path:hover {
                                fill: rgb(0, 33, 64) !important;
                                fill-opacity: 1 !important;
                            }

                            #walkInChart .apexcharts-bar-series .apexcharts-active path {
                                fill: rgb(0, 33, 64) !important;
                                fill-opacity: 1 !important;
                            }
                        </style>
                        <!-- Lead Types Widget -->
                        <div class="widget-card d-flex" data-widget-id="lead-types-widget">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Lead Types
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Internet, Walk-In, Phone Up, Text Up, Service, Import,Wholesale."></i>

                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="lead-types-widget"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#leadTypesModal">View</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Lead Types Modal -->
                        <div class="modal fade" id="leadTypesModal" tabindex="-1" aria-labelledby="leadTypesModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div
                                        class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                                        Lead Types
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
                                        </div> <!-- Filter + Export -->

                                        <div class="chart-holder">
                                            <!-- Chart -->
                                            <div id="leadTypesChart"></div>
                                            <div id="leadTypesLegend"
                                                class="d-flex justify-content-center gap-3 mt-3 flex-wrap"></div>
                                        </div>

                                        <!-- Lead Details Table (hidden by default) -->
                                        <div id="leadTypesTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2" id="leadTypeTableTitle">Deal Details</h6>
                                            <div class="table-responsive table-nowrap"
                                                style="max-height: 400px; overflow-y: auto;">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th><th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th><th>Assigned By</th>
                                                            <th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th><th>Home Number</th><th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th><th>Deal Type</th>
                                                            <th>Source</th><th>Inventory Type</th><th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="leadTypesDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->

                        <!-- ================= OVERDUE TASKS WIDGET ================= -->
                        <div class="widget-card d-flex" data-widget-id="overdue-tasks">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Missed (Overdue)
                                            Tasks
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Overdue Appts/Calls/Emails/Texts/CSI/Other"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="overdue-tasks"></i>
                                        </div>
                                    </div>
                                    <!-- View link -->
                                    <h6 class="fs-16 fw-semibold text-primary cursor-pointer">
                                        <span id="overdue-count" data-bs-toggle="modal"
                                            data-bs-target="#overdueTaskModal">20</span>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- ================= MODAL ================= -->
                        <div class="modal fade" id="overdueTaskModal" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Missed (Overdue) Tasks</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                            <!-- Left side -->
                                            <div class="d-flex gap-3 align-items-center flex-wrap">
                                                <select class="form-select w-auto widgetdateFilter">
                                                    <option value="today">Today</option>
                                                    <option value="yesterday">Yesterday</option>
                                                    <option value="last7">Last 7 Days</option>
                                                    <option value="thisMonth">This Month</option>
                                                    <option value="lastMonth">Last Month</option>
                                                    <option value="custom">Custom Date</option>
                                                </select>
                                                <div style="position:relative;">

                                                    <div class="d-flex align-items-center gap-1">
                                                        <label class="form-label mb-0 me-1">Missed After (hrs):</label>
                                                        <input id="missedHours" type="number" min="0"
                                                            max="999" value="8"
                                                            class="form-control form-control-sm d-inline-block"
                                                            style="width:100px">
                                                        <button id="saveMissedHours" class="btn btn-primary ms-1">
                                                            <div class="loading-spinner" id="saveLoading"
                                                                style="display:none;"></div>
                                                            Save
                                                        </button>
                                                    </div>
                                                    <span id="missedSaved" class="badge bg-success"
                                                        style="position:absolute;right:-70px;top:2px;display:none;">Saved</span>
                                                </div>
                                                <div class="form-check ms-2">
                                                    <input class="form-check-input" type="checkbox" id="includePrimus" />
                                                    <label class="form-check-label" for="includePrimus">Include Primus
                                                        CRM</label>
                                                </div>
                                            </div>

                                            <!-- Right side -->
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
                                        <!-- Success message (hidden by default) -->
                                        <div id="saveSuccessMessage"
                                            class="alert alert-success alert-dismissible fade show success-message"
                                            role="alert" style="display:none;">
                                            <i class="bi bi-check-circle me-2"></i> Missed hours value saved successfully!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>

                                        <!-- Chart container with loading state -->
                                        <!-- Chart -->
                                        <div class="chart-holder mb-4">
                                            <div id="overdueTasksChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="overdueTaskTableContainer" class="mt-4 d-none">
                                            <h6 id="overdueTaskTableTitle" class="fw-semibold mb-2">Task Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Task Type</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Created Task Date/Time</th>
                                                            <th>Inbound or Outbound</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="overdueTaskDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .loading-spinner {
                                display: inline-block;
                                width: 16px;
                                height: 16px;
                                border: 2px solid #ffffff;
                                border-radius: 50%;
                                border-top-color: transparent;
                                animation: spin 1s linear infinite;
                                margin-right: 5px;
                            }

                            @keyframes spin {
                                0% {
                                    transform: rotate(0deg);
                                }

                                100% {
                                    transform: rotate(360deg);
                                }
                            }

                            .success-message {
                                transition: opacity 0.3s ease;
                            }
                        </style>

                        <!-- ================= OPEN TASKS WIDGET ================= -->
                        <div class="widget-card d-flex" data-widget-id="open-tasks-1">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Open Tasks
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Open Appts/Calls/Emails/Texts/CSI/Other"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="open-tasks-1"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold text-primary cursor-pointer" id="openTasksCount" data-bs-toggle="modal"
                                        data-bs-target="#tasksDonutModal">—</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="tasksDonutModal" tabindex="-1" aria-labelledby="tasksDonutLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="tasksDonutLabel">Open Tasks</h5>
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

                                        <!-- Donut Chart -->
                                        <div class="chart-holder">
                                            <div id="tasksDonutChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="openTaskTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2" id="openTaskTableTitle">Task Details</h6>
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
                                                            <th>Lead Status</th><th>Sales Status</th><th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="openTaskDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Widget Card -->
                        <div class="widget-card d-flex" data-widget-id="assigned-by">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Assigned By</p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="assigned-by"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#assignedByModal">View</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="assignedByModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Assigned By</h5>
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

                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="assignedByChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="assignedByTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2" id="assignedByTableTitle">Assigned Leads</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th><th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th><th>Assigned By</th><th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th><th>Home Number</th><th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th><th>Deal Type</th>
                                                            <th>Source</th><th>Inventory Type</th><th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="assignedByDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text Message Modal -->
                        <div class="modal fade" id="textMessageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Send Text Message</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">To:</label>
                                            <input type="text" class="form-control" id="textMessageTo" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message:</label>
                                            <textarea class="form-control" id="textMessageContent" rows="5" placeholder="Type your message here..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light border border-1"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="sendTextMessage">Send
                                            Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone Action Modal -->
                        <div class="modal fade" id="phoneActionModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog  modal-sm modal-dialog-centered">
                                <div class="modal-content border-2 border">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Phone Action</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="mb-3">
                                            <p class="mb-2" id="phoneActionNumber"></p>
                                            <p class="text-muted small">Choose an action for this number</p>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-primary" id="phoneCallAction">
                                                <i class="ti ti-phone me-2"></i>Call
                                            </a>
                                            <button class="btn btn-outline-primary" id="phoneTextAction">
                                                <i class="ti ti-message me-2"></i>Text Message
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Widget Card -->
                        <div class="widget-card d-flex" data-widget-id="appointments">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Appointments</p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="appointments"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" id="appointmentsCount" data-bs-toggle="modal"
                                        data-bs-target="#appointmentsModal">—</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="appointmentsModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Appointments</h5>
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

                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="appointmentsChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="appointmentsTableContainer" class="mt-4 d-none">
                                            <h6 id="appointmentsTableTitle" class="fw-semibold mb-2">Appointment Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Created Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th><th>Assigned By</th><th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th><th>Home Number</th><th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th><th>Deal Type</th>
                                                            <th>Source</th><th>Inventory Type</th><th>Sales Type</th>
                                                            <th>Lead Status</th><th>Sales Status</th><th>Status Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="appointmentsDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card d-flex" data-widget-id="purchase-types">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">
                                            Purchase Types
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Finance: 6 | Cash: 5 | Lease: 3 | Unknown: 2"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="purchase-types"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#purchaseTypesModal">View
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="purchaseTypesModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Purchase Types</h5>
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
                                        <!-- Chart -->
                                        <div class="chart-holder">
                                            <div id="purchaseTypesChart"></div>
                                        </div>

                                        <!-- Table -->
                                        <div id="purchaseTypesTableContainer" class="mt-4 d-none">
                                            <h6 id="purchaseTypesTableTitle" class="fw-semibold mb-2">Purchase Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Lead Status</th><th>Sales Status</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th><th>Assigned By</th><th>Created By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th><th>Home Number</th><th>Work Number</th>
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th><th>Deal Type</th>
                                                            <th>Source</th><th>Inventory Type</th><th>Sales Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="purchaseTypesDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Outcome Metrics Widgets -->