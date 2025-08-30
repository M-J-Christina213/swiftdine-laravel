<?php include '../components/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

<div class="max-w-4xl mx-auto p-6">

  <!-- Title and Tabs -->
  <h1 class="text-3xl font-bold mb-6">My Orders</h1>

  <div class="flex space-x-4 mb-10 border-b-2 border-gray-300">
    <button class="pb-2 border-b-4 border-orange-500 text-orange-600 font-semibold">Delivery</button>
    <button class="pb-2 text-gray-600 hover:text-orange-500">Dine-in</button>
    <button class="pb-2 text-gray-600 hover:text-orange-500">Takeaway</button>
  </div>

  <!-- Active Order Section -->
  <section class="mb-16">
    <h2 class="text-xl font-semibold mb-4">Active Order</h2>

    <!-- Google Map -->
    <div class="mb-6 rounded-lg overflow-hidden shadow">
      <iframe 
        class="w-full h-48" 
        src="https://maps.google.com/maps?q=ITC%20Randeepa&t=&z=13&ie=UTF8&iwloc=&output=embed" 
        allowfullscreen 
        loading="lazy"
      ></iframe>
    </div>

    <!-- Timeline and Status -->
    <div class="flex items-center mb-8">
      <!-- Left - Order status -->
      <div class="w-1/4 text-gray-600 font-semibold">Order Status</div>
      <!-- Right - On the way with timeline -->
      <div class="flex-1 relative flex items-center space-x-4">

        <!-- Circles and connecting bars -->
        <!-- Confirmed circle -->
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-orange-500 border-2 border-white"></div>
          <span class="text-sm mt-2">Confirmed</span>
        </div>

        <!-- Bar orange -->
        <div class="flex-1 h-1 bg-orange-500"></div>

        <!-- Preparing circle -->
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-orange-500 border-2 border-white"></div>
          <span class="text-sm mt-2">Preparing</span>
        </div>

        <!-- Bar orange -->
        <div class="flex-1 h-1 bg-orange-500"></div>

        <!-- Out for delivery circle -->
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-yellow-400 border-2 border-white"></div>
          <span class="text-sm mt-2">Out for delivery</span>
        </div>

        <!-- Bar (partial orange) -->
        <div class="flex-1 h-1 bg-orange-300"></div>

        <!-- Delivered circle grey -->
        <div class="flex flex-col items-center z-10">
          <div class="w-6 h-6 rounded-full bg-gray-400 border-2 border-white"></div>
          <span class="text-sm mt-2">Delivered</span>
        </div>

      </div>
    </div>

    <div class="text-right mb-8 text-orange-500 font-semibold">On the way</div>

    <!-- Driver Details -->
    <div class="flex items-center justify-between mb-10 bg-white p-4 rounded-lg shadow">
      <div class="flex items-center space-x-4">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Driver" class="w-16 h-16 rounded-full object-cover" />
        <div>
          <p class="font-semibold">Michael Rodriguez</p>
          <p class="text-sm text-gray-600">Toyota Corolla - GHI-789</p>
        </div>
      </div>
      <div class="flex space-x-6">
        <button aria-label="Call driver" class="text-orange-500 hover:text-orange-700">
          <!-- Phone icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2l3 7-3 7H3l3-7-3-7z"/></svg>
        </button>
        <button aria-label="Message driver" class="text-orange-500 hover:text-orange-700">
          <!-- Message icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </button>
      </div>
    </div>

    <!-- Restaurant Info -->
    <div class="flex justify-between items-center mb-6">
      <div class="text-lg font-semibold">Kinsburgy Hotel</div>
      <button class="text-orange-500 font-semibold hover:underline">Contact</button>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <ul class="divide-y divide-gray-200">
        <li class="flex justify-between py-3">
          <span>1x Crab Curry</span>
          <span>Rs 850</span>
        </li>
        <li class="flex justify-between py-3">
          <span>1x Chicken Fried Rice</span>
          <span>Rs 450</span>
        </li>
        <li class="flex justify-between py-3">
          <span>2x Vegetable Roti</span>
          <span>Rs 300</span>
        </li>
        <li class="flex justify-between py-3">
          <span>1x Indian Dosa</span>
          <span>Rs 400</span>
        </li>
      </ul>
    </div>

    <!-- Price Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 space-y-2 text-gray-700">
      <div class="flex justify-between font-semibold">
        <span>Subtotal</span>
        <span>Rs 2,000</span>
      </div>
      <div class="flex justify-between">
        <span>Delivery Fee</span>
        <span>Rs 150</span>
      </div>
      <div class="flex justify-between">
        <span>Tax</span>
        <span>Rs 80</span>
      </div>
      <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2">
        <span>Total</span>
        <span>Rs 2,230</span>
      </div>
    </div>

    <!-- Payment Info -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
      <div class="text-orange-500">
        <!-- Credit card icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="2" y="7" width="20" height="10" rx="2" ry="2"/>
          <line x1="2" y1="11" x2="22" y2="11" />
        </svg>
      </div>
      <div class="font-semibold text-lg">**** 5678</div>
    </div>
  </section>

  <!-- Past Orders Section -->
  <section>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">Past Orders</h2>
      <div class="flex space-x-4">
        <select class="border border-gray-300 rounded px-3 py-1">
          <option>All Time</option>
          <option>Last 30 Days</option>
          <option>Last 6 Months</option>
        </select>
        <select class="border border-gray-300 rounded px-3 py-1">
          <option>All Types</option>
          <option>Delivery</option>
          <option>Dine-in</option>
          <option>Takeaway</option>
        </select>
      </div>
    </div>

    <!-- Cards -->
    <?php
    $pastOrders = [
      [
        "restaurant" => "Ocean's Delight",
        "date" => "3 May 2025",
        "mode" => "Delivery",
        "items" => "1x Kottu, 1x Hoppers, 1x Fried Rice",
        "total" => "Rs 4,800",
        "rating" => 4,
      ],
      [
        "restaurant" => "Sunset Grill",
        "date" => "28 Apr 2025",
        "mode" => "Dine-in",
        "items" => "2x Chicken Wings, 1x Caesar Salad",
        "total" => "Rs 3,200",
        "rating" => 5,
      ],
      [
        "restaurant" => "Spice Route",
        "date" => "15 Apr 2025",
        "mode" => "Takeaway",
        "items" => "1x Lamb Curry, 1x Naan Bread",
        "total" => "Rs 3,500",
        "rating" => 3,
      ],
    ];

    function renderStars($count) {
      $stars = "";
      for ($i=1; $i<=5; $i++) {
        if ($i <= $count) {
          $stars .= '<svg class="w-5 h-5 text-yellow-400 inline-block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.946 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88-4.946 4.09 1.824 6.09z"/></svg>';
        } else {
          $stars .= '<svg class="w-5 h-5 text-gray-300 inline-block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.946 12 1 7.91l6.061-.88L10 2l2.939 5.03 6.061.88-4.946 4.09 1.824 6.09z"/></svg>';
        }
      }
      return $stars;
    }

    foreach ($pastOrders as $order) :
    ?>
    <div class="bg-white rounded-lg shadow p-6 mb-6 flex justify-between items-center">
      <div>
        <div class="flex items-center space-x-2 mb-1">
          <div><?= renderStars($order["rating"]) ?></div>
        </div>
        <div class="font-semibold text-lg"><?= htmlspecialchars($order["restaurant"]) ?></div>
        <div class="text-sm text-gray-600"><?= $order["date"] ?> - <?= $order["mode"] ?></div>
        <div class="mt-2"><?= htmlspecialchars($order["items"]) ?></div>
        <div class="font-semibold mt-1"><?= $order["total"] ?></div>
      </div>
      <button class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Reorder</button>
    </div>
    <?php endforeach; ?>
  </section>

</div>

<!-- Bottom Call to Action -->
<div class="fixed bottom-0 left-0 w-full bg-gradient-to-r from-orange-600 via-orange-500 to-orange-400 text-white p-4 flex justify-between items-center">
  <div>
    <p class="font-semibold">You've ordered from Marine Grill 5 times!</p>
    <p class="text-sm mt-1">Would you like to add to favourites for faster order?</p>
  </div>
  <div class="flex space-x-4">
    <button class="bg-white text-orange-500 font-semibold px-4 py-2 rounded hover:bg-orange-100 transition">Add to Favourites</button>
    <button class="bg-transparent border border-white px-4 py-2 rounded hover:bg-white hover:text-orange-500 transition">No Thanks</button>
  </div>
</div>

</body>
</html>


<?php include '../component/footer.php'; ?>
