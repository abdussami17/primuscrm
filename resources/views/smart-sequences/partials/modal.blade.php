<!-- Email Modal -->

                          <?php
                            use \Illuminate\Support\Str;
                          ?>
<div id="addSmartSequenceModal" class="modal fade">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form method="POST" action="{{ route('smart-sequences.store') }}" id="sequenceForm">
                @csrf
                <input type="hidden" name="sequence_id" id="sequenceId" value="{{ $sequence->id ?? '' }}">
                
                <!-- Modal Header -->
                <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
        Create Smart Follow-Up
        <div class="d-flex gap-2">
          <button type="button" id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
            <i class="ti ti-minimize"></i>
          </button>
          <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-light me-1 border-0">
            <i class="ti ti-circle-x"></i>
          </button>
        </div>
      </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="group_area-box-parent mt-2">
                        <!-- Configuration Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-settings me-1 text-white"></i> Smart Configuration
                            </div>
                            <div class="d-flex p-3 justify-content-normal align-items-end">
                                <div class="col-md-12 row g-2">
                                    <div class="col-md-4">
                                        <label for="sequence-title" class="form-label">Title</label>
                                        <input type="text" id="sequence-title" name="title" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Criteria Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-list-check text-white me-1"></i>Smart Criteria
                            </div>
                            <div class="p-3">
                                <div id="criteria-container">
                                    <!-- Criteria groups will be added here -->
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="add-criteria-button" id="addCriteriaBtn">+ Criteria</button>
                                    <button type="button" class="add-criteria-button" id="addOrGroupBtn" style="background: #ffc107; color: #000;">+ OR Criteria</button>
                                </div>
                            </div>
                        </div>

                        <!-- Action & Delay Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-repeat me-1 text-white"></i> Smart Action & Smart Delay
                            </div>
                            <div class="p-3">
                                <button type="button" class="add-action-button" id="addActionBtn">+ Action</button>
                                <div class="action-delay-container" id="actionContainer">
                                    <!-- Actions will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-end gap-1">
                    <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveSequenceBtn">Save Sequence</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Preview Modal -->
<div class="modal fade" id="emailPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Template Preview</h5>
                <div class="ms-auto d-flex align-items-center gap-2 action-group-no-wrap">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportPdfBtn" title="Export preview as PDF" aria-label="Export preview as PDF">
                            <i class="ti ti-file-text"></i>
                        </button>

                        <button type="button" class="btn btn-sm btn-outline-secondary" id="printPreviewBtn" title="Print preview" aria-label="Print preview">
                            <i class="ti ti-printer"></i>
                        </button>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
            </div>
            <div class="modal-body">
              <div class="row">
                <!--<div class="col-md-4">-->
                <!--  <div class="list-group template-list" style="max-height: 420px; overflow:auto;">-->
                <!--    @if(!empty($templates) && count($templates))-->
                <!--      @foreach($templates as $tpl)-->
                <!--        <button type="button" class="list-group-item list-group-item-action template-list-item" data-template-id="{{ $tpl->id }}" data-template-type="{{ $tpl->type ?? '' }}">-->
                <!--          <div class="d-flex w-100 justify-content-between">-->
                <!--            <h6 class="mb-1">{{ $tpl->name }}</h6>-->
                <!--            <small class="text-muted">{{ $tpl->type ?? '' }}</small>-->
                <!--          </div>-->

                <!--          @if(!empty($tpl->subject))-->
                <!--            <p class="mb-1 text-muted small">{{ Str::limit($tpl->subject, 60) }}</p>-->
                <!--          @endif-->
                <!--        </button>-->
                <!--      @endforeach-->
                <!--    @else-->
                <!--      <p class="text-muted">No templates available.</p>-->
                <!--    @endif-->
                <!--  </div>-->
                <!--</div>-->
                <div class="col-md-12">
                  <div id="emailPreviewContent" class="p-3 border rounded" style="background: #fff; min-height: 300px;">
                    <p>Select a template to preview</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                {{-- <div class="d-flex gap-2">

                </div> --}}
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

  <style>
    .criteria-group {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      position: relative;
      padding-top: 35px;
    }
