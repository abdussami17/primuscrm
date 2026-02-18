@extends('layouts.app')



@section('content')
    <div class="content home-page pt-0">
        <div id="alert-box-container">

        </div>
        <div class="d-flex d-block align-items-center justify-content-end flex-wrap gap-3 mb-0">

            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">



            </div>
        </div>
        <!-- Start Breadcrumb -->
        <div class="ai-header-container  pb-0 mb-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="min-height: 100px;">

                <!-- Left Side: Date + Hello Courtney -->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center text-muted small mb-1">
                        <div id="currentDate" class="me-3"></div>
                    </div>
                    <h1 class="fw-bold mb-0">Hello, {{ auth()->user()->name }}</h1>
                </div>

                <!-- Centered Logo -->
                <div class="position-absolute start-50 translate-middle-x text-center">
                    <img src="assets/light_logo.png" alt="Logo" class="logo-img mobile-logo-no"
                        style="max-width: 90px; opacity: 0.9;">
                </div>

                <!-- Right Side: User/Team Dropdown -->
                <div class="d-flex gap-2 align-items-center mt-3 mt-md-0">
                    <select id="selectDealership" class="form-select form-select-sm custom-user-dropdown">
                        <option>Select Dealership</option>

                        <option value="maple_auto_group">Maple Leaf Auto Group</option>
                        <option value="toronto_premium_motors">Toronto Premium Motors</option>
                        <option value="northshore_auto">Northshore Automotive</option>
                        <option value="vancouver_elite_cars">Vancouver Elite Cars</option>
                        <option value="prairie_drive">Prairie Drive Motors</option>
                        <option value="great_lakes_auto">Great Lakes Automotive</option>
                        <option value="canadian_choice_auto">Canadian Choice Auto</option>
                        <option value="aurora_motors">Aurora Motors</option>
                        <option value="polar_auto_group">Polar Auto Group</option>
                        <option value="rocky_mountain_motors">Rocky Mountain Motors</option>
                        <option value="niagara_auto_sales">Niagara Auto Sales</option>
                        <option value="true_north_motors">True North Motors</option>
                    </select>

                    <select id="userTeamDropdown" class="form-select form-select-sm custom-user-dropdown">
                        <option>Select All</option>

                        <option value="courtney">Courtney (You)</option>
                        <option value="ethan_martin">Ethan Martin</option>
                        <option value="olivia_brown">Olivia Brown</option>
                        <option value="liam_smith">Liam Smith</option>
                        <option value="emma_wilson">Emma Wilson</option>
                        <option value="noah_thompson">Noah Thompson</option>
                        <option value="ava_johnson">Ava Johnson</option>
                        <option value="lucas_white">Lucas White</option>
                        <option value="sophia_clark">Sophia Clark</option>
                        <option value="benjamin_taylor">Benjamin Taylor</option>
                        <option value="amelia_moore">Amelia Moore</option>
                        <option value="jackson_anderson">Jackson Anderson</option>

                    </select>
                </div>



            </div>
        </div>


        <!-- End Breadcrumb -->
        <div class="alert-bar mb-4 d-flex flex-wrap align-items-center justify-content-start  rounded shadow-sm">
            <div class="chip chip-red">Missed Leads: 4</div>
            <div class="chip chip-yellow">Avg Response Time: 7m</div>
            <div class="chip chip-green">Tasks Completed: 82%</div>
            <div class="chip chip-green">Sold Today: 6</div>
        </div>


        <div id="widgetContainer" class="mb-4">
            <div class="col-12">
                <!-- Category Buttons -->
                <div class="crm-header-widget d-flex  mb-3">
                    <div class="category-btn active" data-category="lead">Lead Activity Metrics <i
                            class="ti ti-caret-down-filled"></i></div>
                    <div class="category-btn" data-category="outcome">Outcome Metrics <i
                            class="ti ti-caret-down-filled"></i>
                    </div>
                    <div class="category-btn" data-category="favourites">Favourite Metrics <i
                            class="ti ti-caret-down-filled"></i></div>

                    <!-- Color Settings Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="colorSettingsBtn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            🎨 Widget Colors
                        </button>
                        <ul class="dropdown-menu p-3" aria-labelledby="colorSettingsBtn" style="min-width:220px;">
                            <li class="mb-2">
                                <label class="form-label">Border Color</label>
                                <input type="color" id="borderColorPicker" class="form-control form-control-color"
                                    value="#000000">
                            </li>
                            <li class="mb-2">
                                <label class="form-label">Background Color</label>
                                <input type="color" id="bgColorPicker" class="form-control form-control-color"
                                    value="#ffffff">
                            </li>
                            <li class="d-flex gap-2 mt-3">
                                <button id="resetColorsBtn" class="btn btn-light border border-1 flex-fill">Reset</button>
                                <button id="saveColorsBtn" class="btn btn-primary flex-fill">Save</button>

                            </li>

                        </ul>
                    </div>
                </div>
                <!-- Modal -->

                <!-- Lead Activity Widgets -->
                <div class="widgets-area category-lead active">
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
                                            <li>Responded in 0–5 Mins – 30</li>
                                            <li>Responded in 6–10 Mins – 25</li>
                                            <li>Responded in 11–15 Mins – 18</li>
                                            <li>Responded in 16–30 Mins – 20</li>
                                            <li>Responded in 31–60 Mins – 12</li>
                                            <li>Responded in 61+ Mins – 8</li>
                                            <li>No Contact Made – 10</li>
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
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal" data-bs-target="#newLeadsModal">
                                        100</h6>
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
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                function formatPhoneNumber(phone) {
                                    if (!phone) return '-';
                                    const digits = phone.replace(/\D/g, '');
                                    if (digits.length === 10)
                                        return `${digits.substring(0,3)}-${digits.substring(3,6)}-${digits.substring(6)}`;
                                    if (digits.length === 7) return `XXX-${digits.substring(0,3)}-${digits.substring(3)}`;
                                    if (digits.length > 0)
                                        return `${digits.substring(0,3)}-${digits.substring(3,6)}-${digits.substring(6,10)}`;
                                    return '-';
                                }

                                const hours12 = [];
                                for (let i = 0; i < 24; i++) {
                                    if (i === 0) hours12.push("12 AM");
                                    else if (i === 12) hours12.push("12 PM");
                                    else if (i < 12) hours12.push(`${i} AM`);
                                    else hours12.push(`${i - 12} PM`);
                                }

                                const leadTypes = ["Internet", "Walk-in", "Phone-up", "Text-up", "Service", "Import", "Wholesale"];
                                const leadsData = hours12.map(() => {
                                    const breakdown = {};
                                    let total = 0;
                                    leadTypes.forEach(type => {
                                        const count = Math.floor(Math.random() * 5);
                                        breakdown[type] = count;
                                        total += count;
                                    });
                                    if (total === 0) {
                                        const randomType = leadTypes[Math.floor(Math.random() * leadTypes.length)];
                                        breakdown[randomType] = 1;
                                        total = 1;
                                    }
                                    return {
                                        total,
                                        breakdown
                                    };
                                });
                                const leadsCount = leadsData.map(item => item.total);

                                const options = {
                                    series: [{
                                        name: "New Leads",
                                        data: leadsCount
                                    }],
                                    chart: {
                                        type: "bar",
                                        height: 420,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const hourIndex = config.dataPointIndex;
                                                const selectedHour = hours12[hourIndex];
                                                document.getElementById("leadTableTitle").innerText =
                                                    `Lead Details - ${selectedHour}`;

                                                // Show table
                                                document.getElementById("newLeadsTableContainer").classList.remove("d-none");
                                                document.getElementById("newLeadsTableContainer").scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });

                                                // Populate sample table
                                                const sampleData = [
                                                    ["Ali Khan", "Sara Ahmed", "ali.khan@example.com", "03001234567",
                                                        "0421234567", "0517654321", "John Smith (Manager)",
                                                        "2022 Toyota Corolla", "Internet", "Retail",
                                                        "Sep 19, 2025 10:15 AM", "Hot", "Open", "Facebook", "New", "Direct"
                                                    ]
                                                ];
                                                const tbody = document.getElementById("newLeadsDetailsBody");
                                                tbody.innerHTML = sampleData.map(row =>
                                                    "<tr>" + row.map((cell, index) => {
                                                        if (index === 3 || index === 4 || index === 5)
                                                            return `<td>${formatPhoneNumber(cell)}</td>`;
                                                        else if (index === 0)
                                                            return `<td data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas" class="fw-semibold text-black text-decoration-underline">${cell}</td>`;
                                                        else if (index === 7)
                                                            return `<td data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo" class="fw-semibold text-black text-decoration-underline">${cell}</td>`;
                                                        return `<td>${cell}</td>`;
                                                    }).join("") + "</tr>"
                                                ).join("");
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: "50%",
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"],
                                    dataLabels: {
                                        enabled: true,
                                        formatter: val => val === 0 ? "" : val.toString()
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: hours12,
                                        title: {
                                            text: "Hours of the Day"
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: "Leads Count"
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        custom: function({
                                            series,
                                            seriesIndex,
                                            dataPointIndex,
                                            w
                                        }) {
                                            const hour = hours12[dataPointIndex];
                                            const breakdown = leadsData[dataPointIndex].breakdown;
                                            const total = leadsData[dataPointIndex].total;

                                            let tooltipContent = `
                    <div class="custom-tooltip">
                      <div class="custom-tooltip-title">${hour} - ${total} leads</div>
                    `;
                                            Object.keys(breakdown).forEach(type => {
                                                if (breakdown[type] > 0) {
                                                    tooltipContent += `
                          <div class="custom-tooltip-item">
                            <span>${type}:</span>
                            <span>${breakdown[type]} leads</span>
                          </div>
                        `;
                                                }
                                            });
                                            tooltipContent += '</div>';
                                            return tooltipContent;
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#newLeadsChart"), options);
                                chart.render();
                            });
                        </script>





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
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#internetLeadsModal">65
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const hours = Array.from({
                                    length: 24
                                }, (_, i) => {
                                    if (i === 0) return "12 AM";
                                    if (i === 12) return "12 PM";
                                    if (i < 12) return `${i} AM`;
                                    return `${i - 12} PM`;
                                });

                                const leadsCount = hours.map(() => Math.floor(Math.random() * 10));

                                const options = {
                                    series: [{
                                        name: "Internet Leads",
                                        data: leadsCount
                                    }],
                                    chart: {
                                        type: "bar",
                                        height: 420,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const selectedHour = hours[config.dataPointIndex];

                                                // Update table title dynamically
                                                document.getElementById("internetLeadTableTitle").innerText =
                                                    `Lead Details - ${selectedHour}`;

                                                // Dummy table data
                                                const sampleData = [
                                                    ["Hot", "Open", "2025-09-19 10:15", "Ali Khan", "Sara", "Manager",
                                                        "ali@example.com", "03001234567", "0421234567", "0517654321",
                                                        "2022 Toyota Corolla", "Retail", "Facebook", "New", "Direct"
                                                    ],
                                                    ["Warm", "Pending", "2025-09-19 11:30", "Ahmed Raza", "Imran", "Admin",
                                                        "ahmed@example.com", "03007654321", "0412223333", "0514445555",
                                                        "2021 Honda Civic", "Lease", "Website", "Used", "Indirect"
                                                    ]
                                                ];

                                                const tbody = document.getElementById("internetLeadsDetailsBody");
                                                tbody.innerHTML = sampleData.map(row => {
                                                    const formattedRow = [...row];
                                                    formattedRow[2] = formatDateTime(row[2]);

                                                    return `<tr>${formattedRow.map((col, idx) => {
          if(idx===3) return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editVisitCanvas">${col}</td>`;
          if(idx===10) return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editvehicleinfo">${col}</td>`;
          return `<td>${col}</td>`;
        }).join('')}</tr>`;
                                                }).join('');

                                                // Show table
                                                document.getElementById("internetLeadsTableContainer").classList.remove(
                                                    "d-none");
                                                document.getElementById("internetLeadsTableContainer").scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: "50%",
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"],
                                    dataLabels: {
                                        enabled: true
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: hours,
                                        title: {
                                            text: "Hours of the Day"
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: "Internet\nDeals\nCount",
                                            rotate: 0,
                                            offsetY: 0,
                                            offsetX: -50,
                                            style: {
                                                fontSize: '14px',
                                                fontWeight: 'bold',
                                                color: '#000',
                                                lineHeight: 1.2
                                            }
                                        }
                                    },
                                    tooltip: {
                                        enabled: false
                                    },
                                    states: {
                                        normal: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        hover: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        active: {
                                            filter: {
                                                type: "none"
                                            }
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#internetLeadsChart"), options);
                                chart.render();

                                function formatDateTime(dateTimeString) {
                                    const date = new Date(dateTimeString);
                                    const options = {
                                        month: 'short',
                                        day: '2-digit',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    };
                                    return date.toLocaleDateString('en-US', options).replace(',', '');
                                }
                            });
                        </script>



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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const timeLabels = Array.from({
                                    length: 24
                                }, (_, h) => `${((h + 11) % 12) + 1} ${h < 12 ? 'AM' : 'PM'}`);
                                const leadsData = timeLabels.map(() => Math.floor(Math.random() * 5));

                                const options = {
                                    series: [{
                                        name: "Walk-Ins",
                                        data: leadsData
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 420,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const selectedHour = timeLabels[config.dataPointIndex];

                                                // Update table title dynamically
                                                document.getElementById("walkInTableTitle").innerText =
                                                    `Lead Details - ${selectedHour}`;

                                                // Dummy table data
                                                const sampleData = [
                                                    ["Active", "Open", "2025-09-20 10:15", "John Smith", "Mike", "Admin",
                                                        "john@email.com", "555-123-4567", "555-111-2222", "555-333-4444",
                                                        "2023 Toyota Camry", "Cash", "Google", "New", "Retail"
                                                    ],
                                                    ["Sold", "Closed", "2025-09-20 11:45", "Emily Johnson", "Sarah",
                                                        "Manager", "emily@email.com", "555-987-6543", "555-222-3333",
                                                        "555-444-5555", "2022 Honda Accord", "Finance", "Website", "Used",
                                                        "Wholesale"
                                                    ]
                                                ];

                                                const tbody = document.getElementById("walkInDetailsBody");
                                                tbody.innerHTML = sampleData.map(row => {
                                                    const formattedRow = [...row];
                                                    formattedRow[2] = formatDateTime(row[2]);

                                                    return `<tr>${formattedRow.map((col, idx) => {
          if(idx === 3) return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editVisitCanvas">${col}</td>`;
          if(idx === 10) return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editvehicleinfo">${col}</td>`;
          return `<td>${col}</td>`;
        }).join('')}</tr>`;
                                                }).join('');

                                                // Show table and scroll
                                                const table = document.getElementById("walkInDetailsTable");
                                                table.style.display = "block";
                                                table.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '60%',
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ['rgb(0, 33, 64)'],
                                    states: {
                                        normal: {
                                            filter: {
                                                type: 'none'
                                            },
                                            opacity: 1
                                        },
                                        hover: {
                                            filter: {
                                                type: 'none'
                                            },
                                            opacity: 1
                                        },
                                        active: {
                                            filter: {
                                                type: 'none'
                                            },
                                            opacity: 1
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true
                                    },
                                    xaxis: {
                                        categories: timeLabels,
                                        title: {
                                            text: 'Hours of Day'
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Deals\u000ACount',
                                            rotate: 0,
                                            offsetX: -30,
                                            style: {
                                                fontSize: '14px',
                                                fontWeight: 'bold',
                                                color: '#000',
                                                lineHeight: 1.2
                                            }
                                        }
                                    },
                                    grid: {
                                        borderColor: '#eee',
                                        strokeDashArray: 4
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                };

                                new ApexCharts(document.querySelector("#walkInChart"), options).render();

                                function formatDateTime(dateTimeString) {
                                    const date = new Date(dateTimeString.replace(' ', 'T'));
                                    const options = {
                                        month: 'short',
                                        day: '2-digit',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        hour12: true
                                    };
                                    return date.toLocaleDateString('en-US', options).replace(',', '');
                                }
                            });
                        </script>


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
                                        <div id="leadDetailsTableContainer" class="mt-4 d-none">
                                            <h6 class="fw-semibold mb-2">Deal Details</h6>
                                            <div class="table-responsive table-nowrap"
                                                style="max-height: 400px; overflow-y: auto;">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <!-- Important Info - Left Side -->
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>

                                                            <!-- Secondary Info - Right Side -->
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="leadDetailsBody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <script>
                            // Lead Type Categories
                            const leadTypes = [
                                "Internet",
                                "Walk-In",
                                "Phone Up",
                                "Text Up",
                                "Service",
                                "Import",
                                "Wholesale"
                            ];

                            // Function to format date without "at" - North American standard
                            function formatDateTime(dateString) {
                                const date = new Date(dateString);
                                const options = {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                };

                                // Format date and remove "at" from the string
                                const formatted = date.toLocaleString('en-US', options);
                                // Replace "at" with space (e.g., "September 17, 2025 at 9:15 AM" -> "September 17, 2025 9:15 AM")
                                return formatted.replace(' at ', ' ');
                            }

                            // Dummy chart data
                            const leadTypeSeries = [{
                                name: "Leads",
                                data: leadTypes.map(() => Math.floor(Math.random() * 50) + 5)
                            }];

                            // Chart Options
                            const leadTypesOptions = {
                                series: leadTypeSeries,
                                chart: {
                                    type: "bar",
                                    height: 420,
                                    toolbar: {
                                        show: false
                                    },
                                    foreColor: "rgba(0,33,64,1)",
                                    events: {
                                        dataPointSelection: function(event, chartContext, config) {
                                            const selectedType = leadTypes[config.dataPointIndex];

                                            // Sample data - CORRECTED to match table columns (15 columns total)
                                            // Column order: Customer Name, Assigned To, Email, Cell, Home, Work, Vehicle, Lead Type, Deal Type, Created Date, Lead Status, Sales Status, Source, Inventory Type, Sales Type, Created By
                                            const sampleDetails = [
                                                ["Michael Johnson", "David Smith", "michael.johnson@example.com", "310-555-1234",
                                                    "213-555-9876", "424-555-4567", "2024 Ford F-150", "Internet", "Cash",
                                                    "2025-09-17T09:15:00", "Active", "Active", "Facebook", "New", "Retail",
                                                    "Robert Thompson"
                                                ],
                                                ["Emily Davis", "Sarah Miller", "emily.davis@example.com", "323-555-4567",
                                                    "818-555-1122", "213-555-9988", "2023 Toyota Camry", "Walk-In", "Finance",
                                                    "2025-09-17T10:45:00", "Wishlist", "Pending", "Website", "Used", "Retail",
                                                    "Mary Williams"
                                                ],
                                                ["Christopher Brown", "John Wilson", "chris.brown@example.com", "415-555-9987",
                                                    "510-555-3322", "925-555-4455", "2021 Honda Accord", "Phone Up", "Lease",
                                                    "2025-09-17T11:30:00", "Lost", "Closed", "Google Ads", "Used", "Retail",
                                                    "Daniel Moore"
                                                ],
                                                ["Jessica Martinez", "Daniel Thomas", "jessica.martinez@example.com",
                                                    "702-555-7788", "775-555-3344", "725-555-8899", "2025 Tesla Model 3", "Text Up",
                                                    "Cash", "2025-09-17T12:20:00", "Active", "Active", "Instagram", "New", "Retail",
                                                    "Sarah Johnson"
                                                ],
                                                ["Matthew Garcia", "Ashley White", "matthew.garcia@example.com", "602-555-6677",
                                                    "480-555-2233", "928-555-4455", "2022 Chevrolet Malibu", "Service", "Finance",
                                                    "2025-09-17T13:00:00", "Duplicate", "Pending", "Referral", "Used", "Retail",
                                                    "Kevin Lewis"
                                                ],
                                                ["Amanda Rodriguez", "James Anderson", "amanda.rodriguez@example.com",
                                                    "305-555-7788", "954-555-8899", "786-555-3344", "2024 Jeep Wrangler", "Import",
                                                    "Cash", "2025-09-17T14:10:00", "Active", "Active", "Google Search", "New",
                                                    "Retail", "Scott Hall"
                                                ],
                                                ["Joshua Hernandez", "Robert Taylor", "joshua.hernandez@example.com",
                                                    "214-555-4455", "469-555-7788", "972-555-1122", "2020 Nissan Altima",
                                                    "Wholesale", "Finance", "2025-09-17T15:25:00", "Sold", "Closed",
                                                    "Dealer Network", "Used", "Wholesale", "Karen Young"
                                                ],
                                                ["Olivia Moore", "William Martinez", "olivia.moore@example.com", "312-555-6677",
                                                    "773-555-2233", "847-555-8899", "2021 Hyundai Sonata", "Walk-In", "Lease",
                                                    "2025-09-17T16:05:00", "Wishlist", "Pending", "Flyer", "Used", "Retail",
                                                    "Michelle Wright"
                                                ],
                                                ["Ethan Taylor", "Andrew Lee", "ethan.taylor@example.com", "213-555-4455",
                                                    "310-555-6677", "562-555-7788", "2023 BMW X5", "Internet", "Finance",
                                                    "2025-09-17T16:50:00", "Active", "Active", "Website", "New", "Retail",
                                                    "Jason Hill"
                                                ],
                                                ["Sophia Gonzalez", "Anthony Harris", "sophia.gonzalez@example.com", "415-555-2233",
                                                    "650-555-7788", "408-555-3344", "2019 Kia Optima", "Phone Up", "Cash",
                                                    "2025-09-17T17:40:00", "Invalid", "Closed", "Cold Call", "Used", "Retail",
                                                    "Timothy Adams"
                                                ],
                                                ["Benjamin Perez", "Christopher Walker", "benjamin.perez@example.com",
                                                    "720-555-9988", "303-555-2233", "970-555-4455", "2022 Subaru Outback",
                                                    "Service", "Lease", "2025-09-17T18:15:00", "Active", "Active",
                                                    "Customer Referral", "Used", "Retail", "Rebecca Nelson"
                                                ],
                                                ["Isabella Wilson", "Matthew Scott", "isabella.wilson@example.com", "646-555-3344",
                                                    "718-555-7788", "917-555-8899", "2024 Mercedes C-Class", "Wholesale", "Cash",
                                                    "2025-09-17T19:05:00", "Sold", "Closed", "Trade Partner", "New", "Wholesale",
                                                    "Sharon Mitchell"
                                                ]
                                            ];

                                            // Filter data for selected lead type - CORRECTED index from 8 to 7
                                            const filteredData = sampleDetails.filter(row => row[7] === selectedType);

                                            // Fill table with formatted dates and add data attributes
                                            const tbody = document.getElementById("leadDetailsBody");
                                            tbody.innerHTML = filteredData.map((row, index) => {
                                                // Format the date (ninth column - index 9)
                                                const formattedRow = [...row];
                                                formattedRow[9] = formatDateTime(row[9]);

                                                // Create table cells with data attributes for specific columns
                                                const cells = formattedRow.map((col, colIndex) => {
                                                    // Add clickable styling to Customer Name (index 0) and Year/Make/Model (index 6)
                                                    if (colIndex === 0) {
                                                        return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editVisitCanvas">${col}</td>`;
                                                    } else if (colIndex === 6) {
                                                        return `<td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editvehicleinfo">${col}</td>`;
                                                    } else {
                                                        return `<td>${col}</td>`;
                                                    }
                                                }).join("");

                                                // Add special attributes to the fourth row
                                                if (index === 3) {
                                                    return `<tr class="special-row" data-custom="example" data-id="row-4" data-type="highlighted">${cells}</tr>`;
                                                } else {
                                                    return `<tr>${cells}</tr>`;
                                                }
                                            }).join("");

                                            // Update table header
                                            document.querySelector("#leadDetailsTableContainer h6").innerText =
                                                `Lead Details - ${selectedType}`;

                                            // Show table container
                                            document.getElementById("leadDetailsTableContainer").classList.remove("d-none");

                                            // Scroll to table
                                            document.getElementById("leadDetailsTableContainer").scrollIntoView({
                                                behavior: 'smooth'
                                            });
                                        }
                                    }
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: true,
                                        barHeight: "70%",
                                        borderRadius: 4
                                    }
                                },
                                colors: ["rgba(0,33,64,1)"], // theme color
                                dataLabels: {
                                    enabled: true
                                },
                                legend: {
                                    show: false
                                },
                                xaxis: {
                                    categories: leadTypes
                                },
                                grid: {
                                    borderColor: "#e0e0e0",
                                    strokeDashArray: 4
                                },
                                tooltip: {
                                    enabled: false // Remove hover numbers as requested
                                },
                                states: {
                                    normal: {
                                        filter: {
                                            type: "none"
                                        }
                                    },
                                    hover: {
                                        filter: {
                                            type: "none"
                                        }
                                    },
                                    active: {
                                        filter: {
                                            type: "none"
                                        }
                                    }
                                }
                            };

                            // Initialize Chart on Modal Show
                            document.getElementById("leadTypesModal").addEventListener("shown.bs.modal", function() {
                                const chartEl = document.querySelector("#leadTypesChart");
                                if (chartEl && window.ApexCharts) {
                                    chartEl.innerHTML = ""; // clear old chart
                                    const chart = new ApexCharts(chartEl, leadTypesOptions);
                                    chart.render();
                                }

                                // Hide details table when modal opens
                                document.getElementById("leadDetailsTableContainer").classList.add("d-none");
                            });

                            // Hide details table when modal closes
                            document.getElementById("leadTypesModal").addEventListener("hidden.bs.modal", function() {
                                document.getElementById("leadDetailsTableContainer").classList.add("d-none");
                            });
                        </script>








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
                                        <div class="d-flex justify-content-center mb-4">
                                            <div id="chartContainer">
                                                <canvas id="overdueModalChart" style="max-width:500px"></canvas>
                                            </div>
                                        </div>

                                        <!-- Table -->
                                        <div class="table-responsive table-nowrap">
                                            <table id="overdueTable" class="table border" style="display:none;">
                                                <thead class="table-light" id="overdueTableHead"></thead>
                                                <tbody id="overdueTableBody"></tbody>
                                            </table>
                                        </div>
                                        <p id="overdueTotal" class="fw-bold mt-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Simple and clean optimized code
                            document.addEventListener("DOMContentLoaded", () => {
                                // Constants
                                const LABELS = ["Call", "Text", "Email", "CSI", "Other", "Appointment"];
                                const COLORS = ["#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b", "#858796"];

                                // Cache DOM elements
                                const elements = {
                                    modal: document.getElementById("overdueTaskModal"),
                                    table: document.getElementById("overdueTable"),
                                    tableHead: document.getElementById("overdueTableHead"),
                                    tableBody: document.getElementById("overdueTableBody"),
                                    total: document.getElementById("overdueTotal"),
                                    count: document.getElementById("overdue-count"),
                                    missedHours: document.getElementById("missedHours"),
                                    saveButton: document.getElementById("saveMissedHours"),
                                    saveLoading: document.getElementById("saveLoading"),
                                    saveSuccessMessage: document.getElementById("saveSuccessMessage"),
                                    chartContainer: document.getElementById("chartContainer")
                                };

                                // State management
                                let state = {
                                    chartInstance: null,
                                    currentType: null,
                                    data: null,
                                    isModalOpen: false
                                };

                                // Data fetching
                                async function fetchData() {
                                    try {
                                        // Simulate API call
                                        return new Promise(resolve => {
                                            setTimeout(() => {
                                                resolve({
                                                    "Call": [
                                                        ["New Lead", "Pending", "Nov 11, 2025 12:00PM",
                                                            "Inbound", "Michael Johnson", "Sarah Lee",
                                                            "David Smith", "System",
                                                            "michael.johnson@email.com", "555-123-4567",
                                                            "555-987-6543", "555-222-3333",
                                                            "2021 Honda Civic", "Finance", "Referral",
                                                            "Used", "Retail"
                                                        ],
                                                        ["Follow-up", "Contacted",
                                                            "Nov 09, 2025 02:00PM", "Outbound",
                                                            "Emily Davis", "Mark Green", "Amanda White",
                                                            "Admin", "emily.davis@email.com",
                                                            "555-444-2222", "555-333-9999",
                                                            "555-888-1111", "2020 Toyota Camry",
                                                            "Lease", "Web", "New", "Fleet"
                                                        ]
                                                    ],
                                                    "Text": [
                                                        ["New Lead", "Open", "Nov 11, 2025 12:00PM",
                                                            "Inbound", "Jason Brown", "Robert King",
                                                            "Linda Scott", "System",
                                                            "jason.brown@email.com", "555-111-2222",
                                                            "555-444-5555", "555-666-7777",
                                                            "2022 Ford Escape", "Finance", "Referral",
                                                            "New", "Retail"
                                                        ]
                                                    ],
                                                    "Email": [
                                                        ["Contacted", "Follow-Up",
                                                            "Nov 11, 2025 12:00PM", "Inbound",
                                                            "Olivia Wilson", "Chris Moore",
                                                            "Jessica Hall", "Admin",
                                                            "olivia.wilson@email.com", "555-333-2222",
                                                            "555-888-5555", "555-444-9999",
                                                            "2019 Nissan Altima", "Cash", "Walk-in",
                                                            "Used", "Retail"
                                                        ]
                                                    ],
                                                    "CSI": [
                                                        ["Pending", "Survey", "Nov 04, 2025 12:00PM",
                                                            "Inbound", "Daniel White", "Kelly Thomas",
                                                            "Matthew Clark", "Manager",
                                                            "daniel.white@email.com", "555-222-1111",
                                                            "555-999-8888", "555-777-6666",
                                                            "2023 Chevrolet Malibu", "Lease", "Web",
                                                            "New", "Fleet"
                                                        ]
                                                    ],
                                                    "Other": [
                                                        ["Open", "Waiting", "Nov 05, 2025 12:00PM",
                                                            "Inbound", "Sophia Martinez",
                                                            "Anthony Taylor", "Maria Lopez", "System",
                                                            "sophia.martinez@email.com", "555-444-1111",
                                                            "555-555-6666", "555-777-2222",
                                                            "2018 BMW 3 Series", "Finance", "Referral",
                                                            "Used", "Retail"
                                                        ]
                                                    ],
                                                    "Appointment": [
                                                        ["Closed", "Completed", "---", "---",
                                                            "James Anderson", "Patricia Walker",
                                                            "Steven Harris", "Admin",
                                                            "james.anderson@email.com", "555-888-1234",
                                                            "555-222-5678", "555-444-3210",
                                                            "2020 Tesla Model 3", "Cash", "Web", "New",
                                                            "Retail"
                                                        ]
                                                    ]
                                                });
                                            }, 300)
                                        });
                                    } catch (error) {
                                        console.error("Failed to fetch data:", error);
                                        return {};
                                    }
                                }

                                // Save missed hours value
                                async function saveMissedHours() {
                                    const missedHoursValue = elements.missedHours.value;

                                    // Show loading spinner and hide chart
                                    elements.saveLoading.style.display = "inline-block";
                                    elements.saveButton.disabled = true;
                                    elements.chartContainer.style.opacity = "0.3";

                                    try {
                                        // Simulate API call to save the value
                                        await new Promise(resolve => setTimeout(resolve, 2000));

                                        // In a real application, you would send the value to your backend here
                                        console.log("Saving missed hours value:", missedHoursValue);

                                        // Show success message
                                        elements.saveSuccessMessage.style.display = "block";

                                        // Hide success message after 3 seconds
                                        setTimeout(() => {
                                            elements.saveSuccessMessage.style.display = "none";
                                        }, 3000);

                                    } catch (error) {
                                        console.error("Failed to save missed hours:", error);
                                    } finally {
                                        // Hide loading spinner and show chart again
                                        elements.saveLoading.style.display = "none";
                                        elements.saveButton.disabled = false;

                                        // Smooth transition back to chart
                                        setTimeout(() => {
                                            elements.chartContainer.style.transition = "opacity 0.5s ease";
                                            elements.chartContainer.style.opacity = "1";
                                        }, 100);
                                    }
                                }

                                // Chart rendering
                                function renderChart(ctx) {
                                    if (!ctx || !state.data) return null;

                                    if (state.chartInstance) {
                                        state.chartInstance.destroy();
                                    }

                                    const counts = LABELS.map(label => state.data[label]?.length || 0);

                                    state.chartInstance = new Chart(ctx, {
                                        type: "doughnut",
                                        data: {
                                            labels: LABELS,
                                            datasets: [{
                                                data: counts,
                                                backgroundColor: COLORS,
                                                borderWidth: 4,
                                                borderColor: "#fff",
                                                borderRadius: 8,
                                                spacing: 4
                                            }]
                                        },
                                        options: {
                                            cutout: "65%",
                                            plugins: {
                                                legend: {
                                                    position: "left"
                                                }
                                            },
                                            onClick: (_, elements) => {
                                                if (elements.length) {
                                                    const type = LABELS[elements[0].index];
                                                    renderTable(type);
                                                }
                                            }
                                        }
                                    });

                                    return state.chartInstance;
                                }

                                // Table rendering
                                function renderTable(type) {
                                    if (!state.data || !state.data[type]) return;

                                    state.currentType = type;
                                    const rows = state.data[type];

                                    if (!rows.length) {
                                        elements.table.style.display = "none";
                                        elements.total.textContent = `No overdue tasks for ${type}`;
                                        return;
                                    }

                                    elements.table.style.display = "table";

                                    // Header - Added "Task Type" column
                                    elements.tableHead.innerHTML = `
  <tr>
    <th>Task Type</th>
    <th>Lead Status</th>
    <th>Sales Status</th>
    <th>Created Task Date/Time</th>
    <th>Inbound or Outbound</th>
    <th>Customer Name</th>
    <th>Assigned To</th>
    <th>Assigned By</th>
    <th>Created By</th>
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
`;

                                    // Body
                                    elements.tableBody.innerHTML = '';

                                    rows.forEach(row => {
                                        const tr = document.createElement("tr");
                                        tr.className = "clickable-row";
                                        tr.dataset.type = type;

                                        tr.innerHTML = `
    <td>${type}</td>
    <td>${row[0]}</td>
    <td>${row[1]}</td>
    <td>${row[2]}</td>
    <td>${row[3]}</td>
    <td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editVisitCanvas">${row[4]}</td>
    <td>${row[5]}</td>
    <td>${row[6]}</td>
    <td>${row[7]}</td>
    <td>${row[8]}</td>
    <td>${row[9]}</td>
    <td>${row[10]}</td>
    <td>${row[11]}</td>
    <td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editvehicleinfo">${row[12]}</td>
    <td>${row[13]}</td>
    <td>${row[14]}</td>
    <td>${row[15]}</td>
    <td>${row[16]}</td>
  `;

                                        // Event delegation for better performance
                                        tr.addEventListener("click", () => {
                                            document.querySelectorAll("#overdueTableBody tr").forEach(x => x.classList
                                                .remove("table-active"));
                                            tr.classList.add("table-active");
                                        });

                                        elements.tableBody.appendChild(tr);
                                    });

                                    elements.total.textContent = `Total ${type}: ${rows.length}`;

                                    // Scroll to table with smooth animation
                                    if (elements.modal) {
                                        const modalBody = elements.modal.querySelector(".modal-body");
                                        if (modalBody) {
                                            setTimeout(() => {
                                                const tableTop = elements.table.getBoundingClientRect().top;
                                                const modalTop = modalBody.getBoundingClientRect().top;
                                                modalBody.scrollTo({
                                                    top: modalBody.scrollTop + (tableTop - modalTop) - Math.round(
                                                        modalBody.clientHeight * 0.22),
                                                    behavior: "smooth"
                                                });
                                            }, 80);
                                        }
                                    }
                                }

                                // Initialize the widget
                                async function initWidget() {
                                    try {
                                        // Show loading state
                                        if (elements.count) {
                                            elements.count.textContent = "Loading...";
                                        }

                                        // Fetch data
                                        state.data = await fetchData();

                                        // Calculate total count
                                        const totalCount = LABELS.reduce((sum, label) => {
                                            return sum + (state.data[label]?.length || 0);
                                        }, 0);

                                        // Update count
                                        if (elements.count) {
                                            elements.count.textContent = totalCount;
                                        }

                                        // Set up save button event listener
                                        elements.saveButton.addEventListener("click", saveMissedHours);

                                        // Set up modal event listeners
                                        if (elements.modal) {
                                            elements.modal.addEventListener("shown.bs.modal", () => {
                                                state.isModalOpen = true;
                                                const canvas = document.getElementById("overdueModalChart");
                                                if (canvas) {
                                                    state.chartInstance = renderChart(canvas.getContext("2d"));
                                                }
                                            });

                                            elements.modal.addEventListener("hidden.bs.modal", () => {
                                                state.isModalOpen = false;
                                            });
                                        }

                                    } catch (error) {
                                        console.error("Failed to initialize widget:", error);
                                        if (elements.count) {
                                            elements.count.textContent = "Error";
                                        }
                                    }
                                }

                                // Start initialization
                                initWidget();
                            });
                        </script>

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
                                    <h6 class="fs-16 fw-semibold text-primary cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#tasksDonutModal">12</h6>
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

                                        <!-- Donut Chart with Legend on Left -->
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="me-4" id="tasksLegend" style="min-width:200px;"></div>
                                            <div>
                                                <canvas id="tasksDonutChart" height="260" width="260"></canvas>
                                            </div>
                                        </div>

                                        <!-- Table -->
                                        <div id="taskDetailsTable" class="mt-4" style="display:none;">
                                            <h6 class="fw-semibold mb-2">Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border align-middle mb-0">
                                                    <thead class="table-light" id="taskTableHead"></thead>
                                                    <tbody id="taskTableBody"></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="text-end mt-3 fw-bold" id="tasksTotal"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <script>
                             let tasksDonutChart = null;

