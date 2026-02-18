{{-- Deal Vehicle Modal - resources/views/customers/modals/deal-vehicle-modal.blade.php --}}

@props(['dealId' => null])

<div id="dealVehicleModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                <span>Add Vehicle to Deal</span>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body pt-1">
                {{-- Hidden Deal ID --}}
                <input type="hidden" id="currentDealId" value="{{ $dealId }}">

                {{-- Search Input --}}
                <div class="position-relative">
                    <i class="ti ti-search position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:#6c757d;"></i>
                    <input type="text" 
                           placeholder="Search by make, model, VIN, or stock number..." 
                           class="form-control ps-5" 
                           id="dealVehicleSearchInput">
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <p class="vehicle-search-record_text mb-0" id="dealVehicleCount">
                            Loading...
                        </p>
                        <div>
                            <button class="btn btn-outline-secondary me-1 mb-1" data-bs-dismiss="modal">
                                <i class="ti ti-x me-1"></i>Cancel
                            </button>
                            <button class="btn btn-primary mb-1" 
                                    type="button"
                                    onclick="openManualVehicleForm()">
                                <i class="ti ti-plus me-1"></i>Add Manually
                            </button>
                        </div>
                    </div>

                    {{-- INVENTORY LIST --}}
                    <div class="deal-vehicle-list mt-3 d-flex flex-column gap-3"
                         id="dealVehicleList"
                         style="max-height:450px;overflow-y:auto;">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Manual Vehicle Form Modal --}}
<div id="manualVehicleModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                <span>What kind of vehicle does your customer want? </span>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="manualVehicleForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Inventory Type</label>
                            <select class="form-select" name="inventory_type">
                                <option value="">Select Inventory Type</option>
                                <option value="new">New</option>
                                <option value="used">Used</option>
                                <option value="preorder">Preorder</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="year" required min="1900" max="2030">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Make <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="make" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="model" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Trim</label>
                            <input type="text" class="form-control" name="trim">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">VIN</label>
                            <input type="text" class="form-control" name="vin" maxlength="17">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stock Number</label>
                            <input type="text" class="form-control" name="stock_number">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Odometer</label>
                            <input type="number" class="form-control" name="odometer">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Exterior Color</label>
                            <input type="text" class="form-control" name="exterior_color">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Interior Color</label>
                            <input type="text" class="form-control" name="interior_color">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Body Style</label>
                            <select class="form-select" name="body_style">
                                <option value="">Select</option>
                                <option value="sedan">Sedan</option>
                                <option value="coupe">Coupe</option>
                                <option value="hatchback">Hatchback</option>
                                <option value="suv">SUV</option>
                                <option value="truck">Truck</option>
                                <option value="van">Van</option>
                                <option value="wagon">Wagon</option>
                                <option value="convertible">Convertible</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fuel</label>
                            <input type="text" class="form-control" name="fuel">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">MPG (City)</label>
                            <input type="number" class="form-control" name="mpg_city" step="1" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">MPG (Hwy)</label>
                            <input type="number" class="form-control" name="mpg_hwy" step="1" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Transmission</label>
                            <input type="text" class="form-control" name="transmission">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Model Code</label>
                            <input type="text" class="form-control" name="model_code">
                        </div>
                        </div>

                       


                        <h6 class="mt-3">What are your customer's preferred limits?</h6>
                        <div class="row g-2 mt-0">
                            <div class="col-md-6">
                                <label class="form-label">Max Price</label>
                                <input type="number" class="form-control" name="max_price" step="0.01" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Max Odometer</label>
                                <input type="number" class="form-control" name="max_odometer" placeholder="0">
                            </div>
                        </div>
                    </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                <button id="manualVehicleSubmitBtn" type="button" class="btn btn-primary ms-2" onclick="(function(btn){ btn.disabled=true; addManualVehicleToDeal(new FormData(document.getElementById('manualVehicleForm'))).finally(()=>btn.disabled=false); })(document.getElementById('manualVehicleSubmitBtn'))">
                   Add Vehicle
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // Clean up any stale backdrops

    const dealVehicleModal = document.getElementById('dealVehicleModal');
    const searchInput = document.getElementById('dealVehicleSearchInput');
    let searchTimeout;

    // Load inventory when modal opens
    dealVehicleModal?.addEventListener('show.bs.modal', function(e) {
        // Get deal ID from trigger button if available
        const triggerBtn = e.relatedTarget;
        if (triggerBtn?.dataset.dealId) {
            document.getElementById('currentDealId').value = triggerBtn.dataset.dealId;
        }
        loadDealVehicleInventory();
    });

    // Search with debounce
    searchInput?.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => searchDealVehicles(e.target.value), 300);
    });

    // Manual form submission
    document.getElementById('manualVehicleForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        await addManualVehicleToDeal(new FormData(this));
    });
})();

