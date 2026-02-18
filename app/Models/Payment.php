<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'deal_id',
        'payment_type',
        
        // Common fields
        'down_payment',
        'deposit_received',
        'trade_in_value',
        'lien_payout',
        'admin_fee',
        'doc_fee',
        'front_end_gross',
        'back_end_gross',
        'total_gross',
        'credit_score',
        
        // Lease specific
        'lease_company',
        'lease_program',
        'money_factor',
        'lease_term',
        'lease_payment_frequency',
        'miles_per_year',
        'excess_mileage',
        'selling_price',
        'residual_percent',
        'residual_value',
        'monthly_payment',
        'due_at_signing',
        'lease_start',
        'lease_end',
        'buyout_amount',
        'lease_gross',
        'reserve_fee',
        'total_profit',
        
        // Finance specific
        'lender_name',
        'lender_code',
        'interest_rate',
        'finance_term',
        'finance_payment_frequency',
        'start_date',
        'end_date',
        'bank_fee',
        'extended_warranty',
        'warranty_amount',
        
        // Cash specific
        'payment_method',
        'total_cash_received',
        'total_sale_amount',
        'delivered_date',
        'sold_date',
    ];

    protected $casts = [
        'down_payment' => 'decimal:2',
        'deposit_received' => 'decimal:2',
        'trade_in_value' => 'decimal:2',
        'lien_payout' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'doc_fee' => 'decimal:2',
        'front_end_gross' => 'decimal:2',
        'back_end_gross' => 'decimal:2',
        'total_gross' => 'decimal:2',
        'money_factor' => 'decimal:5',
        'excess_mileage' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'residual_percent' => 'decimal:2',
        'residual_value' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'due_at_signing' => 'decimal:2',
        'buyout_amount' => 'decimal:2',
        'lease_gross' => 'decimal:2',
        'reserve_fee' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'bank_fee' => 'decimal:2',
        'warranty_amount' => 'decimal:2',
        'total_cash_received' => 'decimal:2',
        'total_sale_amount' => 'decimal:2',
        'lease_start' => 'date',
        'lease_end' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'delivered_date' => 'date',
        'sold_date' => 'date',
    ];

    /**
     * Get the deal that owns the payment.
     */
    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    /**
     * Scope to filter by payment type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('payment_type', $type);
    }

    /**
     * Check if payment is a lease.
     */
    public function isLease(): bool
    {
        return $this->payment_type === 'lease';
    }

    /**
     * Check if payment is financed.
     */
    public function isFinance(): bool
    {
        return $this->payment_type === 'finance';
    }

    /**
     * Check if payment is cash.
     */
    public function isCash(): bool
    {
        return $this->payment_type === 'cash';
    }

    /**
     * Calculate equivalent APR from money factor (lease).
     */
    public function getEquivalentAprAttribute(): ?float
    {
        if ($this->money_factor) {
            return $this->money_factor * 2400;
        }
        return null;
    }
}