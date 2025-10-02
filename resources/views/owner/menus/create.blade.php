<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Menu Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-2xl mx-auto p-6 ml-64">
        <h1 class="text-3xl font-bold text-orange-600 mb-6">Add Menu Item</h1>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('owner.menus.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded p-6 space-y-4">
            @csrf

            <select name="restaurant_id" required class="w-full border border-gray-300 p-2 rounded">
                <option value="" disabled selected>Select Restaurant</option>
                @foreach($restaurants as $rest)
                    <option value="{{ $rest->id }}">{{ $rest->name }}</option>
                @endforeach
            </select>

            <select name="category_id" required class="w-full border border-gray-300 p-2 rounded">
                <option value="" disabled selected>Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <input type="text" name="name" placeholder="Food Name" required class="w-full border border-gray-300 p-2 rounded" />
            <textarea name="description" placeholder="Description" required class="w-full border border-gray-300 p-2 rounded" rows="3"></textarea>
            <input type="number" step="0.01" min="0" name="price" placeholder="Price (e.g. 9.99)" required class="w-full border border-gray-300 p-2 rounded" />
            
            <label class="block text-orange-600 font-medium">Upload Image</label>
            <input type="file" name="image_url" accept="image/*" class="w-full border border-gray-300 p-2 rounded cursor-pointer" />

            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition duration-300 ease-in-out transform hover:scale-105">Add Menu Item</button>
        </form>
    </div>
</body>
</html>
