<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Menu; 

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        $menus = Menu::latest()->take(10)->get(); 

        return view('restaurants.index', compact('restaurants', 'menus'));
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.show', compact('restaurant'));
    }

   // Browse all menu items
    public function browseMenus()
    {
        $menuItems = Menu::all(); // Fetch all menu items
        return view('restaurants.browseMenus', compact('menuItems'));
    }
}
