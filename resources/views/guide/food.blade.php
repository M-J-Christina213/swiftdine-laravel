
<?php include __DIR__ . '/../components/header.php'; ?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Food Guide Sri Lanka</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Banner -->
  <section class="relative h-[400px] md:h-[500px] bg-cover bg-center" style="background-image: url('../../assets/images/foodguide/foodguide.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
      <div class="container mx-auto px-6 md:px-12 max-w-6xl flex flex-col md:flex-row justify-start items-center md:items-start space-y-6 md:space-y-0 md:space-x-12">
        <div class="text-white max-w-lg">
          <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">Your Culinary Compass in Sri Lanka</h1>
          <p class="mb-6 text-lg md:text-xl">Educate, inspire, and connect users to Sri Lankan food culture — perfect for tourists, food lovers, or first-time diners.</p>
          <div class="flex space-x-4">
            <a href="#menus" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition">Explore Dishes</a>
            <button class="border border-white text-white px-6 py-3 rounded-lg hover:bg-white hover:text-black transition">Watch Food Stories</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Food Stories -->
  <section class="container mx-auto px-6 md:px-12 py-12">
    <h2 class="text-3xl font-bold mb-8 flex items-center space-x-3">
      <span>🇱🇰</span>
      <span>Featured Food Stories</span>
    </h2>
    <div class="grid md:grid-cols-3 gap-8">
      <?php
      $stories = [
        [
          'title' => 'The Story Behind the Hopper',
          'img' => 'https://i0.wp.com/www.lavenderandlovage.com/wp-content/uploads/2016/05/Sri-Lankan-Egg-Hoppers-for-Breakfast.jpg?fit=1200%2C901&ssl=1',
          'cta' => 'Read More',
          'link' => '#'
        ],
        [
          'title' => 'Why Sri Lankans Love Spice',
          'img' => 'https://i.pinimg.com/736x/e3/9b/d7/e39bd751d4154f53604c4460f396d77d.jpg',
          'cta' => 'Watch Related Video',
          'link' => '#'
        ],
        [
          'title' => 'From Palmyrah to Pol Sambol: Sri Lankan Essentials',
          'img' => 'https://i.pinimg.com/736x/b3/2a/2b/b32a2b1e8573adf2751ec9dfe2108a75.jpg',
          'cta' => 'Read More',
          'link' => '#'
        ],
      ];

      foreach ($stories as $story): ?>
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
          <img src="<?= $story['img'] ?>" alt="<?= htmlspecialchars($story['title']) ?>" class="w-full h-48 object-cover" />
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-3"><?= $story['title'] ?></h3>
            <a href="<?= $story['link'] ?>" class="text-orange-500 font-semibold hover:underline"><?= $story['cta'] ?></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Explore by Region -->
  <section class="container mx-auto px-6 md:px-12 py-12 flex flex-col md:flex-row gap-12 items-start">
    <div class="md:w-1/2 h-80 md:h-[400px] rounded-lg overflow-hidden shadow-lg">
      <!-- Embedded Google Map -->
      <!-- Embedded Google Map - Colombo -->
      <iframe
        class="w-full h-96 rounded-lg"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63360.292155879745!2d79.83105558737792!3d6.927078849687859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2592486aa32d7%3A0x2c1d23773995ec5e!2sColombo!5e0!3m2!1sen!2slk!4v1716721415805!5m2!1sen!2slk"
        title="Colombo Map"
        frameborder="0"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>

    </div>
    <div class="md:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-6">
      <?php
      $regions = [
        'North' => ['Jaffna Crab Curry', 'Palmyrah Products'],
        'South' => ['Hikkaduwa Seafood', 'Coconut Sambol'],
        'East' => ['Batticaloa Sweets', 'Spiced Rice'],
        'West' => ['Colombo Fusion Foods', 'Street Eats'],
      ];
      ?>
      <?php foreach ($regions as $region => $dishes): ?>
        <div class="bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition cursor-pointer group">
          <h4 class="font-semibold text-xl mb-2 group-hover:text-orange-500"><?= $region ?></h4>
          <ul class="list-disc list-inside text-gray-700 space-y-1">
            <?php foreach ($dishes as $dish): ?>
              <li class="hover:text-orange-500 transition"><?= $dish ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Food Experience Videos & Reels -->
  <section class="container mx-auto px-6 md:px-12 py-12">
    <h2 class="text-3xl font-bold mb-8">📽️ Food Experience Videos & Reels</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <?php
      $videos = [
        ['title' => 'Trying Spicy Street Kottu in Galle', 'thumbnail' => 'https://i.pinimg.com/736x/73/e1/3e/73e13e4645a9a5a0369966a69677c716.jpg'],
        ['title' => 'Local Aunties Make the Best Curry', 'thumbnail' => 'https://i.pinimg.com/736x/04/f3/c9/04f3c9f0133450287343a27522568da4.jpg'],
        ['title' => 'Tourist Tries Finger Food in Pettah', 'thumbnail' => 'https://i.pinimg.com/736x/35/2a/5c/352a5cbcc5b2e89ce8583206f607e460.jpg'],
      ];
      foreach ($videos as $video): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition cursor-pointer">
          <img src="<?= $video['thumbnail'] ?>" alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-48 object-cover" />
          <div class="p-4">
            <h3 class="font-semibold"><?= $video['title'] ?></h3>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Mobile TikTok-style vertical section -->
    <div class="md:hidden mt-8 space-y-6 overflow-x-auto snap-x snap-mandatory flex px-2">
      <?php foreach ($videos as $video): ?>
        <div class="snap-center flex-shrink-0 w-64 bg-white rounded-lg shadow-md overflow-hidden">
          <img src="<?= $video['thumbnail'] ?>" alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-80 object-cover" />
          <div class="p-3">
            <h3 class="font-semibold text-sm"><?= $video['title'] ?></h3>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Visual Food Glossary -->
  <section class="container mx-auto px-6 md:px-12 py-12">
    <h2 class="text-3xl font-bold mb-8">📸 Visual Food Glossary</h2>
    <?php
    $glossary = [
      [
        'name' => 'Hopper',
        'pronunciation' => '(appa)',
        'description' => 'Savory pancake made of fermented rice batter and coconut milk.',
        'tags' => ['Breakfast', 'South', 'Mild'],
        'img' => 'https://i0.wp.com/www.lavenderandlovage.com/wp-content/uploads/2016/05/Sri-Lankan-Egg-Hoppers-for-Breakfast.jpg?fit=1200%2C901&ssl=1',
      ],
      [
        'name' => 'Kottu',
        'pronunciation' => '(cut-roti)',
        'description' => 'Chopped roti stir-fried with vegetables, eggs, or meat.',
        'tags' => ['Lunch', 'All Regions', 'Medium'],
        'img' => 'https://tb-static.uber.com/prod/image-proc/processed_images/ae1ded3f4b533bb99b692dfb335b7d9b/f0d1762b91fd823a1aa9bd0dab5c648d.jpeg',
      ],
      [
        'name' => 'Pol Sambol',
        'pronunciation' => '(coconut sambol)',
        'description' => 'Spicy shredded coconut condiment with chili, lime, and onion.',
        'tags' => ['All Meals', 'All Regions', 'Spicy'],
        'img' => 'https://i.pinimg.com/736x/44/d5/78/44d578cb5b3d6f8e558f3e07eb45a5a5.jpg',
      ],
    ];
    ?>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <?php foreach ($glossary as $item): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
          <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-48 object-cover" />
          <div class="p-5">
            <h3 class="text-xl font-semibold"><?= $item['name'] ?> <span class="text-gray-500 text-sm font-normal"><?= $item['pronunciation'] ?></span></h3>
            <p class="mt-2 text-gray-700 text-sm"><?= $item['description'] ?></p>
            <div class="mt-3 flex flex-wrap gap-2">
              <?php foreach ($item['tags'] as $tag): ?>
                <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-1 rounded-full"><?= $tag ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Interviews with Locals & Experts -->
  <section class="bg-black text-white py-12">
    <div class="container mx-auto px-6 md:px-12">
      <h2 class="text-3xl font-bold mb-8">🎙️ Interviews with Locals & Experts</h2>
      <div class="flex space-x-6 overflow-x-auto snap-x snap-mandatory">
        <?php
        $interviews = [
          [
            'name' => 'Chef Amar',
            'position' => 'Head Chef',
            'quote' => '“Why we marinate for hours.”',
            'img' => 'https://i.pinimg.com/736x/d2/35/47/d2354797cfb995122e8bf0248cb1fd76.jpg',
          ],
          [
            'name' => 'Food Blogger from UK',
            'position' => 'Travel & Food Writer',
            'quote' => '“First Time Trying Sri Lankan Hoppers!”',
            'img' => 'https://i.pinimg.com/736x/fd/6e/5f/fd6e5fe0f138ddb952028934fe3ab378.jpg',
          ],
          [
            'name' => 'Local Father',
            'position' => 'Home Cook',
            'quote' => '“This dish reminds me of my childhood.”',
            'img' => 'https://i.pinimg.com/736x/0f/81/57/0f8157d2e41cef1fa30024d9921ef7a3.jpg',
          ],
        ];
        ?>
        <?php foreach ($interviews as $int): ?>
          <div class="snap-center min-w-[300px] bg-white bg-opacity-10 rounded-lg p-6 flex flex-col items-center text-center shadow-lg hover:bg-opacity-20 transition cursor-pointer">
            <img src="<?= $int['img'] ?>" alt="<?= htmlspecialchars($int['name']) ?>" class="w-24 h-24 rounded-full object-cover mb-4 border-2 border-orange-500" />
            <h3 class="font-semibold text-lg"><?= $int['name'] ?></h3>
            <p class="italic text-sm mb-3"><?= $int['position'] ?></p>
            <blockquote class="text-orange-300 font-semibold text-center">“<?= $int['quote'] ?>”</blockquote>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Dish Comparison Tool -->
  <section class="container mx-auto px-6 md:px-12 py-12">
    <h2 class="text-3xl font-bold mb-8">🔍 Dish Comparison Tool</h2>
    <div class="overflow-x-auto shadow-md rounded-lg">
      <table class="min-w-full text-left text-gray-800">
        <thead class="bg-orange-500 text-white">
          <tr>
            <th class="px-6 py-3">Dish</th>
            <th class="px-6 py-3">Calories</th>
            <th class="px-6 py-3">Spiciness</th>
            <th class="px-6 py-3">Price (Rs.)</th>
            <th class="px-6 py-3">Popularity</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <tr class="border-b hover:bg-orange-50 transition">
            <td class="px-6 py-4 font-semibold">Kottu</td>
            <td class="px-6 py-4">600</td>
            <td class="px-6 py-4">🌶🌶</td>
            <td class="px-6 py-4">450</td>
            <td class="px-6 py-4">⭐⭐⭐⭐⭐</td>
          </tr>
          <tr class="border-b hover:bg-orange-50 transition">
            <td class="px-6 py-4 font-semibold">Fried Rice</td>
            <td class="px-6 py-4">520</td>
            <td class="px-6 py-4">🌶</td>
            <td class="px-6 py-4">400</td>
            <td class="px-6 py-4">⭐⭐⭐⭐</td>
          </tr>
          <tr class="hover:bg-orange-50 transition">
            <td class="px-6 py-4 font-semibold">Biriyani</td>
            <td class="px-6 py-4">700</td>
            <td class="px-6 py-4">🌶🌶🌶</td>
            <td class="px-6 py-4">600</td>
            <td class="px-6 py-4">⭐⭐⭐⭐</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Fun Bits & Edutainment Section -->
  <section class="container mx-auto px-6 md:px-12 py-12">
    <h2 class="text-3xl font-bold mb-8">💡 Fun Bits & Edutainment</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-orange-100 rounded-lg p-6 shadow-md hover:shadow-lg transition cursor-pointer">
        <h3 class="font-semibold text-xl mb-3">Did You Know?</h3>
        <p>Random food facts about Sri Lankan cuisine that will surprise you!</p>
      </div>
      <div class="bg-orange-100 rounded-lg p-6 shadow-md hover:shadow-lg transition cursor-pointer">
        <h3 class="font-semibold text-xl mb-3">🍛 Guess the Dish</h3>
        <p>Try to guess the dish from blurred images or fun emojis.</p>
      </div>
      <div class="bg-orange-100 rounded-lg p-6 shadow-md hover:shadow-lg transition cursor-pointer">
        <h3 class="font-semibold text-xl mb-3">🍴 Poll</h3>
        <p>What’s your ultimate Lankan comfort food? Vote now!</p>
      </div>
    </div>
  </section>


</body>
</html>

  <?php include __DIR__ . '/../components/footer.php'; ?>