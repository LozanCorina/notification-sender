<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'api.auth'], function () {
    Route::post('/user', [UserController::class, 'store']);
    Route::post('/push-notification/{user}', [UserController::class, 'push'] );
    Route::post('/push-notifications', [UserController::class, 'pushMulticast'] );
    Route::post('/sms-notification/{user}', [UserController::class, 'sms'] );
    Route::post('/sms-notifications', [UserController::class, 'smsMulticast'] );
});

Route::get('/order/{order}', [OrderController::class, 'calculate'] );


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
