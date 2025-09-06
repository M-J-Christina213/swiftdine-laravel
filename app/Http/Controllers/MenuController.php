<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;

class MenuController extends Controller
{
    public function show($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $menus = Menu::where('restaurant_id', $restaurantId)->get();

        return view('menus.show', compact('restaurant', 'menus'));
    }
}
