<?php

namespace App\Models;

use App\Models\CustomerEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'profile_image',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'cell_phone',
        'work_phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'status',
        'lead_source',
        'assigned_to',
        'assigned_manager',
        'secondary_assigned',
        'bdc_agent',
        'interested_make',
        'interested_model',
        'interested_year',
        'budget',
        'tradein_year',
        'tradein_make',
        'tradein_model',
        'tradein_vin',
        'tradein_kms',
        'tradein_value',
        'notes',
        'tags',
        'preferences',
        'consent_marketing',
        'consent_sms',
        'consent_email',
        'dealership_franchises',
        'last_contacted_at',
        'next_follow_up_at',
        // Social Media
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'tiktok_url',
        'reddit_url',
        'inventory_type',
        'finance_manager'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'preferences' => 'array',
        'dealership_franchises' => 'array',
        'budget' => 'decimal:2',
        'tradein_value' => 'decimal:2',
        'tradein_kms' => 'integer',
        'consent_marketing' => 'boolean',
        'consent_sms' => 'boolean',
        'consent_email' => 'boolean',
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
    ];

    /**
     * Get the user assigned to this customer.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Alias for assignedUser for compatibility with callers using `assignedTo`.
     */
    public function assignedTo()
    {
        return $this->assignedUser();
    }

    /**
     * Get the manager assigned to this customer.
     */
    public function assignedManagerUser()
    {
        return $this->belongsTo(User::class, 'assigned_manager');
    }

    /**
     * Get the secondary assigned user.
     */
    public function secondaryAssignedUser()
    {
        return $this->belongsTo(User::class, 'secondary_assigned');
    }

    /**
     * Get the BDC agent assigned to this customer.
     */
    public function bdcAgentUser()
    {
        return $this->belongsTo(User::class, 'bdc_agent');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the co-buyer for the customer.
     */
    public function coBuyer()
    {
        return $this->hasOne(CoBuyer::class);
    }

    /**
     * Get the deals for the customer.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class, 'customer_id');
    }

    /**
     * Get the documents for the customer.
     */
    public function documents()
    {
        return $this->hasMany(CustomerDocument::class, 'customer_id');
    }
   public function task_deals()
{
    return $this->hasMany(Deal::class, 'customer_id')
        ->select('id', 'customer_id', 'deal_number', 'vehicle_description');
}

public function getPrimaryEmailAttribute(): ?string
    {
        $defaultEmail = $this->emails()->where('is_default', true)->first();
        
        if ($defaultEmail) {
            return $defaultEmail->email;
        }

        // Fallback to first email or email column
        $firstEmail = $this->emails()->first();
        return $firstEmail ? $firstEmail->email : $this->email;
    }

    /**
     * Get all email addresses as an array.
     */
    public function getAllEmailsAttribute(): array
    {
        return $this->emails()->pluck('email')->toArray();
    }

    /**
     * Sync emails for the customer.
     */
    public function syncEmails(array $emails, int $defaultIndex = 0): void
    {
        // Delete existing emails
        $this->emails()->delete();

        // Create new emails
        foreach ($emails as $index => $email) {
            $this->emails()->create([
                'email' => $email,
                'is_default' => $index === $defaultIndex,
            ]);
        }

        // Update primary email column for backward compatibility
        $defaultEmail = $emails[$defaultIndex] ?? $emails[0] ?? null;
        if ($defaultEmail) {
            $this->update(['email' => $defaultEmail]);
        }
    }

    public function emails()
{
    return $this->hasMany(CustomerEmail::class);
}


}