document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById("tasksDonutChart");
    if (!canvas) return;

    const openCtx = canvas.getContext("2d");

    const openData = {
        labels: ["Call", "Email", "Text", "Appointment", "CSI", "Other"],
        datasets: [{
            data: [35, 25, 18, 12, 10, 8],
            backgroundColor: ["#002140", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b", "#858796"],
            borderWidth: 3,
            borderColor: "#fff",
            borderRadius: 8,
            spacing: 4
        }]
    };

    // 🔥 DESTROY EXISTING CHART FIRST
    if (tasksDonutChart) {
        tasksDonutChart.destroy();
        tasksDonutChart = null;
    }

    // ✅ CREATE CHART SAFELY
    tasksDonutChart = new Chart(openCtx, {
        type: "doughnut",
        data: openData,
        options: {
            cutout: "65%",
            plugins: {
                legend: { display: false }
            },
            onClick: (evt, els) => {
                if (!els.length) return;
                const type = openData.labels[els[0].index];
                showTaskTable(type);
            }
        }
    });


                                    function generateLegend() {
        return openData.labels.map((label, i) => {
            const bg = openData.datasets[0].backgroundColor[i];
            return `
            <div class="d-flex align-items-center mb-1" style="cursor:pointer"
                 onclick="showTaskTable('${label}')">
                <span style="display:inline-block;width:14px;height:14px;background:${bg};
                    margin-right:8px;border-radius:3px"></span>
                <span>${label}</span>
            </div>`;
        }).join("");
    }

    const legend = document.getElementById("tasksLegend");
    if (legend) {
        legend.innerHTML = generateLegend();
    }

                                    // Lead statuses
                                    const leadStatuses = ["Active", "Duplicate", "Invalid", "Lost", "Sold", "Wishlist"];

                                    // Sample tasks with 20+ entries including CSI and Other
                                    const sampleRows = [{
                                            type: "Call",
                                            leadStatus: "Active",
                                            salesStatus: "Active",
                                            inboundOutbound: "Outbound",
                                            date: "May 15, 2025 10:00 AM",
                                            customer: "Michael Johnson",
                                            assignedTo: "Sarah Lee",
                                            assignedBy: "Manager",
                                            createdBy: "System",
                                            email: "michael.johnson@gmail.com",
                                            cell: "202-555-0172",
                                            home: "212-555-6633",
                                            work: "646-555-7744",
                                            ymm: "2022 Ford F-150",
                                            dealType: "Cash",
                                            source: "Google Ads",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Call",
                                            leadStatus: "Duplicate",
                                            salesStatus: "Pending",
                                            inboundOutbound: "Inbound",
                                            date: "May 16, 2025 11:00 AM",
                                            customer: "Emily Davis",
                                            assignedTo: "Robert Brown",
                                            assignedBy: "Agent",
                                            createdBy: "System",
                                            email: "emily.davis@yahoo.com",
                                            cell: "310-555-8899",
                                            home: "213-555-7788",
                                            work: "323-555-6677",
                                            ymm: "2021 Toyota Camry",
                                            dealType: "Lease",
                                            source: "Walk-in",
                                            inventoryType: "Used",
                                            salesType: "Fleet"
                                        },
                                        {
                                            type: "Email",
                                            leadStatus: "Invalid",
                                            salesStatus: "New",
                                            inboundOutbound: "Outbound",
                                            date: "May 17, 2025 12:00 PM",
                                            customer: "James Anderson",
                                            assignedTo: "Laura Thomas",
                                            assignedBy: "Admin",
                                            createdBy: "CRM",
                                            email: "james.anderson@hotmail.com",
                                            cell: "646-555-9988",
                                            home: "917-555-2233",
                                            work: "212-555-3344",
                                            ymm: "2020 Honda Accord",
                                            dealType: "Finance",
                                            source: "Referral",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Email",
                                            leadStatus: "Lost",
                                            salesStatus: "Active",
                                            inboundOutbound: "Inbound",
                                            date: "May 18, 2025 1:00 PM",
                                            customer: "Sophia Martinez",
                                            assignedTo: "David Wilson",
                                            assignedBy: "Manager",
                                            createdBy: "System",
                                            email: "sophia.martinez@gmail.com",
                                            cell: "718-555-7766",
                                            home: "646-555-8899",
                                            work: "929-555-3344",
                                            ymm: "2023 Tesla Model 3",
                                            dealType: "Cash",
                                            source: "Facebook Ads",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Text",
                                            leadStatus: "Sold",
                                            salesStatus: "Pending",
                                            inboundOutbound: "Outbound",
                                            date: "May 19, 2025 2:00 PM",
                                            customer: "William Scott",
                                            assignedTo: "Anthony Lewis",
                                            assignedBy: "Agent",
                                            createdBy: "Call",
                                            email: "william.scott@outlook.com",
                                            cell: "917-555-4455",
                                            home: "646-555-7788",
                                            work: "212-555-5566",
                                            ymm: "2019 Chevrolet Malibu",
                                            dealType: "Lease",
                                            source: "Web",
                                            inventoryType: "Used",
                                            salesType: "Fleet"
                                        },
                                        {
                                            type: "Text",
                                            leadStatus: "Wishlist",
                                            salesStatus: "New",
                                            inboundOutbound: "Inbound",
                                            date: "May 20, 2025 3:00 PM",
                                            customer: "Olivia White",
                                            assignedTo: "Kevin Martinez",
                                            assignedBy: "Manager",
                                            createdBy: "Email",
                                            email: "olivia.white@gmail.com",
                                            cell: "929-555-1122",
                                            home: "212-555-6677",
                                            work: "646-555-8899",
                                            ymm: "2020 BMW 3 Series",
                                            dealType: "Finance",
                                            source: "Referral",
                                            inventoryType: "Used",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Appointment",
                                            leadStatus: "Active",
                                            salesStatus: "Active",
                                            inboundOutbound: "---",
                                            date: "---",
                                            customer: "Daniel Harris",
                                            assignedTo: "Jessica Brown",
                                            assignedBy: "Admin",
                                            createdBy: "System",
                                            email: "daniel.harris@yahoo.com",
                                            cell: "718-555-2244",
                                            home: "917-555-4455",
                                            work: "646-555-6677",
                                            ymm: "2021 Nissan Altima",
                                            dealType: "Cash",
                                            source: "Google Ads",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "CSI",
                                            leadStatus: "Lost",
                                            salesStatus: "Pending",
                                            inboundOutbound: "Inbound",
                                            date: "May 22, 2025 10:00 AM",
                                            customer: "Ava Rodriguez",
                                            assignedTo: "Michael Harris",
                                            assignedBy: "Manager",
                                            createdBy: "System",
                                            email: "ava.rodriguez@gmail.com",
                                            cell: "646-555-9988",
                                            home: "917-555-2233",
                                            work: "212-555-3344",
                                            ymm: "2019 Toyota Highlander",
                                            dealType: "Cash",
                                            source: "Walk-in",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Other",
                                            leadStatus: "Duplicate",
                                            salesStatus: "New",
                                            inboundOutbound: "Outbound",
                                            date: "May 23, 2025 11:30 AM",
                                            customer: "Ethan Moore",
                                            assignedTo: "Chris Taylor",
                                            assignedBy: "Agent",
                                            createdBy: "CRM",
                                            email: "ethan.moore@gmail.com",
                                            cell: "310-555-8899",
                                            home: "213-555-7788",
                                            work: "323-555-6677",
                                            ymm: "2018 Jeep Grand Cherokee",
                                            dealType: "Finance",
                                            source: "Referral",
                                            inventoryType: "Used",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Call",
                                            leadStatus: "Active",
                                            salesStatus: "Pending",
                                            inboundOutbound: "Outbound",
                                            date: "May 24, 2025 9:00 AM",
                                            customer: "John Smith",
                                            assignedTo: "Nancy Drew",
                                            assignedBy: "Manager",
                                            createdBy: "System",
                                            email: "john.smith@gmail.com",
                                            cell: "202-555-9987",
                                            home: "212-555-3345",
                                            work: "646-555-1122",
                                            ymm: "2022 Ford Mustang",
                                            dealType: "Cash",
                                            source: "Facebook",
                                            inventoryType: "New",
                                            salesType: "Retail"
                                        },
                                        {
                                            type: "Email",
                                            leadStatus: "Wishlist",
                                            salesStatus: "Active",
                                            inboundOutbound: "Inbound",
                                            date: "May 24, 2025 10:30 AM",
                                            customer: "Linda Taylor",
                                            assignedTo: "Robert King",
                                            assignedBy: "Agent",
                                            createdBy: "CRM",
                                            email: "linda.taylor@hotmail.com",
                                            cell: "310-555-7788",
                                            home: "213-555-3344",
                                            work: "323-555-9988",
                                            ymm: "2021 Honda Civic",
                                            dealType: "Lease",
                                            source: "Website",
                                            inventoryType: "Used",
                                            salesType: "Fleet"
                                        }
                                    ];
                                    window.showTaskTable = function(type) {
                                        const head = document.getElementById("taskTableHead");
                                        const body = document.getElementById("taskTableBody");
                                        const total = document.getElementById("tasksTotal");
                                        document.getElementById("taskDetailsTable").style.display = "block";

                                        // Table header (static Inbound/Outbound + Task Type + other columns)
                                        head.innerHTML = `
                        <tr>
                        <th>Lead Status</th>
                        <th>Sales Status</th>
                        <th>Created Task Date/Time</th>
                        <th>Inbound or Outbound</th>
                        <th>Task Type</th>
                        <th>Customer Name</th>
                        <th>Assigned To</th>
                        <th>Assigned By</th>
                        <th>Created By</th>
                        <th>Email Address</th>
                        <th>Cell Number</th>
                        <th>Home Number</th>
                        <th>Work Number</th>
                        <th>Year/Make/Model</th>
                        <th>Deal Type</th>
                        <th>Source</th>
                        <th>Inventory Type</th>
                        <th>Sales Type</th>
                        </tr>`;

                                        const filteredRows = sampleRows.filter(r => r.type === type);

                                        body.innerHTML = filteredRows.map(r => `
                        <tr>
                        <td>${r.leadStatus}</td>
                        <td>${r.salesStatus}</td>
                        <td>${r.date}</td>
                        <td>${r.inboundOutbound}</td>
                        <td>${r.type}</td>
                        <td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editVisitCanvas">${r.customer}</td>
                        <td>${r.assignedTo}</td>
                        <td>${r.assignedBy}</td>
                        <td>${r.createdBy}</td>
                        <td>${r.email}</td>
                        <td>${r.cell}</td>
                        <td>${r.home}</td>
                        <td>${r.work}</td>
                        <td data-bs-toggle="offcanvas" class="text-decoration-underline text-black fw-semibold" data-bs-target="#editvehicleinfo">${r.ymm}</td>
                        <td>${r.dealType}</td>
                        <td>${r.source}</td>
                        <td>${r.inventoryType}</td>
                        <td>${r.salesType}</td>
                        </tr>
                    `).join("");

                                        total.innerHTML = `Total ${type}: ${filteredRows.length}`;
                                    };
                                });
                            </script>










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
                                        <div class="mt-4">
                                            <h6 class="fw-semibold mb-2">Assigned Leads</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border" id="assignedByTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <!-- Important Info - Left Side -->
                                                            <th>Customer Name</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Email Address</th>
                                                            <th>Cell Number</th>
                                                            <th>Home Number</th>
                                                            <th>Work Number</th>

                                                            <!-- Secondary Info - Right Side -->
                                                            <th>Year/Make/Model</th>
                                                            <th>Lead Type</th>
                                                            <th>Deal Type</th>
                                                            <th>Created Lead Date/Time</th>
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Source</th>
                                                            <th>Inventory Type</th>
                                                            <th>Sales Type</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="assignedByDetailsBody">
                                                        <!-- Filled by JS -->
                                                    </tbody>
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Updated with 8 American users
                                const baseAssignedBy = [
                                    "Michael Johnson",
                                    "Sarah Williams",
                                    "David Brown",
                                    "Jennifer Miller",
                                    "Christopher Garcia",
                                    "Jessica Davis",
                                    "Matthew Wilson",
                                    "Amanda Martinez"
                                ];
                                const primusUser = "Primus CRM";
                                let includePrimus = false;

                                const assignedBy = [...baseAssignedBy];

                                // Updated series data for 8 users
                                const seriesData = [{
                                    name: "Leads Assigned",
                                    data: [12, 8, 15, 6, 9, 11, 7, 10] // Lead counts for each user
                                }];

                                // Phone number validation and type detection
                                function isCellPhone(number) {
                                    if (number === '-' || number === '') return false;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    return cleanNumber.length === 10; // US numbers are 10 digits
                                }

                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '') return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }

                                // Create clickable phone number element with modal approach
                                function createPhoneElement(number, type) {
                                    if (number === '-' || number === '') return number;

                                    const formattedNumber = formatPhoneNumber(number);
                                    const isCell = isCellPhone(number);

                                    if (isCell) {
                                        return `
    <a href="javascript:void(0);" class="phone-action-trigger text-primary text-decoration-underline" 
       data-number="${number}" data-formatted="${formattedNumber}">
      ${formattedNumber}
    </a>
  `;
                                    } else {
                                        return `<a href="tel:${number}" class="text-primary text-decoration-underline">${formattedNumber}</a>`;
                                    }
                                }

                                // Updated sample data with American names and vehicles - REMOVED "Admin" and "Manager"
                                const sampleData = {
                                    "Michael Johnson": [
                                        ["James Anderson", "Robert Taylor", "Michael Johnson", "james.anderson@email.com",
                                            "5551234567", "5559876543", "-", "2023 Ford F-150", "Hot", "Cash",
                                            "Sep 10, 2025 10:30 AM", "Pending", "Open", "Facebook", "New", "Retail",
                                            "Brian Scott"
                                        ],
                                        ["Emma Wilson", "Steven Harris", "Michael Johnson", "emma.wilson@email.com",
                                            "5552345678", "5558765432", "-", "2022 Toyota Camry", "Warm", "Finance",
                                            "Sep 11, 2025 02:15 PM", "Contacted", "Open", "Website", "Used", "Retail",
                                            "Kevin Martin"
                                        ]
                                    ],
                                    "Sarah Williams": [
                                        ["Emily Clark", "Daniel White", "Sarah Williams", "emily.clark@email.com", "5552345678",
                                            "-", "5558765432", "2022 Chevrolet Silverado", "Cold", "Finance",
                                            "Sep 11, 2025 03:30 PM", "Closed", "Won", "Google Ads", "Used", "Retail",
                                            "Jason Lee"
                                        ],
                                        ["Olivia Thomas", "Ryan Adams", "Sarah Williams", "olivia.thomas@email.com",
                                            "5553456789", "5557654321", "-", "2023 Honda Accord", "Hot", "Lease",
                                            "Sep 12, 2025 09:45 AM", "Pending", "Open", "Referral", "New", "Retail",
                                            "Paul Walker"
                                        ]
                                    ],
                                    "David Brown": [
                                        ["Olivia Harris", "Kevin Martin", "David Brown", "olivia.harris@email.com",
                                            "5553456789", "5557654321", "-", "2024 Toyota Camry", "Cold", "Lease",
                                            "Sep 12, 2025 11:30 AM", "Pending", "Lost", "Referral", "New", "Retail",
                                            "Andrew King"
                                        ],
                                        ["Sophia Martinez", "Thomas Scott", "David Brown", "sophia.martinez@email.com",
                                            "5554567890", "-", "5556543210", "2021 Ford Explorer", "Warm", "Cash",
                                            "Sep 13, 2025 10:00 AM", "Closed", "Won", "Walk-in", "Used", "Retail",
                                            "Brian Miller"
                                        ]
                                    ],
                                    "Jennifer Miller": [
                                        ["William Thompson", "Brian Scott", "Jennifer Miller", "william.thompson@email.com",
                                            "5554567890", "-", "-", "2021 Honda CR-V", "Cold", "Cash", "Sep 11, 2025 09:45 AM",
                                            "Closed", "Won", "Website", "Used", "Retail", "Daniel White"
                                        ],
                                        ["Ava Jackson", "Christopher Davis", "Jennifer Miller", "ava.jackson@email.com",
                                            "5555678901", "5555432109", "-", "2024 BMW X3", "Hot", "Finance",
                                            "Sep 14, 2025 01:30 PM", "Pending", "Open", "Instagram", "New", "Retail",
                                            "Steven Allen"
                                        ]
                                    ],
                                    "Christopher Garcia": [
                                        ["Sophia Rodriguez", "Jason Lee", "Christopher Garcia", "sophia.rodriguez@email.com",
                                            "5555678901", "5556543210", "-", "2023 RAM 1500", "Warm", "Finance",
                                            "Sep 13, 2025 02:15 PM", "Contacted", "Open", "Walk-in", "New", "Fleet",
                                            "Matthew Taylor"
                                        ],
                                        ["Ethan Moore", "Justin Wilson", "Christopher Garcia", "ethan.moore@email.com",
                                            "5556789012", "-", "5554321098", "2022 Jeep Grand Cherokee", "Cold", "Lease",
                                            "Sep 15, 2025 03:45 PM", "Closed", "Lost", "Facebook", "Used", "Retail",
                                            "Ryan Harris"
                                        ]
                                    ],
                                    "Jessica Davis": [
                                        ["Andrew King", "Paul Walker", "Jessica Davis", "andrew.king@email.com", "5556789012",
                                            "-", "5555432109", "2022 Tesla Model 3", "Hot", "Lease", "Sep 14, 2025 04:20 PM",
                                            "Pending", "Open", "Instagram", "Used", "Retail", "Steven Allen"
                                        ],
                                        ["Mia Robinson", "Brandon Lewis", "Jessica Davis", "mia.robinson@email.com",
                                            "5557890123", "5554321098", "-", "2023 Chevrolet Tahoe", "Warm", "Cash",
                                            "Sep 16, 2025 11:15 AM", "Contacted", "Open", "Referral", "New", "Retail",
                                            "Kevin Young"
                                        ]
                                    ],
                                    "Matthew Wilson": [
                                        ["Isabella Moore", "Ryan Harris", "Matthew Wilson", "isabella.moore@email.com",
                                            "5557890123", "5554321098", "-", "2024 BMW X5", "Hot", "Cash",
                                            "Sep 15, 2025 01:30 PM", "Closed", "Won", "Facebook", "New", "Retail",
                                            "David Thompson"
                                        ],
                                        ["Noah Walker", "Jonathan Clark", "Matthew Wilson", "noah.walker@email.com",
                                            "5558901234", "-", "5553210987", "2023 Audi Q5", "Cold", "Finance",
                                            "Sep 17, 2025 10:30 AM", "Pending", "Open", "Website", "Used", "Retail",
                                            "Michael Scott"
                                        ]
                                    ],
                                    "Amanda Martinez": [
                                        ["Ethan Jackson", "Steven Allen", "Amanda Martinez", "ethan.jackson@email.com",
                                            "5558901234", "-", "5553210987", "2023 Jeep Wrangler", "Warm", "Finance",
                                            "Sep 16, 2025 10:45 AM", "Pending", "Open", "Referral", "New", "Retail",
                                            "Brian Johnson"
                                        ],
                                        ["Charlotte Lewis", "Timothy King", "Amanda Martinez", "charlotte.lewis@email.com",
                                            "5559012345", "5552109876", "-", "2022 Ford Bronco", "Hot", "Lease",
                                            "Sep 18, 2025 02:00 PM", "Closed", "Won", "Walk-in", "Used", "Retail",
                                            "Daniel Martin"
                                        ]
                                    ],
                                    "Primus CRM": [
                                        ["Automated Lead", "System Auto", "Primus CRM", "auto-lead@primus.com", "5559012345",
                                            "-", "-", "2024 Ford Mustang", "Warm", "Lease", "Sep 20, 2025 03:00 PM", "Pending",
                                            "New", "Website", "New", "Fleet", "System Generated"
                                        ]
                                    ]
                                };

                                const options = {
                                    series: seriesData,
                                    chart: {
                                        type: "bar",
                                        height: 400,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const assignedByName = assignedBy[config.dataPointIndex];
                                                const rows = sampleData[assignedByName] || [];
                                                const tbody = document.getElementById("assignedByDetailsBody");
                                                tbody.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                                tbody.innerHTML = rows.map(r => {
                                                    // Format date to remove "at"
                                                    const dateObj = new Date(r[10]);
                                                    const formattedDate = dateObj.toLocaleString('en-US', {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: 'numeric',
                                                        hour: 'numeric',
                                                        minute: '2-digit',
                                                        hour12: true
                                                    }).replace(' at ', ' ');

                                                    const rowData = [
                                                        // Customer Name with existing offcanvas trigger
                                                        `<span class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">
            ${r[0]}
          </span>`,
                                                        r[1], // Assigned To (American name)
                                                        r[2], // Assigned By (American name)
                                                        r[3], // Email Address
                                                        createPhoneElement(r[4], 'cell'), // Cell Number (clickable)
                                                        createPhoneElement(r[5], 'home'), // Home Number (clickable)
                                                        createPhoneElement(r[6], 'work'), // Work Number (clickable)
                                                        // Vehicle with existing offcanvas trigger
                                                        `<span class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">
            ${r[7]}
          </span>`,
                                                        r[8], // Lead Type
                                                        r[9], // Deal Type
                                                        formattedDate, // Created Lead Date/Time (without "at")
                                                        r[11], // Lead Status
                                                        r[12], // Sales Status
                                                        r[13], // Source
                                                        r[14], // Inventory Type
                                                        r[15], // Sales Type
                                                        r[16] // Created By (American name, NOT "Admin")
                                                    ];
                                                    return `<tr>${rowData.map(c => `<td>${c}</td>`).join("")}</tr>`;
                                                }).join("");

                                                // Add event listeners for phone actions
                                                setTimeout(() => {
                                                    // Phone action trigger events
                                                    document.querySelectorAll('.phone-action-trigger').forEach(el => {
                                                        el.addEventListener('click', function() {
                                                            const phoneNumber = this.getAttribute(
                                                                'data-number');
                                                            const formattedNumber = this.getAttribute(
                                                                'data-formatted');

                                                            // Set up the phone action modal
                                                            document.getElementById('phoneActionNumber')
                                                                .textContent = formattedNumber;

                                                            // Set up call action
                                                            const callLink = document.getElementById(
                                                                'phoneCallAction');
                                                            callLink.href = `tel:${phoneNumber}`;

                                                            // Set up text action
                                                            document.getElementById('phoneTextAction')
                                                                .onclick = function() {
                                                                    document.getElementById(
                                                                            'textMessageTo').value =
                                                                        formattedNumber;
                                                                    document.getElementById(
                                                                            'textMessageContent')
                                                                        .value = '';

                                                                    // Close phone modal and open text modal
                                                                    const phoneModal = bootstrap.Modal
                                                                        .getInstance(document
                                                                            .getElementById(
                                                                                'phoneActionModal'));
                                                                    phoneModal.hide();

                                                                    setTimeout(() => {
                                                                        const textModal =
                                                                            new bootstrap.Modal(
                                                                                document
                                                                                .getElementById(
                                                                                    'textMessageModal'
                                                                                ));
                                                                        textModal.show();
                                                                    }, 300);
                                                                };

                                                            // Show phone action modal
                                                            const phoneModal = new bootstrap.Modal(
                                                                document.getElementById(
                                                                    'phoneActionModal'));
                                                            phoneModal.show();
                                                        });
                                                    });
                                                }, 100);
                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"],
                                    dataLabels: {
                                        enabled: true
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: assignedBy,
                                        title: {
                                            text: "Assigned By"
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: "Leads Assigned", // Split into 3 lines
                                            rotate: 0, // Keep horizontal
                                            offsetY: 0, // Adjust vertical alignment
                                            offsetX: -40, // Move left to avoid collision with bars
                                            style: {
                                                fontSize: '14px',
                                                fontWeight: 'bold',
                                                color: '#000',
                                                lineHeight: 1.2 // Adjust line spacing
                                            }
                                        }
                                    },

                                    tooltip: {
                                        enabled: false
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#assignedByChart"), options);
                                chart.render();

                                // Send text message functionality
                                document.getElementById('sendTextMessage').addEventListener('click', function() {
                                    const message = document.getElementById('textMessageContent').value;
                                    const to = document.getElementById('textMessageTo').value;

                                    if (message.trim() === '') {
                                        alert('Please enter a message');
                                        return;
                                    }

                                    // Here you would typically send the message via an API
                                    console.log('Sending message to:', to);
                                    console.log('Message:', message);

                                    // Show success message and close modal
                                    alert('Message sent successfully!');
                                    const textModal = bootstrap.Modal.getInstance(document.getElementById('textMessageModal'));
                                    textModal.hide();
                                });

                                // Checkbox toggle for Primus CRM
                                document.getElementById("includePrimus").addEventListener("change", function(e) {
                                    includePrimus = e.target.checked;
                                    if (includePrimus) {
                                        assignedBy.push(primusUser);
                                        options.series[0].data.push(25); // Reasonable number for Primus CRM
                                    } else {
                                        const idx = assignedBy.indexOf(primusUser);
                                        if (idx > -1) {
                                            assignedBy.splice(idx, 1);
                                            options.series[0].data.splice(idx, 1);
                                        }
                                    }
                                    options.xaxis.categories = assignedBy;
                                    chart.updateOptions(options);
                                });
                            });
                        </script>














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
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#appointmentsModal">60</h6>
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
                                        <div class="mt-4">
                                            <h6 class="fw-semibold mb-2">Appointment Details</h6>
                                            <div class="table-responsive table-nowrap">
                                                <table class="table border">
                                                    <thead class="table-light">
                                                        <tr>

                                                            <th>Created Date/Time</th>
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
                                                            <th>Lead Status</th>
                                                            <th>Sales Status</th>
                                                            <th>Status Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="appointmentsDetailsBody">
                                                        <!-- Filled by JS -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const statuses = ["Open", "Completed", "Missed", "Cancelled", "No Response", "No Show"];

                                // Dummy appointment counts
                                const seriesData = [{
                                    name: "Appointments",
                                    data: [15, 12, 5, 3, 2, 1] // Open, Completed, Missed, Cancelled, No Response, No Show
                                }];

                                const options = {
                                    series: seriesData,
                                    chart: {
                                        type: "bar",
                                        height: 400,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const status = statuses[config.dataPointIndex];

                                                // Dummy table rows with all required columns
                                                const sampleData = {
                                                    "Open": [{
                                                        leadStatus: "New",
                                                        salesStatus: "Active",
                                                        createdDate: "Nov 12, 2026 8:00 AM",
                                                        customerName: "James Carter",
                                                        assignedTo: "Ali",
                                                        assignedBy: "Manager",
                                                        createdBy: "System",
                                                        email: "james.carter@email.com",
                                                        cellNumber: "555-123-4567",
                                                        homeNumber: "555-987-6543",
                                                        workNumber: "555-222-3333",
                                                        vehicle: "2023 Ford F-150",
                                                        leadType: "Hot",
                                                        dealType: "Finance",
                                                        source: "Website",
                                                        inventoryType: "New",
                                                        salesType: "Retail",
                                                        statusType: "Open"
                                                    }],
                                                    "Completed": [{
                                                        leadStatus: "Sold",
                                                        salesStatus: "Closed",
                                                        createdDate: "Nov 11, 2026 2:30 PM",
                                                        customerName: "Michael Smith",
                                                        assignedTo: "John",
                                                        assignedBy: "Admin",
                                                        createdBy: "CRM",
                                                        email: "michael.smith@email.com",
                                                        cellNumber: "555-444-5555",
                                                        homeNumber: "555-666-7777",
                                                        workNumber: "555-888-9999",
                                                        vehicle: "2022 Toyota Camry",
                                                        leadType: "Hot",
                                                        dealType: "Cash",
                                                        source: "Referral",
                                                        inventoryType: "Used",
                                                        salesType: "Retail",
                                                        statusType: "Completed"
                                                    }],
                                                    "Missed": [{
                                                        leadStatus: "Pending",
                                                        salesStatus: "Inactive",
                                                        createdDate: "Nov 10, 2026 10:15 AM",
                                                        customerName: "William Davis",
                                                        assignedTo: "Sara",
                                                        assignedBy: "Supervisor",
                                                        createdBy: "Auto",
                                                        email: "william.davis@email.com",
                                                        cellNumber: "555-111-2222",
                                                        homeNumber: "555-333-4444",
                                                        workNumber: "555-555-6666",
                                                        vehicle: "2021 Honda Civic",
                                                        leadType: "Warm",
                                                        dealType: "Lease",
                                                        source: "Website",
                                                        inventoryType: "New",
                                                        salesType: "Fleet",
                                                        statusType: "Missed"
                                                    }],
                                                    "Cancelled": [{
                                                        leadStatus: "Cancelled",
                                                        salesStatus: "Closed",
                                                        createdDate: "Nov 9, 2026 4:45 PM",
                                                        customerName: "Olivia Brown",
                                                        assignedTo: "Ahmed",
                                                        assignedBy: "Manager",
                                                        createdBy: "Manual",
                                                        email: "olivia.brown@email.com",
                                                        cellNumber: "555-777-8888",
                                                        homeNumber: "555-999-0000",
                                                        workNumber: "555-121-2121",
                                                        vehicle: "2020 Nissan Altima",
                                                        leadType: "Cold",
                                                        dealType: "Finance",
                                                        source: "Website",
                                                        inventoryType: "Used",
                                                        salesType: "Retail",
                                                        statusType: "Cancelled"
                                                    }],
                                                    "No Response": [{
                                                        leadStatus: "No Response",
                                                        salesStatus: "Pending",
                                                        createdDate: "Nov 8, 2026 11:20 AM",
                                                        customerName: "Emily Johnson",
                                                        assignedTo: "Mike",
                                                        assignedBy: "Admin",
                                                        createdBy: "System",
                                                        email: "emily.johnson@email.com",
                                                        cellNumber: "555-232-3232",
                                                        homeNumber: "555-454-5454",
                                                        workNumber: "555-676-7676",
                                                        vehicle: "2023 Chevrolet Malibu",
                                                        leadType: "Warm",
                                                        dealType: "Cash",
                                                        source: "Referral",
                                                        inventoryType: "New",
                                                        salesType: "Retail",
                                                        statusType: "No Response"
                                                    }],
                                                    "No Show": [{
                                                        leadStatus: "No Show",
                                                        salesStatus: "Inactive",
                                                        createdDate: "Nov 7, 2026 3:10 PM",
                                                        customerName: "Robert Wilson",
                                                        assignedTo: "Lisa",
                                                        assignedBy: "Manager",
                                                        createdBy: "Auto",
                                                        email: "robert.wilson@email.com",
                                                        cellNumber: "555-989-8989",
                                                        homeNumber: "555-767-6767",
                                                        workNumber: "555-545-4545",
                                                        vehicle: "2022 BMW 3 Series",
                                                        leadType: "Hot",
                                                        dealType: "Lease",
                                                        source: "Website",
                                                        inventoryType: "New",
                                                        salesType: "Retail",
                                                        statusType: "No Show"
                                                    }]
                                                };

                                                const rows = sampleData[status] || [];
                                                const tbody = document.getElementById("appointmentsDetailsBody");
                                                tbody.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                                tbody.innerHTML = rows.map(row => `
          <tr>
     
            <td>${row.createdDate}</td>
            <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.customerName}</td>
            <td>${row.assignedTo}</td>
            <td>${row.assignedBy}</td>
            <td>${row.createdBy}</td>
            <td>${row.email}</td>
            <td>${row.cellNumber}</td>
            <td>${row.homeNumber}</td>
            <td>${row.workNumber}</td>
            <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.vehicle}</td>
            <td>${row.leadType}</td>
            <td>${row.dealType}</td>
            <td>${row.source}</td>
            <td>${row.inventoryType}</td>
            <td>${row.salesType}</td>
                   <td><span>${row.leadStatus}</span></td>
            <td><span>${row.salesStatus}</span></td>
            <td><span>${row.statusType}</span></td>
          </tr>
        `).join("");


                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: true,
                                            barHeight: "75%",
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"], // Primus Blue
                                    dataLabels: {
                                        enabled: true
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: statuses,
                                        title: {
                                            text: "Count"
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: ""
                                        }
                                    },
                                    tooltip: {
                                        enabled: false
                                    },
                                    states: {
                                        normal: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        hover: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        active: {
                                            filter: {
                                                type: "none"
                                            }
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#appointmentsChart"), options);
                                chart.render();
                            });
                        </script>


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
                                        <div class="mt-4">
                                            <h6 class="fw-semibold mb-2">Purchase Details</h6>
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
                                                    <tbody id="purchaseTypesDetailsBody">
                                                        <!-- Filled by JS -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const types = ["Cash", "Lease", "Finance", "Unknown"];

                                // Dummy purchase counts
                                const seriesData = [{
                                    name: "Purchases",
                                    data: [5, 3, 6, 2] // Cash, Lease, Finance, Unknown
                                }];

                                const options = {
                                    series: seriesData,
                                    chart: {
                                        type: "bar",
                                        height: 400,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const type = types[config.dataPointIndex];

                                                // Dummy table rows with all required columns
                                                const sampleData = {
                                                    "Cash": [{
                                                            leadStatus: "Active",
                                                            salesStatus: "Closed",
                                                            createdDate: "Nov 12, 2025 8:00 PM",
                                                            customerName: "Michael Smith",
                                                            assignedTo: "John",
                                                            assignedBy: "Manager",
                                                            createdBy: "System",
                                                            email: "michael.smith@email.com",
                                                            cellNumber: "555-444-5555",
                                                            homeNumber: "555-666-7777",
                                                            workNumber: "555-888-9999",
                                                            vehicle: "2022 Toyota Camry",
                                                            leadType: "Hot",
                                                            dealType: "Cash",
                                                            source: "Referral",
                                                            inventoryType: "Used",
                                                            salesType: "Retail"
                                                        },
                                                        {
                                                            leadStatus: "Sold",
                                                            salesStatus: "Completed",
                                                            createdDate: "Nov 11, 2025 2:30 PM",
                                                            customerName: "Olivia Brown",
                                                            assignedTo: "Ahmed",
                                                            assignedBy: "Admin",
                                                            createdBy: "CRM",
                                                            email: "olivia.brown@email.com",
                                                            cellNumber: "555-111-2222",
                                                            homeNumber: "555-333-4444",
                                                            workNumber: "555-555-6666",
                                                            vehicle: "2023 Ford F-150",
                                                            leadType: "Warm",
                                                            dealType: "Cash",
                                                            source: "Website",
                                                            inventoryType: "New",
                                                            salesType: "Fleet"
                                                        }
                                                    ],
                                                    "Lease": [{
                                                        leadStatus: "Active",
                                                        salesStatus: "Pending",
                                                        createdDate: "Nov 10, 2025 10:15 AM",
                                                        customerName: "William Davis",
                                                        assignedTo: "Sara",
                                                        assignedBy: "Supervisor",
                                                        createdBy: "Auto",
                                                        email: "william.davis@email.com",
                                                        cellNumber: "555-777-8888",
                                                        homeNumber: "555-999-0000",
                                                        workNumber: "555-121-2121",
                                                        vehicle: "2021 Honda Civic",
                                                        leadType: "Cold",
                                                        dealType: "Lease",
                                                        source: "Walk-in",
                                                        inventoryType: "New",
                                                        salesType: "Retail"
                                                    }],
                                                    "Finance": [{
                                                            leadStatus: "New",
                                                            salesStatus: "Active",
                                                            createdDate: "Nov 9, 2025 4:45 PM",
                                                            customerName: "James Carter",
                                                            assignedTo: "Ali",
                                                            assignedBy: "Manager",
                                                            createdBy: "Manual",
                                                            email: "james.carter@email.com",
                                                            cellNumber: "555-123-4567",
                                                            homeNumber: "555-987-6543",
                                                            workNumber: "555-222-3333",
                                                            vehicle: "2020 Nissan Altima",
                                                            leadType: "Hot",
                                                            dealType: "Finance",
                                                            source: "Website",
                                                            inventoryType: "Used",
                                                            salesType: "Retail"
                                                        },
                                                        {
                                                            leadStatus: "Pending",
                                                            salesStatus: "Open",
                                                            createdDate: "Nov 8, 2025 11:20 AM",
                                                            customerName: "Emily Johnson",
                                                            assignedTo: "Sara",
                                                            assignedBy: "Admin",
                                                            createdBy: "System",
                                                            email: "emily.johnson@email.com",
                                                            cellNumber: "555-232-3232",
                                                            homeNumber: "555-454-5454",
                                                            workNumber: "555-676-7676",
                                                            vehicle: "2023 Chevrolet Malibu",
                                                            leadType: "Warm",
                                                            dealType: "Finance",
                                                            source: "Referral",
                                                            inventoryType: "New",
                                                            salesType: "Retail"
                                                        }
                                                    ],
                                                    "Unknown": [{
                                                        leadStatus: "Unknown",
                                                        salesStatus: "Unknown",
                                                        createdDate: "Nov 7, 2025 3:10 PM",
                                                        customerName: "Robert Wilson",
                                                        assignedTo: "Lisa",
                                                        assignedBy: "Manager",
                                                        createdBy: "Auto",
                                                        email: "robert.wilson@email.com",
                                                        cellNumber: "555-989-8989",
                                                        homeNumber: "555-767-6767",
                                                        workNumber: "555-545-4545",
                                                        vehicle: "2022 BMW 3 Series",
                                                        leadType: "Unknown",
                                                        dealType: "Unknown",
                                                        source: "Unknown",
                                                        inventoryType: "Unknown",
                                                        salesType: "Unknown"
                                                    }]
                                                };

                                                const rows = sampleData[type] || [];
                                                const tbody = document.getElementById("purchaseTypesDetailsBody");
                                                tbody.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                                tbody.innerHTML = rows.map(row => `
          <tr>
            <td><span>${row.leadStatus}</span></td>
            <td><span>${row.salesStatus}</span></td>
            <td>${row.createdDate}</td>
            <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.customerName}</td>
            <td>${row.assignedTo}</td>
            <td>${row.assignedBy}</td>
            <td>${row.createdBy}</td>
            <td>${row.email}</td>
            <td>${row.cellNumber}</td>
            <td>${row.homeNumber}</td>
            <td>${row.workNumber}</td>
            <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.vehicle}</td>
            <td>${row.leadType}</td>
            <td>${row.dealType}</td>
            <td>${row.source}</td>
            <td>${row.inventoryType}</td>
            <td>${row.salesType}</td>
          </tr>
        `).join("");


                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false, // Changed to vertical bars
                                            barHeight: "70%",
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"], // Primus Blue
                                    dataLabels: {
                                        enabled: true
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: types,
                                        title: {
                                            text: "Purchase Type"
                                        } // X-axis shows count
                                    },
                                    yaxis: {
                                        title: {
                                            text: "Count", // Y-axis label
                                            rotate: 0, // Make title horizontal
                                            offsetX: -10, // Adjust horizontal position (move left if needed)
                                            offsetY: 0, // Adjust vertical position
                                            style: {
                                                fontSize: '14px',
                                                fontWeight: 'bold',
                                                color: '#000'
                                            }
                                        },
                                        tickAmount: 10, // Fixed tick amount to prevent duplicates
                                        labels: {
                                            formatter: function(val) {
                                                return Math.floor(val); // Ensure whole numbers
                                            }
                                        }
                                    },

                                    tooltip: {
                                        enabled: false // Disabled tooltip on bar hover
                                    },
                                    states: {
                                        normal: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        hover: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        active: {
                                            filter: {
                                                type: "none"
                                            }
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#purchaseTypesChart"), options);
                                chart.render();
                            });
                        </script>











                    </div>
                </div>


                <!-- Outcome Metrics Widgets -->
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
                                        84%
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Tooltip init
                                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                                [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

                                // Sample data with same columns as Assigned By + Contacted column
                                const contactData = {
                                    contacted: 118,
                                    total: 140,
                                    leads: [{
                                            leadStatus: "Pending",
                                            salesStatus: "Open",
                                            createdDate: "Sep 10, 2025 10:30 AM",
                                            customerName: "James Anderson",
                                            assignedBy: "Michael Johnson",
                                            createdBy: "Admin",
                                            email: "james.anderson@email.com",
                                            cellNumber: "5551234567",
                                            homeNumber: "5559876543",
                                            workNumber: "-",
                                            vehicle: "2023 Ford F-150",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Facebook",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 03:30 PM",
                                            customerName: "Emily Clark",
                                            assignedBy: "Sarah Williams",
                                            createdBy: "Admin",
                                            email: "emily.clark@email.com",
                                            cellNumber: "5552345678",
                                            homeNumber: "-",
                                            workNumber: "5558765432",
                                            vehicle: "2022 Chevrolet Silverado",
                                            leadType: "Cold",
                                            dealType: "Finance",
                                            source: "Google Ads",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Pending",
                                            salesStatus: "Lost",
                                            createdDate: "Sep 12, 2025 11:30 AM",
                                            customerName: "Olivia Harris",
                                            assignedBy: "David Brown",
                                            createdBy: "Admin",
                                            email: "olivia.harris@email.com",
                                            cellNumber: "5553456789",
                                            homeNumber: "5557654321",
                                            workNumber: "-",
                                            vehicle: "2024 Toyota Camry",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Referral",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 09:45 AM",
                                            customerName: "William Thompson",
                                            assignedBy: "Jennifer Miller",
                                            createdBy: "Admin",
                                            email: "william.thompson@email.com",
                                            cellNumber: "5554567890",
                                            homeNumber: "-",
                                            workNumber: "-",
                                            vehicle: "2021 Honda CR-V",
                                            leadType: "Cold",
                                            dealType: "Cash",
                                            source: "Website",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Contacted",
                                            salesStatus: "Open",
                                            createdDate: "Sep 13, 2025 02:15 PM",
                                            customerName: "Sophia Rodriguez",
                                            assignedBy: "Christopher Garcia",
                                            createdBy: "Admin",
                                            email: "sophia.rodriguez@email.com",
                                            cellNumber: "5555678901",
                                            homeNumber: "5556543210",
                                            workNumber: "-",
                                            vehicle: "2023 RAM 1500",
                                            leadType: "Warm",
                                            dealType: "Finance",
                                            source: "Walk-in",
                                            inventoryType: "New",
                                            salesType: "Fleet",
                                            contacted: "Yes"
                                        }
                                    ]
                                };

                                // Calculate % 
                                const percentage = Math.round((contactData.contacted / contactData.total) * 100);

                                // When modal opens → show ratio
                                const modalEl = document.getElementById('contactRateModal');
                                modalEl.addEventListener('shown.bs.modal', function() {
                                    document.getElementById('contactPercentage').textContent = percentage;
                                    document.getElementById('contactedLeads').textContent = contactData.contacted;
                                    document.getElementById('totalLeads').textContent = contactData.total;
                                });

                                // Show Table Button
                                document.getElementById('showContactTableBtn').addEventListener('click', function() {
                                    const tableSection = document.getElementById('contactTableSection');
                                    tableSection.style.display = 'block';
                                    this.style.display = 'none'; // hide button after clicked

                                    const tbody = document.getElementById('contactRateDetailsBody');
                                    tbody.innerHTML = '';

                                    contactData.leads.forEach(lead => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
    <td><span >${lead.leadStatus}</span></td>
    <td><span >${lead.salesStatus}</span></td>
    <td>${lead.createdDate}</td>
    <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
    <td>${lead.assignedBy}</td>
    <td>${lead.createdBy}</td>
    <td>${lead.email}</td>
    <td>${formatPhoneNumber(lead.cellNumber)}</td>
    <td>${formatPhoneNumber(lead.homeNumber)}</td>
    <td>${formatPhoneNumber(lead.workNumber)}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
    <td>${lead.leadType}</td>
    <td>${lead.dealType}</td>
    <td>${lead.source}</td>
    <td>${lead.inventoryType}</td>
    <td>${lead.salesType}</td>
    <td><span >${lead.contacted}</span></td>
  `;
                                        tbody.appendChild(tr);
                                    });
                                });

                                // Helper functions
                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '') return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }

                                function getStatusBadgeClass(status) {
                                    const statusClasses = {
                                        'Pending': 'bg-warning',
                                        'Closed': 'bg-success',
                                        'Contacted': 'bg-info'
                                    };
                                    return statusClasses[status] || 'bg-secondary';
                                }

                                function getSalesBadgeClass(salesStatus) {
                                    const salesClasses = {
                                        'Won': 'bg-success',
                                        'Lost': 'bg-danger',
                                        'Open': 'bg-primary',
                                        'New': 'bg-info'
                                    };
                                    return salesClasses[salesStatus] || 'bg-secondary';
                                }
                            });
                        </script>

                        <div class="widget-card d-flex" data-widget-id="appointments-showed-rate">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1 d-flex justify-content-normal align-items-center">Appointments
                                            Showed Rate
                                            <i class="ti ti-info-circle ms-1 text-black" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Showed Rate % = (Completed Appointments / Open Appointments) x 100"></i>

                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle"
                                                data-widget-id="appointments-showed-rate"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#appointmentsShowedRateModal">50%</h6>
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
                                                            <th>Customer Name</th>
                                                            <th>Vehicle</th>
                                                            <th>Cell Number</th>
                                                            <th>Work Number</th>
                                                            <th>Home Number</th>
                                                            <th>Assigned To</th>
                                                            <th>Assigned By</th>
                                                            <th>Appointment Date/Time</th>
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const statuses = ["Open", "Completed"];

                                // Dummy counts
                                const seriesData = [{
                                    name: "Appointments",
                                    data: [30, 10] // Open, Completed
                                }];

                                const options = {
                                    series: seriesData,
                                    chart: {
                                        type: "bar",
                                        height: 300,
                                        toolbar: {
                                            show: false
                                        },
                                        events: {
                                            dataPointSelection: function(event, chartContext, config) {
                                                const status = statuses[config.dataPointIndex];

                                                // Dummy table rows with required columns only
                                                const sampleData = {
                                                    "Open": [{
                                                            customerName: "James Carter",
                                                            vehicle: "2023 Ford F-150",
                                                            cellNumber: "555-123-4567",
                                                            workNumber: "555-222-3333",
                                                            homeNumber: "555-987-6543",
                                                            assignedTo: "Ali",
                                                            assignedBy: "James Smith",
                                                            appointmentDateTime: "Nov 12, 2025 8:00 PM"
                                                        },
                                                        {
                                                            customerName: "Emily Johnson",
                                                            vehicle: "2022 Toyota Camry",
                                                            cellNumber: "555-444-5555",
                                                            workNumber: "555-888-9999",
                                                            homeNumber: "555-666-7777",
                                                            assignedTo: "Sara",
                                                            assignedBy: "James Smith",
                                                            appointmentDateTime: "Nov 11, 2025 2:30 PM"
                                                        }
                                                    ],
                                                    "Completed": [{
                                                            customerName: "Michael Smith",
                                                            vehicle: "2021 Honda Civic",
                                                            cellNumber: "555-777-8888",
                                                            workNumber: "555-121-2121",
                                                            homeNumber: "555-999-0000",
                                                            assignedTo: "John",
                                                            assignedBy: "James Smith",
                                                            appointmentDateTime: "Nov 10, 2025 10:15 AM"
                                                        },
                                                        {
                                                            customerName: "Olivia Brown",
                                                            vehicle: "2020 Nissan Altima",
                                                            cellNumber: "555-232-3232",
                                                            workNumber: "555-676-7676",
                                                            homeNumber: "555-454-5454",
                                                            assignedTo: "Ahmed",
                                                            assignedBy: "James Smith",
                                                            appointmentDateTime: "Nov 9, 2025 4:45 PM"
                                                        }
                                                    ]
                                                };

                                                const rows = sampleData[status] || [];
                                                const tbody = document.getElementById("appointmentsShowedRateBody");
                                                tbody.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'start'
                                                });
                                                tbody.innerHTML = rows.map(row => `
          <tr>
            <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.customerName}</td>
            <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.vehicle}</td>
            <td>${row.cellNumber}</td>
            <td>${row.workNumber}</td>
            <td>${row.homeNumber}</td>
            <td>${row.assignedTo}</td>
            <td>${row.assignedBy}</td>
            <td>${row.appointmentDateTime}</td>
          </tr>
        `).join("");

                                            }
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: true,
                                            barHeight: "75%",
                                            borderRadius: 4
                                        }
                                    },
                                    colors: ["rgb(0,33,64)"], // Primus Blue
                                    dataLabels: {
                                        enabled: true
                                    },
                                    legend: {
                                        show: false
                                    },
                                    xaxis: {
                                        categories: statuses,
                                        title: {
                                            text: "Count"
                                        }
                                    },
                                    tooltip: {
                                        enabled: false
                                    },
                                    states: {
                                        normal: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        hover: {
                                            filter: {
                                                type: "none"
                                            }
                                        },
                                        active: {
                                            filter: {
                                                type: "none"
                                            }
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#appointmentsShowedRateChart"), options);
                                chart.render();
                            });
                        </script>
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
                                                title="Percentage calculated as: (Completed Task / Open Task) x 100"></i>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="task-completion-rate"></i>
                                        </div>
                                    </div>
                                    <!-- Clickable View -->
                                    <h6 class="fs-16 fw-semibold mb-0 text-primary" id="viewTaskCompletion"
                                        style="cursor:pointer;" data-bs-toggle="modal"
                                        data-bs-target="#taskCompletionRateModal">
                                        90%
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Sample data with all columns
                                const taskData = {
                                    completed: 118,
                                    open: 140,
                                    tasks: [{
                                            name: "Prepare client report",
                                            assignedTo: "Sarah",
                                            status: "Completed",
                                            due: "Nov 02, 2025 10:00 AM",
                                            leadStatus: "Pending",
                                            salesStatus: "Open",
                                            createdDate: "Nov 10, 2025 10:30 AM",
                                            customerName: "James Anderson",
                                            assignedBy: "Michael Johnson",
                                            createdBy: "Admin",
                                            email: "james.anderson@email.com",
                                            cellNumber: "5551234567",
                                            homeNumber: "5559876543",
                                            workNumber: "-",
                                            vehicle: "2023 Ford F-150",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Facebook",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            name: "Follow-up email",
                                            assignedTo: "John",
                                            status: "Completed",
                                            due: "Nov 03, 2025 02:00 PM",
                                            leadStatus: "Active",
                                            salesStatus: "Pending",
                                            createdDate: "Nov 09, 2025 09:15 AM",
                                            customerName: "Emily Davis",
                                            assignedBy: "Robert Brown",
                                            createdBy: "System",
                                            email: "emily.davis@email.com",
                                            cellNumber: "5554442222",
                                            homeNumber: "5553339999",
                                            workNumber: "5558881111",
                                            vehicle: "2022 Toyota Camry",
                                            leadType: "Warm",
                                            dealType: "Finance",
                                            source: "Website",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "No"
                                        },
                                        {
                                            name: "Data entry",
                                            assignedTo: "Michael",
                                            status: "Open",
                                            due: "Nov 06, 2025 11:00 AM",
                                            leadStatus: "New",
                                            salesStatus: "Open",
                                            createdDate: "Nov 08, 2025 03:45 PM",
                                            customerName: "Michael Johnson",
                                            assignedBy: "Sarah Lee",
                                            createdBy: "Admin",
                                            email: "michael.johnson@email.com",
                                            cellNumber: "5551112222",
                                            homeNumber: "5554445555",
                                            workNumber: "5556667777",
                                            vehicle: "2021 Honda Civic",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Referral",
                                            inventoryType: "New",
                                            salesType: "Fleet",
                                            contacted: "Yes"
                                        },
                                        {
                                            name: "Design update",
                                            assignedTo: "Emma",
                                            status: "Completed",
                                            due: "Nov 05, 2025 04:30 PM",
                                            leadStatus: "Sold",
                                            salesStatus: "Closed",
                                            createdDate: "Nov 07, 2025 01:20 PM",
                                            customerName: "Olivia Wilson",
                                            assignedBy: "Chris Moore",
                                            createdBy: "Manager",
                                            email: "olivia.wilson@email.com",
                                            cellNumber: "5553332222",
                                            homeNumber: "5558885555",
                                            workNumber: "5554449999",
                                            vehicle: "2020 Nissan Altima",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Walk-in",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        }
                                    ]
                                };

                                // Phone number formatting function
                                function formatPhoneNumber(phone) {
                                    if (!phone || phone === '-') return '-';
                                    const cleaned = phone.toString().replace(/\D/g, '');
                                    if (cleaned.length === 10) {
                                        return `(${cleaned.slice(0, 3)}) ${cleaned.slice(3, 6)}-${cleaned.slice(6)}`;
                                    }
                                    return phone;
                                }

                                // Calculate percentage
                                const percentage = `90`;

                                // When modal opens → show ratio
                                const modalEl = document.getElementById('taskCompletionRateModal');
                                modalEl.addEventListener('shown.bs.modal', function() {
                                    document.getElementById('completionPercentage').textContent = percentage;
                                    document.getElementById('completedTasks').textContent = taskData.completed;
                                    document.getElementById('openTasks').textContent = taskData.open;
                                });

                                // Show table button
                                document.getElementById('showTableBtn').addEventListener('click', function() {
                                    const tableSection = document.getElementById('taskTableSection');
                                    tableSection.style.display = 'block'; // Show table
                                    this.style.display = 'none'; // Hide button after showing table

                                    const tbody = document.getElementById('taskCompletionRateDetailsBody');
                                    tbody.innerHTML = ''; // Clear existing

                                    taskData.tasks.forEach(task => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
    <td>${task.name}</td>
    <td>${task.assignedTo}</td>
    <td>${task.status}</td>
    <td>${task.due}</td>
    <td><span>${task.leadStatus}</span></td>
    <td><span>${task.salesStatus}</span></td>
    <td>${task.createdDate}</td>
    <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${task.customerName}</td>
    <td>${task.assignedBy}</td>
    <td>${task.createdBy}</td>
    <td>${task.email}</td>
    <td>${formatPhoneNumber(task.cellNumber)}</td>
    <td>${formatPhoneNumber(task.homeNumber)}</td>
    <td>${formatPhoneNumber(task.workNumber)}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${task.vehicle}</td>
    <td>${task.leadType}</td>
    <td>${task.dealType}</td>
    <td>${task.source}</td>
    <td>${task.inventoryType}</td>
    <td>${task.salesType}</td>
    <td><span>${task.contacted}</span></td>
  `;
                                        tbody.appendChild(tr);
                                    });
                                });
                            });
                        </script>

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

                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        // Stage configuration
                                                        const stages = {
                                                            speedToLead: {
                                                                title: "Speed to Lead Details",
                                                                columnName: "Speed to Lead",
                                                                description: "Lead Received → First Response to Customer (in minutes)"
                                                            },
                                                            responseTime: {
                                                                title: "Response Time Details",
                                                                columnName: "Response Time",
                                                                description: "First Response to Customer → First Appointment Open (in minutes)"
                                                            },
                                                            conversionTime: {
                                                                title: "Conversion Time Details",
                                                                columnName: "Conversion Time",
                                                                description: "Appointment Booked (Open) → Sold (in minutes)"
                                                            },
                                                            conversionRate: {
                                                                title: "Conversion Rate Details",
                                                                columnName: "Conversion Rate",
                                                                description: "Lead Received → Sold (in days)"
                                                            }
                                                        };

                                                        // Function to format date to 12-hour format
                                                        function formatTo12Hour(dateString) {
                                                            const date = new Date(dateString);
                                                            const options = {
                                                                month: 'short',
                                                                day: 'numeric',
                                                                year: 'numeric'
                                                            };
                                                            const datePart = date.toLocaleDateString('en-US', options);

                                                            let hours = date.getHours();
                                                            let minutes = date.getMinutes();
                                                            const ampm = hours >= 12 ? 'PM' : 'AM';

                                                            hours = hours % 12;
                                                            hours = hours ? hours : 12; // 0 => 12
                                                            minutes = minutes < 10 ? '0' + minutes : minutes;

                                                            return `${datePart} ${hours}:${minutes} ${ampm}`;
                                                        }

                                                        // Sample data for each stage
                                                        const stageData = {
                                                            speedToLead: [{
                                                                    leadStatus: "New",
                                                                    salesStatus: "Open",
                                                                    createdDate: "Nov 12, 2026 8:00 PM",
                                                                    customerName: "John Doe",
                                                                    timeValue: "45 min",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Manager",
                                                                    createdBy: "System",
                                                                    email: "john.doe@email.com",
                                                                    cellNumber: "555-123-4567",
                                                                    homeNumber: "555-987-6543",
                                                                    workNumber: "555-222-3333",
                                                                    vehicle: "2021 Toyota Corolla",
                                                                    leadType: "Walk-In",
                                                                    dealType: "Cash",
                                                                    source: "Website",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                },
                                                                {
                                                                    leadStatus: "Active",
                                                                    salesStatus: "Pending",
                                                                    createdDate: "Nov 11, 2026 2:30 PM",
                                                                    customerName: "Maryam",
                                                                    timeValue: "120 min",
                                                                    assignedTo: "Usman",
                                                                    assignedBy: "Admin",
                                                                    createdBy: "CRM",
                                                                    email: "maryam@email.com",
                                                                    cellNumber: "555-444-5555",
                                                                    homeNumber: "555-666-7777",
                                                                    workNumber: "555-888-9999",
                                                                    vehicle: "2020 Honda Civic",
                                                                    leadType: "Import",
                                                                    dealType: "Finance",
                                                                    source: "Facebook",
                                                                    inventoryType: "Used",
                                                                    salesType: "Retail"
                                                                },
                                                                {
                                                                    leadStatus: "New",
                                                                    salesStatus: "Open",
                                                                    createdDate: "Nov 13, 2026 10:30 AM",
                                                                    customerName: "Rahul Sharma",
                                                                    timeValue: "30 min",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Manager",
                                                                    createdBy: "System",
                                                                    email: "rahul@email.com",
                                                                    cellNumber: "555-111-2222",
                                                                    homeNumber: "555-333-4444",
                                                                    workNumber: "555-555-6666",
                                                                    vehicle: "2022 Hyundai Creta",
                                                                    leadType: "Internet",
                                                                    dealType: "Finance",
                                                                    source: "Website",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                }
                                                            ],
                                                            responseTime: [{
                                                                    leadStatus: "Contacted",
                                                                    salesStatus: "Open",
                                                                    createdDate: "Nov 10, 2026 10:15 AM",
                                                                    customerName: "Zain",
                                                                    timeValue: "280 min",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Supervisor",
                                                                    createdBy: "Auto",
                                                                    email: "zain@email.com",
                                                                    cellNumber: "555-777-8888",
                                                                    homeNumber: "555-999-0000",
                                                                    workNumber: "555-121-2121",
                                                                    vehicle: "2020 Corolla",
                                                                    leadType: "Walk-In",
                                                                    dealType: "Cash",
                                                                    source: "Website",
                                                                    inventoryType: "Used",
                                                                    salesType: "Retail"
                                                                },
                                                                {
                                                                    leadStatus: "Contacted",
                                                                    salesStatus: "Scheduled",
                                                                    createdDate: "Nov 9, 2026 3:45 PM",
                                                                    customerName: "Priya Patel",
                                                                    timeValue: "180 min",
                                                                    assignedTo: "Usman",
                                                                    assignedBy: "Manager",
                                                                    createdBy: "Manual",
                                                                    email: "priya@email.com",
                                                                    cellNumber: "555-666-7777",
                                                                    homeNumber: "555-888-9999",
                                                                    workNumber: "555-000-1111",
                                                                    vehicle: "2021 Honda City",
                                                                    leadType: "Walk-In",
                                                                    dealType: "Lease",
                                                                    source: "Showroom",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                }
                                                            ],
                                                            conversionTime: [{
                                                                    leadStatus: "Sold",
                                                                    salesStatus: "Closed",
                                                                    createdDate: "Nov 9, 2026 4:45 PM",
                                                                    customerName: "Shahid",
                                                                    timeValue: "1150 min",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Manager",
                                                                    createdBy: "Manual",
                                                                    email: "shahid@email.com",
                                                                    cellNumber: "555-232-3232",
                                                                    homeNumber: "555-454-5454",
                                                                    workNumber: "555-676-7676",
                                                                    vehicle: "2021 Toyota Corolla",
                                                                    leadType: "Walk-In",
                                                                    dealType: "Lease",
                                                                    source: "Website",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                },
                                                                {
                                                                    leadStatus: "Sold",
                                                                    salesStatus: "Closed",
                                                                    createdDate: "Nov 8, 2026 11:20 AM",
                                                                    customerName: "Asma",
                                                                    timeValue: "980 min",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Admin",
                                                                    createdBy: "System",
                                                                    email: "asma@email.com",
                                                                    cellNumber: "555-989-8989",
                                                                    homeNumber: "555-767-6767",
                                                                    workNumber: "555-545-4545",
                                                                    vehicle: "2021 Corolla",
                                                                    leadType: "Internet",
                                                                    dealType: "Cash",
                                                                    source: "Website",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                }
                                                            ],
                                                            conversionRate: [{
                                                                    leadStatus: "Completed",
                                                                    salesStatus: "Sold",
                                                                    createdDate: "Nov 7, 2026 9:15 AM",
                                                                    customerName: "Vikram Singh",
                                                                    timeValue: "4.5 days",
                                                                    assignedTo: "Usman",
                                                                    assignedBy: "Manager",
                                                                    createdBy: "System",
                                                                    email: "vikram@email.com",
                                                                    cellNumber: "555-333-4444",
                                                                    homeNumber: "555-555-6666",
                                                                    workNumber: "555-777-8888",
                                                                    vehicle: "2023 Kia Seltos",
                                                                    leadType: "Internet",
                                                                    dealType: "Finance",
                                                                    source: "Website",
                                                                    inventoryType: "New",
                                                                    salesType: "Retail"
                                                                },
                                                                {
                                                                    leadStatus: "Completed",
                                                                    salesStatus: "Sold",
                                                                    createdDate: "Nov 6, 2026 2:30 PM",
                                                                    customerName: "Anjali Mehta",
                                                                    timeValue: "7.2 days",
                                                                    assignedTo: "Ali",
                                                                    assignedBy: "Admin",
                                                                    createdBy: "CRM",
                                                                    email: "anjali@email.com",
                                                                    cellNumber: "555-444-5555",
                                                                    homeNumber: "555-666-7777",
                                                                    workNumber: "555-888-9999",
                                                                    vehicle: "2020 Maruti Swift",
                                                                    leadType: "Walk-In",
                                                                    dealType: "Cash",
                                                                    source: "Showroom",
                                                                    inventoryType: "Used",
                                                                    salesType: "Retail"
                                                                }
                                                            ]
                                                        };

                                                        // Function to update table header with specific time column
                                                        function updateTableHeader(stageKey) {
                                                            const stageConfig = stages[stageKey];
                                                            const headerRow = document.getElementById('tableHeaderRow');

                                                            // Remove any existing time column
                                                            const existingTimeColumn = headerRow.querySelector('.time-column-header');
                                                            if (existingTimeColumn) {
                                                                existingTimeColumn.remove();
                                                            }

                                                            // Add new time column after Customer Name column (4th position)
                                                            const timeColumnHeader = document.createElement('th');
                                                            timeColumnHeader.className = 'time-column-header';
                                                            timeColumnHeader.textContent = stageConfig.columnName;
                                                            timeColumnHeader.title = stageConfig.description;

                                                            // Insert after Customer Name (4th column)
                                                            const customerNameCell = headerRow.children[3];
                                                            customerNameCell.parentNode.insertBefore(timeColumnHeader, customerNameCell.nextSibling);
                                                        }

                                                        // Function to populate table rows
                                                        function populateTableRows(stageKey) {
                                                            const tbody = document.getElementById("stageTableBody");
                                                            tbody.innerHTML = "";

                                                            (stageData[stageKey] || []).forEach(row => {
                                                                tbody.innerHTML += `
                    <tr>
                      <td><span>${row.leadStatus}</span></td>
                      <td><span>${row.salesStatus}</span></td>
                      <td>${row.createdDate}</td>
                      <td class="text-primary text-decoration-underline cursor-pointer" 
                          data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.customerName}</td>
                      <td class="time-column">${row.timeValue}</td>
                      <td>${row.assignedTo}</td>
                      <td>${row.assignedBy}</td>
                      <td>${row.createdBy}</td>
                      <td>${row.email}</td>
                      <td>${row.cellNumber}</td>
                      <td>${row.homeNumber}</td>
                      <td>${row.workNumber}</td>
                      <td class="text-primary text-decoration-underline cursor-pointer"
                          data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.vehicle}</td>
                      <td>${row.leadType}</td>
                      <td>${row.dealType}</td>
                      <td>${row.source}</td>
                      <td>${row.inventoryType}</td>
                      <td>${row.salesType}</td>
                    </tr>
                  `;
                                                            });
                                                        }

                                                        // Add click listeners on each card
                                                        document.querySelectorAll("#speedMetrics .clickable-assigned").forEach(card => {
                                                            card.addEventListener("click", function() {
                                                                const stageKey = this.getAttribute("data-stage");
                                                                const stageConfig = stages[stageKey];

                                                                if (!stageConfig) return;

                                                                // Update title
                                                                document.getElementById("stageTitle").textContent = stageConfig.title;

                                                                // Update table header with specific column
                                                                updateTableHeader(stageKey);

                                                                // Populate table rows
                                                                populateTableRows(stageKey);

                                                                // Show table
                                                                document.getElementById("stageDetails").style.display = "block";
                                                            });
                                                        });
                                                    });
                                                </script>

                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const stages = ["speedToLead", "responseTime", "conversionTime", "conversionRate"];

                                                // Update labels for conversionRate
                                                const conversionRateCount = document.querySelector('[data-key="conversionRate"]');
                                                if (conversionRateCount) {
                                                    conversionRateCount.textContent = "6.2 Days";
                                                }

                                                function calcAndRender() {
                                                    // Compute performance vs target and progress bars
                                                    stages.forEach((k, idx) => {
                                                        const badge = document.querySelector(`[data-from="${k}"]`);
                                                        const bar = document.querySelector(`[data-bar="${k}"]`);
                                                        if (!badge || !bar) return;

                                                        if (k === "speedToLead") {
                                                            badge.textContent = "Target: 60 min";
                                                            bar.style.width = "85%";
                                                            bar.setAttribute('aria-valuenow', 85);
                                                        } else if (k === "responseTime") {
                                                            badge.textContent = "Target: 300 min";
                                                            bar.style.width = "93%";
                                                            bar.setAttribute('aria-valuenow', 93);
                                                        } else if (k === "conversionTime") {
                                                            badge.textContent = "Target: 1200 min";
                                                            bar.style.width = "97%";
                                                            bar.setAttribute('aria-valuenow', 97);
                                                        } else if (k === "conversionRate") {
                                                            badge.textContent = "Target: 6 days";
                                                            bar.style.width = "97%";
                                                            bar.setAttribute('aria-valuenow', 97);
                                                        }
                                                    });
                                                }

                                                // Initialize from default values in markup
                                                calcAndRender();
                                            });
                                        </script>

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
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#financePenetrationModal">68%
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
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <select class="form-select w-auto widgetdateFilter">
                                                <option value="today">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="last7">Last 7 Days</option>
                                                <option value="thisMonth">This Month</option>
                                                <option value="lastMonth">Last Month</option>
                                                <option value="custom">Custom Date</option>
                                            </select>
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Tooltip init
                                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                                [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

                                // Sample data with same columns as Assigned By + Contacted column
                                const financePenetrationData = {
                                    contacted: 118,
                                    total: 140,
                                    leads: [{
                                            leadStatus: "Pending",
                                            salesStatus: "Open",
                                            createdDate: "Sep 10, 2025 10:30 AM",
                                            customerName: "James Anderson",
                                            assignedBy: "Michael Johnson",
                                            createdBy: "Admin",
                                            email: "james.anderson@email.com",
                                            cellNumber: "5551234567",
                                            homeNumber: "5559876543",
                                            workNumber: "-",
                                            vehicle: "2023 Ford F-150",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Facebook",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 03:30 PM",
                                            customerName: "Emily Clark",
                                            assignedBy: "Sarah Williams",
                                            createdBy: "Admin",
                                            email: "emily.clark@email.com",
                                            cellNumber: "5552345678",
                                            homeNumber: "-",
                                            workNumber: "5558765432",
                                            vehicle: "2022 Chevrolet Silverado",
                                            leadType: "Cold",
                                            dealType: "Finance",
                                            source: "Google Ads",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Pending",
                                            salesStatus: "Lost",
                                            createdDate: "Sep 12, 2025 11:30 AM",
                                            customerName: "Olivia Harris",
                                            assignedBy: "David Brown",
                                            createdBy: "Admin",
                                            email: "olivia.harris@email.com",
                                            cellNumber: "5553456789",
                                            homeNumber: "5557654321",
                                            workNumber: "-",
                                            vehicle: "2024 Toyota Camry",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Referral",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 09:45 AM",
                                            customerName: "William Thompson",
                                            assignedBy: "Jennifer Miller",
                                            createdBy: "Admin",
                                            email: "william.thompson@email.com",
                                            cellNumber: "5554567890",
                                            homeNumber: "-",
                                            workNumber: "-",
                                            vehicle: "2021 Honda CR-V",
                                            leadType: "Cold",
                                            dealType: "Cash",
                                            source: "Website",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Contacted",
                                            salesStatus: "Open",
                                            createdDate: "Sep 13, 2025 02:15 PM",
                                            customerName: "Sophia Rodriguez",
                                            assignedBy: "Christopher Garcia",
                                            createdBy: "Admin",
                                            email: "sophia.rodriguez@email.com",
                                            cellNumber: "5555678901",
                                            homeNumber: "5556543210",
                                            workNumber: "-",
                                            vehicle: "2023 RAM 1500",
                                            leadType: "Warm",
                                            dealType: "Finance",
                                            source: "Walk-in",
                                            inventoryType: "New",
                                            salesType: "Fleet",
                                            contacted: "Yes"
                                        }
                                    ]
                                };

                                // Calculate % 
                                const percentage = Math.round((financePenetrationData.contacted / financePenetrationData.total) * 100);

                                // When modal opens → show ratio
                                const modalEl = document.getElementById('financePenetrationModal');
                                modalEl.addEventListener('shown.bs.modal', function() {
                                    document.getElementById('financePenetrationPercentage').textContent = percentage;
                                    document.getElementById('contactedLeadsFinancePenetration').textContent =
                                        financePenetrationData.contacted;
                                    document.getElementById('financePenetrationTotalLeads').textContent = financePenetrationData
                                        .total;
                                });

                                // Show Table Button
                                document.getElementById('showFinancePenetrationTableBtn').addEventListener('click', function() {
                                    const tableSection = document.getElementById('financePenetrationTableSection');
                                    tableSection.style.display = 'block';
                                    this.style.display = 'none'; // hide button after clicked

                                    const tbody = document.getElementById('financePenetrationDetailsBody');
                                    tbody.innerHTML = '';

                                    financePenetrationData.leads.forEach(lead => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
    <td><span>${lead.leadStatus}</span></td>
    <td><span>${lead.salesStatus}</span></td>
    <td>${lead.createdDate}</td>
    <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
    <td>${lead.assignedBy}</td>
    <td>${lead.createdBy}</td>
    <td>${lead.email}</td>
    <td>${formatPhoneNumber(lead.cellNumber)}</td>
    <td>${formatPhoneNumber(lead.homeNumber)}</td>
    <td>${formatPhoneNumber(lead.workNumber)}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
    <td>${lead.leadType}</td>
    <td>${lead.dealType}</td>
    <td>${lead.source}</td>
    <td>${lead.inventoryType}</td>
    <td>${lead.salesType}</td>
    <td><span>${lead.contacted}</span></td>
  `;
                                        tbody.appendChild(tr);
                                    });
                                });

                                // Helper functions
                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '') return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }

                                function getStatusBadgeClass(status) {
                                    const statusClasses = {
                                        'Pending': 'bg-warning',
                                        'Closed': 'bg-success',
                                        'Contacted': 'bg-info'
                                    };
                                    return statusClasses[status] || 'bg-secondary';
                                }

                                function getSalesBadgeClass(salesStatus) {
                                    const salesClasses = {
                                        'Won': 'bg-success',
                                        'Lost': 'bg-danger',
                                        'Open': 'bg-primary',
                                        'New': 'bg-info'
                                    };
                                    return salesClasses[salesStatus] || 'bg-secondary';
                                }
                            });
                        </script>
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
                                        data-bs-target="#storeVisitClosingRatioModal">72%</h6>
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Initialize tooltips
                                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                                [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

                                // Sample data for Store Visit Closing Ratio
                                const storeVisitClosingRatioData = {
                                    closed: 86,
                                    total: 120,
                                    storeVisits: [{
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Nov 10, 2025 10:30 AM",
                                            customerName: "John Davis",
                                            assignedBy: "Michael Johnson",
                                            createdBy: "Admin",
                                            email: "john.davis@email.com",
                                            cellNumber: "5551234567",
                                            homeNumber: "5559876543",
                                            workNumber: "-",
                                            vehicle: "2023 Ford F-150",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Nov 11, 2025 03:30 PM",
                                            customerName: "Sarah Wilson",
                                            assignedBy: "Robert Miller",
                                            createdBy: "Admin",
                                            email: "sarah.wilson@email.com",
                                            cellNumber: "5552345678",
                                            homeNumber: "-",
                                            workNumber: "5558765432",
                                            vehicle: "2022 Chevrolet Silverado",
                                            leadType: "Warm",
                                            dealType: "Finance",
                                            source: "Store Visit",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Open",
                                            salesStatus: "Pending",
                                            createdDate: "Nov 12, 2025 11:30 AM",
                                            customerName: "David Thompson",
                                            assignedBy: "Lisa Anderson",
                                            createdBy: "Admin",
                                            email: "david.thompson@email.com",
                                            cellNumber: "5553456789",
                                            homeNumber: "5557654321",
                                            workNumber: "-",
                                            vehicle: "2024 Toyota Camry",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            closed: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Nov 11, 2025 09:45 AM",
                                            customerName: "Emma Garcia",
                                            assignedBy: "Thomas White",
                                            createdBy: "Admin",
                                            email: "emma.garcia@email.com",
                                            cellNumber: "5554567890",
                                            homeNumber: "-",
                                            workNumber: "-",
                                            vehicle: "2021 Honda CR-V",
                                            leadType: "Hot",
                                            dealType: "Cash",
                                            source: "Store Visit",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Lost",
                                            createdDate: "Nov 13, 2025 02:15 PM",
                                            customerName: "Michael Brown",
                                            assignedBy: "Jennifer Taylor",
                                            createdBy: "Admin",
                                            email: "michael.brown@email.com",
                                            cellNumber: "5555678901",
                                            homeNumber: "5556543210",
                                            workNumber: "-",
                                            vehicle: "2023 RAM 1500",
                                            leadType: "Warm",
                                            dealType: "Finance",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Fleet",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Open",
                                            salesStatus: "New",
                                            createdDate: "Nov 14, 2025 04:45 PM",
                                            customerName: "Olivia Martinez",
                                            assignedBy: "William Clark",
                                            createdBy: "Admin",
                                            email: "olivia.martinez@email.com",
                                            cellNumber: "5556789012",
                                            homeNumber: "5555432109",
                                            workNumber: "-",
                                            vehicle: "2024 BMW X5",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            closed: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Nov 15, 2025 09:15 AM",
                                            customerName: "James Rodriguez",
                                            assignedBy: "Patricia Lee",
                                            createdBy: "Admin",
                                            email: "james.rodriguez@email.com",
                                            cellNumber: "5557890123",
                                            homeNumber: "-",
                                            workNumber: "5554321098",
                                            vehicle: "2022 Tesla Model 3",
                                            leadType: "Hot",
                                            dealType: "Finance",
                                            source: "Store Visit",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Open",
                                            salesStatus: "Pending",
                                            createdDate: "Nov 16, 2025 01:30 PM",
                                            customerName: "Sophia Harris",
                                            assignedBy: "Christopher Walker",
                                            createdBy: "Admin",
                                            email: "sophia.harris@email.com",
                                            cellNumber: "5558901234",
                                            homeNumber: "5553210987",
                                            workNumber: "-",
                                            vehicle: "2023 Mercedes C-Class",
                                            leadType: "Warm",
                                            dealType: "Cash",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            closed: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Nov 17, 2025 10:00 AM",
                                            customerName: "Daniel Lewis",
                                            assignedBy: "Nancy Hall",
                                            createdBy: "Admin",
                                            email: "daniel.lewis@email.com",
                                            cellNumber: "5559012345",
                                            homeNumber: "-",
                                            workNumber: "-",
                                            vehicle: "2024 Ford Explorer",
                                            leadType: "Hot",
                                            dealType: "Finance",
                                            source: "Store Visit",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Lost",
                                            createdDate: "Nov 18, 2025 03:20 PM",
                                            customerName: "Ava King",
                                            assignedBy: "Brian Scott",
                                            createdBy: "Admin",
                                            email: "ava.king@email.com",
                                            cellNumber: "5550123456",
                                            homeNumber: "5552109876",
                                            workNumber: "5558765432",
                                            vehicle: "2023 Audi Q7",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Store Visit",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            closed: "Yes"
                                        }
                                    ]
                                };

                                // Calculate percentage
                                const storeVisitPercentage = Math.round((storeVisitClosingRatioData.closed / storeVisitClosingRatioData
                                    .total) * 100);

                                // When modal opens → show ratio
                                const storeVisitModalEl = document.getElementById('storeVisitClosingRatioModal');
                                if (storeVisitModalEl) {
                                    storeVisitModalEl.addEventListener('shown.bs.modal', function() {
                                        document.getElementById('storeVisitClosingRatioPercentage').textContent =
                                            storeVisitPercentage;
                                        document.getElementById('closedStoreVisits').textContent = storeVisitClosingRatioData
                                            .closed;
                                        document.getElementById('totalStoreVisits').textContent = storeVisitClosingRatioData
                                            .total;
                                    });
                                }

                                // Show Table Button
                                const showTableBtn = document.getElementById('showStoreVisitClosingRatioTableBtn');
                                if (showTableBtn) {
                                    showTableBtn.addEventListener('click', function() {
                                        const tableSection = document.getElementById('storeVisitClosingRatioTableSection');
                                        tableSection.style.display = 'block';
                                        this.style.display = 'none'; // hide button after clicked

                                        const tbody = document.getElementById('storeVisitClosingRatioDetailsBody');
                                        tbody.innerHTML = '';

                                        storeVisitClosingRatioData.storeVisits.forEach(visit => {
                                            const tr = document.createElement('tr');
                                            tr.innerHTML = `
      <td>${visit.leadStatus}</td>
      <td>${visit.salesStatus}</td>
      <td>${visit.createdDate}</td>
      <td class="text-primary text-decoration-underline cursor-pointer" 
          data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${visit.customerName}</td>
      <td>${visit.assignedBy}</td>
      <td>${visit.createdBy}</td>
      <td>${visit.email}</td>
      <td>${formatPhoneNumber(visit.cellNumber)}</td>
      <td>${formatPhoneNumber(visit.homeNumber)}</td>
      <td>${formatPhoneNumber(visit.workNumber)}</td>
      <td class="text-primary text-decoration-underline cursor-pointer"
          data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${visit.vehicle}</td>
      <td>${visit.leadType}</td>
      <td>${visit.dealType}</td>
      <td>${visit.source}</td>
      <td>${visit.inventoryType}</td>
      <td>${visit.salesType}</td>
      <td>${visit.closed}</td>
    `;
                                            tbody.appendChild(tr);
                                        });
                                    });
                                }

                                // Date filter functionality
                                const dateFilter = document.getElementById('storeVisitClosingRatioDateFilter');
                                if (dateFilter) {
                                    dateFilter.addEventListener('change', function() {
                                        const selectedValue = this.value;
                                        // In a real application, you would fetch data based on the selected date range
                                        console.log('Date filter changed to:', selectedValue);

                                        // For demo purposes, we'll update the displayed data
                                        // In reality, you would make an API call here
                                        if (selectedValue === 'today') {
                                            // Update with today's data
                                            document.getElementById('storeVisitClosingRatioPercentage').textContent = "75";
                                            document.getElementById('closedStoreVisits').textContent = "15";
                                            document.getElementById('totalStoreVisits').textContent = "20";
                                        } else if (selectedValue === 'last7') {
                                            // Update with last 7 days data
                                            document.getElementById('storeVisitClosingRatioPercentage').textContent = "72";
                                            document.getElementById('closedStoreVisits').textContent = "86";
                                            document.getElementById('totalStoreVisits').textContent = "120";
                                        }
                                    });
                                }

                                // Helper functions
                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '' || number === undefined) return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }

                                function getStatusBadgeClass(status) {
                                    const statusClasses = {
                                        'Closed': 'bg-success',
                                        'Open': 'bg-warning',
                                        'Pending': 'bg-info',
                                        'Contacted': 'bg-primary'
                                    };
                                    return statusClasses[status] || 'bg-secondary';
                                }

                                function getSalesBadgeClass(salesStatus) {
                                    const salesClasses = {
                                        'Won': 'bg-success',
                                        'Lost': 'bg-danger',
                                        'Open': 'bg-primary',
                                        'Pending': 'bg-warning',
                                        'New': 'bg-info'
                                    };
                                    return salesClasses[salesStatus] || 'bg-secondary';
                                }

                                // Star toggle functionality for Store Visit Closing Ratio widget
                                const storeVisitStar = document.querySelector(
                                    '[data-widget-id="store-visit-closing-ratio"] .star-toggle');
                                if (storeVisitStar) {
                                    storeVisitStar.addEventListener('click', function() {
                                        this.classList.toggle('ti-star-filled');
                                        this.classList.toggle('ti-star');
                                    });
                                }
                            });

                            // Export functionality for Store Visit Closing Ratio
                            function exportStoreVisitClosingRatio(format) {
                                const headers = [
                                    'Lead Status', 'Sales Status', 'Created Lead Date/Time', 'Customer Name',
                                    'Assigned By', 'Created By', 'Email Address', 'Cell Number', 'Home Number',
                                    'Work Number', 'Year/Make/Model', 'Lead Type', 'Deal Type', 'Source',
                                    'Inventory Type', 'Sales Type', 'Closed'
                                ];

                                // Get data from the table or use sample data
                                const data = storeVisitClosingRatioData.storeVisits || [];

                                if (format === 'csv') {
                                    const csvContent = [
                                        headers.join(','),
                                        ...data.map(item => [
                                            item.leadStatus,
                                            item.salesStatus,
                                            item.createdDate,
                                            item.customerName,
                                            item.assignedBy,
                                            item.createdBy,
                                            item.email,
                                            item.cellNumber,
                                            item.homeNumber,
                                            item.workNumber,
                                            item.vehicle,
                                            item.leadType,
                                            item.dealType,
                                            item.source,
                                            item.inventoryType,
                                            item.salesType,
                                            item.closed
                                        ].map(field => `"${field}"`).join(','))
                                    ].join('\n');

                                    downloadStoreVisitCSV(csvContent, 'store_visit_closing_ratio.csv');
                                } else if (format === 'xlsx') {
                                    alert('XLSX export would be implemented with SheetJS library for Store Visit Closing Ratio');
                                } else if (format === 'pdf') {
                                    alert('PDF export would be implemented with jsPDF library for Store Visit Closing Ratio');
                                }
                            }

                            function downloadStoreVisitCSV(csvContent, filename) {
                                const blob = new Blob([csvContent], {
                                    type: 'text/csv;charset=utf-8;'
                                });
                                const link = document.createElement('a');
                                const url = URL.createObjectURL(blob);
                                link.setAttribute('href', url);
                                link.setAttribute('download', filename);
                                link.style.visibility = 'hidden';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }

                            function printStoreVisitClosingRatio() {
                                const printContent = document.getElementById('storeVisitClosingRatioModal').innerHTML;
                                const originalContent = document.body.innerHTML;

                                document.body.innerHTML = printContent;
                                window.print();
                                document.body.innerHTML = originalContent;

                                // Re-initialize the modal
                                const modalElement = document.getElementById('storeVisitClosingRatioModal');
                                if (modalElement) {
                                    const modal = new bootstrap.Modal(modalElement);
                                    modal.show();
                                }
                            }
                        </script>
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
                                        data-bs-target="#leasePenetrationModal">72%
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Tooltip init
                                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                                [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

                                // Sample data with same columns as Assigned By + Contacted column
                                const leasePenetrationData = {
                                    contacted: 95,
                                    total: 132,
                                    leads: [{
                                            leadStatus: "Pending",
                                            salesStatus: "Open",
                                            createdDate: "Sep 10, 2025 10:30 AM",
                                            customerName: "Robert Wilson",
                                            assignedBy: "Michael Johnson",
                                            createdBy: "Admin",
                                            email: "robert.wilson@email.com",
                                            cellNumber: "5551234567",
                                            homeNumber: "5559876543",
                                            workNumber: "-",
                                            vehicle: "2023 BMW 3 Series",
                                            leadType: "Hot",
                                            dealType: "Lease",
                                            source: "Facebook",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 03:30 PM",
                                            customerName: "Lisa Martinez",
                                            assignedBy: "Sarah Williams",
                                            createdBy: "Admin",
                                            email: "lisa.martinez@email.com",
                                            cellNumber: "5552345678",
                                            homeNumber: "-",
                                            workNumber: "5558765432",
                                            vehicle: "2022 Mercedes C-Class",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Google Ads",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Pending",
                                            salesStatus: "Lost",
                                            createdDate: "Sep 12, 2025 11:30 AM",
                                            customerName: "David Kim",
                                            assignedBy: "David Brown",
                                            createdBy: "Admin",
                                            email: "david.kim@email.com",
                                            cellNumber: "5553456789",
                                            homeNumber: "5557654321",
                                            workNumber: "-",
                                            vehicle: "2024 Audi A4",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Referral",
                                            inventoryType: "New",
                                            salesType: "Retail",
                                            contacted: "No"
                                        },
                                        {
                                            leadStatus: "Closed",
                                            salesStatus: "Won",
                                            createdDate: "Sep 11, 2025 09:45 AM",
                                            customerName: "Amanda Taylor",
                                            assignedBy: "Jennifer Miller",
                                            createdBy: "Admin",
                                            email: "amanda.taylor@email.com",
                                            cellNumber: "5554567890",
                                            homeNumber: "-",
                                            workNumber: "-",
                                            vehicle: "2021 Lexus RX",
                                            leadType: "Cold",
                                            dealType: "Lease",
                                            source: "Website",
                                            inventoryType: "Used",
                                            salesType: "Retail",
                                            contacted: "Yes"
                                        },
                                        {
                                            leadStatus: "Contacted",
                                            salesStatus: "Open",
                                            createdDate: "Sep 13, 2025 02:15 PM",
                                            customerName: "Kevin Johnson",
                                            assignedBy: "Christopher Garcia",
                                            createdBy: "Admin",
                                            email: "kevin.johnson@email.com",
                                            cellNumber: "5555678901",
                                            homeNumber: "5556543210",
                                            workNumber: "-",
                                            vehicle: "2023 Volvo XC60",
                                            leadType: "Warm",
                                            dealType: "Lease",
                                            source: "Walk-in",
                                            inventoryType: "New",
                                            salesType: "Fleet",
                                            contacted: "Yes"
                                        }
                                    ]
                                };

                                // Calculate % 
                                const percentage = Math.round((leasePenetrationData.contacted / leasePenetrationData.total) * 100);

                                // When modal opens → show ratio
                                const modalEl = document.getElementById('leasePenetrationModal');
                                modalEl.addEventListener('shown.bs.modal', function() {
                                    document.getElementById('leasePenetrationPercentage').textContent = percentage;
                                    document.getElementById('contactedLeadsLeasePenetration').textContent = leasePenetrationData
                                        .contacted;
                                    document.getElementById('leasePenetrationTotalLeads').textContent = leasePenetrationData
                                        .total;
                                });

                                // Show Table Button
                                document.getElementById('showLeasePenetrationTableBtn').addEventListener('click', function() {
                                    const tableSection = document.getElementById('leasePenetrationTableSection');
                                    tableSection.style.display = 'block';
                                    this.style.display = 'none'; // hide button after clicked

                                    const tbody = document.getElementById('leasePenetrationDetailsBody');
                                    tbody.innerHTML = '';

                                    leasePenetrationData.leads.forEach(lead => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
    <td><span>${lead.leadStatus}</span></td>
    <td><span>${lead.salesStatus}</span></td>
    <td>${lead.createdDate}</td>
    <td class="text-primary text-decoration-underline cursor-pointer" 
                data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
    <td>${lead.assignedBy}</td>
    <td>${lead.createdBy}</td>
    <td>${lead.email}</td>
    <td>${formatPhoneNumber(lead.cellNumber)}</td>
    <td>${formatPhoneNumber(lead.homeNumber)}</td>
    <td>${formatPhoneNumber(lead.workNumber)}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
                data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
    <td>${lead.leadType}</td>
    <td>${lead.dealType}</td>
    <td>${lead.source}</td>
    <td>${lead.inventoryType}</td>
    <td>${lead.salesType}</td>
    <td><span>${lead.contacted}</span></td>
  `;
                                        tbody.appendChild(tr);
                                    });
                                });

                                // Helper functions
                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '') return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }

                                function getStatusBadgeClass(status) {
                                    const statusClasses = {
                                        'Pending': 'bg-warning',
                                        'Closed': 'bg-success',
                                        'Contacted': 'bg-info'
                                    };
                                    return statusClasses[status] || 'bg-secondary';
                                }

                                function getSalesBadgeClass(salesStatus) {
                                    const salesClasses = {
                                        'Won': 'bg-success',
                                        'Lost': 'bg-danger',
                                        'Open': 'bg-primary',
                                        'New': 'bg-info'
                                    };
                                    return salesClasses[salesStatus] || 'bg-secondary';
                                }
                            });
                        </script>
                        <div class="widget-card d-flex" data-widget-id="beback-customer">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="mb-1">Beback Customer</p>
                                        <div class="d-flex gap-2">
                                            <i class="ti ti-star star-toggle" data-widget-id="beback-customer"></i>
                                        </div>
                                    </div>
                                    <h6 class="fs-16 fw-semibold" data-bs-toggle="modal"
                                        data-bs-target="#bebackCustomerModal">7</h6>
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

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Sample data for Beback Customers
                                const bebackCustomerData = [{
                                        leadStatus: "Follow-up",
                                        salesStatus: "Pending",
                                        createdDate: "Nov 15, 2025 10:30 AM",
                                        customerName: "Michael Rodriguez",
                                        assignedTo: "Sarah Johnson",
                                        assignedBy: "Brian Anderson",
                                        createdBy: "Robert Johnson",
                                        email: "michael.rodriguez@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "555-987-6543",
                                        workNumber: "555-222-3333",
                                        vehicle: "2023 Toyota Camry",
                                        leadType: "Warm",
                                        dealType: "Finance",
                                        source: "Walk-in",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Beback",
                                        salesStatus: "Active",
                                        createdDate: "Nov 14, 2025 2:15 PM",
                                        customerName: "Jennifer Martinez",
                                        assignedTo: "David Wilson",
                                        assignedBy: "Mark Thompson",
                                        createdBy: "William Davis",
                                        email: "jennifer.martinez@email.com",
                                        cellNumber: "555-234-5678",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2022 Honda CR-V",
                                        leadType: "Hot",
                                        dealType: "Cash",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Follow-up",
                                        salesStatus: "Open",
                                        createdDate: "Nov 13, 2025 9:45 AM",
                                        customerName: "Robert Chen",
                                        assignedTo: "Lisa Thompson",
                                        assignedBy: "Steven Miller",
                                        createdBy: "Thomas Wilson",
                                        email: "robert.chen@email.com",
                                        cellNumber: "555-345-6789",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2024 Ford F-150",
                                        leadType: "Cold",
                                        dealType: "Lease",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Fleet"
                                    },
                                    {
                                        leadStatus: "Beback",
                                        salesStatus: "Pending",
                                        createdDate: "Nov 12, 2025 3:20 PM",
                                        customerName: "Amanda Wilson",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Paul Jackson",
                                        createdBy: "Richard Martinez",
                                        email: "amanda.wilson@email.com",
                                        cellNumber: "555-456-7890",
                                        homeNumber: "555-654-3210",
                                        workNumber: "-",
                                        vehicle: "2023 Chevrolet Equinox",
                                        leadType: "Warm",
                                        dealType: "Finance",
                                        source: "Facebook Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Follow-up",
                                        salesStatus: "Active",
                                        createdDate: "Nov 11, 2025 11:10 AM",
                                        customerName: "Daniel Kim",
                                        assignedTo: "Maria Garcia",
                                        assignedBy: "Eric Taylor",
                                        createdBy: "Charles Moore",
                                        email: "daniel.kim@email.com",
                                        cellNumber: "555-567-8901",
                                        homeNumber: "-",
                                        workNumber: "555-543-2109",
                                        vehicle: "2022 BMW 3 Series",
                                        leadType: "Hot",
                                        dealType: "Lease",
                                        source: "Walk-in",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Beback",
                                        salesStatus: "Open",
                                        createdDate: "Nov 10, 2025 4:45 PM",
                                        customerName: "Sarah Johnson",
                                        assignedTo: "Michael Davis",
                                        assignedBy: "Jason White",
                                        createdBy: "Joseph Clark",
                                        email: "sarah.johnson@email.com",
                                        cellNumber: "555-678-9012",
                                        homeNumber: "555-432-1098",
                                        workNumber: "-",
                                        vehicle: "2024 Hyundai Tucson",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Google Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Follow-up",
                                        salesStatus: "Pending",
                                        createdDate: "Nov 09, 2025 1:30 PM",
                                        customerName: "Christopher Lee",
                                        assignedTo: "Emily White",
                                        assignedBy: "Scott Harris",
                                        createdBy: "Jeffrey Lewis",
                                        email: "christopher.lee@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "-",
                                        workNumber: "555-321-0987",
                                        vehicle: "2023 Nissan Rogue",
                                        leadType: "Warm",
                                        dealType: "Finance",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ];
                                // When modal opens → populate table
                                const modalEl = document.getElementById('bebackCustomerModal');
                                modalEl.addEventListener('shown.bs.modal', function() {
                                    const tbody = document.getElementById('bebackCustomerDetailsBody');
                                    tbody.innerHTML = '';

                                    bebackCustomerData.forEach(lead => {
                                        const tr = document.createElement('tr');
                                        tr.innerHTML = `
    <td><span>${lead.leadStatus}</span></td>
    <td><span>${lead.salesStatus}</span></td>
    <td>${lead.createdDate}</td>
    <td class="text-primary text-decoration-underline cursor-pointer" 
        data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
    <td>${lead.assignedTo}</td>
    <td>${lead.assignedBy}</td>
    <td>${lead.createdBy}</td>
    <td>${lead.email}</td>
    <td>${formatPhoneNumber(lead.cellNumber)}</td>
    <td>${formatPhoneNumber(lead.homeNumber)}</td>
    <td>${formatPhoneNumber(lead.workNumber)}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
        data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
    <td>${lead.leadType}</td>
    <td>${lead.dealType}</td>
    <td>${lead.source}</td>
    <td>${lead.inventoryType}</td>
    <td>${lead.salesType}</td>
  `;
                                        tbody.appendChild(tr);
                                    });
                                });

                                // Helper function for phone number formatting
                                function formatPhoneNumber(number) {
                                    if (number === '-' || number === '') return number;
                                    const cleanNumber = number.replace(/[^\d]/g, '');
                                    if (cleanNumber.length === 10) {
                                        return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                    }
                                    return number;
                                }
                            });
                        </script>



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

                        <script>
                            const soldDealSourcesData = [{
                                    source: 'Referral',
                                    leads: 25,
                                    sold: 8
                                },
                                {
                                    source: 'Walk-In',
                                    leads: 40,
                                    sold: 7
                                },
                                {
                                    source: 'Website',
                                    leads: 80,
                                    sold: 12
                                },
                                {
                                    source: 'Facebook Ads',
                                    leads: 50,
                                    sold: 6
                                },
                                {
                                    source: 'Google Ads',
                                    leads: 60,
                                    sold: 5
                                },
                                {
                                    source: 'Organic Search',
                                    leads: 30,
                                    sold: 4
                                },
                                {
                                    source: 'Email Campaign',
                                    leads: 45,
                                    sold: 3
                                },
                                {
                                    source: 'Instagram',
                                    leads: 35,
                                    sold: 2
                                },
                                {
                                    source: 'LinkedIn',
                                    leads: 28,
                                    sold: 2
                                },
                                {
                                    source: 'YouTube Ads',
                                    leads: 33,
                                    sold: 1
                                }
                            ];

                            // Calculate total sold deals
                            const totalSoldDeals = soldDealSourcesData.reduce((total, item) => total + item.sold, 0);

                            const soldDealSourcesDrillDownData = {
                                'Referral': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 15, 2025 10:30 AM",
                                        customerName: "Michael Rodriguez",
                                        assignedTo: "Sarah Johnson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "michael.rodriguez@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "555-987-6543",
                                        workNumber: "-",
                                        vehicle: "2023 Toyota Camry",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 14, 2025 2:15 PM",
                                        customerName: "Jennifer Martinez",
                                        assignedTo: "David Wilson",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "jennifer.martinez@email.com",
                                        cellNumber: "555-234-5678",
                                        homeNumber: "-",
                                        workNumber: "555-876-5432",
                                        vehicle: "2022 Honda CR-V",
                                        leadType: "Warm",
                                        dealType: "Cash",
                                        source: "Referral",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 13, 2025 11:20 AM",
                                        customerName: "Robert Smith",
                                        assignedTo: "Emily Davis",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "robert.smith@email.com",
                                        cellNumber: "555-345-6789",
                                        homeNumber: "555-765-4321",
                                        workNumber: "-",
                                        vehicle: "2024 BMW X5",
                                        leadType: "Hot",
                                        dealType: "Lease",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 12, 2025 3:45 PM",
                                        customerName: "Lisa Wang",
                                        assignedTo: "James Miller",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "lisa.wang@email.com",
                                        cellNumber: "555-456-7890",
                                        homeNumber: "-",
                                        workNumber: "555-654-3210",
                                        vehicle: "2023 Mercedes C-Class",
                                        leadType: "Warm",
                                        dealType: "Finance",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 11, 2025 9:15 AM",
                                        customerName: "Thomas Brown",
                                        assignedTo: "Sarah Johnson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "thomas.brown@email.com",
                                        cellNumber: "555-567-8901",
                                        homeNumber: "555-543-2109",
                                        workNumber: "-",
                                        vehicle: "2022 Audi Q7",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Referral",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 10, 2025 1:30 PM",
                                        customerName: "Patricia Lee",
                                        assignedTo: "David Wilson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "patricia.lee@email.com",
                                        cellNumber: "555-678-9012",
                                        homeNumber: "-",
                                        workNumber: "555-432-1098",
                                        vehicle: "2024 Tesla Model Y",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 9, 2025 4:20 PM",
                                        customerName: "William Taylor",
                                        assignedTo: "Emily Davis",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "william.taylor@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2023 Ford Explorer",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Referral",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 10:45 AM",
                                        customerName: "Susan Clark",
                                        assignedTo: "James Miller",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "susan.clark@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2022 Chevrolet Silverado",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Referral",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ],

                                'Walk-In': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 13, 2025 9:45 AM",
                                        customerName: "Robert Chen",
                                        assignedTo: "Lisa Thompson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "robert.chen@email.com",
                                        cellNumber: "555-345-6789",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2024 Ford F-150",
                                        leadType: "Cold",
                                        dealType: "Lease",
                                        source: "Walk-In",
                                        inventoryType: "New",
                                        salesType: "Fleet"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 12, 2025 2:30 PM",
                                        customerName: "Maria Garcia",
                                        assignedTo: "John Anderson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "maria.garcia@email.com",
                                        cellNumber: "555-456-7890",
                                        homeNumber: "555-654-3210",
                                        workNumber: "-",
                                        vehicle: "2023 Honda Civic",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Walk-In",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 11, 2025 11:15 AM",
                                        customerName: "Kevin Wilson",
                                        assignedTo: "Lisa Thompson",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "kevin.wilson@email.com",
                                        cellNumber: "555-567-8901",
                                        homeNumber: "-",
                                        workNumber: "555-543-2109",
                                        vehicle: "2022 Toyota RAV4",
                                        leadType: "Warm",
                                        dealType: "Cash",
                                        source: "Walk-In",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 10, 2025 3:45 PM",
                                        customerName: "Jessica Martinez",
                                        assignedTo: "John Anderson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "jessica.martinez@email.com",
                                        cellNumber: "555-678-9012",
                                        homeNumber: "555-432-1098",
                                        workNumber: "-",
                                        vehicle: "2024 Hyundai Tucson",
                                        leadType: "Cold",
                                        dealType: "Lease",
                                        source: "Walk-In",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 9, 2025 10:20 AM",
                                        customerName: "Daniel Kim",
                                        assignedTo: "Lisa Thompson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "daniel.kim@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2023 Subaru Outback",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Walk-In",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 1:15 PM",
                                        customerName: "Amanda Davis",
                                        assignedTo: "John Anderson",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "amanda.davis@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2022 Mazda CX-5",
                                        leadType: "Warm",
                                        dealType: "Cash",
                                        source: "Walk-In",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 4:30 PM",
                                        customerName: "Brian Taylor",
                                        assignedTo: "Lisa Thompson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "brian.taylor@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "555-109-8765",
                                        workNumber: "-",
                                        vehicle: "2024 Kia Sportage",
                                        leadType: "Cold",
                                        dealType: "Finance",
                                        source: "Walk-In",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    }
                                ],

                                'Website': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 12, 2025 3:20 PM",
                                        customerName: "Amanda Wilson",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "amanda.wilson@email.com",
                                        cellNumber: "555-456-7890",
                                        homeNumber: "555-654-3210",
                                        workNumber: "-",
                                        vehicle: "2023 Chevrolet Equinox",
                                        leadType: "Warm",
                                        dealType: "Finance",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 11, 2025 10:45 AM",
                                        customerName: "Christopher Lee",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "chris.lee@email.com",
                                        cellNumber: "555-567-8901",
                                        homeNumber: "-",
                                        workNumber: "555-543-2109",
                                        vehicle: "2024 Jeep Wrangler",
                                        leadType: "Hot",
                                        dealType: "Lease",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 10, 2025 2:15 PM",
                                        customerName: "Sarah Johnson",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "sarah.johnson@email.com",
                                        cellNumber: "555-678-9012",
                                        homeNumber: "555-432-1098",
                                        workNumber: "-",
                                        vehicle: "2022 Ford Escape",
                                        leadType: "Warm",
                                        dealType: "Cash",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 9, 2025 11:30 AM",
                                        customerName: "David Miller",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "david.miller@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2023 Toyota Highlander",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 4:45 PM",
                                        customerName: "Jennifer Taylor",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "jennifer.taylor@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2024 Honda Accord",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 9:20 AM",
                                        customerName: "Michael Brown",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "michael.brown@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "555-109-8765",
                                        workNumber: "-",
                                        vehicle: "2022 Chevrolet Malibu",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 1:45 PM",
                                        customerName: "Emily Davis",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "emily.davis@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2023 Subaru Forester",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 3:30 PM",
                                        customerName: "Robert Wilson",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "robert.wilson@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2024 Volkswagen Tiguan",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 4, 2025 10:15 AM",
                                        customerName: "Patricia Moore",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "patricia.moore@email.com",
                                        cellNumber: "555-234-5678",
                                        homeNumber: "555-654-3210",
                                        workNumber: "-",
                                        vehicle: "2022 Nissan Rogue",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 3, 2025 2:50 PM",
                                        customerName: "James Anderson",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "james.anderson@email.com",
                                        cellNumber: "555-345-6789",
                                        homeNumber: "555-543-2109",
                                        workNumber: "-",
                                        vehicle: "2023 Hyundai Santa Fe",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 2, 2025 4:10 PM",
                                        customerName: "Linda Thomas",
                                        assignedTo: "Kevin Brown",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "linda.thomas@email.com",
                                        cellNumber: "555-456-7890",
                                        homeNumber: "-",
                                        workNumber: "555-432-1098",
                                        vehicle: "2024 Ford Bronco",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Website",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 1, 2025 11:25 AM",
                                        customerName: "William Jackson",
                                        assignedTo: "Michelle Adams",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "william.jackson@email.com",
                                        cellNumber: "555-567-8901",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2022 Toyota Tacoma",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Website",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ],

                                'Facebook Ads': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 10, 2025 1:30 PM",
                                        customerName: "Brian Thompson",
                                        assignedTo: "Rachel Green",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "brian.thompson@email.com",
                                        cellNumber: "555-678-9012",
                                        homeNumber: "-",
                                        workNumber: "555-432-1098",
                                        vehicle: "2023 Ford Mustang",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Facebook Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 9, 2025 10:45 AM",
                                        customerName: "Jessica White",
                                        assignedTo: "Mark Robinson",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "jessica.white@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2024 Honda Pilot",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Facebook Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 3:15 PM",
                                        customerName: "Kevin Harris",
                                        assignedTo: "Rachel Green",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "kevin.harris@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2022 Chevrolet Traverse",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Facebook Ads",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 11:20 AM",
                                        customerName: "Amanda Martin",
                                        assignedTo: "Mark Robinson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "amanda.martin@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "555-109-8765",
                                        workNumber: "-",
                                        vehicle: "2023 Toyota 4Runner",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Facebook Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 2:45 PM",
                                        customerName: "Daniel Walker",
                                        assignedTo: "Rachel Green",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "daniel.walker@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2024 Subaru Crosstrek",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Facebook Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 4:30 PM",
                                        customerName: "Susan King",
                                        assignedTo: "Mark Robinson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "susan.king@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2022 Jeep Grand Cherokee",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Facebook Ads",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ],

                                'Google Ads': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 9, 2025 9:30 AM",
                                        customerName: "Thomas Lewis",
                                        assignedTo: "Jessica Scott",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "thomas.lewis@email.com",
                                        cellNumber: "555-789-0123",
                                        homeNumber: "555-321-0987",
                                        workNumber: "-",
                                        vehicle: "2023 Hyundai Elantra",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Google Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 2:15 PM",
                                        customerName: "Patricia Hall",
                                        assignedTo: "Brian Young",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "patricia.hall@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2024 Kia Seltos",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Google Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 11:45 AM",
                                        customerName: "Christopher Allen",
                                        assignedTo: "Jessica Scott",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "chris.allen@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "555-109-8765",
                                        workNumber: "-",
                                        vehicle: "2022 Honda Civic",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Google Ads",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 3:30 PM",
                                        customerName: "Nancy Wright",
                                        assignedTo: "Brian Young",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "nancy.wright@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2023 Mazda3",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Google Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 10:20 AM",
                                        customerName: "Matthew Lopez",
                                        assignedTo: "Jessica Scott",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "matthew.lopez@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2024 Volkswagen Jetta",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Google Ads",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    }
                                ],

                                'Organic Search': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 8, 2025 10:15 AM",
                                        customerName: "Lisa Hill",
                                        assignedTo: "Andrew Clark",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "lisa.hill@email.com",
                                        cellNumber: "555-890-1234",
                                        homeNumber: "-",
                                        workNumber: "555-210-9876",
                                        vehicle: "2023 Toyota Corolla",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Organic Search",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 2:45 PM",
                                        customerName: "Steven Scott",
                                        assignedTo: "Karen Lewis",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "steven.scott@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "555-109-8765",
                                        workNumber: "-",
                                        vehicle: "2024 Hyundai Kona",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Organic Search",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 11:30 AM",
                                        customerName: "Melissa Green",
                                        assignedTo: "Andrew Clark",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "melissa.green@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2022 Ford Focus",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Organic Search",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 4:20 PM",
                                        customerName: "Paul Adams",
                                        assignedTo: "Karen Lewis",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "paul.adams@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2023 Nissan Sentra",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Organic Search",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    }
                                ],

                                'Email Campaign': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 7, 2025 1:30 PM",
                                        customerName: "Rebecca Baker",
                                        assignedTo: "Jason Nelson",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "rebecca.baker@email.com",
                                        cellNumber: "555-901-2345",
                                        homeNumber: "-",
                                        workNumber: "555-109-8765",
                                        vehicle: "2023 Honda HR-V",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Email Campaign",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 10:45 AM",
                                        customerName: "George Carter",
                                        assignedTo: "Amy Carter",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "george.carter@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2024 Mazda CX-30",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Email Campaign",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 3:15 PM",
                                        customerName: "Donna Mitchell",
                                        assignedTo: "Jason Nelson",
                                        assignedBy: "Admin",
                                        createdBy: "Auto",
                                        email: "donna.mitchell@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2022 Toyota Camry",
                                        leadType: "Cold",
                                        dealType: "Cash",
                                        source: "Email Campaign",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ],

                                'Instagram': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 6, 2025 2:30 PM",
                                        customerName: "Edward Perez",
                                        assignedTo: "Sophia Turner",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "edward.perez@email.com",
                                        cellNumber: "555-012-3456",
                                        homeNumber: "555-876-5432",
                                        workNumber: "-",
                                        vehicle: "2023 Kia Forte",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "Instagram",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 11:20 AM",
                                        customerName: "Catherine Roberts",
                                        assignedTo: "Daniel Phillips",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "catherine.roberts@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2024 Hyundai Venue",
                                        leadType: "Warm",
                                        dealType: "Lease",
                                        source: "Instagram",
                                        inventoryType: "New",
                                        salesType: "Retail"
                                    }
                                ],

                                'LinkedIn': [{
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 5, 2025 10:15 AM",
                                        customerName: "Richard Turner",
                                        assignedTo: "Olivia Campbell",
                                        assignedBy: "Manager",
                                        createdBy: "System",
                                        email: "richard.turner@email.com",
                                        cellNumber: "555-123-4567",
                                        homeNumber: "-",
                                        workNumber: "555-765-4321",
                                        vehicle: "2023 Chevrolet Bolt",
                                        leadType: "Hot",
                                        dealType: "Finance",
                                        source: "LinkedIn",
                                        inventoryType: "New",
                                        salesType: "Fleet"
                                    },
                                    {
                                        leadStatus: "Sold",
                                        salesStatus: "Closed",
                                        createdDate: "Nov 4, 2025 3:45 PM",
                                        customerName: "Barbara Parker",
                                        assignedTo: "Ethan Parker",
                                        assignedBy: "Sales Manager",
                                        createdBy: "CRM",
                                        email: "barbara.parker@email.com",
                                        cellNumber: "555-234-5678",
                                        homeNumber: "555-654-3210",
                                        workNumber: "-",
                                        vehicle: "2022 Ford Fusion",
                                        leadType: "Warm",
                                        dealType: "Cash",
                                        source: "LinkedIn",
                                        inventoryType: "Used",
                                        salesType: "Retail"
                                    }
                                ],

                                'YouTube Ads': [{
                                    leadStatus: "Sold",
                                    salesStatus: "Closed",
                                    createdDate: "Nov 4, 2025 1:30 PM",
                                    customerName: "Joseph Evans",
                                    assignedTo: "Victoria Edwards",
                                    assignedBy: "Manager",
                                    createdBy: "System",
                                    email: "joseph.evans@email.com",
                                    cellNumber: "555-234-5678",
                                    homeNumber: "-",
                                    workNumber: "555-654-3210",
                                    vehicle: "2023 Tesla Model 3",
                                    leadType: "Hot",
                                    dealType: "Finance",
                                    source: "YouTube Ads",
                                    inventoryType: "New",
                                    salesType: "Retail"
                                }]
                            };

                            function getSortedSoldDealSources() {
                                return [...soldDealSourcesData].sort((a, b) => {
                                    const aConversion = (a.sold / totalSoldDeals) * 100;
                                    const bConversion = (b.sold / totalSoldDeals) * 100;
                                    return bConversion - aConversion;
                                });
                            }

                            function renderSoldDealSourcesWidgetTable() {
                                const widgetTable = document.getElementById('sdsWidgetTable');
                                widgetTable.innerHTML = '';

                                const sorted = getSortedSoldDealSources().slice(0, 5);
                                sorted.forEach(item => {
                                    const conversionPercent = ((item.sold / totalSoldDeals) * 100).toFixed(1);
                                    widgetTable.innerHTML += `
                    <tr class="bg-white">
                      <td>${item.source}</td>
                      <td class="text-primary cursor-pointer conversion-percent" 
                          data-source="${item.source}" data-conversion="${conversionPercent}" data-actual="${item.sold}">
                        ${conversionPercent}%
                      </td>
                    </tr>`;
                                });
                            }

                            function renderSoldDealSourcesModalTable() {
                                const modalTable = document.getElementById('sdsModalTable');
                                modalTable.innerHTML = '';

                                const sorted = getSortedSoldDealSources();
                                sorted.forEach(item => {
                                    const conversionPercent = ((item.sold / totalSoldDeals) * 100).toFixed(1);
                                    modalTable.innerHTML += `
                    <tr>
                      <td>${item.source}</td>
                      <td class="text-primary text-decoration-underline fw-semibold cursor-pointer conversion-percent" 
                          data-source="${item.source}" data-conversion="${conversionPercent}" data-actual="${item.sold}">
                        ${conversionPercent}%
                      </td>
                    </tr>`;
                                });
                            }

                            function showSoldDealSourcesDrillDown(sourceName, conversionPercent, actualNumber) {
                                const title = document.getElementById('sdsDrillDownSourceTitle');
                                const table = document.getElementById('sdsDrillDownTable');
                                const totalActual = document.getElementById('sdsTotalActualNumber');

                                title.textContent = sourceName;
                                totalActual.textContent = actualNumber; // Changed to actualNumber (not totalSoldDeals)

                                table.innerHTML = '';

                                const sourceData = soldDealSourcesDrillDownData[sourceName] || [];
                                const numberOfLeads = sourceData.length;
                                const sourceConversionPercent = parseFloat(conversionPercent);

                                // Calculate individual percentage for each lead
                                const individualPercent = numberOfLeads > 0 ? (sourceConversionPercent / numberOfLeads) : 0;

                                sourceData.forEach(lead => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
  <td><span>${lead.leadStatus}</span></td>
  <td><span>${lead.salesStatus}</span></td>
  <td>${lead.createdDate}</td>
  <td class="text-primary text-decoration-underline cursor-pointer" 
      data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
  <td>${lead.assignedTo}</td>
  <td>${lead.assignedBy}</td>
  <td>${lead.createdBy}</td>
  <td>${lead.email}</td>
  <td>${formatPhoneNumber(lead.cellNumber)}</td>
  <td>${formatPhoneNumber(lead.homeNumber)}</td>
  <td>${formatPhoneNumber(lead.workNumber)}</td>
  <td class="text-primary text-decoration-underline cursor-pointer"
      data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
  <td>${lead.leadType}</td>
  <td>${lead.dealType}</td>
  <td>${lead.source}</td>
  <td>${lead.inventoryType}</td>
  <td>${lead.salesType}</td>
  <td>${individualPercent.toFixed(2)}%</td> <!-- Individual percentage -->
  <td>1</td> <!-- Each lead counts as 1 -->
`;
                                    table.appendChild(row);
                                });

                                // Also update the footer to show source's total conversion
                                const footer = document.querySelector('#sdsDrillDownTable + tfoot');
                                if (footer) {
                                    const totalConversionCell = footer.querySelector('td.fw-bold:nth-child(2)');
                                    if (totalConversionCell) {
                                        totalConversionCell.textContent = `${sourceConversionPercent.toFixed(1)}%`;
                                    }
                                }

                                const modal = new bootstrap.Modal(document.getElementById('soldDealSourcesDrillDownModal'));
                                modal.show();
                            }
                            // Helper function for phone number formatting
                            function formatPhoneNumber(number) {
                                if (number === '-' || number === '') return number;
                                const cleanNumber = number.replace(/[^\d]/g, '');
                                if (cleanNumber.length === 10) {
                                    return `(${cleanNumber.substring(0, 3)}) ${cleanNumber.substring(3, 6)}-${cleanNumber.substring(6)}`;
                                }
                                return number;
                            }

                            // Event listeners for conversion percentage clicks
                            document.addEventListener('click', function(e) {
                                if (e.target && e.target.classList.contains('conversion-percent')) {
                                    const sourceName = e.target.getAttribute('data-source');
                                    const conversionPercent = e.target.getAttribute('data-conversion');
                                    const actualNumber = e.target.getAttribute('data-actual');

                                    // Close the main modal if open
                                    const mainModal = bootstrap.Modal.getInstance(document.getElementById('soldDealSourcesModal'));
                                    if (mainModal) {
                                        mainModal.hide();
                                    }

                                    setTimeout(() => {
                                        showSoldDealSourcesDrillDown(sourceName, conversionPercent, actualNumber);
                                    }, 300);
                                }
                            });

                            document.addEventListener('DOMContentLoaded', () => {
                                renderSoldDealSourcesWidgetTable();
                                renderSoldDealSourcesModalTable();
                            });
                        </script>
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

                        <script>
                            const pendingFIDeals = [{
                                    customer: 'James ',
                                    vehicle: '2023 Ford F-150',
                                    daysPending: 22,
                                    email: 'james.wilson@email.com',
                                    cellNumber: '555-123-4567',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 01, 2025 10:30 AM',
                                    assignedTo: 'Sarah Johnson',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Finance',
                                    source: 'Walk-in',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Jennifer ',
                                    vehicle: '2024 Chevrolet Silverado',
                                    daysPending: 18,
                                    email: 'jennifer.martinez@email.com',
                                    cellNumber: '555-234-5678',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 05, 2025 2:15 PM',
                                    assignedTo: 'Michael Brown',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Lease',
                                    source: 'Website',
                                    inventoryType: 'New',
                                    salesType: 'Fleet'
                                },
                                {
                                    customer: 'Robert ',
                                    vehicle: '2022 Toyota Camry',
                                    daysPending: 15,
                                    email: 'robert.johnson@email.com',
                                    cellNumber: '555-345-6789',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 08, 2025 9:45 AM',
                                    assignedTo: 'Lisa Thompson',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Finance',
                                    source: 'Referral',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Emily ',
                                    vehicle: '2023 Honda CR-V',
                                    daysPending: 12,
                                    email: 'emily.davis@email.com',
                                    cellNumber: '555-456-7890',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 11, 2025 3:20 PM',
                                    assignedTo: 'David Wilson',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Cash',
                                    source: 'Facebook Ads',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Christopher ',
                                    vehicle: '2024 RAM 1500',
                                    daysPending: 9,
                                    email: 'christopher.lee@email.com',
                                    cellNumber: '555-567-8901',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 14, 2025 11:10 AM',
                                    assignedTo: 'Maria Garcia',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Finance',
                                    source: 'Google Ads',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Amanda ',
                                    vehicle: '2023 Nissan Rogue',
                                    daysPending: 7,
                                    email: 'amanda.taylor@email.com',
                                    cellNumber: '555-678-9012',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 16, 2025 4:45 PM',
                                    assignedTo: 'Kevin Davis',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Lease',
                                    source: 'Walk-in',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Daniel ',
                                    vehicle: '2022 BMW 3 Series',
                                    daysPending: 5,
                                    email: 'daniel.anderson@email.com',
                                    cellNumber: '555-789-0123',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 18, 2025 1:30 PM',
                                    assignedTo: 'Emily White',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Finance',
                                    source: 'Website',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Sarah ',
                                    vehicle: '2024 Hyundai Tucson',
                                    daysPending: 3,
                                    email: 'sarah.thompson@email.com',
                                    cellNumber: '555-890-1234',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 20, 2025 10:15 AM',
                                    assignedTo: 'Robert King',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Cash',
                                    source: 'Instagram',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Matthew ',
                                    vehicle: '2023 Jeep Wrangler',
                                    daysPending: 2,
                                    email: 'matthew.clark@email.com',
                                    cellNumber: '555-901-2345',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 21, 2025 2:45 PM',
                                    assignedTo: 'Sarah Johnson',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Finance',
                                    source: 'Referral',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Jessica ',
                                    vehicle: '2024 Ford Explorer',
                                    daysPending: 1,
                                    email: 'jessica.brown@email.com',
                                    cellNumber: '555-012-3456',
                                    leadStatus: 'Pending F&I',
                                    salesStatus: 'Processing',
                                    createdDate: 'Nov 22, 2025 3:30 PM',
                                    assignedTo: 'Michael Brown',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Lease',
                                    source: 'Website',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                }
                            ];

                            function populatePendingFIDealsWidget() {
                                const table = document.getElementById('pendingFIDealsWidget');
                                table.innerHTML = '';
                                const top5 = [...pendingFIDeals].sort((a, b) => b.daysPending - a.daysPending).slice(0, 5);

                                top5.forEach(deal => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
    <td >${deal.customer}</td>
  
    <td>${deal.daysPending}</td>
    <td >${deal.vehicle}</td>
  `;
                                    table.appendChild(row);
                                });
                            }

                            function populatePendingFIDealsModal() {
                                const table = document.getElementById('pendingFIDealsTable');
                                table.innerHTML = '';
                                const sortedAll = [...pendingFIDeals].sort((a, b) => b.daysPending - a.daysPending);

                                sortedAll.forEach(deal => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
    <td class="text-primary text-decoration-underline cursor-pointer" 
        data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${deal.customer}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
        data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${deal.vehicle}</td>
    <td>${deal.daysPending} days</td>
  `;
                                    table.appendChild(row);
                                });
                            }

                            // Export functionality
                            function exportPendingFIDeals(format) {
                                const headers = ['Customer Name', 'Vehicle', 'Days Pending', 'Email', 'Phone', 'Lead Status', 'Sales Status',
                                    'Created Date'
                                ];

                                const csvContent = [
                                    headers.join(','),
                                    ...pendingFIDeals.map(deal => [
                                        deal.customer,
                                        deal.vehicle,
                                        deal.daysPending,
                                        deal.email,
                                        deal.cellNumber,
                                        deal.leadStatus,
                                        deal.salesStatus,
                                        deal.createdDate
                                    ].map(field => `"${field}"`).join(','))
                                ].join('\n');

                                if (format === 'csv') {
                                    downloadCSV(csvContent, 'pending_fi_deals_aging.csv');
                                } else {
                                    alert('XLSX export would be implemented with SheetJS library');
                                }
                            }

                            function downloadCSV(csvContent, filename) {
                                const blob = new Blob([csvContent], {
                                    type: 'text/csv;charset=utf-8;'
                                });
                                const link = document.createElement('a');
                                const url = URL.createObjectURL(blob);
                                link.setAttribute('href', url);
                                link.setAttribute('download', filename);
                                link.style.visibility = 'hidden';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }

                            function printPendingFIDeals() {
                                const printContent = document.getElementById('pendingFIDealsModal').innerHTML;
                                const originalContent = document.body.innerHTML;

                                document.body.innerHTML = printContent;
                                window.print();
                                document.body.innerHTML = originalContent;

                                // Re-initialize the modal
                                const modal = new bootstrap.Modal(document.getElementById('pendingFIDealsModal'));
                                modal.show();
                            }

                            document.addEventListener('DOMContentLoaded', () => {
                                populatePendingFIDealsWidget();
                                document.getElementById('pendingFIDealsModal').addEventListener('show.bs.modal',
                                    populatePendingFIDealsModal);
                            });
                        </script>
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

                        <script>
                            // Sample data for Store Visit Leads Aging
                            const storeVisitDeals = [{
                                    customer: 'John Smith',
                                    vehicle: '2023 Toyota Highlander',
                                    daysPending: 25,
                                    email: 'john.smith@email.com',
                                    cellNumber: '555-111-2222',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Oct 28, 2025 09:15 AM',
                                    assignedTo: 'Alex Johnson',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Finance',
                                    source: 'Walk-in',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Maria Garcia',
                                    vehicle: '2024 Honda Accord',
                                    daysPending: 20,
                                    email: 'maria.garcia@email.com',
                                    cellNumber: '555-222-3333',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 02, 2025 11:30 AM',
                                    assignedTo: 'Michael Chen',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Lease',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'David Wilson',
                                    vehicle: '2022 BMW X5',
                                    daysPending: 17,
                                    email: 'david.wilson@email.com',
                                    cellNumber: '555-333-4444',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 05, 2025 03:45 PM',
                                    assignedTo: 'Sarah Miller',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Finance',
                                    source: 'Store Visit',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Emma Thompson',
                                    vehicle: '2023 Tesla Model Y',
                                    daysPending: 14,
                                    email: 'emma.thompson@email.com',
                                    cellNumber: '555-444-5555',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 08, 2025 10:20 AM',
                                    assignedTo: 'Robert Kim',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Cash',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'James Rodriguez',
                                    vehicle: '2024 Ford Mustang',
                                    daysPending: 11,
                                    email: 'james.rodriguez@email.com',
                                    cellNumber: '555-555-6666',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 11, 2025 02:15 PM',
                                    assignedTo: 'Lisa Wang',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Finance',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Sophia Lee',
                                    vehicle: '2023 Mercedes C-Class',
                                    daysPending: 8,
                                    email: 'sophia.lee@email.com',
                                    cellNumber: '555-666-7777',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 14, 2025 04:30 PM',
                                    assignedTo: 'Thomas Brown',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Lease',
                                    source: 'Store Visit',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Michael Johnson',
                                    vehicle: '2024 Chevrolet Tahoe',
                                    daysPending: 6,
                                    email: 'michael.johnson@email.com',
                                    cellNumber: '555-777-8888',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 16, 2025 01:10 PM',
                                    assignedTo: 'Jennifer White',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Finance',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Olivia Davis',
                                    vehicle: '2023 Audi Q7',
                                    daysPending: 4,
                                    email: 'olivia.davis@email.com',
                                    cellNumber: '555-888-9999',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 18, 2025 11:45 AM',
                                    assignedTo: 'William Taylor',
                                    assignedBy: 'Sales Manager',
                                    createdBy: 'CRM',
                                    leadType: 'Warm',
                                    dealType: 'Cash',
                                    source: 'Store Visit',
                                    inventoryType: 'Used',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Daniel Martinez',
                                    vehicle: '2024 Jeep Grand Cherokee',
                                    daysPending: 3,
                                    email: 'daniel.martinez@email.com',
                                    cellNumber: '555-999-0000',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 19, 2025 03:20 PM',
                                    assignedTo: 'Patricia Lewis',
                                    assignedBy: 'Admin',
                                    createdBy: 'Auto',
                                    leadType: 'Cold',
                                    dealType: 'Finance',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                },
                                {
                                    customer: 'Ava Anderson',
                                    vehicle: '2023 Lexus RX 350',
                                    daysPending: 2,
                                    email: 'ava.anderson@email.com',
                                    cellNumber: '555-000-1111',
                                    leadStatus: 'Store Visit',
                                    salesStatus: 'Pending Follow-up',
                                    createdDate: 'Nov 20, 2025 09:30 AM',
                                    assignedTo: 'Christopher Harris',
                                    assignedBy: 'Manager',
                                    createdBy: 'System',
                                    leadType: 'Hot',
                                    dealType: 'Lease',
                                    source: 'Store Visit',
                                    inventoryType: 'New',
                                    salesType: 'Retail'
                                }
                            ];

                            // Function to populate Store Visit Leads Aging widget (Top 5)
                            function populateStoreVisitDealsWidget() {
                                const table = document.getElementById('storeVisitDealsWidget');
                                if (!table) return;

                                table.innerHTML = '';
                                const top5 = [...storeVisitDeals].sort((a, b) => b.daysPending - a.daysPending).slice(0, 5);

                                top5.forEach(deal => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
    <td>${deal.customer}</td>
    <td>${deal.daysPending}</td>
    <td>${deal.vehicle}</td>
  `;
                                    table.appendChild(row);
                                });
                            }

                            // Function to populate Store Visit Leads Aging modal (All deals)
                            function populateStoreVisitDealsModal() {
                                const table = document.getElementById('storeVisitDealsTable');
                                if (!table) return;

                                table.innerHTML = '';
                                const sortedAll = [...storeVisitDeals].sort((a, b) => b.daysPending - a.daysPending);

                                sortedAll.forEach(deal => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
    <td class="text-primary text-decoration-underline cursor-pointer" 
        data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${deal.customer}</td>
    <td class="text-primary text-decoration-underline cursor-pointer"
        data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${deal.vehicle}</td>
    <td>${deal.daysPending} days</td>
  `;
                                    table.appendChild(row);
                                });
                            }

                            // Export functionality for Store Visit Deals
                            function exportStoreVisitDeals(format) {
                                const headers = ['Customer Name', 'Vehicle', 'Days Pending', 'Email', 'Phone', 'Lead Status', 'Sales Status',
                                    'Created Date'
                                ];

                                const csvContent = [
                                    headers.join(','),
                                    ...storeVisitDeals.map(deal => [
                                        deal.customer,
                                        deal.vehicle,
                                        deal.daysPending,
                                        deal.email,
                                        deal.cellNumber,
                                        deal.leadStatus,
                                        deal.salesStatus,
                                        deal.createdDate
                                    ].map(field => `"${field}"`).join(','))
                                ].join('\n');

                                if (format === 'csv') {
                                    downloadStoreVisitCSV(csvContent, 'store_visit_deals_aging.csv');
                                } else if (format === 'xlsx') {
                                    alert('XLSX export would be implemented with SheetJS library for Store Visit Deals');
                                } else if (format === 'pdf') {
                                    alert('PDF export would be implemented with jsPDF library for Store Visit Deals');
                                }
                            }

                            function downloadStoreVisitCSV(csvContent, filename) {
                                const blob = new Blob([csvContent], {
                                    type: 'text/csv;charset=utf-8;'
                                });
                                const link = document.createElement('a');
                                const url = URL.createObjectURL(blob);
                                link.setAttribute('href', url);
                                link.setAttribute('download', filename);
                                link.style.visibility = 'hidden';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }

                            function printStoreVisitDeals() {
                                const printContent = document.getElementById('storeVisitDealsModal').innerHTML;
                                const originalContent = document.body.innerHTML;

                                document.body.innerHTML = printContent;
                                window.print();
                                document.body.innerHTML = originalContent;

                                // Re-initialize the modal
                                const modalElement = document.getElementById('storeVisitDealsModal');
                                if (modalElement) {
                                    const modal = new bootstrap.Modal(modalElement);
                                    modal.show();
                                }
                            }

                            // Initialize on DOM load
                            document.addEventListener('DOMContentLoaded', () => {
                                // Populate Store Visit widget
                                populateStoreVisitDealsWidget();

                                // Add event listener for Store Visit modal
                                const storeVisitModal = document.getElementById('storeVisitDealsModal');
                                if (storeVisitModal) {
                                    storeVisitModal.addEventListener('show.bs.modal', populateStoreVisitDealsModal);
                                }

                                // Initialize star toggle functionality for Store Visit widget

                            });
                        </script>
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
                            – 30
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under10">
                            <div class="legend-color" style="background:#6c757d;"></div>&nbsp; Responded in 6–10
                            Mins – 25
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under15">
                            <div class="legend-color" style="background:rgb(0, 33, 64);"></div>&nbsp; Responded in
                            11–15 Mins – 20
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under30">
                            <div class="legend-color" style="background:#ffc107;"></div>&nbsp; Responded in 16–30
                            Mins – 15
                        </div>
                        <div class="legend-item clickable-legend" data-filter="under60">
                            <div class="legend-color" style="background:#17a2b8;"></div>&nbsp; Responded in 31–60
                            Mins – 12
                        </div>
                        <div class="legend-item clickable-legend" data-filter="over60">
                            <div class="legend-color" style="background:#6f42c1;"></div>&nbsp; Responded in 61+ Mins
                            – 8
                        </div>
                        <div class="legend-item clickable-legend" data-filter="nocontact">
                            <div class="legend-color" style="background:#dc3545;"></div>&nbsp; No Contact Made – 10
                        </div>
                    </div>

                    <canvas id="salesChart"></canvas>

                </div>

                <div id="filter-details" class="mt-2" style="display: none;">
                    <div class="table-responsive table-nowrap">
                        <table class="table border  datatable dataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
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

                <!-- Table - Hidden by default -->
                <div id="dealflowTableContainer" class="table-responsive table-nowrap mt-3"
                    style="display: none;">
                    <table class="table border">
                        <thead class="table-light">
                            <tr>
                                <th>Created Date</th>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Year/Make/Model</th>
                                <th>Lead Type</th>
                                <th>Deal Type</th>
                                <th class="sub-lost-reason-col" style="display: none;">Sub-Lost Reason</th>
                                <th>Source</th>
                                <th>Inventory Type</th>
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
                                            <div class="count" data-key="customers">230</div>
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
                                            <div class="count" data-key="contacted">142</div>
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
                                            <div class="count" data-key="apptSet">49</div>
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
                                            <div class="count" data-key="apptShown">27</div>
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
                                            <div class="count" data-key="sold">26</div>
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
                                    <span> Store Visit Closing Ratio: <strong>20%</strong></span>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Stage name mapping
        const stages = {
            customers: "Customers",
            contacted: "Contacted",
            apptSet: "Appointment Set",
            apptShown: "Appointment Shown",
            sold: "Sold"
        };

        // Function to format date to 12-hour format
        function formatTo12Hour(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return "";
            const options = {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            };
            const datePart = date.toLocaleDateString('en-US', options);
            let hours = date.getHours();
            let minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            return `${datePart} ${hours}:${minutes} ${ampm}`;
        }

        // FULL DATA YOU PROVIDED — INSERTED 100% (NO PLACEHOLDERS)
        const stageData = {
            customers: [{
                    date: "2025-09-17",
                    time: "10:40 AM",
                    name: "John Doe",
                    assigned: "Ali",
                    assignedBy: "Primus CRM",
                    model: "2021 Toyota Corolla",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Website",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-16",
                    time: "09:15 AM",
                    name: "Maryam",
                    assigned: "Usman",
                    assignedBy: "Primus CRM",
                    model: "2020 Honda Civic",
                    lead: "Import",
                    deal: "Finance",
                    source: "Facebook",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-15",
                    time: "02:30 PM",
                    name: "Bilal",
                    assigned: "Sara",
                    assignedBy: "Primus CRM",
                    model: "2022 Kia Sportage",
                    lead: "Internet",
                    deal: "Lease",
                    source: "Walk-in",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-14",
                    time: "11:20 AM",
                    name: "Fatima",
                    assigned: "Hamza",
                    assignedBy: "Primus CRM",
                    model: "2023 Hyundai Tucson",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Instagram",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-13",
                    time: "04:45 PM",
                    name: "Omar",
                    assigned: "Ahmed",
                    assignedBy: "Primus CRM",
                    model: "2019 Suzuki Swift",
                    lead: "Walk-In",
                    deal: "Finance",
                    source: "Referral",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                }
            ],

            contacted: [{
                    date: "2025-09-12",
                    time: "01:10 PM",
                    name: "Zain",
                    assigned: "Ali",
                    assignedBy: "Primus CRM",
                    model: "2020 Corolla",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Website",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-11",
                    time: "10:05 AM",
                    name: "Sana",
                    assigned: "Sara",
                    assignedBy: "Primus CRM",
                    model: "2018 Civic",
                    lead: "Internet",
                    deal: "Finance",
                    source: "Walk-in",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-10",
                    time: "03:25 PM",
                    name: "Ali Raza",
                    assigned: "Hamza",
                    assignedBy: "Primus CRM",
                    model: "2019 Kia Sportage",
                    lead: "Import",
                    deal: "Lease",
                    source: "Facebook",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-09",
                    time: "09:50 AM",
                    name: "Amna",
                    assigned: "Usman",
                    assignedBy: "Primus CRM",
                    model: "2021 Tucson",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Instagram",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-09-08",
                    time: "02:15 PM",
                    name: "Kamran",
                    assigned: "Ahmed",
                    assignedBy: "Primus CRM",
                    model: "2020 Swift",
                    lead: "Internet",
                    deal: "Finance",
                    source: "Referral",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                }
            ],

            apptSet: [{
                    date: "2025-09-07",
                    time: "11:30 AM",
                    name: "Shahid",
                    assigned: "Ali",
                    assignedBy: "Primus CRM",
                    model: "2021 Toyota Corolla",
                    lead: "Walk-In",
                    deal: "Lease",
                    source: "Website",
                    inventory: "New",
                    apptCreationUser: "Ali",
                    apptCreationDate: "2025-09-07 10:15 AM"
                },

                {
                    date: "2025-09-06",
                    time: "03:40 PM",
                    name: "Hira",
                    assigned: "Sara",
                    assignedBy: "Primus CRM",
                    model: "2019 Honda Civic",
                    lead: "Import",
                    deal: "Cash",
                    source: "Walk-in",
                    inventory: "Used",
                    apptCreationUser: "Sara",
                    apptCreationDate: "2025-09-06 02:20 PM"
                },

                {
                    date: "2025-09-05",
                    time: "09:25 AM",
                    name: "Danish",
                    assigned: "Hamza",
                    assignedBy: "Primus CRM",
                    model: "2022 Sportage",
                    lead: "Walk-In",
                    deal: "Finance",
                    source: "Facebook",
                    inventory: "New",
                    apptCreationUser: "Hamza",
                    apptCreationDate: "2025-09-05 08:45 AM"
                },

                {
                    date: "2025-09-04",
                    time: "01:55 PM",
                    name: "Kiran",
                    assigned: "Usman",
                    assignedBy: "Primus CRM",
                    model: "2020 Tucson",
                    lead: "Internet",
                    deal: "Lease",
                    source: "Instagram",
                    inventory: "Used",
                    apptCreationUser: "Usman",
                    apptCreationDate: "2025-09-04 12:30 PM"
                },

                {
                    date: "2025-09-03",
                    time: "04:10 PM",
                    name: "Tahir",
                    assigned: "Ahmed",
                    assignedBy: "Primus CRM",
                    model: "2023 Swift",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Referral",
                    inventory: "New",
                    apptCreationUser: "Ahmed",
                    apptCreationDate: "2025-09-03 03:25 PM"
                }
            ],

            apptShown: [{
                    date: "2025-09-02",
                    time: "10:20 AM",
                    name: "Asma",
                    assigned: "Ali",
                    assignedBy: "Primus CRM",
                    model: "2021 Corolla",
                    lead: "Internet",
                    deal: "Cash",
                    source: "Website",
                    inventory: "New",
                    apptCreationUser: "Ali",
                    apptCreationDate: "2025-09-01 02:45 PM"
                },

                {
                    date: "2025-09-01",
                    time: "02:35 PM",
                    name: "Junaid",
                    assigned: "Sara",
                    assignedBy: "Primus CRM",
                    model: "2020 Civic",
                    lead: "Walk-In",
                    deal: "Finance",
                    source: "Walk-in",
                    inventory: "Used",
                    apptCreationUser: "Sara",
                    apptCreationDate: "2025-08-31 11:10 AM"
                },

                {
                    date: "2025-08-31",
                    time: "11:45 AM",
                    name: "Ayesha",
                    assigned: "Hamza",
                    assignedBy: "Primus CRM",
                    model: "2022 Sportage",
                    lead: "Import",
                    deal: "Lease",
                    source: "Facebook",
                    inventory: "New",
                    apptCreationUser: "Hamza",
                    apptCreationDate: "2025-08-30 04:20 PM"
                },

                {
                    date: "2025-08-30",
                    time: "03:15 PM",
                    name: "Imran",
                    assigned: "Usman",
                    assignedBy: "Primus CRM",
                    model: "2019 Tucson",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Instagram",
                    inventory: "Used",
                    apptCreationUser: "Usman",
                    apptCreationDate: "2025-08-29 09:40 AM"
                },

                {
                    date: "2025-08-29",
                    time: "09:55 AM",
                    name: "Nida",
                    assigned: "Ahmed",
                    assignedBy: "Primus CRM",
                    model: "2023 Swift",
                    lead: "Internet",
                    deal: "Finance",
                    source: "Referral",
                    inventory: "New",
                    apptCreationUser: "Ahmed",
                    apptCreationDate: "2025-08-28 01:30 PM"
                }
            ],

            sold: [{
                    date: "2025-08-28",
                    time: "01:20 PM",
                    name: "Hassan",
                    assigned: "Ali",
                    assignedBy: "Primus CRM",
                    model: "2021 Corolla",
                    lead: "Walk-In",
                    deal: "Cash",
                    source: "Website",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-08-27",
                    time: "10:10 AM",
                    name: "Saira",
                    assigned: "Sara",
                    assignedBy: "Primus CRM",
                    model: "2019 Civic",
                    lead: "Import",
                    deal: "Finance",
                    source: "Walk-in",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-08-26",
                    time: "04:30 PM",
                    name: "Rizwan",
                    assigned: "Hamza",
                    assignedBy: "Primus CRM",
                    model: "2022 Sportage",
                    lead: "Walk-In",
                    deal: "Lease",
                    source: "Facebook",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-08-25",
                    time: "11:05 AM",
                    name: "Mahnoor",
                    assigned: "Usman",
                    assignedBy: "Primus CRM",
                    model: "2020 Tucson",
                    lead: "Internet",
                    deal: "Cash",
                    source: "Instagram",
                    inventory: "Used",
                    apptCreationUser: "",
                    apptCreationDate: ""
                },

                {
                    date: "2025-08-24",
                    time: "02:50 PM",
                    name: "Adil",
                    assigned: "Ahmed",
                    assignedBy: "Primus CRM",
                    model: "2023 Swift",
                    lead: "Walk-In",
                    deal: "Finance",
                    source: "Referral",
                    inventory: "New",
                    apptCreationUser: "",
                    apptCreationDate: ""
                }
            ]
        };

        // Navigate to profile
        function navigateToCustomerProfile(customerName) {
            console.log(`Navigating to customer profile: ${customerName}`);
            alert(`Navigating to customer profile: ${customerName}`);
        }

        // Event: clicking each stage opens table
        document.querySelectorAll("#dealFlow .stage, #dealFlow .stage-wrapper").forEach(element => {
            element.addEventListener("click", function() {
                let stageCard = this.classList.contains("stage") ?
                    this :
                    this.querySelector(".stage");

                if (!stageCard) return;

                const stageKey = stageCard.querySelector(".count").getAttribute("data-key");
                const stageTitle = stages[stageKey] || "Stage Details";
                document.getElementById("DealstageTitle").textContent = stageTitle;

                // Show/hide Appointment Set / Shown extra columns
                const showExtra = stageKey === "apptSet" || stageKey === "apptShown";
                document.getElementById("apptCreationUserHeader").style.display = showExtra ?
                    "table-cell" : "none";
                document.getElementById("apptCreationDateHeader").style.display = showExtra ?
                    "table-cell" : "none";

                // Fill Table
                const tbody = document.getElementById("DealstageTableBody");
                tbody.innerHTML = "";

                (stageData[stageKey] || []).forEach(row => {

                    const formattedAppt = formatTo12Hour(row.apptCreationDate);

                    tbody.innerHTML += `
<tr>
  
    <td style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.name}</td>
    <td>${row.assigned}</td>
    <td>${row.assignedBy}</td>
    <td  style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.model}</td>
    <td>${row.lead}</td>
    <td>${row.deal}</td>
    <td>${row.source}</td>
    <td>${row.inventory}</td>
    ${showExtra ? `
        <td>${row.apptCreationUser}</td>
        <td>${formattedAppt}</td>
    ` : ``}
