<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'template_id', 'template_name', 'sender_type', 'sender', 'backup_sender', 'language',
        'subject', 'body', 'start_at', 'end_at', 'set_type', 'drip_initial_count', 'drip_days',
        'recipients', 'recipients_count', 'status', 'created_by'
    ];

    protected $casts = [
        'recipients' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'drip_initial_count' => 'integer',
        'drip_days' => 'integer',
        'recipients_count' => 'integer'
    ];
}
