<?php

namespace App\Services\Order;

use App\Models\Topping;

class HasToppingPriceType extends PriceType
{
    public function calculatePrice(): float
    {
        $toppingsSum = $this->orderItem->toppings
            ->reduce(function (float $sum, Topping $topping) {
                return $sum + $topping->price;
            }, 0);

        return $this->orderItem->product->price + $toppingsSum;
    }
}
