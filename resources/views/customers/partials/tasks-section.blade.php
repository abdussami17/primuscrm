{{-- Tasks Section - resources/views/customers/partials/tasks-section.blade.php --}}

@props(['customerId', 'users' => []])

<div class="col-md-12" id="taskandappointmentSection" data-requires-deal style="display:none;">
    <div class="card-box">
        <div class="d-flex justify-content-between">
            <h6>Task & Appointments</h6>
                <div class="d-flex gap-2">
                     <i class="ti ti-filter" style="font-size:18px;cursor:pointer;" 
                         data-bs-toggle="modal" data-bs-target="#filterTaskModal"></i>
                     <i class="ti ti-refresh" style="font-size:18px;cursor:pointer;" 
                         onclick="loadTasks()"></i>
                     <i class="ti ti-printer" title="Print tasks" style="font-size:18px;cursor:pointer;" onclick="printTasks()"></i>
                     <i class="ti ti-download" title="Export tasks" style="font-size:18px;cursor:pointer;" onclick="exportTasks()"></i>
                     <i class="ti ti-plus" style="font-size:18px;cursor:pointer;" 
                         data-bs-toggle="modal" data-bs-target="#addTaskModal"></i>
                </div>
        </div>
        <div id="tasksContainer" class="tasks-list">
            <p class="text-muted text-center mt-3">Select a deal to view tasks</p>
        </div>
    </div>
</div>

<script>
// Map of user id -> user name (provided server-side)
window.userMap = window.userMap || {};
@if(isset($users) && count($users))
    window.userMap = Object.assign(window.userMap, {
        @foreach($users as $u)
            '{{ $u->id }}': '{{ addslashes($u->name) }}',
        @endforeach
    });
@endif

document.addEventListener('deal:selected', function(e) {
    loadTasks();
});

// Client-side task filters (populated from filter modal)
window.taskFilters = window.taskFilters || { statusType: [], taskType: [] };

// Helper to read multiselect values (works with TomSelect or native select)
function getMultiSelectValues(id) {
    const el = document.getElementById(id);
    if (!el) return [];
    try {
        if (el.tomselect && typeof el.tomselect.getValue === 'function') return el.tomselect.getValue();
        if (window.TomSelect && el.tomselect && typeof el.tomselect.getValue === 'function') return el.tomselect.getValue();
    } catch(e){}
    // native multiple select
    return Array.from(el.selectedOptions || []).map(o => o.value).filter(v => v !== '');
}

// Hook filter modal form submit to apply client-side filters
document.getElementById('filtertaskform')?.addEventListener('submit', function(e) {
    e.preventDefault();
    try {
        window.taskFilters.statusType = getMultiSelectValues('statusType');
        window.taskFilters.taskType = getMultiSelectValues('taskType');
        // Close modal
        const modalEl = document.getElementById('filterTaskModal');
        try { bootstrap.Modal.getInstance(modalEl)?.hide(); } catch (err) {}
        // Reload tasks (client-side filter will be applied)
        loadTasks();
    } catch (err) {
        console.warn('Failed to apply task filters', err);
    }
});

async function loadTasks() {
    if (!AppState.currentDealId) return;
    const container = document.getElementById('tasksContainer');
    
    try {
        const result = await api(`/api/tasks?customer_id={{ $customerId }}&deal_id=${AppState.currentDealId}`);
        let tasks = result.data || [];

        // Apply client-side filters
        try {
            if (window.taskFilters) {
                const normalize = v => (v || '').toString().trim().toLowerCase();

                if (window.taskFilters.statusType && window.taskFilters.statusType.length) {
                    const allowed = window.taskFilters.statusType.map(normalize);
                    tasks = tasks.filter(t => {
                        const st = normalize(t.status_type || t.status || t.statusType || '');
                        return allowed.includes(st);
                    });
                }

                if (window.taskFilters.taskType && window.taskFilters.taskType.length) {
                    const allowed = window.taskFilters.taskType.map(normalize);
                    tasks = tasks.filter(t => {
                        const tt = normalize(t.task_type || t.type || t.taskType || '');
                        // also normalize some common label variants (e.g., 'Inbound Call' vs 'call')
                        const ttShort = tt.replace(/\s+/g, '_');
                        return allowed.includes(tt) || allowed.includes(ttShort);
                    });
                }
            }
        } catch (err) { console.warn('Error filtering tasks client-side', err); }

        container.innerHTML = tasks.length ? tasks.map(task => `
            <div class="d-flex justify-content-between align-items-center task_assignments-section" data-task-id="${task.id}">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-box"><i class="ti ti-calendar"></i></div>
                    <div><p class="mb-0"><strong>${task.task_type}</strong></p></div>
                </div>
                <small>${new Date(task.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</small>
            </div>
        `).join('') : '<p class="text-muted text-center mt-3">No tasks found</p>';
    } catch (error) {
        container.innerHTML = '<p class="text-danger text-center">Failed to load tasks</p>';
    }
}
</script>

