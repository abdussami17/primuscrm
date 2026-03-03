@extends('layouts.app')

@section('title', 'Text Inbox')

@section('content')

<div class="content content-two p-0">
    <div class="d-md-flex">
      <div class="email-sidebar border-end ">
        <div class="active slimscroll h-100">
          <div class="slimscroll-active-sidebar">
            <div class="p-3">
              <div class=" bg-white rounded p-2 mb-3">
                <div class="d-flex justify-content-center align-items-center">
                  <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                    <img src="assets/light_logo.png" class="logo-img" style="height:70px;width: 70px;max-width: 70px;"  class="rounded-circle" alt="Img">
                  </a>
                </div>
              </div>
              <a href="javascript:void(0);" class="btn btn-primary w-100" data-bs-toggle="modal"
                data-bs-target="#sms-compose-modal"><i class="ti ti-edit me-2"></i>Compose</a>
              <div class="mt-4">
                <h5 class="mb-2">Texts</h5>
                <div class="d-block mb-3 pb-3 border-bottom email-tags">
                  <a href="{{ route('text.inbox', ['folder' => 'inbox']) }}"
                    class="d-flex align-items-center justify-content-between p-2 rounded {{ ($folder ?? 'inbox') === 'inbox' ? 'bg-light active' : '' }}">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-inbox text-gray me-2"></i>Inbox</span>
                    <span id="sms-count-unread" class="badge bg-danger rounded-pill badge-xs sms-unread-count{{ ($counts['unread'] ?? 0) === 0 ? ' d-none' : '' }}">{{ $counts['unread'] ?? 0 }}</span>
                  </a>
                  <a href="{{ route('text.inbox', ['folder' => 'starred']) }}"
                    class="d-flex align-items-center justify-content-between p-2 rounded {{ ($folder ?? '') === 'starred' ? 'bg-light active' : '' }}">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-star text-gray me-2"></i>Starred</span>
                    <span id="sms-count-starred" class="fw-semibold fs-12 rounded-pill">{{ $counts['starred'] ?? 0 }}</span>
                  </a>
                  <a href="{{ route('text.inbox', ['folder' => 'sent']) }}"
                    class="d-flex align-items-center justify-content-between p-2 rounded {{ ($folder ?? '') === 'sent' ? 'bg-light active' : '' }}">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-rocket text-gray me-2"></i>Sent</span>
                    <span id="sms-count-sent" class="rounded-pill">{{ $counts['sent'] ?? 0 }}</span>
                  </a>
                  <!--<a href="{{ route('text.inbox', ['folder' => 'draft']) }}"-->
                  <!--  class="d-flex align-items-center justify-content-between p-2 rounded {{ ($folder ?? '') === 'draft' ? 'bg-light active' : '' }}">-->
                  <!--  <span class="d-flex align-items-center fw-medium"><i-->
                  <!--      class="ti ti-file text-gray me-2"></i>Drafts</span>-->
                  <!--  <span id="sms-count-draft" class="fw-semibold fs-12 rounded-pill{{ ($counts['draft'] ?? 0) === 0 ? ' d-none' : '' }}">{{ $counts['draft'] ?? 0 }}</span>-->
                  <!--</a>-->
                  <a href="{{ route('text.inbox', ['folder' => 'deleted']) }}"
                    class="d-flex align-items-center justify-content-between p-2 rounded {{ ($folder ?? '') === 'deleted' ? 'bg-light active' : '' }}">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-trash text-gray me-2"></i>Deleted</span>
                    <span id="sms-count-deleted" class="fw-semibold fs-12 rounded-pill{{ ($counts['deleted'] ?? 0) === 0 ? ' d-none' : '' }}">{{ $counts['deleted'] ?? 0 }}</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white flex-fill border-end border-bottom mail-notifications">
        <div class="active slimscroll h-100">
          <div class="slimscroll-active-sidebar">
            <div class="p-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div>
                  <h5 class="mb-1">
                    @if(($folder ?? 'inbox') === 'starred') Starred
                    @elseif(($folder ?? 'inbox') === 'sent') Sent
                    @elseif(($folder ?? 'inbox') === 'draft') Drafts
                    @elseif(($folder ?? 'inbox') === 'deleted') Deleted
                    @else Text Inbox
                    @endif
                  </h5>
                  <div class="d-flex align-items-center">
                    <span>{{ $threads->count() }} Conversation{{ $threads->count() !== 1 ? 's' : '' }}</span>
                    @if(($folder ?? 'inbox') === 'inbox')
                      <i class="ti ti-point-filled text-primary mx-1"></i>
                      <span>{{ $counts['unread'] ?? 0 }} Unread</span>
                    @endif
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="position-relative input-icon me-3">
                    <form action="{{ route('text.inbox') }}" method="GET" id="smsSearchForm">
                      <input type="hidden" name="folder" value="{{ $folder ?? 'inbox' }}">
                      <input type="hidden" name="filter" value="{{ $filter ?? 'date_high' }}" id="smsFilterInput">
                      <input type="text" class="form-control" name="search" placeholder="Search Texts" value="{{ $search ?? '' }}">
                      <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                      </span>
                    </form>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="dropdown">
                      <a href="#" class="btn btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown"
                        id="filterDropdownBtn">
                        <i class="ti ti-filter-edit"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" id="filterDropdown">
                        <li>
                          <a class="dropdown-item {{ ($filter ?? 'date_high') === 'date_low' ? 'active' : '' }}" href="javascript:void(0);" data-value="date_low" onclick="applyFilter(this)">
                            Date: Earliest to Latest
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item {{ ($filter ?? 'date_high') === 'date_high' ? 'active' : '' }}" href="javascript:void(0);" data-value="date_high" onclick="applyFilter(this)">
                            Date: Latest to Earliest
                          </a>
                        </li>
                      </ul>
                    </div>
                    <input type="hidden" id="selectedFilter" name="selectedFilter" value="{{ $filter ?? 'date_high' }}">
                    <button type="button" id="smsBulkDeleteBtn" class="btn btn-icon btn-sm rounded-circle d-none" title="Delete Selected">
                      <i class="ti ti-trash"></i>
                    </button>
                    <a href="{{ route('text.inbox', ['folder' => $folder ?? 'inbox']) }}" class="btn btn-icon btn-sm rounded-circle" title="Refresh">
                      <i class="ti ti-refresh"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <div class="list-group list-group-flush mails-list">
              @forelse($threads as $thread)
                @php
                  $otherParty  = $thread->other_party;
                  $displayName = $thread->other_party_name;
                  $initials    = mb_strtoupper(mb_substr($displayName, 0, 2));
                  $threadUrl   = route('text.reply', ['phone' => urlencode($otherParty)]);
                @endphp
                <div class="list-group-item border-bottom p-3 {{ !$thread->is_read && $thread->direction === 'inbound' ? 'fw-semibold' : '' }}"
                     data-msg-id="{{ $thread->id }}">
                  <div class="d-flex align-items-center mb-2">
                    <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
                      <input class="form-check-input sms-check" type="checkbox" value="{{ $thread->id }}">
                    </div>
                    <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                      <a href="{{ $threadUrl }}" class="avatar bg-primary avatar-rounded me-2">
                        <span class="avatar-title">{{ $initials }}</span>
                      </a>
                      <div class="flex-fill">
                        <div class="d-flex align-items-start justify-content-between">
                          <div>
                            <h6 class="mb-1"><a href="{{ $threadUrl }}">{{ $displayName }}</a></h6>
                            <span class="text-muted small">{{ $otherParty }}</span>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="dropdown">
                              <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end p-3">
                                @if(($folder ?? 'inbox') === 'deleted')
                                  <li>
                                    <a class="dropdown-item rounded-1 sms-restore" href="javascript:void(0);"
                                       data-id="{{ $thread->id }}">Restore</a>
                                  </li>
                                @elseif(($folder ?? 'inbox') === 'draft')
                                  <li>
                                    <a class="dropdown-item rounded-1 sms-edit-draft" href="javascript:void(0);"
                                       data-id="{{ $thread->id }}"
                                       data-phone="{{ $thread->to }}"
                                       data-body="{{ $thread->body }}"
                                       data-name="{{ $displayName }}">Edit &amp; Send</a>
                                  </li>
                                  <li>
                                    <a class="dropdown-item rounded-1 text-danger sms-delete" href="javascript:void(0);"
                                       data-id="{{ $thread->id }}">Delete Draft</a>
                                  </li>
                                @else
                                  <li>
                                    <a class="dropdown-item rounded-1" href="{{ $threadUrl }}">Open Message Thread</a>
                                  </li>
                                  <li>
                                    <a class="dropdown-item rounded-1 sms-toggle-read" href="javascript:void(0);"
                                       data-id="{{ $thread->id }}" data-read="{{ $thread->is_read ? '1' : '0' }}">
                                      Mark as {{ $thread->is_read ? 'Unread' : 'Read' }}
                                    </a>
                                  </li>
                                  <li>
                                    <a class="dropdown-item rounded-1 text-danger sms-delete" href="javascript:void(0);"
                                       data-id="{{ $thread->id }}">Delete</a>
                                  </li>
                                @endif
                              </ul>
                            </div>
                            <span class="text-muted small">
                              <i class="ti ti-point-filled {{ !$thread->is_read && $thread->direction === 'inbound' ? 'text-danger' : 'text-success' }}"></i>
                              {{ $thread->created_at->format('g:i A') }}
                            </span>
                            <div class="ms-2 sms-star-icon" data-id="{{ $thread->id }}" style="cursor:pointer">
                              <i class="ti {{ $thread->is_starred ? 'ti-star-filled text-warning' : 'ti-star' }}"></i>
                            </div>
                          </div>
                        </div>
                        <p class="mb-0 text-truncate" style="max-width:400px">{{ Str::limit($thread->body, 80) }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="p-4 text-center text-muted">
                  <i class="ti ti-message-off fs-1 d-block mb-2"></i>
                  No messages found.
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Toast Container (used by showToast) ───────────────────────────────── --}}
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:9999;">
    <div id="smsToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body d-flex align-items-center gap-2">
          <i id="smsToastIcon" class="ti fs-5"></i>
          <span id="smsToastMsg"></span>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  {{-- â”€â”€ Compose Modal â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
  <div id="sms-compose-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="bg-white border-0 rounded compose-view">
          <div class="compose-header d-flex align-items-center justify-content-between bg-dark p-3">
            <h5 class="text-white">Compose Text</h5>
            <div class="d-flex align-items-center">
              <button type="button" class="btn-close btn-close-modal custom-btn-close bg-transparent fs-16 text-white position-static"
                data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
            </div>
          </div>

          <div class="p-3 position-relative pb-2 border-bottom">
            <div class="tag-with-img d-flex align-items-center">
              <label class="form-label me-2 mb-0">To</label>
              <input class="input-tags form-control border-0 h-100" id="smsToInput" type="text"
                placeholder="Search customer or enter number..." autocomplete="off" />
              <input type="hidden" id="smsCustomerIdInput">
              <input type="hidden" id="smsContactNameInput">
              <ul id="smsSuggestionsList" class="list-group position-absolute shadow-sm d-none"
                style="top:65px;z-index:1000;width:90%;left:50%;transform:translateX(-50%)"></ul>
            </div>
          </div>

          <div class="p-3 border-bottom">
            <div class="mb-3">
              <textarea id="smsBodyInput" rows="7" class="form-control" placeholder="Message body..."></textarea>
            </div>
            <div>
              <label class="form-label fw-semibold">Insert Template</label>
              <select id="smsTemplateSelect" class="form-select border border-1">
                <option value="">Select a template...</option>
                @foreach($smsTemplates as $tpl)
                  <option value="{{ $tpl->id }}">{{ $tpl->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="p-3 d-flex align-items-center justify-content-between">
            <div>
              <button type="button" id="smsDraftBtn" class="btn btn-outline-secondary d-inline-flex align-items-center">
                <i class="ti ti-file me-2"></i>Save Draft
              </button>
            </div>
            <div class="d-flex align-items-center compose-footer">
              <input type="hidden" id="smsDraftId">
              <span id="smsSendStatus" class="me-2 small text-muted"></span>
              <button type="button" id="smsSendBtn" class="btn btn-primary d-inline-flex align-items-center ms-2">
                Send <i class="ti ti-arrow-right ms-2"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const smsCustomers = @json($customers);
    let _smsSending = false; // prevent double-submit

    // ── Toast helper ──────────────────────────────────────────────────────────
    function showToast(message, type = 'success') {
      let toastEl = document.getElementById('smsToast');
      // If toast container missing (edge cases), create it dynamically
      if (!toastEl) {
        const container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        container.innerHTML = `
          <div id="smsToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body d-flex align-items-center gap-2">
                <i id="smsToastIcon" class="ti fs-5"></i>
                <span id="smsToastMsg"></span>
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
          </div>`;
        document.body.appendChild(container);
        toastEl = document.getElementById('smsToast');
      }

      const icon = document.getElementById('smsToastIcon');
      const msg  = document.getElementById('smsToastMsg');
      if (!toastEl || !icon || !msg) {
        try { console.warn('Toast elements missing, falling back to alert'); } catch (e) {}
        alert(message);
        return;
      }

      try {
        toastEl.className = 'toast align-items-center border-0 text-white ' + (type === 'success' ? 'bg-success' : 'bg-danger');
        icon.className = 'ti fs-5 ' + (type === 'success' ? 'ti-circle-check' : 'ti-alert-circle');
        msg.textContent = String(message || '');
        // show toast wrapped in try/catch to avoid uncaught errors when bootstrap isn't available
        if (window.bootstrap && bootstrap.Toast && typeof bootstrap.Toast.getOrCreateInstance === 'function') {
          const toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3000 });
          toast.show();
        } else {
          // If Bootstrap JS missing, briefly show a simple visible element then hide
          toastEl.style.display = 'block';
          setTimeout(() => { try { toastEl.style.display = ''; } catch (e) {} }, 3000);
        }
      } catch (err) {
        try { console.error('Toast show failed:', err); } catch (e) {}
        alert(message);
      }
    }

    // Cross-version modal hide helper (Bootstrap 5 getOrCreateInstance may be missing)
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
        // Fallback: remove show class and hide
        el.classList.remove('show');
        el.style.display = 'none';
      } catch (e) {
        try { console.warn('hideModal error', e); } catch (er) {}
      }
    }

    // â”€â”€ Autocomplete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const smsToInput        = document.getElementById('smsToInput');
    const smsSuggestions    = document.getElementById('smsSuggestionsList');
    const smsCustomerIdInp  = document.getElementById('smsCustomerIdInput');
    const smsContactNameInp = document.getElementById('smsContactNameInput');

    smsToInput.addEventListener('input', function () {
      const q = this.value.toLowerCase();
      smsSuggestions.innerHTML = '';
      if (!q) { smsSuggestions.classList.add('d-none'); return; }
      const filtered = smsCustomers.filter(c =>
        c.name.toLowerCase().includes(q) || (c.phone || '').includes(q)
      );
      if (!filtered.length) { smsSuggestions.classList.add('d-none'); return; }
      filtered.forEach(c => {
        const li = document.createElement('li');
        li.className = 'list-group-item list-group-item-action';
        li.textContent = `${c.name} â€” ${c.phone}`;
        li.addEventListener('click', () => {
          smsToInput.value        = c.phone;
          smsCustomerIdInp.value  = c.id;
          smsContactNameInp.value = c.name;
          smsSuggestions.classList.add('d-none');
        });
        smsSuggestions.appendChild(li);
      });
      smsSuggestions.classList.remove('d-none');
    });
    document.addEventListener('click', e => {
      if (!smsToInput.contains(e.target)) smsSuggestions.classList.add('d-none');
    });

    // â”€â”€ Template fill â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const smsTemplatesData = @json($smsTemplates->keyBy('id'));
    document.getElementById('smsTemplateSelect').addEventListener('change', function () {
      const tpl = smsTemplatesData[this.value];
      document.getElementById('smsBodyInput').value = tpl ? tpl.body : '';
      this.value = '';
    });

    // â”€â”€ Send â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.getElementById('smsSendBtn').addEventListener('click', async function () {
      const to   = smsToInput.value.trim();
      const body = document.getElementById('smsBodyInput').value.trim();
      const cid  = smsCustomerIdInp.value;
      const name = smsContactNameInp.value;
      const status = document.getElementById('smsSendStatus');

      if (!to || !body) {
        showToast('Recipient and message are required.', 'error');
        return;
      }

      if (_smsSending) return;
      _smsSending = true;
      this.disabled = true;
      this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending…';
      status.textContent = '';

      try {
        const res = await fetch('{{ route('sms.send') }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ to, body, customer_id: cid || null, contact_name: name || null })
        });
        const data = await res.json();
          if (data.success) {
          document.getElementById('smsBodyInput').value = '';
          smsToInput.value = '';
          // If editing a draft, delete it after sending
          const draftId = document.getElementById('smsDraftId')?.value;
          if (draftId) {
            await fetch(`/sms/${draftId}`, {
              method: 'DELETE',
              headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            document.getElementById('smsDraftId').value = '';
            }

            refreshSmsSidebarCounts();
          hideModal(document.getElementById('sms-compose-modal'));
          showToast('Message sent successfully!', 'success');
          setTimeout(() => location.reload(), 1500);
        } else {
          showToast(data.message || 'Failed to send.', 'error');
        }
      } catch (e) {
        showToast('Network error. Please try again.', 'error');
      } finally {
        _smsSending = false;
        this.disabled = false;
        this.innerHTML = 'Send <i class="ti ti-arrow-right ms-2"></i>';
      }
    });

    // â”€â”€ Star toggle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    // ── Sidebar counts refresh ───────────────────────────────────────────────
    function refreshSmsSidebarCounts() {
      fetch('{{ route('sms.counts') }}', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
          const setCount = (id, val, hiddenWhenZero = false) => {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = val;
            if (hiddenWhenZero) {
              if (val > 0) el.classList.remove('d-none'); else el.classList.add('d-none');
            }
          };
          setCount('sms-count-unread',  data.unread  ?? 0, true);
          setCount('sms-count-starred', data.starred ?? 0);
          setCount('sms-count-sent',    data.sent    ?? 0);
          setCount('sms-count-draft',   data.draft   ?? 0, true);
          setCount('sms-count-deleted', data.deleted ?? 0, true);
        })
        .catch(() => {});
    }

    // ── Bulk delete visibility ───────────────────────────────────────────────
    function updateBulkDeleteVisibility() {
      const checked = document.querySelectorAll('.sms-check:checked').length;
      const btn = document.getElementById('smsBulkDeleteBtn');
      if (!btn) return;
      if (checked > 0) { btn.classList.remove('d-none'); btn.title = `Delete (${checked})`; }
      else btn.classList.add('d-none');
    }
    document.querySelectorAll('.sms-check').forEach(cb => cb.addEventListener('change', updateBulkDeleteVisibility));

    // ── Bulk delete handler ──────────────────────────────────────────────────
    document.getElementById('smsBulkDeleteBtn')?.addEventListener('click', async function () {
      const checked = [...document.querySelectorAll('.sms-check:checked')];
      if (!checked.length) return;
      if (!confirm(`Delete ${checked.length} selected message(s)?`)) return;
      this.disabled = true;
      const csrf = '{{ csrf_token() }}';
      await Promise.all(checked.map(cb =>
        fetch(`/sms/${cb.value}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        }).then(() => cb.closest('.list-group-item')?.remove())
      ));
      this.disabled = false;
      this.classList.add('d-none');
      refreshSmsSidebarCounts();
    });

    // ── Star toggle ──────────────────────────────────────────────────────────
    document.querySelectorAll('.sms-star-icon').forEach(el => {
      el.addEventListener('click', async function (e) {
        e.stopPropagation();
        const id = this.dataset.id;
        const i  = this.querySelector('i');
        const res = await fetch(`/sms/${id}/star`, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
          i.classList.toggle('ti-star', !data.is_starred);
          i.classList.toggle('ti-star-filled', data.is_starred);
          i.classList.toggle('text-warning', data.is_starred);
          refreshSmsSidebarCounts();
        }
      });
    });

    // â”€â”€ Read toggle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.querySelectorAll('.sms-toggle-read').forEach(el => {
      el.addEventListener('click', async function () {
        const id = this.dataset.id;
        await fetch(`/sms/${id}/read`, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        location.reload();
      });
    });

    // â”€â”€ Delete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.querySelectorAll('.sms-delete').forEach(el => {
      el.addEventListener('click', async function () {
        if (!confirm('Delete this message?')) return;
        const id = this.dataset.id;
        await fetch(`/sms/${id}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        this.closest('.list-group-item')?.remove();
        refreshSmsSidebarCounts();
      });
    });

    // ── Save Draft ──────────────────────────────────────────────────────────
    document.getElementById('smsDraftBtn').addEventListener('click', async function () {
      const to   = smsToInput.value.trim();
      const body = document.getElementById('smsBodyInput').value.trim();
      const cid  = smsCustomerIdInp.value;
      const name = smsContactNameInp.value;
      const status = document.getElementById('smsSendStatus');
      if (!to || !body) {
        status.textContent = 'Recipient and message are required.';
        status.className = 'me-2 small text-danger';
        return;
      }
      this.disabled = true;
      status.textContent = 'Saving…';
      status.className = 'me-2 small text-muted';
      try {
        const res = await fetch('{{ route('sms.draft') }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ to, body, customer_id: cid || null, contact_name: name || null })
        });
        const data = await res.json();
        if (data.success) {
          status.textContent = 'Draft saved!';
          status.className = 'me-2 small text-success';
          document.getElementById('smsBodyInput').value = '';
          smsToInput.value = '';
          refreshSmsSidebarCounts();
          setTimeout(() => hideModal(document.getElementById('sms-compose-modal')), 800);
          setTimeout(() => location.reload(), 1200);
        } else {
          status.textContent = data.message || 'Failed to save draft.';
          status.className = 'me-2 small text-danger';
        }
      } catch (e) {
        status.textContent = 'Network error.';
        status.className = 'me-2 small text-danger';
      } finally {
        this.disabled = false;
      }
    });

    // ── Restore (deleted folder) ────────────────────────────────────────────
    document.querySelectorAll('.sms-restore').forEach(el => {
      el.addEventListener('click', async function () {
        const id = this.dataset.id;
        await fetch(`/sms/${id}/restore`, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        this.closest('.list-group-item')?.remove();
        refreshSmsSidebarCounts();
      });
    });

    // ── Edit & Send Draft ───────────────────────────────────────────────────
    document.querySelectorAll('.sms-edit-draft').forEach(el => {
      el.addEventListener('click', function () {
        smsToInput.value                               = this.dataset.phone || '';
        document.getElementById('smsBodyInput').value  = this.dataset.body  || '';
        document.getElementById('smsDraftId').value    = this.dataset.id    || '';
        smsContactNameInp.value                        = this.dataset.name  || '';
        try {
          if (window.bootstrap && bootstrap.Modal && typeof bootstrap.Modal.getOrCreateInstance === 'function') {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('sms-compose-modal')).show();
          } else if (window.jQuery) {
            jQuery(document.getElementById('sms-compose-modal')).modal('show');
          } else {
            document.getElementById('sms-compose-modal').classList.add('show');
            document.getElementById('sms-compose-modal').style.display = 'block';
          }
        } catch (e) {
          try { console.warn('Show modal fallback', e); } catch (er) {}
        }
      });
    });

    // Reset draft id when modal closes
    document.getElementById('sms-compose-modal').addEventListener('hidden.bs.modal', function () {
      document.getElementById('smsDraftId').value = '';
      document.getElementById('smsSendStatus').textContent = '';
    });

    // â”€â”€ Filter â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    function applyFilter(el) {
      document.getElementById('smsFilterInput').value = el.dataset.value;
      document.getElementById('smsSearchForm').submit();
    }
  </script>

@endsection
