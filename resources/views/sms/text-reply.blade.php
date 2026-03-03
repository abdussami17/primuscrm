@extends('layouts.app')

@section('title', 'Text Thread — ' . $contactName)

@section('content')

<div class="content content-two p-0">
    <div class="d-md-flex">

        {{-- ── Sidebar ────────────────────────────────────────────────── --}}
        <div class="email-sidebar border-end">
            <div class="active slimscroll h-100">
                <div class="slimscroll-active-sidebar">
                    <div class="p-3">
                        <div class="bg-white rounded p-2 mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                                    <img src="assets/light_logo.png" class="logo-img"
                                         style="height:70px;width:70px;max-width:70px;" alt="Logo">
                                </a>
                            </div>
                        </div>

                        <a href="javascript:void(0);" class="btn btn-primary w-100"
                           data-bs-toggle="modal" data-bs-target="#sms-compose-modal">
                            <i class="ti ti-edit me-2"></i>Compose
                        </a>

                        <div class="mt-4">
                            <h5 class="mb-2">Texts</h5>
                            <div class="d-block mb-3 pb-3 border-bottom email-tags">
                                <a href="{{ route('text.inbox', ['folder' => 'inbox']) }}"
                                   class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium">
                                        <i class="ti ti-inbox text-gray me-2"></i>Inbox
                                    </span>
                                    @if(($counts['unread'] ?? 0) > 0)
                                        <span class="badge bg-danger rounded-pill badge-xs sms-unread-count">
                                            {{ $counts['unread'] }}
                                        </span>
                                    @endif
                                </a>
                                <a href="{{ route('text.inbox', ['folder' => 'starred']) }}"
                                   class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium">
                                        <i class="ti ti-star text-gray me-2"></i>Starred
                                    </span>
                                    <span class="fw-semibold fs-12 rounded-pill">{{ $counts['starred'] ?? 0 }}</span>
                                </a>
                                <a href="{{ route('text.inbox', ['folder' => 'sent']) }}"
                                   class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium">
                                        <i class="ti ti-rocket text-gray me-2"></i>Sent
                                    </span>
                                    <span class="rounded-pill">{{ $counts['sent'] ?? 0 }}</span>
                                </a>
                                <!--<a href="{{ route('text.inbox', ['folder' => 'draft']) }}"-->
                                <!--   class="d-flex align-items-center justify-content-between p-2 rounded">-->
                                <!--    <span class="d-flex align-items-center fw-medium">-->
                                <!--        <i class="ti ti-file text-gray me-2"></i>Drafts-->
                                <!--    </span>-->
                                <!--    @if(($counts['draft'] ?? 0) > 0)-->
                                <!--        <span class="fw-semibold fs-12 rounded-pill">{{ $counts['draft'] }}</span>-->
                                <!--    @endif-->
                                <!--</a>-->
                                <a href="{{ route('text.inbox', ['folder' => 'deleted']) }}"
                                   class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium">
                                        <i class="ti ti-trash text-gray me-2"></i>Deleted
                                    </span>
                                    @if(($counts['deleted'] ?? 0) > 0)
                                        <span class="fw-semibold fs-12 rounded-pill">{{ $counts['deleted'] }}</span>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Thread Panel ────────────────────────────────────────────── --}}
        <div class="mail-detail bg-white border-bottom p-3 flex-fill">
            <div class="active slimscroll h-100">
                <div class="slimscroll-active-sidebar">

                    {{-- Header --}}
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 border-bottom mb-3 pb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('text.inbox') }}" class="btn btn-icon btn-sm rounded-circle me-2"
                               title="Back to Inbox">
                                <i class="ti ti-arrow-left"></i>
                            </a>
                            <div>
                                <h5 class="mb-0">{{ $contactName }}</h5>
                                <small class="text-muted">{{ $decodedPhone }}</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" id="threadStarBtn"
                               class="btn btn-icon btn-sm rounded-circle"
                               title="{{ $isStarred ? 'Unstar' : 'Star' }} conversation"
                               data-phone="{{ urlencode($decodedPhone) }}">
                                <i class="ti ti-star{{ $isStarred ? '-filled text-warning' : '' }}"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Chat bubbles --}}
                    <div id="sms-chat-area" class="d-flex flex-column gap-3 mb-4"
                         style="max-height:55vh;overflow-y:auto;padding-bottom:1rem;">

                        @forelse($messages as $msg)
                            @php
                                $isOut = $msg->direction === 'outbound';
                                $initials = strtoupper(substr($contactName, 0, 1));
                            @endphp

                            <div class="d-flex {{ $isOut ? 'justify-content-end' : 'justify-content-start' }}">
                                @if(!$isOut)
                                    <div class="avatar avatar-sm avatar-rounded flex-shrink-0 me-2"
                                         style="background:#e0e0e0;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        {{ $initials }}
                                    </div>
                                @endif

                                <div class="d-flex flex-column {{ $isOut ? 'align-items-end' : 'align-items-start' }}"
                                     style="max-width:65%;">
                                    <div class="rounded p-2 px-3 {{ $isOut ? 'bg-primary text-white' : 'bg-light text-dark' }}"
                                         style="word-break:break-word;">
                                        {{ $msg->body }}
                                    </div>
                                    <small class="text-muted mt-1" style="font-size:0.75rem;">
                                        {{ $msg->created_at->format('M j, g:i A') }}
                                        @if($isOut)
                                            <span class="ms-1">
                                                @if($msg->status === 'delivered')
                                                    <i class="ti ti-checks text-success" title="Delivered"></i>
                                                @elseif($msg->status === 'failed')
                                                    <i class="ti ti-alert-circle text-danger" title="Failed"></i>
                                                @else
                                                    <i class="ti ti-check text-muted" title="{{ $msg->status }}"></i>
                                                @endif
                                            </span>
                                        @endif
                                    </small>
                                </div>

                                @if($isOut)
                                    <div class="avatar avatar-sm avatar-rounded flex-shrink-0 ms-2"
                                         style="background:#4f46e5;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;">
                                        Me
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="ti ti-message-off fs-1 d-block mb-2"></i>
                                No messages yet. Start the conversation below.
                            </div>
                        @endforelse
                    </div>

                    {{-- Reply form --}}
                    <div class="border rounded">
                        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                            <span class="fw-medium">Reply to <strong>{{ $contactName }}</strong></span>
                            <small class="text-muted">{{ $decodedPhone }}</small>
                        </div>
                        <div class="p-3 border-bottom">
                            <textarea id="replyBody" rows="4" class="form-control"
                                      placeholder="Type your message…"></textarea>
                        </div>
                        <div class="p-3 d-flex align-items-center justify-content-end">
                            <button id="replySendBtn" type="button"
                                    class="btn btn-primary d-inline-flex align-items-center">
                                Send <i class="ti ti-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── Compose New SMS Modal ─────────────────────────────────────────────── --}}
