<x-admin.sidebar />

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Restaurant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10 ml-64">

  <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-orange-600">➕ Add New Restaurant</h1>

    <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <input type="text" name="name" placeholder="Restaurant Name" value="{{ old('name') }}" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="location" placeholder="Location" value="{{ old('location') }}" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="cuisine" placeholder="Cuisine" value="{{ old('cuisine') }}" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="rating" placeholder="Rating (1-5)" value="{{ old('rating') }}" min="1" max="5" step="0.1" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="owner_id" placeholder="Owner ID" value="{{ old('owner_id') }}" required class="w-full border px-4 py-2 rounded">

      <div>
        <label class="block mb-1">Upload Image</label>
        <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">
      </div>

      <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Add Restaurant</button>
    </form>

    @if ($errors->any())
      <div class="mt-4 text-red-500">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
</body>
</html>
