<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'inventory_id',
        'deal_number',
        'status',
        'lead_type',
        'inventory_type',
        'vehicle_description',
        'price',
        'down_payment',
        'trade_in_value',
        'sold_date',
        'delivery_date',
        'sales_person_id',
        'sales_manager_id',
        'finance_manager_id',
        'notes',
        'deal_type',
    ];

    protected $casts = [
        'sold_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    /**
     * Get the customer that owns the deal.
     */

    public function vehicle(){

        return $this->belongsTo(Inventory::class,'inventory_id');
    }

    public function serviceHistory(){

        return $this->hasMany(ServiceHistory::class,'deals_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the inventory/vehicle for this deal.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the sales person.
     */
    public function salesPerson()
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    /**
     * Get the sales manager.
     */
    public function salesManager()
    {
        return $this->belongsTo(User::class, 'sales_manager_id');
    }

    /**
     * Get the finance manager.
     */
    public function financeManager()
    {
        return $this->belongsTo(User::class, 'finance_manager_id');
    }

    /**
     * Get the trade-in record for this deal.
     */
    public function tradeIn()
    {
        return $this->hasOne(TradeIn::class, 'deal_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'deal_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'deal_id');
    }

    public function showroomVisits()
    {
        return $this->hasMany(ShowroomVisit::class, 'deal_id');
    }
}
