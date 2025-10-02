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

        <!-- Add Menu Button -->
        <a href="{{ route('owner.menus.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition duration-300 ease-in-out">Add New Menu Item</a>

        <!-- Menu Items Table -->
        <div class="overflow-x-auto shadow-md rounded-lg border border-orange-200 bg-white mt-6">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Category</th>
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
                        <td class="py-3 px-4">{{ $menu->id }}</td>
                        <td class="py-3 px-4">{{ $menu->category->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="Current Image" class="w-20 h-20 object-cover border rounded" />
                            @else
                                <div class="w-16 h-16 flex items-center justify-center bg-orange-200 text-orange-600 rounded">No Img</div>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $menu->name }}</td>
                        <td class="py-3 px-4">{{ $menu->description }}</td>
                        <td class="py-3 px-4">{{ number_format($menu->price, 2) }}</td>
                        <td class="py-3 px-4 space-x-4">
                            <a href="{{ route('owner.menus.edit', $menu) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('owner.menus.destroy', $menu) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline">Delete</button>
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
