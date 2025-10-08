@section('content')
@include('components.header')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

<div class="max-w-4xl mx-auto p-6">

  <!-- Title and Tabs -->
  <h1 class="text-3xl font-bold mb-6">My Orders</h1>

  <div class="flex space-x-4 mb-10 border-b-2 border-gray-300">
    <button class="pb-2 border-b-4 border-orange-500 text-orange-600 font-semibold">Delivery</button>
    <button class="pb-2 text-gray-600 hover:text-orange-500">Dine-in</button>
    <button class="pb-2 text-gray-600 hover:text-orange-500">Takeaway</button>
  </div>

  @php
      $order = $latestOrder ?? null;
  @endphp

  @if($order)
  <!-- Active Order Section -->
  <section class="mb-16">
    <h2 class="text-xl font-semibold mb-4">Active Order</h2>

    <!-- Google Map -->
    <div class="mb-6 rounded-lg overflow-hidden shadow">
      <iframe 
        class="w-full h-48" 
        src="https://maps.google.com/maps?q={{ urlencode($order->restaurant_name ?? 'Restaurant') }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
        allowfullscreen 
        loading="lazy"
      ></iframe>
    </div>

    <!-- Timeline and Status -->
    <div class="flex items-center mb-8">
      <!-- Left - Order status -->
      <div class="w-1/4 text-gray-600 font-semibold">Order Status</div>
      <!-- Right - On the way with timeline -->
      <div class="flex-1 relative flex items-center space-x-4">

        <!-- Circles and connecting bars -->
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-orange-500 border-2 border-white"></div>
          <span class="text-sm mt-2">Confirmed</span>
        </div>
        <div class="flex-1 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-orange-500 border-2 border-white"></div>
          <span class="text-sm mt-2">Preparing</span>
        </div>
        <div class="flex-1 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-yellow-400 border-2 border-white"></div>
          <span class="text-sm mt-2">Out for delivery</span>
        </div>
        <div class="flex-1 h-1 bg-orange-300"></div>
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-gray-400 border-2 border-white"></div>
          <span class="text-sm mt-2">Delivered</span>
        </div>
      </div>
    </div>

    <div class="text-right mb-8 text-orange-500 font-semibold">On the way</div>

    <!-- Driver Details -->
    <div class="flex items-center justify-between mb-10 bg-white p-4 rounded-lg shadow">
      <div class="flex items-center space-x-4">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Driver" class="w-16 h-16 rounded-full object-cover" />
        <div>
          <p class="font-semibold">Michael Rodriguez</p>
          <p class="text-sm text-gray-600">Toyota Corolla - GHI-789</p>
        </div>
      </div>
      <div class="flex space-x-6">
        <button aria-label="Call driver" class="text-orange-500 hover:text-orange-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2l3 7-3 7H3l3-7-3-7z"/></svg>
        </button>
        <button aria-label="Message driver" class="text-orange-500 hover:text-orange-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </button>
      </div>
    </div>

    <!-- Restaurant Info -->
    <div class="flex justify-between items-center mb-6">
      <div class="text-lg font-semibold">{{ $order->restaurant_name ?? 'Restaurant' }}</div>
      <button class="text-orange-500 font-semibold hover:underline">Contact</button>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <ul class="divide-y divide-gray-200">
        @foreach($order->items as $item)
        <li class="flex justify-between py-3">
          <span>{{ $item->quantity }}x {{ $item->name }}</span>
          <span>Rs {{ $item->price * $item->quantity }}</span>
        </li>
        @endforeach
      </ul>
    </div>

    <!-- Price Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 space-y-2 text-gray-700">
      <div class="flex justify-between font-semibold">
        <span>Subtotal</span>
        <span>Rs {{ $order->subtotal }}</span>
      </div>
      <div class="flex justify-between">
        <span>Delivery Fee</span>
        <span>Rs {{ $order->delivery_fee }}</span>
      </div>
      <div class="flex justify-between">
        <span>Tax</span>
        <span>Rs {{ $order->tax }}</span>
      </div>
      <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2">
        <span>Total</span>
        <span>Rs {{ $order->total }}</span>
      </div>
    </div>

    <!-- Payment Info -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
      <div class="text-orange-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="2" y="7" width="20" height="10" rx="2" ry="2"/>
          <line x1="2" y1="11" x2="22" y2="11" />
        </svg>
      </div>
      <div class="font-semibold text-lg">
        @if($order->payment_method === 'card')
          **** {{ substr($order->card_number ?? '4242424242424242', -4) }}
        @else
          {{ ucfirst($order->payment_method) }}
        @endif
      </div>
    </div>
  </section>
  @else
  <p class="text-center text-gray-500">No active orders to track.</p>
  @endif

  <!-- Past Orders Section -->
  <section>
    <!-- ... keep your existing past orders HTML as is ... -->
  </section>

</div>

<!-- Bottom Call to Action -->
<div class="fixed bottom-0 left-0 w-full bg-gradient-to-r from-orange-600 via-orange-500 to-orange-400 text-white p-4 flex justify-between items-center">
  <div>
    <p class="font-semibold">You've ordered from Marine Grill 5 times!</p>
    <p class="text-sm mt-1">Would you like to add to favourites for faster order?</p>
  </div>
  <div class="flex space-x-4">
    <button class="bg-white text-orange-500 font-semibold px-4 py-2 rounded hover:bg-orange-100 transition">Add to Favourites</button>
    <button class="bg-transparent border border-white px-4 py-2 rounded hover:bg-white hover:text-orange-500 transition">No Thanks</button>
  </div>
</div>

</body>
</html>

@include('components.footer')
