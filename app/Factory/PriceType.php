<?php

namespace App\Factory;


use App\Models\OrderItem;
use App\Services\Order\HasBatchesPriceType;
use App\Services\Order\HasToppingPriceType;
use App\Services\Order\PriceType;
use App\Services\Order\StandardPriceType;

class PriceTypeFactory
{
    public function create(OrderItem $item): PriceType
    {
        return match ($item->product->type) {
            'standard' => new StandardPriceType($item->product),
            'has_batches' => new HasBatchesPriceType($item->product),
            'has_toppings' => new HasToppingPriceType($item->product),
        };
    }

}
