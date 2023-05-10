<?php

namespace App\Services\Order;

class HasBatchesPriceType extends PriceType
{
     public function calculatePrice(): float
     {
         return $this->orderItem->product->price +
             $this->orderItem->product_batch->price;
     }

}
