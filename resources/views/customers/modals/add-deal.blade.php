{{-- Add Deal Modal - resources/views/customers/modals/add-deal.blade.php --}}

@props(['customerId', 'users' => []])

<div id="addDealModal" class="modal fade" style="z-index:9999!important;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Deal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDealForm" action="{{ route('deals.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customerId }}">
                    <input type="hidden" name="inventory_id" id="dealInventoryId">
                    
                    <div class="border rounded p-3 bg-light mb-3">
                        <label class="form-label fw-semibold">Selected Vehicle</label>
                        <p class="mb-0 text-success fw-semibold" id="selectedVehicleDisplay">No vehicle selected</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Deal Number</label>
                            <input type="text" class="form-control" name="deal_number" placeholder="Auto-generated">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                @foreach(['Active', 'Pending F&I', 'Sold', 'Delivered', 'Lost'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lead Type</label>
                            <select class="form-select" name="lead_type">
                                <option value="">Select</option>
                                @foreach(['Walk-In', 'Phone', 'Internet', 'Referral'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inventory Type</label>
                            <select class="form-select" name="inventory_type">
                                <option value="">Select</option>
                                @foreach(['New', 'Used', 'CPO'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Deal Type</label>
                            <select class="form-select" name="deal_type">
                                @foreach(['cash' => 'Cash', 'lease' => 'Lease', 'finance' => 'Finance', 'unknown' => 'Unknown'] as $value => $label)
                                <option value="{{ $value }}" {{ $value === 'unknown' ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Vehicle Description</label>
                            <input type="text" class="form-control" name="vehicle_description" id="dealVehicleDescription">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="dealPrice">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Down Payment</label>
                            <input type="number" step="0.01" class="form-control" name="down_payment">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trade-In Value</label>
                            <input type="number" step="0.01" class="form-control" name="trade_in_value">
                        </div>
                        @foreach(['sales_person_id' => 'Sales Person', 'sales_manager_id' => 'Sales Manager', 'finance_manager_id' => 'Finance Manager'] as $field => $label)
                        <div class="col-md-4">
                            <label class="form-label">{{ $label }}</label>
                            <select class="form-select" name="{{ $field }}">
                                <option value="">Select</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button id="addDealSubmitBtn" type="submit" class="btn btn-primary">Save Deal</button>
            </div>
                </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

    function attachAddDealHandler() {
        const form = document.getElementById('addDealForm');
        if (!form) { console.debug('addDealForm not found when attaching handler'); return; }
        console.debug('Attaching addDealForm submit handler');
        form.removeEventListener('submit', window._addDealFormHandler);
        window._addDealFormHandler = async function(e) {
            console.debug('addDealForm submit triggered', { eventTarget: e.target && e.target.id });
            e.preventDefault();
            await doAddDealSubmit(form);
        };
        form.addEventListener('submit', window._addDealFormHandler);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachAddDealHandler);
    } else {
        attachAddDealHandler();
    }
    // Core submit logic factored so it can be called from delegated fallback
    async function doAddDealSubmit(formEl) {
        if (!formEl) return;
        if (window._addDealSubmitting) {
            console.warn('addDealForm: duplicate submit prevented');
            return;
        }
        window._addDealSubmitting = true;
        const submitBtn = document.getElementById('addDealSubmitBtn');
        const originalText = submitBtn ? submitBtn.innerHTML : null;
        if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...'; }

        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        if (!data.deal_number) data.deal_number = 'DL-' + Date.now();

        try {
            if (typeof api !== 'function') {
                console.error('API helper not available: cannot submit addDealForm');
                throw new Error('API helper not available');
            }
            const created = await api('/api/deals', 'POST', data);
            showToast('Deal created successfully');

            // Robustly close modal (try several approaches)
            try {
                const modalEl = document.getElementById('addDealModal');
                if (modalEl) {
                    try {
                        const inst = (typeof bootstrap.Modal.getInstance === 'function') ? bootstrap.Modal.getInstance(modalEl) : null;
                        if (inst && typeof inst.hide === 'function') inst.hide();
                        else if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                            bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                        } else {
                            modalEl.classList.remove('show'); modalEl.style.display = 'none';
                        }
                    } catch (e) {
                        modalEl.classList.remove('show'); modalEl.style.display = 'none';
                    }
                }
            } catch (e) { console.warn('Failed to close addDealModal via JS', e); }

            // Remove any backdrops and body modal class
            try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
            try { document.body.classList.remove('modal-open'); } catch(e){}

            // Refresh deals section: fetch and support JSON or HTML response
            try {
                const maybeId = created?.id || created?.data?.id || created?.deal?.id || null;
                    // If we have the newly created deal ID, ensure it has a details area and prefetch its partial
                    try {
                        if (maybeId) {
                const customerId = formEl.querySelector('input[name="customer_id"]')?.value || document.getElementById('customerId')?.value || null;
                const dealsContainer = document.getElementById('dealsContainer');
                if (dealsContainer && customerId) {
                    const res = await fetch(`/api/customers/${customerId}/deals`);
                    if (res.ok) {
                        const ct = (res.headers.get('content-type') || '').toLowerCase();
                        if (ct.includes('application/json')) {
                            const json = await res.json().catch(() => null);
                            if (json) {
                                const deals = json.deals || json.data || [];
                                if (Array.isArray(deals)) {
                                    dealsContainer.innerHTML = deals.map(deal => `
                                        <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="${deal.id}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="d-flex align-items-center">
                                                        <p class="deal-vehicle-name fw-semibold mb-0 ${ (deal.vehicle_description || '').trim() === 'No Vehicle Entered' ? 'text-danger' : '' }" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})">${deal.vehicle_description || 'Added Manually Vehicle'}</p>
                                                        <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})"></i>
                                                    </div>
                                                    <small class="text-muted small mb-0">Created: ${new Date(deal.created_at).toLocaleDateString()}</small>
                                                </div>
                                                <div class="text-end">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${deal.id})"></i>
                                                        <span class="fw-bold" style="color:rgb(0,33,64)">${deal.status || ''}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `).join('');
                                }
                            }
                        } else {
                            // If HTML, inject directly
                            const text = await res.text();
                            if (text && text.trim()) dealsContainer.innerHTML = text;
                        }
                    }
                }
            } catch (err) { console.warn('Failed to refresh deals after create', err); }

            // Reset form
            try { formEl.reset(); } catch(e){}
        } catch (error) {
            console.error('addDealForm submit error', error);
            showToast(error.message || 'Failed to create deal', 'error');
        } finally {
            if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
            window._addDealSubmitting = false;
        }
    }

    // Ensure button triggers the submit logic directly (single guarded call)
    try {
        const addBtn = document.getElementById('addDealSubmitBtn');
                                                        const newDealEl = dealsContainer.querySelector(`[data-deal-id="${maybeId}"]`);
                                                        if (newDealEl) {
                                                            const details = document.createElement('div');
                                                            details.className = 'row deals-detail-area g-2 mt-2 d-none';
                                                            details.innerHTML = `<div data-vehicle-container="${maybeId}"></div>`;
                                                            newDealEl.appendChild(details);
                                                            if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(maybeId);
                                                        }
                                                    }
        if (addBtn && !addBtn._directAttached) {
            addBtn._directAttached = true;
            addBtn.addEventListener('click', function(ev) {
                try {
                    ev.preventDefault();
                    const form = document.getElementById('addDealForm');
                    console.debug('Add Deal direct click handler invoked', { formExists: !!form });
                    if (!form) return;
                    // Directly call the shared submit routine to avoid triggering multiple submit listeners
                    doAddDealSubmit(form);
                } catch(err) { console.error('Add Deal direct click handler error', err); }
            });
        }
    } catch(e) { console.warn('Failed to attach direct addDeal button handler', e); }
    // Ensure submit button triggers the form programmatically in all cases
    function ensureAddDealButtonTriggers() {
        const btn = document.getElementById('addDealSubmitBtn');
        const form = document.getElementById('addDealForm');
        if (!btn || !form) return;
        // prevent duplicate registrations
        if (btn._attached) return; btn._attached = true;
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            try {
                if (typeof form.requestSubmit === 'function') return form.requestSubmit();
            } catch (e) {}
            // fallback
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        });
    }

    
</script>