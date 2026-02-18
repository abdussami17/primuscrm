@extends('layouts.app')

@section('title', 'Email Inbox')

@section('content')
<div class="content content-two p-0">
    <div class="d-md-flex">
        {{-- Sidebar --}}
        @include('emails.partials.sidebar', ['currentFolder' => $currentFolder ?? 'inbox'])

        {{-- Main Content --}}
        <div class="bg-white flex-fill border-end border-bottom mail-notifications">
            <div class="active slimscroll h-100">
                <div class="slimscroll-active-sidebar">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <div>
                                <h5 class="mb-1">
                                    @switch($currentFolder ?? 'inbox')
                                        @case('starred')
                                            Starred
                                            @break
                                        @case('sent')
                                            Sent
                                            @break
                                        @case('drafts')
                                            Drafts
                                            @break
                                        @case('deleted')
                                            Deleted
                                            @break
                                        @default
                                            Email Inbox
                                    @endswitch
                                </h5>
                                <div class="d-flex align-items-center">
                                    <span>{{ $emails->total() }} Emails</span>
                                    @if(($currentFolder ?? 'inbox') === 'inbox')
                                        <i class="ti ti-point-filled text-primary mx-1"></i>
                                        <span>{{ $counts['unread'] ?? 0 }} Unread</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="position-relative input-icon me-3">
                                    <form action="{{ route('email.' . ($currentFolder ?? 'inbox')) }}" method="GET" id="searchForm">
                                        <input type="text" class="form-control" name="search" placeholder="Search Email" value="{{ $search ?? '' }}">
                                        <input type="hidden" name="filter" value="{{ $filter ?? 'date_high' }}">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-search"></i>
                                        </span>
                                    </form>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown" id="filterDropdownBtn">
                                            <i class="ti ti-filter-edit"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" id="filterDropdown">
                                            <li>
                                                <a class="dropdown-item {{ ($filter ?? 'date_high') === 'date_low' ? 'active' : '' }}" href="javascript:void(0);" data-value="date_low" onclick="applyFilter(this)">
                                                    Date: Earliest to Latest
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item {{ ($filter ?? 'date_high') === 'date_high' ? 'active' : '' }}" href="javascript:void(0);" data-value="date_high" onclick="applyFilter(this)">
                                                    Date: Latest to Earliest
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <input type="hidden" id="selectedFilter" name="selectedFilter" value="{{ $filter ?? 'date_high' }}">

                                    <button type="button" id="bulkDeleteBtn" class="btn btn-icon btn-sm rounded-circle d-none" title="Delete Selected">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                    <a href="{{ route('email.' . ($currentFolder ?? 'inbox')) }}" class="btn btn-icon btn-sm rounded-circle" title="Refresh">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Email List --}}
                    <div class="list-group list-group-flush mails-list">
                        @forelse($emails as $email)
                            @include('emails.partials.email-item', [
                                'email' => $email,
                                'currentFolder' => $currentFolder ?? 'inbox'
                            ])
                        @empty
                            <div class="list-group-item border-bottom p-4 text-center">
                                <i class="ti ti-inbox-off fs-1 text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">
                                    @switch($currentFolder ?? 'inbox')
                                        @case('starred')
                                            No starred emails
                                            @break
                                        @case('sent')
                                            No sent emails
                                            @break
                                        @case('drafts')
                                            No drafts
                                            @break
                                        @case('deleted')
                                            No deleted emails
                                            @break
                                        @default
                                            Your inbox is empty
                                    @endswitch
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($emails->hasPages())
                        <div class="p-3 d-flex justify-content-center">
                            {{ $emails->appends(['filter' => $filter ?? 'date_high', 'search' => $search ?? ''])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Compose Modal --}}
@include('emails.partials.compose-modal')

@endsection

@push('scripts')
@include('emails.partials.script')

{{-- <script data-cfasync="false" src="{{ asset('assets/js/inbox.js') }}"></script> --}}
@endpush