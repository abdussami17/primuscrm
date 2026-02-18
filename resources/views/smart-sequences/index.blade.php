@extends('layouts.app')

@section('title', 'Smart Follow-Up')

@section('content')
<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
        style="min-height: 80px;">
       

        <!-- Left: Title -->
        <div>
            <h6 class="mb-0">Smart Follow-Up</h6>
        </div>
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <!-- Center: Logo -->
        <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" class="mobile-logo-no logo-img"
            style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

        <!-- Right: Buttons -->
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <button class="btn btn-danger d-flex align-items-center me-2" id="deleteSequencesBtn" title="Delete selected" type="button">
                <i class="isax isax-trash-2 me-1"></i>
                Delete
            </button>
            <button class="btn btn-light border border-1" onclick="window.print()">
                <i class="isax isax-printer me-1"></i>
                Print
            </button>
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                    data-bs-toggle="dropdown">
                    <i class="isax isax-export-1 me-1"></i>Export
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('smart-sequences.export', ['format' => 'pdf']) }}">PDF</a></li>
                    <li><a class="dropdown-item" href="{{ route('smart-sequences.export', ['format' => 'xlsx']) }}">Excel (XLSX)</a></li>
                    <li><a class="dropdown-item" href="{{ route('smart-sequences.export', ['format' => 'csv']) }}">Excel (CSV)</a></li>
                </ul>
            </div>

            <div>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addSmartSequenceModal"
                    class="btn btn-primary d-flex align-items-center" id="createSequenceBtn">
                    <i class="isax isax-add-circle me-2"></i>Create Follow-Up
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="table-search d-flex align-items-center mb-0">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th class="no-sort">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <th>Follow-Up Name</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created On</th>
                    <th>Last Sent</th>
                    <th>Last Edit Date</th>
                    <th>Last Edit By</th>
                    <th>Sent</th>
                    <th>Bounced</th>
                    <th>Invalid</th>
                    <th>CASL Restricted</th>
                    <th>Appointments</th>
                    <th>Unsubscribed</th>
                    <th>Delivered</th>
                    <th>Opened</th>
                    <th>Clicked</th>
                    <th>Replied</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sequences as $sequence)
                <tr data-sequence-id="{{ $sequence->id }}">
                    <td>
                        <div class="form-check form-check-md">
                            <input class="form-check-input row-select" type="checkbox" value="{{ $sequence->id }}">
                        </div>
                    </td>
                    <td>
                        <a href="javascript:void(0)" 
                           class="text-primary text-decoration-none edit-sequence-link" 
                           data-sequence-id="{{ $sequence->id }}"
                           data-sequence-title="{{ $sequence->title }}"
                           data-sequence-criteria="{{ json_encode($sequence->criteriaGroups ?? []) }}"
                           data-sequence-actions="{{ json_encode($sequence->actions ?? []) }}"
                           style="cursor: pointer;">
                            <strong>{{ $sequence->title }}</strong>
                        </a>
                        <a href="javascript:void(0)" class="ms-2 text-muted copy-sequence" data-sequence-id="{{ $sequence->id }}" title="Copy sequence">
                            <i class="isax isax-copy" style="font-size:14px;cursor:pointer"></i>
                        </a>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" 
                                id="toggle-{{ $sequence->id }}"
                                data-id="{{ $sequence->id }}"
                                data-bs-toggle="tooltip" 
                                data-bs-title="{{ $sequence->is_active ? 'Active' : 'Inactive' }}" 
                                title="{{ $sequence->is_active ? 'Active' : 'Inactive' }}"
                                {{ $sequence->is_active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>{{ $sequence->creator->name ?? 'N/A' }}</td>
                    <td>{{ $sequence->created_at->format('M d, Y g:i A') }}</td>
                    <td>{{ $sequence->last_sent_at ? $sequence->last_sent_at->format('M d, Y') : '-' }}</td>
                    <td>{{ $sequence->edited_at?->format('M d, Y h:i A') ?? '-' }}</td>
                    <td>{{ $sequence->editor?->name ?? '-' }}</td>                                       
                    <td>{{ $sequence->sent_count }}</td>
                    <td>{{ $sequence->bounced_count }}</td>
                    <td>{{ $sequence->invalid_count }}</td>
                    <td>{{ $sequence->casl_restricted_count }}</td>
                    <td>{{ $sequence->appointments_count }}</td>
                    <td>{{ $sequence->unsubscribed_count }}</td>
                    <td>{{ $sequence->delivered_count }}</td>
                    <td>{{ $sequence->opened_count }}</td>
                    <td>{{ $sequence->clicked_count }}</td>
                    <td>{{ $sequence->replied_count }}</td>
                </tr>
                @empty
               
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sequences->links() }}
</div>