</tr>
`;


                });

                document.getElementById("DealstageDetails").style.display = "block";
            });
        });

        // Initialize conversion calculations
        const order = ["customers", "contacted", "apptSet", "apptShown", "sold"];

        function clamp(n) {
            return Math.max(0, Number.isFinite(+n) ? +n : 0);
        }

        function calcAndRender() {
            // Read numbers from DOM
            const vals = {};
            order.forEach(k => {
                const el = document.querySelector(`[data-key="${k}"]`);
                vals[k] = clamp(el ? el.textContent : 0);
            });

            // Compute stage-to-stage conversion and progress bars
            order.forEach((k, idx) => {
                const badge = document.querySelector(`[data-from="${k}"]`);
                const bar = document.querySelector(`[data-bar="${k}"]`);
                if (!badge || !bar) return; // avoid null errors

                if (idx === 0) {
                    badge.textContent = "Start";
                    bar.style.width = "100%";
                    bar.setAttribute('aria-valuenow', 100);
                    bar.setAttribute('aria-valuemin', 0);
                    bar.setAttribute('aria-valuemax', 100);
                } else {
                    const prev = vals[order[idx - 1]];
                    const cur = vals[k];
                    const pct = prev > 0 ? Math.round((cur / prev) * 100) : 0;
                    badge.textContent = prev === 0 ? "—" : `${pct}%`;
                    bar.style.width = `${Math.min(100, Math.max(0, pct))}%`;
                    bar.setAttribute('aria-valuenow', pct);
                    bar.setAttribute('aria-valuemin', 0);
                    bar.setAttribute('aria-valuemax', 100);
                }
            });

            // Overall conversion
            const overall = vals["customers"] > 0 ? Math.round((vals["sold"] / vals["customers"]) * 100) : 0;
            const overallEl = document.getElementById("overallConv");
            if (overallEl) overallEl.textContent = `${overall}%`;
        }

        // Initialize from default values in markup
        calcAndRender();

        window.navigateToCustomerProfile = navigateToCustomerProfile;
        /* ============================================================
DEBUGGING BLOCK - ENABLES COMPLETE FLAW DETECTION
============================================================ */
        console.log("DEBUG: Sales Funnel Script Loaded");

        try {
            // Log modal opening
            const modal = document.getElementById("salesfunnelModal");
            if (modal) {
                modal.addEventListener("shown.bs.modal", () => {
                    console.log("DEBUG: Sales Funnel Modal Opened");
                });
            } else {
                console.warn("DEBUG WARNING: salesfunnelModal NOT FOUND.");
            }

            // Log clicks on stages
            document.querySelectorAll("#dealFlow .stage, #dealFlow .stage-wrapper").forEach(element => {
                element.addEventListener("click", function() {
                    let stageCard = this.classList.contains("stage") ?
                        this :
                        this.querySelector(".stage");

                    if (!stageCard) {
                        console.error("DEBUG ERROR: No stage card found on click event.");
                        return;
                    }

                    const stageKey = stageCard.querySelector(".count")?.getAttribute(
                        "data-key");
                    console.log("DEBUG: Stage Clicked =", stageKey);

                    if (!stageKey) {
                        console.error("DEBUG ERROR: Missing data-key for clicked stage.");
                        return;
                    }

                    if (!stageData[stageKey]) {
                        console.error("DEBUG ERROR: No stageData entry found for key:",
                            stageKey);
                    } else {
                        console.log(
                            `DEBUG: Loaded ${stageData[stageKey].length} rows for stage "${stageKey}"`
                        );
                    }
                });
            });

            // Log table population
            const originalTableFunction = (stageKey) => {
                console.log("DEBUG: Populating table for stage =", stageKey);
                const data = stageData[stageKey] || [];
                if (!Array.isArray(data)) {
                    console.error("DEBUG ERROR: stageData entry is NOT an array:", stageKey);
                }
                data.forEach((row, index) => {
                    console.log(`DEBUG ROW ${index}:`, row);
                });
            };

            // Hook into your existing click logic
            document.querySelectorAll("#dealFlow .stage, #dealFlow .stage-wrapper").forEach(element => {
                element.addEventListener("click", function() {
                    const stageCard = this.classList.contains("stage") ?
                        this :
                        this.querySelector(".stage");

                    const stageKey = stageCard?.querySelector(".count")?.getAttribute(
                        "data-key");
                    if (stageKey) originalTableFunction(stageKey);
                });
            });

            // Log conversion calculation values
            const order = ["customers", "contacted", "apptSet", "apptShown", "sold"];
            console.log("DEBUG: Initial Stage Order:", order);

            order.forEach(k => {
                const el = document.querySelector(`[data-key="${k}"]`);
                if (!el) {
                    console.warn(`DEBUG WARNING: Missing DOM element for stage: ${k}`);
                } else {
                    console.log(`DEBUG: Loaded count for ${k}:`, el.textContent);
                }
            });

            console.log("DEBUG: stageData Keys:", Object.keys(stageData));

        } catch (e) {
            console.error("DEBUG FATAL ERROR:", e);
        }

    });
</script>

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

<script>
    const emailData = [{
            date: '2025-08-08',
            type: 'Sent',
            from: 'me@company.com',
            to: 'client1@example.com',
            subject: 'Follow-up Meeting'
        },
        {
            date: '2025-08-08',
            type: 'Received',
            from: 'client2@example.com',
            to: 'me@company.com',
            subject: 'Quote Request'
        },
        {
            date: '2025-08-07',
            type: 'Sent',
            from: 'me@company.com',
            to: 'client3@example.com',
            subject: 'Proposal'
        },
        {
            date: '2025-07-20',
            type: 'Received',
            from: 'client4@example.com',
            to: 'me@company.com',
            subject: 'Contract Signed'
        },
        {
            date: '2025-07-15',
            type: 'Sent',
            from: 'me@company.com',
            to: 'client5@example.com',
            subject: 'Project Update'
        }
    ];

    // Helper to format date for filtering
    function formatDate(date) {
        return new Date(date).toISOString().split('T')[0];
    }

    // Populate table with filter
    function populateEmailTable(period) {
        const today = new Date();
        let filteredData = emailData;

        if (period === 'today') {
            filteredData = emailData.filter(e => formatDate(e.date) === formatDate(today));
        } else if (period === 'yesterday') {
            const yest = new Date(today);
            yest.setDate(yest.getDate() - 1);
            filteredData = emailData.filter(e => formatDate(e.date) === formatDate(yest));
        } else if (period === 'thisMonth') {
            const month = today.getMonth();
            const year = today.getFullYear();
            filteredData = emailData.filter(e => {
                const d = new Date(e.date);
                return d.getMonth() === month && d.getFullYear() === year;
            });
        } else if (period === 'lastMonth') {
            let month = today.getMonth() - 1;
            let year = today.getFullYear();
            if (month < 0) {
                month = 11;
                year--;
            }
            filteredData = emailData.filter(e => {
                const d = new Date(e.date);
                return d.getMonth() === month && d.getFullYear() === year;
            });
        }

        const tbody = document.getElementById('emailTableBody');
        const tbody1 = document.getElementById('textTableBody');

        tbody.innerHTML = '';
        tbody1.innerHTML = '';


        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">No emails found for this period</td></tr>`;
            tbody1.innerHTML = `<tr><td colspan="5" class="text-center">No emails found for this period</td></tr>`;

            return;
        }

        filteredData.forEach(email => {
            const row = document.createElement('tr');
            row.innerHTML = `
                        <td>${email.date}</td>
                        <td>${email.type}</td>
                        <td>${email.from}</td>
                        <td>${email.to}</td>
                        <td>${email.subject}</td>
                      `;
            tbody.appendChild(row);
            tbody1.appendChild(row);

        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateEmailTable('today'); // default view
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                populateEmailTable(btn.dataset.period);
            });
        });
    });
