<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AddressController;

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::get('{id}', [CustomerController::class, 'show']);
    Route::put('{id}', [CustomerController::class, 'update']);
    Route::delete('{id}', [CustomerController::class, 'destroy']);

    Route::prefix('{customer_id}/addresses')->group(function () {
        Route::get('/', [AddressController::class, 'index']);
        Route::post('/', [AddressController::class, 'store']);
        Route::get('{id}', [AddressController::class, 'show']);
        Route::put('{id}', [AddressController::class, 'update']);
        Route::delete('{id}', [AddressController::class, 'destroy']);
    });
});
