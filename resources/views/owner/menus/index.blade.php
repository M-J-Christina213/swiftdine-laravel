<?php
include '../../config/db.php';
include '../components/sidebarOwner.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['add'])) {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image: prioritize upload over URL
    $image = '';
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

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO menus (restaurant_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $restaurant_id, $name, $description, $price, $image);

    if ($stmt->execute()) {
        header("Location: manageMenus.php");
        exit();
    } else {
        echo "Error adding menu item: " . $stmt->error;
    }
}


if (isset($_POST['update'])) {
    echo "Update triggered for ID: " . $_POST['id'];
    // you can add exit here to check
    exit();
}


// Fetch menus (you can add filtering by owner or restaurant if needed)
$result = $conn->query("SELECT * FROM menus ORDER BY id DESC");

// Path for uploaded images (relative to document root)
$uploadDir = '/assets/images/menus/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Menus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-7xl mx-auto p-6 ml-64">
        <h1 class="text-3xl font-bold text-orange-600 mb-6">Manage Menus</h1>

        <!-- Add Menu Item Form (optional) -->
        <form method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-6 mb-6 max-w-xl space-y-4">
            <h2 class="text-xl font-semibold text-orange-600">Add Menu Item</h2>
            <select name="restaurant_id" required class="w-full border border-gray-300 p-2 rounded">
                <option value="" disabled selected>Select Restaurant</option>
                <?php
                $restaurants = $conn->query("SELECT id, name FROM restaurants");
                while ($rest = $restaurants->fetch_assoc()):
                ?>
                <option value="<?= $rest['id'] ?>"><?= htmlspecialchars($rest['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <input type="text" name="name" placeholder="Food Name" required class="w-full border border-gray-300 p-2 rounded" />
            <textarea name="description" placeholder="Description" required class="w-full border border-gray-300 p-2 rounded" rows="3"></textarea>
            <input type="number" step="0.01" min="0" name="price" placeholder="Price (e.g. 9.99)" required class="w-full border border-gray-300 p-2 rounded" />
            
            <label class="block text-orange-600 font-medium">Upload Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 p-2 rounded cursor-pointer" />

            <label class="block text-orange-600 font-medium">Or Enter Image URL</label>
            <input type="text" name="image_url" placeholder="https://example.com/image.jpg" class="w-full border border-gray-300 p-2 rounded" />


            <button type="submit" name="add" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded transition duration-300 ease-in-out transform hover:scale-105">Add Menu Item</button>
        </form>

        <!-- Menu Items Table -->
        <div class="overflow-x-auto shadow-md rounded-lg border border-orange-200 bg-white">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Image</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        // Get image URL or show placeholder
                        $image = $row['image'];
                        $imagePath = '';
                        if (!empty($image)) {
                            // Check if image is URL or local file
                            if (filter_var($image, FILTER_VALIDATE_URL)) {
                                $imagePath = $image;
                            } else {
                                // Build relative path for HTML img src
                                $filePath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $image;
                                if (file_exists($filePath)) {
                                    $imagePath = $uploadDir . $image;
                                }
                            }
                        }
                    ?>
                    <tr class="border-b hover:bg-orange-50">
                        <td class="py-3 px-4 align-middle"><?= $row['id'] ?></td>
                        <td class="py-3 px-4 align-middle">
                            <?php if ($imagePath): ?>
                                <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-16 h-16 rounded object-cover border border-orange-300 shadow" />
                            <?php else: ?>
                                <div class="w-16 h-16 flex items-center justify-center bg-orange-200 text-orange-600 rounded">
                                    No Img
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 align-middle"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="py-3 px-4 align-middle"><?= htmlspecialchars($row['description']) ?></td>
                        <td class="py-3 px-4 align-middle"><?= number_format($row['price'], 2) ?></td>
                        <td class="py-3 px-4 align-middle space-x-4">
                            <a href="editMenus.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this menu item?')" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
