<x-admin.sidebar />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage Users - SwiftDine Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hover styling for links */
        .action-link {
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .action-link:hover {
            color: #fb923c; /* orange-400 */
            text-decoration: underline;
        }
    </style>
</head>
<body class="flex bg-gray-50 min-h-screen font-sans">

<main class="flex-1 p-10 ml-64 bg-white shadow-lg rounded-lg mx-6 my-6">
    <h1 class="text-3xl font-bold text-orange-600 mb-6">Manage Users</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <button id="add_user_btn" onclick="showAddForm()" class="mb-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        + Add New User
    </button>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden">
        <thead class="bg-orange-100">
            <tr>
                <th class="p-3 border-b">ID</th>
                <th class="p-3 border-b">Name</th>
                <th class="p-3 border-b">Email</th>
                <th class="p-3 border-b">Role</th>
                <th class="p-3 border-b">Created At</th>
                <th class="p-3 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Add User Form -->
            <tr id="add_user_form" style="display:none;" class="bg-green-50">
                <form method="POST" action="{{ route('admin.users.add') }}">
                    @csrf
                    <td>New</td>
                    <td><input type="text" name="name" required placeholder="Name" class="border rounded px-2 py-1 w-full" /></td>
                    <td><input type="email" name="email" required placeholder="Email" class="border rounded px-2 py-1 w-full" /></td>
                    <td>
                        <select name="role" required class="border rounded px-2 py-1 w-full">
                            <option value="" disabled selected>Select Role</option>
                            <option value="customer">Customer</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td>--</td>
                    <td class="flex gap-2">
                        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Add</button>
                        <button type="button" onclick="cancelAdd()" class="bg-gray-400 text-white px-4 py-1 rounded hover:bg-gray-500">Cancel</button>
                    </td>
                </form>
            </tr>

            <!-- Users -->
            @foreach($users as $user)
                <tr id="display_row_{{ $user->id }}" class="border-b hover:bg-orange-50 transition-colors">
                    <td class="p-2">{{ $user->id }}</td>
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 capitalize">{{ $user->role }}</td>
                    <td class="p-2">{{ $user->created_at }}</td>
                    <td class="p-2 flex gap-4">
                        <span class="action-link" onclick="showEditForm({{ $user->id }})">Edit</span>
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline bg-transparent border-0">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Row -->
                <tr id="edit_row_{{ $user->id }}" class="border-b bg-orange-50" style="display: none;">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <td class="p-2">{{ $user->id }}</td>
                        <td class="p-2"><input type="text" name="name" value="{{ $user->name }}" class="border rounded px-2 py-1 w-full" required></td>
                        <td class="p-2"><input type="email" name="email" value="{{ $user->email }}" class="border rounded px-2 py-1 w-full" required></td>
                        <td class="p-2">
                            <select name="role" class="border rounded px-2 py-1 w-full" required>
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="restaurant" {{ $user->role === 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </td>
                        <td class="p-2">{{ $user->created_at }}</td>
                        <td class="p-2 flex gap-2">
                            <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Update</button>
                            <button type="button" onclick="cancelEdit({{ $user->id }})" class="bg-gray-400 text-white px-4 py-1 rounded hover:bg-gray-500">Cancel</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>

<script>
    function showEditForm(id) {
        document.getElementById('display_row_' + id).style.display = 'none';
        document.getElementById('edit_row_' + id).style.display = 'table-row';
    }
    function cancelEdit(id) {
        document.getElementById('edit_row_' + id).style.display = 'none';
        document.getElementById('display_row_' + id).style.display = 'table-row';
    }
    function showAddForm() {
        document.getElementById('add_user_form').style.display = 'table-row';
        document.getElementById('add_user_btn').style.display = 'none';
    }
    function cancelAdd() {
        document.getElementById('add_user_form').style.display = 'none';
        document.getElementById('add_user_btn').style.display = 'inline-block';
    }
</script>

</body>
</html>
