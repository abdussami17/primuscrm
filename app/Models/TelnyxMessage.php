<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelnyxMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'telnyx_messages';

    protected $fillable = [
        'telnyx_id', 'direction', 'type', 'from', 'to', 'body', 'status', 'raw',
        'is_starred', 'is_read', 'is_draft', 'contact_name', 'customer_id',
    ];

    protected $casts = [
        'raw'        => 'array',
        'is_starred' => 'boolean',
        'is_read'    => 'boolean',
        'is_draft'   => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * The "other party" phone number — the person we're texting with.
     * For outbound messages it's the `to` field; for inbound it's the `from` field.
     */
    public function getOtherPartyAttribute(): ?string
    {
        return $this->direction === 'outbound' ? $this->to : $this->from;
    }

    /**
     * Display name for the other party — contact_name if stored, else the phone number.
     */
    public function getOtherPartyNameAttribute(): string
    {
        return $this->contact_name ?: ($this->other_party ?? 'Unknown');
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    /** Only SMS type messages. */
    public function scopeSms($query)
    {
        return $query->where('type', 'sms');
    }

    /** Only inbound messages. */
    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    /** Only outbound messages. */
    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    /** Only starred messages. */
    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    /** Only unread messages. */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /** Only draft messages. */
    public function scopeDraft($query)
    {
        return $query->where('is_draft', true);
    }

    /** Exclude drafts (for inbox / starred / sent). */
    public function scopeNotDraft($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('is_draft')->orWhere('is_draft', false);
        });
    }
}
