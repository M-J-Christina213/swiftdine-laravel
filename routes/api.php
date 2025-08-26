<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\DealController;

// Default user route (keep it)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurants/{id}/menu', [MenuController::class, 'show']);
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'view']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update', [CartController::class, 'update']);
    Route::delete('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [OrderController::class, 'store']);

    // Reservations
    Route::post('/reservations', [ReservationController::class, 'store']);

    // Deals
    Route::get('/deals', [DealController::class, 'index']);
});
