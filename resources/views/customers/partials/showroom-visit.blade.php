{{-- Showroom Visit Component - resources/views/customers/partials/showroom-visit.blade.php --}}

<div class="mb-3 bg-light p-3 border rounded">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <strong class="text-primary">Showroom Visit</strong><br>
            <small class="text-muted">Start or stop the visit session</small>
        </div>
        <div>
            <button class="btn btn-primary btn-sm me-2" id="startVisitBtn" onclick="startVisit()">
                Start Visit
            </button>
            <button class="btn btn-light border btn-sm" id="stopVisitBtn" onclick="stopVisit()" disabled>
                Stop Visit
            </button>
            <button class="btn btn-secondary btn-sm ms-2" id="editVisitBtn" onclick="editVisit()" disabled>
                Edit Visit
            </button>
        </div>
    </div>
    <div class="d-flex align-items-start gap-2">
        <div class="avatar-circle">
            <img src="{{ auth()->user()->profile_image ?? '/assets/img/users/avatar-2.jpg' }}" alt="">
        </div>
        <div class="flex-grow-1">
            <div><strong>By:</strong> <span id="visitByName">{{ auth()->user()->name ?? '' }}</span></div>
            <div><strong>Started:</strong> <span id="visitStartTime">--</span></div>
            <div><strong>Ended:</strong> <span id="visitEndTimeDisplay">--</span></div>
            <div><strong>Duration:</strong> <span id="visitDurationDisplay">0 seconds</span></div>
            <div class="mt-1"><span id="visitStatusIndicator" class="text-muted">Visit not started</span></div>
        </div>
    </div>
</div>

<script>
var visitStartTime = null;
var visitInterval = null;
var currentVisitId = null;

function startVisit() {
    // Call central showroom API to create visit
    (async () => {
        try {
            const res = await api('/api/visits/start', 'POST', {
                customer_id: AppState.customerId,
                deal_id: AppState.currentDealId || null
            });
            if (res && res.status === 'success' && res.data) {
                currentVisitId = res.data.id;
                visitStartTime = res.data.start_time ? new Date(res.data.start_time) : new Date();
                // enable edit button for this visit
                try { document.getElementById('editVisitBtn').disabled = false; } catch(e){}
            } else {
                // fallback to local start time
                visitStartTime = new Date();
            }

            document.getElementById('startVisitBtn').disabled = true;
            document.getElementById('stopVisitBtn').disabled = false;
            document.getElementById('visitStartTime').textContent = visitStartTime.toLocaleString();
            document.getElementById('visitStatusIndicator').textContent = 'Visit in progress...';
            document.getElementById('visitStatusIndicator').className = 'text-success';

            visitInterval = setInterval(() => {
                const seconds = Math.floor((new Date() - visitStartTime) / 1000);
                const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
                const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
                const s = (seconds % 60).toString().padStart(2, '0');
                document.getElementById('visitDurationDisplay').textContent = `${h}:${m}:${s}`;
            }, 1000);
        } catch (err) {
            showToast('Failed to start visit', 'error');
        }
    })();
}

