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
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;

// Default user route (keep it)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/categories/name/{name}', [CategoryController::class, 'getByName']);



Route::middleware('auth:sanctum')->group(function () {
    // Fetch menus by restaurant
    Route::get('/restaurants/{id}/menu', [MenuController::class, 'show']);

    // Fetch menus by category
    Route::get('/categories/{id}/menus', [MenuController::class, 'getByCategory']);
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::get('/restaurants', [RestaurantController::class, 'index']);
// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::get('/restaurants/{id}/menu', [MenuController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'view']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update', [CartController::class, 'update']);
    Route::delete('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/checkout', [OrderController::class, 'store']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);

    // Reservations
    Route::post('/reservations', [ReservationController::class, 'store']);

    // Deals
    Route::get('/deals', [DealController::class, 'index']);
});
