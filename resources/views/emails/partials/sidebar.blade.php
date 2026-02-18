{{-- Email Sidebar Component --}}
<div class="email-sidebar border-end ">
    <div class="active slimscroll h-100">
        <div class="slimscroll-active-sidebar">
            <div class="p-3">
                <div class=" bg-white rounded p-2 mb-3">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                            <img src="{{ asset('assets/light_logo.png') }}" class="logo-imgs" style="height:70px;width: 70px;max-width: 70px;" class="rounded-circle" alt="Img">
                        </a>
                        <div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#email-view">
                    <i class="ti ti-edit me-2"></i>Compose
                </a>
                <div class="mt-4">
                    <h5 class="mb-2">Emails</h5>
                    <div class="d-block mb-3 pb-3 border-bottom email-tags">
                        <a href="{{ route('email.inbox') }}" class="d-flex align-items-center justify-content-between p-2 rounded {{ ($currentFolder ?? 'inbox') === 'inbox' ? 'bg-light active' : '' }}">
                            <span class="d-flex align-items-center fw-medium">
                                <i class="ti ti-inbox text-gray me-2"></i>Inbox
                            </span>
                            @if(($counts['unread'] ?? 0) > 0)
                                <span id="email-count-unread" class="badge bg-danger bg-danger rounded-pill badge-xs">{{ $counts['unread'] }}</span>
                            @else
                                <span id="email-count-unread" class="d-none"></span>
                            @endif
                        </a>
                        <a href="{{ route('email.starred') }}" class="d-flex align-items-center justify-content-between p-2 rounded {{ ($currentFolder ?? '') === 'starred' ? 'bg-light active' : '' }}">
                            <span class="d-flex align-items-center fw-medium">
                                <i class="ti ti-star text-gray me-2"></i>Starred
                            </span>
                            <span id="email-count-starred" class="fw-semibold fs-12 rounded-pill">{{ $counts['starred'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('email.sent') }}" class="d-flex align-items-center justify-content-between p-2 rounded {{ ($currentFolder ?? '') === 'sent' ? 'bg-light active' : '' }}">
                            <span class="d-flex align-items-center fw-medium">
                                <i class="ti ti-rocket text-gray me-2"></i>Sent
                            </span>
                            <span id="email-count-sent" class="rounded-pill">{{ $counts['sent'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('email.drafts') }}" class="d-flex align-items-center justify-content-between p-2 rounded {{ ($currentFolder ?? '') === 'drafts' ? 'bg-light active' : '' }}">
                            <span class="d-flex align-items-center fw-medium">
                                <i class="ti ti-file text-gray me-2"></i>Drafts
                            </span>
                            <span id="email-count-drafts" class="rounded-pill">{{ $counts['drafts'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('email.deleted') }}" class="d-flex align-items-center justify-content-between p-2 rounded {{ ($currentFolder ?? '') === 'deleted' ? 'bg-light active' : '' }}">
                            <span class="d-flex align-items-center fw-medium">
                                <i class="ti ti-trash text-gray me-2"></i>Deleted
                            </span>
                            <span id="email-count-deleted" class="rounded-pill">{{ $counts['deleted'] ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>