<x-owner.sidebar/>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> Restaurants </title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg ml-64 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-orange-600"> + Add New Restaurant</h1>

    <form action="{{ route('owner.restaurants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Restaurant Name" required class="w-full border px-4 py-2 rounded">
        <input type="text" name="location" placeholder="Location" required class="w-full border px-4 py-2 rounded">
        <input type="text" name="cuisine" placeholder="Cuisine" required class="w-full border px-4 py-2 rounded">
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" step="0.1" required class="w-full border px-4 py-2 rounded">
        
        <div>
            <label class="block mb-1">Upload Image </label>
            <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">
            
        </div>

        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Add Restaurant</button>
    </form>
</div>
