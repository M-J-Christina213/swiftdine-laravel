<?php
include '../../config/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// For demonstration, sample cart/order items array
// In real, fetch this from order_items table or session
$orderItems = [
    [
        'image' => 'cheese_kottu.jpg',
        'name' => 'Cheese Kottu Roti',
        'prep_time' => '15 mins',
        'price' => 850,
        'quantity' => 2,
        'description' => 'Delicious cheese-filled kottu roti with spices',
    ],
    [
        'image' => 'veggie_fried_rice.jpg',
        'name' => 'Veggie Fried Rice',
        'prep_time' => '10 mins',
        'price' => 650,
        'quantity' => 1,
        'description' => 'Fresh vegetables with fragrant fried rice',
    ],
    [
        'image' => 'chicken_biryani.jpg',
        'name' => 'Chicken Biryani',
        'prep_time' => '20 mins',
        'price' => 950,
        'quantity' => 3,
        'description' => 'Spicy chicken biryani cooked with aromatic spices',
    ],
];

// Calculate totals
$subtotal = 0;
foreach ($orderItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$discount = 200; // example discount
$deliveryFee = 150; // example delivery fee
$tax = ($subtotal - $discount + $deliveryFee) * 0.1; // 10% tax
$total = $subtotal - $discount + $deliveryFee + $tax;

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart - Almost There Foodie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Banner -->
<section class="relative h-48 bg-gradient-to-r from-orange-500 to-yellow-400 flex flex-col justify-center items-center text-white">
    <h1 class="text-4xl font-extrabold mb-2">Almost There Foodie</h1>
    <p class="italic text-lg font-light">Ready for your delicious meal?</p>
</section>

<!-- Nav, Cancel & Confirm -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="home.php" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="menu.php" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
    
  </div>

  <a href="checkout.php" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    Proceed to Checkout →
  </a>
</div>

<!-- Step Progress Section -->
<div class="flex items-center justify-center mt-12 px-10">
    
    <!-- 6 steps -->
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
                <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                <span class="text-sm mt-1 text-orange-500">Menu</span>
            </div>
            <div class="h-1 w-14 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">4</div>
                <span class="text-sm mt-1 text-black">Cart</span>
            </div>
             <div class="h-1 w-14 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">5</div>
                <span class="text-sm mt-1 text-black">Checkout</span>
            </div>
             <div class="h-1 w-14 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">6</div>
                <span class="text-sm mt-1 text-black">Confirmation</span>
            </div>


        </div>
        
    
</div>
<br>

<!-- Main Content -->
<div class="flex flex-col lg:flex-row max-w-7xl mx-auto px-6 gap-8 pb-12 flex-grow">

    <!-- Cart Items -->
    <div class="flex-1 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Your Cart (<?= count($orderItems) ?> items)</h2>

        <div class="space-y-6">
            <?php foreach ($orderItems as $index => $item): ?>
            <div class="flex items-center gap-4 border-b pb-4">
                <img src="/assets/images/menus/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-24 h-24 object-cover rounded-md shadow" />

                <div class="flex-1">
                    <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-sm text-gray-500">Prep time: <?= htmlspecialchars($item['prep_time']) ?></p>
                    <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($item['description']) ?></p>
                </div>

                <!-- Quantity controls -->
                <div class="flex items-center space-x-2">
                    <form method="post" action="update_quantity.php" class="flex items-center space-x-1">
                        <input type="hidden" name="item_id" value="<?= $index ?>" />
                        <button type="submit" name="action" value="decrease" class="bg-gray-200 hover:bg-gray-300 rounded px-2 py-1">-</button>
                        <span class="w-6 text-center"><?= $item['quantity'] ?></span>
                        <button type="submit" name="action" value="increase" class="bg-gray-200 hover:bg-gray-300 rounded px-2 py-1">+</button>
                    </form>
                    <span class="font-bold text-orange-600">Rs <?= number_format($item['price'] * $item['quantity']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Add Note -->
            <div>
                <label for="order_note" class="block font-semibold mb-1">Add Note / Special Instructions</label>
                <textarea id="order_note" name="order_note" rows="3" class="w-full border rounded p-2 resize-none" placeholder="E.g. No onions, extra spicy..."></textarea>
            </div>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <aside class="w-full lg:w-96 bg-white rounded-lg shadow p-6 flex flex-col gap-6">

        <h2 class="text-2xl font-bold border-b pb-3">Order Summary</h2>

        <!-- Promo Code -->
        <form method="post" class="flex gap-2">
            <input type="text" name="promo_code" placeholder="Enter promo code" class="flex-grow border rounded px-3 py-2" />
            <button type="submit" class="bg-orange-500 text-white px-4 rounded hover:bg-orange-600 transition">Apply</button>
        </form>

        <!-- Delivery Address -->
        <div>
            <h3 class="font-semibold mb-1">Delivery Address</h3>
            <p class="text-gray-700 text-sm">123 Main Street, Apt 4B, New York, NY 10001</p>
        </div>

        <!-- Estimated Delivery -->
        <div>
            <h3 class="font-semibold mb-1">Estimated Delivery Time</h3>
            <p class="text-gray-700 text-sm">30 to 45 minutes</p>
        </div>

        <!-- Price Breakdown -->
        <div class="space-y-2 border-t pt-3">
            <div class="flex justify-between text-gray-700">
                <span>Subtotal</span>
                <span>Rs <?= number_format($subtotal) ?></span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Discount</span>
                <span class="-text-green-600">- Rs <?= number_format($discount) ?></span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Delivery Fee</span>
                <span>Rs <?= number_format($deliveryFee) ?></span>
            </div>
            <div class="flex justify-between text-gray-700">
                <span>Taxes (10%)</span>
                <span>Rs <?= number_format($tax) ?></span>
            </div>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center font-extrabold text-2xl mt-4 text-orange-600">
            <span>Total</span>
            <span>Rs <?= number_format($total) ?></span>
        </div>

        <a href="checkout.php" class="block bg-orange-600 hover:bg-orange-700 text-white text-center py-3 rounded font-semibold mt-6 transition">Proceed to Checkout</a>

    </aside>
</div>

</body>
</html>
