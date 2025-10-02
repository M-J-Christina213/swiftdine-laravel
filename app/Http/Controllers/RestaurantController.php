<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Menu; 
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


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

    public function menu($restaurantId)
    {
        $menus = Menu::where('restaurant_id', $restaurantId)->get();

        // Get cart items for the logged-in user
        $cartItems = Cart::with('menu')->where('user_id', Auth::id())->get();

        // Pass both $menus and $cartItems to the view
        return view('restaurants.menu', compact('menus', 'cartItems'));
    }
}
