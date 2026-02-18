<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHistory extends Model
{
    use HasFactory;

    protected $table = 'service_history';

    protected $fillable = [
        'inventory_id',
        'deals_id',
        'customer_id',
        'service_date',
        'service_type',
        'description',
        'mileage',
        'cost',
        'advisor_id',
        'advisor_name',
        'technician',
        'parts_used',
        'labor_hours',
        'notes',
        'ro_number',
    ];

    protected $casts = [
        'service_date' => 'date',
        'cost' => 'decimal:2',
        'parts_used' => 'array',
        'labor_hours' => 'decimal:2',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
}