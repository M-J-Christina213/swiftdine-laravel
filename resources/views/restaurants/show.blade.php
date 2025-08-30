<?php
include '../../config/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get restaurant by ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM restaurants WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $restaurant = $result->fetch_assoc();
} else {
    echo "Restaurant not found.";
    exit;
}
?>

<!-- TaAilwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Banner Section -->
<div class="relative h-[350px]">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($restaurant['image_url'] ?: 'https://source.unsplash.com/1600x900/?restaurant'); ?>');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Banner Content -->
    <div class="relative z-10 flex items-center justify-between h-full px-10">
        <div class="text-white">
            <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
            <p class="text-lg mt-2"><?php echo htmlspecialchars($restaurant['location']); ?></p>
            <div class="mt-6 flex gap-4">
                <a href="reserve.php?id=<?php echo $restaurant['id']; ?>" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full text-sm font-semibold shadow-md">
                    Reserve Table
                </a>
                <a href="menu.php" class="bg-white text-gray-800 hover:bg-gray-100 px-6 py-2 rounded-full text-sm font-semibold shadow-md">
                    View Menu
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Nav, Cancel & Confirm -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="home.php" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="browseMenus.php" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
    
  </div>

  <a href="menu.php" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    view menu →
  </a>
</div>


<!-- Step Progress Section -->
<div class="flex items-center justify-center mt-12 px-10">
    
    <!-- Step 1 and 2 -->
    <div class="flex gap-6 items-center text-white">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                <span class="text-sm mt-1 text-orange-500">Discover</span>
            </div>
            <div class="w-16 h-1 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold">2</div>
                <span class="text-sm mt-1 text-black">View Restaurant</span>
            </div>
            <div class="w-16 h-1 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">3</div>
                <span class="text-sm mt-1 text-black">Menu</span>
            </div>
            <div class="h-1 w-14 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">4</div>
                <span class="text-sm mt-1 text-black">Cart</span>
            </div>
             <div class="h-1 w-14 bg-black"></div>
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

<!-- Restaurant Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-10 py-12">

    <!-- Ratings & Reviews -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-2">Ratings & Reviews</h2>
        <div class="flex items-center text-yellow-400 text-xl font-bold">
            ★ 4.8
            <span class="text-gray-600 text-sm font-normal ml-2">based on 2,548 reviews</span>
        </div>
        <a href="reviews.php?id=<?php echo $restaurant['id']; ?>" class="mt-4 inline-block text-orange-500 hover:underline text-sm font-semibold">
            View all reviews
        </a>
    </div>

    <!-- Location -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 1011.314-11.314z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Location
        </h2>
        <p class="text-gray-700 text-sm mb-4">42 Marine Drive, Colombo 03, Sri Lanka</p>
        <!-- Embedded Google Map -->
        <iframe class="w-full h-40 rounded-md"
            src="https://www.google.com/maps?q=42%20Marine%20Drive,%20Colombo%2003,%20Sri%20Lanka&output=embed"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Hours & Contact -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Hours & Contact
        </h2>

        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-700 text-sm">Today, Opens at 8 AM</p>
            <span class="text-green-600 font-semibold text-sm">Open Now</span>
        </div>

        <div class="flex items-center text-gray-700 text-sm mb-2">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 5h2l3.6 7.59a1 1 0 00.9.41h6.72a1 1 0 00.9-.55l3.38-6.72A1 1 0 0020 4H6" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7 20h10a1 1 0 001-1v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1a1 1 0 001 1z" />
            </svg>
            +94 77 123 4567
        </div>

        <div class="flex items-center text-gray-700 text-sm">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 12h2a2 2 0 012 2v6H4v-6a2 2 0 012-2h2m4-4V4m0 0L8 8m4-4l4 4" />
            </svg>
            info@restaurant.com
        </div>
    </div>

</div>

<!-- Payment Options Section -->
<div class="px-10 mt-16">
  <div class="flex items-center gap-3 text-lg font-semibold mb-4">
    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
      viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M17 9V7a4 4 0 00-8 0v2M5 9h14a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z" />
    </svg>
    <span class="text-black">Payment Options</span>
  </div>

  <div class="flex flex-wrap gap-4">
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
      💵 <span>Cash</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
      💳 <span>Visa</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
      🏦 <span>MasterCard</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
      🅿️ <span>PayPal</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-4 py-2">
       <span>Apple Pay</span>
    </div>
  </div>
