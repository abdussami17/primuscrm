@extends('layouts.app')

@section('title', isset($template) ? 'Edit Template' : 'Create Template')

@section('content')
<div class="content content-two pt-0">
    <div class="template-header rounded-3 p-3 mb-3">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div>
                <h5 class="mb-0">{{ isset($template) ? 'Edit' : 'Create' }} Email Template</h5>
                <small class="text-secondary">{{ isset($template) ? 'Update your' : 'Design a new' }} email template</small>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('templates.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" form="templateForm" class="btn btn-primary">
                    <i class="bi bi-save2 me-1"></i>{{ isset($template) ? 'Update' : 'Save' }} Template
                </button>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="templateForm" action="{{ isset($template) ? route('templates.update', $template) : route('templates.store') }}" method="POST">
        @csrf
        @if(isset($template))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <!-- Basic Info -->
                <div class="card p-3 mb-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Template Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $template->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="email" {{ old('type', $template->type ?? 'email') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="text" {{ old('type', $template->type ?? '') == 'text' ? 'selected' : '' }}>Text</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Subject Line</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                                value="{{ old('subject', $template->subject ?? '') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $template->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1"
                                    {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Editor -->
                <div class="card p-0 mb-4">
                    <x-editor-toolbar />
                    
                    <div class="editor-wrapper">
                        <div class="editor-container">
                            <div class="editor" id="editor" contenteditable="true">
                                {!! old('body', $template->body ?? '<p>Start typing your template here...</p>') !!}
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="body" id="bodyInput">
                </div>

                <!-- Preview -->
                <div class="preview-container">
                    <div class="preview-header d-flex justify-content-between">
                        <h6 class="mb-0 text-white">Live Preview</h6>
                        <div class="device-toggle">
                            <button type="button" id="mobileBtn"><i class="bi bi-phone"></i></button>
                            <button type="button" id="desktopBtn" class="active"><i class="bi bi-display"></i></button>
                        </div>
                    </div>
                    <div class="preview-content" id="preview"></div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <x-merge-fields :categories="$mergeFields" />
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const SAMPLE_DATA = {!! json_encode($sampleData ?? [
    'first_name' => 'Michael',
    'last_name' => 'Smith',
    'dealer_name' => 'Primus Motors',
    'dealer_phone' => '222-333-4444',

]) !!};

function updatePreview() {
    const editor = document.getElementById('editor');
    let html = editor.innerHTML;
    
    // Replace tokens with sample data
    html = html.replace(/@\{\{\s*([^}]+)\s*\}\}/g, (match, token) => {
        return SAMPLE_DATA[token.trim()] || match;
    });
    
    document.getElementById('preview').innerHTML = html;
}

document.getElementById('editor').addEventListener('input', updatePreview);

// Update hidden input before submit
document.getElementById('templateForm').addEventListener('submit', function(e) {
    document.getElementById('bodyInput').value = document.getElementById('editor').innerHTML;
});

// Device toggle
document.getElementById('mobileBtn').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('desktopBtn').classList.remove('active');
    document.getElementById('preview').classList.add('mobile');
});

document.getElementById('desktopBtn').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('mobileBtn').classList.remove('active');
    document.getElementById('preview').classList.remove('mobile');
});

// Initial preview
updatePreview();
</script>
@endpush

@push('styles')
<style>
.editor {
    min-height: 400px;
    padding: 20px;
    outline: none;
    background: white;
    font-size: 14px;
    line-height: 1.6;
}

.editor:focus {
    outline: 2px solid #002140;
}

.token {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
}

.preview-content {
    padding: 20px;
    min-height: 400px;
    background: white;
}

.preview-content.mobile {
    max-width: 375px;
    margin: 0 auto;
    border-left: 1px solid #e1e5eb;
    border-right: 1px solid #e1e5eb;
}

.device-toggle button {
    border: none;
    background: transparent;
    color: white;
    padding: 5px 10px;
    cursor: pointer;
}

.device-toggle button.active {
    background: rgba(255,255,255,0.2);
    border-radius: 4px;
}
</style>
@endpush