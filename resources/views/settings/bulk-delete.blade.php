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
                                                            <select class="form-select" id="leadAssignedManagerFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="leadAssignedToFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="leadSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="leadBDCAgentFilter">
                                                                <option value="">All Users</option>
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
                                                                <tr><td colspan="13" class="text-center">Loading data...</td></tr>
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
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select" id="undeleteLeadAssignedManagerFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadAssignedToFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select"
                                                                id="undeleteLeadBDCAgentFilter">
                                                                <option value="">All Users</option>
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
                                                                <tr><td colspan="14" class="text-center">Loading data...</td></tr>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load filters
    loadFilters();
    loadDeletionHistory();
    
    // Load initial data
    loadCustomers();
    loadDeletedCustomers();
    
    // Setup table selections
    setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo', 'deleteLeadsBtn');
    setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads', 'deletedLeadsSelectionInfo', 'undeleteLeadsBtn');
    
    // Filter change listeners - Active Customers
    const activeFilters = document.querySelectorAll('#leads-delete select, #leads-delete input.cf-datepicker');
    activeFilters.forEach(filter => {
        filter.addEventListener('change', loadCustomers);
    });
    
    // Filter change listeners - Deleted Customers
    const deletedFilters = document.querySelectorAll('#leads-undelete select, #leads-undelete input.cf-datepicker');
    deletedFilters.forEach(filter => {
        filter.addEventListener('change', loadDeletedCustomers);
    });
    
    // Refresh buttons
    document.getElementById('refreshLeadsBtn').addEventListener('click', loadCustomers);
    document.getElementById('refreshDeletedLeadsBtn').addEventListener('click', loadDeletedCustomers);
    
    // Delete button
    document.getElementById('deleteLeadsBtn').addEventListener('click', handleDelete);
    
    // Restore button
    document.getElementById('undeleteLeadsBtn').addEventListener('click', handleRestore);
});

// Load filter options
async function loadFilters() {
    try {
        const res = await fetch('/settings/bulk-delete/filters', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load filters');
        const data = await res.json();
        
        // Populate user dropdowns (both tabs)
        populateUserDropdowns(data.users);
        
        // Populate other filter dropdowns
        populateSelect('sourcesFilter', data.sources);
        populateSelect('undeleteSourcesFilter', data.sources);
        populateSelect('leadStatusFilter', data.statuses);
        populateSelect('undeleteLeadStatusFilter', data.statuses);
        populateSelect('inventoryTypeFilter', data.inventory_types);
        populateSelect('undeleteInventoryTypeFilter', data.inventory_types);
        populateSelect('dealTypeFilter', data.deal_types);
        populateSelect('undeleteDealTypeFilter', data.deal_types);
        populateSelect('leadTypeFilter', data.lead_types);
        populateSelect('undeleteLeadTypeFilter', data.lead_types);
        
    } catch (err) {
        console.error('Error loading filters:', err);
    }
}

// Load deletion history
async function loadDeletionHistory() {
    try {
        const res = await fetch('/settings/bulk-delete/deletion-history', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load deletion history');
        const history = await res.json();
        
        const select = document.getElementById('leadUndoHistory');
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
        }
        
    } catch (err) {
        console.error('Error loading deletion history:', err);
    }
}

function populateUserDropdowns(users) {
    const userSelects = [
        'leadAssignedManagerFilter',
        'leadAssignedToFilter',
        'leadSecondaryAssignedFilter',
        'leadBDCAgentFilter',
        'undeleteLeadAssignedManagerFilter',
        'undeleteLeadAssignedToFilter',
        'undeleteLeadSecondaryAssignedFilter',
        'undeleteLeadBDCAgentFilter'
    ];
    
    userSelects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (select) {
            // Clear existing options except first
            while (select.options.length > 1) {
                select.remove(1);
            }
            // Add user options
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name;
                select.appendChild(option);
            });
        }
    });
}

function populateSelect(selectId, items) {
    const select = document.getElementById(selectId);
    if (!select) return;
    
    // Clear existing options except first
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // Add items
    items.forEach(item => {
        if (item) {
            const option = document.createElement('option');
            option.value = item;
            option.textContent = item;
            select.appendChild(option);
        }
    });
}

// Load active customers
async function loadCustomers() {
    const filters = {
        assigned_manager: document.getElementById('leadAssignedManagerFilter')?.value || '',
        assigned_to: document.getElementById('leadAssignedToFilter')?.value || '',
        secondary_assigned: document.getElementById('leadSecondaryAssignedFilter')?.value || '',
        bdc_agent: document.getElementById('leadBDCAgentFilter')?.value || '',
        lead_source: document.getElementById('sourcesFilter')?.value || '',
        status: document.getElementById('leadStatusFilter')?.value || '',
        inventory_type: document.getElementById('inventoryTypeFilter')?.value || '',
        deal_type: document.getElementById('dealTypeFilter')?.value || '',
        lead_type: document.getElementById('leadTypeFilter')?.value || '',
        start_date: document.getElementById('startLeadCreatedDate')?.value || '',
        end_date: document.getElementById('endLeadCreatedDate')?.value || ''
    };
    
    const params = new URLSearchParams(filters);
    
    try {
        const res = await fetch('/settings/bulk-delete/customers?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load customers');
        const data = await res.json();
        
        renderCustomersTable(data.items);
        document.getElementById('leadsCount').textContent = `Showing ${data.count} leads`;
        setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo', 'deleteLeadsBtn');
    } catch (err) {
        console.error('Error loading customers:', err);
        document.getElementById('leadsTableBody').innerHTML = '<tr><td colspan="13" class="text-center text-danger">Error loading data</td></tr>';
    }
}

