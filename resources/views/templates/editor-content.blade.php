<div class="app container-fluid py-3">
    <div class="template-header rounded-3 p-3 mb-3">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h5 class="mb-0" id="templateCreatorTitle">Email Template Creator</h5>
                    <small class="text-secondary" id="templateCreatorSubtitle">AI-powered email template builder</small>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap button-group">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" id="templateTypeBtn">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <span id="templateTypeLabel">Email</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item template-type-option active" href="#" data-type="email">Email</a></li>
                        <li><a class="dropdown-item template-type-option" href="#" data-type="text">Text</a></li>
                    </ul>
                </div>

                <button class="btn-primary btn" id="btnAIAssistant">
                    <i class="bi bi-stars"></i>
                    <span>AI Assistant</span>
                </button>
                <input type="hidden" name="type" id="tplType" value="email">
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card p-3 mb-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label" style="font-size: 13px;">Template Name <span class="text-danger">*</span></label>
                        <input type="text" style="border-color: rgb(0, 33, 64);border-width: 2px;" class="form-control" name="name" id="tplName" placeholder="Enter template name" required />
                    </div>
                    <div class="col-12 col-md-6" id="subjectCol">
                        <label class="form-label" style="font-size: 13px;">Subject Line <span class="text-danger">*</span></label>
                        <input type="text" style="border-color: rgb(0, 33, 64);border-width: 2px;" class="form-control" name="subject" id="tplSubject" placeholder="Enter email subject" required />
                    </div>
                </div>
            </div>

            <div class="card p-0 mb-4">
                <x-editor-toolbar />

                <div class="editor-wrapper">
                    <div class="editor-container">
                        @verbatim
                        <div class="editor" id="editor" contenteditable="true">
                            <p>Hi <span class="token" data-token="first_name">@{{ first_name }}</span>,</p>
                            <p>Welcome to <span class="token" data-token="dealer_name">@{{ dealer_name }}</span>! We're excited to help you find your perfect vehicle.</p>
                            <p>If you have any questions, please don't hesitate to contact me.</p>
                            <p><strong>Best regards,</strong><br>
                                <span class="token" data-token="assigned_to">@{{ assigned_to }}</span><br>
                                <span class="token" data-token="dealer_name">@{{ dealer_name }}</span><br>
                                Phone: <span class="token" data-token="dealer_phone">@{{ dealer_phone }}</span>
                            </p>
                        </div>
                        @endverbatim
                    </div>
                </div>
            </div>

            <div class="preview-container">
                <div class="preview-header d-flex justify-content-between flex-wrap">
                    <h6 class="mb-0 text-white">Live Preview</h6>
                    <div class="device-toggle">
                        <button type="button" id="mobileBtn"><i class="bi bi-phone"></i></button>
                        <button type="button" id="desktopBtn" class="active"><i class="bi bi-display"></i></button>
                    </div>
                </div>
                <div class="preview-content" id="preview">
                    <div class="template-preview">
                        <p>Preview will appear here...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <x-merge-fields :categories="$mergeFields ?? []" />
        </div>
    </div>
</div>

