
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Almost There Foodie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Banner -->
<section class="relative h-48 bg-gradient-to-r from-orange-500 to-yellow-400 flex flex-col justify-center items-center text-white">
    <h1 class="text-4xl font-extrabold mb-2">Almost There Foodie</h1>
    <p class="italic text-lg font-light">Ready for your delicious meal?</p>
</section>

<!-- Nav -->
<div class="flex justify-between items-center px-6 py-4">
    <div class="flex gap-3">
        <a href="{{ route('menus.index') }}" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">Cancel</a>
        <a href="{{ route('menus.index') }}" class="text-sm text-gray-600 hover:text-black flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg> Back
        </a>
    </div>
    <a href="{{ route('cart.checkout') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
        Proceed to Checkout →
    </a>
</div>

<!-- Step Progress -->
<div class="flex items-center justify-center mt-6 px-10">
    <div class="flex gap-6 items-center text-white">
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">Discover</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">View Restaurant</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">Menu</span>
        </div>
        <div class="h-1 w-14 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">4</div>
            <span class="text-sm mt-1 text-black">Cart</span>
        </div>
        <div class="h-1 w-14 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">5</div>
            <span class="text-sm mt-1 text-black">Checkout</span>
        </div>
        <div class="h-1 w-14 bg-black"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">6</div>
            <span class="text-sm mt-1 text-black">Confirmation</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="flex flex-col lg:flex-row max-w-7xl mx-auto px-6 gap-8 pb-12 flex-grow">

    <!-- Cart Items -->
    <div class="flex-1 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Your Cart ({{ $cartItems->count() }} items)</h2>

        <div id="cart-items" class="space-y-6">
            @forelse($cartItems as $item)
                <div class="flex items-center gap-4 border-b pb-4" data-id="{{ $item->id }}">
                    <img src="{{ asset('storage/'.$item->menu->image_url) }}" alt="{{ $item->menu->name }}" class="w-24 h-24 object-cover rounded-md shadow" />

                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">{{ $item->menu->name }}</h3>
                        <p class="text-sm text-gray-500">Prep time: {{ $item->menu->prep_time ?? '15 mins' }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $item->menu->description }}</p>
                    </div>

                    <!-- Quantity controls -->
                    <div class="flex flex-col items-end gap-2">
                        <div class="flex items-center gap-1">
                            <button class="qty-btn bg-gray-200 hover:bg-gray-300 rounded px-2 py-1" data-action="decrease">-</button>
                            <span class="quantity w-6 text-center">{{ $item->quantity }}</span>
                            <button class="qty-btn bg-gray-200 hover:bg-gray-300 rounded px-2 py-1" data-action="increase">+</button>
                        </div>
                        <button class="text-red-500 hover:text-red-700 remove-btn text-sm mt-1">Remove</button>
                        <span class="font-bold text-orange-600">Rs <span class="item-total">{{ number_format($item->menu->price * $item->quantity,2) }}</span></span>
                    </div>
                </div>
            @empty
                <p>Your cart is empty.</p>
            @endforelse
        </div>

        <!-- Add Note -->
        <div class="mt-4">
            <label for="order_note" class="block font-semibold mb-1">Add Note / Special Instructions</label>
            <textarea id="order_note" name="order_note" rows="3" class="w-full border rounded p-2 resize-none" placeholder="E.g. No onions, extra spicy..."></textarea>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <aside class="w-full lg:w-96 bg-white rounded-lg shadow p-6 flex flex-col gap-6 sticky top-6 self-start">

        <h2 class="text-2xl font-bold border-b pb-3">Order Summary</h2>

        <div id="sidebar-summary" class="space-y-2">
            <!-- AJAX loaded summary -->
            @include('cart.summary')
        </div>

        <a href="{{ route('cart.checkout') }}" class="block bg-orange-600 hover:bg-orange-700 text-white text-center py-3 rounded font-semibold mt-6 transition">Proceed to Checkout</a>

    </aside>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    async function updateCart(itemId, action) {
        await fetch('/cart/update', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ id: itemId, action: action })
        });
        await refreshCart();
    }

    async function removeItem(itemId) {
        await fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        await refreshCart();
    }

    async function refreshCart() {
        // Refresh sidebar
        const summary = await fetch('/cart/summary');
        const html = await summary.text();
        document.getElementById('sidebar-summary').innerHTML = html;

        // Refresh main cart quantities
        const cartItemsContainer = document.getElementById('cart-items');
        const response = await fetch('/cart/summary');
        const parser = new DOMParser();
        const doc = parser.parseFromString(await response.text(), 'text/html');
        const items = doc.querySelectorAll('[data-id]');
        items.forEach(newItem => {
            const id = newItem.dataset.id;
            const existing = cartItemsContainer.querySelector(`[data-id="${id}"]`);
            if(existing) {
                const qty = newItem.querySelector('.quantity').innerText;
                const total = newItem.querySelector('.item-total').innerText;
                existing.querySelector('.quantity').innerText = qty;
                existing.querySelector('.item-total').innerText = total;
            }
        });
    }

    document.addEventListener('click', (e) => {
        const parent = e.target.closest('[data-id]');
        if(!parent) return;
        const itemId = parent.dataset.id;

        // Quantity buttons
        if(e.target.classList.contains('qty-btn')) {
            const action = e.target.dataset.action;
            updateCart(itemId, action);
        }

        // Remove button
        if(e.target.classList.contains('remove-btn')) {
            removeItem(itemId);
        }
    });
</script>

</body>
</html>
