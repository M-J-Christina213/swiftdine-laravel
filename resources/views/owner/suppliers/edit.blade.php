<x-owner.sidebar/>

<div class="max-w-xl mx-auto p-6 mt-10 bg-white rounded shadow ml-64">
    <h2 class="text-2xl font-bold text-orange-600 mb-6">Edit Supplier</h2>

    <form method="POST" action="{{ route('owner.suppliers.update', $supplier->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $supplier->name }}" required class="w-full border px-4 py-2 rounded" placeholder="Supplier Name">
        <input type="email" name="email" value="{{ $supplier->contact_email }}" required class="w-full border px-4 py-2 rounded" placeholder="Contact Email">
        <input type="text" name="phone" value="{{ $supplier->phone }}" required class="w-full border px-4 py-2 rounded" placeholder="Phone Number">
        <input type="text" name="address" value="{{ $supplier->address }}" required class="w-full border px-4 py-2 rounded" placeholder="Address">

        <div class="flex justify-between">
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">Update</button>
            <a href="{{ route('owner.suppliers.index') }}" class="text-orange-600 hover:underline mt-2">Cancel</a>
        </div>
    </form>
</div>
