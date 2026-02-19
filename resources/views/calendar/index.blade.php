@extends('layouts.app')

@section('title', 'Calendar')

@section('content')
    <div class="content content-two pt-2">

        @php
            $statusColors = [
                'Open' => '#0d6efd',
                'Confirmed' => '#198754',
                'Completed' => '#6c757d',
                'Missed' => '#dc3545',
                'Cancelled' => '#6c757d',
                'Walk-In' => '#6f42c1',
                'No Response' => '#fd7e14',
                'No Show' => '#b02a37',
                'Left VM' => '#ffc107',
            ];
        @endphp

        <!-- Start Breadcrumb -->
        <div class="mb-3 position-relative d-flex align-items-center justify-content-between flex-wrap gap-2"
            style="min-height: 80px;">
            <div>
                <h4 class="mb-1 fw-bold">Calendar</h4>
            </div>

            <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap table-header">
                <div class="mb-2 me-2">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#customcanvas"
                        class="btn btn-lg py-1 h-auto btn-light border-1 border d-flex align-items-center">
                        <i class="ti ti-filter me-2"></i>Filter
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Navigation -->
                <div class="custom-nav-container">
                    <a href="{{ route('calendar.index', array_merge(request()->query(), ['date' => $prevDate])) }}"
                        class="nav-btn-custom">←</a>
                    <h5 class="dateDisplay">{{ $dateDisplay }}</h5>
                    <a href="{{ route('calendar.index', array_merge(request()->query(), ['date' => $nextDate])) }}"
                        class="nav-btn-custom">→</a>
                </div>

                <!-- View Toggle -->
                <div class="d-flex justify-content-end mb-2">
                    <div class="btn-group">
                        <a href="{{ route('calendar.index', array_merge(request()->query(), ['view' => 'month', 'date' => $currentDate])) }}"
                            class="fc-button {{ $view === 'month' ? 'active' : '' }}">Month</a>

                        <a href="{{ route('calendar.index', array_merge(request()->query(), ['view' => 'week', 'date' => $currentDate])) }}"
                            class="fc-button {{ $view === 'week' ? 'active' : '' }}">Week</a>

                        <a href="{{ route('calendar.index', array_merge(request()->query(), ['view' => 'day', 'date' => $currentDate])) }}"
                            class="fc-button {{ $view === 'day' ? 'active' : '' }}">Day</a>
                    </div>

                </div>

                <!-- Calendar Grid -->
                <div id="serverCalendarWrapper" class="card mb-0">
                    <div class="card-body p-0">
                        @if ($view === 'month')
                            {{-- Month View --}}
                            <table class="table table-bordered mb-0 calendar-table">
                                <thead>
                                    <tr>
                                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                            <th class="text-center bg-light py-2">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calendarWeeks as $week)
                                        <tr>
                                            @foreach ($week as $day)
                                                <td class="calendar-cell {{ $day['isCurrentMonth'] ? '' : 'text-muted bg-light' }} {{ $day['isToday'] ? 'bg-primary-light' : '' }}"
                                                    style="vertical-align: top; height: 120px; width: 14.28%;">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center px-2 py-1">
                                                        <span
                                                            class="fw-bold {{ $day['isToday'] ? 'text-primary' : '' }}">{{ $day['day'] }}</span>
                                                        @if (count($day['tasks']) > 0)
                                                            <span
                                                                class="badge bg-secondary">{{ count($day['tasks']) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="calendar-events px-1"
                                                        style="max-height: 80px; overflow-y: auto;">
                                                        @foreach ($day['tasks']->take(3) as $task)
                                                            @php
                                                                $bg = '#6c757d';
                                                                foreach ($statusColors as $sk => $sc) {
                                                                    if (
                                                                        is_string($task->status_type) &&
                                                                        strcasecmp(
                                                                            trim($sk),
                                                                            trim($task->status_type),
                                                                        ) === 0
                                                                    ) {
                                                                        $bg = $sc;
                                                                        break;
                                                                    }
                                                                }
                                                            @endphp
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#taskModal{{ $task->id }}"
                                                                class="d-block text-truncate small p-1 mb-1 rounded task-event task-{{ $task->task_type_class }}"
                                                                style="background-color: {{ $bg }}; border-color: {{ $bg }}; color: #ffffff;">
                                                                {{ $task->due_time }} -
                                                                {{ $task->customer->first_name ?? 'Unknown' }}
                                                            </a>
                                                        @endforeach
                                                        @if (count($day['tasks']) > 3)
                                                            <a href="{{ route('calendar.index', ['view' => 'day', 'date' => $day['date']]) }}"
                                                                class="small text-muted">+{{ count($day['tasks']) - 3 }}
                                                                more</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif($view === 'week')
                            {{-- Week View --}}
                            <table class="table table-bordered mb-0 calendar-table">
                                <thead>
                                    <tr>
                                        @foreach ($weekDays as $day)
                                            <th class="text-center bg-light py-2 {{ $day['isToday'] ? 'bg-primary text-white' : '' }}"
                                                style="width: 14.28%;">
                                                <a href=""> {{ $day['dayName'] }} {{ $day['dayNum'] }} </a>

                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($weekDays as $day)
                                            <td class="calendar-cell" style="vertical-align: top; height: 400px;">
                                                <div class="calendar-events p-1"
                                                    style="max-height: 380px; overflow-y: auto;">
                                                    @forelse($day['tasks'] as $task)
                                                        @php
                                                            $bg = '#6c757d';
                                                            foreach ($statusColors as $sk => $sc) {
                                                                if (
                                                                    is_string($task->status_type) &&
                                                                    strcasecmp(trim($sk), trim($task->status_type)) ===
                                                                        0
                                                                ) {
                                                                    $bg = $sc;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#taskModal{{ $task->id }}"
                                                            class="event task-{{ $task->task_type_class }}"
                                                            style="background-color: {{ $bg }}; border-color: {{ $bg }}; color: #ffffff;"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ $task->due_time }} - {{ $task->task_type }} - {{ $task->customer->first_name ?? 'Unknown' }} {{ $task->customer->last_name ?? '' }}">
                                                            {{ $task->due_time }} - {{ $task->task_type }} -
                                                            {{ $task->customer->first_name ?? 'Unknown' }}
                                                            {{ $task->customer->last_name ?? '' }}
                                                        </a>


                                                    @empty
                                                        {{-- <span class="text-muted small">No tasks</span> --}}
                                                    @endforelse
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            {{-- Day View --}}
                            <div class="p-3">
                                <h5 class="mb-3">{{ \Carbon\Carbon::parse($currentDate)->format('l, F j, Y') }}</h5>
                                @forelse($dayTasks as $task)
                                    @php
                                        $bg = '#6c757d';
                                        foreach ($statusColors as $sk => $sc) {
                                            if (
                                                is_string($task->status_type) &&
                                                strcasecmp(trim($sk), trim($task->status_type)) === 0
                                            ) {
                                                $bg = $sc;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}"
                                        class="d-block p-3 mb-2 rounded task-event task-{{ $task->task_type_class }}"
                                        style="text-decoration: none; background-color: {{ $bg }}; border-color: {{ $bg }}; color: #ffffff;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $task->due_time }} - {{ $task->task_type }}</strong><br>
                                                <span>{{ $task->customer->first_name ?? 'Unknown' }}
                                                    {{ $task->customer->last_name ?? '' }}</span><br>
                                                <small>{{ $task->description }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-light text-dark">{{ $task->status_type }}</span><br>
                                                <small>{{ $task->assignedUser->name ?? 'Unassigned' }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center text-muted py-5">
                                        <i class="ti ti-calendar-off" style="font-size: 48px;"></i>
                                        <p class="mt-2">No tasks scheduled for this day</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Filter Offcanvas -->
<div class="offcanvas offcanvas-end filter-canvas" tabindex="-1" id="customcanvas">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <form action="{{ route('calendar.index') }}" method="GET">

        <input type="hidden" name="view" value="{{ $view }}">
        <input type="hidden" name="date" value="{{ $currentDate }}">

        {{-- Scroll Body --}}
        <div class="offcanvas-body filter-scroll">


            {{-- 1 Lead Status --}}
            <div class="mb-3">
                <label class="form-label">Lead Status</label>
                <select name="lead_status[]" class="form-select tom-multi" multiple>
                    @foreach (['active','duplicate','invalid','lost','sold','wishlist','buy-in'] as $s)
                        <option value="{{ $s }}" {{ in_array($s,(array)request('lead_status',[]))?'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2 Lead Type --}}
            <div class="mb-3">
                <label class="form-label">Lead Type</label>
                <select name="lead_type[]" class="form-select tom-multi" multiple>
                    @foreach (['internet','walk-in','phoneup','textup','websitechat','service','import','wholesale'] as $t)
                        <option value="{{ $t }}" {{ in_array($t,(array)request('lead_type',[]))?'selected':'' }}>
                            {{ ucfirst($t) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3 Inventory Type --}}
            <div class="mb-3">
                <label class="form-label">Inventory Type</label>
                <select name="inventory_type[]" class="form-select tom-multi" multiple>
                    @foreach (['new','pre-owned','cpo','demo','wholesale','leaserenewal','unknown'] as $t)
                        <option value="{{ $t }}" {{ in_array($t,(array)request('inventory_type',[]))?'selected':'' }}>
                            {{ ucfirst($t) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 4 Sales Status --}}
            <div class="mb-3">
                <label class="form-label">Sales Status</label>
                <select name="sales_status[]" class="form-select tom-multi" multiple>
                    @foreach (['uncontacted','attempted','contacted','dealervisit','demo','write-up','pendingf&i','sold','lost','delivered'] as $t)
                        <option value="{{ $t }}" {{ in_array($t,(array)request('sales_status',[]))?'selected':'' }}>
                            {{ ucfirst($t) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 5 Status Type --}}
            <div class="mb-3">
                <label class="form-label">Status Type</label>
                <select name="status_type[]" class="form-select tom-multi" multiple>
                    @foreach (['Open','Completed','Missed','Cancelled','No Response','No Show'] as $status)
                        <option value="{{ $status }}" {{ in_array($status,(array)request('status_type',[]))?'selected':'' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 6 Task Type --}}
            <div class="mb-3">
                <label class="form-label">Task Type</label>
                <select name="task_type[]" class="form-select tom-multi" multiple>
                    @foreach (['Inbound Call','Outbound Call','Inbound Text','Outbound Text','Inbound Email','Outbound Email','Appointment','Other'] as $type)
                        <option value="{{ $type }}" {{ in_array($type,(array)request('task_type',[]))?'selected':'' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 7 Assigned To --}}
            <div class="mb-3">
                <label class="form-label">Assigned To</label>
                <select name="assigned_to[]" class="form-select tom-multi" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id,(array)request('assigned_to',[]))?'selected':'' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 8 Assigned By --}}
            <div class="mb-3">
                <label class="form-label">Assigned By</label>
                <select name="assigned_by[]" class="form-select tom-multi" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id,(array)request('assigned_by',[]))?'selected':'' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 9 Created By --}}
            <div class="mb-3">
                <label class="form-label">Created By</label>
                <select name="created_by[]" class="form-select tom-multi" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id,(array)request('created_by',[]))?'selected':'' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 10 Priority --}}
            <div class="mb-3">
                <label class="form-label">Priority</label>
                <select name="priority[]" class="form-select tom-multi" multiple>
                    @foreach (['Low','Normal','High','Urgent'] as $priority)
                        <option value="{{ $priority }}" {{ in_array($priority,(array)request('priority',[]))?'selected':'' }}>
                            {{ $priority }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 11 Automated --}}
            <div class="mb-3">
                <label class="form-label">Automated</label>
                <select name="automated[]" class="form-select tom-multi" multiple>
                    <option value="0" {{ in_array('0',(array)request('automated',[]))?'selected':'' }}>Manual</option>
                    <option value="1" {{ in_array('1',(array)request('automated',[]))?'selected':'' }}>Automatic</option>
                </select>
            </div>

        </div>

        {{-- Footer --}}
        <div class="filter-footer border-top bg-white p-3">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('calendar.index',['view'=>$view,'date'=>$currentDate]) }}"
                       class="btn btn-light border w-100">Reset</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </div>

    </form>
