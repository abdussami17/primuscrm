{{-- Single Email Item Component --}}
@props(['email', 'currentFolder' => 'inbox'])

@php
    $isSent           = $currentFolder === 'sent';
    $isSentWithReplies = $email->is_sent && $currentFolder === 'inbox';

    // For sent: recipient name (resolve via customer table if possible)
    if ($isSent || $isSentWithReplies) {
        $customerMatch = \App\Models\Customer::where('email', $email->to_email)->first();
        $otherParty    = $customerMatch
            ? trim($customerMatch->first_name . ' ' . $customerMatch->last_name)
            : $email->to_email;
    } else {
        $otherParty = $email->sender_display_name;
    }

    // Reply count for sent threads
    $replyCount       = isset($email->replies_count) ? $email->replies_count : 0;
    // Whether there is at least one unread inbound reply
    $hasUnreadReply   = $isSentWithReplies && $email->replies()->where('is_sent', false)->where('is_read', false)->exists();
    // Unread indicator (bold row) — unread inbound email OR thread with unread reply
    $hasUnread        = (!$email->is_read && !$isSent) || $hasUnreadReply;
@endphp

<div class="list-group-item border-bottom p-3" data-email-id="{{ $email->id }}">
    <div class="d-flex align-items-center mb-2">
        <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
            <input class="form-check-input email-checkbox" type="checkbox" value="{{ $email->id }}">
        </div>

        <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
            <a href="{{ route('email.reply', $email->id) }}" class="avatar bg-primary avatar-rounded me-2">
                <span class="avatar-title">{{ strtoupper(substr($otherParty, 0, 2)) }}</span>
            </a>

            <div class="flex-fill">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h6 class="mb-1 {{ $hasUnread ? 'fw-bold' : '' }}">
                            <a href="{{ route('email.reply', $email->id) }}">{{ $otherParty }}</a>
                            @if($hasUnreadReply)
                                <span class="badge bg-success ms-1" style="font-size:9px">New Reply</span>
                            @elseif($isSentWithReplies && $replyCount > 0)
                                <span class="badge bg-secondary ms-1" style="font-size:9px">Replied</span>
                            @elseif($isSent && $replyCount > 0)
                                <span class="badge bg-secondary ms-1" style="font-size:9px">{{ $replyCount }} {{ $replyCount === 1 ? 'reply' : 'replies' }}</span>
                            @endif
                        </h6>
                        <span class="{{ $hasUnread ? 'fw-bold' : 'fw-semibold' }}">
                            {{ $email->subject }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li>
                                    <a class="dropdown-item rounded-1" href="{{ route('email.reply', $email->id) }}">Open Thread</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-1" href="{{ route('email.reply', $email->id) }}">Reply</a>
                                </li>
                                @if($currentFolder !== 'sent' && $currentFolder !== 'drafts' && !$isSentWithReplies)
                                    <li>
                                        <a class="dropdown-item rounded-1 toggle-read-btn" href="javascript:void(0);" data-email-id="{{ $email->id }}">
                                            {{ $email->is_read ? 'Mark as Unread' : 'Mark as Read' }}
                                        </a>
                                    </li>
                                @endif
                                @if($currentFolder === 'deleted')
                                    <li>
                                        <form action="{{ route('email.restore', $email->id) }}" method="POST" class="d-inline restore-email-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item rounded-1">Restore</button>
                                        </form>
                                    </li>
                                    @can('forceDelete', $email)
                                        <li>
                                            <form action="{{ route('email.force-delete', $email->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item rounded-1 text-danger">Delete Permanently</button>
                                            </form>
                                        </li>
                                    @endcan
                                @else
                                    @can('delete', $email)
                                        <li>
                                            <form action="{{ route('email.delete', $email->id) }}" method="POST" class="d-inline delete-email-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item rounded-1 text-danger">Delete</button>
                                            </form>
                                        </li>
                                    @endcan
                                @endif
                            </ul>
                        </div>
                        <span>
                            @if($hasUnread)
                                <i class="ti ti-point-filled text-success"></i>
                            @endif
                            {{ $email->formatted_time }}
                        </span>
                        <div class="ms-2 favorite-icon" data-email-id="{{ $email->id }}">
                            <i class="ti {{ $email->is_starred ? 'ti-star-filled text-warning' : 'ti-star' }}"></i>
                        </div>
                    </div>
                </div>
                <p class="mb-0 text-muted">{{ $email->excerpt }}</p>
                @if($email->attachments->count() > 0)
                    <small class="text-muted">
                        <i class="ti ti-paperclip"></i> {{ $email->attachments->count() }} attachment{{ $email->attachments->count() > 1 ? 's' : '' }}
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>