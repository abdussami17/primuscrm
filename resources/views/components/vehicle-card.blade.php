{{-- Vehicle Card Component - resources/views/components/vehicle-card.blade.php --}}

@props([
    'vehicle',
    'showHoldCheckbox' => false,
    'size' => 'default'
])

@php
    $condition = $vehicle->condition ?? 'Used';
    $conditionClass = match(strtolower($condition)) {
        'new' => 'bg-primary',
        'cpo' => 'bg-info',
        default => 'bg-secondary'
    };
    $stockStatus = $vehicle->status ?? 'In Stock';
    $stockClass = match(strtolower($stockStatus)) {
        'in stock' => 'bg-success',
        'sold' => 'bg-danger',
        'pending' => 'bg-warning',
        default => 'bg-secondary'
    };
@endphp

<div class="car-card border rounded overflow-hidden position-relative">
    {{-- Condition Badge --}}
    <div class="position-absolute top-0 start-0 end-0 {{ $conditionClass }} text-white px-2 py-1" 
         style="font-size:0.75rem;">
        <span>{{ $condition }}</span>
    </div>
    
    {{-- Vehicle Image --}}
    <img src="{{ $vehicle->images[0] ?? '/assets/img/cars/default.png' }}" 
         alt="{{ $vehicle->make }} {{ $vehicle->model }}"
         class="w-100"
         style="height:{{ $size === 'small' ? '100px' : '150px' }};object-fit:cover;margin-top:24px;">
    
    {{-- Stock Status Badge --}}
    <div class="position-absolute bottom-0 start-0 end-0 {{ $stockClass }} text-white px-2 py-1"
         style="font-size:0.75rem;">
        <span>{{ $stockStatus }}</span>
    </div>
</div>

@if($showHoldCheckbox)
<div class="form-check form-check-inline mt-2">
    <input class="form-check-input" 
           type="checkbox" 
           id="holdVehicle_{{ $vehicle->id }}"
           name="hold_vehicle"
           value="1"
           {{ $vehicle->is_held ? 'checked' : '' }}>
    <label class="form-check-label small" for="holdVehicle_{{ $vehicle->id }}">
        Hold Vehicle
    </label>
</div>
@endif