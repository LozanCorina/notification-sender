<?php

namespace App\Services\Order;

use App\Models\OrderItem;

abstract class PriceType
{
     public function __construct(protected readonly OrderItem $orderItem)
     {
     }

    abstract function calculatePrice(): float;

}
