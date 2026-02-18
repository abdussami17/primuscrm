{{-- AI Assistant Modal --}}
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
            {{-- AI Options --}}
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

            {{-- AI Input Section --}}
            <div class="ai-input-section" id="aiInputSection">
                <button class="btn btn-sm btn-outline-secondary mb-3" id="btnBackToOptions">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </button>
                <div id="aiInputContent"></div>
            </div>

            {{-- AI Generating Spinner --}}
            <div class="ai-generating" id="aiGenerating">
                <div class="ai-spinner"></div>
                <h6>AI is working its magic...</h6>
                <p class="text-muted small">Creating your content with professional formatting</p>
            </div>
        </div>
    </div>
</div>