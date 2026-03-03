{{-- Customer Details View - resources/views/customers/details.blade.php --}}

@php
    $customerId = $customer->id ?? request()->get('customer_id');
@endphp
<script>
    // Telnyx click-to-call and send-sms handlers
    document.addEventListener('click', function(e) {
        const callBtn = e.target.closest('.telnyx-call-btn');
        const smsBtn = e.target.closest('.telnyx-sms-btn');
        const videoBtn = e.target.closest('.telnyx-video-btn');
        if (callBtn) {
            const to = callBtn.dataset.phone || document.getElementById('cell_phone_input')?.value;
            if (!to) return showToast('No phone number available', 'error');
            callBtn.disabled = true;
            callBtn.innerHTML = '<i class="ti ti-loader rotate"></i>';
            fetch('/telnyx/call', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.AppState?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content
                },
                credentials: 'same-origin',
                body: JSON.stringify({ to })
            }).then(r => r.json()).then(data => {
                if (data && data.success) showToast('Call initiated to ' + to, 'success');
                else showToast(data?.message || 'Call failed', 'error');
            }).catch(err => {
                console.error('Call error', err);
                showToast('Call error', 'error');
            }).finally(() => {
                callBtn.disabled = false;
                callBtn.innerHTML = '<i class="ti ti-phone"></i>';
            });
        }
        if (smsBtn) {
            const to = smsBtn.dataset.phone || document.getElementById('cell_phone_input')?.value;
            if (!to) return showToast('No phone number available', 'error');
            // Show SMS modal instead of prompt
            const firstName = document.getElementsByName('first_name')[0]?.value || '';
            const lastName  = document.getElementsByName('last_name')[0]?.value  || '';
            const name = [firstName, lastName].filter(Boolean).join(' ') || to;
            document.getElementById('csSmsTo').value = to;
            document.getElementById('csSmsRecipientName').textContent = name;
            document.getElementById('csSmsBody').value = '';
            document.getElementById('csSmsCharCount').textContent = '0 / 1,600';
            document.getElementById('csSmsStatus').textContent = '';
            document.getElementById('csSmsStatus').className = 'small';
            const sendBtn = document.getElementById('csSmsSendBtn');
            sendBtn.disabled = false;
            sendBtn.innerHTML = 'Send <i class="ti ti-send ms-1"></i>';
            const modal = new bootstrap.Modal(document.getElementById('customerSmsModal'));
            modal.show();
            setTimeout(() => document.getElementById('csSmsBody').focus(), 300);
        }
        if (videoBtn) {
            const to = videoBtn.dataset.phone || document.getElementById('cell_phone_input')?.value;
            if (!to) return showToast('No phone number available', 'error');
            if (!confirm('Start a video call to ' + to + '?')) return;
            videoBtn.disabled = true;
            videoBtn.innerHTML = '<i class="ti ti-loader rotate"></i>';
            fetch('/telnyx/video', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.AppState.csrfToken || document.querySelector(
                        'meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    to
                })
            }).then(r => r.json()).then(data => {
                if (data && data.success) {
                    showToast('Video call initiated', 'success');
                    // If provider returns a join URL (optional), open it
                    try {
                        const join = data.data && (data.data.join_url || data.data.data && data.data
                            .data.join_url);
                        if (join) window.open(join, '_blank');
                    } catch (e) {
                        /* ignore */ }
                } else showToast(data.message || 'Video call failed', 'error');
            }).catch(err => {
                console.error('Video call error', err);
                showToast('Video call error', 'error');
            }).finally(() => {
                videoBtn.disabled = false;
                videoBtn.innerHTML = '<i class="ti ti-device-desktop"></i>';
            });
        }
    });

    window.AppState = window.AppState || {
        customerId: {{ $customerId }},
        currentDealId: null,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.content
    };
    // Provide any existing social links (may be empty if model columns differ)
    window.customerSocial = {
        facebook: "{{ $customer->facebook_url ?? ($customer->facebook ?? '') }}",
        instagram: "{{ $customer->instagram_url ?? ($customer->instagram ?? '') }}",
        twitter: "{{ $customer->twitter_url ?? ($customer->twitter ?? '') }}",
        youtube: "{{ $customer->youtube_url ?? ($customer->youtube ?? '') }}",
        tiktok: "{{ $customer->tiktok_url ?? ($customer->tiktok ?? '') }}",
        reddit: "{{ $customer->reddit_url ?? ($customer->reddit ?? '') }}"
    };
    // Simple API helper
    async function api(url, method = 'GET', data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': AppState.csrfToken
            },
            // Ensure cookies / session are sent so Laravel session auth works
            credentials: 'same-origin'
        };
        // Some environments (or routes) only accept POST/GET; spoof PATCH/PUT/DELETE via header
        if (['PATCH', 'PUT', 'DELETE'].includes(method.toUpperCase())) {
            options.method = 'POST';
            options.headers['X-HTTP-Method-Override'] = method.toUpperCase();
        }
        if (data) options.body = JSON.stringify(data);
        const response = await fetch(url, options);
        return response.json();
    }

    // Toast notification
    function showToast(a, b = 'success') {
        // Flexible showToast: accepts either (message, type) or (type, message)
        let message = '';
        let type = 'success';

        const arg1 = (typeof a === 'string' || typeof a === 'number') ? String(a) : a;
        const arg2 = (typeof b === 'string' || typeof b === 'number') ? String(b) : b;

        const knownTypes = ['error', 'danger', 'success', 'info', 'warning'];

        if (knownTypes.includes(String(arg1).toLowerCase()) && typeof arg2 === 'string') {
            // Called as (type, message)
            type = String(arg1).toLowerCase();
            message = String(arg2);
        } else {
            // Called as (message, type?)
            message = String(arg1 || '');
            type = String(arg2 || 'success').toLowerCase();
        }

        // Normalize type to bootstrap alert class
        const alertType = (type === 'error') ? 'danger' : (type === 'danger' ? 'danger' : (type || 'success'));
        let icon = (alertType === 'danger') ? 'x' : 'check';

        // If message is missing or accidentally equals the type keyword (e.g. showToast('error'))
        // provide a sensible default message instead of displaying the literal keyword.
        const lowerMsg = (message || '').toString().toLowerCase();
        if (!message || lowerMsg === alertType || ['error', 'success', 'warning', 'info', 'danger'].includes(
            lowerMsg)) {
            if (alertType === 'danger') message = 'An error occurred';
            else if (alertType === 'success') message = 'Saved successfully';
            else message = alertType.charAt(0).toUpperCase() + alertType.slice(1);
            icon = (alertType === 'danger') ? 'x' : 'check';
        }

        // Prefer toastr/Swal if available
        if (typeof toastr !== 'undefined' && toastr[alertType]) {
            try {
                toastr[alertType](message);
                return;
            } catch (e) {
                /* fallback below */ }
        }
        if (typeof Swal !== 'undefined' && Swal.fire) {
            try {
                Swal.fire({
                    icon: alertType === 'danger' ? 'error' : alertType,
                    title: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            } catch (e) {
                /* fallback below */ }
        }

        // DOM fallback
        const toast = document.createElement('div');
        toast.className = `alert alert-${alertType} position-fixed`;
        toast.style.cssText = 'top:20px;right:20px;z-index:9999;min-width:250px;';
        toast.innerHTML = `<i class="ti ti-${icon} me-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Select deal and show related sections
    function selectDeal(dealId) {
        AppState.currentDealId = dealId;

        document.querySelectorAll('[data-requires-deal]').forEach(el => {
            el.style.display = (el.style.display === 'block') ? 'none' : 'block';
        });

        document.querySelectorAll('[data-deal-id-input]').forEach(el => {
            el.value = dealId;
        });

        // Trigger custom event for components to load their data
        document.dispatchEvent(
            new CustomEvent('deal:selected', {
                detail: {
                    dealId,
                    customerId: AppState.customerId
                }
            })
        );
    }
</script>
<style>
    .customerProfileOffcanvas .offcanvas-body {
        background-color: var(--cf-primary)
    }
</style>
<div class="row g-3" data-customer-id="{{ $customerId }}">

    {{-- Customer Details Card --}}
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-0">
            <div class="card-body">
                {{-- Title Row --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Customer Details</h6>
                    <!-- ===== Row 2: Shortcut Buttons ===== -->
                    <div class="top-shortcut-btn ">

                        <!-- Existing Send To DMS button -->
                        <button id="sendToDmsBtn" data-bs-original-title="" disabled>
                            <i class="ti ti-database"></i> Send To DMS
                        </button>

                        <!-- New Send to Credit App button -->
                        <button id="sendToCreditAppBtn" data-bs-original-title="" disabled>
                            <i class="ti ti-file-text"></i> Send To Credit App
                        </button>

                        <!-- Existing Documents button -->
                        <button id="documentsBtn" data-bs-original-title="" disabled>
                            <i class="ti ti-folders"></i> Documents
                        </button>

                        <!-- Delete Customer icon -->
                        <i class="ti ti-trash text-danger delete-customer" data-bs-toggle="tooltip"
                            style="cursor:pointer;font-size: 18px;" aria-label="Delete Customer"
                            data-bs-original-title="Delete Customer"></i>

                    </div>
                    <!-- Social Media Icons -->

                </div>
                <div class="customer-social-icons d-flex align-items-center justify-content-end gap-2">
                    <div class="customer-social-icon" data-platform="facebook"
                        onclick="openCustomerSocialModal('facebook', {{ $customerId }})" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="customer-social-icon" data-platform="instagram"
                        onclick="openCustomerSocialModal('instagram', {{ $customerId }})" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="customer-social-icon" data-platform="twitter"
                        onclick="openCustomerSocialModal('twitter', {{ $customerId }})" title="Twitter/X">
                        <i class="fab fa-x-twitter"></i>
                    </div>
                    <div class="customer-social-icon" data-platform="youtube"
                        onclick="openCustomerSocialModal('youtube', {{ $customerId }})" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <div class="customer-social-icon" data-platform="tiktok"
                        onclick="openCustomerSocialModal('tiktok', {{ $customerId }})" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </div>
                    <div class="customer-social-icon" data-platform="reddit"
                        onclick="openCustomerSocialModal('reddit', {{ $customerId }})" title="Reddit">
                        <i class="fab fa-reddit-alien"></i>
                    </div>
                </div>

                {{-- Profile Row --}}
                <form id="customerForm" method="POST" action="{{ route('customers.update', $customer->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- if using RESTful update route --}}

                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-normal align-items-center gap-2">
                                <div class="position-relative">
                                    <img src="{{ $customer->profile_image ?? '/assets/img/default-avatar.png' }}"
                                        alt="Profile" class="rounded-circle" id="customerProfileImage"
                                        style="width:110px;height:100px;object-fit:cover;border:3px solid #e9ecef;">
                                    <input type="file" name="profile_image" id="profileImageInput" class="d-none"
                                        accept="image/*">
                                    <label for="profileImageInput"
                                        class="btn btn-sm btn-light border position-absolute bottom-0 end-0 rounded-circle p-1">
                                        <i class="ti ti-camera"></i>
                                    </label>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-12 col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="first_name"
                                                placeholder="First Name" value="{{ $customer->first_name ?? '' }}">
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <input type="text" class="form-control form-control-sm"
                                                name="middle_name" placeholder="Middle Name"
                                                value="{{ $customer->middle_name ?? '' }}">
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <input type="text" class="form-control form-control-sm" name="last_name"
                                                placeholder="Last Name" value="{{ $customer->last_name ?? '' }}">
                                        </div>
                                        <div class="col-2 col-md-1 d-flex justify-content-center">
                                            <i class="ti ti-ban do-not-contact-icon"
                                                style="font-size:20px;cursor:pointer;" data-bs-toggle="modal"
                                                data-bs-target="#doNotContactModal"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Donot Call Modal --}}
                            @include('customers.modals.donot-call')

                            {{-- Contact Info --}}
                            <div class="mt-3 row g-2">
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="customer_location"
                                            name="customer_location" value="{{ $customer->full_address ?? '' }}">
                                        <a href="#" class="btn btn-outline-secondary" id="openMap">
                                            <i class="ti ti-home"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Cell Phone</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cell_phone"
                                            value="{{ $customer->cell_phone ?? '' }}" id="cell_phone_input">
                                        <button type="button" class="btn btn-outline-secondary telnyx-call-btn"
                                            data-phone="{{ $customer->cell_phone ?? '' }}">
                                            <i class="ti ti-phone"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary telnyx-sms-btn"
                                            data-phone="{{ $customer->cell_phone ?? '' }}">
                                            <i class="ti ti-message-circle"></i>
                                        </button>
                                        {{-- <button type="button" class="btn btn-outline-secondary telnyx-video-btn"
                                            data-phone="{{ $customer->cell_phone ?? '' }}" title="Video Call">
                                            <i class="ti ti-device-desktop"></i>
                                        </button> --}}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Work Phone</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="work_phone"
                                            value="{{ $customer->work_phone ?? '' }}" id="work_phone_input">
                                        <button type="button" class="btn btn-outline-secondary telnyx-call-btn"
                                            data-phone="{{ $customer->work_phone ?? '' }}">
                                            <i class="ti ti-phone"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Home Phone</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="home_phone"
                                            value="{{ $customer->home_phone ?? '' }}" id="home_phone_input">
                                        <button type="button" class="btn btn-outline-secondary telnyx-call-btn"
                                            data-phone="{{ $customer->home_phone ?? '' }}">
                                            <i class="ti ti-phone"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $customer->email ?? '' }}">
                                        <a href="mailto:{{ $customer->email ?? '' }}"
                                            class="btn btn-outline-secondary"><i class="ti ti-mail"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="alt_email"
                                            placeholder="Alternative Email" value="{{ $customer->alt_email ?? '' }}">
                                        <a href="#" class="btn btn-outline-secondary"><i
                                                class="ti ti-mail"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Co-Buyer Section - Add after the contact info section, before </form> --}}
                    <div class="col-12 mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light  border border-1" type="button"
                                id="toggleCoBuyerBtn" onclick="toggleEditCoBuyer()">
                                {{ $customer?->coBuyer?->first_name ? 'Edit Co-Buyer' : '+ Co-Buyer' }}
                            </button>

                            <button type="button" id="confirmCoBuyerBtn"
                                class="btn btn-sm btn-success {{ $customer?->coBuyer?->first_name ? '' : 'd-none' }}"
                                title="Confirm Co-Buyer" onclick="confirmCoBuyer()">
                                <i class="ti ti-check"></i>
                            </button>

                            <button type="button" id="deleteCoBuyerBtn"
                                class="btn btn-sm btn-danger {{ $customer?->coBuyer?->first_name ? '' : 'd-none' }}"
                                title="Delete Co-Buyer" onclick="deleteCoBuyer()">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>

                        <div id="editCoBuyerFields" class="{{ $customer?->coBuyer?->first_name ? '' : 'd-none' }}"
                            data-main-address="{{ $customer->address ?? ($customer->full_address ?? '') }}"
                            data-main-city="{{ $customer->city ?? '' }}"
                            data-main-state="{{ $customer->state ?? '' }}"
                            data-main-zip="{{ $customer->zip_code ?? ($customer->zip ?? '') }}">
                            <div class="col-12">
                                <div class="crm-header mt-2">
                                    Co-Buyer Information
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="co_first_name"
                                        value="{{ $customer?->coBuyer?->first_name ?? '' }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="co_middle_name"
                                        value="{{ $customer?->coBuyer?->middle_name ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="co_last_name"
                                        value="{{ $customer?->coBuyer?->last_name ?? '' }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="co_email"
                                        value="{{ $customer?->coBuyer?->email ?? '' }}">
                                </div>

                                <!-- Co-Buyer Phone Numbers -->
                                <div class="col-md-4">
                                    <label class="form-label">Cell Number</label>
                                    <input type="tel" class="form-control" name="co_cell_phone"
                                        value="{{ $customer?->coBuyer?->cell_phone ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Work Number</label>
                                    <input type="tel" class="form-control" name="co_work_phone"
                                        value="{{ $customer?->coBuyer?->work_phone ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Home Number</label>
                                    <input type="tel" class="form-control" name="co_phone"
                                        value="{{ $customer?->coBuyer?->phone ?? '' }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Street Address</label>
                                    <button class="btn btn-sm btn-dark" type="button"
                                        onclick="copyFromMainCustomer()">Copy From Main Customer</button>

                                    <div class="input-group">
                                        <input type="text" class="form-control" name="co_address"
                                            value="{{ $customer?->coBuyer?->address ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="co_city"
                                        value="{{ $customer?->coBuyer?->city ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Province</label>
                                    <input type="text" class="form-control" name="co_state"
                                        value="{{ $customer?->coBuyer?->state ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" name="co_zip_code"
                                        value="{{ $customer?->coBuyer?->zip_code ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="co_confirm" id="co_confirm"
                        value="{{ $customer?->coBuyer?->confirmed ?? 0 }}">
                    <input type="hidden" name="remove_co_buyer" id="remove_co_buyer" value="0">

                </form>

                <!-- Generic Social Modal (used by social icon buttons) -->
                <div class="modal fade" id="customerSocialModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Customer Social</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="customerSocialModalBody">
                                Loading...
                            </div>
                            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> --}}
                        </div>
                    </div>
                </div>

                <script>
                    function openCustomerSocialModal(platform, customerId) {
                        const id = customerId || window.AppState?.customerId || document.querySelector('[data-customer-id]')?.dataset
                            .customerId;
                        if (!id) {
                            Swal.fire({
                                title: 'No customer selected',
                                text: 'Please open a customer profile first.',
                                icon: 'warning'
                            });
                            return;
                        }

                        const modalBody = document.getElementById('customerSocialModalBody');
                        modalBody.innerHTML = `<div class="p-2">Loading ${platform}…</div>`;

                        function buildForm(currentUrl) {
                            const safeUrl = currentUrl || '';
                            return `
        <form id="socialForm">
          <div class="mb-3">
            <label class="form-label">${platform.charAt(0).toUpperCase() + platform.slice(1)} URL</label>
            <input type="url" id="socialUrlInput" class="form-control" placeholder="https://" value="${safeUrl}">
            <div class="form-text">Enter the customer's social media profile URL</div>
          </div>
          <div class="d-flex justify-content-between">
            <div>
              <button type="button" class="btn btn-outline-danger" id="removeSocialBtn">Remove</button>
            </div>
            </div>

                
              <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="saveSocialBtn">Save</button>
            </div>
          </div>
        </form>
      `;
                        }

                        // Always use the inline built form (no server GET) so modal behavior is consistent
                        const fallback = (window.customerSocial && window.customerSocial[platform]) || '';
                        modalBody.innerHTML = buildForm(fallback);
                        const modalEl = document.getElementById('customerSocialModal');
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                        initActions(id, platform, modal);

                        function initActions(id, platform, modal) {
                            const saveBtn = document.getElementById('saveSocialBtn');
                            const removeBtn = document.getElementById('removeSocialBtn');
                            const urlInput = document.getElementById('socialUrlInput');

                            if (saveBtn) saveBtn.onclick = async function() {
                                const url = (urlInput && urlInput.value) ? urlInput.value.trim() : '';
                                if (url !== '' && !/^https?:\/\//i.test(url)) {
                                    Swal.fire({
                                        title: 'Invalid URL',
                                        text: 'Please enter a valid URL starting with http:// or https://',
                                        icon: 'warning'
                                    });
                                    return;
                                }

                                saveBtn.disabled = true;
                                saveBtn.textContent = 'Saving...';

                                try {
                                    const res = await fetch(`/customers/${id}/social/${platform}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': window.AppState.csrfToken || document.querySelector(
                                                'meta[name="csrf-token"]').content
                                        },
                                        credentials: 'same-origin',
                                        body: JSON.stringify({
                                            url
                                        })
                                    });

                                    console.log('Social save response status:', res.status, 'content-type:', res.headers.get(
                                        'content-type'));
                                    const text = await res.text().catch(() => null);
                                    console.log('Social save response body:', text);
                                    let data = null;
                                    try {
                                        data = text ? JSON.parse(text) : null;
                                    } catch (e) {
                                        /* not JSON */ }

                                    if (res.ok) {
                                        // success if server returned success flag or url
                                        const ok = (data && (data.success === true || data.url)) || res.status === 204;
                                        if (ok) {
                                            if (window.customerSocial) window.customerSocial[platform] = (data && data.url) ?
                                                data.url : url;
                                            Swal.fire({
                                                title: 'Saved',
                                                icon: 'success',
                                                timer: 1000,
                                                showConfirmButton: false
                                            });
                                            try {
                                                modal.hide();
                                            } catch (e) {
                                                const modalEl2 = document.getElementById('customerSocialModal');
                                                const mi = modalEl2 ? bootstrap.Modal.getInstance(modalEl2) : null;
                                                if (mi) mi.hide();
                                            }
                                        } else {
                                            const errMsg = (data && (data.message || JSON.stringify(data))) || text ||
                                                'Unknown server response';
                                            console.error('Unexpected save response', res.status, errMsg);
                                            Swal.fire({
                                                title: 'Error',
                                                text: errMsg,
                                                icon: 'error'
                                            });
                                        }
                                    } else {
                                        const errMsg = (data && (data.message || JSON.stringify(data))) || text ||
                                            `Server returned ${res.status}`;
                                        console.error('Save social error', res.status, errMsg);
                                        Swal.fire({
                                            title: 'Error',
                                            text: errMsg,
                                            icon: 'error'
                                        });
                                    }
                                } catch (e) {
                                    console.error('Save social exception', e);
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Failed to save social link. See console for details.',
                                        icon: 'error'
                                    });
                                } finally {
                                    saveBtn.disabled = false;
                                    saveBtn.textContent = 'Save';
                                }
                            };

                            if (removeBtn) removeBtn.onclick = async function() {
                                try {
                                    const res = await fetch(`/customers/${id}/social/${platform}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': window.AppState.csrfToken || document.querySelector(
                                                'meta[name="csrf-token"]').content
                                        },
                                        credentials: 'same-origin'
                                    });

                                    if (!res.ok) throw new Error('Remove failed');
                                    if (window.customerSocial) window.customerSocial[platform] = '';
                                    Swal.fire({
                                        title: 'Removed',
                                        icon: 'success',
                                        timer: 900,
                                        showConfirmButton: false
                                    });
                                    try {
                                        modal.hide();
                                    } catch (e) {
                                        const modalEl2 = document.getElementById('customerSocialModal');
                                        const mi = modalEl2 ? bootstrap.Modal.getInstance(modalEl2) : null;
                                        if (mi) mi.hide();
                                    }
                                } catch (e) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Failed to remove social link.',
                                        icon: 'error'
                                    });
                                }
                            };
                        }
                    }
                </script>

            </div>
        </div>
    </div>
    @php
        $customerId = $customer->id;
    @endphp

    @include('customers.partials.general_customer_notes', ['customerId' => $customerId])



    {{-- Deals Section --}}
    @include('customers.partials.deals-section', [
        'customerId' => $customerId,
        'deals' => $customer->deals,
        'users' => $users ?? [],
    ])

    {{-- Tasks & Appointments Section --}}
    @include('customers.partials.tasks-section', ['customerId' => $customerId, 'users' => $users ?? []])

    {{-- Vehicles of Interest Section (Component-Based) --}}
    @include('customers.partials.vehicles-interest', [
        'customerId' => $customerId,
        'vehicle' => null,
        'users' => $users ?? [],
        'conditionGrades' => ['excellent' => 'Excellent', 'good' => 'Good', 'fair' => 'Fair', 'poor' => 'Poor'],
    ])

    {{-- Notes & History Section --}}
    @include('customers.partials.notes-history', ['customerId' => $customerId, 'users' => $users ?? []])

    {{-- Activity Timeline --}}
    @include('customers.partials.activity-timeline')
    <div class="offcanvas-footer bg-white p-3">
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-light border border-1 flex-fill"
                data-bs-dismiss="offcanvas">Cancel</button>
            <button type="button" class="btn btn-primary flex-fill" id="saveCustomerBtn">Save Changes</button>
        </div>
    </div>
</div>
<script>
    document.getElementById('saveCustomerBtn').addEventListener('click', function() {
        document.getElementById('customerForm').submit();
    });
</script>
{{-- Footer --}}

{{-- Modals --}}
@include('customers.modals.edit-deal', ['customerId' => $customerId, 'users' => $users ?? []])

@include('customers.modals.add-deal', ['customerId' => $customerId, 'users' => $users ?? []])
@include('customers.modals.inventory', ['customerId' => $customerId, 'inventory' => $inventory])
@include('customers.modals.add-task', ['customerId' => $customerId, 'users' => $users ?? []])
@include('customers.modals.edit-visit')



{{-- Minimal Core JS --}}


<script>
    function toggleEditCoBuyer() {
        const section = document.getElementById('editCoBuyerFields');
        const confirmBtn = document.getElementById('confirmCoBuyerBtn');
        const deleteBtn = document.getElementById('deleteCoBuyerBtn');
        const toggleBtn = document.getElementById('toggleCoBuyerBtn');
        if (!section) return;
        section.classList.toggle('d-none');
        const visible = !section.classList.contains('d-none');
        // Show/hide confirm button only when editing
        if (confirmBtn) confirmBtn.classList.toggle('d-none', !visible);
        if (deleteBtn) deleteBtn.classList.toggle('d-none', !visible);
        // Update toggle text
        if (toggleBtn) toggleBtn.textContent = visible ? 'Hide Co-Buyer' : (document.getElementsByName('co_first_name')[
            0]?.value ? 'Edit Co-Buyer' : '+ Co-Buyer');
    }

    async function confirmCoBuyer() {
        const id = window.AppState?.customerId || document.querySelector('[data-customer-id]')?.dataset.customerId;
        if (!id) return showToast('No customer selected', 'error');

        const payload = {
            co_first_name: document.getElementsByName('co_first_name')[0]?.value || '',
            co_middle_name: document.getElementsByName('co_middle_name')[0]?.value || '',
            co_last_name: document.getElementsByName('co_last_name')[0]?.value || '',
            co_email: document.getElementsByName('co_email')[0]?.value || '',
            co_phone: document.getElementsByName('co_phone')[0]?.value || '',
            co_cell_phone: document.getElementsByName('co_cell_phone')[0]?.value || '',
            co_work_phone: document.getElementsByName('co_work_phone')[0]?.value || '',
            co_address: document.getElementsByName('co_address')[0]?.value || '',
            co_city: document.getElementsByName('co_city')[0]?.value || '',
            co_state: document.getElementsByName('co_state')[0]?.value || '',
            co_zip_code: document.getElementsByName('co_zip_code')[0]?.value || '',
        };

        const btn = document.getElementById('confirmCoBuyerBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader rotate"></i>';
        }

        try {
            const res = await fetch(`/customers/${id}/cobuyer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.AppState?.csrfToken || document.querySelector(
                        'meta[name="csrf-token"]')?.content
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            });

            const data = await res.json().catch(() => null);
            if (res.ok && data && data.success) {
                if (typeof showToast === 'function') showToast('Co-Buyer saved', 'success');
                // ensure delete button visible
                document.getElementById('deleteCoBuyerBtn')?.classList.remove('d-none');
            } else {
                const msg = (data && data.message) ? data.message : 'Failed to save co-buyer';
                if (typeof showToast === 'function') showToast(msg, 'error');
            }
        } catch (e) {
            console.error('save co-buyer error', e);
            if (typeof showToast === 'function') showToast('Error saving co-buyer', 'error');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="ti ti-check"></i>';
            }
        }
    }

    function deleteCoBuyer() {
        const id = window.AppState?.customerId || document.querySelector('[data-customer-id]')?.dataset.customerId;
        if (!id) return showToast('No customer selected', 'error');

        // Use SweetAlert if available for nicer confirmation
        const doDelete = async () => {
            try {
                const res = await fetch(`/customers/${id}/cobuyer`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': window.AppState?.csrfToken || document.querySelector(
                            'meta[name="csrf-token"]')?.content
                    },
                    credentials: 'same-origin'
                });
                const data = await res.json().catch(() => null);
                if (res.ok && data && data.success) {
                    // clear inputs and hide section
                    const section = document.getElementById('editCoBuyerFields');
                    const inputs = section ? section.querySelectorAll('input') : [];
                    inputs.forEach(i => {
                        if (i.type !== 'hidden') i.value = '';
                    });
                    if (section) section.classList.add('d-none');
                    document.getElementById('toggleCoBuyerBtn').textContent = '+ Co-Buyer';
                    if (typeof showToast === 'function') showToast('Co-Buyer deleted', 'success');
                } else {
                    const msg = (data && data.message) ? data.message : 'Failed to delete co-buyer';
                    if (typeof showToast === 'function') showToast(msg, 'error');
                }
            } catch (e) {
                console.error('delete co-buyer error', e);
                if (typeof showToast === 'function') showToast('Error deleting co-buyer', 'error');
            }
        };

        if (window.Swal) {
            Swal.fire({
                title: 'Delete Co-Buyer?',
                text: 'This will permanently remove the co-buyer for this customer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) doDelete();
            });
        } else {
            if (confirm('Delete co-buyer? This cannot be undone.')) doDelete();
        }
    }

    function copyFromMainCustomer() {
        const section = document.getElementById('editCoBuyerFields');
        if (!section) return;
        const mainAddress = section.dataset.mainAddress || '';
        const mainCity = section.dataset.mainCity || '';
        const mainState = section.dataset.mainState || '';
        const mainZip = section.dataset.mainZip || '';

        const addressInput = document.getElementsByName('co_address')[0];
        const cityInput = document.getElementsByName('co_city')[0];
        const stateInput = document.getElementsByName('co_state')[0];
        const zipInput = document.getElementsByName('co_zip_code')[0];

        if (addressInput) addressInput.value = mainAddress;
        if (cityInput) cityInput.value = mainCity;
        if (stateInput) stateInput.value = mainState;
        if (zipInput) zipInput.value = mainZip;

        if (typeof showToast === 'function') showToast('Co-Buyer address copied from main customer', 'success');
    }