<!-- AI Assistant Modal -->
<div class="ai-modal" id="aiModal">
    <div class="ai-modal-content">
        <div class="ai-modal-header">
            <div>
                <h5 class="mb-1 d-flex align-items-center gap-2 text-white">
                    <i class="bi bi-stars"></i>
                    AI Assistant
                </h5>
                <small class="opacity-75">Create professional content in seconds</small>
            </div>
            <button class="btn-close btn-close-white" id="closeAIModal"></button>
        </div>

        <div class="ai-modal-body">
            <div id="aiOptions">
                <div class="ai-option-card" data-action="generate-email">
                    <div class="ai-option-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h6 class="mb-1">Generate Complete Email</h6>
                    <p class="text-muted small mb-0">Describe what you need and AI will create a full email template</p>
                </div>

                <div class="ai-option-card" data-action="generate-subject">
                    <div class="ai-option-icon">
                        <i class="bi bi-cursor-text"></i>
                    </div>
                    <h6 class="mb-1">Generate Subject Line</h6>
                    <p class="text-muted small mb-0">Create compelling subject lines</p>
                </div>

                <div class="ai-option-card" data-action="generate-image">
                    <div class="ai-option-icon">
                        <i class="bi bi-image-fill"></i>
                    </div>
                    <h6 class="mb-1">Generate Image</h6>
                    <p class="text-muted small mb-0">Describe an image and AI will create it</p>
                </div>
            </div>

            <div class="ai-input-section" id="aiInputSection">
                <button class="btn btn-sm btn-outline-secondary mb-3" id="btnBackToOptions">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </button>

                <div id="aiInputContent"></div>
            </div>

            <div class="ai-generating" id="aiGenerating">
                <div class="ai-spinner"></div>
                <h6>AI is working its magic...</h6>
                <p class="text-muted small">Creating your content with professional formatting</p>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal (header includes export/print next to close) -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Email Template Preview</h5>

        <!-- Right aligned action group: export, print, close -->
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
        <div id="templatePreviewContent" style="width:100%;min-height:400px;border:0;"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
/*
  Updated preview script + print/export integration.
  - Replaces tokens (data-token, wrapped tokens, inline tokens)
  - Wraps replacement values in <strong class="token-value"> so they are bold in preview.
  - Uses RegExp via constructor to avoid Blade interpreting @{{ in script.
*/

const SAMPLE_DATA = {!! json_encode($sampleData ?? [
    'first_name' => 'Michael',
    'last_name' => 'Smith',
    'email' => 'michael.smith@email.com',
    'street_address' => '611 Padget Lane',
    'city' => 'Saskatoon',
    'province' => 'Saskatchewan',
    'postal_code' => 'S7W 0H3',
    'country' => 'Canada',
    'dealer_name' => 'Primus Motors',
    'dealer_phone' => '222-333-4444',
    'dealer_address' => '123 Main Street, Vancouver, BC, V5K 2X8',
    'dealer_street_address' => '123 Main Street',
    'dealer_city' => 'Vancouver',
    'dealer_province' => 'BC',
    'dealer_postal_code' => 'V5K 2X8',
    'dealer_email' => 'dealer@dealer.com',
    'dealer_website' => 'www.primusmotors.ca',
    'assigned_to' => 'MC Cerda',
    'assigned_manager' => 'Marie-Amy Mazuzu',
    'year' => '2025',
    'make' => 'Ferrari',
    'model' => 'F80',
    'vin' => '12345678ABCDEFGHI',
    'stock_number' => '10101',
    'selling_price' => '$50,000',
    'internet_price' => '$49,000',
    'kms' => '35,000',
    'tradein_year' => '2011',
    'tradein_make' => 'Dodge',
    'tradein_model' => 'Calibre',
    'tradein_vin' => 'ABCDEFGHI12345678',
    'tradein_kms' => '100,000',
    'tradein_price' => '$10,000',
    'finance_manager' => 'Nancy Hitch',
    'advisor_name' => 'Amy Basura',
    
    
]) !!};

function getReplacementForToken(token) {
    if (!token) return '';
    const key = token.trim();
    // prefer runtime-provided `window.templateData` if present
    const runtime = window.templateData || window.TEMPLATE_DATA || {};
    if (typeof runtime[key] !== 'undefined' && runtime[key] !== null && runtime[key] !== '') return runtime[key];
    if (typeof SAMPLE_DATA[key] !== 'undefined' && SAMPLE_DATA[key] !== null) return SAMPLE_DATA[key];

    // fallback heuristics
    const fallbacks = [
        key.replace(/_full_name$/,''),
        key.replace(/_name$/,''),
        key.replace(/^advisor_name$/,'assigned_to'),
        key.replace(/^assigned_to_full_name$/,'assigned_to'),
        key.replace(/^assigned_manager_full_name$/,'assigned_manager')
    ];
    for (const f of fallbacks) {
        if (typeof SAMPLE_DATA[f] !== 'undefined' && SAMPLE_DATA[f] !== null) return SAMPLE_DATA[f];
    }
    console.warn('No sample value for token:', key);
    return '';
}

