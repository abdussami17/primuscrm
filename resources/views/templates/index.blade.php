@extends('layouts.app')

@section('title', 'Templates')

@section('content')

<div class="content content-two pt-0">
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
        style="min-height: 80px;">

        <div>
            <h6 class="mb-0">Templates</h6>
        </div>

        <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
            style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div class="d-flex justify-content-normal align-items-center gap-2">
                <a href="{{ route('mobile-templates.index') }}" class="btn btn-light border border-1 bg-white fw-medium"><i class="ti ti-phone me-1"></i>Scripts</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#addTemplateModal"
                    class="btn btn-primary d-flex align-items-center">
                    <i class="isax isax-add-circle5 me-1"></i>Create Template
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="table-search d-flex align-items-center mb-0">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn-searchset"><i
                                class="isax isax-search-normal fs-12"></i></a>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger delete-all-btn" id="deleteAllBtn" disabled><i class="ti ti-trash me-1"></i>Delete All</button>
        </div>
    </div>
    <!-- Loader overlay -->
<div id="templateLoaderOverlay" style="
position: fixed;
top: 0; left: 0;
width: 100%; height: 100%;
background: rgba(255,255,255,0.9);
z-index: 9999;
display: flex;
align-items: center;
justify-content: center;
flex-direction: column;
">
<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
    <span class="visually-hidden">Loading...</span>
</div>
<div class="mt-2 text-dark fw-bold">Loading template...</div>
</div>
    <div class="table-responsive datatable-has-controls templates-preload" id="templateTableWrapper" style="display:none;">
        <table class="table templates-table datatable no-dt-auto table-nowrap">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <th>
                        <span class="d-flex align-items-center">
                            Template Name
                            <i class="ms-1 ti ti-arrows-sort cursor-pointer text-muted" data-bs-toggle="tooltip"
                                data-bs-title="Sort A–Z / Z–A"></i>
                        </span>
                    </th>
                    <th>
                        <span class="d-flex align-items-center">
                            Email/Text
                            <i class="ms-1 ti ti-arrows-sort cursor-pointer text-muted" data-bs-toggle="tooltip"
                                data-bs-title="Sort A–Z / Z–A"></i>
                        </span>
                    </th>
                    <th>
                        <span class="d-flex align-items-center">
                            Created On
                            <i class="ms-1 ti ti-arrows-sort cursor-pointer text-muted" data-bs-toggle="tooltip"
                                data-bs-title="Sort by Date"></i>
                        </span>
                    </th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input row-check" type="checkbox" value="{{ $template->id }}">
                        </div>
                    </td>
                    <td>{{ $template->name }}</td>
                    <td>{{ ucfirst($template->type) }}</td>
                    <td>{{ $template->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <a href="#" class="edit-template" data-id="{{ $template->id }}" data-bs-toggle="tooltip" data-bs-title="Edit Template">
                                <i class="isax isax-edit" style="font-size: 16px; cursor: pointer;"></i>
                            </a>
                            
                            <form action="{{ route('templates.duplicate', $template) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0" data-bs-toggle="tooltip" data-bs-title="Copy Template">
                                    <i class="isax isax-copy" style="font-size: 16px;"></i>
                                </button>
                            </form>
                            
                            <a href="#" class="preview-template" data-id="{{ $template->id }}" data-bs-toggle="tooltip" data-bs-title="Preview Template">
                                <i class="isax isax-eye" style="font-size: 16px; cursor: pointer;"></i>
                            </a>
                            
                            <form action="{{ route('templates.destroy', $template) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-link p-0 text-danger delete-single-btn" 
                                        data-id="{{ $template->id }}" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-title="Delete Template">
                                    <i class="isax isax-trash" style="font-size: 16px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const loaderOverlay = document.getElementById('templateLoaderOverlay');
    const tableWrapper = document.getElementById('templateTableWrapper');

    // Small timeout to ensure table DOM is ready (especially if large data)
    setTimeout(() => {
        if (tableWrapper) tableWrapper.style.display = 'block';
        if (loaderOverlay) loaderOverlay.style.display = 'none';
    }, 200); // 200ms delay, adjust if needed
});
</script>
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Template Preview</h5>
                    <div class="ms-auto d-flex gap-2">
                        <i class="ti ti-device-laptop cursor-pointer" data-bs-toggle="tooltip"
                            data-bs-title="Laptop View" onclick="setPreviewView('desktop')"></i>
                        <i class="ti ti-device-mobile cursor-pointer" data-bs-toggle="tooltip"
                            data-bs-title="Mobile View" onclick="setPreviewView('mobile')"></i>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="templatePreviewContent" style="width:100%;min-height:400px;border:0;"></div>
                </div>
            </div>
        </div>
    </div>

    @include('templates.modal')
</div>

