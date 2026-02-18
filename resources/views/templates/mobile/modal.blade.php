<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title" id="addTemplateModal">Create Phone Script</h1>
                <div>
                    <button type="button" id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                        <i class="ti ti-minimize" data-bs-toggle="tooltip" data-bs-title="Minimize"></i>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form id="templateForm" action="{{ route('templates.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="templateFormMethod" value="POST">
                    <input type="hidden" name="template_id" id="templateId">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="body" id="bodyInput">
                    <input type="hidden" id="templateFormAction" value="create">

                    @include('templates.mobile.editor-content')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="templateForm" class="btn btn-primary">Save Phone Script</button>
            </div>
        </div>
    </div>
</div>

<div id="minimizedBar" class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow" style="cursor: pointer; z-index: 1050; border-radius: 6px;">
    Phone Script Editor
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const modalEl = document.getElementById("addTemplateModal");
    const minimizeBtn = document.getElementById("minimizeModalBtn");
    const minimizedBar = document.getElementById("minimizedBar");

    if (!modalEl || !minimizeBtn || !minimizedBar) return;

    const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);

    // Restore state
    const modalState = localStorage.getItem("templateModalState");

    if (modalState === "minimized") {
        minimizedBar.classList.remove("d-none");
    }

    // Minimize
    minimizeBtn.addEventListener("click", function() {
        localStorage.setItem("templateModalState", "minimized");
        bsModal.hide();

        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) backdrop.remove();
        document.body.classList.remove("modal-open");
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';

        minimizedBar.classList.remove("d-none");
    });

    // Restore
    minimizedBar.addEventListener("click", function() {
        localStorage.setItem("templateModalState", "open");
        minimizedBar.classList.add("d-none");
        bsModal.show();
    });

    // Close
    modalEl.addEventListener("hidden.bs.modal", function() {
        if (localStorage.getItem("templateModalState") !== "minimized") {
            localStorage.setItem("templateModalState", "closed");
            minimizedBar.classList.add("d-none");
            // Reset form
            document.getElementById('templateForm').reset();
            document.getElementById('editor').innerHTML = '<p>Hi <span class="token">@{{ first_name }}</span>,</p><p>Start typing your template here...</p>';
            document.getElementById('templateFormAction').value = 'create';
            document.getElementById('templateFormMethod').value = 'POST';
            document.getElementById('templateForm').action = '{{ route("templates.store") }}';
        }
    });

    // Form submit handler
    const templateForm = document.getElementById('templateForm');
    if (templateForm) {
        console.log('Mobile template form submit handler attached');
        templateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('=== MOBILE FORM SUBMITTED ===');
            
            // Capture editor content BEFORE creating FormData
            const editorContent = document.getElementById('editor').innerHTML;
            console.log('Editor content length:', editorContent.length);
            
            // Set hidden input value
            document.getElementById('bodyInput').value = editorContent;
            
            // Get form data (now includes the body from hidden input)
            const formData = new FormData(this);
            
            const action = document.getElementById('templateFormAction').value;
            const templateId = document.getElementById('templateId').value;
            console.log('Action:', action, 'Template ID:', templateId);
            
            let url = this.action;
            if (action === 'update' && templateId) {
                url = `/templates/${templateId}`;
                formData.append('_method', 'PUT');
            }
            console.log('Submitting to URL:', url);
            
            // Submit via fetch
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                console.log('=== RESPONSE RECEIVED ===');
                console.log('Status:', response.status, 'OK:', response.ok);
                
                if (response.ok) {
                    console.log('SUCCESS - Showing toast and reloading');
                    localStorage.removeItem("templateModalState");
                    
                    // Hide modal
                    try { 
                        const bs = bootstrap.Modal.getInstance(modalEl); 
                        if(bs) { 
                            bs.hide(); 
                            console.log('Modal hidden');
                        }
                    } catch(e) { console.error('Modal hide error:', e); }
                    
                    // Clear backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(b=>b.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow='';
                    document.body.style.paddingRight='';
                    
                    // Show toast
                    const toast = document.createElement('div');
                    toast.className = 'position-fixed bottom-0 end-0 p-3';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = '<div class="toast show align-items-center text-bg-success"><div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>Phone script saved successfully!</div></div></div>';
                    document.body.appendChild(toast);
                    console.log('Toast added to body');
                    
                    // Reload after delay
                    setTimeout(() => {
                        console.log('Reloading page...');
                        window.location.reload();
                    }, 1200);
                    return;
                }
                
                // Handle errors
                console.log('ERROR - Response not OK');
                return response.json().then(data => {
                    console.log('Error data:', data);
                    if (data.errors) {
                        alert('Validation errors: ' + Object.values(data.errors).join(', '));
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                }).catch(err => {
                    console.error('JSON parse error:', err);
                    alert('An error occurred. Please try again.');
                });
            })
            .catch(err => { 
                console.error('=== FETCH ERROR ===', err); 
                alert('Network error. Please try again.'); 
            });
        });
    } else {
        console.error('templateForm not found!');
    }
});
</script>
@endpush