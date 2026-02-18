<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreHours extends Model
{
    protected $table = 'store_hours';

    protected $fillable = [
        'hours',
        'show_hours',
        'holiday_overrides',
    ];

    protected $casts = [
        'hours' => 'array',
        'holiday_overrides' => 'array',
        'show_hours' => 'boolean',
    ];
}
