<?php include '../components/sidebarAdmin.php'; ?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection (edit credentials as needed)
$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $conn->query("DELETE FROM reviews WHERE id = $deleteId");
    header("Location: manageReviews.php");
    exit;
}

// Fetch reviews with user and restaurant names
$sql = "SELECT reviews.id, users.name AS user_name, restaurants.name AS restaurant_name, 
               reviews.rating, reviews.comment, reviews.created_at 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id 
        JOIN restaurants ON reviews.restaurant_id = restaurants.id 
        ORDER BY reviews.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Reviews - SwiftDine</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

  

  <main class="flex-1 p-10 ml-64 bg-white overflow-x-auto">
    <h1 class="text-3xl font-bold mb-6 text-orange-600">📝 Manage Reviews</h1>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th class="px-4 py-3 text-left">ID</th>
          <th class="px-4 py-3 text-left">User</th>
          <th class="px-4 py-3 text-left">Restaurant</th>
          <th class="px-4 py-3 text-left">Rating</th>
          <th class="px-4 py-3 text-left">Comment</th>
          <th class="px-4 py-3 text-left">Created At</th>
          <th class="px-4 py-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-4 py-3"><?php echo $row['id']; ?></td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($row['user_name']); ?></td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
              <td class="px-4 py-3"><?php echo $row['rating']; ?> ⭐</td>
              <td class="px-4 py-3"><?php echo htmlspecialchars($row['comment']); ?></td>
              <td class="px-4 py-3"><?php echo $row['created_at']; ?></td>
              <td class="px-4 py-3">
                <a href="?delete=<?php echo $row['id']; ?>" 
                   class="text-red-500 hover:underline" 
                   onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="px-4 py-3 text-center text-gray-500">No reviews available.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

</body>
</html>
