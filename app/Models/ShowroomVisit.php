<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'deal_id',
        'user_id',
        'start_time',
        'end_time',
        'duration',
        'notes',
        'status',
        // visit flags
        'demo',
        'write_up',
        'touch_desk',
        'pending_fi',
        'trade_appraisal',
        'sold',
        'lost',
        // dynamic flags JSON
        'flags',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'demo' => 'boolean',
        'write_up' => 'boolean',
        'touch_desk' => 'boolean',
        'pending_fi' => 'boolean',
        'trade_appraisal' => 'boolean',
        'sold' => 'boolean',
        'lost' => 'boolean',
        'flags' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) return '00:00:00';
        
        $h = floor($this->duration / 3600);
        $m = floor(($this->duration % 3600) / 60);
        $s = $this->duration % 60;
        
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}