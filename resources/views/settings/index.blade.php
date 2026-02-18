@extends('layouts.app')


@section('title', 'Settings')


@section('content')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple toast container
            let toastContainer = document.getElementById('primusToastContainer');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'primusToastContainer';
                toastContainer.style.position = 'fixed';
                toastContainer.style.top = '1rem';
                toastContainer.style.right = '1rem';
                toastContainer.style.zIndex = 2000;
                document.body.appendChild(toastContainer);
            }

            function showToast(message, variant = 'success', timeout = 3000) {
                const el = document.createElement('div');
                el.className = 'primus-crm-toast';
                el.style.marginBottom = '0.5rem';
                el.style.padding = '0.75rem 1rem';
                el.style.borderRadius = '8px';
                el.style.minWidth = '220px';
                el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
                el.style.color = '#fff';
                el.style.fontWeight = '600';
                el.style.opacity = '0';
                el.style.transition = 'all 0.25s ease';
                if (variant === 'success') el.style.background = 'linear-gradient(90deg,#10B981,#059669)';
                else if (variant === 'error') el.style.background = 'linear-gradient(90deg,#EF4444,#DC2626)';
                else el.style.background = '#333';
                el.textContent = message;
                toastContainer.appendChild(el);
                // force reflow
                void el.offsetWidth;
                el.style.transform = 'translateY(0)';
                el.style.opacity = '1';
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 300);
                }, timeout);
            }

            const form = document.getElementById('dealershipInfoForm');
            if (!form) return;

            // Prevent double-binding if script runs twice
            if (form.dataset.primusListenerAttached) return;
            form.dataset.primusListenerAttached = '1';

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;
                const data = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: data
                    }).then(res => res.json())
                    .then(json => {
                        if (submitBtn) submitBtn.disabled = false;
                        if (json && json.success) {
                            showToast('Saved successfully', 'success');
                            // keep existing behavior: reload to reflect saved values
                            setTimeout(() => window.location.reload(), 700);
                        } else {
                            showToast('Failed to save', 'error');
                        }
                    }).catch(err => {
                        if (submitBtn) submitBtn.disabled = false;
                        showToast('Error saving settings', 'error');
                        console.error(err);
                    });
            });
        });
    </script>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4" id="confirmationModalBody">
                    <!-- Dynamic content -->
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4" id="successModalBody">
                    Operation completed successfully.
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Setting Code main Start --}}

    <div class="content">

        <!-- start row -->
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="primus-crm-container">
                    <div class="primus-crm-layout">
                        <aside class="primus-crm-sidebar">
                            <div class="primus-crm-search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="primusCrmSearchInput" placeholder="Search settings...">
                            </div>

                            <!-- Bootstrap Tabs Navigation -->
                            <ul class="nav nav-tabs flex-column" id="primusCrmSettingsNav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="contact-info-tab" data-bs-toggle="tab"
                                        data-bs-target="#contact-info" type="button" role="tab"
                                        aria-controls="contact-info" aria-selected="true">
                                        <i class="fas fa-cog me-2"></i>Dealership Contact Information
                                    </button>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ip-restrictions-tab" data-bs-toggle="tab"
                                        data-bs-target="#ip-restrictions" type="button" role="tab"
                                        aria-controls="ip-restrictions" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>IP Restrictions
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notifications-tab" data-bs-toggle="tab"
                                        data-bs-target="#notifications" type="button" role="tab"
                                        aria-controls="notifications" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>Notification Center
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="store-hours-tab" data-bs-toggle="tab"
                                        data-bs-target="#store-hours" type="button" role="tab"
                                        aria-controls="store-hours" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>Store Hours
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                        data-bs-target="#security" type="button" role="tab"
                                        aria-controls="security" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>Store Security
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="merge-sold-deals-tab" data-bs-toggle="tab"
                                        data-bs-target="#mergesolddeals" type="button" role="tab"
                                        aria-controls="mergesolddeals" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>Merge Sold Deals
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="permissions-tab" data-bs-toggle="tab"
                                        data-bs-target="#permissions" type="button" role="tab"
                                        aria-controls="permissions" aria-selected="false">
                                        <i class="fas fa-cog me-2"></i>Team/Role Based Permissions
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="email-account-tab" data-bs-toggle="tab"
                                        data-bs-target="#email-account" type="button" role="tab"
                                        aria-controls="email-account" aria-selected="false">
                                        <i class="fas fa-envelope me-2"></i>Email/Lead Account Setup
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex justify-content-between align-items-start"
                                        id="email-footer-tab" data-bs-toggle="tab"
                                        data-bs-target="#email-footer-configuration-tab" type="button" role="tab"
                                        aria-controls="email-account" aria-selected="false">
                                        <i class="fas fa-envelope me-2 mt-1"></i><span>Email Header/Footer
                                            Configuration</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="bulk-delete" data-bs-toggle="tab"
                                        data-bs-target="#bulk-task-tab" type="button" role="tab"
                                        aria-controls="bulk-delete" aria-selected="false">
                                        <i class="fas fa-user me-2 mt-1"></i><span>Bulk Task
                                            Delete/Undelete</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="bulklead-delete" data-bs-toggle="tab"
                                        data-bs-target="#bulk-leads-tab" type="button" role="tab"
                                        aria-controls="bulk-delete" aria-selected="false">
                                        <i class="fas fa-user me-2 mt-1"></i><span>Bulk Lead Delete/Undelete
                                        </span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="bulkreassign-delete" data-bs-toggle="tab"
                                        data-bs-target="#customer-reassignment-tab" type="button" role="tab"
                                        aria-controls="bulk-delete" aria-selected="false">
                                        <i class="fas fa-user me-2 mt-1"></i><span>Customer Reassignment
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </aside>

                        <main class="primus-crm-main-content">
                            <!-- Bootstrap Tab Content -->
                            <div class="tab-content" id="primusCrmContentArea">



                                @include('settings.bulk-tasks')
                                @include('settings.notification')
                                @include('settings.bulk-delete')
                                @include('settings.customer-reassignment')
                                @include('settings.ip-restriction')
                                @include('settings.email-setup')
                                @include('settings.email-configuration')
                                @include('settings.merge-sold-deals')
                                @include('settings.store-hours')
                                @include('settings.store-security')
                                @include('settings.teams-permissions')
                                @include('settings.dealership-info')


                                


                                <!-- Modals (keep existing modals) -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1"
                                    aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmationModalLabel">Confirmation
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="confirmationModalBody">
                                                <!-- Content will be inserted here -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn"
                                                    id="confirmActionBtn">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="successModal" tabindex="-1"
                                    aria-labelledby="successModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="successModalLabel">Success</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="successModalBody">
                                                Action completed successfully.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));

                                        // Generic function to handle checkbox selection and button enable/disable
                                        function setupTableSelection(tableBodyId, selectAllId, selectionInfoId, actionBtnId) {
                                            const tableBody = document.getElementById(tableBodyId);
                                            const selectAll = document.getElementById(selectAllId);
                                            const selectionInfo = document.getElementById(selectionInfoId);
                                            const actionBtn = document.getElementById(actionBtnId);

                                            function updateSelection() {
                                                const checkboxes = tableBody.querySelectorAll('.row-checkbox');
                                                const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                                                selectionInfo.textContent = `${checkedCount} selected`;
                                                actionBtn.disabled = checkedCount === 0;
                                                selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
                                            }

                                            tableBody.addEventListener('change', function(e) {
                                                if (e.target.classList.contains('row-checkbox')) updateSelection();
                                            });

                                            selectAll.addEventListener('change', function() {
                                                const checkboxes = tableBody.querySelectorAll('.row-checkbox');
                                                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                                                updateSelection();
                                            });

                                            updateSelection(); // initial
                                        }

                                        // Task Delete
                                        setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo', 'deleteTasksBtn');

                                        document.getElementById('deleteTasksBtn').addEventListener('click', function() {
                                            const checkedCount = document.querySelectorAll('#tasksTableBody .row-checkbox:checked')
                                                .length;
                                            document.getElementById('confirmationModalBody').innerHTML =
                                                `Are you sure you want to <strong>delete</strong> ${checkedCount} selected task(s)?`;
                                            document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                            confirmationModal.show();

                                            document.getElementById('confirmActionBtn').onclick = function() {
                                                document.querySelectorAll('#tasksTableBody .row-checkbox:checked').forEach(cb => {
                                                    cb.closest('tr').remove();
                                                });
                                                confirmationModal.hide();
                                                successModal.show();
                                                setupTableSelection('tasksTableBody', 'selectAllTasks', 'tasksSelectionInfo',
                                                    'deleteTasksBtn');
                                                document.getElementById('tasksCount').textContent =
                                                    `Showing ${document.querySelectorAll('#tasksTableBody tr').length} tasks`;
                                            };
                                        });

                                        // Task Undelete
                                        setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks', 'deletedTasksSelectionInfo',
                                            'undeleteTasksBtn');

                                        document.getElementById('undeleteTasksBtn').addEventListener('click', function() {
                                            const checkedCount = document.querySelectorAll(
                                                '#deletedTasksTableBody .row-checkbox:checked').length;
                                            document.getElementById('confirmationModalBody').innerHTML =
                                                `Are you sure you want to <strong>restore</strong> ${checkedCount} selected task(s)?`;
                                            document.getElementById('confirmActionBtn').className = 'btn btn-success';
                                            confirmationModal.show();

                                            document.getElementById('confirmActionBtn').onclick = function() {
                                                document.querySelectorAll('#deletedTasksTableBody .row-checkbox:checked').forEach(
                                                    cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                confirmationModal.hide();
                                                successModal.show();
                                                setupTableSelection('deletedTasksTableBody', 'selectAllDeletedTasks',
                                                    'deletedTasksSelectionInfo', 'undeleteTasksBtn');
                                                document.getElementById('deletedTasksCount').textContent =
                                                    `Showing ${document.querySelectorAll('#deletedTasksTableBody tr').length} deleted tasks`;
                                            };
                                        });

                                        // Leads Delete
                                        setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo', 'deleteLeadsBtn');

                                        document.getElementById('deleteLeadsBtn').addEventListener('click', function() {
                                            const checkedCount = document.querySelectorAll('#leadsTableBody .row-checkbox:checked')
                                                .length;
                                            document.getElementById('confirmationModalBody').innerHTML =
                                                `Are you sure you want to <strong>delete</strong> ${checkedCount} selected lead(s)/deal(s)?`;
                                            document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                            confirmationModal.show();

                                            document.getElementById('confirmActionBtn').onclick = function() {
                                                document.querySelectorAll('#leadsTableBody .row-checkbox:checked').forEach(cb => {
                                                    cb.closest('tr').remove();
                                                });
                                                confirmationModal.hide();
                                                successModal.show();
                                                setupTableSelection('leadsTableBody', 'selectAllLeads', 'leadsSelectionInfo',
                                                    'deleteLeadsBtn');
                                                document.getElementById('leadsCount').textContent =
                                                    `Showing ${document.querySelectorAll('#leadsTableBody tr').length} leads`;
                                            };
                                        });

                                        // Leads Undelete
                                        setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads', 'deletedLeadsSelectionInfo',
                                            'undeleteLeadsBtn');

                                        document.getElementById('undeleteLeadsBtn').addEventListener('click', function() {
                                            const checkedCount = document.querySelectorAll(
                                                '#deletedLeadsTableBody .row-checkbox:checked').length;
                                            document.getElementById('confirmationModalBody').innerHTML =
                                                `Are you sure you want to <strong>restore</strong> ${checkedCount} selected lead(s)/deal(s)?`;
                                            document.getElementById('confirmActionBtn').className = 'btn btn-success';
                                            confirmationModal.show();

                                            document.getElementById('confirmActionBtn').onclick = function() {
                                                document.querySelectorAll('#deletedLeadsTableBody .row-checkbox:checked').forEach(
                                                    cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                confirmationModal.hide();
                                                successModal.show();
                                                setupTableSelection('deletedLeadsTableBody', 'selectAllDeletedLeads',
                                                    'deletedLeadsSelectionInfo', 'undeleteLeadsBtn');
                                                document.getElementById('deletedLeadsCount').textContent =
                                                    `Showing ${document.querySelectorAll('#deletedLeadsTableBody tr').length} deleted leads`;
                                            };
                                        });

                                        // Customer Reassignment
                                        setupTableSelection('customersTableBody', 'selectAllCustomers', 'customersSelectionInfo',
                                            'reassignCustomersBtn');

                                        // Undo Reassignment
                                        setupTableSelection('undoReassignmentsTableBody', 'selectAllUndoReassignments',
                                            'undoReassignmentsSelectionInfo', 'undoReassignBtn');

                                        document.getElementById('undoReassignBtn').addEventListener('click', function() {
                                            const checkedCount = document.querySelectorAll(
                                                '#undoReassignmentsTableBody .row-checkbox:checked').length;
                                            document.getElementById('confirmationModalBody').innerHTML =
                                                `Are you sure you want to <strong>undo</strong> ${checkedCount} selected reassignment(s)?`;
                                            document.getElementById('confirmActionBtn').className = 'btn btn-danger';
                                            confirmationModal.show();

                                            document.getElementById('confirmActionBtn').onclick = function() {
                                                document.querySelectorAll('#undoReassignmentsTableBody .row-checkbox:checked')
                                                    .forEach(cb => {
                                                        cb.closest('tr').remove();
                                                    });
                                                confirmationModal.hide();
                                                successModal.show();
                                                setupTableSelection('undoReassignmentsTableBody', 'selectAllUndoReassignments',
                                                    'undoReassignmentsSelectionInfo', 'undoReassignBtn');
                                                document.getElementById('undoReassignmentsCount').textContent =
                                                    `Showing ${document.querySelectorAll('#undoReassignmentsTableBody tr').length} previous reassignments`;
                                            };
                                        });

                                        // Refresh buttons (just reset selection)
                                        document.querySelectorAll('[id^="refresh"]').forEach(btn => {
                                            btn.addEventListener('click', function() {
                                                const tableId = this.id.replace('refresh', '').replace('Btn', '').toLowerCase();
                                                const checkboxes = document.querySelectorAll(
                                                    `#${tableId}TableBody .row-checkbox, #selectAll${tableId.charAt(0).toUpperCase() + tableId.slice(1)}`
                                                    );
                                                checkboxes.forEach(cb => cb.checked = false);
                                                const actionBtn = document.querySelector(
                                                    `#${this.id.replace('refresh', '').replace('Btn', '').toLowerCase()}Btn`
                                                    ) || this;
                                                if (actionBtn.id.includes('delete') || actionBtn.id.includes('undelete') ||
                                                    actionBtn.id.includes('reassign')) {
                                                    actionBtn.disabled = true;
                                                }
                                                document.querySelectorAll('[id$="SelectionInfo"]').forEach(el => el
                                                    .textContent = '0 selected');
                                            });
                                        });

                                        // Undo History dropdown functionality
                                        document.querySelectorAll('#taskUndoHistory, #leadUndoHistory, #reassignmentUndoHistory').forEach(
                                            dropdown => {
                                                dropdown.addEventListener('change', function() {
                                                    if (this.value) {
                                                        // In a real application, this would fetch the previous undo data
                                                        // For this demo, we'll just show a message
                                                        const modalBody =
                                                            `This would load the data from the selected undo: "${this.options[this.selectedIndex].text}"`;
                                                        document.getElementById('successModalBody').textContent = modalBody;
                                                        successModal.show();
                                                    }
                                                });
                                            });
                                    });

                                    // Dummy function for reassign selected button
                                    function handleReassignSelected() {
                                        const checkedCount = document.querySelectorAll('#customersTableBody .row-checkbox:checked').length;
                                        const newRep = document.getElementById('reassignSalesRep').selectedOptions[0]?.textContent || 'selected rep';
                                        const newTeam = document.getElementById('reassignTeam').selectedOptions[0]?.textContent || 'selected team';

                                        if (!document.getElementById('reassignSalesRep').value && !document.getElementById('reassignTeam').value) {
                                            alert('Please select at least one reassignment option (Sales Rep or Team).');
                                            return;
                                        }

                                        if (checkedCount === 0) {
                                            alert('Please select at least one customer to reassign.');
                                            return;
                                        }

                                        // Show success message
                                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                        document.getElementById('successModalBody').textContent =
                                            `Success! ${checkedCount} customer(s) have been reassigned to ${newRep} (${newTeam})`;
                                        successModal.show();
                                    }
                                </script>





                                <script>
                                    // Updated sample deals data with some having empty DMS IDs
                                    const dealsData = [{
                                            id: 1,
                                            dmsNumber: "DMS-1001", // Has DMS ID
                                            customerName: "John Smith",
                                            physicalAddress: "123 Main St, New York, NY 10001",
                                            mobileNumber: "+1 (555) 123-4567",
                                            homeNumber: "+1 (555) 987-6543",
                                            workNumber: "+1 (555) 456-7890",
                                            email: "john.smith@example.com",
                                            leadType: "Hot Lead",
                                            source: "Website Inquiry",
                                            salesType: "Direct Sale",
                                            dealType: "New Purchase",
                                            inventoryType: "SUV",
                                            leadStatus: "Closed Won",
                                            vehicleInfo: {
                                                year: "2023",
                                                make: "Toyota",
                                                model: "RAV4",
                                                stockNumber: "STK-78901",
                                                vin: "1HGBH41JXMN109186"
                                            },
                                            salesStatus: "Delivered"
                                        },
                                        {
                                            id: 2,
                                            dmsNumber: "", // No DMS ID - will be merged into deal with DMS ID
                                            customerName: "John Smith", // Same customer, duplicate deal
                                            physicalAddress: "123 Main St, New York, NY 10001",
                                            mobileNumber: "+1 (555) 123-4567",
                                            homeNumber: "+1 (555) 987-6543",
                                            workNumber: "+1 (555) 456-7890",
                                            email: "john.smith@example.com",
                                            leadType: "Hot Lead",
                                            source: "Phone Call",
                                            salesType: "Direct Sale",
                                            dealType: "New Purchase",
                                            inventoryType: "SUV",
                                            leadStatus: "Closed Won",
                                            vehicleInfo: {
                                                year: "2023",
                                                make: "Toyota",
                                                model: "RAV4",
                                                stockNumber: "STK-78901",
                                                vin: "1HGBH41JXMN109186"
                                            },
                                            salesStatus: "Delivered"
                                        },
                                        {
                                            id: 3,
                                            dmsNumber: "DMS-1003",
                                            customerName: "Sarah Williams",
                                            physicalAddress: "789 Pine Rd, Chicago, IL 60601",
                                            mobileNumber: "+1 (555) 345-6789",
                                            homeNumber: "+1 (555) 765-4321",
                                            workNumber: "+1 (555) 456-7890",
                                            email: "sarah.w@example.com",
                                            leadType: "Cold Lead",
                                            source: "Walk-in",
                                            salesType: "Finance",
                                            dealType: "New Purchase",
                                            inventoryType: "Truck",
                                            leadStatus: "Closed Won",
                                            vehicleInfo: {
                                                year: "2024",
                                                make: "Ford",
                                                model: "F-150",
                                                stockNumber: "STK-12345",
                                                vin: "1FTFW1RG5LFC56789"
                                            },
                                            salesStatus: "Pending Delivery"
                                        },
                                        {
                                            id: 4,
                                            dmsNumber: "", // No DMS ID
                                            customerName: "Michael Brown",
                                            physicalAddress: "321 Elm St, Houston, TX 77001",
                                            mobileNumber: "+1 (555) 456-7890",
                                            homeNumber: "+1 (555) 654-3210",
                                            workNumber: "+1 (555) 567-8901",
                                            email: "michael.b@example.com",
                                            leadType: "Hot Lead",
                                            source: "Phone Call",
                                            salesType: "Direct Sale",
                                            dealType: "First-time Buyer",
                                            inventoryType: "Coupe",
                                            leadStatus: "Closed Won",
                                            vehicleInfo: {
                                                year: "2023",
                                                make: "BMW",
                                                model: "M4",
                                                stockNumber: "STK-98765",
                                                vin: "WBS3R9C50J7K12345"
                                            },
                                            salesStatus: "Delivered"
                                        }
                                    ];

                                    // State management
                                    let selectedDeals = [];
                                    let mergeModal = null;

                                    // Initialize when DOM is ready
                                    document.addEventListener('DOMContentLoaded', function() {
                                        initializeTable();
                                        setupEventListeners();

                                        // Initialize Bootstrap Modal (guarded)
                                        const modalElement = document.getElementById('mergeComparisonModal');
                                        if (modalElement && window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                                            mergeModal = new bootstrap.Modal(modalElement);
                                            // Reset modal when hidden
                                            modalElement.addEventListener('hidden.bs.modal', function() {
                                                resetModal();
                                            });
                                        }
                                    });

                                    // Populate table with deals data
                                    function initializeTable() {
                                        const tableBody = document.getElementById('dealsTableBody');
                                        if (!tableBody) {
                                            console.warn('initializeTable: dealsTableBody not found — skipping initialization');
                                            return;
                                        }
                                        tableBody.innerHTML = '';

                                        dealsData.forEach(deal => {
                                            const row = document.createElement('tr');
                                            row.id = `deal-row-${deal.id}`;

                                            // Format DMS ID display
                                            const hasDmsId = deal.dmsNumber && deal.dmsNumber.trim() !== '';
                                            const dmsCellClass = hasDmsId ? ' fw-bold' : 'text-danger fw-bold';
                                            const dmsDisplay = hasDmsId ? deal.dmsNumber : 'No DMS ID';

                                            // Format customer info as a single reference box (without DMS ID)
                                            const customerInfo = `
            <div class="customer-info-box">
                <div class="fw-bold">${deal.customerName}</div>
                <div class="small text-muted">${deal.physicalAddress}</div>
                <div class="small">Mobile: ${deal.mobileNumber}</div>
                <div class="small">Home: ${deal.homeNumber || 'N/A'}</div>
                <div class="small">Work: ${deal.workNumber || 'N/A'}</div>
                <div class="small">Email: ${deal.email}</div>
            </div>
        `;

                                            // Format vehicle info in two lines
                                            const vehicleInfo = `
            <div class="vehicle-info-box">
                <div class="fw-bold">${deal.vehicleInfo.year} ${deal.vehicleInfo.make} ${deal.vehicleInfo.model}</div>
                <div class="small text-muted">Stock: ${deal.vehicleInfo.stockNumber} | VIN: ${deal.vehicleInfo.vin}</div>
            </div>
        `;

                                            row.innerHTML = `
            <td>
                <input type="checkbox" class="form-check-input deal-checkbox" data-deal-id="${deal.id}" data-dms-id="${deal.dmsNumber}">
            </td>
             <td class="${dmsCellClass}"><strong>${dmsDisplay}</strong></td>
            <td>${customerInfo}</td>
           
            <td>${vehicleInfo}</td>
            <td>${deal.leadType}</td>
            <td>${deal.leadStatus}</td>
            <td>${deal.salesStatus}</td>
        `;
                                            tableBody.appendChild(row);
                                        });
                                    }

                                    // Set up event listeners
                                    function setupEventListeners() {
                                        // Select all checkbox
                                        document.getElementById('selectAllCheckbox').addEventListener('change', function(e) {
                                            const checkboxes = document.querySelectorAll('.deal-checkbox');
                                            checkboxes.forEach(checkbox => {
                                                checkbox.checked = e.target.checked;
                                                toggleDealSelection(checkbox);
                                            });
                                            updateMergeButtonState();
                                        });

                                        // Individual deal checkboxes
                                        document.addEventListener('change', function(e) {
                                            if (e.target.classList.contains('deal-checkbox')) {
                                                toggleDealSelection(e.target);
                                                updateMergeButtonState();
                                            }
                                        });

                                        // Merge button click
                                        document.getElementById('mergeDealsBtn').addEventListener('click', showMergeComparison);

                                        // Confirm merge button
                                        document.getElementById('confirmMergeBtn').addEventListener('click', performMerge);
                                    }

                                    // Toggle deal selection
                                    function toggleDealSelection(checkbox) {
                                        const dealId = parseInt(checkbox.getAttribute('data-deal-id'));
                                        const row = document.getElementById(`deal-row-${dealId}`);

                                        if (checkbox.checked) {
                                            if (selectedDeals.length >= 2 && !selectedDeals.includes(dealId)) {
                                                checkbox.checked = false;
                                                alert('You can only select two deals to merge.');
                                                return;
                                            }

                                            if (!selectedDeals.includes(dealId)) {
                                                selectedDeals.push(dealId);
                                            }
                                        } else {
                                            const index = selectedDeals.indexOf(dealId);
                                            if (index > -1) {
                                                selectedDeals.splice(index, 1);
                                            }
                                        }

                                        // Update select all checkbox
                                        updateSelectAllCheckbox();
                                    }

                                    // Update select all checkbox state
                                    function updateSelectAllCheckbox() {
                                        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                                        const allCheckboxes = document.querySelectorAll('.deal-checkbox');
                                        const checkedCheckboxes = document.querySelectorAll('.deal-checkbox:checked');

                                        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
                                        selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes
                                            .length;
                                    }

                                    // Update merge button state
                                    function updateMergeButtonState() {
                                        const mergeBtn = document.getElementById('mergeDealsBtn');
                                        const isEnabled = selectedDeals.length === 2;
                                        mergeBtn.disabled = !isEnabled;

                                        if (isEnabled) {
                                            mergeBtn.innerHTML = `<i class="fas fa-merge me-1"></i> Merge Selected Deals (${selectedDeals.length})`;
                                            mergeBtn.classList.add('btn-primary');
                                            mergeBtn.classList.remove('btn-light');
                                        } else {
                                            mergeBtn.innerHTML = `<i class="fas fa-merge me-1"></i> Merge Deals`;
                                            mergeBtn.classList.remove('btn-primary');
                                            mergeBtn.classList.add('btn-light');
                                        }
                                    }

                                    // Show merge comparison modal
                                    function showMergeComparison() {
                                        if (selectedDeals.length !== 2) return;

                                        const deal1 = dealsData.find(d => d.id === selectedDeals[0]);
                                        const deal2 = dealsData.find(d => d.id === selectedDeals[1]);

                                        if (!deal1 || !deal2) return;

                                        // Update modal titles
                                        const deal1Dms = deal1.dmsNumber ? deal1.dmsNumber : 'No DMS ID';
                                        const deal2Dms = deal2.dmsNumber ? deal2.dmsNumber : 'No DMS ID';

                                        document.getElementById('deal1Title').textContent = `${deal1Dms} - ${deal1.customerName}`;
                                        document.getElementById('deal2Title').textContent = `${deal2Dms} - ${deal2.customerName}`;

                                        // Populate customer sections with DMS ID underneath
                                        document.getElementById('deal1CustomerSection').innerHTML = `
        <div class="customer-info-display mb-2">
            <div class="fw-bold">${deal1.customerName}</div>
            <div class="small text-muted">${deal1.physicalAddress}</div>
            <div class="small">Mobile: ${deal1.mobileNumber}</div>
            <div class="small">Home: ${deal1.homeNumber || 'N/A'}</div>
            <div class="small">Work: ${deal1.workNumber || 'N/A'}</div>
            <div class="small">Email: ${deal1.email}</div>
        </div>
        <div class="dms-id-display mt-2 pt-2 border-top">
            <div class="small fw-bold">DMS ID #:</div>
            <div class=" fw-bold">${deal1Dms}</div>
        </div>
    `;

                                        document.getElementById('deal2CustomerSection').innerHTML = `
        <div class="customer-info-display mb-2">
            <div class="fw-bold">${deal2.customerName}</div>
            <div class="small text-muted">${deal2.physicalAddress}</div>
            <div class="small">Mobile: ${deal2.mobileNumber}</div>
            <div class="small">Home: ${deal2.homeNumber || 'N/A'}</div>
            <div class="small">Work: ${deal2.workNumber || 'N/A'}</div>
            <div class="small">Email: ${deal2.email}</div>
        </div>
        <div class="dms-id-display mt-2 pt-2 border-top">
            <div class="small fw-bold">DMS ID #:</div>
            <div class=" fw-bold">${deal2Dms}</div>
        </div>
    `;

                                        // Populate vehicle info
                                        document.getElementById('deal1VehicleInfo').innerHTML = `
        <div class="fw-bold">${deal1.vehicleInfo.year} ${deal1.vehicleInfo.make} ${deal1.vehicleInfo.model}</div>
        <div class="small text-muted">Stock: ${deal1.vehicleInfo.stockNumber} | VIN: ${deal1.vehicleInfo.vin}</div>
    `;

                                        document.getElementById('deal2VehicleInfo').innerHTML = `
        <div class="fw-bold">${deal2.vehicleInfo.year} ${deal2.vehicleInfo.make} ${deal2.vehicleInfo.model}</div>
        <div class="small text-muted">Stock: ${deal2.vehicleInfo.stockNumber} | VIN: ${deal2.vehicleInfo.vin}</div>
    `;

                                        // Build comparison fields
                                        const fieldsComparison = document.getElementById('fieldsComparison');
                                        fieldsComparison.innerHTML = '';

                                        // Define fields to compare
                                        const fields = [{
                                                key: 'customerInfo',
                                                label: 'Customer Information',
                                                note: 'All customer info fields will be merged together from selected deal',
                                                mergeable: false
                                            },
                                            {
                                                key: 'dmsNumber',
                                                label: 'DMS ID #',
                                                mergeable: false,
                                                special: 'dms'
                                            },
                                            {
                                                key: 'vehicleInfo',
                                                label: 'Vehicle Information',
                                                mergeable: true
                                            },
                                            {
                                                key: 'leadType',
                                                label: 'Lead Type',
                                                mergeable: true
                                            },
                                            {
                                                key: 'source',
                                                label: 'Source',
                                                mergeable: true
                                            },
                                            {
                                                key: 'salesType',
                                                label: 'Sales Type',
                                                mergeable: true
                                            },
                                            {
                                                key: 'dealType',
                                                label: 'Deal Type',
                                                mergeable: true
                                            },
                                            {
                                                key: 'inventoryType',
                                                label: 'Inventory Type',
                                                mergeable: true
                                            },
                                            {
                                                key: 'leadStatus',
                                                label: 'Lead Status',
                                                mergeable: true
                                            },
                                            {
                                                key: 'salesStatus',
                                                label: 'Sales Status',
                                                mergeable: true
                                            }
                                        ];

                                        fields.forEach(field => {
                                            const row = document.createElement('div');
                                            row.className = 'row align-items-center mb-3 pb-2 border-bottom';

                                            // Format display values
                                            let deal1Value = 'N/A';
                                            let deal2Value = 'N/A';

                                            if (field.key === 'dmsNumber') {
                                                deal1Value = deal1.dmsNumber ? `<span class=" fw-bold">${deal1.dmsNumber}</span>` :
                                                    '<span class="text-danger fw-bold">No DMS ID</span>';
                                                deal2Value = deal2.dmsNumber ? `<span class=" fw-bold">${deal2.dmsNumber}</span>` :
                                                    '<span class="text-danger fw-bold">No DMS ID</span>';
                                            } else if (field.key === 'customerInfo') {
                                                deal1Value =
                                                    `${deal1.customerName}<br><small class="text-muted">${deal1.physicalAddress}</small><br><small class="text-muted">Mobile: ${deal1.mobileNumber}</small><br><small class="text-muted">Home: ${deal1.homeNumber}</small><br><small class="text-muted">Work: ${deal1.workNumber}</small><br><small class="text-muted">Email: ${deal1.email}</small>`;
                                                deal2Value =
                                                    `${deal2.customerName}<br><small class="text-muted">${deal2.physicalAddress}</small><br><small class="text-muted">Mobile: ${deal2.mobileNumber}</small><br><small class="text-muted">Home: ${deal2.homeNumber}</small><br><small class="text-muted">Work: ${deal2.workNumber}</small><br><small class="text-muted">Email: ${deal2.email}</small>`;
                                            } else if (field.key === 'vehicleInfo') {
                                                deal1Value =
                                                    `${deal1.vehicleInfo.year} ${deal1.vehicleInfo.make} ${deal1.vehicleInfo.model}<br><small class="text-muted">Stock: ${deal1.vehicleInfo.stockNumber}</small>`;
                                                deal2Value =
                                                    `${deal2.vehicleInfo.year} ${deal2.vehicleInfo.make} ${deal2.vehicleInfo.model}<br><small class="text-muted">Stock: ${deal2.vehicleInfo.stockNumber}</small>`;
                                            } else {
                                                deal1Value = deal1[field.key] || 'N/A';
                                                deal2Value = deal2[field.key] || 'N/A';
                                            }

                                            // Customer information - no radio buttons (only display)
                                            if (field.key === 'customerInfo') {
                                                row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="p-2 border rounded bg-light">
                        ${deal1Value}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-2 border rounded bg-light">
                        ${deal2Value}
                    </div>
                </div>
            `;
                                            }
                                            // DMS ID field - special handling with radio buttons
                                            else if (field.key === 'dmsNumber') {
                                                // Determine which deal has DMS ID
                                                const deal1HasDms = deal1.dmsNumber && deal1.dmsNumber.trim() !== '';
                                                const deal2HasDms = deal2.dmsNumber && deal2.dmsNumber.trim() !== '';

                                                // Set default selection
                                                let defaultDeal1 = false;
                                                let defaultDeal2 = false;

                                                if (deal1HasDms && !deal2HasDms) {
                                                    defaultDeal1 = true;
                                                } else if (!deal1HasDms && deal2HasDms) {
                                                    defaultDeal2 = true;
                                                } else {
                                                    // If both have DMS IDs or both don't have DMS IDs, default to Deal 1
                                                    defaultDeal1 = true;
                                                }

                                                row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal1" 
                               value="deal1" 
                               ${defaultDeal1 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal1">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal1').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal1Value}
                                ${deal1HasDms && !deal2HasDms ? '<div class="mt-1"><small class=" fw-bold">✓ Has DMS ID</small></div>' : ''}
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal2" 
                               value="deal2"
                               ${defaultDeal2 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal2">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal2').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal2Value}
                                ${!deal1HasDms && deal2HasDms ? '<div class="mt-1"><small class=" fw-bold">✓ Has DMS ID</small></div>' : ''}
                            </div>
                        </label>
                    </div>
                </div>
            `;
                                            }
                                            // Mergeable fields - with radio buttons (same style as DMS ID and Vehicle Info)
                                            else {
                                                // Determine default selection based on DMS ID logic
                                                const dmsRadio = document.querySelector('input[name="dmsNumber"]:checked');
                                                const dmsSelected = dmsRadio ? dmsRadio.value : 'deal1';

                                                let defaultCheckedDeal1 = false;
                                                let defaultCheckedDeal2 = false;

                                                if (field.key === 'vehicleInfo') {
                                                    // For vehicle info, default to the same deal as DMS ID
                                                    defaultCheckedDeal1 = dmsSelected === 'deal1';
                                                    defaultCheckedDeal2 = dmsSelected === 'deal2';
                                                } else {
                                                    // For other fields, follow the DMS ID selection
                                                    defaultCheckedDeal1 = dmsSelected === 'deal1';
                                                    defaultCheckedDeal2 = dmsSelected === 'deal2';
                                                }

                                                row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label fw-bold">${field.label}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal1" 
                               value="deal1" 
                               ${defaultCheckedDeal1 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal1">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal1').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal1Value}
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" 
                               name="${field.key}" 
                               id="${field.key}_deal2" 
                               value="deal2"
                               ${defaultCheckedDeal2 ? 'checked' : ''}>
                        <label class="form-check-label w-100" for="${field.key}_deal2">
                            <div class="p-2 border rounded bg-light" 
                                 onclick="document.getElementById('${field.key}_deal2').checked = true; highlightSelection(this, '${field.key}')">
                                ${deal2Value}
                            </div>
                        </label>
                    </div>
                </div>
            `;
                                            }

                                            fieldsComparison.appendChild(row);
                                        });

                                        // Show modal
                                        mergeModal.show();
                                    }

                                    // Highlight selection when field is clicked
                                    window.highlightSelection = function(element, fieldName) {
                                        // Remove highlight from all options in this field group
                                        const row = element.closest('.row');
                                        row.querySelectorAll('.border-primary').forEach(el => {
                                            el.classList.remove('bg-primary', 'bg-opacity-10', 'border-primary');
                                            el.classList.add('bg-light', 'border');
                                        });

                                        // Add highlight to selected option
                                        element.classList.add('bg-primary', 'bg-opacity-10', 'border-primary');
                                        element.classList.remove('bg-light', 'border');
                                    };

                                    // Perform the merge operation
                                    function performMerge() {
                                        // Show loading state
                                        document.getElementById('comparisonContent').style.display = 'none';
                                        document.getElementById('loadingState').style.display = 'block';
                                        document.getElementById('confirmMergeBtn').disabled = true;

                                        // Simulate API call delay (2 seconds)
                                        setTimeout(() => {
                                            // Hide loading state
                                            document.getElementById('loadingState').style.display = 'none';

                                            // Show success state
                                            document.getElementById('successState').style.display = 'block';
                                            document.getElementById('confirmMergeBtn').style.display = 'none';

                                            // Collect selected values for logging/demo
                                            const selectedValues = {};
                                            const mergeableFields = ['dmsNumber', 'vehicleInfo', 'leadType', 'source', 'salesType',
                                                'dealType', 'inventoryType', 'leadStatus', 'salesStatus'
                                            ];

                                            mergeableFields.forEach(field => {
                                                const selectedRadio = document.querySelector(`input[name="${field}"]:checked`);
                                                if (selectedRadio) {
                                                    selectedValues[field] = selectedRadio.value;
                                                }
                                            });

                                            // Customer info is always from the same deal as DMS ID
                                            const dmsSelected = selectedValues['dmsNumber'] || 'deal1';
                                            selectedValues['customerInfo'] = dmsSelected;

                                            console.log('Merge completed with selected values:', selectedValues);

                                            // Determine which deal is being kept (the one with DMS ID)
                                            const deal1 = dealsData.find(d => d.id === selectedDeals[0]);
                                            const deal2 = dealsData.find(d => d.id === selectedDeals[1]);
                                            const keptDealId = dmsSelected === 'deal1' ? deal1.id : deal2.id;
                                            const mergedDealId = dmsSelected === 'deal1' ? deal2.id : deal1.id;

                                            console.log(`Deal ${keptDealId} kept (selected for DMS ID), Deal ${mergedDealId} merged into it`);

                                            // Reset table selection after successful merge
                                            setTimeout(() => {
                                                // Clear checkboxes
                                                document.querySelectorAll('.deal-checkbox:checked').forEach(cb => {
                                                    cb.checked = false;
                                                    const dealId = parseInt(cb.getAttribute('data-deal-id'));
                                                    const row = document.getElementById(`deal-row-${dealId}`);
                                                });

                                                // Reset selectedDeals array
                                                selectedDeals = [];

                                                // Update button state
                                                updateMergeButtonState();

                                                // Reset select all checkbox
                                                document.getElementById('selectAllCheckbox').checked = false;
                                                document.getElementById('selectAllCheckbox').indeterminate = false;

                                                // Close modal after 2 seconds
                                                setTimeout(() => {
                                                    mergeModal.hide();
                                                }, 2000);
                                            }, 1000);
                                        }, 2000);
                                    }

                                    // Reset modal to initial state
                                    function resetModal() {
                                        // Reset all states
                                        document.getElementById('comparisonContent').style.display = 'block';
                                        document.getElementById('loadingState').style.display = 'none';
                                        document.getElementById('successState').style.display = 'none';
                                        document.getElementById('confirmMergeBtn').disabled = false;
                                        document.getElementById('confirmMergeBtn').style.display = 'block';

                                        // Clear customer info displays
                                        document.getElementById('deal1CustomerSection').innerHTML = '';
                                        document.getElementById('deal2CustomerSection').innerHTML = '';
                                        document.getElementById('deal1VehicleInfo').innerHTML = '';
                                        document.getElementById('deal2VehicleInfo').innerHTML = '';

                                        // Clear modal titles
                                        document.getElementById('deal1Title').textContent = 'Deal 1';
                                        document.getElementById('deal2Title').textContent = 'Deal 2';
                                    }
                                </script>

                                <style>
                                    /* Minimal custom styles for better UX */
                                    .deal-checkbox:checked {
                                        background-color: var(--cf-primary);
                                        border-color: var(--cf-primary);
                                    }

                                    #mergeDealsBtn:disabled {
                                        opacity: 0.5;
                                        cursor: not-allowed;
                                    }

                                    .form-check-input:checked {
                                        background-color: var(--cf-primary);
                                        border-color: var(--cf-primary);
                                    }

                                    .border-primary {
                                        border-color: var(--cf-primary) !important;
                                    }

                                    .form-check-label div {
                                        cursor: pointer;
                                        transition: all 0.2s;
                                    }

                                    .form-check-label div:hover {
                                        background-color: #e9ecef !important;
                                    }

                                    /* Customer info box styling */
                                    .customer-info-box {
                                        background-color: #f8f9fa;
                                        border-radius: 4px;
                                        padding: 8px;
                                        border: 1px solid #dee2e6;
                                        font-size: 0.875rem;
                                    }

                                    .customer-info-box .fw-bold {
                                        font-size: 0.9rem;
                                        margin-bottom: 2px;
                                    }

                                    /* Vehicle info box styling */
                                    .vehicle-info-box {
                                        font-size: 0.875rem;
                                    }

                                    /* Modal styling */
                                    .modal-body .card {
                                        background-color: #f8f9fa;
                                    }

                                    .modal-body .card-header {
                                        background-color: #e9ecef !important;
                                        border-bottom: 1px solid #dee2e6;
                                    }

                                    /* Customer info display in modal */
                                    .customer-info-display {
                                        font-size: 0.875rem;
                                    }

                                    .dms-id-display {
                                        font-size: 0.875rem;
                                    }
                                </style>




                                <style>
                                    .primus-crm-delivery-channels {
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 10px;
                                        margin-top: 12px;
                                        padding-top: 12px;
                                        border-top: 1px solid #e8eaed;
                                    }

                                    .primus-crm-channel-item {
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        justify-content: center;
                                        width: 60px;
                                        height: 60px;
                                        padding: 8px;
                                        border-radius: 10px;
                                        border: 2px solid #d1d9e6;
                                        background: #ffffff;
                                        cursor: pointer;
                                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                        position: relative;
                                        overflow: hidden;
                                    }

                                    .primus-crm-channel-item:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                                        border-color: #666;
                                    }

                                    .primus-crm-channel-item.active {
                                        background: rgb(0, 33, 64);
                                        border-color: #1a1a1a;
                                    }

                                    .primus-crm-channel-item.active:hover {
                                        border-color: rgb(0, 33, 64);
                                        box-shadow: 0 4px 12px rgba(26, 26, 26, 0.15);
                                    }

                                    .primus-crm-channel-icon {
                                        width: 20px;
                                        height: 20px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 8px;
                                        background: #f8f9fa;
                                        margin-bottom: 6px;
                                        transition: all 0.3s ease;
                                    }

                                    .primus-crm-channel-item.active .primus-crm-channel-icon {
                                        background: #2c2c2c;
                                    }

                                    .primus-crm-channel-icon i {
                                        font-size: 13px;
                                        color: #666;
                                        transition: all 0.3s ease;
                                    }

                                    .primus-crm-channel-item.active .primus-crm-channel-icon i {
                                        color: #ffffff;
                                    }

                                    .primus-crm-channel-label {
                                        font-size: 11px;
                                        font-weight: 600;
                                        color: #444;
                                        text-align: center;
                                        transition: all 0.3s ease;
                                    }

                                    .primus-crm-channel-item.active .primus-crm-channel-label {
                                        color: #ffffff;
                                    }

                                    /* Consistent color for all channels */
                                    .primus-crm-channel-item .primus-crm-channel-icon {
                                        background: #f0f2f5;
                                    }

                                    .primus-crm-channel-item .primus-crm-channel-icon i {
                                        color: #666;
                                    }

                                    .primus-crm-channel-item.active .primus-crm-channel-icon {
                                        background: #2c2c2c;
                                    }

                                    .primus-crm-channel-item.active .primus-crm-channel-icon i {
                                        color: #ffffff;
                                    }

                                    /* Checkmark indicator */
                                    .primus-crm-channel-item::after {
                                        content: '';
                                        position: absolute;
                                        top: 6px;
                                        right: 6px;
                                        width: 14px;
                                        height: 14px;
                                        border-radius: 50%;
                                        background: #ffffff;
                                        border: 2px solid #d1d9e6;
                                        transition: all 0.3s ease;
                                    }

                                    .primus-crm-channel-item.active::after {
                                        background: #4CAF50;
                                        border-color: #4CAF50;
                                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");
                                        background-size: 9px;
                                        background-position: center;
                                        background-repeat: no-repeat;
                                    }

                                    /* Disabled state when notification is off */
                                    .primus-crm-setting-row:not(.notification-enabled) .primus-crm-channel-item {
                                        opacity: 0.5;
                                        pointer-events: none;
                                    }

                                    /* Animation for toggle */
                                    @keyframes channelToggle {
                                        0% {
                                            transform: scale(0.95);
                                        }

                                        50% {
                                            transform: scale(1.05);
                                        }

                                        100% {
                                            transform: scale(1);
                                        }
                                    }

                                    .primus-crm-channel-item.active {
                                        animation: channelToggle 0.3s ease;
                                    }

                                    /* Enhanced toggle switch */
                                    .primus-crm-toggle-switch {
                                        width: 50px;
                                        height: 26px;
                                        background: #ccc;
                                        border-radius: 13px;
                                        position: relative;
                                        cursor: pointer;
                                        transition: background 0.3s ease;
                                    }

                                    .primus-crm-toggle-switch.active {
                                        background: #4CAF50;
                                    }

                                    .primus-crm-toggle-switch::after {
                                        content: '';
                                        position: absolute;
                                        top: 3px;
                                        left: 3px;
                                        width: 20px;
                                        height: 20px;
                                        background: white;
                                        border-radius: 50%;
                                        transition: transform 0.3s ease;
                                    }

                                    .primus-crm-toggle-switch.active::after {
                                        transform: translateX(24px);
                                    }
                                </style>

                                <script>
                                    // JavaScript for interactive functionality
                                    function toggleChannel(element) {
                                        element.classList.toggle('active');

                                        // Add animation effect
                                        element.style.animation = 'none';
                                        setTimeout(() => {
                                            element.style.animation = 'channelToggle 0.3s ease';
                                        }, 10);
                                    }

                                    function toggleNotification(element) {
                                        const row = element.closest('.primus-crm-setting-row');
                                        element.classList.toggle('active');
                                        row.classList.toggle('notification-enabled');
                                    }

                                    function savePreferences() {
                                        // Collect all notification preferences
                                        const preferences = [];
                                        const notificationRows = document.querySelectorAll('.primus-crm-setting-row');

                                        notificationRows.forEach(row => {
                                            const notificationName = row.querySelector('.primus-crm-setting-name').textContent;
                                            const isEnabled = row.querySelector('.primus-crm-toggle-switch').classList.contains('active');
                                            const channels = Array.from(row.querySelectorAll('.primus-crm-channel-item')).map(channel => ({
                                                type: channel.getAttribute('data-channel'),
                                                enabled: channel.classList.contains('active')
                                            }));

                                            preferences.push({
                                                name: notificationName,
                                                enabled: isEnabled,
                                                channels: channels
                                            });
                                        });

                                        // Collect reminder settings
                                        const salesReminderTime = document.querySelector(
                                            '.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(2)').value;
                                        const serviceReminderTime = document.querySelector(
                                            '.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(5)').value;
                                        const taskReminderTime = document.querySelector(
                                            '.primus-crm-settings-section:nth-last-child(1) .primus-crm-form-control:nth-child(8)').value;

                                        const reminderSettings = {
                                            salesAppointmentReminder: salesReminderTime,
                                            serviceAppointmentReminder: serviceReminderTime,
                                            taskOverdueReminder: taskReminderTime
                                        };

                                        const allSettings = {
                                            notifications: preferences,
                                            reminders: reminderSettings
                                        };

                                        // In a real application, you would send this data to your server
                                        console.log('Saving preferences:', allSettings);
                                        alert('Notification preferences saved successfully!');
                                    }

                                    function resetToDefaults() {
                                        if (confirm('Are you sure you want to reset all notification preferences to defaults?')) {
                                            // Reset all toggles
                                            document.querySelectorAll('.primus-crm-toggle-switch').forEach(toggle => {
                                                toggle.classList.add('active');
                                                toggle.closest('.primus-crm-setting-row').classList.add('notification-enabled');
                                            });

                                            // Reset all channels to default states
                                            document.querySelectorAll('.primus-crm-channel-item').forEach(channel => {
                                                const channelType = channel.getAttribute('data-channel');
                                                // Default settings based on your original logic
                                                const shouldBeActive = (channelType === 'email' || channelType === 'app' || channelType ===
                                                    'desktop');
                                                channel.classList.toggle('active', shouldBeActive);
                                            });

                                            // Reset reminder dropdowns to default values
                                            document.querySelectorAll('.primus-crm-form-control').forEach((select, index) => {
                                                if (index === 1 || index === 4 || index === 7) { // Reminder dropdowns
                                                    select.value = '30';
                                                }
                                            });

                                            alert('Preferences reset to defaults!');
                                        }
                                    }

                                    // Initialize on page load
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Add notification-enabled class to all active rows initially
                                        document.querySelectorAll('.primus-crm-toggle-switch.active').forEach(toggle => {
                                            toggle.closest('.primus-crm-setting-row').classList.add('notification-enabled');
                                        });
                                    });
                                </script>






                                <script>
                                    // Generate time options for all dropdowns
                                    const timeOptions = [
                                        '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30',
                                        '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30',
                                        '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                                        '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
                                        '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
                                        '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'
                                    ];

                                    function formatTime(time) {
                                        if (!time) return '';
                                        const parts = String(time).split(':');
                                        const hours = parseInt(parts[0], 10) || 0;
                                        // take first two chars of minutes (handles '00' and '00:00' cases)
                                        const minutes = parts[1] ? parts[1].slice(0, 2) : '00';
                                        const ampm = hours >= 12 ? 'PM' : 'AM';
                                        const displayHour = hours === 0 ? 12 : hours > 12 ? hours - 12 : hours;
                                        return `${displayHour}:${minutes} ${ampm}`;
                                    }

                                    // Populate all time dropdowns
                                    function populateTimeDropdowns() {
                                        document.querySelectorAll('.primus-crm-time-dropdown').forEach(select => {
                                            if (select.options.length <= 1) { // Only populate if empty
                                                timeOptions.forEach(time => {
                                                    const option = document.createElement('option');
                                                    option.value = time;
                                                    option.textContent = formatTime(time);
                                                    select.appendChild(option);
                                                });
                                            }
                                        });
                                    }

                                    // Toggle day hours visibility
                                    function toggleDayHours(checkbox) {
                                        const row = checkbox.closest('.primus-crm-hours-row');
                                        const selects = row.querySelectorAll('.primus-crm-time-dropdown');
                                        const toText = row.querySelectorAll('span')[1];
                                        const closedLabel = row.querySelector('.primus-crm-closed-label');

                                        if (checkbox.checked) {
                                            selects.forEach(s => s.style.display = 'block');
                                            if (toText) toText.style.display = 'inline';
                                            if (closedLabel) closedLabel.style.display = 'none';
                                        } else {
                                            selects.forEach(s => s.style.display = 'none');
                                            if (toText) toText.style.display = 'none';
                                            if (closedLabel) closedLabel.style.display = 'inline';
                                        }
                                    }

                                    // Apply to all days
                                    function applyToAllDays() {
                                        const startTime = document.getElementById('quickStartTime').value;
                                        const endTime = document.getElementById('quickEndTime').value;

                                        if (!startTime || !endTime) {
                                            alert('Please select both start and end times');
                                            return;
                                        }

                                        document.querySelectorAll('.primus-crm-hours-row').forEach(row => {
                                            const checkbox = row.querySelector('input[type="checkbox"]');
                                            const startSelect = row.querySelector('.day-start-time');
                                            const endSelect = row.querySelector('.day-end-time');

                                            if (checkbox && startSelect && endSelect) {
                                                checkbox.checked = true;
                                                startSelect.value = startTime;
                                                endSelect.value = endTime;
                                                toggleDayHours(checkbox);
                                            }
                                        });
                                    }

                                    // Apply to weekdays only
                                    function applyToWeekdays() {
                                        const startTime = document.getElementById('quickStartTime').value;
                                        const endTime = document.getElementById('quickEndTime').value;

                                        if (!startTime || !endTime) {
                                            alert('Please select both start and end times');
                                            return;
                                        }

                                        const weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

                                        document.querySelectorAll('.primus-crm-hours-row').forEach(row => {
                                            const day = row.getAttribute('data-day');

                                            if (weekdays.includes(day)) {
                                                const checkbox = row.querySelector('input[type="checkbox"]');
                                                const startSelect = row.querySelector('.day-start-time');
                                                const endSelect = row.querySelector('.day-end-time');

                                                if (checkbox && startSelect && endSelect) {
                                                    checkbox.checked = true;
                                                    startSelect.value = startTime;
                                                    endSelect.value = endTime;
                                                    toggleDayHours(checkbox);
                                                }
                                            }
                                        });
                                    }

                                    // Holiday Management (dynamic via backend)
                                    let holidays = [];
                                    let editingHolidayId = null;

                                    function toggleHolidaySection(toggle) {
                                        toggle.classList.toggle('active');
                                        const section = document.getElementById('holidayOverrideSection');

                                        if (toggle.classList.contains('active')) {
                                            section.style.display = 'block';
                                        } else {
                                            section.style.display = 'none';
                                        }
                                    }

                                    function openHolidayModal() {
                                        editingHolidayId = null;
                                        document.getElementById('holidayName').value = '';
                                        document.getElementById('holidayDate').value = '';
                                        document.getElementById('holidayClosed').checked = false;
                                        document.getElementById('holidayStartTime').value = '';
                                        document.getElementById('holidayEndTime').value = '';
                                        document.getElementById('holidayHoursSection').style.display = 'block';
                                        document.getElementById('holidayModal').style.display = 'flex';
                                    }

                                    function closeHolidayModal() {
                                        document.getElementById('holidayModal').style.display = 'none';
                                    }

                                    // Debug helper: ensure notifications tab content becomes visible
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const notifTabBtn = document.getElementById('notifications-tab');
                                        const notifPane = document.getElementById('notifications');
                                        if (!notifTabBtn || !notifPane) return;

                                        notifTabBtn.addEventListener('click', function() {
                                            console.log('Notifications tab clicked');
                                        });

                                        // Listen for Bootstrap tab show event and force visibility if needed
                                        notifTabBtn.addEventListener('shown.bs.tab', function(e) {
                                            console.log('Notifications tab shown event', e);
                                            if (!notifPane.classList.contains('show')) {
                                                notifPane.classList.add('show', 'active');
                                            }
                                        });
                                    });

                                    function toggleHolidayHours(checkbox) {
                                        const hoursSection = document.getElementById('holidayHoursSection');
                                        hoursSection.style.display = checkbox.checked ? 'none' : 'block';
                                    }

                                    function fetchHolidays() {
                                        fetch('{{ route('settings.holidays.index') }}', {
                                            headers: {
                                                'Accept': 'application/json'
                                            }
                                        }).then(r => r.json()).then(json => {
                                            const raw = Array.isArray(json.data) ? json.data : [];
                                            // normalize server fields (snake_case) to expected camelCase keys
                                            holidays = raw.map(h => ({
                                                id: h.id,
                                                name: h.name,
                                                date: h.date ? h.date.split('T')[0] : h.date,
                                                isClosed: h.is_closed ?? h.isClosed ?? false,
                                                startTime: h.start_time ?? h.startTime ?? null,
                                                endTime: h.end_time ?? h.endTime ?? null,
                                            }));
                                            renderHolidayList();
                                        }).catch(err => {
                                            console.error(err);
                                        });
                                    }

                                    function saveHoliday() {
                                        const name = document.getElementById('holidayName').value.trim();
                                        const date = document.getElementById('holidayDate').value;
                                        const isClosed = document.getElementById('holidayClosed').checked;
                                        const startTime = document.getElementById('holidayStartTime').value;
                                        const endTime = document.getElementById('holidayEndTime').value;

                                        if (!name || !date) {
                                            alert('Please enter holiday name and date');
                                            return;
                                        }

                                        if (!isClosed && (!startTime || !endTime)) {
                                            alert('Please select custom hours or mark as closed');
                                            return;
                                        }

                                        const payload = {
                                            name,
                                            date,
                                            isClosed,
                                            startTime: isClosed ? null : startTime,
                                            endTime: isClosed ? null : endTime
                                        };

                                        const submit = editingHolidayId ?
                                            fetch(`{{ url('/settings/holidays') }}/${editingHolidayId}`, {
                                                method: 'PUT',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify(payload)
                                            }) :
                                            fetch('{{ route('settings.holidays.store') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify(payload)
                                            });

                                        submit.then(r => r.json()).then(json => {
                                            if (json && json.success) {
                                                fetchHolidays();
                                                closeHolidayModal();
                                            } else {
                                                alert('Failed to save holiday');
                                            }
                                        }).catch(err => {
                                            console.error(err);
                                            alert('Error saving holiday');
                                        });
                                    }

                                    function renderHolidayList() {
                                        const list = document.getElementById('holidayList');

                                        if (!holidays || holidays.length === 0) {
                                            list.innerHTML =
                                                '<p style="color: #94a3b8; text-align: center; padding: 20px;">No holiday overrides added yet</p>';
                                            return;
                                        }

                                        list.innerHTML = holidays.map((holiday) => {
                                            const formattedDate = new Date(holiday.date).toLocaleDateString('en-US', {
                                                weekday: 'long',
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            });

                                            const hoursText = holiday.isClosed ? 'Closed' :
                                                `${formatTime(holiday.startTime)} - ${formatTime(holiday.endTime)}`;

                                            return `
        <div class="primus-crm-holiday-item">
            <div class="primus-crm-holiday-info">
                <h4>${holiday.name}</h4>
                <p>${formattedDate} • ${hoursText}</p>
            </div>
            <div class="primus-crm-holiday-actions">
                <div class="primus-crm-holiday-edit" onclick="editHoliday('${holiday.id}')" title="Edit">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="primus-crm-holiday-delete" onclick="deleteHoliday('${holiday.id}')" title="Delete">
                    <i class="fas fa-trash"></i>
                </div>
            </div>
        </div>
    `;
                                        }).join('');
                                    }

                                    function editHoliday(id) {
                                        const idx = holidays.findIndex(h => String(h.id) === String(id));
                                        if (idx === -1) return;
                                        const holiday = holidays[idx];
                                        editingHolidayId = holiday.id;
                                        document.getElementById('holidayName').value = holiday.name;
                                        document.getElementById('holidayDate').value = holiday.date;
                                        document.getElementById('holidayClosed').checked = !!holiday.isClosed;
                                        document.getElementById('holidayStartTime').value = holiday.startTime || '';
                                        document.getElementById('holidayEndTime').value = holiday.endTime || '';
                                        toggleHolidayHours(document.getElementById('holidayClosed'));
                                        document.getElementById('holidayModal').style.display = 'flex';
                                    }

                                    function deleteHoliday(id) {
                                        if (!confirm('Are you sure you want to delete this holiday override?')) return;
                                        fetch(`{{ url('/settings/holidays') }}/${id}`, {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(r => r.json()).then(json => {
                                                if (json && json.success) fetchHolidays();
                                                else alert('Failed to delete holiday');
                                            }).catch(err => {
                                                console.error(err);
                                                alert('Error deleting holiday');
                                            });
                                    }

                                    // On initial page load, fetch holidays from backend if available,
                                    // otherwise fall back to injected `window.holidays` data.
                                    document.addEventListener('DOMContentLoaded', function() {
                                        if (typeof fetchHolidays === 'function') {
                                            try {
                                                fetchHolidays();
                                            } catch (e) {
                                                console.error(e);
                                            }
                                            return;
                                        }

                                        if (window.holidays && Array.isArray(window.holidays) && window.holidays.length) {
                                            holidays = window.holidays.map(h => ({
                                                id: h.id ?? null,
                                                name: h.name ?? h.title ?? '',
                                                date: h.date ? String(h.date).split('T')[0] : (h.date ?? ''),
                                                isClosed: h.is_closed ?? h.isClosed ?? h.closed ?? false,
                                                startTime: h.start_time ?? h.startTime ?? h.start ?? null,
                                                endTime: h.end_time ?? h.endTime ?? h.end ?? null,
                                            }));
                                            try {
                                                renderHolidayList();
                                            } catch (e) {
                                                console.error(e);
                                            }
                                        }
                                    });

                                    // Close modal on outside click
                                    window.onclick = function(event) {
                                        const modal = document.getElementById('holidayModal');
                                        if (event.target === modal) {
                                            closeHolidayModal();
                                        }
                                    }

                                    // Initialize on page load
                                    document.addEventListener('DOMContentLoaded', function() {
                                        populateTimeDropdowns();

                                        // Show holiday section by default if toggle is active
                                        const holidayToggle = document.getElementById('holidayToggle');
                                        if (holidayToggle && holidayToggle.classList.contains('active')) {
                                            document.getElementById('holidayOverrideSection').style.display = 'block';
                                        }
                                    });
                                </script>




                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Load saved targets
                                        function loadSavedTargets() {
                                            const savedTargets = JSON.parse(localStorage.getItem('speedSaleTargets') || '{}');

                                            document.querySelectorAll('.speed-target-input').forEach(input => {
                                                const targetType = input.getAttribute('data-target');
                                                if (savedTargets[targetType]) {
                                                    input.value = savedTargets[targetType];
                                                }
                                            });

                                            // Update frontend display if modal is open
                                            updateFrontendTargets(savedTargets);
                                        }

                                        // Update frontend targets display
                                        function updateFrontendTargets(targets) {
                                            const order = ["speedToLead", "followUpTime", "conversionTime"];

                                            order.forEach((k, idx) => {
                                                const badge = document.querySelector(`[data-from="${k}"]`);
                                                if (!badge) return;

                                                if (targets[k] && targets[k] !== '') {
                                                    badge.textContent = `Target: ${targets[k]} min`;
                                                } else {
                                                    badge.textContent = "N/A";
                                                }
                                            });
                                        }

                                        // Save targets
                                        document.getElementById('saveSpeedTargets').addEventListener('click', function() {
                                            const targets = {};

                                            document.querySelectorAll('.speed-target-input').forEach(input => {
                                                const targetType = input.getAttribute('data-target');
                                                const value = input.value.trim();

                                                if (value === '') {
                                                    targets[targetType] = '';
                                                } else {
                                                    targets[targetType] = parseInt(value) || 0;
                                                }
                                            });

                                            // Save to localStorage (in real app, this would be API call)
                                            localStorage.setItem('speedSaleTargets', JSON.stringify(targets));

                                            // Update frontend display
                                            updateFrontendTargets(targets);

                                            // Show success message
                                            alert('Speed to Sale targets saved successfully!');
                                        });

                                        // Initialize
                                        loadSavedTargets();
                                    });

                                    // Update the existing Speed to Sale calculation function
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const order = ["speedToLead", "followUpTime", "conversionTime"];

                                        function calcAndRender() {
                                            // Load saved targets
                                            const savedTargets = JSON.parse(localStorage.getItem('speedSaleTargets') || '{}');

                                            // Compute performance vs target and progress bars
                                            order.forEach((k, idx) => {
                                                const badge = document.querySelector(`[data-from="${k}"]`);
                                                const bar = document.querySelector(`[data-bar="${k}"]`);
                                                if (!badge || !bar) return;

                                                const currentTarget = savedTargets[k];

                                                if (currentTarget && currentTarget !== '') {
                                                    badge.textContent = `Target: ${currentTarget} min`;

                                                    // Calculate progress percentage (example logic)
                                                    let progressPercentage = 0;
                                                    if (idx === 0) {
                                                        progressPercentage = Math.min(100, (75 / currentTarget) * 100);
                                                    } else if (idx === 1) {
                                                        progressPercentage = Math.min(100, (320 / currentTarget) * 100);
                                                    } else if (idx === 2) {
                                                        progressPercentage = Math.min(100, (1240 / currentTarget) * 100);
                                                    }

                                                    bar.style.width = `${progressPercentage}%`;
                                                    bar.setAttribute('aria-valuenow', progressPercentage);
                                                } else {
                                                    badge.textContent = "N/A";
                                                    // Set default progress if no target
                                                    if (idx === 0) {
                                                        bar.style.width = "85%";
                                                        bar.setAttribute('aria-valuenow', 85);
                                                    } else if (idx === 1) {
                                                        bar.style.width = "93%";
                                                        bar.setAttribute('aria-valuenow', 93);
                                                    } else if (idx === 2) {
                                                        bar.style.width = "97%";
                                                        bar.setAttribute('aria-valuenow', 97);
                                                    }
                                                }
                                            });
                                        }

                                        // Initialize from saved values
                                        calcAndRender();
                                    });
                                </script>




                                <style>
                                    /* Additional styles for better UI */


                                    .primus-crm-checkbox-list .form-check:hover {
                                        background-color: #f8f9fa;
                                    }

                                    #rulesList .list-group-item {
                                        margin-bottom: 10px;
                                        border-radius: 8px;
                                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                                    }

                                    #rulesList .list-group-item:hover {
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                                    }

                                    .primus-crm-toggle-switch {
                                        width: 50px;
                                        height: 26px;
                                        background-color: #ccc;
                                        border-radius: 13px;
                                        position: relative;
                                        cursor: pointer;
                                        transition: background-color 0.3s;
                                    }

                                    .primus-crm-toggle-switch::after {
                                        content: '';
                                        position: absolute;
                                        width: 22px;
                                        height: 22px;
                                        background-color: white;
                                        border-radius: 50%;
                                        top: 2px;
                                        left: 2px;
                                        transition: left 0.3s;
                                    }

                                    .primus-crm-toggle-switch.active {
                                        background-color: var(--cf-primary);
                                    }


                                    #ruleMembers {
                                        min-height: 150px;
                                    }
                                </style>
                                <!-- Email footer Tab -->




                                <style>
                                    /* Social Media Grid Styles */
                                    .primus-crm-social-media-grid {
                                        display: flex;
                                        gap: 15px;
                                        flex-wrap: wrap;
                                        margin-top: 15px;
                                    }

                                    .primus-crm-social-icon {
                                        width: 50px;
                                        height: 50px;
                                        border-radius: 8px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 24px;
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                        border: 2px solid #e2e8f0;
                                        background: #f8f9fa;
                                        color: #cbd5e1;
                                        position: relative;
                                    }

                                    .primus-crm-social-icon:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                    }

                                    .primus-crm-social-icon.active {
                                        border-color: #3b82f6;
                                    }

                                    .primus-crm-social-icon[data-platform="facebook"].active {
                                        color: #1877f2;
                                        background: #e7f3ff;
                                    }

                                    .primus-crm-social-icon[data-platform="instagram"].active {
                                        color: #e4405f;
                                        background: #ffe7ec;
                                    }

                                    .primus-crm-social-icon[data-platform="twitter"].active {
                                        color: #000000;
                                        background: #e7e7e7;
                                    }

                                    .primus-crm-social-icon[data-platform="youtube"].active {
                                        color: #ff0000;
                                        background: #ffe7e7;
                                    }

                                    .primus-crm-social-icon[data-platform="reddit"].active {
                                        color: #ff4500;
                                        background: #fff0e7;
                                    }

                                    /* Modal Styles */
                                    .primus-crm-modal {
                                        position: fixed;
                                        top: 0;
                                        left: 0;
                                        width: 100%;
                                        height: 100%;
                                        background: rgba(0, 0, 0, 0.5);
                                        z-index: 10000;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }

                                    .primus-crm-modal-content {
                                        background: white;
                                        border-radius: 8px;
                                        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                                        width: 90%;
                                        max-width: 500px;
                                    }

                                    .primus-crm-modal-header {
                                        padding: 20px;
                                        border-bottom: 1px solid #e2e8f0;
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                    }

                                    .primus-crm-modal-header h3 {
                                        margin: 0;
                                        font-size: 18px;
                                        font-weight: 600;
                                    }

                                    .primus-crm-modal-close {
                                        font-size: 28px;
                                        cursor: pointer;
                                        color: #64748b;
                                        line-height: 1;
                                    }

                                    .primus-crm-modal-close:hover {
                                        color: #1e293b;
                                    }

                                    .primus-crm-modal-body {
                                        padding: 20px;
                                    }

                                    .primus-crm-modal-footer {
                                        padding: 20px;
                                        border-top: 1px solid #e2e8f0;
                                        display: flex;
                                        justify-content: flex-end;
                                        gap: 10px;
                                    }

                                    /* Logo Upload Section */
                                    .primus-crm-logo-upload-section {
                                        padding: 15px;
                                        background: #f8f9fa;
                                        border-radius: 6px;
                                        border: 1px solid #e2e8f0;
                                    }

                                    .primus-crm-file-upload-wrapper {
                                        display: flex;
                                        align-items: center;
                                    }

                                    .primus-crm-btn {
                                        padding: 8px 16px;
                                        border-radius: 6px;
                                        border: none;
                                        cursor: pointer;
                                        font-size: 14px;
                                        font-weight: 500;
                                        transition: all 0.2s;
                                    }

                                    .primus-crm-btn-secondary {
                                        background: #f1f5f9;
                                        color: #475569;
                                        border: 1px solid #cbd5e1;
                                    }

                                    .primus-crm-btn-secondary:hover {
                                        background: #e2e8f0;
                                    }

                                    .primus-crm-btn-primary {
                                        background: #3b82f6;
                                        color: white;
                                    }

                                    .primus-crm-btn-primary:hover {
                                        background: #2563eb;
                                    }

                                    /* Confidentiality Text Styling */
                                    .primus-crm-confidentiality-text {
                                        font-size: 10px !important;
                                        color: #000000 !important;
                                        line-height: 1.4;
                                    }
                                </style>

                                <script>
                                    // Store social media links
                                    const socialMediaLinks = {
                                        facebook: '',
                                        instagram: '',
                                        twitter: '',
                                        youtube: '',
                                        reddit: ''
                                    };

                                    let currentSocialPlatform = '';

                                    // Toggle Header Logo Upload Section
                                    function toggleHeaderLogo(element) {
                                        element.classList.toggle('active');
                                        const uploadSection = document.getElementById('headerLogoUploadSection');

                                        if (element.classList.contains('active')) {
                                            uploadSection.style.display = 'block';
                                        } else {
                                            uploadSection.style.display = 'none';
                                        }
                                    }

                                    // Preview Header Logo
                                    function previewHeaderLogo(event) {
                                        const file = event.target.files[0];
                                        if (file) {
                                            document.getElementById('headerLogoFileName').textContent = file.name;

                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                const preview = document.getElementById('headerLogoPreview');
                                                const img = document.getElementById('headerLogoPreviewImg');
                                                img.src = e.target.result;
                                                preview.style.display = 'block';
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    }

                                    // Open Social Media Modal
                                    function openSocialModal(platform) {
                                        currentSocialPlatform = platform;
                                        // also store on modal element and window to make this value accessible to other scripts
                                        const modal = document.getElementById('socialMediaModal');
                                        if (modal) modal.dataset.platform = platform;
                                        try { window.currentSocialPlatform = platform; } catch(e) {}
                                        const modal = document.getElementById('socialMediaModal');
                                        const title = document.getElementById('socialModalTitle');
                                        const label = document.getElementById('socialModalLabel');
                                        const input = document.getElementById('socialMediaUrl');

                                        // Capitalize platform name
                                        const platformName = platform.charAt(0).toUpperCase() + platform.slice(1);
                                        if (platform === 'twitter') {
                                            title.textContent = 'Twitter/X URL';
                                            label.textContent = 'Twitter/X URL';
                                        } else {
                                            title.textContent = platformName + ' URL';
                                            label.textContent = platformName + ' URL';
                                        }

                                        // Set current value
                                        input.value = socialMediaLinks[platform] || '';

                                        modal.style.display = 'flex';
                                    }

                                    // Close Social Media Modal
                                    function closeSocialModal() {
                                        document.getElementById('socialMediaModal').style.display = 'none';
                                        currentSocialPlatform = '';
                                    }

                                    // // Save Social Media Link
                                    // function saveSocialLink() {
                                    //     const url = document.getElementById('socialMediaUrl').value.trim();
                                    //     const icon = document.querySelector(`.primus-crm-social-icon[data-platform="${currentSocialPlatform}"]`);

                                    //     socialMediaLinks[currentSocialPlatform] = url;

                                    //     if (url) {
                                    //         icon.classList.add('active');
                                    //     } else {
                                    //         icon.classList.remove('active');
                                    //     }

                                    //     closeSocialModal();
                                    // }

                                    // Close modal on outside click
                                    window.onclick = function(event) {
                                        const modal = document.getElementById('socialMediaModal');
                                        if (event.target === modal) {
                                            closeSocialModal();
                                        }
                                    }

                                    // Initialize: Show header logo upload section by default (toggle is ON)
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const headerLogoSection = document.getElementById('headerLogoUploadSection');
                                        if (headerLogoSection) {
                                            headerLogoSection.style.display = 'block';
                                        }
                                    });
                                </script>
                            </div>
                    </div>

                    <div class="primus-crm-actions-footer">
                        <div id="primusCrmSuccessMessage" class="primus-crm-success-alert primus-crm-hidden">
                            <i class="fas fa-check-circle"></i>
                            <span>Settings saved successfully!</span>
                        </div>
                        <button class="primus-crm-btn-save" id="primusCrmSaveBtn">
                            <i class="fas fa-save"></i>
                            <span id="primusCrmSaveBtnText">Save Changes</span>
                        </button>
                    </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
    {{-- Setting end --}}


    <script>
        // Initialize Bootstrap tabs and basic functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs if available and persist active tab in localStorage
            if (typeof bootstrap !== 'undefined') {
                var triggerTabList = [].slice.call(document.querySelectorAll('#primusCrmSettingsNav button'))
                triggerTabList.forEach(function(triggerEl) {
                    var tabTrigger = new bootstrap.Tab(triggerEl)
                    // Restore active tab from storage
                    var saved = localStorage.getItem('primusSettingsActiveTab');
                    if (saved && triggerEl.getAttribute('data-bs-target') === saved) {
                        tabTrigger.show();
                    }
                    triggerEl.addEventListener('shown.bs.tab', function(event) {
                        // store the target selector used for activation
                        var target = event.target.getAttribute('data-bs-target');
                        if (target) localStorage.setItem('primusSettingsActiveTab', target);
                    });
                    triggerEl.addEventListener('click', function(event) {
                        event.preventDefault()
                        tabTrigger.show()
                    })
                })
            }

            // Save button functionality
            document.getElementById('primusCrmSaveBtn').addEventListener('click', function() {
                const saveBtn = document.getElementById('primusCrmSaveBtn');
                const saveBtnText = document.getElementById('primusCrmSaveBtnText');
                const successMessage = document.getElementById('primusCrmSuccessMessage');

                saveBtn.disabled = true;
                saveBtnText.textContent = 'Saving...';

                setTimeout(() => {
                    saveBtn.disabled = false;
                    saveBtnText.textContent = 'Save Changes';
                    successMessage.classList.remove('primus-crm-hidden');

                    setTimeout(() => {
                        successMessage.classList.add('primus-crm-hidden');
                    }, 3000);
                }, 1000);
            });

            // Search functionality
            document.getElementById('primusCrmSearchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const navItems = document.querySelectorAll('#primusCrmSettingsNav .nav-item');

                navItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Toggle switch functionality
            document.querySelectorAll('.primus-crm-toggle-switch').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                });
            });
        });

        // Lead Process Management System
        (function() {
            // ---------- sample users (replace by real data in backend) ----------
            const USERS = [{
                    id: 'u1',
                    name: 'Ali Khan',
                    team: 'sales',
                    managerId: 'm1'
                },
                {
                    id: 'u2',
                    name: 'Sara Ali',
                    team: 'sales',
                    managerId: 'm1'
                },
                {
                    id: 'u3',
                    name: 'Omar Rehman',
                    team: 'sales',
                    managerId: 'm1'
                },
                {
                    id: 'u4',
                    name: 'Nadia Noor',
                    team: 'support',
                    managerId: 'm2'
                },
            ];
            const MANAGERS = [{
                    id: 'm1',
                    name: 'Manager - John Smith'
                },
                {
                    id: 'm2',
                    name: 'Manager - Sarah Khan'
                },
            ];

            // ---------- persistent storage helpers ----------
            const STORAGE_KEYS = {
                RULES: 'primus_rules_v1',
                ROTATIONS: 'primus_rotations_v1'
            };
            const readJSON = (k) => JSON.parse(localStorage.getItem(k) || '[]');
            const saveJSON = (k, v) => localStorage.setItem(k, JSON.stringify(v));

            // ---------- UI elements ----------
            const teamMembersEl = document.getElementById('teamMembers');
            const ruleMembersEl = document.getElementById('ruleMembers');
            const fallbackUserEl = document.getElementById('fallbackUser');
            const addRuleBtn = document.getElementById('addRuleBtn');
            const rulesListEl = document.getElementById('rulesList');
            const simulateBtn = document.getElementById('simulateLeadBtn');
            const notificationsEl = document.getElementById('notifications');
            const distTypeEl = document.getElementById('distType');
            const roundRobinEl = document.getElementById('roundRobin');
            const selectAllToggle = document.getElementById('selectAllToggle');

            // ---------- initialize UI lists ----------
            function populateUserSelects() {
                // teamMembers & ruleMembers
                [teamMembersEl, ruleMembersEl].forEach(sel => {
                    sel.innerHTML = '';
                    USERS.forEach(u => {
                        const opt = document.createElement('option');
                        opt.value = u.id;
                        opt.textContent = u.name + ' (' + u.team + ')';
                        sel.appendChild(opt);
                    });
                });

                // fallback managers
                fallbackUserEl.innerHTML = '';
                const choose = document.createElement('option');
                choose.textContent = 'Choose Fallback User';
                choose.value = '';
                choose.selected = true;
                fallbackUserEl.appendChild(choose);
                MANAGERS.forEach(m => {
                    const opt = document.createElement('option');
                    opt.value = m.id;
                    opt.textContent = m.name;
                    fallbackUserEl.appendChild(opt);
                });
            }

            // ---------- rules management ----------
            function loadRules() {
                return readJSON(STORAGE_KEYS.RULES) || [];
            }

            function saveRules(rules) {
                saveJSON(STORAGE_KEYS.RULES, rules);
            }

            function loadRotations() {
                return JSON.parse(localStorage.getItem(STORAGE_KEYS.ROTATIONS) || '{}');
            }

            function saveRotations(rot) {
                localStorage.setItem(STORAGE_KEYS.ROTATIONS, JSON.stringify(rot));
            }

            function renderRules() {
                const rules = loadRules();
                rulesListEl.innerHTML = '';
                if (!rules.length) {
                    rulesListEl.innerHTML = '<div class="primus-crm-form-help">No rules yet</div>';
                    return;
                }
                rules.forEach((r, idx) => {
                    const wrap = document.createElement('div');
                    wrap.className = 'border p-2 mb-2';
                    wrap.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <strong>${r.name}</strong> <small>[${r.enabled ? 'Enabled' : 'Disabled'}]</small><br>
                            <small>${r.source} • ${r.vehicle || 'Any'} • members: ${(r.members || []).map(id => userName(id)).join(', ') || '—'}</small>
                        </div>
                        <div>
                            <button data-idx="${idx}" class="primus-crm-btn primus-crm-btn-secondary btn-test">Test</button>
                            <button data-idx="${idx}" class="primus-crm-btn primus-crm-btn-tertiary btn-delete">Delete</button>
                        </div>
                    </div>
                `;
                    rulesListEl.appendChild(wrap);
                });

                // attach listeners
                rulesListEl.querySelectorAll('.btn-delete').forEach(b => {
                    b.addEventListener('click', () => {
                        const idx = +b.getAttribute('data-idx');
                        const rules = loadRules();
                        rules.splice(idx, 1);
                        saveRules(rules);
                        renderRules();
                        notify('Rule deleted');
                    });
                });
                rulesListEl.querySelectorAll('.btn-test').forEach(b => {
                    b.addEventListener('click', () => {
                        const idx = +b.getAttribute('data-idx');
                        const rules = loadRules();
                        const r = rules[idx];
                        simulateLead({
                            source: r.source,
                            vehicle: r.vehicle === 'any' ? 'new' : r.vehicle,
                            makeModel: r.makeModel || ''
                        }, true);
                    });
                });
            }

            function userName(id) {
                const u = USERS.find(x => x.id === id);
                return u ? u.name : id;
            }

            // ---------- add rule handler ----------
            addRuleBtn.addEventListener('click', () => {
                const name = document.getElementById('ruleName').value.trim();
                if (!name) {
                    return notify('Please provide a rule name', true);
                }
                const rule = {
                    id: 'r_' + Date.now(),
                    name,
                    enabled: document.getElementById('ruleEnable').value === 'yes',
                    vehicle: document.getElementById('ruleVehicle').value,
                    makeModel: document.getElementById('ruleMakeModel').value.trim(),
                    source: document.getElementById('ruleSource').value,
                    team: document.getElementById('ruleTeam').value,
                    members: Array.from(document.getElementById('ruleMembers').selectedOptions).map(o => o
                        .value)
                };

                // if select-all toggle active, assign all users of that team
                if (selectAllToggle.classList.contains('active')) {
                    rule.members = USERS.filter(u => u.team === rule.team).map(u => u.id);
                }

                const rules = loadRules();
                rules.unshift(rule);
                saveRules(rules);
                renderRules();
                notify('Rule added');
                // clear some inputs
                document.getElementById('ruleName').value = '';
                document.getElementById('ruleMakeModel').value = '';
            });

            // ---------- simulations / matching ----------
            document.getElementById('simulateLeadBtn').addEventListener('click', () => {
                const lead = {
                    source: document.getElementById('simSource').value,
                    vehicle: document.getElementById('simVehicle').value,
                    makeModel: document.getElementById('simMakeModel').value.trim()
                };
                simulateLead(lead, false);
            });

            function simulateLead(lead, isTest) {
                notify(
                    `Incoming lead — source: ${lead.source}, vehicle: ${lead.vehicle}, make/model: "${lead.makeModel}"`);
                // find first matching rule
                const rules = loadRules();
                const matched = rules.find(r => {
                    if (!r.enabled) return false;
                    if (r.source && r.source !== lead.source) return false;
                    if (r.vehicle && r.vehicle !== 'any' && r.vehicle !== lead.vehicle) return false;
                    if (r.makeModel && r.makeModel.length) {
                        return lead.makeModel.toLowerCase().includes(r.makeModel.toLowerCase());
                    }
                    return true;
                });

                if (matched) {
                    notify('Rule matched: ' + matched.name);
                    assignByRule(lead, matched);
                } else {
                    notify('No custom rule matched — using default distribution settings');
                    const distType = distTypeEl.value;
                    const members = Array.from(teamMembersEl.selectedOptions).map(o => o.value);
                    const tempRule = {
                        id: 'fallback_rule',
                        name: 'Default distribution',
                        members,
                        roundRobin: roundRobinEl.value === 'yes'
                    };
                    assignByRule(lead, tempRule);
                }
            }

            // ---------- assignment & round-robin ----------
            function assignByRule(lead, rule) {
                // rule may be a saved rule object or temp with members
                const members = rule.members || [];
                if (!members.length && (distTypeEl.value === 'individual' || distTypeEl.value === 'custom')) {
                    notify('No members selected to assign to!', true);
                    return;
                }

                const isRoundRobin = (roundRobinEl.value === 'yes') || (rule.roundRobin === true);
                if (distTypeEl.value === 'team') {
                    // Team: mark assigned to team (all members notified)
                    members.forEach(id => createAssignment(lead, id, rule, false));
                    notify('Assigned to team members: ' + members.map(userName).join(', '));
                    return;
                }

                if (!isRoundRobin) {
                    // Individual or custom but no RR: assign to first member
                    const assignee = members[0];
                    createAssignment(lead, assignee, rule, true);
                    return;
                }

                // Round robin path
                const rotations = loadRotations();
                const rotKey = rule.id;
                const list = members.slice(); // copy
                if (!rotations[rotKey]) rotations[rotKey] = {
                    index: 0
                };
                const idx = rotations[rotKey].index % list.length;
                const assignee = list[idx];
                // advance rotation for next time
                rotations[rotKey].index = (rotations[rotKey].index + 1) % list.length;
                saveRotations(rotations);
                createAssignment(lead, assignee, rule, true);
                notify('Round-robin assigned to ' + userName(assignee));
            }

            // ---------- create assignment + response-time handling ----------
            function createAssignment(lead, assigneeId, rule, startTimer) {
                const assignId = 'a_' + Date.now();
                const assignment = {
                    id: assignId,
                    lead,
                    assigneeId,
                    ruleId: rule.id || 'default',
                    assignedAt: Date.now(),
                    responded: false,
                    cycleCount: 0
                };
                // show assignment in notifications
                notify(`Assigned lead to ${userName(assigneeId)} (rule: ${rule.name || rule.id})`);
                // start timeout timer if required (simulate demo scaling)
                if (startTimer) {
                    const responseMinutes = Number(document.getElementById('responseTime').value) || 5;
                    const demo = document.getElementById('demoMode').checked;
                    const ms = demo ? (responseMinutes * 1000) : (responseMinutes * 60000);
                    // store assignment in memory (simple)
                    assignment.timeoutId = setTimeout(() => {
                        if (!assignment.responded) {
                            notify(
                                `${userName(assigneeId)} did not respond within ${responseMinutes} minute(s). Auto-reassigning...`);
                            handleReassign(assignment, rule);
                        }
                    }, ms);
                }
                // setup reminders if enabled
                if (document.getElementById('alertsToggle').classList.contains('active')) {
                    startReminders(assignment);
                }
                // display an actionable button for debugging (respond)
                showAssignmentAction(assignment);
            }

            function showAssignmentAction(assignment) {
                const el = document.createElement('div');
                el.className = 'border p-2 mb-2';
                el.innerHTML = `
                <div><strong>Assignment:</strong> ${userName(assignment.assigneeId)} — ${assignment.lead.source} / ${assignment.lead.vehicle} ${assignment.lead.makeModel ? ' / ' + assignment.lead.makeModel : ''}</div>
                <div style="margin-top:6px;">
                    <button class="primus-crm-btn primus-crm-btn-primary btn-respond">Mark Responded</button>
                    <button class="primus-crm-btn primus-crm-btn-tertiary btn-escalate">Escalate Now</button>
                </div>
            `;
                notificationsEl.prepend(el);
                el.querySelector('.btn-respond').addEventListener('click', () => {
                    assignment.responded = true;
                    if (assignment.timeoutId) clearTimeout(assignment.timeoutId);
                    notify(`${userName(assignment.assigneeId)} marked as responded — assignment closed.`);
                });
                el.querySelector('.btn-escalate').addEventListener('click', () => {
                    if (assignment.timeoutId) clearTimeout(assignment.timeoutId);
                    notify('Manually escalating assignment to fallback user.');
                    escalateToFallback(assignment);
                });
            }

            // ---------- reassign logic ----------
            function handleReassign(assignment, rule) {
                const cyclesAllowed = Number(document.getElementById('reassignmentCount').value) || 3;
                const demo = document.getElementById('demoMode').checked;
                // pick next user in members (if round-robin) else rotate index by cycleCount
                const members = rule.members || Array.from(teamMembersEl.selectedOptions).map(o => o.value);
                if (!members || !members.length) {
                    notify('No members to reassign to. Escalating to fallback.');
                    escalateToFallback(assignment);
                    return;
                }

                // maintain a counter in assignment
                assignment.cycleCount = (assignment.cycleCount || 0) + 1;
                // determine if cycles exhausted: cyclesAllowed means full cycles through members
                const rotations = loadRotations();
                // if rule has rotation state use it, else shift to next
                const rotKey = rule.id || 'default';
                if (!rotations[rotKey]) rotations[rotKey] = {
                    index: 0,
                    cycles: 0
                };
                // advance index to next
                rotations[rotKey].index = (rotations[rotKey].index + 1) % members.length;
                if (rotations[rotKey].index === 0) rotations[rotKey].cycles = (rotations[rotKey].cycles || 0) + 1;
                saveRotations(rotations);

                if ((rotations[rotKey].cycles || 0) >= cyclesAllowed) {
                    // escalate to fallback
                    notify('Reassignment cycles exhausted. Triggering fallback/escalation.');
                    escalateToFallback(assignment);
                    return;
                }

                // assign to next member
                const nextAssignee = members[rotations[rotKey].index];
                notify('Auto-reassigned to ' + userName(nextAssignee));
                createAssignment(assignment.lead, nextAssignee, rule, true);
            }

            function escalateToFallback(assignment) {
                const fallbackId = document.getElementById('fallbackUser').value;
                if (!fallbackId) {
                    notify('No fallback user selected; please configure one.', true);
                    return;
                }
                // notify manager
                notify('Escalated to fallback manager: ' + MANAGERS.find(m => m.id === fallbackId).name);
                if (document.getElementById('managerNotifToggle').classList.contains('active')) {
                    // show explicit manager notification
                    notify('Manager notified via bell. (Email simulation not implemented here)');
                }
            }

            // ---------- reminders ----------
            function startReminders(assignment) {
                const freq = Number(document.getElementById('alertFrequency').value) || 5;
                const repeat = Number(document.getElementById('alertRepeat').value) || 4;
                const demo = document.getElementById('demoMode').checked;
                const ms = demo ? (freq * 1000) : (freq * 60000);
                let sent = 0;
                const reminderId = setInterval(() => {
                    if (assignment.responded || sent >= repeat) {
                        clearInterval(reminderId);
                        return;
                    }
                    sent++;
                    notify(`Reminder #${sent} → ${userName(assignment.assigneeId)} to respond to lead.`);
                }, ms);
            }

            // ---------- small helpers ----------
            function notify(msg, isError) {
                const d = document.createElement('div');
                d.style.padding = '6px';
                d.style.marginBottom = '6px';
                d.style.borderRadius = '6px';
                d.style.background = isError ? '#fdecea' : '#f1f6ff';
                d.textContent = '[' + new Date().toLocaleTimeString() + '] ' + msg;
                notificationsEl.prepend(d);
            }

            // ---------- team selection update ----------
            document.getElementById('ruleTeam').addEventListener('change', (e) => {
                const team = e.target.value;
                // auto-select members of team in ruleMembers
                Array.from(ruleMembersEl.options).forEach(opt => {
                    opt.selected = (team && USERS.find(u => u.id === opt.value && u.team === team) !=
                        null);
                });
            });

            // select all toggle functionality
            selectAllToggle.addEventListener('click', () => {
                selectAllToggle.classList.toggle('active');
                if (selectAllToggle.classList.contains('active')) {
                    // select all members of currently selected team
                    const team = document.getElementById('ruleTeam').value;
                    Array.from(ruleMembersEl.options).forEach(opt => {
                        opt.selected = (team ? USERS.find(u => u.id === opt.value && u.team === team) !=
                            null : true);
                    });
                } else {
                    Array.from(ruleMembersEl.options).forEach(opt => opt.selected = false);
                }
            });

            // ---------- initial population ----------
            populateUserSelects();
            renderRules();

            // expose some helpers for console debug (optional)
            window.__primus_debug = {
                loadRules,
                saveRules,
                loadRotations,
                saveRotations
            };

        })();
    </script>



    <div id="holidayModal" class="primus-crm-holiday-modal" style="display: none;">
        <div class="primus-crm-holiday-modal-content">
            <div class="primus-crm-holiday-modal-header">
                <h3>Add Holiday Override</h3>
                <span class="primus-crm-holiday-modal-close" onclick="closeHolidayModal()">&times;</span>
            </div>
            <div class="primus-crm-holiday-modal-body">
                <div class="primus-crm-form-group">
                    <label>Holiday Name</label>
                    <input type="text" id="holidayName" class="primus-crm-form-control"
                        placeholder="e.g., Christmas Day, Store Event">
                </div>
                <div class="primus-crm-form-group">
                    <label>Select Date</label>
                    <input type="text" id="holidayDate" class="form-control mb-2 cf-datepicker"
                        placeholder="Click to select date" readonly>
                </div>
                <div class="primus-crm-form-group">
                    <label class="primus-crm-custom-checkbox">
                        <input type="checkbox" id="holidayClosed" onchange="toggleHolidayHours(this)">
                        <span>Store Closed</span>
                    </label>
                </div>
                <div id="holidayHoursSection">
                    <div class="primus-crm-form-group">
                        <label>Custom Hours</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <select class="primus-crm-time-dropdown" id="holidayStartTime">
                                <option value="">Start Time</option>
                            </select>
                            <span>to</span>
                            <select class="primus-crm-time-dropdown" id="holidayEndTime">
                                <option value="">End Time</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="primus-crm-holiday-modal-footer">
                <button type="button" class="primus-crm-btn primus-crm-btn-secondary"
                    onclick="closeHolidayModal()">Cancel</button>
                <button type="button" class="primus-crm-btn primus-crm-btn-primary" onclick="saveHoliday()">Save
                    Holiday</button>
            </div>
        </div>
    </div>

