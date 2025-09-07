

<header class="bg-white text-orange-600 shadow-md py-4 px-6 flex items-center justify-between">
  <!-- Left: Logo -->
  <div class="flex items-center space-x-4">
    <img src="{{ 'assets/images/swiftdine.jpg' }}" alt="Logo" class="h-32 md:h-24 max-w-full" />
  </div>

  <!-- Center: Navigation -->
  <nav class="hidden md:flex space-x-8 text-base font-semibold tracking-wide">
    <a href="{{ route('home') }}" class="hover:text-black">Home</a>
    <a href="{{ route('restaurants.index') }}" class="hover:text-black">Restaurants</a>
    <a href="{{ route('menus.index') }}" class="hover:text-black">Browse Menu</a>
    <a href="{{ route('guide.index') }}" class="hover:text-black">Food Guide</a>
    <a href="{{ route('deals.index') }}" class="hover:text-black">Special Offers</a>
    <a href="{{ route('orders.track') }}" class="hover:text-black">Track Order</a>
  </nav>

  <!-- Right: Buttons -->
 <div class="flex space-x-4">
  @auth
    <!-- Show Logout Button -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center space-x-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-lg">
          <span>Logout</span>
        </button>
      </form>
    @endauth
    
    @guest
    <!-- Show Login Button -->
    <a href="{{ route('login') }}" class="flex items-center space-x-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-lg">
        <span>Login</span>
      </a>
    @endguest

  <!-- Cart button always shown -->
    <a href="{{ route('cart.index') }}" class="flex items-center space-x-2 border border-orange-600 text-orange-600 hover:bg-orange-100 px-5 py-2 rounded-lg">
      <span>Cart</span>
    </a>
</div>
</header>