<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="assets/img/icons/delete.svg" alt="img">
                </div>
                <h6 class="mb-1">Delete Template</h6>
                <p class="mb-3">Are you sure, you want to delete Template?</p>
                <div class="d-flex justify-content-center">
                    <a href="javascript:void(0);" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</a>
                    <a href="templates.html" class="btn btn-primary">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    if (window.templatesInitialized) return;
    window.templatesInitialized = true;
    
    let isProcessing = false;
    let checkboxesBound = false;
    
    function updateDeleteAllState() {
        const deleteAllBtn = document.getElementById("deleteAllBtn");
        if (!deleteAllBtn) return;
        
        const checkedCount = document.querySelectorAll(".row-check:checked").length;
        const shouldEnable = checkedCount >= 2;
        
        deleteAllBtn.disabled = !shouldEnable;
        deleteAllBtn.classList.toggle('disabled', !shouldEnable);
    }
    
    function setupCheckboxes() {
        if (checkboxesBound) return;
        checkboxesBound = true;

        const selectAll = document.getElementById("select-all");
        const table = document.querySelector('.templates-table');

        // When the header checkbox is toggled, (re)query current row checkboxes and set them
        if (selectAll) {
            selectAll.addEventListener("change", function() {
                const isChecked = this.checked;
                const rowChecks = table ? table.querySelectorAll('.row-check') : document.querySelectorAll('.row-check');
                rowChecks.forEach(chk => {
                    chk.checked = isChecked;
                    chk.dispatchEvent(new Event('change', { bubbles: true }));
                });
                updateDeleteAllState();
            });
        }

        // Use event delegation so changes to checkboxes added/removed by DataTables are handled
        const listenTarget = table || document;
        listenTarget.addEventListener('change', function(e) {
            const target = e.target;
            if (!target || !target.classList) return;
            if (!target.classList.contains('row-check')) return;

            const rowChecks = table ? table.querySelectorAll('.row-check') : document.querySelectorAll('.row-check');
            const allChecked = (table ? table.querySelectorAll('.row-check:checked') : document.querySelectorAll('.row-check:checked')).length;
            const total = rowChecks.length;

            if (selectAll) {
                selectAll.checked = allChecked === total && total > 0;
                selectAll.indeterminate = allChecked > 0 && allChecked < total;
            }

            updateDeleteAllState();
        });
    }
    
    function setupDeleteAllButton() {
        const deleteAllBtn = document.getElementById("deleteAllBtn");
        if (!deleteAllBtn) return;
        
        deleteAllBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            if (isProcessing || this.disabled) return;
            
            const selectedIds = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
            if (selectedIds.length < 2) return;
            
            if (!confirm(`Are you sure you want to delete ${selectedIds.length} template(s)?`)) return;
            
            isProcessing = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="ti ti-trash me-1"></i>Deleting...';
            this.disabled = true;
            
            try {
                const response = await fetch('{{ route("templates.destroy-multiple") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Deletion failed');
                }
            } catch (error) {
                alert('Error: ' + error.message);
                this.innerHTML = originalText;
                this.disabled = false;
                isProcessing = false;
            }
        });
    }
    
    function setupTooltips() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            if (!tooltipTriggerEl._tooltip) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            }
        });
    }
    
    async function loadTemplateForEdit(templateId) {
        try {
            const response = await fetch(`/templates/${templateId}/edit`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            
            document.getElementById('templateId').value = data.id;
            document.getElementById('tplName').value = data.name;
            document.getElementById('tplSubject').value = data.subject || '';
            document.getElementById('editor').innerHTML = data.body;
            document.getElementById('templateFormAction').value = 'update';
            
            new bootstrap.Modal(document.getElementById('addTemplateModal')).show();
        } catch (error) {
            alert('Error loading template data');
        }
    }
    
    async function loadTemplatePreview(templateId) {
        try {
            const response = await fetch(`/templates/${templateId}/preview`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            
            document.getElementById('templatePreviewContent').innerHTML = data.html;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        } catch (error) {
            alert('Error loading template preview');
        }
    }
    
    window.setPreviewView = function(view) {
        const preview = document.getElementById("templatePreviewContent");
        if (view === 'mobile') {
            preview.style.width = "375px";
            preview.style.margin = "0 auto";
        } else {
            preview.style.width = "100%";
            preview.style.margin = "0";
        }
    };
    
    function initialize() {
        setupCheckboxes();
        setupDeleteAllButton();
        setupTooltips();
        updateDeleteAllState();
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // Delegated handlers to ensure dynamic rows (DataTables) always respond
    document.addEventListener('click', function (e) {
        const editEl = e.target.closest && e.target.closest('.edit-template');
        if (editEl) {
            e.preventDefault();
            e.stopPropagation();
            const templateId = editEl.dataset.id;
            if (templateId) loadTemplateForEdit(templateId);
            return;
        }

        const previewEl = e.target.closest && e.target.closest('.preview-template');
        if (previewEl) {
            e.preventDefault();
            e.stopPropagation();
            const templateId = previewEl.dataset.id;
            if (templateId) loadTemplatePreview(templateId);
            return;
        }

        const deleteBtn = e.target.closest && e.target.closest('.delete-single-btn');
        if (deleteBtn) {
            e.preventDefault();
            e.stopPropagation();
            if (!confirm('Are you sure you want to delete this template?')) return;
            const form = deleteBtn.closest('form');
            if (form) form.submit();
            return;
        }
    });
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!(window.jQuery && jQuery.fn && jQuery.fn.dataTable)) return;

    try {
        const $tbl = $('.templates-table');
        if (!$tbl.length || $.fn.dataTable.isDataTable($tbl)) return;

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // hide server-rendered rows until DataTable finishes its first load
        $tbl.addClass('dt-loading');

        $tbl.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("templates.data") }}',
                type: 'GET'
            },
            dom: 'fBtlpi',
            searching: true,
            ordering: true,
            pageLength: 25,
            lengthMenu: [[25, 75, 100, 200, 500, 1000], [25, 75, 100, 200, 500, 1000]],
            columns: [
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<div class="form-check"><input class="form-check-input row-check" type="checkbox" value="'+data+'"></div>';
                    }
                },
                { data: 'name' },
                { data: 'type' },
                { data: 'created_at' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return ` <div class="d-flex gap-2 align-items-center">\
                                    <a href="#" class="edit-template" data-id="${data}" data-bs-toggle="tooltip" data-bs-title="Edit Template">\
                                        <i class="isax isax-edit" style="font-size:16px;cursor:pointer;"></i>\
                                    </a>\
                                    <form action="/templates/${data}/duplicate" method="POST" class="d-inline">\
                                        <input type="hidden" name="_token" value="${csrf}">\
                                        <button type="submit" class="btn btn-link p-0"><i class="isax isax-copy" style="font-size:16px;"></i></button>\
                                    </form>\
                                    <a href="#" class="preview-template" data-id="${data}" data-bs-toggle="tooltip" data-bs-title="Preview Template">\
                                        <i class="isax isax-eye" style="font-size:16px;cursor:pointer;"></i>\
                                    </a>\
                                    <form action="/templates/${data}" method="POST" class="d-inline delete-form">\
                                        <input type="hidden" name="_token" value="${csrf}">\
                                        <input type="hidden" name="_method" value="DELETE">\
                                        <button type="button" class="btn btn-link p-0 text-danger delete-single-btn" data-id="${data}">\
                                            <i class="isax isax-trash" style="font-size:16px;"></i>\
                                        </button>\
                                    </form>\
                                </div>`;
                    }
                }
            ],
            language: {
                search: ' ',
                searchPlaceholder: 'Search',
                sLengthMenu: 'Row Per Page _MENU_ Entries',
                info: '_START_ - _END_ of _TOTAL_ items',
                paginate: {
                    next: '<i class="isax isax-arrow-right-1"></i>',
                    previous: '<i class="isax isax-arrow-left"></i> '
                }
            },
            scrollX: false,
            scrollCollapse: false,
            responsive: false,
            autoWidth: false,
            initComplete: function (settings, json) {
                // reveal table now that DataTable has initialized and requested data
                $tbl.removeClass('dt-loading');
                // small delay to ensure AJAX-rendered rows are attached before showing
                setTimeout(function(){
                    try {
                        $tbl.closest('.table-responsive').removeClass('templates-preload');
                    } catch(e){}
                }, 150);

                $('.dataTables_filter').appendTo('.search-input');
            },
            drawCallback: function() {
                const selectAll = document.getElementById('select-all');
                if (selectAll) {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                }

                const deleteAllBtn = document.getElementById('deleteAllBtn');
                if (deleteAllBtn) {
                    deleteAllBtn.disabled = true;
                    deleteAllBtn.classList.add('disabled');
                }

                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltipTriggerList.forEach(tooltipTriggerEl => {
                    if (!tooltipTriggerEl._tooltip) {
                        new bootstrap.Tooltip(tooltipTriggerEl);
                    }
                });
            }
        });
    } catch (e) {
        console.debug('Could not ensure templates DataTable server-side init', e);
    }
});
</script>
@endpush

@push('styles')
<style>
.btn-danger:disabled, 
.btn-danger.disabled {
    opacity: 0.65;
    cursor: not-allowed;
    pointer-events: none;
}

#deleteAllBtn:not(:disabled):not(.disabled) {
    cursor: pointer;
    opacity: 1;
}

.form-check-input {
    cursor: pointer;
}
/* Ensure pagination/length controls are visible for this table despite global overrides */
.datatable-has-controls .dataTables_length,
.datatable-has-controls div.dataTables_wrapper div.dataTables_paginate,
.datatable-has-controls .paging_simple_numbers {
    display: block !important;
}

/* Hide any server-rendered rows until DataTable completes its AJAX load
   Prevents flicker where initial Blade-rendered rows are shown briefly */
.templates-table.dt-loading tbody {
    visibility: hidden;
}
.templates-table.dt-loading .dataTables_processing {
    display: block !important;
}

/* Fully hide the table container until DataTables finishes initial load */
.templates-preload {
    display: none !important;
}
</style>
@endpush