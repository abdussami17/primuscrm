@extends('layouts.app')

@section('title', 'Email Reply')

@section('content')
<div class="content content-two p-0">
    <div class="d-md-flex">
        {{-- Sidebar --}}
        @include('emails.partials.sidebar')

        {{-- Main Content - Email Detail --}}
        <div class="mail-detail bg-white border-bottom p-3">
            <div class="active slimscroll h-100">
                <div class="slimscroll-active-sidebar">
                    {{-- Header --}}
                    <div class="d-flex align-items-center table-header justify-content-between flex-wrap row-gap-2 border-bottom mb-3 pb-3">
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="badge bg-dark rounded-circle badge-xs me-1">{{ $peopleInThread->count() }}</span> Peoples
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li>
                                    <span class="dropdown-item-text fw-bold">Peoples</span>
                                </li>
                                @foreach($peopleInThread as $person)
                                    <li>
                                        <a class="dropdown-item rounded-1" href="javascript:void(0);">{{ $person->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply" title="Reply">
                                <i class="ti ti-arrow-back-up"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply" title="Reply All">
                                <i class="ti ti-arrow-back-up-double"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply" title="Forward">
                                <i class="ti ti-arrow-forward"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle" title="Bookmark">
                                <i class="ti ti-bookmarks-filled"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle" title="Archive">
                                <i class="ti ti-archive-filled"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle" title="Mark Read">
                                <i class="ti ti-mail-opened-filled"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle" title="Print" onclick="window.print()">
                                <i class="ti ti-printer"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle favorite-icon" data-email-id="{{ $email->id }}" title="Star">
                                <i class="ti {{ $email->is_starred ? 'ti-star-filled text-warning' : 'ti-star-filled text-warning' }}"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Email Header Info --}}
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center flex-fill border-bottom mb-3 pb-3">
                            <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                @if($email->sender && $email->sender->avatar)
                                    <img src="{{ asset('storage/' . $email->sender->avatar) }}" alt="{{ $email->sender->name }}">
                                @else
                                    <span class="avatar-title bg-primary">{{ $email->sender_initials }}</span>
                                @endif
                            </a>
                            <div class="flex-fill">
                                <div class="d-flex align-items-start justify-content-between flex-wrap row-gap-2">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="javascript:void(0);">{{ $email->sender->name ?? 'Unknown Sender' }}</a>
                                        </h6>
                                        <p>Subject: {{ $email->subject }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="me-2 mb-0">{{ $email->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-wrap row-gap-2">
                            <p class="mb-0 text-dark me-3">
                                <span class="text-gray">From: </span> {{ $email->sender->name ?? 'Unknown' }}
                            </p>
                            <p class="mb-0 text-dark me-3">
                                <span class="text-gray">To: </span> {{ $email->user->name ?? $email->to_email }}
                            </p>
                            @if($email->cc && count($email->cc) > 0)
                                <p class="mb-0 text-dark">
                                    <span class="text-gray">Cc: </span> {{ implode(', ', $email->cc) }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Reply Box (Hidden by default) --}}
                    <div class="card shadow-none d-none" id="replybackbox">
                        <div class="card-body">
                            <div class="bg-light rounded p-3 mb-3">
                                <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                                    <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                        @else
                                            <span class="avatar-title bg-primary">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                        @endif
                                    </a>
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-start justify-content-between flex-wrap row-gap-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="javascript:void(0);">{{ auth()->user()->name }}</a>
                                                </h6>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0">
                                                        <span>To: </span> {{ $email->sender->email ?? $email->to_email }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0">Now</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-2">Dear {{ $email->sender->name ?? 'Sender' }}</h6>
                                <p class="text-dark">Reply to: {{ $email->subject }}</p>
                            </div>
                            <form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="to_email" value="{{ $email->sender->email ?? $email->to_email }}">
                                <input type="hidden" name="subject" value="Re: {{ $email->subject }}">
                                <input type="hidden" name="parent_id" value="{{ $email->id }}">

                                <div class="border rounded mt-3">
                                    <div class="p-3 position-relative border-bottom">
                                        <div class="tag-with-img d-flex align-items-center">
                                            <label class="form-label me-2 mb-0">To</label>
                                            <input class="input-tags form-control border-0 h-100" type="text" readonly value="{{ $email->sender->name ?? '' }} <{{ $email->sender->email ?? $email->to_email }}>">
                                        </div>
                                        <div class="d-flex align-items-center email-cc">
                                            <a href="javascript:void(0);" class="d-inline-flex me-2" id="replyCcBtn">Cc</a>
                                            <a href="javascript:void(0);" class="d-inline-flex" id="replyBccBtn">Bcc</a>
                                        </div>
                                    </div>

                                    {{-- Hidden CC field --}}
                                    <div class="p-3 pb-0 border-bottom d-none" id="replyCcField">
                                        <input class="form-control border-0" name="cc[]" type="text" placeholder="Add CC recipients...">
                                    </div>

                                    {{-- Hidden BCC field --}}
                                    <div class="p-3 pb-0 border-bottom d-none" id="replyBccField">
                                        <input class="form-control border-0" name="bcc[]" type="text" placeholder="Add BCC recipients...">
                                    </div>

                                    <div class="p-3">
                                        <div class="mb-3">
                                            <textarea rows="5" name="body" class="form-control border-0 p-0 bg-transparent" placeholder="Write your reply..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top p-3 flex-wrap">
                                        <div class="d-flex align-items-center">
                                            <label for="replyAttachment" class="btn btn-icon btn-sm rounded-circle" style="cursor: pointer;">
                                                <i class="ti ti-paperclip"></i>
                                            </label>
                                            <input type="file" id="replyAttachment" name="attachments[]" multiple class="d-none">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-photo"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-link"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-pencil"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-mood-smile"></i></a>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-calendar-repeat"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply"><i class="ti ti-trash"></i></a>
                                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center ms-2">
                                                Send <i class="ti ti-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Main Email Content --}}
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div>
                                <h6 class="mb-3">Dear {{ $email->user->name ?? 'Recipient' }}</h6>
                                <div class="text-dark email-content">
                                    {!! nl2br(e($email->body)) !!}
                                </div>
                            </div>

                            {{-- Attachments --}}
                            @if($email->attachments->count() > 0)
                                <div class="d-flex align-items-center justify-content-between my-3 pt-3 border-top">
                                    <h5>Attachments</h5>
                                    <a href="javascript:void(0);" class="text-primary fw-medium" id="downloadAllAttachments">Download All</a>
                                </div>
                                <div class="d-flex align-items-center email-attach flex-wrap">
                                    @foreach($email->attachments as $attachment)
                                        @if($attachment->is_image)
                                            <a href="{{ asset('storage/' . $attachment->file_path) }}" data-fancybox="gallery" class="avatar avatar-xl me-3 mb-2 gallery-item">
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}" class="rounded" alt="{{ $attachment->original_filename }}">
                                                <span class="avatar avatar-md avatar-rounded"><i class="ti ti-eye"></i></span>
                                            </a>
                                        @else
                                            <a href="{{ route('email.download-attachment', $attachment->id) }}" class="d-flex align-items-center border rounded p-2 me-3 mb-2">
                                                <i class="ti ti-file fs-4 me-2"></i>
                                                <div>
                                                    <small class="d-block">{{ \Str::limit($attachment->original_filename, 20) }}</small>
                                                    <small class="text-muted">{{ $attachment->formatted_size }}</small>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Previous Messages in Thread --}}
                    @if($threadEmails->count() > 1)
                        <div class="text-center">
                            <a href="javascript:void(0);" class="btn btn-dark btn-sm" id="viewOlderMessages">
                                View Older Messages ({{ $threadEmails->count() - 1 }})
                            </a>
                        </div>

                        <div class="older-messages d-none" id="olderMessagesContainer">
                            @foreach($threadEmails->reverse()->skip(1) as $threadEmail)
                                <div class="card shadow-none mt-3">
                                    <div class="card-body">
                                        <div class="bg-light rounded p-3 mb-3">
                                            <div class="d-flex align-items-center flex-fill">
                                                <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                                    @if($threadEmail->sender && $threadEmail->sender->avatar)
                                                        <img src="{{ asset('storage/' . $threadEmail->sender->avatar) }}" alt="{{ $threadEmail->sender->name }}">
                                                    @else
                                                        <span class="avatar-title bg-primary">{{ $threadEmail->sender_initials }}</span>
                                                    @endif
                                                </a>
                                                <div class="flex-fill">
                                                    <div class="d-flex align-items-start justify-content-between">
                                                        <div>
                                                            <h6 class="mb-1">{{ $threadEmail->sender->name ?? 'Unknown' }}</h6>
                                                            <p class="mb-0 text-muted">{{ $threadEmail->created_at->format('M d, Y g:i A') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-dark">
                                            {!! nl2br(e($threadEmail->body)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
<script>
    // Reply CC/BCC Toggle
    document.getElementById('replyCcBtn')?.addEventListener('click', function() {
        document.getElementById('replyCcField')?.classList.toggle('d-none');
    });
    document.getElementById('replyBccBtn')?.addEventListener('click', function() {
        document.getElementById('replyBccField')?.classList.toggle('d-none');
    });

    // View Older Messages Toggle
    document.getElementById('viewOlderMessages')?.addEventListener('click', function() {
        const container = document.getElementById('olderMessagesContainer');
        if (container) {
            container.classList.toggle('d-none');
            this.textContent = container.classList.contains('d-none') 
                ? 'View Older Messages ({{ $threadEmails->count() - 1 }})' 
                : 'Hide Older Messages';
        }
    });
</script>
@endpush