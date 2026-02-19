@extends('layouts.app')


@section('title', 'My Wishlist')


@section('content')

    <div class="content content-two p-0 ps-3 pe-3" id="showroom-page">

        <!-- Page Header -->
        <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 ">
            <div style="position: relative; width: 100%; height: 80px;">
                <!-- Title aligned left -->
                <h6 style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); margin: 0;">
                    Wishlist
                </h6>

                <!-- Image centered -->
                <img class="logo-img" src="assets/light_logo.png" alt="Showroom"
                    style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px;">
            </div>


        </div>
        <!-- End Page Header -->


        <div class="split-container">
            <!-- View 1 -->
            <div class="split-view">
              <form id="wishlistFilters">
                <div class="crm-box">
                    <div class="crm-header">Filters</div>
                    <div class="row g-2" >

                        <!-- First 4 filters: Always visible -->
                        <div class="col-md-3 mb-2">
                            <label class="form-label">From</label>
                            <input type="text" name="fromDate" class="bg-light form-control cf-datepicker" id="fromDate"
                                readonly>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">To</label>
                            <input type="text" name="toDate" class="bg-light form-control cf-datepicker" id="toDate"
                                readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Users</label>
                            <select class="form-select" name="user" id="userSelect">
                                <option value="">--ALL--</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">Teams</label>
                            <select class="form-select" name="team" id="teamSelect">
                                <option value="">--ALL--</option>
                            </select>
                        </div>

                        <div class="col-5 dates-option">
                            <span class="me-2" style="cursor:pointer" data-range="ytd">YTD</span>
                            <span class="me-2" style="cursor:pointer" data-range="this_week">This Week</span>
                            <span class="me-2" style="cursor:pointer" data-range="last_week">Last Week</span>
                            <span class="me-2" style="cursor:pointer" data-range="lm">LM</span>
                            <span class="me-2" style="cursor:pointer" data-range="mtd">MTD</span>
                            <span class="me-2" style="cursor:pointer" data-range="last_7">Last 7 Days</span>
                            <span class="me-2" style="cursor:pointer" data-range="yesterday">Yesterday</span>
                            <span class="me-2" style="cursor:pointer" data-range="today">Today</span>
                        </div>

                        <div class="col-6 mt-2 d-flex gap-2 button-group mb-3">
                            <button type="button" id="resetFiltersBtn" class="btn btn-secondary">Refresh</button>
                            <button type="button" id="exportCsvBtn" class="btn btn-outline-primary">Export</button>
                            <button type="button" id="printBtn" class="btn btn-outline-dark">Print</button>
                        </div>

                        <!-- Show More Filters Button -->
                        <div class="col-12" id="toggleFiltersBtn">
                            <button type="button" class="float-end btn btn-sm btn-outline-primary border-2">View More
                                Filters</button>
                        </div>

                        <!-- All remaining fields wrapped here -->
                        <div class="extra-filters row" style="display: none;">

                            <!-- 🔹 Lead Information -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Type</label>
                                <select class="form-select" name="lead_type">
                                    <option value="">--ALL--</option>
                                    <option value="Internet">Internet</option>
                                    <option value="Walk-In">Walk-In</option>
                                    <option value="Phone Up">Phone Up</option>
                                    <option value="Text Up">Text Up</option>
                                    <option value="Website Chat">Website Chat</option>
                                    <option value="Import">Import</option>
                                    <option value="Wholesale">Wholesale</option>
                                    <option value="Lease Renewal">Lease Renewal</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Status</label>
                                <select class="form-select" name="lead_status">
                                    <option value="">--ALL--</option>
                                    <option value="Active">Active</option>
                                    <option value="Duplicate">Duplicate</option>
                                    <option value="Invalid">Invalid</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Wishlist">Wishlist</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Source</label>
                                <select class="form-select" name="source">
                                    <option value="">--ALL--</option>
                                    <option value="Walk-In">Walk-In</option>
                                    <option value="Phone Up">Phone Up</option>
                                    <option value="Text">Text</option>
                                    <option value="Repeat Customer">Repeat Customer</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Service to Sales">Service to Sales</option>
                                    <option value="Lease Renewal">Lease Renewal</option>
                                    <option value="Drive By">Drive By</option>
                                    <option value="Dealer Website">Dealer Website</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">Inventory Type</label>
                                <select class="form-select" name="inventory_type">
                                    <option value="">--ALL--</option>
                                    <option value="New">New</option>
                                    <option value="Pre-Owned">Pre-Owned</option>
                                    <option value="CPO">CPO</option>
                                    <option value="Demo">Demo</option>
                                    <option value="Wholesale">Wholesale</option>
                                    <option value="Unknown">Unknown</option>
                                </select>
                            </div>

                            <!-- 🔹 Dealership & Sales Info -->
                            <div class="col-md-12">
                                <div class="row mt-0">

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Dealership</label>
                                        <select class="form-select" name="dealership">
                                            <option value="">--ALL--</option>
                                            <option value="#18874 Bannister GM Vernon">#18874 Bannister GM Vernon</option>
                                            <option value="Twin Motors Thompson">Twin Motors Thompson</option>
                                            <option value="#19234 Bannister Ford">#19234 Bannister Ford</option>
                                            <option value="#19345 Bannister Nissan">#19345 Bannister Nissan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Sales Status</label>
                                        <select class="form-select" name="sales_status">
                                            <option value="">--ALL--</option>
                                            <option value="Untouched">Untouched</option>
                                            <option value="Attempted">Attempted</option>
                                            <option value="Contacted">Contacted</option>
                                            <option value="Dealer Visit">Dealer Visit</option>
                                            <option value="Demo">Demo</option>
                                            <option value="Write-Up">Write-Up</option>
                                            <option value="Pending F&I">Pending F&I</option>
                                            <option value="Sold">Sold</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Lost">Lost</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Deal Type</label>
                                        <select class="form-select" name="deal_type">
                                            <option value="" selected>--All--</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Lease">Lease</option>
                                            <option value="Unknown">Unknown</option>

                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Sales Type</label>
                                        <select class="form-select" name="sales_type">
                                            <option value="Sales" selected>Sales Inquiry</option>
                                            <option value="Service">Service Inquiry</option>
                                            <option value="Parts">Parts Inquiry</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <script>
                            const toggleBtn = document.querySelector("#toggleFiltersBtn button");
                            const extraFilters = document.querySelector(".extra-filters");

                            toggleBtn.addEventListener("click", function() {
                                extraFilters.classList.toggle('active');
                            });
                        </script>


                        <style>
                            .extra-filters {
                                flex-wrap: wrap;
                            }
                        </style>
                    </div>
                </div>
                <div class="crm-box">
                    <div class="crm-header">Year / Price / KMs</div>
                    <style>
                        .filter-group {
                            border: 1px solid #dcdcdc;
                            border-radius: 8px;
                            padding: 15px;
                            margin-bottom: 15px;
                            background: #fff;
                        }

                        .filter-group h6 {
                            font-weight: 600;
                            font-size: 14px;
                            color: #333;
                            margin-bottom: 10px;
                        }

                        .filter-group .form-label {
                            font-size: 13px;
                            font-weight: 500;
                        }

                        .filter-group .form-control {}
                    </style>

                    <div class="form-section">
                        <div class="row">

                            <!-- Year Group -->
                            <div class="col-md-12 col-lg-4">
                                <div class="filter-group">
                                    <h6>Year Range</h6>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">From:</label>
                                            <input type="text" name="year_from" class="form-control realtime-filter"
                                                placeholder="e.g. 2015">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">To:</label>
                                            <input type="text" name="year_to" class="form-control realtime-filter"
                                                placeholder="e.g. 2024">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Group -->
                            <div class="col-md-12 col-lg-4">
                                <div class="filter-group">
                                    <h6>Price Range</h6>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">From:</label>
                                            <input type="number" name="price_min" class="form-control realtime-filter"
                                                placeholder="e.g. 20000">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">To:</label>
                                            <input type="number" name="price_max" class="form-control realtime-filter"
                                                placeholder="e.g. 40000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kilometers Group -->
                            <div class="col-md-12 col-lg-4">
                                <div class="filter-group">
                                    <h6>Kilometers Range</h6>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">From:</label>
                                            <input type="number" name="mileage_min" class="form-control realtime-filter"
                                                placeholder="e.g. 10000">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">To:</label>
                                            <input type="number" name="mileage_max" class="form-control realtime-filter"
                                                placeholder="e.g. 60000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="crm-box">
                    <div class="crm-header">Year / Make / Model</div>
                    <div class="form-section">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Year:</label>
                                <input type="text" name="year" class="form-control realtime-filter"
                                    placeholder="e.g. 2025">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Make:</label>
                                <input type="text" name="make" class="form-control realtime-filter"
                                    placeholder="e.g. Toyota">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Model:</label>
                                <input type="text" name="model" class="form-control realtime-filter"
                                    placeholder="e.g. Corolla">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Customer Visit Box -->
                <div class="respo-visit-container mb-3">
                    <div class="visit-container wishlist-col-system">
                        <!-- HEADER ROW -->
                        <div class="visit-header">
                            <div class="visit-col col-1">Customer Name</div>
                            <div class="visit-col col-2">Work List Name</div>
                            <div class="visit-col col-3">List Updated</div>
                            <div class="visit-col col-4">List Matched</div>
                            <div class="visit-col col-5"></div>



                        </div>

                        <!-- Items will be injected here -->
                        <div id="wishlistAlert" class="text-danger small mb-2" style="display:none;">Apply at least one
                            filter before loading items.</div>
                        <div id="wishlistItems" aria-live="polite"></div>


                    </div>
                </div>
                </form>

            </div>

            <!-- View 2 -->

        </div>


    </div>
