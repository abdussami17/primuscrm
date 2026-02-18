<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title" id="addTemplateModal">Create Template</h1>
                <div>
                    <button type="button" id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                        <i class="ti ti-minimize" data-toggle="tooltip" title="Minimize"></i>
                    </button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-light me-1 border-0">
                        <i class="ti ti-circle-x"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form id="templateForm" action="{{ route('templates.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="templateFormMethod" value="POST">
                    <input type="hidden" name="template_id" id="templateId">
                    <input type="hidden" name="type" value="email">
                    <input type="hidden" name="body" id="bodyInput">
                    <input type="hidden" id="templateFormAction" value="create">

                    @include('templates.editor-content')

                    <!-- Save button inside the form -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border border-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="minimizedBar" class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow" style="cursor: pointer; z-index: 1050; border-radius: 6px;">
    Template Editor
</div>

@push('scripts')
<script>
// Unsaved-changes helpers for the template editor
function serializeTemplateForm(form) {
    if (!form) return '';
    try {
        const fd = new FormData(form);
        const arr = [];
        for (const pair of fd.entries()) {
            arr.push(`${pair[0]}=${pair[1]}`);
        }
        arr.sort();
        return arr.join('&');
    } catch (e) { return ''; }
}

function captureInitialTemplateFormState() {
    const form = document.getElementById('templateForm');
    if (!form) return;
    window._initialTemplateFormState = serializeTemplateForm(form);
    window._closeAfterSaveTemplate = false;
    window._forceCloseTemplate = false;
}

function isTemplateFormDirty() {
    const form = document.getElementById('templateForm');
    if (!form) return false;
    if (!window._initialTemplateFormState) return false;
    return serializeTemplateForm(form) !== window._initialTemplateFormState;
}

function ensureUnsavedModalExistsForTemplate() {
    if (document.getElementById('unsavedConfirmModalTemplate')) return;
    const tpl = `
    <div class="modal fade" id="unsavedConfirmModalTemplate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <div class="text-center">
                        <div class="unsaved-icon"><i class="ti ti-alert-circle text-danger"></i></div>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <div class="unsaved-title">Unsaved Changes</div>
                    <div class="unsaved-desc">You have unsaved changes in this area. Review and Save before exiting to avoid losing any changes.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="unsavedSaveBtnTemplate"><i class="ti ti-check me-1"></i> Save</button>
                    <button type="button" class="btn btn-outline-danger" id="unsavedDiscardBtnTemplate"><i class="ti ti-trash me-1"></i> Discard</button>
                    <button type="button" class="btn btn-light" id="unsavedCancelBtnTemplate"><i class="ti ti-x me-1"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>`;
    const div = document.createElement('div');
    div.innerHTML = tpl;
    document.body.appendChild(div.firstElementChild);

    const saveBtn = document.getElementById('unsavedSaveBtnTemplate');
    const discardBtn = document.getElementById('unsavedDiscardBtnTemplate');
    const cancelBtn = document.getElementById('unsavedCancelBtnTemplate');
    const unsavedEl = document.getElementById('unsavedConfirmModalTemplate');
    const unsavedModal = new bootstrap.Modal(unsavedEl);

    saveBtn.addEventListener('click', function() {
        window._closeAfterSaveTemplate = true;
        window._forceCloseTemplate = true;
        window._isSavingTemplate = true;
        unsavedModal.hide();
        const form = document.getElementById('templateForm');
        try { form.requestSubmit(); } catch (e) { try { form.submit(); } catch(e) {} }
    });

    discardBtn.addEventListener('click', function() {
        window._forceCloseTemplate = true;
        unsavedModal.hide();
        try { const modalEl = document.getElementById('addTemplateModal'); const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl); modal.hide(); } catch(e) {}
    });

    cancelBtn.addEventListener('click', function() { unsavedModal.hide(); });

    unsavedEl.addEventListener('hidden.bs.modal', function() {
        setTimeout(function() {
            if (!window._isSavingTemplate && !window._closeAfterSaveTemplate && !window._forceCloseTemplate) {
                window._closeAfterSaveTemplate = false;
                window._forceCloseTemplate = false;
            }
        }, 300);
    });
}

window.addEventListener('beforeunload', function(e) {
    try {
        // If we're in the middle of a save flow initiated by our code, don't prompt
        if (window._suppressBeforeUnload || window._isSavingTemplate || window._closeAfterSaveTemplate) return;
        const isEdit = !!(document.getElementById('templateId') && document.getElementById('templateId').value);
        if (isEdit && isTemplateFormDirty()) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    } catch (err) {}
});

