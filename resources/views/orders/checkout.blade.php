<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - SwiftDine</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <!-- Banner Section -->
<div class="relative h-[400px]">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://i.pinimg.com/736x/1c/a7/c7/1ca7c798e8da4d18b7676e6786a55b00.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Banner Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-10 text-center text-white">
        <h1 class="text-5xl font-extrabold mb-2">One Step to Yum</h1>
        <p class="text-xl font-light italic">Complete your order details below</p>
    </div>
</div>

<!-- Nav, Cancel & Confirm -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="home.php" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="cart.php" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
    
  </div>

  <a href="confirmation.php" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    Confirm your Order →
  </a>
</div>

<!-- Step Progress Section -->
<div class="flex items-center justify-center mt-12 px-10">
    <div class="flex gap-6 items-center text-white">
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">Discover</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">View Restaurant</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500">Menu</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
            <span class="text-sm mt-1 text-orange-500 font-semibold">Cart</span>
        </div>
        <div class="w-16 h-1 bg-orange-500"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">5</div>
            <span class="text-sm mt-1 text-black font-semibold">Checkout</span>
        </div>
        <div class="w-16 h-1 bg-gray-300"></div>
        <div class="flex flex-col items-center">
            <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">6</div>
            <span class="text-sm mt-1 text-black">Confirmation</span>
        </div>
    </div>
</div>



  <!-- Main Content -->
  <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    <!-- Left side -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Personal Information -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" placeholder="Full Name*" class="border border-gray-300 rounded p-2">
          <input type="text" placeholder="Phone Number*" class="border border-gray-300 rounded p-2">
          <input type="email" placeholder="Email Address" class="border border-gray-300 rounded p-2">
          <input type="text" placeholder="Address*" class="border border-gray-300 rounded p-2">
          <input type="text" placeholder="City*" class="border border-gray-300 rounded p-2">
          <input type="text" placeholder="Postal Code*" class="border border-gray-300 rounded p-2">
        </div>
        <textarea placeholder="Order Notes" rows="3" class="mt-4 w-full border border-gray-300 rounded p-2"></textarea>
      </div>

      <!-- Payment Details -->
<div class="bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-semibold mb-4">Payment Details</h2>
  <div class="space-y-4">
    <!-- Payment Method -->
    <div>
      <label class="block text-sm font-medium mb-1">Select Payment Method:</label>
      <select class="w-full border border-gray-300 rounded p-2">
        <option value="card">Credit / Debit Card</option>
        <option value="cod">Cash on Delivery</option>
        <option value="bank">Bank Transfer</option>
      </select>
    </div>

    <!-- Card Details -->
    <div class="space-y-2">
      <input type="text" placeholder="Cardholder Name" class="w-full border border-gray-300 rounded p-2">
      <input type="text" placeholder="Card Number" class="w-full border border-gray-300 rounded p-2">
      <div class="flex gap-4">
        <input type="text" placeholder="MM/YY" class="w-1/2 border border-gray-300 rounded p-2">
        <input type="text" placeholder="CVV" class="w-1/2 border border-gray-300 rounded p-2">
      </div>
    </div>
  </div>
</div>

      <!-- Delivery Options -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">How would you like it?</h2>
        <div class="space-y-4">
          <label class="flex items-start p-4 border border-orange-500 rounded bg-orange-100">
            <input type="radio" name="method" class="mr-3 mt-1" checked>
            <div>
              <p class="font-semibold">Delivery (Bike)</p>
              <p class="text-sm text-gray-600">We’ll deliver your order to the address provided. ETA: 30 mins</p>
            </div>
          </label>
          <label class="flex items-start p-4 border border-gray-300 rounded">
            <input type="radio" name="method" class="mr-3 mt-1">
            <div>
              <p class="font-semibold">Pickup</p>
              <p class="text-sm text-gray-600">Pick up your order from our restaurant.</p>
            </div>
          </label>
          <label class="flex items-start p-4 border border-gray-300 rounded">
            <input type="radio" name="method" class="mr-3 mt-1">
            <div>
              <p class="font-semibold">Dine-in</p>
              <p class="text-sm text-gray-600">Reserve a table at our restaurant.</p>
            </div>
          </label>
        </div>
      </div>
    </div>


    <!-- Right side -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>

      <!-- Order items -->
      <div class="mb-4">
        <div class="flex justify-between mb-2">
          <p>Cheese Kottu Roti x2</p>
          <p>Rs 1700</p>
        </div>
        <!-- Add more items as needed -->
      </div>

      <!-- Promo code -->
      <div class="mb-4">
        <div class="flex">
          <input type="text" placeholder="Promo code" class="flex-1 border border-gray-300 rounded-l p-2">
          <button class="bg-orange-500 text-white px-4 rounded-r">Apply</button>
        </div>
        <p class="text-green-600 text-sm mt-2">✔ Promo applied: 20% - Rs 2000 saved</p>
      </div>

      <!-- Totals -->
      <div class="space-y-1 text-sm" id="order-totals">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span id="subtotal">Rs 8500</span>
        </div>
        <div class="flex justify-between">
          <span>Discount</span>
          <span id="discount">- Rs 2000</span>
        </div>
        <div class="flex justify-between">
          <span>Delivery Fee</span>
          <span id="delivery-fee">Rs 300</span>
        </div>
        <div class="flex justify-between">
          <span>Tax (10%)</span>
          <span id="tax">Rs 650</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span>
          <span id="total">Rs 7450</span>
        </div>
      </div>

      <script>
        // Parse currency string like "Rs 8500" into number 8500
        function parseRs(value) {
          return Number(value.replace(/[^\d.-]/g, ''));
        }

        // Calculate and update total
        function updateTotal() {
          const subtotal = parseRs(document.getElementById('subtotal').textContent);
          const discount = parseRs(document.getElementById('discount').textContent);
          const deliveryFee = parseRs(document.getElementById('delivery-fee').textContent);
          const tax = parseRs(document.getElementById('tax').textContent);

          // Total = Subtotal - Discount + Delivery Fee + Tax
          const total = subtotal - discount + deliveryFee + tax;

          // Update total display with Rs prefix
          document.getElementById('total').textContent = `Rs ${total}`;
        }

        // Run on page load
        updateTotal();
      </script>


      <button class="w-full bg-orange-600 text-white py-2 rounded mt-6 hover:bg-orange-700 transition">Place Order Now</button>
    </div>
  </div>
</body>
</html>
