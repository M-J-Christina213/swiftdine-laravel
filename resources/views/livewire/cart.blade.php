<div class="space-y-2">
    @forelse($cartItems as $item)
        <div class="flex justify-between items-center p-2 bg-white rounded shadow">
            <span>{{ $item->menu->name }} x {{ $item->quantity }}</span>
            <span>Rs {{ number_format($item->menu->price * $item->quantity,2) }}</span>
            <button wire:click="remove({{ $item->id }})" class="text-red-500">&times;</button>
        </div>
    @empty
        <p class="text-gray-500">Your cart is empty.</p>
    @endforelse
</div>
