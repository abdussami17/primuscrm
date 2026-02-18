{{-- Finance Options Component - resources/views/customers/partials/vehicles/finance-options.blade.php --}}

@props(['selectedType' => null])

<div class="finance-payment-options-grid">
    {{-- Finance Option --}}
    <x-finance-option-card 
        type="finance"
        icon="credit-card"
        title="Finance"
        description="Flexible payment plans with competitive rates"
        :isSelected="$selectedType === 'finance'"
    >
       
    </x-finance-option-card>

    {{-- Lease Option --}}
    <x-finance-option-card 
        type="lease"
        icon="car-front"
        title="Lease"
        description="Lower monthly payments with flexibility"
        :isSelected="$selectedType === 'lease'"
    >
       
    </x-finance-option-card>

    {{-- Cash Option --}}
    <x-finance-option-card 
        type="cash"
        icon="cash-coin"
        title="Cash"
        description="Immediate payment, no monthly obligations"
        :isSelected="$selectedType === 'cash'"
    >
       
    </x-finance-option-card>
</div>

{{-- Selected Payment Summary --}}
@if($selectedType)
<div class="mt-4 p-3 border rounded bg-light">
    <h6 class="fw-bold mb-3">
        <i class="ti ti-receipt me-1"></i>Payment Summary
    </h6>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="text-muted small">Payment Type</div>
            <div class="fw-bold text-capitalize">{{ $selectedType }}</div>
        </div>
        <div class="col-md-4">
            <div class="text-muted small">Monthly Payment</div>
            <div class="fw-bold text-success" id="monthlyPaymentDisplay">--</div>
        </div>
        <div class="col-md-4">
            <div class="text-muted small">Term</div>
            <div class="fw-bold" id="termDisplay">--</div>
        </div>
    </div>
</div>
@endif