<!-- Create/Edit Smart Sequence Modal -->
@include('smart-sequences.partials.modal', [
    'fieldConfig' => $fieldConfig ?? [],
    'actionConfig' => $actionConfig ?? [],
    'users' => $users ?? [],
    'templates' => $templates ?? [],
])

<!-- Floating minimized bar -->
<div id="minimizedBar" class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow rounded"
    style="cursor:pointer; z-index: 1050;">
    Sequence
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prevent double-initialization when the script is included/executed more than once
    if (window.smartSequencesInit) return;
    window.smartSequencesInit = true;
    // Initialize Bootstrap tooltips for toggle switches
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('.form-check-input[type="checkbox"][data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Update tooltip text on toggle change
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const isActive = this.checked;
            const newTitle = isActive ? 'Active' : 'Inactive';

            this.setAttribute('data-bs-title', newTitle);
            this.setAttribute('title', newTitle);

            const tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.setContent({ '.tooltip-inner': newTitle });
            }

            fetch(`{{ url('smart-sequences') }}/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).catch(error => {
                console.error('Error:', error);
                this.checked = !isActive;
            });
        });
    });

    // Handle "Create Sequence" button click - reset form for new sequence
    const createSequenceBtn = document.getElementById('createSequenceBtn');
    if (createSequenceBtn) {
        createSequenceBtn.addEventListener('click', function() {
            resetModalForCreate();
        });
    }

    // Utility: show confirmation using SAWI modal if available, fallback to native
    function showConfirm(message) {
        if (window.sawi && typeof window.sawi.confirm === 'function') {
            return window.sawi.confirm(message);
        }
        return Promise.resolve(confirm(message));
    }

    // Utility: show toast using SAWI if available, fallback to alert
    if (typeof window.showToast !== 'function') {
        function showToast(message, type = 'info') {
            if (window.sawi && typeof window.sawi.toast === 'function') {
                window.sawi.toast(message, { type: type });
                return;
            }
            // simple fallback
            alert(message);
        }
    }

    // Select-all header checkbox behavior
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('tbody input.row-select[type="checkbox"]').forEach(cb => cb.checked = checked);
        });
    }

    // Delete selected sequences (bulk) — uses row-select class to avoid picking up status toggles
    const deleteBtn = document.getElementById('deleteSequencesBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            const checked = Array.from(document.querySelectorAll('tbody input.row-select[type="checkbox"]:checked'));
            const ids = checked.map(cb => cb.value).filter(Boolean);

            if (ids.length === 0) {
                showToast('Please select one or more Smart Follow-Ups to delete.', 'warning');
                return;
            }

            showConfirm(`Delete ${ids.length} selected follow-up(s)? This cannot be undone.`).then(confirmed => {
                if (!confirmed) return;

                deleteBtn.disabled = true;

                fetch('{{ route("smart-sequences.bulk-delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: ids })
                }).then(resp => {
                    if (!resp.ok) {
                        return resp.json().then(err => { throw err; }).catch(() => { throw new Error('Request failed'); });
                    }
                    return resp.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showToast(data.message || 'Deleted selected follow-ups.', 'success');

                        // remove deleted rows from DOM in real-time
                        ids.forEach(id => {
                            const row = document.querySelector(`tr[data-sequence-id="${id}"]`);
                            if (row) row.remove();
                        });

                        // clear header checkbox and re-enable button
                        const selectAllCb = document.getElementById('select-all');
                        if (selectAllCb) selectAllCb.checked = false;

                        deleteBtn.disabled = false;
                        return;
                    }

                    showToast(data.message || 'Error deleting sequences', 'error');
                    deleteBtn.disabled = false;
                }).catch(err => {
                    console.error(err);
                    const msg = (err && err.message) ? err.message : (err && err.error) ? err.error : 'Error deleting sequences';
                    showToast(msg, 'error');
                    deleteBtn.disabled = false;
                });
            });
        });
    }

    // Handle edit sequence link click
    document.querySelectorAll('.edit-sequence-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Prevent any other handlers or native navigation
            e.preventDefault();
            e.stopImmediatePropagation();

            const sequenceId = this.dataset.sequenceId;
            const sequenceTitle = this.dataset.sequenceTitle;
            const sequenceCriteria = this.dataset.sequenceCriteria;
            const sequenceActions = this.dataset.sequenceActions;

            const modalEl = document.getElementById('addSmartSequenceModal');
            if (!modalEl) {
                console.error('Modal element not found');
                return;
            }

            // Set sequence ID and form action immediately to avoid other scripts submitting old form state
            const sequenceIdEl = document.getElementById('sequenceId');
            if (sequenceIdEl) sequenceIdEl.value = sequenceId;

            const sequenceForm = document.getElementById('sequenceForm');
            if (sequenceForm) {
                sequenceForm.action = '{{ url("smart-sequences") }}/' + sequenceId;
                let methodField = sequenceForm.querySelector('input[name="_method"]');
                if (!methodField) {
                    methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    sequenceForm.insertBefore(methodField, sequenceForm.firstChild);
                }
                methodField.value = 'PUT';
            }

            // Populate modal immediately (no need to wait for shown event)
            try {
                populateModalForEdit(sequenceId, sequenceTitle, sequenceCriteria, sequenceActions);
            } catch (err) {
                console.error('Error populating modal for edit', err);
            }

            // Show the modal
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) modal = new bootstrap.Modal(modalEl);
            modal.show();
            // try {
            //     if (typeof showToast === 'function') showToast('Sequence loaded for edit.', 'success');
            // } catch (e) { console.debug('showToast failed', e); }
        });
    });

    // Handle copy sequence click
    document.querySelectorAll('.copy-sequence').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.sequenceId;
            if (!id) return;

            if (!confirm('Create a copy of this sequence?')) return;

            const url = `{{ url('smart-sequences') }}/${id}/duplicate`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (!response.ok) throw new Error('Request failed');
                return response.json();
            }).then(data => {
                if (data && data.success) {
                    // reload to show the new sequence
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Could not duplicate sequence');
                }
            }).catch(err => {
                console.error(err);
                alert('Error copying sequence');
            });
        });
    });

    // Helper function to wait for TomSelect
    function waitForTomSelect(callback) {
        if (typeof TomSelect !== 'undefined') {
            callback();
        } else {
            setTimeout(() => waitForTomSelect(callback), 100);
        }
    }

    // Function to reset modal for creating new sequence
    function resetModalForCreate() {
        // Clear sequence ID first (so modal knows it's create mode)
        const sequenceIdEl = document.getElementById('sequenceId');
        if (sequenceIdEl) {
            sequenceIdEl.value = '';
        }
        
        // Update modal title
        const modalTitleEl = document.getElementById('modalTitle');
        if (modalTitleEl) {
            modalTitleEl.textContent = 'Create Smart Sequence';
        }
        
        // Clear title
        const sequenceTitleEl = document.getElementById('sequence-title');
        if (sequenceTitleEl) {
            sequenceTitleEl.value = '';
        }
        
        // Update form action for store
        const sequenceForm = document.getElementById('sequenceForm');
        if (sequenceForm) {
            sequenceForm.action = '{{ route("smart-sequences.store") }}';
            
            // Remove _method field if exists (for PUT request)
            const methodField = sequenceForm.querySelector('input[name="_method"]');
            if (methodField) {
                methodField.remove();
            }
        }
        
        // Update save button text
        const saveBtn = document.getElementById('saveSequenceBtn');
        if (saveBtn) {
            saveBtn.textContent = 'Save Sequence';
        }
        
        // Reset will be handled by modal's show.bs.modal event since sequenceId is empty
    }

    // Function to populate modal for editing
    function populateModalForEdit(sequenceId, title, criteriaJson, actionsJson) {
        console.log('populateModalForEdit called with:', { sequenceId, title });
        
        // Update modal title
        const modalTitleEl = document.getElementById('modalTitle');
        if (modalTitleEl) {
            modalTitleEl.textContent = 'Edit Smart Sequence';
        }
        
        // Set sequence ID (should already be set, but ensure it)
        const sequenceIdEl = document.getElementById('sequenceId');
        if (sequenceIdEl) {
            sequenceIdEl.value = sequenceId;
        }
        
        // Set title input
        const sequenceTitleEl = document.getElementById('sequence-title');
        if (sequenceTitleEl) {
            sequenceTitleEl.value = title;
        }
        
        // Update form action for update
        const sequenceForm = document.getElementById('sequenceForm');
        if (sequenceForm) {
            sequenceForm.action = '{{ url("smart-sequences") }}/' + sequenceId;
            
            // Add or update _method field for PUT request
            let methodField = sequenceForm.querySelector('input[name="_method"]');
            if (!methodField) {
                methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                sequenceForm.insertBefore(methodField, sequenceForm.firstChild);
            }
            methodField.value = 'PUT';
        }
        
        // Update save button text
        const saveBtn = document.getElementById('saveSequenceBtn');
        if (saveBtn) {
            saveBtn.textContent = 'Update Sequence';
        }
        
        // Parse and populate criteria using the exposed global function
        try {
            const criteria = JSON.parse(criteriaJson);
            console.log('Parsed criteria:', criteria);
            
            if (typeof window.populateCriteriaWithData === 'function') {
                window.populateCriteriaWithData(criteria);
            } else {
                console.error('populateCriteriaWithData function not available');
            }
        } catch (e) {
            console.error('Error parsing criteria:', e);
        }
        
        // Parse and populate actions using the exposed global function
        try {
            const actions = JSON.parse(actionsJson);
            console.log('Parsed actions:', actions);
            
            if (typeof window.populateActionsWithData === 'function') {
                // Small delay to ensure criteria population is complete
                setTimeout(function() {
                    window.populateActionsWithData(actions);
                }, 200);
            } else {
                console.error('populateActionsWithData function not available');
            }
        } catch (e) {
            console.error('Error parsing actions:', e);
        }
    }

    // Minimize/Restore modal
    const modalEl = document.getElementById('addSmartSequenceModal');
    const minimizeBtn = document.getElementById('minimizeModalBtn');
    const minimizedBar = document.getElementById('minimizedBar');

    if (modalEl && minimizeBtn && minimizedBar) {
        // Compatible with Bootstrap 5.0+
        function getModalInstance() {
            return bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl, { backdrop: true });
        }

        minimizeBtn.addEventListener('click', function() {
            const bsModal = getModalInstance();
            const onHidden = function() {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                minimizedBar.classList.remove('d-none');
                modalEl.removeEventListener('hidden.bs.modal', onHidden);
            };
            modalEl.addEventListener('hidden.bs.modal', onHidden);
            bsModal.hide();
        });

        minimizedBar.addEventListener('click', function() {
            const bsModal = getModalInstance();
            minimizedBar.classList.add('d-none');
            bsModal.show();
        });
    }
});
</script>
@endpush