$(document).ready(function() {
    var $modal = $('#addTemplateModal');
    var $minimizeBtn = $('#minimizeModalBtn');
    var $minimizedBar = $('#minimizedBar');
    var $templateForm = $('#templateForm');

    if (!$modal.length || !$minimizeBtn.length || !$minimizedBar.length || !$templateForm.length) return;

    // Hook modal show/hide to manage unsaved changes for edit mode
    (function() {
        const modalEl = document.getElementById('addTemplateModal');
        if (!modalEl) return;
        modalEl.addEventListener('show.bs.modal', function() {
            const id = document.getElementById('templateId') ? document.getElementById('templateId').value : '';
            window.templateIsEditMode = !!(id && id !== '');
            if (window.templateIsEditMode) {
                captureInitialTemplateFormState();
                ensureUnsavedModalExistsForTemplate();
                setTimeout(captureInitialTemplateFormState, 300);
            }
        });

        modalEl.addEventListener('hide.bs.modal', function(e) {
            try {
                if (window.templateIsEditMode && isTemplateFormDirty() && !window._forceCloseTemplate) {
                    e.preventDefault();
                    ensureUnsavedModalExistsForTemplate();
                    new bootstrap.Modal(document.getElementById('unsavedConfirmModalTemplate')).show();
                }
            } catch (err) {}
        });
    })();

    // Restore modal state
    if (localStorage.getItem("templateModalState") === "minimized") {
        $minimizedBar.removeClass('d-none');
    }

    // Minimize modal
    $minimizeBtn.on('click', function() {
        localStorage.setItem("templateModalState", "minimized");
        $modal.modal('hide');
        $minimizedBar.removeClass('d-none');
    });

    // Restore modal from minimized bar
    $minimizedBar.on('click', function() {
        localStorage.setItem("templateModalState", "open");
        $minimizedBar.addClass('d-none');
        $modal.modal('show');
    });

    // Modal hidden event
    $modal.on('hidden.bs.modal', function() {
        if (localStorage.getItem("templateModalState") !== "minimized") {
            localStorage.setItem("templateModalState", "closed");
            $minimizedBar.addClass('d-none');

            $templateForm[0].reset();
            var $editor = $('#editor');
            if ($editor.length) $editor.html('<p>Hi <span class="token">@{{ first_name }}</span>,</p><p>Start typing your template here...</p>');
            $('#templateFormAction').val('create');
            $('#templateFormMethod').val('POST');
            $templateForm.attr('action', '{{ route("templates.store") }}');
        }
    });

    // AJAX form submit - FIX: remove previous bindings to prevent double submit
    $templateForm.off('submit').on('submit', function(e) {
        e.preventDefault();

        // Capture editor content
        $('#bodyInput').val($('#editor').html());
        var formData = new FormData(this);
        var action = $('#templateFormAction').val();
        var templateId = $('#templateId').val();
        var url = $templateForm.attr('action');

        if (action === 'update' && templateId) {
            url = '/templates/' + templateId;
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            success: function(response) {
                localStorage.removeItem("templateModalState");
                try { window._isSavingTemplate = false; } catch(e) {}
                try { captureInitialTemplateFormState(); } catch(e) {}
                $modal.modal('hide');

                // Show toast
                var $toast = $(`<div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body"><i class="bi bi-check-circle me-2"></i>Template saved successfully!</div>
                    </div>
                </div>`);
                $('body').append($toast);
                $toast.toast({ delay: 2000 });
                $toast.toast('show');

                // Reload page after toast disappears (2 seconds)
                setTimeout(function() {
                    try { window._suppressBeforeUnload = true; } catch(e) {}
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    alert('Validation errors: ' + Object.values(xhr.responseJSON.errors).join(', '));
                } else {
                    alert(xhr.responseJSON?.message || 'An error occurred.');
                }
            },
            complete: function() {
                try { window._isSavingTemplate = false; } catch(e) {}
                try { if (!window._closeAfterSaveTemplate) captureInitialTemplateFormState(); } catch(e) {}
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
/* Unsaved modal styles for template editor */
#unsavedConfirmModalTemplate .modal-content{border-radius:12px;background:linear-gradient(180deg,#ffffff,#f7fbff);box-shadow:0 12px 30px rgba(2,6,23,0.08);border:1px solid rgba(13,110,253,0.06);}
#unsavedConfirmModalTemplate .modal-header{border-bottom:none;padding-bottom:0}
#unsavedConfirmModalTemplate .modal-body{padding-top:4px;padding-bottom:10px}
#unsavedConfirmModalTemplate .unsaved-icon{font-size:40px;color:#0d6efd;margin-bottom:6px}
#unsavedConfirmModalTemplate .unsaved-title{font-weight:700;color:#073b6b;margin-bottom:4px}
#unsavedConfirmModalTemplate .unsaved-desc{color:#495057;margin-bottom:10px}
#unsavedConfirmModalTemplate .modal-footer{border-top:none;display:flex;justify-content:center;gap:8px;padding-top:6px}
#unsavedConfirmModalTemplate .btn{min-width:110px}
</style>
@endpush
