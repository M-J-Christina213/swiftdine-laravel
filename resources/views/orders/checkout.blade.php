@extends('layouts.app')

@section('content')

<div class="bg-gray-50 text-gray-800">

    <!-- Banner -->
    <div class="relative h-[400px]">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://i.pinimg.com/736x/1c/a7/c7/1ca7c798e8da4d18b7676e6786a55b00.jpg');">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-10 text-center text-white">
            <h1 class="text-5xl font-extrabold mb-2">One Step to Yum</h1>
            <p class="text-xl font-light italic">Complete your order details below</p>
        </div>
    </div>

    <!-- Nav -->
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex gap-3">
            <a href="{{ route('home') }}" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
                Cancel
            </a>
            <a href="{{ route('cart.index') }}" class="text-sm text-gray-600 hover:text-black flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg> Back
            </a>
        </div>
    </div>

    <!-- Step Progress -->
    <div class="flex items-center justify-center mt-12 px-10">
        <div class="flex gap-6 items-center text-white">
            @php
                $steps = ['Discover','View Restaurant','Menu','Cart','Checkout','Confirmation'];
            @endphp
            @foreach($steps as $index => $step)
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 {{ $index < 4 ? 'bg-orange-500 text-white' : ($index == 4 ? 'bg-black text-white' : 'bg-gray-300 text-gray-800') }} rounded-full flex items-center justify-center font-bold">
                        {{ $index+1 }}
                    </div>
                    <span class="text-sm mt-1 {{ $index <= 4 ? 'text-orange-500 font-semibold' : 'text-black' }}">{{ $step }}</span>
                </div>
                @if($index < count($steps)-1)
                    <div class="w-16 h-1 {{ $index < 4 ? 'bg-orange-500' : 'bg-gray-300' }}"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Main Content -->
    <form action="{{ route('order.confirmation') }}" method="POST" class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        @csrf

        <!-- Left side -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Personal Information -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="name" placeholder="Full Name*" value="{{ old('name', session('checkout.name', '')) }}" required class="border border-gray-300 rounded p-2">
                    <input type="text" name="phone" placeholder="Phone Number*" value="{{ old('phone', session('checkout.phone', '')) }}" required class="border border-gray-300 rounded p-2">
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email', session('checkout.email', '')) }}" class="border border-gray-300 rounded p-2">
                    <input type="text" name="address" placeholder="Address*" value="{{ old('address', session('checkout.address', '')) }}" required class="border border-gray-300 rounded p-2">
                    <input type="text" name="city" placeholder="City*" value="{{ old('city', session('checkout.city', '')) }}" required class="border border-gray-300 rounded p-2">
                    <input type="text" name="postal_code" placeholder="Postal Code*" value="{{ old('postal_code', session('checkout.postal_code', '')) }}" required class="border border-gray-300 rounded p-2">
                </div>
                <textarea name="instructions" placeholder="Order Notes" rows="3" class="mt-4 w-full border border-gray-300 rounded p-2">{{ old('instructions', session('checkout.instructions', '')) }}</textarea>
            </div>

            <!-- Payment Details -->
            <div class="bg-white p-6 rounded shadow" x-data="{ paymentMethod: '{{ old('payment_method', session('checkout.payment_method', 'card')) }}' }">
                <h2 class="text-2xl font-semibold mb-4">Payment Details</h2>
                <div class="space-y-4">

                    <!-- Payment method selector -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Select Payment Method:</label>
                        <select name="payment_method" class="w-full border border-gray-300 rounded p-2" x-model="paymentMethod">
                            <option value="card">Credit / Debit Card</option>
                            <option value="cod">Cash on Delivery</option>
                            <option value="bank">Bank Transfer</option>
                        </select>
                    </div>

                    <!-- Credit / Debit Card details -->
                    <div x-show="paymentMethod === 'card'" class="space-y-2">
                        <input type="text" name="card_name" placeholder="Cardholder Name" value="{{ old('card_name', session('checkout.card_name', '')) }}" class="w-full border border-gray-300 rounded p-2">
                        <input type="text" name="card_number" placeholder="Card Number" value="{{ old('card_number', session('checkout.card_number', '')) }}" class="w-full border border-gray-300 rounded p-2">
                        <div class="flex gap-4">
                            <input type="text" name="expiry" placeholder="MM/YY" value="{{ old('expiry', session('checkout.expiry', '')) }}" class="w-1/2 border border-gray-300 rounded p-2">
                            <input type="text" name="cvv" placeholder="CVV" value="{{ old('cvv', session('checkout.cvv', '')) }}" class="w-1/2 border border-gray-300 rounded p-2">
                        </div>
                    </div>

                    <!-- Cash on Delivery info -->
                    <div x-show="paymentMethod === 'cod'" class="p-3 bg-yellow-100 border border-yellow-300 rounded text-gray-800">
                        Pay in cash when your order is delivered. No online details required.
                    </div>

                    <!-- Bank Transfer info -->
                    <div x-show="paymentMethod === 'bank'" class="p-3 bg-green-100 border border-green-300 rounded text-gray-800">
                        <p>Please transfer the total amount to the following SwiftDine bank account:</p>
                        <ul class="mt-2 list-disc list-inside">
                            <li>Bank: Commercial Bank of Ceylon</li>
                            <li>Account Name: SwiftDine (Pvt) Ltd</li>
                            <li>Account Number: 0123456789</li>
                            <li>Branch: Colombo 03</li>
                            <li>SWIFT Code: CCEYLKLX</li>
                        </ul>
                        <p class="mt-2 text-sm text-gray-700">
                            Once the payment is done, kindly upload your payment proof or notify us.
                        </p>
                    </div>

                </div>
            </div>

            <!-- Delivery Options -->
            <div class="bg-white p-6 rounded shadow" x-data="{ deliveryMethod: '{{ old('delivery_method', session('checkout.delivery_method', 'delivery')) }}' }">
                <h2 class="text-2xl font-semibold mb-4">Delivery Options</h2>
                <div class="space-y-4">

                    <label class="flex items-start p-4 border rounded" 
                           :class="deliveryMethod === 'delivery' ? 'border-orange-500 bg-orange-100' : 'border-gray-300'">
                        <input type="radio" name="delivery_method" value="delivery" x-model="deliveryMethod" class="mr-3 mt-1">
                        <div>
                            <p class="font-semibold">Delivery (Bike)</p>
                            <p class="text-sm text-gray-600">We’ll deliver your order to the address provided. ETA: 30 mins</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded" 
                           :class="deliveryMethod === 'pickup' ? 'border-orange-500 bg-orange-100' : 'border-gray-300'">
                        <input type="radio" name="delivery_method" value="pickup" x-model="deliveryMethod" class="mr-3 mt-1">
                        <div>
                            <p class="font-semibold">Pickup</p>
                            <p class="text-sm text-gray-600">Pick up your order from our restaurant.</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded" 
                           :class="deliveryMethod === 'dinein' ? 'border-orange-500 bg-orange-100' : 'border-gray-300'">
                        <input type="radio" name="delivery_method" value="dinein" x-model="deliveryMethod" class="mr-3 mt-1">
                        <div>
                            <p class="font-semibold">Dine-in</p>
                            <p class="text-sm text-gray-600">Reserve a table at our restaurant.</p>
                        </div>
                    </label>

                </div>

                <!-- Friendly message for non-delivery options -->
                <div class="mt-4 p-3 bg-yellow-100 border border-yellow-300 rounded text-gray-800"
                     x-show="deliveryMethod === 'pickup' || deliveryMethod === 'dinein'">
                    Currently we have Delivery options available, but we know you’re excited to try out Pickup or Dine-in! 😊
                </div>
            </div>

            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded mt-4 w-full">
                Confirm Your Order →
            </button>
        </div>

        <!-- Right side: Livewire Order Summary -->
        <div>
            @livewire('cart-summary')
        </div>
    </form>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

@endsection