</script>
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
                        <tbody id="loginTableBody">
                            <tr>
                                <td>John Smith</td>
                                <td>Jan 10, 2026 8:10AM</td>
                                <td>Jan 10, 2026 9:15AM</td>
                            </tr>
                            <tr>
                                <td>Emily</td>
                                <td>Jan 10, 2026 8:45AM</td>
                                <td>Jan 10, 2026 10:20AM</td>
                            </tr>
                            <tr>
                                <td>Michael</td>
                                <td>Jan 10, 2026 9:05AM</td>
                                <td>Jan 10, 2026 11:30AM</td>
                            </tr>
                            <tr>
                                <td>Jessica</td>
                                <td>Jan 10, 2026 9:20AM</td>
                                <td>Jan 10, 2026 1:45PM</td>
                            </tr>
                            <tr>
                                <td>David</td>
                                <td>Jan 10, 2026 9:50AM</td>
                                <td>Jan 10, 2026 2:15PM</td>
                            </tr>
                            <tr>
                                <td>Ashley</td>
                                <td>Jan 10, 2026 10:15AM</td>
                                <td>Jan 10, 2026 3:00PM</td>
                            </tr>
                            <tr>
                                <td>Matthew</td>
                                <td>Jan 10, 2026 10:35AM</td>
                                <td>Jan 10, 2026 4:25PM</td>
                            </tr>
                            <tr>
                                <td>Brittany</td>
                                <td>Jan 10, 2026 11:00AM</td>
                                <td>Jan 10, 2026 5:10PM</td>
                            </tr>
                            <tr>
                                <td>Christopher</td>
                                <td>Jan 10, 2026 11:25AM</td>
                                <td>Jan 10, 2026 6:05PM</td>
                            </tr>
                            <tr>
                                <td>Lauren</td>
                                <td>Jan 10, 2026 11:45AM</td>
                                <td>Jan 10, 2026 7:20PM</td>
                            </tr>
                            <tr>
                                <td>Joshua</td>
                                <td>Jan 10, 2026 12:10PM</td>
                                <td>Jan 10, 2026 8:30PM</td>
                            </tr>
                            <tr>
                                <td>Madison</td>
                                <td>Jan 10, 2026 12:30PM</td>
                                <td>Jan 10, 2026 9:45PM</td>
                            </tr>
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

