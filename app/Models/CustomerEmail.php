<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'email',
        'is_default',
        'label',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the email.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope to get only default emails.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope to get only verified emails.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Mark this email as verified.
     */
    public function markAsVerified(): bool
    {
        return $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Set this email as the default for the customer.
     */
    public function setAsDefault(): bool
    {
        // Remove default from other emails
        self::where('customer_id', $this->customer_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this one as default
        return $this->update(['is_default' => true]);
    }
}