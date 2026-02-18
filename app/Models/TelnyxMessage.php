<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelnyxMessage extends Model
{
    use HasFactory;

    protected $table = 'telnyx_messages';

    protected $fillable = [
        'telnyx_id', 'direction', 'type', 'from', 'to', 'body', 'status', 'raw'
    ];

    protected $casts = [
        'raw' => 'array'
    ];
}
