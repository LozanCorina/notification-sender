<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PriceCalculatorService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function calculate(Order $order, PriceCalculatorService $orderService)
    {
        $price = $orderService->calculatePrice($order);

        return response()->json([
            'status' => 'success',
            'price' => $price
        ]);
    }
}