<script>
    const repsData = [{
            name: 'Henry Thomas',
            count: 9,
            customers: [{
                    leadStatus: "Active",
                    salesStatus: "Pending",
                    completedDate: "Nov 13, 2026 10:30 AM", // Added completedDate
                    createdDate: "Nov 12, 2026 8:00 PM",
                    customerName: "Jack Robinson",
                    assignedTo: "Henry Thomas",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "jack.robinson@email.com",
                    cellNumber: "555-123-4567",
                    homeNumber: "555-987-6543",
                    workNumber: "555-222-3333",
                    vehicle: "Toyota Fortuner",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail"
                },
                {
                    leadStatus: "Sold",
                    salesStatus: "Closed",
                    completedDate: "Nov 14, 2026 2:15 PM", // Added completedDate
                    createdDate: "Nov 10, 2026 9:30 AM",
                    customerName: "Sarah Connor",
                    assignedTo: "Henry Thomas",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "sarah.connor@email.com",
                    cellNumber: "555-444-5555",
                    homeNumber: "555-666-7777",
                    workNumber: "555-888-9999",
                    vehicle: "Ford Mustang",
                    leadType: "Hot",
                    dealType: "Cash",
                    source: "Referral",
                    inventoryType: "New",
                    salesType: "Retail"
                }
            ]
        },
        {
            name: 'Alice Johnson',
            count: 8,
            customers: [{
                    leadStatus: "New",
                    salesStatus: "Open",
                    completedDate: "Nov 12, 2026 11:45 AM", // Added completedDate
                    createdDate: "Nov 11, 2026 2:30 PM",
                    customerName: "John Doe",
                    assignedTo: "Alice Johnson",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "john.doe@email.com",
                    cellNumber: "555-444-5555",
                    homeNumber: "555-666-7777",
                    workNumber: "555-888-9999",
                    vehicle: "Toyota Corolla",
                    leadType: "Warm",
                    dealType: "Cash",
                    source: "Referral",
                    inventoryType: "Used",
                    salesType: "Retail"
                },
                {
                    leadStatus: "Active",
                    salesStatus: "Contacted",
                    completedDate: "Nov 13, 2026 3:20 PM", // Added completedDate
                    createdDate: "Nov 09, 2026 4:15 PM",
                    customerName: "Jane Smith",
                    assignedTo: "Alice Johnson",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "jane.smith@email.com",
                    cellNumber: "555-111-2222",
                    homeNumber: "555-333-4444",
                    workNumber: "555-555-6666",
                    vehicle: "Honda Civic",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail"
                }
            ]
        },
        {
            name: 'Grace Parker',
            count: 7,
            customers: [{
                    leadStatus: "Sold",
                    salesStatus: "Closed",
                    completedDate: "Nov 11, 2026 9:00 AM", // Added completedDate
                    createdDate: "Nov 10, 2026 10:15 AM",
                    customerName: "Omar Sheikh",
                    assignedTo: "Grace Parker",
                    assignedBy: "Supervisor",
                    createdBy: "Auto",
                    email: "omar.sheikh@email.com",
                    cellNumber: "555-777-8888",
                    homeNumber: "555-999-0000",
                    workNumber: "555-121-2121",
                    vehicle: "Hyundai Sonata",
                    leadType: "Hot",
                    dealType: "Lease",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Fleet"
                },
                {
                    leadStatus: "Completed",
                    salesStatus: "Delivered",
                    completedDate: "Nov 14, 2026 4:45 PM", // Added completedDate
                    createdDate: "Nov 08, 2026 1:30 PM",
                    customerName: "Robert Chen",
                    assignedTo: "Grace Parker",
                    assignedBy: "Supervisor",
                    createdBy: "Auto",
                    email: "robert.chen@email.com",
                    cellNumber: "555-222-3333",
                    homeNumber: "555-444-5555",
                    workNumber: "555-666-7777",
                    vehicle: "Kia Sorento",
                    leadType: "Warm",
                    dealType: "Finance",
                    source: "Referral",
                    inventoryType: "Used",
                    salesType: "Retail"
                }
            ]
        },
        {
            name: 'Bob Smith',
            count: 6,
            customers: [{
                    leadStatus: "Pending",
                    salesStatus: "Active",
                    completedDate: "Nov 10, 2026 5:30 PM", // Added completedDate
                    createdDate: "Nov 9, 2026 4:45 PM",
                    customerName: "Michael Brown",
                    assignedTo: "Bob Smith",
                    assignedBy: "Manager",
                    createdBy: "Manual",
                    email: "michael.brown@email.com",
                    cellNumber: "555-232-3232",
                    homeNumber: "555-454-5454",
                    workNumber: "555-676-7676",
                    vehicle: "Hyundai Elantra",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "Used",
                    salesType: "Retail"
                },
                {
                    leadStatus: "Follow-up",
                    salesStatus: "Scheduled",
                    completedDate: "Nov 12, 2026 10:00 AM", // Added completedDate
                    createdDate: "Nov 07, 2026 3:15 PM",
                    customerName: "Lisa Wong",
                    assignedTo: "Bob Smith",
                    assignedBy: "Manager",
                    createdBy: "Manual",
                    email: "lisa.wong@email.com",
                    cellNumber: "555-898-9898",
                    homeNumber: "555-787-8787",
                    workNumber: "555-656-5656",
                    vehicle: "Mazda CX-5",
                    leadType: "Warm",
                    dealType: "Lease",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail"
                }
            ]
        },
        {
            name: 'James Carter',
            count: 6,
            customers: [{
                    leadStatus: "Completed",
                    salesStatus: "Finished",
                    completedDate: "Nov 09, 2026 2:45 PM", // Added completedDate
                    createdDate: "Nov 8, 2026 11:20 AM",
                    customerName: "Samuel Perez",
                    assignedTo: "James Carter",
                    assignedBy: "Admin",
                    createdBy: "System",
                    email: "samuel.perez@email.com",
                    cellNumber: "555-989-8989",
                    homeNumber: "555-767-6767",
                    workNumber: "555-545-4545",
                    vehicle: "Honda Jazz",
                    leadType: "Warm",
                    dealType: "Cash",
                    source: "Referral",
                    inventoryType: "New",
                    salesType: "Retail"
                },
                {
                    leadStatus: "Active",
                    salesStatus: "Negotiating",
                    completedDate: "Nov 13, 2026 1:30 PM", // Added completedDate
                    createdDate: "Nov 06, 2026 9:45 AM",
                    customerName: "David Miller",
                    assignedTo: "James Carter",
                    assignedBy: "Admin",
                    createdBy: "System",
                    email: "david.miller@email.com",
                    cellNumber: "555-323-2323",
                    homeNumber: "555-434-3434",
                    workNumber: "555-545-4545",
                    vehicle: "Toyota RAV4",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail"
                }
            ]
        }
    ];

    // Populate Top 5
    function populateTopRepList() {
        const list = document.getElementById('topRepList');
        if (!list) return;

        list.innerHTML = '';
        [...repsData]
        .sort((a, b) => b.count - a.count)
            .slice(0, 5)
            .forEach(rep => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
          <span class="text-primary cursor-pointer rep-name" data-rep="${rep.name}">${rep.name}</span>
          <span class="badge bg-secondary rounded-pill cursor-pointer rep-name" data-rep="${rep.name}">${rep.count}</span>
        `;
                list.appendChild(li);
            });
    }

    // Populate Full List
    function populateFullRepList() {
        const list = document.getElementById('fullRepList');
        if (!list) return;

        list.innerHTML = '';
        [...repsData]
        .sort((a, b) => b.count - a.count)
            .forEach(rep => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
          <span class="text-primary cursor-pointer rep-name" data-rep="${rep.name}">${rep.name}</span>
          <span class="badge bg-secondary rounded-pill cursor-pointer rep-name" data-rep="${rep.name}">${rep.count}</span>
        `;
                list.appendChild(li);
            });
    }

    // Show Rep's Customers
    function showRepCustomers(repName) {
        const rep = repsData.find(r => r.name === repName);
        const table = document.getElementById('repCustomerTable');
        const title = document.getElementById('repNameTitle');

        if (!rep || !table || !title) return;

        title.textContent = rep.name;
        table.innerHTML = '';

        rep.customers.forEach(cust => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td><span>${cust.leadStatus}</span></td>
        <td><span>${cust.salesStatus}</span></td>
        <td>${cust.completedDate || '---'}</td>
        <td>${cust.createdDate}</td>
        <td class="text-primary text-decoration-underline cursor-pointer" 
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${cust.customerName}</td>
        <td>${cust.assignedTo}</td>
        <td>${cust.assignedBy}</td>
        <td>${cust.createdBy}</td>
        <td>${cust.email}</td>
        <td>${cust.cellNumber}</td>
        <td>${cust.homeNumber}</td>
        <td>${cust.workNumber}</td>
        <td class="text-primary text-decoration-underline cursor-pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${cust.vehicle}</td>
        <td>${cust.leadType}</td>
        <td>${cust.dealType}</td>
        <td>${cust.source}</td>
        <td>${cust.inventoryType}</td>
        <td>${cust.salesType}</td>
      `;
            table.appendChild(row);
        });

        const modalElement = document.getElementById('repDetailModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }

    // Event Listeners
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('rep-name')) {
            const repName = e.target.getAttribute('data-rep');
            const repListModalElement = document.getElementById('repListModal');
            if (repListModalElement) {
                const modal = bootstrap.Modal.getInstance(repListModalElement);
                if (modal) modal.hide();
            }
            setTimeout(() => showRepCustomers(repName), 300);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        populateTopRepList();
        populateFullRepList();
    });
</script>

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

<script>
    const lostReasons = [{
            reason: 'Bad Credit',
            count: 30,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 15, 2025 10:30 AM",
                    lostDateTime: "Nov 18, 2025 11:45 AM",
                    customerName: "John Doe",
                    assignedTo: "Sarah Lee",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "john.doe@email.com",
                    cellNumber: "555-123-4567",
                    homeNumber: "555-987-6543",
                    workNumber: "-",
                    vehicle: "2023 Toyota Corolla",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Bad Credit"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 14, 2025 2:15 PM",
                    lostDateTime: "Nov 17, 2025 3:30 PM",
                    customerName: "Jane Smith",
                    assignedTo: "Mike Johnson",
                    assignedBy: "Sales Manager",
                    createdBy: "CRM",
                    email: "jane.smith@email.com",
                    cellNumber: "555-234-5678",
                    homeNumber: "-",
                    workNumber: "555-876-5432",
                    vehicle: "2022 Honda Civic",
                    leadType: "Warm",
                    dealType: "Cash",
                    source: "Walk-in",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Bad Credit"
                }
            ]
        },
        {
            reason: 'Bad Email',
            count: 25,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 13, 2025 9:45 AM",
                    lostDateTime: "Nov 16, 2025 10:20 AM",
                    customerName: "Ali Khan",
                    assignedTo: "David Wilson",
                    assignedBy: "Admin",
                    createdBy: "Auto",
                    email: "ali.khan@email.com",
                    cellNumber: "555-345-6789",
                    homeNumber: "555-765-4321",
                    workNumber: "-",
                    vehicle: "2023 Hyundai Sonata",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Bad Email"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 12, 2025 3:20 PM",
                    lostDateTime: "Nov 15, 2025 4:45 PM",
                    customerName: "Sarah Ahmed",
                    assignedTo: "Lisa Brown",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "sarah.ahmed@email.com",
                    cellNumber: "555-456-7890",
                    homeNumber: "-",
                    workNumber: "-",
                    vehicle: "2024 Kia Sorento",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Google Ads",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Bad Email"
                }
            ]
        },
        {
            reason: 'Bad Phone Number',
            count: 22,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 11, 2025 11:10 AM",
                    lostDateTime: "Nov 14, 2025 2:15 PM",
                    customerName: "Sara Ahmed",
                    assignedTo: "Kevin Davis",
                    assignedBy: "Sales Manager",
                    createdBy: "CRM",
                    email: "sara.ahmed@email.com",
                    cellNumber: "555-567-8901",
                    homeNumber: "555-654-3210",
                    workNumber: "-",
                    vehicle: "2023 Kia Picanto",
                    leadType: "Warm",
                    dealType: "Lease",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Bad Phone Number"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 10, 2025 4:45 PM",
                    lostDateTime: "Nov 13, 2025 5:30 PM",
                    customerName: "Daniel Taylor",
                    assignedTo: "Emily White",
                    assignedBy: "Admin",
                    createdBy: "Auto",
                    email: "daniel.taylor@email.com",
                    cellNumber: "555-678-9012",
                    homeNumber: "-",
                    workNumber: "555-432-1098",
                    vehicle: "2022 Toyota RAV4",
                    leadType: "Cold",
                    dealType: "Cash",
                    source: "Website",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Bad Phone Number"
                }
            ]
        },
        {
            reason: 'Did Not Respond',
            count: 20,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 09, 2025 1:30 PM",
                    lostDateTime: "Nov 12, 2025 9:00 AM",
                    customerName: "Hassan Raza",
                    assignedTo: "Maria Garcia",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "hassan.raza@email.com",
                    cellNumber: "555-789-0123",
                    homeNumber: "555-321-0987",
                    workNumber: "-",
                    vehicle: "2024 MG HS",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Referral",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Did Not Respond"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 08, 2025 10:15 AM",
                    lostDateTime: "Nov 11, 2025 11:45 AM",
                    customerName: "Michael Brown",
                    assignedTo: "Robert King",
                    assignedBy: "Sales Manager",
                    createdBy: "CRM",
                    email: "michael.brown@email.com",
                    cellNumber: "555-890-1234",
                    homeNumber: "-",
                    workNumber: "555-210-9876",
                    vehicle: "2023 Nissan Altima",
                    leadType: "Warm",
                    dealType: "Lease",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Did Not Respond"
                }
            ]
        },
        {
            reason: 'Diff Dealer, Diff Brand',
            count: 18,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 07, 2025 2:45 PM",
                    lostDateTime: "Nov 10, 2025 3:15 PM",
                    customerName: "Mehwish Mirza",
                    assignedTo: "Sarah Lee",
                    assignedBy: "Admin",
                    createdBy: "Auto",
                    email: "mehwish.mirza@email.com",
                    cellNumber: "555-901-2345",
                    homeNumber: "555-109-8765",
                    workNumber: "-",
                    vehicle: "2021 Toyota Corolla",
                    leadType: "Cold",
                    dealType: "Cash",
                    source: "Website",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Diff Brand"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 06, 2025 3:30 PM",
                    lostDateTime: "Nov 09, 2025 10:30 AM",
                    customerName: "Waleed Khan",
                    assignedTo: "Mike Johnson",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "waleed.khan@email.com",
                    cellNumber: "555-012-3456",
                    homeNumber: "-",
                    workNumber: "555-098-7654",
                    vehicle: "2024 Tesla Model 3",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Diff Brand"
                }
            ]
        },
        {
            reason: 'Diff Dealer, Same Brand',
            count: 16,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 05, 2025 9:20 AM",
                    lostDateTime: "Nov 08, 2025 2:45 PM",
                    customerName: "Omar Ali",
                    assignedTo: "David Wilson",
                    assignedBy: "Sales Manager",
                    createdBy: "CRM",
                    email: "omar.ali@email.com",
                    cellNumber: "555-123-9876",
                    homeNumber: "555-987-1234",
                    workNumber: "-",
                    vehicle: "2023 Hyundai Elantra",
                    leadType: "Warm",
                    dealType: "Lease",
                    source: "Google Ads",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Same Brand"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 04, 2025 11:45 AM",
                    lostDateTime: "Nov 07, 2025 1:30 PM",
                    customerName: "Imran Shah",
                    assignedTo: "Lisa Brown",
                    assignedBy: "Admin",
                    createdBy: "Auto",
                    email: "imran.shah@email.com",
                    cellNumber: "555-234-8765",
                    homeNumber: "-",
                    workNumber: "-",
                    vehicle: "2022 Honda Accord",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Same Brand"
                }
            ]
        },
        {
            reason: 'Diff Dealer, Same Group',
            count: 14,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 03, 2025 4:10 PM",
                    lostDateTime: "Nov 06, 2025 9:15 AM",
                    customerName: "Usman Tariq",
                    assignedTo: "Kevin Davis",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "usman.tariq@email.com",
                    cellNumber: "555-345-7654",
                    homeNumber: "555-765-2345",
                    workNumber: "-",
                    vehicle: "2021 Ford Explorer",
                    leadType: "Hot",
                    dealType: "Cash",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Same Group"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 02, 2025 1:55 PM",
                    lostDateTime: "Nov 05, 2025 3:45 PM",
                    customerName: "Hamza Ahmed",
                    assignedTo: "Emily White",
                    assignedBy: "Sales Manager",
                    createdBy: "CRM",
                    email: "hamza.ahmed@email.com",
                    cellNumber: "555-456-6543",
                    homeNumber: "-",
                    workNumber: "555-654-3456",
                    vehicle: "2024 Hyundai Tucson",
                    leadType: "Warm",
                    dealType: "Finance",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Diff Dealer, Same Group"
                }
            ]
        },
        {
            reason: 'Import Lead',
            count: 12,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Nov 01, 2025 9:00 AM",
                    lostDateTime: "Nov 04, 2025 10:30 AM",
                    customerName: "Farhan Ali",
                    assignedTo: "Maria Garcia",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "farhan.ali@email.com",
                    cellNumber: "555-567-5432",
                    homeNumber: "555-543-2109",
                    workNumber: "-",
                    vehicle: "2023 Mazda CX-5",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Import",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Import Lead"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 31, 2025 2:30 PM",
                    lostDateTime: "Nov 03, 2025 4:00 PM",
                    customerName: "Alex Johnson",
                    assignedTo: "Robert King",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "alex.johnson@email.com",
                    cellNumber: "555-678-4321",
                    homeNumber: "-",
                    workNumber: "555-321-0987",
                    vehicle: "2022 Subaru Outback",
                    leadType: "Warm",
                    dealType: "Cash",
                    source: "Import",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Import Lead"
                }
            ]
        },
        {
            reason: 'No Agreement Reached',
            count: 10,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 30, 2025 11:20 AM",
                    lostDateTime: "Nov 02, 2025 2:15 PM",
                    customerName: "Sophia Wilson",
                    assignedTo: "David Wilson",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "sophia.wilson@email.com",
                    cellNumber: "555-789-3210",
                    homeNumber: "555-210-9876",
                    workNumber: "-",
                    vehicle: "2024 Chevrolet Equinox",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "No Agreement Reached"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 29, 2025 3:45 PM",
                    lostDateTime: "Nov 01, 2025 10:45 AM",
                    customerName: "James Miller",
                    assignedTo: "Lisa Brown",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "james.miller@email.com",
                    cellNumber: "555-890-2109",
                    homeNumber: "-",
                    workNumber: "555-098-7654",
                    vehicle: "2023 Volkswagen Tiguan",
                    leadType: "Hot",
                    dealType: "Lease",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "No Agreement Reached"
                }
            ]
        },
        {
            reason: 'No Credit',
            count: 8,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 28, 2025 10:10 AM",
                    lostDateTime: "Oct 31, 2025 11:30 AM",
                    customerName: "Emma Davis",
                    assignedTo: "Kevin Davis",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "emma.davis@email.com",
                    cellNumber: "555-901-0987",
                    homeNumber: "555-109-8765",
                    workNumber: "-",
                    vehicle: "2023 Kia Sportage",
                    leadType: "Warm",
                    dealType: "Finance",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "No Credit"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 27, 2025 1:25 PM",
                    lostDateTime: "Oct 30, 2025 3:20 PM",
                    customerName: "Noah Garcia",
                    assignedTo: "Emily White",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "noah.garcia@email.com",
                    cellNumber: "555-012-8765",
                    homeNumber: "-",
                    workNumber: "555-876-5432",
                    vehicle: "2022 Ford Escape",
                    leadType: "Cold",
                    dealType: "Cash",
                    source: "Google Ads",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "No Credit"
                }
            ]
        },
        {
            reason: 'No Longer Owns',
            count: 6,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 26, 2025 9:45 AM",
                    lostDateTime: "Oct 29, 2025 10:15 AM",
                    customerName: "Olivia Martinez",
                    assignedTo: "Maria Garcia",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "olivia.martinez@email.com",
                    cellNumber: "555-123-6543",
                    homeNumber: "555-987-0123",
                    workNumber: "-",
                    vehicle: "2024 Toyota Camry",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "No Longer Owns"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 25, 2025 2:15 PM",
                    lostDateTime: "Oct 28, 2025 4:30 PM",
                    customerName: "Liam Rodriguez",
                    assignedTo: "Robert King",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "liam.rodriguez@email.com",
                    cellNumber: "555-234-5432",
                    homeNumber: "-",
                    workNumber: "555-765-4321",
                    vehicle: "2023 Honda CR-V",
                    leadType: "Warm",
                    dealType: "Lease",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "No Longer Owns"
                }
            ]
        },
        {
            reason: 'Other Salesperson Lead',
            count: 5,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 24, 2025 11:30 AM",
                    lostDateTime: "Oct 27, 2025 2:00 PM",
                    customerName: "Ava Hernandez",
                    assignedTo: "David Wilson",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "ava.hernandez@email.com",
                    cellNumber: "555-345-4321",
                    homeNumber: "555-654-3210",
                    workNumber: "-",
                    vehicle: "2022 Hyundai Santa Fe",
                    leadType: "Cold",
                    dealType: "Cash",
                    source: "Referral",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Other Salesperson Lead"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 23, 2025 3:50 PM",
                    lostDateTime: "Oct 26, 2025 11:45 AM",
                    customerName: "Lucas Lopez",
                    assignedTo: "Lisa Brown",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "lucas.lopez@email.com",
                    cellNumber: "555-456-3210",
                    homeNumber: "-",
                    workNumber: "555-543-2109",
                    vehicle: "2024 Nissan Rogue",
                    leadType: "Hot",
                    dealType: "Finance",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Other Salesperson Lead"
                }
            ]
        },
        {
            reason: 'Out of Market',
            count: 4,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 22, 2025 10:05 AM",
                    lostDateTime: "Oct 25, 2025 1:30 PM",
                    customerName: "Mia Gonzalez",
                    assignedTo: "Kevin Davis",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "mia.gonzalez@email.com",
                    cellNumber: "555-567-2109",
                    homeNumber: "555-432-1098",
                    workNumber: "-",
                    vehicle: "2023 Chevrolet Malibu",
                    leadType: "Warm",
                    dealType: "Finance",
                    source: "Google Ads",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Out of Market"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 21, 2025 1:40 PM",
                    lostDateTime: "Oct 24, 2025 3:15 PM",
                    customerName: "Ethan Perez",
                    assignedTo: "Emily White",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "ethan.perez@email.com",
                    cellNumber: "555-678-1098",
                    homeNumber: "-",
                    workNumber: "555-321-0987",
                    vehicle: "2022 Toyota Highlander",
                    leadType: "Cold",
                    dealType: "Lease",
                    source: "Website",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Out of Market"
                }
            ]
        },
        {
            reason: 'Requested No More Contact',
            count: 3,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 20, 2025 9:15 AM",
                    lostDateTime: "Oct 23, 2025 10:45 AM",
                    customerName: "Isabella Torres",
                    assignedTo: "Maria Garcia",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "isabella.torres@email.com",
                    cellNumber: "555-789-0987",
                    homeNumber: "555-210-9876",
                    workNumber: "-",
                    vehicle: "2024 Ford Bronco",
                    leadType: "Hot",
                    dealType: "Cash",
                    source: "Walk-in",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Requested No More Contact"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 19, 2025 2:55 PM",
                    lostDateTime: "Oct 22, 2025 4:30 PM",
                    customerName: "Mason Flores",
                    assignedTo: "Robert King",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "mason.flores@email.com",
                    cellNumber: "555-890-9876",
                    homeNumber: "-",
                    workNumber: "555-098-7654",
                    vehicle: "2023 Jeep Wrangler",
                    leadType: "Warm",
                    dealType: "Finance",
                    source: "Facebook",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Requested No More Contact"
                }
            ]
        },
        {
            reason: 'Service Lead',
            count: 2,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 18, 2025 10:50 AM",
                    lostDateTime: "Oct 21, 2025 11:30 AM",
                    customerName: "Charlotte Rivera",
                    assignedTo: "David Wilson",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "charlotte.rivera@email.com",
                    cellNumber: "555-901-8765",
                    homeNumber: "555-109-7654",
                    workNumber: "-",
                    vehicle: "2022 Honda Pilot",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Service",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Service Lead"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 17, 2025 3:20 PM",
                    lostDateTime: "Oct 20, 2025 2:15 PM",
                    customerName: "Benjamin Cruz",
                    assignedTo: "Lisa Brown",
                    assignedBy: "Manager",
                    createdBy: "System",
                    email: "benjamin.cruz@email.com",
                    cellNumber: "555-012-7654",
                    homeNumber: "-",
                    workNumber: "555-876-5432",
                    vehicle: "2024 Subaru Forester",
                    leadType: "Hot",
                    dealType: "Lease",
                    source: "Service",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Service Lead"
                }
            ]
        },
        {
            reason: 'Sold Privately',
            count: 1,
            leads: [{
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 16, 2025 11:10 AM",
                    lostDateTime: "Oct 19, 2025 3:45 PM",
                    customerName: "Amelia Gomez",
                    assignedTo: "Kevin Davis",
                    assignedBy: "Admin",
                    createdBy: "CRM",
                    email: "amelia.gomez@email.com",
                    cellNumber: "555-123-4321",
                    homeNumber: "555-987-1098",
                    workNumber: "-",
                    vehicle: "2023 Mazda CX-30",
                    leadType: "Warm",
                    dealType: "Cash",
                    source: "Website",
                    inventoryType: "New",
                    salesType: "Retail",
                    lostSubReason: "Sold Privately"
                },
                {
                    leadStatus: "Lost",
                    salesStatus: "Closed",
                    createdDate: "Oct 15, 2025 2:00 PM",
                    lostDateTime: "Oct 18, 2025 10:00 AM",
                    customerName: "Henry Reyes",
                    assignedTo: "Emily White",
                    assignedBy: "Sales Manager",
                    createdBy: "Auto",
                    email: "henry.reyes@email.com",
                    cellNumber: "555-234-3210",
                    homeNumber: "-",
                    workNumber: "555-765-4321",
                    vehicle: "2022 Toyota Tacoma",
                    leadType: "Cold",
                    dealType: "Finance",
                    source: "Walk-in",
                    inventoryType: "Used",
                    salesType: "Retail",
                    lostSubReason: "Sold Privately"
                }
            ]
        }
    ];

    // Populate modal with ALL reasons from your list
    function populateLostListModal() {
        const list = document.getElementById('lostReasonList');
        list.innerHTML = '';

        // Sort by count (highest first)
        const allReasons = [...lostReasons].sort((a, b) => b.count - a.count);

        allReasons.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center cursor-pointer';
            li.style.cursor = 'pointer';
            li.innerHTML = `
            ${item.reason}
            <span class="badge bg-danger rounded-pill">${item.count}</span>
          `;
            li.addEventListener('click', () => {
                // Close the current modal first
                const modal = bootstrap.Modal.getInstance(document.getElementById('lostListModal'));
                if (modal) modal.hide();

                // Show detail modal after a short delay
                setTimeout(() => showLostReasonDetail(item.reason), 300);
            });
            list.appendChild(li);
        });
    }

    // Populate widget with TOP 5 reasons
    function populateLostWidgetList() {
        const widgetList = document.getElementById('lostReasonWidgetList');
        if (widgetList) {
            widgetList.innerHTML = '';
            const topFive = [...lostReasons].sort((a, b) => b.count - a.count).slice(0, 5);
            topFive.forEach(item => {
                const li = document.createElement('li');
                li.className =
                    'list-group-item d-flex justify-content-between align-items-center cursor-pointer';
                li.style.cursor = 'pointer';
                li.innerHTML = `
              ${item.reason}
              <span class="badge bg-danger rounded-pill">${item.count}</span>
            `;
                li.addEventListener('click', () => {
                    showLostReasonDetail(item.reason);
                });
                widgetList.appendChild(li);
            });
        }
    }

    // Show lost reason detail modal
    function showLostReasonDetail(reasonName) {
        const reason = lostReasons.find(r => r.reason === reasonName);
        if (!reason) return;

        // Update modal title and info


        // Populate the table
        const tableBody = document.getElementById('lostReasonDetailTable');
        tableBody.innerHTML = '';

        reason.leads.forEach((lead, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td class="text-primary text-decoration-underline cursor-pointer" 
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${lead.customerName}</td>
        <td>${lead.assignedTo}</td>
        <td>${lead.assignedBy}</td>
        <td>${lead.createdBy}</td>
        <td>${lead.email}</td>
        <td>${formatPhoneNumber(lead.cellNumber)}</td>
        <td>${formatPhoneNumber(lead.homeNumber)}</td>
        <td>${formatPhoneNumber(lead.workNumber)}</td>
        <td class="text-primary text-decoration-underline cursor-pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${lead.vehicle}</td>
        <td>${lead.leadType}</td>
        <td>${lead.dealType}</td>
        <td>${lead.source}</td>
        <td>${lead.inventoryType}</td>
        <td>${lead.salesType}</td>
        <td>${lead.lostSubReason}</td>
        <td>${lead.leadStatus}</td>
        <td>${lead.salesStatus}</td>
        <td>${lead.createdDate}</td>
        <td>${lead.lostDateTime}</td>
      `;
            tableBody.appendChild(row);
        });

        // Show the moda
        const modal = new bootstrap.Modal(document.getElementById('lostReasonDetailModal'));
        modal.show();
    }

    // Helper function for phone number formatting
    function formatPhoneNumber(phone) {
        if (!phone || phone === '-' || phone.trim() === '') return '-';
        return phone;
    }

    // Helper function for lead type badge styling
    function getLeadTypeBadgeClass(leadType) {
        switch (leadType.toLowerCase()) {
            case 'hot':
                return 'bg-danger';
            case 'warm':
                return 'bg-warning text-dark';
            case 'cold':
                return 'bg-info';
            default:
                return 'bg-secondary';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        populateLostListModal();
        if (typeof populateLostWidgetList === 'function') {
            populateLostWidgetList();
        }
    });
