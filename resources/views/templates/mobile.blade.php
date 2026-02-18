@extends('layouts.app')

@section('title', 'Templates')

@section('content')

<div class="content content-two pt-0">

    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
        style="min-height: 80px;">

        <!-- Left: Title -->
        <div>
            <h6 class="mb-0">Templates</h6>
        </div>

        <!-- Center: Logo -->
        <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" class="mobile-logo-no logo-img"
            style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div class="d-flex justify-content-normal align-items-center gap-2">
                <a href="{{ route('templates.mobile') }}" class="btn btn-light border border-1 bg-white fw-medium"><i class="ti ti-phone me-1"></i>Scripts</a>
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
            <button class="btn btn-danger delete-all-btn" id="deleteAllBtn" disabled><i class="ti ti-trash me-1"></i>Delete
                All</button>

        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table templates-table datatable table-nowrap">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <!-- Sortable Template Name -->
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
                                <button type="submit" class="btn btn-link p-0 text-danger" data-bs-toggle="tooltip" data-bs-title="Delete Template">
                                    <i class="isax isax-trash" style="font-size: 16px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <p class="text-muted mb-0">No templates found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Preview Modal -->
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

    <!-- Include the template editor modal -->
    @include('templates.modal',['type'=>$type])

</div>

<!-- Delete Modal -->
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
document.addEventListener("DOMContentLoaded", function() {
    const selectAll = document.getElementById("select-all");
    const rowChecks = document.querySelectorAll(".row-check");
    const deleteAllBtn = document.getElementById("deleteAllBtn");

    function updateDeleteAllState() {
        const checkedCount = document.querySelectorAll(".row-check:checked").length;
        deleteAllBtn.disabled = checkedCount < 2;
    }

    selectAll.addEventListener("change", function() {
        rowChecks.forEach(chk => chk.checked = this.checked);
        updateDeleteAllState();
    });

    rowChecks.forEach(chk => {
        chk.addEventListener("change", function() {
            selectAll.checked = document.querySelectorAll(".row-check:checked").length === rowChecks.length;
            updateDeleteAllState();
        });
    });

    deleteAllBtn.addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
        
        if (selectedIds.length === 0) return;
        
        if (confirm(`Delete ${selectedIds.length} template(s)?`)) {
            fetch('{{ route("templates.destroy-multiple") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        }
    });

    // Edit template
    document.querySelectorAll('.edit-template').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const templateId = this.dataset.id;
            loadTemplateForEdit(templateId);
        });
    });

    // Preview template
    document.querySelectorAll('.preview-template').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const templateId = this.dataset.id;
            loadTemplatePreview(templateId);
        });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this template?')) {
                this.submit();
            }
        });
    });

    updateDeleteAllState();
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
@endpush