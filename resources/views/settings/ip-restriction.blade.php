<!-- IP Restrictions Tab -->
<div class="tab-pane fade" id="ip-restrictions" role="tabpanel" aria-labelledby="ip-restrictions-tab">
    <form id="ipRestrictionForm" action="{{ route('settings.ip.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="primus-crm-content-header">
            <h2 class="primus-crm-content-title">IP Access Restrictions</h2>
            <p class="primus-crm-content-description">Configure IP-based access control settings.</p>
        </div>

        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-network-wired"></i></span>
                IP Filtering Settings
            </h3>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">IP Restriction Mode</label>
                <select name="mode" class="primus-crm-form-control">
                    @php $mode = old('mode', $ipRestriction->mode ?? 'Disabled'); @endphp
                    <option value="Disabled" {{ $mode == 'Disabled' ? 'selected' : '' }}>Disabled</option>
                    <option value="Whitelist" {{ $mode == 'Whitelist' ? 'selected' : '' }}>Whitelist Only (Allow Listed IPs)</option>
                    <option value="Blacklist" {{ $mode == 'Blacklist' ? 'selected' : '' }}>Blacklist (Block Listed IPs)</option>
                </select>
                <span class="primus-crm-form-help">Control how IP restrictions are applied</span>
            </div>

            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                <label class="primus-crm-form-label">Allowed IP Addresses (one per line)</label>
                <textarea name="allowed_ips" class="primus-crm-form-control" rows="6" placeholder="192.168.1.100&#10;10.0.0.0/24&#10;172.16.0.1">{{ old('allowed_ips', $ipRestriction->allowed_ips ?? "192.168.1.100\n192.168.1.101\n10.0.0.0/24") }}</textarea>
                <span class="primus-crm-form-help">Supports individual IPs and CIDR notation</span>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Enable IP restriction bypass for admins</div>
                    <div class="primus-crm-setting-desc">Allow administrators to access from any IP</div>
                </div>
                <div>
                    <input type="hidden" name="bypass_admin" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="bypass_admin" value="1" {{ (old('bypass_admin', isset($ipRestriction) && $ipRestriction->bypass_admin) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Bypass for admins</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Log blocked access attempts</div>
                    <div class="primus-crm-setting-desc">Record all attempts from restricted IPs</div>
                </div>
                <div>
                    <input type="hidden" name="log_blocked" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="log_blocked" value="1" {{ (old('log_blocked', isset($ipRestriction) ? $ipRestriction->log_blocked : true) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Log blocked attempts</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-actions-footer mt-3">
                <button type="submit" class="primus-crm-btn-save">Save IP Restrictions</button>
            </div>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ipRestrictionForm');
        if (!form) return;
        if (form.dataset.primusListenerAttached) return;
        form.dataset.primusListenerAttached = '1';

        // if showToast is not defined (guard), create a minimal one
        if (typeof showToast === 'undefined') {
            window.showToast = function (message, variant = 'success') {
                let container = document.getElementById('primusToastContainer');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'primusToastContainer';
                    container.style.position = 'fixed';
                    container.style.top = '1rem';
                    container.style.right = '1rem';
                    container.style.zIndex = 2000;
                    document.body.appendChild(container);
                }
                const el = document.createElement('div');
                el.textContent = message;
                el.style.marginBottom = '0.5rem';
                el.style.padding = '0.75rem 1rem';
                el.style.borderRadius = '8px';
                el.style.color = '#fff';
                el.style.background = variant === 'error' ? '#dc2626' : '#059669';
                container.appendChild(el);
                setTimeout(() => { el.remove(); }, 3000);
            };
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;
            const data = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: data
            }).then(res => res.json())
            .then(json => {
                if (submitBtn) submitBtn.disabled = false;
                if (json && json.success) {
                    showToast('IP settings saved', 'success');
                    setTimeout(() => window.location.reload(), 700);
                } else {
                    showToast('Failed to save IP settings', 'error');
                }
            }).catch(err => {
                if (submitBtn) submitBtn.disabled = false;
                showToast('Error saving IP settings', 'error');
                console.error(err);
            });
        });
    });
    </script>
</div>