{{-- Empty Vehicle State - resources/views/customers/partials/vehicles/vehicle-empty.blade.php --}}

<div class="text-center py-5" data-vehicle-container="{{ $dealId }}">
    <div class="mb-3">
        <i class="ti ti-car-off text-muted" style="font-size:64px;"></i>
    </div>
    <h6 class="text-muted mb-2">No Vehicle Assigned</h6>
    <p class="text-muted small mb-3">Select a vehicle from inventory to associate with this deal</p>
    <button type="button" 
            class="btn btn-primary btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#gotoinventoryModal"
            data-deal-id="{{ $dealId }}">
        <i class="ti ti-plus me-1"></i>Add Vehicle
    </button>
</div>