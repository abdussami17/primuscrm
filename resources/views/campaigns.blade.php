@extends('layouts.app')


@section('title','Campaigns')


@section('content')

<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Campaigns</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

      <!-- Right: Buttons -->
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
        <!-- Trigger Button -->
        <button class="btn btn-light border border-1">
          <i class="isax isax-printer me-1"></i>
          Print
        </button>
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

        <!-- <div>
          <a href="create-campaign.html" class="btn btn-primary d-flex align-items-center">
            <i class="isax isax-add-circle me-2"></i>Create Campaign
          </a>
        </div> -->
      </div>
    </div>

    <!-- End Page Header -->
    <div class="mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <div class="table-search d-flex align-items-center mb-0">
            <div class="search-input">
              <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

  
  <div class="table-responsive">
    <table class="table table-nowrap datatable">
        <thead class="thead-light">
            <tr>
                <th class="no-sort">
                    <div class="form-check form-check-md">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th>Campaign Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Tracking</th>
                <th>Created By</th>
                <th>Created On</th>
                <th>Sent</th>
                <th>Bounced</th>
                <th>Appointments</th>
                <th>Unsubscribed</th>
                <th>Delivered</th>
                <th>Opened</th>
                <th>Clicked</th>
                <th>Replied</th>
            </tr>
        </thead>
        <tbody id="campaignsTableBody">
            @if(isset($campaigns) && $campaigns->count())
                @foreach($campaigns as $c)
                    <tr>
                        <td>
                            <div class="form-check form-check-md"><input class="form-check-input" type="checkbox" data-id="{{ $c->id }}"></div>
                        </td>
                        <td>{{ e($c->name ?? $c->title ?? '') }}</td>
                        <td>{{ e($c->type ?? 'Email') }}</td>
                        <td><span class="badge bg-light text-muted border border-1" title="{{ e($c->status ?? '') }}">{{ e($c->status ?? 'N/A') }}</span></td>
                        <td>{{ e($c->tracking ?? '') }}</td>
                        <td>{{ e($c->created_by_name ?? $c->created_by ?? '') }}</td>
                        <td>{{ $c->created_at ? $c->created_at->toDateTimeString() : '' }}</td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="sent">{{ data_get($c, 'metrics.sent', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="bounced">{{ data_get($c, 'metrics.bounced', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="appointments">{{ data_get($c, 'metrics.appointments', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="unsubscribed">{{ data_get($c, 'metrics.unsubscribed', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="delivered">{{ data_get($c, 'metrics.delivered', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="opened">{{ data_get($c, 'metrics.opened', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="clicked">{{ data_get($c, 'metrics.clicked', 0) }}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="{{ $c->id }}" data-status="replied">{{ data_get($c, 'metrics.replied', 0) }}</a></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="15" class="text-center py-4 text-muted">No campaigns found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Customer List Modal -->
<div class="modal fade" id="customerListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customers - <span id="modalStatus"></span> (<span id="rowCount">0</span> rows)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
                <div class="table-responsive table-nowrap">
                    <table class="table border" id="customerTable">
                        <thead class="table-light">
                            <tr>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Email Address</th>
                                <th>Cell Number</th>
                                <th>Home Number</th>
                                <th>Work Number</th>
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
                                <th id="dynamicDateColumn"></th>
                            </tr>
                        </thead>
                        <tbody id="customerList">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample customer data with all requested columns
        const allCustomers = [
            {
                id: 1,
                firstName: "John",
                lastName: "Miller",
                assignedTo: "Mike Johnson",
                assignedBy: "Sarah Wilson",
                email: "john.m@email.com",
                cellNumber: "555-1234",
                homeNumber: "555-0001",
                workNumber: "555-1001",
                yearMakeModel: "2023 Toyota Camry",
                leadType: "New Lead",
                dealType: "Retail",
                createdLeadDateTime: "Jan 15, 2024 10:30 AM",
                leadStatus: "Active",
                salesStatus: "Prospect",
                source: "Website",
                inventoryType: "New",
                salesType: "Direct",
                createdBy: "System",
                sentDate: "Jan 30, 2024 2:15 PM",
                bouncedDate: "",
                appointmentsDate: "Feb 1, 2024 11:00 AM",
                unsubscribedDate: "",
                deliveredDate: "Jan 30, 2024 2:16 PM",
                openedDate: "Jan 30, 2024 3:45 PM",
                clickedDate: "Jan 30, 2024 4:20 PM",
                repliedDate: "Jan 31, 2024 9:15 AM"
            },
            {
                id: 2,
                firstName: "Emily",
                lastName: "Roberts",
                assignedTo: "David Chen",
                assignedBy: "Admin",
                email: "emily.r@email.com",
                cellNumber: "555-2345",
                homeNumber: "555-0002",
                workNumber: "555-1002",
                yearMakeModel: "2022 Honda Civic",
                leadType: "Follow-up",
                dealType: "Lease",
                createdLeadDateTime: "Jan 20, 2024 3:45 PM",
                leadStatus: "Hot",
                salesStatus: "Negotiation",
                source: "Referral",
                inventoryType: "Used",
                salesType: "Internet",
                createdBy: "Alex Smith",
                sentDate: "Jan 31, 2024 10:00 AM",
                bouncedDate: "",
                appointmentsDate: "Feb 2, 2024 2:00 PM",
                unsubscribedDate: "",
                deliveredDate: "Jan 31, 2024 10:01 AM",
                openedDate: "Jan 31, 2024 11:30 AM",
                clickedDate: "Jan 31, 2024 12:15 PM",
                repliedDate: "Feb 1, 2024 10:45 AM"
            },
            {
                id: 3,
                firstName: "David",
                lastName: "Chen",
                assignedTo: "Lisa Thompson",
                assignedBy: "Mike Johnson",
                email: "david.c@email.com",
                cellNumber: "555-3456",
                homeNumber: "555-0003",
                workNumber: "555-1003",
                yearMakeModel: "2024 Ford F-150",
                leadType: "Service",
                dealType: "Finance",
                createdLeadDateTime: "Jan 25, 2024 9:15 AM",
                leadStatus: "Warm",
                salesStatus: "Pending",
                source: "Walk-in",
                inventoryType: "New",
                salesType: "Direct",
                createdBy: "System",
                sentDate: "Feb 1, 2024 1:30 PM",
                bouncedDate: "Feb 1, 2024 1:31 PM",
                appointmentsDate: "",
                unsubscribedDate: "",
                deliveredDate: "",
                openedDate: "",
                clickedDate: "",
                repliedDate: ""
            },
            {
                id: 4,
                firstName: "Maria",
                lastName: "Garcia",
                assignedTo: "James Anderson",
                assignedBy: "Admin",
                email: "maria.g@email.com",
                cellNumber: "555-4567",
                homeNumber: "555-0004",
                workNumber: "555-1004",
                yearMakeModel: "2021 BMW X5",
                leadType: "New Lead",
                dealType: "Cash",
                createdLeadDateTime: "Jan 28, 2024 4:20 PM",
                leadStatus: "Active",
                salesStatus: "Closed",
                source: "Phone",
                inventoryType: "Certified",
                salesType: "Internet",
                createdBy: "Sarah Wilson",
                sentDate: "Feb 2, 2024 9:00 AM",
                bouncedDate: "",
                appointmentsDate: "Feb 3, 2024 3:30 PM",
                unsubscribedDate: "Feb 2, 2024 10:00 AM",
                deliveredDate: "Feb 2, 2024 9:01 AM",
                openedDate: "Feb 2, 2024 10:15 AM",
                clickedDate: "Feb 2, 2024 11:00 AM",
                repliedDate: "Feb 2, 2024 2:30 PM"
            }
        ];

        // Initialize modal
        const customerListModalElement = document.getElementById('customerListModal');
        const customerListModal = new bootstrap.Modal(customerListModalElement);

        // Fix backdrop issue
        customerListModalElement.addEventListener('hidden.bs.modal', function() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => {
                backdrop.remove();
            });
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });

        // Helper: escape HTML for inserted content (available to this scope)
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe).replace(/[&<>"'`]/g, function(m){
                return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;',"`":'&#96;'})[m];
            });
        }

        // Function to update main table counts based on actual data
        function updateTableCounts() {
            // Calculate actual counts from allCustomers data
            const counts = {
                sent: allCustomers.filter(c => c.sentDate).length,
                bounced: allCustomers.filter(c => c.bouncedDate).length,
                appointments: allCustomers.filter(c => c.appointmentsDate).length,
                unsubscribed: allCustomers.filter(c => c.unsubscribedDate).length,
                delivered: allCustomers.filter(c => c.deliveredDate).length,
                opened: allCustomers.filter(c => c.openedDate).length,
                clicked: allCustomers.filter(c => c.clickedDate).length,
                replied: allCustomers.filter(c => c.repliedDate).length
            };

            // Update the clickable links with correct counts
            document.querySelectorAll('.clickable-count').forEach(el => {
                const status = el.getAttribute('data-status');
                const count = counts[status] || 0;
                el.textContent = count;
                
                // Add disabled class if count is 0
                if (count === 0) {
                    el.classList.add('text-muted');
                    el.style.cursor = 'default';
                    el.style.textDecoration = 'none';
                } else {
                    el.classList.remove('text-muted');
                    el.style.cursor = 'pointer';
                    el.style.textDecoration = '';
                }
            });
        }

        // Function to populate modal table
        function populateCustomerTable(status) {
            const customerList = document.getElementById('customerList');
            const dynamicDateColumn = document.getElementById('dynamicDateColumn');
            const modalStatus = document.getElementById('modalStatus');
            const rowCount = document.getElementById('rowCount');

            // Clear previous data
            customerList.innerHTML = '';

            // Set modal title and dynamic column
            modalStatus.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            
            // Set dynamic column header based on status
            const dateColumnMap = {
                'sent': 'Sent Date',
                'bounced': 'Bounced Date',
                'appointments': 'Appointments Date',
                'unsubscribed': 'Unsubscribed Date',
                'delivered': 'Delivered Date',
                'opened': 'Opened Date',
                'clicked': 'Clicked Date',
                'replied': 'Replied Date'
            };
            
            dynamicDateColumn.textContent = dateColumnMap[status] || 'Date';
            
            // If a specific campaign id is stored on the modal trigger, use it. Otherwise fall back to returning all sample customers.
            const campaignId = populateCustomerTable.campaignId || populateCustomerTable.lastCampaignId;

            // Fetch recipients from server if campaignId available
            if (campaignId) {
                fetch(`/api/campaigns/${campaignId}/recipients?status=${encodeURIComponent(status)}`)
                    .then(r => r.ok ? r.json() : Promise.reject(r))
                    .then(json => {
                        const filteredCustomers = Array.isArray(json.data) ? json.data : [];
                        rowCount.textContent = filteredCustomers.length;
                        if (filteredCustomers.length === 0) {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td colspan="18" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-people fs-1"></i>
                                        <p class="mt-2">No data is available</p>
                                    </div>
                                </td>
                            `;
                            customerList.appendChild(row);
                            return;
                        }
                        filteredCustomers.forEach(customer => {
                            const row = document.createElement('tr');
                            let statusDate = customer[status] || customer[`${status}Date`] || '';
                            row.innerHTML = `
                                <td>
                                    <a href="javascript:void(0)" class="customer-name text-decoration-underline fw-bold" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">
                                        ${escapeHtml(customer.name || (customer.first_name ? customer.first_name + ' ' + (customer.last_name||'') : ''))}
                                    </a>
                                </td>
                                <td>${escapeHtml(customer.assigned_to || customer.assignedTo || '')}</td>
                                <td>${escapeHtml(customer.assigned_by || customer.assignedBy || '')}</td>
                                <td><a href="mailto:${escapeHtml(customer.email || '')}" class="text-decoration-none">${escapeHtml(customer.email || '')}</a></td>
                                <td><a href="tel:${escapeHtml(customer.cell_number || customer.cellNumber || '')}">${escapeHtml(customer.cell_number || customer.cellNumber || '')}</a></td>
                                <td><a href="tel:${escapeHtml(customer.home_number || customer.homeNumber || '')}">${escapeHtml(customer.home_number || customer.homeNumber || '')}</a></td>
                                <td><a href="tel:${escapeHtml(customer.work_number || customer.workNumber || '')}">${escapeHtml(customer.work_number || customer.workNumber || '')}</a></td>
                                <td>
                                    <a href="javascript:void(0)" class="vehicle-info text-decoration-underline" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">
                                        ${escapeHtml(customer.vehicle || customer.yearMakeModel || '')}
                                    </a>
                                </td>
                                <td>${escapeHtml(customer.lead_type || customer.leadType || '')}</td>
                                <td>${escapeHtml(customer.deal_type || customer.dealType || '')}</td>
                                <td>${escapeHtml(customer.created_at || customer.createdLeadDateTime || '')}</td>
                                <td>${escapeHtml(customer.lead_status || customer.leadStatus || '')}</td>
                                <td>${escapeHtml(customer.sales_status || customer.salesStatus || '')}</td>
                                <td>${escapeHtml(customer.source || '')}</td>
                                <td>${escapeHtml(customer.inventory_type || customer.inventoryType || '')}</td>
                                <td>${escapeHtml(customer.sales_type || customer.salesType || '')}</td>
                                <td>${escapeHtml(customer.created_by || customer.createdBy || '')}</td>
                                <td>${escapeHtml(statusDate || 'N/A')}</td>
                            `;
                            customerList.appendChild(row);
                        });
                    })
                    .catch(err => {
                        console.error('Failed to load recipients', err);
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td colspan="18" class="text-center py-4">
                                <div class="text-muted">Failed to load data</div>
                            </td>
                        `;
                        customerList.appendChild(row);
                    });
                return;
            }

            // Fallback: use sample data when no campaign id is available
            const filteredCustomers = allCustomers.filter(customer => {
                if (status === 'sent') return customer.sentDate;
                if (status === 'bounced') return customer.bouncedDate;
                if (status === 'appointments') return customer.appointmentsDate;
                if (status === 'unsubscribed') return customer.unsubscribedDate;
                if (status === 'delivered') return customer.deliveredDate;
                if (status === 'opened') return customer.openedDate;
                if (status === 'clicked') return customer.clickedDate;
                if (status === 'replied') return customer.repliedDate;
                return false;
            });

            // Update row count
            rowCount.textContent = filteredCustomers.length;

            // Populate table rows
            filteredCustomers.forEach(customer => {
                const row = document.createElement('tr');
                
                // Get the appropriate date for the clicked status
                let statusDate = '';
                switch(status) {
                    case 'sent': statusDate = customer.sentDate; break;
                    case 'bounced': statusDate = customer.bouncedDate; break;
                    case 'appointments': statusDate = customer.appointmentsDate; break;
                    case 'unsubscribed': statusDate = customer.unsubscribedDate; break;
                    case 'delivered': statusDate = customer.deliveredDate; break;
                    case 'opened': statusDate = customer.openedDate; break;
                    case 'clicked': statusDate = customer.clickedDate; break;
                    case 'replied': statusDate = customer.repliedDate; break;
                }
                
                row.innerHTML = `
                    <td>
                        <a href="javascript:void(0)" 
                           class="customer-name text-decoration-underline fw-bold"
                           data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">
                            ${customer.firstName} ${customer.lastName}
                        </a>
                    </td>
                    <td>${customer.assignedTo}</td>
                    <td>${customer.assignedBy}</td>
                    <td>
                        <a href="mailto:${customer.email}" class="text-decoration-none">${customer.email}</a>
                    </td>
                    <td><a href="tel:${customer.cellNumber}">${customer.cellNumber}</a></td>
                    <td><a href="tel:${customer.homeNumber}">${customer.homeNumber}</a></td>
                    <td><a href="tel:${customer.workNumber}">${customer.workNumber}</a></td>
                    <td>
                        <a href="javascript:void(0)" 
                           class="vehicle-info text-decoration-underline"
                           data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">
                            ${customer.yearMakeModel}
                        </a>
                    </td>
                    <td>${customer.leadType}</td>
                    <td>${customer.dealType}</td>
                    <td>${customer.createdLeadDateTime}</td>
                    <td>${customer.leadStatus}</td>
                    <td>${customer.salesStatus}</td>
                    <td>${customer.source}</td>
                    <td>${customer.inventoryType}</td>
                    <td>${customer.salesType}</td>
                    <td>${customer.createdBy}</td>
                    <td>${statusDate || 'N/A'}</td>
                `;
                
                customerList.appendChild(row);
            });
            
            // If no customers found
            if (filteredCustomers.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="18" class="text-center py-4">
                        <div class="text-muted">
                            <i class="bi bi-people fs-1"></i>
                            <p class="mt-2">No data is available</p>
                        </div>
                    </td>
                `;
                customerList.appendChild(row);
            }
        }

        // Open modal with filtered customers (dynamic)
        document.addEventListener('click', function(e){
            const el = e.target.closest && e.target.closest('.clickable-count');
            if (!el) return;
            e.preventDefault();
            const status = el.getAttribute('data-status');
            const campaignId = el.getAttribute('data-campaign-id');
            const count = parseInt(el.textContent) || 0;
            if (count <= 0) return;
            // store campaign id for populateCustomerTable to use
            populateCustomerTable.campaignId = campaignId;
            populateCustomerTable(status);
            customerListModal.show();
        });

        // Initialize tooltips
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(element => {
            new bootstrap.Tooltip(element);
        });

        // Update table counts on page load
        updateTableCounts();
    });

    // Global functions for clickable elements
    function openCustomerDetails(customerId) {
        console.log('Opening customer details for ID:', customerId);
        // Implement your customer details opening logic here
        alert(`Opening customer details for ID: ${customerId}\n\nIn a real application, this would open a detailed view with complete customer information.`);
    }

    function viewVehicleDetails(vehicleInfo, customerId) {
        console.log('Viewing vehicle details:', vehicleInfo, 'for customer ID:', customerId);
        // Implement your vehicle details opening logic here
        alert(`Vehicle Details:\n${vehicleInfo}\n\nCustomer ID: ${customerId}\n\nIn a real application, this would show detailed vehicle information and history.`);
    }
</script>

<script>
    (function(){
        // Show a Bootstrap toast (appended to body)
        function showToast(message, type = 'success'){
            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'error' ? 'bg-danger text-white' : (type === 'warning' ? 'bg-warning' : 'bg-success text-white');
            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center ${bgClass} border-0 position-fixed" role="alert" aria-live="assertive" aria-atomic="true" style="top:20px; right:20px; z-index:1080;">
                  <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                </div>`;

            const container = document.createElement('div');
            container.innerHTML = toastHtml;
            document.body.appendChild(container.firstElementChild);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl, { delay: 5000 });
            bsToast.show();
            // remove from DOM after hidden
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }

        // Expose global showToast if not already defined to standardize behavior
        if (typeof window.showToast !== 'function') window.showToast = showToast;

        // Load campaigns and populate table
        async function loadCampaigns(){
            try{
                const res = await fetch('/api/campaigns');
                if(!res.ok) throw new Error('Failed to fetch campaigns');
                const data = await res.json();
                console.debug('loadCampaigns response', data);
                // Handle paginated response or direct array
                let items = [];
                // direct array
                if (Array.isArray(data)) items = data;
                // wrapped array: { data: [...] }
                else if (data && Array.isArray(data.data)) items = data.data;
                // Laravel paginator wrapped further: { data: { data: [...] , ... } }
                else if (data && data.data && Array.isArray(data.data.data)) items = data.data.data;
                const tbody = document.getElementById('campaignsTableBody');
                tbody.innerHTML = '';
                console.debug('campaign items count', Array.isArray(items) ? items.length : 0);
                if(!Array.isArray(items) || items.length === 0){
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="15" class="text-center py-4 text-muted">No campaigns found</td>`;
                    tbody.appendChild(tr);
                    return;
                }

                items.forEach(c => {
                    const tr = document.createElement('tr');
                    const statusBadge = `<span class="badge bg-light text-muted border border-1" title="${c.status || ''}">${c.status || 'N/A'}</span>`;
                    tr.innerHTML = `
                        <td>
                            <div class="form-check form-check-md"><input class="form-check-input" type="checkbox" data-id="${c.id}"></div>
                        </td>
                        <td>${escapeHtml(c.name || c.title || '')}</td>
                        <td>${escapeHtml((c.type || 'Email'))}</td>
                        <td>${statusBadge}</td>
                        <td>${escapeHtml(c.tracking || '')}</td>
                        <td>${escapeHtml((c.created_by_name || c.created_by || ''))}</td>
                        <td>${escapeHtml(formatDate(c.created_at))}</td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="sent">${c.metrics?.sent ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="bounced">${c.metrics?.bounced ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="appointments">${c.metrics?.appointments ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="unsubscribed">${c.metrics?.unsubscribed ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="delivered">${c.metrics?.delivered ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="opened">${c.metrics?.opened ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="clicked">${c.metrics?.clicked ?? 0}</a></td>
                        <td><a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="replied">${c.metrics?.replied ?? 0}</a></td>
                    `;
                    tbody.appendChild(tr);
                });
                // If DataTables is present, destroy and reinitialize to pick up new rows
                try{
                    if(window.jQuery && jQuery.fn && jQuery.fn.dataTable){
                        const tableEl = jQuery('.datatable');
                        if(tableEl.length){
                            if(jQuery.fn.dataTable.isDataTable(tableEl)){
                                tableEl.DataTable().clear().destroy();
                            }
                            // reinitialize with default options (preserves design)
                            tableEl.DataTable();
                        }
                    }
                }catch(e){ console.debug('DataTable reinit error', e); }
                // re-bind clickable-count handlers to open modal (reuse existing behavior)
                if (typeof bindClickableCountHandlers === 'function') bindClickableCountHandlers();

            }catch(err){
                console.error(err);
                showToast('Unable to load campaigns', 'error');
            }
        }

        // Helpers
        function escapeHtml(unsafe){
            if(unsafe === null || unsafe === undefined) return '';
            return String(unsafe).replace(/[&<>"'`]/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;',"`":'&#96;'})[m]; });
        }

        function formatDate(d){
            if(!d) return '';
            try{ const dt = new Date(d); if(isNaN(dt)) return d; return dt.toLocaleString(); }catch(e){ return d; }
        }

        // Bind click handlers for metric links (reusable for server- or client-rendered rows)
        function bindClickableCountHandlers(){
            document.querySelectorAll('.clickable-count').forEach(el => {
                // remove previous handlers to avoid duplicates
                el.replaceWith(el.cloneNode(true));
            });
            document.querySelectorAll('.clickable-count').forEach(el => el.addEventListener('click', function(e){
                e.preventDefault();
                const status = this.getAttribute('data-status');
                const count = parseInt(this.textContent) || 0;
                if(count > 0){
                    if(typeof populateCustomerTable === 'function'){
                        populateCustomerTable(status);
                        const modalEl = document.getElementById('customerListModal');
                        if(modalEl) new bootstrap.Modal(modalEl).show();
                    }
                }
            }));
        }

        // Monkey-patch fetch to detect campaign POSTs and show toast + refresh list
        const _fetch = window.fetch;
        window.fetch = async function(resource, init){
            try{
                const response = await _fetch.apply(this, arguments);
                try{
                    const url = (typeof resource === 'string') ? resource : (resource && resource.url) || '';
                    const method = (init && init.method) || 'GET';
                    if(url.includes('/api/campaigns') && method.toUpperCase() === 'POST'){
                        if(response.ok){
                            showToast('Campaign saved successfully', 'success');
                            // refresh campaigns list
                            loadCampaigns();
                        }else{
                            let msg = 'Failed to save campaign';
                            try{ const j = await response.clone().json(); msg = j.message || msg; }catch(e){}
                            showToast(msg, 'error');
                        }
                    }
                }catch(e){ console.debug('fetch interceptor parse error', e); }
                return response;
            }catch(err){
                // network error
                console.error(err);
                showToast('Network error while saving campaign', 'error');
                throw err;
            }
        };

        // Initial load: if server-side rows exist, keep them and bind handlers; otherwise fetch via API
        document.addEventListener('DOMContentLoaded', function(){
            const tbody = document.getElementById('campaignsTableBody');
            if (!tbody) return;
            const hasRows = Array.from(tbody.children).some(r => r.querySelector('td'));
            if (hasRows) {
                if (typeof bindClickableCountHandlers === 'function') bindClickableCountHandlers();
            } else {
                loadCampaigns();
            }
        });

        // Expose for debugging
        window._loadCampaigns = loadCampaigns;
        window._showToast = showToast;
    })();
</script>


  

  </div>
@endsection