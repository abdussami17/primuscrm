{{-- Availability / Hold Details Modal --}}
<div id="availabilityModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                Vehicle Inventory Details
                <button type="button" data-bs-dismiss="modal">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>

            <div class="modal-body pt-1">
                {{-- Vehicle Info Card --}}
                <div class="col-md-12 mb-2">
                    <div class="card bg-light border">
                        <div class="card-body py-2 px-3">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <small class="text-muted">Vehicle</small>
                                    <div class="fw-semibold" id="modalVehicleName">-</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Stock #</small>
                                    <div class="fw-semibold" id="modalStockNumber">-</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">VIN</small>
                                    <div class="fw-semibold" id="modalVin">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Interested Customers List --}}
                <div class="col-md-12 mb-2">
                    <label class="form-label fw-semibold">
                        Interested Customers (<span id="customerCount">0</span>)
                    </label>
                    <div id="customersList" class="border rounded p-2" style="max-height: 280px; overflow-y: auto; background: #fafafa;">
                        <div class="text-center text-muted py-3">
                            Loading customers...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Exit Confirmation Modal --}}
<div id="confirmExitModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="isax isax-warning-2 text-warning" style="font-size: 3rem;"></i>
                <h5 class="mt-3 mb-2">Unsaved Changes</h5>
                <p class="text-muted">Are you sure you want to exit without saving?</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button id="confirmExitNo" class="btn btn-sm btn-secondary">No, Go Back</button>
                    <button id="confirmExitYes" class="btn btn-sm btn-danger">Yes, Exit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.customer-item {
    padding: 10px;
    background: white;
    border-radius: 4px;
    margin-bottom: 8px;
    border: 1px solid #dee2e6;
    cursor: pointer;
    transition: all 0.2s;
}
.customer-item:hover {
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    border-color: var(--cf-primary);
}
.customer-name {
    color: var(--cf-primary);
    font-weight: 700;
    text-decoration: none;
}
.customer-name:hover {
    text-decoration: underline;
}
</style>

@push('scripts')
<script>
// Load availability details into the modal and show it
async function loadAvailabilityModal(inventoryId) {
    if (!inventoryId) return;
    const modalEl = document.getElementById('availabilityModal');
    const vehicleNameEl = document.getElementById('modalVehicleName');
    const stockEl = document.getElementById('modalStockNumber');
    const vinEl = document.getElementById('modalVin');
    const customersList = document.getElementById('customersList');
    const countEl = document.getElementById('customerCount');

    if (!customersList) return;

    // show loading state
    customersList.innerHTML = '<div class="text-center text-muted py-3">Loading customers...</div>';
    countEl.textContent = '0';

    try {
        const res = await fetch(`/api/inventory/${encodeURIComponent(inventoryId)}/availability`, { credentials: 'same-origin' });
        if (!res.ok) throw new Error('Failed to fetch availability');
        const json = await res.json();

        // populate top vehicle info
        if (json.vehicle) {
            vehicleNameEl.textContent = json.vehicle.name || '-';
            stockEl.textContent = json.vehicle.stock_number || '-';
            vinEl.textContent = json.vehicle.vin || '-';
        }

        const list = Array.isArray(json.customers) ? json.customers : [];
        if (list.length === 0) {
            customersList.innerHTML = '<div class="text-center text-muted py-3">No interested customers found.</div>';
            countEl.textContent = '0';
        } else {
            countEl.textContent = String(list.length);
            customersList.innerHTML = '';
            list.forEach(c => {
                const item = document.createElement('div');
                item.className = 'customer-item d-flex align-items-center justify-content-between';
                item.innerHTML = `
                    <div>
                        <a href="javascript:void(0)" class="customer-name" data-customer-id="${c.id}">${escapeHtml(c.name)}</a>
                        <div class="text-muted small">${escapeHtml(c.assigned_to || '')}</div>
                    </div>
                    <div class="text-end small text-muted">
                        ${c.hold_date ? escapeHtml(c.hold_date + ' ' + (c.hold_time || '')) : ''}
                    </div>`;
                customersList.appendChild(item);
            });
        }

        // show modal
        try {
            const inst = new bootstrap.Modal(modalEl);
            inst.show();
        } catch (e) { console.warn('Failed to show availability modal', e); }
    } catch (err) {
        console.error('loadAvailabilityModal error', err);
        customersList.innerHTML = '<div class="text-center text-danger py-3">Failed to load customers.</div>';
    }
}

// delegate click on customer names to open the global customer offcanvas
document.addEventListener('click', function(e){
    const a = e.target.closest && e.target.closest('.customer-name');
    if (!a) return;
    const id = a.getAttribute('data-customer-id');
    if (!id) return;
    // call global function to open customer profile
    try { if (typeof openCustomerProfile === 'function') openCustomerProfile(id); else window.openCustomerProfile?.(id); } catch (err) { console.error(err); }
}, true);

function escapeHtml(str) {
    if (!str && str !== 0) return '';
    return String(str).replace(/[&<>\"']/g, function (s) {
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[s]);
    });
}
</script>
@endpush