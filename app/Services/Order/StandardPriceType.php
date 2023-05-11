<?php

namespace App\Services\Order;

class StandardPriceType extends PriceType
{
     public function calculatePrice(): float
     {
         return $this->orderItem->product->price;
     }
}
