<?php
include '../../config/db.php';
include '../components/sidebarOwner.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch the menu item by ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid menu ID.";
    exit();
}

$menu_id = $_GET['id'];

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM menus WHERE id = ?");
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();

if (!$menu) {
    echo "Menu item not found.";
    exit();
}

// Handle update form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $restaurant_id = $_POST['restaurant_id'];
    $image = $menu['image']; // default: keep old image

    // Handle image update (if provided)
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../../assets/images/menus/';
        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        $relativePath = 'assets/images/menus/' . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $relativePath;
        }
    } elseif (!empty($_POST['image_url'])) {
        $image = trim($_POST['image_url']);
    }

    // Update DB
    $update = $conn->prepare("UPDATE menus SET name = ?, description = ?, price = ?, image = ?, restaurant_id = ? WHERE id = ?");
    $update->bind_param("ssdssi", $name, $description, $price, $image, $restaurant_id, $menu_id);

    if ($update->execute()) {
        header("Location: manageMenus.php");
        exit();
    } else {
        echo "Error updating menu: " . $update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-2xl mx-auto p-6 ml-64">
        <h1 class="text-3xl font-bold text-orange-600 mb-6">Edit Menu Item</h1>

        <form method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-6 space-y-4">
            <select name="restaurant_id" required class="w-full border border-gray-300 p-2 rounded">
                <option value="" disabled>Select Restaurant</option>
                <?php
                $restaurants = $conn->query("SELECT id, name FROM restaurants");
                while ($rest = $restaurants->fetch_assoc()):
                ?>
                <option value="<?= $rest['id'] ?>" <?= $rest['id'] == $menu['restaurant_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($rest['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>

            <input type="text" name="name" value="<?= htmlspecialchars($menu['name']) ?>" required class="w-full border border-gray-300 p-2 rounded" />
            <textarea name="description" required class="w-full border border-gray-300 p-2 rounded" rows="3"><?= htmlspecialchars($menu['description']) ?></textarea>
            <input type="number" step="0.01" min="0" name="price" value="<?= htmlspecialchars($menu['price']) ?>" required class="w-full border border-gray-300 p-2 rounded" />

            <label class="block text-orange-600 font-medium">Upload New Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 p-2 rounded" />

            <label class="block text-orange-600 font-medium">Or Enter Image URL</label>
            <input type="text" name="image_url" placeholder="https://example.com/image.jpg" class="w-full border border-gray-300 p-2 rounded" />

            <div class="flex items-center space-x-4 mt-4">
                <?php if (!empty($menu['image'])): ?>
                    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="Current Image" class="w-20 h-20 object-cover border rounded" />
                <?php else: ?>
                    <span>No image available</span>
                <?php endif; ?>
            </div>

            <button type="submit" name="update" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition transform hover:scale-105">
                Update Menu
            </button>
        </form>
    </div>
</body>
</html>
