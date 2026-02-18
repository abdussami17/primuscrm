<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAccount extends Model
{
    protected $table = 'email_accounts';

    protected $fillable = [
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_enc', 'smtp_from', 'data'
    ];

    protected $casts = [
        'data' => 'array',
        'smtp_port' => 'integer'
    ];
}
