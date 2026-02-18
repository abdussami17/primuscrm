/**
 * Deals Manager - Dynamic Deals Management System
 */

const DealsManager = {
    currentCustomerId: null,
    currentDealId: null,
    deals: [],
    users: [],
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.content,

    init(customerId) {
        this.currentCustomerId = customerId;
        this.bindEvents();
        this.loadUsers();
        this.loadDeals();
    },

    bindEvents() {
        // Deal tabs filter
        document.querySelectorAll('.deals-tabs .nav-link').forEach(btn => {
            btn.onclick = (e) => {
                document.querySelectorAll('.deals-tabs .nav-link').forEach(b => b.classList.remove('active'));
                e.target.classList.add('active');
                this.filterDeals(e.target.dataset.filter);
            };
        });

        // Add deal form
        document.getElementById('addDealForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.saveDeal();
        });

        // Load inventory when modal opens
        const inventoryModal = document.getElementById('gotoinventoryModal');
        if (inventoryModal) {
            inventoryModal.addEventListener('show.bs.modal', () => this.loadInventory());
        }

        // Inventory search
        const inventorySearch = document.getElementById('inventorySearchInput');
        if (inventorySearch) {
            let timeout;
            inventorySearch.oninput = (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => this.searchInventory(e.target.value), 300);
            };
        }

        // Event delegation for deals container
        document.getElementById('dealsContainer')?.addEventListener('click', (e) => {
            const dealBox = e.target.closest('.deal-box');
            if (!dealBox) return;
            const dealId = dealBox.dataset.dealId;

            // Toggle deal details on icon or vehicle name click
            if (e.target.closest('.toggle-deal-details-icon') || e.target.closest('.deal-vehicle-name')) {
                this.toggleDealDetails(dealBox, dealId);
            }

            // Delete deal
            if (e.target.closest('.ti-trash')) {
                e.stopPropagation();
                if (confirm('Are you sure you want to delete this deal?')) {
                    this.deleteDeal(dealId);
                }
            }
        });

        // Auto-save deal fields on change
        document.getElementById('dealsContainer')?.addEventListener('change', (e) => {
            const dealBox = e.target.closest('.deal-box');
            if (dealBox && e.target.matches('select, input')) {
                const dealId = dealBox.dataset.dealId;
                const field = e.target.dataset.field || e.target.name;
                if (dealId && field) {
                    this.updateDealField(dealId, field, e.target.value);
                }
            }
        });
    },

    // Toggle deal details and load associated data
    toggleDealDetails(dealBox, dealId) {
        const detailsArea = dealBox.querySelector('.deals-detail-area');
        const icon = dealBox.querySelector('.toggle-deal-details-icon');
        
        if (detailsArea.classList.contains('d-none')) {
            // Show details
            detailsArea.classList.remove('d-none');
            icon.classList.remove('ti-caret-down-filled');
            icon.classList.add('ti-caret-up-filled');
            
            // Select this deal and load associated sections
            this.selectDeal(dealId);
        } else {
            // Hide details
            detailsArea.classList.add('d-none');
            icon.classList.remove('ti-caret-up-filled');
            icon.classList.add('ti-caret-down-filled');
        }
    },

    // API Helper
    async api(url, method = 'GET', data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken
            }
        };
        if (data) options.body = JSON.stringify(data);

        const response = await fetch(url, options);
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Request failed');
        return result;
    },

    // Load users for dropdowns
    async loadUsers() {
        try {
            const result = await this.api('/api/users');
            this.users = result.data || result.users || [];
        } catch (error) {
            console.error('Failed to load users');
        }
    },

    // Load customer deals
    async loadDeals() {
        if (!this.currentCustomerId) return;
        const container = document.getElementById('dealsContainer');

        try {
            const result = await this.api(`/api/customers/${this.currentCustomerId}/deals`);
            this.deals = result.deals || [];
            this.renderDeals();
        } catch (error) {
            container.innerHTML = '<p class="text-danger text-center">Failed to load deals</p>';
        }
    },

    // Render deals with original design
    renderDeals() {
        const container = document.getElementById('dealsContainer');
        if (!container) return;

        if (!this.deals.length) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="ti ti-car-off" style="font-size:48px;"></i>
                    <p class="mt-2">No deals found. Click + to add a new deal.</p>
                </div>`;
            return;
        }

        container.innerHTML = this.deals.map(deal => this.dealTemplate(deal)).join('');
    },

    // Original deal template design
    dealTemplate(deal) {
        const statusClass = this.getStatusClass(deal.status);
        const statusColor = this.getStatusColor(deal.status);
        const createdDate = new Date(deal.created_at).toLocaleDateString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric'
        });

        return `
        <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" 
             data-deal-id="${deal.id}" data-status="${statusClass}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="d-flex justify-content-normal align-items-center">
                        <p class="deal-vehicle-name fw-semibold mb-0" style="cursor:pointer;">
                            ${deal.vehicle_description || 'No Vehicle Selected'}
                        </p>
                        <i class="toggle-deal-details-icon ti ms-2 ti-caret-down-filled" style="cursor:pointer;"></i>
                    </div>
                    <p class="text-muted deal-date">Created Date: ${createdDate}</p>
                </div>
                <div class="text-end">
                    <div class="d-flex justify-content-normal align-items-center gap-1">
                        <i class="ti ti-trash text-danger" style="cursor:pointer;"></i>
                        <span class="fw-bold d-block" style="color:${statusColor};">${deal.status}</span>
                    </div>
                </div>
            </div>
            <div class="row deals-detail-area d-none g-2">
                ${this.dealDetailsTemplate(deal)}
            </div>
        </div>`;
    },

    // Deal details template (original design)
    dealDetailsTemplate(deal) {
        return `
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Assigned To</label>
                <select class="form-select form-select-sm" data-field="sales_person_id">
                    <option value="" hidden>-- Select --</option>
                    ${this.userOptions(deal.sales_person_id)}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Secondary Assigned To</label>
                <select class="form-select form-select-sm" data-field="sales_manager_id">
                    <option value="" hidden>-- Select --</option>
                    ${this.userOptions(deal.sales_manager_id)}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">BDC Agent</label>
                <select class="form-select form-select-sm" data-field="finance_manager_id">
                    <option value="" hidden>-- Select --</option>
                    ${this.userOptions(deal.finance_manager_id)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-sm mb-1">Lead Type</label>
                <select class="form-select form-select-sm" data-field="lead_type">
                    ${this.selectOptions(['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Import', 'Wholesale', 'Lease Renewal'], deal.lead_type)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-sm mb-1">Lead Status</label>
                <select class="form-select form-select-sm sales-status" data-field="status">
                    ${this.selectOptions(['Active', 'Duplicate', 'Invalid', 'Lost', 'Sold', 'Wishlist'], deal.status)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-sm mb-1">Inventory Type</label>
                <select class="form-select form-select-sm" data-field="inventory_type">
                    ${this.selectOptions(['New', 'Pre-Owned', 'CPO', 'Demo', 'Wholesale', 'Unknown'], deal.inventory_type)}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-sm mb-1">Source</label>
                <select class="form-select form-select-sm" data-field="source">
                    ${this.selectOptions(['Walk-In', 'Phone Up', 'Text', 'Repeat Customer', 'Referral', 'Service to Sales', 'Lease Renewal', 'Drive By', 'Dealer Website'], deal.source)}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Sales Type</label>
                <select class="form-select form-select-sm" data-field="sales_type">
                    <option value="Sales" ${deal.sales_type === 'Sales' ? 'selected' : ''}>Sales Lead</option>
                    <option value="Service" ${deal.sales_type === 'Service' ? 'selected' : ''}>Service Lead</option>
                    <option value="Parts" ${deal.sales_type === 'Parts' ? 'selected' : ''}>Parts Lead</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Sales Status</label>
                <select class="form-select form-select-sm" data-field="sales_status">
                    ${this.selectOptions(['Uncontacted', 'Attempted', 'Contacted', 'Dealer Visit', 'Demo', 'Write-Up', 'Pending F&I', 'Sold', 'Delivered'], deal.sales_status)}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-sm mb-1">Deal Type</label>
                <select class="form-select form-select-sm" data-field="deal_type">
                    <option value="Finance" ${deal.deal_type === 'Finance' ? 'selected' : ''}>Finance</option>
                    <option value="Cash" ${deal.deal_type === 'Cash' ? 'selected' : ''}>Cash</option>
                    <option value="Lease" ${deal.deal_type === 'Lease' ? 'selected' : ''}>Lease</option>
                </select>
            </div>`;
    },

    userOptions(selectedId) {
        return this.users.map(u => 
            `<option value="${u.id}" ${u.id == selectedId ? 'selected' : ''}>${u.name}</option>`
        ).join('');
    },

    selectOptions(options, selected) {
        return options.map(opt => 
            `<option value="${opt}" ${opt === selected ? 'selected' : ''}>${opt}</option>`
        ).join('');
    },

    getStatusClass(status) {
        const map = { 'Active': 'active', 'Sold': 'sold', 'Delivered': 'sold', 'Lost': 'lost', 'Pending F&I': 'pending' };
        return map[status] || 'active';
    },

    getStatusColor(status) {
        const colors = { 'Active': '#0d6efd', 'Sold': '#198754', 'Delivered': '#198754', 'Lost': '#dc3545', 'Pending F&I': '#ffc107' };
        return colors[status] || '#6c757d';
    },

    filterDeals(filter) {
        document.querySelectorAll('.deal-box').forEach(box => {
            box.style.display = (filter === 'all' || box.dataset.status === filter) ? '' : 'none';
        });
    },

    // Select deal and load all associated sections
    selectDeal(dealId) {
        this.currentDealId = dealId;

        // Highlight selected deal
        document.querySelectorAll('.deal-box').forEach(box => {
            box.classList.toggle('border-primary', box.dataset.dealId == dealId);
            box.style.borderWidth = box.dataset.dealId == dealId ? '2px' : '';
        });

        // Show all sections
        ['taskandappointmentSection', 'vehiclesInterest', 'notesHistory', 'activityTimelineSection'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'block';
        });

        // Set deal ID in task form
        const taskDealId = document.getElementById('taskDealId');
        if (taskDealId) taskDealId.value = dealId;

        // Load associated data
        TasksManager.loadTasks(this.currentCustomerId, dealId);
        VehiclesManager.loadVehicle(dealId);
        NotesManager.loadNotes(this.currentCustomerId, dealId);
        ActivityManager.loadActivities(dealId);
    },

    async saveDeal() {
        const form = document.getElementById('addDealForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        data.customer_id = this.currentCustomerId;

        if (!data.deal_number) data.deal_number = 'DL-' + Date.now();

        try {
            await this.api('/api/deals', 'POST', data);
            this.showToast('Deal created successfully', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addDealModal'))?.hide();
            form.reset();
            this.loadDeals();
        } catch (error) {
            this.showToast(error.message, 'error');
        }
    },

    async updateDealField(dealId, field, value) {
        try {
            await this.api(`/api/deals/${dealId}/field`, 'PATCH', { field, value });
            if (field === 'status') this.loadDeals();
        } catch (error) {
            this.showToast(error.message, 'error');
        }
    },

    async deleteDeal(dealId) {
        try {
            await this.api(`/api/deals/${dealId}`, 'DELETE');
            this.showToast('Deal deleted', 'success');
            this.deals = this.deals.filter(d => d.id != dealId);
            this.renderDeals();
            
            if (!this.deals.length) {
                ['taskandappointmentSection', 'vehiclesInterest', 'notesHistory', 'activityTimelineSection'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.style.display = 'none';
                });
            }
        } catch (error) {
            this.showToast(error.message, 'error');
        }
    },

    // Inventory functions
    async loadInventory() {
        const container = document.querySelector('.go-to-inventory');
        if (!container) return;

        container.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm"></div></div>';

        try {
            const result = await this.api('/api/inventory');
            this.renderInventoryItems(container, result.data || []);
        } catch (error) {
            container.innerHTML = '<p class="text-danger text-center">Failed to load inventory</p>';
        }
    },

    async searchInventory(query) {
        const container = document.querySelector('.go-to-inventory');
        if (!container) return;
        if (!query.trim()) return this.loadInventory();

        try {
            const result = await this.api(`/api/inventory/search?search=${encodeURIComponent(query)}`);
            this.renderInventoryItems(container, result.data || []);
        } catch (error) {
            container.innerHTML = '<p class="text-danger text-center">Search failed</p>';
        }
    },

    renderInventoryItems(container, items) {
        const countEl = document.querySelector('.vehicle-search-record_text');
        if (countEl) countEl.textContent = `Vehicles (1-${items.length}) OF ${items.length}`;

        if (!items.length) {
            container.innerHTML = '<p class="text-muted text-center py-4">No vehicles found</p>';
            return;
        }

        container.innerHTML = items.map(item => `
            <div class="inventory-item border rounded p-2 d-flex align-items-center gap-3" 
                 data-id="${item.id}" data-vehicle='${JSON.stringify(item).replace(/'/g, "\\'")}'>
                <img src="${item.images?.[0] || '/assets/img/cars/default.png'}" 
                     style="width:80px;height:60px;object-fit:cover;border-radius:4px;">
                <div class="flex-grow-1">
                    <p class="fw-semibold mb-0">${item.year} ${item.make} ${item.model} ${item.trim || ''}</p>
                    <p class="text-muted small mb-0">Stock: ${item.stock_number || 'N/A'} | VIN: ${item.vin || 'N/A'}</p>
                    <p class="text-success fw-bold mb-0">$${parseFloat(item.price || 0).toLocaleString()}</p>
                </div>
                <button class="btn btn-primary btn-sm select-inventory-btn">Select</button>
            </div>
        `).join('');

        container.querySelectorAll('.select-inventory-btn').forEach(btn => {
            btn.onclick = () => {
                const item = JSON.parse(btn.closest('.inventory-item').dataset.vehicle.replace(/\\'/g, "'"));
                this.selectInventory(item);
            };
        });
    },

    selectInventory(vehicle) {
        document.getElementById('dealInventoryId').value = vehicle.id;
        document.getElementById('dealVehicleDescription').value = 
            `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim();
        document.getElementById('dealPrice').value = vehicle.price || '';
        document.getElementById('selectedVehicleDisplay').textContent = 
            `${vehicle.year} ${vehicle.make} ${vehicle.model}`;

        bootstrap.Modal.getInstance(document.getElementById('gotoinventoryModal'))?.hide();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addDealModal')).show();
    },

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : 'success'} position-fixed`;
        toast.style.cssText = 'top:20px;right:20px;z-index:9999;min-width:250px;';
        toast.innerHTML = `<i class="ti ti-${type === 'error' ? 'x' : 'check'} me-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
};

