@extends('layouts.app')


@section('title', 'Users')

@push('styles')
    <style>
        /* Hide inactive users by default */
        tr.user-inactive {
            display: none;
        }

        /* Show inactive users when toggle is checked */
        tr.user-active.hide-active {
            display: none;
        }

        tr.user-inactive.show-inactive {
            display: table-row;
        }
    </style>
@endpush

@section('content')
    <div class="content content-two pt-0">

        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
            style="min-height: 80px;">

            <!-- Left: Title -->
            <div>
                <h6 class="mb-0">Users</h6>
            </div>

            <!-- Center: Logo -->
            <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <!-- Right: Buttons -->
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <!-- Trigger Button -->
                <div>
                    <button class="btn btn-light border-1 border d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#duplicateUserModal">
                        Duplicate From Existing
                    </button>
                </div>

                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="isax isax-export-1 me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('users.export.pdf') }}">Download as PDF</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="exportToExcel()">Download as
                                Excel</a></li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('add-user') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="isax isax-add-circle5 me-1"></i>New User
                    </a>
                </div>
            </div>

        </div>

        <!-- End Page Header -->

        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="table-search d-flex align-items-center mb-0">
                        <div class="search-input input-group">
                            <input type="text" id="usersSearchInput" class="form-control form-control-sm"
                                placeholder="Search users...">
                            <button class="btn btn-light btn-searchset" id="usersSearchBtn" type="button"></button>
                        </div>
                    </div>

                </div>
                <div class="d-flex align-items-center gap-2">
                    <button id="bulkDeleteBtn" class="btn btn-danger btn-sm" style="display: none;"
                        onclick="bulkDeleteUsers()">
                        <i class="isax isax-trash me-1"></i>Delete Selected (<span id="selectedCount">0</span>)
                    </button>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="inactiveToggle">
                        <label class="form-check-label " for="inactiveToggle">Show Inactive Users</label>
                    </div>
                </div>
            </div>
            <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                <h6 class="fs-13 fw-semibold">Filters</h6>
                <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                        class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Users
                    Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
                        class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Status
                    Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
                <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-nowrap table-hover mb-0">
                <thead class="thead-light" style="background:rgb(0,33,64);">
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th style=" color:white;">Name</th>
                        <th style=" color:white;">Email</th>
                        <th style=" color:white;">Work Phone</th>
                        <th style=" color:white;">Cell Phone</th>
                        <th style=" color:white;">Role</th>
                        <th style=" color:white;">Status</th>
                        <th style=" color:white;">Last Login</th>
                        <th style=" color:white;">Created On</th>
                        <th class="no-sort text-end" style=" color:white;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr class="{{ $user->is_active ? 'user-active' : 'user-inactive' }}">
                            <td>
                                <div class="form-check form-check-md">
                                    <input class="form-check-input user-checkbox" type="checkbox"
                                        data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                </div>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->work_phone ?? 'N/A' }}</td>
                            <td>{{ $user->cell_phone ?? 'N/A' }}</td>
                            <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}</td>
                            <td>
                                @if ($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->format('d M Y, h:i A') : 'Never' }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="dropdown table-dropdown">
                                    <button class="btn btn-sm btn-light" type="button">
                                        <i class="isax isax-more"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('users.edit', $user->id) }}" class="dropdown-item">
                                                <i class="isax isax-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item toggle-status"
                                                data-user-id="{{ $user->id }}">
                                                <i
                                                    class="ti ti-lock-open-off me-2"></i>{{ $user->is_active ? 'Inactivate' : 'Activate' }}
                                                User
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item send-reset"
                                                data-user="{{ $user->email }}">
                                                <i class="ti ti-send me-2"></i>Send Password Reset Email
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item text-danger delete-user"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                <i class="isax isax-trash me-2"></i>Delete User
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <p class="mb-0">No users found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        @if (method_exists($users, 'links'))
            <div class="d-flex justify-content-center mt-3">
                {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
        <!-- Delete User Modal -->
        <div class="modal fade" id="delete_user_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <img src="assets/img/icons/delete.svg" alt="img">
                        </div>
                        <h6 class="mb-1">Delete User</h6>
                        <p class="mb-3" id="delete_user_modal_text">Are you sure you want to delete this user?</p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button type="button" class="btn btn-light border border-1"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirm_delete_user_btn">Yes,
                                Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="duplicateUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select User to Duplicate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select id="userSelect" class="form-select">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button onclick="duplicateUser()" class="btn btn-primary">Duplicate</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdowns = document.querySelectorAll('.table-dropdown');

                dropdowns.forEach(dropdown => {
                    const button = dropdown.querySelector('button');
                    const menu = dropdown.querySelector('.dropdown-menu');

                    // Append menu to body
                    document.body.appendChild(menu);

                    let popperInstance = null;

                    function createPopper() {
                        popperInstance = Popper.createPopper(button, menu, {
                            placement: 'bottom-end',
                            modifiers: [{
                                    name: 'offset',
                                    options: {
                                        offset: [0, 5]
                                    }
                                },
                                {
                                    name: 'preventOverflow',
                                    options: {
                                        boundary: 'viewport'
                                    }
                                }
                            ]
                        });
                    }

                    function destroyPopper() {
                        if (popperInstance) {
                            popperInstance.destroy();
                            popperInstance = null;
                        }
                    }

                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (menu.classList.contains('show')) {
                            menu.classList.remove('show');
                            destroyPopper();
                        } else {
                            menu.classList.add('show');
                            createPopper();
                        }
                    });

                    document.addEventListener('click', function(e) {
                        if (!dropdown.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.remove('show');
                            destroyPopper();
                        }
                    });
                });
            });
        </script>
        <script>
            // User data from server
            const userData = {
                @foreach ($users as $user)
                    {{ $user->id }}: {
                        fullName: "{{ $user->name }}",
                        email: "{{ $user->email }}",
                        workPhone: "{{ $user->work_phone ?? 'N/A' }}",
                        cellPhone: "{{ $user->cell_phone ?? 'N/A' }}",
                        role: "{{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}",
                        lastLogin: "{{ $user->last_login_at ? $user->last_login_at->format('d M Y, h:i A') : 'Never' }}",
                        createdOn: "{{ $user->created_at->format('d M Y') }}",
                        profileImg: "{{ $user->profile_photo ? asset($user->profile_photo) : asset('assets/light_logo.png') }}"
                    },
                @endforeach
            };

            function duplicateUser() {
                const selectedId = document.getElementById("userSelect").value;
                if (!selectedId) {
                    alert("Please select a user!");
                    return;
                }

                const user = userData[selectedId];
                if (!user) {
                    alert("User data not found!");
                    return;
                }

                // Redirect to add user page with user ID parameter for duplication
                window.location.href = "{{ route('add-user') }}?duplicate=" + selectedId;
            }
        </script>
     <script>
      document.addEventListener('DOMContentLoaded', function() {
      
          // Global modal instance
          const deleteUserModalEl = document.getElementById('delete_user_modal');
          const deleteUserModal = new bootstrap.Modal(deleteUserModalEl);
      
          let deleteUserId = null;
      
          // Event delegation for delete-user buttons
          document.addEventListener('click', function(e) {
              const btn = e.target.closest('.delete-user');
              if (!btn) return;
      
              e.preventDefault();
              deleteUserId = btn.dataset.userId;
              const userName = btn.dataset.userName || "this user";
      
              // Set modal text dynamically
              document.getElementById('delete_user_modal_text').textContent =
                  `Are you sure you want to delete ${userName}? This action cannot be undone!`;
      
              // Show modal
              deleteUserModal.show();
          });
      
          // Confirm delete
          document.getElementById('confirm_delete_user_btn').addEventListener('click', function() {
              if (!deleteUserId) return;
      
              // Optional: disable button to prevent multiple clicks
              this.disabled = true;
      
              fetch(`/users/${deleteUserId}`, {
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                      'Accept': 'application/json'
                  }
              })
              .then(response => {
                  if (!response.ok) throw new Error('Network response was not ok');
                  return response.json();
              })
              .then(data => {
                  // Hide modal
                  deleteUserModal.hide();
                  this.disabled = false;
      
                  if (data.success) {
                      Swal.fire({
                          title: 'Deleted!',
                          text: data.message || 'User has been deleted.',
                          icon: 'success',
                          confirmButtonColor: 'rgb(0, 33, 64)'
                      }).then(() => location.reload());
                  } else {
                      Swal.fire({
                          title: 'Error!',
                          text: data.message || 'Failed to delete user.',
                          icon: 'error',
                          confirmButtonColor: 'rgb(0, 33, 64)'
                      });
                  }
      
                  deleteUserId = null;
              })
              .catch(error => {
                  deleteUserModal.hide();
                  this.disabled = false;
                  deleteUserId = null;
                  console.error('Delete error:', error);
      
                  Swal.fire({
                      title: 'Error!',
                      text: 'An error occurred. Please try again.',
                      icon: 'error',
                      confirmButtonColor: 'rgb(0, 33, 64)'
                  });
              });
          });
      
      });
      </script>
      
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const toggle = document.getElementById("inactiveToggle");
                const activeRows = document.querySelectorAll(".user-active");
                const inactiveRows = document.querySelectorAll(".user-inactive");
                const selectAllCheckbox = document.getElementById('select-all');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');

                function filterRows() {
                    if (toggle.checked) {
                        // Show only inactive users
                        activeRows.forEach(row => row.classList.add('hide-active'));
                        inactiveRows.forEach(row => row.classList.add('show-inactive'));
                    } else {
                        // Show only active users (default)
                        activeRows.forEach(row => row.classList.remove('hide-active'));
                        inactiveRows.forEach(row => row.classList.remove('show-inactive'));
                    }

                    // Uncheck all checkboxes when filter changes
                    selectAllCheckbox.checked = false;
                    userCheckboxes.forEach(cb => cb.checked = false);

                    // Update bulk delete button
                    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                    if (bulkDeleteBtn) {
                        bulkDeleteBtn.style.display = 'none';
                    }
                }

                // Run when toggle changes
                toggle.addEventListener("change", filterRows);
            });
        </script>

        <script>
            // Select All Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                const selectedCountSpan = document.getElementById('selectedCount');

                // Handle select all
                selectAllCheckbox.addEventListener('change', function() {
                    // Get only visible checkboxes (force reflow to ensure CSS is applied)
                    const visibleCheckboxes = Array.from(userCheckboxes).filter(cb => {
                        const row = cb.closest('tr');
                        if (!row) return false;

                        // Force browser to recalculate styles
                        const display = window.getComputedStyle(row).display;
                        return display !== 'none';
                    });

                    // Check/uncheck only visible checkboxes
                    visibleCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });

                    updateBulkDeleteButton();
                });

                // Handle individual checkbox changes
                userCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateBulkDeleteButton();

                        // Update select-all checkbox state
                        const visibleCheckboxes = Array.from(userCheckboxes).filter(cb => {
                            const row = cb.closest('tr');
                            return row && window.getComputedStyle(row).display !== 'none';
                        });
                        const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb =>
                            cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    });
                });

                // Update bulk delete button visibility and count
                function updateBulkDeleteButton() {
                    // Only count visible and checked checkboxes
                    const selectedCheckboxes = Array.from(userCheckboxes).filter(cb => {
                        if (!cb.checked) return false;
                        const row = cb.closest('tr');
                        if (!row) return false;
                        const display = window.getComputedStyle(row).display;
                        return display !== 'none';
                    });
                    const count = selectedCheckboxes.length;

                    if (count > 0) {
                        bulkDeleteBtn.style.display = 'inline-block';
                        selectedCountSpan.textContent = count;
                    } else {
                        bulkDeleteBtn.style.display = 'none';
                    }
                }
            });

            // Bulk Delete Users Function
            function bulkDeleteUsers() {
                const selectedCheckboxes = Array.from(document.querySelectorAll('.user-checkbox:checked'));
                const userIds = selectedCheckboxes.map(cb => cb.dataset.userId);
                const userNames = selectedCheckboxes.map(cb => cb.dataset.userName);

                if (userIds.length === 0) {
                    Swal.fire({
                        title: 'No Users Selected',
                        text: 'Please select at least one user to delete.',
                        icon: 'warning',
                        confirmButtonColor: 'rgb(0, 33, 64)'
                    });
                    return;
                }

                const userList = userNames.length <= 5 ?
                    userNames.join(', ') :
                    `${userNames.slice(0, 5).join(', ')} and ${userNames.length - 5} more`;

                Swal.fire({
                    title: 'Delete Multiple Users?',
                    html: `Are you sure you want to delete <strong>${userIds.length}</strong> user(s)?<br><br><em>${userList}</em><br><br>This action cannot be undone!`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: 'rgb(0, 33, 64)',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete the selected users.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Send AJAX request to bulk delete
                        fetch('/users/bulk-delete', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    user_ids: userIds
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonColor: 'rgb(0, 33, 64)',
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Failed to delete users.',
                                        icon: 'error',
                                        confirmButtonColor: 'rgb(0, 33, 64)'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonColor: 'rgb(0, 33, 64)'
                                });
                            });
                    }
                });
            }
        </script>

        <script>
            // Client-side search for users table
            (function() {
                function normalize(s) {
                    return (s || '').toString().toLowerCase();
                }

                const input = document.getElementById('usersSearchInput');
                const btn = document.getElementById('usersSearchBtn');
                const toggle = document.getElementById('inactiveToggle');
                const tbody = document.querySelector('table.table tbody');

                if (!input || !tbody) return;

                function applyFilter() {
                    const q = normalize(input.value).trim();
                    const rows = Array.from(tbody.querySelectorAll('tr'));

                    rows.forEach(row => {
                        const text = normalize(row.textContent);
                        const isActive = row.classList.contains('user-active');
                        const isInactive = row.classList.contains('user-inactive');

                        const matches = q === '' || text.indexOf(q) !== -1;

                        if (!matches) {
                            row.style.display = 'none';
                            return;
                        }

                        // Respect the inactive toggle: when checked show inactive rows only, otherwise show active rows only
                        if (toggle && toggle.checked) {
                            if (isInactive) row.style.display = '';
                            else row.style.display = 'none';
                        } else {
                            if (isActive) row.style.display = '';
                            else row.style.display = 'none';
                        }
                    });

                    // Update select-all checkbox state after filtering
                    const selectAll = document.getElementById('select-all');
                    if (selectAll) {
                        const visibleCheckboxes = Array.from(document.querySelectorAll('.user-checkbox')).filter(cb => {
                            const row = cb.closest('tr');
                            return row && window.getComputedStyle(row).display !== 'none';
                        });
                        selectAll.checked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
                    }
                }

                // wire events
                input.addEventListener('input', applyFilter);
                btn.addEventListener('click', () => {
                    input.focus();
                    applyFilter();
                });

                // also re-run filter when inactive toggle changes (so results stay in sync)
                if (toggle) toggle.addEventListener('change', applyFilter);
            })();

            // Export to Excel function
            function exportToExcel() {
                // Prepare data for export
                const data = [
                    ['Employee #', 'First Name', 'Last Name', 'Email', 'Work Phone', 'Cell Phone', 'Role', 'Status',
                        'Last Login', 'Created On'
                    ]
                ];

                // Add all user data
                @foreach ($users as $user)
                    @php
                        $nameParts = array_filter(explode(' ', trim($user->name)));
                        $firstName = $nameParts[0] ?? '';
                        $lastName = end($nameParts) !== $firstName ? end($nameParts) : '';
                    @endphp
                    data.push([
                        '{{ $user->employee_number ?? 'N/A' }}',
                        '{{ $firstName }}',
                        '{{ $lastName }}',
                        '{{ $user->email }}',
                        '{{ $user->work_phone ?? 'N/A' }}',
                        '{{ $user->cell_phone ?? 'N/A' }}',
                        '{{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}',
                        '{{ $user->is_active ? 'Active' : 'Inactive' }}',
                        '{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}',
                        '{{ $user->created_at->format('M d, Y') }}'
                    ]);
                @endforeach

                // Create workbook and worksheet
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.aoa_to_sheet(data);

                // Set column widths
                ws['!cols'] = [{
                        wch: 12
                    }, // Employee #
                    {
                        wch: 15
                    }, // First Name
                    {
                        wch: 15
                    }, // Last Name
                    {
                        wch: 25
                    }, // Email
                    {
                        wch: 15
                    }, // Work Phone
                    {
                        wch: 15
                    }, // Cell Phone
                    {
                        wch: 20
                    }, // Role
                    {
                        wch: 10
                    }, // Status
                    {
                        wch: 20
                    }, // Last Login
                    {
                        wch: 15
                    } // Created On
                ];

                // Style the header row
                const range = XLSX.utils.decode_range(ws['!ref']);
                for (let col = range.s.c; col <= range.e.c; col++) {
                    const cell_address = XLSX.utils.encode_cell({
                        r: 0,
                        c: col
                    });
                    if (!ws[cell_address]) continue;
                    ws[cell_address].s = {
                        font: {
                            bold: true,
                            color: {
                                rgb: "FFFFFF"
                            }
                        },
                        fill: {
                            fgColor: {
                                rgb: "002140"
                            }
                        },
                        alignment: {
                            horizontal: "center"
                        }
                    };
                }

                // Add worksheet to workbook
                XLSX.utils.book_append_sheet(wb, ws, "Users");

                // Generate filename with timestamp
                const timestamp = new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-');
                const filename = `users_${timestamp}.xlsx`;

                // Download the file
                XLSX.writeFile(wb, filename);
            }
        </script>


    </div>


@endsection
