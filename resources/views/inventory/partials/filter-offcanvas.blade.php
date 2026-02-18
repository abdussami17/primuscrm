{{-- Filter Inventory Offcanvas --}}
<div class="offcanvas offcanvas-start inventoryFilterModal" tabindex="-1" id="customcanvas">
    <div class="crm-header p-3 d-flex justify-content-between align-items-center">
        <h6 style="font-size: 16px;" class="text-white">FILTER INVENTORY</h6>
        <button type="button" class="border-0 bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
            <i style="font-size: 18px;" class="isax isax-close-circle text-white"></i>
        </button>
    </div>

    <div class="offcanvas-body pt-3">
        <form action="{{ route('inventory.web') }}" method="GET" id="inventoryFilterForm">
            {{-- Preserve existing non-filter params --}}
            @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if(request('dir'))
            <input type="hidden" name="dir" value="{{ request('dir') }}">
            @endif

            <div class="row">
                {{-- Year Range --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Year (Min)</label>
                    <select name="year_min" id="yearMin" class="form-control">
                        <option value="">Select...</option>
                        @for($year = date('Y') + 1; $year >= date('Y') - 20; $year--)
                        <option value="{{ $year }}" {{ request('year_min') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Year (Max)</label>
                    <select name="year_max" id="yearMax" class="form-control">
                        <option value="">Select...</option>
                        @for($year = date('Y') + 1; $year >= date('Y') - 20; $year--)
                        <option value="{{ $year }}" {{ request('year_max') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Make --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Make</label>
                    <select name="make" id="makeSelect" class="form-control">
                        <option value="">Select...</option>
                        @foreach($makes ?? [] as $make)
                        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Model --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Model</label>
                    <select name="model" id="modelSelect" class="form-control">
                        <option value="">Select...</option>
                        @foreach($models ?? [] as $model)
                        <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Trim --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Trim</label>
                    <select name="trim" id="trimSelect" class="form-control">
                        <option value="">Select...</option>
                        @foreach($trims ?? [] as $trim)
                        <option value="{{ $trim }}" {{ request('trim') == $trim ? 'selected' : '' }}>{{ $trim }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Colors --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Color (Int)</label>
                    <select name="color_int" id="colorInt" class="form-control">
                        <option value="">Select...</option>
                        @foreach($interiorColors ?? [] as $color)
                        <option value="{{ $color }}" {{ request('color_int') == $color ? 'selected' : '' }}>{{ $color }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Color (Ext)</label>
                    <select name="color_ext" id="colorExt" class="form-control">
                        <option value="">Select...</option>
                        @foreach($exteriorColors ?? [] as $color)
                        <option value="{{ $color }}" {{ request('color_ext') == $color ? 'selected' : '' }}>{{ $color }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Mileage Range --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mileage (Min)</label>
                    <select name="mileage_min" id="mileageMin" class="form-control">
                        <option value="">Select...</option>
                        @foreach([0, 10000, 20000, 30000, 50000, 75000, 100000] as $mileage)
                        <option value="{{ $mileage }}" {{ request('mileage_min') == $mileage ? 'selected' : '' }}>{{ number_format($mileage) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mileage (Max)</label>
                    <select name="mileage_max" id="mileageMax" class="form-control">
                        <option value="">Select...</option>
                        @foreach([25000, 50000, 75000, 100000, 150000, 200000] as $mileage)
                        <option value="{{ $mileage }}" {{ request('mileage_max') == $mileage ? 'selected' : '' }}>{{ number_format($mileage) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Footer --}}
            <div class="offcanvas-footer mt-5">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>