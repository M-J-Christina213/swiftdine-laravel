<h2 class="text-2xl font-bold mb-4 text-orange-600">Order Summary</h2>

@if(count($cartItems) > 0)
    @foreach($cartItems as $item)
        <div class="flex justify-between mb-2">
            <span>{{ $item->name }} x{{ $item->quantity }}</span>
            <span>Rs {{ number_format($item->price * $item->quantity, 2) }}</span>
        </div>
    @endforeach
    <hr class="my-2">
    <div class="flex justify-between font-bold">
        <span>Total</span>
        <span>Rs {{ number_format($cartItems->sum(fn($i)=>$i->price*$i->quantity), 2) }}</span>
    </div>
@else
    <p>Your cart is empty.</p>
@endif
