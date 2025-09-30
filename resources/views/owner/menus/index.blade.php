<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Menus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-7xl mx-auto p-6 ml-64">
        <h1 class="text-3xl font-bold text-orange-600 mb-6">Manage Menus</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Menu Item Form -->
        <form method="POST" action="{{ route('owner.menus.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded p-6 mb-6 max-w-xl space-y-4">
            @csrf
            <h2 class="text-xl font-semibold text-orange-600">Add Menu Item</h2>
            
            <select name="restaurant_id" required class="w-full border border-gray-300 p-2 rounded">
                <option value="" disabled selected>Select Restaurant</option>
                @foreach($restaurants as $rest)
                    <option value="{{ $rest->id }}">{{ $rest->name }}</option>
                @endforeach
            </select>

            <input type="text" name="name" placeholder="Food Name" required class="w-full border border-gray-300 p-2 rounded" />
            <textarea name="description" placeholder="Description" required class="w-full border border-gray-300 p-2 rounded" rows="3"></textarea>
            <input type="number" step="0.01" min="0" name="price" placeholder="Price (e.g. 9.99)" required class="w-full border border-gray-300 p-2 rounded" />
            
            <label class="block text-orange-600 font-medium">Upload Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 p-2 rounded cursor-pointer" />

            <label class="block text-orange-600 font-medium">Or Enter Image URL</label>
            <input type="text" name="image_url" placeholder="https://example.com/image.jpg" class="w-full border border-gray-300 p-2 rounded" />

            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition duration-300 ease-in-out transform hover:scale-105">Add Menu Item</button>
        </form>

        <!-- Menu Items Table -->
        <div class="overflow-x-auto shadow-md rounded-lg border border-orange-200 bg-white">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Image</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($menus as $menu)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4 align-middle">{{ $menu->id }}</td>
                        <td class="py-3 px-4 align-middle">
                            @if($menu->image)
                                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-16 h-16 rounded object-cover border border-orange-300 shadow" />
                            @else
                                <div class="w-16 h-16 flex items-center justify-center bg-orange-200 text-orange-600 rounded">
                                    No Img
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4 align-middle">{{ $menu->name }}</td>
                        <td class="py-3 px-4 align-middle">{{ $menu->description }}</td>
                        <td class="py-3 px-4 align-middle">{{ number_format($menu->price, 2) }}</td>
                        <td class="py-3 px-4 align-middle space-x-4">
                            <a href="{{ route('owner.menus.edit', $menu) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('owner.menus.destroy', $menu) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this menu item?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
