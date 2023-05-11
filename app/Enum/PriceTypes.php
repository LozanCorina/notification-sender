<?php

namespace App\Enum;

use App\Models\OrderItem;
use App\Services\Order\HasBatchesPriceType;
use App\Services\Order\HasToppingPriceType;
use App\Services\Order\PriceType;
use App\Services\Order\StandardPriceType;

enum PriceTypes: string
{
    case Standard = 'standard';
    case HasBatches = 'has_batches';
    case HasToppings = 'has_toppings';

    public function create(OrderItem $item): PriceType
    {
        return match ($this) {
            self::Standard => new StandardPriceType($item),
            self::HasBatches => new HasBatchesPriceType($item),
            self::HasToppings => new HasToppingPriceType($item),
        };
    }
}

