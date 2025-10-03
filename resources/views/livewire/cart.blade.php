<div class="bg-gray-50 p-4 rounded-xl shadow-lg max-w-md mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Cart</h2>

    <div class="space-y-4">
        @forelse($cartItems as $item)
        <div class="relative bg-white rounded-xl shadow p-3 flex flex-col md:flex-row items-center gap-3 hover:shadow-md transition">

            <!-- Image -->
            <img src="{{ asset('storage/' . $item->menu->image_url) }}" 
                 alt="{{ $item->menu->name }}" class="w-24 h-24 rounded-lg object-cover flex-shrink-0">

            <!-- Name on top -->
            <div class="flex-1 flex flex-col justify-between w-full gap-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $item->menu->name }}</h3>

                <!-- Quantity controls and price -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button wire:click="decrement({{ $item->id }})" 
                                class="px-3 py-1 text-gray-600 bg-gray-100 rounded hover:bg-gray-200">-</button>
                        <span class="px-4 py-1 border rounded text-gray-700">{{ $item->quantity }}</span>
                        <button wire:click="increment({{ $item->id }})" 
                                class="px-3 py-1 text-gray-600 bg-gray-100 rounded hover:bg-gray-200">+</button>
                    </div>

                    <!-- Price -->
                    <div class="text-gray-800 font-semibold text-right w-24">
                        Rs {{ number_format($item->menu->price * $item->quantity,2) }}
                    </div>
                </div>
            </div>

            <!-- Delete button (trash icon) -->
            <button wire:click="remove({{ $item->id }})" 
                    class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" 
                          d="M6 2a1 1 0 00-1 1v1H3a1 1 0 100 2h1v10a2 2 0 002 2h6a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm2 5a1 1 0 012 0v7a1 1 0 11-2 0V7zm4 0a1 1 0 10-2 0v7a1 1 0 102 0V7z" 
                          clip-rule="evenodd" />
                </svg>
            </button>

        </div>
        @empty
        <p class="text-gray-500 text-center py-4">Your cart is empty.</p>
        @endforelse
    </div>

    @if($cartItems->count() > 0)
    <div class="mt-6 border-t pt-4 flex flex-col md:flex-row justify-between items-center">
        <span class="text-lg font-semibold text-gray-700">Total:</span>
        <span class="text-lg font-bold text-gray-900 mt-2 md:mt-0">
            Rs {{ number_format($cartItems->sum(fn($i) => $i->menu->price * $i->quantity),2) }}
        </span>
        <a href="{{ route('cart.index') }}" 
           class="mt-4 md:mt-0 md:ml-4 block text-center bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-700 transition">
           Proceed to Checkout
        </a>
    </div>
    @endif
</div>
