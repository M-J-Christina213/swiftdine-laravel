<?php
include '../../config/db.php'; 

$restaurants = getRestaurants($conn);
$menus = getMenuHighlights($conn); 

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SwiftDine - Sri Lankan Food Journey</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  <!-- Header -->
  <?php include '../components/header.php'; ?>

  <!-- Hero Banner -->
  <section class="relative bg-cover bg-center h-screen" style="background-image: url('https://miro.medium.com/v2/resize:fit:1400/0*OuSIEprF8jIzBc4g');">
    <!-- Dark transparent overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-12 lg:px-24 flex flex-col justify-center h-full text-center text-white">
      <h1 class="text-4xl sm:text-6xl font-extrabold drop-shadow-lg mb-4">
        Craving Something Delicious?
      </h1>
      <p class="text-lg sm:text-xl mb-12 drop-shadow-md max-w-xl mx-auto">
        From breakfast to dinner, discover your perfect meal, anytime, anywhere.
      </p>

      <!-- Meal Category Selector -->
      <div class="flex justify-center space-x-4 mb-12 overflow-x-auto no-scrollbar">
        <?php
          $meals = [
            ['icon' => '☀️', 'label' => 'Breakfast'],
            ['icon' => '🍳', 'label' => 'Brunch'],
            ['icon' => '🍛', 'label' => 'Lunch'],
            ['icon' => '🍝', 'label' => 'Dinner'],
          ];
          foreach ($meals as $meal) {
              echo '<button class="flex items-center space-x-2 bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full py-2 px-5 text-white font-semibold transition cursor-pointer whitespace-nowrap">';
              echo "<span class='text-xl'>{$meal['icon']}</span>";
              echo "<span>{$meal['label']}</span>";
              echo '</button>';
          }
        ?>
      </div>

      <!-- Interaction Mode Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-4xl mx-auto">
        <?php
          $modes = [
            ['icon' => '🪑', 'title' => 'Dine-In', 'desc' => 'Reserve a table in advance', 'btn' => 'Reserve Now'],
            ['icon' => '🛵', 'title' => 'Delivery', 'desc' => 'Food at your door', 'btn' => 'Order Delivery'],
            ['icon' => '🥡', 'title' => 'Takeaway', 'desc' => 'Pick up and go', 'btn' => 'Order Takeaway'],
          ];

          foreach ($modes as $mode) {
              echo '<div class="bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-6 flex flex-col items-center text-center text-white hover:scale-105 transition-transform cursor-pointer shadow-lg">';
              echo "<div class='text-6xl mb-4'>{$mode['icon']}</div>";
              echo "<h3 class='text-2xl font-bold mb-2'>{$mode['title']}</h3>";
              echo "<p class='mb-6'>{$mode['desc']}</p>";
              echo "<button class='bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-full transition'>{$mode['btn']}</button>";
              echo '</div>';
          }
        ?>
      </div>
    </div>
  </section>

  <!-- 2. Restaurants Section -->
   
