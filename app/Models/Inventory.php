<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    
    protected $fillable = [
        'vin',
        'stock_number',
        'year',
        'make',
        'model',
        'trim',
        'body_type',
        'exterior_color',
        'interior_color',
        'condition',
        'mileage',
        'price',
        'msrp',
        'sale_price',
        'cost',
        'status',
        'description',
        'features',
        'images',
        'engine',
        'transmission',
        'drivetrain',
        'fuel_type',
        'provider_id',
        'external_id',
        'last_synced_at',
        'location',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'msrp' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'last_synced_at' => 'datetime',
    ];

    /**
     * Get all deals for this inventory item
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Price history entries for this inventory item.
     */
    public function priceHistory()
    {
        return $this->hasMany(InventoryPriceHistory::class, 'inventory_id');
    }

    /**
     * Customers who have expressed interest in this inventory item.
     * Assumes a pivot table named `customer_inventory` with optional pivot columns like `hold_date`.
     */
    public function interestedCustomers()
    {
        // Return customers via deals (Inventory -> Deal -> Customer)
        return $this->hasManyThrough(
            Customer::class,
            Deal::class,
            'inventory_id', // Foreign key on deals table
            'id',            // Foreign key on customers table (primary key)
            'id',            // Local key on inventory table
            'customer_id'    // Local key on deals table
        );
    }

    /**
     * Scope to get only available inventory
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope to get inventory by condition
     */
    public function scopeCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    /**
     * Get full vehicle name
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->year} {$this->make} {$this->model} {$this->trim}");
    }
}
