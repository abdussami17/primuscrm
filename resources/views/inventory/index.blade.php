@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="content content-two pt-0">

        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3"
            style="min-height: 80px;">
            <div>
                <h6 class="mb-0">Inventory</h6>
            </div>

            <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" class="mobile-logo-no logo-img"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#emailModal">
                    <i class="isax isax-eye me-1"></i>View Brochure Wizard
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <form action="{{ route('inventory.index') }}" method="GET" class="d-flex align-items-center gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            {{-- <div class="search-input">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></button>
                        </div> --}}
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn-searchset"><i
                                        class="isax isax-search-normal fs-12"></i></a>
                            </div>
                        </div>
                    </form>
                    <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);"
                        data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                        <i class="isax isax-filter me-1"></i>Filter
                    </a>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            {{ request('condition') ? ucfirst(request('condition')) : 'All Vehicles' }} <i
                                class="ti ti-chevron-down ms-2 fw-bold"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="{{ route('inventory.index', array_merge(request()->except('condition'), [])) }}"
                                    class="dropdown-item {{ !request('condition') ? 'active' : '' }}">All Vehicles</a></li>
                            <li><a href="{{ route('inventory.index', array_merge(request()->all(), ['condition' => 'new'])) }}"
                                    class="dropdown-item {{ request('condition') == 'new' ? 'active' : '' }}">New</a></li>
                            <li><a href="{{ route('inventory.index', array_merge(request()->all(), ['condition' => 'used'])) }}"
                                    class="dropdown-item {{ request('condition') == 'used' ? 'active' : '' }}">Pre-Owned</a>
                            </li>
                            <li><a href="{{ route('inventory.index', array_merge(request()->all(), ['condition' => 'certified_pre_owned'])) }}"
                                    class="dropdown-item {{ request('condition') == 'certified_pre_owned' ? 'active' : '' }}">CPO</a>
                            </li>
                            <li><a href="{{ route('inventory.index', array_merge(request()->all(), ['condition' => 'demo'])) }}"
                                    class="dropdown-item {{ request('condition') == 'demo' ? 'active' : '' }}">Demo</a>
                            </li>
                            <li><a href="{{ route('inventory.index', array_merge(request()->all(), ['condition' => 'wholesale'])) }}"
                                    class="dropdown-item {{ request('condition') == 'wholesale' ? 'active' : '' }}">Wholesale</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @if (request()->hasAny(['search', 'condition', 'year_min', 'year_max', 'make', 'model']))
                <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
                    <h6 class="fs-13 fw-semibold">Active Filters</h6>
                    @if (request('search'))
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge">
                            Search: {{ request('search') }}
                            <a href="{{ route('inventory.index', request()->except('search')) }}" class="ms-1 tag-close"><i
                                    class="fa-solid fa-x fs-10"></i></a>
                        </span>
                    @endif
                    @if (request('condition'))
                        <span class="tag bg-light border rounded-1 fs-12 text-dark badge">
                            {{ ucfirst(str_replace('_', ' ', request('condition'))) }}
                            <a href="{{ route('inventory.index', request()->except('condition')) }}"
                                class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></a>
                        </span>
                    @endif
                    <a href="{{ route('inventory.index') }}"
                        class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
                </div>
            @endif
        </div>

        <!-- Inventory Table -->
        <div class="table-responsive">
            <table class="table table-nowrap datatable" id="inventoryTable">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th>Photos</th>
                        <th>
                            <a
                              class="text-white"  href="{{ route('inventory.index', array_merge(request()->all(), ['sort' => 'stock_number', 'dir' => request('dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                Stock # {!! request('sort') == 'stock_number' ? (request('dir') == 'asc' ? '↑' : '↓') : '' !!}
                            </a>
                        </th>
                        <th>CARFAX</th>
                        <th>VB</th>
                        <th>
                            <a
                                href="{{ route('inventory.index', array_merge(request()->all(), ['sort' => 'year', 'dir' => request('dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                Year {!! request('sort') == 'year' ? (request('dir') == 'asc' ? '↑' : '↓') : '' !!}
                            </a>
                        </th>
                        <th>
                            <a
                              class="text-white"  href="{{ route('inventory.index', array_merge(request()->all(), ['sort' => 'make', 'dir' => request('dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                Make {!! request('sort') == 'make' ? (request('dir') == 'asc' ? '↑' : '↓') : '' !!}
                            </a>
                        </th>
                        <th>Model</th>
                        <th>Trim</th>
                        <th>Body Style</th>
                        <th>Drive Type</th>
                        <th>Doors</th>
                        <th>Interior / Exterior</th>
                        <th>VIN</th>
                        <th>
                            <a
                              class="text-white"  href="{{ route('inventory.index', array_merge(request()->all(), ['sort' => 'price', 'dir' => request('dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                Price {!! request('sort') == 'price' ? (request('dir') == 'asc' ? '↑' : '↓') : '' !!}
                            </a>
                        </th>
                        <th>Hold Details</th>
                        <th>KM's</th>
                        <th>Age</th>
                        <th>Inventory Type</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                        <tr data-inventory-id="{{ $item->id }}">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input row-checkbox" type="checkbox"
                                        value="{{ $item->id }}">
                                </div>
                            </td>
                            <td>
                                <div class="car-image_inventory">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageInventory"
                                        data-inventory-id="{{ $item->id }}">
                                        @php
                                            $images = [];
                                            if (!empty($item->images)) {
                                                $images = is_array($item->images)
                                                    ? $item->images
                                                    : json_decode($item->images, true);
                                                if (!is_array($images)) {
                                                    $images = [];
                                                }
                                            }
                                            $firstImage =
                                                count($images) > 0 ? $images[0] : asset('assets/img/car-detail/1.jpg');
                                        @endphp

                                        <img src="{{ $firstImage }}" alt="{{ $item->make }} {{ $item->model }}"
                                            style="width: 100px; height: auto;">
                                        <div class="image-count-overlay d-none">{{ count($images) }}</div>
                                    </a>
                                </div>

                            </td>
                            <td class="fw-semibold text-primary">{{ $item->stock_number ?? 'N/A' }}</td>
                            <td>
                                {{-- @if ($item->carfax_available)
                                    <i class="ti ti-check text-success fw-bold"></i>
                                @endif --}}
                               <a  href="https://www.carfax.ca/tools/vin-decode"><i class="ti ti-link"></i></a>
                            </td>
                            <td><i class="ti ti-check text-success fw-bold"></i></td>
                            <td>{{ $item->year }}</td>
                            <td>{{ $item->make }}</td>
                            <td>{{ $item->model }}</td>
                            <td>{{ $item->trim ?? '-' }}</td>
                            <td>{{ $item->body_type ?? '-' }}</td>
                            <td>{{ $item->drivetrain ?? '-' }}</td>
                            <td>{{ $item->doors ?? '4' }}D</td>
                            <td>{{ $item->interior_color ?? 'N/A' }} / {{ $item->exterior_color ?? 'N/A' }}</td>
                            <td>{{ $item->vin ?? 'N/A' }}</td>
                            <td>
                                <a href="javascript:void(0);" class="text-danger text-decoration-underline"
                                    data-bs-toggle="modal" data-bs-target="#priceAdjustmentModal"
                                    data-inventory-id="{{ $item->id }}">
                                    ${{ number_format($item->price, 2) }}
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="text-black text-decoration-underline"
                                    data-bs-toggle="modal" data-bs-target="#availabilityModal"
                                    data-inventory-id="{{ $item->id }}">
                                    View All
                                </a>
                            </td>
                            <td>{{ number_format($item->mileage ?? 0) }}</td>
                            <td>{{ $item->created_at ? $item->created_at->diffInDays(now()) : 0 }}</td>
                            <td>
                                @php
                                    $conditionLabels = [
                                        'new' => 'New',
                                        'used' => 'Pre-Owned',
                                        'certified_pre_owned' => 'CPO',
                                        'demo' => 'Demo',
                                        'wholesale' => 'Wholesale',
                                    ];
                                @endphp
                                {{ $conditionLabels[$item->condition] ?? ucfirst($item->condition) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19" class="text-center text-muted py-4">
                                No inventory items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
      
        <div class="d-flex align-items-center justify-content-between mt-2">
            <p class=" fw-medium mb-0">
                Showing <span id="start-item">0</span> to <span id="end-item">0</span>
                of <span id="total-items">0</span> entries
            </p>
            <select id="rows-per-page" class="form-select" style="width:80px">
                <option value="25" selected>25</option>
                <option value="75">75</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
            </select>
        
           
        </div>
       
        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $inventory->firstItem() ?? 0 }} to {{ $inventory->lastItem() ?? 0 }} of
                {{ $inventory->total() }} entries
            </div>
            {{ $inventory->appends(request()->query())->links() }}
        </div> --}}

        <!-- Image Count Toggle -->
        <div class="form-check mt-1">
            <input class="form-check-input" type="checkbox" id="showCountCheckbox"
                {{ session('show_image_count') ? 'checked' : '' }}>
            <label class="form-check-label" for="showCountCheckbox">Show Image Count</label>
        </div>

        {{-- <p class="mt-2">
            <span class="text-danger fw-bold">Red</span> Stock numbers must be removed manually. They will not get removed
            via a DMS import.<br>
            Use the search box to search by make, model, stock # or VIN.<br>
            Click on column headings to sort.
        </p> --}}
    </div>

    <!-- Filter Offcanvas -->
    @include('inventory.partials.filter-offcanvas')

    <!-- Email Modal -->
    @include('inventory.partials.email-modal')

    <!-- Availability Modal -->
    @include('inventory.partials.availability-modal')

    <!-- Price Adjustment Modal -->
    @include('inventory.partials.price-modal')

    <!-- Image Gallery Modal -->
    @include('inventory.partials.image-modal')

    @include('inventory.scripts')

    <!-- Minimized Bar -->
    <div id="minimizedBar" class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow"
        style="cursor:pointer;border-radius:50%;">
        Brochure
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/inventory.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/inventory.js') }}"></script>
@endpush
