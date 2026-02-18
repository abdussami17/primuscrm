
    <style>
        /* Make the Add Customer offcanvas behave like a modal-md by constraining its width.
           Uses Bootstrap's --bs-offcanvas-width variable so behavior is responsive and consistent. */
        .customerProfileOffcanvas {
            --bs-offcanvas-width: 550px; /* modal-sm-ish */
        }

        /* On very small screens, allow full width (default mobile behavior) */
        @media (max-width: 576px) {
            .customerProfileOffcanvas {
                --bs-offcanvas-width: 100%;
            }
        }
    </style>

    <style>
        /* Stronger override in case other styles override the CSS variable. */
        #commonCanvas.customerProfileOffcanvas,
        .customerProfileOffcanvas.offcanvas,
        .customerProfileOffcanvas {
            width: 550px !important;
            max-width: 95vw !important;
            --bs-offcanvas-width: 550px !important;
        }

        /* Ensure the offcanvas dialog doesn't force extra large padding/content */
        #commonCanvas .offcanvas-body {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            background-color:#fff !important;
        }

        @media (max-width: 768px) {
            #commonCanvas.customerProfileOffcanvas,
            .customerProfileOffcanvas.offcanvas,
            .customerProfileOffcanvas {
                width: 100% !important;
                max-width: 100% !important;
                --bs-offcanvas-width: 100% !important;
            }
        }

            /* Scope background to the Add Customer offcanvas only */
            #commonCanvas.customerProfileOffcanvas .offcanvas-body{
                background-color: white !important;
            }
    </style>

