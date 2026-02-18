<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryPriceHistory extends Model
{
    use HasFactory;

    protected $table = 'inventory_price_history';

    protected $fillable = [
        'inventory_id',
        'user_id',
        'price',
        'internet_price',
        'note',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'internet_price' => 'decimal:2',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
