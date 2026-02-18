<div class="app container-fluid py-3">
    <div class="template-header rounded-3 p-3 mb-3">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h5 class="mb-0">Phone Script Creator</h5>
                    <small class="text-secondary">AI-powered text template builder</small>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap button-group">
                <button class="btn-primary btn" id="btnAIAssistant">
                    <i class="bi bi-stars"></i>
                    <span>AI Assistant</span>
                </button>
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
                    {{-- <div class="col-12 col-md-6">
                        <label class="form-label" style="font-size: 13px;">Subject Line <span class="text-danger">*</span></label>
                        <input type="text" style="border-color: rgb(0, 33, 64);border-width: 2px;" class="form-control" name="subject" id="tplSubject" placeholder="Enter email subject" required />
                    </div> --}}
                </div>
            </div>

            <div class="card p-0 mb-4">
                <x-editor-toolbar />

                <div class="editor-wrapper">
                    <div class="editor-container">
                        <div class="editor" id="editor" contenteditable="true">
                            <p>Hi <span class="token">@{{ first_name }}</span>,</p>
                            <p>Welcome to <span class="token">@{{ dealer_name }}</span>! We're excited to help you find your perfect vehicle.</p>
                            <p>If you have any questions, please don't hesitate to contact me.</p>
                            <p><strong>Best regards,</strong><br>
                                <span class="token">@{{ advisor_name }}</span><br>
                                <span class="token">@{{ dealer_name }}</span><br>
                                Phone: <span class="token">@{{ dealer_phone }}</span>
                            </p>
                        </div>
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

@push('scripts')
<script>
const SAMPLE_DATA = {!! json_encode($sampleData ?? [
    'first_name' => 'Michael',
    'last_name' => 'Smith',
    'email' => 'michael.smith@email.com',
    'dealer_name' => 'Primus Motors',
    'dealer_phone' => '222-333-4444',
    'advisor_name' => 'John Doe'
]) !!};

function updatePreview() {
    const editor = document.getElementById('editor');
    if (!editor) return;
    
    let html = editor.innerHTML;
    
    // Update hidden body input
    const bodyInput = document.getElementById('bodyInput');
    if (bodyInput) {
        bodyInput.value = html;
    }
    
    // Replace tokens with sample data
    html = html.replace(/@\{\{\s*([^}]+)\s*\}\}/g, (match, token) => {
        return SAMPLE_DATA[token.trim()] || match;
    });
    
    const preview = document.getElementById('preview');
    if (preview) {
        preview.innerHTML = html;
    }
}

// Update preview on editor change
if (document.getElementById('editor')) {
    const editor = document.getElementById('editor');
    
    editor.addEventListener('input', updatePreview);
    editor.addEventListener('blur', updatePreview);
    editor.addEventListener('keyup', updatePreview);
    
    // Initial preview
    setTimeout(updatePreview, 100);
}

// Device toggle
if (document.getElementById('mobileBtn')) {
    document.getElementById('mobileBtn').addEventListener('click', function() {
        this.classList.add('active');
        document.getElementById('desktopBtn').classList.remove('active');
        document.getElementById('preview').classList.add('mobile');
    });
}

if (document.getElementById('desktopBtn')) {
    document.getElementById('desktopBtn').addEventListener('click', function() {
        this.classList.add('active');
        document.getElementById('mobileBtn').classList.remove('active');
        document.getElementById('preview').classList.remove('mobile');
    });
}

// AI Assistant functionality
document.addEventListener('DOMContentLoaded', function() {
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
        closeAIModal.addEventListener('click', () => {
            modal.classList.remove('show');
        });
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('show');
    });

    if (btnBackToOptions) {
        btnBackToOptions.addEventListener('click', () => {
            showAIOptions();
        });
    }

    document.querySelectorAll('.ai-option-card').forEach(card => {
        card.addEventListener('click', () => {
            handleAIAction(card.dataset.action);
        });
    });
});

function showAIOptions() {
    document.getElementById('aiOptions').style.display = 'block';
    document.getElementById('aiInputSection').classList.remove('show');
    document.getElementById('aiGenerating').classList.remove('show');
}

