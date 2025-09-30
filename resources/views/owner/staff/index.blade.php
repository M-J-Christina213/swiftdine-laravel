<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Staff - SwiftDine Owner</title>
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
      <h1 class="text-3xl font-bold text-orange-600">Manage Staff</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
      <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    <!-- Add New Staff Form -->
    <form method="POST" action="{{ route('owner.staff.store') }}" class="mb-6 bg-orange-50 p-4 rounded-lg shadow">
      @csrf
      <div class="grid grid-cols-2 gap-4">
        <input type="text" name="name" placeholder="Full Name" required class="border p-2 rounded" />
        <input type="email" name="email" placeholder="Email" required class="border p-2 rounded" />
        <input type="text" name="role" placeholder="Role (e.g. Chef)" required class="border p-2 rounded" />
        <input type="text" name="phone" placeholder="Phone Number" class="border p-2 rounded" />
      </div>
      <button type="submit" class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Add Staff</button>
    </form>

    <!-- Staff Table -->
    <table class="w-full text-left border border-orange-300 rounded-lg overflow-hidden">
      <thead class="bg-orange-100 text-orange-800 font-semibold">
        <tr>
          <th class="p-3 border-b border-orange-300">Name</th>
          <th class="p-3 border-b border-orange-300">Email</th>
          <th class="p-3 border-b border-orange-300">Role</th>
          <th class="p-3 border-b border-orange-300">Phone</th>
          <th class="p-3 border-b border-orange-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($staff as $member)
          <!-- Normal Row -->
          <tr id="row_{{ $member->id }}" class="hover:bg-orange-50">
            <td class="p-3 border-b">{{ $member->name }}</td>
            <td class="p-3 border-b">{{ $member->email }}</td>
            <td class="p-3 border-b">{{ $member->role }}</td>
            <td class="p-3 border-b">{{ $member->phone }}</td>
            <td class="p-3 border-b space-x-2">
              <button onclick="showEditForm({{ $member->id }})" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
              <form method="POST" action="{{ route('owner.staff.destroy', $member) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this staff member?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
              </form>
            </td>
          </tr>

          <!-- Edit Row -->
          <tr id="edit_{{ $member->id }}" style="display:none;" class="bg-orange-50">
            <form method="POST" action="{{ route('owner.staff.update', $member) }}">
              @csrf
              @method('PUT')
              <td class="p-2 border-b"><input type="text" name="name" value="{{ $member->name }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="email" name="email" value="{{ $member->email }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="role" value="{{ $member->role }}" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="phone" value="{{ $member->phone }}" class="border p-1 w-full rounded"></td>
              <td class="p-2 border-b space-x-2">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Update</button>
                <button type="button" onclick="cancelEdit({{ $member->id }})" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancel</button>
              </td>
            </form>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>
