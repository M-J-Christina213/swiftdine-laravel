<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\FoodGuideController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Restaurants
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Menus
Route::get('/restaurants/{id}/menu', [MenuController::class, 'show'])->name('menus.show');
Route::get('/restaurants/menus', [RestaurantController::class, 'browseMenus'])
    ->name('menus.browse');

Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
// Cart
Route::get('/cart', [CartController::class, 'view'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

// Reservations
Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Deals
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

Route::get('/food-guide', [FoodGuideController::class, 'index'])->name('guide.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
