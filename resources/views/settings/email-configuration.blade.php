@php
    $emailConf = App\Models\EmailConfiguration::first() ?? new App\Models\EmailConfiguration();
@endphp

<div class="tab-pane fade" id="email-footer-configuration-tab" role="tabpanel"
    aria-labelledby="email-footer-configuration-tab">

    <div class="primus-crm-content-header">
        <h2 class="primus-crm-content-title">Email Header/Footer Configuration</h2>
        <p class="primus-crm-content-description">
            Configure the header and footer that appear in all outgoing emails.
        </p>
    </div>
    <form id="emailConfForm" method="POST" action="{{ url('email-conf/save') }}" enctype="multipart/form-data">
        @csrf
        <!-- HEADER LOGO SECTION -->
        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-image"></i></span>
                Email Header
            </h3>
            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Include company logo in header</div>
                    <div class="primus-crm-setting-desc">Add dealership logo to email header</div>
                </div>
                <input type="hidden" name="include_logo_header" value="0">
                <div class="primus-crm-toggle-switch {{ $emailConf->include_logo_header ? 'active' : '' }}"
                    id="headerLogoToggle" onclick="toggleHeaderLogo(this)"></div>
            </div>

            <div id="headerLogoUploadSection" class="primus-crm-logo-upload-section"
                style="margin-top: 20px; {{ $emailConf->include_logo_header ? '' : 'display:none;' }}">
                <label class="primus-crm-form-label">Upload Header Logo</label>
                <div class="primus-crm-file-upload-wrapper">
                    <input type="file" id="headerLogoInput" name="header_logo" accept="image/*" style="display: none;">
                    <button type="button" class="primus-crm-btn primus-crm-btn-secondary"
                        onclick="document.getElementById('headerLogoInput').click()">
                        <i class="fas fa-upload"></i> Browse
                    </button>
                    <span id="headerLogoFileName" style="margin-left: 10px; color: #64748b;">
                        {{ $emailConf->header_logo_path ? basename($emailConf->header_logo_path) : 'No file chosen' }}
                    </span>
                </div>
                @if ($emailConf->header_logo_path)
                    <div id="headerLogoPreview" style="margin-top: 15px;">
                        <img id="headerLogoPreviewImg" src="{{ asset('/storage/'.$emailConf->header_logo_path) }}"
                            alt="Header Logo Preview"
                            style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    </div>
                @else
                    <div id="headerLogoPreview" style="margin-top: 15px; display:none;">
                        <img id="headerLogoPreviewImg" src="" alt="Header Logo Preview"
                            style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    </div>
                @endif
            </div>
        </div>

        <!-- FOOTER LOGO SECTION -->
        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-image"></i></span>
                Email Footer
            </h3>
            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Include company logo in footer</div>
                    <div class="primus-crm-setting-desc">Add dealership logo to email footer</div>
                </div>
                <input type="hidden" name="include_logo_footer" value="0">
                <div class="primus-crm-toggle-switch {{ $emailConf->include_logo_footer ? 'active' : '' }}"
                    id="footerLogoToggle" onclick="toggleFooterLogo(this)"></div>
            </div>

            <div id="FooterLogoUploadSection" class="primus-crm-logo-upload-section"
                style="margin-top: 20px; {{ $emailConf->include_logo_footer ? '' : 'display:none;' }}">
                <label class="primus-crm-form-label">Upload Footer Logo</label>
                <div class="primus-crm-file-upload-wrapper">
                    <input type="file" id="FooterLogoInput" name="footer_logo" accept="image/*" style="display: none;">
                    <button type="button" class="primus-crm-btn primus-crm-btn-secondary"
                        onclick="document.getElementById('FooterLogoInput').click()">
                        <i class="fas fa-upload"></i> Browse
                    </button>
                    <span id="FooterLogoFileName" style="margin-left: 10px; color: #64748b;">
                        {{ $emailConf->footer_logo_path ? basename($emailConf->footer_logo_path) : 'No file chosen' }}
                    </span>
                </div>
                @if ($emailConf->footer_logo_path)
                    <div id="FooterLogoPreview" style="margin-top: 15px;">
                        <img id="FooterLogoPreviewImg" src="{{ asset('/storage/'.$emailConf->footer_logo_path) }}"
                            alt="Footer Logo Preview"
                            style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    </div>
                @else
                    <div id="FooterLogoPreview" style="margin-top: 15px; display:none;">
                        <img id="FooterLogoPreviewImg" src="" alt="Footer Logo Preview"
                            style="max-width: 200px; max-height: 100px; border: 1px solid #e2e8f0; border-radius: 4px;">
                    </div>
                @endif
            </div>
        </div>

        <!-- SOCIAL MEDIA SECTION -->
        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-share-alt"></i></span>
                Social Media Links
            </h3>
            <div class="primus-crm-social-media-grid">
                @foreach (['facebook', 'instagram', 'twitter', 'youtube', 'reddit'] as $platform)
                    @php
                        $url = $emailConf->{$platform . '_url'} ?? '';
                    @endphp
                    <div class="primus-crm-social-icon" data-platform="{{ $platform }}"
                        onclick="openSocialModal('{{ $platform }}')" title="{{ ucfirst($platform) }}">
                        <i class="fab fa-{{ $platform == 'twitter' ? 'x-twitter' : $platform }}"></i>
                    </div>
                    <input type="hidden" name="{{ $platform }}_url" id="{{ $platform }}_url"
                        value="{{ $url }}">
                @endforeach
            </div>
        </div>

        <!-- CONFIDENTIALITY NOTICE -->
        <div class="primus-crm-form-group primus-crm-form-group-full-width">
            <label class="primus-crm-form-label">Confidentiality Notice</label>
            <textarea name="confidentiality_notice" class="primus-crm-form-control primus-crm-confidentiality-text"
                rows="4" style="font-size: 10px; color: #000000;">{{ $emailConf->confidentiality_notice ?? 'CONFIDENTIALITY NOTICE: This email and any attachments are for the exclusive and confidential use of the intended recipient. If you are not the intended recipient, please do not read, distribute, or take action based on this message. If you have received this in error, please notify us immediately and delete this email.' }}</textarea>
        </div>

        <button type="submit" class="primus-crm-btn primus-crm-btn-primary mt-4">Save Configuration</button>
    </form>