</div>

<!-- Dine-in Preview Section -->
<div class="px-10 mt-16">
  <div class="flex items-center gap-3 text-lg font-semibold mb-6">
    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
      viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
    </svg>
    <span class="text-black">Dine-in Preview</span>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- Left Side: Table Layout -->
    <div class="bg-white p-6 rounded-xl shadow">
    <div class="grid grid-cols-3 gap-4 mb-4">
        <!-- Table Circles with labels -->
        <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">T1</div>
        <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">T2</div>
        <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">T3</div>
        <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">T4</div>
        <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">T5</div>
        <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">T6</div>
        <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">T7</div>
        <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">T8</div>
        <div class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold">T9</div>
    </div>

    <div class="flex items-center gap-4">
        <div class="flex items-center gap-1 text-sm">
        <div class="w-4 h-4 bg-green-500 rounded-full"></div> <span>Available</span>
        </div>
        <div class="flex items-center gap-1 text-sm">
        <div class="w-4 h-4 bg-gray-400 rounded-full"></div> <span>Occupied</span>
        </div>
    </div>

    <button class="mt-6 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-semibold shadow">
        Reserve a Table
    </button>
    </div>


    <!-- Right Side: Suggestions & Features -->
    <div class="bg-white p-6 rounded-xl shadow space-y-4">
      <div>
        <h3 class="font-bold text-lg mb-2">Best For</h3>
        <div class="flex gap-4 text-sm text-gray-700">
          <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full">👤 Solo</div>
          <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full">❤️ Couples</div>
          <div class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full">👥 Groups</div>
        </div>
      </div>

      <div>
        <h3 class="font-bold text-lg mb-2">Highlights</h3>
        <ul class="space-y-2 text-sm text-gray-700">
          <li class="flex items-center gap-2">✅ Private Dining</li>
          <li class="flex items-center gap-2">✅ Ocean View</li>
          <li class="flex items-center gap-2">✅ Family Friendly</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Delivery & Takeaway Options -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-10 mt-12">
  
  <!-- Delivery Card -->
  <div class="border-2 border-orange-400 rounded-xl p-6 shadow bg-white">
    <div class="flex items-center gap-2 mb-4">
      <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l4-4m0 0l4-4m-4 4H21" />
      </svg>
      <h2 class="text-lg font-bold text-gray-800">Delivery Available</h2>
    </div>
    <p class="text-sm mb-2">Minimum Order: <span class="font-medium">Rs. 5,000</span></p>
    <p class="text-sm mb-2">Delivery Fee: <span class="font-medium">Rs. 300</span> <span class="text-xs text-gray-500">(depends on location)</span></p>
    <p class="text-sm mb-6">Estimated Time: <span class="font-medium">30–40 mins</span></p>
    <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full font-semibold shadow">
      Order for Delivery
    </button>
  </div>

  <!-- Takeaway Card -->
  <div class="border-2 border-orange-400 rounded-xl p-6 shadow bg-white">
    <div class="flex items-center gap-2 mb-4">
      <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-4H5v4H3V9a2 2 0 012-2h14a2 2 0 012 2v8h-2v-4h-4v4h-2v-4h-4v4H9z" />
      </svg>
      <h2 class="text-lg font-bold text-gray-800">Takeaway Available</h2>
    </div>
    <p class="text-sm mb-2">Preparation Time: <span class="font-medium">15–20 mins</span></p>
    <p class="text-sm mb-2">Pickup Hours: <span class="font-medium">10 AM – 9 PM</span></p>
    <p class="text-sm mb-2">Curbside Pickup</p>
    <p class="text-sm mb-6">Pre-order up to <span class="font-medium">2 days in advance</span></p>
    <button class="bg-black hover:bg-gray-800 text-white px-5 py-2 rounded-full font-semibold flex items-center gap-2">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
      </svg>
      Schedule Pickup
    </button>
  </div>

