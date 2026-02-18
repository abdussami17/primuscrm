<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecuritySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_password_length',
        'require_uppercase',
        'require_numbers',
        'require_special',
        'password_expiry_days',
        'password_history',
        'require_2fa',
        'preferred_2fa_method',
        'remember_device_days',
        'session_timeout_minutes',
    ];

    protected $casts = [
        'require_uppercase' => 'boolean',
        'require_numbers' => 'boolean',
        'require_special' => 'boolean',
        'require_2fa' => 'boolean',
    ];
}
