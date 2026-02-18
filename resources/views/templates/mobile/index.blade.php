@extends('layouts.app')

@section('title', 'Scripts')

@section('content')

<div class="content content-two pt-0">

    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
        style="min-height: 80px;">

        <!-- Left: Title -->
        <div>
            <h6 class="mb-0">Scripts</h6>
        </div>

        <!-- Center: Logo -->
        <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" class="mobile-logo-no logo-img"
            style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div class="d-flex justify-content-normal align-items-center gap-2">
                <a href="{{ route('templates.index') }}" class="btn btn-light border border-1 bg-white fw-medium"><i class="ti ti-template me-1"></i>Templates</a>

                <a href="#" id="openCreateScriptBtn" data-bs-toggle="modal" data-bs-target="#addTemplateModal"
                    class="btn btn-primary d-flex align-items-center">
                    <i class="isax isax-add-circle5 me-1"></i>Create Script
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
            <button class="btn btn-danger delete-all-btn" id="deleteAllBtn" disabled><i class="ti ti-trash me-1"></i>Delete
                All</button>

        </div>
    </div>
    
    <div class="table-responsive datatable-has-controls">
        <table class="table templates-table datatable table-nowrap">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <!-- Sortable Script Name -->
                    <th>
                        <span class="d-flex align-items-center">
                            Script Name
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
                    <!-- Sortable Created On -->
                    <th>
                        <span class="d-flex align-items-center">
                            Created On
                            <i class="ms-1 ti ti-arrows-sort cursor-pointer text-muted" data-bs-toggle="tooltip"
                                data-bs-title="Sort by Date"></i>
                        </span>
                    </th>

                    <!-- Actions with tooltips -->
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
                            <a href="#" class="edit-template" data-id="{{ $template->id }}" data-bs-toggle="tooltip" data-bs-title="Edit Script">
                                <i class="isax isax-edit" style="font-size: 16px; cursor: pointer;"></i>
                            </a>
                            
                            <form action="{{ route('templates.duplicate', $template) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link p-0" data-bs-toggle="tooltip" data-bs-title="Copy Script">
                                    <i class="isax isax-copy" style="font-size: 16px;"></i>
                                </button>
                            </form>
                            
                            <a href="#" class="preview-template" data-id="{{ $template->id }}" data-bs-toggle="tooltip" data-bs-title="Preview Script">
                                <i class="isax isax-eye" style="font-size: 16px; cursor: pointer;"></i>
                            </a>
                            
                            <form action="{{ route('templates.destroy', $template) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" data-bs-title="Delete Script">
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

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Script Preview</h5>
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

    <!-- Include the template editor modal -->
    @include('templates.modal',['type'=>'text'])