</script>

{{-- ============================================================
     SMS COMPOSE MODAL
============================================================ --}}
<div class="modal fade" id="customerSmsModal" tabindex="-1" aria-labelledby="customerSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header border-0 text-white px-4 py-3" style="background: linear-gradient(135deg, #1c2a3a 0%, #0f1b27 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-message-circle fs-5"></i>
                    <h5 class="modal-title mb-0 fw-semibold" id="customerSmsModalLabel">Send SMS</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4 py-3">
                {{-- Recipient --}}
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold mb-1">To</label>
                    <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #f8f9fa;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width: 36px; height: 36px; min-width: 36px;">
                            <i class="ti ti-user fs-6"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold small" id="csSmsRecipientName">–</div>
                            <input type="text" class="form-control-plaintext form-control-sm p-0 text-muted" id="csSmsTo" readonly style="font-size: 13px;">
                        </div>
                    </div>
                </div>

                {{-- Message --}}
                <div class="mb-2">
                    <label class="form-label text-muted small fw-semibold mb-1">Message</label>
                    <textarea id="csSmsBody" class="form-control" rows="5"
                        placeholder="Type your message here…"
                        maxlength="1600"
                        style="resize: vertical; border-radius: 12px; border-color: #dee2e6;"></textarea>
                    <div class="d-flex justify-content-between mt-1">
                        <span id="csSmsStatus" class="small"></span>
                        <span id="csSmsCharCount" class="text-muted" style="font-size: 12px;">0 / 1,600</span>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4 d-inline-flex align-items-center" id="csSmsSendBtn">
                    Send <i class="ti ti-send ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