</script>



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




@endsection
@push('scripts')
{{-- custom date select logic --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        function formatDisplayDate(dateStr) {
            let day, month, year;

            // yyyy-mm-dd
            if (dateStr.includes("-")) {
                const parts = dateStr.split("-");
                if (parts.length === 3) {
                    year = parts[0];
                    month = parseInt(parts[1], 10) - 1;
                    day = parts[2];
                }
            }
            // dd/mm/yyyy
            else if (dateStr.includes("/")) {
                const parts = dateStr.split("/");
                if (parts.length === 3) {
                    day = parts[0];
                    month = parseInt(parts[1], 10) - 1;
                    year = parts[2];
                }
            }

            if (!day || !year || month < 0) return dateStr;

            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            return `${months[month]} ${day}, ${year}`;
        }

        const container = document.getElementById("customDateContainer");
        let currentSelect = null;

        document.querySelectorAll(".widgetdateFilter").forEach(select => {
            select.addEventListener("change", function() {

                if (this.value === "custom") {
                    currentSelect = this;
                    container.classList.remove("d-none");

                    const rect = this.getBoundingClientRect();
                    container.style.top = rect.bottom + window.scrollY + "px";
                    container.style.left = rect.left + window.scrollX + "px";

                    container.querySelector(".custom-from").value = "";
                    container.querySelector(".custom-to").value = "";

                } else {
                    container.classList.add("d-none");
                }
            });
        });

        // Close container when clicking outside
        document.addEventListener("click", function(event) {
            const clickedInsideContainer = container.contains(event.target);
            const clickedSelect = currentSelect && currentSelect.contains(event.target);

            if (!clickedInsideContainer && !clickedSelect) {
                container.classList.add("d-none");
                currentSelect = null;
            }
        });


        container.querySelector(".applyCustomDate").addEventListener("click", function() {

            const fromRaw = container.querySelector(".custom-from").value;
            const toRaw = container.querySelector(".custom-to").value;

            if (!fromRaw || !toRaw) {
                alert("Please select both From and To dates.");
                return;
            }

            const from = formatDisplayDate(fromRaw);
            const to = formatDisplayDate(toRaw);

            if (currentSelect) {
                currentSelect.value = "custom";
                currentSelect.options[currentSelect.selectedIndex].text =
                    `Custom: ${from} to ${to}`;
            }

            console.log("Custom Range Applied:", fromRaw, toRaw);
            container.classList.add("d-none");
        });

    });
