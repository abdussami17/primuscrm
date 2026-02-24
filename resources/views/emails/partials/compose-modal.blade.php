@include('emails.style')


{{-- Compose Email Modal --}}

<div id="email-view" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content overflow-auto">
            <div class="bg-white border-0 rounded compose-view">
                <div class="compose-header d-flex align-items-center justify-content-between bg-dark p-3">
                    <h5 class="text-white">Compose New Email</h5>
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" class="d-inline-flex me-2 text-white fs-16"><i
                                class="ti ti-minus"></i></a>
                        <a href="javascript:void(0);" class="d-inline-flex me-2 fs-16 text-white"><i
                                class="ti ti-maximize"></i></a>
                        <button type="button"
                            class="btn-close btn-close-modal custom-btn-close bg-transparent fs-16 text-white position-static"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data"
                    id="composeEmailForm">
                    @csrf
                    <div class="p-3 position-relative pb-2 border-bottom">
                        <div class="tag-with-img d-flex align-items-center">
                            <label class="form-label me-2 mb-0">To</label>
                            <input class="input-tags form-control border-0 h-100" id="composeInputBox" name="to_email"
                                type="text" placeholder="Type to search..." required />
                            <ul id="compose-suggestions-list" class="list-group position-absolute shadow-sm d-none"
                                style="top: 65px; z-index: 1000;width:90%;left:50%;transform: translateX(-50%);"></ul>
                        </div>
                        <div class="d-flex align-items-center email-cc">
                            <a href="javascript:void(0);" class="d-inline-flex me-2" id="showCcBtn">Cc</a>
                            <a href="javascript:void(0);" class="d-inline-flex" id="showBccBtn">Bcc</a>
                        </div>
                    </div>

                    {{-- CC Field (hidden by default) --}}
                    <div class="p-3 pb-0 border-bottom d-none" id="ccField">
                        <div class="tag-with-img d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Cc</label>
                            <input class="form-control border-0 h-100" name="cc[]" type="text"
                                placeholder="Add CC recipients..." />
                        </div>
                    </div>

                    {{-- BCC Field (hidden by default) --}}
                    <div class="p-3 pb-0 border-bottom d-none" id="bccField">
                        <div class="tag-with-img d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Bcc</label>
                            <input class="form-control border-0 h-100" name="bcc[]" type="text"
                                placeholder="Add BCC recipients..." />
                        </div>
                    </div>

                    <div class="p-3 border-bottom">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                        </div>

                        <button type="button" class="btn-primary btn" id="btnAIAssistant">
                            <i class="bi bi-stars"></i>
                            <span>AI Assistant</span>
                        </button>
                        {{-- Email Body --}}

                        <div class="app container-fluid py-2">


                            <div class="row g-4">
                                <div class="col-12 col-lg-8">


                                    <div class="card p-0 mb-4">
                                        <div class="outlook-toolbar">
                                            <!-- Font Family -->
                                            <select class="toolbar-select" id="fontFamily" title="Font family">
                                                <option value="Arial">Arial</option>
                                                <option value="Times New Roman">Times New Roman
                                                </option>
                                                <option value="Helvetica">Helvetica</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Verdana">Verdana</option>
                                                <option value="Courier New">Courier New</option>
                                            </select>

                                            <!-- Font Size -->
                                            <select class="toolbar-select" id="fontSize" title="Font size">
                                                <option value="8px">8</option>
                                                <option value="10px">10</option>
                                                <option value="12px">12</option>
                                                <option value="14px" selected>14</option>
                                                <option value="16px">16</option>
                                                <option value="18px">18</option>
                                                <option value="24px">24</option>
                                                <option value="32px">32</option>
                                            </select>

                                            <div class="toolbar-separator"></div>

                                            <!-- Basic Formatting -->
                                            <button type="button" class="toolbar-btn" data-cmd="bold"
                                                title="Bold (Ctrl+B)">
                                                <i class="bi bi-type-bold"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="italic"
                                                title="Italic (Ctrl+I)">
                                                <i class="bi bi-type-italic"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="underline"
                                                title="Underline (Ctrl+U)">
                                                <i class="bi bi-type-underline"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="strikeThrough"
                                                title="Strikethrough">
                                                <i class="bi bi-type-strikethrough"></i>
                                            </button>

                                            <div class="toolbar-separator"></div>

                                            <!-- Text Color -->
                                            <div class="color-picker-wrapper">
                                                <button type="button" class="color-picker-btn" id="textColorBtn"
                                                    title="Text color">
                                                    <i class="bi bi-fonts" style="font-size: 18px;"></i>
                                                    <div class="color-underline" id="textColorIndicator"
                                                        style="background: #000000;">
                                                    </div>
                                                </button>
                                                <div class="color-dropdown" id="textColorDropdown">
                                                </div>
                                            </div>

                                            <!-- Highlight Color -->
                                            <div class="color-picker-wrapper">
                                                <button type="button" class="color-picker-btn"
                                                    id="highlightColorBtn" title="Highlight color">
                                                    <i class="bi bi-highlighter"></i>
                                                    <div class="color-underline" id="highlightColorIndicator"
                                                        style="background: #ffff00;"></div>
                                                </button>
                                                <div class="color-dropdown" id="highlightColorDropdown"></div>
                                            </div>

                                            <div class="toolbar-separator"></div>

                                            <!-- Alignment -->
                                            <button type="button" class="toolbar-btn" data-cmd="justifyLeft"
                                                title="Align left">
                                                <i class="bi bi-text-left"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="justifyCenter"
                                                title="Align center">
                                                <i class="bi bi-text-center"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="justifyRight"
                                                title="Align right">
                                                <i class="bi bi-text-right"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="justifyFull"
                                                title="Justify">
                                                <i class="bi bi-justify"></i>
                                            </button>

                                            <div class="toolbar-separator"></div>

                                            <!-- Lists and Indentation -->
                                            <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList"
                                                title="Bullet list">
                                                <i class="bi bi-list-ul"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="insertOrderedList"
                                                title="Numbered list">
                                                <i class="bi bi-list-ol"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="indent"
                                                title="Increase indent">
                                                <i class="bi bi-indent"></i>
                                            </button>
                                            <button type="button" class="toolbar-btn" data-cmd="outdent"
                                                title="Decrease indent">
                                                <i class="bi bi-unindent"></i>
                                            </button>

                                            <div class="toolbar-separator"></div>

                                            <!-- Insert Options -->
                                            <div class="color-picker-wrapper">
                                                <button type="button" class="toolbar-btn" id="btnTable"
                                                    title="Insert table">
                                                    <i class="bi bi-table"></i>
                                                </button>
                                                <div class="table-grid-popup" id="tableGridPopup">
                                                    <div class="table-grid" id="tableGrid"></div>
                                                    <div class="table-size-label" id="tableSizeLabel">
                                                        1 x 1 Table</div>
                                                </div>
                                            </div>

                                            <button type="button" class="toolbar-btn" id="btnImage"
                                                title="Insert image">
                                                <i class="bi bi-image"></i>
                                            </button>

                                            <button type="button" class="toolbar-btn" id="btnLink"
                                                title="Insert link">
                                                <i class="bi bi-link-45deg"></i>
                                            </button>

                                            <button type="button" class="toolbar-btn" id="btnAttach"
                                                title="Attach file">
                                                <i class="bi bi-paperclip"></i>
                                            </button>

                                            <button type="button" class="toolbar-btn" id="btnClearFormat"
                                                title="Clear formatting">
                                                <i class="bi bi-eraser"></i>
                                            </button>

                                            <div class="toolbar-separator"></div>

                                            <!-- Smart Text -->
                                            <button type="button" class="toolbar-btn" id="btnSmartText"
                                                title="Smart Text - Enhance with AI">
                                                <i class="bi bi-magic"></i>
                                            </button>

                                            <div class="toolbar-separator"></div>

                                            <!-- HTML Edit Mode -->
                                            <button type="button" class="toolbar-btn" id="btnHtmlMode"
                                                title="Edit HTML / Switch to HTML mode">
                                                <i class="bi bi-code-slash"></i>
                                            </button>

                                            <!-- Voice Input -->
                                            <button type="button" class="voice-btn" id="btnVoice"
                                                title="Voice to text">
                                                <i class="bi bi-mic-fill"></i>
                                            </button>
                                        </div>

                                        <!-- HTML Textarea (Hidden by default) -->
                                        <textarea class="html-textarea" id="htmlTextarea"
                                            style="display:none; width:100%; height:400px; padding:12px; font-family:monospace; font-size:12px; border:2px solid #002140; background:#f8f9fa;"></textarea>

                                        <div class="editor-wrapper">
                                            <div class="editor-container">
                                                <div class="editor" id="editor" contenteditable="true">
                                                    <p>Hi <span class="token">@{{ first_name }}</span>,
                                                    </p>
                                                    <p>Welcome to <span class="token">@{{ dealer_name }}</span>!
                                                        We're excited to help
                                                        you find your perfect
                                                        vehicle.</p>
                                                    <p>If you have any questions, please don't hesitate
                                                        to contact me.</p>
                                                    <p><strong>Best regards,</strong><br>
                                                        <span class="token">@{{ advisor_name }}</span><br>
                                                        <span class="token">@{{ dealer_name }}</span><br>
                                                        Phone: <span class="token">@{{ dealer_phone }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="body" id="email-body">
                                    </div>

                                    <script>
                                        (function() {
                                            const editor = document.getElementById('editor');
                                            const preview = document.getElementById('preview');
                                            const htmlTextarea = document.getElementById('htmlTextarea');
                                            const mobileBtn = document.getElementById('mobileBtn');
                                            const desktopBtn = document.getElementById('desktopBtn');
                                            let updateTimer = null;

                                            function getEditorContent() {
                                                try {
                                                    if (htmlTextarea && htmlTextarea.style.display !== 'none') return htmlTextarea.value;
                                                    return editor ? editor.innerHTML : '';
                                                } catch (e) {
                                                    return '';
                                                }
                                            }

                                            function ensurePreviewBody() {
                                                if (!preview) return null;
                                                let body = preview.querySelector('.template-preview');
                                                if (!body) {
                                                    body = document.createElement('div');
                                                    body.className = 'template-preview';
                                                    preview.appendChild(body);
                                                }
                                                return body;
                                            }

                                            function updateLivePreview() {
                                                const body = ensurePreviewBody();
                                                if (!body) return;
                                                // Mirror the editor HTML into the preview
                                                body.innerHTML = getEditorContent();
                                            }

                                            function scheduleUpdate() {
                                                clearTimeout(updateTimer);
                                                updateTimer = setTimeout(updateLivePreview, 120);
                                            }

                                            // Bind events
                                            if (editor) {
                                                ['input', 'keyup', 'paste'].forEach(evt => editor.addEventListener(evt, scheduleUpdate));
                                                // also update when toolbar actions change content via execCommand
                                                document.addEventListener('selectionchange', scheduleUpdate);
                                            }
                                            if (htmlTextarea) htmlTextarea.addEventListener('input', scheduleUpdate);

                                            // Device toggle
                                            if (mobileBtn && desktopBtn && preview) {
                                                mobileBtn.addEventListener('click', function() {
                                                    mobileBtn.classList.add('active');
                                                    desktopBtn.classList.remove('active');
                                                    preview.classList.add('preview-mobile');
                                                });
                                                desktopBtn.addEventListener('click', function() {
                                                    desktopBtn.classList.add('active');
                                                    mobileBtn.classList.remove('active');
                                                    preview.classList.remove('preview-mobile');
                                                });
                                            }

                                            // Initial render
                                            document.addEventListener('DOMContentLoaded', function() {
                                                scheduleUpdate();
                                            });
                                        })();
                                    </script>

                                    <div class="preview-container">
                                        <div class="preview-header d-flex justify-content-between flex-wrap">
                                            <h6 class="mb-0 text-white">Live Preview</h6>
                                            <div class="device-toggle">
                                                <button type="button" id="mobileBtn" class="active "><i
                                                        class="bi bi-phone"></i></button>
                                                <button type="button" id="desktopBtn"><i
                                                        class="bi bi-display"></i></button>
                                            </div>
                                        </div>
                                        <div class="preview-content" id="preview">
                                            <div class="template-preview">
                                                <h3>Sample Template</h3>
                                                <p>This is a sample template preview. When you click the
                                                    mobile button, you'll see
                                                    how this template looks
                                                    on a mobile device.</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit. Sed do eiusmod tempor
                                                    incididunt ut labore et
                                                    dolore magna aliqua.</p>
                                                <button class="btn">Call to Action</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-12 col-lg-4">
                                    @include('components.merge-fields')
                                </div>
                            </div>
                        </div>

                        
                        <div class="ai-modal" id="aiModal">
                            <div class="ai-modal-content">
                                <div class="ai-modal-header">
                                    <div>
                                        <h5 class="mb-1 d-flex align-items-center gap-2 text-white">
                                            <i class="bi bi-stars"></i>
                                            AI Assistant
                                        </h5>
                                        <small class="opacity-75">Create professional content in
                                            seconds</small>
                                    </div>
                                    <button class="btn-close btn-close-white"
                                        id="closeAIModal"></button>
                                </div>

                                <div class="ai-modal-body">
                                    <div id="aiOptions">
                                        <div class="ai-option-card" data-action="generate-email">
                                            <div class="ai-option-icon">
                                                <i class="bi bi-envelope-fill"></i>
                                            </div>
                                            <h6 class="mb-1">Generate Complete Email</h6>
                                            <p class="text-muted small mb-0">Describe what you need
                                                and AI will create a full
                                                email template</p>
                                        </div>

                                        <!-- <div class="ai-option-card" data-action="use-template">
                            <div class="ai-option-icon">
                              <i class="bi bi-layout-text-window-reverse"></i>
                            </div>
                            <h6 class="mb-1">Use Pre-built Template</h6>
                            <p class="text-muted small mb-0">Choose from professionally designed templates</p>
                          </div> -->

                                        <div class="ai-option-card" data-action="generate-subject">
                                            <div class="ai-option-icon">
                                                <i class="bi bi-cursor-text"></i>
                                            </div>
                                            <h6 class="mb-1">Generate Subject Line</h6>
                                            <p class="text-muted small mb-0">Create compelling subject
                                                lines</p>
                                        </div>

                                        <div class="ai-option-card" data-action="generate-image">
                                            <div class="ai-option-icon">
                                                <i class="bi bi-image-fill"></i>
                                            </div>
                                            <h6 class="mb-1">Generate Image</h6>
                                            <p class="text-muted small mb-0">Describe an image and AI
                                                will create it</p>
                                        </div>
                                    </div>

                                    <div class="ai-input-section" id="aiInputSection">
                                        <button class="btn btn-sm btn-outline-secondary mb-3"
                                            id="btnBackToOptions">
                                            <i class="bi bi-arrow-left me-1"></i> Back
                                        </button>

                                        <div id="aiInputContent"></div>
                                    </div>

                                    <div class="ai-generating" id="aiGenerating">
                                        <div class="ai-spinner"></div>
                                        <h6>AI is working its magic...</h6>
                                        <p class="text-muted small">Creating your content with
                                            professional formatting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image-controls" id="imageControls">
                            <div class="image-control-section">
                                <span class="image-control-label">Alignment</span>
                                <div class="image-align-btns">
                                    <button class="image-align-btn btn btn-light border-1 border"
                                        data-align="left"><i class="bi bi-align-start"></i></button>
                                    <button class="image-align-btn btn btn-light border-1 border"
                                        data-align="center"><i
                                            class="bi bi-align-center"></i></button>
                                    <button class="image-align-btn btn btn-light border-1 border"
                                        data-align="right"><i class="bi bi-align-end"></i></button>
                                </div>
                            </div>
                            <div class="image-control-section">
                                <span class="image-control-label form-label">Size</span>
                                <div class="image-size-inputs">
                                    <div class="image-size-group mb-2">
                                        <span class="image-size-label form-label">Width (px)</span>
                                        <input type="number" class="image-size-input form-control"
                                            id="imageWidth" min="50" step="10">
                                    </div>
                                    <div class="image-size-group mb-2">
                                        <span class="image-size-label form-label">Height (px)</span>
                                        <input type="number" class="image-size-input form-control"
                                            id="imageHeight" min="50" step="10">
                                    </div>
                                </div>
                                <label class="image-lock-aspect mb-2">
                                    <input type="checkbox" id="lockAspectRatio" checked>
                                    <span class="form-label">Lock aspect ratio</span>
                                </label>
                            </div>
                            <div class="image-control-actions mb-2">
                                <button class="image-control-btn btn btn-light border border-1"
                                    id="resetImageSize"><i
                                        class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                                <button class="image-control-btn danger btn btn-danger"
                                    id="deleteImage"><i class="bi bi-trash me-1"></i>Delete</button>
                            </div>
                        </div>
                        {{-- <div class="mb-0" id="email-body-section">
                            <textarea id="email-body" name="body" rows="7" class="form-control" placeholder="Compose Email" required></textarea>
                        </div> --}}

                        {{-- Template Selector --}}
                        <div class="mb-0 d-none" id="template-select-section">
                            <select class="form-select mb-2" id="templateSelect">
                                <option value="" selected disabled>Choose a Template</option>
                                @foreach ($templates ?? [] as $template)
                                    <option value="{{ $template->id }}" data-subject="{{ $template->subject }}"
                                        data-body="{{ $template->body }}">
                                        {{ $template->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="mt-2 btn btn-outline-secondary btn-sm" id="backToBody">
                                <i class="ti ti-arrow-left me-2"></i>Back
                            </button>
                        </div>

                        @if (isset($templates) && $templates->count() > 0)
                            <button type="button" id="insertTemplateBtn" class="mt-3 btn btn-light border border-1">
                                Insert Template
                            </button>
                        @endif
                    </div>

                    <div class="p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <label for="attachmentInput" class="btn btn-icon btn-sm rounded-circle"
                                style="cursor: pointer;">
                                <i class="ti ti-paperclip"></i>
                            </label>
                            <input type="file" id="attachmentInput" name="attachments[]" multiple class="d-none"
                                accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i
                                    class="ti ti-photo"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i
                                    class="ti ti-link"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i
                                    class="ti ti-mood-smile"></i></a>
                        </div>
                        <div class="d-flex align-items-center compose-footer">
                            <button type="submit" name="is_draft" value="1"
                                class="btn btn-outline-secondary d-inline-flex align-items-center">
                                <i class="ti ti-file me-2"></i>Save Draft
                            </button>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center ms-2">
                                Send <i class="ti ti-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Attachment preview --}}
                    <div class="p-3 pt-0 d-none" id="attachmentPreview">
                        <small class="text-muted">Attachments:</small>
                        <div id="attachmentList" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Store users data for JavaScript --}}
<script>
    window.emailUsers = @json($users ?? []);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileBtn = document.getElementById('mobileBtn');
        const desktopBtn = document.getElementById('desktopBtn');
        const preview = document.getElementById('preview');

        // Set default to desktop if elements exist
        if (desktopBtn) desktopBtn.classList.add('active');
        if (preview) preview.classList.remove('mobile');

        if (mobileBtn && desktopBtn && preview) {
            mobileBtn.addEventListener('click', function() {
                mobileBtn.classList.add('active');
                desktopBtn.classList.remove('active');
                preview.classList.add('mobile');
            });

            desktopBtn.addEventListener('click', function() {
                desktopBtn.classList.add('active');
                mobileBtn.classList.remove('active');
                preview.classList.remove('mobile');
            });
        }
    });