#emailPreviewContent p{
margin-bottom: 0.1rem !important
}
    .criteria-group.or-group {
      background: #fff3cd;
      border: 1px solid #ffc107;

    }

    .criteria-group-label {
      position: absolute;
      top: -10px;
      left: 15px;
      background: #0d6efd;
      color: white;
      padding: 2px 10px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: bold;
    }

    .criteria-group.or-group .criteria-group-label {
      background: #ffc107;
      color: #000;
    }

    .criteria-rows-container {
      margin-top: 10px;
    }

    .criteria-row {
      background: white;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 10px;
      border: 1px solid #e9ecef;
    }

    .remove-group-btn {
      position: absolute;
      top: 5px;
      right: 5px;
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      cursor: pointer;
    }

    .remove-group-btn:hover {
      background: #c82333;
    }

    .add-criteria-button {
      background: #28a745;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      margin-right: 4px;
    }

    .add-criteria-button:hover {
      background: #218838;
    }

    .add-or-button {
      background: #ffc107;
      color: #000;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .add-or-button:hover {
      background: #e0a800;
    }

    .btn-icon-only {
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-icon-only:hover {
      background: #c82333;
    }

    .date-input-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .date-input-container span {
      color: #6c757d;
      font-size: 14px;
    }

    .action-delay-container-row {
      margin-bottom: 15px;
    }

    .action-sequence {
      font-size: 12px;
      padding: 3px 8px;
    }

    .check-btn {
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      margin-bottom: 5px;
    }

    .check-btn.valid {
      background: #28a745;
    }

    .check-btn.invalid {
      background: #dc3545;
    }

    /* .delete-btn {
      background: #dc3545;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
    }

    .delete-btn:hover {
      background: #c82333;
    } */

    .add-action-button {
      background: #0d6efd;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      margin-bottom: 15px;
    }

    .add-action-button:hover {
      background: #0b5ed7;
    }
  </style>

@include('smart-sequences.partials.modal-scripts')

<!-- html2pdf library for direct PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script>
// Bind template list clicks to preview action (works even if modal-scripts loads later)
document.addEventListener('click', function(e){
  const btn = e.target.closest('.template-list-item');
  if(!btn) return;
  const id = btn.getAttribute('data-template-id');
  const type = btn.getAttribute('data-template-type') || '';
  if (!id) return;
  if (typeof showTemplatePreview === 'function') {
    showTemplatePreview(id, type);
  } else {
    // fallback: fetch preview directly
    fetch(`{{ url('templates') }}/${id}/preview`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(response => {
        const ct = response.headers.get('content-type') || '';
        if (ct.indexOf('application/json') !== -1) {
          return response.json().then(data => ({ json: data }));
        }
        return response.text().then(text => ({ text }));
      })
      .then(result => {
        const previewContent = document.getElementById('emailPreviewContent');
        if (result.json) {
          const data = result.json;
          if (data.html) {
            previewContent.innerHTML = data.html;
            return;
          }
          if (data.preview) {
            if (typeof data.preview === 'string') {
              previewContent.innerHTML = data.preview;
              return;
            }
            previewContent.innerHTML = data.preview.body_html || data.preview.body_text || data.html || 'No preview available';
            return;
          }
          previewContent.innerHTML = data.html || '<p>Unable to load preview</p>';
        } else if (result.text) {
          previewContent.innerHTML = result.text || '<p>No preview available</p>';
        } else {
          previewContent.innerHTML = '<p>Unable to load preview</p>';
        }
      }).catch(() => {
        const previewContent = document.getElementById('emailPreviewContent');
        previewContent.innerHTML = '<p>Error loading preview</p>';
      });
  }
});
</script>
<script>
// Export/Print helpers for the preview modal
function _collectPreviewHead() {
  // collect style/link tags so preview retains styling
  try {
    return Array.from(document.querySelectorAll('link[rel="stylesheet"], style'))
      .map(n => n.outerHTML)
      .join('\n');
  } catch (e) { return ''; }
}

function openPreviewWindowAndPrint(htmlContent, autoPrint = true) {
  const popup = window.open('', '_blank', 'noopener');
  if (!popup) {
    alert('Popup blocked. Please allow popups for this site to export/print.');
    return;
  }
  const head = _collectPreviewHead();
  const doc = `<!doctype html><html><head><meta charset="utf-8"><title>Template Preview</title>${head}</head><body>${htmlContent}</body></html>`;
  popup.document.open();
  popup.document.write(doc);
  popup.document.close();
  // ensure resources load before printing
  popup.focus();
  if (autoPrint) {
    // small delay to allow fonts/styles to apply
    setTimeout(() => { try { popup.print(); } catch (e) { /* ignore */ } }, 500);
  }
}

document.addEventListener('DOMContentLoaded', function(){
  const exportBtn = document.getElementById('exportPdfBtn');
  const printBtn = document.getElementById('printPreviewBtn');
  const previewEl = document.getElementById('emailPreviewContent');

  if (exportBtn) {
    // Use `onclick` to ensure we don't register multiple handlers accidentally
    exportBtn.onclick = function(){
      if (!previewEl) return alert('No preview content available');
      try {
        if (typeof html2pdf === 'undefined') {
          // fallback to print popup if library not loaded
          return openPreviewWindowAndPrint(previewEl.innerHTML, true);
        }

        const opt = {
          margin: 0.5,
          filename: 'template-preview.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2, useCORS: true },
          jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        // Use the preview element directly so styles are preserved
        html2pdf().set(opt).from(previewEl).save();
      } catch (e) {
        console.debug('html2pdf export failed', e);
        openPreviewWindowAndPrint(previewEl.innerHTML, true);
      }
    };
  }

  if (printBtn) {
    // Replace any existing handler to avoid duplicate popups
    printBtn.onclick = function(){
      if (!previewEl) return alert('No preview content available');
      openPreviewWindowAndPrint(previewEl.innerHTML, true);
    };
  }
});
</script>
<!-- Floating Add Action Button -->
<button type="button" id="addActionFloatBtn" class="btn btn-primary floating-add-action" style="display:none; z-index:2500;">
  + Action
</button>
<style>
.floating-add-action{position:fixed;right:28px;bottom:28px;border-radius:50px;padding:10px 16px;box-shadow:0 6px 18px rgba(11,31,58,0.12);transition:bottom .18s ease}
.floating-add-action.hidden{display:none}
/* When any bootstrap modal is shown, lift the floating button above modal footer */
.modal.show ~ .floating-add-action,
.modal-backdrop.show ~ .floating-add-action {
  bottom:130px !important;
}
</style>
</style>
<script>
function updateFloatingAddVisibility(){
  const cnt = document.querySelectorAll('.action-delay-container-row').length;
  const btn = document.getElementById('addActionFloatBtn');
  if(!btn) return;
  if(cnt > 3) btn.style.display = 'block'; else btn.style.display = 'none';
}
document.addEventListener('click', function(e){
  const btn = e.target.closest('#addActionFloatBtn');
  if(!btn) return;
  // prefer to call addAction if available
  if(typeof addAction === 'function') return addAction();
  const primary = document.getElementById('addActionBtn');
  if(primary) primary.click();
});
// initialize visibility on load
document.addEventListener('DOMContentLoaded', function(){ updateFloatingAddVisibility(); });
</script>
<script>
// Fallback: ensure a global helper exists & observe container changes
(function(){
  if (typeof window.updateFloatingAddVisibility !== 'function') {
    window.updateFloatingAddVisibility = function(){
      try {
        const btn = document.getElementById('addActionFloatBtn');
        if (!btn) return;
        const cnt = document.querySelectorAll('.action-delay-container-row').length;
        btn.style.display = cnt > 3 ? 'block' : 'none';
      } catch(e) {}
    };
  }

  // Observe action container for dynamic changes
  try {
    const container = document.getElementById('actionContainer');
    if (container) {
      const mo = new MutationObserver(function(){ try{ window.updateFloatingAddVisibility(); }catch(e){} });
      mo.observe(container, { childList: true });
    }
  } catch(e) {}

  // Ensure clicks on the primary add button also update visibility
  const primary = document.getElementById('addActionBtn');
  if (primary) primary.addEventListener('click', function(){ setTimeout(()=>{ try{ window.updateFloatingAddVisibility(); }catch(e){} }, 50); });
})();
</script>