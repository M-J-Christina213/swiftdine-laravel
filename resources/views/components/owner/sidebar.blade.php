<aside class="w-64 h-screen bg-orange-500 text-white shadow-md fixed top-0 left-0">
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-6">SwiftDine Owner</h2>
    <nav class="space-y-4">
      <a href="{{ route('owner.dashboard') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Dashboard</a>
      <a href="{{ route('owner.restaurants.index') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Restaurant</a>
      <a href="{{ route('owner.menus') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Menus</a>
      <a href="{{ route('owner.orders') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Orders</a>
      <a href="{{ route('owner.staff') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Staff</a>
      <a href="{{ route('owner.suppliers') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Suppliers</a>
      <form method="POST" action="{{ route('logout') }}" class="mt-10">
        @csrf
        <button type="submit" class="block w-full px-4 py-2 rounded bg-orange-600 hover:bg-orange-700">Logout</button>
      </form>
    </nav>
  </div>
</aside>