</script>

<script>
    // HTML Mode Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const btnHtmlMode = document.getElementById('btnHtmlMode');
        const editor = document.getElementById('editor');
        const htmlTextarea = document.getElementById('htmlTextarea');
        const editorWrapper = document.querySelector('.editor-wrapper');
        const previewContainer = document.querySelector('.preview-container');
        let isHtmlMode = false;

        // Require required elements
        if (!btnHtmlMode || !editor || !htmlTextarea || !editorWrapper || !previewContainer) return;

        btnHtmlMode.addEventListener('click', function(e) {
            e.preventDefault();
            isHtmlMode = !isHtmlMode;

            if (isHtmlMode) {
                // Switch to HTML mode
                // Get current HTML content from editor
                const currentHTML = editor.innerHTML;
                htmlTextarea.value = currentHTML;

                // Hide editor and preview, show textarea
                editorWrapper.classList.add('html-mode');
                editorWrapper.style.display = 'none';
                previewContainer.classList.add('html-mode');
                previewContainer.style.display = 'none';
                htmlTextarea.classList.add('active');
                htmlTextarea.style.display = 'block';

                // Update button appearance
                btnHtmlMode.classList.add('active');
                btnHtmlMode.title = 'Switch back to Normal Mode';
            } else {
                // Switch back to rendered view
                const htmlContent = htmlTextarea.value;

                // Update editor with new HTML
                editor.innerHTML = htmlContent;

                // Show editor and preview, hide textarea
                editorWrapper.classList.remove('html-mode');
                editorWrapper.style.display = 'block';
                previewContainer.classList.remove('html-mode');
                previewContainer.style.display = 'block';
                htmlTextarea.classList.remove('active');
                htmlTextarea.style.display = 'none';

                // Update button appearance
                btnHtmlMode.classList.remove('active');
                btnHtmlMode.title = 'Edit HTML / Switch to HTML mode';

                // Update preview to show exact email appearance
                updateLivePreview();
            }
        });

        // Function to update live preview
        function updateLivePreview() {
            const preview = document.getElementById('preview');
            if (preview) {
                const templatePreview = preview.querySelector('.template-preview');
                if (templatePreview) {
                    templatePreview.innerHTML = editor.innerHTML;
                }
            }
        }

        // Auto-update preview when editor changes
        editor.addEventListener('input', updateLivePreview);
        editor.addEventListener('change', updateLivePreview);
    });