function handleAIAction(action) {
    const content = document.getElementById('aiInputContent');
    document.getElementById('aiOptions').style.display = 'none';

    if (action === 'generate-email') {
        content.innerHTML = `
            <h6 class="mb-3">Describe Your Email</h6>
            <textarea class="ai-textarea" id="emailDesc" placeholder="Example: Create a welcome email for new customers..."></textarea>
            <div class="mt-3">
                <button class="btn btn-primary" id="genEmail">
                    <i class="bi bi-stars me-2"></i>Generate Email
                </button>
            </div>
        `;
        document.getElementById('aiInputSection').classList.add('show');
        
        setTimeout(() => {
            document.getElementById('genEmail').addEventListener('click', () => {
                const desc = document.getElementById('emailDesc').value;
                if (desc.trim()) generateEmail(desc);
            });
        }, 100);
    } else if (action === 'generate-subject') {
        content.innerHTML = `
            <h6 class="mb-3">Generate Subject Line</h6>
            <textarea class="ai-textarea" id="subjectDesc" placeholder="Describe your email content..."></textarea>
            <div class="mt-3">
                <button class="btn btn-primary" id="genSubject">
                    <i class="bi bi-stars me-2"></i>Generate Subjects
                </button>
            </div>
        `;
        document.getElementById('aiInputSection').classList.add('show');
        
        setTimeout(() => {
            document.getElementById('genSubject').addEventListener('click', () => {
                const desc = document.getElementById('subjectDesc').value;
                if (desc.trim()) generateSubjects(desc);
            });
        }, 100);
    } else if (action === 'generate-image') {
        content.innerHTML = `
            <h6 class="mb-3">Generate Image</h6>
            <textarea class="ai-textarea" id="imageDesc" placeholder="Example: Modern dealership showroom..."></textarea>
            <div class="mt-3">
                <button class="btn btn-primary" id="genImage">
                    <i class="bi bi-stars me-2"></i>Generate Image
                </button>
            </div>
        `;
        document.getElementById('aiInputSection').classList.add('show');
        
        setTimeout(() => {
            document.getElementById('genImage').addEventListener('click', () => {
                const desc = document.getElementById('imageDesc').value;
                if (desc.trim()) generateImage(desc);
            });
        }, 100);
    }
}

function generateEmail(description) {
    showGenerating();
    
    fetch('/api/ai/generate-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ description: description })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('editor').innerHTML = data.content;
            if (data.subject) {
                document.getElementById('tplSubject').value = data.subject;
            }
            updatePreview();
            document.getElementById('aiModal').classList.remove('show');
            showToast('Email generated successfully!');
        } else {
            alert('Error generating email. Please try again.');
            showAIOptions();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating email. Please try again.');
        showAIOptions();
    });
}

function generateSubjects(description) {
    showGenerating();
    
    fetch('/api/ai/generate-subjects', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ description: description })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const content = document.getElementById('aiInputContent');
            content.innerHTML = '<h6 class="mb-3">Generated Subject Lines</h6>' + 
                data.subjects.map((s, i) => `
                    <div class="ai-option-card" onclick="selectSubject('${s.replace(/'/g, "\\'")}')">
                        <div class="d-flex gap-3">
                            <div style="font-size: 24px; color: #002140;">${i + 1}</div>
                            <p class="mb-0">${s}</p>
                        </div>
                    </div>
                `).join('');
            document.getElementById('aiGenerating').classList.remove('show');
            document.getElementById('aiInputSection').classList.add('show');
        } else {
            alert('Error generating subjects. Please try again.');
            showAIOptions();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating subjects. Please try again.');
        showAIOptions();
    });
}

function selectSubject(subject) {
    document.getElementById('tplSubject').value = subject;
    document.getElementById('aiModal').classList.remove('show');
    showToast('Subject line selected!');
}