<section class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-24 py-16">
  <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Where Would You Like to Eat?</h2>
  <p class="text-gray-600 mb-8">Search, browse, or explore popular picks</p>

  <!-- Search Bar -->
  <div class="mb-8 max-w-lg mx-auto relative">
    <input type="search" id="restaurantSearch" placeholder="Search by cuisine or location..." 
      class="w-full border border-gray-300 rounded-full py-3 px-5 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
    <!-- You can add JS autocomplete/suggestions later -->
  </div>

  <!-- Popular Categories Tabs -->
  <div class="flex justify-center space-x-6 mb-12 text-gray-700 font-semibold">
    <button class="category-tab px-4 py-2 rounded-full hover:bg-orange-100 focus:bg-orange-200 transition cursor-pointer" data-category="tourist">🌍 Tourist Favorites</button>
    <button class="category-tab px-4 py-2 rounded-full hover:bg-orange-100 focus:bg-orange-200 transition cursor-pointer" data-category="srilankan">🇱🇰 Sri Lankan Gems</button>
    <button class="category-tab px-4 py-2 rounded-full hover:bg-orange-100 focus:bg-orange-200 transition cursor-pointer" data-category="trending">🔥 Trending Now</button>
  </div>

  <!-- Restaurant Cards Grid -->
  <div id="restaurantCards" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($restaurants as $res): ?>
      <div class="bg-white rounded-lg shadow-md p-5 flex flex-col">

     
      
        
        <img src="<?= !empty($res['image_url']) ? htmlspecialchars($res['image_url']) : 'assets/images/restuarants/r1.jpg' ?>"
          alt="<?= htmlspecialchars($res['name']) ?>" class="rounded-md mb-4 object-cover h-48 w-full" />


        <h3 class="text-xl font-bold mb-1"><?= htmlspecialchars($res['name']) ?></h3>
        <p class="text-sm text-gray-600 mb-1"><?= htmlspecialchars($res['location']) ?></p>
        <p class="text-sm text-gray-600 mb-2 italic"><?= htmlspecialchars($res['cuisine']) ?></p>
        <p class="mb-4 font-semibold text-orange-600">⭐ <?= number_format($res['rating'], 1) ?></p>

        <div class="mt-auto flex space-x-3">
          <a href="menu.php?restaurant_id=<?= $res['id'] ?>" 
             class="flex-grow text-center bg-orange-500 hover:bg-orange-600 text-white rounded-full py-2 font-semibold transition">
             View Menu
          </a>
          <a href="restaurantProfile.php?id=<?= $res['id'] ?>" 
             class="flex-grow text-center border border-orange-500 hover:bg-orange-500 hover:text-white rounded-full py-2 font-semibold transition">
             View Restaurant
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- 3. Audience-Based menu Filters -->

