
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
                                            <select class="primus-crm-form-control mb-3">
                                                <option value="">-- Select Team --</option>
                                                <option value="sales-rep" selected>Sales Rep</option>
                                                <option value="bdc-agent">BDC Agent</option>
                                                <option value="fi">F&I</option>
                                                <option value="sales-manager">Sales Manager</option>
                                                <option value="bdc-manager">BDC Manager</option>
                                                <option value="finance-director">Finance Director</option>
                                                <option value="general-sales-manager">General Sales Manager</option>
                                                <option value="general-manager">General Manager</option>
                                                <option value="dealer-principal">Dealer Principal</option>
                                                <option value="admin">Admin</option>
                                                <option value="reception">Reception</option>
                                                <option value="service-advisor">Service Advisor</option>
                                                <option value="service-manager">Service Manager</option>
                                                <option value="inventory-manager">Inventory Manager</option>
                                                <option value="fixed-operations-manager">Fixed Operations Manager
                                                </option>
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
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Allow users to view
                                                            other team members</div>
                                                        <div class="primus-crm-setting-desc">Team members can see
                                                            profiles of colleagues in their team</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Create new customers
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Permission to add new
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Edit customer
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">Modify existing
                                                            customer records</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Delete customers</div>
                                                        <div class="primus-crm-setting-desc">Remove customer records
                                                            from system</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
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
                                                        <!-- Sub-section Name -->
                                                        <div class="primus-crm-setting-name">Ability To Close
                                                            Showroom Visit</div>
                                                        <!-- Sub-section Description -->
                                                        <div class="primus-crm-setting-desc">

                                                            Controls visibility and access to showroom visit
                                                            records.
                                                        </div>
                                                    </div>
                                                    <!-- Toggle Switch -->
                                                    <div class="primus-crm-toggle-switch"
                                                        id="ability-close-showroom"></div>
                                                </div>
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // ===== Roles with default permission OFF =====
                                                    const rolesWithOffDefault = ["Sales Rep", "BDC Agent", "F&I", "Reception"];

                                                    // ===== Current User Role =====
                                                    // Replace this with your actual dynamic user role from backend or JS
                                                    const currentUserRole = window.currentUserRole || "Sales Manager";

                                                    // ===== Toggle Element =====
                                                    const toggle = document.getElementById("ability-close-showroom");

                                                    // ===== Set Default State Based on Role =====
                                                    // OFF for roles in rolesWithOffDefault, ON for others
                                                    if (rolesWithOffDefault.includes(currentUserRole)) {
                                                        toggle.classList.remove('active'); // OFF
                                                    } else {
                                                        toggle.classList.add('active'); // ON
                                                    }

                                                    // ===== Toggle Functionality on Click =====
                                                    toggle.addEventListener('click', function () {
                                                        this.classList.toggle('active');
                                                    });
                                                });
                                            </script>
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
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Modify inventory</div>
                                                        <div class="primus-crm-setting-desc">Edit vehicle details
                                                            and pricing</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Access pricing
                                                            information</div>
                                                        <div class="primus-crm-setting-desc">View cost and profit
                                                            margins</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
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
                                                    <div class="primus-crm-toggle-switch active"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">Export reports</div>
                                                        <div class="primus-crm-setting-desc">Download reports as
                                                            PDF/Excel</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
                                                </div>
                                                <div class="primus-crm-setting-row">
                                                    <div class="primus-crm-setting-info">
                                                        <div class="primus-crm-setting-name">View financial data
                                                        </div>
                                                        <div class="primus-crm-setting-desc">Access to revenue and
                                                            financial reports</div>
                                                    </div>
                                                    <div class="primus-crm-toggle-switch"
                                                        onclick="this.classList.toggle('active')"></div>
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
                                                <button class="primus-crm-btn primus-crm-btn-primary"
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
                                                // Create custom modal instances without backdrop
                                                const lostReasonModal = new bootstrap.Modal(document.getElementById('lostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                const deleteLostReasonModal = new bootstrap.Modal(document.getElementById('deleteLostReasonModal'), {
                                                    backdrop: false,
                                                    keyboard: true
                                                });

                                                // Modal elements
                                                const addLostReasonBtn = document.getElementById('addLostReasonBtn');
                                                const saveLostReasonBtn = document.getElementById('saveLostReasonBtn');
                                                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                                                const lostReasonInput = document.getElementById('lostReasonInput');
                                                const lostReasonModalLabel = document.getElementById('lostReasonModalLabel');
                                                const lostReasonToDelete = document.getElementById('lostReasonToDelete');

                                                // State variables
                                                let currentEditId = null;
                                                let currentDeleteId = null;

                                                // Initialize lost reasons
                                                initializeLostReasons();

                                                // Event listeners
                                                addLostReasonBtn.addEventListener('click', openAddModal);
                                                saveLostReasonBtn.addEventListener('click', saveLostReason);
                                                confirmDeleteBtn.addEventListener('click', confirmDelete);

                                                // Reset modal when hidden
                                                document.getElementById('lostReasonModal').addEventListener('hidden.bs.modal', function () {
                                                    currentEditId = null;
                                                    lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                    lostReasonInput.value = '';
                                                });

                                                // Close modals when clicking outside (since no backdrop)
                                                document.addEventListener('click', function (event) {
                                                    const lostReasonModalEl = document.getElementById('lostReasonModal');
                                                    const deleteLostReasonModalEl = document.getElementById('deleteLostReasonModal');

                                                    if (lostReasonModalEl.classList.contains('show') &&
                                                        !lostReasonModalEl.contains(event.target) &&
                                                        event.target !== addLostReasonBtn &&
                                                        !event.target.closest('.edit-lost-reason')) {
                                                        lostReasonModal.hide();
                                                    }

                                                    if (deleteLostReasonModalEl.classList.contains('show') &&
                                                        !deleteLostReasonModalEl.contains(event.target) &&
                                                        !event.target.closest('.delete-lost-reason')) {
                                                        deleteLostReasonModal.hide();
                                                    }
                                                });

                                                // Initialize lost reasons from localStorage or default values
                                                function initializeLostReasons() {
                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (!lostReasons) {
                                                        // Set default lost reasons
                                                        lostReasons = [
                                                            "Bad Credit",
                                                            "Bad Email",
                                                            "Bad Phone Number",
                                                            "Did Not Respond",
                                                            "Diff Dealer, Diff Brand",
                                                            "Diff Dealer, Same Brand",
                                                            "Diff Dealer, Same Group",
                                                            "Import Lead",
                                                            "No Agreement Reached",
                                                            "No Credit",
                                                            "No Longer Owns",
                                                            "Other Salesperson Lead",
                                                            "Out of Market",
                                                            "Requested No More Contact",
                                                            "Service Lead",
                                                            "Sold Privately"
                                                        ];
                                                        localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                    }

                                                    renderLostReasons(lostReasons);
                                                }

                                                // Render lost reasons list
                                                function renderLostReasons(reasons) {
                                                    const container = document.querySelector('.primus-crm-lost-reasons-list');
                                                    container.innerHTML = '';

                                                    if (reasons.length === 0) {
                                                        container.innerHTML = '<p class="primus-crm-no-data">No lost reasons configured</p>';
                                                        return;
                                                    }

                                                    reasons.forEach((reason, index) => {
                                                        const reasonElement = document.createElement('div');
                                                        reasonElement.className = 'primus-crm-lost-reason-item';
                                                        reasonElement.innerHTML = `
            <div class="primus-crm-lost-reason-text">${reason}</div>
            <div class="primus-crm-lost-reason-actions">
                <button class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline edit-lost-reason" data-id="${index}">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="primus-crm-btn primus-crm-btn-sm primus-crm-btn-outline-danger delete-lost-reason" data-id="${index}">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        `;
                                                        container.appendChild(reasonElement);
                                                    });

                                                    // Add event listeners to edit and delete buttons
                                                    document.querySelectorAll('.edit-lost-reason').forEach(button => {
                                                        button.addEventListener('click', function () {
                                                            const id = parseInt(this.getAttribute('data-id'));
                                                            openEditModal(id);
                                                        });
                                                    });

                                                    document.querySelectorAll('.delete-lost-reason').forEach(button => {
                                                        button.addEventListener('click', function () {
                                                            const id = parseInt(this.getAttribute('data-id'));
                                                            openDeleteModal(id);
                                                        });
                                                    });
                                                }

                                                // Open modal for adding a new reason
                                                function openAddModal() {
                                                    currentEditId = null;
                                                    lostReasonModalLabel.textContent = 'Add Lost Reason';
                                                    lostReasonInput.value = '';
                                                    lostReasonModal.show();
                                                    setTimeout(() => lostReasonInput.focus(), 100);
                                                }

                                                // Open modal for editing an existing reason
                                                function openEditModal(id) {
                                                    const lostReasons = JSON.parse(localStorage.getItem('lostReasons'));
                                                    currentEditId = id;
                                                    lostReasonModalLabel.textContent = 'Edit Lost Reason';
                                                    lostReasonInput.value = lostReasons[id];
                                                    lostReasonModal.show();
                                                    setTimeout(() => lostReasonInput.focus(), 100);
                                                }

                                                // Open modal for deleting a reason
                                                function openDeleteModal(id) {
                                                    const lostReasons = JSON.parse(localStorage.getItem('lostReasons'));
                                                    currentDeleteId = id;
                                                    lostReasonToDelete.textContent = lostReasons[id];
                                                    deleteLostReasonModal.show();
                                                }

                                                // Save a new or edited lost reason
                                                function saveLostReason() {
                                                    const reason = lostReasonInput.value.trim();

                                                    if (!reason) {
                                                        alert('Please enter a lost reason');
                                                        return;
                                                    }

                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (currentEditId === null) {
                                                        // Add new reason
                                                        lostReasons.push(reason);
                                                    } else {
                                                        // Edit existing reason
                                                        lostReasons[currentEditId] = reason;
                                                    }

                                                    localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                    renderLostReasons(lostReasons);
                                                    lostReasonModal.hide();
                                                }

                                                // Confirm deletion of a lost reason
                                                function confirmDelete() {
                                                    let lostReasons = JSON.parse(localStorage.getItem('lostReasons'));

                                                    if (currentDeleteId !== null) {
                                                        lostReasons.splice(currentDeleteId, 1);
                                                        localStorage.setItem('lostReasons', JSON.stringify(lostReasons));
                                                        renderLostReasons(lostReasons);
                                                    }

                                                    deleteLostReasonModal.hide();
                                                    currentDeleteId = null;
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