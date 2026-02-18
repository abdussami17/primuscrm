<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlagDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'label', 'input_type', 'options', 'order', 'active'
    ];

    protected $casts = [
        'options' => 'array',
        'active' => 'boolean'
    ];
}
