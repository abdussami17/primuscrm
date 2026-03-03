
                                    <!-- Permissions Tab -->
                                    <div class="tab-pane fade" id="permissions" role="tabpanel"
                                        aria-labelledby="permissions-tab">
                                        <div class="primus-crm-content-header">
                                            <h2 class="primus-crm-content-title">Role-Based Permissions</h2>
                                            <p class="primus-crm-content-description">Configure default permissions
                                                for user roles.</p>
                                        </div>
                                        <div class="primus-crm-form-group border-2 border rounded-3 p-3 mb-4">
                                            <label class="primus-crm-form-label">Configure Permissions For</label>
                                            <select class="primus-crm-form-control mb-3" id="roleSelector">
                                                <option value="">-- Select Role --</option>
                                            </select>




                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-users"></i></span>
                                                    Customer Management
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View all customers
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Access to view customer
                                                            records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Customers"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Allow users to view
                                                            other team members</div>
                                                        <div class="primus-crm-setting-desc">Team members can see
                                                            profiles of colleagues in their team</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Team Members"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Create new customers
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Permission to add new
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="Create Customer"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Edit customer
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">Modify existing
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="Edit Customer"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Delete customers</div>
                                                        <div class="primus-crm-setting-desc">Remove customer records
                                                            from system</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="Delete Customer"></div>
                                                </div>
                                            </div>
                                            <!-- ================= Showroom Visits Section ================= -->
                                            <div class="primus-crm-settings-section">
                                                <!-- Section Title -->
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-users"></i></span>
                                                    Showroom Visits
                                                </h3>

                                                <!-- Sub-Section: Ability To Close Showroom Visit -->
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Ability To Close
                                                            Showroom Visit</div>
                                                        <div class="primus-crm-setting-desc">

                                                            Controls visibility and access to showroom visit
                                                            records.
                                                        </div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle"
                                                        data-permission="Close Showroom Visit"></div>
                                                </div>
                                            </div>

                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-warehouse"></i></span>
                                                    Inventory Management
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View inventory</div>
                                                        <div class="primus-crm-setting-desc">Access to browse
                                                            inventory listings</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Inventory"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Modify inventory</div>
                                                        <div class="primus-crm-setting-desc">Edit vehicle details
                                                            and pricing</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="Edit Inventory"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Access pricing
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">View cost and profit
                                                            margins</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Pricing"></div>
                                                </div>
                                            </div>
                                            <div class="primus-crm-settings-section">
                                                <h3 class="primus-crm-section-title">
                                                    <span class="primus-crm-section-icon"><i
                                                            class="fas fa-chart-bar"></i></span>
                                                    Reports & Analytics
                                                </h3>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View reports</div>
                                                        <div class="primus-crm-setting-desc">Access to standard
                                                            reports and dashboards</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Reports"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Export reports</div>
                                                        <div class="primus-crm-setting-desc">Download reports as
                                                            PDF/Excel</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="Export Reports"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View financial data
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Access to revenue and
                                                            financial reports</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch permission-toggle" 
                                                        data-permission="View Financial Data"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Lost Reasons Management Section -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-ban"></i></span>
                                                Sub-Lost Lead Reasons Management
                                            </h3>

                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Manage Lost Reasons</div>
                                                    <div class="primus-crm-setting-desc">Add, edit, or remove
                                                        reasons for lost sales opportunities</div>
                                                </div>
                                                    <button type="button" class="primus-crm-btn primus-crm-btn-primary"
                                                        id="addLostReasonBtn">
                                                    <i class="fas fa-plus"></i> Add New Reason
                                                </button>
                                            </div>

                                            <div class="primus-crm-lost-reasons-list">
                                                <!-- Lost reasons will be dynamically populated here -->
                                            </div>
                                        </div>

                                        <!-- Add/Edit Lost Reason Modal -->
                                        <div class="modal" id="lostReasonModal" tabindex="-1"
                                            aria-labelledby="lostReasonModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="lostReasonModalLabel">Add Lost
                                                            Reason</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="primus-crm-form-group">
                                                            <label class="primus-crm-form-label">Lost Reason</label>
                                                            <input type="text" class="primus-crm-form-control"
                                                                id="lostReasonInput"
                                                                placeholder="Enter lost reason">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-primary"
                                                            id="saveLostReasonBtn">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal" id="deleteLostReasonModal" tabindex="-1"
                                            aria-labelledby="deleteLostReasonModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteLostReasonModalLabel">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete "<span
                                                                id="lostReasonToDelete"></span>"?</p>
                                                        <p class="text-danger">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                            class="primus-crm-btn primus-crm-btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button"
                                                                class="primus-crm-btn primus-crm-btn-danger"
                                                                id="confirmDeleteBtn">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const CSRF = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                                // No backdrop on either modal — avoids page-blocking overlays
                                                const lostReasonModal = new bootstrap.Modal(document.getElementById('lostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                const deleteLostReasonModal = new bootstrap.Modal(document.getElementById('deleteLostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                const addLostReasonBtn    = document.getElementById('addLostReasonBtn');
                                                const saveLostReasonBtn   = document.getElementById('saveLostReasonBtn');
                                                const confirmDeleteBtn    = document.getElementById('confirmDeleteBtn');
                                                const lostReasonInput     = document.getElementById('lostReasonInput');
                                                const lostReasonModalLabel= document.getElementById('lostReasonModalLabel');
                                                const lostReasonToDelete  = document.getElementById('lostReasonToDelete');

                                                // Snapshot of edit/delete id captured per-operation (no race with hidden.bs.modal)
                                                let currentEditId   = null;
                                                let currentDeleteId = null;
                                                let saveInFlight    = false;
                                                let deleteInFlight  = false;

                                                initializeLostReasons();

                                                // ── Button listeners ──────────────────────────────────────────────
                                                addLostReasonBtn.addEventListener('click', function(ev) {
                                                    ev.preventDefault(); ev.stopPropagation();
                                                    openAddModal();
                                                });

                                                saveLostReasonBtn.addEventListener('click', function(ev) {
                                                    ev.preventDefault(); ev.stopPropagation();
                                                    saveLostReason();
                                                });

                                                confirmDeleteBtn.addEventListener('click', function(ev) {
                                                    ev.preventDefault(); ev.stopPropagation();
                                                    confirmDelete();
                                                });

                                                // Enter inside the input triggers save (not a form submit)
                                                lostReasonInput.addEventListener('keydown', function(e) {
                                                    if (e.key === 'Enter') { e.preventDefault(); saveLostReason(); }
                                                });

                                                // Reset add/edit modal state when it is fully hidden
                                                document.getElementById('lostReasonModal').addEventListener('hidden.bs.modal', function () {
                                                    // Only reset when NOT in the middle of a programmatic save
                                                    if (!saveInFlight) {
                                                        currentEditId = null;
                                                        lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                        lostReasonInput.value = '';
                                                    }
                                                });

                                                // ── Data ─────────────────────────────────────────────────────────
                                                async function initializeLostReasons() {
                                                    try {
                                                        const resp = await fetch('/settings/lost-reasons', { credentials: 'same-origin' });
                                                        if (!resp.ok) throw new Error('Failed to load');
                                                        renderLostReasons(await resp.json());
                                                    } catch (e) {
                                                        console.error('Failed to fetch lost reasons', e);
                                                        renderLostReasons([
                                                            { id: null, name: "Bad Credit" },
                                                            { id: null, name: "Bad Email" },
                                                            { id: null, name: "Bad Phone Number" },
                                                            { id: null, name: "Did Not Respond" },
                                                            { id: null, name: "Diff Dealer, Diff Brand" },
                                                            { id: null, name: "Diff Dealer, Same Brand" },
                                                            { id: null, name: "Diff Dealer, Same Group" },
                                                            { id: null, name: "Import Lead" },
                                                            { id: null, name: "No Agreement Reached" },
                                                            { id: null, name: "No Credit" },
                                                            { id: null, name: "No Longer Owns" },
                                                            { id: null, name: "Other Salesperson Lead" },
                                                            { id: null, name: "Out of Market" },
                                                            { id: null, name: "Requested No More Contact" },
                                                            { id: null, name: "Service Lead" },
                                                            { id: null, name: "Sold Privately" }
                                                        ]);
                                                    }
                                                }

                                                function renderLostReasons(items) {
                                                    const container = document.querySelector('.primus-crm-lost-reasons-list');
                                                    container.innerHTML = '';

                                                    if (!items || items.length === 0) {
                                                        container.innerHTML = '<p class="primus-crm-no-data">No lost reasons configured</p>';
                                                        return;
                                                    }

                                                    items.forEach(function(item) {
                                                        const el = document.createElement('div');
                                                        el.className = 'primus-crm-lost-reason-item';
                                                        const safe = (item.name || '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;');
                                                        const id   = item.id || '';
                                                        el.innerHTML = `
            <div class="primus-crm-lost-reason-text">${safe}</div>
            <div class="primus-crm-lost-reason-actions">
                <button type="button" class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline edit-lost-reason"
                    data-id="${id}" data-name="${safe}"><i class="fas fa-edit"></i> Edit</button>
                <button type="button" class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline-danger delete-lost-reason"
                    data-id="${id}" data-name="${safe}"><i class="fas fa-trash"></i> Delete</button>
            </div>`;
                                                        container.appendChild(el);
                                                    });

                                                    // Use container-level delegation — no per-button listener accumulation
                                                    container.querySelectorAll('.edit-lost-reason').forEach(function(btn) {
                                                        btn.addEventListener('click', function(ev) {
                                                            ev.preventDefault(); ev.stopPropagation();
                                                            openEditModalById(this.dataset.id, this.dataset.name);
                                                        });
                                                    });

                                                    container.querySelectorAll('.delete-lost-reason').forEach(function(btn) {
                                                        btn.addEventListener('click', function(ev) {
                                                            ev.preventDefault(); ev.stopPropagation();
                                                            openDeleteModalById(this.dataset.id, this.dataset.name);
                                                        });
                                                    });
                                                }

                                                // ── Modal openers ────────────────────────────────────────────────
                                                function openAddModal() {
                                                    currentEditId = null;
                                                    lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                    lostReasonInput.value = '';
                                                    lostReasonModal.show();
                                                    setTimeout(function(){ lostReasonInput.focus(); }, 150);
                                                }

                                                function openEditModalById(id, name) {
                                                    currentEditId = id ? parseInt(id, 10) : null;
                                                    lostReasonModalLabel.textContent = 'Edit Lost Reason';
                                                    lostReasonInput.value = name || '';
                                                    lostReasonModal.show();
                                                    setTimeout(function(){ lostReasonInput.focus(); }, 150);
                                                }

                                                function openDeleteModalById(id, name) {
                                                    currentDeleteId = id ? parseInt(id, 10) : null;
                                                    lostReasonToDelete.textContent = name || '';
                                                    deleteLostReasonModal.show();
                                                    // Scroll the delete modal into the current viewport
                                                    setTimeout(function() {
                                                        const el = document.getElementById('deleteLostReasonModal');
                                                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                                    }, 150);
                                                }

                                                // ── Save (create or update) ───────────────────────────────────────
                                                async function saveLostReason() {
                                                    if (saveInFlight) return;

                                                    const reason = lostReasonInput.value.trim();
                                                    if (!reason) { alert('Please enter a lost reason'); return; }

                                                    // Snapshot the edit id NOW before any async work
                                                    const editId = currentEditId;

                                                    saveInFlight = true;
                                                    saveLostReasonBtn.disabled = true;

                                                    try {
                                                        if (editId === null) {
                                                            // ── CREATE ──
                                                            const resp = await fetch('/settings/lost-reasons', {
                                                                method: 'POST',
                                                                credentials: 'same-origin',
                                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
                                                                body: JSON.stringify({ name: reason })
                                                            });
                                                            if (!resp.ok) throw new Error('Failed to create (status ' + resp.status + ')');
                                                        } else {
                                                            // ── UPDATE ──
                                                            const resp = await fetch('/settings/lost-reasons/' + editId, {
                                                                method: 'PUT',
                                                                credentials: 'same-origin',
                                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
                                                                body: JSON.stringify({ name: reason })
                                                            });
                                                            if (!resp.ok) throw new Error('Failed to update (status ' + resp.status + ')');
                                                        }

                                                        currentEditId = null;
                                                        lostReasonInput.value = '';
                                                        lostReasonModal.hide();
                                                        await initializeLostReasons();
                                                    } catch (e) {
                                                        console.error(e);
                                                        alert('Save failed: ' + e.message);
                                                    } finally {
                                                        saveInFlight = false;
                                                        saveLostReasonBtn.disabled = false;
                                                    }
                                                }

                                                // ── Delete ────────────────────────────────────────────────────────
                                                async function confirmDelete() {
                                                    if (deleteInFlight) return;
                                                    if (currentDeleteId === null) { deleteLostReasonModal.hide(); return; }

                                                    const deleteId = currentDeleteId;
                                                    deleteInFlight = true;
                                                    confirmDeleteBtn.disabled = true;

                                                    try {
                                                        const resp = await fetch('/settings/lost-reasons/' + deleteId, {
                                                            method: 'DELETE',
                                                            credentials: 'same-origin',
                                                            headers: { 'X-CSRF-TOKEN': CSRF() }
                                                        });
                                                        if (!resp.ok) throw new Error('Delete failed (status ' + resp.status + ')');

                                                        currentDeleteId = null;
                                                        deleteLostReasonModal.hide();
                                                        await initializeLostReasons();
                                                    } catch (e) {
                                                        console.error(e);
                                                        alert('Delete failed: ' + e.message);
                                                    } finally {
                                                        deleteInFlight = false;
                                                        confirmDeleteBtn.disabled = false;
                                                    }
                                                }
                                            });
                                        </script>

                                        <style>
                                            .primus-crm-lost-reasons-list {
                                                margin-top: 20px;
                                                border: 1px solid #e0e0e0;
                                                border-radius: 8px;
                                                overflow: hidden;
                                            }

                                            .primus-crm-lost-reason-item {
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: center;
                                                padding: 12px 16px;
                                                border-bottom: 1px solid #f0f0f0;
                                                transition: background-color 0.2s;
                                            }

                                            .primus-crm-lost-reason-item:hover {
                                                background-color: #f9f9f9;
                                            }

                                            .primus-crm-lost-reason-item:last-child {
                                                border-bottom: none;
                                            }

                                            .primus-crm-lost-reason-text {
                                                flex: 1;
                                                font-weight: 500;
                                            }

                                            .primus-crm-lost-reason-actions {
                                                display: flex;
                                                gap: 8px;
                                            }

                                            .primus-crm-no-data {
                                                text-align: center;
                                                padding: 20px;
                                                color: #6c757d;
                                                font-style: italic;
                                            }

                                            /* Button Styles */
                                            .primus-crm-btn {
                                                display: inline-flex;
                                                align-items: center;
                                                justify-content: center;
                                                gap: 6px;
                                                padding: 8px 16px;
                                                border: none;
                                                border-radius: 4px;
                                                font-size: 0.875rem;
                                                font-weight: 500;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                                text-decoration: none;
                                            }

                                            .primus-crm-btn-primary {
                                                background-color: #007bff;
                                                color: white;
                                            }

                                            .primus-crm-btn-primary:hover {
                                                background-color: #0069d9;
                                            }

                                            .primus-crm-btn-secondary {
                                                background-color: #6c757d;
                                                color: white;
                                            }

                                            .primus-crm-btn-secondary:hover {
                                                background-color: #5a6268;
                                            }

                                            .primus-crm-btn-danger {
                                                background-color: #dc3545;
                                                color: white;
                                            }

                                            .primus-crm-btn-danger:hover {
                                                background-color: #c82333;
                                            }

                                            .primus-crm-btn-outline {
                                                background-color: transparent;
                                                border: 1px solid #007bff;
                                                color: #007bff;
                                            }

                                            .primus-crm-btn-outline:hover {
                                                background-color: #007bff;
                                                color: white;
                                            }

                                            .primus-crm-btn-outline-danger {
                                                background-color: transparent;
                                                border: 1px solid #dc3545;
                                                color: #dc3545;
                                            }

                                            .primus-crm-btn-outline-danger:hover {
                                                background-color: #dc3545;
                                                color: white;
                                            }

                                            .primus-crm-btn-sm {
                                                padding: 6px 12px;
                                                font-size: 0.8rem;
                                            }

                                            .text-danger {
                                                color: #dc3545;
                                            }
                                        </style>


                                        <!-- Speed to Sale Settings Section -->
                                        <div class="primus-crm-settings-section">
                                            <h3 class="primus-crm-section-title">
                                                <span class="primus-crm-section-icon"><i
                                                        class="fas fa-bolt"></i></span>
                                                Speed to Sale
                                            </h3>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Speed to Lead Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from lead
                                                        received to first response</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="speedToLead" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Follow-up Time Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from first
                                                        response to appointment booked</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="followUpTime" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                            <div class="primus-crm-setting-row">
                                                <div class="primus-crm-setting-info">
                                                    <div class="primus-crm-setting-name">Conversion Time Target
                                                        (minutes)</div>
                                                    <div class="primus-crm-setting-desc">Target time from
                                                        appointment booked to sold</div>
                                                </div>
                                                <div class="primus-crm-form-group" style="width: 150px; margin: 0;">
                                                    <input type="number"
                                                        class="primus-crm-form-control speed-target-input"
                                                        data-target="conversionTime" placeholder="Enter minutes"
                                                        min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Save Changes Button -->

                                    </div>

                                    <!-- Permission Management Script -->
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const roleSelector = document.getElementById('roleSelector');
                                            const permissionToggles = document.querySelectorAll('.permission-toggle');
                                            let currentRoleId = null;
                                            let isLoading = false;

                                            // Load all roles on page load
                                            loadRoles();

                                            // Role selector change event
                                            roleSelector.addEventListener('change', function() {
                                                const roleId = this.value;
                                                if (roleId) {
                                                    currentRoleId = roleId;
                                                    loadRolePermissions(roleId);
                                                } else {
                                                    // Reset all toggles when no role selected
                                                    currentRoleId = null;
                                                    permissionToggles.forEach(toggle => {
                                                        toggle.classList.remove('active');
                                                    });
                                                }
                                            });

                                            // Permission toggle click events
                                            permissionToggles.forEach(toggle => {
                                                toggle.addEventListener('click', function() {
                                                    // Prevent duplicate clicks on the same toggle while updating
                                                    if (this.dataset.loading === '1') return;

                                                    if (isLoading || !currentRoleId) {
                                                        if (!currentRoleId) {
                                                            alert('Please select a role first');
                                                        }
                                                        return;
                                                    }

                                                    const permission = this.dataset.permission;
                                                    const isActive = this.classList.contains('active');
                                                    const newState = !isActive;

                                                    // Optimistically update UI
                                                    if (newState) {
                                                        this.classList.add('active');
                                                    } else {
                                                        this.classList.remove('active');
                                                    }

                                                    // Mark this toggle as loading to prevent double submits
                                                    this.dataset.loading = '1';
                                                    this.style.pointerEvents = 'none';

                                                    // Save to backend
                                                    togglePermission(currentRoleId, permission, newState, this);
                                                });
                                            });

                                            /**
                                             * Load all roles from backend
                                             */
                                            async function loadRoles() {
                                                try {
                                                    const response = await fetch('/settings/roles');
                                                    if (!response.ok) throw new Error('Failed to load roles');
                                                    
                                                    const roles = await response.json();
                                                    
                                                    // Clear existing options except placeholder
                                                    roleSelector.innerHTML = '<option value="">-- Select Role --</option>';
                                                    
                                                    // Populate roles
                                                    roles.forEach(role => {
                                                        const option = document.createElement('option');
                                                        option.value = role.id;
                                                        option.textContent = role.name;
                                                        roleSelector.appendChild(option);
                                                    });
                                                } catch (error) {
                                                    console.error('Error loading roles:', error);
                                                    alert('Failed to load roles. Please refresh the page.');
                                                }
                                            }

                                            /**
                                             * Load permissions for a specific role
                                             */
                                            async function loadRolePermissions(roleId) {
                                                isLoading = true;
                                                
                                                try {
                                                    const response = await fetch(`/settings/roles/${roleId}/permissions`);
                                                    if (!response.ok) throw new Error('Failed to load permissions');
                                                    
                                                    const data = await response.json();
                                                    const rolePermissions = data.permissions || [];
                                                    
                                                    // Update all toggles based on role permissions
                                                    permissionToggles.forEach(toggle => {
                                                        const permission = toggle.dataset.permission;
                                                        if (rolePermissions.includes(permission)) {
                                                            toggle.classList.add('active');
                                                        } else {
                                                            toggle.classList.remove('active');
                                                        }
                                                    });
                                                } catch (error) {
                                                    console.error('Error loading role permissions:', error);
                                                    alert('Failed to load permissions for this role.');
                                                } finally {
                                                    isLoading = false;
                                                }
                                            }

                                            /**
                                             * Toggle a single permission for the current role
                                             */
                                            async function togglePermission(roleId, permission, enabled, toggleElement) {
                                                try {
                                                    const response = await fetch(`/settings/roles/${roleId}/permissions/toggle`, {
                                                        method: 'POST',
                                                        credentials: 'same-origin',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        },
                                                        body: JSON.stringify({
                                                            permission: permission,
                                                            enabled: enabled
                                                        })
                                                    });

                                                    // If server returned an error status, attempt to read body for debugging
                                                    if (!response.ok) {
                                                        let errText = '';
                                                        try { errText = await response.text(); } catch (e) { errText = response.statusText; }
                                                        // Provide clearer messages for common statuses
                                                        if (response.status === 419) {
                                                            throw new Error('CSRF token mismatch (status 419). Please refresh the page and try again.');
                                                        }
                                                        if (response.status === 401) {
                                                            throw new Error('Not authenticated (status 401). Please login and try again.');
                                                        }
                                                        if (response.status === 403) {
                                                            throw new Error('Permission denied (status 403). You may not have access to change role permissions.');
                                                        }
                                                        throw new Error('Failed to update permission: ' + (errText || response.status));
                                                    }

                                                    // Only parse JSON when content-type is JSON. Some responses (redirects/html) break response.json()
                                                    const contentType = (response.headers.get('content-type') || '').toLowerCase();
                                                    if (contentType.includes('application/json')) {
                                                        try {
                                                            const result = await response.json();
                                                            // Optional: check result.success or other flags here
                                                        } catch (e) {
                                                            console.warn('Permission toggle: failed to parse JSON response', e);
                                                        }
                                                    } else {
                                                        // Non-JSON but successful (e.g., plain text) — read for logging but treat as success
                                                        try {
                                                            const txt = await response.text();
                                                            console.warn('Permission toggle: non-JSON response:', txt);
                                                        } catch (e) {
                                                            console.warn('Permission toggle: could not read non-JSON response', e);
                                                        }
                                                    }

                                                } catch (error) {
                                                    console.error('Error toggling permission:', error);

                                                    // Revert UI on error
                                                    if (enabled) {
                                                        toggleElement.classList.remove('active');
                                                    } else {
                                                        toggleElement.classList.add('active');
                                                    }

                                                    alert('Failed to update permission. Please try again.');
                                                } finally {
                                                    // Clear loading flag and re-enable clicks
                                                    try {
                                                        if (toggleElement) {
                                                            delete toggleElement.dataset.loading;
                                                            toggleElement.style.pointerEvents = '';
                                                        }
                                                    } catch (e) {
                                                        // ignore
                                                    }
                                                }
                                            }
                                        });
                                    </script>