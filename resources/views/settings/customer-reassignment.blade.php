
                                    <!-- Customer Reassignment Tab -->
                                    <div class="tab-pane fade" id="customer-reassignment-tab" role="tabpanel"
                                        aria-labelledby="customer-reassignment-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Customer Reassignment</h2>
                                            <p class="primus-crm-content-description">Reassign customers to
                                                different sales representatives or teams.</p>
                                        </div>

                                        <!-- Tabs for Reassignment and Undo Reassignment -->
                                        <ul class="nav nav-tabs mb-4" id="reassignmentTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="reassignment-tab"
                                                    data-bs-toggle="tab" data-bs-target="#reassignment"
                                                    type="button" role="tab" aria-controls="reassignment"
                                                    aria-selected="true">
                                                    <i class="fas fa-user-check me-1"></i> Customer Reassignment
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="undo-reassignment-tab"
                                                    data-bs-toggle="tab" data-bs-target="#undo-reassignment"
                                                    type="button" role="tab" aria-controls="undo-reassignment"
                                                    aria-selected="false">
                                                    <i class="fas fa-undo me-1"></i> Undo Reassignment
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Customer Reassignment Content -->
                                        <div class="tab-content" id="reassignmentTabContent">
                                            <div class="tab-pane fade show active" id="reassignment" role="tabpanel"
                                                aria-labelledby="reassignment-tab">
                                                <div class="primus-crm-settings-section">
                                                    <h3 class="primus-crm-section-title">
                                                        <span class="primus-crm-section-icon"><i
                                                                class="fas fa-filter"></i></span>
                                                        Filters & Options
                                                    </h3>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select" id="customerAssignedManagerFilter">
                                                                <option value="">All Users</option>
                                                                @foreach($users as $u)
                                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="customerAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                @foreach($users as $u)
                                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select" id="customerSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                @foreach($users as $u)
                                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="customerBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                @foreach($users as $u)
                                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select" id="leadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                @foreach($leadStatuses as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="leadTypeFilter">
                                                                <option value="">All Types</option>
                                                                @foreach($leadTypes as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select" id="inventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                @foreach($inventoryTypes as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="salesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                @foreach($salesStatuses as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="sourcesFilter">
                                                                <option value="">All Sources</option>
                                                                @foreach($sources as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="dealTypeFilter">
                                                                <option value="">All Types</option>
                                                                @foreach($dealTypes as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="salesTypeFilter">
                                                                <option value="">All Types</option>
                                                                @foreach($salesTypes as $k => $v)
                                                                    <option value="{{ $k }}">{{ $v }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">Start Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="startCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">End Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="endCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Reassign To User</label>
                                                            <select class="" id="reassignSalesRep" multiple>
                                                                @foreach($users as $u)
                                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                new TomSelect('#reassignSalesRep', {
                                                                    plugins: ['checkbox_options', 'clear_button'],
                                                                    placeholder: 'Select Users',
                                                                    persist: false,
                                                                    hideSelected: false,
                                                                    closeAfterSelect: false,
                                                                    allowEmptyOption: true
                                                                });
                                                            });
                                                        </script>

                                                        <div class="col-md-6">
                                                            <label class="form-label">Reassign To Team</label>
                                                            <select class="form-select" id="reassignTeam">
                                                                <option value="">-- Select Team --</option>
                                                                <option value="sales-rep">Sales Rep</option>
                                                                <option value="bdc-agent">BDC Agent</option>
                                                                <option value="fi">F&I</option>
                                                                <option value="sales-manager">Sales Manager</option>
                                                                <option value="bdc-manager">BDC Manager</option>
                                                                <option value="finance-director">Finance Director
                                                                </option>
                                                                <option value="general-sales-manager">General Sales
                                                                    Manager
                                                                </option>
                                                                <option value="general-manager">General Manager
                                                                </option>
                                                                <option value="dealer-principal">Dealer Principal
                                                                </option>
                                                                <option value="admin">Admin</option>
                                                                <option value="reception">Reception</option>
                                                                <option value="service-advisor">Service Advisor
                                                                </option>
                                                                <option value="service-manager">Service Manager
                                                                </option>
                                                                <option value="inventory-manager">Inventory Manager
                                                                </option>
                                                                <option value="fixed-operations-manager">Fixed
                                                                    Operations
                                                                    Manager</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-user-friends"></i></span>
                                                            Customers
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="reassignCustomersBtn"
                                                                class="btn btn-success" disabled
                                                                onclick="handleReassignSelected()">
                                                                <i class="fas fa-user-check me-1"></i> <span
                                                                    class="d-none d-md-inline">Complete
                                                                    Reassignment</span>
                                                            </button>
                                                            <button id="refreshCustomersBtn"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                            <div
                                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                                                                <a href="javascript:void(0);"
                                                                    onclick="window.print()"
                                                                    class="btn btn-light border border-1 d-flex align-items-center">
                                                                    <i class="isax isax-printer me-1"></i>Print
                                                                </a>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-outline-white d-inline-flex align-items-center"
                                                                        data-bs-toggle="dropdown">
                                                                        <i
                                                                            class="isax isax-export-1 me-1"></i>Export
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="#">PDF</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (XLSX)</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (CSV)</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-hover border">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="50">
                                                                        <input type="checkbox"
                                                                            id="selectAllCustomers"
                                                                            class="form-check-input">
                                                                    </th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Year / Make / Model</th>
                                                                    <th>Email(s)</th>
                                                                    <th>Work Number</th>
                                                                    <th>Cell Number</th>
                                                                    <th>Home Number</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Created Date</th>
                                                                    <th>Assigned To</th>
                                                                    <th>Secondary Assigned To</th>
                                                                    <th>BDC Agent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="customersTableBody">
                                                                {{-- Populated by AJAX --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                    <script>
                        (function () {
                            const apiCustomers = '/settings/customer-reassignment/data';
                            const apiReassign = '/settings/customer-reassignment/reassign';
                            const apiHistory = '/settings/customer-reassignment/history';
                            const apiUndo = '/settings/customer-reassignment/undo';

                            let customersTableBody;
                            let undoTableBody;
                            let customersSelectionInfo;
                            let customersCount;
                            let reassignBtn;
                            let refreshBtn;
                            let selectAll;

                            let undoSelectAll;
                            let undoReassignBtn;
                            let refreshUndoBtn;

                            let selectedCustomerIds = new Set();
                            let selectedHistoryIds = new Set();

                            function getCsrf() {
                                const m = document.querySelector('meta[name="csrf-token"]');
                                return m ? m.getAttribute('content') : '';
                            }

                            function qVal(id) { const el = document.getElementById(id); return el ? el.value : ''; }

                            async function loadCustomers() {
                                const params = new URLSearchParams();

                                // explicit mapping from input IDs to controller expected param names
                                const mappings = {
                                    customerAssignedToFilter: 'assigned_to',
                                    customerSecondaryAssignedFilter: 'secondary_assigned',
                                    customerBDCAgentFilter: 'bdc_agent',
                                    leadStatusFilter: 'lead_status',
                                    leadTypeFilter: 'lead_type',
                                    inventoryTypeFilter: 'inventory_type',
                                    startCustomerCreatedDate: 'start_created',
                                    endCustomerCreatedDate: 'end_created'
                                };

                                Object.keys(mappings).forEach(id => {
                                    const v = qVal(id);
                                    if (v) params.set(mappings[id], v);
                                });

                                const url = params.toString() ? (apiCustomers + '?' + params.toString()) : apiCustomers;
                                console.debug('loadCustomers url', url);
                                const res = await fetch(url, { credentials: 'same-origin' });
                                let json = null;
                                try {
                                    json = await res.json();
                                } catch (err) {
                                    console.error('loadCustomers parse error', err, await res.text());
                                }
                                console.debug('loadCustomers response', json);
                                renderCustomers((json && json.data) ? json.data : []);
                            }

                            function renderCustomers(rows) {
                                    try {
                                        if (!customersTableBody) {
                                            console.error('customersTableBody element not found');
                                            return;
                                        }
                                        console.debug('renderCustomers rows', rows && rows.length, rows && rows[0]);
                                        customersTableBody.innerHTML = '';
                                        customersCount.textContent = `Showing ${rows.length} customers`;

                                // build HTML in a string to avoid createElement quirks
                                let html = '';
                                rows.forEach(c => {
                                    const id = c.id;
                                    html += `
                                        <tr>
                                            <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${id}"></td>
                                            <td>${escapeHtml(c.first_name || '')}</td>
                                            <td>${escapeHtml(c.last_name || '')}</td>
                                            <td>${escapeHtml((c.interested_year || '') + ' ' + (c.interested_make || '') + ' ' + (c.interested_model || ''))}</td>
                                            <td>${escapeHtml((c.all_emails && c.all_emails.join ? c.all_emails.join(', ') : (c.email || '')))}</td>
                                            <td>${escapeHtml(c.work_phone || c.phone || '')}</td>
                                            <td>${escapeHtml(c.cell_phone || '')}</td>
                                            <td>${escapeHtml(c.home_phone || '')}</td>
                                            <td>${escapeHtml(c.status || '')}</td>
                                            <td>${escapeHtml(c.lead_source || '')}</td>
                                            <td>${escapeHtml(c.inventory_type || '')}</td>
                                            <td>${escapeHtml(c.sales_status || '')}</td>
                                            <td>${escapeHtml(c.lead_source || '')}</td>
                                            <td>${escapeHtml(c.deal_type || '')}</td>
                                            <td>${escapeHtml(c.sales_type || '')}</td>
                                            <td>${escapeHtml(formatDate(c.created_at))}</td>
                                            <td>${escapeHtml((c.assigned_user && c.assigned_user.name) || (c.assignedUser && c.assignedUser.name) || '')}</td>
                                            <td>${escapeHtml((c.secondary_assigned_user && c.secondary_assigned_user.name) || (c.secondaryAssignedUser && c.secondaryAssignedUser.name) || '')}</td>
                                            <td>${escapeHtml((c.bdc_agent_user && c.bdc_agent_user.name) || (c.bdcAgentUser && c.bdcAgentUser.name) || '')}</td>
                                        </tr>
                                    `;
                                });

                                customersTableBody.innerHTML = html;
                                console.debug('customersTableBody children after insert', customersTableBody.children.length, customersTableBody.innerHTML ? customersTableBody.innerHTML.length : 0);

                                // detect if another script clears/replaces the tbody after we insert
                                try {
                                    const original = customersTableBody;
                                    const observer = new MutationObserver((mutations) => {
                                        if (!original || !document.body) return;
                                        const current = document.getElementById('customersTableBody');
                                        if (current !== original) {
                                            console.warn('customersTableBody element was replaced by another script', {currentExists: !!current, originalRemoved: !document.body.contains(original)});
                                            console.warn(new Error('replacement stack').stack);
                                            observer.disconnect();
                                            return;
                                        }
                                        if (original.children.length === 0) {
                                            console.warn('customersTableBody children cleared by another script', {mutations});
                                            console.warn(new Error('cleared stack').stack);
                                            observer.disconnect();
                                        }
                                    });
                                    observer.observe(customersTableBody, { childList: true });
                                    // stop observing after 5s
                                    setTimeout(() => observer.disconnect(), 5000);
                                } catch(e) { console.error('observer setup failed', e); }

                                // attach checkbox handlers
                                document.querySelectorAll('#customersTableBody .row-checkbox').forEach(cb => {
                                    cb.addEventListener('change', e => {
                                        const id = e.target.dataset.id;
                                        if (e.target.checked) selectedCustomerIds.add(id); else selectedCustomerIds.delete(id);
                                        updateSelectionInfo();
                                    });
                                });

                                selectAll.checked = false;
                                selectedCustomerIds.clear();
                                updateSelectionInfo();
                            } catch (err) {
                                console.error('renderCustomers error', err);
                            }
                            }

                            function updateSelectionInfo() {
                                customersSelectionInfo.textContent = `${selectedCustomerIds.size} customers selected`;
                                reassignBtn.disabled = selectedCustomerIds.size === 0;
                            }

                            function escapeHtml(s){ return String(s || '').replace(/[&<>\"']/g, function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c];}); }

                            function formatDate(d){ if(!d) return ''; try{ return new Date(d).toLocaleDateString(); }catch(e){return d;} }

                            // note: event bindings moved into DOMContentLoaded to avoid running before elements exist

                            async function handleReassignSelected(){
                                if (selectedCustomerIds.size === 0) return;
                                const reassignSelect = document.getElementById('reassignSalesRep');
                                const team = document.getElementById('reassignTeam').value;
                                const users = Array.from(reassignSelect.selectedOptions).map(o => o.value);

                                const body = { customer_ids: Array.from(selectedCustomerIds), reassign_users: users, reassign_team: team };

                                const res = await fetch(apiReassign, {
                                    method: 'POST',
                                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': getCsrf() },
                                    body: JSON.stringify(body),
                                    credentials: 'same-origin'
                                });
                                const json = await res.json();
                                if (json.success) {
                                    await loadCustomers();
                                    await loadHistory();
                                    alert((json.updated||0) + ' customers reassigned');
                                } else {
                                    alert('Failed to reassign');
                                }
                            }

                            // Undo history load
                            async function loadHistory(){
                                const res = await fetch(apiHistory, { credentials: 'same-origin' });
                                const json = await res.json();
                                undoTableBody.innerHTML = '';
                                const select = document.getElementById('reassignmentUndoHistory');
                                select.innerHTML = '<option value="">-- Select Previous Undo --</option>';

                                (json.data||[]).forEach(entry => {
                                    const tr = document.createElement('tr');
                                    const hid = entry.id;
                                    const prevName = entry.previous_value_name || (entry.previous_value ? entry.previous_value : '');
                                    const newName = entry.new_value_name || (entry.new_value ? entry.new_value : '');
                                    const when = formatDate(entry.created_at);

                                    tr.innerHTML = `
                                        <td><input type="checkbox" class="form-check-input row-checkbox" data-hid="${hid}"></td>
                                        <td>${escapeHtml(entry.customer?.first_name || '')}</td>
                                        <td>${escapeHtml(entry.customer?.last_name || '')}</td>
                                        <td>${escapeHtml((entry.customer?.interested_year||'') + ' ' + (entry.customer?.interested_make||'') + ' ' + (entry.customer?.interested_model||''))}</td>
                                        <td>${escapeHtml(entry.customer?.email || '')}</td>
                                        <td>${escapeHtml(entry.customer?.work_phone || '')}</td>
                                        <td>${escapeHtml(entry.customer?.cell_phone || '')}</td>
                                        <td>${escapeHtml(entry.customer?.home_phone || '')}</td>
                                        <td>${escapeHtml(entry.customer?.status || '')}</td>
                                        <td>${escapeHtml(entry.customer?.lead_source || '')}</td>
                                        <td>${escapeHtml(entry.customer?.inventory_type || '')}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>${escapeHtml(formatDate(entry.customer?.created_at))}</td>
                                        <td>${escapeHtml(entry.changed_by_user?.name || '')}</td>
                                        <td>${escapeHtml(newName)}</td>
                                        <td>${escapeHtml(when)}</td>
                                    `;
                                    undoTableBody.appendChild(tr);

                                    // add to undo history select
                                    const opt = document.createElement('option');
                                    opt.value = hid;
                                    opt.text = `${when} - ${entry.changed_by_user?.name || 'Unknown'}`;
                                    select.appendChild(opt);
                                });

                                // attach handlers for undo checkboxes
                                document.querySelectorAll('#undoReassignmentsTableBody .row-checkbox').forEach(cb => {
                                    cb.addEventListener('change', e => {
                                        const hid = e.target.dataset.hid;
                                        if (e.target.checked) selectedHistoryIds.add(hid); else selectedHistoryIds.delete(hid);
                                        undoReassignBtn.disabled = selectedHistoryIds.size === 0;
                                    });
                                });

                                undoReassignBtn.disabled = true;
                                selectedHistoryIds.clear();
                            }

                            if (refreshUndoBtn) refreshUndoBtn.addEventListener('click', loadHistory);

                            async function handleUndoSelected(){
                                if (selectedHistoryIds.size === 0) return;
                                const body = { history_ids: Array.from(selectedHistoryIds) };
                                const res = await fetch(apiUndo, {
                                    method: 'POST',
                                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': getCsrf() },
                                    body: JSON.stringify(body),
                                    credentials: 'same-origin'
                                });
                                const json = await res.json();
                                if (json.success) {
                                    await loadCustomers();
                                    await loadHistory();
                                    alert((json.restored||0) + ' reassignments undone');
                                } else {
                                    alert('Failed to undo');
                                }
                            }

                            document.addEventListener('DOMContentLoaded', () => {
                                // query DOM elements now
                                customersTableBody = document.getElementById('customersTableBody');
                                undoTableBody = document.getElementById('undoReassignmentsTableBody');
                                customersSelectionInfo = document.getElementById('customersSelectionInfo');
                                customersCount = document.getElementById('customersCount');
                                reassignBtn = document.getElementById('reassignCustomersBtn');
                                refreshBtn = document.getElementById('refreshCustomersBtn');
                                selectAll = document.getElementById('selectAllCustomers');

                                undoSelectAll = document.getElementById('selectAllUndoReassignments');
                                undoReassignBtn = document.getElementById('undoReassignBtn');
                                refreshUndoBtn = document.getElementById('refreshUndoReassignBtn');

                                // attach handlers safely
                                if (selectAll) selectAll.addEventListener('change', e => {
                                    const checked = e.target.checked;
                                    document.querySelectorAll('#customersTableBody .row-checkbox').forEach(cb => { cb.checked = checked; cb.dispatchEvent(new Event('change')); });
                                });

                                if (refreshBtn) refreshBtn.addEventListener('click', loadCustomers);
                                if (reassignBtn) reassignBtn.addEventListener('click', handleReassignSelected);
                                if (undoReassignBtn) undoReassignBtn.addEventListener('click', handleUndoSelected);
                                if (refreshUndoBtn) refreshUndoBtn.addEventListener('click', loadHistory);

                                loadCustomers();
                                loadHistory();
                            });

                        })();
                    </script>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="customersSelectionInfo" class="text-muted small">0
                                                            customers selected</div>
                                                        <div class="text-muted small" id="customersCount">Showing 4
                                                            customers</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Undo Reassignment Content -->
                                            <div class="tab-pane fade" id="undo-reassignment" role="tabpanel"
                                                aria-labelledby="undo-reassignment-tab">
                                                <div class="primus-crm-settings-section">
                                                    <h3 class="primus-crm-section-title">
                                                        <span class="primus-crm-section-icon"><i
                                                                class="fas fa-filter"></i></span>
                                                        Filters & Options
                                                    </h3>

                                                    <!-- Undo History Dropdown -->
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Previous Undo History</label>
                                                            <select class="form-select" id="reassignmentUndoHistory">
                                                                <option value="">-- Select Previous Undo --</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned Manager</label>
                                                            <select class="form-select">
                                                                <option value="">All Users</option>
                                                                <option value="David Johnson">David Johnson</option>
                                                                <option value="Amanda Lee">Amanda Lee</option>
                                                                <option value="Steven Clark">Steven Clark</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Assigned To</label>
                                                            <select class="form-select" id="undoAssignedToFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Secondary Assigned To</label>
                                                            <select class="form-select"
                                                                id="undoSecondaryAssignedFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">BDC Agent</label>
                                                            <select class="form-select" id="undoBDCAgentFilter">
                                                                <option value="">All Users</option>
                                                                <option value="john_doe">John Doe</option>
                                                                <option value="jane_smith">Jane Smith</option>
                                                                <option value="bob_johnson">Bob Johnson</option>
                                                                <option value="sarah_williams">Sarah Williams
                                                                </option>
                                                                <option value="mike_brown">Mike Brown</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Status</label>
                                                            <select class="form-select" id="undoLeadStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="new">New</option>
                                                                <option value="qualified">Qualified</option>
                                                                <option value="prospect">Prospect</option>
                                                                <option value="customer">Customer</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Lead Type</label>
                                                            <select class="form-select" id="undoLeadTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="inbound">Inbound</option>
                                                                <option value="outbound">Outbound</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="website">Website</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Inventory Type</label>
                                                            <select class="form-select"
                                                                id="undoInventoryTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="sedan">Sedan</option>
                                                                <option value="suv">SUV</option>
                                                                <option value="truck">Truck</option>
                                                                <option value="convertible">Convertible</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Status</label>
                                                            <select class="form-select" id="undoSalesStatusFilter">
                                                                <option value="">All Statuses</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="in_progress">In Progress</option>
                                                                <option value="negotiation">Negotiation</option>
                                                                <option value="closed_won">Closed Won</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sources</label>
                                                            <select class="form-select" id="undoSourcesFilter">
                                                                <option value="">All Sources</option>
                                                                <option value="website">Website</option>
                                                                <option value="walk_in">Walk-in</option>
                                                                <option value="referral">Referral</option>
                                                                <option value="phone">Phone</option>
                                                                <option value="email">Email</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Deal Type</label>
                                                            <select class="form-select" id="undoDealTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="retail">Retail</option>
                                                                <option value="lease">Lease</option>
                                                                <option value="finance">Finance</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label class="form-label">Sales Type</label>
                                                            <select class="form-select" id="undoSalesTypeFilter">
                                                                <option value="">All Types</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="finance">Finance</option>
                                                                <option value="lease">Lease</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">Start Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="undoStartCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <label class="form-label">End Customer Created
                                                                Date</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control bg-light cf-datepicker"
                                                                    placeholder="Click To Enter" readonly
                                                                    id="undoEndCustomerCreatedDate">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                        <h3 class="primus-crm-section-title mb-0">
                                                            <span class="primus-crm-section-icon"><i
                                                                    class="fas fa-undo"></i></span>
                                                            Previous Reassignments
                                                        </h3>
                                                        <div class="d-flex gap-2">
                                                            <button id="undoReassignBtn" class="btn btn-danger"
                                                                disabled>
                                                                <i class="fas fa-undo me-1"></i> <span
                                                                    class="d-none d-md-inline">Undo Selected
                                                                    Reassignment</span>
                                                            </button>
                                                            <button id="refreshUndoReassignBtn"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </button>
                                                            <div
                                                                class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                                                                <a href="javascript:void(0);"
                                                                    onclick="window.print()"
                                                                    class="btn btn-light border border-1 d-flex align-items-center">
                                                                    <i class="isax isax-printer me-1"></i>Print
                                                                </a>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-outline-white d-inline-flex align-items-center"
                                                                        data-bs-toggle="dropdown">
                                                                        <i
                                                                            class="isax isax-export-1 me-1"></i>Export
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="#">PDF</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (XLSX)</a></li>
                                                                        <li><a class="dropdown-item" href="#">Excel
                                                                                (CSV)</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-hover border">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="50">
                                                                        <input type="checkbox"
                                                                            id="selectAllUndoReassignments"
                                                                            class="form-check-input">
                                                                    </th>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Year / Make / Model</th>
                                                                    <th>Email(s)</th>
                                                                    <th>Work Number</th>
                                                                    <th>Cell Number</th>
                                                                    <th>Home Number</th>
                                                                    <th>Lead Status</th>
                                                                    <th>Lead Type</th>
                                                                    <th>Inventory Type</th>
                                                                    <th>Sales Status</th>
                                                                    <th>Sources</th>
                                                                    <th>Deal Type</th>
                                                                    <th>Sales Type</th>
                                                                    <th>Created Date</th>
                                                                    <th>Previous Assigned To</th>
                                                                    <th>Reassigned To</th>
                                                                    <th>Reassignment Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="undoReassignmentsTableBody">
                                                                {{-- Populated by AJAX --}}
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3">
                                                        <div id="undoReassignmentsSelectionInfo"
                                                            class="text-muted small">0 reassignments selected</div>
                                                        <div class="text-muted small" id="undoReassignmentsCount">
                                                            Showing 4 previous reassignments</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