async function stopVisit() {
    clearInterval(visitInterval);
    const endTime = new Date();
    const duration = Math.floor((endTime - visitStartTime) / 1000);

    document.getElementById('startVisitBtn').disabled = false;
    document.getElementById('stopVisitBtn').disabled = true;
    document.getElementById('visitEndTimeDisplay').textContent = endTime.toLocaleString();
    document.getElementById('visitStatusIndicator').textContent = 'Visit completed';
    document.getElementById('visitStatusIndicator').className = 'text-muted';

    // If we have a visit id from start, call the central showroom stop route
    if (currentVisitId) {
        try {
            const res = await api(`/api/visits/${currentVisitId}/stop`, 'POST', {
                notes: `Showroom visit - Duration: ${document.getElementById('visitDurationDisplay').textContent}`,
                metadata: {
                    start_time: visitStartTime.toISOString(),
                    end_time: endTime.toISOString(),
                    duration_seconds: duration
                }
            });
            if (res && res.status === 'success') {
                // keep visit id so it can be edited after completion
                if (res.data && res.data.id) currentVisitId = res.data.id;
                showToast('Visit recorded');
                loadNotes();
                // show edit button for completed visit
                try { document.getElementById('editVisitBtn').disabled = false; } catch(e){}
                // update displayed end time and duration from response when available
                if (res.data && res.data.end_time) document.getElementById('visitEndTimeDisplay').textContent = new Date(res.data.end_time).toLocaleString();
                if (res.data && typeof res.data.duration !== 'undefined') {
                    const d = parseInt(res.data.duration || 0, 10);
                    const hh = String(Math.floor(d/3600)).padStart(2,'0');
                    const mm = String(Math.floor((d%3600)/60)).padStart(2,'0');
                    const ss = String(d%60).padStart(2,'0');
                    document.getElementById('visitDurationDisplay').textContent = `${hh}:${mm}:${ss}`;
                }
            } else {
                showToast('Failed to save visit', 'error');
            }
        } catch (error) {
            showToast('Failed to save visit', 'error');
        } finally {
            // stop timer already cleared, do not clear currentVisitId so edit remains available
        }
    } else if (AppState.currentDealId) {
        // fallback: create a note entry when no central visit exists
        try {
            await api('/api/notes', 'POST', {
                customer_id: AppState.customerId,
                deal_id: AppState.currentDealId,
                type: 'Showroom Visit',
                description: `Showroom visit - Duration: ${document.getElementById('visitDurationDisplay').textContent}`,
                metadata: {
                    start_time: visitStartTime ? visitStartTime.toISOString() : null,
                    end_time: endTime.toISOString(),
                    duration_seconds: duration
                }
            });
            showToast('Visit recorded');
            loadNotes();
        } catch (error) {
            showToast('Failed to save visit', 'error');
        }
    }
}

async function editVisit() {
    if (!currentVisitId) {
        showToast('No active visit to edit', 'error');
        return;
    }

    try {
        const res = await api(`/api/visits/${currentVisitId}`, 'GET');
        if (!res || res.status !== 'success' || !res.data) {
            showToast('Failed to load visit data', 'error');
            return;
        }

        const v = res.data;

        // populate shared offcanvas fields used by desklog
        try { document.getElementById('showroom_visit_id').value = v.id || currentVisitId; } catch(e) {}
        try { document.getElementById('showroom_note_text').value = v.notes || ''; } catch(e) {}
        try { document.getElementById('showroom_note_deal_id').value = v.deal_id || (AppState.currentDealId || ''); } catch(e) {}

        // set customer info display
        try { document.getElementById('showroom_customer_link').textContent = v.customer?.full_name || document.getElementById('visitByName').textContent || '—'; } catch(e) {}
        try { document.getElementById('showroom_customer_email').textContent = v.customer?.email || '—'; } catch(e) {}
        try { document.getElementById('showroom_customer_home').textContent = v.customer?.home_phone || '—'; } catch(e) {}
        try { document.getElementById('showroom_customer_work').textContent = v.customer?.work_phone || '—'; } catch(e) {}
        try { document.getElementById('showroom_customer_cell').textContent = v.customer?.cell_phone || '—'; } catch(e) {}

        // set assigned selects if available
        try { if (v.user_id) document.getElementById('showroom_assigned_to').value = v.user_id; } catch(e) {}
        try { if (v.assigned_manager) document.getElementById('showroom_assigned_manager').value = v.assigned_manager; } catch(e) {}

        // populate flags into inputs named flags[key]
        try {
            const flags = v.flags || {};
            Object.keys(flags).forEach(k => {
                const inputs = document.querySelectorAll(`[name="flags[${k}]"]`);
                if (!inputs || inputs.length === 0) return;
                if (inputs[0].type === 'radio') {
                    const yes = Array.from(inputs).find(i => i.value === '1' || i.value === 'Yes');
                    const no = Array.from(inputs).find(i => i.value === '0' || i.value === 'No');
                    if ((flags[k] === true || flags[k] === 1 || flags[k] === '1' || flags[k] === 'Yes') && yes) yes.checked = true;
                    else if (no) no.checked = true;
                } else if (inputs[0].type === 'checkbox') {
                    inputs[0].checked = !!flags[k];
                }
            });
        } catch(e) { console.debug('populate flags failed', e); }

        // show offcanvas
        const offEl = document.getElementById('editShowroomVisitCanvas');
        if (offEl) {
            const off = new bootstrap.Offcanvas(offEl);
            off.show();
        }
    } catch (err) {
        console.error('load visit failed', err);
        showToast('Failed to load visit data', 'error');
    }
}

