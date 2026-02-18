{{-- Inventory Modal - resources/views/customers/modals/inventory.blade.php --}}

@props(['customerId'])

<div id="gotoinventoryModal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      {{-- HEADER --}}
      <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
        <span id="inventoryModalTitle">Add Vehicle</span>
        <button type="button" data-bs-dismiss="modal" aria-label="Close">
          <i class="isax isax-close-circle"></i>
        </button>
      </div>

      {{-- BODY --}}
      <div class="modal-body pt-1">
        {{-- Hidden field to track if we're editing an existing deal --}}
        <input type="hidden" id="inventoryEditDealId" value="">
        {{-- Hidden field to track which customer the modal was opened for --}}
        <input type="hidden" id="inventoryModalCustomerId" value="{{ $customerId ?? '' }}">

        <input type="text" placeholder="Search" class="form-control" id="inventorySearchInput">

        <div class="mt-3">
          <div class="d-flex justify-content-between align-items-center">
            <p class="vehicle-search-record_text mb-0" id="inventoryCount">
              Loading...
            </p>
            <div>
              <button type="button" id="skipVehicleBtn" class="btn me-1 mb-1 btn-danger">
                Skip adding vehicle for now
              </button>
              <button type="button" class="btn btn-primary mb-1" onclick="openManualVehicleFormFromInventory()">
                Not in Stock? Add Manually
              </button>
            </div>
          </div>

          {{-- INVENTORY LIST --}}
          <div class="go-to-inventory mt-2 d-flex flex-column gap-3"
               id="inventoryList"
               style="max-height:400px;overflow-y:auto;">
            <div class="text-center py-4">
              <div class="spinner-border text-primary"></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
(function() {
  // Clean up any stale backdrops on load
  document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

  const inventoryModalEl = document.getElementById('gotoinventoryModal');
  if (!inventoryModalEl) return;

  // Load inventory on page load
  loadInventory();

  // Handle modal show event
  inventoryModalEl.addEventListener('show.bs.modal', function(event) {
    const triggerButton = event.relatedTarget;
    const dealId = triggerButton?.getAttribute('data-deal-id') || '';
    
    // If a data-deal-id was explicitly provided by the trigger, respect it (edit mode)
    document.getElementById('inventoryEditDealId').value = dealId;

    // If no explicit dealId provided but a deal is currently selected in AppState,
    // mark modal as opened for attaching vehicle to current deal (Vehicles Of Interest flow)
    if (!dealId && window.AppState && window.AppState.currentDealId) {
      window.inventoryOpenedForInterest = true;
    } else {
      window.inventoryOpenedForInterest = false;
    }

    // Capture which customer this modal was opened for (from the trigger or its nearest ancestor)
    try {
      const modalCustomerField = document.getElementById('inventoryModalCustomerId');
      const fromTrigger = triggerButton?.getAttribute('data-customer-id') || triggerButton?.closest('[data-customer-id]')?.dataset?.customerId;
      if (modalCustomerField) modalCustomerField.value = fromTrigger || (window.AppState && window.AppState.customerId) || '';
    } catch(e) { /* ignore */ }

    const isEditMode = !!dealId;
    document.getElementById('inventoryModalTitle').textContent = 
      isEditMode ? 'Select Vehicle for Deal' : 'Add Vehicle';
    document.getElementById('skipVehicleBtn').style.display = 
      isEditMode ? 'none' : 'inline-block';

    loadInventory();
  });

  // Handle modal hidden - clean up backdrops
  inventoryModalEl.addEventListener('hidden.bs.modal', function() {
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('padding-right');
    document.body.style.removeProperty('overflow');
  });

  // Search with debounce
  let searchTimeout;
  document.getElementById('inventorySearchInput')?.addEventListener('input', e => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => searchInventory(e.target.value), 300);
  });
})();

async function loadInventory() {
  const container = document.getElementById('inventoryList');
  if (!container) return;
  
  container.innerHTML = `<div class="text-center py-4">
    <div class="spinner-border text-primary"></div>
  </div>`;

  try {
    const result = await api('/api/inventory');
    renderInventoryItems(result.data || []);
  } catch (err) {
    container.innerHTML = `<p class="text-danger text-center">Failed to load inventory</p>`;
  }
}

