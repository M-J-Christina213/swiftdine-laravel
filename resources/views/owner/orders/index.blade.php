<x-owner.sidebar/>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="flex-1 bg-white p-10 ml-64 overflow-auto">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold">Manage Orders</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300 rounded-lg overflow-hidden text-left">
        <thead class="bg-orange-100 text-orange-800 font-semibold">
            <tr>
                <th class="p-3 border-b border-orange-300">Order ID</th>
                <th class="p-3 border-b border-orange-300">User</th>
                <th class="p-3 border-b border-orange-300">Restaurant</th>
                <th class="p-3 border-b border-orange-300">Total Price ($)</th>
                <th class="p-3 border-b border-orange-300">Status</th>
                <th class="p-3 border-b border-orange-300">Created At</th>
                <th class="p-3 border-b border-orange-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr id="display_row_{{ $order->id }}" class="hover:bg-orange-50">
                <td class="p-3 border-b border-gray-200">{{ $order->id }}</td>
                <td class="p-3 border-b border-gray-200">{{ $order->user->name ?? 'Unknown' }}</td>
                <td class="p-3 border-b border-gray-200">{{ $order->restaurant->name ?? 'Unknown' }}</td>
                <td class="p-3 border-b border-gray-200">{{ number_format($order->total_price, 2) }}</td>
                <td class="p-3 border-b border-gray-200">
                    <span class="{{ $order->status == 'completed' ? 'text-green-600 font-semibold' : ($order->status == 'pending' ? 'text-yellow-600 font-semibold' : 'text-gray-600') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="p-3 border-b border-gray-200">{{ $order->created_at }}</td>
                <td class="p-3 border-b border-gray-200 space-x-2">
                    <button onclick="showEditForm({{ $order->id }})" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                    <form method="POST" action="{{ route('owner.orders.destroy', $order->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this order?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit row -->
            <tr id="edit_row_{{ $order->id }}" style="display:none;" class="bg-orange-50">
                <form method="POST" action="{{ route('owner.orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <td class="p-3 border-b border-gray-200">{{ $order->id }}</td>
                    <td class="p-3 border-b border-gray-200">{{ $order->user->name ?? 'Unknown' }}</td>
                    <td class="p-3 border-b border-gray-200">{{ $order->restaurant->name ?? 'Unknown' }}</td>
                    <td class="p-3 border-b border-gray-200">{{ number_format($order->total_price, 2) }}</td>
                    <td class="p-3 border-b border-gray-200">
                        <select name="status" class="border rounded px-2 py-1 w-full">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </td>
                    <td class="p-3 border-b border-gray-200">{{ $order->created_at }}</td>
                    <td class="p-3 border-b border-gray-200 space-x-2">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
                        <button type="button" onclick="cancelEdit({{ $order->id }})" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 ml-2">Cancel</button>
                    </td>
                </form>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-4 text-center text-gray-500">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function showEditForm(id) {
    document.getElementById('display_row_' + id).style.display = 'none';
    document.getElementById('edit_row_' + id).style.display = 'table-row';
}

function cancelEdit(id) {
    document.getElementById('edit_row_' + id).style.display = 'none';
    document.getElementById('display_row_' + id).style.display = 'table-row';
}
</script>
