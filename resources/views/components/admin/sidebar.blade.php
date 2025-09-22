
<aside class="w-64 h-screen bg-orange-500 text-white shadow-md fixed top-0 left-0">
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-6">SwiftDine Admin</h2>
    <nav class="space-y-4 text-lg">
      <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Dashboard</a>
      <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Users</a>
      <a href="{{ route('admin.restaurants') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Restaurants</a>
      <a href="{{ route('admin.orders') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Orders</a>
      <a href="{{ route('admin.discounts') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Discounts</a>
      <a href="{{ route('admin.reviews') }}" class="block px-4 py-2 rounded hover:bg-orange-600">Manage Reviews</a>
      <form method="POST" action="{{ route('logout') }}" class="mt-10">
        @csrf
        <button type="submit" class="block w-full px-4 py-2 rounded bg-orange-600 hover:bg-orange-700">Logout</button>
      </form>
    </nav>
  </div>
</aside>