// ==================== TASKS MANAGER ====================
const TasksManager = {
    tasks: [],

    async loadTasks(customerId, dealId) {
        try {
            const result = await DealsManager.api(`/api/tasks?customer_id=${customerId}&deal_id=${dealId}`);
            this.tasks = result.data || [];
            this.renderTasks();
        } catch (error) {
            console.error('Failed to load tasks');
        }
    },

    renderTasks() {
        const section = document.getElementById('taskandappointmentSection');
        if (!section) return;

        const cardBox = section.querySelector('.card-box');
        let container = cardBox.querySelector('.tasks-list');
        if (!container) {
            container = document.createElement('div');
            container.className = 'tasks-list';
            cardBox.appendChild(container);
        }

        container.innerHTML = this.tasks.length ? this.tasks.map(task => `
            <div class="d-flex justify-content-between align-items-center task_assignments-section" data-task-id="${task.id}">
                <div class="d-flex justify-content-normal align-items-center gap-2">
                    <div class="icon-box"><i class="ti ti-calendar"></i></div>
                    <div class="detail"><p><strong>${task.task_type}</strong></p></div>
                </div>
                <div><small>${new Date(task.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</small></div>
            </div>
        `).join('') : '<p class="text-muted text-center mt-3">No tasks found</p>';
    }
};