async function searchInventory(query) {
  if (!query.trim()) return loadInventory();

  try {
    const result = await api(`/api/inventory/search?search=${encodeURIComponent(query)}`);
    renderInventoryItems(result.data || []);
  } catch (err) {
    console.error('Search failed:', err);
  }
}

// Helper: prefer the explicit customer id captured when opening the modal,
// otherwise fall back to the page's `[data-customer-id]` or AppState.
function getInventoryModalCustomerId() {
  try {
    const hidden = document.getElementById('inventoryModalCustomerId');
    const fromHidden = hidden && hidden.value ? hidden.value : null;
    if (fromHidden) return fromHidden;
  } catch(e) {}

  try {
    const el = document.querySelector('[data-customer-id]');
    if (el && el.dataset && el.dataset.customerId) return el.dataset.customerId;
  } catch(e) {}

  return (window.AppState && window.AppState.customerId) || null;
}

function renderInventoryItems(items) {
  const container = document.getElementById('inventoryList');
  const countEl = document.getElementById('inventoryCount');

  if (countEl) {
    countEl.textContent = `Vehicles (1-${items.length}) OF ${items.length}`;
  }

  if (!items.length) {
    container.innerHTML = `<p class="text-muted text-center py-4">No vehicles found</p>`;
    return;
  }

  container.innerHTML = items.map(vehicle => {
    const vehicleData = encodeURIComponent(JSON.stringify(vehicle));
    return `
    <div class="row bg-light border border-1 g-2 p-2">
      <div class="col-md-2">
        <img src="${vehicle.images?.[0] || '/assets/img/cars/default.png'}" alt="" class="img-fluid">
      </div>

      <div class="col-md-8">
        <h6>${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}</h6>
        <p class="text-success mb-0">$${Number(vehicle.price || 0).toLocaleString()}</p>
        <p>
          Stock #: ${vehicle.stock_number || 'N/A'}
          | Fuel: ${vehicle.fuel || 'N/A'}
          | VIN: ${vehicle.vin || 'N/A'}
          | Odometer: ${vehicle.odometer || 'N/A'}
          | Transmission: ${vehicle.transmission || 'N/A'}
          | Engine: ${vehicle.engine || 'N/A'}
          | Exterior Color: ${vehicle.exterior_color || 'N/A'}
          | Interior Color: ${vehicle.interior_color || 'N/A'}
        </p>
      </div>

      <div class="col-md-2 d-flex align-items-center">
        <button class="btn btn-primary w-100" onclick="selectInventoryItem('${vehicleData}')">
          SELECT VEHICLE
        </button>
      </div>
    </div>
  `}).join('');
}

