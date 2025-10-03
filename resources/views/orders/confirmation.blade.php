@extends('layouts.app')

@section('title', 'Order Confirmation - SwiftDine')

@section('content')
<section class="relative h-60 bg-gradient-to-r from-orange-400 to-yellow-300 flex items-center justify-center text-white">
  <img src="/assets/images/banner_delivery.png" alt="Delivery" class="absolute inset-0 w-full h-full object-cover opacity-20"/>
  <h1 class="z-10 text-4xl font-bold">Your order is on its way</h1>
</section>

<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="{{ route('home') }}" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">Cancel</a>
    <a href="{{ route('cart.checkout') }}" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
  </div>
  <a href="{{ route('orders.track') }}" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Confirm →</a>
</div>

<!-- Step Progress Section -->
<div class="flex items-center justify-center mt-12 px-10">
    <div class="flex gap-6 items-center text-white">
        @php
            $steps = ['Discover', 'View Restaurant', 'Menu', 'Cart', 'Checkout', 'Confirmation'];
        @endphp
        @foreach($steps as $index => $step)
        <div class="flex flex-col items-center">
            <div class="{{ $index >= 3 ? 'w-10 h-10' : 'w-8 h-8' }} bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500 {{ $index >= 3 ? 'font-semibold' : '' }}">{{ $step }}</span>
        </div>
        @if(!$loop->last)
            <div class="w-16 h-1 bg-orange-500"></div>
        @endif
        @endforeach
    </div>
</div>

@php
    $subtotal = collect($orderItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    $tax = round($subtotal * 0.1);
    $deliveryFee = 200;
    $total = $subtotal + $tax + $deliveryFee;
@endphp

<div class="max-w-6xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Left/Main Column: All Order Info -->
  <div class="lg:col-span-2 space-y-6">
    <!-- Order Info -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex justify-between text-sm text-gray-700">
        <span>Order No: <strong>#{{ $orderNumber }}</strong></span>
        <span>Estimated Delivery: <strong class="text-orange-600">{{ $estimatedDelivery }}</strong></span>
      </div>
      <div class="mt-1 text-gray-500 text-sm">{{ $orderDateTime }}</div>
      <p class="mt-3 text-gray-700 text-sm">Thank you for your order! We are preparing your meal and will update you once it’s on the way.</p>
    </div>

    <!-- Payment Summary -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4">Payment Summary</h3>
      <div class="flex justify-between items-center text-sm">
        <div class="flex items-center gap-2">
          <img src="/assets/icons/visa.svg" class="w-6 h-6" alt="Visa" />
          <span>Visa ending in {{ $cardLast4 }}</span>
        </div>
        <span>Exp: {{ $cardExpiry }}</span>
      </div>
      <div class="flex justify-between mt-3 font-semibold text-gray-800">
        <span>Amount Paid</span><span>Rs {{ number_format($total) }}</span>
      </div>
      <div class="mt-2 text-green-600 text-sm flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        Payment Successful
      </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
      <p class="text-sm text-gray-700 mb-1"><strong>Name:</strong> {{ $customerName }}</p>
      <p class="text-sm text-gray-700 mb-1"><strong>Phone:</strong> {{ $customerPhone }}</p>
      <p class="text-sm text-gray-700"><strong>Email:</strong> {{ $customerEmail }}</p>
    </div>

    <!-- Delivery Instructions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Delivery Info</h3>
        <p class="text-sm text-gray-700 mb-1"><strong>Fulfillment:</strong> {{ $fulfillment }}</p>
        <p class="text-sm text-gray-700 mb-1"><strong>Delivery Address:</strong> {{ $deliveryAddress }}</p>
        <p class="text-sm text-gray-700 mb-1"><strong>Estimated Arrival:</strong> {{ $estimatedArrival }}</p>
        <p class="text-sm text-gray-700"><strong>Instructions:</strong> {{ $instructions ?? 'None' }}</p>
    </div>
  </div>

  <!-- Right Column: Only Cart Summary -->
  <div class="lg:sticky lg:top-20 space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Your Cart</h3>
        @livewire('cart-summary')
    </div>
  </div>
</div>
@endsection