</script>

<script>
    // Signature Editor HTML Mode Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const btnSigHtmlMode = document.getElementById('btnSigHtmlMode');
        const signatureEditor = document.getElementById('signatureEditor');
        const sigHtmlTextarea = document.getElementById('sigHtmlTextarea');
        const signaturePreview = document.getElementById('signaturePreview');
        const sigEditorWrapper = document.querySelector('.signature-editor-wrapper');
        let isSigHtmlMode = false;

        if (!btnSigHtmlMode || !signatureEditor || !sigHtmlTextarea || !signaturePreview || !sigEditorWrapper)
            return;

        btnSigHtmlMode.addEventListener('click', function(e) {
            e.preventDefault();
            isSigHtmlMode = !isSigHtmlMode;

            if (isSigHtmlMode) {
                // Switch to HTML mode
                const currentHTML = signatureEditor.innerHTML;
                sigHtmlTextarea.value = currentHTML;

                // Hide editor and preview, show textarea
                sigEditorWrapper.style.display = 'none';
                if (signaturePreview && signaturePreview.parentElement) signaturePreview.parentElement
                    .style.display = 'none';
                sigHtmlTextarea.classList.add('active');
                sigHtmlTextarea.style.display = 'block';

                // Update button appearance
                btnSigHtmlMode.classList.add('active');
                btnSigHtmlMode.title = 'Switch back to Normal Mode';
            } else {
                // Switch back to rendered view
                const htmlContent = sigHtmlTextarea.value;
                signatureEditor.innerHTML = htmlContent;

                // Show editor and preview, hide textarea
                sigEditorWrapper.style.display = 'block';
                if (signaturePreview && signaturePreview.parentElement) signaturePreview.parentElement
                    .style.display = 'block';
                sigHtmlTextarea.classList.remove('active');
                sigHtmlTextarea.style.display = 'none';

                // Update button appearance
                btnSigHtmlMode.classList.remove('active');
                btnSigHtmlMode.title = 'Edit HTML / Switch to HTML mode';

                // Update preview
                updateSigPreview();
            }
        });

        // Update preview when editor changes
        function updateSigPreview() {
            if (signaturePreview) {
                signaturePreview.innerHTML = signatureEditor.innerHTML;
            }
        }

        signatureEditor.addEventListener('input', updateSigPreview);
        signatureEditor.addEventListener('change', updateSigPreview);

        // Formatting buttons for signature (guarded)
        const sigBold = document.getElementById('sigBold');
        if (sigBold) sigBold.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('bold', false, null);
            signatureEditor.focus();
        });

        const sigItalic = document.getElementById('sigItalic');
        if (sigItalic) sigItalic.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('italic', false, null);
            signatureEditor.focus();
        });

        const sigUnderline = document.getElementById('sigUnderline');
        if (sigUnderline) sigUnderline.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('underline', false, null);
            signatureEditor.focus();
        });

        const sigFontFamily = document.getElementById('sigFontFamily');
        if (sigFontFamily) sigFontFamily.addEventListener('change', function() {
            document.execCommand('fontName', false, this.value);
            signatureEditor.focus();
        });

        const sigFontSize = document.getElementById('sigFontSize');
        if (sigFontSize) sigFontSize.addEventListener('change', function() {
            document.execCommand('fontSize', false, this.value);
            signatureEditor.focus();
        });
    });
</script>

