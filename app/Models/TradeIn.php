<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'customer_id',
        'vin',
        'year',
        'make',
        'model',
        'trim',
        'odometer',
        'condition_grade',
        'trade_allowance',
        'lien_payout',
        'acv',
        'market_value',
        'recon_estimate',
        'appraised_by',
        'appraisal_date',
        'photos',
        'video_walkaround',
        'notes',
    ];

    protected $casts = [
        'trade_allowance' => 'decimal:2',
        'lien_payout' => 'decimal:2',
        'acv' => 'decimal:2',
        'market_value' => 'decimal:2',
        'recon_estimate' => 'decimal:2',
        'appraisal_date' => 'datetime',
        'photos' => 'array',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function appraiser()
    {
        return $this->belongsTo(User::class, 'appraised_by');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->year} {$this->make} {$this->model} {$this->trim}");
    }

    public function getNetTradeValueAttribute()
    {
        return ($this->trade_allowance ?? 0) - ($this->lien_payout ?? 0);
    }
}