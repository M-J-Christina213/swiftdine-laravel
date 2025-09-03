<?php include '../components/sidebarAdmin.php'; ?>

<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);
error_reporting(E_ALL);
session_start();

if (!isset($_GET['id'])) {
  echo "❌ No restaurant ID provided.";
  exit;
}

$id = $_GET['id'];

// Fetch restaurant info
$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "❌ Restaurant not found.";
  exit;
}

$restaurant = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $cuisine = $_POST['cuisine'];
  $rating = $_POST['rating'];
  $owner_id = $_POST['owner_id'];

  // Handle image update if a new one is uploaded
  if (!empty($_FILES['image']['name'])) {
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
  } else {
    $imagePath = $restaurant['image_url']; // Keep existing image
  }

  $updateStmt = $conn->prepare("UPDATE restaurants SET name = ?, location = ?, cuisine = ?, rating = ?, owner_id = ?, image_url = ? WHERE id = ?");
  $updateStmt->bind_param("sssdisi", $name, $location, $cuisine, $rating, $owner_id, $imagePath, $id);

  if ($updateStmt->execute()) {
    header("Location: manageRestaurants.php");
    exit;
  } else {
    echo "❌ Failed to update: " . $updateStmt->error;
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
<body class="bg-gray-50 p-10">

  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-orange-600">Edit Restaurant</h1>
    
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Restaurant Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($restaurant['name']); ?>" class="w-full px-4 py-2 border rounded" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Location</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($restaurant['location']); ?>" class="w-full px-4 py-2 border rounded" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Cuisine</label>
        <input type="text" name="cuisine" value="<?php echo htmlspecialchars($restaurant['cuisine']); ?>" class="w-full px-4 py-2 border rounded" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Rating</label>
        <input type="number" step="0.1" name="rating" value="<?php echo htmlspecialchars($restaurant['rating']); ?>" class="w-full px-4 py-2 border rounded" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Owner ID</label>
        <input type="number" name="owner_id" value="<?php echo htmlspecialchars($restaurant['owner_id']); ?>" class="w-full px-4 py-2 border rounded" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Current Image</label><br>
        <?php if (!empty($restaurant['image_url'])): ?>
          <img src="<?php echo htmlspecialchars($restaurant['image_url']); ?>" class="w-24 h-24 object-cover rounded mb-2">
        <?php else: ?>
          <span class="text-gray-400 italic">No image uploaded</span>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-medium">Change Image (optional)</label>
        <input type="file" name="image" class="w-full px-4 py-2 border rounded">
      </div>

      <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Update Restaurant</button>
    </form>
  </div>

</body>
</html>