// Load deleted customers
async function loadDeletedCustomers() {
    const filters = {
        deletion_date: document.getElementById('leadUndoHistory')?.value || '',
        assigned_manager: document.getElementById('undeleteLeadAssignedManagerFilter')?.value || '',
        assigned_to: document.getElementById('undeleteLeadAssignedToFilter')?.value || '',
        secondary_assigned: document.getElementById('undeleteLeadSecondaryAssignedFilter')?.value || '',
        bdc_agent: document.getElementById('undeleteLeadBDCAgentFilter')?.value || '',
        lead_source: document.getElementById('undeleteSourcesFilter')?.value || '',
        status: document.getElementById('undeleteLeadStatusFilter')?.value || '',
        inventory_type: document.getElementById('undeleteInventoryTypeFilter')?.value || '',
        deal_type: document.getElementById('undeleteDealTypeFilter')?.value || '',
        lead_type: document.getElementById('undeleteLeadTypeFilter')?.value || '',
        start_date: document.getElementById('undeleteStartLeadCreatedDate')?.value || '',
        end_date: document.getElementById('undeleteEndLeadCreatedDate')?.value || ''
    };
    
    const params = new URLSearchParams(filters);
    
    try {
        const res = await fetch('/settings/bulk-delete/deleted-customers?' + params.toString(), {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Failed to load deleted customers');
        const data = await res.json();
        
        renderDeletedCustomersTable(data.items);
        document.getElementById('deletedLeadsCount').textContent = `Showing ${data.count} deleted leads`;
        setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads', 'deletedLeadsSelectionInfo', 'undeleteLeadsBtn');
    } catch (err) {
        console.error('Error loading deleted customers:', err);
        document.getElementById('deletedLeadsTableBody').innerHTML = '<tr><td colspan="14" class="text-center text-danger">Error loading data</td></tr>';
    }
}

// Render customers table
function renderCustomersTable(items) {
    const tbody = document.getElementById('leadsTableBody');
    tbody.innerHTML = '';
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="13" class="text-center">No leads found</td></tr>';
        return;
    }
    
    items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${item.id}"></td>
            <td>${item.customer_name}</td>
            <td>${item.sales_type}</td>
            <td>${item.lead_type}</td>
            <td>${item.lead_status}</td>
            <td>${item.inventory_type}</td>
            <td>${item.sales_status}</td>
            <td>${item.created_date}</td>
            <td>${item.source}</td>
            <td>${item.deal_type}</td>
            <td>${item.assigned_to}</td>
            <td>${item.secondary_assigned}</td>
            <td>${item.bdc_agent}</td>
        `;
        tbody.appendChild(tr);
    });
}

// Render deleted customers table
function renderDeletedCustomersTable(items) {
    const tbody = document.getElementById('deletedLeadsTableBody');
    tbody.innerHTML = '';
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="14" class="text-center">No deleted leads found</td></tr>';
        return;
    }
    
    items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${item.id}"></td>
            <td>${item.customer_name}</td>
            <td>${item.sales_type}</td>
            <td>${item.lead_type}</td>
            <td>${item.lead_status}</td>
            <td>${item.inventory_type}</td>
            <td>${item.sales_status}</td>
            <td>${item.created_date}</td>
            <td>${item.source}</td>
            <td>${item.deal_type}</td>
            <td>${item.assigned_to}</td>
            <td>${item.secondary_assigned}</td>
            <td>${item.bdc_agent}</td>
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
        info.textContent = `${count} leads selected`;
        btn.disabled = count === 0;
    }
    
    // Initial update
    updateSelection();
}

// Handle delete
async function handleDelete() {
    const checkedBoxes = document.querySelectorAll('#leadsTableBody .row-checkbox:checked');
    const customerIds = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-id'));
    
    if (customerIds.length === 0) {
        alert('Please select at least one customer to delete');
        return;
    }
    
    if (!confirm(`Are you sure you want to delete ${customerIds.length} customer(s)? This action can be undone from the Undelete tab.`)) {
        return;
    }
    
    try {
        const res = await fetch('/settings/bulk-delete/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify({ customer_ids: customerIds })
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert(data.message);
            loadCustomers();
            loadDeletedCustomers();
            loadDeletionHistory();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (err) {
        console.error('Error deleting customers:', err);
        alert('Failed to delete customers. Please try again.');
    }
}

// Handle restore
async function handleRestore() {
    const checkedBoxes = document.querySelectorAll('#deletedLeadsTableBody .row-checkbox:checked');
    const customerIds = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-id'));
    
    if (customerIds.length === 0) {
        alert('Please select at least one customer to restore');
        return;
    }
    
    if (!confirm(`Are you sure you want to restore ${customerIds.length} customer(s)?`)) {
        return;
    }
    
    try {
        const res = await fetch('/settings/bulk-delete/restore', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin',
            body: JSON.stringify({ customer_ids: customerIds })
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert(data.message);
            loadCustomers();
            loadDeletedCustomers();
            loadDeletionHistory();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (err) {
        console.error('Error restoring customers:', err);
        alert('Failed to restore customers. Please try again.');
    }
}
</script>