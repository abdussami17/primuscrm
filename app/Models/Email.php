<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'to_email',
        'from_email',
        'cc',
        'bcc',
        'subject',
        'body',
        'is_read',
        'is_starred',
        'is_draft',
        'is_sent',
        'parent_id',
        'thread_id',
        'message_id',
        'imap_uid',
    ];

    protected $casts = [
        'cc' => 'array',
        'bcc' => 'array',
        'is_read' => 'boolean',
        'is_starred' => 'boolean',
        'is_draft' => 'boolean',
        'is_sent' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the user who owns this email (recipient)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sender of this email (CRM user)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Resolve the customer who sent this inbound email (matched by from_email)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'from_email', 'email');
    }

    /**
     * Display name of whoever sent this email — CRM user, matched customer, or raw email.
     */
    public function getSenderDisplayNameAttribute(): string
    {
        if ($this->sender) {
            return $this->sender->name;
        }
        if ($this->customer) {
            return trim($this->customer->first_name . ' ' . $this->customer->last_name);
        }
        return $this->from_email ?? 'Unknown';
    }

    /**
     * Initials for avatar derived from senderDisplayName.
     */
    public function getSenderInitialsAttribute(): string
    {
        $name = $this->sender_display_name;
        if ($name === 'Unknown') return '?';
        $words    = explode(' ', $name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper(mb_substr($w, 0, 1));
        }
        return mb_substr($initials, 0, 2);
    }

    /**
     * Get the parent email (for replies)
     */
    public function parent()
    {
        return $this->belongsTo(Email::class, 'parent_id');
    }

    /**
     * Get replies to this email
     */
    public function replies()
    {
        return $this->hasMany(Email::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get all emails in the same thread
     */
    public function thread()
    {
        return $this->hasMany(Email::class, 'thread_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get attachments for this email
     */
    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class);
    }

    /**
     * Scope for inbox emails:
     *  - Sent thread roots that have ANY inbound customer reply (read or unread)
     *  - Also any unsolicited inbound emails (parent_id IS NULL, is_sent = false)
     * Once a customer replies, the thread lives in inbox — not just while unread.
     */
    public function scopeInbox($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->where('is_draft', false)
                     ->whereNull('parent_id')   // only thread roots, never individual replies
                     ->where(function ($q) {
                         // Thread roots where a customer (inbound) reply exists
                         $q->where(function ($q2) {
                             $q2->where('is_sent', true)
                                ->whereHas('replies', function ($r) {
                                    $r->where('is_sent', false); // any inbound reply, read or unread
                                });
                         })
                         // OR inbound emails that started a thread (customer wrote first)
                         ->orWhere('is_sent', false);
                     });
    }

    /**
     * Scope for sent emails — only thread roots so replies don't show as separate rows.
     */
    public function scopeSent($query, $userId)
    {
        return $query->where('from_user_id', $userId)
                     ->where('is_sent', true)
                     ->where('is_draft', false)
                     ->whereNull('parent_id'); // thread roots only
    }

    /**
     * Scope for draft emails
     */
    public function scopeDrafts($query, $userId)
    {
        return $query->where('from_user_id', $userId)
                     ->where('is_draft', true);
    }

    /**
     * Scope for starred emails
     */
    public function scopeStarred($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->where('is_starred', true);
    }

    /**
     * Scope for unread emails
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for deleted emails (soft deleted)
     */
    public function scopeDeleted($query, $userId)
    {
        return $query->onlyTrashed()
                     ->where('user_id', $userId);
    }

    /**
     * Get formatted time
     */
    public function getFormattedTimeAttribute()
    {
        if ($this->created_at->isToday()) {
            return $this->created_at->format('g:i A');
        } elseif ($this->created_at->isYesterday()) {
            return 'Yesterday ' . $this->created_at->format('g:i A');
        } elseif ($this->created_at->isCurrentYear()) {
            return $this->created_at->format('M d');
        }
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get excerpt of body
     */
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->body), 50);
    }
}