function generateImage(description) {
    showGenerating();
    
    fetch('/api/ai/generate-image', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ description: description })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const img = `<img src="${data.image_url}" style="max-width: 600px; border-radius: 8px; margin: 20px auto; display: block;">`;
            const editor = document.getElementById('editor');
            editor.innerHTML += img;
            updatePreview();
            document.getElementById('aiModal').classList.remove('show');
            showToast('Image generated and inserted!');
        } else {
            alert('Error generating image. Please try again.');
            showAIOptions();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating image. Please try again.');
        showAIOptions();
    });
}

function showGenerating() {
    document.getElementById('aiInputSection').classList.remove('show');
    document.getElementById('aiGenerating').classList.add('show');
}

if (typeof window.showToast !== 'function') {
    function showToast(msg) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast show align-items-center text-bg-success">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>${msg}
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
}
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

.editor {
    min-height: 400px;
    padding: 20px;
    outline: none;
    background: white;
    font-size: 14px;
    line-height: 1.6;
    word-wrap: break-word;
}

.editor:focus {
    outline: 2px solid #002140;
}

.editor img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 10px 0;
    border-radius: 4px;
    cursor: pointer;
}

.editor img.selected {
    outline: 3px solid #8b5cf6;
    outline-offset: 2px;
}

.editor table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    border: 1px solid #d1d5db;
}

.editor table th,
.editor table td {
    border: 1px solid #d1d5db;
    padding: 8px 12px;
    text-align: left;
}

.token {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.preview-content {
    padding: 20px;
    min-height: 400px;
    background: white;
}

.preview-content.mobile {
    max-width: 375px;
    margin: 0 auto;
    border-left: 1px solid #e1e5eb;
    border-right: 1px solid #e1e5eb;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.preview-content .token {
    background: transparent;
    color: #000;
    padding: 0 !important;
    border-radius: 0;
    font-size: inherit !important;
    border: none !important;
    display: inline;
    margin: 0;
    cursor: text;
}

.device-toggle button {
    border: none;
    background: transparent;
    color: white;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
}

.device-toggle button.active {
    background: rgba(255, 255, 255, 0.2);
}

.preview-container {
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    overflow: hidden;
}

.preview-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 16px;
}

.editor-wrapper {
    border: 1px solid #d1d5db;
    border-radius: 0 0 6px 6px;
    border-top: none;
    background: white;
}

.editor-container {
    height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

p {
    margin-bottom: 0.5rem !important;
}

/* AI Modal Styles */
.ai-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.ai-modal.show {
    display: flex;
}

.ai-modal-content {
    background: white;
    border-radius: 12px;
    max-width: 700px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.ai-modal-header {
    background: rgb(0, 33, 64);
    color: white;
    padding: 20px;
    border-radius: 12px 12px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ai-modal-body {
    padding: 24px;
}

.ai-option-card {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ai-option-card:hover {
    border-color: rgb(0, 33, 64);
    background: #f5f5f5;
    transform: translateY(-2px);
}

.ai-option-icon {
    width: 48px;
    height: 48px;
    background: rgb(0, 33, 64);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-bottom: 12px;
}

.ai-input-section {
    display: none;
}

.ai-input-section.show {
    display: block;
}

.ai-textarea {
    width: 100%;
    min-height: 120px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px;
    font-size: 14px;
    resize: vertical;
    transition: all 0.2s ease;
}

.ai-textarea:focus {
    outline: none;
    border-color: rgb(0, 33, 64);
    box-shadow: 0 0 0 3px rgba(0, 33, 64, 0.1);
}

.ai-generating {
    text-align: center;
    padding: 40px 20px;
    display: none;
}

.ai-generating.show {
    display: block;
}

.ai-spinner {
    width: 60px;
    height: 60px;
    border: 4px solid #ede9fe;
    border-top-color: rgb(0, 33, 64);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.btn-primary {
    background: rgb(0, 33, 64) !important;
    border-color: rgb(0, 33, 64) !important;
}

.btn-primary:hover {
    background: rgb(0, 25, 48) !important;
    border-color: rgb(0, 25, 48) !important;
}
</style>
@endpush