{{-- Vehicles of Interest Section - resources/views/customers/partials/vehicles-interest.blade.php --}}
{{-- Component-based approach with minimal JavaScript --}}
@props(['vehicle' => null])

<div class="col-md-12" id="vehiclesInterest" data-requires-deal style="display:none;">
    <div class="card-box">
        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="mb-0">
                Vehicles Of Interest 
                <button type="button" class="btn btn-light btn-sm ms-1 border" 
                        onclick="quickAddInventoryToDeal()">
                    <i class="ti ti-plus" style="font-size:12px;"></i>
                </button>
            </h6>
            <ul class="nav nav-tabs me-3 mt-2" id="vehicleTabs" role="tablist">
                @foreach([
                    'vehicle' => ['icon' => 'car', 'label' => 'Vehicle'],
                    'tradein' => ['icon' => 'exchange', 'label' => 'Trade-In'],
                    'finance' => ['icon' => 'credit-card', 'label' => 'Finance / Cash / Lease'],
                    'serviceHistory' => ['icon' => 'tools', 'label' => 'Service History']
                ] as $tabId => $tab)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                            id="{{ $tabId }}-tab"
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $tabId }}Tab"
                            type="button" 
                            role="tab">
                        <i class="ti ti-{{ $tab['icon'] }} d-md-none"></i>
                        <span class="d-none d-md-inline">{{ $tab['label'] }}</span>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        
        {{-- Tab Content --}}
        <div class="tab-content mt-3" id="vehicleTabsContent">
            
            {{-- Vehicle Tab --}}
            <div class="tab-pane fade show active" id="vehicleTab" role="tabpanel">
                @include('customers.partials.vehicles.vehicle-details',['vehicle'=>$vehicle])
            </div>
            
            {{-- Trade-In Tab --}}
            <div class="tab-pane fade" id="tradeinTab" role="tabpanel">
                @include('customers.partials.vehicles.trade-in-form', [
                    'conditionGrades' => $conditionGrades ?? []
                ])
            </div>
            
            {{-- Finance Tab --}}
            <div class="tab-pane fade" id="financeTab" role="tabpanel">
                @include('customers.partials.vehicles.finance-options')
            </div>
            
            {{-- Service History Tab --}}
            <div class="tab-pane fade" id="serviceHistoryTab" role="tabpanel">
                <div id="serviceHistory">
                    
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Finance Modals --}}
@include('customers.modals.finance-modal')
@include('customers.modals.lease-modal')
@include('customers.modals.cash-modal')

