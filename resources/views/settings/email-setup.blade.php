
                                    <div class="tab-pane fade" id="email-account" role="tabpanel"
                                        aria-labelledby="email-account-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Email Account Configuration</h2>
                                            <p class="primus-crm-content-description">Configure SMTP settings and
                                                email delivery options.</p>
                                        </div>

                                        <div class="primus-crm-form-grid">
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">SMTP Host</label>
                                                <input id="smtpHost" type="text" class="primus-crm-form-control"
                                                    value="smtp.gmail.com">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">SMTP Port</label>
                                                <input id="smtpPort" type="number" class="primus-crm-form-control"
                                                    value="587" min="1" max="65535">
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">SMTP Username</label>
                                                <input id="smtpUser" type="email" class="primus-crm-form-control"
                                                    value="crm@primusmotors.com">
                                            </div>
                                            <div class="primus-crm-form-group primus-crm-form-group-full-width">
                                                <label class="primus-crm-form-label">SMTP Password</label>
                                                <input id="smtpPass" type="password" class="primus-crm-form-control"
                                                    value="••••••••">
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">Encryption Method</label>
                                                <select id="smtpEnc" class="primus-crm-form-control">
                                                    <option value="tls" selected>TLS</option>
                                                    <option value="ssl">SSL</option>
                                                    <option value="none">None</option>
                                                </select>
                                            </div>
                                            <div class="primus-crm-form-group">
                                                <label class="primus-crm-form-label">From Name</label>
                                                <input id="smtpFrom" type="text" class="primus-crm-form-control"
                                                    value="Primus Motors">
                                            </div>
                                        </div>
                                        
                                        <script>
