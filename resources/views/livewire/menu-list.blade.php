<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($menus as $menu)
        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-4 flex flex-col">
            <div class="relative">
                <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover rounded-lg">
                <span class="absolute top-2 right-2 bg-orange-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                    Rs {{ number_format($menu->price, 2) }}
                </span>
            </div>
            <div class="mt-4 flex flex-col flex-grow">
                <h3 class="text-lg font-semibold text-gray-800">{{ $menu->name }}</h3>
                <p class="text-gray-500 text-sm flex-grow">{{ $menu->description }}</p>
               <br>

               @auth
                    <!-- If user is logged in -->
                    <button wire:click="addToCart({{ $menu->id }})" class="bg-orange-500 text-white px-4 py-2 rounded justify-center">
                        Add to Cart 🛒
                    </button>
               @else
                    <!-- If user is not logged in -->
                    <button onclick="alert('You must be logged in to add items to the cart.')" 
                            class="bg-gray-400 cursor-not-allowed text-white px-4 py-2 rounded justify-center">
                        Add to Cart 🛒
                    </button>
               @endauth
            </div>
        </div>
    @empty
        <p class="text-gray-500">No menu items found.</p>
    @endforelse
</div>