<script>
// Export tasks as CSV for the currently selected deal
async function exportTasks() {
    if (!AppState.currentDealId) { showToast('Select a deal first', 'error'); return; }
    try {
        const res = await api(`/api/tasks?customer_id={{ $customerId }}&deal_id=${AppState.currentDealId}`);
        const tasks = res.data || [];
        if (!tasks.length) { showToast('No tasks to export', 'error'); return; }

        const headers = ['id','task_type','due_date','assigned_to','status_type','priority','description'];
        const escape = s => '"' + String(s ?? '').replace(/"/g, '""') + '"';
        const getUserName = (val) => {
            if (!val) return '';
            if (typeof val === 'object') return val.name || val.full_name || '';
            return (window.userMap && window.userMap[val]) ? window.userMap[val] : String(val);
        };
        const rows = tasks.map(t => [t.id, t.task_type, t.due_date, getUserName(t.assigned_to), t.status_type ?? '', t.priority ?? '', t.description ?? ''].map(escape).join(','));
        const csv = [headers.join(','), ...rows].join('\r\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `tasks-deal-${AppState.currentDealId}.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
        showToast('Tasks exported');
    } catch (err) {
        console.error(err);
        showToast('Failed to export tasks', 'error');
    }
}

// Print tasks for the currently selected deal (opens print dialog)
async function printTasks() {
    if (!AppState.currentDealId) { showToast('Select a deal first', 'error'); return; }
    try {
        const res = await api(`/api/tasks?customer_id={{ $customerId }}&deal_id=${AppState.currentDealId}`);
        const tasks = res.data || [];
        const printWindow = window.open('', '_blank');
        const style = `<style>body{font-family:Arial,Helvetica,sans-serif;padding:20px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:8px;text-align:left}th{background:#f5f5f5}</style>`;
        const getUserName = (val) => {
            if (!val) return '';
            if (typeof val === 'object') return val.name || val.full_name || '';
            return (window.userMap && window.userMap[val]) ? window.userMap[val] : String(val);
        };
        const rows = tasks.map(t => `<tr><td>${t.id}</td><td>${t.task_type ?? ''}</td><td>${t.due_date ?? ''}</td><td>${getUserName(t.assigned_to)}</td><td>${t.status_type ?? ''}</td><td>${t.priority ?? ''}</td><td>${(t.description||'').replace(/</g,'&lt;')}</td></tr>`).join('');
        const html = `<!doctype html><html><head><meta charset="utf-8"><title>Tasks - Deal ${AppState.currentDealId}</title>${style}</head><body><h3>Tasks for Deal ${AppState.currentDealId}</h3><table><thead><tr><th>ID</th><th>Type</th><th>Due</th><th>Assigned To</th><th>Status</th><th>Priority</th><th>Description</th></tr></thead><tbody>${rows}</tbody></table></body></html>`;
        printWindow.document.write(html);
        printWindow.document.close();
        printWindow.focus();
        // Delay slightly to allow render
        setTimeout(() => { try { printWindow.print(); } catch (e) { console.warn(e); } }, 300);
    } catch (err) {
        console.error(err);
        showToast('Failed to print tasks', 'error');
    }
}
</script>