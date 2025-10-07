<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;


class RestaurantController extends Controller
{
    public function index()
{
    $restaurants = Restaurant::with('menus')->get();

    return response()->json($restaurants);
}

public function show($id)
{
    $restaurant = Restaurant::find($id);
    if (!$restaurant) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json($restaurant);
}


}
