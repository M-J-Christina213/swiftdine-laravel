<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Menu Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="max-w-2xl mx-auto p-6 ml-64">
    <h1 class="text-3xl font-bold text-orange-600 mb-6">Edit Menu Item</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('owner.menus.update', $menu->id) }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        @method('PUT')

        <select name="restaurant_id" required class="w-full border border-gray-300 p-2 rounded">
            <option value="" disabled>Select Restaurant</option>
            @foreach($restaurants as $rest)
                <option value="{{ $rest->id }}" {{ $rest->id == $menu->restaurant_id ? 'selected' : '' }}>
                    {{ $rest->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="name" value="{{ old('name', $menu->name) }}" required class="w-full border border-gray-300 p-2 rounded" />
        <textarea name="description" required class="w-full border border-gray-300 p-2 rounded" rows="3">{{ old('description', $menu->description) }}</textarea>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $menu->price) }}" required class="w-full border border-gray-300 p-2 rounded" />

        <label class="block text-orange-600 font-medium">Upload New Image </label>
        <input type="file" name="image_url" accept="image/*" class="w-full border border-gray-300 p-2 rounded" />

        <div class="flex items-center space-x-4 mt-4">
            @if($menu->image_url)
                <img src="{{ asset('storage/' . $menu->image_url) }}" 
                    alt="Current Image" 
                    class="w-20 h-20 object-cover border rounded" />
            @else
                <span>No image available</span>
            @endif
        </div>


        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition transform hover:scale-105">
            Update Menu
        </button>
    </form>
</div>
