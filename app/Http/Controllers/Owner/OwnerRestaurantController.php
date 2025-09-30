<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class OwnerRestaurantController extends Controller
{
    // Show form to edit
    public function edit(Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== auth()->id()) {
            abort(403, 'You do not have permission to edit this restaurant.');
        }
        return view('owner.restaurants.edit', compact('restaurant'));
    }

    // Update restaurant
    public function update(Request $request, Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== auth()->id()) {
            abort(403, 'You do not have permission to update this restaurant.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'cuisine' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $restaurant->name = $request->name;
        $restaurant->location = $request->location;
        $restaurant->cuisine = $request->cuisine;
        $restaurant->rating = $request->rating;

        if ($request->hasFile('image')) {
            $restaurant->image_url = $request->file('image')->store('restaurants', 'public');
        } elseif ($request->image_url) {
            $restaurant->image_url = $request->image_url;
        }

        $restaurant->save();

        return redirect()->route('owner.restaurants.index')
                         ->with('success', 'Restaurant updated successfully!');
    }

    // Delete restaurant
    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->owner_id !== auth()->id()) {
            abort(403, 'You do not have permission to delete this restaurant.');
        }

        $restaurant->delete();

        return redirect()->route('owner.restaurants.index')
                         ->with('success', 'Restaurant deleted successfully!');
    }
}