(function() {
    const body = document.getElementById('csSmsBody');
    const charCount = document.getElementById('csSmsCharCount');
    const sendBtn = document.getElementById('csSmsSendBtn');
    const statusEl = document.getElementById('csSmsStatus');

    // Character counter
    body.addEventListener('input', function() {
        const len = this.value.length;
        charCount.textContent = len.toLocaleString() + ' / 1,600';
        charCount.className = len > 1500 ? 'text-danger' : 'text-muted';
        charCount.style.fontSize = '12px';
    });

    // Send handler
    sendBtn.addEventListener('click', async function() {
        const to = document.getElementById('csSmsTo').value.trim();
        const message = body.value.trim();

        if (!message) {
            statusEl.textContent = 'Please enter a message.';
            statusEl.className = 'small text-danger';
            body.focus();
            return;
        }

        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending…';
        statusEl.textContent = '';
        statusEl.className = 'small';

        try {
            const res = await fetch('/telnyx/sms', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.AppState?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content
                },
                credentials: 'same-origin',
                body: JSON.stringify({ to, message })
            });
            const data = await res.json();

            if (data && data.success) {
                statusEl.textContent = 'Sent successfully!';
                statusEl.className = 'small text-success fw-semibold';
                sendBtn.innerHTML = '<i class="ti ti-check me-1"></i> Sent';
                sendBtn.classList.replace('btn-primary', 'btn-success');
                if (typeof showToast === 'function') showToast('SMS sent', 'success');
                // Close modal after a short delay
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('customerSmsModal'));
                    if (modal) modal.hide();
                    sendBtn.classList.replace('btn-success', 'btn-primary');
                }, 1200);
            } else {
                const errMsg = data?.message || 'SMS failed';
                const errDetail = data?.details ? ('\n' + data.details) : '';
                statusEl.textContent = errMsg;
                statusEl.className = 'small text-danger';
                if (typeof showToast === 'function') showToast(errMsg, 'error');
                console.error('SMS error:', errMsg, errDetail);
                sendBtn.disabled = false;
                sendBtn.innerHTML = 'Send <i class="ti ti-send ms-1"></i>';
            }
        } catch (err) {
            console.error('SMS error', err);
            statusEl.textContent = 'Network error. Please try again.';
            statusEl.className = 'small text-danger';
            if (typeof showToast === 'function') showToast('SMS error', 'error');
            sendBtn.disabled = false;
            sendBtn.innerHTML = 'Send <i class="ti ti-send ms-1"></i>';
        }
    });
})();
</script>

