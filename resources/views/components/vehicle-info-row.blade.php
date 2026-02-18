{{-- Vehicle Info Row Component - resources/views/components/vehicle-info-row.blade.php --}}

@props([
    'label',
    'value' => null,
    'suffix' => '',
    'icon' => null
])

<p class="mb-1 d-flex justify-content-between">
    <span class="text-muted">
        @if($icon)
            <i class="ti ti-{{ $icon }} me-1"></i>
        @endif
        <strong>{{ $label }}:</strong>
    </span>
    <span>{{ $value ?? 'N/A' }}{{ $value && $suffix ? ' ' . $suffix : '' }}</span>
</p>