<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class OwnerMenusController extends Controller
{
    // Show all menus
    public function index()
    {
        $menus = Menu::with('restaurant')->orderByDesc('id')->get();
        $restaurants = Restaurant::all();

        return view('owner.menus.index', compact('menus', 'restaurants'));
    }

    // Show edit form
    public function edit(Menu $menu)
    {
        $restaurants = Restaurant::all();
        return view('owner.menus.edit', compact('menu', 'restaurants'));
    }

    // Store new menu item
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Menu::create([
            'restaurant_id' => $request->restaurant_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('owner.menus.index')->with('success', 'Menu item added successfully.');
    }

    // Update existing menu
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ]);

        $imagePath = $menu->image; // keep old image by default

        if ($request->hasFile('image')) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $menu->update([
            'restaurant_id' => $request->restaurant_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('owner.menus.index')->with('success', 'Menu item updated successfully.');
    }

    // Delete menu
    public function destroy(Menu $menu)
    {
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('owner.menus.index')->with('success', 'Menu item deleted successfully.');
    }
}
