<?php include __DIR__ . '/../components/header.php'; ?>
<?php

require_once '../../config/db.php';

// Fetch menu items from the database using MySQLi
$result = $conn->query("SELECT * FROM menus LIMIT 9");

if (!$result) {
    die("Database query failed: " . $conn->error);
}

$menuItems = [];
while ($row = $result->fetch_assoc()) {
    $menuItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-7xl mx-auto p-6 flex flex-col lg:flex-row gap-6">

    <!-- ✅ Sidebar Filters -->
    <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow-md p-4 space-y-6">
        <h2 class="text-xl font-bold">Advanced Filters</h2>

        <!-- Cuisine Filter -->
        <div>
            <h3 class="font-semibold mb-2">Cuisine</h3>
            <ul class="space-y-1">
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Sri Lankan <span class="text-gray-500">142</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Indian <span class="text-gray-500">89</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Chicken <span class="text-gray-500">63</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Thai <span class="text-gray-500">37</span></label></li>
            </ul>
        </div>

        <!-- Dietary Filter -->
        <div>
            <h3 class="font-semibold mb-2">Dietary</h3>
            <ul class="space-y-1">
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Vegetarian <span class="text-gray-500">72</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Vegan <span class="text-gray-500">38</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Gluten-Free <span class="text-gray-500">21</span></label></li>
            </ul>
        </div>

        <!-- Budget Filter -->
        <div>
            <h3 class="font-semibold mb-2">Budget</h3>
            <ul class="space-y-1">
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Under LKR 500 <span class="text-gray-500">45</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> LKR 500 - 1000 <span class="text-gray-500">83</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Over LKR 1000 <span class="text-gray-500">61</span></label></li>
            </ul>
        </div>

        <!-- Features Filter -->
        <div>
            <h3 class="font-semibold mb-2">Features</h3>
            <ul class="space-y-1">
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Spicy <span class="text-gray-500">58</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Popular <span class="text-gray-500">102</span></label></li>
                <li><label class="flex justify-between"><input type="checkbox" class="mr-2"> Healthy <span class="text-gray-500">40</span></label></li>
            </ul>
        </div>
    </aside>

    <!-- ✅ Main Menu Grid -->
    <section class="w-full lg:w-3/4">
        <h1 class="text-3xl font-bold mb-6">Browse Our Menu</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($menuItems as $item): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="<?= (filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : 'images/' . htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold"><?= htmlspecialchars($item['name']) ?></h2>
                        <p class="text-gray-600 mb-4">LKR <?= number_format($item['price'], 2) ?></p>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['name']) ?>">
                            <input type="hidden" name="item_price" value="<?= htmlspecialchars($item['price']) ?>">
                            <button type="submit" name="add_to_cart" class="w-full bg-orange-500 text-white py-2 px-4 rounded flex items-center justify-center hover:bg-orange-600 transition">
                                <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>

  <?php include __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
