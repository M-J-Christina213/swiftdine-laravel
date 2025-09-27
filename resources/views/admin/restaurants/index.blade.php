<x-admin.sidebar />

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Restaurants - SwiftDine</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

  <main class="flex-1 p-10 ml-64 bg-white overflow-x-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Manage Restaurants</h1>
      <a href="{{ route('admin.restaurants.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">➕ Add Restaurant</a>
    </div>

    @if(session('success'))
      <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Image</th>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Location</th>
          <th class="px-4 py-3">Cuisine</th>
          <th class="px-4 py-3">Rating</th>
          <th class="px-4 py-3">Owner</th>
          <th class="px-4 py-3">Created At</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        @foreach($restaurants as $restaurant)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3">{{ $restaurant->id }}</td>
            <td class="px-4 py-3">
              @if(!empty($restaurant->image_url))
                <img src="{{ $restaurant->image_url }}" class="w-16 h-16 rounded object-cover">
              @else
                <span class="text-gray-400 italic">No image</span>
              @endif
            </td>
            <td class="px-4 py-3">{{ $restaurant->name }}</td>
            <td class="px-4 py-3">{{ $restaurant->location }}</td>
            <td class="px-4 py-3">{{ $restaurant->cuisine }}</td>
            <td class="px-4 py-3">{{ $restaurant->rating }}</td>
            <td class="px-4 py-3">{{ $restaurant->owner?->name ?? 'N/A' }}</td>
            <td class="px-4 py-3">{{ $restaurant->created_at?->format('Y-m-d') }}</td>
            <td class="px-4 py-4 flex items-center gap-2">
              <!-- Edit Button -->
              <a href="{{ route('admin.restaurants.edit', $restaurant->id) }}" class="text-blue-500 hover:underline inline">Edit</a>

              <!-- Delete Form -->
              <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this restaurant?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline inline">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>
