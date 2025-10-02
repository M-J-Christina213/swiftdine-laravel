{{-- cart/summary.blade.php --}}

@php
    $subtotal = 0;
@endphp

@if($cartItems->isEmpty())
    <p class="text-gray-500">Your cart is empty.</p>
@else
    <div class="space-y-4">
        @foreach($cartItems as $item)
            @php $itemTotal = $item->menu->price * $item->quantity; $subtotal += $itemTotal; @endphp
            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="font-semibold">{{ $item->menu->name }} x {{ $item->quantity }}</span>
                    <span class="text-sm text-gray-500">Rs {{ number_format($itemTotal, 2) }}</span>
                </div>
            </div>
        @endforeach

        <div class="border-t pt-2 mt-2">
            <div class="flex justify-between font-bold text-orange-600">
                <span>Subtotal</span>
                <span>Rs {{ number_format($subtotal, 2) }}</span>
            </div>
        </div>

       

        <div class="flex justify-between font-bold text-black mt-2">
            <span>Total</span>
            <span>Rs {{ number_format($total, 2) }}</span>
        </div>
    </div>
@endif