<form id="addCustomerForm" method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
    @csrf
    
    <!-- Hidden fields to store the uploaded license image paths -->
    <input type="hidden" name="driver_license_front" id="driverLicenseFrontPath" value="">
    <input type="hidden" name="driver_license_back" id="driverLicenseBackPath" value="">
    
    <div class="row g-3">

        <div class="col-12">
            <div class="crm-header mb-0">
                Customer Information
            </div>
        </div>

        <!-- Profile Image -->
        {{-- <div class="col-12">
            <label class="form-label">Profile Image</label>
            <input type="file" class="form-control" name="profileImage" id="profileImage" accept="image/*">
            <small class="text-muted">Upload a profile picture (JPG, PNG, GIF)</small>
        </div> --}}

        <div class="col-md-6">
            <label class="form-label">Suffix</label>
            <select class="form-select" name="suffix">
                <option value="">Select</option>
                <option>Jr</option>
                <option>Sr</option>
            </select>
        </div>

        <!-- Business Name -->
        <div class="col-md-6">
            <label class="form-label">Business Name</label>
            <input type="text" class="form-control" name="businessName" id="businessName">
        </div>

        <!-- Name Fields -->
        <div class="col-md-4">
            <label class="form-label">First Name <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control" name="first_name" id="first_name" required>
                <button data-bs-toggle="modal" data-bs-target="#licenseScannerModal"
                    class="btn btn-light border-1 border" type="button" title="Scan Driver's License">
                    <i class="fa-solid fa-id-card"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Middle Name</label>
            <input type="text" class="form-control" name="middleName" id="middleName">
        </div>
        <div class="col-md-4">
            <label class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last_name" >
        </div>

        <!-- Phone Numbers -->
        <div class="col-md-4">
            <label class="form-label">Home Phone</label>
            <input type="tel" class="form-control" name="homePhone">
        </div>
        <div class="col-md-4">
            <label class="form-label">Cell Phone</label>
            <input type="tel" class="form-control" name="cellPhone" id="cellPhone">
        </div>
        <div class="col-md-4">
            <label class="form-label">Work Phone</label>
            <input type="tel" class="form-control" name="workPhone">
        </div>

        <!-- Email Section -->
        <div class="col-12">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <div id="email-container">
                <div class="email-group mb-2">
                    <div class="input-group">
                        <input type="email" class="form-control" name="emails[]" placeholder="Email" >
                        <div class="input-group-text">
                            <input type="radio" name="defaultEmail" value="0" title="Set as default" checked>
                        </div>
                        <button class="btn btn-outline-danger" type="button" onclick="removeEmailField(this)" style="display: none;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-link" onclick="addEmailField()">+ Add Email</button>
        </div>

        <!-- Mailing Address -->
        <div class="col-md-6">
            <label class="form-label">Street Address</label>
            <input type="text" class="form-control" id="streetAddressMain" name="streetAddress" placeholder="Street address">
        </div>
        <div class="col-md-6">
            <label class="form-label">City</label>
            <input type="text" class="form-control" name="city">
        </div>
        <div class="col-md-6">
            <label class="form-label">Province</label>
            <input type="text" class="form-control" name="state">
        </div>
        <div class="col-md-6">
            <label class="form-label">Postal Code</label>
            <input type="text" class="form-control" name="zipCode">
        </div>

        <!-- Co-Buyer -->
        <div class="col-12">
            <button class="btn btn-sm btn-outline-primary mb-2" type="button" onclick="toggleCoBuyer()">+ Co-Buyer</button>

            <div id="coBuyerFields" class="d-none">
                <div class="col-12">
                    <div class="crm-header mt-2">
                        Co-Buyer Information
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="co_buyer_first_name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="co_buyer_middle_name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="co_buyer_last_name">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="co_buyer_email">
                    </div>

                    <!-- Co-Buyer Phone Numbers -->
                    <div class="col-md-4">
                        <label class="form-label">Cell Number</label>
                        <input type="tel" class="form-control" name="co_buyer_cell_phone">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Work Number</label>
                        <input type="tel" class="form-control" name="co_buyer_work_phone">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Home Number</label>
                        <input type="tel" class="form-control" name="co_buyer_phone">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Street Address</label>
                        <input type="text" class="form-control" name="co_buyer_address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="co_buyer_city">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Province</label>
                        <input type="text" class="form-control" name="co_buyer_state">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="co_buyer_zip_code">
                    </div>
                </div>
            </div>
        </div>

        <!-- Deal Information Section -->
        <div class="col-12">
            <div class="crm-header mb-0">
                Deal Information
            </div>
        </div>

        <!-- Employee Dropdowns -->
        <div class="col-md-6">
            <label class="form-label">Assigned To <span class="text-danger">*</span></label>
            <select class="form-select" name="assignedTo" id="assignedTo" >
                <option value="" hidden>Select</option>
                @if (isset($users))
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Secondary Assigned To</label>
            <select class="form-select" name="secondaryAssignedTo">
                <option value="">Select</option>
                @if (isset($users))
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Sales Manager -->
        <div class="col-md-6">
            <label class="form-label">Assigned Manager</label>
            <select class="form-select" name="salesManager" id="salesManager">
                <option value="">Select</option>
                @if (isset($salesManagers))
                    @foreach ($salesManagers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Finance Manager</label>
            <select class="form-select" name="financeManager">
                <option value="">Select</option>
                @if (isset($financeManagers))
                    @foreach ($financeManagers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">BDC Agent <span class="text-danger">*</span></label>
            <select class="form-select" name="bdcAgent" >
                <option value="">Select</option>
                @if (isset($bdcAgents))
                    @foreach ($bdcAgents as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Lead Type -->
        <div class="col-md-6">
            <label class="form-label">Lead Type</label>
            <select class="form-select" name="leadType">
                <option value="">Select</option>
                <option value="Internet">Internet</option>
                <option value="Walk-In" selected>Walk-In</option>
                <option value="Phone Up">Phone Up</option>
                <option value="Text Up">Text Up</option>
                <option value="Website Chat">Website Chat</option>
                <option value="Import">Import</option>
                <option value="Wholesale">Wholesale</option>
                <option value="Lease Renewal">Lease Renewal</option>
            </select>
        </div>

        <!-- Source -->
        <div class="col-md-6">
            <label class="form-label">Source</label>
            <select class="form-select" name="leadSource">
                <option value="">Select</option>
                <option disabled style="font-weight:bold;">Automated Sources</option>
                <option value="facebook">Facebook</option>
                <option value="google_ads">Google Ads</option>
                <option value="dealer_website">Dealer Website</option>
                <option disabled>──────────</option>
                <option disabled style="font-weight:bold;">Manual Sources</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="walk_in">Walk-In</option>
                <option value="phone_up">Phone Up</option>
                <option value="text">Text</option>
                <option value="repeat_customer">Repeat Customer</option>
                <option value="referral">Referral</option>
                <option value="service_to_sales">Service to Sales</option>
                <option value="lease_renewal">Lease Renewal</option>
                <option value="drive_by">Drive By</option>
            </select>
        </div>

        <!-- Sales Type -->
        <div class="col-md-6">
            <label class="form-label">Sales Type <span class="text-danger">*</span></label>
            <select class="form-select" name="salesType" >
                <option value="">Select</option>
                <option value="Sales" selected>Sales Inquiry</option>
                <option value="Service">Service Inquiry</option>
                <option value="Parts">Parts Inquiry</option>
            </select>
        </div>

        <!-- Deal Type -->
        <div class="col-md-6">
            <label class="form-label">Deal Type</label>
            <select class="form-select" name="dealType">
                <option value="">Select</option>
                <option value="Finance">Finance</option>
                <option value="Cash">Cash</option>
                <option value="Lease">Lease</option>
            </select>
        </div>

        <!-- Inventory Type -->
        <div class="col-md-6">
            <label class="form-label">Inventory Type</label>
            <select class="form-select" name="inventoryType">
                <option value="">Select</option>
                <option value="New">New</option>
                <option value="Pre-Owned">Pre-Owned</option>
                <option value="CPO">CPO</option>
                <option value="Demo">Demo</option>
                <option value="Wholesale">Wholesale</option>
                <option value="Lease Renewal">Lease Renewal</option>
                <option value="Unknown">Unknown</option>
            </select>
        </div>

        <!-- Lead Status -->
        <div class="col-md-6">
            <label class="form-label">Lead Status <span class="text-danger">*</span></label>
            <select class="form-select" name="leadStatus" >
                <option value="">Select</option>
                <option value="Active" selected>Active</option>
                <option value="Duplicate">Duplicate</option>
                <option value="Invalid">Invalid</option>
                <option value="Lost">Lost</option>
                <option value="Sold">Sold</option>
                <option value="Wishlist">Wishlist</option>
                <option value="Buy-In">Buy-In</option>
            </select>
        </div>

    </div>

    <!-- Footer Buttons -->
    <div class="offcanvas-footer mt-4">
        <div class="row g-2">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-white w-100">Reset</button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary w-100">Add Customer</button>
            </div>
        </div>
    </div>
</form>

<!-- Driver's License Scanner Modal -->
<div class="modal fade" id="licenseScannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-id-card me-2"></i>Driver's License Scanner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted">Open front/back camera, capture image, then click <strong>Save Images</strong>.</p>

                <div class="row g-3">
                    <!-- FRONT -->
                    <div class="col-md-6">
                        <h6 class="mb-2">Front Side <span class="text-danger">*</span></h6>
                        <div class="preview-box position-relative" id="frontPreviewBox" style="min-height: 200px; border: 2px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <div id="frontPlaceholder">
                                <div class="text-center p-4">
                                    <i class="fa-solid fa-id-card fa-3x text-muted mb-3"></i>
                                    <div>
                                        <button class="btn btn-outline-primary me-2" id="openFrontCamBtn" type="button">
                                            <i class="fa-solid fa-camera me-1"></i> Open Camera
                                        </button>
                                        <label class="btn btn-outline-secondary mb-0">
                                            <i class="fa-solid fa-upload me-1"></i> Upload
                                            <input type="file" id="uploadFrontInput" accept="image/*" style="display: none;">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <img id="frontImg" src="" alt="Front of License" class="img-fluid" style="display:none; max-height: 250px; border-radius: 8px;">
                            <div class="video-wrap w-100" id="frontVideoWrap" style="display: none;">
                                <video id="cameraStreamFront" autoplay playsinline style="width: 100%; border-radius: 8px;"></video>
                            </div>
                            <!-- Scanning overlay -->
                            <div id="frontScanningOverlay" class="position-absolute w-100 h-100 d-none" style="background: rgba(0,0,0,0.5); border-radius: 8px; top: 0; left: 0;">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-white text-center">
                                        <div class="spinner-border mb-2" role="status"></div>
                                        <div>Processing...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <button class="btn btn-sm btn-outline-secondary me-1" id="captureFrontBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-camera"></i> Capture
                            </button>
                            <button class="btn btn-sm btn-outline-danger me-1" id="cancelFrontBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-times"></i> Cancel
                            </button>
                            <button class="btn btn-sm btn-outline-warning" id="retakeFrontBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-redo"></i> Retake
                            </button>
                        </div>
                    </div>

                    <!-- BACK -->
                    <div class="col-md-6">
                        <h6 class="mb-2">Back Side</h6>
                        <div class="preview-box position-relative" id="backPreviewBox" style="min-height: 200px; border: 2px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <div id="backPlaceholder">
                                <div class="text-center p-4">
                                    <i class="fa-solid fa-id-card fa-3x text-muted mb-3"></i>
                                    <div>
                                        <button class="btn btn-outline-primary me-2" id="openBackCamBtn" type="button">
                                            <i class="fa-solid fa-camera me-1"></i> Open Camera
                                        </button>
                                        <label class="btn btn-outline-secondary mb-0">
                                            <i class="fa-solid fa-upload me-1"></i> Upload
                                            <input type="file" id="uploadBackInput" accept="image/*" style="display: none;">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <img id="backImg" src="" alt="Back of License" class="img-fluid" style="display:none; max-height: 250px; border-radius: 8px;">
                            <div class="video-wrap w-100" id="backVideoWrap" style="display: none;">
                                <video id="cameraStreamBack" autoplay playsinline style="width: 100%; border-radius: 8px;"></video>
                            </div>
                            <!-- Scanning overlay -->
                            <div id="backScanningOverlay" class="position-absolute w-100 h-100 d-none" style="background: rgba(0,0,0,0.5); border-radius: 8px; top: 0; left: 0;">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="text-white text-center">
                                        <div class="spinner-border mb-2" role="status"></div>
                                        <div>Processing...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <button class="btn btn-sm btn-outline-secondary me-1" id="captureBackBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-camera"></i> Capture
                            </button>
                            <button class="btn btn-sm btn-outline-danger me-1" id="cancelBackBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-times"></i> Cancel
                            </button>
                            <button class="btn btn-sm btn-outline-warning" id="retakeBackBtn" type="button" style="display:none;">
                                <i class="fa-solid fa-redo"></i> Retake
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Status message -->
                <div id="scannerStatusMessage" class="alert mt-3 d-none" role="alert"></div>

                <!-- Hidden canvas for capture -->
                <canvas id="captureCanvas" style="display:none;"></canvas>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="closeScannerBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveImagesBtn" disabled>
                    <i class="fa-solid fa-save me-1"></i> Save Images
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addCustomerForm');
    if (!form) return;

    // Base URL to customer profiles (will be appended with /{id})
    const customerBase = "{{ url('customers') }}";

    async function handleSubmit(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Saving...'; }

        const formData = new FormData(form);

        // Resolve CSRF token from meta or hidden input
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
            form.querySelector('input[name="_token"]')?.value || '';

        try {
            const res = await fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            console.debug('Customer create response', res.status, res.redirected, res.headers.get('content-type'));

            // If server performed a redirect (non-AJAX flow), follow it
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            const contentType = res.headers.get('content-type') || '';
            if (contentType.indexOf('application/json') !== -1) {
                    const data = await res.json();
                    console.debug('Customer create JSON', data);

                    // Surface server-side validation errors (common Laravel 422 structure)
                    if (!res.ok) {
                        const messages = [];
                        if (data && data.errors) {
                            Object.keys(data.errors).forEach(k => {
                                if (Array.isArray(data.errors[k])) {
                                    data.errors[k].forEach(m => messages.push(m));
                                } else if (data.errors[k]) {
                                    messages.push(data.errors[k]);
                                }
                            });
                        } else if (data && data.message) {
                            messages.push(data.message);
                        }

                        if (messages.length) {
                            alert(messages.join('\n'));
                            return;
                        }
                    }

                    const id = data?.customer?.id || data?.id || data?.customer_id;
                    if (id) {
                        // Prefer opening the profile in the global offcanvas if available
                        if (typeof window.openCustomerProfile === 'function') {
                            try {
                                // hide the add-customer offcanvas first if present
                                const off = bootstrap.Offcanvas.getInstance(document.getElementById('addCustomerCanvas'));
                                if (off) off.hide();
                            } catch (e) {}
                            try { window.openCustomerProfile(id); } catch (e) { window.location.assign(customerBase + '/' + id); }
                        } else if (data && data.redirect_url) {
                            // fallback to server-provided redirect when offcanvas is unavailable
                            window.location.assign(data.redirect_url);
                        } else {
                            window.location.assign(customerBase + '/' + id);
                        }
                        return;
                    }

                    if (res.ok) {
                        window.location.reload();
                        return;
                    }
            }

            // Non-JSON fallback
            if (!res.ok) {
                try {
                    const text = await res.text();
                    alert('Error creating customer: ' + (text || res.status));
                } catch (e) {
                    window.location.reload();
                }
            } else {
                window.location.reload();
            }

        } catch (err) {
            console.error('Customer create error', err);
            // If AJAX fails, remove this handler and submit normally
            form.removeEventListener('submit', handleSubmit);
            form.submit();
        } finally {
            if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Add Customer'; }
        }
    }

    form.addEventListener('submit', handleSubmit);
});
</script>

<style>
.preview-box {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}
.preview-box:hover {
    border-color: #0d6efd !important;
}
.preview-box img {
    object-fit: contain;
}
.video-wrap video {
    max-height: 250px;
    object-fit: cover;
}
</style>

<style>
    /* Make form labels and section headers slightly bolder and easier to read */
    .crm-header {
        font-weight: 700;
        font-size: 1rem;
    }


</style>

<script>
(function() {
    'use strict';

    // State management
    const state = {
        frontStream: null,
        backStream: null,
        frontImageData: null,
        backImageData: null,
        isUploading: false
    };

    // DOM Elements
    const elements = {
        // Front side elements
        frontPlaceholder: document.getElementById('frontPlaceholder'),
        frontImg: document.getElementById('frontImg'),
        frontVideoWrap: document.getElementById('frontVideoWrap'),
        cameraStreamFront: document.getElementById('cameraStreamFront'),
        openFrontCamBtn: document.getElementById('openFrontCamBtn'),
        captureFrontBtn: document.getElementById('captureFrontBtn'),
        cancelFrontBtn: document.getElementById('cancelFrontBtn'),
        retakeFrontBtn: document.getElementById('retakeFrontBtn'),
        uploadFrontInput: document.getElementById('uploadFrontInput'),
        frontScanningOverlay: document.getElementById('frontScanningOverlay'),

        // Back side elements
        backPlaceholder: document.getElementById('backPlaceholder'),
        backImg: document.getElementById('backImg'),
        backVideoWrap: document.getElementById('backVideoWrap'),
        cameraStreamBack: document.getElementById('cameraStreamBack'),
        openBackCamBtn: document.getElementById('openBackCamBtn'),
        captureBackBtn: document.getElementById('captureBackBtn'),
        cancelBackBtn: document.getElementById('cancelBackBtn'),
        retakeBackBtn: document.getElementById('retakeBackBtn'),
        uploadBackInput: document.getElementById('uploadBackInput'),
        backScanningOverlay: document.getElementById('backScanningOverlay'),

        // Common elements
        captureCanvas: document.getElementById('captureCanvas'),
        saveImagesBtn: document.getElementById('saveImagesBtn'),
        statusMessage: document.getElementById('scannerStatusMessage'),
        modal: document.getElementById('licenseScannerModal'),

        // Hidden form fields
        driverLicenseFrontPath: document.getElementById('driverLicenseFrontPath'),
        driverLicenseBackPath: document.getElementById('driverLicenseBackPath')
    };

    // Utility functions
    function showStatus(message, type = 'info') {
        elements.statusMessage.className = `alert alert-${type} mt-3`;
        elements.statusMessage.textContent = message;
        elements.statusMessage.classList.remove('d-none');
    }

    function hideStatus() {
        elements.statusMessage.classList.add('d-none');
    }

    function updateSaveButton() {
        // Enable save button if at least front image is captured
        elements.saveImagesBtn.disabled = !state.frontImageData;
    }

    // Camera functions
    async function openCamera(side) {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });

            if (side === 'front') {
                state.frontStream = stream;
                elements.cameraStreamFront.srcObject = stream;
                elements.frontPlaceholder.style.display = 'none';
                elements.frontImg.style.display = 'none';
                elements.frontVideoWrap.style.display = 'block';
                elements.captureFrontBtn.style.display = 'inline-block';
                elements.cancelFrontBtn.style.display = 'inline-block';
                elements.retakeFrontBtn.style.display = 'none';
            } else {
                state.backStream = stream;
                elements.cameraStreamBack.srcObject = stream;
                elements.backPlaceholder.style.display = 'none';
                elements.backImg.style.display = 'none';
                elements.backVideoWrap.style.display = 'block';
                elements.captureBackBtn.style.display = 'inline-block';
                elements.cancelBackBtn.style.display = 'inline-block';
                elements.retakeBackBtn.style.display = 'none';
            }

            hideStatus();
        } catch (error) {
            console.error('Camera access error:', error);
            showStatus('Unable to access camera. Please check permissions or upload an image instead.', 'danger');
        }
    }

    function stopCamera(side) {
        if (side === 'front' && state.frontStream) {
            state.frontStream.getTracks().forEach(track => track.stop());
            state.frontStream = null;
            elements.cameraStreamFront.srcObject = null;
        } else if (side === 'back' && state.backStream) {
            state.backStream.getTracks().forEach(track => track.stop());
            state.backStream = null;
            elements.cameraStreamBack.srcObject = null;
        }
    }

    function captureImage(side) {
        const video = side === 'front' ? elements.cameraStreamFront : elements.cameraStreamBack;
        const canvas = elements.captureCanvas;
        const img = side === 'front' ? elements.frontImg : elements.backImg;
        const videoWrap = side === 'front' ? elements.frontVideoWrap : elements.backVideoWrap;
        const captureBtn = side === 'front' ? elements.captureFrontBtn : elements.captureBackBtn;
        const cancelBtn = side === 'front' ? elements.cancelFrontBtn : elements.cancelBackBtn;
        const retakeBtn = side === 'front' ? elements.retakeFrontBtn : elements.retakeBackBtn;

        // Set canvas size to video size
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw video frame to canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);

        // Get image data as base64
        const imageData = canvas.toDataURL('image/png');

        // Store image data
        if (side === 'front') {
            state.frontImageData = imageData;
        } else {
            state.backImageData = imageData;
        }

        // Stop camera and show captured image
        stopCamera(side);

        img.src = imageData;
        img.style.display = 'block';
        videoWrap.style.display = 'none';
        captureBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
        retakeBtn.style.display = 'inline-block';

        updateSaveButton();
        showStatus('Image captured successfully!', 'success');
    }

    function cancelCapture(side) {
        stopCamera(side);

        if (side === 'front') {
            elements.frontVideoWrap.style.display = 'none';
            elements.frontPlaceholder.style.display = 'block';
            elements.captureFrontBtn.style.display = 'none';
            elements.cancelFrontBtn.style.display = 'none';
        } else {
            elements.backVideoWrap.style.display = 'none';
            elements.backPlaceholder.style.display = 'block';
            elements.captureBackBtn.style.display = 'none';
            elements.cancelBackBtn.style.display = 'none';
        }

        hideStatus();
    }

    function retakeImage(side) {
        if (side === 'front') {
            state.frontImageData = null;
            elements.frontImg.style.display = 'none';
            elements.retakeFrontBtn.style.display = 'none';
            elements.frontPlaceholder.style.display = 'block';
        } else {
            state.backImageData = null;
            elements.backImg.style.display = 'none';
            elements.retakeBackBtn.style.display = 'none';
            elements.backPlaceholder.style.display = 'block';
        }

        updateSaveButton();
        hideStatus();
    }

    function handleFileUpload(side, file) {
        if (!file || !file.type.startsWith('image/')) {
            showStatus('Please select a valid image file.', 'danger');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const imageData = e.target.result;

            if (side === 'front') {
                state.frontImageData = imageData;
                elements.frontImg.src = imageData;
                elements.frontImg.style.display = 'block';
                elements.frontPlaceholder.style.display = 'none';
                elements.retakeFrontBtn.style.display = 'inline-block';
            } else {
                state.backImageData = imageData;
                elements.backImg.src = imageData;
                elements.backImg.style.display = 'block';
                elements.backPlaceholder.style.display = 'none';
                elements.retakeBackBtn.style.display = 'inline-block';
            }

            updateSaveButton();
            showStatus('Image uploaded successfully!', 'success');
        };

        reader.onerror = function() {
            showStatus('Failed to read the image file.', 'danger');
        };

        reader.readAsDataURL(file);
    }

    async function saveImages() {
        if (!state.frontImageData) {
            showStatus('Please capture or upload the front side of the license.', 'warning');
            return;
        }

        if (state.isUploading) return;
        state.isUploading = true;

        elements.saveImagesBtn.disabled = true;
        elements.saveImagesBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

        // Show scanning overlays
        elements.frontScanningOverlay.classList.remove('d-none');
        if (state.backImageData) {
            elements.backScanningOverlay.classList.remove('d-none');
        }

        try {
            const response = await fetch('/driver-license/upload', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]')?.value
                },
                body: JSON.stringify({
                    front_image: state.frontImageData,
                    back_image: state.backImageData
                })
            });

            const result = await response.json();

            if (result.success) {
                // Store the paths in hidden form fields
                if (result.front_path) {
                    elements.driverLicenseFrontPath.value = result.front_path;
                }
                if (result.back_path) {
                    elements.driverLicenseBackPath.value = result.back_path;
                }

                showStatus('License images saved successfully!', 'success');

                // Close modal after a short delay
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(elements.modal);
                    if (modal) modal.hide();
                }, 1000);

            } else {
                showStatus(result.message || 'Failed to save images.', 'danger');
            }

        } catch (error) {
            console.error('Upload error:', error);
            showStatus('An error occurred while saving the images. Please try again.', 'danger');
        } finally {
            state.isUploading = false;
            elements.saveImagesBtn.disabled = false;
            elements.saveImagesBtn.innerHTML = '<i class="fa-solid fa-save me-1"></i> Save Images';
            elements.frontScanningOverlay.classList.add('d-none');
            elements.backScanningOverlay.classList.add('d-none');
            updateSaveButton();
        }
    }

    function resetScanner() {
        // Stop any active camera streams
        stopCamera('front');
        stopCamera('back');

        // Reset state (but keep saved paths)
        state.frontImageData = null;
        state.backImageData = null;

        // Reset UI
        elements.frontImg.style.display = 'none';
        elements.frontImg.src = '';
        elements.frontPlaceholder.style.display = 'block';
        elements.frontVideoWrap.style.display = 'none';
        elements.captureFrontBtn.style.display = 'none';
        elements.cancelFrontBtn.style.display = 'none';
        elements.retakeFrontBtn.style.display = 'none';

        elements.backImg.style.display = 'none';
        elements.backImg.src = '';
        elements.backPlaceholder.style.display = 'block';
        elements.backVideoWrap.style.display = 'none';
        elements.captureBackBtn.style.display = 'none';
        elements.cancelBackBtn.style.display = 'none';
        elements.retakeBackBtn.style.display = 'none';

        // Reset file inputs
        elements.uploadFrontInput.value = '';
        elements.uploadBackInput.value = '';

        hideStatus();
        updateSaveButton();
    }

    // Event listeners
    function initEventListeners() {
        // Front camera buttons
        elements.openFrontCamBtn.addEventListener('click', () => openCamera('front'));
        elements.captureFrontBtn.addEventListener('click', () => captureImage('front'));
        elements.cancelFrontBtn.addEventListener('click', () => cancelCapture('front'));
        elements.retakeFrontBtn.addEventListener('click', () => retakeImage('front'));

        // Back camera buttons
        elements.openBackCamBtn.addEventListener('click', () => openCamera('back'));
        elements.captureBackBtn.addEventListener('click', () => captureImage('back'));
        elements.cancelBackBtn.addEventListener('click', () => cancelCapture('back'));
        elements.retakeBackBtn.addEventListener('click', () => retakeImage('back'));

        // File upload inputs
        elements.uploadFrontInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                handleFileUpload('front', e.target.files[0]);
            }
        });

        elements.uploadBackInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                handleFileUpload('back', e.target.files[0]);
            }
        });

        // Save button
        elements.saveImagesBtn.addEventListener('click', saveImages);

        // Modal events
        elements.modal.addEventListener('hidden.bs.modal', resetScanner);
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEventListeners);
    } else {
        initEventListeners();
    }

    // Expose functions globally if needed
    window.toggleCoBuyer = function() {
        const section = document.getElementById('coBuyerFields');
        if (section) {
            section.classList.toggle('d-none');
        }
    };

    window.addEmailField = function() {
        const container = document.getElementById('email-container');
        const emailCount = container.querySelectorAll('.email-group').length;
        
        const newEmailGroup = document.createElement('div');
        newEmailGroup.className = 'email-group mb-2';
        newEmailGroup.innerHTML = `
            <div class="input-group">
                <input type="email" class="form-control" name="emails[]" placeholder="Email">
                <div class="input-group-text">
                    <input type="radio" name="defaultEmail" value="${emailCount}" title="Set as default">
                </div>
                <button class="btn btn-outline-danger" type="button" onclick="removeEmailField(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newEmailGroup);
        updateDeleteButtons();
    };

    window.removeEmailField = function(button) {
        const emailGroup = button.closest('.email-group');
        const container = document.getElementById('email-container');
        
        if (container.querySelectorAll('.email-group').length > 1) {
            emailGroup.remove();
            updateDeleteButtons();
            updateRadioValues();
        } else {
            alert('At least one email is required');
        }
    };

    window.updateDeleteButtons = function() {
        const emailGroups = document.querySelectorAll('.email-group');
        emailGroups.forEach((group, index) => {
            const deleteBtn = group.querySelector('.btn-outline-danger');
            if (deleteBtn) {
                deleteBtn.style.display = emailGroups.length > 1 ? 'block' : 'none';
            }
        });
    };

    window.updateRadioValues = function() {
        const emailGroups = document.querySelectorAll('.email-group');
        emailGroups.forEach((group, index) => {
            const radio = group.querySelector('input[type="radio"]');
            if (radio) {
                radio.value = index;
            }
        });
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateDeleteButtons();
    });
})();
</script>