async function apiRequest(url, options = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const response = await fetch(url, {
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            ...options.headers
        },
        ...options
    });
    
    if (!response.ok) {
        const error = await response.json().catch(() => ({}));
        throw new Error(error.message || 'Request failed');
    }
    
    return response.json();
}

async function loadDealVehicleInventory() {
    const container = document.getElementById('dealVehicleList');
    container.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary"></div>
            <p class="text-muted mt-2 mb-0">Loading inventory...</p>
        </div>
    `;

    try {
        const result = await apiRequest('/api/inventory');
        renderDealVehicleItems(result.data || []);
    } catch (error) {
        container.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="ti ti-alert-circle me-2"></i>
                Failed to load inventory. Please try again.
            </div>
        `;
    }
}

async function searchDealVehicles(query) {
    if (!query.trim()) {
        return loadDealVehicleInventory();
    }

    const container = document.getElementById('dealVehicleList');
    container.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border spinner-border-sm text-primary"></div>
            <span class="ms-2">Searching...</span>
        </div>
    `;

    try {
        const result = await apiRequest(`/api/inventory/search?search=${encodeURIComponent(query)}`);
        renderDealVehicleItems(result.data || []);
    } catch (error) {
        container.innerHTML = `
            <div class="alert alert-warning text-center">
                Search failed. Please try again.
            </div>
        `;
    }
}

function renderDealVehicleItems(items) {
    const container = document.getElementById('dealVehicleList');
    const countEl = document.getElementById('dealVehicleCount');

    countEl.textContent = items.length > 0 
        ? `Showing ${items.length} vehicle${items.length !== 1 ? 's' : ''}`
        : 'No vehicles found';

    if (!items.length) {
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="ti ti-car-off text-muted" style="font-size:48px;"></i>
                <p class="text-muted mt-3 mb-0">No vehicles found in inventory</p>
                <button class="btn btn-primary btn-sm mt-3" onclick="openManualVehicleForm()">
                    <i class="ti ti-plus me-1"></i>Add Vehicle Manually
                </button>
            </div>
        `;
        return;
    }

    container.innerHTML = items.map(vehicle => `
        <div class="vehicle-card border rounded p-3 bg-light hover-shadow">
            <div class="row g-3 align-items-center">
                <div class="col-md-2">
                    <img src="${vehicle.images?.[0] || '/assets/img/cars/default.png'}" 
                         alt="${vehicle.make} ${vehicle.model}"
                         class="img-fluid rounded"
                         style="max-height:80px;object-fit:cover;width:100%;">
                </div>
                <div class="col-md-8">
                    <h6 class="mb-1 fw-bold">
                        ${vehicle.year || ''} ${vehicle.make || ''} ${vehicle.model || ''} ${vehicle.trim || ''}
                    </h6>
                    <p class="text-success fw-semibold mb-1">
                        $${Number(vehicle.price || 0).toLocaleString()}
                    </p>
                    <p class="text-muted small mb-0">
                        <span class="me-3"><strong>Stock:</strong> ${vehicle.stock_number || 'N/A'}</span>
                        <span class="me-3"><strong>VIN:</strong> ${vehicle.vin || 'N/A'}</span>
                        <span><strong>Miles:</strong> ${vehicle.odometer ? Number(vehicle.odometer).toLocaleString() : 'N/A'}</span>
                    </p>
                    <p class="text-muted small mb-0">
                        <span class="me-3"><strong>Color:</strong> ${vehicle.exterior_color || 'N/A'}</span>
                        <span><strong>Trans:</strong> ${vehicle.transmission || 'N/A'}</span>
                    </p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-primary w-100"
                            onclick='addVehicleToDeal(${JSON.stringify(vehicle).replace(/'/g, "&#39;")})'>
                        <i class="ti ti-plus me-1"></i>Add
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

async function addVehicleToDeal(vehicle) {
    const dealId = document.getElementById('currentDealId').value;
    
    if (!dealId) {
        showToast('error', 'No deal selected');
        return;
    }

    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    try {
        await apiRequest(`/api/deals/${dealId}/vehicle`, {
            method: 'POST',
            body: JSON.stringify({
                inventory_id: vehicle.id
            })
        });

        showToast('success', 'Vehicle added to deal successfully');
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('dealVehicleModal'))?.hide();
        
        // Refresh vehicle partial on page
        refreshVehiclePartial(dealId);

    } catch (error) {
        showToast('error', error.message || 'Failed to add vehicle');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

function openManualVehicleForm() {
    const currentEl = document.getElementById('dealVehicleModal');
    const manualEl = document.getElementById('manualVehicleModal');

    const showManual = () => {
        try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
        try { document.body.appendChild(manualEl); } catch(e){}
        document.getElementById('manualVehicleForm')?.reset();
        try {
            if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                bootstrap.Modal.getOrCreateInstance(manualEl).show();
            } else {
                new bootstrap.Modal(manualEl).show();
            }
        } catch (e) {
            try { bootstrap.Modal.getInstance(manualEl)?.show(); } catch(e){}
            try { new bootstrap.Modal(manualEl).show(); } catch(e){}
        }
    };

    try {
        const currentModal = bootstrap.Modal.getInstance(currentEl);
        if (currentModal) {
            const handler = function() {
                currentEl.removeEventListener('hidden.bs.modal', handler);
                // small delay to ensure backdrop removed
                setTimeout(showManual, 50);
            };
            currentEl.addEventListener('hidden.bs.modal', handler);
            currentModal.hide();
            return;
        }
    } catch(e) { console.warn(e); }

    // If no current modal instance, show immediately
    showManual();
}

async function addManualVehicleToDeal(formData) {
    // Prevent duplicate submissions from multiple triggers
    if (window._manualVehicleSubmitting) {
        console.warn('addManualVehicleToDeal: already submitting, ignoring duplicate call');
        return;
    }
    window._manualVehicleSubmitting = true;

    const dealIdEl = document.getElementById('currentDealId');
    const dealId = dealIdEl ? dealIdEl.value : null;

    const submitBtn = document.getElementById('manualVehicleSubmitBtn') || document.querySelector('#manualVehicleForm button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Adding...';
    if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...'; }

    try {
        const vehicleData = Object.fromEntries(formData.entries());

        if (dealId) {
            // Add vehicle to existing deal
            await apiRequest(`/api/deals/${dealId}/vehicle/manual`, {
                method: 'POST',
                body: JSON.stringify(vehicleData)
            });

            showToast('success', 'Vehicle added successfully');

            // Robust close manual modal
            try {
                const modalEl = document.getElementById('manualVehicleModal');
                if (modalEl) {
                    try {
                        const inst = (typeof bootstrap.Modal.getInstance === 'function') ? bootstrap.Modal.getInstance(modalEl) : null;
                        if (inst && typeof inst.hide === 'function') inst.hide();
                        else if (typeof bootstrap.Modal.getOrCreateInstance === 'function') bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                        else { modalEl.classList.remove('show'); modalEl.style.display = 'none'; }
                    } catch (e) { modalEl.classList.remove('show'); modalEl.style.display = 'none'; }
                }
            } catch (e) { console.warn('Failed to hide manualVehicleModal', e); }

            try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
            try { document.body.classList.remove('modal-open'); } catch(e){}

            // Refresh vehicle partial
            refreshVehiclePartial(dealId);
            return;
        }

        // No dealId: create a new deal with this vehicle (send explicit vehicle fields)
        const customerId = (document.getElementById('customerId')?.value)
            || document.querySelector('input[name="customer_id"]')?.value
            || null;

        const descParts = [];
        if (vehicleData.year) descParts.push(vehicleData.year);
        if (vehicleData.make) descParts.push(vehicleData.make);
        if (vehicleData.model) descParts.push(vehicleData.model);
        const vehicleDescription = (vehicleData.model && `${vehicleData.model} vehicle`) || descParts.join(' ').trim() || 'Manual Vehicle';

        const payload = {
            customer_id: customerId || undefined,
            inventory_id: null,
            vehicle_description: vehicleDescription,
            year: vehicleData.year || null,
            make: vehicleData.make || null,
            model: vehicleData.model || null,
            trim: vehicleData.trim || null,
            vin: vehicleData.vin || null,
            stock_number: vehicleData.stock_number || null,
            price: vehicleData.price || null,
            odometer: vehicleData.odometer || null,
            exterior_color: vehicleData.exterior_color || null,
            interior_color: vehicleData.interior_color || null,
            transmission: vehicleData.transmission || null,
            inventory_type: vehicleData.inventory_type || null,
            status: 'Active'
        };

        const created = await apiRequest('/api/deals', {
            method: 'POST',
            body: JSON.stringify(payload)
        });

        showToast('success', 'Deal created');
        if (created && (created.id || created.data?.id || created.deal?.id)) {
            // Close manual modal robustly
            try {
                const modalEl = document.getElementById('manualVehicleModal');
                if (modalEl) {
                    try {
                        const inst = (typeof bootstrap.Modal.getInstance === 'function') ? bootstrap.Modal.getInstance(modalEl) : null;
                        if (inst && typeof inst.hide === 'function') inst.hide();
                        else if (typeof bootstrap.Modal.getOrCreateInstance === 'function') bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                        else { modalEl.classList.remove('show'); modalEl.style.display = 'none'; }
                    } catch (e) { modalEl.classList.remove('show'); modalEl.style.display = 'none'; }
                }
            } catch (e) { console.warn('Failed to hide manualVehicleModal', e); }

            try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
            try { document.body.classList.remove('modal-open'); } catch(e){}

            const createdDeal = created.deal || created.data || created || null;
            const resolvedId = createdDeal && (createdDeal.id || createdDeal.deal_id || createdDeal.dealId || createdDeal.data?.id) ? (createdDeal.id || createdDeal.deal_id || createdDeal.dealId || createdDeal.data?.id) : null;
            const dealsContainer = document.getElementById('dealsContainer');

            if (dealsContainer) {
                try {
                    const displayDesc = (createdDeal && createdDeal.vehicle_description && String(createdDeal.vehicle_description).trim()) || vehicleDescription || 'No Vehicle Entered';
                    const isPlaceholder = displayDesc === 'No Vehicle Entered';
                    const div = document.createElement('div');
                    div.className = 'deal-box mb-3 p-2 border rounded bg-white shadow-sm';
                    if (resolvedId) div.dataset.dealId = resolvedId;
                    div.innerHTML = `
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center">
                                    <p class="deal-vehicle-name fw-semibold mb-0 ${isPlaceholder ? 'text-danger' : ''}" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'), ${resolvedId || ''})">${displayDesc}</p>
                                    <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'), ${resolvedId || ''})"></i>
                                </div>
                                <small class="text-muted small mb-0">Created: ${new Date().toLocaleDateString()}</small>
                            </div>
                            <div class="text-end">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${resolvedId || ''})"></i>
                                    <span class="fw-bold" style="color:rgb(0,33,64)">${(createdDeal && createdDeal.status) || 'Active'}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    dealsContainer.prepend(div);

                    // Attach a hidden details area and prefetch its partial so details load immediately
                    try {
                        if (resolvedId) {
                            const details = document.createElement('div');
                            details.className = 'row deals-detail-area g-2 mt-2 d-none';
                            details.innerHTML = `<div data-vehicle-container="${resolvedId}"></div>`;
                            div.appendChild(details);
                            if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(resolvedId);
                        }
                    } catch(e) { /* ignore */ }

                    return;
                } catch (err) { console.error('Failed to insert created deal into DOM', err); }
            }

            // fallback: navigate to deal page
            const finalId = resolvedId || created.id;
            if (finalId) window.location.href = `/deals/${finalId}`;
            return;
        }

    } catch (error) {
        showToast('error', error.message || 'Failed to add vehicle / create deal');
    } finally {
        if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
        window._manualVehicleSubmitting = false;
    }
}

async function refreshVehiclePartial(dealId) {
    const vehicleContainer = document.getElementById('vehiclePartialContainer');
    if (!vehicleContainer) return;

    try {
        const response = await fetch(`/api/deals/${dealId}/vehicle-partial`);
        vehicleContainer.innerHTML = await response.text();
    } catch (error) {
        console.error('Failed to refresh vehicle partial:', error);
    }
}

if (typeof window.showToast !== 'function') {
    function showToast(type, message) {
        // Use your existing toast system, or create a simple one
        if (typeof toastr !== 'undefined') {
            if (typeof toastr[type] === 'function') {
                toastr[type](message);
                return;
            }
            toastr.success(message);
            return;
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type === 'error' ? 'error' : 'success',
                title: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        } else {
            alert(message);
        }
    }
}
</script>

<style>
.vehicle-card {
    transition: all 0.2s ease;
}
.vehicle-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: var(--bs-primary) !important;
}
.hover-shadow:hover {
    transform: translateY(-1px);
}


</style>