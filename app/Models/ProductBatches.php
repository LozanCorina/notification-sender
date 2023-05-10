<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBatches extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'price',
        'product_id',
    ];
}
