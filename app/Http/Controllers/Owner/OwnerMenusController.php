<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class OwnerMenusController extends Controller
{
    // Show all menus
    public function index()
    {
        $menus = Menu::with(['restaurant', 'category'])->orderBy('id')->get();
        return view('owner.menus.index', compact('menus'));
    }

    // Show create form
    public function create()
    {
        $restaurants = Restaurant::where('owner_id', auth()->id())->get();
        $categories = Category::all(); // fetch categories
        return view('owner.menus.create', compact('restaurants', 'categories'));
    }

    // Store new menu item
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id' => 'required|exists:categories,id', // category required
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'restaurant_id' => $request->restaurant_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('owner.menus.index')->with('success', 'Menu item added successfully.');
    }

    // Show edit form
    public function edit(Menu $menu)
    {
        $restaurants = Restaurant::where('owner_id', auth()->id())->get();
        $categories = Category::all();
        return view('owner.menus.edit', compact('menu', 'restaurants', 'categories'));
    }

   
     // Update existing menu
public function update(Request $request, Menu $menu)
{
    $validated = $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id',
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    if ($request->hasFile('image_url')) {
        // delete old image if exists
        if ($menu->image_url && \Storage::disk('public')->exists($menu->image_url)) {
            \Storage::disk('public')->delete($menu->image_url);
        }

        // store new image
        $path = $request->file('image_url')->store('menus', 'public');
        $validated['image_url'] = $path;
    }

    $menu->update($validated);

    return redirect()->route('owner.menus.index')->with('success', 'Menu updated successfully!');
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
