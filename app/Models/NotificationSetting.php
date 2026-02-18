<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $table = 'notification_settings';
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];
}
