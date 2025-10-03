<form action="{{ route('order.confirmation') }}" method="POST">
    @csrf
    <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md mx-auto space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-3">Order Summary</h2>

    <!-- Cart Items -->
        <div class="space-y-4 max-h-80 overflow-y-auto">
            @forelse($cartItems as $item)
            <div class="flex items-center gap-4 p-3 bg-white rounded-2xl shadow hover:shadow-lg transition">
                
                <!-- Item Image -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $item->menu->image_url) }}" 
                        alt="{{ $item->menu->name }}" 
                        class="w-20 h-20 object-cover rounded-xl">
                </div>

                <!-- Item Details -->
                <div class="flex-1 flex flex-col justify-between">
                    <!-- Name & Quantity -->
                    <div class="flex items-center justify-between">
                        <h3 class="text-gray-800 font-semibold text-lg">{{ $item->menu->name }}</h3>
                        <span class="px-3 py-1 bg-gray-200 rounded-full text-sm font-medium">
                            x{{ $item->quantity }}
                        </span>
                    </div>

                    <!-- Price -->
                    <p class="text-gray-500 mt-1">
                        Rs {{ number_format($item->menu->price * $item->quantity, 2) }}
                    </p>
                </div>

            </div>
            @empty
            <p class="text-gray-400 text-center py-6">Your cart is empty 😔</p>
            @endforelse
        </div>

        <!-- Promo Code -->
        <div class="space-y-2">
            <label class="block text-gray-700 font-medium">Apply Promo Code:</label>
            <div class="flex gap-2 flex-wrap">
                @foreach($promoCodes as $code => $percent)
                <button 
                    wire:click="applyPromo('{{ $code }}')" 
                    class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm hover:bg-orange-200 transition">
                    {{ $code }} → {{ $percent*100 }}%
                </button>
                @endforeach
            </div>
            @if($appliedPromo)
            <p class="text-green-600 text-sm mt-1">✔ Promo applied: {{ $appliedPromo }} - 
                Rs {{ number_format($discount, 2) }} saved
            </p>
            @endif
        </div>

    <!-- Totals -->
        <div class="space-y-2 text-gray-700 border-t pt-4">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>Rs {{ number_format($this->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Discount</span>
                <span>- Rs {{ number_format($discount ?? ($appliedPromo ? $this->subtotal * $promoCodes[$appliedPromo] : 0), 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Delivery Fee</span>
                <span>Rs {{ number_format($deliveryFee ?? 300, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tax (10%)</span>
                <span>Rs {{ number_format($this->tax, 2) }}</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between font-bold text-lg text-gray-800">
                <span>Total</span>
                <span>Rs {{ number_format($this->total, 2) }}</span>
            </div>
        </div>


    <button type="submit" 
            class="w-full bg-orange-600 text-white py-3 rounded-2xl text-lg font-semibold hover:bg-orange-700 transition">
        Place Order Now
    </button>

</div>
</form>