document.addEventListener('DOMContentLoaded', function () {
    const emailTab = document.getElementById('email-account');
    if (!emailTab) return;

    // Insert Save button after the first form grid (reuse existing if present)
    const grid = emailTab.querySelector('.primus-crm-form-grid');
    let saveBtn = document.getElementById('saveEmailSettingsBtn');
    if (!saveBtn) {
        const wrapper = document.createElement('div');
        wrapper.className = 'text-end mt-3';
        saveBtn = document.createElement('button');
        saveBtn.id = 'saveEmailSettingsBtn';
        saveBtn.className = 'btn btn-primary';
        saveBtn.textContent = 'Save Email Settings';
        wrapper.appendChild(saveBtn);
        if (grid && grid.parentNode) grid.parentNode.insertBefore(wrapper, grid.nextSibling);
    }

    async function loadEmailSettings() {
        try {
            const res = await fetch('/settings/email-account/data', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const payload = await res.json();
            const data = payload?.data || payload || {};
            const set = (id, value) => { const el = document.getElementById(id); if (el) el.value = value ?? ''; };
            set('smtpHost', data.smtp_host || data.host || '');
            set('smtpPort', data.smtp_port || data.port || '');
            set('smtpUser', data.smtp_user || data.username || '');
            set('smtpPass', data.smtp_pass || data.password || '');
            set('smtpEnc', data.encryption || data.smtp_enc || data.encryption_method || 'TLS');
            set('smtpFrom', data.from_name || data.from || '');
        } catch (e) {
            console.error('Failed to load email settings', e);
        }
    }

    loadEmailSettings();
    // Load broader notification / lead-process settings and populate fields
    async function loadNotificationSettings() {
        try {
            const res = await fetch('/settings/notifications', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const payload = await res.json();
            const data = payload?.data || payload || {};

            const setIf = (id, value) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (el.tagName === 'SELECT' || el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.value = value ?? '';
                    // for multiple select, mark options
                    if (el.multiple && Array.isArray(value)) {
                        Array.from(el.options).forEach(opt => { opt.selected = value.includes(opt.value) || value.includes(opt.text); });
                    }
                }
            };

            // Distribution
            const dist = data.distribution || data.dist || data.lead_distribution || {};
            if (dist.type) setIf('distType', dist.type);
            if (dist.individual) setIf('individualSelect', dist.individual);
            if (dist.team) setIf('teamSelect', dist.team);
            if (data.round_robin !== undefined) setIf('roundRobin', data.round_robin ? 'yes' : 'no');

            // Performance / AI
            const perf = data.performance || data.ai || {};
            if (perf.strategy) setIf('performanceStrategy', perf.strategy);
            if (Array.isArray(perf.members) && perf.members.length) {
                const el = document.getElementById('performanceTeamMembers');
                if (el) {
                    Array.from(el.options).forEach(opt => { opt.selected = perf.members.includes(opt.value) || perf.members.includes(opt.text); });
                }
            }
            if (perf.threshold) setIf('performanceThreshold', perf.threshold);

            // Hybrid weights
            const weights = perf.weights || data.hybrid_weights || {};
            if (weights.close_rate !== undefined) setIf('closeRateWeight', weights.close_rate);
            if (weights.response_time !== undefined) setIf('responseTimeWeight', weights.response_time);
            if (weights.workload !== undefined) setIf('workloadWeight', weights.workload);

            // Timeouts & fallback
            if (data.response_time !== undefined) setIf('responseTime', data.response_time);
            if (data.reassignment_count !== undefined) setIf('reassignmentCount', data.reassignment_count);
            if (data.fallback_manager) setIf('fallbackUser', data.fallback_manager);

            // Alerts / manager toggles
            const toggle = (id, truthy) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (truthy) el.classList.add('active'); else el.classList.remove('active');
            };

            toggle('manualOverrideToggle', data.manual_override ?? data.manualOverride ?? false);
            toggle('showReasoningToggle', data.show_reasoning ?? data.showReasoning ?? false);
            toggle('managerNotifToggle', data.manager_notifications ?? data.managerNotif ?? false);
            toggle('alertsToggle', data.alerts_enabled ?? data.alertsEnabled ?? false);
            toggle('afterHoursToggle', data.after_hours_enabled ?? data.afterHoursEnabled ?? false);

            // Alert details
            if (data.alert_frequency !== undefined) setIf('alertFrequency', data.alert_frequency);
            if (data.alert_repeat !== undefined) setIf('alertRepeat', data.alert_repeat);

            // After hours & stop rules
            if (data.after_hours_sequence) setIf('afterHoursSequence', data.after_hours_sequence);
            if (data.smart_sequence_stop_rule) setIf('smartSequenceStopRule', data.smart_sequence_stop_rule);

            // Custom rules (populate UI list)
            if (Array.isArray(data.custom_rules)) {
                customRules = data.custom_rules;
                displayRules();
            }

            // Ensure UI updates according to selected distribution
            const distEl = document.getElementById('distType');
            if (distEl) distEl.dispatchEvent(new Event('change'));

        } catch (e) {
            console.error('Failed to load notification settings', e);
        }
    }

    loadNotificationSettings();

    saveBtn.addEventListener('click', async function () {
        saveBtn.disabled = true;
        const payload = {
            smtp_host: document.getElementById('smtpHost').value,
            smtp_port: document.getElementById('smtpPort').value,
            smtp_user: document.getElementById('smtpUser').value,
            smtp_pass: document.getElementById('smtpPass').value,
            smtp_enc: document.getElementById('smtpEnc').value,
            smtp_from: document.getElementById('smtpFrom').value
        };

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch('/settings/email-account/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const text = await res.text();
            let data = {};
            try { data = JSON.parse(text); } catch (e) { data = { message: text }; }
            if (!res.ok) {
                const msg = data?.message || ('HTTP ' + res.status);
                throw new Error(msg);
            }
            if (typeof showNotification === 'function') showNotification('Email settings saved', 'success'); else alert('Saved');
            // reload displayed values
            await loadEmailSettings();
        } catch (err) {
            console.error('Save failed', err);
            if (typeof showNotification === 'function') showNotification('Save failed: ' + (err.message || err), 'danger'); else alert('Save failed: ' + (err.message || err));
        } finally {
            saveBtn.disabled = false;
        }
    });
});
</script>

                                        <!-- Save button injected and dynamic load/save handled by script -->

                                        <!-- Lead Process Configuration Section -->
                                        <div class="primus-crm-settings-section mt-5">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-users-cog"></i></span>
                                                Lead Process Configuration
                                            </h3>

                                            <!-- 1️⃣ Lead Distribution Logic -->
                                            <div class="primus-crm-form-grid">
                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Distribution Type</label>
                                                    <select id="distType" class="primus-crm-form-control">
                                                        <option value="individual" selected>Individual</option>
                                                        <option value="team">Team</option>
                                                        <option value="custom">Custom Team / Individuals</option>
                                                        <option value="performance" class="performance-option">⚡
                                                            Performance-Based Distribution (AI-Powered)</option>
                                                    </select>
                                                    <span class="primus-crm-form-help" id="distTypeHelp">Select how
                                                        leads should be distributed to your team.</span>
                                                </div>

                                                <!-- Individual Selection -->
                                                <div id="individualSection" class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Select Individual</label>
                                                    <select id="individualSelect" class="primus-crm-form-control">
                                                        <option value="">-- Select Team Member --</option>
                                                        <option value="1">Ali Khan</option>
                                                        <option value="2">Sara Ali</option>
                                                        <option value="3">Omar Rehman</option>
                                                        <option value="4">Fatima Noor</option>
                                                        <option value="5">Bilal Hussain</option>
                                                        <option value="6">Hassan Raza</option>
                                                        <option value="7">Nadia Aslam</option>
                                                        <option value="8">Usman Tariq</option>
                                                        <option value="9">Ayesha Malik</option>
                                                        <option value="10">Zain Ahmed</option>
                                                        <option value="11">Tariq Mehmood</option>
                                                    </select>
                                                    <span class="primus-crm-form-help">Select a single user for lead
                                                        assignment.</span>
                                                </div>

                                                <!-- Team Selection -->
                                                <div id="teamSection" class="primus-crm-form-group"
                                                    style="display: none;">
                                                    <label class="primus-crm-form-label">Select Team</label>
                                                    <select id="teamSelect" class="primus-crm-form-control">
                                                        c
                                                        <option value="sales-rep">Sales Rep</option>
                                                        <option value="bdc-agent">BDC Agent</option>
                                                        <option value="fi">F&I</option>
                                                        <option value="sales-manager">Sales Manager</option>
                                                        <option value="bdc-manager">BDC Manager</option>
                                                        <option value="finance-director">Finance Director</option>
                                                        <option value="general-sales-manager">General Sales Manager
                                                        </option>
                                                        <option value="general-manager">General Manager</option>
                                                        <option value="dealer-principal">Dealer Principal</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="reception">Reception</option>
                                                        <option value="service-advisor">Service Advisor</option>
                                                        <option value="service-manager">Service Manager</option>
                                                        <option value="inventory-manager">Inventory Manager</option>
                                                        <option value="fixed-operations-manager">Fixed Operations
                                                            Manager</option>
                                                    </select>
                                                    <span class="primus-crm-form-help">All members of this team will
                                                        be included in round robin.</span>
                                                </div>

                                                <!-- Custom Team / Individuals Selection -->
                                                <div id="customSection"
                                                    class="primus-crm-form-group primus-crm-form-group-full-width"
                                                    style="display: none;">
                                                    <label class="primus-crm-form-label">Select Individuals &
                                                        Teams</label>
                                                    <div class="primus-crm-checkbox-list"
                                                        style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 4px;">
                                                        <div
                                                            style="margin-bottom: 10px; font-weight: 600; color: #333;">
                                                            Individuals:</div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="ayesha-malik" id="member1">
                                                            <label class="form-check-label" for="member1">Ayesha
                                                                Malik</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="ali-khan" id="member2">
                                                            <label class="form-check-label" for="member2">Ali
                                                                Khan</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="bilal-hussain" id="member3">
                                                            <label class="form-check-label" for="member3">Bilal
                                                                Hussain</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="fatima-noor" id="member4">
                                                            <label class="form-check-label" for="member4">Fatima
                                                                Noor</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="hassan-raza" id="member5">
                                                            <label class="form-check-label" for="member5">Hassan
                                                                Raza</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="nadia-aslam" id="member6">
                                                            <label class="form-check-label" for="member6">Nadia
                                                                Aslam</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="omar-rehman" id="member7">
                                                            <label class="form-check-label" for="member7">Omar
                                                                Rehman</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="sara-ali" id="member8">
                                                            <label class="form-check-label" for="member8">Sara
                                                                Ali</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="tariq-mehmood" id="member9">
                                                            <label class="form-check-label" for="member9">Tariq
                                                                Mehmood</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="usman-tariq" id="member10">
                                                            <label class="form-check-label" for="member10">Usman
                                                                Tariq</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-member-check"
                                                                type="checkbox" value="zain-ahmed" id="member11">
                                                            <label class="form-check-label" for="member11">Zain
                                                                Ahmed</label>
                                                        </div>

                                                        <hr style="margin: 15px 0;">

                                                        <div
                                                            style="margin-bottom: 10px; font-weight: 600; color: #333;">
                                                            Teams:</div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="sales-rep" id="team1">
                                                            <label class="form-check-label" for="team1">Sales
                                                                Rep</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="bdc-agent" id="team2">
                                                            <label class="form-check-label" for="team2">BDC
                                                                Agent</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="fi" id="team3">
                                                            <label class="form-check-label" for="team3">F&I</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="sales-manager" id="team4">
                                                            <label class="form-check-label" for="team4">Sales
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="bdc-manager" id="team5">
                                                            <label class="form-check-label" for="team5">BDC
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="finance-director" id="team6">
                                                            <label class="form-check-label" for="team6">Finance
                                                                Director</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="general-sales-manager"
                                                                id="team7">
                                                            <label class="form-check-label" for="team7">General
                                                                Sales Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="general-manager" id="team8">
                                                            <label class="form-check-label" for="team8">General
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="dealer-principal" id="team9">
                                                            <label class="form-check-label" for="team9">Dealer
                                                                Principal</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="admin" id="team10">
                                                            <label class="form-check-label"
                                                                for="team10">Admin</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="reception" id="team11">
                                                            <label class="form-check-label"
                                                                for="team11">Reception</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="service-advisor" id="team12">
                                                            <label class="form-check-label" for="team12">Service
                                                                Advisor</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="service-manager" id="team13">
                                                            <label class="form-check-label" for="team13">Service
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="inventory-manager"
                                                                id="team14">
                                                            <label class="form-check-label" for="team14">Inventory
                                                                Manager</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input custom-team-check"
                                                                type="checkbox" value="fixed-operations-manager"
                                                                id="team15">
                                                            <label class="form-check-label" for="team15">Fixed
                                                                Operations Manager</label>
                                                        </div>
                                                    </div>
                                                    <span class="primus-crm-form-help">Select individuals and/or
                                                        teams for custom distribution.</span>
                                                </div>

                                                <!-- Performance-Based Distribution Section -->
                                                <div id="performanceSection"
                                                    class="primus-crm-form-group primus-crm-form-group-full-width"
                                                    style="display: none;">
                                                    <div class="performance-ai-banner">
                                                        <div class="ai-badge">
                                                            <i class="fas fa-brain"></i>
                                                            <span>AI-POWERED</span>
                                                        </div>
                                                        <h4 class="performance-title">
                                                            <i class="fas fa-chart-line me-2"></i>
                                                            Performance-Based Distribution
                                                        </h4>
                                                        <p class="performance-description">
                                                            Revolutionary AI technology that analyzes historical
                                                            data to automatically route leads to your
                                                            highest-performing team members based on real-time
                                                            metrics and behavioral patterns.
                                                        </p>
                                                    </div>

                                                    <!-- AI Learning Status -->
                                                    <div class="ai-learning-status mb-4">
                                                        <div class="learning-header">
                                                            <i class="fas fa-graduation-cap me-2"></i>
                                                            <strong>AI Learning Status</strong>
                                                        </div>
                                                        <div class="learning-progress-bar">
                                                            <div class="learning-progress" id="aiLearningProgress"
                                                                style="width: 35%;">
                                                                <span class="progress-text">35% Trained</span>
                                                            </div>
                                                        </div>
                                                        <div class="learning-info">
                                                            <div class="info-item">
                                                                <i class="fas fa-calendar-check text-primary"></i>
                                                                <span><strong>Active Since:</strong> <span
                                                                        id="aiActiveDate">Jan 15, 2025</span></span>
                                                            </div>
                                                            <div class="info-item">
                                                                <i class="fas fa-database text-success"></i>
                                                                <span><strong>Leads Analyzed:</strong> <span
                                                                        id="aiLeadsAnalyzed">1,247</span></span>
                                                            </div>
                                                            <div class="info-item">
                                                                <i class="fas fa-clock text-warning"></i>
                                                                <span><strong>Est. Full Training:</strong> <span
                                                                        id="aiTrainingTime">45 days</span></span>
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-info mt-3">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Learning Period:</strong> The AI requires 60-90
                                                            days of data to reach optimal accuracy. During this
                                                            period, it analyzes close rates, response times,
                                                            lead-to-sale conversions, and team member availability
                                                            patterns. You can enable it now, and it will improve
                                                            automatically as it learns.
                                                        </div>
                                                    </div>

                                                    <!-- Distribution Strategy Selection -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-bullseye me-2"></i>
                                                            Primary Distribution Strategy
                                                        </label>
                                                        <select id="performanceStrategy"
                                                            class="primus-crm-form-control performance-select">
                                                            <option value="">-- Select Strategy --</option>
                                                            <option value="close_rate">🏆 Highest Close Rate (Assign
                                                                to best converter)</option>
                                                            <option value="response_time">⚡ Fastest Response Time
                                                                (Speed-to-contact)</option>
                                                            <option value="workload">⚖️ Balanced Workload (Lowest
                                                                current leads)</option>
                                                            <option value="revenue">💰 Highest Revenue Per Sale
                                                            </option>
                                                            <option value="satisfaction">⭐ Best Customer
                                                                Satisfaction Score</option>
                                                            <option value="hybrid">🎯 Hybrid AI Model (Multi-factor
                                                                optimization)</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Choose how AI should
                                                            prioritize lead assignment.</span>
                                                    </div>

                                                    <!-- Strategy Details Panel -->
                                                    <div id="strategyDetails" class="strategy-details-panel"
                                                        style="display: none;">
                                                        <!-- Close Rate Strategy -->
                                                        <div class="strategy-detail" data-strategy="close_rate"
                                                            style="display: none;">
                                                            <div class="strategy-icon">🏆</div>
                                                            <h5>Highest Close Rate Strategy</h5>
                                                            <p><strong>How it works:</strong> AI tracks each team
                                                                member's lead-to-sale conversion rate over time and
                                                                assigns new leads to the person with the best
                                                                closing percentage.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Total leads assigned vs. sales closed</li>
                                                                    <li>Close rate by lead source</li>
                                                                    <li>Close rate by vehicle type</li>
                                                                    <li>Historical performance trends</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Teams focused on
                                                                maximizing conversion rates and ROI from every lead.
                                                            </div>
                                                        </div>

                                                        <!-- Response Time Strategy -->
                                                        <div class="strategy-detail" data-strategy="response_time"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⚡</div>
                                                            <h5>Fastest Response Time Strategy</h5>
                                                            <p><strong>How it works:</strong> Routes leads to team
                                                                members who consistently respond fastest, ensuring
                                                                hot leads get immediate attention.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Average time from lead assignment to first
                                                                        contact</li>
                                                                    <li>Response time by time of day/day of week
                                                                    </li>
                                                                    <li>Current availability and activity status
                                                                    </li>
                                                                    <li>Peak performance hours per team member</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Internet leads and
                                                                time-sensitive inquiries where speed is critical.
                                                            </div>
                                                        </div>

                                                        <!-- Workload Strategy -->
                                                        <div class="strategy-detail" data-strategy="workload"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⚖️</div>
                                                            <h5>Balanced Workload Strategy</h5>
                                                            <p><strong>How it works:</strong> Ensures fair
                                                                distribution by routing leads to team members with
                                                                the fewest active opportunities, preventing burnout.
                                                            </p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Current active leads per team member</li>
                                                                    <li>Open tasks and pending follow-ups</li>
                                                                    <li>Scheduled appointments and time commitments
                                                                    </li>
                                                                    <li>Historical capacity handling</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Teams prioritizing
                                                                fairness and preventing individual overload.
                                                            </div>
                                                        </div>

                                                        <!-- Revenue Strategy -->
                                                        <div class="strategy-detail" data-strategy="revenue"
                                                            style="display: none;">
                                                            <div class="strategy-icon">💰</div>
                                                            <h5>Highest Revenue Per Sale Strategy</h5>
                                                            <p><strong>How it works:</strong> Assigns leads to team
                                                                members who historically generate the highest
                                                                average sale value and profit margins.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Average deal value per salesperson</li>
                                                                    <li>Product mix and upsell success rates</li>
                                                                    <li>F&I product penetration</li>
                                                                    <li>Profit per unit trends</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Maximizing profit per
                                                                lead and overall dealership revenue.
                                                            </div>
                                                        </div>

                                                        <!-- Satisfaction Strategy -->
                                                        <div class="strategy-detail" data-strategy="satisfaction"
                                                            style="display: none;">
                                                            <div class="strategy-icon">⭐</div>
                                                            <h5>Best Customer Satisfaction Strategy</h5>
                                                            <p><strong>How it works:</strong> Routes leads to team
                                                                members with the highest customer satisfaction
                                                                ratings and positive reviews.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>Customer survey scores and feedback</li>
                                                                    <li>Online review ratings per salesperson</li>
                                                                    <li>Repeat customer rate</li>
                                                                    <li>Referral generation patterns</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Building long-term
                                                                customer relationships and brand reputation.
                                                            </div>
                                                        </div>

                                                        <!-- Hybrid Strategy -->
                                                        <div class="strategy-detail" data-strategy="hybrid"
                                                            style="display: none;">
                                                            <div class="strategy-icon">🎯</div>
                                                            <h5>Hybrid AI Model (Recommended)</h5>
                                                            <p><strong>How it works:</strong> Advanced multi-factor
                                                                algorithm that weighs multiple performance metrics
                                                                simultaneously for optimal lead placement.</p>
                                                            <div class="metrics-required">
                                                                <strong>AI Analyzes:</strong>
                                                                <ul>
                                                                    <li>All metrics from above strategies</li>
                                                                    <li>Dynamic weighting based on lead type/source
                                                                    </li>
                                                                    <li>Real-time team availability</li>
                                                                    <li>Predictive success probability scoring</li>
                                                                </ul>
                                                            </div>
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-lightbulb me-2"></i>
                                                                <strong>Best For:</strong> Maximum ROI - combines
                                                                all factors for the smartest possible assignment.
                                                            </div>

                                                            <!-- Custom Weighting for Hybrid -->
                                                            <div class="hybrid-weights mt-3">
                                                                <h6><i class="fas fa-sliders-h me-2"></i>Custom
                                                                    Factor Weights (Optional)</h6>
                                                                <div class="weight-slider">
                                                                    <label>Close Rate Importance: <span
                                                                            id="closeRateValue">40%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="closeRateWeight" min="0" max="100"
                                                                        value="40">
                                                                </div>
                                                                <div class="weight-slider">
                                                                    <label>Response Time Importance: <span
                                                                            id="responseTimeValue">30%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="responseTimeWeight" min="0" max="100"
                                                                        value="30">
                                                                </div>
                                                                <div class="weight-slider">
                                                                    <label>Workload Balance Importance: <span
                                                                            id="workloadValue">30%</span></label>
                                                                    <input type="range" class="form-range"
                                                                        id="workloadWeight" min="0" max="100"
                                                                        value="30">
                                                                </div>
                                                                <small class="text-muted">Adjust these values to
                                                                    customize how the AI prioritizes different
                                                                    factors.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Team Member Pool Selection -->
                                                    <div class="primus-crm-form-group mt-4">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-users me-2"></i>
                                                            Select Team Members for AI Distribution Pool
                                                        </label>
                                                        <select id="performanceTeamMembers"
                                                            class="primus-crm-form-control" multiple size="8">
                                                            <option value="1">Ali Khan</option>
                                                            <option value="2">Sara Ali</option>
                                                            <option value="3">Omar Rehman</option>
                                                            <option value="4">Fatima Noor</option>
                                                            <option value="5">Bilal Hussain</option>
                                                            <option value="6">Hassan Raza</option>
                                                            <option value="7">Nadia Aslam</option>
                                                            <option value="8">Usman Tariq</option>
                                                            <option value="9">Ayesha Malik</option>
                                                            <option value="10">Zain Ahmed</option>
                                                            <option value="11">Tariq Mehmood</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Hold Ctrl (Cmd on Mac) to
                                                            select multiple team members. Only selected members will
                                                            be included in AI-powered distribution.</span>
                                                    </div>

                                                    <!-- Performance Threshold -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">
                                                            <i class="fas fa-filter me-2"></i>
                                                            Minimum Performance Threshold
                                                        </label>
                                                        <select id="performanceThreshold"
                                                            class="primus-crm-form-control">
                                                            <option value="none">No Minimum (Include all selected
                                                                members)</option>
                                                            <option value="low">Low (Include members with >10% close
                                                                rate)</option>
                                                            <option value="medium" selected>Medium (Include members
                                                                with >20% close rate)</option>
                                                            <option value="high">High (Include members with >30%
                                                                close rate)</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">Set minimum performance
                                                            criteria. Members below threshold will be excluded from
                                                            AI distribution.</span>
                                                    </div>

                                                    <!-- AI Override Options -->
                                                    <div class="primus-crm-setting-row mt-3">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-name">
                                                                <i class="fas fa-hand-paper me-2"></i>
                                                                Allow Manual Override
                                                            </div>
                                                            <div class="primus-crm-setting-desc">Managers can
                                                                manually reassign AI-distributed leads if needed
                                                            </div>
                                                        </div>
                                                        <div id="manualOverrideToggle"
                                                            class="primus-crm-toggle-switch active"
                                                            onclick="this.classList.toggle('active')"></div>
                                                    </div>

                                                    <div class="primus-crm-setting-row">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-name">
                                                                <i class="fas fa-chart-bar me-2"></i>
                                                                Show AI Reasoning
                                                            </div>
                                                            <div class="primus-crm-setting-desc">Display why AI
                                                                chose specific team member (for transparency)</div>
                                                        </div>
                                                        <div id="showReasoningToggle"
                                                            class="primus-crm-toggle-switch active"
                                                            onclick="this.classList.toggle('active')"></div>
                                                    </div>
                                                </div>

                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Round Robin Enabled</label>
                                                    <select id="roundRobin" class="primus-crm-form-control">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- 2️⃣ Lead Timeout & Reassignment -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-clock me-2"></i>Lead Response Timeout &
                                                    Auto-Reassign</h4>
                                                <p class="primus-crm-form-help mb-2">Define how long selected
                                                    users/teams have to respond before lead reassignment occurs.</p>
                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Response Time
                                                            (minutes)</label>
                                                        <input id="responseTime" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="5">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Reassignment Count
                                                            (cycles)</label>
                                                        <input id="reassignmentCount" type="number"
                                                            class="primus-crm-form-control" min="1" max="10"
                                                            value="3">
                                                        <span class="primus-crm-form-help">Number of times to cycle
                                                            through selected members before fallback.</span>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Fallback
                                                            Manager</label>
                                                        <select id="fallbackUser" class="primus-crm-form-control">
                                                            <option value="">-- Select Fallback Manager --</option>
                                                            <option value="m1">Adnan Malik</option>
                                                            <option value="m2">Sana Khan</option>
                                                            <option value="m3">Farhan Ahmed</option>
                                                            <option value="m4">Hira Qureshi</option>
                                                            <option value="m5">Imran Raza</option>
                                                            <option value="m6">Kiran Fatima</option>
                                                            <option value="m7">Taimoor Shah</option>
                                                            <option value="m8">Ayesha Zafar</option>
                                                            <option value="m9">Usman Javed</option>
                                                            <option value="m10">Nadia Rehman</option>
                                                            <option value="m11">Bilal Khan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Manager Notification
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Notify manager when
                                                            user fails to respond (bell + optional email)</div>
                                                    </div>
                                                    <div id="managerNotifToggle"
                                                        class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                            </div>

                                            <!-- 3️⃣ Lead Alerts & Reminders -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-bell me-2"></i>Pending Lead Alerts</h4>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Enable Alerts</div>
                                                        <div class="primus-crm-setting-desc">Toggle to remind users
                                                            about unanswered leads</div>
                                                    </div>
                                                    <div id="alertsToggle" class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-form-grid mt-3">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Alert Frequency
                                                            (minutes)</label>
                                                        <input id="alertFrequency" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="5">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Repeat Count</label>
                                                        <input id="alertRepeat" type="number"
                                                            class="primus-crm-form-control" min="1" max="99"
                                                            value="4">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 4️⃣ After Hours Handling -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-moon me-2"></i>After Hours Process</h4>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Enable After Hours
                                                            Process</div>
                                                        <div class="primus-crm-setting-desc">Trigger dedicated
                                                            off-hours Smart Sequence</div>
                                                    </div>
                                                    <div id="afterHoursToggle" class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-form-group mt-3">
                                                    <label class="primus-crm-form-label">After Hours Smart
                                                        Sequence</label>
                                                    <select id="afterHoursSequence" class="primus-crm-form-control">
                                                        <option selected>Select Smart Sequence</option>
                                                        <option>Off-Hours Follow Up</option>
                                                        <option>Night Response Automation</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- 5️⃣ Lead Stop Conditions -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-stop-circle me-2"></i>Smart Sequence Stop
                                                    Rules</h4>
                                                <p class="primus-crm-form-help mb-2">Smart Sequence process
                                                    continues unless marked Sold, Lost, or Pending F&I.</p>
                                                <div class="primus-crm-form-group">
                                                    <label class="primus-crm-form-label">Stop On:</label>
                                                    <select id="smartSequenceStopRule"
                                                        class="primus-crm-form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Sold">Sold</option>
                                                        <option value="Lost">Lost</option>
                                                        <option value="Pending F&I">Pending F&I</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-code-branch me-2"></i>Custom Lead Assignment
                                                    Rules</h4>
                                                <p class="primus-crm-form-help mb-2">Create rules for assigning
                                                    leads based on source, vehicle type, or other filters.</p>

                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Rule Name</label>
                                                        <input id="ruleName" type="text"
                                                            class="primus-crm-form-control"
                                                            placeholder="e.g. Facebook Leads Rule">
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Enable Rule</label>
                                                        <select id="ruleEnable" class="primus-crm-form-control">
                                                            <option value="yes">Yes</option>
                                                            <option value="no" selected>No</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Inventory Type</label>
                                                        <select id="ruleVehicle" class="primus-crm-form-control">
                                                            <option value="new">New</option>
                                                            <option value="pre-owned">Pre-Owned</option>
                                                            <option value="cpo">CPO</option>
                                                            <option value="demo">Demo</option>
                                                            <option value="wholesale">Wholesale</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Make</label>
                                                        <select id="ruleMakeModel" class="primus-crm-form-control">
                                                            <option value="">Select Vehicle Make</option>
                                                            <option value="Toyota">Toyota</option>
                                                            <option value="Honda">Honda</option>
                                                            <option value="Suzuki">Suzuki</option>
                                                            <option value="Hyundai">Hyundai</option>
                                                            <option value="Kia">Kia</option>
                                                            <option value="Ford">Ford</option>
                                                            <option value="Chevrolet">Chevrolet</option>
                                                            <option value="Nissan">Nissan</option>
                                                            <option value="BMW">BMW</option>
                                                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                            <option value="Audi">Audi</option>
                                                            <option value="Volkswagen">Volkswagen</option>
                                                            <option value="Lexus">Lexus</option>
                                                            <option value="Mitsubishi">Mitsubishi</option>
                                                            <option value="Jeep">Jeep</option>
                                                        </select>
                                                    </div>

                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Model</label>
                                                        <select name="" id="" class="primus-crm-form-control">
                                                            <option value="">Select Vehicle Model</option>
                                                            <option value="">Camry</option>
                                                            <option value="">Corolla</option>
                                                            <option value="">Mustang</option>
                                                            <option value="">Santa Fe</option>
                                                            <option value="">E-Class</option>
                                                            <option value="">Sonata</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Lead Source</label>
                                                        <select id="ruleSource" class="primus-crm-form-control">
                                                            <option value="facebook" selected>Facebook</option>
                                                            <option value="google">Google Ads</option>
                                                            <option value="kijiji">Kijiji</option>
                                                            <option value="referral">Referral</option>
                                                            <option value="website">Website</option>
                                                        </select>
                                                    </div>

                                                    <!-- NEW: Smart Sequence Assignment Dropdown -->
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Add This Lead
                                                            Assignment to Smart Sequence</label>
                                                        <select id="smartSequenceSelect"
                                                            class="primus-crm-form-control">
                                                            <option value="">Select Smart Sequence</option>
                                                            <option value="seq1">Follow-Up Sequence A</option>
                                                            <option value="seq2">VIP Customer Sequence</option>
                                                            <option value="seq3">New Lead Nurturing</option>
                                                            <option value="seq4">Service Reminder Sequence</option>
                                                            <option value="seq5">Trade-In Follow Up</option>
                                                        </select>
                                                        <span class="primus-crm-form-help">
                                                            Selected users will be assigned to the chosen Smart
                                                            Sequence
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- User Assignment Area -->
                                                <div class="primus-crm-settings-subsection mt-3">
                                                    <h5 class="primus-crm-subtitle"><i
                                                            class="fas fa-users me-2"></i>Assign To Users / Teams
                                                    </h5>
                                                    <div class="primus-crm-form-grid">
                                                        <div class="primus-crm-form-group">
                                                            <label class="primus-crm-form-label">Team</label>
                                                            <select id="ruleTeam" class="primus-crm-form-control"
                                                                onchange="updateMembersDropdown()">
                                                                <option value="all_teams" selected>All User Teams
                                                                </option>
                                                                <option value="sales">Sales Team</option>
                                                                <option value="support">Support Team</option>
                                                                <option value="marketing">Marketing Team</option>
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="primus-crm-form-group primus-crm-form-group-full-width">
                                                            <label class="primus-crm-form-label">Select
                                                                Member</label>
                                                            <select id="ruleMembers" class="form-select" multiple
                                                                placeholder="Search and select members...">
                                                                <!-- Options will be populated dynamically -->
                                                            </select>
                                                            <span class="primus-crm-form-help">
                                                                Type to search for members. Use backspace to remove
                                                                selections.
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="primus-crm-setting-row mt-2 d-none">
                                                        <div id="selectAllToggle" class="primus-crm-toggle-switch"
                                                            onclick="toggleSelectAllUsers(this)"></div>
                                                    </div>
                                                </div>

                                                <div class="text-end mt-4">
                                                    <button id="addRuleBtn"
                                                        class="primus-crm-btn primus-crm-btn-primary btn btn-primary"
                                                        onclick="addCustomRule()">
                                                        <i class="fas fa-plus-circle me-1"></i> Add Custom Rule
                                                    </button>
                                                </div>

                                                <div id="rulesList" class="mt-3"></div>
                                            </div>

                                            <!-- Add TomSelect CSS -->
                                            <link
                                                href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css"
                                                rel="stylesheet">

                                            <script
                                                src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

                                            <script>
                                                // Global variable to store rules
                                                let customRules = [];
                                                let tomSelectInstance = null;



                                                // Team and user data structure
                                                const teamData = {
                                                    all_teams: [
                                                        { id: "u1", name: "John Carter", team: "sales" },
                                                        { id: "u2", name: "Emily Johnson", team: "sales" },
                                                        { id: "u3", name: "Michael Smith", team: "sales" },
                                                        { id: "u4", name: "Olivia Brown", team: "support" },
                                                        { id: "u5", name: "James Wilson", team: "support" },
                                                        { id: "u6", name: "Sophia Davis", team: "marketing" },
                                                        { id: "u7", name: "Daniel Miller", team: "marketing" },
                                                        { id: "u8", name: "Ava Thompson", team: "sales" },
                                                        { id: "u9", name: "Liam Anderson", team: "support" },
                                                        { id: "u10", name: "Isabella Martinez", team: "marketing" },
                                                        { id: "u11", name: "Ethan Roberts", team: "sales" }
                                                    ]
                                                };

                                                // Filtering function
                                                function getMembersByTeam(team) {
                                                    if (team === "all_teams") {
                                                        return teamData.all_teams;
                                                    }
                                                    return teamData.all_teams.filter(member => member.team === team);
                                                }

                                                // Initialize TomSelect with options
                                                function initializeTomSelect(options = []) {
                                                    const selectElement = document.getElementById('ruleMembers');
                                                    selectElement.innerHTML = '';

                                                    options.forEach(option => {
                                                        const opt = document.createElement('option');
                                                        opt.value = option.value;
                                                        opt.textContent = option.text;
                                                        selectElement.appendChild(opt);
                                                    });

                                                    // Destroy previous instance
                                                    if (tomSelectInstance) {
                                                        tomSelectInstance.destroy();
                                                    }

                                                    // Initialize new TomSelect
                                                    tomSelectInstance = new TomSelect(selectElement, {
                                                        plugins: ['remove_button', 'checkbox_options'],
                                                        maxItems: null,
                                                        placeholder: 'Search and select members...',
                                                        searchField: ['text'],
                                                        render: {
                                                            option: (data, escape) =>
                                                                `<div class="d-flex align-items-center">
                <span class="flex-grow-1">${escape(data.text)}</span>
             </div>`,
                                                            item: (data, escape) =>
                                                                `<div class="ts-item">${escape(data.text)}</div>`,
                                                            no_results: (data, escape) =>
                                                                `<div class="no-results">No members found for "${escape(data.input)}"</div>`
                                                        },
                                                        onInitialize() {
                                                            this.setValue([]);
                                                        }
                                                    });
                                                }

                                                // Update members dropdown
                                                function updateMembersDropdown() {
                                                    const selectedTeam = document.getElementById('ruleTeam').value;

                                                    let filteredMembers = getMembersByTeam(selectedTeam);

                                                    let options = [];

                                                    // Add "All Users" only for All Teams
                                                    if (selectedTeam === "all_teams") {
                                                        options.push({ value: "all_users", text: "All Users" });
                                                    }

                                                    filteredMembers.forEach(m => {
                                                        options.push({
                                                            value: m.id,
                                                            text: m.name
                                                        });
                                                    });

                                                    // Update TomSelect
                                                    initializeTomSelect(options);
                                                }

                                                // Initialize default
                                                document.addEventListener("DOMContentLoaded", () => {
                                                    updateMembersDropdown();
                                                });

                                                // Distribution Type Logic - Auto show/hide sections and set Round Robin defaults
                                                (function () {
                                                    const distTypeEl = document.getElementById('distType');
                                                    if (!distTypeEl) return;
                                                    distTypeEl.addEventListener('change', function () {
                                                        const distType = this.value;
                                                        const individualSection = document.getElementById('individualSection');
                                                        const teamSection = document.getElementById('teamSection');
                                                        const customSection = document.getElementById('customSection');
                                                        const performanceSection = document.getElementById('performanceSection');
                                                        const roundRobinSelect = document.getElementById('roundRobin');
                                                        const distTypeHelp = document.getElementById('distTypeHelp');

                                                        // Hide all sections first (defensive)
                                                        [individualSection, teamSection, customSection, performanceSection].forEach(el => { if (el) el.style.display = 'none'; });
                                                        if (roundRobinSelect) roundRobinSelect.value = roundRobinSelect.value || 'no';
                                                        if (!distTypeHelp) return;

                                                        // Show relevant section and set Round Robin default
                                                        if (distType === 'individual') {
                                                            if (individualSection) individualSection.style.display = 'block';
                                                            if (roundRobinSelect) roundRobinSelect.value = 'no';
                                                            distTypeHelp.textContent = 'Select a single user for lead assignment.';
                                                        } else if (distType === 'team') {
                                                            if (teamSection) teamSection.style.display = 'block';
                                                            if (roundRobinSelect) roundRobinSelect.value = 'yes';
                                                            distTypeHelp.textContent = 'All members of this team will be included in round robin.';
                                                        } else if (distType === 'custom') {
                                                            if (customSection) customSection.style.display = 'block';
                                                            if (roundRobinSelect) roundRobinSelect.value = 'yes';
                                                            distTypeHelp.textContent = 'Select individuals and/or teams for custom distribution.';
                                                        } else if (distType === 'performance') {
                                                            if (performanceSection) performanceSection.style.display = 'block';
                                                            if (roundRobinSelect) roundRobinSelect.value = 'no';
                                                            distTypeHelp.innerHTML = '<strong>AI-Powered Distribution:</strong> Leads are automatically assigned based on performance metrics and AI analysis.';
                                                        }
                                                    });
                                                })();

                                                // Performance Strategy Change Handler
                                                (function () {
                                                    const perfEl = document.getElementById('performanceStrategy');
                                                    if (!perfEl) return;
                                                    perfEl.addEventListener('change', function () {
                                                        const strategy = this.value;
                                                        const strategyDetails = document.getElementById('strategyDetails');
                                                        const allDetails = document.querySelectorAll('.strategy-detail');

                                                        // Hide all strategy details (defensive)
                                                        allDetails.forEach(detail => { if (detail) detail.style.display = 'none'; });

                                                        if (strategy) {
                                                            if (strategyDetails) strategyDetails.style.display = 'block';
                                                            const selectedDetail = document.querySelector(`.strategy-detail[data-strategy="${strategy}"]`);
                                                            if (selectedDetail) selectedDetail.style.display = 'block';
                                                        } else {
                                                            if (strategyDetails) strategyDetails.style.display = 'none';
                                                        }
                                                    });
                                                })();

                                                // Hybrid Weight Sliders
                                                ['closeRateWeight', 'responseTimeWeight', 'workloadWeight'].forEach(id => {
                                                    const slider = document.getElementById(id);
                                                    if (slider) {
                                                        slider.addEventListener('input', function () {
                                                            const valueId = id.replace('Weight', 'Value');
                                                            const valueEl = document.getElementById(valueId);
                                                            if (valueEl) valueEl.textContent = this.value + '%';
                                                        });
                                                    }
                                                });

                                                // Toggle Select All Users functionality
                                                function toggleSelectAllUsers(toggleElement) {
                                                    toggleElement.classList.toggle('active');
                                                    const isActive = toggleElement.classList.contains('active');

                                                    if (tomSelectInstance) {
                                                        if (isActive) {
                                                            // Select all available options
                                                            const allValues = Object.values(tomSelectInstance.options).map(opt => opt.value);
                                                            tomSelectInstance.setValue(allValues);
                                                        } else {
                                                            // Clear all selections
                                                            tomSelectInstance.setValue([]);
                                                        }
                                                    }
                                                }

                                                // Add Custom Rule functionality
                                                function addCustomRule() {
                                                    const ruleName = document.getElementById('ruleName').value.trim();
                                                    const ruleEnable = document.getElementById('ruleEnable').value;
                                                    const ruleVehicle = document.getElementById('ruleVehicle').value;
                                                    const ruleMakeModel = document.getElementById('ruleMakeModel').value.trim();
                                                    const ruleSource = document.getElementById('ruleSource').value;
                                                    const ruleTeam = document.getElementById('ruleTeam').value;
                                                    const smartSequence = document.getElementById('smartSequenceSelect').value;
                                                    const selectAllActive = document.getElementById('selectAllToggle').classList.contains('active');

                                                    // Get selected members from TomSelect
                                                    let selectedMembers = [];
                                                    if (tomSelectInstance) {
                                                        const selectedValues = tomSelectInstance.getValue();
                                                        selectedMembers = selectedValues.map(value => {
                                                            const option = tomSelectInstance.options[value];
                                                            return option ? option.text : value;
                                                        });
                                                    }

                                                    // Validation
                                                    if (!ruleName) {
                                                        showNotification('Please enter a rule name', 'danger');
                                                        return;
                                                    }

                                                    if (!selectedMembers.length && !selectAllActive) {
                                                        showNotification('Please select at least one member or enable "Select All Users"', 'danger');
                                                        return;
                                                    }

                                                    // Create rule object
                                                    const rule = {
                                                        id: Date.now(),
                                                        name: ruleName,
                                                        enabled: ruleEnable,
                                                        vehicleType: ruleVehicle,
                                                        makeModel: ruleMakeModel || 'Any',
                                                        source: ruleSource,
                                                        team: ruleTeam,
                                                        smartSequence: smartSequence,
                                                        members: selectAllActive ? 'All Users' : selectedMembers.join(', '),
                                                        selectAll: selectAllActive
                                                    };

                                                    // Add to rules array
                                                    customRules.push(rule);

                                                    // Display the rule
                                                    displayRules();

                                                    // Clear form
                                                    document.getElementById('ruleName').value = '';
                                                    document.getElementById('ruleEnable').value = 'yes';
                                                    document.getElementById('ruleVehicle').value = 'new';
                                                    document.getElementById('ruleMakeModel').value = '';
                                                    document.getElementById('ruleSource').value = 'facebook';
                                                    document.getElementById('ruleTeam').value = 'sales';
                                                    document.getElementById('smartSequenceSelect').value = '';

                                                    // Clear TomSelect selections but keep options
                                                    if (tomSelectInstance) {
                                                        tomSelectInstance.setValue([]);
                                                    }

                                                    document.getElementById('selectAllToggle').classList.remove('active');

                                                    showNotification('Custom rule added successfully!', 'success');
                                                }

                                                // Display all rules
                                                function displayRules() {
                                                    const rulesList = document.getElementById('rulesList');

                                                    if (customRules.length === 0) {
                                                        rulesList.innerHTML = '<p class="text-muted">No custom rules created yet.</p>';
                                                        return;
                                                    }

                                                    let html = '<div class="list-group">';

                                                    customRules.forEach(rule => {
                                                        const statusBadge = rule.enabled === 'yes'
                                                            ? '<span class="badge bg-success">Enabled</span>'
                                                            : '<span class="badge bg-secondary">Disabled</span>';

                                                        // Get Smart Sequence name
                                                        const smartSequenceSelect = document.getElementById('smartSequenceSelect');
                                                        const smartSequenceOption = smartSequenceSelect.querySelector(`option[value="${rule.smartSequence}"]`);
                                                        const smartSequenceName = smartSequenceOption ? smartSequenceOption.textContent : 'Not assigned';

                                                        html += `
                                                            <div class="list-group-item" id="rule-${rule.id}">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="mb-1">
                                                                            <i class="fas fa-filter me-2"></i>${rule.name} 
                                                                            ${statusBadge}
                                                                        </h6>
                                                                        <p class="mb-1 small">
                                                                            <strong>Source:</strong> ${rule.source.charAt(0).toUpperCase() + rule.source.slice(1)} | 
                                                                            <strong>Vehicle:</strong> ${rule.vehicleType.charAt(0).toUpperCase() + rule.vehicleType.slice(1)} | 
                                                                            <strong>Make/Model:</strong> ${rule.makeModel}
                                                                        </p>
                                                                        <p class="mb-1 small">
                                                                            <strong>Team:</strong> ${rule.team.charAt(0).toUpperCase() + rule.team.slice(1)} Team | 
                                                                            <strong>Assigned To:</strong> ${rule.members}
                                                                        </p>
                                                                        ${rule.smartSequence ? `<p class="mb-1 small"><strong>Smart Sequence:</strong> ${smartSequenceName}</p>` : ''}
                                                                    </div>
                                                                    <div class="btn-group btn-group-sm ms-3">
                                                                        <button class="btn btn-outline-danger" onclick="deleteRule(${rule.id})" title="Delete Rule">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                                    });

                                                    html += '</div>';
                                                    rulesList.innerHTML = html;
                                                }

                                                // Delete rule
                                                function deleteRule(ruleId) {
                                                    if (confirm('Are you sure you want to delete this rule?')) {
                                                        customRules = customRules.filter(rule => rule.id !== ruleId);
                                                        displayRules();
                                                        showNotification('Rule deleted successfully!', 'success');
                                                    }
                                                }

                                                // Simulate Lead functionality (defensive)
                                                function simulateLead() {
                                                    const g = id => document.getElementById(id);
                                                    const simSourceEl = g('simSource');
                                                    const simVehicleEl = g('simVehicle');
                                                    const simMakeModelEl = g('simMakeModel');
                                                    const demoModeEl = g('demoMode');

                                                    const simSource = simSourceEl ? simSourceEl.value : '';
                                                    const simVehicle = simVehicleEl ? simVehicleEl.value : '';
                                                    const simMakeModel = simMakeModelEl ? (simMakeModelEl.value || '').trim() : '';
                                                    const demoMode = demoModeEl ? !!demoModeEl.checked : false;

                                                    if (!simMakeModel) {
                                                        if (typeof showNotification === 'function') showNotification('Please enter Make/Model for simulation', 'warning'); else alert('Please enter Make/Model for simulation');
                                                        return;
                                                    }

                                                    const distTypeEl = g('distType');
                                                    const roundRobinEl = g('roundRobin');
                                                    const responseTimeEl = g('responseTime');
                                                    const reassignmentCountEl = g('reassignmentCount');
                                                    const fallbackUserEl = g('fallbackUser');

                                                    const distType = distTypeEl ? distTypeEl.value : '';
                                                    const roundRobin = roundRobinEl ? roundRobinEl.value : '';
                                                    const responseTime = responseTimeEl ? responseTimeEl.value : '';
                                                    const reassignmentCount = reassignmentCountEl ? reassignmentCountEl.value : '';

                                                    let assignedTo = 'Not assigned';
                                                    let distributionMethod = 'Default';

                                                    if (distType === 'performance') {
                                                        const perfStrategyEl = g('performanceStrategy');
                                                        const strategy = perfStrategyEl ? perfStrategyEl.value : '';
                                                        const performanceTeamMembers = g('performanceTeamMembers');
                                                        const selectedMembers = performanceTeamMembers && performanceTeamMembers.selectedOptions ? Array.from(performanceTeamMembers.selectedOptions).map(o => o.text) : [];

                                                        if (!strategy) {
                                                            if (typeof showNotification === 'function') showNotification('Please select a Performance Strategy', 'warning'); else alert('Please select a Performance Strategy');
                                                            return;
                                                        }

                                                        if (selectedMembers.length === 0) {
                                                            if (typeof showNotification === 'function') showNotification('Please select team members for AI distribution pool', 'warning'); else alert('Please select team members for AI distribution pool');
                                                            return;
                                                        }

                                                        const strategyNames = {
                                                            'close_rate': 'Highest Close Rate',
                                                            'response_time': 'Fastest Response Time',
                                                            'workload': 'Balanced Workload',
                                                            'revenue': 'Highest Revenue Per Sale',
                                                            'satisfaction': 'Best Customer Satisfaction',
                                                            'hybrid': 'Hybrid AI Model'
                                                        };

                                                        const randomMember = selectedMembers[Math.floor(Math.random() * selectedMembers.length)];
                                                        assignedTo = randomMember;
                                                        distributionMethod = `AI-Powered (${strategyNames[strategy] || 'Default'})`;

                                                        const showReasoningEl = g('showReasoningToggle');
                                                        const showReasoning = showReasoningEl ? showReasoningEl.classList.contains('active') : false;
                                                        if (showReasoning) {
                                                            let reasoning = '';
                                                            switch (strategy) {
                                                                case 'close_rate':
                                                                    reasoning = `${randomMember} has a 32% close rate (highest in pool)`;
                                                                    break;
                                                                case 'response_time':
                                                                    reasoning = `${randomMember} average response time: 2.3 minutes (fastest)`;
                                                                    break;
                                                                case 'workload':
                                                                    reasoning = `${randomMember} has 5 active leads (lowest workload)`;
                                                                    break;
                                                                case 'revenue':
                                                                    reasoning = `${randomMember} average deal value: $45,200 (highest)`;
                                                                    break;
                                                                case 'satisfaction':
                                                                    reasoning = `${randomMember} customer satisfaction: 4.8/5 stars (highest)`;
                                                                    break;
                                                                case 'hybrid':
                                                                    reasoning = `${randomMember} scored 94/100 on multi-factor analysis (close rate: 28%, response: 3.1 min, workload: 7 leads)`;
                                                                    break;
                                                            }
                                                            distributionMethod += `<br><small class="text-muted">AI Reasoning: ${reasoning}</small>`;
                                                        }
                                                    } else {
                                                        let matchedRule = null;
                                                        for (let rule of customRules || []) {
                                                            if (rule && rule.enabled === 'yes' && rule.source === simSource) {
                                                                if (rule.vehicleType === 'any' || rule.vehicleType === simVehicle) {
                                                                    if (!rule.makeModel || rule.makeModel === 'Any' || simMakeModel.toLowerCase().includes(rule.makeModel.toLowerCase())) {
                                                                        matchedRule = rule; break;
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        if (matchedRule) {
                                                            assignedTo = matchedRule.members || assignedTo;
                                                            distributionMethod = `Custom Rule: ${matchedRule.name}`;
                                                        } else {
                                                            if (distType === 'individual') {
                                                                const individual = g('individualSelect');
                                                                if (individual && individual.options.length) assignedTo = individual.options[individual.selectedIndex]?.text || 'Not selected';
                                                                distributionMethod = 'Individual Assignment';
                                                            } else if (distType === 'team') {
                                                                const team = g('teamSelect');
                                                                if (team && team.options.length) assignedTo = team.options[team.selectedIndex]?.text || 'Not selected';
                                                                distributionMethod = `Team Assignment (Round Robin: ${roundRobin})`;
                                                            } else if (distType === 'custom') {
                                                                const selectedMembers = [];
                                                                document.querySelectorAll('.custom-member-check:checked').forEach(cb => selectedMembers.push(cb.nextElementSibling ? cb.nextElementSibling.textContent : ''));
                                                                document.querySelectorAll('.custom-team-check:checked').forEach(cb => selectedMembers.push((cb.nextElementSibling ? cb.nextElementSibling.textContent : '') + ' Team'));
                                                                assignedTo = selectedMembers.length > 0 ? selectedMembers.join(', ') : 'None selected';
                                                                distributionMethod = `Custom Assignment (Round Robin: ${roundRobin})`;
                                                            }
                                                        }
                                                    }

                                                    const timeUnit = demoMode ? 'seconds' : 'minutes';
                                                    const timeValue = responseTimeEl ? responseTimeEl.value : '';
                                                    const fallbackUserText = fallbackUserEl && fallbackUserEl.options && fallbackUserEl.selectedIndex >= 0 ? fallbackUserEl.options[fallbackUserEl.selectedIndex].text : 'Not selected';

                                                    const resultHTML = `
                                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                            <h6 class="alert-heading"><i class="fas fa-vial me-2"></i>Lead Simulation Result</h6>
                                                            <hr>
                                                            <p class="mb-1"><strong>Source:</strong> ${simSource ? simSource.charAt(0).toUpperCase() + simSource.slice(1) : 'N/A'}</p>
                                                            <p class="mb-1"><strong>Vehicle:</strong> ${simVehicle ? simVehicle.charAt(0).toUpperCase() + simVehicle.slice(1) : 'N/A'} - ${simMakeModel}</p>
                                                            <p class="mb-1"><strong>Distribution Method:</strong> ${distributionMethod}</p>
                                                            <p class="mb-1"><strong>Assigned To:</strong> ${assignedTo}</p>
                                                            <p class="mb-1"><strong>Response Timeout:</strong> ${timeValue} ${timeUnit}</p>
                                                            <p class="mb-1"><strong>Reassignment Cycles:</strong> ${reassignmentCount}</p>
                                                            <p class="mb-1"><strong>Fallback Manager:</strong> ${fallbackUserText}</p>
                                                            ${demoMode ? '<p class="mb-0 mt-2"><span class="badge bg-warning text-dark">Demo Mode Active</span></p>' : ''}
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    `;

                                                    const notificationsEl = g('notifications');
                                                    if (notificationsEl) notificationsEl.innerHTML = resultHTML;

                                                    if (typeof showNotification === 'function') showNotification('Lead simulation completed!', 'success');
                                                }

                                                // Show notification helper
                                                function showNotification(message, type = 'info') {
                                                    const notification = document.createElement('div');
                                                    notification.className = `alert alert-${type} alert-dismissible fade show`;
                                                    notification.style.position = 'fixed';
                                                    notification.style.top = '20px';
                                                    notification.style.right = '20px';
                                                    notification.style.zIndex = '9999';
                                                    notification.style.minWidth = '300px';
                                                    notification.style.maxWidth = '500px';
                                                    notification.innerHTML = `
                                                        ${message}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    `;

                                                    document.body.appendChild(notification);

                                                    // Auto remove after 4 seconds
                                                    setTimeout(() => {
                                                        notification.classList.remove('show');
                                                        setTimeout(() => notification.remove(), 150);
                                                    }, 4000);
                                                }

                                                // Initialize on page load
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // Trigger the change event to set initial state
                                                    document.getElementById('distType').dispatchEvent(new Event('change'));

                                                    // Initialize team dropdown with default options
                                                    updateMembersDropdown();

                                                    // Backend-controlled email settings (hidden from UI)
                                                    const emailSettings = {
                                                        dailyLimit: 100,
                                                        retryAttempts: 3,
                                                        trackOpens: true,
                                                        trackClicks: true
                                                    };

                                                    console.log('Email settings (backend-controlled):', emailSettings);

                                                    // Initialize rules display
                                                    displayRules();
                                                });
                                            </script>

                                            <!-- Simulation & Testing -->
                                            <div class="primus-crm-settings-subsection mt-4">
                                                <h4 class="primus-crm-subtitle"><i
                                                        class="fas fa-vial me-2"></i>Simulate Incoming Lead (Test
                                                    Rules)</h4>
                                                <div class="primus-crm-form-grid">
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Lead Source</label>
                                                        <select id="simSource" class="primus-crm-form-control">
                                                            <option value="facebook">Facebook</option>
                                                            <option value="google">Google Ads</option>
                                                            <option value="kijiji">Kijiji</option>
                                                            <option value="website">Website</option>
                                                            <option value="referral">Referral</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Vehicle Type</label>
                                                        <select id="simVehicle" class="primus-crm-form-control">
                                                            <option value="new">New</option>
                                                            <option value="used">Used</option>
                                                        </select>
                                                    </div>
                                                    <div class="primus-crm-form-group">
                                                        <label class="primus-crm-form-label">Make / Model</label>
                                                        <input id="simMakeModel" type="text"
                                                            class="primus-crm-form-control"
                                                            placeholder="e.g. Honda Civic">
                                                    </div>
                                                </div>

                                                <!-- <div class="primus-crm-form-group mt-2">
                                                    <label class="primus-crm-form-label">Demo Mode (minutes →
                                                        seconds)</label>
                                                    <div class="primus-crm-setting-row">
                                                        <div class="primus-crm-setting-info">
                                                            <div class="primus-crm-setting-desc">Enable for quick
                                                                testing</div>
                                                        </div>
                                                        <input id="demoMode" type="checkbox" />
                                                    </div>
                                                </div> -->

                                                <div class="text-end mt-3">
                                                    <button id="simulateLeadBtn"
                                                        class="primus-crm-btn primus-crm-btn-secondary btn btn-primary"
                                                        onclick="simulateLead()">
                                                        Simulate Lead
                                                    </button>
                                                </div>

                                                <div id="notifications" class="mt-3"></div>
                                            </div>
                                        </div>
                                    </div>