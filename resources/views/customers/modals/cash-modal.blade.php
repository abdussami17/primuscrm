{{-- Cash Modal - resources/views/customers/modals/cash-modal.blade.php --}}

<div class="modal fade finance-custom-modal modal-cash"
     id="cashModal"
     tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
        <span>Cash Details</span>
        <button type="button" data-bs-dismiss="modal" aria-label="Close">
            <i class="isax isax-close-circle"></i>
        </button>
    </div>

      <div class="modal-body">
        <form id="cashForm" class="row g-3">



          <div class="col-md-3">
            <label class="form-label">Payment Type</label>
            <select class="form-select" name="payment_method">
              <option selected disabled>Select Payment Type</option>
              <option value="certified_cheque">Certified Cheque</option>
              <option value="wire">Wire</option>
              <option value="debit">Debit</option>
              <option value="eft">EFT</option>
              <option value="cash">Cash</option>
              <option value="credit_card">Credit Card</option>
            </select>
            <small class="text-muted d-block mt-1">
              (Auto-fill from DMS entry if available)
            </small>
          </div>

          <div class="col-md-3">
            <label class="form-label">Deposit Received ($)</label>
            <input type="number"
                   class="form-control"
                   name="deposit_received"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Total Cash Received ($)</label>
            <input type="number"
                   class="form-control"
                   name="total_cash_received"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Trade Allowance ($)</label>
            <input type="number"
                   class="form-control"
                   id="cashTradeIn"
                   name="trade_in_value"
                   readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Lien Payout ($)</label>
            <input type="number"
                   class="form-control"
                   name="lien_payout"
                   readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Admin Fee ($)</label>
            <input type="number"
                   class="form-control"
                   id="cashAdminFee"
                   name="admin_fee"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Doc Fee ($)</label>
            <input type="number"
                   class="form-control"
                   id="cashDocFee"
                   name="doc_fee"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Total Sale Amount ($)</label>
            <input type="number"
                   class="form-control"
                   id="cashTotalSale"
                   name="total_sale_amount"
                   readonly>
          </div>

          <div class="col-md-3">
            <label class="form-label">Delivered Date</label>
            <input type="date"
                   class="form-control"
                   name="delivered_date">
          </div>

          <div class="col-md-3">
            <label class="form-label">Sold Date</label>
            <input type="date"
                   class="form-control"
                   name="sold_date">
          </div>



          <div class="col-md-3">
            <label class="form-label">Front-End Gross ($)</label>
            <input type="number"
                   class="form-control"
                   name="front_end_gross"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Back-End Gross ($)</label>
            <input type="number"
                   class="form-control"
                   name="back_end_gross"
                   step="0.01"
                   value="0">
          </div>

          <div class="col-md-3">
            <label class="form-label">Total Gross ($)</label>
            <input type="number"
                   class="form-control"
                   id="cashTotalGross"
                   readonly>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="applyCashBtn">
          Save Cash
        </button>
      </div>

    </div>
  </div>
</div>
<script>
document.getElementById('cashForm')
  ?.addEventListener('input', calculateCash);

function calculateCash() {
  const tradeIn = parseFloat(document.getElementById('cashTradeIn')?.value) || 0;
  const adminFee = parseFloat(document.getElementById('cashAdminFee')?.value) || 0;
  const docFee = parseFloat(document.getElementById('cashDocFee')?.value) || 0;

  const totalSale = adminFee + docFee - tradeIn;
  document.getElementById('cashTotalSale').value =
    totalSale.toFixed(2);
}

document.getElementById('applyCashBtn')
  ?.addEventListener('click', async () => {
    const dealId = AppState.currentDealId;
    if (!dealId) {
      showToast('Please select a deal first', 'error');
      return;
    }

    const formData = new FormData(document.getElementById('cashForm'));
    formData.append('deal_id', dealId);
    formData.append('payment_type', 'cash');

    try {
      const res = await api(
        `/api/deals/${dealId}/payment`,
        'POST',
        Object.fromEntries(formData)
      );
      if (res && (res.success === true || String(res.success) === 'true')) {
        showToast('Cash purchase saved successfully');
        try {
          const modalEl = document.getElementById('cashModal');
          if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = (bootstrap.Modal.getInstance ? bootstrap.Modal.getInstance(modalEl) : null)
              || (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(modalEl) : new bootstrap.Modal(modalEl));
            if (modalInstance && typeof modalInstance.hide === 'function') modalInstance.hide();
          }
        } catch (e) { console.warn('Could not hide cashModal', e); }
      } else {
        const msg = (res && (res.message || res.error)) || JSON.stringify(res) || 'Failed to save cash purchase';
        showToast(msg, 'error');
      }
    } catch (error) {
      const msg = (error && (error.message || error.toString())) || 'Network error saving cash purchase';
      showToast(msg, 'error');
    }
  });
</script>