async function selectInventoryItem(encodedVehicle) {
  const vehicle = JSON.parse(decodeURIComponent(encodedVehicle));
  const editDealId = document.getElementById('inventoryEditDealId').value;
  console.debug('selectInventoryItem:', { editDealId, currentDealId: window.AppState && window.AppState.currentDealId, inventoryOpenedForInterest: window.inventoryOpenedForInterest });
  
  // Close inventory modal properly
  const inventoryModalEl = document.getElementById('gotoinventoryModal');
  try {
    let inventoryModal = null;
    if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
      inventoryModal = bootstrap.Modal.getOrCreateInstance(inventoryModalEl);
    } else {
      inventoryModal = bootstrap.Modal.getInstance(inventoryModalEl) || new bootstrap.Modal(inventoryModalEl);
    }

    if (inventoryModal) {
      await new Promise(resolve => {
        const handler = function() {
          try { inventoryModalEl.removeEventListener('hidden.bs.modal', handler); } catch(e){}
          resolve();
        };
        inventoryModalEl.addEventListener('hidden.bs.modal', handler);
        try { inventoryModal.hide(); } catch (e) { resolve(); }
      });
    } else {
      // Fallback: force-hide classes if no instance
      try { inventoryModalEl.classList.remove('show'); inventoryModalEl.style.display = 'none'; } catch(e){}
    }
  } catch (err) {
    console.warn('selectInventoryItem: failed to hide inventory modal gracefully', err);
    try { inventoryModalEl.classList.remove('show'); inventoryModalEl.style.display = 'none'; } catch(e){}
  }

  // Clean up any remaining backdrops and body classes
  try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
  try { document.body.classList.remove('modal-open'); } catch(e){}
  // FORCE: only attach immediately if modal was opened for interest (explicit flow)
  try {
    if (window.inventoryOpenedForInterest && window.AppState && window.AppState.currentDealId) {
      const currentDealId = window.AppState.currentDealId;
      const customerId = getInventoryModalCustomerId();
      const payload = {
        inventory_id: vehicle.id,
        vehicle_description: `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim(),
        price: vehicle.price || null
      };

      const res = await fetch(`/api/deals/${currentDealId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-HTTP-Method-Override': 'PATCH',
          'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      const text = await res.text().catch(() => null);
      let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }
      if (!res.ok) throw new Error((data && (data.message || JSON.stringify(data))) || text || `HTTP ${res.status}`);

      // Refresh deals container
      try {
        if (customerId) {
          const dc = document.getElementById('dealsContainer');
          if (dc) {
            const r = await fetch(`/api/customers/${customerId}/deals`);
            if (r.ok) {
              const ct = (r.headers.get('content-type') || '').toLowerCase();
              if (ct.includes('application/json')) {
                const json = await r.json().catch(() => null);
                const deals = json?.deals || json?.data || [];
                if (Array.isArray(deals)) {
                  dc.innerHTML = deals.map(deal => `
                    <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="${deal.id}">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="d-flex align-items-center">
                            <p class="deal-vehicle-name fw-semibold mb-0 ${(deal.vehicle_description || '').trim() === 'No Vehicle Entered' ? 'text-danger' : ''}" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})">${deal.vehicle_description || 'Added Manually Vehicle'}</p>
                            <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})"></i>
                          </div>
                          <small class="text-muted small mb-0">Created: ${new Date(deal.created_at).toLocaleDateString()}</small>
                        </div>
                        <div class="text-end">
                          <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${deal.id})"></i>
                            <span class="fw-bold" style="color:rgb(0,33,64)">${deal.status || 'Active'}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  `).join('');
                  const newDealEl = dc.querySelector(`[data-deal-id="${currentDealId}"]`);
                  if (newDealEl) {
                    const details = document.createElement('div');
                    details.className = 'row deals-detail-area g-2 mt-2 d-none';
                    details.innerHTML = `<div data-vehicle-container="${currentDealId}"></div>`;
                    newDealEl.appendChild(details);
                    if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(currentDealId);
                  }
                }
              } else {
                const txt = await r.text(); if (txt && txt.trim()) dc.innerHTML = txt;
              }
            }
          }
        }
      } catch (err) { console.warn('Failed to refresh deals after attaching vehicle', err); }

      if (typeof showToast === 'function') showToast('Vehicle added to deal');
      window.inventoryOpenedForInterest = false;
      return;
    }
  } catch (err) { console.warn('force attach failed', err); }
  // If modal was opened for Vehicles Of Interest flow, or the editDealId matches the currentDealId,
  // attach selection to current deal immediately (prefer attaching over opening Edit modal)
  try {
    const openedForInterest = !!window.inventoryOpenedForInterest || (editDealId && window.AppState && Number(editDealId) === Number(window.AppState.currentDealId));
    if (openedForInterest && window.AppState && window.AppState.currentDealId) {
      const currentDealId = window.AppState.currentDealId;
      const customerId = getInventoryModalCustomerId();
      const payload = {
        inventory_id: vehicle.id,
        vehicle_description: `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim(),
        price: vehicle.price || null
      };

      const res = await fetch(`/api/deals/${currentDealId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-HTTP-Method-Override': 'PATCH',
          'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      const text = await res.text().catch(() => null);
      let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }
      if (!res.ok) throw new Error((data && (data.message || JSON.stringify(data))) || text || `HTTP ${res.status}`);

      // Refresh deals container
      try {
        if (customerId) {
          const dc = document.getElementById('dealsContainer');
          if (dc) {
            const r = await fetch(`/api/customers/${customerId}/deals`);
            if (r.ok) {
              const ct = (r.headers.get('content-type') || '').toLowerCase();
              if (ct.includes('application/json')) {
                const json = await r.json().catch(() => null);
                const deals = json?.deals || json?.data || [];
                if (Array.isArray(deals)) {
                  dc.innerHTML = deals.map(deal => `
                    <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="${deal.id}">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="d-flex align-items-center">
                            <p class="deal-vehicle-name fw-semibold mb-0 ${(deal.vehicle_description || '').trim() === 'No Vehicle Entered' ? 'text-danger' : ''}" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})">${deal.vehicle_description || 'Added Manually Vehicle'}</p>
                            <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})"></i>
                          </div>
                          <small class="text-muted small mb-0">Created: ${new Date(deal.created_at).toLocaleDateString()}</small>
                        </div>
                        <div class="text-end">
                          <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${deal.id})"></i>
                            <span class="fw-bold" style="color:rgb(0,33,64)">${deal.status || 'Active'}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  `).join('');
                  const newDealEl = dc.querySelector(`[data-deal-id="${currentDealId}"]`);
                  if (newDealEl) {
                    const details = document.createElement('div');
                    details.className = 'row deals-detail-area g-2 mt-2 d-none';
                    details.innerHTML = `<div data-vehicle-container="${currentDealId}"></div>`;
                    newDealEl.appendChild(details);
                    if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(currentDealId);
                  }
                }
              } else {
                const txt = await r.text(); if (txt && txt.trim()) dc.innerHTML = txt;
              }
            }
          }
        }
      } catch (err) { console.warn('Failed to refresh deals after attaching vehicle', err); }

      if (typeof showToast === 'function') showToast('Vehicle added to deal');
      window.inventoryOpenedForInterest = false;
      return;
    }
  } catch (err) { console.warn('interest attach guard failed', err); }
  
  // If modal was opened for Vehicles Of Interest, attach to the currently-selected deal first
  const openedForInterest = !!window.inventoryOpenedForInterest;
  if (openedForInterest) {
    try {
      const currentDealId = window.AppState && window.AppState.currentDealId;
      if (currentDealId) {
        const customerId = getInventoryModalCustomerId();
        const payload = {
          inventory_id: vehicle.id,
          vehicle_description: `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim(),
          price: vehicle.price || null
        };

        const res = await fetch(`/api/deals/${currentDealId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'PATCH',
            'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          credentials: 'same-origin',
          body: JSON.stringify(payload)
        });

        const text = await res.text().catch(() => null);
        let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }

        if (!res.ok) {
          const msg = (data && (data.message || JSON.stringify(data))) || text || `Server returned ${res.status}`;
          throw new Error(msg);
        }

        // Refresh deals list and vehicle partial
        try {
          if (customerId) {
            const dc = document.getElementById('dealsContainer');
            if (dc) {
              const r = await fetch(`/api/customers/${customerId}/deals`);
              if (r.ok) {
                const ct = (r.headers.get('content-type') || '').toLowerCase();
                if (ct.includes('application/json')) {
                  const json = await r.json().catch(() => null);
                  const deals = json?.deals || json?.data || [];
                  if (Array.isArray(deals)) {
                    dc.innerHTML = deals.map(deal => `
                      <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="${deal.id}">
                        <div class="d-flex justify-content-between align-items-start">
                          <div>
                            <div class="d-flex align-items-center">
                              <p class="deal-vehicle-name fw-semibold mb-0 ${(deal.vehicle_description || '').trim() === 'No Vehicle Entered' ? 'text-danger' : ''}" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})">${deal.vehicle_description || 'Added Manually Vehicle'}</p>
                              <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})"></i>
                            </div>
                            <small class="text-muted small mb-0">Created: ${new Date(deal.created_at).toLocaleDateString()}</small>
                          </div>
                          <div class="text-end">
                            <div class="d-flex align-items-center gap-1">
                              <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${deal.id})"></i>
                              <span class="fw-bold" style="color:rgb(0,33,64)">${deal.status || 'Active'}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    `).join('');
                    const newDealEl = dc.querySelector(`[data-deal-id="${currentDealId}"]`);
                    if (newDealEl) {
                      const details = document.createElement('div');
                      details.className = 'row deals-detail-area g-2 mt-2 d-none';
                      details.innerHTML = `<div data-vehicle-container="${currentDealId}"></div>`;
                      newDealEl.appendChild(details);
                      if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(currentDealId);
                    }
                  }
                } else {
                  const txt = await r.text(); if (txt && txt.trim()) dc.innerHTML = txt;
                }
              }
            }
          }
        } catch (err) { console.warn('Failed to refresh deals after attaching vehicle', err); }

        if (typeof showToast === 'function') showToast('Vehicle added to deal');
        window.inventoryOpenedForInterest = false;
        return;
      }
    } catch (err) {
      console.error('Failed to attach vehicle to existing deal (interest):', err);
      window.inventoryOpenedForInterest = false;
      if (typeof showToast === 'function') showToast('Failed to add vehicle to deal', 'error');
      return;
    }
  }

  if (editDealId) {
    // EDIT MODE: Open Edit Deal modal with vehicle pre-populated
    await openEditDealModal(editDealId, vehicle);
  } else if ((window.inventoryOpenedForInterest) || (editDealId && window.AppState && Number(editDealId) === Number(window.AppState.currentDealId))) {
    // VEHICLE OF INTEREST MODE: attach selected vehicle to the currently selected deal
    try {
      const currentDealId = window.AppState.currentDealId;
      const customerId = getInventoryModalCustomerId();
      const payload = {
        inventory_id: vehicle.id,
        vehicle_description: `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim(),
        price: vehicle.price || null
      };

      const res = await fetch(`/api/deals/${currentDealId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-HTTP-Method-Override': 'PATCH',
          'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      const text = await res.text().catch(() => null);
      let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }

      if (!res.ok) {
        const msg = (data && (data.message || JSON.stringify(data))) || text || `Server returned ${res.status}`;
        throw new Error(msg);
      }

      // Refresh deals list so the updated deal appears correctly
      try {
        if (customerId) {
          const dc = document.getElementById('dealsContainer');
          if (dc) {
            const r = await fetch(`/api/customers/${customerId}/deals`);
            if (r.ok) {
              const ct = (r.headers.get('content-type') || '').toLowerCase();
              if (ct.includes('application/json')) {
                const json = await r.json().catch(() => null);
                const deals = json?.deals || json?.data || [];
                if (Array.isArray(deals)) {
                  dc.innerHTML = deals.map(deal => `
                    <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="${deal.id}">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <div class="d-flex align-items-center">
                            <p class="deal-vehicle-name fw-semibold mb-0 ${(deal.vehicle_description || '').trim() === 'No Vehicle Entered' ? 'text-danger' : ''}" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})">${deal.vehicle_description || 'Added Manually Vehicle'}</p>
                            <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${deal.id})"></i>
                          </div>
                          <small class="text-muted small mb-0">Created: ${new Date(deal.created_at).toLocaleDateString()}</small>
                        </div>
                        <div class="text-end">
                          <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${deal.id})"></i>
                            <span class="fw-bold" style="color:rgb(0,33,64)">${deal.status || 'Active'}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  `).join('');

                  // ensure details areas exist and prefetch partial for currentDealId
                  const newDealEl = dc.querySelector(`[data-deal-id="${currentDealId}"]`);
                  if (newDealEl) {
                    const details = document.createElement('div');
                    details.className = 'row deals-detail-area g-2 mt-2 d-none';
                    details.innerHTML = `<div data-vehicle-container="${currentDealId}"></div>`;
                    newDealEl.appendChild(details);
                    if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(currentDealId);
                  }
                }
              } else {
                const txt = await r.text(); if (txt && txt.trim()) dc.innerHTML = txt;
              }
            }
          }
        }
      } catch (err) { console.warn('Failed to refresh deals after attaching vehicle', err); }

      if (typeof showToast === 'function') showToast('Vehicle added to deal');
      return;
    } catch (err) {
      console.error('Failed to attach vehicle to existing deal:', err);
      if (typeof showToast === 'function') showToast('Failed to add vehicle to deal', 'error');
      return;
    }
  } else {
    // ADD MODE: Create deal immediately from selected inventory (no extra modal)
    try {
      const customerId = getInventoryModalCustomerId();
      if (!customerId) throw new Error('No customer selected');

      const payload = {
        customer_id: customerId,
        inventory_id: vehicle.id,
        vehicle_description: `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim(),
        price: vehicle.price || null,
        status: 'Active'
      };

      const res = await fetch('/api/deals', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
      });

      const text = await res.text().catch(() => null);
      let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }

      if (!res.ok) {
        const msg = (data && (data.message || JSON.stringify(data))) || text || `Server returned ${res.status}`;
        throw new Error(msg);
      }

      const createdDeal = (data && data.deal) ? data.deal : (data || null);
      if (!createdDeal) throw new Error('No deal returned from server');

      // Prepend simple deal box to dealsContainer
      const container = document.getElementById('dealsContainer');
        if (container) {
          const div = document.createElement('div');
          div.className = 'deal-box mb-3 p-2 border rounded bg-white shadow-sm';
          div.dataset.dealId = createdDeal.id;
          const displayDesc = (createdDeal.vehicle_description && String(createdDeal.vehicle_description).trim()) || 'No Vehicle Entered';
          const isPlaceholder = displayDesc === 'No Vehicle Entered';
          div.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="d-flex align-items-center">
  <p class="deal-vehicle-name fw-semibold mb-0 ${isPlaceholder ? 'text-danger' : ''}" 
     style="cursor:pointer;" 
     onclick="toggleDealDetails(this.closest('.deal-box'), ${createdDeal.id})">
   ${displayDesc}
  </p>
                  <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'), ${createdDeal.id})"></i>
                </div>
                <small class="text-muted small mb-0">Created: ${new Date(createdDeal.created_at).toLocaleDateString()}</small>
              </div>
              <div class="text-end">
                <div class="d-flex align-items-center gap-1">
                  <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${createdDeal.id})"></i>
                  <span class="fw-bold" style="color:rgb(0,33,64)">${createdDeal.status || 'Active'}</span>
                </div>
              </div>
            </div>
          `;
          container.prepend(div);
        }

      if (typeof showToast === 'function') showToast('Vehicle added to deals');

      // Ensure newly prepended deal has a details area and load its vehicle partial
      try {
        const newDealBox = container.querySelector(`[data-deal-id="${createdDeal.id}"]`);
        if (newDealBox) {
          const details = document.createElement('div');
          details.className = 'row deals-detail-area g-2 mt-2 d-none';
          details.innerHTML = `<div data-vehicle-container="${createdDeal.id}"></div>`;
          newDealBox.appendChild(details);
          // Prefetch the vehicle partial so toggling details works immediately
          if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(createdDeal.id);
        }
      } catch(e) { /* ignore */ }
    } catch (err) {
      console.error('Failed to create deal from inventory:', err);
      if (typeof showToast === 'function') showToast('Failed to add vehicle to deals', 'error');
    }
  }
}

// Handle "Skip adding vehicle for now" button: create a placeholder deal
// Delegated handler for skip button so it works even if the element is added/removed
document.addEventListener('click', async function (e) {
  const btn = e.target.closest && e.target.closest('#skipVehicleBtn');
  if (!btn) return;
  e.preventDefault();
  const inventoryModalEl = document.getElementById('gotoinventoryModal');
  try {
    let inventoryModal = null;
    if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
      inventoryModal = bootstrap.Modal.getOrCreateInstance(inventoryModalEl);
    } else {
      inventoryModal = bootstrap.Modal.getInstance(inventoryModalEl) || new bootstrap.Modal(inventoryModalEl);
    }

    if (inventoryModal) {
      await new Promise(resolve => {
        const handler = function() {
          try { inventoryModalEl.removeEventListener('hidden.bs.modal', handler); } catch(e){}
          resolve();
        };
        inventoryModalEl.addEventListener('hidden.bs.modal', handler);
        try { inventoryModal.hide(); } catch (e) { resolve(); }
      });
    } else {
      try { inventoryModalEl.classList.remove('show'); inventoryModalEl.style.display = 'none'; } catch(e){}
    }
  } catch (err) {
    console.warn('skipVehicleBtn: failed to hide inventory modal gracefully', err);
  }

  // Clean up any remaining backdrops and body classes
  try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
  try { document.body.classList.remove('modal-open'); } catch(e){}

  try {
    const customerId = getInventoryModalCustomerId();
    if (!customerId) throw new Error('No customer selected');

    const payload = {
      customer_id: customerId,
      inventory_id: null,
      vehicle_description: 'No Vehicle Entered',
      price: null,
      status: 'Active'
    };

    const res = await fetch('/api/deals', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': (window.AppState && window.AppState.csrfToken) || document.querySelector('meta[name="csrf-token"]')?.content || ''
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload)
    });

    const text = await res.text().catch(() => null);
    let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }

    if (!res.ok) {
      const msg = (data && (data.message || JSON.stringify(data))) || text || `Server returned ${res.status}`;
      throw new Error(msg);
    }

    const createdDeal = (data && data.deal) ? data.deal : (data || null);
    if (!createdDeal) throw new Error('No deal returned from server');

    const container = document.getElementById('dealsContainer');
    if (container) {
      const div = document.createElement('div');
      div.className = 'deal-box mb-3 p-2 border rounded bg-white shadow-sm';
      div.dataset.dealId = createdDeal.id;
      const displayDesc = (createdDeal.vehicle_description && String(createdDeal.vehicle_description).trim()) || 'No Vehicle Entered';
      const isPlaceholder = displayDesc === 'No Vehicle Entered';
      div.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="d-flex align-items-center">
            <p class="deal-vehicle-name fw-semibold mb-0 ${isPlaceholder ? 'text-danger' : ''}" 
              style="cursor:pointer;" 
              onclick="toggleDealDetails(this.closest('.deal-box'), ${createdDeal.id})">
              ${displayDesc}
            </p>
              <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;" onclick="toggleDealDetails(this.closest('.deal-box'),${createdDeal.id})"></i>
            </div>
            <small class="text-muted small mb-0">Created: ${new Date(createdDeal.created_at).toLocaleDateString()}</small>
          </div>
          <div class="text-end">
            <div class="d-flex align-items-center gap-1">
              <i class="ti ti-trash text-danger" style="cursor:pointer;" onclick="deleteDeal(${createdDeal.id})"></i>
              <span class="fw-bold" style="color:rgb(0,33,64)">${createdDeal.status || 'Active'}</span>
            </div>
          </div>
        </div>
      `;
      container.prepend(div);
    }

    if (typeof showToast === 'function') showToast('Vehicle skip recorded as placeholder deal');

      // Attach a hidden details area and prefetch its partial so details can open immediately
      try {
        const newDealBox = container.querySelector(`[data-deal-id="${createdDeal.id}"]`);
        if (newDealBox) {
          const details = document.createElement('div');
          details.className = 'row deals-detail-area g-2 mt-2 d-none';
          details.innerHTML = `<div data-vehicle-container="${createdDeal.id}"></div>`;
          newDealBox.appendChild(details);
          if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(createdDeal.id);
        }
      } catch(e) { /* ignore */ }
  } catch (err) {
    console.error('Failed to create placeholder deal:', err);
    if (typeof showToast === 'function') showToast('Failed to add placeholder deal', 'error');
  }
});

async function openEditDealModal(dealId, vehicle) {
  try {
    const result = await api(`/api/deals/${dealId}`);
    const deal = result.data || result.deal || result;
    
    const form = document.getElementById('editDealForm');
    if (form) {
      form.setAttribute('data-deal-id', dealId);
      
      // Set the vehicle info from selected inventory
      const editDealInventoryId = document.getElementById('editDealInventoryId');
      const editDealVehicleDescription = document.getElementById('editDealVehicleDescription');
      const editDealPrice = document.getElementById('editDealPrice');
      const editSelectedVehicleDisplay = document.getElementById('editSelectedVehicleDisplay');
      
      if (editDealInventoryId) editDealInventoryId.value = vehicle.id;
      if (editDealVehicleDescription) {
        editDealVehicleDescription.value = `${vehicle.year} ${vehicle.make} ${vehicle.model} ${vehicle.trim || ''}`.trim();
      }
      if (editDealPrice) editDealPrice.value = vehicle.price || '';
      if (editSelectedVehicleDisplay) {
        editSelectedVehicleDisplay.textContent = `${vehicle.year} ${vehicle.make} ${vehicle.model}`;
      }
      
      // Populate other deal fields
      const fieldMappings = {
        'editDealNumber': 'deal_number',
        'editDealStatus': 'status',
        'editDealLeadType': 'lead_type',
        'editDealInventoryType': 'inventory_type',
        'editDealDownPayment': 'down_payment',
        'editDealTradeInValue': 'trade_in_value',
        'editDealSalesPerson': 'sales_person_id',
        'editDealSalesManager': 'sales_manager_id',
        'editDealFinanceManager': 'finance_manager_id',
        'editDealNotes': 'notes'
      };
      
      for (const [elementId, fieldName] of Object.entries(fieldMappings)) {
        const el = document.getElementById(elementId);
        if (el) el.value = deal[fieldName] || '';
      }
    }
    
    // Open the edit deal modal
    const editDealModalEl = document.getElementById('editDealModal');
    if (editDealModalEl) {
      const editDealModal = new bootstrap.Modal(editDealModalEl);
      editDealModal.show();
    }
    
  } catch (error) {
    console.error('Failed to load deal data:', error);
    if (typeof showToast === 'function') {
      showToast('Failed to load deal data', 'error');
    }
  }
}

async function refreshVehiclePartial(dealId) {
  const vehicleContainer = document.querySelector(`[data-vehicle-container="${dealId}"]`) 
    || document.getElementById('vehiclePartialContainer');
  
  if (vehicleContainer) {
    try {
      const response = await fetch(`/api/deals/${dealId}/vehicle-partial`);
      if (response.ok) {
        vehicleContainer.innerHTML = await response.text();
      }
    } catch (error) {
      console.error('Failed to refresh vehicle partial:', error);
    }
  }
}
</script>
{{-- Ensure manual vehicle modal is available on this page --}}
@include('customers.modals.add-vehicle')
<script>
  function openManualVehicleFormFromInventory() {
    const currentEl = document.getElementById('gotoinventoryModal');
    const manual = document.getElementById('manualVehicleModal') || document.getElementById('addManuallyModal');

    const showManual = async () => {
      if (!manual) { alert('Manual vehicle form is not available on this page.'); return; }
      try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
      try { if (manual.parentNode !== document.body) document.body.appendChild(manual); } catch(e){}
      try {
        if (typeof openManualVehicleForm === 'function') { openManualVehicleForm(); return; }
        if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
          bootstrap.Modal.getOrCreateInstance(manual).show();
        } else {
          new bootstrap.Modal(manual).show();
        }
        // Ensure manual modal is on top
        setTimeout(() => {
          try {
            manual.style.zIndex = 200050;
            const md = manual.querySelector('.modal-dialog'); if (md) md.style.zIndex = 200051;
            document.querySelectorAll('.modal-backdrop').forEach(b => b.style.zIndex = 200000);
          } catch(e){}
        }, 50);
      } catch(e){
        try { bootstrap.Modal.getInstance(manual)?.show(); } catch(e){}
      }
    };

    try {
      const currentModal = bootstrap.Modal.getInstance(currentEl);
      if (currentModal) {
        // Wait for inventory modal to fully hide, then show manual modal
        await new Promise(resolve => {
          const handler = function() {
            currentEl.removeEventListener('hidden.bs.modal', handler);
            resolve();
          };
          currentEl.addEventListener('hidden.bs.modal', handler);
          try { currentModal.hide(); } catch(e) { resolve(); }
        });

        // Clean up any leftover backdrops and show manual modal
        try { document.querySelectorAll('.modal-backdrop').forEach(b => b.remove()); } catch(e){}
        await showManual();
        return;
      }
    } catch(e) { console.warn(e); }

    await showManual();
  }
  // Expose to global so inline onclicks can call it
  try { window.openManualVehicleFormFromInventory = openManualVehicleFormFromInventory; } catch(e) {}
</script>