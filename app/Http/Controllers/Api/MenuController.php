<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function show($id)
{
    $restaurant = Restaurant::with('menuItems')->findOrFail($id);
    return response()->json($restaurant->menuItems);
}

public function getByCategory($id)
    {
        // Fetch menus where category_id = $id
        $menus = Menu::where('category_id', $id)->get();

        return response()->json($menus);
    }

}
