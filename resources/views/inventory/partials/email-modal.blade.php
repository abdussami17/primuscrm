{{-- Email/Brochure Wizard Modal --}}
<div id="emailModal" class="modal fade">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title" id="addTemplateModal">Brochure Wizard - View Brochure</h1>
                <div>
                    <button type="button" id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                        <i class="ti ti-minimize" data-bs-toggle="tooltip" data-bs-title="Minimize"></i>
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body pt-1">
                <form id="brochureEmailForm" action="{{ route('inventory.send-brochure') }}" method="POST">
                    @csrf
                    <input type="hidden" name="inventory_id" id="brochureInventoryId">

                    <p class="text-black mt-2">Selected Auto: <span class="fw-bold" id="selectedVehicleInfo">-</span></p>

                    <div class="row g-2">
                        {{-- Email From --}}
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Email From:</label>
                            <input type="email" name="email_from" class="form-control" value="{{ auth()->user()->email ?? '' }}" readonly>
                            <div class="form-check mt-1">
                                <input type="checkbox" name="bcc_to_me" class="form-check-input" id="bccToMe" value="1">
                                <label class="form-check-label" for="bccToMe">Send blind carbon copy to me also</label>
                            </div>
                        </div>

                        {{-- Email To --}}
                        <div class="mb-3 col-md-4 email-suggest-wrapper">
                            <label class="form-label">Email To:</label>
                            <input type="email" name="email_to" class="form-control email-input" placeholder="Type name or email" required>
                            <div class="suggestion-box"></div>
                        </div>

                        {{-- Email CC --}}
                        <div class="mb-3 col-md-4 email-suggest-wrapper">
                            <label class="form-label">Email CC:</label>
                            <input type="email" name="email_cc" class="form-control email-input" placeholder="Type name or email">
                            <div class="suggestion-box"></div>
                        </div>

                        {{-- Email BCC --}}
                        <div class="mb-3 col-md-4 email-suggest-wrapper">
                            <label class="form-label">Email BCC:</label>
                            <input type="email" name="email_bcc" class="form-control email-input" placeholder="Type name or email">
                            <div class="suggestion-box"></div>
                        </div>

                        {{-- Subject --}}
                        <div class="mb-3 col-md-8">
                            <label class="form-label">Subject:</label>
                            <input type="text" name="subject" class="form-control" value="Vehicle Brochure">
                        </div>

                        {{-- Email Body Editor --}}
                        <div class="col-md-12 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label">Body</label>
                                <div class="d-flex gap-2 flex-wrap button-group">
                                    <button type="button" class="btn-primary btn" id="btnAIAssistant">
                                        <i class="bi bi-stars"></i>
                                        <span>AI Assistant</span>
                                    </button>
                                </div>
                            </div>

                            <div class="app container-fluid py-2">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-8">
                                        @include('inventory.partials.email-editor')

                                        {{-- Live Preview --}}
                                        <div class="preview-container">
                                            <div class="preview-header d-flex justify-content-between flex-wrap">
                                                <h6 class="mb-0 text-white">Live Preview</h6>
                                                <div class="device-toggle">
                                                    <button type="button" id="mobileBtn"><i class="bi bi-phone"></i></button>
                                                    <button type="button" id="desktopBtn" class="active"><i class="bi bi-display"></i></button>
                                                </div>
                                            </div>
                                            <div class="preview-content" id="preview">
                                                <div class="template-preview"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        @include('components.merge-fields')
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden field for email body HTML --}}
                            <input type="hidden" name="email_body" id="emailBodyHidden">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="brochureEmailForm" class="btn btn-primary">Send Email</button>
            </div>
        </div>
    </div>
</div>

{{-- AI Assistant Modal --}}
@include('inventory.partials.ai-assistant-modal')

{{-- Image Controls Popup --}}
<div class="image-controls" id="imageControls">
    <div class="image-control-section">
        <span class="image-control-label">Alignment</span>
        <div class="image-align-btns">
            <button type="button" class="image-align-btn btn btn-light border-1 border" data-align="left"><i class="bi bi-align-start"></i></button>
            <button type="button" class="image-align-btn btn btn-light border-1 border" data-align="center"><i class="bi bi-align-center"></i></button>
            <button type="button" class="image-align-btn btn btn-light border-1 border" data-align="right"><i class="bi bi-align-end"></i></button>
        </div>
    </div>
    <div class="image-control-section">
        <span class="image-control-label form-label">Size</span>
        <div class="image-size-inputs">
            <div class="image-size-group mb-2">
                <span class="image-size-label form-label">Width (px)</span>
                <input type="number" class="image-size-input form-control" id="imageWidth" min="50" step="10">
            </div>
            <div class="image-size-group mb-2">
                <span class="image-size-label form-label">Height (px)</span>
                <input type="number" class="image-size-input form-control" id="imageHeight" min="50" step="10">
            </div>
        </div>
        <label class="image-lock-aspect mb-2">
            <input type="checkbox" id="lockAspectRatio" checked>
            <span class="form-label">Lock aspect ratio</span>
        </label>
    </div>
    <div class="image-control-actions mb-2">
        <button type="button" class="image-control-btn btn btn-light border border-1" id="resetImageSize">
            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
        </button>
        <button type="button" class="image-control-btn danger btn btn-danger" id="deleteImage">
            <i class="bi bi-trash me-1"></i>Delete
        </button>
    </div>
</div>

@push('scripts')
<script>
        window.users = @json($users ?? []);
        
</script>
<script src="{{ asset('assets/js/email-editor.js') }}"></script>
@endpush