<?php
session_start();
include '../../config/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

//  session ID to track user's cart
$session_id = session_id();


// Handle AJAX requests for cart operations
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $menu_id = intval($_POST['menu_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);

    if ($action === 'add') {
        // Check if item already in cart
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE session_id = ? AND menu_id = ?");
        $stmt->bind_param("si", $session_id, $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Update quantity
            $new_quantity = $row['quantity'] + $quantity;
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update->bind_param("ii", $new_quantity, $row['id']);
            $update->execute();
        } else {
            // Insert new
            $insert = $conn->prepare("INSERT INTO cart (session_id, menu_id, quantity) VALUES (?, ?, ?)");
            $insert->bind_param("sii", $session_id, $menu_id, $quantity);
            $insert->execute();
        }
        echo json_encode(['status' => 'success', 'message' => 'Added to cart']);
        exit;
    }

    if ($action === 'remove') {
        $delete = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND menu_id = ?");
        $delete->bind_param("si", $session_id, $menu_id);
        $delete->execute();
        echo json_encode(['status' => 'success', 'message' => 'Removed from cart']);
        exit;
    }

    if ($action === 'update') {
        if ($quantity <= 0) {
            // Remove if quantity zero or less
            $delete = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND menu_id = ?");
            $delete->bind_param("si", $session_id, $menu_id);
            $delete->execute();
        } else {
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE session_id = ? AND menu_id = ?");
            $update->bind_param("isi", $quantity, $session_id, $menu_id);
            $update->execute();
        }
        echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
        exit;
    }
}


// Fetch all menu items
$result = $conn->query("SELECT * FROM menus"); 
if (!$result) {
    die("Query failed: " . $conn->error);
}
$menus = [];
while ($row = $result->fetch_assoc()) {
    $menus[] = $row;
}

// Fetch cart items for current session
$stmt = $conn->prepare("
    SELECT c.menu_id, c.quantity, m.name, m.price 
    FROM cart c 
    JOIN menus m ON c.menu_id = m.id 
    WHERE c.session_id = ?
");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$cart_result = $stmt->get_result();
$orderItems = [];
while ($row = $cart_result->fetch_assoc()) {
    $orderItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    // AJAX helper
    async function ajaxCart(action, menu_id, quantity=1) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('menu_id', menu_id);
        formData.append('quantity', quantity);

        const response = await fetch('menu.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if(data.status === 'success') {
            // Refresh cart display
            loadCart();
        } else {
            alert('Something went wrong.');
        }
    }

    // Load cart summary via AJAX (simple approach)
    async function loadCart() {
        const response = await fetch('cart_summary.php'); // We'll create this endpoint below
        const html = await response.text();
        document.getElementById('cart-summary').innerHTML = html;
    }

    // On page load, load cart
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();

        // Attach add to cart handlers
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                const quantity = parseInt(qtyElem.value) || 1;
                ajaxCart('add', menuId, quantity);
            });
        });

        // Attach quantity increment/decrement
        document.querySelectorAll('.qty-decrease').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                let val = parseInt(qtyElem.value) || 1;
                if(val > 1) val--;
                qtyElem.value = val;
            });
        });

        document.querySelectorAll('.qty-increase').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                let val = parseInt(qtyElem.value) || 1;
                val++;
                qtyElem.value = val;
            });
        });
    });
    </script>
</head>


<!-- Banner Section -->
<div class="relative h-[350px]">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://media.cntravellerme.com/photos/66cc5cb74871ab67bc593f1b/16:9/w_2560%2Cc_limit/ShoulldersByHarpos3.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- Transparent dark overlay -->
    </div>

    <!-- Banner Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-10 text-center text-white">
        <h1 class="text-5xl font-extrabold mb-2">Where Flavor Meets Passion</h1>
        <p class="text-xl font-light italic">Delicious meals, made fresh for you</p>
    </div>
</div>

<!-- Nav, Cancel & Confirm -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="home.php" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="restuarants.php" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
    
  </div>

  <a href="checkout.php" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    Proceed to Cart →
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
                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                <span class="text-sm mt-1 text-orange-500">View Restaurant</span>
            </div>
            <div class="w-16 h-1 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">3</div>
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
<!-- Main Container -->
<div class="flex flex-col lg:flex-row max-w-7xl mx-auto p-6 gap-6">

    <!-- Menu Items Section -->
    <div class="flex-1">
        <h1 class="text-4xl font-bold text-orange-600 mb-6">Full Menu</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($menus as $menu): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                    <!-- Image -->
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
                            $tagsArray = array_map('trim', explode(',', $menu['tags'] ?? ''));
                            foreach ($tagsArray as $tag) {
                                switch (strtolower($tag)) {
                                    case 'vegetarian':
                                        echo '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">🥦 Vegetarian</span>';
                                        break;
                                    case 'spicy':
                                        echo '<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full">🌶️ Spicy</span>';
                                        break;
                                    case 'gluten-free':
                                        echo '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">🌾 Gluten-Free</span>';
                                        break;
                                    case 'gluten':
                                        echo '<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full">🌾 Contains Gluten</span>';
                                        break;
                                }
                            }
                            ?>
                        </div>

                        <!-- Quantity controls -->
                        <div class="flex items-center mb-3 gap-2">
                            <button data-menu-id="<?= $menu['id'] ?>" class="qty-decrease bg-gray-200 rounded px-3 py-1 hover:bg-gray-300">-</button>
                            <input id="qty-<?= $menu['id'] ?>" type="number" min="1" value="1" class="w-12 text-center rounded border border-gray-300">
                            <button data-menu-id="<?= $menu['id'] ?>" class="qty-increase bg-gray-200 rounded px-3 py-1 hover:bg-gray-300">+</button>
                        </div>

                        <button data-menu-id="<?= $menu['id'] ?>" class="add-to-cart-btn w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700 transition">
                            Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div id="cart-summary" class="w-full lg:w-96 bg-white rounded-lg shadow-lg p-6 sticky top-6 self-start">
        <!-- Cart summary will load here by AJAX -->
        <h2 class="text-2xl font-bold mb-4 text-orange-600">Order Summary</h2>
        <p>Loading your cart...</p>
    </div>
    
</div>
</body>
</html>