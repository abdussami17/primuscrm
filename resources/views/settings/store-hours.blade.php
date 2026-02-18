<!-- Store Hours Tab -->
<div class="tab-pane fade" id="store-hours" role="tabpanel" aria-labelledby="store-hours-tab">
    <form id="storeHoursForm" action="{{ route('settings.store_hours.update') }}" method="POST">
        @php
            $defaultHours = [
                'monday' => ['open' => true, 'start' => '09:00', 'end' => '18:00'],
                'tuesday' => ['open' => true, 'start' => '09:00', 'end' => '18:00'],
                'wednesday' => ['open' => true, 'start' => '09:00', 'end' => '18:00'],
                'thursday' => ['open' => true, 'start' => '09:00', 'end' => '18:00'],
                'friday' => ['open' => true, 'start' => '09:00', 'end' => '18:00'],
                'saturday' => ['open' => true, 'start' => '10:00', 'end' => '16:00'],
                'sunday' => ['open' => false, 'start' => null, 'end' => null],
            ];
        @endphp
        <script>
            // Initialize store hours and holidays from backend
            window.storeHoursData = @json($storeHours->hours ?? $defaultHours);
            window.holidays = @json($storeHours->holiday_overrides ?? []);

            // If the dynamic holiday endpoints are available, fetch latest list
            if (typeof fetchHolidays === 'function') {
                try { fetchHolidays(); } catch (e) { /* ignore */ }
            }
            // expose legacy render function name used elsewhere
            if (typeof renderHolidayList === 'function' && typeof window.renderHolidays === 'undefined') {
                window.renderHolidays = renderHolidayList;
            }
        </script>
        @csrf
        @method('PUT')

        <div class="primus-crm-content-header">
            <h2 class="primus-crm-content-title">Store Operating Hours</h2>
            <p class="primus-crm-content-description">Set your dealership's operating hours for each day of the week.</p>
        </div>

        <!-- Quick Apply Section -->
        <div class="primus-crm-quick-apply-section">
            <div class="primus-crm-quick-apply-header">
                <span>Quick Apply Hours</span>
            </div>
            <div class="primus-crm-quick-apply-controls">
                <select class="primus-crm-time-dropdown" id="quickStartTime">
                    <option value="">Start Time</option>
                    <option value="09:00">9:00 AM</option>
                    <option value="10:00">10:00 AM</option>
                    <option value="11:00">11:00 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="13:00">1:00 PM</option>
                    <option value="14:00">2:00 PM</option>
                    <option value="15:00">3:00 PM</option>
                    <option value="16:00">4:00 PM</option>
                    <option value="17:00">5:00 PM</option>
                    <option value="18:00" selected>6:00 PM</option>
                </select>
                <span style="color: var(--text-secondary); margin: 0 10px;">to</span>
                <select class="primus-crm-time-dropdown" id="quickEndTime">
                    <option value="">End Time</option>
                    <option value="17:00">5:00 PM</option>
                    <option value="18:00" selected>6:00 PM</option>
                    <option value="19:00">7:00 PM</option>
                    <option value="20:00">8:00 PM</option>
                </select>
                <button type="button" class="primus-crm-btn-apply-all" onclick="applyToAllDays()">
                    <i class="fas fa-check-double"></i> Apply to All Days
                </button>
                <button type="button" class="primus-crm-btn-apply-weekdays" onclick="applyToWeekdays()">
                    <i class="fas fa-briefcase"></i> Apply to Weekdays
                </button>
            </div>
        </div>

        <!-- Days of Week -->
        <div class="primus-crm-hours-row" data-day="monday">
            <div class="primus-crm-day-name">Monday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="09:00" selected>9:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="18:00" selected>6:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="tuesday">
            <div class="primus-crm-day-name">Tuesday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="09:00" selected>9:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="18:00" selected>6:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="wednesday">
            <div class="primus-crm-day-name">Wednesday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="09:00" selected>9:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="18:00" selected>6:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="thursday">
            <div class="primus-crm-day-name">Thursday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="09:00" selected>9:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="18:00" selected>6:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="friday">
            <div class="primus-crm-day-name">Friday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="09:00" selected>9:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="18:00" selected>6:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="saturday">
            <div class="primus-crm-day-name">Saturday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" checked onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <select class="primus-crm-time-dropdown day-start-time">
                <option value="10:00" selected>10:00 AM</option>
            </select>
            <span style="color: var(--text-secondary);">to</span>
            <select class="primus-crm-time-dropdown day-end-time">
                <option value="16:00" selected>4:00 PM</option>
            </select>
        </div>

        <div class="primus-crm-hours-row" data-day="sunday">
            <div class="primus-crm-day-name">Sunday</div>
            <label class="primus-crm-custom-checkbox">
                <input type="checkbox" class="day-open" onchange="toggleDayHours(this)">
                <span>Open</span>
            </label>
            <span class="primus-crm-closed-label">Closed</span>
            <select class="primus-crm-time-dropdown day-start-time" style="display: none;"></select>
            <span style="color: var(--text-secondary); display: none;">to</span>
            <select class="primus-crm-time-dropdown day-end-time" style="display: none;"></select>
        </div>

        <!-- Additional Settings -->
        <div class="primus-crm-settings-section" style="margin-top: 2rem;">
            <h3 class="primus-crm-section-title">
                <span class="primus-crm-section-icon"><i class="fas fa-clock"></i></span>
                Additional Settings
            </h3>
            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Show hours on website</div>
                    <div class="primus-crm-setting-desc">Display operating hours on your public website</div>
                </div>
                <div>
                    <input type="hidden" name="show_hours" value="0">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" name="show_hours" value="1" {{ (old('show_hours', isset($storeHours) ? $storeHours->show_hours : true) ? 'checked' : '') }}>
                        <span style="margin-left:8px">Show on website</span>
                    </label>
                </div>
            </div>
            <div class="primus-crm-setting-row">
                <div class="primus-crm-setting-info">
                    <div class="primus-crm-setting-name">Holiday hours override</div>
                    <div class="primus-crm-setting-desc">Allow temporary hours changes for holidays</div>
                </div>
                <div class="primus-crm-toggle-switch active" id="holidayToggle" onclick="toggleHolidaySection(this)"></div>
            </div>

            <!-- Holiday Override Section -->
            <div id="holidayOverrideSection" class="primus-crm-holiday-section">
                <div class="primus-crm-holiday-add-button" onclick="openHolidayModal()">
                    <i class="fas fa-plus-circle"></i> Add Holiday Override
                </div>

                <!-- Holiday List -->
                <div id="holidayList" class="primus-crm-holiday-list">
                    <!-- Dynamic holiday items will appear here -->
                </div>
            </div>

            <div class="primus-crm-actions-footer mt-3">
                <button type="submit" class="primus-crm-btn-save">Save Store Hours</button>
            </div>
        </div>

        <input type="hidden" name="hours" id="storeHoursPayload">
        <input type="hidden" name="holiday_overrides" id="storeHolidayPayload">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('storeHoursForm');
        if (!form) return;
        if (form.dataset.primusListenerAttached) return;
        form.dataset.primusListenerAttached = '1';

            // Ensure time dropdowns are populated (index has a populateTimeDropdowns function)
            if (typeof populateTimeDropdowns === 'function') {
                try { populateTimeDropdowns(); } catch (e) { /* ignore */ }
            }

            // Apply stored hours into UI (after dropdowns are populated)
            setTimeout(function applyStoredHours() {
                const data = window.storeHoursData || {};
                Object.keys(data).forEach(function(day) {
                    const row = document.querySelector(`.primus-crm-hours-row[data-day="${day}"]`);
                    if (!row) return;
                    const info = data[day] || {};
                    const isOpen = !!info.open;
                    const checkbox = row.querySelector('.day-open');
                    if (checkbox) {
                        checkbox.checked = isOpen;
                    }
                    const startSelect = row.querySelector('.day-start-time');
                    const endSelect = row.querySelector('.day-end-time');
                    if (startSelect && info.start) startSelect.value = info.start;
                    if (endSelect && info.end) endSelect.value = info.end;
                    // toggle visibility based on open state
                    if (!isOpen) {
                        if (startSelect) startSelect.style.display = 'none';
                        if (endSelect) endSelect.style.display = 'none';
                        const toSpan = row.querySelector('span[style*="to"]');
                        if (toSpan) toSpan.style.display = 'none';
                    } else {
                        if (startSelect) startSelect.style.display = '';
                        if (endSelect) endSelect.style.display = '';
                        const toSpan = row.querySelector('span[style*="to"]');
                        if (toSpan) toSpan.style.display = '';
                    }
                });

                // Render holidays if helper exists
                if (typeof populateHolidayList === 'function') {
                    try { populateHolidayList(); } catch (e) { /* ignore */ }
                }
                if (typeof renderHolidays === 'function') {
                    try { renderHolidays(); } catch (e) { /* ignore */ }
                }
            }, 120);

        // Helper to collect current hours state
        function collectHours() {
            const rows = document.querySelectorAll('.primus-crm-hours-row');
            const result = {};
            rows.forEach(row => {
                const day = row.getAttribute('data-day');
                const open = !!row.querySelector('.day-open') && row.querySelector('.day-open').checked;
                const start = row.querySelector('.day-start-time') ? row.querySelector('.day-start-time').value : null;
                const end = row.querySelector('.day-end-time') ? row.querySelector('.day-end-time').value : null;
                result[day] = { open: open, start: start, end: end };
            });
            return result;
        }

        // Collect holiday overrides if global variable 'holidays' exists (index has code initializing it)
        function collectHolidays() {
            if (typeof holidays !== 'undefined') return holidays;
            return [];
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;

            document.getElementById('storeHoursPayload').value = JSON.stringify(collectHours());
            document.getElementById('storeHolidayPayload').value = JSON.stringify(collectHolidays());

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
                    if (typeof showToast !== 'undefined') showToast('Store hours saved', 'success');
                    else alert('Store hours saved');
                    setTimeout(() => window.location.reload(), 700);
                } else {
                    if (typeof showToast !== 'undefined') showToast('Failed to save store hours', 'error');
                    else alert('Failed to save store hours');
                }
            }).catch(err => {
                if (submitBtn) submitBtn.disabled = false;
                if (typeof showToast !== 'undefined') showToast('Error saving store hours', 'error');
                else alert('Error saving store hours');
                console.error(err);
            });
        });
    });
    </script>
</div>
