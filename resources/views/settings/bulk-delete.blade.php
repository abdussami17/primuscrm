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