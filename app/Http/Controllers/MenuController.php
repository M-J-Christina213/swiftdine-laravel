<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function show($restaurantId)
{
    $restaurant = Restaurant::findOrFail($restaurantId);
    $menus = Menu::where('restaurant_id', $restaurantId)->get();

    $cartItems = [];
    if(auth()->check()) {
        $cartItems = \App\Models\Cart::with('menu')
                    ->where('user_id', auth()->id())
                    ->get();
    }

    return view('restaurants.menu', compact('restaurant', 'menus', 'cartItems'));
}



}
