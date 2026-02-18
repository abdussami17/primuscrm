{{-- Activity Timeline Section - resources/views/customers/partials/activity-timeline.blade.php --}}

<div class="col-md-12 mb-4" id="activityTimelineSection" data-requires-deal style="display:none;">
    <div class="card-box">
        <div class="d-flex justify-content-between">
            <h6>Activity Timeline</h6>
            <i class="ti ti-refresh" style="font-size:18px;cursor:pointer;" onclick="loadActivities()"></i>
        </div>
        <div id="activityContainer" class="activities-list">
            <p class="text-muted text-center mt-3">Select a deal to view activity</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('deal:selected', function(e) {
    loadActivities();
});

async function loadActivities() {
    if (!AppState.currentDealId) return;
    const container = document.getElementById('activityContainer');
    
    try {
        const result = await api(`/api/deals/${AppState.currentDealId}/activities`);
        const activities = result.data || [];
        
        const icons = {
            'vehicle_change': 'car',
            'status_change': 'toggle-right',
            'note_added': 'note',
            'deal_created': 'receipt',
            'customer_update': 'user',
            'task_created': 'calendar-plus',
            'task_completed': 'calendar-check'
        };
        
        container.innerHTML = activities.length ? activities.map(a => `
            <div class="d-flex justify-content-between align-items-start mt-2 task_assignments-section">
                <div class="d-flex align-items-center gap-2 flex-grow-1">
                    <div class="icon-box">
                        <i class="ti ti-${icons[a.type] || 'activity'}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 text-wrap">
                            ${a.description}
                            ${a.user ? ` by <strong>${a.user.name}</strong>` : ''}
                        </p>
                    </div>
                </div>
                <div class="ms-2" style="white-space:nowrap;">
                    <small class="text-muted">
                        ${new Date(a.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                    </small>
                </div>
            </div>
        `).join('') : '<p class="text-muted text-center mt-3">No activity yet</p>';
    } catch (error) {
        container.innerHTML = '<p class="text-danger text-center">Failed to load activities</p>';
    }
}
</script>