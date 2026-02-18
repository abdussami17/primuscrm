{{-- Compose Email Modal --}}
<div id="email-view" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="bg-white border-0 rounded compose-view">
                <div class="compose-header d-flex align-items-center justify-content-between bg-dark p-3">
                    <h5 class="text-white">Compose New Email</h5>
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" class="d-inline-flex me-2 text-white fs-16"><i class="ti ti-minus"></i></a>
                        <a href="javascript:void(0);" class="d-inline-flex me-2 fs-16 text-white"><i class="ti ti-maximize"></i></a>
                        <button type="button" class="btn-close btn-close-modal custom-btn-close bg-transparent fs-16 text-white position-static" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data" id="composeEmailForm">
                    @csrf
                    <div class="p-3 position-relative pb-2 border-bottom">
                        <div class="tag-with-img d-flex align-items-center">
                            <label class="form-label me-2 mb-0">To</label>
                            <input class="input-tags form-control border-0 h-100" id="composeInputBox" name="to_email" type="text" placeholder="Type to search..." required />
                            <ul id="compose-suggestions-list" class="list-group position-absolute shadow-sm d-none" style="top: 65px; z-index: 1000;width:90%;left:50%;transform: translateX(-50%);"></ul>
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
                            <input class="form-control border-0 h-100" name="cc[]" type="text" placeholder="Add CC recipients..." />
                        </div>
                    </div>

                    {{-- BCC Field (hidden by default) --}}
                    <div class="p-3 pb-0 border-bottom d-none" id="bccField">
                        <div class="tag-with-img d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Bcc</label>
                            <input class="form-control border-0 h-100" name="bcc[]" type="text" placeholder="Add BCC recipients..." />
                        </div>
                    </div>

                    <div class="p-3 border-bottom">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                        </div>

                        {{-- Email Body --}}
                        <div class="mb-0" id="email-body-section">
                            <textarea id="email-body" name="body" rows="7" class="form-control" placeholder="Compose Email" required></textarea>
                        </div>

                        {{-- Template Selector --}}
                        <div class="mb-0 d-none" id="template-select-section">
                            <select class="form-select mb-2" id="templateSelect">
                                <option value="" selected disabled>Choose a Template</option>
                                @foreach($templates ?? [] as $template)
                                    <option value="{{ $template->id }}" data-subject="{{ $template->subject }}" data-body="{{ $template->body }}">
                                        {{ $template->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="mt-2 btn btn-outline-secondary btn-sm" id="backToBody">
                                <i class="ti ti-arrow-left me-2"></i>Back
                            </button>
                        </div>

                        @if(isset($templates) && $templates->count() > 0)
                            <button type="button" id="insertTemplateBtn" class="mt-3 btn btn-light border border-1">
                                Insert Template
                            </button>
                        @endif
                    </div>

                    <div class="p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <label for="attachmentInput" class="btn btn-icon btn-sm rounded-circle" style="cursor: pointer;">
                                <i class="ti ti-paperclip"></i>
                            </label>
                            <input type="file" id="attachmentInput" name="attachments[]" multiple class="d-none" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-photo"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-link"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-mood-smile"></i></a>
                        </div>
                        <div class="d-flex align-items-center compose-footer">
                            <button type="submit" name="is_draft" value="1" class="btn btn-outline-secondary d-inline-flex align-items-center">
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