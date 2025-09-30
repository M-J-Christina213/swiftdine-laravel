<x-owner.sidebar/>

<div class="flex-1 p-10 ml-64">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold">Manage Suppliers</h1>
        <a href="{{ route('owner.suppliers.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">+ Add Supplier</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto shadow-md rounded-lg border border-orange-200 bg-white">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Phone</th>
                    <th class="py-3 px-4">Address</th>
                    <th class="py-3 px-4">Created At</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($suppliers as $supplier)
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4">{{ $supplier->id }}</td>
                        <td class="py-3 px-4">{{ $supplier->name }}</td>
                        <td class="py-3 px-4">{{ $supplier->contact_email }}</td>
                        <td class="py-3 px-4">{{ $supplier->phone }}</td>
                        <td class="py-3 px-4">{{ $supplier->address }}</td>
                        <td class="py-3 px-4">{{ $supplier->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('owner.suppliers.edit', $supplier->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('owner.suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure to delete this supplier?')" class="text-red-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-4 text-center text-gray-500">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