<script>
    const SAMPLE_DATAs = {
        // Customer Information (Updated as per client request)
        first_name: 'Michael',
        last_name: 'Smith',
        email: 'michael.smith@email.com',
        alt_email: 'm.smith@work.com',
        cell_phone: '(555) 123-4567',
        work_phone: '(555) 890-1234',
        home_phone: '(555) 567-8901',
        street_address: '611 Padget Lane',
        city: 'Saskatoon',
        province: 'Saskatchewan',
        postal_code: 'S7W 0H3',
        country: 'Canada',

        // Updated field names
        assigned_to: 'MC Cerda',
        assigned_manager: 'Marie-Amy Mazuzu',
        secondary_assigned: 'John Doe',


        // Dealership Information (Updated as per client request)
        dealer_name: 'Primus Motors',
        dealer_phone: '222-333-4444',
        dealer_address: '123 Main Street, Vancouver, BC, V5K 2X8',
        dealer_email: 'dealer@dealer.com',
        dealer_website: 'www.primusmotors.ca',

        // Vehicle Information (Updated as per client request)
        year: '2025',
        make: 'Ferrari',
        model: 'F80',
        vin: '12345678ABCDEFGHI',
        stock_number: '10101',
        selling_price: '$50,000',
        internet_price: '$49,000',
        kms: '35,000',

        // Trade-In Information
        tradein_year: '2011',
        tradein_make: 'Dodge',
        tradein_model: 'Calibre',
        tradein_vin: 'ABCDEFGHI12345678',
        tradein_kms: '100,000',
        tradein_price: '$10,000',

        // Finance Manager
        finance_manager: 'Robert Wilson',

        // Assigned To
        assigned_to: 'Michael Scott',
        assigned_to_email: 'michael.scott@dealership.com',
        assigned_to_work_number: '555-111-2222',
        assigned_to_cell_number: '555-333-4444',
        assigned_to_title: 'Sales Executive',

        // Assigned Manager
        assigned_manager: 'Sarah Johnson',

        // Secondary Assigned
        secondary_assigned: 'Pam Beesly',
        secondary_assigned_email: 'pam.beesly@dealership.com',
        secondary_assigned_work_number: '555-555-6666',
        secondary_assigned_cell_number: '555-777-8888',
        secondary_assigned_title: 'Assistant Sales Manager',

        // BDC Agent
        bdc_agent: 'Emily Davis',
        bdc_agent_email: 'emily.davis@dealership.com',
        bdc_agent_work_number: '555-101-2020',
        bdc_agent_cell_number: '555-303-4040',
        bdc_agent_title: 'BDC Agent',

        // BDC Manager
        bdc_manager: 'David Brown',
        bdc_manager_email: 'david.brown@dealership.com',
        bdc_manager_work_number: '555-505-6060',
        bdc_manager_cell_number: '555-707-8080',
        bdc_manager_title: 'BDC Manager',

        // General Manager
        general_manager: 'Jennifer Martinez',
        general_manager_email: 'jennifer.martinez@dealership.com',
        general_manager_title: 'General Manager',

        // Sales Manager
        sales_manager: 'Kevin Anderson',
        sales_manager_email: 'kevin.anderson@dealership.com',
        sales_manager_work_number: '555-909-1010',
        sales_manager_cell_number: '555-111-1212',
        sales_manager_title: 'Sales Manager',

        // Service Advisor
        service_advisor: 'Lisa Thompson',

        // Source
        source: 'Website Inquiry',

        // Appointment Date/Time
        appointment_datetime: 'Oct 14, 2025 10:00AM',

        // Inventory Manager
        inventory_manager: 'Mark Robinson',

        // Warranty Expiration
        warranty_expiration: 'Oct 14, 2025'
    };

    const OUTLOOK_COLORS = ['#000000', '#444444', '#666666', '#999999', '#CCCCCC', '#EEEEEE', '#F3F3F3', '#FFFFFF',
        '#FF0000', '#FF9900', '#FFFF00', '#00FF00', '#00FFFF', '#4A86E8', '#0000FF', '#9900FF', '#FF00FF',
        '#C00000',
        '#E26B0A', '#F1C232', '#6AA84F', '#45818E', '#3C78D8', '#3D85C6', '#674EA7', '#A64D79', '#85200C',
        '#990000',
        '#B45F06', '#BF9000', '#38761D', '#134F5C', '#1155CC', '#0B5394', '#351C75', '#741B47'
    ];

    const EMAIL_TEMPLATES = {
        welcome: {
            name: 'Welcome Email',
            subject: 'Welcome to @{{ dealer_name }}, @{{ first_name }}!',
            body: '<h2 style="color: #002140;">Welcome to @{{ dealer_name }}!</h2><p>Dear <span class="token">@{{ first_name }}</span>,</p><p>Thank you for choosing us!</p><div style="text-align: center; margin: 20px 0;"><a href="#" class="cta-button">View Our Inventory</a></div><p><strong>Best regards,</strong><br><span class="token">@{{ advisor_name }}</span></p>'
        },
        promotional: {
            name: 'Promotional Offer',
            subject: 'Exclusive Offer for You!',
            body: '<div style="background: linear-gradient(135deg, #002140 0%, #001a33 100%); color: white; padding: 30px; text-align: center; border-radius: 8px; margin-bottom: 20px;"><h1 style="color: white; margin: 0;">Special Offer!</h1></div><p>Dear <span class="token">@{{ first_name }}</span>,</p><div style="text-align: center; margin: 30px 0;"><a href="#" class="cta-button">Claim Your Offer</a></div>'
        }
    };

    class TemplateBuilder {
        constructor() {
            this.currentTextColor = '#000000';
            this.currentHighlightColor = '#ffff00';
            this.selectedTableSize = {
                rows: 1,
                cols: 1
            };
            this.recognition = null;
            this.currentAIAction = null;
            this.selectedImage = null;
            this.originalImageDimensions = {
                width: 0,
                height: 0
            };
            this.lastVoiceResult = '';
            this.isVoiceRecording = false;
            this.currentFormatting = {
                bold: false,
                italic: false,
                underline: false,
                strikeThrough: false,
                indent: false
            };
            this.init();
        }

        init() {
            this.setupToolbar();
            this.setupColorPickers();
            this.setupTableGrid();
            this.setupMergeFields();
            this.setupImageControls();
            this.setupVoiceRecognition();
            this.setupEditor();
            this.setupAIAssistant();
            this.setupSmartText();
            this.renderPreview();
            const _strikeBtn = document.querySelector('[data-cmd="strikeThrough"]');
            if (_strikeBtn) _strikeBtn.classList.remove('active');
        }

        setupImageControls() {
            // Alignment buttons
            document.querySelectorAll('.image-align-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (!this.selectedImage) return;
                    const align = btn.dataset.align;
                    document.querySelectorAll('.image-align-btn').forEach(b => b.classList.remove(
                        'active'));
                    btn.classList.add('active');

                    if (align === 'left') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = '0';
                        this.selectedImage.style.marginRight = 'auto';
                    } else if (align === 'center') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = 'auto';
                        this.selectedImage.style.marginRight = 'auto';
                    } else if (align === 'right') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = 'auto';
                        this.selectedImage.style.marginRight = '0';
                    }
                    this.renderPreview();
                });
            });

            // Size inputs with aspect ratio lock
            const widthInput = document.getElementById('imageWidth');
            const heightInput = document.getElementById('imageHeight');
            const lockAspect = document.getElementById('lockAspectRatio');

            if (widthInput && heightInput && lockAspect) {
                widthInput.addEventListener('input', () => {
                    if (!this.selectedImage) return;
                    const width = parseInt(widthInput.value);
                    if (width && width > 0) {
                        this.selectedImage.style.width = width + 'px';
                        if (lockAspect.checked && this.originalImageDimensions.width > 0) {
                            const ratio = this.originalImageDimensions.height / this.originalImageDimensions
                                .width;
                            const height = Math.round(width * ratio);
                            this.selectedImage.style.height = height + 'px';
                            heightInput.value = height;
                        }
                        this.renderPreview();
                    }
                });

                heightInput.addEventListener('input', () => {
                    if (!this.selectedImage) return;
                    const height = parseInt(heightInput.value);
                    if (height && height > 0) {
                        this.selectedImage.style.height = height + 'px';
                        if (lockAspect.checked && this.originalImageDimensions.height > 0) {
                            const ratio = this.originalImageDimensions.width / this.originalImageDimensions
                                .height;
                            const width = Math.round(height * ratio);
                            this.selectedImage.style.width = width + 'px';
                            widthInput.value = width;
                        }
                        this.renderPreview();
                    }
                });
            }

            // Reset button (guarded)
            const resetBtn = document.getElementById('resetImageSize');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    if (!this.selectedImage) return;
                    const origWidth = parseInt(this.selectedImage.dataset.originalWidth) || this
                        .originalImageDimensions.width;
                    const origHeight = parseInt(this.selectedImage.dataset.originalHeight) || this
                        .originalImageDimensions.height;
                    let width = origWidth;
                    let height = origHeight;
                    if (width > 600) {
                        height = (height * 600) / width;
                        width = 600;
                    }
                    this.selectedImage.style.width = width + 'px';
                    this.selectedImage.style.height = height + 'px';
                    if (widthInput) widthInput.value = Math.round(width);
                    if (heightInput) heightInput.value = Math.round(height);
                    this.renderPreview();
                });
            }

            // Delete button (guarded)
            const delBtn = document.getElementById('deleteImage');
            if (delBtn) {
                delBtn.addEventListener('click', () => {
                    if (this.selectedImage && confirm('Delete this image?')) {
                        this.selectedImage.remove();
                        this.deselectImage();
                        this.renderPreview();
                    }
                });
            }

            // Close controls when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.image-controls') && !e.target.closest('img') && e.target.id !==
                    'btnImage') {
                    this.deselectImage();
                }
            });
        }

        selectImage(img) {
            this.deselectImage();
            this.selectedImage = img;
            img.classList.add('selected');

            const currentWidth = img.offsetWidth;
            const currentHeight = img.offsetHeight;
            this.originalImageDimensions = {
                width: parseInt(img.dataset.originalWidth) || currentWidth,
                height: parseInt(img.dataset.originalHeight) || currentHeight
            };

            document.getElementById('imageWidth').value = Math.round(currentWidth);
            document.getElementById('imageHeight').value = Math.round(currentHeight);

            const marginLeft = img.style.marginLeft;
            const marginRight = img.style.marginRight;
            document.querySelectorAll('.image-align-btn').forEach(btn => btn.classList.remove('active'));

            if (marginLeft === 'auto' && marginRight === 'auto') {
                document.querySelector('[data-align="center"]').classList.add('active');
            } else if (marginLeft === 'auto') {
                document.querySelector('[data-align="right"]').classList.add('active');
            } else {
                document.querySelector('[data-align="left"]').classList.add('active');
            }

            const controls = document.getElementById('imageControls');
            const rect = img.getBoundingClientRect();
            controls.style.position = 'fixed';
            controls.style.left = (rect.right + 10) + 'px';
            controls.style.top = rect.top + 'px';

            setTimeout(() => {
                const controlsRect = controls.getBoundingClientRect();
                if (controlsRect.right > window.innerWidth) {
                    controls.style.left = (rect.left - controlsRect.width - 10) + 'px';
                }
                if (controlsRect.bottom > window.innerHeight) {
                    controls.style.top = (window.innerHeight - controlsRect.height - 20) + 'px';
                }
            }, 10);

            controls.classList.add('show');
        }

        deselectImage() {
            if (this.selectedImage) {
                this.selectedImage.classList.remove('selected');
                this.selectedImage = null;
            }
            document.getElementById('imageControls').classList.remove('show');
        }

        setupToolbar() {
            // Track current formatting state
            this.currentFormatting = {
                bold: false,
                italic: false,
                underline: false,
                indent: false
            };

            // Basic formatting commands
            document.querySelectorAll('.toolbar-btn[data-cmd]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cmd = btn.dataset.cmd;

                    // Handle alignment buttons (mutually exclusive)
                    if (['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'].includes(
                            cmd)) {
                        // Remove active from all alignment buttons
                        document.querySelectorAll('[data-cmd^="justify"]').forEach(b => {
                            b.classList.remove('active');
                        });
                        // Add active to clicked button
                        btn.classList.add('active');

                        // Execute the alignment command
                        document.execCommand(cmd, false, null);
                    }

                    // Handle indent/outdent buttons
                    else if (['indent', 'outdent'].includes(cmd)) {
                        // For indent/outdent, we don't maintain active state as they're one-time actions
                        document.execCommand(cmd, false, null);
                        // Update toolbar state to reflect current paragraph state
                        setTimeout(() => this.updateToolbarState(), 10);
                    }
                    // Handle lists and strikethrough
                    else if (['insertUnorderedList', 'insertOrderedList', 'strikeThrough'].includes(
                            cmd)) {
                        // Execute the command directly for lists and strikethrough
                        document.execCommand(cmd, false, null);

                        // For strikethrough, update the button state
                        if (cmd === 'strikeThrough') {
                            const isActive = document.queryCommandState('strikeThrough');
                            btn.classList.toggle('active', isActive);
                            this.currentFormatting.strikeThrough = isActive;
                        }
                    } else {
                        // For bold, italic, underline - use our tracked state
                        if (cmd === 'bold') {
                            this.currentFormatting.bold = !this.currentFormatting.bold;
                            btn.classList.toggle('active', this.currentFormatting.bold);
                            document.execCommand('bold', false, null);
                        } else if (cmd === 'italic') {
                            this.currentFormatting.italic = !this.currentFormatting.italic;
                            btn.classList.toggle('active', this.currentFormatting.italic);
                            document.execCommand('italic', false, null);
                        } else if (cmd === 'underline') {
                            this.currentFormatting.underline = !this.currentFormatting.underline;
                            btn.classList.toggle('active', this.currentFormatting.underline);
                            document.execCommand('underline', false, null);
                        }
                    }

                    this.renderPreview();

                    // Update toolbar state after command execution
                    setTimeout(() => this.updateToolbarState(), 10);
                });
            });

            // Update toolbar state based on current selection
            const editor = document.getElementById('editor');

            editor.addEventListener('click', () => {
                setTimeout(() => this.updateToolbarState(), 10);
            });

            editor.addEventListener('keydown', (e) => {
                // Handle Enter key - differentiate between Enter and Shift+Enter
                if (e.key === 'Enter') {
                    e.preventDefault();

                    if (e.shiftKey) {
                        // Shift+Enter: Insert line break (same line)
                        this.handleShiftEnter();
                    } else {
                        // Enter: Create new paragraph (new line with spacing)
                        this.handleEnter();
                    }
                }
            });

            editor.addEventListener('keyup', (e) => {
                this.updateToolbarState();

                // If it's a regular character key and we have active formatting, apply it
                if (e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey && !e.shiftKey) {
                    this.applyCurrentFormatting();
                }
            });

            editor.addEventListener('mouseup', () => {
                this.updateToolbarState();
            });

            // Handle focus and selection changes to maintain formatting
            editor.addEventListener('focus', () => {
                this.updateToolbarState();
            });

            // Handle selection changes
            editor.addEventListener('selectionchange', () => {
                this.updateToolbarState();
            });

            // Handle paste events to maintain formatting
            editor.addEventListener('paste', (e) => {
                // Let the paste happen first, then apply formatting
                setTimeout(() => {
                    this.applyCurrentFormatting();
                    this.updateToolbarState();
                }, 10);
            });

            // Font Family
            document.getElementById('fontFamily').addEventListener('change', (e) => {
                document.execCommand('fontName', false, e.target.value);
                this.renderPreview();
            });

            // Font Size
            document.getElementById('fontSize').addEventListener('change', (e) => {
                document.execCommand('fontSize', false, '7');
                document.querySelectorAll('font[size="7"]').forEach(el => {
                    el.removeAttribute('size');
                    el.style.fontSize = e.target.value;
                });
                this.renderPreview();
            });

            // Image upload
            document.getElementById('btnImage').addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.multiple = true;
                input.onchange = (e) => {
                    const files = Array.from(e.target.files);
                    files.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (event) => {
                                const img = new Image();
                                img.onload = () => {
                                    const maxWidth = 600;
                                    let width = img.width;
                                    let height = img.height;
                                    if (width > maxWidth) {
                                        height = (height * maxWidth) / width;
                                        width = maxWidth;
                                    }
                                    const imgHtml =
                                        `<img src="${event.target.result}" style="max-width:600px;width:${width}px;height:${height}px;display:block;margin:10px auto;border-radius:8px;" data-original-width="${img.width}" data-original-height="${img.height}">`;
                                    document.execCommand('insertHTML', false, imgHtml);
                                    this.renderPreview();
                                    setTimeout(() => {
                                        const editor = document.getElementById(
                                            'editor');
                                        const images = editor.querySelectorAll(
                                            'img');
                                        const newImage = images[images.length -
                                            1];
                                        this.selectImage(newImage);
                                    }, 100);
                                };
                                img.src = event.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                };
                input.click();
            });

            // Link
            document.getElementById('btnLink').addEventListener('click', () => {
                let url = prompt('Enter URL:');
                if (url) {
                    // âœ… Auto add protocol if missing
                    if (!/^https?:\/\//i.test(url)) {
                        url = 'https://' + url;
                    }

                    // Create the link
                    document.execCommand('createLink', false, url);


                    const selection = window.getSelection();
                    if (selection.rangeCount > 0) {
                        const range = selection.getRangeAt(0);
                        let anchor = range.startContainer.parentElement;
                        if (anchor && anchor.tagName === 'A') {
                            anchor.setAttribute('target', '_blank');
                        }
                    }

                    this.renderPreview();
                }
            });


            // Clear Formatting
            document.getElementById('btnClearFormat').addEventListener('click', () => {
                document.execCommand('removeFormat', false, null);
                // Remove active from all toolbar buttons and reset formatting state
                document.querySelectorAll('.toolbar-btn.active').forEach(btn => {
                    btn.classList.remove('active');
                });
                // Reset current formatting state
                this.currentFormatting = {
                    bold: false,
                    italic: false,
                    underline: false,
                    strikeThrough: false, // Add this line
                    indent: false
                };
                this.renderPreview();
            });

            // Attach (placeholder)
            document.getElementById('btnAttach').addEventListener('click', () => {
                alert('File attachment - integrate with backend');
            });

            // Save & Cancel


            // Initialize toolbar state
            this.updateToolbarState();
        }

        // Add this function to handle Enter key (new paragraph with spacing)
        handleEnter() {
            // Save current formatting state
            const wasBold = this.currentFormatting.bold;
            const wasItalic = this.currentFormatting.italic;
            const wasUnderline = this.currentFormatting.underline;

            // Insert new paragraph with proper spacing
            document.execCommand('insertHTML', false, '<p><br></p>');

            // Restore formatting state after inserting new paragraph
            setTimeout(() => {
                this.currentFormatting.bold = wasBold;
                this.currentFormatting.italic = wasItalic;
                this.currentFormatting.underline = wasUnderline;

                // Apply current formatting to the new paragraph
                this.applyCurrentFormatting();
                this.renderPreview();
            }, 10);
        }


        // Add this function to handle Shift+Enter (line break without spacing)
        handleShiftEnter() {
            // Save current formatting state
            const wasBold = this.currentFormatting.bold;
            const wasItalic = this.currentFormatting.italic;
            const wasUnderline = this.currentFormatting.underline;

            // Insert simple line break (same paragraph)
            document.execCommand('insertHTML', false, '<br>');

            // Restore formatting state and apply to continue on same line
            setTimeout(() => {
                this.currentFormatting.bold = wasBold;
                this.currentFormatting.italic = wasItalic;
                this.currentFormatting.underline = wasUnderline;

                this.applyCurrentFormatting();
                this.renderPreview();
            }, 10);
        }

        // Add this function to apply current formatting to new text
        applyCurrentFormatting() {
            // Save current selection
            this.saveSelection();

            // Apply each active formatting
            if (this.currentFormatting.bold) {
                document.execCommand('bold', false, null);
            }
            // Add strikethrough to the applyCurrentFormatting method
            if (this.currentFormatting.strikeThrough) {
                document.execCommand('strikeThrough', false, null);
            }
            if (this.currentFormatting.italic) {
                document.execCommand('italic', false, null);
            }
            if (this.currentFormatting.underline) {
                document.execCommand('underline', false, null);
            }

            // Restore selection after applying formatting
            this.restoreSelection();
        }

        // Add this function to update toolbar state based on current selection
        updateToolbarState() {
            const editor = document.getElementById('editor');

            // Check if editor has focus and selection
            if (document.activeElement !== editor) {
                // If editor doesn't have focus, keep the current formatting state but update buttons
                document.querySelector('[data-cmd="bold"]').classList.toggle('active', this.currentFormatting.bold);
                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting
                    .italic);
                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting
                    .underline);
                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this
                    .currentFormatting.strikeThrough);
                return;
            }

            const selection = window.getSelection();
            if (!selection.rangeCount) {
                return;
            }

            // For empty editor or new line, use our tracked formatting state
            if (selection.isCollapsed && editor.innerHTML.trim() === '') {
                document.querySelector('[data-cmd="bold"]').classList.toggle('active', this.currentFormatting.bold);
                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting
                    .italic);
                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting
                    .underline);
                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this
                    .currentFormatting.strikeThrough);
                return;
            }

            // Check formatting states using both queryCommandState and DOM inspection
            const isBoldCommand = document.queryCommandState('bold');
            const isItalicCommand = document.queryCommandState('italic');
            const isUnderlineCommand = document.queryCommandState('underline');
            const isStrikeThroughCommand = document.queryCommandState('strikeThrough');

            // Also check DOM for formatting
            const domFormatting = this.checkFormattingAtCursor();

            // Use DOM formatting if available, otherwise use command state
            const isBold = domFormatting.bold !== undefined ? domFormatting.bold : isBoldCommand;
            const isItalic = domFormatting.italic !== undefined ? domFormatting.italic : isItalicCommand;
            const isUnderline = domFormatting.underline !== undefined ? domFormatting.underline :
                isUnderlineCommand;
            const isStrikeThrough = domFormatting.strikeThrough !== undefined ? domFormatting.strikeThrough :
                isStrikeThroughCommand;

            // Update button states
            document.querySelector('[data-cmd="bold"]').classList.toggle('active', isBold);
            document.querySelector('[data-cmd="italic"]').classList.toggle('active', isItalic);
            document.querySelector('[data-cmd="underline"]').classList.toggle('active', isUnderline);
            document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', isStrikeThrough);

            // Update current formatting state based on actual state
            // But only if we have actual content to check, otherwise keep our tracked state
            if (!selection.isCollapsed || editor.innerHTML.trim() !== '') {
                this.currentFormatting.bold = isBold;
                this.currentFormatting.italic = isItalic;
                this.currentFormatting.underline = isUnderline;
                this.currentFormatting.strikeThrough = isStrikeThrough;
            }

            // Check alignment by examining the current block element
            this.checkAlignmentState();

            // Check indent state by examining the current element
            this.checkIndentState();
        }
        // Add this function to check and update alignment state
        checkAlignmentState() {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Alignment detection
            let alignment = null;
            let current = window.getSelection().anchorNode;

            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);
                    const textAlign = style.textAlign;

                    if (textAlign === 'center') {
                        alignment = 'center';
                        break;
                    } else if (textAlign === 'right') {
                        alignment = 'right';
                        break;
                    } else if (textAlign === 'justify') {
                        alignment = 'justify';
                        break;
                    } else if (textAlign === 'left') {
                        alignment = 'left';
                        break;
                    }
                }
                current = current.parentNode;
            }

            // Update alignment buttons based on detected alignment
            document.querySelectorAll('[data-cmd^="justify"]').forEach(btn => {
                btn.classList.remove('active');
            });

            switch (alignment) {
                case 'left':
                    document.querySelector('[data-cmd="justifyLeft"]').classList.add('active');
                    break;
                case 'center':
                    document.querySelector('[data-cmd="justifyCenter"]').classList.add('active');
                    break;
                case 'right':
                    document.querySelector('[data-cmd="justifyRight"]').classList.add('active');
                    break;
                case 'justify':
                    document.querySelector('[data-cmd="justifyFull"]').classList.add('active');
                    break;
            }
        }

        // Add this function to check formatting at cursor position (for collapsed selection)
        checkFormattingAtCursor() {
            const selection = window.getSelection();
            if (!selection.rangeCount || !selection.isCollapsed) return {};

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Traverse up the DOM tree to find formatting
            let current = node;
            let isBold = false;
            let isItalic = false;
            let isUnderline = false;
            let isStrikeThrough = false;
            let foundFormatting = false;

            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);

                    // Check for bold
                    if (style.fontWeight === 'bold' || style.fontWeight === '700' ||
                        current.tagName === 'B' || current.tagName === 'STRONG') {
                        isBold = true;
                        foundFormatting = true;
                    }
                    if (style.textDecoration.includes('line-through') || current.tagName === 'STRIKE' || current
                        .tagName === 'S') {
                        isStrikeThrough = true;
                        foundFormatting = true;
                    }
                    // Check for italic
                    if (style.fontStyle === 'italic' || current.tagName === 'I' || current.tagName === 'EM') {
                        isItalic = true;
                        foundFormatting = true;
                    }
                    // Check for underline
                    if (style.textDecoration.includes('underline') || current.tagName === 'U') {
                        isUnderline = true;
                        foundFormatting = true;
                    }

                    // If we found any formatting, break early
                    if (foundFormatting) break;
                }
                current = current.parentNode;
            }
            return {
                bold: foundFormatting ? isBold : undefined,
                italic: foundFormatting ? isItalic : undefined,
                underline: foundFormatting ? isUnderline : undefined,
                strikeThrough: foundFormatting ? isStrikeThrough : undefined
            };
        }

        // Add this function to check and update indent state
        checkIndentState() {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Traverse up to find block element
            let current = node;
            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);
                    const marginLeft = parseInt(style.marginLeft) || 0;
                    const paddingLeft = parseInt(style.paddingLeft) || 0;
                    const textIndent = parseInt(style.textIndent) || 0;

                    // Consider it indented if there's significant left spacing
                    const isIndented = (marginLeft + paddingLeft + textIndent) > 20;

                    // Update indent state (we don't show active state for indent/outdent as they're actions)
                    this.currentFormatting.indent = isIndented;

                    break;
                }
                current = current.parentNode;
            }
        }

        setupSmartText() {
            document.getElementById('btnSmartText').addEventListener('click', () => {
                const selection = window.getSelection();
                if (!selection.rangeCount || selection.isCollapsed) {
                    alert('Please select some text first');
                    return;
                }

                const range = selection.getRangeAt(0);
                const text = selection.toString();
                const span = document.createElement('span');
                span.textContent = text;
                span.style.display = 'inline-block';
                span.style.transition = 'opacity 0.3s';
                range.deleteContents();
                range.insertNode(span);

                const btn = document.getElementById('btnSmartText');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-magic"></i> <span>Enhancing...</span>';
                btn.disabled = true;

                // Text shuffle effect before showing final text
                const chars = '!<>-_\\/[]{}â€"=+*^?#________';
                let frame = 0;
                const iterations = 20;
                const originalText = text;
                const shuffled = setInterval(() => {
                    span.textContent = originalText
                        .split('')
                        .map((c, i) => {
                            if (i < frame) return originalText[i];
                            return chars[Math.floor(Math.random() * chars.length)];
                        })
                        .join('');
                    frame++;
                    if (frame > originalText.length + iterations) {
                        clearInterval(shuffled);
                        span.style.opacity = '0';
                        setTimeout(() => {
                            const enhanced =
                                `<span style="opacity:0; transition:opacity 0.4s;"><p style="margin:0; line-height:1.6;">${originalText}</p></span>`;
                            span.outerHTML = enhanced;
                            const newEl = document.querySelector(
                                'span[style*="opacity:0"]');
                            setTimeout(() => {
                                newEl.style.opacity = '1';
                            }, 20);
                            this.renderPreview();
                            btn.innerHTML = originalHTML;
                            btn.disabled = false;
                        }, 300);
                    }
                }, 40);
            });
        }

        setupAIAssistant() {
            const modal = document.getElementById('aiModal');

            document.getElementById('btnAIAssistant').addEventListener('click', () => {
                modal.classList.add('show');
                this.showAIOptions();
            });

            document.getElementById('closeAIModal').addEventListener('click', () => {
                modal.classList.remove('show');
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.remove('show');
            });

            document.getElementById('btnBackToOptions').addEventListener('click', () => {
                this.showAIOptions();
            });

            document.querySelectorAll('.ai-option-card').forEach(card => {
                card.addEventListener('click', () => {
                    this.handleAIAction(card.dataset.action);
                });
            });
        }

        showAIOptions() {
            document.getElementById('aiOptions').style.display = 'block';
            document.getElementById('aiInputSection').classList.remove('show');
            document.getElementById('aiGenerating').classList.remove('show');
        }

        handleAIAction(action) {
            this.currentAIAction = action;
            document.getElementById('aiOptions').style.display = 'none';

            const content = document.getElementById('aiInputContent');

            if (action === 'generate-email') {
                content.innerHTML =
                    '<h6 class="mb-3">Describe Your Email</h6><textarea class="ai-textarea" id="emailDesc" placeholder="Example: Create a welcome email for new customers..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genEmail"><i class="bi bi-stars me-2"></i>Generate Email</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genEmail').addEventListener('click', () => {
                    const desc = document.getElementById('emailDesc').value;
                    if (desc.trim()) this.generateEmail(desc);
                });
            } else if (action === 'use-template') {
                content.innerHTML = '<h6 class="mb-3">Choose a Template</h6><div class="template-gallery">' +
                    Object.keys(EMAIL_TEMPLATES).map(key =>
                        `<div class="template-card" data-template="${key}"><div class="template-preview"><i class="bi bi-file-earmark-text"></i></div><h6 class="small mb-0">${EMAIL_TEMPLATES[key].name}</h6></div>`
                    ).join('') + '</div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.querySelectorAll('.template-card').forEach(card => {
                    card.addEventListener('click', () => {
                        this.applyTemplate(card.dataset.template);
                    });
                });
            } else if (action === 'generate-subject') {
                content.innerHTML =
                    '<h6 class="mb-3">Generate Subject Line</h6><textarea class="ai-textarea" id="subjectDesc" placeholder="Describe your email content..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genSubject"><i class="bi bi-stars me-2"></i>Generate Subjects</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genSubject').addEventListener('click', () => {
                    const desc = document.getElementById('subjectDesc').value;
                    if (desc.trim()) this.generateSubjects(desc);
                });
            } else if (action === 'generate-image') {
                content.innerHTML =
                    '<h6 class="mb-3">Generate Image</h6><textarea class="ai-textarea" id="imageDesc" placeholder="Example: Modern dealership showroom..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genImage"><i class="bi bi-stars me-2"></i>Generate Image</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genImage').addEventListener('click', () => {
                    const desc = document.getElementById('imageDesc').value;
                    if (desc.trim()) this.generateImage(desc);
                });
            }
        }

        generateEmail(desc) {
            this.showGenerating();
            setTimeout(() => {
                const template = /promo|sale|offer/i.test(desc) ? EMAIL_TEMPLATES.promotional :
                    EMAIL_TEMPLATES.welcome;
                this.applyGeneratedContent(template);
            }, 2000);
        }



        generateImage(desc) {
            this.showGenerating();
            setTimeout(() => {
                const img =
                    `<img src="https://placehold.co/600x400/002140/white?text=${encodeURIComponent(desc.split(' ').slice(0, 3).join('+'))}" style="max-width: 600px; border-radius: 8px; margin: 20px auto; display: block;">`;
                document.getElementById('editor').innerHTML += img;
                this.renderPreview();
                document.getElementById('aiModal').classList.remove('show');
            }, 2000);
        }

        applyTemplate(templateKey) {
            this.applyGeneratedContent(EMAIL_TEMPLATES[templateKey]);
        }

        applyGeneratedContent(template) {

            document.getElementById('editor').innerHTML = template.body;
            this.renderPreview();
            document.getElementById('aiModal').classList.remove('show');
            this.showToast('Template applied!');
        }

        showGenerating() {
            document.getElementById('aiInputSection').classList.remove('show');
            document.getElementById('aiGenerating').classList.add('show');
        }

        showToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML =
                `<div class="toast show align-items-center text-bg-success"><div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>${msg}</div></div></div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        setupColorPickers() {
            this.savedSelection = null;

            this.createColorDropdown('textColorDropdown', 'text');
            this.createColorDropdown('highlightColorDropdown', 'highlight');

            // Save selection when opening color picker
            document.getElementById('textColorBtn').addEventListener('mousedown', (e) => {
                e.preventDefault();
            });

            document.getElementById('textColorBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.saveSelection();
                this.toggleColorDropdown('textColorDropdown');
            });

            document.getElementById('highlightColorBtn').addEventListener('mousedown', (e) => {
                e.preventDefault();
            });

            document.getElementById('highlightColorBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.saveSelection();
                this.toggleColorDropdown('highlightColorDropdown');
            });

            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.color-dropdown').forEach(dropdown => {
                dropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.color-picker-wrapper') && !e.target.closest('.table-grid-popup')) {
                    document.querySelectorAll('.color-dropdown, .table-grid-popup').forEach(d => d.classList
                        .remove('show'));
                }
            });
        }

        saveSelection() {
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                this.savedSelection = selection.getRangeAt(0).cloneRange();
            }
        }

        restoreSelection() {
            const editor = document.getElementById('editor');
            if (!editor.contains(document.activeElement)) {
                editor.focus();
            }
            if (this.savedSelection) {
                const selection = window.getSelection();
                selection.removeAllRanges();
                try {
                    selection.addRange(this.savedSelection);
                } catch (e) {
                    console.log('Could not restore selection');
                }
            }
        }

        createColorDropdown(dropdownId, type) {
            const dropdown = document.getElementById(dropdownId);

            // Color swatches grid
            const grid = document.createElement('div');
            grid.className = 'color-grid';

            OUTLOOK_COLORS.forEach(color => {
                const swatch = document.createElement('div');
                swatch.className = 'color-swatch';
                swatch.style.background = color;
                swatch.addEventListener('mousedown', (e) => e.preventDefault()); // prevent losing selection
                swatch.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (type === 'text') this.applyTextColor(color);
                    else this.applyHighlight(color);
                    dropdown.classList.remove('show');
                });
                grid.appendChild(swatch);
            });

            dropdown.appendChild(grid);

            // Hex input always visible
            const hexWrapper = document.createElement('div');
            hexWrapper.className = 'hex-input-wrapper';
            hexWrapper.style.marginTop = '6px';

            hexWrapper.innerHTML = `
                        <label style="font-size:13px">
                          <div class="color-input-group"><span style="color:var(--cf-primary)" class="color-input-label">Hex:</span><input type="text" class="color-input hex-input" placeholder="#000000" maxlength="7"></div>
                        </label>
                      `;

            dropdown.appendChild(hexWrapper);

            const hexInput = hexWrapper.querySelector('.hex-input');

            const applyHexColor = () => {
                let hex = hexInput.value.trim();

                // Allow both #ff0000 and ff0000
                if (!hex.startsWith('#')) hex = '#' + hex;

                // Expand shorthand (#fff → #ffffff)
                if (/^#([0-9A-F]{3})$/i.test(hex)) {
                    hex = '#' + hex.slice(1).split('').map(ch => ch + ch).join('');
                }

                if (/^#[0-9A-F]{6}$/i.test(hex)) {
                    if (type === 'text') this.applyTextColor(hex);
                    else this.applyHighlight(hex);
                }
            };

            // Apply color on typing and on Enter/blur
            hexInput.addEventListener('input', applyHexColor);
            hexInput.addEventListener('change', applyHexColor);
            hexInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyHexColor();
                    dropdown.classList.remove('show'); // close on Enter
                }
            });
        }

        toggleColorDropdown(dropdownId) {
            document.querySelectorAll('.color-dropdown, .table-grid-popup').forEach(d => {
                if (d.id !== dropdownId) d.classList.remove('show');
            });
            document.getElementById(dropdownId).classList.toggle('show');
        }

        applyTextColor(color) {
            this.restoreSelection();
            document.execCommand('foreColor', false, color);
            this.currentTextColor = color;
            document.getElementById('textColorIndicator').style.background = color;
            this.renderPreview();
        }

        applyHighlight(color) {
            this.restoreSelection();
            document.execCommand('hiliteColor', false, color);
            this.currentHighlightColor = color;
            document.getElementById('highlightColorIndicator').style.background = color;
            this.renderPreview();
        }

        setupTableGrid() {
            const grid = document.getElementById('tableGrid');
            for (let row = 0; row < 10; row++) {
                for (let col = 0; col < 10; col++) {
                    const cell = document.createElement('div');
                    cell.className = 'table-cell';
                    cell.dataset.row = row;
                    cell.dataset.col = col;
                    cell.addEventListener('mouseenter', () => this.highlightTableCells(row + 1, col + 1));
                    cell.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.insertTable(row + 1, col + 1);
                    });
                    grid.appendChild(cell);
                }
            }

            // Prevent table grid popup from closing when clicking inside
            document.getElementById('tableGridPopup').addEventListener('click', (e) => {
                e.stopPropagation();
            });

            document.getElementById('btnTable').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.querySelectorAll('.color-dropdown').forEach(d => d.classList.remove('show'));
                document.getElementById('tableGridPopup').classList.toggle('show');
            });
        }

        highlightTableCells(rows, cols) {
            document.querySelectorAll('.table-cell').forEach(cell => {
                const r = parseInt(cell.dataset.row);
                const c = parseInt(cell.dataset.col);
                if (r < rows && c < cols) cell.classList.add('selected');
                else cell.classList.remove('selected');
            });
            document.getElementById('tableSizeLabel').textContent = `${rows} x ${cols} Table`;
            this.selectedTableSize = {
                rows,
                cols
            };
        }

        insertTable(rows, cols) {
            const editor = document.getElementById('editor');

            // Restore the last saved cursor position
            if (this.savedSelection) {
                editor.focus();
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(this.savedSelection);
            } else {
                editor.focus();
            }

            // Enhanced table with better styling that will show in preview
            let html = `<table style="width: 100%; border-collapse: collapse; margin: 15px 0; border: 1px solid #d1d5db;">
                                <thead>
                                  <tr >`;

            for (let c = 0; c < cols; c++) {
                html +=
                    `<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;  color: #000;font-weight:400 !important ;">Header ${c + 1}</th>`;
            }

            html += `</tr>
                                </thead>
                                <tbody>`;

            for (let r = 0; r < rows - 1; r++) {
                html += `<tr>`;
                for (let c = 0; c < cols; c++) {
                    html +=
                        `<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left; color: #000;">Cell ${r + 1}-${c + 1}</td>`;
                }
                html += `</tr>`;
            }

            html += `</tbody>
                              </table>
                              <p><br></p>`;

            document.execCommand('insertHTML', false, html);
            document.getElementById('tableGridPopup').classList.remove('show');

            // Save cursor position after insert
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                this.savedSelection = selection.getRangeAt(0).cloneRange();
            }

            this.renderPreview();
        }

        setupMergeFields() {
            document.querySelectorAll('.category-header').forEach(header => {
                header.addEventListener('click', () => {
                    const body = header.nextElementSibling;
                    const icon = header.querySelector('i:last-child');
                    body.classList.toggle('show');
                    icon.classList.toggle('bi-chevron-down');
                    icon.classList.toggle('bi-chevron-up');
                });
            });

            document.querySelectorAll('.field-item').forEach(item => {
                item.addEventListener('click', () => this.insertToken(item.dataset.token));
            });
        }

        insertToken(tokenName) {
            const editor = document.getElementById('editor');

            // Restore the last saved cursor position
            if (this.savedSelection) {
                editor.focus();
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(this.savedSelection);
            } else {
                // If no saved position, focus at the end
                editor.focus();
                const range = document.createRange();
                range.selectNodeContents(editor);
                range.collapse(false);
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
            }

            // Create and insert token
            const token = document.createElement('span');
            token.className = 'token';
            token.textContent = `@{{ $ {
    tokenName }}}`;
            token.contentEditable = 'false';

            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(token);

                // Add a space after the token
                const space = document.createTextNode('\u00A0');
                range.setStartAfter(token);
                range.insertNode(space);

                // Move cursor after the space
                range.setStartAfter(space);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);

                // Save the new position
                this.savedSelection = range.cloneRange();
            }

            this.renderPreview();
        }
        setupVoiceRecognition() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                document.getElementById('btnVoice').style.display = 'none';
                return;
            }

            this.recognition = new SpeechRecognition();
            this.recognition.continuous = true;
            this.recognition.interimResults = true;

            // Disable auto-punctuation
            if ('autoPunctuation' in this.recognition) {
                this.recognition.autoPunctuation = false;
            }

            const btn = document.getElementById('btnVoice');

            btn.addEventListener('click', () => {
                if (btn.classList.contains('recording')) {
                    this.recognition.stop();
                    btn.classList.remove('recording');
                } else {
                    this.recognition.start();
                    btn.classList.add('recording');
                }
            });

            this.recognition.onresult = (event) => {
                let finalTranscript = '';

                // Loop through results and only take the final ones
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    if (event.results[i].isFinal) {
                        finalTranscript += event.results[i][0].transcript;
                    }
                }

                if (finalTranscript) {
                    let processed = finalTranscript.toLowerCase();

                    // Spoken commands handling
                    processed = processed
                        .replace(/\bcomma\b/g, ',')
                        .replace(/\bspace\b/g, ' ')
                        .replace(/\b(full stop|period)\b/g, '.')
                        .replace(/\b(new line|next line)\b/g, '\n')
                        // Remove spaces before punctuation
                        .replace(/\s+([,.!?;:])/g, '$1')
                        // Fix double spaces
                        .replace(/\s+/g, ' ');

                    // Remove only unwanted auto-dots, not manual ones
                    if (!/\b(full stop|period)\b/i.test(finalTranscript)) {
                        processed = processed.replace(/\.+$/, '');
                    }

                    // Prevent double dots (if both Google + replacement add one)
                    processed = processed.replace(/\.{2,}/g, '.');

                    document.execCommand('insertText', false, processed);
                    this.renderPreview();
                }
            };

            this.recognition.onerror = () => btn.classList.remove('recording');
            this.recognition.onend = () => btn.classList.remove('recording');
        }

        setupEditor() {
            const editor = document.getElementById('editor');
            editor.addEventListener('click', (e) => {
                if (e.target.tagName === 'IMG') {
                    e.preventDefault();
                    this.selectImage(e.target);
                } else {
                    this.deselectImage();
                }
            });
            editor.addEventListener('input', () => this.renderPreview());


            // Save cursor position whenever editor loses focus
            editor.addEventListener('blur', () => {
                this.saveSelection();
            });

            // Save cursor position on any selection change
            editor.addEventListener('mouseup', () => {
                this.saveSelection();
            });

            editor.addEventListener('keyup', () => {
                this.saveSelection();
            });
        }

        renderPreview() {
            let html = document.getElementById('editor').innerHTML;

            // Ensure tables maintain their styling in preview
            html = html.replace(/<table/g,
                '<table style="border-collapse: collapse; width: 100%; margin: 15px 0;"');
            html = html.replace(/<th/g,
                '<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;font-weight:400 !important;color:#000 "'
            );
            html = html.replace(/<td/g,
                '<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left;color:#000"');

            // Replace tokens with sample data
            html = html.replace(/\{\{([^}]+)\}\}/g, (match, token) => {
                return SAMPLE_DATAs[token.trim()] || match;
            });

            document.getElementById('preview').innerHTML = html;
        }


    }

    new TemplateBuilder();
</script>
<script>
    // Update hidden input before submit
document.getElementById('composeEmailForm').addEventListener('submit', function(e) {
    document.getElementById('email-body').value = document.getElementById('editor').innerHTML;
});
</script>