// ==================== VEHICLES MANAGER ====================
const VehiclesManager = {
    async loadVehicle(dealId) {
        try {
            const result = await DealsManager.api(`/api/deals/${dealId}/vehicle`);
            this.renderVehicle(result.vehicle);
            this.renderServiceHistory(result.service_history || []);
        } catch (error) {
            console.error('Failed to load vehicle');
        }
    },

    renderVehicle(v) {
        const container = document.getElementById('vehicleTab');
        if (!container) return;

        if (!v) {
            container.innerHTML = '<p class="text-muted text-center py-4">No vehicle assigned</p>';
            return;
        }

        container.innerHTML = `
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="car-card border border-1">
                        <div class="top bg-light"><span>${v.condition || 'Used'}</span></div>
                        <img src="${v.images?.[0] || '/assets/img/cars/default.png'}" alt="${v.make}">
                        <div class="bottom bg-success"><span>In Stock</span></div>
                    </div>
                    <div class="form-check form-check-inline mt-2">
                        <input class="form-check-input" type="checkbox" id="holdVehicle">
                        <label class="form-check-label" for="holdVehicle">Hold Vehicle</label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="car-name">${v.year} ${v.make} ${v.model} ${v.trim || ''}</div>
                    <div class="price text-success mb-1">$${parseFloat(v.price || 0).toLocaleString()}</div>
                    <div class="details row">
                        <div class="col-md-6">
                            <p><strong>Stock #:</strong> ${v.stock_number || 'N/A'}</p>
                            <p><strong>VIN:</strong> ${v.vin || 'N/A'}</p>
                            <p><strong>Odometer:</strong> ${v.mileage?.toLocaleString() || 'N/A'}</p>
                            <p><strong>Body Style:</strong> ${v.body_type || 'N/A'}</p>
                            <p><strong>Exterior Color:</strong> ${v.exterior_color || 'N/A'}</p>
                            <p><strong>Interior Color:</strong> ${v.interior_color || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fuel:</strong> ${v.fuel_type || 'N/A'}</p>
                            <p><strong>Transmission:</strong> ${v.transmission || 'N/A'}</p>
                            <p><strong>Engine:</strong> ${v.engine || 'N/A'}</p>
                            <p><strong>Drive Type:</strong> ${v.drivetrain || 'N/A'}</p>
                        </div>
                    </div>
                </div>
            </div>`;
    },

    renderServiceHistory(history) {
        const tbody = document.querySelector('#serviceHistoryTab tbody');
        if (!tbody) return;
        tbody.innerHTML = history.length ? history.map(h => `
            <tr>
                <td>${new Date(h.service_date).toLocaleDateString()}</td>
                <td>${h.service_type}</td>
                <td>${h.description}</td>
                <td>${h.mileage?.toLocaleString() || ''}</td>
                <td>$${parseFloat(h.cost || 0).toFixed(2)}</td>
                <td>${h.advisor_name || ''}</td>
            </tr>
        `).join('') : '<tr><td colspan="6" class="text-center text-muted">No service history</td></tr>';
    }
};

