@extends('layouts.app') 

@section('content')
<div class="max-w-7xl mx-auto p-6 flex flex-col lg:flex-row gap-6">

    <!-- Sidebar Static Categories -->
    <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow-md p-4 space-y-6">
    <h2 class="text-xl font-bold mb-4">Categories</h2>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('restaurants.browseMenus', ['category' => 'all']) }}" 
               class="block px-3 py-2 rounded hover:bg-orange-100 transition">
                All
            </a>
        </li>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('restaurants.browseMenus', ['category' => $category->id]) }}" 
                   class="block px-3 py-2 rounded hover:bg-orange-100 transition">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</aside>


    <!-- Main Menu Grid -->
    <section class="w-full lg:w-3/4">
        <h1 class="text-3xl font-bold mb-6">Browse Our Menu</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ Storage::url($item->image_url) }}" 
                    alt="{{ $item->name }}" 
                    class="w-full h-48 object-cover">

                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $item->name }}</h2>
                    <p class="text-gray-600 mb-2">LKR {{ number_format($item->price, 2) }}</p>
                    <p class="text-gray-500 text-sm">{{ $item->description }}</p>
                </div>
            </div>
        @endforeach


        </div>
    </section>

</div>
@endsection