<section class="py-12 px-6 max-w-full mx-auto bg-orange-500  shadow-lg">
  <h2 class="text-3xl font-extrabold mb-8 text-center text-white drop-shadow-md">
     Menu Highlights
  </h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php 
        $menuCount = 0;
        foreach ($menus as $menu): 
        if ($menuCount >= 4) break;
        $menuCount++;
        ?>
      <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
        <!-- Image -->
        <!--img src="../../assets/images/menus/htmlspecialchars($menu['image']) ?>" alt=" htmlspecialchars($menu['name']) ?>" class="w-full h-48 object-cover"-->
        <img src="<?= (filter_var($menu['image'], FILTER_VALIDATE_URL) ? $menu['image'] : 'images/' . htmlspecialchars($menu['image'])) ?>" alt="<?= htmlspecialchars($menu['name']) ?>" class="w-full h-48 object-cover">

        <!-- Content -->
        <div class="p-4">
          <!-- Title + Price -->
          <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold"><?= htmlspecialchars($menu['name']) ?></h3>
            <span class="text-green-600 font-bold">LKR <?= number_format($menu['price'], 2) ?></span>
          </div>

          <!-- Description -->
          <p class="text-gray-600 text-sm mb-3"><?= htmlspecialchars($menu['description']) ?></p>

          <!-- Dietary Tags -->
          <div class="flex flex-wrap gap-2 mb-4 text-sm">
            <?php
              
              $tagsArray = array_map('trim', explode(',', $menu['tags']));
                $tagsHtml = [];

                foreach ($tagsArray as $tag) {
                    switch (strtolower($tag)) {
                        case 'vegetarian':
                            $tagsHtml[] = '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">🥦 Vegetarian</span>';
                            break;
                        case 'spicy':
                            $tagsHtml[] = '<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full">🌶️ Spicy</span>';
                            break;
                        case 'gluten-free':
                            $tagsHtml[] = '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">🌾 Gluten-Free</span>';
                            break;
                        case 'gluten':
                            $tagsHtml[] = '<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full">🌾 Contains Gluten</span>';
                            break;
                    }
                }

                echo implode(' ', $tagsHtml);

            ?>
          </div>

          <button class="w-full bg-black text-orange-500 font-semibold text-lg tracking-wide uppercase py-3 rounded-lg shadow-md hover:bg-gray-900 hover:shadow-lg transition duration-300">
            Add to Order
            </button>


        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<section class="bg-white text-black px-4 py-10 sm:px-8 md:px-16 lg:px-24">
  <!-- Seating Preview -->
  <h2 class="text-center text-3xl font-bold mb-2">Seating Preview</h2>
  <p class="text-center text-gray-500 mb-8">Choose your preferred table and reserve in advance</p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
    <!-- Layout Section -->
    <div class="bg-gray-50 border rounded-xl p-6 shadow-sm">
      <h3 class="font-semibold mb-4">Restaurant Layout</h3>
      <div class="grid grid-cols-3 gap-4 justify-items-center text-sm font-medium">
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T1</div>
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T2</div>
        <div class="bg-red-200 rounded p-4 w-16 h-16 flex items-center justify-center">T3</div>
        <div class="bg-red-200 rounded p-4 w-16 h-16 flex items-center justify-center">T4</div>
        <div class="bg-yellow-200 rounded p-4 w-16 h-16 flex items-center justify-center">T5</div>
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T6</div>
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T7</div>
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T8</div>
        <div class="bg-green-200 rounded p-4 w-16 h-16 flex items-center justify-center">T9</div>
      </div>
      <div class="mt-4 text-sm text-gray-600">🟩 Available | 🟥 Occupied | 🟨 Selected</div>
    </div>

    <!-- Reservation Form -->
    <div class="bg-gray-50 border rounded-xl p-6 shadow-sm">
      <h3 class="font-semibold mb-4">Reservation Details</h3>
      <label class="block text-sm mb-1">Date</label>
      <input type="date" class="w-full border rounded p-2 mb-4">

      <label class="block text-sm mb-1">Time</label>
      <div class="grid grid-cols-3 gap-2 mb-4">
        <button class="bg-gray-100 hover:bg-orange-100 px-3 py-2 rounded">17:30</button>
        <button class="bg-orange-500 text-white px-3 py-2 rounded">18:00</button>
        <button class="bg-gray-100 hover:bg-orange-100 px-3 py-2 rounded">18:30</button>
      </div>

      <label class="block text-sm mb-1">Number of Guests</label>
      <input type="number" value="4" class="w-full border rounded p-2 mb-4">

      <label class="block text-sm mb-1">Selected Table</label>
      <div class="text-sm text-orange-600 font-medium mb-4">Table 5 (Near Window, Seats 4)</div>

      <label class="block text-sm mb-1">Special Requests</label>
      <textarea class="w-full border rounded p-2 mb-4" placeholder="Any special requests or dietary requirements?"></textarea>

      <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded font-semibold">
        Confirm Reservation
      </button>
    </div>
  </div>

  <!-- Delivery & Takeaway -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Delivery -->
    <div class="bg-gray-50 border rounded-xl p-6 shadow-sm">
      <h3 class="text-lg font-bold mb-2">Delivery</h3>
      <p class="text-sm text-gray-500 mb-4">Get your favorite Sri Lankan dishes delivered to your doorstep</p>
      <input type="text" placeholder="Enter your delivery address" class="w-full border p-2 rounded mb-4">
      <div class="flex items-center justify-between mb-2 text-sm">
        <span>Estimated Delivery Time</span>
        <span class="text-blue-600">25–35 mins</span>
      </div>
      <input type="text" placeholder="Any instructions for the delivery person?" class="w-full border p-2 rounded mb-4">
      <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded font-semibold">
        Proceed to Order
      </button>
    </div>

    <!-- Takeaway -->
    <div class="bg-gray-50 border rounded-xl p-6 shadow-sm">
      <h3 class="text-lg font-bold mb-2">Takeaway</h3>
      <p class="text-sm text-gray-500 mb-4">Skip the wait and pick up your order at your convenience</p>
      <input type="text" placeholder="Search for a restaurant" class="w-full border p-2 rounded mb-4">
      <div class="text-sm text-orange-600 mb-4 font-medium">Spice Garden (2.3km away)</div>
      <div class="flex gap-2 mb-4">
        <button class="px-4 py-2 border rounded hover:bg-orange-100">ASAP</button>
        <button class="px-4 py-2 border bg-orange-500 text-white rounded">30 min</button>
        <button class="px-4 py-2 border rounded hover:bg-orange-100">45 min</button>
      </div>
      <input type="text" placeholder="Any special instructions?" class="w-full border p-2 rounded mb-4">
      <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded font-semibold">
        Schedule Pickup
      </button>
    </div>
  </div>
