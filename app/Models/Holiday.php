<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'is_closed',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date' => 'date',
        'is_closed' => 'boolean',
    ];
}
