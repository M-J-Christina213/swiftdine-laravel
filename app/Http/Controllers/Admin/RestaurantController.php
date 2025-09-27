<?php
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRestaurantController extends Controller
{
    public function index() {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create() {
        return view('admin.restaurants.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'owner_id' => 'required|exists:users,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'location', 'cuisine', 'rating', 'owner_id');

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('restaurants', 'public');
        }

        Restaurant::create($data);

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant added successfully.');
    }

    public function edit(Restaurant $restaurant) {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant) {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'owner_id' => 'required|exists:users,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'location', 'cuisine', 'rating', 'owner_id');

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update($data);

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant updated successfully.');
    }

    public function destroy(Restaurant $restaurant) {
        $restaurant->delete();
        return redirect()->route('admin.restaurants')->with('success', 'Restaurant deleted successfully.');
    }
}
