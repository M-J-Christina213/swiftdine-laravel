<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function show($id)
{
    $restaurant = Restaurant::with('menuItems')->findOrFail($id);
    return response()->json($restaurant->menuItems);
}

}
