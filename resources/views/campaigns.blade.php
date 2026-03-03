@extends('layouts.app')


@section('title','Campaigns')


@section('content')

<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Campaigns</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

      <!-- Right: Buttons -->
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
        <!-- Trigger Button -->
        <button class="btn btn-light border border-1">
          <i class="isax isax-printer me-1"></i>
          Print
        </button>
        <div class="dropdown">
          <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
            data-bs-toggle="dropdown">
            <i class="isax isax-export-1 me-1"></i>Export
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">PDF</a></li>
            <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
            <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
          </ul>
        </div>

        <!-- <div>
          <a href="create-campaign.html" class="btn btn-primary d-flex align-items-center">
            <i class="isax isax-add-circle me-2"></i>Create Campaign
          </a>
        </div> -->
      </div>
    </div>

    <!-- End Page Header -->
    <div class="mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <div class="table-search d-flex align-items-center mb-0">
            <div class="search-input">
              <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
              <input type="text" id="campaignSearch" class="form-control" placeholder="Search campaigns…" style="min-width:220px;">
            </div>
          </div>
        </div>
      </div>
    </div>

  
  <div class="table-responsive">
    <table id="campaignsTable" class="table table-nowrap">
        <thead class="thead-light">
            <tr>
                <th class="no-sort">
                    <div class="form-check form-check-md">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th>Campaign Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Tracking</th>
                <th>Created By</th>
                <th>Created On</th>
                <th>Sent</th>
                <th>Bounced</th>
                <th>Appointments</th>
                <th>Unsubscribed</th>
                <th>Delivered</th>
                <th>Opened</th>
                <th>Clicked</th>
                <th>Replied</th>
            </tr>
        </thead>
        <tbody id="campaignsTableBody">
            <tr>
                <td colspan="15" class="text-center py-4 text-muted">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading campaigns…
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Customer List Modal -->
<div class="modal fade" id="customerListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customers - <span id="modalStatus"></span> (<span id="rowCount">0</span> rows)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
                <div class="table-responsive table-nowrap">
                    <table class="table border" id="customerTable">
                        <thead class="table-light">
                            <tr>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>Email Address</th>
                                <th>Cell Number</th>
                                <th>Home Number</th>
                                <th>Work Number</th>
                                <th>Year/Make/Model</th>
                                <th>Lead Type</th>
                                <th>Deal Type</th>
                                <th>Created Lead Date/Time</th>
                                <th>Lead Status</th>
                                <th>Sales Status</th>
                                <th>Source</th>
                                <th>Inventory Type</th>
                                <th>Sales Type</th>
                                <th>Created By</th>
                                <th id="dynamicDateColumn"></th>
                            </tr>
                        </thead>
                        <tbody id="customerList">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ── helpers ──────────────────────────────────────────────────────────
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe).replace(/[&<>"'`]/g, function(m) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`': '&#96;' })[m];
            });
        }

        function formatDate(d) {
            if (!d) return '';
            try { const dt = new Date(d); if (isNaN(dt)) return d; return dt.toLocaleString(); } catch (e) { return d; }
        }

        // ── show toast ────────────────────────────────────────────────────────
        function showToast(message, type = 'success') {
            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'error' ? 'bg-danger text-white' : (type === 'warning' ? 'bg-warning' : 'bg-success text-white');
            const toastHtml = `<div id="${toastId}" class="toast align-items-center ${bgClass} border-0 position-fixed" role="alert" aria-live="assertive" aria-atomic="true" style="top:20px;right:20px;z-index:1080;"><div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
            const container = document.createElement('div');
            container.innerHTML = toastHtml;
            document.body.appendChild(container.firstElementChild);
            const toastEl = document.getElementById(toastId);
            const bsToast = new bootstrap.Toast(toastEl, { delay: 5000 });
            bsToast.show();
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        }
        if (typeof window.showToast !== 'function') window.showToast = showToast;

        // ── modal refs ────────────────────────────────────────────────────────
        const customerListModalEl = document.getElementById('customerListModal');
        let customerListModal = null;
        if (customerListModalEl) {
            customerListModal = new bootstrap.Modal(customerListModalEl);
            customerListModalEl.addEventListener('hidden.bs.modal', function () {
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        }

        // ── load campaigns from API ───────────────────────────────────────────
        async function loadCampaigns() {
            try {
                const res = await fetch('/api/campaigns');
                if (!res.ok) throw new Error('Failed to fetch campaigns');
                const data = await res.json();

                let items = [];
                if (Array.isArray(data))                          items = data;
                else if (data && Array.isArray(data.data))        items = data.data;
                else if (data?.data && Array.isArray(data.data.data)) items = data.data.data;

                const tbody = document.getElementById('campaignsTableBody');
                if (!tbody) return;
                tbody.innerHTML = '';

                if (!items.length) {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="15" class="text-center py-4 text-muted">No campaigns found</td>`;
                    tbody.appendChild(tr);
                    return;
                }

                items.forEach(c => {
                    const m = c.metrics || {};
                    const statusBadge = `<span class="badge bg-light text-muted border border-1">${escapeHtml(c.status || 'N/A')}</span>`;

                    const metricCell = (status, val) => {
                        const n = parseInt(val) || 0;
                        if (n === 0) return `<span class="text-muted">0</span>`;
                        return `<a href="#" class="clickable-count" data-campaign-id="${c.id}" data-status="${status}">${n}</a>`;
                    };

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox" data-id="${c.id}"></div></td>
                        <td>${escapeHtml(c.name || c.title || '—')}</td>
                        <td>${escapeHtml(c.set_type === 'once' ? 'One-time' : (c.set_type === 'drip' ? 'Drip' : (c.type || 'Email')))}</td>
                        <td>${statusBadge}</td>
                        <td>${escapeHtml(c.tracking || '—')}</td>
                        <td>${escapeHtml(c.created_by_name || String(c.created_by || '—'))}</td>
                        <td>${formatDate(c.created_at)}</td>
                        <td>${metricCell('sent', m.sent)}</td>
                        <td>${metricCell('bounced', m.bounced)}</td>
                        <td>${metricCell('appointments', m.appointments)}</td>
                        <td>${metricCell('unsubscribed', m.unsubscribed)}</td>
                        <td>${metricCell('delivered', m.delivered)}</td>
                        <td>${metricCell('opened', m.opened)}</td>
                        <td>${metricCell('clicked', m.clicked)}</td>
                        <td>${metricCell('replied', m.replied)}</td>
                    `;
                    tbody.appendChild(tr);
                });

                bindClickableCountHandlers();
                initCampaignSearch();

            } catch (err) {
                console.error(err);
                showToast('Unable to load campaigns', 'error');
            }
        }

        // ── plain search ──────────────────────────────────────────────────────
        function initCampaignSearch() {
            const input = document.getElementById('campaignSearch');
            if (!input) return;
            // Remove old listener by cloning
            const fresh = input.cloneNode(true);
            input.parentNode.replaceChild(fresh, input);
            fresh.addEventListener('input', function () {
                const q = this.value.toLowerCase();
                const rows = document.querySelectorAll('#campaignsTableBody tr');
                rows.forEach(tr => {
                    tr.style.display = q === '' || tr.textContent.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        }

        // ── metric link click → open customer modal ───────────────────────────
        function bindClickableCountHandlers() {
            document.querySelectorAll('.clickable-count').forEach(el => {
                el.replaceWith(el.cloneNode(true));
            });
            document.querySelectorAll('.clickable-count').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    const count = parseInt(this.textContent) || 0;
                    if (count <= 0) return;
                    openRecipientsModal(
                        this.getAttribute('data-campaign-id'),
                        this.getAttribute('data-status')
                    );
                });
            });
        }

        // ── open customer list modal ──────────────────────────────────────────
        const dateColumnMap = {
            sent: 'Sent Date', bounced: 'Bounced Date', appointments: 'Appointment Date',
            unsubscribed: 'Unsubscribed Date', delivered: 'Delivered Date',
            opened: 'Opened Date', clicked: 'Clicked Date', replied: 'Replied Date'
        };

        function openRecipientsModal(campaignId, status) {
            const customerList   = document.getElementById('customerList');
            const modalStatusEl  = document.getElementById('modalStatus');
            const rowCountEl     = document.getElementById('rowCount');
            const dynColEl       = document.getElementById('dynamicDateColumn');
            if (!customerList) return;

            if (modalStatusEl) modalStatusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            if (dynColEl)      dynColEl.textContent = dateColumnMap[status] || 'Date';
            if (rowCountEl)    rowCountEl.textContent = '…';
            customerList.innerHTML = `<tr><td colspan="18" class="text-center py-4"><div class="spinner-border spinner-border-sm" role="status"></div> Loading…</td></tr>`;

            if (customerListModal) customerListModal.show();

            fetch(`/api/campaigns/${campaignId}/recipients`)
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(json => {
                    let all = Array.isArray(json.data) ? json.data : [];
                    // Filter by status — e.g. only show rows where the status date is non-null
                    const filtered = all.filter(row => {
                        const val = row[status];
                        if (status === 'sent')        return !!val;
                        if (status === 'delivered')   return !!val;
                        if (status === 'bounced')     return !!val;
                        if (status === 'opened')      return !!val;
                        if (status === 'clicked')     return !!val;
                        if (status === 'replied')     return !!val;
                        if (status === 'appointments') return !!val;
                        if (status === 'unsubscribed') return !!val;
                        return true;
                    });

                    if (rowCountEl) rowCountEl.textContent = filtered.length;
                    customerList.innerHTML = '';

                    if (!filtered.length) {
                        customerList.innerHTML = `<tr><td colspan="18" class="text-center py-4 text-muted"><i class="bi bi-people fs-1 d-block mb-2"></i>No data available</td></tr>`;
                        return;
                    }

                    filtered.forEach(row => {
                        const tr = document.createElement('tr');
                        const custId = row.customer_id || row.id || null;
                        const custUrl = custId ? `/customers/${custId}/edit` : null;
                        const nameLink = custUrl
                            ? `<a href="#" class="fw-semibold text-decoration-underline" data-ajax-popup="true" data-url="${custUrl}" data-title="Customer Profile">${escapeHtml(row.name || '')}</a>`
                            : `<span class="fw-semibold">${escapeHtml(row.name || '')}</span>`;
                        tr.innerHTML = `
                            <td>${nameLink}</td>
                            <td>${escapeHtml(row.assigned_to || '—')}</td>
                            <td>${escapeHtml(row.assigned_by || '—')}</td>
                            <td><a href="mailto:${escapeHtml(row.email || '')}" class="text-decoration-none">${escapeHtml(row.email || '—')}</a></td>
                            <td>${escapeHtml(row.cell_phone || '—')}</td>
                            <td>${escapeHtml(row.phone || '—')}</td>
                            <td>${escapeHtml(row.work_phone || '—')}</td>
                            <td>${escapeHtml(row.vehicle || '—')}</td>
                            <td>${escapeHtml(row.lead_type || '—')}</td>
                            <td>${escapeHtml(row.deal_type || '—')}</td>
                            <td>${formatDate(row.created_at) || '—'}</td>
                            <td>${escapeHtml(row.lead_status || '—')}</td>
                            <td>${escapeHtml(row.sales_status || '—')}</td>
                            <td>${escapeHtml(row.source || '—')}</td>
                            <td>${escapeHtml(row.inventory_type || '—')}</td>
                            <td>${escapeHtml(row.sales_type || '—')}</td>
                            <td>${escapeHtml(row.created_by ? String(row.created_by) : '—')}</td>
                            <td>${formatDate(row[status]) || '—'}</td>
                        `;
                        customerList.appendChild(tr);
                    });
                })
                .catch(err => {
                    console.error('Failed to load recipients', err);
                    customerList.innerHTML = `<tr><td colspan="18" class="text-center py-4 text-muted">Failed to load data</td></tr>`;
                });
        }

        // ── initial load ──────────────────────────────────────────────────────
        loadCampaigns();

        // Expose so campaigns.blade.php script block can reload after new campaign saved
        window._loadCampaigns = loadCampaigns;

        // Initialize tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    });
</script>


  

  </div>
@endsection