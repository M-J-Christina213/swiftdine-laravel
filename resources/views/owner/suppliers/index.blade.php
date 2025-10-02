<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Suppliers - SwiftDine Owner</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showEditForm(id) {
      document.getElementById('row_' + id).style.display = 'none';
      document.getElementById('edit_' + id).style.display = 'table-row';
    }

    function cancelEdit(id) {
      document.getElementById('edit_' + id).style.display = 'none';
      document.getElementById('row_' + id).style.display = 'table-row';
    }
  </script>
</head>
<body class="flex font-sans text-gray-900 min-h-screen">

  <!-- Main Content -->
  <main class="flex-1 bg-white p-10 ml-64 overflow-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Manage Suppliers</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
      <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    <!-- Add New Supplier Form -->
    <form method="POST" action="{{ route('owner.suppliers.store') }}" class="mb-6 bg-orange-50 p-4 rounded-lg shadow">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <input type="text" name="name" placeholder="Supplier Name" required class="border p-2 rounded" />
        <input type="email" name="contact_email" placeholder="Email" required class="border p-2 rounded" />
        <input type="text" name="phone" placeholder="Phone Number" required class="border p-2 rounded" />
        <input type="text" name="address" placeholder="Address" required class="border p-2 rounded" />
      </div>
      <button type="submit" class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Add Supplier</button>
    </form>

    <!-- Suppliers Table -->
    <table class="w-full text-left border border-orange-300 rounded-lg overflow-hidden">
      <thead class="bg-orange-100 text-orange-800 font-semibold">
        <tr>
          <th class="p-3 border-b border-orange-300">Name</th>
          <th class="p-3 border-b border-orange-300">Email</th>
          <th class="p-3 border-b border-orange-300">Phone</th>
          <th class="p-3 border-b border-orange-300">Address</th>
          <th class="p-3 border-b border-orange-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($suppliers as $supplier)
          <!-- Normal Row -->
          <tr id="row_{{ $supplier->id }}" class="hover:bg-orange-50">
            <td class="p-3 border-b">{{ $supplier->name }}</td>
            <td class="p-3 border-b">{{ $supplier->contact_email }}</td>
            <td class="p-3 border-b">{{ $supplier->phone }}</td>
            <td class="p-3 border-b">{{ $supplier->address }}</td>
            <td class="p-3 border-b space-x-2">
              <button onclick="showEditForm({{ $supplier->id }})" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
              <form method="POST" action="{{ route('owner.suppliers.destroy', $supplier) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this supplier?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
              </form>
            </td>
          </tr>

          <!-- Edit Row -->
          <tr id="edit_{{ $supplier->id }}" style="display:none;" class="bg-orange-50">
            <form method="POST" action="{{ route('owner.suppliers.update', $supplier) }}">
              @csrf
              @method('PUT')
              <td class="p-2 border-b"><input type="text" name="name" value="{{ $supplier->name }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="email" name="contact_email" value="{{ $supplier->contact_email }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="phone" value="{{ $supplier->phone }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="address" value="{{ $supplier->address }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b space-x-2">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Update</button>
                <button type="button" onclick="cancelEdit({{ $supplier->id }})" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancel</button>
              </td>
            </form>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>
