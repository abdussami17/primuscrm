@extends('layouts.app')

@section('title', $smartSequence->title)

@section('content')

<div class="content">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('smart-sequences.index') }}" class="text-decoration-none text-muted">
                <i class="ti ti-arrow-left me-1"></i> Back to Sequences
            </a>
            <h4 class="mb-0 mt-2">{{ $smartSequence->title }}</h4>
            <span class="badge {{ $smartSequence->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $smartSequence->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('smart-sequences.edit', $smartSequence) }}" class="btn btn-primary">
                <i class="ti ti-edit me-1"></i> Edit
            </a>
            <form action="{{ route('smart-sequences.duplicate', $smartSequence) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary">
                    <i class="ti ti-copy me-1"></i> Duplicate
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Statistics -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti ti-chart-bar me-2"></i>Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col">
                            <div class="fs-4 fw-bold text-primary">{{ number_format($smartSequence->sent_count) }}</div>
                            <small class="text-muted">Sent</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-success">{{ number_format($smartSequence->delivered_count) }}</div>
                            <small class="text-muted">Delivered</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-info">{{ number_format($smartSequence->opened_count) }}</div>
                            <small class="text-muted">Opened</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-warning">{{ number_format($smartSequence->clicked_count) }}</div>
                            <small class="text-muted">Clicked</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-success">{{ number_format($smartSequence->replied_count) }}</div>
                            <small class="text-muted">Replied</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-danger">{{ number_format($smartSequence->bounced_count) }}</div>
                            <small class="text-muted">Bounced</small>
                        </div>
                        <div class="col">
                            <div class="fs-4 fw-bold text-secondary">{{ number_format($smartSequence->unsubscribed_count) }}</div>
                            <small class="text-muted">Unsubscribed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Criteria -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti ti-list-check me-2"></i>Criteria Groups</h6>
                </div>
                <div class="card-body">
                    @forelse($smartSequence->criteriaGroups as $group)
                        <div class="mb-3 p-3 rounded {{ $group->logic_type === 'OR' ? 'bg-warning-subtle' : 'bg-light' }}">
                            <span class="badge {{ $group->logic_type === 'OR' ? 'bg-warning text-dark' : 'bg-primary' }} mb-2">
                                {{ $group->logic_type }}
                            </span>
                            <ul class="list-unstyled mb-0">
                                @foreach($group->criteria as $criterion)
                                    <li class="mb-1">
                                        <strong>{{ $criterion->field_label }}</strong>
                                        <span class="text-muted">{{ $criterion->operator_label }}</span>
                                        @if($criterion->requiresValue() && !empty($criterion->values))
                                            <span class="text-primary">{{ implode(', ', $criterion->values) }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No criteria defined</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti ti-repeat me-2"></i>Actions</h6>
                </div>
                <div class="card-body">
                    @forelse($smartSequence->actions as $index => $action)
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-grow-1">
                                <div class="fw-medium">{{ $action->action_label }}</div>
                                <small class="text-muted">Delay: {{ $action->delay_description }}</small>
                                @if($action->parameters)
                                    <div class="small text-muted mt-1">
                                        @foreach($action->parameters as $key => $value)
                                            <span class="badge bg-light text-dark me-1">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $action->is_valid ? '#28a745' : '#dc3545' }}" 
                                  title="{{ $action->is_valid ? 'Valid' : 'Invalid' }}"></span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No actions defined</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti ti-info-circle me-2"></i>Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Created By</small>
                            <span>{{ $smartSequence->creator->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Created On</small>
                            <span>{{ $smartSequence->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Last Updated</small>
                            <span>{{ $smartSequence->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Last Sent</small>
                            <span>{{ $smartSequence->last_sent_at?->format('M d, Y h:i A') ?? 'Never' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Execution Logs -->
        @if($smartSequence->executionLogs && $smartSequence->executionLogs->count() > 0)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="ti ti-history me-2"></i>Recent Execution Logs</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Lead</th>
                                <th>Status</th>
                                <th>Scheduled</th>
                                <th>Executed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($smartSequence->executionLogs as $log)
                            <tr>
                                <td>{{ $log->action->action_label ?? 'N/A' }}</td>
                                <td>{{ $log->lead->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        @switch($log->status)
                                            @case('completed') bg-success @break
                                            @case('failed') bg-danger @break
                                            @case('pending') bg-warning @break
                                            @case('processing') bg-info @break
                                            @default bg-secondary
                                        @endswitch">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td>{{ $log->scheduled_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $log->executed_at?->format('M d, Y h:i A') ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection