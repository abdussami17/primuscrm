<div class="tab-pane fade" id="mergesolddeals" role="tabpanel" aria-labelledby="mergesolddeals-tab">
    <div class="primus-crm-content-header">
        <h2 class="primus-crm-content-title">Merge Sold Deals</h2>
        <p class="primus-crm-content-description">Select exactly two deals to
            merge. After selection, you can choose which fields to keep from
            each deal.</p>
    </div>

    <!-- Instructions moved to top -->
    <div class="alert alert-info border-info mb-2">
        <div class="d-flex">
            <div class="me-2">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <strong>Instructions:</strong> Select exactly two deals to
                merge. After selection, you can choose which fields to keep from
                each deal.
                <strong>Important:</strong> The DMS ID # field determines which
                deal will be kept as the primary record. Typically, one deal has
                a DMS ID # (the correct lead) and the other is blank (merged
                into the one with DMS ID #).
            </div>
        </div>
    </div>

    <div class="primus-crm-settings-section">
        <h3 class="primus-crm-section-title">
            <span class="primus-crm-section-icon"><i class="fas fa-network-wired"></i></span>
            Merge Sold Deals
        </h3>

        <!-- Merge Button (Initially Disabled) -->
        <div class="d-flex justify-content-end">
            <button id="mergeBtn" class="btn btn-light border border-1 mb-2" disabled>
                <i class="fas fa-merge me-1"></i> Merge Deals
            </button>
        </div>

        
        <!-- Deals Table -->
        <div class="table-responsive table-nowrap">
            <table class="table border">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="selectAllCheckbox" class="form-check-input"></th>
                        <th>DMS ID #</th>
                        <th>Customer Info</th>

                        <th>Vehicle Info</th>
                        <th>Lead Type</th>
                        <th>Lead Status</th>
                        <th>Sales Status</th>
                    </tr>
                </thead>
                <tbody id="dealsBody">
                    <!-- Deals will be dynamically populated -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Removed duplicate modal: keeping the primary merge modal below -->





