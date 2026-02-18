{{-- Single Email Item Component --}}
@props(['email', 'currentFolder' => 'inbox'])

<div class="list-group-item border-bottom p-3" data-email-id="{{ $email->id }}">
    <div class="d-flex align-items-center mb-2">
        <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
            <input class="form-check-input email-checkbox" type="checkbox" value="{{ $email->id }}">
        </div>

        <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
            <a href="{{ route('email.reply', $email->id) }}" class="avatar bg-primary avatar-rounded me-2">
                @if($currentFolder === 'sent')
                    @if($email->user && $email->user->avatar)
                        <img src="{{ asset('storage/' . $email->user->avatar) }}" alt="{{ $email->user->name }}" class="rounded-circle">
                    @else
                        <span class="avatar-title">{{ strtoupper(substr($email->to_email, 0, 2)) }}</span>
                    @endif
                @else
                    @if($email->sender && $email->sender->avatar)
                        <img src="{{ asset('storage/' . $email->sender->avatar) }}" alt="{{ $email->sender->name }}" class="rounded-circle">
                    @else
                        <span class="avatar-title">{{ $email->sender_initials }}</span>
                    @endif
                @endif
            </a>
            <div class="flex-fill">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h6 class="mb-1 {{ !$email->is_read && $currentFolder !== 'sent' ? 'fw-bold' : '' }}">
                            <a href="{{ route('email.reply', $email->id) }}">
                                @if($currentFolder === 'sent')
                                    {{ $email->to_email }}
                                @else
                                    {{ $email->sender->name ?? 'Unknown Sender' }}
                                @endif
                            </a>
                        </h6>
                        <span class="fw-semibold {{ !$email->is_read && $currentFolder !== 'sent' ? 'fw-bold' : '' }}">
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
                                    <a class="dropdown-item rounded-1" href="{{ route('email.reply', $email->id) }}">Open Message Thread</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-1" href="{{ route('email.reply', $email->id) }}">Reply</a>
                                </li>
                                @if($currentFolder !== 'sent' && $currentFolder !== 'drafts')
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
                                            <form action="{{ route('email.force-delete', $email->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this email?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item rounded-1 text-danger">Delete Permanently</button>
                                            </form>
                                        </li>
                                    @endcan
                                @else
                                    {{-- Delete (only Managers can see this based on your comments) --}}
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
                            @if(!$email->is_read && $currentFolder !== 'sent')
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