@if($vehicle)
<div id="vehicleSelectedArea" style="display: block;">
    <div class="row g-2">

        {{-- LEFT: IMAGE + HOLD --}}
        <div class="col-md-3">
            <div class="car-card border border-1">
                <div class="top bg-light">
                    <span>{{ $vehicle->condition ?? 'Used' }}</span>
                </div>

                <img src="{{ asset($vehicle->images[0]) ?? asset('assets/img/placeholder-car.png') }}"
                     alt="vehicle-image">

                <div class="bottom bg-success">
                    <span>{{ $vehicle->status ?? 'In Stock' }}</span>
                </div>
            </div>

            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input"
                       type="checkbox"
                       id="holdVehicle"
                       {{ $vehicle->is_on_hold ? 'checked' : '' }}>
                <label class="form-check-label" for="holdVehicle">
                    Hold Vehicle
                </label>
            </div>
        </div>

        {{-- RIGHT: DETAILS --}}
        <div class="col-md-9">
            <div class="car-name"
                 data-bs-toggle="modal"
                 data-bs-target="#gotoinventoryModal">
                {{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}
            </div>

            <div class="price text-success mb-1">
                ${{ number_format($vehicle->price ?? 0, 2) }}
            </div>

            <div class="view-incentives-text mb-1">
                <i class="ti ti-info-circle me-1"></i>
                View Incentives ({{ $vehicle->incentives_count ?? 0 }})
            </div>

            <div class="cash-down-text mb-1">
                <i class="ti ti-circle-plus-filled me-1"></i>
                Cash Down
            </div>

            <div class="details row">
                {{-- LEFT COLUMN --}}
                <div class="col-md-6">
                    <p><strong>Stock #:</strong> {{ $vehicle->stock_number }}</p>
                    <p><strong>VIN:</strong> {{ $vehicle->vin }}</p>
                    <p><strong>Odometer:</strong> {{ number_format($vehicle->mileage ?? 0) }}</p>
                    <p><strong>Body Style:</strong> {{ $vehicle->body_type }}</p>
                    <p><strong>Exterior Color:</strong> {{ $vehicle->exterior_color }}</p>
                    <p><strong>Interior Color:</strong> {{ $vehicle->interior_color }}</p>
                    <p><strong>Dealership:</strong> {{ $vehicle->dealership_name ?? '-' }}</p>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="col-md-6">
                    <p><strong>Fuel:</strong> {{ $vehicle->fuel_type }}</p>
                    <p><strong>MPG:</strong> {{ $vehicle->city_mpg ?? 0 }} city / {{ $vehicle->highway_mpg ?? 0 }} hwy</p>
                    <p><strong>Transmission:</strong> {{ $vehicle->transmission }}</p>
                    <p><strong>Engine:</strong> {{ $vehicle->engine }}</p>
                    <p><strong>Drive Type:</strong> {{ $vehicle->drivetrain }}</p>
                    <p><strong>Doors:</strong> {{ $vehicle->doors }}</p>
                    <p><strong>Lot Location:</strong> {{ $vehicle->lot_location ?? '-' }}</p>
                    <p><strong>Franchise:</strong> {{ $vehicle->franchise ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
