<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpRestriction extends Model
{
    protected $table = 'ip_restrictions';

    protected $fillable = [
        'mode',
        'allowed_ips',
        'bypass_admin',
        'log_blocked',
    ];

    protected $casts = [
        'bypass_admin' => 'boolean',
        'log_blocked' => 'boolean',
    ];
}
