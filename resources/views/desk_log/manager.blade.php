@extends('layouts.app')

@section('title', "Manager's Desklog")
@section('content')
    <div class="content content-two p-0 ps-3 pe-3" id="showroom-page">
        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
            style="min-height: 80px;">
            <div>
                <h6 class="mb-0">Manager's Desklog</h6>
            </div>
            <img src="assets/light_logo.png" alt="Logo" class="logo-img mobile-logo-no"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">
            <div class="d-flex my-xl-auto right-content align-items-center gap-2">
                <select class="form-select form-select-sm" id="savedFiltersDropdown">
                    <option value="" selected>Select Saved Filter</option>
                </select>
                <button style="min-width: 100px;" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#saveFilterModal">Save Filters</button>
            </div>
        </div>

        @php
            $hasFilters = false;
            if (isset($filters) && is_array($filters) && count(array_filter($filters))) {
                $hasFilters = true;
            }
        @endphp

        {{-- @if (config('app.debug'))
            <div class="alert alert-info small">
                <strong>Debug:</strong>
                <div>Applied filters: <pre style="display:inline">{{ json_encode($filters, JSON_PRETTY_PRINT) }}</pre></div>
                <div>Deals returned: <strong>{{ $deals->count() }}</strong></div>
            </div>
        @endif --}}

        <div class="split-container">
            <div class="split-view">
                <div class="crm-box">
                    <div class="crm-header">Desk Log @if ($hasFilters)
                            ({{ $deals->count() }})
                        @else
                            <small class="text-muted">— apply filters to view results</small>
                        @endif
                    </div>

                    {{-- Main Filter Form --}}
                    <form class="row g-2" id="filterForm" method="GET" action="{{ route('desk-log.manager') }}">

                        <div class="col-md-3 mb-2">
                            <label class="form-label">From</label>
                            <input type="text" name="from_date" class="form-control cf-datepicker"
                                placeholder="Select From Date" value="{{ $filters['from_date'] ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">To</label>
                            <input type="text" name="to_date" class="form-control cf-datepicker"
                                placeholder="Select To Date" value="{{ $filters['to_date'] ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Users</label>
                            <select class="form-select" name="user_id">
                                <option value="">--ALL--</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Teams</label>
                            <select class="form-select" name="team">
                                <option value="">--ALL--</option>
                                @foreach ($teams as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ ($filters['team'] ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date Preset Links --}}
                        <div class="col-md-5 dates-option">
                            @foreach ([
            'ytd' => 'YTD',
            'thisWeek' => 'This Week',
            'lastWeek' => 'Last Week',
            'lastMonth' => 'LM',
            'mtd' => 'MTD',
            'last7Days' => 'Last 7 Days',
            'yesterday' => 'Yesterday',
            'today' => 'Today',
            'last30days' => 'Last 30 Days',
            'last60days' => 'Last 60 Days',
            'last90days' => 'Last 90 Days',
            'next7days' => 'Next 7 Days',
        ] as $preset => $label)
                                <span
                                    class="me-2 preset-item {{ ($filters['preset'] ?? '') == $preset ? 'fw-bold text-primary' : '' }}"
                                    data-url="{{ route('desk-log.manager', array_merge($filters, ['preset' => $preset])) }}"
                                    style="cursor: pointer;">
                                    {{ $label }}
                                </span>

                                @if ($loop->index == 7)
                                    <br>
                                @endif
                            @endforeach
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.querySelectorAll('.preset-item').forEach(function(el) {
                                    el.addEventListener('click', function() {
                                        window.location.href = this.dataset.url;
                                    });
                                });
                            });
                        </script>


                        <div class="col-6 mt-2 d-flex gap-2 button-group mb-3">
                            <button type="button" id="resetFiltersBtn" class="btn btn-secondary">Refresh</button>
                            {{-- <a href="{{ route('desk-log.manager') }}" class="btn btn-light border">View All</a> --}}
                            <a href="{{ route('desk-log.export', $filters) }}" class="btn btn-outline-primary">Export</a>
                            <button type="button" class="btn btn-outline-dark" onclick="window.print()">Print</button>
                            <button type="button" id="serviceApptBtn"
                                class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                                title="Today's Service Appointments">
                                <i class="bi bi-tools"></i>
                            </button>

                        </div>

                        <div class="col-12" id="toggleFiltersBtn">
                            <button type="button" class="float-end btn btn-sm btn-outline-primary border-2"
                                onclick="document.querySelector('.extra-filters').classList.toggle('d-none'); this.textContent = this.textContent === 'Hide Filters' ? 'View More Filters' : 'Hide Filters';">
                                View More Filters
                            </button>
                        </div>

                        {{-- Extra Filters --}}
                        <div class="extra-filters row d-none">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Type</label>
                                <select class="form-select" name="lead_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($leadTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['lead_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Lead Status</label>
                                <select class="form-select" name="lead_status">
                                    <option value="">--ALL--</option>
                                    @foreach ($leadStatuses as $status)
                                        <option value="{{ $status }}"
                                            {{ ($filters['lead_status'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Source</label>
                                <select class="form-select" name="source">
                                    <option value="">--ALL--</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source }}"
                                            {{ ($filters['source'] ?? '') == $source ? 'selected' : '' }}>
                                            {{ $source }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Visits</label>
                                <select class="form-select" name="visits">
                                    <option value="">--ALL--</option>
                                    <option value="closed" {{ ($filters['visits'] ?? '') == 'closed' ? 'selected' : '' }}>
                                        Closed Visits</option>
                                    <option value="open" {{ ($filters['visits'] ?? '') == 'open' ? 'selected' : '' }}>
                                        Open Visits</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Inventory Type</label>
                                <select class="form-select" name="inventory_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($inventoryTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['inventory_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Dealership</label>
                                <select class="form-select" name="dealership">
                                    <option value="">--ALL--</option>
                                    @foreach ($dealerships as $d)
                                        <option value="{{ $d['id'] }}"
                                            {{ ($filters['dealership'] ?? '') == $d['id'] ? 'selected' : '' }}>
                                            {{ $d['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Sales Status</label>
                                <select class="form-select" name="sales_status">
                                    <option value="">--ALL--</option>
                                    @foreach ($salesStatuses as $status)
                                        <option value="{{ $status }}"
                                            {{ ($filters['sales_status'] ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Deal Type</label>
                                <select class="form-select" name="deal_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($dealTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['deal_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Sales Type</label>
                                <select class="form-select" name="sales_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($salesTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['sales_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Task Type</label>
                                <select class="form-select" name="task_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($taskTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['task_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Status Type</label>
                                <select class="form-select" name="status_type">
                                    <option value="">--ALL--</option>
                                    @foreach ($statusTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ ($filters['status_type'] ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Save Filter Modal --}}
        <div class="modal fade" id="saveFilterModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Save Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Filter Name</label>
                        <input type="text" class="form-control" id="filterName" placeholder="Enter filter name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSaveFilter">Save</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="table-responsive table-nowrap mb-4 datatable-has-controls">
            <div class="d-flex justify-content-between mb-2 align-items-center">
                {{-- <div id="tableSearch" class="search-input"></div> --}}
                {{-- <div id="tableButtons" class="btn-toolbar"></div> --}}
            </div>
            <table id="filterTable" class="table border datatable dataTable no-footer no-dt-auto">
                <thead class="table-light">
                    <tr>
                        <th class="no-sort" style="width: 80px;">Add Task</th>
                        <th><span class="header-text" style="padding:5px;">Lead Type</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Lead Contacted Within</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Assigned To</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Assigned By</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Created Date/Time</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Customer/Vehicle Information</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th style="min-width: 250px;"><span style="padding:5px;" class="header-text">Showroom
                                Details</span><i class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Source</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Notes</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text"style="padding:5px;">Phone</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Sold</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Delivered</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Credit Score</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                        <th><span class="header-text" style="padding:5px;">Created By</span><i
                                class="bi bi-arrows-move drag-handle" data-bs-toggle="tooltip"
                                data-bs-title="Move Column"></i></th>
                    </tr>
                    <tr id="filtersRowDesklog" class="filter-row">
                        <th class="no-sort"></th>
                        <th>
                            <div class="filter-wrapper" data-col="1"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="2"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="3"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="4"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="5"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="6"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="7"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="8"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="9"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="10"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="11"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="12"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="13"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="14"></div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($hasFilters)
                        @forelse($deals as $deal)
                            @php
                                $latestVisit = $deal->showroomVisits()->latest('start_time')->first();
                                $isActiveVisit = $latestVisit && !$latestVisit->end_time;
                            @endphp
                            <tr data-deal-id="{{ $deal->id }}" data-customer-id="{{ $deal->customer->id ?? '' }}"
                                data-customer-name="{{ $deal->customer->full_name ?? '' }}"
                                data-customer-email="{{ $deal->customer->email ?? '' }}"
                                data-customer-home="{{ $deal->customer->home_phone ?? '' }}"
                                data-customer-work="{{ $deal->customer->work_phone ?? '' }}"
                                data-customer-cell="{{ $deal->customer->cell_phone ?? '' }}"
                                data-vehicle="{{ $deal->inventory ? $deal->inventory->year . ' ' . $deal->inventory->make . ' ' . $deal->inventory->model : '' }}"
                                data-salesperson-id="{{ $deal->salesPerson->id ?? '' }}"
                                data-salesmanager-id="{{ $deal->salesManager->id ?? '' }}">
                                <td class="fw-semibold text-primary" data-bs-toggle="modal" data-bs-target="#add_modal">
                                    <i data-bs-toggle="tooltip" data-bs-title="Add Task" class="ti ti-copy-plus"></i>
                                </td>
                                <td>{{ $deal->lead_type ?? 'N/A' }}</td>
                                <td>{{ $deal->lead_contacted_within }}</td>
                                <td>{{ $deal->salesPerson->name ?? 'Unassigned' }}</td>
                                <td>{{ $deal->salesManager->name ?? 'N/A' }}</td>
                                <td>{{ $deal->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                <td>
                                    <div class="custom-hover-container name-cell">
                                        <a href="#"
                                            class="customer-link text-black text-decoration-underline fw-semibold"
                                            data-url="{{ $deal->customer ? route('customers.edit', $deal->customer->id) : '#' }}"
                                            data-ajax-popup="true" data-title="{{ __('Customer Profile') }}">
                                            {{ $deal->customer->full_name ?? 'N/A' }}
                                        </a>

                                        <div class="custom-hover-box" aria-hidden="true">
                                            <div class="hover-inner">
                                                <div class="hover-img-wrap">
                                                    <img src="{{ asset($deal->customer->profile_image ?? 'assets/img/default-avatar.png') }}"
                                                        alt="Customer Photo">
                                                    <span
                                                        class="status-dot {{ $deal->customer->is_online ?? false ? 'online' : '' }}"
                                                        title="{{ $deal->customer->is_online ?? false ? 'Online' : '' }}"></span>
                                                </div>
                                                <div class="hover-details">
                                                    <strong
                                                        class="hover-name">{{ $deal->customer->full_name ?? '' }}</strong>
                                                    <div class="hover-line">
                                                        {{ $deal->customer->street_address ?? '' }}{{ $deal->customer->city ?? '' }},
                                                        {{ $deal->customer->state ?? '' }}
                                                        {{ $deal->customer->zip_code ?? '' }}</div>
                                                    <div class="hover-line">Cell:
                                                        {{ $deal->customer->cell_phone ?? ($deal->customer->phone ?? '-') }}
                                                    </div>
                                                    <div class="hover-line">Email: {{ $deal->customer->email ?? '-' }}
                                                    </div>
                                                    <div class="hover-line">Sales Rep:
                                                        {{ $deal->customer->assignedUser->name ?? '-' }}</div>
                                                    <div class="hover-line muted small">Last Updated:
                                                        {{ $deal->customer->updated_at ? $deal->customer->updated_at->format('n/j/y g:ia') : '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- deals badge intentionally omitted in desk log --}}
                                    </div>
                                    @if ($deal->inventory)
                                        <div class="text-muted">
                                            {{ $deal->inventory->year ?? '' }}
                                            <a data-bs-toggle="offcanvas" href="#"
                                                data-bs-target="#editvehicleinfo" class="text-decoration-underline">
                                                {{ $deal->inventory->make ?? '' }} {{ $deal->inventory->model ?? '' }}
                                            </a>
                                            ({{ $deal->inventory->stock_number ?? '' }})
                                            ({{ $deal->inventory_type_code }})<br>
                                            {{ $deal->inventory->vin ?? '' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div id="showroom-actions-{{ $deal->id }}"
                                        @if ($latestVisit) data-visit-id="{{ $latestVisit->id }}"
                                                                     data-visit-flags='@json($latestVisit->flags ?? [])' @endif>

                                        {{-- Show active visit / open visit buttons --}}
                                        @if ($isActiveVisit)
                                            <div id="openVisitRow-{{ $deal->id }}" class="d-none"></div>
                                            <div id="activeVisitRow-{{ $deal->id }}" class="align-items-center gap-2"
                                                data-start-ts="{{ $latestVisit->start_time?->getTimestamp() }}">
                                                <span class="badge bg-success">Open Showroom Visit</span>
                                                <button class="btn btn-danger btn-sm end-showroom-btn ms-2"
                                                    data-deal-id="{{ $deal->id }}" data-bs-toggle="offcanvas"
                                                    data-bs-target="#editShowroomVisitCanvas">
                                                    End Showroom Visit
                                                </button>
                                                <span id="visitTimer-{{ $deal->id }}"
                                                    class="fw-semibold text-muted ms-2">
                                                    {{ $latestVisit ? ($isActiveVisit ? '00hrs 00mins 00seconds' : (isset($latestVisit->duration) ? gmdate('H\:i\:s', $latestVisit->duration) : '00hrs 00mins 00seconds')) : '00hrs 00mins 00seconds' }}
                                                </span>
                                            </div>
                                        @elseif($latestVisit)
                                            <div id="openVisitRow-{{ $deal->id }}" class="d-none"></div>
                                            <div id="activeVisitRow-{{ $deal->id }}"
                                                class="align-items-center gap-2">
                                                <a class="credit-link end-showroom-btn" href="#"
                                                    data-deal-id="{{ $deal->id }}" data-bs-toggle="offcanvas"
                                                    data-bs-target="#editShowroomVisitCanvas">
                                                    Edit Showroom Visit
                                                </a>
                                                <span class="fw-semibold text-muted ms-2">
                                                    {{ isset($latestVisit->duration) ? gmdate('H\:i\:s', $latestVisit->duration) : $latestVisit->start_time?->format('M d, Y h:i A') ?? '' }}
                                                </span>
                                            </div>
                                        @else
                                            <div id="openVisitRow-{{ $deal->id }}">
                                                <button class="btn btn-success btn-sm open-showroom-btn"
                                                    data-deal-id="{{ $deal->id }}">
                                                    Open Showroom Visit
                                                </button>
                                            </div>
                                            <div id="activeVisitRow-{{ $deal->id }}"
                                                class="d-none align-items-center gap-2">
                                                <span id="visitTimer-{{ $deal->id }}"
                                                    class="fw-semibold text-muted ms-2">00hrs 00mins 00seconds</span>
                                            </div>
                                        @endif

                                        {{-- Visit summary --}}
                                        @if ($latestVisit)
                                            {{-- <div class="small text-muted mt-1">
                                                {{ $latestVisit->start_time?->format('M d, Y h:i A') }}
                                            </div> --}}
                                            {{-- <div class="fw-semibold">{{ $latestVisit->user->name ?? '—' }}</div> --}}

                                            @php
                                                $defs =
                                                    $flagDefinitions && $flagDefinitions->count()
                                                        ? $flagDefinitions
                                                        : $fallback;
                                            @endphp

                                            {{-- Modern checkbox design --}}
                                            <div class="checkbox-container mt-1">
                                                @foreach ($flagDefinitions as $def)
                                                    @php
                                                        $k = $def->key;
                                                        $label = $def->label;
                                                        $checked = !empty($latestVisit->flags[$k])
                                                            ? (bool) $latestVisit->flags[$k]
                                                            : (bool) ($latestVisit->{$k} ?? false);
                                                    @endphp

                                                    <div class="checkbox-item">
                                                        <label
                                                            for="flag-{{ $deal->id }}-{{ $k }}">{{ $label }}</label>

                                                        <input type="checkbox"
                                                            id="flag-{{ $deal->id }}-{{ $k }}"
                                                            {{ $checked ? 'checked' : '' }} class="readonly-checkbox">
                                                    </div>
                                                @endforeach
                                            </div>


                                            {{-- @if ($latestVisit->end_time)
                                                <div class="small text-muted mt-1">
                                                    Duration:
                                                    {{ isset($latestVisit->duration) ? gmdate('H:i:s', $latestVisit->duration) : '' }}
                                                </div>
                                            @endif --}}

                                            <div class="custom-alert-box mt-1">
                                                <div class="alert-text">
                                                    @foreach ($deal->showroomVisits as $visit)
                                                        <div>
                                                            @php
                                                                $visitNote = $visit->related_notes
                                                                    ->sortByDesc('created_at')
                                                                    ->first();
                                                            @endphp
                                                            <div class="alert-text">
                                                                {{ $visitNote?->description }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>{{ $deal->customer->source ?? 'N/A' }}</td>
                                {{-- showroom visit summary moved into Showroom Details (see above) --}}
                                <td style="white-space:normal;">
                                    <div class="note-area">
                                        @php $latestNote = $deal->notes()->latest('created_at')->first(); @endphp
                                        {{ Str::limit($latestNote->description ?? '', 80) }}
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#noteModal{{ $deal->id }}" title="View / Add Notes">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if ($deal->customer->work_phone ?? false)
                                        <div>Work: <a
                                                href="tel:{{ $deal->customer->work_phone }}">{{ $deal->customer->work_phone }}</a>
                                        </div>
                                    @endif
                                    @if ($deal->customer->cell_phone ?? false)
                                        <div>Cell: <a
                                                href="tel:{{ $deal->customer->cell_phone }}">{{ $deal->customer->cell_phone }}</a>
                                        </div>
                                    @endif
                                    @if ($deal->customer->home_phone ?? false)
                                        <div>Home: <a
                                                href="tel:{{ $deal->customer->home_phone }}">{{ $deal->customer->home_phone }}</a>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($deal->sold_date)
                                        <span
                                            class="text-success fw-semibold">{{ $deal->sold_date->format('m-d-Y') }}</span>
                                    @else
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#dateModal{{ $deal->id }}-sold">
                                            <i class="fa-solid fa-xmark text-danger"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($deal->delivery_date)
                                        <span
                                            class="text-success fw-semibold">{{ $deal->delivery_date->format('m-d-Y') }}</span>
                                    @else
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#dateModal{{ $deal->id }}-delivery">
                                            <i class="fa-solid fa-xmark text-danger"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $deal->credit_display }}</td>
                                <td>{{ $deal->financeManager->name ?? 'Primus CRM' }}</td>
                            </tr>

                            {{-- inline modals moved below the table to avoid breaking DataTables (only TRs should be in tbody) --}}
                        @empty
                            <tr>
                                <td class="text-center text-muted py-4 align-middle" colspan="15">
                                    {{-- <i class="ti ti-folder-off fs-1 d-block mb-2"></i> --}}
                                    No deals found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td class="text-center text-muted py-4 align-middle" colspan="15">
                                {{-- <i class="ti ti-filter fs-1 d-block mb-2"></i> --}}
                                Please apply one or more filters above to display events.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Render per-deal modals outside the table so DataTables sees a clean tbody --}}
    @if ($hasFilters)
        @foreach ($deals as $deal)
            {{-- Note Modal for this deal --}}
            <div class="modal fade" id="noteModal{{ $deal->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Notes - {{ $deal->customer->full_name ?? 'Deal #' . $deal->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="note-history mb-4" style="max-height: 300px; overflow-y: auto;">
                                @php $allNotes = $deal->notes()->orderBy('created_at', 'desc')->get(); @endphp
                                @if ($allNotes->count())
                                    @foreach ($allNotes as $note)
                                        <div class="note-entry mb-3 p-2 bg-light rounded">{{ $note->description }}</div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No notes yet.</p>
                                @endif
                            </div>
                            <hr>
                            <form method="POST" action="{{ route('desk-log.add-note') }}">
                                @csrf
                                <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                                <label class="form-label fw-bold">Add Note</label>
                                <textarea name="note" class="form-control mb-3" rows="3" placeholder="Write your note..." required></textarea>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Add Note</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sold Date Modal --}}
            <div class="modal fade" id="dateModal{{ $deal->id }}-sold" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('desk-log.update-date') }}">
                            @csrf
                            <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                            <input type="hidden" name="date_type" value="sold_date">
                            <div class="modal-header py-2">
                                <h6 class="modal-title">Set Sold Date</h6>
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <input type="text" name="date" class="form-control cf-datepicker" required>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delivery Date Modal --}}
            <div class="modal fade" id="dateModal{{ $deal->id }}-delivery" tabindex="-1">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('desk-log.update-date') }}">
                            @csrf
                            <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                            <input type="hidden" name="date_type" value="delivery_date">
                            <div class="modal-header py-2">
                                <h6 class="modal-title">Set Delivery Date</h6>
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <input type="text" name="date" class="form-control cf-datepicker" required>
                            </div>
                            <div class="modal-footer py-2">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    <!-- Showroom Visit offcanvas (shared) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editShowroomVisitCanvas">
        <div class="offcanvas-header d-block pb-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
                <h6 class="offcanvas-title">Edit Showroom Visit</h6>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        </div>
        <div class="offcanvas-body pt-3">
            <div class="container">
                <div class="row g-2 mb-3">
                    <div class="col-md-4 mb-2">
                        <div class="mb-1"><strong>Assigned To:</strong></div>
                        <select class="form-select" id="showroom_assigned_to">
                            <option value="" selected>-- Select --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="mb-1"><strong>Assigned Manager:</strong></div>
                        <select class="form-select" id="showroom_assigned_manager">
                            <option value="">-- Select --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="mb-1"><strong>Lead Type:</strong></div>
                        <select class="form-select" id="showroom_lead_type">
                            <option value="Internet">Internet</option>
                            <option value="Walk-In">Walk-In</option>
                            <option value="Phone Up">Phone Up</option>
                            <option value="Text Up">Text Up</option>
                            <option value="Website Chat">Website Chat</option>
                            <option value="Import">Import</option>
                            <option value="Wholesale">Wholesale</option>
                            <option value="Lease Renewal">Lease Renewal</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="mb-1"><strong>Deal Type:</strong></div>
                        <select class="form-select" id="showroom_deal_type">
                            <option value="Finance">Finance</option>
                            <option value="Lease">Lease</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="mb-1"><strong>Source:</strong></div>
                        <select class="form-select" id="showroom_source">
                            <option value="Facebook">Facebook</option>
                            <option value="Marketplace">Marketplace</option>
                            <option value="Dealer Website">Dealer Website</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="section-title"><img src="{{ asset('assets/img/icons/user_illustration.png') }}"
                            class="title-icon">Did you enter all of their personal information?</div>
                    <div class="personal-content">
                        <p> Customer: <a href="#" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                id="showroom_customer_link">—</a></p>
                        <p> Email: <span id="showroom_customer_email">—</span></p>
                        <p> Home: <span id="showroom_customer_home">—</span></p>
                        <p> Work: <span id="showroom_customer_work">—</span></p>
                        <p> Cell: <span id="showroom_customer_cell">—</span></p>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title"><img src="{{ asset('assets/img/icons/vehicle_illustration.png') }}"
                            class="title-icon">Is this the correct vehicle they are interested in?</div>
                    <div class="personal-content mb-4 mt-3">
                        <p> Vehicle: <a href="#" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo"
                                id="showroom_vehicle_link">(none)</a></p>
                        <p> Trade-In: <a href="#" data-bs-toggle="modal" data-bs-target="#tradeInModal">(no
                                trade)</a></p>
                    </div>
                </div>

                @if ($flagDefinitions && $flagDefinitions->count())

                    <div class="form-section checkboxes-area ps-4 pe-4 row">
                        @foreach ($flagDefinitions as $flag)
                            <div class="col-md-12 mb-2 d-flex justify-content-between align-items-center">
                                <span>{{ $flag->label }}</span>
                                <div>
                                    @if ($flag->input_type === 'radio')
                                        <input class="form-check-input me-1" type="radio"
                                            name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}_yes"
                                            value="1">
                                        <label class="form-check-label me-3"
                                            for="flag_{{ $flag->key }}_yes">Yes</label>
                                        <input class="form-check-input me-1" type="radio"
                                            name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}_no"
                                            value="0" checked>
                                        <label class="form-check-label" for="flag_{{ $flag->key }}_no">No</label>
                                    @elseif($flag->input_type === 'checkbox')
                                        <input class="form-check-input me-1" type="checkbox"
                                            name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}"
                                            value="1">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="form-section checkboxes-area ps-4 pe-4 row">
                        <div class="col-12 text-muted small">No visit flags configured.</div>
                    </div>
                @endif

                <!-- Note: showroom visit changes can be recorded as a customer note using the normal note submission -->
                <div class="container px-3 mt-3">
                    <div class="mb-2 small text-muted">Checking the box below will add the showroom visit summary to the
                        customer's notes using the standard note submission workflow.</div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="showroom_add_note" checked>
                        <label class="form-check-label" for="showroom_add_note">Also add this to customer's notes</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Optional note text</label>
                        <textarea id="showroom_note_text" class="form-control" rows="3"
                            placeholder="Enter note to add to customer (optional)"></textarea>
                        <input type="hidden" id="showroom_note_deal_id" value="">
                        <input type="hidden" id="showroom_visit_id" value="">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-light border" data-bs-dismiss="offcanvas">Cancel</button>
                    <button class="btn btn-primary ms-2" id="saveShowroomVisit">Save</button>
                </div>
            </div>
        </div>
    </div>



    {{-- Add task Modal --}}
    <div id="add_modal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="taskFormModal" class="no-global-ajax" method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="modal-body pb-2">
                        <div class="row g-2">

                            <!-- Due Date -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Due Date</label>
                                <input type="text" value="" name="due_date" id="dueDatePickerModal"
                                    class="bg-light form-control cf-datepicker" placeholder="Select Due Date">
                                <input type="hidden" id="taskIdModal" name="task_id">
                                <input type="hidden" id="dealIdModal" name="deal_id">
                                <input type="hidden" id="customerIdModal" name="customer_id">

                            </div>

                            <!-- Customer Search -->
                            <div class="col-md-6 mb-4 position-relative">
                                <label class="form-label">Customer</label>
                                <input type="text" name="customer_search" class="form-control"
                                    id="customerSearchModal" placeholder="Enter name, email, or phone">
                                <div id="customerSuggestionsModal" class="list-group position-absolute w-100 mt-1 "
                                    style="z-index: 1050;"></div>
                            </div>

                            <!-- Deal List -->
                            <div class="col-md-12 mb-4 d-none" id="dealSectionModal">
                                <label class="form-label deal-section-header">Select Event</label>
                                <div class="list-group" id="dealListModal"></div>
                            </div>

                            <!-- Assigned To -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Assigned To</label>
                                <select class="form-select" id="assignedToModal" name="assigned_to">
                                    <option value="" hidden>-- Select --</option>
                                    @if ($users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No record found</option>
                                    @endif

                                </select>
                            </div>

                            <!-- Status Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Status Type</label>
                                <select class="form-select" id="statusTypeModal" name="status_type">
                                    <option value="" hidden>-- Select --</option>
                                    <option value="open">Open</option>
                                    <option value="completed">Completed</option>
                                    <option value="missed">Missed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="walkin">Walk-In</option>
                                    <option value="noresponse">No Response</option>
                                    <option value="noshow">No Show</option>
                                </select>
                            </div>

                            <!-- Task Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Task Type</label>
                                <select class="form-select" id="taskTypeModal" name="task_type">
                                    <option value="" hidden>-- Select --</option>
                                    <option value="call">Inbound Call</option>
                                    <option value="call_outbound">Outbound Call</option>
                                    <option value="text_inbound">Inbound Text</option>
                                    <option value="text_outbound">Outbound Text</option>
                                    <option value="email_inbound">Inbound Email</option>
                                    <option value="email_outbound">Outbound Email</option>
                                    <option value="csi">CSI</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Phone Scripts with Tom Select -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Phone Scripts</label>
                                <select id="phoneScriptSelectModal" name="phone_script_id"
                                    placeholder="Search & select script..."></select>
                            </div>

                            <!-- Priority -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Priority</label>
                                <select class="form-select" id="priorityModal" name="priority">
                                    <option value="" hidden>-- Select --</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="descriptionFieldModal" rows="3"
                                    placeholder="Enter task description (max 140 characters)"></textarea>
                                <div class="description-counter"><span id="charCountModal">0</span>/140</div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-end gap-1">
                        <button type="button" class="btn btn-light border border-1"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskForm = document.getElementById('taskFormModal');
            if (!taskForm) return;

            // Prevent binding the handler multiple times
            if (taskForm.dataset.ajaxBound) return;
            taskForm.dataset.ajaxBound = '1';

            taskForm.addEventListener('submit', function(e) {
                // stop other handlers and bubbling to avoid duplicate global interceptions
                try {
                    e.stopImmediatePropagation();
                } catch (er) {}
                e.preventDefault();

                // Simple in-flight guard to prevent multiple submissions
                if (taskForm.dataset.saving === '1') return;
                taskForm.dataset.saving = '1';

                const submitBtn = taskForm.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;

                const fd = new FormData(taskForm);
                const action = taskForm.getAttribute('action') || '';
                if (!action) {
                    alert('No task endpoint configured');
                    if (submitBtn) submitBtn.disabled = false;
                    taskForm.dataset.saving = '0';
                    return;
                }

                fetch(action, {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(r => r.json?.() || r.text())
                    .then(res => {
                        if (!res) {
                            throw new Error('Empty response');
                        }
                        if (res.status && (res.status === 'success' || res.status === 200)) {
                            try {
                                const modalEl = document.getElementById('add_modal');
                                const bsModal = (typeof bootstrap.Modal.getInstance === 'function' ?
                                        bootstrap.Modal.getInstance(modalEl) : null) || new bootstrap
                                    .Modal(modalEl);
                                if (bsModal) bsModal.hide();
                            } catch (e) {}
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Task saved',
                                    text: res.message || 'Task created',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                alert(res.message || 'Task created');
                            }
                            // Optionally refresh page to show new task
                            setTimeout(() => location.reload(), 800);
                        } else {
                            // show validation/other errors
                            if (typeof warningAlert === 'function') {
                                warningAlert(res);
                            } else {
                                alert((res && res.message) ? res.message : 'Failed to create task');
                            }
                        }
                    }).catch(err => {
                        console.error('Task save failed', err);
                        if (typeof warningAlert === 'function') warningAlert({
                            message: err.message || 'Failed to create task'
                        });
                        else alert('Failed to create task');
                    }).finally(() => {
                        if (submitBtn) submitBtn.disabled = false;
                        taskForm.dataset.saving = '0';
                    });
            });
        });
    </script>

    <style>
        .readonly-checkbox {
            pointer-events: none;
            /* blocks mouse clicks */
        }

        .dates-option a {
            cursor: pointer;
            padding: 2px 8px;
            border-radius: 4px;
            text-decoration: none;
            color: inherit;
        }

        .dates-option a:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Saved Filters (localStorage only - minimal JS)
        document.addEventListener('DOMContentLoaded', function() {

            const dropdown = document.getElementById('savedFiltersDropdown');
            const saveBtn = document.getElementById('confirmSaveFilter');
            const nameInput = document.getElementById('filterName');
            const form = document.getElementById('filterForm');

            if (!saveBtn || !dropdown || !form) {
                console.error('Desklog filter elements missing');
                return;
            }

            // -------------------------
            // Load dropdown
            // -------------------------
            function loadDropdown() {
                const filters = JSON.parse(localStorage.getItem('desklogFilters') || '[]');
                dropdown.innerHTML = '<option value="">Select Saved Filter</option>';
                filters.forEach((f, i) => {
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = f.name;
                    dropdown.appendChild(opt);
                });
                console.log('Dropdown loaded with filters:', filters);
            }

            loadDropdown();

            // -------------------------
            // APPLY FILTER
            // -------------------------
            dropdown.addEventListener('change', function() {
                if (!this.value) return;

                // 🔹 always reload from localStorage in case new filters were added
                const filters = JSON.parse(localStorage.getItem('desklogFilters') || '[]');
                const filter = filters[this.value];

                console.log('Selected filter index:', this.value, 'Filter:', filter);

                if (!filter?.data) return;

                Object.entries(filter.data).forEach(([key, value]) => {
                    const els = form.querySelectorAll(`[name="${key}"]`);
                    if (!els.length) {
                        console.warn(`Field not found for name="${key}"`);
                        return;
                    }
                    els.forEach(el => {
                        switch (el.type) {
                            case 'checkbox':
                                el.checked = value === 'on' || value === '1' || value ===
                                    true;
                                break;
                            case 'radio':
                                el.checked = el.value == value;
                                break;
                            default:
                                el.value = value;
                                break;
                        }

                        if (el.tomselect) {
                            el.tomselect.setValue(value, true);
                        }
                    });
                });

                if (typeof fetchDesklog === 'function') {
                    fetchDesklog();
                }
            });

            // -------------------------
            // SAVE FILTER
            // -------------------------
            saveBtn.addEventListener('click', function() {
                const name = nameInput.value.trim();
                if (!name) {
                    alert('Please enter filter name');
                    return;
                }

                const filters = JSON.parse(localStorage.getItem('desklogFilters') || '[]');

                const data = {};
                new FormData(form).forEach((v, k) => {
                    const field = form.querySelector(`[name="${k}"]`);
                    if (!field) return;

                    if (field.type === 'checkbox') {
                        data[k] = field.checked ? 'on' : 'off';
                    } else {
                        data[k] = v;
                    }
                });

                filters.push({
                    name,
                    data
                });
                localStorage.setItem('desklogFilters', JSON.stringify(filters));

                // close modal
                const modalEl = document.getElementById('saveFilterModal');
                if (modalEl && window.bootstrap) {
                    bootstrap.Modal.getInstance(modalEl)?.hide();
                }

                loadDropdown();
                nameInput.value = '';

                alert('Filter saved successfully');
                console.log('Saved filter data:', data);
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize flatpickr for date fields
            if (typeof flatpickr !== 'undefined') {
                document.querySelectorAll('.cf-datepicker').forEach(function(el) {
                    flatpickr(el, {
                        dateFormat: 'Y-m-d'
                    });
                });
            }

            // Initialize DataTable if available. Avoid re-initialising an already active instance
            // Also enable column dragging and safe reinitialization after columns are moved.
            if (typeof $ !== 'undefined' && $.fn && $.fn.DataTable) {
                // Setup column dragging handlers (operate on the first thead row)
                try {
                    const table = document.getElementById('filterTable');
                    if (table) {
                        const headers = table.querySelectorAll('thead tr:first-child th:not(.no-sort)');
                        let draggingHeader = null;
                        let draggingIndex = null;

                        headers.forEach(th => {
                            th.setAttribute('draggable', true);

                            th.addEventListener('dragstart', function(e) {
                                draggingHeader = this;
                                draggingIndex = [...this.parentNode.children].indexOf(this);
                                this.classList.add('dragging');
                                e.dataTransfer.effectAllowed = 'move';
                            });

                            th.addEventListener('dragover', function(e) {
                                e.preventDefault();
                                e.dataTransfer.dropEffect = 'move';
                                if (this !== draggingHeader) this.classList.add('drag-over');
                            });

                            th.addEventListener('dragleave', function() {
                                this.classList.remove('drag-over');
                            });

                            th.addEventListener('drop', function(e) {
                                e.preventDefault();
                                if (this !== draggingHeader) {
                                    const targetIndex = [...this.parentNode.children].indexOf(this);
                                    moveColumn(draggingIndex, targetIndex);
                                }
                                this.classList.remove('drag-over');
                            });

                            th.addEventListener('dragend', function() {
                                this.classList.remove('dragging');
                                headers.forEach(h => h.classList.remove('drag-over'));
                            });
                        });

                        function moveColumn(from, to) {
                            // Reorder cells reliably by rebuilding the children array for each row
                            const rows = table.querySelectorAll('tr');
                            rows.forEach(row => {
                                try {
                                    const cells = Array.from(row.children);
                                    if (!cells || cells.length <= 1) return;
                                    if (from < 0 || from >= cells.length) return;

                                    // normalize target index to be within bounds after removal
                                    const newCells = cells.slice();
                                    const [moved] = newCells.splice(from, 1);
                                    // if `to` is beyond bounds, append at end
                                    const insertIndex = Math.max(0, Math.min(to, newCells.length));
                                    newCells.splice(insertIndex, 0, moved);

                                    // only update DOM if order changed
                                    let changed = false;
                                    for (let i = 0; i < newCells.length; i++) {
                                        if (newCells[i] !== cells[i]) {
                                            changed = true;
                                            break;
                                        }
                                    }
                                    if (!changed) return;

                                    // detach and reappend in new order
                                    // Using DocumentFragment minimizes reflow
                                    const frag = document.createDocumentFragment();
                                    newCells.forEach(n => frag.appendChild(n));
                                    // clear row and append frag
                                    while (row.firstChild) row.removeChild(row.firstChild);
                                    row.appendChild(frag);
                                } catch (err) {
                                    console.warn('moveColumn row reorder error', err);
                                }
                            });

                            // If DataTable is active, destroy and re-init to align internal state
                            try {
                                // After moving DOM cells, update filter-wrapper data-col attributes to match new positions
                                const headerRow = table.querySelector('thead tr:first-child');
                                const filterRow = table.querySelector('thead tr.filter-row');
                                if (filterRow && headerRow) {
                                    const ths = Array.from(headerRow.children);
                                    ths.forEach((th, idx) => {
                                        const filterTh = filterRow.children[idx];
                                        if (filterTh) {
                                            const wrapper = filterTh.querySelector('.filter-wrapper');
                                            if (wrapper) {
                                                wrapper.setAttribute('data-col', String(idx));
                                                const btn = wrapper.querySelector(
                                                    '.filter-dropdown-trigger');
                                                if (btn) btn.setAttribute('data-col', String(idx));
                                            }
                                        }
                                    });
                                }

                                if ($.fn.DataTable.isDataTable('#filterTable')) {
                                    // destroy current instance and reinitialize after a tick
                                    $('#filterTable').DataTable().destroy();
                                    setTimeout(function() {
                                        try {
                                            initFilterTable();
                                        } catch (e) {
                                            console.warn('Re-init after move failed', e);
                                        }
                                    }, 50);
                                }
                            } catch (e) {
                                console.warn('Failed to reinit DataTable after column move', e);
                            }
                        }
                    }
                } catch (e) {
                    console.warn('Column dragging setup failed', e);
                }

                // Core initializer function that (re)initializes DataTable and builds filters
                function initFilterTable() {
                    try {
                        // Build a columns array from the first thead row only so DataTables gets the correct column count
                        const headerCells = document.querySelectorAll('#filterTable thead tr:first-child th');
                        const columns = Array.from(headerCells).map(() => ({}));

                        // Remove placeholder/no-data rows that use a single <td colspan="X"> cell
                        try {
                            const tbody = document.querySelector('#filterTable tbody');
                            if (tbody) {
                                const firstRow = tbody.querySelector('tr');
                                if (firstRow) {
                                    const cells = firstRow.querySelectorAll('td, th');
                                    if (cells.length === 1) {
                                        const colspan = parseInt(cells[0].getAttribute('colspan') || '1', 10);
                                        if (colspan === columns.length) {
                                            firstRow.remove();
                                            console.log(
                                                'Removed placeholder row with colspan before DataTable init');
                                        }
                                    }
                                }
                            }
                        } catch (remErr) {
                            console.warn('Error while removing placeholder row before DataTable init', remErr);
                        }

                        // Only initialize if not already initialized by a global script
                        if ($.fn.DataTable.isDataTable('#filterTable')) {
                            console.log('DataTable already initialized for #filterTable — skipping re-init');
                            return;
                        }

                        $('#filterTable').DataTable({
                            columns: columns,
                            order: [
                                [4, 'desc']
                            ],
                            pageLength: 25,
                            responsive: true,
                            searching: false,
                            columnDefs: [{
                                orderable: false,
                                targets: [5, 8]
                            }]
                        });

                        // Build simple per-column select filters from current table data
                        try {
                            const dt = $('#filterTable').DataTable();
                            const colCount = dt.columns().count();
                            for (let i = 0; i < colCount; i++) {
                                const wrapper = document.querySelector(
                                    '#filterTable thead .filter-wrapper[data-col="' + i + '"]');
                                if (!wrapper) continue;

                                // gather unique values for this column
                                const data = dt.column(i).data().toArray().map(v => (v || '').toString().trim())
                                    .filter(v => v !== '');
                                const uniq = Array.from(new Set(data)).sort();

                                // create a checkbox-dropdown filter (allows multiple selections)
                                wrapper.style.position = wrapper.style.position || 'relative';

                                const triggerBtn = document.createElement('button');
                                triggerBtn.type = 'button';
                                triggerBtn.className =
                                    'btn btn-sm btn-light filter-dropdown-trigger w-100 text-start';
                                triggerBtn.setAttribute('data-col', i);
                                triggerBtn.innerHTML =
                                    `<span class="filter-text">Filter</span> <span class="filter-count small text-muted ms-2"></span>`;

                                const menu = document.createElement('div');
                                menu.className = 'filter-dropdown-menu card p-2 shadow-sm';
                                Object.assign(menu.style, {
                                    position: 'absolute',
                                    top: 'calc(100% + 6px)',
                                    left: '0',
                                    zIndex: 2000,
                                    minWidth: '220px',
                                    maxHeight: '260px',
                                    overflow: 'auto',
                                    display: 'none'
                                });

                                // build checkbox list
                                uniq.forEach(val => {
                                    const id = 'f_' + i + '_' + Math.random().toString(36).slice(2, 9);
                                    const row = document.createElement('div');
                                    row.className = 'form-check';
                                    const inp = document.createElement('input');
                                    inp.className = 'form-check-input';
                                    inp.type = 'checkbox';
                                    inp.id = id;
                                    inp.value = val;
                                    // apply filter immediately when checkbox state changes (debounced backend fetch)
                                    inp.addEventListener('change', function() {
                                        const checksNow = Array.from(menu.querySelectorAll(
                                            'input[type="checkbox"]'));
                                        const vals = checksNow.filter(c => c.checked).map(c => c
                                            .value);
                                        const countNow = vals.length;
                                        const textElNow = triggerBtn.querySelector('.filter-text');
                                        if (textElNow) textElNow.textContent = countNow ?
                                            `Filter (${countNow})` : 'Filter';
                                        scheduleRealtimeFilter();
                                    });
                                    const lab = document.createElement('label');
                                    lab.className = 'form-check-label small';
                                    lab.htmlFor = id;
                                    lab.textContent = val.length > 80 ? val.substring(0, 80) + '...' : val;
                                    row.appendChild(inp);
                                    row.appendChild(lab);
                                    menu.appendChild(row);
                                });

                                // action buttons
                                const actions = document.createElement('div');
                                actions.className = 'd-flex justify-content-between mt-2';
                                const clearBtn = document.createElement('button');
                                clearBtn.type = 'button';
                                clearBtn.className = 'btn btn-sm btn-light';
                                clearBtn.textContent = 'Clear';
                                const applyBtn = document.createElement('button');
                                applyBtn.type = 'button';
                                applyBtn.className = 'btn btn-sm btn-primary';
                                applyBtn.textContent = 'Apply';
                                actions.appendChild(clearBtn);
                                actions.appendChild(applyBtn);
                                menu.appendChild(actions);

                                // wire behavior
                                triggerBtn.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                                });

                                // close on outside click
                                document.addEventListener('click', function docClick(e) {
                                    if (!menu.contains(e.target) && e.target !== triggerBtn) {
                                        menu.style.display = 'none';
                                    }
                                });

                                function escapeRegex(s) {
                                    return s.replace(/[.*+?^${}()|[\\]\\]/g, '\\$&');
                                }

                                applyBtn.addEventListener('click', function() {
                                    const checks = Array.from(menu.querySelectorAll(
                                        'input[type="checkbox"]'));
                                    const values = checks.filter(c => c.checked).map(c => c.value);
                                    if (!values.length) {
                                        dt.column(i).search('', false, false).draw();
                                    } else {
                                        const regex = values.map(v => escapeRegex(v)).join('|');
                                        dt.column(i).search(regex, true, false).draw();
                                    }
                                    // update trigger text
                                    const count = values.length;
                                    const textEl = triggerBtn.querySelector('.filter-text');
                                    const countEl = triggerBtn.querySelector('.filter-count');
                                    if (textEl) textEl.textContent = count ? `Filter (${count})` : 'Filter';
                                    if (countEl) countEl.textContent = '';
                                    menu.style.display = 'none';
                                });

                                clearBtn.addEventListener('click', function() {
                                    menu.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked =
                                        false);
                                    dt.column(i).search('', false, false).draw();
                                    const textEl = triggerBtn.querySelector('.filter-text');
                                    if (textEl) textEl.textContent = 'Filter';
                                    menu.style.display = 'none';
                                });

                                wrapper.innerHTML = '';
                                wrapper.appendChild(triggerBtn);
                                wrapper.appendChild(menu);
                            }
                        } catch (err) {
                            console.warn('Could not build column filters', err);
                        }
                    } catch (e) {
                        console.warn('DataTable init failed', e);
                    }
                }

                // Initial init
                initFilterTable();

                // Allow re-init after column move
                document.addEventListener('desklog:reinitTable', function() {
                    try {
                        initFilterTable();
                    } catch (e) {
                        console.warn('Reinit failed', e);
                    }
                });
            }

            // Initialize TomSelect for enhanced selects
            if (typeof TomSelect !== 'undefined') {
                document.querySelectorAll('select').forEach(function(sel) {
                    if (!sel.classList.contains('no-tom')) {
                        try {
                            new TomSelect(sel, {
                                hideSelected: true
                            });
                        } catch (e) {}
                    }
                });
            }

            // Load phone/text templates into the Phone Scripts select and wire insertion into description
            (function() {
                const sel = document.getElementById('phoneScriptSelectModal');
                const desc = document.getElementById('descriptionFieldModal');
                if (!sel) return;

                // Helper to replace merge tokens in the form @{{ key }} using provided data


                // Fetch templates list (DataTables endpoint) and populate select
                fetch('/templates/data?type=text', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json?.() || r.text())
                    .then(json => {
                        const list = (json && json.data) ? json.data : [];
                        list.forEach(t => {
                            const opt = document.createElement('option');
                            opt.value = t.id;
                            opt.text = t.name;
                            sel.appendChild(opt);
                        });

                        // Initialize TomSelect instance or update existing one
                        try {
                            if (typeof TomSelect !== 'undefined') {
                                if (!sel.tomselect) {
                                    new TomSelect(sel, {
                                        hideSelected: true,
                                        plugins: ['clear_button'],
                                        allow_empty_option: true
                                    });
                                } else {
                                    // add options to existing instance
                                    const ts = sel.tomselect;
                                    list.forEach(t => ts.addOption({
                                        value: t.id,
                                        text: t.name
                                    }));
                                }
                            }
                        } catch (e) {
                            console.warn('Phone script TomSelect init failed', e);
                        }
                    }).catch(err => {
                        console.warn('Could not load phone templates', err);
                    });

                // When a template is selected, fetch its body and insert into description
                sel.addEventListener('change', function() {
                    const id = this.value;
                    if (!id) return;

                    fetch(`/templates/${id}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.json?.() || r.text())
                        .then(data => {
                            // TemplateController@show returns JSON with 'body' when requested via AJAX
                            const body = (data && data.body) ? data.body : (data && data.html) ?
                                data.html : '';

                            // Build merge-data from globals if available
                            const mergeData = {};
                            try {
                                if (window.selectedCustomer) {
                                    const c = window.selectedCustomer || {};
                                    mergeData.first_name = c.first_name || c.name?.split(' ')[0] ||
                                        c.name || '';
                                    mergeData.last_name = c.last_name || (c.name ? c.name.split(' ')
                                        .slice(1).join(' ') : '') || '';
                                    mergeData.email = c.email || '';
                                    mergeData.cell_phone = c.phone || c.cell || c.cell_phone || '';
                                }
                                if (window.selectedDeal) {
                                    mergeData.deal_number = window.selectedDeal.dealNumber || window
                                        .selectedDeal.id || '';
                                }
                            } catch (e) {
                                console.warn('Failed to build merge data', e);
                            }

                            const final = replaceMergeTokens(body, mergeData);

                            if (desc) {
                                // Trim to 140 chars if necessary to fit UI constraint
                                const trimmed = final.length > 140 ? final.substring(0, 140) :
                                    final;
                                desc.value = trimmed;
                                // update counter if present
                                const counter = document.getElementById('charCountModal');
                                if (counter) counter.textContent = String(desc.value.length);
                            }
                        }).catch(err => {
                            console.warn('Failed to load template preview', err);
                        });
                });
            })();

            // Date preset click handlers (ensure present)
            document.querySelectorAll('.preset-item').forEach(function(el) {
                el.addEventListener('click', function() {
                    if (this.dataset.url) window.location.href = this.dataset.url;
                });
            });

            // Real-time backend filter: collect filter form + column checkbox filters, fetch updated table HTML, replace tbody
            (function() {
                let realtimeTimer = null;
                const debounceMs = 300;
                const filterForm = document.getElementById('filterForm');

                function getColumnFilters() {
                    const map = {};
                    document.querySelectorAll('#filterTable thead .filter-wrapper[data-col]').forEach(function(
                        w) {
                        const col = w.getAttribute('data-col');
                        const vals = Array.from(w.querySelectorAll('input[type="checkbox"]')).filter(
                            c => c.checked).map(c => c.value);
                        if (vals.length) map[col] = vals;
                    });
                    return map;
                }

                function buildParams() {
                    const params = new URLSearchParams();
                    if (filterForm) {
                        new FormData(filterForm).forEach((v, k) => {
                            if (v !== null && v !== undefined) params.append(k, v);
                        });
                    }
                    const colFilters = getColumnFilters();
                    Object.keys(colFilters).forEach(col => {
                        params.append('col_filters[' + col + ']', colFilters[col].join('|'));
                    });
                    return params;
                }

                function applyColumnFiltersClientSide(dt) {
                    try {
                        const colFilters = getColumnFilters();
                        let applied = false;
                        Object.keys(colFilters).forEach(col => {
                            const i = parseInt(col, 10);
                            if (isNaN(i)) return;
                            const vals = colFilters[col];
                            if (!vals || !vals.length) {
                                dt.column(i).search('', false, false);
                            } else {
                                const regex = vals.map(v => escapeRegex(v)).join('|');
                                dt.column(i).search(regex, true, false);
                                applied = true;
                            }
                        });
                        if (applied) dt.draw();
                    } catch (e) {
                        console.warn('Client-side column apply failed', e);
                    }
                }

                function fetchAndReplace() {
                    try {
                        const params = buildParams();
                        const base = (filterForm && filterForm.getAttribute('action')) ? filterForm
                            .getAttribute('action') : window.location.pathname;
                        const url = base + (params.toString() ? ('?' + params.toString()) : '');
                        fetch(url, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(r => r.text())
                            .then(html => {
                                try {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newTbody = doc.querySelector('#filterTable tbody');
                                    const curTbody = document.querySelector('#filterTable tbody');
                                    if (newTbody && curTbody) {
                                        curTbody.innerHTML = newTbody.innerHTML;
                                    } else {
                                        // fallback: replace whole table container
                                        const newTableWrap = doc.querySelector('.table-responsive');
                                        const curWrap = document.querySelector('.table-responsive');
                                        if (newTableWrap && curWrap) curWrap.innerHTML = newTableWrap
                                            .innerHTML;
                                    }

                                    // Re-init DataTable and filters
                                    document.dispatchEvent(new Event('desklog:reinitTable'));

                                    // After DataTable init, apply any column checkbox filters client-side
                                    setTimeout(function() {
                                        try {
                                            if (typeof $ !== 'undefined' && $.fn && $.fn
                                                .DataTable && $.fn.DataTable.isDataTable(
                                                    '#filterTable')) {
                                                const dt = $('#filterTable').DataTable();
                                                applyColumnFiltersClientSide(dt);
                                            }
                                        } catch (e) {
                                            console.warn(
                                                'Applying column filters after replace failed',
                                                e);
                                        }
                                    }, 120);
                                } catch (err) {
                                    console.warn('Parse/replace table failed', err);
                                }
                            }).catch(err => {
                                console.warn('Realtime filter fetch failed', err);
                            });
                    } catch (e) {
                        console.warn('fetchAndReplace error', e);
                    }
                }

                function scheduleRealtimeFilter() {
                    if (realtimeTimer) clearTimeout(realtimeTimer);
                    realtimeTimer = setTimeout(fetchAndReplace, debounceMs);
                }

                // Wire main filter form inputs to trigger realtime fetch
                if (filterForm) {
                    filterForm.querySelectorAll('input, select').forEach(function(el) {
                        el.addEventListener('change', scheduleRealtimeFilter);
                        el.addEventListener('input', scheduleRealtimeFilter);
                    });
                }

                // Expose for other handlers (e.g., checkbox change)
                window.scheduleRealtimeFilter = scheduleRealtimeFilter;
            })();

            // Reset Filters button: clear all table column filters and form inputs
            (function() {
                const resetBtn = document.getElementById('resetFiltersBtn');
                if (!resetBtn) return;
                resetBtn.addEventListener('click', function() {
                    try {
                        // Clear DataTable column filters
                        if (typeof $ !== 'undefined' && $.fn && $.fn.DataTable && $.fn.DataTable
                            .isDataTable('#filterTable')) {
                            const dt = $('#filterTable').DataTable();
                            const colCount = dt.columns().count();
                            for (let c = 0; c < colCount; c++) dt.column(c).search('', false, false);
                            dt.draw();
                        }

                        // Clear UI checkbox filters and trigger text
                        document.querySelectorAll('#filterTable thead .filter-wrapper').forEach(
                            function(w) {
                                w.querySelectorAll('input[type="checkbox"]').forEach(function(ch) {
                                    ch.checked = false;
                                });
                                const textEl = w.querySelector('.filter-text');
                                if (textEl) textEl.textContent = 'Filter';
                            });

                        // Reset main filter form inputs
                        const filterForm = document.getElementById('filterForm');
                        if (filterForm) {
                            filterForm.reset();
                            // clear TomSelect instances inside the filter form if present
                            filterForm.querySelectorAll('select').forEach(function(s) {
                                if (s.tomselect) try {
                                    s.tomselect.clear(true);
                                } catch (e) {}
                            });
                        }
                    } catch (err) {
                        console.warn('Reset filters failed', err);
                    }
                });
            })();
        });
    </script>

    <!-- Include optional CDN scripts used by desklog.html if not already included globally -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  {{-- SHowroom Visit Logics --}}
  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const intervals = new Map();
            const pendingStarts = new Set();

            function prefillOffcanvasFromRow(tr) {
                if (!tr) return;
                const dealId = tr.dataset.dealId || '';
                const customerName = tr.dataset.customerName || '';
                const email = tr.dataset.customerEmail || '';
                const home = tr.dataset.customerHome || '';
                const work = tr.dataset.customerWork || '';
                const cell = tr.dataset.customerCell || '';
                const vehicle = tr.dataset.vehicle || '';
                const salespersonId = tr.dataset.salespersonId || '';
                const salesmanagerId = tr.dataset.salesmanagerId || '';

                const custLink = document.getElementById('showroom_customer_link');
                const custEmail = document.getElementById('showroom_customer_email');
                const custHome = document.getElementById('showroom_customer_home');
                const custWork = document.getElementById('showroom_customer_work');
                const custCell = document.getElementById('showroom_customer_cell');
                const vehicleLink = document.getElementById('showroom_vehicle_link');
                const noteDealId = document.getElementById('showroom_note_deal_id');
                const assignedTo = document.getElementById('showroom_assigned_to');
                const assignedManager = document.getElementById('showroom_assigned_manager');

                if (custLink) custLink.textContent = customerName || '—';
                if (custEmail) custEmail.textContent = email || '—';
                if (custHome) custHome.textContent = home || '—';
                if (custWork) custWork.textContent = work || '—';
                if (custCell) custCell.textContent = cell || '—';
                if (vehicleLink) vehicleLink.textContent = vehicle || '(none)';
                if (noteDealId) noteDealId.value = dealId;
                if (assignedTo && salespersonId) assignedTo.value = salespersonId;
                if (assignedManager && salesmanagerId) assignedManager.value = salesmanagerId;

                // populate visit id and flags if available
                try {
                    const showroomActions = document.getElementById(`showroom-actions-${dealId}`);
                    if (showroomActions) {
                        const visitId = showroomActions.getAttribute('data-visit-id');
                        const flagsJson = showroomActions.getAttribute('data-visit-flags');
                        if (visitId) {
                            const visitInput = document.getElementById('showroom_visit_id');
                            if (visitInput) visitInput.value = visitId;
                        }
                        if (flagsJson) {
                            try {
                                const flagsObj = JSON.parse(flagsJson);
                                Object.keys(flagsObj || {}).forEach(k => {
                                    const inputs = document.querySelectorAll(`[name="flags[${k}]"]`);
                                    if (!inputs || inputs.length === 0) return;
                                    if (inputs[0].type === 'radio') {
                                        const yes = Array.from(inputs).find(i => i.value === '1' || i
                                            .value === 'Yes');
                                        const no = Array.from(inputs).find(i => i.value === '0' || i
                                            .value === 'No');
                                        if ((flagsObj[k] === true || flagsObj[k] === 1 || flagsObj[k] ===
                                                '1' || flagsObj[k] === 'Yes') && yes) {
                                            yes.checked = true;
                                        } else if (no) {
                                            no.checked = true;
                                        }
                                    } else if (inputs[0].type === 'checkbox') {
                                        inputs[0].checked = !!flagsObj[k];
                                    }
                                });
                            } catch (e) {
                                console.debug('parse visit flags failed', e);
                            }
                        }
                    }
                } catch (e) {
                    console.debug('prefill flags failed', e);
                }
            }

            function startTimerForDeal(dealId) {
                if (!dealId) return;
                if (intervals.has(dealId)) return;

                const timerEl = document.getElementById(`visitTimer-${dealId}`);
                if (!timerEl) return;

                const start = Date.now();
                const iv = setInterval(() => {
                    const diff = Date.now() - start;
                    timerEl.textContent = formatDuration(diff);
                }, 1000);

                intervals.set(dealId, {
                    iv,
                    start
                });
            }

            function stopTimerForDeal(dealId) {
                const rec = intervals.get(dealId);
                if (!rec) return 0;

                clearInterval(rec.iv);
                intervals.delete(dealId);

                const elapsed = Date.now() - rec.start;
                const timerEl = document.getElementById(`visitTimer-${dealId}`);
                if (timerEl) timerEl.textContent = formatDuration(elapsed);

                return elapsed;
            }

            function formatDuration(ms) {
                const totalSeconds = Math.floor(ms / 1000);
                const hrs = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                const mins = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                const secs = String(totalSeconds % 60).padStart(2, '0');
                return `${hrs}hrs ${mins}mins ${secs}seconds`;
            }

            // **CORRECTED: "Open Showroom Visit" button handler**
            document.querySelectorAll('.open-showroom-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dealId = this.dataset.dealId;

                    if (pendingStarts.has(dealId)) return;
                    pendingStarts.add(dealId);

                    this.disabled = true;
                    const tr = this.closest('tr');
                    const customerId = tr?.dataset?.customerId || '';

                    // Call API to create visit first
                    const startUrl = '/api/visits/start';
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

                    fetch(startUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: new URLSearchParams({
                                customer_id: customerId,
                                deal_id: dealId
                            }),
                            credentials: 'same-origin'
                        })
                        .then(r => r.json?.() || r.text())
                        .then(res => {
                            // Update UI to show active visit
                            const openRow = document.getElementById(`openVisitRow-${dealId}`);
                            const activeRow = document.getElementById(
                                `activeVisitRow-${dealId}`);

                            if (openRow) openRow.classList.add('d-none');
                            if (activeRow) {
                                activeRow.classList.remove('d-none');
                                // Add active visit badge and end button
                                activeRow.innerHTML = `
                        <span class="badge bg-success">Open Showroom Visit</span>
                        <button class="btn btn-danger btn-sm end-showroom-btn ms-2" 
                                data-deal-id="${dealId}">
                            End Showroom Visit
                        </button>
                        <span id="visitTimer-${dealId}" class="fw-semibold text-muted ms-2">
                            00hrs 00mins 00seconds
                        </span>
                    `;

                                // Re-bind the end button
                                const endBtn = activeRow.querySelector('.end-showroom-btn');
                                if (endBtn) {
                                    endBtn.addEventListener('click', handleEndVisit);
                                }
                            }

                            // Store visit ID for later use
                            const data = res.data || res;
                            const visitId = data.id || data.visit_id || data.visit?.id;
                            const showroomActions = document.getElementById(
                                `showroom-actions-${dealId}`);
                            if (showroomActions && visitId) {
                                showroomActions.setAttribute('data-visit-id', visitId);
                            }

                            // Start client timer
                            startTimerForDeal(dealId);

                            // Show success message
                            showAlert('Showroom visit started successfully', 'success');

                        })
                        .catch(err => {
                            console.error('Failed to start visit', err);
                            showAlert('Failed to start showroom visit', 'danger');
                            this.disabled = false;
                        })
                        .finally(() => {
                            pendingStarts.delete(dealId);
                        });
                });
            });

            // **NEW: Handle "End Showroom Visit" button**
            function handleEndVisit(e) {
                e.preventDefault();
                const dealId = this.dataset.dealId;
                const tr = document.querySelector(`tr[data-deal-id="${dealId}"]`);

                if (tr) {
                    prefillOffcanvasFromRow(tr);

                    // Open the offcanvas to show options
                    const offcanvasEl = document.getElementById('editShowroomVisitCanvas');
                    if (offcanvasEl) {
                        const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
                        offcanvas.show();

                        // Update the save button to handle ending the visit
                        const saveBtn = document.getElementById('saveShowroomVisit');
                        if (saveBtn) {
                            saveBtn.onclick = function() {
                                saveEndShowroomVisit(dealId);
                            };
                        }
                    }
                }
            }

            // **NEW: Save function for ending showroom visit**
            function saveEndShowroomVisit(dealId) {
                const addNote = document.getElementById('showroom_add_note')?.checked;
                const noteText = document.getElementById('showroom_note_text')?.value || '';
                const visitId = document.getElementById('showroom_visit_id')?.value || '';

                if (!visitId) {
                    alert('No active visit found');
                    return;
                }

                // Stop timer and get elapsed time
                const elapsedMs = stopTimerForDeal(dealId);
                const elapsedText = formatDuration(elapsedMs);
                const elapsedMinutes = Math.round(elapsedMs / 60000);

                // Build final note
                let finalNote = noteText.trim();
                if (finalNote) finalNote += '\n\n';
                finalNote +=
                    `Showroom visit duration: ${elapsedText} (${elapsedMinutes} minute${elapsedMinutes !== 1 ? 's' : ''}).`;

                // Prepare form data
                const formData = new FormData();
                if (addNote && noteText.trim()) formData.append('notes', noteText.trim());

                // Collect flags
                const offcanvasEl = document.getElementById('editShowroomVisitCanvas');
                if (offcanvasEl) {
                    const inputs = offcanvasEl.querySelectorAll('[name^="flags"]');
                    inputs.forEach((el) => {
                        const name = el.getAttribute('name') || '';
                        const m = name.match(/^flags\[(.+)\]$/);
                        if (!m) return;
                        const key = m[1];
                        let val = '0';

                        if (el.type === 'radio') {
                            const grp = offcanvasEl.querySelectorAll(`[name="flags[${key}]"]`);
                            for (const r of grp) {
                                if (r.checked) {
                                    val = r.value;
                                    break;
                                }
                            }
                        } else if (el.type === 'checkbox') {
                            val = el.checked ? '1' : '0';
                        }
                        formData.append(`flags[${key}]`, val);
                    });
                }

                // Call API to end visit
                const stopUrl = `/api/visits/${visitId}/stop`;
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

                fetch(stopUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData,
                        credentials: 'same-origin'
                    })
                    .then(r => r.json?.() || r.text())
                    .then(res => {
                        // Close offcanvas
                        const offcanvasEl = document.getElementById('editShowroomVisitCanvas');
                        if (offcanvasEl) {
                            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                            if (offcanvas) offcanvas.hide();
                        }

                        // Update UI to show completed visit
                        const openRow = document.getElementById(`openVisitRow-${dealId}`);
                        const activeRow = document.getElementById(`activeVisitRow-${dealId}`);

                        if (activeRow) {
                            activeRow.classList.add('d-none');
                        }

                        // Show completed visit summary
                        const showroomActions = document.getElementById(`showroom-actions-${dealId}`);
                        if (showroomActions) {
                            // This would be better handled by refreshing the row via AJAX
                            // For now, show success message
                            showAlert(`Showroom visit ended. Duration: ${elapsedText}`, 'success');

                            // Optionally refresh the table row
                            if (window.scheduleRealtimeFilter) {
                                window.scheduleRealtimeFilter();
                            }
                        }
                    })
                    .catch(err => {
                        console.error('Failed to end visit', err);
                        showAlert('Failed to save visit', 'danger');
                    });
            }

            // Helper function to show alerts
            function showAlert(message, type = 'info') {
                const alertBox = document.getElementById('alert-box-container');
                if (alertBox) {
                    const alertEl = document.createElement('div');
                    alertEl.className = `alert alert-${type} alert-dismissible fade show mt-2`;
                    alertEl.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
                    alertBox.appendChild(alertEl);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (alertEl.parentNode) {
                            alertEl.remove();
                        }
                    }, 5000);
                }
            }

            // Initialize event listeners for existing end buttons
            document.querySelectorAll('.end-showroom-btn').forEach(btn => {
                btn.addEventListener('click', handleEndVisit);
            });

            // Start timers for server-rendered active visits
            document.querySelectorAll('[id^="activeVisitRow-"][data-start-ts]').forEach(function(el) {
                const id = (el.id || '').replace('activeVisitRow-', '');
                if (id && el.querySelector('.end-showroom-btn')) {
                    startTimerForDeal(id);
                }
            });
        });
    </script>
    <script>
        // Start timers for server-rendered active visits (if any)
        (function() {
            function startServerActiveTimers() {
                try {
                    document.querySelectorAll('[id^="activeVisitRow-"][data-start-ts]').forEach(function(el) {
                        try {
                            const id = (el.id || '').replace('activeVisitRow-', '');
                            if (!id) return;
                            if (typeof startTimerForDeal === 'function') startTimerForDeal(id);
                        } catch (e) {
                            console.debug('startServerActiveTimers inner error', e);
                        }
                    });
                } catch (e) {
                    console.debug('startServerActiveTimers error', e);
                }
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded',
                startServerActiveTimers);
            else startServerActiveTimers();
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX submit for per-deal add-note forms so notes appear in real-time
            document.querySelectorAll('input[name="deal_id"]').forEach(function(hidden) {
                const form = hidden.closest('form');
                if (!form) return;
                // prevent double-binding
                if (form.dataset.ajaxBound) return;
                form.dataset.ajaxBound = '1';

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) submitBtn.disabled = true;

                    const fd = new FormData(form);
                    const url = form.getAttribute('action');
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: fd,
                        credentials: 'same-origin'
                    }).then(function(res) {
                        // try parse json
                        return res.json ? res.json() : res.text();
                    }).then(function(json) {
                        if (!json || json.status !== 'success') {
                            alert('Failed to add note');
                            return;
                        }

                        const note = json.data;
                        // update modal history (prepend)
                        const modal = form.closest('.modal');
                        const history = modal?.querySelector('.note-history');
                        const createdAt = note.created_at ? new Date(note.created_at)
                            .toLocaleString() : new Date().toLocaleString();
                        const author = note.created_by ? (note.createdBy?.name || 'You') : (
                            note.createdBy?.name || 'You');
                        const noteHtml =
                            `<div class="note-entry mb-3 p-2 bg-light rounded">${note.description}<div class="small text-muted mt-1">${author} • ${createdAt}</div></div>`;
                        if (history) history.insertAdjacentHTML('afterbegin', noteHtml);

                        // clear textarea
                        const ta = form.querySelector('textarea[name="note"]');
                        if (ta) ta.value = '';

                        // update table preview for this deal
                        const dealId = hidden.value;
                        const row = document.querySelector(`tr[data-deal-id="${dealId}"]`);
                        if (row) {
                            const noteArea = row.querySelector('.note-area');
                            const preview = note.description.length > 80 ? note.description
                                .substring(0, 80) + '...' : note.description;
                            if (noteArea) {
                                noteArea.innerHTML =
                                    `${preview} <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal${dealId}"><i class="ti ti-edit"></i></a>`;
                            }
                        }

                        // re-enable button and show success toast briefly
                        if (submitBtn) submitBtn.disabled = false;
                    }).catch(function(err) {
                        console.error('Note save failed', err);
                        alert('Failed to add note');
                        if (submitBtn) submitBtn.disabled = false;
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                if (window.rebindCustomerHover) window.rebindCustomerHover();
            } catch (e) {}
        });
    </script>
    <style>
        /* Minimal hover styles copied from customers index for desk log */
        .custom-hover-container.name-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: visible;
            position: relative;
        }

        .custom-hover-box {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            background: #fff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            padding: 8px;
            z-index: 3000;
            width: 320px;
        }

        #customerHoverPopup {
            position: absolute;
            display: block;
            pointer-events: auto;
        }

        #customerHoverPopup.show {
            display: block;
        }
    </style>

    <script>
        // Attach hover handlers (copied from customers script)
        (function() {
            function attachHoverHandlers() {
                document.querySelectorAll('#filterTable .name-cell, .custom-hover-container.name-cell').forEach(el => {
                    const hover = el.querySelector('.custom-hover-box');
                    if (!hover) return;

                    let hideTimer = null;

                    const show = () => {
                        if (hideTimer) {
                            clearTimeout(hideTimer);
                            hideTimer = null;
                        }
                        hover.style.display = 'block';
                        hover.style.zIndex = 3000;
                    };
                    const hide = () => {
                        if (hideTimer) clearTimeout(hideTimer);
                        hideTimer = setTimeout(() => {
                            hover.style.display = 'none';
                        }, 80);
                    };

                    // avoid duplicate bindings
                    if (el.dataset.primusHoverBound) return;
                    el.dataset.primusHoverBound = '1';

                    el.addEventListener('mouseenter', show);
                    el.addEventListener('mouseleave', hide);
                    hover.addEventListener('mouseenter', show);
                    hover.addEventListener('mouseleave', hide);
                });
            }

            document.addEventListener('DOMContentLoaded', attachHoverHandlers);
            window.rebindCustomerHover = attachHoverHandlers;
        })();

        (function() {
            let popup = null;

            function createPopup() {
                if (!popup) {
                    popup = document.createElement('div');
                    popup.id = 'customerHoverPopup';
                    popup.style.position = 'absolute';
                    popup.style.display = 'none';
                    document.body.appendChild(popup);
                }
            }

            function showPopupFromCell(cell) {
                if (!cell) return;
                createPopup();
                const hover = cell.querySelector('.custom-hover-box');
                if (!hover) return;
                popup.innerHTML = hover.innerHTML;

                const rect = cell.getBoundingClientRect();
                const scrollY = window.scrollY || window.pageYOffset;
                const scrollX = window.scrollX || window.pageXOffset;

                let left = rect.left + scrollX;
                let top = rect.bottom + scrollY + 5;

                popup.style.left = left + 'px';
                popup.style.top = top + 'px';
                popup.classList.add('show');
                popup.style.display = 'block';
            }

            function hidePopup() {
                if (popup) {
                    popup.classList.remove('show');
                    popup.style.display = 'none';
                }
            }

            let hoverTarget = null;
            document.addEventListener('mouseover', function(e) {
                const cell = e.target.closest('.name-cell');
                if (cell && cell.querySelector('.custom-hover-box')) {
                    hoverTarget = cell;
                    showPopupFromCell(cell);
                }
            });

            document.addEventListener('mouseout', function(e) {
                const related = e.relatedTarget;
                if (!related) {
                    hidePopup();
                    hoverTarget = null;
                    return;
                }
                if (hoverTarget && (related === hoverTarget || hoverTarget.contains(related))) return;
                if (popup && (related === popup || popup.contains(related))) return;
                hidePopup();
                hoverTarget = null;
            });

            window.addEventListener('scroll', hidePopup);
            window.addEventListener('resize', hidePopup);
        })();
    </script>
@endpush
