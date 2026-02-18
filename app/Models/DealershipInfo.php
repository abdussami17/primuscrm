<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealershipInfo extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'language',
        'timezone',
        'address',
        'website',
        'tax_id',
        'license_number',
    ];
}