// ==================== NOTES MANAGER ====================
const NotesManager = {
    notes: [],
    visitStartTime: null,
    visitInterval: null,

    init() {
        document.getElementById('addNote')?.addEventListener('click', () => this.addNote());
        document.getElementById('startVisitBtn')?.addEventListener('click', () => this.startVisit());
        document.getElementById('stopVisitBtn')?.addEventListener('click', () => this.stopVisit());
    },

    async loadNotes(customerId, dealId) {
        try {
            const result = await DealsManager.api(`/api/notes?customer_id=${customerId}&deal_id=${dealId}`);
            this.notes = result.data || [];
            this.renderNotes();
        } catch (error) {
            console.error('Failed to load notes');
        }
    },

    renderNotes() {
        const container = document.getElementById('recentHistory');
        if (!container) return;

        container.innerHTML = this.notes.length ? this.notes.slice(0, 5).map(note => `
            <div class="history-item border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-bold">${note.created_by?.name || 'System'}</span>
                        <span class="text-muted ms-2">${new Date(note.created_at).toLocaleDateString()}</span>
                    </div>
                    <span class="badge bg-light text-dark">${note.type || 'Note'}</span>
                </div>
                <p class="mb-1 mt-1">${note.description}</p>
            </div>
        `).join('') : '<p class="text-muted text-center">No history yet</p>';
    },

    async addNote() {
        const text = document.getElementById('noteText')?.value?.trim();
        if (!text) return;

        try {
            await DealsManager.api('/api/notes', 'POST', {
                customer_id: DealsManager.currentCustomerId,
                deal_id: DealsManager.currentDealId,
                description: text,
                type: 'Note'
            });
            document.getElementById('noteText').value = '';
            DealsManager.showToast('Note added', 'success');
            this.loadNotes(DealsManager.currentCustomerId, DealsManager.currentDealId);
        } catch (error) {
            DealsManager.showToast('Failed to add note', 'error');
        }
    },

    startVisit() {
        this.visitStartTime = new Date();
        document.getElementById('startVisitBtn').disabled = true;
        document.getElementById('stopVisitBtn').disabled = false;
        document.getElementById('visitStartTime').textContent = this.visitStartTime.toLocaleString();
        document.getElementById('visitStatusIndicator').textContent = 'Visit in progress...';

        this.visitInterval = setInterval(() => {
            const s = Math.floor((new Date() - this.visitStartTime) / 1000);
            document.getElementById('visitDurationDisplay').textContent = 
                `${Math.floor(s/3600).toString().padStart(2,'0')}:${Math.floor((s%3600)/60).toString().padStart(2,'0')}:${(s%60).toString().padStart(2,'0')}`;
        }, 1000);
    },

    stopVisit() {
        clearInterval(this.visitInterval);
        document.getElementById('startVisitBtn').disabled = false;
        document.getElementById('stopVisitBtn').disabled = true;
        document.getElementById('visitEndTimeDisplay').textContent = new Date().toLocaleString();
        document.getElementById('visitStatusIndicator').textContent = 'Visit completed';
    }
};

