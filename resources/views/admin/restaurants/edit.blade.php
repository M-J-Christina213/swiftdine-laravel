<x-admin.sidebar />

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Restaurant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10 ml-64">

<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-orange-600">✏️ Edit Restaurant</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($restaurant) && is_object($restaurant))
        <form action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ old('name', $restaurant->name) }}" required class="w-full border px-4 py-2 rounded">
            <input type="text" name="location" value="{{ old('location', $restaurant->location) }}" required class="w-full border px-4 py-2 rounded">
            <input type="text" name="cuisine" value="{{ old('cuisine', $restaurant->cuisine) }}" required class="w-full border px-4 py-2 rounded">
            <input type="number" name="rating" value="{{ old('rating', $restaurant->rating) }}" min="1" max="5" step="0.1" required class="w-full border px-4 py-2 rounded">
            <input type="number" name="owner_id" value="{{ old('owner_id', $restaurant->owner_id) }}" required class="w-full border px-4 py-2 rounded">

            {{-- Current Image --}}
            <div>
                <label class="block mb-1 font-medium">Current Image</label>
                @if($restaurant->image_path && file_exists(storage_path('app/public/' . $restaurant->image_path)))
                    <img src="{{ asset('storage/' . $restaurant->image_path) }}" alt="Restaurant Image" class="w-32 h-32 object-cover rounded mb-2">
                @else
                    <span class="text-gray-400 italic">No image uploaded</span>
                @endif
            </div>

            {{-- Upload New Image --}}
            <div>
                <label class="block mb-1 font-medium">Change Image (optional)</label>
                <input type="file" name="image" class="w-full border px-4 py-2 rounded">
            </div>

            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Update Restaurant</button>
        </form>
    @else
        <p class="text-red-500 font-medium">❌ Restaurant not found.</p>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mt-4 text-red-500">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</body>
</html>