@endsection



@push('styles')
    <style>
        .primus-crm-main-content,
        .tab-content,
        .tab-pane,
        .primus-crm-settings-section {
            min-width: 0;
        }
    </style>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: rgb(0, 33, 64);
            /* Deep blue */
            --primary-dark: rgb(0, 28, 51);
            /* Darker blue */
            --primary-light: rgb(102, 132, 175);
            /* Light muted blue */
            --secondary: rgb(36, 123, 160);
            /* Muted blue-gray */
            --success: rgb(40, 167, 69);
            /* Soft green */
            --danger: rgb(220, 53, 69);
            /* Soft red */
            --warning: rgb(255, 193, 7);
            /* Warm yellow */
            --bg-light: #f1f5f9;
            /* Light grayish background */
            --bg-card: #ffffff;
            /* White for cards */
            --text-primary: #1e293b;
            /* Dark grayish blue for text */
            --text-secondary: #475569;
            /* Muted grayish blue */
            --border: #d1d5db;
            /* Light gray border */
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .search-area button {
            width: 40px
        }

        .nav-tabs .nav-link {
            width: 100%;
            border: none !important;
            border-top-left-radius: 8px !important;
            border-top-right-radius: 8px !important;

            text-align: left;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--cf-primary) !important;
            color: #fff !important;
        }

        .nav-tabs .nav-link.active i {
            color: #fff !important;
        }

        body.dark-mode {
            --bg-light: #0f172a;
            --bg-card: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: #334155;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .primus-crm-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .dark-mode .primus-crm-header {
            background: rgba(30, 41, 59, 0.95);
            border-bottom-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-logo {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .primus-crm-header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .primus-crm-icon-btn {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--bg-light);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .primus-crm-icon-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .primus-crm-notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--bg-card);
            animation: primus-crm-pulse 2s infinite;
        }

        @keyframes primus-crm-pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .primus-crm-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--bg-light);
            border-radius: 12px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .primus-crm-user-info:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .primus-crm-user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .primus-crm-user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .primus-crm-container {
            max-width: 100%;
            margin: 1rem auto;
            padding: 0 2rem;
        }

        .primus-crm-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2rem;
            animation: primus-crm-fadeIn 0.5s ease;
        }

        @keyframes primus-crm-fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .primus-crm-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-xl);
            position: sticky;
            top: 0;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            border: 1px solid #ddd;
        }

        @media only screen and (min-width:1600px) {
            .primus-crm-sidebar {
                max-height: calc(100vh - 120px) !important;

            }
        }

        .dark-mode .primus-crm-sidebar {
            background: rgba(30, 41, 59, 0.95);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-sidebar::-webkit-scrollbar {
            width: 6px;

        }

        .primus-crm-sidebar::-webkit-scrollbar-track {
            background: transparent;
            margin-top: 30px;

        }

        .primus-crm-sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .primus-crm-search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .primus-crm-search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 0.875rem;
            background: var(--bg-light);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .primus-crm-search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .primus-crm-menu-section {
            margin-bottom: 0.5rem;
        }

        .primus-crm-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1rem;
            background: transparent;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .primus-crm-menu-header:hover {
            background: var(--bg-light);
        }

        .primus-crm-menu-header-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .primus-crm-menu-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .primus-crm-menu-arrow {
            transition: transform 0.3s ease;
            color: var(--text-secondary);
        }

        .primus-crm-menu-header.expanded .primus-crm-menu-arrow {
            transform: rotate(90deg);
        }

        .primus-crm-submenu {
            /* margin-left: 3rem; */
            margin-top: 0.25rem;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }

        .primus-crm-submenu.show {
            max-height: 1000px;
        }

        .primus-crm-submenu-item {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-align: left;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }

        .primus-crm-submenu-item:hover {
            background: var(--primary);
            color: #fff;
            transform: translateX(4px);
        }

        .primus-crm-submenu-item.active {
            background: var(--primary);
            color: white;
            font-weight: 500;

        }

        .primus-crm-main-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid #ddd;

            min-height: 600px;


            max-width: 100%;
            overflow: hidden;
        }

        .dark-mode .primus-crm-main-content {
            background: rgba(30, 41, 59, 0.95);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-content-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }

        .primus-crm-content-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .primus-crm-content-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .primus-crm-settings-section {
            margin-bottom: 2rem;
        }

        .primus-crm-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .primus-crm-section-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
        }

        .primus-crm-subtitle {
            font-size: 18px;
            margin-bottom: 14px !important;
        }

        .primus-crm-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .primus-crm-form-group {
            margin-bottom: 1.5rem;
        }

        .primus-crm-form-group.full-width {
            grid-column: 1 / -1;
        }

        .primus-crm-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .primus-crm-form-help {
            display: block;
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .primus-crm-form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 0.875rem;
            background: #fff;
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .primus-crm-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            background: var(--bg-card);
        }

        .primus-crm-form-control:hover {
            border-color: var(--primary-light);
        }

        textarea.primus-crm-form-control {
            resize: vertical;
            min-height: 100px;
        }

        .primus-crm-toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
            background: var(--border);
            border-radius: 13px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .primus-crm-toggle-switch.active {
            background: var(--primary);
        }

        .primus-crm-toggle-switch::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .primus-crm-toggle-switch.active::after {
            transform: translateX(24px);
        }

        .primus-crm-setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--bg-light);
            border: 2px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .primus-crm-setting-row:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-setting-info {
            flex: 1;
        }

        .primus-crm-setting-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .primus-crm-setting-desc {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .primus-crm-hours-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: var(--bg-light);
            border: 2px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .primus-crm-hours-row:hover {
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-day-name {
            font-weight: 600;
            min-width: 120px;
            text-transform: capitalize;
            color: var(--text-primary);
        }

        .primus-crm-custom-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
        }

        .primus-crm-custom-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            position: relative;
        }

        .primus-crm-custom-checkbox input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .primus-crm-custom-checkbox input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.875rem;
        }

        .primus-crm-time-input {
            padding: 0.625rem 0.875rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            background: var(--bg-card);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .primus-crm-time-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .primus-crm-color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .primus-crm-color-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--border);
        }

        .primus-crm-slider-container {
            width: 100%;
        }

        .primus-crm-slider {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: var(--border);
            outline: none;
            -webkit-appearance: none;
        }

        .primus-crm-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
        }

        .primus-crm-slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            border: none;
        }

        .primus-crm-slider-value {
            display: inline-block;
            margin-left: 1rem;
            font-weight: 600;
            color: var(--primary);
        }

        .primus-crm-actions-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border);
        }

        .primus-crm-btn-save {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.875rem 2rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            /* box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); */
        }

        .primus-crm-btn-save:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 8px 20px rgba(99, 102, 241, 0.5); */
        }

        .primus-crm-btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .primus-crm-success-alert {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1.5rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            animation: primus-crm-slideIn 0.3s ease;
        }

        @keyframes primus-crm-slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .primus-crm-notification-panel {
            position: fixed;
            right: 2rem;
            top: 100px;
            width: 420px;
            max-height: 600px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(226, 232, 240, 0.5);
            overflow: hidden;
            z-index: 200;
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark-mode .primus-crm-notification-panel {
            background: rgba(30, 41, 59, 0.98);
            border-color: rgba(51, 65, 85, 0.5);
        }

        .primus-crm-notification-panel.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .primus-crm-notification-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-notification-title {
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--text-primary);
        }

        .primus-crm-notification-list {
            max-height: 480px;
            overflow-y: auto;
        }

        .primus-crm-notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .primus-crm-notification-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .primus-crm-notification-list::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .primus-crm-notification-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .primus-crm-notification-item:hover {
            background: var(--bg-light);
        }

        .primus-crm-notification-content {
            display: flex;
            gap: 1rem;
        }

        .primus-crm-notification-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .primus-crm-notification-body {
            flex: 1;
        }

        .primus-crm-notification-user {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .primus-crm-notification-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .primus-crm-notification-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .primus-crm-notification-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .primus-crm-btn-dismiss {
            background: transparent;
            border: none;
            color: var(--danger);
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .primus-crm-btn-dismiss:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .primus-crm-hidden {
            display: none !important;
        }

        @media (max-width: 1024px) {
            /* .primus-crm-layout {
                  grid-template-columns: 1fr;
              } */

            .primus-crm-sidebar {
                position: static;
                max-height: none;
            }

            .primus-crm-notification-panel {
                width: calc(100% - 4rem);
                right: 2rem;
            }
        }

        @media (max-width: 768px) {
            .primus-crm-header-content {
                padding: 1rem;
            }

            .primus-crm-user-name {
                display: none;
            }

            .primus-crm-container {
                padding: 0 1rem;
            }

            .primus-crm-main-content {
                padding: 1.5rem;
            }

            .primus-crm-form-grid {
                grid-template-columns: 1fr;
            }

            .primus-crm-hours-row {
                flex-wrap: wrap;
            }
        }
    </style>



    <style>
        .compare-col {
            border: 1px solid rgb(0, 33, 64);
        }

        .col-title {
            background: rgb(0, 33, 64);
            color: #fff;
            padding: 8px;
            font-weight: 600;
        }

        .compare-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px dashed #e9ecef;
        }

        .compare-field {
            font-size: .85rem;
            color: #6c757d;
        }

        .toast-container {
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 1200;
        }

        .btn-merge {
            margin-bottom: 12px;
        }
    </style>
@endpush
