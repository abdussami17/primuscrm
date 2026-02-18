{{-- Price Adjustment Modal --}}
<div id="priceAdjustmentModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                Inventory Price
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>

            <div class="modal-body pt-1">
                <form id="inventoryPriceForm" action="{{ route('inventory.update-price') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="inventory_id" id="priceInventoryId">

                    {{-- Default Visible Fields --}}
                    <div class="row mb-2 align-items-center">
                        <label class="col-5 col-form-label">MSRP:</label>
                        <div class="col-7">
                            <input type="text" name="msrp" id="priceMsrp" class="form-control" value="$0.00">
                        </div>
                    </div>

                    <div class="row mb-2 align-items-center">
                        <label class="col-5 col-form-label">Selling Price:</label>
                        <div class="col-7">
                            <input type="text" name="selling_price" id="priceSellingPrice" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-2 align-items-center">
                        <label class="col-5 col-form-label">Internet Price:</label>
                        <div class="col-7">
                            <input type="text" name="internet_price" id="priceInternetPrice" class="form-control">
                        </div>
                    </div>

                    {{-- Show More Toggle --}}
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-sm btn-light border border-1" id="toggleMoreFields">
                            Show More
                        </button>
                    </div>

                    {{-- Hidden Advanced Price Fields --}}
                    <div id="morePriceFields" style="display:none;">
                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Advertised Price:</label>
                            <div class="col-7">
                                <input type="text" name="advertised_price" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Start Date:</label>
                            <div class="col-7">
                                <input type="text" name="price_start_date" class="form-control cf-datepicker" id="priceStartDate" readonly>
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Expiration Date:</label>
                            <div class="col-7">
                                <input type="text" name="price_expiration_date" class="form-control cf-datepicker" id="priceExpirationDate" readonly>
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Lot Location:</label>
                            <div class="col-7">
                                <select name="lot_location" class="form-select">
                                    <option value="" hidden>Select Location</option>
                                    <option value="main">Main Lot</option>
                                    <option value="offsite">Offsite</option>
                                    <option value="service">Service</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Inventory Type:</label>
                            <div class="col-7">
                                <select name="condition" id="vehicleType" class="form-select">
                                    <option value="" hidden>Select Type</option>
                                    <option value="new">New</option>
                                    <option value="used">Pre-Owned</option>
                                    <option value="certified_pre_owned">CPO</option>
                                    <option value="demo">Demo</option>
                                    <option value="wholesale">Wholesale</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2 align-items-center">
                            <label class="col-5 col-form-label">Vehicle Cost:</label>
                            <div class="col-7">
                                <input type="number" name="vehicle_cost" class="form-control" placeholder="Enter internal cost">
                            </div>
                        </div>

                        {{-- Conditional Fields for Used/CPO --}}
                        <div id="usedCpoFields" style="display:none; border-top:1px dashed #ccc; margin-top:10px; padding-top:10px;">
                            <h6 class="fw-bold mb-2">Used / CPO Vehicle Details</h6>

                            <div class="row mb-2 align-items-center">
                                <label class="col-5 col-form-label">Book Value (via vAuto):</label>
                                <div class="col-7 d-flex gap-2">
                                    <input type="text" name="book_value" class="form-control" id="bookValue" placeholder="Fetching from vAuto..." readonly>
                                    <button type="button" id="fetchBookValue" class="btn btn-light border border-1 btn-sm">GET</button>
                                </div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <label class="col-5 col-form-label">Rebate Amount:</label>
                                <div class="col-7">
                                    <input type="number" name="rebate_amount" class="form-control" id="rebateAmount" placeholder="Enter rebate amount">
                                </div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <label class="col-5 col-form-label">Recon Cost:</label>
                                <div class="col-7">
                                    <input type="number" name="recon_cost" class="form-control" id="reconCost" placeholder="Enter reconditioning cost">
                                </div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <label class="col-5 col-form-label">Acquisition Source:</label>
                                <div class="col-7">
                                    <select name="acquisition_source" id="acquisitionSource" class="form-select">
                                        <option value="" hidden>Select Source</option>
                                        <option value="trade_in">Trade-in</option>
                                        <option value="auction">Auction</option>
                                        <option value="lease_return">Lease Return</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2 align-items-center">
                                <label class="col-5 col-form-label">Appraisal Value:</label>
                                <div class="col-7">
                                    <input type="number" name="appraisal_value" class="form-control" id="appraisalValue" placeholder="Enter appraisal value">
                                </div>
                            </div>
                        </div>

                        {{-- Last Modified By --}}
                        <div class="row mb-2 align-items-center border-top pt-2">
                            <label class="col-5 col-form-label">Last Modified By:</label>
                            <div class="col-7">
                                <select class="form-select" id="modificationHistory">
                                    <option hidden>View Modification History</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="inventoryPriceForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<style>