</section>

<section class="bg-white text-black px-4 py-14 sm:px-8 md:px-16 lg:px-24">
  <h2 class="text-center text-3xl font-bold mb-2">Reviews & Ratings</h2>
  <p class="text-center text-gray-500 mb-10">See what our customers are saying about their experiences</p>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Review Card 1 -->
    <div class="bg-gray-50 border-2 border-orange-500 rounded-xl p-6 shadow-sm hover:shadow-md transition">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Customer" class="w-12 h-12 rounded-full object-cover">
        <div>
          <h3 class="font-semibold">Amanda Silva</h3>
          <p class="text-sm text-gray-500">1 week ago</p>
        </div>
      </div>

      <div class="flex items-center text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>

      <div class="flex gap-2 mb-3 flex-wrap">
        <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">Verified Visit</span>
        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded">Tourist Favorite</span>
      </div>

      <p class="text-sm text-gray-700 mb-4">
        We were warmly welcomed and seated right by the window. The ambiance was lovely, and our dishes arrived quickly.
        The seafood curry was rich and flavorful. Easily one of the best dining experiences I’ve had during my trip to Colombo.
      </p>

      <p class="text-xs text-gray-500 italic">Ordered from: <strong>Spice Garden</strong></p>
    </div>

    <!-- Review Card 2 -->
    <div class="bg-gray-50 border-2 border-orange-500 rounded-xl p-6 shadow-sm hover:shadow-md transition">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://randomuser.me/api/portraits/men/33.jpg" alt="Customer" class="w-12 h-12 rounded-full object-cover">
        <div>
          <h3 class="font-semibold">Nuwan Perera</h3>
          <p class="text-sm text-gray-500">3 days ago</p>
        </div>
      </div>

      <div class="flex items-center text-yellow-400 mb-2">
        <span>★★★★☆</span>
      </div>

      <div class="flex gap-2 mb-3">
        <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">Verified Visit</span>
      </div>

      <p class="text-sm text-gray-700 mb-4">
        The delivery was prompt, arriving even earlier than expected. Everything was neatly packed and still warm.
        The chicken kottu was delicious, though the spice level was a bit higher than I prefer. Will definitely reorder!
      </p>

      <p class="text-xs text-gray-500 italic">Ordered from: <strong>Hopper House</strong></p>
    </div>

    <!-- Review Card 3 -->
    <div class="bg-gray-50 border-2 border-orange-500 rounded-xl p-6 shadow-sm hover:shadow-md transition">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Customer" class="w-12 h-12 rounded-full object-cover">
        <div>
          <h3 class="font-semibold">Dilani Fernando</h3>
          <p class="text-sm text-gray-500">5 days ago</p>
        </div>
      </div>

      <div class="flex items-center text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>

      <div class="flex gap-2 mb-3">
        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded">Tourist Favorite</span>
      </div>

      <p class="text-sm text-gray-700 mb-4">
        This place never disappoints! I picked up my lunch and it was ready on time, hot and fresh. The staff were polite,
        and I loved the traditional flavors in their rice & curry combo. Highly recommended for locals and tourists alike.
      </p>

      <p class="text-xs text-gray-500 italic">Ordered from: <strong>Village Delight</strong></p>
    </div>

  </div>
</section>








</body>
</html>

<?php include '../components/footer.php'; ?>
