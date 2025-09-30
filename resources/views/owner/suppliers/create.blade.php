<x-owner.sidebar/>

<div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg ml-64 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-orange-600">➕ Add New Supplier</h1>

    <form action="{{ route('owner.suppliers.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Supplier Name" required class="w-full border px-4 py-2 rounded">
        <input type="email" name="email" placeholder="Contact Email" required class="w-full border px-4 py-2 rounded">
        <input type="text" name="phone" placeholder="Phone Number" required class="w-full border px-4 py-2 rounded">
        <input type="text" name="address" placeholder="Address" required class="w-full border px-4 py-2 rounded">

        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Add Supplier</button>
    </form>
</div>