// Initialize visit state on load: fetch latest visit for this customer/deal
(function initVisitState() {
    (async () => {
        try {
            if (!window.AppState || !AppState.customerId) return;
            const dealId = AppState.currentDealId || '';
            const qs = `?customer_id=${encodeURIComponent(AppState.customerId)}${dealId?`&deal_id=${encodeURIComponent(dealId)}`:''}`;
            const res = await api(`/api/visits/latest${qs}`, 'GET');
            if (!res || res.status !== 'success') return;

            const v = res.data;
            if (!v) {
                // no visit: enable start, disable stop/edit
                try { document.getElementById('startVisitBtn').disabled = false; } catch(e){}
                try { document.getElementById('stopVisitBtn').disabled = true; } catch(e){}
                try { document.getElementById('editVisitBtn').disabled = true; } catch(e){}
                return;
            }

            // we have a visit
            currentVisitId = v.id;
            const status = v.status || '';
            if (status === 'in_progress') {
                // disable start, enable stop and edit, start timer from start_time
                try { document.getElementById('startVisitBtn').disabled = true; } catch(e){}
                try { document.getElementById('stopVisitBtn').disabled = false; } catch(e){}
                try { document.getElementById('editVisitBtn').disabled = false; } catch(e){}
                if (v.start_time) {
                    visitStartTime = new Date(v.start_time);
                    document.getElementById('visitStartTime').textContent = visitStartTime.toLocaleString();
                    visitInterval = setInterval(() => {
                        const seconds = Math.floor((new Date() - visitStartTime) / 1000);
                        const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
                        const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
                        const s = (seconds % 60).toString().padStart(2, '0');
                        document.getElementById('visitDurationDisplay').textContent = `${h}:${m}:${s}`;
                    }, 1000);
                    document.getElementById('visitStatusIndicator').textContent = 'Visit in progress...';
                    document.getElementById('visitStatusIndicator').className = 'text-success';
                }
            } else if (status === 'completed') {
                // disable start and stop, enable edit
                try { document.getElementById('startVisitBtn').disabled = true; } catch(e){}
                try { document.getElementById('stopVisitBtn').disabled = true; } catch(e){}
                try { document.getElementById('editVisitBtn').disabled = false; } catch(e){}
                if (v.start_time) document.getElementById('visitStartTime').textContent = new Date(v.start_time).toLocaleString();
                if (v.end_time) document.getElementById('visitEndTimeDisplay').textContent = new Date(v.end_time).toLocaleString();
                if (typeof v.duration !== 'undefined') {
                    const d = parseInt(v.duration || 0, 10);
                    const hh = String(Math.floor(d/3600)).padStart(2,'0');
                    const mm = String(Math.floor((d%3600)/60)).padStart(2,'0');
                    const ss = String(d%60).padStart(2,'0');
                    document.getElementById('visitDurationDisplay').textContent = `${hh}:${mm}:${ss}`;
                }
                document.getElementById('visitStatusIndicator').textContent = 'Visit completed';
                document.getElementById('visitStatusIndicator').className = 'text-muted';
            } else {
                try { document.getElementById('startVisitBtn').disabled = false; } catch(e){}
                try { document.getElementById('stopVisitBtn').disabled = true; } catch(e){}
                try { document.getElementById('editVisitBtn').disabled = true; } catch(e){}
            }
        } catch (err) {
            console.debug('init visit state failed', err);
        }
    })();
})();
</script>
    {{-- showroom offcanvas intentionally not included here; it's rendered globally in the main layout --}}