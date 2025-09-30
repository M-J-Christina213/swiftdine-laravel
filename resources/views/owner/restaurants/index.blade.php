<x-owner.sidebar/>

<div class="max-w-6xl mx-auto p-6 ml-64">
    <h2 class="text-3xl font-bold text-orange-600 mb-6">My Restaurants</h2>

    <a href="{{ route('owner.restaurants.create') }}" class="mb-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded">
        + Add New Restaurant
    </a>

    <div class="overflow-x-auto mt-4 shadow-md rounded-lg border border-orange-200 bg-white">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Image</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Location</th>
                    <th class="py-3 px-4">Cuisine</th>
                    <th class="py-3 px-4">Rating</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($restaurants as $restaurant)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4">{{ $restaurant->id }}</td>
                        <td class="py-3 px-4">
                            @if($restaurant->image_url)
                                <img src="{{ asset('storage/' . $restaurant->image_url) }}" alt="{{ $restaurant->name }}" class="w-16 h-16 rounded object-cover border border-orange-300 shadow" />
                            @else
                                <div class="w-16 h-16 flex items-center justify-center bg-orange-200 text-orange-600 rounded">No Img</div>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $restaurant->name }}</td>
                        <td class="py-3 px-4">{{ $restaurant->location }}</td>
                        <td class="py-3 px-4">{{ $restaurant->cuisine }}</td>
                        <td class="py-3 px-4">{{ $restaurant->rating }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('owner.restaurants.edit', $restaurant->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('owner.restaurants.destroy', $restaurant->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this restaurant?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-4 text-center text-gray-500">No restaurants found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