function buildReplacementNode(text, contextEl = null) {
    // Use <strong class="token-value"> to ensure bold display in preview
    const s = document.createElement('strong');
    s.className = 'token-value';
    s.textContent = text;
    return s;
}

function updatePreview() {
    const editor = document.getElementById('editor');
    if (!editor) return;

    // Clone editor to avoid mutating selection
    const clone = editor.cloneNode(true);

    // token pattern built via RegExp constructor to avoid Blade parsing issues
    const tokenRegex = new RegExp('@?\\{\\{\\s*([^}]+)\\s*\\}\\}', 'g');

    // 1) Replace element tokens with data-token attribute
    const tokenEls = Array.from(clone.querySelectorAll('[data-token]'));
    tokenEls.forEach(el => {
        const tokenName = el.getAttribute('data-token') || (() => {
            const m = (el.textContent || '').match(new RegExp('@?\\{\\{\\s*([^}]+)\\s*\\}\\}'));
            return m ? m[1] : null;
        })();
        const replacement = getReplacementForToken(tokenName);
        const repl = buildReplacementNode(replacement, el);
        if (el.parentNode) el.parentNode.replaceChild(repl, el);
    });

    // 2) Replace inline tokens inside text nodes (e.g. "Hi {{ first_name }},")
    const walker = document.createTreeWalker(clone, NodeFilter.SHOW_TEXT, null, false);
    const textNodes = [];
    let n;
    while ((n = walker.nextNode())) textNodes.push(n);

    textNodes.forEach(tNode => {
        const original = tNode.nodeValue;
        if (!original || original.indexOf('{{') === -1) return;

        let match;
        tokenRegex.lastIndex = 0;
        const frag = document.createDocumentFragment();
        let lastIndex = 0;
        let found = false;

        while ((match = tokenRegex.exec(original)) !== null) {
            found = true;
            const before = original.slice(lastIndex, match.index);
            if (before) frag.appendChild(document.createTextNode(before));

            const tokenName = match[1];
            const replacement = getReplacementForToken(tokenName);
            frag.appendChild(buildReplacementNode(replacement, tNode.parentNode));

            lastIndex = match.index + match[0].length;
        }

        if (found) {
            const after = original.slice(lastIndex);
            if (after) frag.appendChild(document.createTextNode(after));
            tNode.parentNode.replaceChild(frag, tNode);
        }
    });

    // 3) Render processed clone into preview container
    const preview = document.getElementById('preview');
    if (preview) {
        preview.innerHTML = '';
        while (clone.childNodes.length) preview.appendChild(clone.childNodes[0]);
    }

    // Also update templatePreviewContent if present (used by modal)
    const modalPreview = document.getElementById('templatePreviewContent');
    if (modalPreview) {
        const cloneForModal = editor.cloneNode(true);

        // replace data-token elements in cloneForModal
        Array.from(cloneForModal.querySelectorAll('[data-token]')).forEach(el => {
            const tokenName = el.getAttribute('data-token') || '';
            const replacement = getReplacementForToken(tokenName);
            const repl = buildReplacementNode(replacement, el);
            if (el.parentNode) el.parentNode.replaceChild(repl, el);
        });

        // replace inline tokens in cloneForModal text nodes
        const walker2 = document.createTreeWalker(cloneForModal, NodeFilter.SHOW_TEXT, null, false);
        const tNodes2 = [];
        let x;
        while ((x = walker2.nextNode())) tNodes2.push(x);

        tNodes2.forEach(tn => {
            const txt = tn.nodeValue;
            if (!txt || txt.indexOf('{{') === -1) return;
            const tokenRe = new RegExp('@?\\{\\{\\s*([^}]+)\\s*\\}\\}', 'g');
            tokenRe.lastIndex = 0;
            let mm;
            let li = 0;
            const frag2 = document.createDocumentFragment();
            let found2 = false;
            while ((mm = tokenRe.exec(txt)) !== null) {
                found2 = true;
                const before2 = txt.slice(li, mm.index);
                if (before2) frag2.appendChild(document.createTextNode(before2));
                const replacement2 = getReplacementForToken(mm[1]);
                frag2.appendChild(buildReplacementNode(replacement2, tn.parentNode));
                li = mm.index + mm[0].length;
            }
            if (found2) {
                const after2 = txt.slice(li);
                if (after2) frag2.appendChild(document.createTextNode(after2));
                tn.parentNode.replaceChild(frag2, tn);
            }
        });

        modalPreview.innerHTML = '';
        while (cloneForModal.childNodes.length) modalPreview.appendChild(cloneForModal.childNodes[0]);
    }

    // Optional: update hidden body input for form submission
    const bodyInput = document.getElementById('bodyInput');
    if (bodyInput) bodyInput.value = editor.innerHTML;
}

