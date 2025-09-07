<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('restaurants.index', compact('restaurants'));
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.show', compact('restaurant'));
    }

    public function browseMenus()
    {
        return view('restaurants.browse-menus');
    }
}
