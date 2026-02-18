<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CustomerReassignment extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'field',
        'previous_value',
        'new_value',
        'changed_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
