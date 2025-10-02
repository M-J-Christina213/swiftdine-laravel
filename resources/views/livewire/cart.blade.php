<div>
    @if($cartItems->isEmpty())
        <div class="text-center p-6">
            <p class="text-gray-500">Your cart is empty </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($cartItems as $item)
                <div class="flex items-center bg-white rounded-xl shadow p-3">
                    <img src="{{ asset('storage/' . $item->menu->image_url) }}" 
                         alt="{{ $item->menu->name }}" 
                         class="w-20 h-20 object-cover rounded-lg">
                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-gray-800">{{ $item->menu->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $item->menu->description }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <!-- Quantity Controls -->
                            <button wire:click="decreaseQuantity({{ $item->id }})"
                                    class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                            <span class="font-bold">{{ $item->quantity }}</span>
                            <button wire:click="increaseQuantity({{ $item->id }})"
                                    class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <p class="font-bold text-orange-600">Rs {{ number_format($item->menu->price * $item->quantity, 2) }}</p>
                        <button wire:click="remove({{ $item->id }})"
                                class="text-red-500 text-sm mt-1 hover:underline">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="mt-6 border-t pt-4 space-y-2">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Subtotal:</span>
                <span class="font-bold text-gray-900">Rs {{ number_format($cartItems->sum(fn($i)=>$i->menu->price * $i->quantity), 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Tax (10%):</span>
                <span class="font-bold text-gray-900">Rs {{ number_format($cartItems->sum(fn($i)=>$i->menu->price * $i->quantity)*0.1, 2) }}</span>
            </div>
            <div class="flex justify-between border-t pt-2 font-bold text-orange-600 text-lg">
                <span>Total:</span>
                <span>Rs {{ number_format($cartItems->sum(fn($i)=>$i->menu->price * $i->quantity)*1.1, 2) }}</span>
            </div>

            <a href="{{ route('cart.index') }}" 
               class="block w-full text-center bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 mt-4">
               Checkout
            </a>
        </div>
    @endif
</div>
