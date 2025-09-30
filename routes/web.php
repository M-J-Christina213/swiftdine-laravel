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
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController; // admin

//Customers Routes

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static route first
Route::get('/restaurants/menus', [RestaurantController::class, 'browseMenus'])->name('restaurants.browseMenus');

//  restaurant routes
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurant/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Menu dynamic route
Route::get('/restaurant/{id}/menu', [MenuController::class, 'show'])->name('menus.show');
 

Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
// Cart
Route::get('/cart', [CartController::class, 'view'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/track', [OrderController::class, 'track'])->name('orders.track');

// Reservations
Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Deals
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

Route::get('/food-guide', [FoodGuideController::class, 'index'])->name('guide.index');

// Admin routes
Route::prefix('admin')->middleware(['auth','can:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'addUser'])->name('admin.users.add');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Restaurants
    Route::get('/restaurants', [AdminRestaurantController::class, 'index'])->name('admin.restaurants');
    Route::get('/restaurants/create', [AdminRestaurantController::class, 'create'])->name('admin.restaurants.create');
    Route::post('/restaurants', [AdminRestaurantController::class, 'store'])->name('admin.restaurants.store'); // <-- add store
    Route::get('/restaurants/{restaurant}/edit', [AdminRestaurantController::class, 'edit'])->name('admin.restaurants.edit');
    Route::put('/restaurants/{restaurant}', [AdminRestaurantController::class, 'update'])->name('admin.restaurants.update'); // <-- add update
    Route::delete('/restaurants/{restaurant}', [AdminRestaurantController::class, 'destroy'])->name('admin.restaurants.destroy');

    // Orders, discounts, reviews
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/discounts', [AdminController::class, 'discounts'])->name('admin.discounts');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
});

// Owner routes
Route::prefix('owner')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

    // Manage Restaurants
    Route::get('/restaurants', function () {
        return view('owner.restaurants.index');
    })->name('owner.restaurants');

    Route::get('/restaurants/create', function () {
        return view('owner.restaurants.create');
    })->name('owner.restaurants.create');

    Route::get('/restaurants/{restaurant}/edit', function ($restaurant) {
        return view('owner.restaurants.edit', compact('restaurant'));
    })->name('owner.restaurants.edit');

    // Manage Menus
    Route::get('/menus', function () {
        return view('owner.menus.index');
    })->name('owner.menus');

    Route::get('/menus/{menu}/edit', function ($menu) {
        return view('owner.menus.edit', compact('menu'));
    })->name('owner.menus.edit');

    // Manage Orders
    Route::get('/orders', function () {
        return view('owner.orders.index');
    })->name('owner.orders');

    // Manage Staff
    Route::get('/staff', function () {
        return view('owner.staff.index');
    })->name('owner.staff');

    // Manage Suppliers
    Route::get('/suppliers', function () {
        return view('owner.suppliers.index');
    })->name('owner.suppliers');
});

// Customer home
Route::get('/user/home', function () {
    return view('home');
})->name('user.home')->middleware('auth');

// Restaurant owner dashboard
Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
})->name('owner.dashboard')->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