</div>

<!-- SOCIAL MEDIA MODAL -->
<div id="socialMediaModal" class="primus-crm-modal" style="display: none;">
    <div class="primus-crm-modal-content" style="max-width: 500px;">
        <div class="primus-crm-modal-header">
            <h3 id="socialModalTitle">Add Social Media Link</h3>
            <span class="primus-crm-modal-close" onclick="closeSocialModal()">&times;</span>
        </div>
        <div class="primus-crm-modal-body">
            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label" id="socialModalLabel">Facebook URL</label>
                <input type="url" id="socialMediaUrl" class="primus-crm-form-control"
                    placeholder="https://facebook.com/yourpage">
            </div>
        </div>
        <div class="primus-crm-modal-footer">
            <button type="button" class="primus-crm-btn primus-crm-btn-secondary"
                onclick="closeSocialModal()">Cancel</button>
            <button type="button" class="primus-crm-btn primus-crm-btn-primary"
                onclick="saveSocialLink()">Save</button>
        </div>
    </div>
</div>
<!-- Holiday Modal -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="emailConfToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Saved successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
document.getElementById('emailConfForm')?.addEventListener('submit', function(e) {
    e.preventDefault(); // prevent default

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            showToast('Email configuration saved successfully!', 'success');
        } else {
            showToast('Failed to save configuration.', 'danger');
        }
    })
    .catch(err => showToast('Something went wrong!', 'danger'));
});


    function showToast(message, type = 'success') {
    const toastEl = document.getElementById('emailConfToast');
    const toastMessage = document.getElementById('toastMessage');

    // Set message
    toastMessage.textContent = message;

    // Set type (success, danger, info)
    toastEl.className = `toast align-items-center text-bg-${type} border-0`;

    // Show toast
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

    function toggleHeaderLogo(el) {
        el.classList.toggle('active');
        document.getElementById('headerLogoUploadSection').style.display = el.classList.contains('active') ? 'block' :
            'none';
        document.querySelector('input[name="include_logo_header"]').value = el.classList.contains('active') ? 1 : 0;
    }

    function toggleFooterLogo(el) {
        el.classList.toggle('active');
        document.getElementById('FooterLogoUploadSection').style.display = el.classList.contains('active') ? 'block' :
            'none';
        document.querySelector('input[name="include_logo_footer"]').value = el.classList.contains('active') ? 1 : 0;
    }


    // Preview Header Logo
    document.getElementById('headerLogoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        document.getElementById('headerLogoFileName').textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.getElementById('headerLogoPreviewImg');
            img.src = event.target.result;
            document.getElementById('headerLogoPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    });

    // Preview Footer Logo
    document.getElementById('FooterLogoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        document.getElementById('FooterLogoFileName').textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.getElementById('FooterLogoPreviewImg');
            img.src = event.target.result;
            document.getElementById('FooterLogoPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    });

    // Social Modal functions
    let currentPlatform = '';

    function openSocialModal(platform) {
        currentPlatform = platform;
        const modal = document.getElementById('socialMediaModal');
        modal.style.display = 'flex';
        // store platform on modal element so save can read it even if another script defines a different var
        modal.dataset.platform = platform;
        const url = document.getElementById(platform + '_url')?.value || '';
        document.getElementById('socialMediaUrl').value = url;
        document.getElementById('socialModalLabel').innerText = platform.charAt(0).toUpperCase() + platform.slice(1) +
            ' URL';
    }

    function closeSocialModal() {
        const modal = document.getElementById('socialMediaModal');
        if (modal) {
            modal.style.display = 'none';
            // clear stored platform
            delete modal.dataset.platform;
        }
    }

function saveSocialLink() {
    const modal = document.getElementById('socialMediaModal');
    // Resolve platform from multiple possible sources (different scripts use different variable names)
    let platform = '';
    if (modal && modal.dataset && modal.dataset.platform) platform = modal.dataset.platform;
    else if (typeof currentPlatform !== 'undefined' && currentPlatform) platform = currentPlatform;
    else if (typeof currentSocialPlatform !== 'undefined' && currentSocialPlatform) platform = currentSocialPlatform;
    else if (typeof window !== 'undefined' && window.currentSocialPlatform) platform = window.currentSocialPlatform;
    const value = document.getElementById('socialMediaUrl').value;

    console.log('saveSocialLink called', { platform, value, modalPlatform: modal?.dataset?.platform, currentPlatform: (typeof currentPlatform !== 'undefined' ? currentPlatform : null), currentSocialPlatform: (typeof currentSocialPlatform !== 'undefined' ? currentSocialPlatform : null), windowCurrentSocial: (typeof window !== 'undefined' ? window.currentSocialPlatform : null) });

    if (!platform) {
        console.error('No platform selected for social save');
        showToast('No social platform selected.', 'danger');
        return;
    }

    fetch('{{ url("email-conf/save-social") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ platform: platform, url: value })
    })
    .then(res => {
        console.log('fetch response status', res.status);
        return res.json().catch(err => ({ success: false, _parseError: err }));
    })
    .then(data => {
        console.log('saveSocialLink response', data);
        if(data.success){
            const hiddenInput = document.getElementById(platform + '_url');
            if (hiddenInput) hiddenInput.value = value;
            // Update in-page state if present (preserve original UI behavior)
            try {
                // update shared links object if exists
                if (typeof socialMediaLinks !== 'undefined') {
                    socialMediaLinks[platform] = value;
                }
                // update active class on icon
                const icon = document.querySelector(`.primus-crm-social-icon[data-platform="${platform}"]`);
                if (icon) {
                    if (value) icon.classList.add('active');
                    else icon.classList.remove('active');
                }
            } catch (e) {
                console.warn('Could not update UI state for social link', e);
            }

            showToast(`${platform.charAt(0).toUpperCase() + platform.slice(1)} link saved successfully!`, 'success');
        } else {
            showToast(`Failed to save ${platform} link.`, 'danger');
        }
    })
    .catch(err => {
        console.error('saveSocialLink error', err);
        showToast('Something went wrong!', 'danger');
    });

    // ensure modal closes after request completes
    // use finally if available
    // attach a finally handler by re-wrapping the fetch above is complex here; instead close in both then/catch via Promise.finally
    
    // Move closure into promise chain using Promise.resolve to access finally
    Promise.resolve()
        .then(() => {})
        .finally(() => closeSocialModal());
}
</script>
