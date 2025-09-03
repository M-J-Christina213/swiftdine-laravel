<?php
session_start();
error_reporting(E_ALL);

// DB connection
$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);

// Handle Delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
  $delete_id = $_POST['delete_id'];

  // Optional: delete image file too if needed
  $imageQuery = $conn->prepare("SELECT image_url FROM restaurants WHERE id = ?");
  $imageQuery->bind_param("i", $delete_id);
  $imageQuery->execute();
  $imageResult = $imageQuery->get_result()->fetch_assoc();
  if (!empty($imageResult['image_url']) && file_exists($imageResult['image_url'])) {
    unlink($imageResult['image_url']);
  }

  // Delete restaurant
  $stmt = $conn->prepare("DELETE FROM restaurants WHERE id = ?");
  $stmt->bind_param("i", $delete_id);
  $stmt->execute();
}

// Fetch all restaurants
$result = $conn->query("SELECT * FROM restaurants");
?>

<?php include '../components/sidebarAdmin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Restaurants - SwiftDine</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

  <main class="flex-1 p-10 ml-64 bg-white overflow-x-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Manage Restaurants</h1>
      <a href="addRestaurant.php" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">➕ Add Restaurant</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Image</th>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Location</th>
          <th class="px-4 py-3">Cuisine</th>
          <th class="px-4 py-3">Rating</th>
          <th class="px-4 py-3">Owner</th>
          <th class="px-4 py-3">Created At</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3"><?php echo $row['id']; ?></td>
            <td class="px-4 py-3">
              <?php if (!empty($row['image_url'])): ?>
                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="w-16 h-16 rounded object-cover">
              <?php else: ?>
                <span class="text-gray-400 italic">No image</span>
              <?php endif; ?>
            </td>
            <td class="px-4 py-3"><?php echo $row['name']; ?></td>
            <td class="px-4 py-3"><?php echo $row['location']; ?></td>
            <td class="px-4 py-3"><?php echo $row['cuisine']; ?></td>
            <td class="px-4 py-3"><?php echo $row['rating']; ?></td>
            <td class="px-4 py-3"><?php echo $row['owner_id']; ?></td>
            <td class="px-4 py-3"><?php echo $row['created_at']; ?></td>
            <td class="px-4 py-4 flex items-center gap-2">
              <!-- Edit Button -->
              <a href="editRestaurant.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline inline">Edit</a>

              <!-- Delete Form -->
              <form method="POST" onsubmit="return confirm('Are you sure you want to delete this restaurant?');">
                <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <button type="submit" class="text-red-500 hover:underline inline">Delete</button>
              </form>
            </td>

          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