// Wire editor events to update preview
document.addEventListener('DOMContentLoaded', function () {
    const editor = document.getElementById('editor');
    if (editor) {
        editor.addEventListener('input', updatePreview);
        editor.addEventListener('blur', updatePreview);
        editor.addEventListener('keyup', updatePreview);

        editor.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (e.shiftKey) {
                    document.execCommand('insertHTML', false, '<p><br></p>');
                } else {
                    document.execCommand('insertHTML', false, '<br>');
                }
                setTimeout(updatePreview, 10);
            }
        });

        // initial preview
        setTimeout(updatePreview, 120);
    }

    // Device toggles
    const mobileBtn = document.getElementById('mobileBtn');
    const desktopBtn = document.getElementById('desktopBtn');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', function () {
            this.classList.add('active');
            if (desktopBtn) desktopBtn.classList.remove('active');
            document.getElementById('preview').classList.add('mobile');
        });
    }
    if (desktopBtn) {
        desktopBtn.addEventListener('click', function () {
            this.classList.add('active');
            if (mobileBtn) mobileBtn.classList.remove('active');
            document.getElementById('preview').classList.remove('mobile');
        });
    }

    // AI Assistant modal controls (unchanged)
    const modal = document.getElementById('aiModal');
    const btnAIAssistant = document.getElementById('btnAIAssistant');
    const closeAIModal = document.getElementById('closeAIModal');
    const btnBackToOptions = document.getElementById('btnBackToOptions');

    if (btnAIAssistant) {
        btnAIAssistant.addEventListener('click', () => {
            modal.classList.add('show');
            showAIOptions();
        });
    }
    if (closeAIModal) {
        closeAIModal.addEventListener('click', () => modal.classList.remove('show'));
    }
    if (btnBackToOptions) {
        btnBackToOptions.addEventListener('click', () => showAIOptions());
    }

    // Print / Export handlers: use the modal processed content to print/export
    function collectStylesHtml() {
        const nodes = Array.from(document.querySelectorAll('link[rel="stylesheet"], style'));
        return nodes.map(n => n.outerHTML).join('\n');
    }

    function openPrintWindowAndPrint(html) {
        const stylesHtml = collectStylesHtml();
        const printWindow = window.open('', '_blank', 'noopener');
        if (!printWindow) {
            alert('Please allow popups for this site to print or export.');
            return;
        }
        const doc = printWindow.document;
        doc.open();
        doc.write(`<!doctype html><html><head><meta charset="utf-8"><title>Preview</title>${stylesHtml}
            <style>
                .token-value { font-weight: 700 !important; }
                body { margin: 20px; color: #222; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
            </style></head><body>${html}</body></html>`);
        doc.close();
        printWindow.focus();
        setTimeout(() => {
            try { printWindow.print(); } catch (e) { console.error('Print failed', e); }
        }, 300);
    }

    document.getElementById('printPreviewBtn')?.addEventListener('click', function () {
        const html = document.getElementById('templatePreviewContent')?.innerHTML || document.getElementById('preview')?.innerHTML || '';
        if (!html) return alert('Nothing to print.');
        openPrintWindowAndPrint(html);
    });

    document.getElementById('exportPdfBtn')?.addEventListener('click', function () {
        const html = document.getElementById('templatePreviewContent')?.innerHTML || document.getElementById('preview')?.innerHTML || '';
        if (!html) return alert('Nothing to export.');
        openPrintWindowAndPrint(html);
    });

    // Template type options
    document.querySelectorAll('.template-type-option').forEach(item => {
        item.addEventListener('click', function(e){
            e.preventDefault();
            const type = this.getAttribute('data-type') || 'email';
            const label = document.getElementById('templateTypeLabel');
            const hidden = document.getElementById('tplType');
            const title = document.getElementById('templateCreatorTitle');
            const subtitle = document.getElementById('templateCreatorSubtitle');

            if (label) label.textContent = type === 'text' ? 'Text' : 'Email';
            if (hidden) hidden.value = type;
            if (title) title.textContent = type === 'text' ? 'Text Template Creator' : 'Email Template Creator';
            if (subtitle) subtitle.textContent = type === 'text' ? 'Create SMS/text templates' : 'AI-powered email template builder';

            document.querySelectorAll('.template-type-option').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            const subjectCol = document.getElementById('subjectCol');
            const tplSubject = document.getElementById('tplSubject');
            if (type === 'text') {
                if (subjectCol) subjectCol.style.display = 'none';
                if (tplSubject) tplSubject.required = false;
            } else {
                if (subjectCol) subjectCol.style.display = '';
                if (tplSubject) tplSubject.required = true;
            }
        });
    });

    // AI card handlers
    document.querySelectorAll('.ai-option-card').forEach(card => {
        card.addEventListener('click', () => {
            handleAIAction(card.dataset.action);
        });
    });
});
</script>
@endpush

