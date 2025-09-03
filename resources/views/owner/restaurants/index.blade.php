<?php include '../components/sidebarOwner.php'; ?>

<?php
include("../../config/db.php");
session_start();

if (!isset($_SESSION['owner_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

// Handle delete action inline
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM restaurants WHERE id = ? AND owner_id = ?");
    $stmt->bind_param("ii", $delete_id, $owner_id);
    $stmt->execute();
    header("Location: view_restaurants.php"); // Refresh page after deletion
    exit();
}

$result = $conn->query("SELECT * FROM restaurants WHERE owner_id = $owner_id");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View My Restaurants</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
    <div class="max-w-6xl mx-auto p-6 ml-64">
        <h2 class="text-3xl font-bold text-orange-600 mb-6">My Restaurants</h2>

        <a href="addRestaurant.php" class="mb-4 inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded">
            + Add New Restaurant
        </a>

        <div class="overflow-x-auto mt-4 shadow-md rounded-lg border border-orange-200 bg-white">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-orange-100 border-b border-orange-300 text-orange-700">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Image</th>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Cuisine</th>
                        <th class="py-3 px-4">Rating</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-orange-50">
                            <td class="py-3 px-4"><?= $row['id'] ?></td>
                            <td class="py-3 px-4">
                                <?php if (!empty($row['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-16 h-16 rounded object-cover border border-orange-300 shadow" />
                                <?php else: ?>
                                    <div class="w-16 h-16 flex items-center justify-center bg-orange-200 text-orange-600 rounded">
                                        No Img
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row['location']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row['cuisine']) ?></td>
                            <td class="py-3 px-4"><?= htmlspecialchars($row['rating']) ?></td>
                            <td class="py-3 px-4 space-x-2">
                                <a href="editRestaurant.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                                <a href="?delete_id=<?= $row['id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this restaurant?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
