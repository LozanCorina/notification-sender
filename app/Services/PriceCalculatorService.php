<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class PriceCalculatorService
{
    public function calculatePrice(Order $order): float
    {
        return $order->items->reduce(function($sum, OrderItem $item) {
            return  $sum + $item->price_type->calculatePrice();
        }, 0);
    }
}
