<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topping extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    public function order_item(): belongsToMany
    {
        return $this->belongsToMany(OrderItem::class, 'order_item_toppings');
    }
}
