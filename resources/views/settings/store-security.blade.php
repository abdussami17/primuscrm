<!-- Security Tab -->
<div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
    <form id="securityForm" action="{{ route('settings.security.update') }}" method="POST">
        @csrf
        @method('PUT')

        @php $s = $securitySetting ?? null; @endphp

        <div class="primus-crm-content-header">
            <h2 class="primus-crm-content-title">Security Settings</h2>
            <p class="primus-crm-content-description">Configure security policies and authentication requirements.</p>
        </div>

        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-lock"></i></span>
                Password Policy
            </h3>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Minimum Password Length</label>
                <div class="primus-crm-slider-container">
                    <input type="range" name="min_password_length" id="minPasswordLength" class="primus-crm-slider" min="4" max="128" value="{{ old('min_password_length', $s->min_password_length ?? 8) }}" oninput="this.nextElementSibling.textContent = this.value + ' characters'">
                    <span class="primus-crm-slider-value">{{ old('min_password_length', $s->min_password_length ?? 8) }} characters</span>
                </div>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Require uppercase letters</div>
                    <div class="primus-crm-setting-desc">Password must contain at least one uppercase letter</div>
                </div>
                <div>
                    <input type="hidden" name="require_uppercase" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="require_uppercase" value="1" {{ (old('require_uppercase', ($s->require_uppercase ?? true)) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Require uppercase</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Require numbers</div>
                    <div class="primus-crm-setting-desc">Password must contain at least one number</div>
                </div>
                <div>
                    <input type="hidden" name="require_numbers" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="require_numbers" value="1" {{ (old('require_numbers', ($s->require_numbers ?? true)) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Require numbers</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Require special characters</div>
                    <div class="primus-crm-setting-desc">Password must contain special characters (!@#$%)</div>
                </div>
                <div>
                    <input type="hidden" name="require_special" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="require_special" value="1" {{ (old('require_special', ($s->require_special ?? false)) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Require special characters</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Password Expiry (days)</label>
                <input type="number" name="password_expiry_days" class="primus-crm-form-control" value="{{ old('password_expiry_days', $s->password_expiry_days ?? 90) }}" min="0" max="3650">
                <span class="primus-crm-form-help">Set to 0 to disable password expiration</span>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Password History</label>
                <input type="number" name="password_history" class="primus-crm-form-control" value="{{ old('password_history', $s->password_history ?? 5) }}" min="0" max="100">
                <span class="primus-crm-form-help">Prevent reuse of last "X" passwords</span>
            </div>
        </div>

        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-shield-alt"></i></span>
                Two-Factor Authentication
            </h3>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Require 2FA for all users</div>
                    <div class="primus-crm-setting-desc">Mandatory two-factor authentication for all accounts</div>
                </div>
                <div>
                    <input type="hidden" name="require_2fa" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="require_2fa" value="1" {{ (old('require_2fa', ($s->require_2fa ?? false)) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Require 2FA</span>
                    </label>
                </div>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Preferred 2FA Method</label>
                <select name="preferred_2fa_method" class="primus-crm-form-control">
                    <option value="app" {{ (old('preferred_2fa_method', $s->preferred_2fa_method ?? '') === 'app') ? 'selected' : '' }}>Authenticator App (Recommended)</option>
                    <option value="sms" {{ (old('preferred_2fa_method', $s->preferred_2fa_method ?? '') === 'sms') ? 'selected' : '' }}>SMS Code</option>
                    <option value="email" {{ (old('preferred_2fa_method', $s->preferred_2fa_method ?? '') === 'email') ? 'selected' : '' }}>Email Code</option>
                </select>
            </div>

            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Remember device for days</div>
                    <div class="primus-crm-setting-desc">Skip 2FA on trusted devices for specified days</div>
                </div>
                <div>
                    <input type="number" name="remember_device_days" class="primus-crm-form-control" value="{{ old('remember_device_days', $s->remember_device_days ?? 30) }}" min="0" max="365">
                </div>
            </div>
        </div>

        <div class="primus-crm-settings-section">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-user-clock"></i></span>
                Session Management
            </h3>
            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Session Timeout (minutes)</label>
                <input type="number" name="session_timeout_minutes" class="primus-crm-form-control" value="{{ old('session_timeout_minutes', $s->session_timeout_minutes ?? 30) }}" min="1" max="1440">
                <span class="primus-crm-form-help">Automatically log out inactive users</span>
            </div>
        </div>

        <div class="primus-crm-actions-footer mt-3">
            <button type="submit" class="primus-crm-btn-save">Save Security Settings</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('securityForm');
            if (!form) return;
            if (form.dataset.primusListenerAttached) return;
            form.dataset.primusListenerAttached = '1';

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
                        if (typeof showToast !== 'undefined') showToast('Security settings saved', 'success');
                        else alert('Saved');
                        setTimeout(() => window.location.reload(), 600);
                    } else {
                        if (typeof showToast !== 'undefined') showToast('Failed to save', 'error');
                    }
                }).catch(err => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (typeof showToast !== 'undefined') showToast('Error saving settings', 'error');
                    console.error(err);
                });
            });
        });
    </script>
</div>