</div>
<br>
<div class="flex justify-between items-center px-10 mb-6">
  <h2 class="text-2xl font-bold flex items-center gap-2 text-gray-800">
    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M4 4h16v16H4z" /> <!-- example icon shape, can be replaced -->
      <path d="M8 12h8" />
    </svg>
    Menu Highlights
  </h2>
    <a href="menu.php" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg  font-semibold shadow">
      view full menu
    </a>
</div>
<!-- Menu Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-10">
  <!-- Sri Lankan Food -->
  <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
    <img src="https://i.pinimg.com/736x/d6/d0/75/d6d0759eea5d87f87488272a9fa5eb71.jpg" alt="Kottu Roti" class="rounded-lg h-40 object-cover mb-3">
    <div class="flex justify-between items-center">
      <h3 class="font-bold text-lg text-gray-800">Chicken Kottu</h3>
      <span class="text-orange-600 font-semibold">LKR 980</span>
    </div>
    <div class="flex justify-between items-center text-sm mt-2 text-gray-600">
      <span>#SriLankan #StreetFood</span>
      <div class="flex items-center gap-1">
        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.343l-6.828-6.829a4 4 0 010-5.656z" /></svg>
        <span>97% Recommended</span>
      </div>
    </div>
  </div>

  <!-- Indian Food -->
  <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
    <img src="https://i.pinimg.com/736x/ed/85/d3/ed85d360367e23b6a593d402d4b20554.jpg" alt="Masala Dosa" class="rounded-lg h-40 object-cover mb-3">
    <div class="flex justify-between items-center">
      <h3 class="font-bold text-lg text-gray-800">Masala Dosa</h3>
      <span class="text-orange-600 font-semibold">LKR 850</span>
    </div>
    <div class="flex justify-between items-center text-sm mt-2 text-gray-600">
      <span>#Indian #Veg #SouthIndian</span>
      <div class="flex items-center gap-1">
        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.343l-6.828-6.829a4 4 0 010-5.656z" /></svg>
        <span>93% Recommended</span>
      </div>
    </div>
  </div>

  <!-- Chinese Food -->
  <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
    <img src="https://i.pinimg.com/736x/2e/b2/69/2eb26947d6afd1f62450039e145ac25a.jpg" alt="Fried Rice" class="rounded-lg h-40 object-cover mb-3">
    <div class="flex justify-between items-center">
      <h3 class="font-bold text-lg text-gray-800">Chinese Fried Rice</h3>
      <span class="text-orange-600 font-semibold">LKR 1,100</span>
    </div>
    <div class="flex justify-between items-center text-sm mt-2 text-gray-600">
      <span>#Chinese #EggRice</span>
      <div class="flex items-center gap-1">
        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.343l-6.828-6.829a4 4 0 010-5.656z" /></svg>
        <span>90% Recommended</span>
      </div>
    </div>
  </div>
</div>

<div class="px-10 mt-16">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Gallery</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <!-- 6 gallery images -->
    <img src="https://i.pinimg.com/736x/1d/5c/17/1d5c171ff3498f3fc930dafb644538d8.jpg" class="rounded-xl object-cover h-40 w-full">
    <img src="https://i.pinimg.com/736x/09/7b/98/097b98a664e178cc5b3c0148626a931e.jpg" class="rounded-xl object-cover h-40 w-full">
    <img src="https://i.pinimg.com/736x/e1/2c/b5/e12cb5bf6722cc47bfcf54562f777160.jpg" class="rounded-xl object-cover h-40 w-full">
    <img src="https://i.pinimg.com/736x/84/6f/1b/846f1b761b1b851b7f3e5f1c42fc1744.jpg" class="rounded-xl object-cover h-40 w-full">
    <img src="https://i.pinimg.com/736x/a2/83/cd/a283cd857de7d58dd1d20b5399c0befe.jpg" class="rounded-xl object-cover h-40 w-full">
    <img src="https://i.pinimg.com/736x/df/20/3a/df203a316e2b6e17c10bbe7d88fd057e.jpg" class="rounded-xl object-cover h-40 w-full">
  </div>
</div>