// ==================== ACTIVITY MANAGER ====================
const ActivityManager = {
    async loadActivities(dealId) {
        try {
            const result = await DealsManager.api(`/api/deals/${dealId}/activities`);
            this.renderActivities(result.data || []);
        } catch (error) {
            console.error('Failed to load activities');
        }
    },

    renderActivities(activities) {
        const section = document.getElementById('activityTimelineSection');
        if (!section) return;

        const cardBox = section.querySelector('.card-box');
        let container = cardBox.querySelector('.activities-list');
        if (!container) {
            container = document.createElement('div');
            container.className = 'activities-list';
            cardBox.appendChild(container);
        }

        const icons = { 'vehicle_change': 'car', 'status_change': 'toggle-right', 'note_added': 'note', 'deal_created': 'receipt', 'customer_update': 'user' };

        container.innerHTML = activities.length ? activities.map(a => `
            <div class="d-flex justify-content-between align-items-start mt-2 task_assignments-section">
                <div class="d-flex align-items-center justify-content-normal gap-2 flex-grow-1">
                    <div class="icon-box"><i class="ti ti-${icons[a.type] || 'activity'}"></i></div>
                    <div class="detail flex-grow-1">
                        <p class="mb-0 text-wrap">${a.description} ${a.user ? `by <strong>${a.user.name}</strong>` : ''}</p>
                    </div>
                </div>
                <div class="ms-2" style="white-space:nowrap;">
                    <small>${new Date(a.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</small>
                </div>
            </div>
        `).join('') : '<p class="text-muted text-center mt-3">No activity yet</p>';
    }
};

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    NotesManager.init();
    const customerId = document.querySelector('[data-customer-id]')?.dataset.customerId;
    if (customerId) DealsManager.init(customerId);
});