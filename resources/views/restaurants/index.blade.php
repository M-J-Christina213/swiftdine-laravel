@extends('layouts.app')

@section('content')

  <!-- Hero Banner -->
  <section class="relative bg-cover bg-center h-screen" 
    style="background-image: url('https://miro.medium.com/v2/resize:fit:1400/0*OuSIEprF8jIzBc4g');">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-12 lg:px-24 flex flex-col justify-center h-full text-center text-white">
      <h1 class="text-4xl sm:text-6xl font-extrabold drop-shadow-lg mb-4">
        Craving Something Delicious?
      </h1>
      <p class="text-lg sm:text-xl mb-12 drop-shadow-md max-w-xl mx-auto">
        From breakfast to dinner, discover your perfect meal, anytime, anywhere.
      </p>

      <!-- Meal Category Selector -->
      <div class="flex justify-center space-x-4 mb-12 overflow-x-auto no-scrollbar">
        @php
          $meals = [
            ['icon' => '☀️', 'label' => 'Breakfast'],
            ['icon' => '🍳', 'label' => 'Brunch'],
            ['icon' => '🍛', 'label' => 'Lunch'],
            ['icon' => '🍝', 'label' => 'Dinner'],
          ];
        @endphp

        @foreach ($meals as $meal)
          <button class="flex items-center space-x-2 bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full py-2 px-5 text-white font-semibold transition cursor-pointer whitespace-nowrap">
            <span class="text-xl">{{ $meal['icon'] }}</span>
            <span>{{ $meal['label'] }}</span>
          </button>
        @endforeach
      </div>

      <!-- Interaction Mode Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-4xl mx-auto">
        @php
          $modes = [
            ['icon' => '🪑', 'title' => 'Dine-In', 'desc' => 'Reserve a table in advance', 'btn' => 'Reserve Now'],
            ['icon' => '🛵', 'title' => 'Delivery', 'desc' => 'Food at your door', 'btn' => 'Order Delivery'],
            ['icon' => '🥡', 'title' => 'Takeaway', 'desc' => 'Pick up and go', 'btn' => 'Order Takeaway'],
          ];
        @endphp

        @foreach ($modes as $mode)
          <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 flex flex-col items-center text-center text-white hover:scale-105 transition-transform cursor-pointer shadow-lg">
            <div class="text-6xl mb-4">{{ $mode['icon'] }}</div>
            <h3 class="text-2xl font-bold mb-2">{{ $mode['title'] }}</h3>
            <p class="mb-6">{{ $mode['desc'] }}</p>
            <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-full transition">
              {{ $mode['btn'] }}
            </button>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Restaurants Section -->
  <section class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-24 py-16">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Where Would You Like to Eat?</h2>
    <p class="text-gray-600 mb-8">Search, browse, or explore popular picks</p>

    <div id="restaurantCards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach ($restaurants as $res)
        <div class="bg-white rounded-lg shadow-md p-5 flex flex-col">
          <img src="{{ $res->image_path ? Storage::url($res->image_path) : asset('images/restaurants/r1.jpg') }}" alt="Restaurant Image">


          <h3 class="text-xl font-bold mb-1">{{ $res->name }}</h3>
          <p class="text-sm text-gray-600 mb-1">{{ $res->location }}</p>
          <p class="text-sm text-gray-600 mb-2 italic">{{ $res->cuisine }}</p>
          <p class="mb-4 font-semibold text-orange-600">⭐ {{ number_format($res->rating, 1) }}</p>

          <div class="mt-auto flex space-x-3">
            <a href="{{ url('menu/'.$res->id) }}" 
              class="flex-grow text-center bg-orange-500 hover:bg-orange-600 text-white rounded-full py-2 font-semibold transition">
              View Menu
            </a>
            <a href="{{ url('restaurant/'.$res->id) }}" 
              class="flex-grow text-center border border-orange-500 hover:bg-orange-500 hover:text-white rounded-full py-2 font-semibold transition">
              View Restaurant
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- Menu Highlights -->
  <section class="py-12 px-6 max-w-full mx-auto bg-orange-500 shadow-lg">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-white drop-shadow-md">Menu Highlights</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach ($menus->take(4) as $menu)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
          <img src="{{ filter_var($menu->image, FILTER_VALIDATE_URL) ? $menu->image : asset('images/'.$menu->image) }}"
            alt="{{ $menu->name }}" class="w-full h-48 object-cover" />

          <div class="p-4">
            <div class="flex justify-between items-center mb-2">
              <h3 class="text-lg font-semibold">{{ $menu->name }}</h3>
              <span class="text-green-600 font-bold">LKR {{ number_format($menu->price, 2) }}</span>
            </div>
            <p class="text-gray-600 text-sm mb-3">{{ $menu->description }}</p>
            <div class="flex flex-wrap gap-2 mb-4 text-sm">
              @foreach (explode(',', $menu->tags) as $tag)
                @if (strtolower(trim($tag)) == 'vegetarian')
                  <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">🥦 Vegetarian</span>
                @elseif (strtolower(trim($tag)) == 'spicy')
                  <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full">🌶️ Spicy</span>
                @elseif (strtolower(trim($tag)) == 'gluten-free')
                  <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">🌾 Gluten-Free</span>
                @elseif (strtolower(trim($tag)) == 'gluten')
                  <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full">🌾 Contains Gluten</span>
                @endif
              @endforeach
            </div>
            <button class="w-full bg-black text-orange-500 font-semibold text-lg tracking-wide uppercase py-3 rounded-lg shadow-md hover:bg-gray-900 hover:shadow-lg transition duration-300">
              Add to Order
            </button>
          </div>
        </div>
      @endforeach
    </div>
  </section>

@endsection