</div>


    </form>
</div>


<style>/* Offcanvas full height */
    .filter-canvas {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    /* Scroll only here */
    .filter-scroll {
        overflow-y: auto;
        height: calc(100vh - 140px); /* header + footer space */
        padding-bottom: 10px;
    }
    
    /* Always visible footer */
    .filter-footer {
        position: sticky;
        bottom: 0;
        background: #fff;
        z-index: 10;
    }
    </style>
    <!-- Task Modals -->
    @foreach ($allTasks as $task)
        <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(0, 33, 64); color: #fff;">
                        <h5 class="modal-title text-white">Task Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="customer_id" value="{{ $task->customer_id }}">
                        <input type="hidden" name="deal_id" value="{{ $task->deal?->id ?? '' }}">
                        <input type="hidden" name="due_date"
                            value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i:s') : '' }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Customer</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            value="{{ $task->customer->first_name ?? 'Unknown' }} {{ $task->customer->last_name ?? '' }}"
                                            readonly>
                                        @if ($task->customer_id)
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="openCustomerProfile({{ $task->customer_id }})">
                                                View Profile
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Assigned To</strong></label>
                                    <select name="assigned_to" class="form-select">
                                        <option value="">Unassigned</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>Date</strong></label>
                                    <input type="date" name="due_date_date" class="form-control"
                                        value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>Time</strong></label>
                                    <input type="time" name="due_date_time" class="form-control"
                                        value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('H:i') : '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"><strong>Priority</strong></label>
                                    <select name="priority" class="form-select">
                                        @foreach (['Low', 'Normal', 'High', 'Urgent'] as $priority)
                                            <option value="{{ $priority }}"
                                                {{ $task->priority == $priority ? 'selected' : '' }}>
                                                {{ $priority }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Task Type</strong></label>
                                    <select name="task_type" class="form-select">
                                        @foreach (['Inbound Call', 'Outbound Call', 'Inbound Text', 'Outbound Text', 'Inbound Email', 'Outbound Email', 'CSI', 'Appointment', 'Other'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $task->task_type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Status</strong></label>
                                    <select name="status_type" class="form-select">
                                        @foreach (['Open', 'Completed', 'Missed', 'Cancelled', 'No Response', 'No Show'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $task->status_type == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if ($task->deal)
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label"><strong>Vehicle</strong></label>
                                        <input type="text" class="form-control"
                                            value="{{ $task->deal->year }} {{ $task->deal->make }} {{ $task->deal->model }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label"><strong>Description</strong></label>
                                <textarea name="description" class="form-control" rows="2">{{ $task->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Script/Notes</strong></label>
                                <textarea name="script" class="form-control" rows="2">{{ $task->script }}</textarea>
                            </div>

                            <div class="row text-muted small">
                                <div class="col-md-6">
                                    <strong>Created By:</strong> {{ $task->createdBy->name ?? 'System' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Created:</strong> {{ $task->created_at?->format('M j, Y g:i A') }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.tom-multi').forEach(function(el) {

                new TomSelect(el, {
                    plugins: ['checkbox_options', 'remove_button'],
                    closeAfterSelect: false,
                    hideSelected: false,
                    persist: false,
                    create: false,
                    maxOptions: null,
                    placeholder: el.querySelector('option[disabled]')?.textContent ||
                        'Select options'
                });

            });

        });

        // Intercept server-rendered task modal form submissions and submit via AJAX to avoid page reloads
        const STATUS_COLORS = {!! json_encode($statusColors) !!};
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form || typeof form.getAttribute !== 'function') return;
            const action = form.getAttribute('action') || '';
            if (!action.includes('/tasks/update')) return;

            e.preventDefault();
            e.stopPropagation();
            console.log('Intercepted calendar task update form submit for', action);

            try {
                const fd = new FormData(form);
                const payload = {};
                fd.forEach((value, key) => {
                    if (payload[key] === undefined) payload[key] = value;
                    else if (Array.isArray(payload[key])) payload[key].push(value);
                    else payload[key] = [payload[key], value];
                });

                // If form contains separate date/time parts, combine into `due_date` expected by backend
                try {
                    if (payload.due_date_date || payload.due_date_time) {
                        const datePart = payload.due_date_date || '';
                        const timePart = payload.due_date_time || '';
                        let combined = datePart;
                        if (timePart) {
                            combined += ' ' + (timePart.length === 5 ? (timePart + ':00') : timePart);
                        } else {
                            combined += ' 00:00:00';
                        }
                        payload.due_date = combined;
                    }
                } catch (e) {
                    console.warn('Could not combine due_date parts', e);
                }

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(Object.assign({
                            _method: 'PUT'
                        }, payload))
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (!data || String(data.status).toLowerCase() !== 'success') {
                            console.error('Task update failed', data);
                            alert((data && data.message) ? data.message : 'Failed to update task');
                            return;
                        }

                        // Close the modal
                        const modalEl = form.closest('.modal');
                        if (modalEl) {
                            try {
                                bootstrap.Modal.getInstance(modalEl).hide();
                            } catch (err) {
                                modalEl.classList.remove('show');
                            }
                        }

                        // Update UI: FullCalendar event if present, and server-rendered calendar links
                        try {
                            const m = action.match(/\/tasks\/update\/(\d+)/);
                            const taskId = m ? m[1] : null;

                            if (taskId) {
                                // Update FullCalendar event if available
                                try {
                                    const ev = (typeof window.calendar !== 'undefined') ? window.calendar
                                        .getEventById(String(taskId)) : null;
                                    if (ev) {
                                        const newTitle = payload.description || ev.title;
                                        ev.setProp('title', newTitle);
                                        if (payload.due_date) ev.setStart(payload.due_date);
                                    }
                                } catch (err) {
                                    console.warn('FullCalendar update skipped', err);
                                }

                                // Update any server-rendered calendar anchors that open this modal
                                try {
                                    const anchors = document.querySelectorAll(
                                        `a[data-bs-target="#taskModal${taskId}"]`);
                                    anchors.forEach(a => {
                                        // Update text: keep leading time if present
                                        const text = (a.textContent || '').trim();
                                        const parts = text.split(' - ');
                                        const timePart = parts[0] || '';
                                        const nameOrDesc = payload.description || parts.slice(1).join(
                                            ' - ') || '';
                                        a.textContent = timePart ? (timePart + ' - ' + nameOrDesc) :
                                            nameOrDesc;

                                        // Determine color from payload.status_type (case-insensitive)
                                        let statusVal = payload.status_type || payload.status || payload
                                            .statusType || '';
                                        let bg = '#6c757d';
                                        if (statusVal) {
                                            Object.keys(STATUS_COLORS).some(k => {
                                                if (String(k).trim().toLowerCase() === String(
                                                        statusVal).trim().toLowerCase()) {
                                                    bg = STATUS_COLORS[k];
                                                    return true;
                                                }
                                                return false;
                                            });
                                        }
                                        a.style.backgroundColor = bg;
                                        a.style.borderColor = bg;
                                        a.style.color = '#ffffff';
                                    });

                                    // Refresh the server-rendered calendar block so counts/positions update
                                    try {
                                        const wrapper = document.getElementById('serverCalendarWrapper');
                                        if (wrapper) {
                                            fetch(window.location.href, {
                                                    headers: {
                                                        'X-Requested-With': 'XMLHttpRequest'
                                                    }
                                                })
                                                .then(r => r.text())
                                                .then(html => {
                                                    const tmp = document.createElement('div');
                                                    tmp.innerHTML = html;
                                                    const newWrapper = tmp.querySelector(
                                                        '#serverCalendarWrapper');
                                                    if (newWrapper) wrapper.outerHTML = newWrapper
                                                        .outerHTML;
                                                })
                                                .catch(err => console.warn('Failed to refresh calendar HTML',
                                                    err));
                                        }
                                    } catch (e) {
                                        console.warn('Refresh calendar wrapper failed', e);
                                    }
                                } catch (err) {
                                    console.error('Failed to update server-rendered anchors', err);
                                }
                            }
                        } catch (err) {
                            console.error('Failed to update calendar UI after AJAX save', err);
                        }

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved',
                                text: data.message || 'Task updated',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Save error', err);
                        alert('An error occurred while saving.');
                    });
            } catch (err) {
                console.error('Failed to submit task update via AJAX', err);
            }
        }, true);
    </script>
@endpush

@push('styles')
    <style>
        .fc-button {
            color: var(--star-icon);
            background-color: var(--cf-light);
            border: 1px solid #ddd;
            box-shadow: none !important;
            outline: none;
            margin: 0 3px !important;
            border-radius: 5px !important;
            flex: 1 1 auto;
            position: relative;
            text-align: center;
            user-select: none;
            vertical-align: middle;
            display: inline-block;
            font-size: 1em;
            font-weight: 400;
            line-height: 1.5;
        }

        .fc-button.active {
            background-color: rgb(0, 33, 64);
            border-color: rgb(0, 33, 64);
            color: #fff;
        }

        .custom-nav-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0px 0px 10px;
            background: rgb(255, 255, 255);
            border-bottom: 1px solid rgb(233, 236, 239);
            margin-bottom: 10px;
        }

        .dateDisplay {
            font-size: 18px;
            font-weight: 600;
            min-width: 240px;
            text-align: center;
            color: rgb(33, 37, 41);
        }

        .nav-btn-custom {
            background: none;
            border: 1px solid rgb(222, 226, 230);
            padding: 8px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            color: rgb(73, 80, 87);
            transition: 0.2s;
            margin-right: 15px;
        }

        .tom-multi {
            background: #fff
        }

        .calendar-table {
            table-layout: fixed;
        }

        .calendar-cell {
            padding: 0 !important;
        }

        .task-event {
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .task-event:hover {
            opacity: 0.85;
        }

        .task-call {
            background-color: rgb(125, 125, 125) !important;
        }

        .task-email,
        .task-text {
            background-color: rgb(56, 115, 166) !important;
        }

        .task-appointment {
            background-color: rgb(212, 142, 51) !important;
        }

        .task-other {
            background-color: rgb(105, 87, 194) !important;
        }

        .bg-primary-light {
            background-color: #f5f5f5 !important;
        }

        #customcanvas {
            width: 350px;
            z-index: 1070 !important;
        }

        .offcanvas-footer {
            border-top: 1px solid #ddd;
        }

        .event {
            display: block;
            padding: 4px 6px;
            margin-bottom: 4px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            /* keep text in one line */
            overflow: hidden;
            /* hide overflow */
            text-overflow: ellipsis;
            /* show "..." if too long */
            transition: transform 0.1s, box-shadow 0.2s;
        }

        .event:hover {
            transform: translateY(-1px);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all elements with data-bs-toggle="tooltip"
            var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

            // Initialize each tooltip
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
