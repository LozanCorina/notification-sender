<?php

namespace App\Factory;



use App\Models\OrderItem;
use App\Services\Order\HasBatchesPriceType;
use App\Services\Order\HasToppingPriceType;
use App\Services\Order\PriceType;
use App\Services\Order\StandardPriceType;

class PriceTypeFactory
{

    public function create(OrderItem $orderItem): PriceType
    {
        switch ($orderItem->product->type)
        {
            case 'standard':
                return new StandardPriceType($orderItem);

            case 'has_batches':
                return new HasBatchesPriceType($orderItem);

            case 'has_toppings':
                return new HasToppingPriceType($orderItem);
        }

    }

}