<div id="sms-compose-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="bg-white border-0 rounded compose-view">
                <div class="compose-header d-flex align-items-center justify-content-between bg-dark p-3">
                    <h5 class="text-white">New Text Message</h5>
                    <div class="d-flex align-items-center">
                        <button type="button"
                                class="btn-close btn-close-modal custom-btn-close bg-transparent fs-16 text-white position-static"
                                data-bs-dismiss="modal" aria-label="Close">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>

                <div class="p-3 position-relative pb-2 border-bottom">
                    <div class="tag-with-img d-flex align-items-center">
                        <label class="form-label me-2 mb-0">To</label>
                        <input class="form-control border-0 h-100" id="smsToInput" type="text"
                               placeholder="Type name or number…"/>
                        <input type="hidden" id="smsToPhone"/>
                    </div>
                    <ul id="smsSuggestionsList"
                        class="list-group position-absolute shadow-sm d-none"
                        style="top:65px;z-index:1000;width:90%;left:50%;transform:translateX(-50%);"></ul>
                </div>

                <div class="p-3 border-bottom position-relative">
                    <div class="mb-3">
                        <textarea id="smsComposeBody" rows="7" class="form-control"
                                  placeholder="Message body"></textarea>
                    </div>
                    <div class="position-relative">
                        <label class="form-label fw-semibold">Insert Template</label>
                        <select id="smsTemplateSelect" class="form-select border border-1">
                            <option value="">Select a template…</option>
                            @foreach($smsTemplates as $tpl)
                              <option value="{{ $tpl->id }}">{{ $tpl->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="p-3 d-flex align-items-center justify-content-end compose-footer">
                    <button id="smsSendBtn" type="button"
                            class="btn btn-primary d-inline-flex align-items-center ms-2">
                        Send <i class="ti ti-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const smsCustomers  = @json($customers);
    const decodedPhone  = @json($decodedPhone);
    const sendRoute     = "{{ route('sms.send') }}";
    const threadStarUrl = "{{ url('sms/thread') }}/" + encodeURIComponent(@json($decodedPhone)) + '/star';
    const csrf          = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let _replySending = false; // prevent double-submit

        {{-- Toast container (ensure exists) --}}
        if (!document.getElementById('smsToast')) {
                const toastWrap = document.createElement('div');
                toastWrap.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastWrap.style.zIndex = 9999;
                toastWrap.innerHTML = `
                    <div id="smsToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body d-flex align-items-center gap-2">
                                <i id="smsToastIcon" class="ti fs-5"></i>
                                <span id="smsToastMsg"></span>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>`;
                document.body.appendChild(toastWrap);
        }

        /* Toast helper */
        function showToast(message, type = 'success') {
                const toastEl = document.getElementById('smsToast');
                const icon    = document.getElementById('smsToastIcon');
                const msg     = document.getElementById('smsToastMsg');
                if (!toastEl || !icon || !msg) {
                        try { console.warn('Toast elements missing, falling back to alert'); } catch (e) {}
                        alert(message);
                        return;
                }
                toastEl.className = 'toast align-items-center border-0 text-white ' + (type === 'success' ? 'bg-success' : 'bg-danger');
                icon.className = 'ti fs-5 ' + (type === 'success' ? 'ti-circle-check' : 'ti-alert-circle');
                msg.textContent = message;
                const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 });
                toast.show();
        }

        /* Cross-version modal hide helper */
        function hideModal(el) {
            try {
                if (!el) return;
                if (window.bootstrap && bootstrap.Modal) {
                    if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                        bootstrap.Modal.getOrCreateInstance(el).hide();
                        return;
                    }
                    if (typeof bootstrap.Modal.getInstance === 'function') {
                        const inst = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                        inst.hide();
                        return;
                    }
                }
                if (window.jQuery) {
                    jQuery(el).modal('hide');
                    return;
                }
                el.classList.remove('show');
                el.style.display = 'none';
            } catch (e) {
                try { console.warn('hideModal error', e); } catch (er) {}
            }
        }

    /* Auto-scroll chat to bottom */
    const chatArea = document.getElementById('sms-chat-area');
    if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;

    /* Reply Send */
    document.getElementById('replySendBtn').addEventListener('click', function () {
        const body = document.getElementById('replyBody').value.trim();
        if (!body || _replySending) return;
        _replySending = true;
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending…';
        fetch(sendRoute, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ to: decodedPhone, body })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) throw new Error(data.message ?? 'Send failed');
            appendOutboundBubble(body);
            document.getElementById('replyBody').value = '';
            showToast('Message sent successfully!', 'success');
        })
        .catch(err => showToast(err.message || 'Failed to send message', 'error'))
        .finally(() => {
            _replySending = false;
            this.disabled = false;
            this.innerHTML = 'Send <i class="ti ti-arrow-right ms-2"></i>';
        });
    });

    function appendOutboundBubble(body) {
        const now = new Date();
        const timeStr = now.toLocaleString('en-US', { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true });
        chatArea.insertAdjacentHTML('beforeend', `
            <div class="d-flex justify-content-end">
                <div class="d-flex flex-column align-items-end" style="max-width:65%;">
                    <div class="rounded p-2 px-3 bg-primary text-white" style="word-break:break-word;">${escHtml(body)}</div>
                    <small class="text-muted mt-1" style="font-size:.75rem;">${timeStr} <i class="ti ti-check text-muted ms-1"></i></small>
                </div>
                <div class="avatar avatar-sm avatar-rounded flex-shrink-0 ms-2"
                     style="background:#4f46e5;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;">Me</div>
            </div>`);
        chatArea.scrollTop = chatArea.scrollHeight;
    }

    /* Thread Star Toggle */
    document.getElementById('threadStarBtn')?.addEventListener('click', function () {
        fetch(threadStarUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const icon = this.querySelector('i');
            icon.className = data.starred ? 'ti ti-star-filled text-warning' : 'ti ti-star';
            this.title      = data.starred ? 'Unstar conversation' : 'Star conversation';
        })
        .catch(err => console.error(err));
    });

    /* Compose Modal — autocomplete */
    const toInput  = document.getElementById('smsToInput');
    const toPhone  = document.getElementById('smsToPhone');
    const suggList = document.getElementById('smsSuggestionsList');
    if (toInput) {
        toInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            suggList.innerHTML = '';
            if (!q) { suggList.classList.add('d-none'); return; }
            const matches = smsCustomers.filter(c => c.name.toLowerCase().includes(q) || c.phone?.includes(q)).slice(0, 8);
            if (!matches.length) { suggList.classList.add('d-none'); return; }
            matches.forEach(c => {
                const li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action cursor-pointer';
                li.textContent = c.name + (c.phone ? ' — ' + c.phone : '');
                li.addEventListener('click', () => { toInput.value = c.name; toPhone.value = c.phone ?? ''; suggList.classList.add('d-none'); });
                suggList.appendChild(li);
            });
            suggList.classList.remove('d-none');
        });
        document.addEventListener('click', e => { if (!toInput.contains(e.target)) suggList.classList.add('d-none'); });
    }

    /* Compose Modal — template fill */
    const smsTemplatesData = @json($smsTemplates->keyBy('id'));
    document.getElementById('smsTemplateSelect')?.addEventListener('change', function () {
        const tpl = smsTemplatesData[this.value];
        const b = document.getElementById('smsComposeBody');
        if (b) b.value = tpl ? tpl.body : '';
        this.value = '';
    });

    /* Compose Modal — send */
    document.getElementById('smsSendBtn')?.addEventListener('click', function () {
        const to   = toPhone?.value.trim() || toInput?.value.trim();
        const body = document.getElementById('smsComposeBody')?.value.trim();
        if (!to || !body) { showToast('Please enter a recipient and message.', 'error'); return; }
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending…';
        fetch(sendRoute, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ to, body })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) throw new Error(data.message ?? 'Send failed');
            document.getElementById('smsComposeBody').value = '';
            if (toInput) toInput.value = '';
            if (toPhone) toPhone.value = '';
            hideModal(document.getElementById('sms-compose-modal'));
            showToast('Message sent successfully!', 'success');
        })
        .catch(err => showToast(err.message || 'Failed to send message', 'error'))
        .finally(() => { this.disabled = false; this.innerHTML = 'Send <i class="ti ti-arrow-right ms-2"></i>'; });
    });

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
})();
</script>

@endsection