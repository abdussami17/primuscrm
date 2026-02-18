{{-- Edit Visit Modal - resources/views/customers/modals/edit-visit.blade.php --}}

<div class="modal fade" id="editVisitsModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Showroom Visit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editVisitForm">
                    <input type="hidden" name="visit_id" id="editVisitId">
                    
                    <div class="mb-3">
                        <label class="form-label">Visit Notes</label>
                        <textarea class="form-control" name="notes" id="visitNotesInput" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Duration (HH:MM:SS)</label>
                        <input type="text" class="form-control" name="duration" id="visitDurationInput" 
                               placeholder="00:05:30" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}">
                        <small class="text-muted">Format: HH:MM:SS (e.g., 00:15:30 for 15 minutes, 30 seconds)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" name="start_time" id="visitTime">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" name="end_time" id="visitEndTime" readonly>
                        <small class="text-muted">Calculated from start time + duration</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveVisitChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());

// Calculate end time when start or duration changes
['visitTime', 'visitDurationInput'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', calculateEndTime);
});

function calculateEndTime() {
    const startTime = document.getElementById('visitTime').value;
    const duration = document.getElementById('visitDurationInput').value;
    
    if (!startTime || !duration) return;
    
    const [hours, minutes, seconds] = duration.split(':').map(Number);
    const startDate = new Date(startTime);
    startDate.setHours(startDate.getHours() + hours);
    startDate.setMinutes(startDate.getMinutes() + minutes);
    startDate.setSeconds(startDate.getSeconds() + seconds);
    
    // Format for datetime-local input
    const endTimeStr = startDate.toISOString().slice(0, 16);
    document.getElementById('visitEndTime').value = endTimeStr;
}

document.getElementById('saveVisitChanges')?.addEventListener('click', async function() {
    const visitId = document.getElementById('editVisitId').value;
    const formData = new FormData(document.getElementById('editVisitForm'));
    
    try {
        await api(`/api/visits/${visitId}`, 'PUT', Object.fromEntries(formData.entries()));
        showToast('Visit updated successfully');
        bootstrap.Modal.getInstance(document.getElementById('editVisitsModal')).hide();
        loadNotes();
    } catch (error) {
        showToast('Failed to update visit', 'error');
    }
});
</script>