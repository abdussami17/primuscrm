{{-- Finance Option Card Component - resources/views/components/finance-option-card.blade.php --}}

@props([
    'type',
    'icon',
    'title',
    'description',
    'isSelected' => false
])

<div class="finance-payment-option-card {{ $isSelected ? 'border-primary selected' : '' }}" 
     data-bs-toggle="modal" 
     data-bs-target="#{{ $type }}Modal"
     role="button"
     tabindex="0">
    <div class="finance-payment-card-inner-content">
        {{-- Icon --}}
        <div class="finance-payment-icon-circle-wrapper {{ $isSelected ? 'bg-primary text-white' : '' }}">
            <i class="bi bi-{{ $icon }}"></i>
        </div>
        
        {{-- Title --}}
        <h3 class="finance-payment-option-card-title h6 fw-bold mb-1">
            {{ $title }}
        </h3>
        
        {{-- Description --}}
        <p class="finance-payment-option-card-description text-muted small mb-0">
            {{ $description }}
        </p>
        
        {{-- Slot for additional content --}}
        {{ $slot }}
        
        {{-- Selected indicator --}}
        @if($isSelected)
        <div class="mt-2">
            <span class="badge bg-primary">
                <i class="ti ti-check me-1"></i>Selected
            </span>
        </div>
        @endif
    </div>
</div>

<style>
.finance-payment-option-card.selected {
    border-color: var(--bs-primary) !important;
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}
.finance-payment-option-card:focus {
    outline: 2px solid var(--bs-primary);
    outline-offset: 2px;
}
</style>