@endsection



@push('scripts')
    <script>
        // Populate users select from API
        async function populateUsers() {
            try {
                const res = await fetch('/api/users', {
                    credentials: 'same-origin'
                });
                if (!res.ok) return;
                const json = await res.json();
                const users = json.data || [];
                const sel = document.getElementById('userSelect');
                const teamSel = document.getElementById('teamSelect');
                const teams = new Set();

                users.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    sel.appendChild(opt);

                    // collect roles
                    if (Array.isArray(u.roles)) {
                        u.roles.forEach(r => {
                            if (r && r.name) teams.add(r.name);
                        });
                    }
                });

                // populate teams
                Array.from(teams).sort().forEach(name => {
                    const o = document.createElement('option');
                    o.value = name;
                    o.textContent = name;
                    teamSel.appendChild(o);
                });
            } catch (err) {
                console.error('Failed to load users', err);
            }
        }

        // store last fetched items so export/print use the same dataset
        window.wishlistItemsData = [];

        function escapeHtml(s) {
            if (!s && s !== 0) return '';
            return String(s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function hasFiltersApplied(form) {
            const fd = new FormData(form);
            for (const [, v] of fd.entries()) {
                if (v !== null && String(v).trim() !== '') return true;
            }
            return false;
        }

        function renderItem(item) {
            const entry = document.createElement('div');
            entry.className = 'visit-entry';

            entry.innerHTML = `
            <div class="visit-col col-1 ">
                <div class="d-flex gap-2 justify-content-normal align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" class="icon">
                    <div>${escapeHtml(item.customer_name)}</div>
                </div>
            </div>
            <div class="visit-col col-2">${escapeHtml(item.work_list_name || '')}</div>
            <div class="visit-col col-3">${escapeHtml(item.list_updated || '')}</div>
            <div class="visit-col col-4">${escapeHtml(item.list_matched || '')}</div>
            <div class="visit-col col-5">
                <a class="edit-vehicle-link fw-semibold" href="${escapeHtml(item.inventory_link || '/inventory')}">View Matches</a>
            </div>
        `;

            return entry;
        }

        async function fetchWishlist() {
            const form = document.getElementById('wishlistFilters');
            const data = new URLSearchParams(new FormData(form));

            try {
                const res = await fetch('/wishlist/data?' + data.toString(), {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!res.ok) throw new Error('Network response was not ok');

                const json = await res.json();
                const container = document.getElementById('wishlistItems');
                container.innerHTML = '';

                // keep a copy of items for export/print
                window.wishlistItemsData = json.items || [];

                (window.wishlistItemsData || []).forEach(i => {
                    if (i) container.appendChild(renderItem(i));
                });

                document.querySelector('.wishlist-col-system').style.display = 'block';
            } catch (err) {
                console.error('Failed to load wishlist', err);
            }
        }

        // Reset handler will be attached inside DOMContentLoaded to ensure elements exist

        document.addEventListener('DOMContentLoaded', function() {
            // initialize date placeholders
            const fromDate = document.querySelector('#fromDate');
            const toDate = document.querySelector('#toDate');
            if (fromDate) {
                fromDate.value = '';
                fromDate.setAttribute('placeholder', 'Click to choose Start Date…');
            }
            if (toDate) {
                toDate.value = '';
                toDate.setAttribute('placeholder', 'Click to choose End Date…');
            }

            populateUsers();
            fetchWishlist();
            // wire date-range quick picks
            const dateSpans = document.querySelectorAll('.dates-option span[data-range]');

            function pad(n) {
                return n < 10 ? '0' + n : n
            }

            function fmt(d) {
                return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
            }

            function startOfWeek(d) {
                const day = d.getDay();
                const diff = (day + 6) % 7;
                const s = new Date(d);
                s.setDate(d.getDate() - diff);
                s.setHours(0, 0, 0, 0);
                return s;
            }

            function endOfWeek(d) {
                const s = startOfWeek(d);
                const e = new Date(s);
                e.setDate(s.getDate() + 6);
                e.setHours(23, 59, 59, 999);
                return e;
            }

            function startOfMonth(d) {
                return new Date(d.getFullYear(), d.getMonth(), 1);
            }

            function endOfMonth(d) {
                return new Date(d.getFullYear(), d.getMonth() + 1, 0);
            }

            function applyRange(key) {
                const today = new Date();
                let from, to;
                switch (key) {
                    case 'ytd':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = today;
                        break;
                    case 'this_week':
                        from = startOfWeek(today);
                        to = endOfWeek(today);
                        break;
                    case 'last_week': {
                        const last = new Date();
                        last.setDate(today.getDate() - 7);
                        from = startOfWeek(last);
                        to = endOfWeek(last);
                        break;
                    }
                    case 'lm': {
                        const firstOfThis = startOfMonth(today);
                        const lastMonthEnd = new Date(firstOfThis);
                        lastMonthEnd.setDate(0);
                        from = startOfMonth(lastMonthEnd);
                        to = endOfMonth(lastMonthEnd);
                        break;
                    }
                    case 'mtd':
                        from = startOfMonth(today);
                        to = today;
                        break;
                    case 'last_7':
                        from = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 6);
                        to = today;
                        break;
                    case 'yesterday':
                        from = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 1);
                        to = from;
                        break;
                    case 'today':
                        from = today;
                        to = today;
                        break;
                    default:
                        return;
                }
                const fromInput = document.getElementById('fromDate');
                const toInput = document.getElementById('toDate');
                if (fromInput) fromInput.value = fmt(from);
                if (toInput) toInput.value = fmt(to);
                const alertEl = document.getElementById('wishlistAlert');
                if (alertEl) alertEl.style.display = 'none';
                // trigger fetch with current filters
                fetchWishlist();
            }

            dateSpans.forEach(s => s.addEventListener('click', e => applyRange(s.dataset.range)));

            // Debounced auto-apply for other filters (year/price/mileage/make/model etc.)
            function debounce(fn, wait) {
                let t;
                return function(...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), wait);
                };
            }
            const formEl = document.getElementById('wishlistFilters');
            if (formEl) {
                let inputs = Array.from(formEl.querySelectorAll('input, select'));
                // also include any elements explicitly marked for realtime updates
                const realtimeEls = Array.from(formEl.querySelectorAll('.realtime-filter'));
                realtimeEls.forEach(e => {
                    if (!inputs.includes(e)) inputs.push(e);
                });
                // ensure specific groups (year/price/km and year/make/model) are included
                const extraSelectors = ['[name="year_from"]', '[name="year_to"]', '[name="price_min"]',
                    '[name="price_max"]', '[name="mileage_min"]', '[name="mileage_max"]', '[name="year"]',
                    '[name="make"]', '[name="model"]'
                ];
                extraSelectors.forEach(s => {
                    const el = formEl.querySelector(s);
                    if (el && !inputs.includes(el)) inputs.push(el);
                });
                inputs.forEach(el => {
                    const handler = debounce(function() {
                        const alertEl = document.getElementById('wishlistAlert');
                        if (!hasFiltersApplied(formEl)) {
                            // if no filters, clear results and show alert
                            if (alertEl) alertEl.style.display = 'block';
                            const c = document.getElementById('wishlistItems');
                            if (c) c.innerHTML = '';
                            return;
                        }
                        if (alertEl) alertEl.style.display = 'none';
                        fetchWishlist();
                    }, 350);

                    if (el.tagName.toLowerCase() === 'select' || el.type === 'checkbox' || el.type ===
                        'radio') {
                        el.addEventListener('change', handler);
                    } else {
                        el.addEventListener('input', handler);
                    }
                });
            }

            // Attach Reset button handler now that DOM is ready
            const resetBtn = document.getElementById('resetFiltersBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    try {
                        const form = document.getElementById('wishlistFilters');
                        if (form) {
                            form.reset();
                            // clear tomselect instances if any
                            form.querySelectorAll('select').forEach(s => {
                                if (s.tomselect) try {
                                    s.tomselect.clear(true);
                                } catch (e) {}
                            });
                        }
                        const alertEl = document.getElementById('wishlistAlert');
                        if (alertEl) alertEl.style.display = 'none';
                        // fetch with cleared filters
                        fetchWishlist();
                    } catch (e) {
                        console.warn('Reset filters failed', e);
                    }
                });
            }

            // CSV export helper
            function csvEscape(value) {
                if (value === null || value === undefined) return '';
                const s = String(value);
                if (/[",\n\r]/.test(s)) {
                    return '"' + s.replace(/"/g, '""') + '"';
                }
                return s;
            }

            function exportWishlistToCsv() {
                const items = window.wishlistItemsData || [];
                if (!items.length) {
                    alert('No items to export. Apply filters and load items first.');
                    return;
                }

                const headers = ['Customer Name', 'Work List Name', 'List Updated', 'List Matched',
                    'Inventory Link'];
                const rows = items.map(it => [
                    csvEscape(it.customer_name || ''),
                    csvEscape(it.work_list_name || ''),
                    csvEscape(it.list_updated || ''),
                    csvEscape(it.list_matched || ''),
                    csvEscape(it.inventory_link || '')
                ].join(','));

                const csvContent = [headers.join(','), ...rows].join('\r\n');
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                const ts = new Date().toISOString().replace(/[:.]/g, '-');
                a.href = url;
                a.download = `wishlist-${ts}.csv`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            }

            // Print only the wishlist area
            function printWishlist() {
                const content = document.getElementById('wishlistItems');
                if (!content || !content.innerHTML.trim()) {
                    alert('No items to print. Apply filters and load items first.');
                    return;
                }
                const w = window.open('', '_blank');
                const style = `
          <style>
            body{font-family: Arial, Helvetica, sans-serif; padding:20px}
            .visit-entry{border-bottom:1px solid #ddd; padding:10px 0}
            .visit-col{display:inline-block; vertical-align:top}
          </style>`;
                w.document.write('<html><head><title>Wishlist Print</title>' + style + '</head><body>');
                w.document.write('<h3>Wishlist</h3>');
                w.document.write(content.innerHTML);
                w.document.write('</body></html>');
                w.document.close();
                w.focus();
                setTimeout(() => {
                    w.print(); /* optional close */
                }, 300);
            }

            // wire export/print buttons
            const exportBtn = document.getElementById('exportCsvBtn');
            if (exportBtn) exportBtn.addEventListener('click', exportWishlistToCsv);
            const printBtn = document.getElementById('printBtn');
            if (printBtn) printBtn.addEventListener('click', printWishlist);
        });
    </script>
@endpush
