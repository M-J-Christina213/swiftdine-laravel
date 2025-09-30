<x-owner.sidebar/>

<div class="max-w-xl mx-auto p-6 mt-10 bg-white rounded shadow ml-64">
    <h2 class="text-2xl font-bold text-orange-600 mb-6">Edit Restaurant</h2>

    <form method="POST" action="{{ route('owner.restaurants.update', $restaurant->id) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $restaurant->name }}" required class="w-full border px-4 py-2 rounded" placeholder="Restaurant Name">
        <input type="text" name="location" value="{{ $restaurant->location }}" required class="w-full border px-4 py-2 rounded" placeholder="Location">
        <input type="text" name="cuisine" value="{{ $restaurant->cuisine }}" required class="w-full border px-4 py-2 rounded" placeholder="Cuisine">
        <input type="number" name="rating" value="{{ $restaurant->rating }}" required min="1" max="5" step="0.1" class="w-full border px-4 py-2 rounded" placeholder="Rating">

        <div>
            <label class="block mb-1">Upload Image (or enter URL)</label>
            <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">
            <input type="text" name="image_url" value="{{ $restaurant->image_url }}" placeholder="Or paste image URL here" class="w-full border px-4 py-2 rounded mt-2">

            @if($restaurant->image_url)
                <img src="{{ asset('storage/' . $restaurant->image_url) }}" class="w-32 h-32 mt-2 object-cover rounded border">
            @endif
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">Update</button>
            <a href="{{ route('owner.restaurants.index') }}" class="text-orange-600 hover:underline mt-2">Cancel</a>
        </div>
    </form>
</div>
