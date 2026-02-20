@props(['tradeIn' => null, 'conditionGrades' => []])

<form id="tradeInForm" method="POST" action="{{ route('trade-ins.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="deal_id" data-deal-id-input>

    @if ($tradeIn)
        @method('PUT')
        <input type="hidden" name="trade_in_id" value="{{ $tradeIn->id }}">
    @endif

    <div class="row g-3">

        {{-- VIN & Odometer --}}
        <div class="col-md-6">
            <label class="form-label">
                VIN <span class="text-danger">*</span>
                <i class="ti ti-search ms-1" style="cursor:pointer" id="decodeVinBtn" title="Decode VIN"></i>
            </label>
            <input type="text" class="form-control" id="vinInput" name="vin" placeholder="Enter VIN"
                value="{{ $tradeIn->vin ?? old('vin') }}" maxlength="17" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Odometer (KM) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="odometerInput" name="odometer"
                placeholder="Enter Odometer in KM" value="{{ $tradeIn->odometer ?? old('odometer') }}" required>
        </div>

        {{-- Year / Make / Model --}}
        <div class="col-md-4">
            <label class="form-label">Year <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="vehicleYear" name="year"
                value="{{ $tradeIn->year ?? old('year') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Make <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="vehicleMake" name="make"
                value="{{ $tradeIn->make ?? old('make') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Model <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="vehicleModel" name="model"
                value="{{ $tradeIn->model ?? old('model') }}">
        </div>

        {{-- Appraised By / Date --}}
        <div class="col-md-6">
            <label class="form-label">Appraised By <span class="text-danger">*</span></label>
            <select class="form-select" name="appraised_by" required>
                <option value="">Select Appraiser</option>
                <option value="manager1">Manager 1</option>
                <option value="manager2">Manager 2</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Appraisal Date/Time <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control" name="appraisal_datetime"
                value="{{ $tradeIn->appraisal_datetime ?? old('appraisal_datetime') }}" required>
        </div>

        {{-- Trade Allowance / Lien --}}
        <div class="col-md-6">
            <label class="form-label">Trade Allowance <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="tradeAllowance" name="trade_allowance"
                placeholder="Enter Trade Allowance" value="{{ $tradeIn->trade_allowance ?? old('trade_allowance') }}"
                required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Lien Payout</label>
            <input type="number" class="form-control" id="lienPayout" name="lien_payout"
                placeholder="Enter Lien Payout" value="{{ $tradeIn->lien_payout ?? old('lien_payout') }}">
        </div>

        {{-- Condition / Values --}}
        <div class="col-md-4">
            <label class="form-label">Condition Grade</label>
            <select class="form-select" name="condition_grade" id="conditionGrade">
                <option value="">Select Grade</option>
                @foreach ($conditionGrades as $value => $label)
                    <option value="{{ $value }}"
                        {{ ($tradeIn->condition_grade ?? old('condition_grade')) === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Market Value</label>
            <input type="number" class="form-control" id="marketValue" name="market_value"
                placeholder="Enter Market Value" value="{{ $tradeIn->market_value ?? old('market_value') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">ACV</label>
            <input type="number" class="form-control" id="acvValue" name="acv" placeholder="Enter ACV"
                value="{{ $tradeIn->acv ?? old('acv') }}">
        </div>

        {{-- Recon --}}
        <div class="col-md-12">
            <label class="form-label">Recon Estimate</label>
            <textarea class="form-control" name="recon_estimate" rows="2"
                placeholder="Enter reconditioning estimate details">{{ $tradeIn->recon_estimate ?? old('recon_estimate') }}</textarea>
        </div>

        {{-- Video --}}
        <div class="col-md-6">
            <label class="form-label">Video Walkaround</label>
            <input type="file" class="form-control" name="video_walkaround" accept="video/*">
            <small class="text-muted">Upload video walkaround of the vehicle</small>
        </div>

        {{-- Photos --}}
        <div class="col-md-6">
            <label class="form-label">Photos <span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="photos[]" accept="image/*" multiple required>
            <small class="text-muted">Upload at least 1 photo (multiple allowed)</small>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="col-12 mt-4">
            <div class="d-flex gap-3 justify-content-between align-items-center flex-wrap">

                <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#serviceAppointmentModal">
                    <i class="ti ti-calendar-plus"></i>
                    New Service Appointment
                </button>

                <button type="submit" class="btn btn-success btn-lg d-flex align-items-center gap-2 px-4"
                    id="sendToVAuto">
                    <i class="ti ti-send"></i>
                    Send to V-Auto
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="col-12">
            <div id="tradeInMessages"></div>
        </div>

    </div>
</form>

<div class="modal fade" id="serviceAppointmentModal" tabindex="-1" aria-labelledby="serviceAppointmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceAppointmentModalLabel">
                    <i class="ti ti-calendar-plus me-2"></i>New Service Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="serviceAppointmentForm">
                    <div class="row g-3">

                        <!-- RO Number -->
                        <div class="col-md-6">
                            <label class="form-label">RO Number</label>
                            <input type="text" class="form-control" disabled id="roNumber"
                                placeholder="Auto-generated">
                        </div>

                        <!-- Service Date -->
                        <div class="col-md-6">
                            <label class="form-label">Service Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="serviceDate" required>
                        </div>

                        <!-- Internal Department -->
                        <div class="col-md-6">
                            <label class="form-label">Internal Department <span class="text-danger">*</span></label>
                            <select class="form-select" id="internalDepartment" required>
                                <option value="">Select Department</option>
                                <option value="service">Service</option>
                                <option value="sales">Sales</option>
                                <option value="detail">Detail</option>
                                <option value="body">Body</option>
                            </select>
                        </div>

                        <!-- Service Type -->
                        <div class="col-md-6">
                            <label class="form-label">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="serviceType" required>
                                <option value="">Select Service Type</option>
                                <option value="customer_pay">Customer Pay</option>
                                <option value="internal">Internal</option>
                                <option value="warranty">Warranty</option>
                            </select>
                            <small class="text-muted">For new appointments only; blank for DMS integration</small>
                        </div>

                        <!-- Labor -->
                        <div class="col-md-4">
                            <label class="form-label">Labor ($)</label>
                            <input type="number" class="form-control" id="laborCost" placeholder="0.00"
                                step="0.01">
                        </div>

                        <!-- Parts -->
                        <div class="col-md-4">
                            <label class="form-label">Parts ($)</label>
                            <input type="number" class="form-control" id="partsCost" placeholder="0.00"
                                step="0.01">
                        </div>

                        <!-- Total -->
                        <div class="col-md-4">
                            <label class="form-label">Total ($)</label>
                            <input type="number" class="form-control" id="totalCost" placeholder="0.00"
                                step="0.01" readonly>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="serviceDescription" rows="3" placeholder="Enter service description"></textarea>
                        </div>

                        <!-- Technician -->
                        <div class="col-md-6">
                            <label class="form-label">Technician <span class="text-danger">*</span></label>
                            <select class="form-select" id="technician" required>
                                <option value="">Select Technician</option>
                                <option value="tech1">Technician 1</option>
                                <option value="tech2">Technician 2</option>
                                <option value="tech3">Technician 3</option>
                            </select>
                            <small class="text-muted">For new appointments only; blank for DMS integration</small>
                        </div>

                        <!-- Completed Date -->
                        <div class="col-md-6">
                            <label class="form-label">Completed Date</label>
                            <input type="date" class="form-control" id="completedDate">
                        </div>

                        <!-- Current KMs -->
                        <div class="col-md-6">
                            <label class="form-label">Current KMs</label>
                            <input type="number" class="form-control" id="currentKms"
                                placeholder="Enter current kilometers">
                        </div>

                        <!-- Service Advisor -->
                        <div class="col-md-6">
                            <label class="form-label">Service Advisor <span class="text-danger">*</span></label>
                            <select class="form-select" id="serviceAdvisor" required>
                                <option value="">Select Service Advisor</option>
                                <@if (isset($serviceAdvisor))
                                    @foreach ($serviceAdvisor as $user)
                                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                                    @endforeach
                                    @endif
                            </select>
                            <small class="text-muted">For new appointments only; blank for DMS integration</small>
                        </div>

                        <!-- Video Walkaround -->
                        <div class="col-md-6">
                            <label class="form-label">Video Walkaround</label>
                            <input type="file" class="form-control" id="serviceVideoWalkaround" accept="video/*">
                            <small class="text-muted">Option to upload video or link</small>
                        </div>

                        <!-- Photos -->
                        <div class="col-md-6">
                            <label class="form-label">Photos</label>
                            <input type="file" class="form-control" id="servicePhotos" accept="image/*" multiple>
                            <small class="text-muted">Similar to Trade-In tab</small>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="saveServiceAppointment">
                    <i class="ti ti-device-floppy me-1"></i>Save Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-calculate Total
    function calculateTotal() {
        const labor = parseFloat(document.getElementById('laborCost')?.value || 0);
        const parts = parseFloat(document.getElementById('partsCost')?.value || 0);
        const total = labor + parts;
        document.getElementById('totalCost').value = total.toFixed(2);
    }

    document.getElementById('laborCost')?.addEventListener('input', calculateTotal);
    document.getElementById('partsCost')?.addEventListener('input', calculateTotal);

    // Save Service Appointment
    document.getElementById('saveServiceAppointment')?.addEventListener('click', function() {
        const form = document.getElementById('serviceAppointmentForm');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Build payload with snake_case keys expected by backend
        const laborVal = parseFloat(document.getElementById('laborCost')?.value || 0) || 0;
        const partsVal = parseFloat(document.getElementById('partsCost')?.value || 0) || 0;
        const totalValEl = document.getElementById('totalCost');
        const totalVal = totalValEl && totalValEl.value ? parseFloat(totalValEl.value) || (laborVal +
            partsVal) : (laborVal + partsVal);

        // Build appointment payload with both camelCase (server validation) and snake_case (backend DB)
        const appointmentData = {
            // camelCase (expected by controller validation)
            roNumber: document.getElementById('roNumber').value || 'AUTO-' + Date.now(),
            serviceDate: document.getElementById('serviceDate').value,
            internalDepartment: document.getElementById('internalDepartment').value,
            serviceType: document.getElementById('serviceType').value,
            laborCost: laborVal,
            partsCost: partsVal,
            totalCost: totalVal,
            description: document.getElementById('serviceDescription').value,
            technician: document.getElementById('technician').value,
            completedDate: document.getElementById('completedDate').value,
            currentKms: document.getElementById('currentKms').value,
            serviceAdvisor: document.getElementById('serviceAdvisor')?.value || '',
            deals_id: AppState.currentDealId,
            // snake_case duplicates for compatibility
            ro_number: document.getElementById('roNumber').value || 'AUTO-' + Date.now(),
            service_date: document.getElementById('serviceDate').value,
            internal_department: document.getElementById('internalDepartment').value,
            service_type: document.getElementById('serviceType').value,
            labor_cost: laborVal,
            parts_cost: partsVal,
            total_cost: totalVal,
            completed_date: document.getElementById('completedDate').value,
            current_kms: document.getElementById('currentKms').value,
            service_advisor: document.getElementById('serviceAdvisor')?.value || '',
        };

        // API call to save appointment
        const csrfToken = (window.AppState && window.AppState.csrfToken) || document.querySelector(
            'meta[name="csrf-token"]')?.content || '';
        fetch('/api/service-appointment/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify(appointmentData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    succeesAlert('New Service appointment has been added successfully!');
                    // Safely obtain a modal instance (getInstance may be null if modal wasn't created via JS)
                    try {
                        const modalEl = document.getElementById('serviceAppointmentModal');
                        if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const modalInstance = (bootstrap.Modal.getInstance ? bootstrap.Modal
                                    .getInstance(modalEl) : null) ||
                                (bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(
                                    modalEl) : new bootstrap.Modal(modalEl));
                            if (modalInstance && typeof modalInstance.hide === 'function') modalInstance
                                .hide();
                        }
                    } catch (e) {
                        console.warn('Could not hide serviceAppointmentModal', e);
                    }
                    form.reset();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(err => {
                alert('Network error: ' + err.message);
            });
    });
</script>

{{-- VIN Decode Script (minimal) --}}
<script>
document.getElementById('decodeVinBtn')?.addEventListener('click', async function() {
    const vin = document.getElementById('vinInput').value.trim().toUpperCase();

    if (vin.length !== 17) {
        showToast('Please enter a valid 17-character VIN', 'error');
        return;
    }

    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    try {
        const response = await fetch(`/api/vin/decode/${vin}`);
        const data = await response.json();

        if (data.success) {
            document.getElementById('vehicleYear').value = data.data.year || '';
            document.getElementById('vehicleMake').value = data.data.make || '';
            document.getElementById('vehicleModel').value = data.data.model || '';
            showToast('VIN found in inventory');
        } else {
            showToast(data.message, 'error');
        }

    } catch (e) {
        showToast('Error decoding VIN', 'error');
    }

    this.disabled = false;
    this.innerHTML = 'Decode';
});

    // Form submit via AJAX
    document.getElementById('tradeInForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formEl = this;
        const formData = new FormData(formEl);

        // Determine whether this is an update (PUT) or create (POST)
        const isUpdate = Boolean(formEl.querySelector('input[name="trade_in_id"]'));
        const desiredMethod = isUpdate ? 'PUT' : 'POST';

        // If there are file inputs, keep FormData; otherwise we can send JSON
        const hasFiles = Array.from(formEl.querySelectorAll('input[type="file"]')).some(i => i.files && i
            .files.length > 0);

        const csrfToken = (window.AppState && window.AppState.csrfToken) || document.querySelector(
            'meta[name="csrf-token"]')?.content || '';

        const headers = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        };

        // Servers that disallow PUT should accept POST + X-HTTP-Method-Override
        const useMethodOverride = desiredMethod !== 'POST';
        if (useMethodOverride) headers['X-HTTP-Method-Override'] = desiredMethod;

        try {
            const fetchOptions = {
                method: 'POST', // always POST at transport level
                headers,
                credentials: 'same-origin'
            };

            if (hasFiles) {
                // send multipart/form-data; browser will set the correct Content-Type
                fetchOptions.body = formData;
            } else {
                // send JSON body
                const payload = Object.fromEntries(formData.entries());
                headers['Content-Type'] = 'application/json';
                fetchOptions.body = JSON.stringify(payload);
            }

            const res = await fetch(formEl.action, fetchOptions);
            const contentType = (res.headers.get('content-type') || '').toLowerCase();
            let data = null;
            if (contentType.includes('application/json')) {
                data = await res.json().catch(() => null);
            } else {
                const text = await res.text().catch(() => null);
                try {
                    data = text ? JSON.parse(text) : null;
                } catch (e) {
                    data = {
                        success: false,
                        text
                    };
                }
            }

            if (!res.ok) {
                const msg = (data && (data.message || data.error)) || `Server returned ${res.status}`;
                throw new Error(msg);
            }

            if (data && data.success) {
                showToast('Trade-in saved successfully');
            } else {
                showToast(data?.message || 'Trade-in saved', 'success');
            }
        } catch (error) {
            console.error('Trade-in save failed', error);
            showToast(error.message || 'Failed to save trade-in', 'error');
        }
    });
</script>
