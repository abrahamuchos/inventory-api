<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1/'], function () {

    /* Public Routes */
    //User
    Route::post('register', [UserController::class, 'store']);
    Route::post('login', [AuthController::class, 'login']);

    //Item
    Route::get('item/{item:sku}', [ItemController::class, 'show']);
    Route::get('item', [ItemController::class, 'index']);

    /* Private Routes */
    Route::middleware('auth:sanctum')->group(function () {
        /*Item*/
        Route::post('/item', [ItemController::class, 'store']);
        Route::patch('/item/{item}', [ItemController::class, 'update']);
        Route::put('/item/{item}', [ItemController::class, 'update']);
        Route::delete('item/{item}', [ItemController::class, 'destroy']);

        /*Stock*/
        Route::post('/stock/{item:sku}', [StockController::class, 'store']);
        Route::get('/stock/{item:sku}', [StockController::class, 'show']);

        /*User*/
        Route::get('logout', [AuthController::class, 'logout']);

    });


});

