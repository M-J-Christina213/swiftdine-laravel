<h2 class="text-2xl font-bold mb-4 text-orange-600">Order Summary</h2>

@if(count($cartItems) > 0)
    @foreach($cartItems as $item)
        <div class="flex justify-between mb-2 items-center">
            <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
            <div class="flex items-center gap-2">
                <button data-cart-id="{{ $item->id }}" class="cart-remove-btn text-red-500 hover:text-red-700">Remove</button>
                <span>Rs {{ number_format($item->menu->price * $item->quantity, 2) }}</span>
            </div>
        </div>
    @endforeach
    <hr class="my-2">
    <div class="flex justify-between font-bold">
        <span>Total</span>
        <span>Rs {{ number_format($cartItems->sum(fn($i) => $i->menu->price * $i->quantity), 2) }}</span>
    </div>
@else
    <p>Your cart is empty.</p>
@endif
