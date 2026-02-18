{{-- Finance Modal - resources/views/customers/modals/finance-modal.blade.php --}}

<div class="modal fade finance-custom-modal modal-finance"
     id="financeModal"
     tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
        <span>Finance Details</span>
        <button type="button" data-bs-dismiss="modal" aria-label="Close">
            <i class="isax isax-close-circle"></i>
        </button>
    </div>

      <div class="modal-body">
        <form id="financeForm" class="row g-3">


          <div class="col-md-3">
            <label class="form-label">Lender / Bank Name</label>
            <input type="text" class="form-control" name="lender_name">
          </div>

          <div class="col-md-3">
            <label class="form-label">Program / Lender Code</label>
            <input type="text" class="form-control" name="lender_code">
          </div>



          <div class="col-md-3">
            <label class="form-label">Interest Rate (%)</label>
            <input type="number" class="form-control"
                   id="financeInterestRate"
                   name="interest_rate"
                   step="0.01"
                   value="5.99">
          </div>

          <div class="col-md-3">
            <label class="form-label">Term (Months)</label>
            <input type="number" class="form-control"
                   id="financeTerm"
                   name="term"
                   value="60">
          </div>

          <div class="col-md-3">
            <label class="form-label">Payment Frequency</label>
            <select class="form-select" name="payment_frequency">
              <option selected>Monthly</option>
              <option>Bi-weekly</option>
              <option>Weekly</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Finance Start Date</label>
            <input type="date" class="form-control" name="start_date">
          </div>

          <div class="col-md-3">
            <label class="form-label">Finance End Date</label>
            <input type="date" class="form-control" name="end_date">
          </div>



          <div class="col-md-3">
            <label class="form-label">Payment Amount ($)</label>
            <input type="number" class="form-control"
                   id="financeMonthlyPayment"
                   name="monthly_payment"
                   step="0.01"
                   readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Down Payment ($)</label>
            <input type="number" class="form-control"
                   id="financeDownPayment"
                   name="down_payment"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Deposit Received ($)</label>
            <input type="number" class="form-control"
                   name="deposit_received"
                   step="0.01"
                   value="0">
          </div>



          <div class="col-md-3">
            <label class="form-label">Trade Allowance ($)</label>
            <input type="number" class="form-control"
                   id="financeTradeIn"
                   name="trade_in_value"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Lien Payout ($)</label>
            <input type="number" class="form-control"
                   name="lien_payout"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Bank Fee ($)</label>
            <input type="number" class="form-control"
                   id="financeTaxesFees"
                   name="bank_fee"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Admin Fee ($)</label>
            <input type="number" class="form-control"
                   name="admin_fee"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Doc Fee ($)</label>
            <input type="number" class="form-control"
                   name="doc_fee"
                   step="0.01"
                   value="0">
          </div>

      

          <div class="col-md-3">
            <label class="form-label">Extended Warranty</label>
            <select class="form-select" name="extended_warranty">
              <option selected>Yes</option>
              <option>No</option>
              <option>Expired</option>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Extended Warranty ($)</label>
            <input type="number" class="form-control"
                   name="warranty_amount"
                   step="0.01"
                   value="0">
          </div>

          

          <div class="col-md-3">
            <label class="form-label">Front-End Gross ($)</label>
            <input type="number" class="form-control" step="0.01">
          </div>

          <div class="col-md-3">
            <label class="form-label">Back-End Gross ($)</label>
            <input type="number" class="form-control" step="0.01">
          </div>

          <div class="col-md-3">
            <label class="form-label">Total Gross ($)</label>
            <input type="number" class="form-control" step="0.01">
          </div>


          <div class="col-md-3">
            <label class="form-label">Credit Score</label>
            <input type="text" class="form-control" name="credit_score">
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="applyFinanceBtn">
          Save Finance
        </button>
      </div>

    </div>
  </div>
</div>


<script>
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

// Finance Calculator
document.getElementById('financeForm')?.addEventListener('input', calculateFinance);

function calculateFinance() {
    const price = parseFloat(document.getElementById('financeVehiclePrice').value) || 0;
    const down = parseFloat(document.getElementById('financeDownPayment').value) || 0;
    const tradeIn = parseFloat(document.getElementById('financeTradeIn').value) || 0;
    const rate = parseFloat(document.getElementById('financeInterestRate').value) || 0;
    const term = parseInt(document.getElementById('financeTerm').value) || 60;
    const taxesFees = parseFloat(document.getElementById('financeTaxesFees').value) || 0;
    
    const amountFinanced = price - down - tradeIn + taxesFees;
    const monthlyRate = (rate / 100) / 12;
    
    let monthlyPayment = 0;
    if (monthlyRate > 0) {
        monthlyPayment = amountFinanced * (monthlyRate * Math.pow(1 + monthlyRate, term)) / (Math.pow(1 + monthlyRate, term) - 1);
    } else {
        monthlyPayment = amountFinanced / term;
    }
    
    const totalInterest = (monthlyPayment * term) - amountFinanced;
    
    document.getElementById('financeAmountFinanced').textContent = '$' + amountFinanced.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('financeMonthlyPayment').textContent = '$' + monthlyPayment.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('financeTotalInterest').textContent = '$' + totalInterest.toLocaleString('en-US', {minimumFractionDigits: 2});
}

document.getElementById('applyFinanceBtn')?.addEventListener('click', async function() {
    const dealId = AppState.currentDealId;
    if (!dealId) {
        showToast('Please select a deal first', 'error');
        return;
    }
    
    const formData = new FormData(document.getElementById('financeForm'));
    formData.append('deal_id', dealId);
    formData.append('payment_type', 'finance');
    
    try {
      const res = await api('/api/deals/' + dealId + '/payment', 'POST', Object.fromEntries(formData));
      if (res && (res.success === true || String(res.success) === 'true')) {
        showToast('Finance option applied successfully');
        try {
          const modalEl = document.getElementById('financeModal');
          if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = (bootstrap.Modal.getInstance ? bootstrap.Modal.getInstance(modalEl) : null)
              || (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(modalEl) : new bootstrap.Modal(modalEl));
            if (modalInstance && typeof modalInstance.hide === 'function') modalInstance.hide();
          }
        } catch (e) { console.warn('Could not hide financeModal', e); }
      } else {
        const msg = (res && (res.message || res.error)) || JSON.stringify(res) || 'Failed to apply finance option';
        showToast(msg, 'error');
      }
    } catch (error) {
      const msg = (error && (error.message || error.toString())) || 'Network error applying finance option';
      showToast(msg, 'error');
    }
});
</script>