</script>

{{-- table scrolling optimize logic --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scrollAmount = 100; // pixels to scroll per key press

        // Select all table-responsive containers
        document.querySelectorAll('.table-responsive').forEach(tableContainer => {
            // Make the container focusable
            tableContainer.setAttribute("tabindex", "0");
            tableContainer.style.outline = "none"; // optional: remove focus outline

            // Listen for arrow key presses
            tableContainer.addEventListener("keydown", function(e) {
                switch (e.key) {
                    case "ArrowLeft":
                        tableContainer.scrollBy({
                            left: -scrollAmount,
                            behavior: "smooth"
                        });
                        e.preventDefault();
                        break;
                    case "ArrowRight":
                        tableContainer.scrollBy({
                            left: scrollAmount,
                            behavior: "smooth"
                        });
                        e.preventDefault();
                        break;
                }
            });
        });
    });
</script>

{{-- Dashboard Date Script --}}
<script>
    // Function to format and display current date
    function updateCurrentDate() {
        const now = new Date();
        const options = {
            weekday: 'short',
            month: 'long',
            day: 'numeric'
        };
        const formattedDate = now.toLocaleDateString('en-US', options);
        document.getElementById('currentDate').textContent = formattedDate;
    }

    // Call the function when the page loads
    updateCurrentDate();