{{-- Vehicle Interest Component Script --}}
<script>
document.addEventListener('deal:selected', async function(e) {
    const { dealId } = e.detail;
    
    // Load vehicle data via server-side rendering
    try {
        const response = await fetch(`/api/deals/${dealId}/vehicle-partial`);
        if (response.ok) {
            const html = await response.text();
            document.getElementById('vehicleTab').innerHTML = html;
        }
        
        // Load service history
        const historyResponse = await fetch(`/api/deals/${dealId}/service-history-partial`);
        if (historyResponse.ok) {
            const historyHtml = await historyResponse.text();
            document.querySelector('#serviceHistory').innerHTML = historyHtml;
        }
    } catch (error) {
        console.error('Failed to load vehicle data');
    }

    // Load trade-in data for this deal and populate the trade-in form if present
    try {
        const tradeResp = await fetch(`/trade-ins/${dealId}`);
        if (tradeResp.ok) {
            const json = await tradeResp.json().catch(() => null);
            const trade = json?.data || null;
            const container = document.getElementById('vehiclesInterest');
            const form = container ? container.querySelector('#tradeInForm') : document.getElementById('tradeInForm');
            if (form) {
                // set deal id hidden input
                const dealIdInput = form.querySelector('[data-deal-id-input]');
                if (dealIdInput) dealIdInput.value = dealId;

                if (trade) {
                    // ensure hidden trade_in_id exists so submit handler treats it as update
                    let tradeIdInput = form.querySelector('input[name="trade_in_id"]');
                    if (!tradeIdInput) {
                        tradeIdInput = document.createElement('input');
                        tradeIdInput.type = 'hidden';
                        tradeIdInput.name = 'trade_in_id';
                        form.appendChild(tradeIdInput);
                    }
                    tradeIdInput.value = trade.id;

                    // populate known fields (by id/name) scoped to this form
                    const setIf = (selector, val) => { const el = form.querySelector(selector); if (el) el.value = (val === null || typeof val === 'undefined') ? '' : val; };
                    setIf('#vinInput', trade.vin);
                    setIf('#odometerInput', trade.odometer);
                    setIf('#vehicleYear', trade.year);
                    setIf('#vehicleMake', trade.make);
                    setIf('#vehicleModel', trade.model);
                    setIf('input[name="trade_allowance"]', trade.trade_allowance);
                    setIf('#tradeAllowance', trade.trade_allowance);
                    setIf('#lienPayout', trade.lien_payout);
                    setIf('#marketValue', trade.market_value);
                    setIf('#acvValue', trade.acv);
                    setIf('textarea[name="recon_estimate"]', trade.recon_estimate);
                    // condition grade select
                    const cg = form.querySelector('#conditionGrade'); if (cg) cg.value = trade.condition_grade || '';
                    // appraisal datetime and appraised_by
                    const appraisalEl = form.querySelector('input[name="appraisal_datetime"]');
                    if (appraisalEl && trade.appraisal_date) {
                        // convert ISO date to datetime-local format YYYY-MM-DDTHH:MM
                        const d = new Date(trade.appraisal_date);
                        if (!isNaN(d.getTime())) {
                            const pad = n => String(n).padStart(2, '0');
                            const local = `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
                            appraisalEl.value = local;
                        }
                    }
                    const appraiserEl = form.querySelector('select[name="appraised_by"]');
                    if (appraiserEl && typeof trade.appraised_by !== 'undefined' && trade.appraised_by !== null) {
                        try { appraiserEl.value = trade.appraised_by; } catch(e) { /* ignore */ }
                    }
                }
            }
        }
    } catch (err) { console.warn('Failed to load trade-in for deal', err); }
});

// Quickly assign the first available inventory vehicle to the currently selected deal
async function quickAddInventoryToDeal() {
    try {
        const dealId = window.AppState?.currentDealId || null;
        if (!dealId) return (typeof showToast === 'function') ? showToast('No deal selected', 'error') : null;

        // Fetch inventory (use api helper if available)
        let inventory = null;
        try {
            if (typeof api === 'function') {
                const res = await api('/api/inventory');
                inventory = res?.data || res || [];
            } else {
                const raw = await fetch('/api/inventory', { headers: { 'X-CSRF-TOKEN': window.AppState?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content || '' } });
                if (raw.ok) inventory = (await raw.json())?.data || [];
            }
        } catch (err) { console.error('Failed to fetch inventory', err); inventory = []; }

        if (!inventory || !inventory.length) return (typeof showToast === 'function') ? showToast('No inventory available', 'error') : null;

        const vehicle = inventory[0];

        const payload = {
            inventory_id: vehicle.id || null,
            vehicle_description: `${vehicle.year || ''} ${vehicle.make || ''} ${vehicle.model || ''} ${vehicle.trim || ''}`.trim(),
            price: vehicle.price || null
        };

        const token = window.AppState?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content || '';
        const res = await fetch(`/api/deals/${dealId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-HTTP-Method-Override': 'PATCH', 'X-CSRF-TOKEN': token },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
        });

        const text = await res.text().catch(() => null);
        let data = null; try { data = text ? JSON.parse(text) : null; } catch(e) { /* ignore */ }

        if (!res.ok) {
            const msg = (data && (data.message || JSON.stringify(data))) || text || `Server returned ${res.status}`;
            throw new Error(msg);
        }

        if (typeof showToast === 'function') showToast('Vehicle added to interest');
        // Refresh vehicle partial in the Vehicles of Interest component
        if (typeof refreshVehiclePartial === 'function') refreshVehiclePartial(dealId);
        // Also refresh service history listener via dispatch
        document.dispatchEvent(new CustomEvent('deal:selected', { detail: { dealId, customerId: window.AppState?.customerId } }));

    } catch (err) {
        console.error('quickAddInventoryToDeal error', err);
        if (typeof showToast === 'function') showToast('Failed to add vehicle', 'error');
    }
}
</script>