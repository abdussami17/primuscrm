<div class="tab-pane fade show active" id="contact-info" role="tabpanel" aria-labelledby="contact-info-tab">
    <form id="dealershipInfoForm" action="{{ route('settings.dealership.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="primus-crm-content-header">
            <h2 class="primus-crm-content-title">Dealership Contact Information</h2>
            <p class="primus-crm-content-description">Configure your dealership's primary contact details and business information.</p>
        </div>

        <div class="primus-crm-form-grid">
            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Dealership Name</label>
                <input type="text" name="name" class="primus-crm-form-control" value="{{ old('name', $dealership->name ?? 'Primus Motors') }}">
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Email Address</label>
                <input type="email" name="email" class="primus-crm-form-control" value="{{ old('email', $dealership->email ?? 'contact@primusmotors.com') }}">
                <span class="primus-crm-form-help">Primary email for customer communications</span>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Phone Number</label>
                <input type="tel" name="phone" class="primus-crm-form-control" value="{{ old('phone', $dealership->phone ?? '+1 (555) 123-4567') }}">
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Language</label>
                <select name="language" class="primus-crm-form-control">
                    <option value="English" {{ (old('language', $dealership->language ?? 'English') == 'English') ? 'selected' : '' }}>English</option>
                    <option value="French" {{ (old('language', $dealership->language ?? '') == 'French') ? 'selected' : '' }}>French</option>
                    <option value="Spanish" {{ (old('language', $dealership->language ?? '') == 'Spanish') ? 'selected' : '' }}>Spanish</option>
                </select>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Timezone</label>
                <select name="timezone" class="primus-crm-form-control">
                    @php $tz = old('timezone', $dealership->timezone ?? 'Eastern Time (ET)'); @endphp
                    <option {{ $tz == 'Eastern Time (ET)' ? 'selected' : '' }}>Eastern Time (ET)</option>
                    <option {{ $tz == 'Central Time (CT)' ? 'selected' : '' }}>Central Time (CT)</option>
                    <option {{ $tz == 'Mountain Time (MT)' ? 'selected' : '' }}>Mountain Time (MT)</option>
                    <option {{ $tz == 'Pacific Time (PT)' ? 'selected' : '' }}>Pacific Time (PT)</option>
                </select>
            </div>

            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                <label class="primus-crm-form-label">Business Address</label>
                <textarea name="address" class="primus-crm-form-control" rows="3">{{ old('address', $dealership->address ?? '123 Main Street, City, State 12345') }}</textarea>
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Website URL</label>
                <input type="url" name="website" class="primus-crm-form-control" value="{{ old('website', $dealership->website ?? 'https://primusmotors.com') }}">
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">Tax ID / EIN</label>
                <input type="text" name="tax_id" class="primus-crm-form-control" value="{{ old('tax_id', $dealership->tax_id ?? 'XX-XXXXXXX') }}">
            </div>

            <div class="primus-crm-form-group">
                <label class="primus-crm-form-label">License Number</label>
                <input type="text" name="license_number" class="primus-crm-form-control" value="{{ old('license_number', $dealership->license_number ?? 'DLR-123456') }}">
            </div>

        </div>

        <div class="primus-crm-actions-footer mt-3">
            <button type="submit" class="primus-crm-btn-save">Save Dealership Info</button>
        </div>

    </form>
</div>
                  