</script>


{{-- Dashboard Tabs Script --}}


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryButtons = document.querySelectorAll(".category-btn");
        const allWidgetAreas = document.querySelectorAll(".widgets-area");

        // Initially hide all widget areas
        allWidgetAreas.forEach((area) => (area.style.display = "none"));
        document.querySelector('.category-lead').style.display = 'flex';
        document.querySelector('.category-btn[data-category="lead"]').classList.add('active');
        categoryButtons.forEach((btn) => {
            btn.addEventListener("click", function() {
                const category = this.dataset.category;

                // Remove active from all buttons
                categoryButtons.forEach((b) => b.classList.remove("active"));
                this.classList.add("active");

                // Hide all widgets
                allWidgetAreas.forEach((area) => (area.style.display = "none"));

                // Show selected category widgets
                const selected = document.querySelector(".category-" + category);
                if (selected) {
                    selected.style.display =
                        "flex"; // or "block" depending on your layout needs
                }
            });
        });

        // Optional: Trigger click on first category button to show initial content
        // categoryButtons[0].click();
    });
</script>



{{-- Tooltip Initialize --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>


{{-- Widgets Color Optimize Script --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const borderPicker = document.getElementById("borderColorPicker");
        const bgPicker = document.getElementById("bgColorPicker");
        const widgets = document.querySelectorAll(".widget-card .card");

        const saveBtn = document.getElementById("saveColorsBtn");
        const resetBtn = document.getElementById("resetColorsBtn");
        const root = document.documentElement;

        const cssVar = (name) =>
            getComputedStyle(root).getPropertyValue(name).trim();

        // Load saved overrides
        const savedBorder = localStorage.getItem("widgetBorderColor");
        const savedBg = localStorage.getItem("widgetBgColor");

        /* ---------------- INITIAL STATE ---------------- */

        // Apply inline styles ONLY if user saved colors
        if (savedBorder || savedBg) {
            applyColors(savedBorder, savedBg);
        }

        syncPickers();

        /* ---------------- EVENTS ---------------- */

        borderPicker.addEventListener("input", () =>
            applyColors(borderPicker.value, bgPicker.value)
        );

        bgPicker.addEventListener("input", () =>
            applyColors(borderPicker.value, bgPicker.value)
        );

        saveBtn.addEventListener("click", () => {
            localStorage.setItem("widgetBorderColor", borderPicker.value);
            localStorage.setItem("widgetBgColor", bgPicker.value);
        });

        resetBtn.addEventListener("click", () => {
            localStorage.removeItem("widgetBorderColor");
            localStorage.removeItem("widgetBgColor");

            widgets.forEach(card => {
                card.style.removeProperty("border");
                card.style.removeProperty("background-color");
            });

            syncPickers();
        });

        /* ---------------- THEME CHANGE HANDLING ---------------- */

        new MutationObserver(() => {
            // If user has NOT overridden colors, restore CSS control
            if (!localStorage.getItem("widgetBorderColor") &&
                !localStorage.getItem("widgetBgColor")) {

                widgets.forEach(card => {
                    card.style.removeProperty("border");
                    card.style.removeProperty("background-color");
                });
            }

            syncPickers();
        }).observe(root, {
            attributes: true,
            attributeFilter: ["data-bs-theme"]
        });

        /* ---------------- HELPERS ---------------- */

        function applyColors(border, bg) {
            widgets.forEach(card => {
                if (border) card.style.border = `2px solid ${border}`;
                if (bg) card.style.backgroundColor = bg;
            });
        }

        function syncPickers() {
            const savedBorder = localStorage.getItem("widgetBorderColor");
            const savedBg = localStorage.getItem("widgetBgColor");

            // BORDER PICKER
            borderPicker.value = savedBorder ?
                savedBorder :
                normalizeHex(cssVar("--widget-border") || "#000000");

            // BG PICKER
            const bg = savedBg || cssVar("--widget-bg");
            bgPicker.value = normalizeHex(
                bg === "transparent" ? "#ffffff" : bg || "#ffffff"
            );
        }

        function normalizeHex(color) {
            if (!color) return "#ffffff";
            if (color === "transparent") return "#ffffff";

            if (/^#([0-9a-f]{3})$/i.test(color)) {
                return "#" + color.slice(1).split("").map(c => c + c).join("");
            }
            return color;
        }
    });
</script>



{{-- Widget Favourites Logic  --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const favContainer = document.getElementById('favorites-container');
        let favoriteWidgets = JSON.parse(localStorage.getItem('favoriteWidgets')) || {};

        // Toggle favorite status
        function toggleFavorite(widgetId, starEl) {
            if (favoriteWidgets[widgetId]) {
                // Remove from favorites
                delete favoriteWidgets[widgetId];
                starEl.className = "ti ti-star star-toggle";
                const favCard = favContainer.querySelector(`[data-widget-id="${widgetId}"]`);
                if (favCard) favCard.remove();
            } else {
                // Add to favorites
                favoriteWidgets[widgetId] = true;
                starEl.className = "ti ti-star-filled star-toggle";
                const original = document.querySelector(`.widget-card[data-widget-id="${widgetId}"]`);
                if (original && !favContainer.querySelector(`[data-widget-id="${widgetId}"]`)) {
                    const clone = original.cloneNode(true);
                    const cloneStar = clone.querySelector('.star-toggle');
                    if (cloneStar) cloneStar.className = "ti ti-star-filled star-toggle";
                    attachStarHandler(cloneStar);
                    favContainer.appendChild(clone);
                }
            }
            // Save state
            localStorage.setItem('favoriteWidgets', JSON.stringify(favoriteWidgets));
        }

        // Attach click handler to star icons
        function attachStarHandler(starEl) {
            if (!starEl || starEl.__favBound) return;
            starEl.__favBound = true;
            starEl.addEventListener('click', e => {
                e.stopPropagation();
                const card = starEl.closest('.widget-card');
                if (!card) return;
                const id = card.getAttribute('data-widget-id');
                toggleFavorite(id, starEl);
            });
        }

        // Initial binding
        document.querySelectorAll('.star-toggle').forEach(attachStarHandler);

        // Initialize favorites from localStorage
        Object.keys(favoriteWidgets).forEach(widgetId => {
            const starEl = document.querySelector(`[data-widget-id="${widgetId}"] .star-toggle`);
            if (starEl) starEl.className = "ti ti-star-filled star-toggle";
            const original = document.querySelector(`.widget-card[data-widget-id="${widgetId}"]`);
            if (original && !favContainer.querySelector(`[data-widget-id="${widgetId}"]`)) {
                const clone = original.cloneNode(true);
                const cloneStar = clone.querySelector('.star-toggle');
                if (cloneStar) cloneStar.className = "ti ti-star-filled star-toggle";
                attachStarHandler(cloneStar);
                favContainer.appendChild(clone);
            }
        });

        console.log("[STAR] Favourites system ready.");
    });
</script>

<script src="{{ asset('assets/js/index.js') }}"></script>
@endpush