@push('styles')
<style>
:root {
    --primary-color: rgb(0, 33, 64);
    --primary-light: rgba(0, 33, 64, 0.1);
    --primary-dark: rgb(0, 25, 48);
    --surface: #ffffff;
    --muted: #6b7280;
    --ring: #e5e7eb;
    --bg: #f8fafc;
}

/* Editor styling */
.editor {
    min-height: 400px;
    padding: 20px;
    outline: none;
    background: white;
    font-size: 14px;
    line-height: 1.6;
    word-wrap: break-word;
}
.editor:focus { outline: 2px solid #002140; }

/* Token visual in editor */
.token {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: inherit;
    cursor: pointer;
}

/* Preview token value style (bold) */
.preview-content { padding: 20px; min-height: 400px; background: white; }
.token-value { font-weight: 700 !important; color: inherit; }

/* Neutralize .token inside preview */
.preview-content .token { background: transparent; color: #000; padding: 0 !important; border-radius: 0; display: inline; }

/* Modal header action group (print/export) */
.action-group-no-wrap { white-space: nowrap; }
@media (max-width: 420px) { .action-group-no-wrap .btn { padding: .25rem .45rem; font-size: .85rem; } }

/* Layout styles */
.device-toggle button { border: none; background: transparent; color: white; padding: 5px 10px; cursor: pointer; border-radius: 4px; }
.device-toggle button.active { background: rgba(255,255,255,0.2); }
.preview-container { background: white; border: 1px solid #d1d5db; border-radius: 6px; overflow: hidden; }
.preview-header { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); color: white; padding: 16px; }
.editor-wrapper { border: 1px solid #d1d5db; border-radius: 0 0 6px 6px; border-top: none; background: white; }
.editor-container { height: 500px; overflow-y: auto; overflow-x: hidden; }
p { margin-bottom: 0.5rem !important; }

/* AI Modal styles (kept minimal) */
.ai-modal { position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px; }
.ai-modal.show { display:flex; }
.ai-modal-content { background:white; border-radius:12px; max-width:700px; width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3); }
.ai-modal-header { background: rgb(0,33,64); color:white; padding:20px; border-radius:12px 12px 0 0; display:flex; align-items:center; justify-content:space-between; }
</style>
@endpush