<div class="px-10 mt-20">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Ratings & Reviews</h2>

  <!-- Overall Rating -->
  <div class="flex flex-col md:flex-row justify-between gap-10 bg-gray-50 p-6 rounded-xl border">
    <div class="text-center md:text-left">
      <p class="text-4xl font-bold text-orange-500">4.6</p>
      <div class="flex justify-center md:justify-start gap-1 my-1">
        <svg class="w-5 h-5 text-yellow-400" fill="currentColor"><path d="..."/></svg>
        <!-- Repeat for 5 stars -->
      </div>
      <p class="text-gray-600 text-sm">Based on 254 reviews</p>
    </div>

    <!-- Breakdown -->
    <div class="flex-1">
      <div class="space-y-2">
        <div class="flex items-center gap-2">
          <span class="text-sm font-medium w-12">5 ★</span>
          <div class="bg-gray-300 w-full h-2 rounded-full relative">
            <div class="bg-yellow-400 h-2 rounded-full absolute top-0 left-0 w-[70%]"></div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-medium w-12">4 ★</span>
          <div class="bg-gray-300 w-full h-2 rounded-full relative">
            <div class="bg-yellow-400 h-2 rounded-full absolute top-0 left-0 w-[20%]"></div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-sm font-medium w-12">3 ★</span>
          <div class="bg-gray-300 w-full h-2 rounded-full relative">
            <div class="bg-yellow-400 h-2 rounded-full absolute top-0 left-0 w-[6%]"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Review Filters -->
  <div class="flex gap-4 mt-6 mb-4 text-sm font-medium text-gray-700">
    <button class="bg-orange-100 text-orange-600 px-4 py-1 rounded-full">All Reviews</button>
    <button class="hover:underline">Most Recent</button>
    <button class="hover:underline">Positive</button>
    <button class="hover:underline">Moderate</button>
    <button class="hover:underline">Negative</button>
  </div>

  <!-- Individual Reviews -->
  <div class="space-y-6">
    <!-- Review Card -->
    <div class="border rounded-xl p-5 bg-white shadow-sm">
      <div class="flex items-center gap-3 mb-2">
        <img src="https://i.pinimg.com/736x/3b/51/05/3b510543ec18f623dcadbdcae0a4a1e0.jpg" alt="User" class="w-10 h-10 rounded-full object-cover">
        <div>
          <p class="font-semibold text-gray-800">Nuwan Perera</p>
          <p class="text-xs text-gray-500">Posted on April 15, 2025</p>
        </div>
      </div>
      <p class="text-sm text-gray-700 mb-3">Delicious food and friendly staff! Highly recommended for a casual dinner.</p>
      <div class="flex gap-2">
        <img src="https://i.pinimg.com/736x/e0/8e/28/e08e28e27fa931cd4dfd982141081c3c.jpg" class="w-20 h-20 object-cover rounded-lg">
      </div>
      <button class="mt-2 text-sm text-gray-600 hover:text-orange-500">Helpful?</button>
    </div>

    <!-- More reviews... -->
    <div class="border rounded-xl p-5 bg-white shadow-sm">
      <div class="flex items-center gap-3 mb-2">
        <img src="https://i.pinimg.com/736x/76/9a/70/769a703c13796a3d42c8daf573993121.jpg" class="w-10 h-10 rounded-full">
        <div>
          <p class="font-semibold text-gray-800">Hashini Silva</p>
          <p class="text-xs text-gray-500">Posted on March 22, 2025</p>
        </div>
      </div>
      <p class="text-sm text-gray-700">Loved the ambiance. Perfect for date nights. Would visit again!</p>
    </div>

    <div class="border rounded-xl p-5 bg-white shadow-sm">
      <div class="flex items-center gap-3 mb-2">
        <img src="https://i.pinimg.com/736x/40/fd/3c/40fd3cddaed5f9a9ef909913fc99bfec.jpg" class="w-10 h-10 rounded-full">
        <div>
          <p class="font-semibold text-gray-800">Sahan Dissanayake</p>
          <p class="text-xs text-gray-500">Posted on February 10, 2025</p>
        </div>
      </div>
      <p class="text-sm text-gray-700">Food was okay, but delivery took longer than expected.</p>
    </div>
  </div>
</div>

