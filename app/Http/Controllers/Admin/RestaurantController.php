<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // Show all restaurants
    public function index()
    {
        $restaurants = Restaurant::orderBy('id', 'asc')->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    // Show form to create a restaurant
    public function create()
    {
        return view('admin.restaurants.create');
    }

    // Store new restaurant
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'owner_id' => 'required|exists:users,id',
        ]);

        Restaurant::create($request->all());

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant added successfully.');
    }

    // Show edit form
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    // Update restaurant
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'owner_id' => 'required|exists:users,id',
        ]);

        $restaurant->update($request->all());

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant updated successfully.');
    }

    // Delete restaurant
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant deleted successfully.');
    }
}
