<!DOCTYPE html>
<html lang="en">
@livewireStyles

<head>
    <meta charset="UTF-8">
    <title>Full Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<!-- Banner Section -->
<div class="relative h-[350px]">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://media.cntravellerme.com/photos/66cc5cb74871ab67bc593f1b/16:9/w_2560%2Cc_limit/ShoulldersByHarpos3.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-10 text-center text-white">
        <h1 class="text-5xl font-extrabold mb-2">Where Flavor Meets Passion</h1>
        <p class="text-xl font-light italic">Delicious meals, made fresh for you</p>
    </div>
</div>

<!-- Nav & Checkout -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="{{ route('home') }}" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="{{ route('restaurants.index') }}" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
  </div>
  <a href="{{ route('cart.index') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    Proceed to Checkout →
  </a>
</div>

<!-- Step Progress -->
<div class="flex items-center justify-center mt-12 px-10">
    <div class="flex gap-6 items-center text-white">
        <!-- Steps 1-6 -->
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">Discover</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">View Restaurant</span>
        </div>
        <div class="w-16 h-1 bg-black"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">3</div>
            <span class="text-sm mt-1 text-black">Menu</span>
        </div>
        <div class="h-1 w-14 bg-black"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">4</div>
            <span class="text-sm mt-1 text-black">Cart</span>
        </div>
        <div class="h-1 w-14 bg-black"></div>
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

<!-- Main Container -->
<div class="flex flex-col lg:flex-row max-w-7xl mx-auto p-6 gap-6">

    <!-- Menu Items -->
    <div class="flex-1">
        <h1 class="text-4xl font-bold text-orange-600 mb-6">Full Menu</h1>
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
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center border rounded-lg">
                            <button wire:click="$emit('decreaseQty', {{ $menu->id }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                            <input type="text" value="1" class="w-12 text-center border-0" readonly>
                            <button wire:click="$emit('increaseQty', {{ $menu->id }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                        </div>
                        <button 
                        wire:click="$emitTo('cart', 'add', {{ $menu->id }})" 
                        class="bg-orange-500 text-white px-4 py-2 rounded">
                        Add to Cart
                    </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center p-10">
                <h2 class="text-2xl font-bold text-orange-600 mb-4">Oops! Nothing here yet 🍽️</h2>
                <p class="text-gray-500">Check back soon or explore other restaurants!</p>
                <a href="{{ route('restaurants.index') }}" class="mt-4 inline-block bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700">
                    Explore Restaurants
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Sidebar Cart -->
    <div id="cart-summary">
        @livewire('cart')

    </div>

</div>

@livewireScripts
</body>
</html>