.flatpickr-input,
.modern-datepicker {
    background-color: #fff !important;
    border: 1px solid #ddd !important;
    color: #333;
    border-radius: 6px;
    padding: .45rem .6rem;
}

.flatpickr-calendar {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initPriceModal(container = document) {
        const toggleBtn = container.querySelector('#toggleMoreFields');
        const moreFields = container.querySelector('#morePriceFields');
        const vehicleType = container.querySelector('#vehicleType');
        const usedFields = container.querySelector('#usedCpoFields');
        const modal = container.querySelector('#priceAdjustmentModal');

        if (!toggleBtn || !moreFields) return;

        // Ensure initial state
        if (moreFields.style.display === '' || moreFields.style.display === 'block') {
            // keep as-is
        } else {
            moreFields.style.display = 'none';
        }
        toggleBtn.textContent = moreFields.style.display === 'none' ? 'Show More' : 'Show Less';

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isHidden = moreFields.style.display === 'none' || getComputedStyle(moreFields).display === 'none';
            if (isHidden) {
                moreFields.style.display = '';
                toggleBtn.textContent = 'Show Less';
            } else {
                moreFields.style.display = 'none';
                toggleBtn.textContent = 'Show More';
            }
        });

        function updateUsedCpoVisibility() {
            if (!usedFields || !vehicleType) return;
            const v = vehicleType.value;
            if (v === 'used' || v === 'certified_pre_owned') {
                usedFields.style.display = '';
            } else {
                usedFields.style.display = 'none';
            }
        }

        if (vehicleType) {
            vehicleType.addEventListener('change', updateUsedCpoVisibility);
            // run once to set initial visibility
            updateUsedCpoVisibility();
        }

        // If modal is shown/reset, ensure fields are in default state
        if (modal) {
            modal.addEventListener('show.bs.modal', function() {
                if (moreFields) {
                    moreFields.style.display = 'none';
                    toggleBtn.textContent = 'Show More';
                }
                updateUsedCpoVisibility();
            });
        }
    }

    initPriceModal();
    
    // AJAX submit handler for the price form — closes modal and shows toast on success
    (function initPriceFormAjax() {
        const form = document.getElementById('inventoryPriceForm');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const url = form.getAttribute('action');
            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            }).then(async (res) => {
                const contentType = res.headers.get('content-type') || '';
                if (contentType.indexOf('application/json') === -1) {
                    // Fallback: try to parse text and show generic success/failure
                    const text = await res.text();
                    try { console.warn('Unexpected non-JSON response for price update', text); } catch(e){}
                    if (res.ok) {
                        showPriceUpdatedToast('Price updated');
                        closePriceModal();
                    } else {
                        showPriceUpdatedToast('Failed to update price', true);
                    }
                    return;
                }

                const data = await res.json();
                if (data && data.success) {
                    // Close modal
                    closePriceModal();
                    // Show toast with message
                    showPriceUpdatedToast(data.message || 'Price updated successfully.');
                    // Dispatch event so other parts of the page can update displayed prices
                    try {
                        window.dispatchEvent(new CustomEvent('inventory.price.updated', { detail: data.inventory }));
                    } catch (err) {}
                } else {
                    showPriceUpdatedToast((data && data.message) ? data.message : 'Failed to update price', true);
                }
            }).catch(err => {
                console.error('Price update failed', err);
                showPriceUpdatedToast('Failed to update price', true);
            });
        });

        function closePriceModal() {
            const modalEl = document.getElementById('priceAdjustmentModal');
            if (!modalEl) return;
            try {
                const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                bsModal.hide();
            } catch (err) {}
        }

        function showPriceUpdatedToast(message, isError = false) {
            // create a Bootstrap toast element dynamically
            try {
                const toastId = 'priceToast' + Date.now();
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <div id="${toastId}" class="toast align-items-center text-bg-${isError ? 'danger' : 'success'} border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position:fixed; top:20px; right:20px; z-index:2000; min-width:200px;">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>`;

                document.body.appendChild(wrapper.firstElementChild);
                const toastEl = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
                toast.show();
                // remove after hidden
                toastEl.addEventListener('hidden.bs.toast', () => { try { toastEl.remove(); } catch(e){} });
            } catch (err) {
                // fallback
                alert(message);
            }
        }
    })();
});
</script>
@endpush