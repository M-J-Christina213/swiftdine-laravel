<?php
require_once '../../config/db.php';

// Handle add supplier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    $conn->query("INSERT INTO suppliers (name, contact_email, phone, address) VALUES ('$name', '$email', '$phone', '$address')");
    header("Location: manageSupplier.php");
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM suppliers WHERE id=$id");
    header("Location: manageSuppliers.php");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_supplier'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    $conn->query("UPDATE suppliers SET name='$name', contact_email='$email', phone='$phone', address='$address' WHERE id=$id");
    header("Location: manageSupplier.php");
    exit();
}

// Fetch suppliers
$sql = "SELECT * FROM suppliers ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Suppliers - SwiftDine Admin</title>
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
  </script>
</head>
<body class="flex font-sans text-gray-900 min-h-screen">

  <!-- Sidebar Include -->
  <?php include('../components/sidebarOwner.php'); ?>

  <!-- Main Content -->
  <main class="flex-1 bg-white p-10 ml-64 overflow-auto">

    <div class="flex justify-between items-center mb-10">
      <h1 class="text-3xl font-bold">Manage Suppliers</h1>
    </div>

    <!-- Add Supplier Form -->
    <div class="mb-8">
      <h2 class="text-2xl font-semibold mb-4">Add New Supplier</h2>
      <form method="post" action="manageSupplier.php" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 bg-orange-50 p-4 rounded-lg shadow">
        <input type="text" name="name" placeholder="Supplier Name" required class="border p-2 rounded" />
        <input type="email" name="email" placeholder="Contact Email" required class="border p-2 rounded" />
        <input type="text" name="phone" placeholder="Phone Number" required class="border p-2 rounded" />
        <input type="text" name="address" placeholder="Address" required class="border p-2 rounded" />
        <div class="md:col-span-2 lg:col-span-4 flex justify-end">
          <button type="submit" name="add_supplier" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Add Supplier</button>
        </div>
      </form>
    </div>

    <!-- Suppliers Table -->
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden text-left">
      <thead class="bg-orange-100 text-orange-800 font-semibold">
        <tr>
          <th class="p-3 border-b border-orange-300">ID</th>
          <th class="p-3 border-b border-orange-300">Name</th>
          <th class="p-3 border-b border-orange-300">Email</th>
          <th class="p-3 border-b border-orange-300">Phone</th>
          <th class="p-3 border-b border-orange-300">Address</th>
          <th class="p-3 border-b border-orange-300">Created At</th>
          <th class="p-3 border-b border-orange-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <!-- Display Row -->
            <tr id="display_row_<?= $row['id'] ?>" class="hover:bg-orange-50">
              <td class="p-3 border-b border-gray-200"><?= $row['id'] ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['name']) ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['contact_email']) ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['phone']) ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['address']) ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="p-3 border-b border-gray-200 space-x-2">
                <button onclick="showEditForm(<?= $row['id'] ?>)" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                <a href="manageSupplier.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this supplier?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
              </td>
            </tr>

            <!-- Edit Row -->
            <tr id="edit_row_<?= $row['id'] ?>" style="display:none;" class="bg-orange-50">
              <form method="post" action="manageSupplier.php">
                <td class="p-3 border-b border-gray-200"><?= $row['id'] ?>
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                </td>
                <td class="p-3 border-b border-gray-200"><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="border rounded px-2 py-1 w-full" required></td>
                <td class="p-3 border-b border-gray-200"><input type="email" name="email" value="<?= htmlspecialchars($row['contact_email']) ?>" class="border rounded px-2 py-1 w-full" required></td>
                <td class="p-3 border-b border-gray-200"><input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="border rounded px-2 py-1 w-full" required></td>
                <td class="p-3 border-b border-gray-200"><input type="text" name="address" value="<?= htmlspecialchars($row['address']) ?>" class="border rounded px-2 py-1 w-full" required></td>
                <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['created_at']) ?></td>
                <td class="p-3 border-b border-gray-200 space-x-2">
                  <button type="submit" name="update_supplier" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
                  <button type="button" onclick="cancelEdit(<?= $row['id'] ?>)" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
                </td>
              </form>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="p-4 text-center text-gray-500">No suppliers found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

</body>
</html>

<?php $conn->close(); ?>
