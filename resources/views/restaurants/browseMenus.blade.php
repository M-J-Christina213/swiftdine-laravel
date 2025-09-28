@extends('layouts.app') 

@section('content')
<div class="max-w-7xl mx-auto p-6 flex flex-col lg:flex-row gap-6">

    <!--  Sidebar Filters -->
    <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow-md p-4 space-y-6">
        <h2 class="text-xl font-bold">Advanced Filters</h2>
        {{-- Static filters can stay as is --}}
    </aside>

    <!-- Main Menu Grid -->
    <section class="w-full lg:w-3/4">
        <h1 class="text-3xl font-bold mb-6">Browse Our Menu</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menuItems as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('images/' . $item->image) }}" 
                         alt="{{ $item->name }}" 
                         class="w-full h-48 object-cover">

                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $item->name }}</h2>
                        <p class="text-gray-600 mb-4">LKR {{ number_format($item->price, 2) }}</p>
                        
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="item_name" value="{{ $item->name }}">
                            <input type="hidden" name="item_price" value="{{ $item->price }}">
                            <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded flex items-center justify-center hover:bg-orange-600 transition">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
