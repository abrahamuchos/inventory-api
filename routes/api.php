<?php

use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1/'], function () {

    /* Public Routes */
    Route::get('item/{item:sku}', [ItemController::class, 'show']);
    Route::get('item', [ItemController::class, 'index']);

    /* Private Routes */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/item', [ItemController::class, 'store']);
        Route::patch('item/{item}', [ItemController::class, 'update']);
        Route::delete('item/{item}', [ItemController::class, 'destroy']);
    });

});

