<?php
session_start();
include("../../config/db.php");

// Redirect if user is not logged in
if (!isset($_SESSION['owner_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

// Check if restaurant ID is provided
if (!isset($_GET['id'])) {
    echo "No restaurant ID provided.";
    exit();
}

$restaurant_id = $_GET['id'];

// Fetch restaurant data
$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ? AND owner_id = ?");
$stmt->bind_param("ii", $restaurant_id, $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Restaurant not found or access denied.";
    exit();
}

$restaurant = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $cuisine = $_POST['cuisine'];
    $rating = $_POST['rating'];
    $image_url = $_POST['image_url'];

    $update = $conn->prepare("UPDATE restaurants SET name=?, location=?, cuisine=?, rating=?, image_url=? WHERE id=? AND owner_id=?");
    $update->bind_param("ssssssi", $name, $location, $cuisine, $rating, $image_url, $restaurant_id, $owner_id);

    if ($update->execute()) {
        header("Location: manageRestaurant.php");
        exit();
    } else {
        echo "Error updating restaurant.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Restaurant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-xl mx-auto p-6 mt-10 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-orange-600 mb-6">Edit Restaurant</h2>

        <form method="post" class="space-y-4">
            <div>
                <label class="block font-medium">Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($restaurant['name']) ?>" required class="w-full px-4 py-2 border rounded">
            </div>
            <div>
                <label class="block font-medium">Location:</label>
                <input type="text" name="location" value="<?= htmlspecialchars($restaurant['location']) ?>" required class="w-full px-4 py-2 border rounded">
            </div>
            <div>
                <label class="block font-medium">Cuisine:</label>
                <input type="text" name="cuisine" value="<?= htmlspecialchars($restaurant['cuisine']) ?>" required class="w-full px-4 py-2 border rounded">
            </div>
            <div>
                <label class="block font-medium">Rating:</label>
                <input type="text" name="rating" value="<?= htmlspecialchars($restaurant['rating']) ?>" required class="w-full px-4 py-2 border rounded">
            </div>
            <div>
                <label class="block font-medium">Image URL:</label>
                <input type="text" name="image_url" value="<?= htmlspecialchars($restaurant['image_url']) ?>" class="w-full px-4 py-2 border rounded">
                <?php if (!empty($restaurant['image_url'])): ?>
                    <img src="<?= htmlspecialchars($restaurant['image_url']) ?>" class="w-32 h-32 mt-2 object-cover rounded border">
                <?php endif; ?>
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">Update</button>
                <a href="manageRestaurant.php" class="text-orange-600 hover:underline mt-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
