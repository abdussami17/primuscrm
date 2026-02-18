{{-- Lease Modal - resources/views/customers/modals/lease-modal.blade.php --}}
<div class="modal fade finance-custom-modal modal-lease" id="leaseModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                <span>Lease Details</span>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="leaseForm" class="row g-3">
                 
                    <div class="col-md-3">
                        <label class="form-label">Lender / Lease Company</label>
                        <input type="text" class="form-control" name="lease_company" placeholder="Enter lease company">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Lease Program / Code</label>
                        <input type="text" class="form-control" name="lease_program" placeholder="Program code">
                    </div>

                  
                    <div class="col-md-3">
                        <label class="form-label">Lease Rate (%) / Money Factor</label>
                        <input type="number" class="form-control" name="money_factor" id="leaseMoneyFactor" step="0.00001" value="0.00125" required>
                        <small class="text-muted">Equivalent APR: <span id="leaseEquivApr">3.00%</span></small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Term (Months)</label>
                        <select class="form-select" name="term" id="leaseTerm" required>
                            <option value="24">24 months</option>
                            <option value="36" selected>36 months</option>
                            <option value="39">39 months</option>
                            <option value="48">48 months</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Frequency</label>
                        <select class="form-select" name="payment_frequency">
                            <option>Monthly</option>
                            <option>Bi-weekly</option>
                            <option>Weekly</option>
                        </select>
                    </div>

                
                    <div class="col-md-3">
                        <label class="form-label">Miles / KM Allowance (Per Year)</label>
                        <select class="form-select" name="miles_per_year" id="leaseMilesPerYear">
                            <option value="10000">10,000 miles</option>
                            <option value="12000" selected>12,000 miles</option>
                            <option value="15000">15,000 miles</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Excess Mileage Charge ($/mile)</label>
                        <input type="number" class="form-control" name="excess_mileage" step="0.01" placeholder="0.15">
                    </div>

                   
                    <div class="col-md-3">
                        <label class="form-label">Capitalized Cost ($)</label>
                        <input type="number" class="form-control" name="selling_price" id="leaseSellingPrice" step="0.01" placeholder="Selling price" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cap Cost Reduction ($)</label>
                        <input type="number" class="form-control" name="down_payment" id="leaseDownPayment" step="0.01" value="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Net Cap Cost ($)</label>
                        <input type="number" class="form-control" id="leaseCapCost" placeholder="Auto calculated" readonly>
                    </div>

                    <!-- RESIDUAL -->
                    <div class="col-md-3 mt-3">
                        <label class="form-label">Residual Value %</label>
                        <input type="number" class="form-control" name="residual_percent" id="leaseResidualPercent" step="0.01" value="55" required>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label">Residual Value ($)</label>
                        <input type="number" class="form-control" id="leaseResidualValue" readonly>
                    </div>

                  
                    <div class="col-md-3">
                        <label class="form-label">Monthly Payment ($)</label>
                        <input type="number" class="form-control" id="leaseMonthlyPayment" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Due at Signing ($)</label>
                        <input type="number" class="form-control" id="leaseDueAtSigning" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trade-In Equity ($)</label>
                        <input type="number" class="form-control" name="trade_in" id="leaseTradeIn" step="0.01" value="0">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Lease Start Date</label>
                        <input type="date" class="form-control" name="lease_start">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Lease End Date</label>
                        <input type="date" class="form-control" name="lease_end">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Buyout Amount ($)</label>
                        <input type="number" class="form-control" name="buyout_amount" step="0.01" placeholder="0.00">
                    </div>

                   
                    <div class="col-md-3">
                        <label class="form-label">Lease Gross ($)</label>
                        <input type="number" class="form-control" name="lease_gross" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Reserve / Flat Fee ($)</label>
                        <input type="number" class="form-control" name="reserve_fee" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Back-End Gross ($)</label>
                        <input type="number" class="form-control" name="backend_gross" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total Profit ($)</label>
                        <input type="number" class="form-control" name="total_profit" step="0.01">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Credit Score</label>
                        <input type="text" class="form-control" name="credit_score">
                    </div>

                   
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="applyLeaseBtn">
                    Save Lease
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('leaseForm')?.addEventListener('input', calculateLease);

function calculateLease() {
    const msrp = parseFloat(document.getElementById('leaseSellingPrice').value) || 0;
    const downPayment = parseFloat(document.getElementById('leaseDownPayment').value) || 0;
    const tradeIn = parseFloat(document.getElementById('leaseTradeIn').value) || 0;
    const residualPercent = parseFloat(document.getElementById('leaseResidualPercent').value) || 0;
    const moneyFactor = parseFloat(document.getElementById('leaseMoneyFactor').value) || 0;
    const term = parseInt(document.getElementById('leaseTerm').value) || 36;

    // Equivalent APR
    const equivApr = moneyFactor * 2400;
    document.getElementById('leaseEquivApr').textContent = equivApr.toFixed(2) + '%';

    const residualValue = msrp * (residualPercent / 100);
    const capCost = msrp - downPayment - tradeIn;
    const depreciation = (capCost - residualValue) / term;
    const rentCharge = (capCost + residualValue) * moneyFactor;
    const monthlyPayment = depreciation + rentCharge;
    const dueAtSigning = downPayment + monthlyPayment;

    document.getElementById('leaseCapCost').value = capCost.toFixed(2);
    document.getElementById('leaseResidualValue').value = residualValue.toFixed(2);
    document.getElementById('leaseMonthlyPayment').value = monthlyPayment.toFixed(2);
    document.getElementById('leaseDueAtSigning').value = dueAtSigning.toFixed(2);
}

document.getElementById('applyLeaseBtn')?.addEventListener('click', async function() {
    const dealId = AppState.currentDealId;
    if (!dealId) {
        showToast('Please select a deal first', 'error');
        return;
    }

    const formData = new FormData(document.getElementById('leaseForm'));
    formData.append('deal_id', dealId);
    formData.append('payment_type', 'lease');

    try {
        const res = await api('/api/deals/' + dealId + '/payment', 'POST', Object.fromEntries(formData));
        if (res && (res.success === true || String(res.success) === 'true')) {
            showToast('Lease option applied successfully');
            try {
                const modalEl = document.getElementById('leaseModal');
                if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modalInstance = (bootstrap.Modal.getInstance ? bootstrap.Modal.getInstance(modalEl) : null)
                        || (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(modalEl) : new bootstrap.Modal(modalEl));
                    if (modalInstance && typeof modalInstance.hide === 'function') modalInstance.hide();
                }
            } catch (e) { console.warn('Could not hide leaseModal', e); }
        } else {
            const msg = (res && (res.message || res.error)) || JSON.stringify(res) || 'Failed to apply lease option';
            showToast(msg, 'error');
        }
    } catch (error) {
        const msg = (error && (error.message || error.toString())) || 'Network error applying lease option';
        showToast(msg, 'error');
    }
});
</script>