{{-- ============================================================
     TELNYX WEBRTC CALL DIALOG
============================================================ --}}
<style>
#telnyxCallDialog{position:fixed;top:80px;right:24px;width:280px;background:linear-gradient(180deg,#1c2a3a 0%,#0f1b27 100%);border-radius:24px;box-shadow:0 20px 60px rgba(0,0,0,.5),0 0 0 1px rgba(255,255,255,.08);z-index:99999;color:#fff;user-select:none;overflow:hidden;transition:opacity .2s}
#telnyxCallDialog.cd-minimized .cd-body,#telnyxCallDialog.cd-minimized #callKeypad{display:none!important}
.cd-drag{display:flex;align-items:center;justify-content:space-between;padding:12px 16px 6px;cursor:grab}
.cd-drag:active{cursor:grabbing}
.cd-drag-bar{width:36px;height:4px;background:rgba(255,255,255,.2);border-radius:2px;margin:0 auto}
.cd-min-btn{background:none;border:none;color:rgba(255,255,255,.4);font-size:18px;cursor:pointer;padding:0 4px;line-height:1}
.cd-min-btn:hover{color:#fff}
.cd-body{padding:8px 20px 18px;text-align:center}
.cd-avatar{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#4f8ef7,#2563eb);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:700;color:#fff;margin:0 auto 12px;box-shadow:0 0 0 6px rgba(79,142,247,.15),0 0 0 12px rgba(79,142,247,.08)}
.cd-avatar.cd-pulse{animation:cd-ring 1.5s infinite}
@keyframes cd-ring{0%,100%{box-shadow:0 0 0 6px rgba(79,142,247,.15),0 0 0 12px rgba(79,142,247,.08)}50%{box-shadow:0 0 0 12px rgba(79,142,247,.28),0 0 0 24px rgba(79,142,247,.07)}}
.cd-name{font-size:17px;font-weight:600;color:#fff;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.cd-num{font-size:13px;color:rgba(255,255,255,.45);margin-bottom:10px;letter-spacing:.3px}
.cd-status-row{display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:16px}
.cd-dot{width:7px;height:7px;border-radius:50%;background:#f59e0b;animation:cd-blink 1s infinite}
.cd-dot.cd-on{background:#10b981;animation:none}
.cd-dot.cd-end{background:#ef4444;animation:none}
@keyframes cd-blink{0%,100%{opacity:1}50%{opacity:.3}}
.cd-status-txt{font-size:13px;color:rgba(255,255,255,.55)}
.cd-timer{font-size:13px;color:#10b981;font-variant-numeric:tabular-nums;display:none}
.cd-timer.cd-show{display:inline}
.cd-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:16px}
.cd-btn{display:flex;flex-direction:column;align-items:center;gap:4px;background:rgba(255,255,255,.08);border:none;border-radius:14px;padding:10px 4px;cursor:pointer;color:rgba(255,255,255,.75);transition:background .15s,color .15s;font-size:11px}
.cd-btn i{font-size:18px}
.cd-btn:hover{background:rgba(255,255,255,.14);color:#fff}
.cd-btn.cd-active{background:rgba(255,255,255,.22);color:#fff}
.cd-hangup-row{display:flex;justify-content:center;padding-bottom:4px}
.cd-hangup{width:62px;height:62px;border-radius:50%;background:#ef4444;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;box-shadow:0 4px 16px rgba(239,68,68,.45);transition:background .15s,transform .1s}
.cd-hangup:hover{background:#dc2626;transform:scale(1.06)}
.cd-hangup:active{transform:scale(.96)}
#callKeypad{background:rgba(0,0,0,.2);padding:10px 20px 14px;border-top:1px solid rgba(255,255,255,.07)}
.cd-kp-display{background:rgba(0,0,0,.25);border-radius:8px;padding:6px 10px;margin-bottom:8px;font-size:16px;font-family:monospace;color:#fff;min-height:32px;letter-spacing:2px;text-align:center}
.cd-kp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:6px}
.cd-key{background:rgba(255,255,255,.09);border:none;border-radius:10px;padding:10px 4px;color:#fff;font-size:16px;font-weight:500;cursor:pointer;transition:background .12s;display:flex;flex-direction:column;align-items:center;line-height:1}
.cd-key .sub{font-size:8px;color:rgba(255,255,255,.4);margin-top:1px}
.cd-key:hover{background:rgba(255,255,255,.2)}
.cd-key:active{background:rgba(255,255,255,.3)}
</style>

<div id="telnyxCallDialog" style="display:none;">
    <div class="cd-drag" id="cdDragHandle">
        <div style="width:24px"></div>
        <div class="cd-drag-bar"></div>
        <button class="cd-min-btn" onclick="cdMinimize()" title="Minimize"><i class="ti ti-minus"></i></button>
    </div>
    <div class="cd-body">
        <div class="cd-avatar cd-pulse" id="cdAvatar">??</div>
        <div class="cd-name"  id="cdName">–</div>
        <div class="cd-num"   id="cdNum">–</div>
        <div class="cd-status-row">
            <span class="cd-dot" id="cdDot"></span>
            <span class="cd-status-txt" id="cdStatusTxt">Calling…</span>
            <span class="cd-timer" id="cdTimer">0:00</span>
        </div>
        <div class="cd-actions">
            <button class="cd-btn" id="cdMuteBtn" onclick="cdToggleMute()">
                <i class="ti ti-microphone" id="cdMuteIcon"></i><span id="cdMuteLbl">Mute</span>
            </button>
            <button class="cd-btn" id="cdHoldBtn" onclick="cdToggleHold()">
                <i class="ti ti-player-pause" id="cdHoldIcon"></i><span id="cdHoldLbl">Hold</span>
            </button>
            <button class="cd-btn" id="cdKpBtn" onclick="cdToggleKeypad()">
                <i class="ti ti-keypad"></i><span>Keypad</span>
            </button>
            <button class="cd-btn" id="cdSpkBtn" onclick="cdToggleSpeaker()">
                <i class="ti ti-volume" id="cdSpkIcon"></i><span>Speaker</span>
            </button>
        </div>
        <div class="cd-hangup-row">
            <button class="cd-hangup" onclick="cdHangup()" title="Hang up">
                <i class="ti ti-phone-off"></i>
            </button>
        </div>
    </div>
    <div id="callKeypad" style="display:none;">
        <div class="cd-kp-display" id="cdKpDisp"></div>
        <div class="cd-kp-grid">
            <button class="cd-key" onclick="cdDTMF('1')">1</button>
            <button class="cd-key" onclick="cdDTMF('2')">2<span class="sub">ABC</span></button>
            <button class="cd-key" onclick="cdDTMF('3')">3<span class="sub">DEF</span></button>
            <button class="cd-key" onclick="cdDTMF('4')">4<span class="sub">GHI</span></button>
            <button class="cd-key" onclick="cdDTMF('5')">5<span class="sub">JKL</span></button>
            <button class="cd-key" onclick="cdDTMF('6')">6<span class="sub">MNO</span></button>
            <button class="cd-key" onclick="cdDTMF('7')">7<span class="sub">PQRS</span></button>
            <button class="cd-key" onclick="cdDTMF('8')">8<span class="sub">TUV</span></button>
            <button class="cd-key" onclick="cdDTMF('9')">9<span class="sub">WXYZ</span></button>
            <button class="cd-key" onclick="cdDTMF('*')">*</button>
            <button class="cd-key" onclick="cdDTMF('0')">0<span class="sub">+</span></button>
            <button class="cd-key" onclick="cdDTMF('#')">#</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@telnyx/webrtc/lib/bundle.js"></script>
<script>
(function(){
    'use strict';
    let _client=null,_call=null,_muted=false,_held=false,_spk=false,_timerInt=null,_secs=0,_kpStr='';
    const $=id=>document.getElementById(id);
    const dlg=()=>$('telnyxCallDialog');

    /* ---- Drag ---- */
    (function(){
        let dragging=false,ox=0,oy=0;
        document.addEventListener('mousedown',e=>{
            if(!e.target.closest('#cdDragHandle'))return;
            dragging=true;const r=dlg().getBoundingClientRect();ox=e.clientX-r.left;oy=e.clientY-r.top;
        });
        document.addEventListener('mousemove',e=>{
            if(!dragging)return;const d=dlg();
            d.style.left=(e.clientX-ox)+'px';d.style.top=(e.clientY-oy)+'px';d.style.right='auto';
        });
        document.addEventListener('mouseup',()=>{dragging=false;});
    })();

    /* ---- Timer ---- */
    function startTimer(){_secs=0;clearInterval(_timerInt);_timerInt=setInterval(()=>{
        _secs++;const m=Math.floor(_secs/60),s=String(_secs%60).padStart(2,'0');
        const t=$('cdTimer');if(t){t.className='cd-timer cd-show';t.textContent=`${m}:${s}`;}
    },1000);}
    function stopTimer(){clearInterval(_timerInt);const t=$('cdTimer');if(t)t.className='cd-timer';}

    /* ---- Status helper ---- */
    function setStatus(txt,type){
        const d=$('cdDot'),s=$('cdStatusTxt');
        if(s)s.textContent=txt;
        if(d)d.className='cd-dot'+(type==='connected'?' cd-on':type==='end'?' cd-end':'');
    }

    /* ---- Show dialog ---- */
    function showCD(to,name){
        const initials=name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2)||'?';
        $('cdAvatar').textContent=initials;$('cdAvatar').className='cd-avatar cd-pulse';
        $('cdName').textContent=name;$('cdNum').textContent=to;
        setStatus('Calling…','calling');$('cdTimer').className='cd-timer';
        _muted=false;_held=false;
        $('cdMuteBtn').classList.remove('cd-active');$('cdHoldBtn').classList.remove('cd-active');$('cdKpBtn').classList.remove('cd-active');
        $('cdMuteIcon').className='ti ti-microphone';$('cdMuteLbl').textContent='Mute';
        $('cdHoldIcon').className='ti ti-player-pause';$('cdHoldLbl').textContent='Hold';
        $('callKeypad').style.display='none';_kpStr='';$('cdKpDisp').textContent='';
        dlg().style.display='';
    }
    function hideCD(){dlg().style.display='none';stopTimer();}

    /* ---- Init WebRTC client ---- */
    async function initClient(){
        if(_client)return _client;
        let creds;
        try{const r=await fetch('/telnyx/webrtc-credentials',{credentials:'same-origin'});creds=await r.json();}
        catch(e){console.warn('[Telnyx] credential fetch failed',e);return null;}
        if(!creds||!creds.configured){
            console.warn('[Telnyx] SIP credentials not set. Add TELNYX_SIP_USERNAME & TELNYX_SIP_PASSWORD to .env');
            return null;
        }
        if(typeof TelnyxRTC==='undefined'){console.error('[Telnyx] SDK not loaded');return null;}
        _client=new TelnyxRTC({login:creds.login,password:creds.password});
        window._cdCallerNum=creds.caller_number;
        _client.on('telnyx.ready',()=>console.log('[Telnyx] ready'));
        _client.on('telnyx.error',e=>console.error('[Telnyx] error',e));
        _client.on('telnyx.notification',n=>{
            if(n.type!=='callUpdate')return;
            const st=n.call.state;
            console.log('[Telnyx] call:',st);
            if(st==='ringing'||st==='trying'){setStatus('Calling…','calling');}
            else if(st==='active'){$('cdAvatar').classList.remove('cd-pulse');setStatus('Connected','connected');startTimer();}
            else if(st==='held'){setStatus('On Hold','calling');}
            else if(st==='hangup'||st==='destroy'||st==='purge'){
                setStatus('Call ended','end');stopTimer();_call=null;setTimeout(hideCD,1400);
            }
        });
        _client.connect();
        return _client;
    }

    /* ---- PUBLIC API ---- */
    window.startTelnyxCall=async function(to,name){
        if(_call){showToast('Already in a call','error');return;}
        const num=to.replace(/[^+\d]/g,'');
        showCD(num,name||num);
        const client=await initClient();
        if(!client){
            setStatus('WebRTC not configured','end');
            $('cdAvatar').classList.remove('cd-pulse');
            $('cdDot').className='cd-dot cd-end';
            return;
        }
        try{_call=client.newCall({destinationNumber:num,callerNumber:window._cdCallerNum||undefined});}
        catch(e){console.error('[Telnyx] newCall',e);setStatus('Call failed','end');}
    };

    window.cdHangup=function(){
        if(_call){try{_call.hangup();}catch(e){}}
        _call=null;setStatus('Call ended','end');stopTimer();setTimeout(hideCD,900);
    };
    window.cdToggleMute=function(){
        if(!_call)return;_muted=!_muted;
        try{_muted?_call.muteAudio():_call.unmuteAudio();}catch(e){}
        $('cdMuteBtn').classList.toggle('cd-active',_muted);
        $('cdMuteIcon').className=_muted?'ti ti-microphone-off':'ti ti-microphone';
        $('cdMuteLbl').textContent=_muted?'Unmute':'Mute';
    };
    window.cdToggleHold=function(){
        if(!_call)return;_held=!_held;
        try{_held?_call.hold():_call.unhold();}catch(e){}
        $('cdHoldBtn').classList.toggle('cd-active',_held);
        $('cdHoldIcon').className=_held?'ti ti-player-play':'ti ti-player-pause';
        $('cdHoldLbl').textContent=_held?'Unhold':'Hold';
        setStatus(_held?'On Hold':'Connected',_held?'calling':'connected');
    };
    window.cdToggleKeypad=function(){
        const kp=$('callKeypad'),btn=$('cdKpBtn');
        const show=kp.style.display==='none';kp.style.display=show?'':'none';
        btn.classList.toggle('cd-active',show);
    };
    window.cdToggleSpeaker=function(){
        _spk=!_spk;$('cdSpkBtn').classList.toggle('cd-active',_spk);
        $('cdSpkIcon').className=_spk?'ti ti-volume-3':'ti ti-volume';
        showToast(_spk?'Speaker on':'Speaker off');
    };
    window.cdDTMF=function(d){
        if(_call){try{_call.dtmf(d);}catch(e){}}
        _kpStr+=d;$('cdKpDisp').textContent=_kpStr;
    };
    window.cdMinimize=function(){dlg().classList.toggle('cd-minimized');};

    /* Pre-warm connection after page loads */
    document.addEventListener('DOMContentLoaded',()=>setTimeout(initClient,3000));
})();
</script>