</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="assets/img/icons/delete.svg" alt="img">
                </div>
                <h6 class="mb-1">Delete Script</h6>
                <p class="mb-3">Are you sure, you want to delete Script?</p>
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
document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery && jQuery.fn && jQuery.fn.dataTable) {
        try {
            if (jQuery.fn.dataTable.isDataTable('.templates-table')) {
                $('.templates-table').DataTable().page.len(50).draw();
            } else {
                $('.templates-table').DataTable({ pageLength: 50 });
            }
        } catch (e) {
            console.debug('Could not adjust templates table page length', e);
        }
    }
});


    document.addEventListener("DOMContentLoaded", function () {
        const selectAll = document.getElementById("select-all");
        const deleteAllBtn = document.getElementById("deleteAllBtn");

        function updateDeleteAllState() {
            const checkedCount = document.querySelectorAll(".row-check:checked").length;
            deleteAllBtn.disabled = checkedCount < 2;
        }

        // Rebindable handlers for rows injected by DataTables
        function rebindMobileHandlers() {
            // Edit
            document.querySelectorAll('.edit-template').forEach(btn => {
                btn.removeEventListener('_mobile_edit', btn._mobile_edit);
                btn._mobile_edit = function (e) { e.preventDefault(); loadTemplateForEdit(this.dataset.id); };
                btn.addEventListener('click', btn._mobile_edit);
            });

            // Preview
            document.querySelectorAll('.preview-template').forEach(btn => {
                btn.removeEventListener('_mobile_preview', btn._mobile_preview);
                btn._mobile_preview = function (e) { e.preventDefault(); loadTemplatePreview(this.dataset.id); };
                btn.addEventListener('click', btn._mobile_preview);
            });

            // Delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.removeEventListener('submit', form._delete_handler);
                form._delete_handler = function (e) { e.preventDefault(); if (confirm('Are you sure you want to delete this template?')) this.submit(); };
                form.addEventListener('submit', form._delete_handler);
            });

            // Select-all checkbox handling (rebind)
            if (selectAll) {
                selectAll.removeEventListener('change', selectAll._handler);
                selectAll._handler = function () {
                    const table = document.querySelector('.templates-table');
                    const checks = table ? table.querySelectorAll('.row-check') : document.querySelectorAll('.row-check');
                    checks.forEach(chk => { chk.checked = this.checked; });
                    updateDeleteAllState();
                };
                selectAll.addEventListener('change', selectAll._handler);
            }

            // Row checkbox delegation: listen at table level to handle dynamically generated rows
            const table = document.querySelector('.templates-table');
            if (table) {
                table.addEventListener('change', function (e) {
                    const target = e.target;
                    if (!target || !target.classList) return;
                    if (!target.classList.contains('row-check')) return;

                    const rowChecks = table.querySelectorAll('.row-check');
                    const checked = table.querySelectorAll('.row-check:checked').length;
                    const total = rowChecks.length;
                    if (selectAll) {
                        selectAll.checked = checked === total && total > 0;
                        selectAll.indeterminate = checked > 0 && checked < total;
                    }
                    updateDeleteAllState();
                });
            }
        }

        // Initial one-time bindings (create modal button behaviour)
        const openCreateBtn = document.getElementById('openCreateScriptBtn');
        if (openCreateBtn) {
            openCreateBtn.addEventListener('click', function () {
                try {
                    const modalEl = document.getElementById('addTemplateModal');
                    if (!modalEl) return;
                    const modalTypeInput = modalEl.querySelector('input[name="type"]');
                    if (modalTypeInput) modalTypeInput.value = 'text';
                    const editorTplType = modalEl.querySelector('#tplType');
                    if (editorTplType) editorTplType.value = 'text';
                    const titleEl = modalEl.querySelector('.modal-title');
                    if (titleEl) titleEl.textContent = 'Create Phone Script';
                    const saveBtn = modalEl.querySelector('button[type="submit"][form="templateForm"]');
                    if (saveBtn) saveBtn.textContent = 'Save Phone Script';
                    const subjectCol = modalEl.querySelector('#subjectCol');
                    const subjectInput = modalEl.querySelector('#tplSubject');
                    if (subjectCol) subjectCol.style.display = 'none';
                    if (subjectInput) subjectInput.removeAttribute('required');
                } catch (e) { /* ignore */ }
            });
        }

        updateDeleteAllState();

        // Initialize DataTable server-side for mobile scripts (type = text)
        if (window.jQuery && jQuery.fn && jQuery.fn.dataTable) {
            setTimeout(function () {
                try {
                    const $tbl = $('.templates-table');
                    if ($.fn.dataTable.isDataTable($tbl)) {
                        try { $tbl.DataTable().destroy(); } catch (e) { /* ignore */ }
                    }

                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    $tbl.DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("templates.data") }}',
                            type: 'GET',
                            data: function (d) { d.type = 'all'; }
                        },
                        dom: 'fBtlpi',
                        searching: true,
                        ordering: true,
                        columns: [
                            {
                                data: 'id', orderable: false, searchable: false,
                                render: function (data) { return '<div class="form-check"><input class="form-check-input row-check" type="checkbox" value="'+data+'"></div>'; }
                            },
                            { data: 'name' },
                            { data: 'type' },
                            { data: 'created_at' },
                            {
                                data: 'id', orderable: false, searchable: false,
                                render: function (data) {
                                    return ` <div class="d-flex gap-2 align-items-center">\
                                                <a href="#" class="edit-template" data-id="${data}" data-bs-toggle="tooltip" data-bs-title="Edit Script">\
                                                    <i class="isax isax-edit" style="font-size:16px;cursor:pointer;"></i>\
                                                </a>\
                                                <form action="/templates/${data}/duplicate" method="POST" class="d-inline">\
                                                    <input type="hidden" name="_token" value="${csrf}">\
                                                    <button type="submit" class="btn btn-link p-0"><i class="isax isax-copy" style="font-size:16px;"></i></button>\
                                                </form>\
                                                <a href="#" class="preview-template" data-id="${data}" data-bs-toggle="tooltip" data-bs-title="Preview Script">\
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
                            sLengthMenu: '_MENU_',
                            searchPlaceholder: 'Search',
                            sLengthMenu: 'Row Per Page _MENU_ Entries',
                            info: '_START_ - _END_ of _TOTAL_ items',
                            paginate: {
                                next: '<i class="isax isax-arrow-right-1"></i>',
                                previous: '<i class="isax isax-arrow-left"></i>'
                            }
                        },
                        scrollX: false,
                        scrollCollapse: false,
                        responsive: false,
                        autoWidth: false,
                        pageLength: 50,
                        initComplete: function () {
                            $('.dataTables_filter').appendTo('#tableSearch');
                            $('.dataTables_filter').appendTo('.search-input');
                        },
                        drawCallback: function () {
                            try { rebindMobileHandlers(); } catch (e) { }
                        }
                    });
                } catch (e) {
                    console.debug('Could not init mobile DataTable', e);
                }
            }, 80);
        }
    });

function loadTemplateForEdit(templateId) {
    fetch(`/templates/${templateId}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('templateId').value = data.id;
        document.getElementById('tplName').value = data.name;
        document.getElementById('tplSubject').value = data.subject || '';
        document.getElementById('editor').innerHTML = data.body;
        document.getElementById('templateFormAction').value = 'update';
        
        const modal = new bootstrap.Modal(document.getElementById('addTemplateModal'));
        modal.show();
    });
}

function loadTemplatePreview(templateId) {
    fetch(`/templates/${templateId}/preview`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('templatePreviewContent').innerHTML = data.html;
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    });
}

function setPreviewView(view) {
    const preview = document.getElementById("templatePreviewContent");
    if (view === 'mobile') {
        preview.style.width = "375px";
        preview.style.margin = "0 auto";
    } else {
        preview.style.width = "100%";
        preview.style.margin = "0";
    }
}
</script>


@endpush

@push('styles')
<style>
/* Ensure pagination/length controls are visible for this table despite global overrides */
.datatable-has-controls .dataTables_length,
.datatable-has-controls div.dataTables_wrapper div.dataTables_paginate,
.datatable-has-controls .paging_simple_numbers {
    display: block !important;
}
</style>
@endpush