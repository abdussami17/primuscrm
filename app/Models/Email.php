<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'to_email',
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
     * Get the sender of this email
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
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
     * Scope for inbox emails
     */
    public function scopeInbox($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->where('is_draft', false)
                     ->where('is_sent', false);
    }

    /**
     * Scope for sent emails
     */
    public function scopeSent($query, $userId)
    {
        return $query->where('from_user_id', $userId)
                     ->where('is_sent', true)
                     ->where('is_draft', false);
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
     * Get sender initials for avatar
     */
    public function getSenderInitialsAttribute()
    {
        if ($this->sender) {
            $names = explode(' ', $this->sender->name);
            $initials = '';
            foreach ($names as $name) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
            return substr($initials, 0, 2);
        }
        return 'NA';
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