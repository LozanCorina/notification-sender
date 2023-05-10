<?php

namespace App\Models;

use App\Factory\PriceTypeFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_batch_id',
        'price'
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function toppings(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'order_item_toppings');
    }
    public function product_batch(): BelongsTo
    {
        return $this->belongsTo(ProductBatches::class);
    }

    public function priceType(): Attribute
    {
        return new Attribute(
            get: fn () => (new PriceTypeFactory())
                ->create($this),
        );
    }
}
