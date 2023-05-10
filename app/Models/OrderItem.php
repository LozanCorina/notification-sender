<?php

namespace App\Models;

use App\Services\Factory\PriceType;
use App\Services\Factory\PriceTypes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_batch_id',
        'price'
    ];

    public function priceType(): Attribute
    {
        return new Attribute(
            get: fn () => PriceTypes::from(
                $this->product->price_type
            )->create($this),
        );

    }
}
