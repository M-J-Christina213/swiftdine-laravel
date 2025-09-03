<?php include '../components/sidebarAdmin.php'; ?>

<?php
error_reporting(E_ALL);
$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);

// Delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM discounts WHERE id=$id");
  header("Location: manageDiscounts.php");
  exit();
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_discount'])) {
    $id = intval($_POST['id']);
    $restaurant_id = intval($_POST['restaurant_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $discount = floatval($_POST['discount']);
    $validity = $conn->real_escape_string($_POST['validity']);

    $conn->query("UPDATE discounts SET restaurant_id=$restaurant_id, description='$description', discount=$discount, validity='$validity' WHERE id=$id");
    header("Location: manageDiscounts.php");
    exit();
  }

  // Add New
  if (isset($_POST['add_discount'])) {
    $restaurant_id = intval($_POST['restaurant_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $discount = floatval($_POST['discount']);
    $validity = $conn->real_escape_string($_POST['validity']);

    // Handle image upload
    $image_path = "NULL";
    if (!empty($_FILES['image']['name'])) {
      $target_dir = "../uploads/deals/";
      $image_name = basename($_FILES["image"]["name"]);
      $target_file = $target_dir . $image_name;

      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = "'/uploads/deals/$image_name'";
      }
    }

    $conn->query("INSERT INTO discounts (restaurant_id, description, discount, validity, image, created_at) VALUES ($restaurant_id, '$description', $discount, '$validity', $image_path, NOW())");
    header("Location: manageDiscounts.php");
    exit();
  }
}

// Fetch
$result = $conn->query("SELECT * FROM deals ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Discounts - SwiftDine Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showEditForm(id) {
      document.getElementById('display_row_' + id).style.display = 'none';
      document.getElementById('edit_row_' + id).style.display = 'table-row';
    }
    function cancelEdit(id) {
      document.getElementById('edit_row_' + id).style.display = 'none';
      document.getElementById('display_row_' + id).style.display = 'table-row';
    }
    function showAddForm() {
      document.getElementById('add_discount_form').style.display = 'table-row';
      document.getElementById('add_discount_btn').style.display = 'none';
    }
    function cancelAdd() {
      document.getElementById('add_discount_form').style.display = 'none';
      document.getElementById('add_discount_btn').style.display = 'inline-block';
    }
  </script>
</head>
<body class="flex bg-gray-50 min-h-screen font-sans">

<main class="flex-1 p-10 ml-64 bg-white shadow-lg rounded-lg mx-6 my-6">
  <h1 class="text-3xl font-bold text-orange-600 mb-6">Manage Discounts</h1>

  <button id="add_discount_btn" onclick="showAddForm()" class="mb-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">+ Add Discount</button>

  <table class="min-w-full border border-gray-300 rounded overflow-hidden">
    <thead class="bg-orange-100">
      <tr>
        <th class="p-2 border-b">ID</th>
        <th class="p-2 border-b">Restaurant ID</th>
        <th class="p-2 border-b">Description</th>
        <th class="p-2 border-b">Discount</th>
        <th class="p-2 border-b">Validity</th>
        <th class="p-2 border-b">Image</th>
        <th class="p-2 border-b">Created At</th>
        <th class="p-2 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Add Form -->
      <tr id="add_discount_form" style="display:none;" class="bg-green-50">
        <form method="post" action="manageDiscounts.php" enctype="multipart/form-data">
          <td class="p-2">New</td>
          <td class="p-2"><input type="number" name="restaurant_id" required class="border px-2 py-1 rounded w-full"></td>
          <td class="p-2"><input type="text" name="description" required class="border px-2 py-1 rounded w-full"></td>
          <td class="p-2"><input type="number" name="discount" step="0.01" required class="border px-2 py-1 rounded w-full"></td>
          <td class="p-2"><input type="datetime-local" name="validity" required class="border px-2 py-1 rounded w-full"></td>
          <td class="p-2"><input type="file" name="image" class="border px-2 py-1 rounded w-full"></td>
          <td class="p-2">--</td>
          <td class="p-2 flex gap-2">
            <button type="submit" name="add_discount" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Add</button>
            <button type="button" onclick="cancelAdd()" class="bg-gray-400 text-white px-4 py-1 rounded hover:bg-gray-500">Cancel</button>
          </td>
        </form>
      </tr>

      <!-- Rows -->
      <?php while ($row = $result->fetch_assoc()): ?>
        <!-- Display -->
        <tr id="display_row_<?= $row['id'] ?>" class="hover:bg-orange-50 border-b">
          <td class="p-2"><?= $row['id'] ?></td>
          <td class="p-2"><?= $row['restaurant_id'] ?></td>
          <td class="p-2"><?= htmlspecialchars($row['description']) ?></td>
          <td class="p-2"><?= $row['discount'] ?>%</td>
          <td class="p-2"><?= $row['validity'] ?></td>
          <td class="p-2"><?= $row['image'] ? "<img src='{$row['image']}' class='w-16 h-12 object-cover'>" : '—' ?></td>
          <td class="p-2"><?= $row['created_at'] ?></td>
          <td class="p-2 flex gap-4">
            <span class="text-blue-600 cursor-pointer hover:underline" onclick="showEditForm(<?= $row['id'] ?>)">Edit</span>
            <a href="manageDiscounts.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this discount?')" class="text-red-600 hover:underline">Delete</a>
          </td>
        </tr>

        <!-- Edit -->
        <tr id="edit_row_<?= $row['id'] ?>" style="display: none;" class="bg-orange-50 border-b">
          <form method="post" action="manageDiscounts.php">
            <td class="p-2"><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"></td>
            <td class="p-2"><input type="number" name="restaurant_id" value="<?= $row['restaurant_id'] ?>" class="border px-2 py-1 rounded w-full"></td>
            <td class="p-2"><input type="text" name="description" value="<?= htmlspecialchars($row['description']) ?>" class="border px-2 py-1 rounded w-full"></td>
            <td class="p-2"><input type="number" name="discount" step="0.01" value="<?= $row['discount'] ?>" class="border px-2 py-1 rounded w-full"></td>
            <td class="p-2"><input type="datetime-local" name="validity" value="<?= str_replace(' ', 'T', $row['validity']) ?>" class="border px-2 py-1 rounded w-full"></td>
            <td class="p-2">Image not editable</td>
            <td class="p-2"><?= $row['created_at'] ?></td>
            <td class="p-2 flex gap-2">
              <button type="submit" name="update_discount" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Update</button>
              <button type="button" onclick="cancelEdit(<?= $row['id'] ?>)" class="bg-gray-400 text-white px-4 py-1 rounded hover:bg-gray-500">Cancel</button>
            </td>
          </form>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

</body>
</html>
