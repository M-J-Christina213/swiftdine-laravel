<?php include '../components/sidebarOwner.php'; ?>
<?php
session_start();
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $cuisine = $_POST['cuisine'];
  $rating = $_POST['rating'];
  $owner_id = $_POST['owner_id'];
  $imagePath = '';

  // Use uploaded file if provided
  if (!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $targetDir = "../assets/images/";
    
    // Make sure the folder exists
    if (!file_exists($targetDir)) {
      mkdir($targetDir, 0777, true);
    }

    $uniqueName = uniqid() . "_" . basename($imageName);
    $targetPath = $targetDir . $uniqueName;

    if (move_uploaded_file($imageTmp, $targetPath)) {
      // Save relative path to use in HTML
      $imagePath = "assets/images/" . $uniqueName;
    } else {
      echo "❌ Failed to upload the image. Please try again.";
      exit();
    }
  }
  // If no file uploaded, use image URL
  elseif (!empty($_POST['image_url'])) {
    $imagePath = $_POST['image_url'];
  }

  $stmt = $conn->prepare("INSERT INTO restaurants (name, location, cuisine, rating, owner_id, image_url) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssdis", $name, $location, $cuisine, $rating, $owner_id, $imagePath);

  if ($stmt->execute()) {
    header("Location: manageRestaurants.php");
    exit();
  } else {
    echo "❌ Error: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Restaurant</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10 ml-64">

  <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-orange-600">➕ Add New Restaurant</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="text" name="name" placeholder="Restaurant Name" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="location" placeholder="Location" required class="w-full border px-4 py-2 rounded">
      <input type="text" name="cuisine" placeholder="Cuisine" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" step="0.1" required class="w-full border px-4 py-2 rounded">
      <input type="number" name="owner_id" placeholder="Owner ID" required class="w-full border px-4 py-2 rounded">

      <div>
        <label class="block mb-1">Upload Image (or enter URL)</label>
        <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">
        <input type="text" name="image_url" placeholder="Or paste image URL here" class="w-full border px-4 py-2 rounded mt-2">
      </div>

      <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Add Restaurant</button>
    </form>
  </div>
</body>
</html>
