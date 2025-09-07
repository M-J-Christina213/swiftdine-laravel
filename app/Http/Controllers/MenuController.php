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

        return view('menus.show', compact('restaurant', 'menus'));

    }

    public function index()
    {
        // Fetch all menu items
    $menus = DB::table('menus')->get(); 
    
    return view('restaurants.menu', compact('menus'));
    }

}