<!-- Dynamic Merge Comparison Modal (single source) -->
<div class="modal fade" id="mergeComparisonModal" tabindex="-1" aria-labelledby="mergeComparisonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="mergeComparisonModalLabel"><i class="fas fa-merge me-2"></i>Merge Deals - Select Fields</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info"><i class="fas fa-info-circle me-2"></i><strong>Instructions:</strong> Select which field values to keep in the merged deal by clicking the preferred option.</div>

                <div id="comparisonContent">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0" id="deal1Title">Deal 1</h6>
                                </div>
                                <div class="card-body">
                                    <div id="deal1CustomerSection" class="mb-3 p-2 border rounded bg-light"></div>
                                    <div id="deal1VehicleInfo" class="mb-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0" id="deal2Title">Deal 2</h6>
                                </div>
                                <div class="card-body">
                                    <div id="deal2CustomerSection" class="mb-3 p-2 border rounded bg-light"></div>
                                    <div id="deal2VehicleInfo" class="mb-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mb-4"><i class="fas fa-exclamation-triangle me-2"></i><strong>Important:</strong> The DMS ID # field determines which deal will be kept as the primary record.</div>

                    <div class="row mb-3">
                        <div class="col-md-2"><label class="form-label fw-bold">Field</label></div>
                        <div class="col-md-5 text-center"><label class="form-label fw-bold">Deal 1</label></div>
                        <div class="col-md-5 text-center"><label class="form-label fw-bold">Deal 2</label></div>
                    </div>

                    <div id="fieldsComparison" class="mb-4"></div>
                </div>

                <div id="loadingState" class="text-center py-5" style="display:none;">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    <p class="mt-3">Merging deals, please wait...</p>
                </div>

                <div id="successState" class="text-center py-5" style="display:none;">
                    <div class="mb-3"><i class="fas fa-check-circle text-success" style="font-size:4rem"></i></div>
                    <h4 class="text-success">Deals Merged Successfully!</h4>
                    <p>The selected deals have been merged into a single record.</p>
                    <button type="button" class="btn btn-success mt-2" data-bs-dismiss="modal"><i class="fas fa-check me-1"></i> Continue</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Cancel</button>
                <button type="button" id="confirmMergeBtn" class="btn btn-primary"><i class="fas fa-merge me-1"></i> Merge Selected Fields</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const dealsBody = document.getElementById('dealsBody');
    const selectAll = document.getElementById('selectAllCheckbox');
    const mergeBtn = document.getElementById('mergeBtn') || document.getElementById('mergeDealsBtn');

    const dealsList = [];
    const dealsMap = {};
    const selected = new Set();

    function escapeHtml(str) {
        if (!str && str !== 0) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    // build vehicle HTML (reusable) - shows "YEAR MAKE MODEL" and "Stock: ... | VIN: ..."
    function buildVehicleHtml(deal) {
        const vi = deal.vehicleInfo || deal.inventory || {};
        const year = vi.year || vi.inventory_year || deal.inventory_year || '';
        const make = vi.make || vi.inventory_make || deal.inventory_make || '';
        const model = vi.model || vi.inventory_model || deal.inventory_model || '';
        const stock = vi.stockNumber || vi.inventory_stock || vi.stock || deal.inventory_stock || '';
        const vin = vi.vin || vi.inventory_vin || vi.VIN || deal.inventory_vin || '';
        const title = [year, make, model].filter(Boolean).join(' ');
        const stockParts = [];
        if (stock) stockParts.push('Stock: ' + escapeHtml(stock));
        if (vin) stockParts.push('VIN: ' + escapeHtml(vin));
        const stockLine = stockParts.length ? `<div class="small text-muted">${stockParts.join(' | ')}</div>` : '';
        return `<div class="vehicle-info-box"><div class="fw-bold">${escapeHtml(title)}</div>${stockLine}</div>`;
    }

    async function loadDeals() {
        if (!dealsBody) return;
        dealsBody.innerHTML = '<tr><td colspan="7" class="text-center py-4">Loading...</td></tr>';
        try {
            const res = await fetch('/settings/merge-sold-deals/data', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Network response not ok');
            let payload = await res.json();
            let list = [];
            if (Array.isArray(payload)) list = payload;
            else if (Array.isArray(payload.data)) list = payload.data;
            else if (Array.isArray(payload.deals)) list = payload.deals;

            dealsList.length = 0;
            list.forEach(d => { dealsList.push(d); dealsMap[d.id] = d; });

            if (!dealsList.length) {
                dealsBody.innerHTML = '<tr><td colspan="7" class="text-center py-4">No deals found.</td></tr>';
                return;
            }

            dealsBody.innerHTML = dealsList.map(deal => {
                const dms = escapeHtml(deal.deal_number || deal.dms_id || deal.dmsNumber || '');
                // customer block with lines
                const custName = escapeHtml(deal.customer_name || deal.customerName || '');
                const physical = escapeHtml(deal.physical_address || deal.physicalAddress || '');
                const mobile = escapeHtml(deal.customer_cell || deal.mobileNumber || deal.customer_phone || '');
                const home = escapeHtml(deal.homeNumber || deal.home_number || '');
                const work = escapeHtml(deal.workNumber || deal.work_number || '');
                const email = escapeHtml(deal.customer_email || deal.email || deal.customerEmail || '');
                const customerHtml = `
                    <div class="customer-info-box">
                        <div class="fw-bold">${custName}</div>
                        <div class="small text-muted">${physical}</div>
                        ${mobile?`<div class="small">Mobile: ${mobile}</div>`:''}
                        ${home?`<div class="small">Home: ${home}</div>`:''}
                        ${work?`<div class="small">Work: ${work}</div>`:''}
                        ${email?`<div class="small">Email: ${email}</div>`:''}
                    </div>`;

                // vehicle info using reusable helper
                const vehicleHtml = buildVehicleHtml(deal);

                const leadType = escapeHtml(deal.lead_type || deal.leadType || '');
                const leadStatus = escapeHtml(deal.lead_status || deal.status || '');
                const salesStatus = escapeHtml(deal.sales_status || deal.salesStatus || deal.status || '');

                return `
                    <tr>
                        <td><input type="checkbox" class="form-check-input deal-checkbox" data-id="${deal.id}"></td>
                        <td>${dms}</td>
                        <td>${customerHtml}</td>
                        <td>${vehicleHtml}</td>
                        <td>${leadType}</td>
                        <td>${leadStatus}</td>
                        <td>${salesStatus}</td>
                    </tr>`;
            }).join('');

            document.querySelectorAll('.deal-checkbox').forEach(cb => cb.addEventListener('change', onCheckboxChange));
            if (selectAll) selectAll.checked = false;
            updateMergeState();
        } catch (err) {
            console.error(err);
            dealsBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4">Error loading deals</td></tr>';
        }
    }

    function onCheckboxChange(e) {
        const id = e.target.dataset.id;
        if (!id) return;
        if (e.target.checked) selected.add(Number(id)); else selected.delete(Number(id));
        if (selectAll) {
            const all = Array.from(document.querySelectorAll('.deal-checkbox'));
            selectAll.checked = all.length > 0 && all.every(b => b.checked);
        }
        updateMergeState();
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.deal-checkbox').forEach(cb => {
                cb.checked = checked;
                cb.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
    }

    function updateMergeState() {
        if (!mergeBtn) return;
        mergeBtn.disabled = selected.size !== 2;
        if (!mergeBtn.disabled) mergeBtn.classList.add('btn-primary','text-white'); else mergeBtn.classList.remove('btn-primary','text-white');
    }

    function clearExtraBackdrops() {
        // remove any stray backdrops that cause persistent blur
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        // ensure body isn't left with modal-open or extra padding
        document.body.classList.remove('modal-open');
        try { document.body.style.removeProperty('padding-right'); } catch(e) {}
        // if any other modal is visible, hide it (safety)
        document.querySelectorAll('.modal.show').forEach(el => {
            if (el.id !== 'mergeComparisonModal') {
                el.classList.remove('show');
                el.setAttribute('aria-hidden', 'true');
                el.style.display = 'none';
            }
        });
    }

    function buildComparisonModal(dealA, dealB) {
        // Titles
        document.getElementById('deal1Title').textContent = `${dealA.deal_number || dealA.dmsNumber || dealA.dms_id || ''} - ${dealA.customer_name || dealA.customerName || ''}`;
        document.getElementById('deal2Title').textContent = `${dealB.deal_number || dealB.dmsNumber || dealB.dms_id || ''} - ${dealB.customer_name || dealB.customerName || ''}`;

        // Customer sections - show name, address, mobile/home/work/email
        function buildCustomerHtml(deal) {
            const name = escapeHtml(deal.customer_name || deal.customerName || '');
            const address = escapeHtml(deal.physical_address || deal.physicalAddress || '');
            const mobile = escapeHtml(deal.customer_cell || deal.mobileNumber || deal.customer_phone || '');
            const home = escapeHtml(deal.homeNumber || deal.home_number || '');
            const work = escapeHtml(deal.workNumber || deal.work_number || '');
            const email = escapeHtml(deal.customer_email || deal.email || deal.customerEmail || '');
            return `
                <div class="customer-info-display mb-2">
                    <div class="fw-bold">${name}</div>
                    <div class="small text-muted">${address}</div>
                    ${mobile?`<div class="small">Mobile: ${mobile}</div>`:''}
                    ${home?`<div class="small">Home: ${home}</div>`:''}
                    ${work?`<div class="small">Work: ${work}</div>`:''}
                    ${email?`<div class="small">Email: ${email}</div>`:''}
                </div>
                <div class="dms-id-display mt-2 pt-2 border-top"><div class="small fw-bold">DMS ID #:</div><div class="fw-bold">${escapeHtml(deal.deal_number || deal.dmsNumber || deal.dms_id || 'No DMS ID')}</div></div>`;
        }

        document.getElementById('deal1CustomerSection').innerHTML = buildCustomerHtml(dealA);
        document.getElementById('deal2CustomerSection').innerHTML = buildCustomerHtml(dealB);

        // Vehicle info - use global helper
        document.getElementById('deal1VehicleInfo').innerHTML = buildVehicleHtml(dealA);
        document.getElementById('deal2VehicleInfo').innerHTML = buildVehicleHtml(dealB);

        // Build comparison fields
        const fieldsComparison = document.getElementById('fieldsComparison');
        fieldsComparison.innerHTML = '';
        const fields = [
            { key: 'dmsNumber', label: 'DMS ID #' },
            { key: 'vehicleInfo', label: 'Vehicle Information' },
            { key: 'leadType', label: 'Lead Type' },
            { key: 'source', label: 'Source' },
            { key: 'salesType', label: 'Sales Type' },
            { key: 'dealType', label: 'Deal Type' },
            { key: 'inventoryType', label: 'Inventory Type' },
            { key: 'leadStatus', label: 'Lead Status' },
            { key: 'salesStatus', label: 'Sales Status' }
        ];

        fields.forEach(field => {
            const row = document.createElement('div');
            row.className = 'row align-items-center mb-3 pb-2 border-bottom';

            let valA = 'N/A';
            let valB = 'N/A';

            if (field.key === 'dmsNumber') {
                valA = dealA.deal_number || dealA.dmsNumber || dealA.dms_id || 'No DMS ID';
                valB = dealB.deal_number || dealB.dmsNumber || dealB.dms_id || 'No DMS ID';
                row.innerHTML = `
                    <div class="col-md-2"><label class="form-label fw-bold">${field.label}</label></div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal1" value="deal1" checked>
                            <label class="form-check-label w-100" for="${field.key}_deal1"><div class="p-2 border rounded bg-light">${escapeHtml(valA)}</div></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal2" value="deal2">
                            <label class="form-check-label w-100" for="${field.key}_deal2"><div class="p-2 border rounded bg-light">${escapeHtml(valB)}</div></label>
                        </div>
                    </div>`;
            } else if (field.key === 'vehicleInfo') {
                valA = `${dealA.inventory_year||dealA.vehicle_year||''} ${dealA.inventory_make||dealA.vehicle_make||''} ${dealA.inventory_model||dealA.vehicle_model||''}`.trim() || 'N/A';
                valB = `${dealB.inventory_year||dealB.vehicle_year||''} ${dealB.inventory_make||dealB.vehicle_make||''} ${dealB.inventory_model||dealB.vehicle_model||''}`.trim() || 'N/A';
                row.innerHTML = `
                    <div class="col-md-2"><label class="form-label fw-bold">${field.label}</label></div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal1" value="deal1" checked>
                            <label class="form-check-label w-100" for="${field.key}_deal1"><div class="p-2 border rounded bg-light">${escapeHtml(valA)}</div></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal2" value="deal2">
                            <label class="form-check-label w-100" for="${field.key}_deal2"><div class="p-2 border rounded bg-light">${escapeHtml(valB)}</div></label>
                        </div>
                    </div>`;
            } else {
                valA = dealA[field.key] || dealA[field.key.replace(/([A-Z])/g, '_$1').toLowerCase()] || 'N/A';
                valB = dealB[field.key] || dealB[field.key.replace(/([A-Z])/g, '_$1').toLowerCase()] || 'N/A';
                row.innerHTML = `
                    <div class="col-md-2"><label class="form-label fw-bold">${field.label}</label></div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal1" value="deal1" checked>
                            <label class="form-check-label w-100" for="${field.key}_deal1"><div class="p-2 border rounded bg-light">${escapeHtml(valA)}</div></label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${field.key}" id="${field.key}_deal2" value="deal2">
                            <label class="form-check-label w-100" for="${field.key}_deal2"><div class="p-2 border rounded bg-light">${escapeHtml(valB)}</div></label>
                        </div>
                    </div>`;
            }

            fieldsComparison.appendChild(row);
        });
    }

    // Show modal for selected deals
    function showComparisonModal() {
        if (selected.size !== 2) return;
        const ids = Array.from(selected);
        const dealA = dealsMap[ids[0]];
        const dealB = dealsMap[ids[1]];
        if (!dealA || !dealB) return;
        // Clean duplicate backdrops/modals before showing
        clearExtraBackdrops();
        document.querySelectorAll('#mergeComparisonModal').forEach((el, idx) => {
            // keep the first occurrence (this one), remove others
            if (el !== document.getElementById('mergeComparisonModal')) {
                el.remove();
            }
        });

        buildComparisonModal(dealA, dealB);
        const modalEl = document.getElementById('mergeComparisonModal');
        if (!modalEl) return;

        // Ensure modal is a child of body to avoid stacking-context issues
        try {
            if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl);
        } catch (e) {}

        // Create a single clean backdrop and attach it under the modal
        function createBackdrop(zIndex) {
            // remove all existing backdrops first
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            const bd = document.createElement('div');
            bd.classList.add('modal-backdrop', 'fade', 'show');
            bd.style.zIndex = (zIndex - 5).toString();
            document.body.appendChild(bd);
            return bd;
        }

        const modalZ = 2005;
        // set body modal-open to allow scroll locking
        document.body.classList.add('modal-open');

        // Hide other visible modals (best-effort)
        document.querySelectorAll('.modal.show').forEach(other => {
            if (other === modalEl) return;
            try { other.classList.remove('show'); other.style.display = 'none'; other.setAttribute('aria-hidden', 'true'); } catch(e){}
        });

        // create backdrop and set z-indexes
        const backdropEl = createBackdrop(modalZ);
        modalEl.style.zIndex = modalZ.toString();

        // store current selection and deal snapshots on modal for reliability
        try {
            modalEl.dataset.selectedIds = JSON.stringify(Array.from(selected));
            modalEl.dataset.dealA = JSON.stringify(dealA);
            modalEl.dataset.dealB = JSON.stringify(dealB);
        } catch(e) {}

        // show via bootstrap if available, otherwise fallback
        if (window.bootstrap && typeof window.bootstrap.Modal === 'function') {
            const bs = new bootstrap.Modal(modalEl, { backdrop: false });
            bs.show();
            // ensure focus
            setTimeout(() => modalEl.focus(), 40);

            // on hide cleanup
            modalEl.addEventListener('hidden.bs.modal', function cleanup() {
                try { backdropEl.remove(); } catch(e) {}
                document.body.classList.remove('modal-open');
                try { document.body.style.removeProperty('padding-right'); } catch(e) {}
                modalEl.style.zIndex = '';
                modalEl.removeEventListener('hidden.bs.modal', cleanup);
            });
        } else {
            // fallback display
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
            modalEl.setAttribute('aria-hidden', 'false');
            setTimeout(() => modalEl.focus(), 40);
            // cleanup when clicking modal close buttons
            modalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => btn.addEventListener('click', () => {
                try { backdropEl.remove(); } catch(e) {}
                document.body.classList.remove('modal-open');
                modalEl.classList.remove('show');
                modalEl.style.display = 'none';
            }));
        }
    }

    // Confirm merge: collect selections and POST to server
    document.getElementById('confirmMergeBtn').addEventListener('click', async function () {
        const btn = this;
        const comparisonContent = document.getElementById('comparisonContent');
        const loadingState = document.getElementById('loadingState');
        const successState = document.getElementById('successState');
        const fieldsComparison = document.getElementById('fieldsComparison');

        if (!fieldsComparison) return;

        // prefer live checked checkboxes, fallback to Set or modal-stored selection
        let ids = Array.from(document.querySelectorAll('.deal-checkbox:checked')).map(cb => Number(cb.dataset.id));
        if (ids.length !== 2) {
            ids = Array.from(selected);
        }
        if (ids.length !== 2) {
            try {
                const modalEl = document.getElementById('mergeComparisonModal');
                const stored = modalEl?.dataset?.selectedIds ? JSON.parse(modalEl.dataset.selectedIds) : null;
                if (Array.isArray(stored)) ids = stored.map(Number);
            } catch (e) { console.error('failed to parse stored selection', e); }
        }

        console.debug('Confirm merge - live checked count:', document.querySelectorAll('.deal-checkbox:checked').length, 'Set size:', selected.size, 'final ids:', ids);

        if (ids.length !== 2) {
            alert('Please select exactly two deals to merge.');
            return;
        }

        // collect chosen radios
        const fieldChoices = {};
        fieldsComparison.querySelectorAll('input[type="radio"]:checked').forEach(r => {
            fieldChoices[r.name] = r.value; // 'deal1' or 'deal2'
        });

        // helper to resolve actual value for a key from a deal object
        function resolveValue(deal, key) {
            if (!deal) return null;
            if (key === 'dmsNumber') return deal.deal_number || deal.dmsNumber || deal.dms_id || null;
            if (key === 'vehicleInfo') return (deal.vehicle || `${deal.inventory_year||''} ${deal.inventory_make||''} ${deal.inventory_model||''}`).trim() || null;
            // try direct key then snake_case fallback
            if (deal[key] !== undefined && deal[key] !== null) return deal[key];
            const snake = key.replace(/([A-Z])/g, '_$1').toLowerCase();
            if (deal[snake] !== undefined && deal[snake] !== null) return deal[snake];
            return null;
        }

        // build merged_values based on choices
        const merged_values = {};
        let dealA = dealsMap[ids[0]];
        let dealB = dealsMap[ids[1]];
        // fallback to modal-stored snapshots if map lookup fails
        if ((!dealA || !dealB) && document.getElementById('mergeComparisonModal')) {
            try {
                const modalEl = document.getElementById('mergeComparisonModal');
                if (!dealA && modalEl.dataset.dealA) dealA = JSON.parse(modalEl.dataset.dealA);
                if (!dealB && modalEl.dataset.dealB) dealB = JSON.parse(modalEl.dataset.dealB);
            } catch (e) { console.error('failed to parse modal deals', e); }
        }
        Object.keys(fieldChoices).forEach(k => {
            const choice = fieldChoices[k];
            merged_values[k] = choice === 'deal1' ? resolveValue(dealA, k) : resolveValue(dealB, k);
        });

        // also populate explicit customer and vehicle fields to avoid nulls
        const customer_fields = ['customer_name','physical_address','customer_cell','customer_phone','customer_email'];
        customer_fields.forEach(f => {
            if (!(f in merged_values)) {
                const val = (merged_values[f] = (dealA[f] || dealA[f.replace(/([A-Z])/g,'_$1').toLowerCase()] || dealB[f] || dealB[f.replace(/([A-Z])/g,'_$1').toLowerCase()] || null));
                if (val) merged_values[f] = val;
            }
        });
        const vehicle_fields = ['inventory_year','inventory_make','inventory_model','inventory_stock','inventory_vin','vehicle'];
        vehicle_fields.forEach(f => {
            if (!(f in merged_values)) {
                const val = (merged_values[f] = (dealA[f] || dealA[f.replace(/([A-Z])/g,'_$1').toLowerCase()] || dealB[f] || dealB[f.replace(/([A-Z])/g,'_$1').toLowerCase()] || null));
                if (val) merged_values[f] = val;
            }
        });

        // determine left/right ids (prefer the one with a DMS ID as left/primary)
        let leftId = ids[0];
        let rightId = ids[1];
        try {
            const aHas = !!(dealA.deal_number || dealA.dmsNumber || dealA.dms_id);
            const bHas = !!(dealB.deal_number || dealB.dmsNumber || dealB.dms_id);
            if (bHas && !aHas) { leftId = ids[1]; rightId = ids[0]; }
        } catch (e) {}

        // build selected_fields expected by server: map of field -> 'left'|'right'
        const selected_fields = {};
        Object.keys(fieldChoices).forEach(k => {
            selected_fields[k] = fieldChoices[k] === 'deal1' ? 'left' : 'right';
        });

        // only include merged_values for keys that resolve to non-null
        const merged_values_nonnull = {};
        Object.keys(merged_values).forEach(k => {
            if (merged_values[k] !== null && merged_values[k] !== undefined) merged_values_nonnull[k] = merged_values[k];
        });

        const payload = {
            left_id: leftId,
            right_id: rightId,
            selected_fields: selected_fields,
            merged_values: merged_values_nonnull
        };

        console.debug('Merge payload', payload);

        // Prevent duplicate submits immediately
        if (btn.dataset.merging === '1') return;
        btn.dataset.merging = '1';
        // UI
        btn.disabled = true;
        if (comparisonContent) comparisonContent.style.display = 'none';
        if (loadingState) loadingState.style.display = 'block';

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch('/settings/merge-sold-deals/merge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });


            const text = await res.text();
            let data = {};
            try { data = JSON.parse(text); } catch(e) { data = { message: text }; }

            if (!res.ok) {
                // surface validation errors if present
                const msg = data?.message || ('HTTP ' + res.status);
                if (data?.errors) {
                    const errs = Object.values(data.errors).flat().join('\n');
                    throw new Error(msg + ' - ' + errs);
                }
                throw new Error(msg);
            }

            // show success
            if (loadingState) loadingState.style.display = 'none';
            if (successState) successState.style.display = 'block';
            btn.style.display = 'none';

            // refresh deals list and close modal after short delay
            setTimeout(() => {
                loadDeals();
                const modalEl = document.getElementById('mergeComparisonModal');
                if (modalEl && window.bootstrap && typeof bootstrap.Modal === 'function') {
                    const inst = bootstrap.Modal.getInstance(modalEl);
                    if (inst) inst.hide();
                } else if (modalEl) {
                    modalEl.classList.remove('show'); modalEl.style.display = 'none';
                }
            }, 900);

        } catch (err) {
            console.error('Merge request failed', err);
            if (loadingState) loadingState.style.display = 'none';
            if (comparisonContent) comparisonContent.style.display = 'block';
            btn.disabled = false;
            try { btn.dataset.merging = '0'; } catch(e){}
            alert('Merge failed: ' + (err.message || 'Unknown error'));
        }
    });

    // Wire merge button
    if (mergeBtn) {
        mergeBtn.addEventListener('click', function () {
            if (selected.size !== 2) return;
            showComparisonModal();
        });
    }

    // Initial load
    loadDeals();
});
</script>
