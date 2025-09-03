<?php include '../components/sidebarAdmin.php'; ?>
<?php
require_once '../../config/db.php';
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM orders WHERE id=$id");
    header("Location: manageOrders.php");
    exit();
}

// Handle update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE orders SET status='$status' WHERE id=$id");
    header("Location: manageOrders.php");
    exit();
}

// Fetch orders with user and restaurant names
$sql = "SELECT orders.id, orders.user_id, orders.restaurant_id, orders.total_price, orders.status, orders.created_at,
        users.name AS user_name, restaurants.name AS restaurant_name
        FROM orders
        LEFT JOIN users ON orders.user_id = users.id
        LEFT JOIN restaurants ON orders.restaurant_id = restaurants.id
        ORDER BY orders.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Orders - SwiftDine Admin</title>
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
  <?php include('../components/sidebarAdmin.php'); ?>

  <!-- Main Content -->
  <main class="flex-1 bg-white p-10 ml-64 overflow-auto">
    <div class="flex justify-between items-center mb-10">
      <h1 class="text-3xl font-bold">Manage Orders</h1>
      <a href="logout.php" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        Logout
      </a>
    </div>

    <table class="w-full border border-gray-300 rounded-lg overflow-hidden text-left">
      <thead class="bg-orange-100 text-orange-800 font-semibold">
        <tr>
          <th class="p-3 border-b border-orange-300">Order ID</th>
          <th class="p-3 border-b border-orange-300">User</th>
          <th class="p-3 border-b border-orange-300">Restaurant</th>
          <th class="p-3 border-b border-orange-300">Total Price ($)</th>
          <th class="p-3 border-b border-orange-300">Status</th>
          <th class="p-3 border-b border-orange-300">Created At</th>
          <th class="p-3 border-b border-orange-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <!-- Display row -->
            <tr id="display_row_<?= $row['id'] ?>" class="hover:bg-orange-50">
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['id']) ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['restaurant_name'] ?? 'Unknown') ?></td>
              <td class="p-3 border-b border-gray-200"><?= number_format($row['total_price'], 2) ?></td>
              <td class="p-3 border-b border-gray-200">
                <span class="<?= 
                  $row['status'] === 'completed' ? 'text-green-600 font-semibold' : 
                  ($row['status'] === 'pending' ? 'text-yellow-600 font-semibold' : 'text-gray-600') ?>">
                  <?= htmlspecialchars(ucfirst($row['status'])) ?>
                </span>
              </td>
              <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="p-3 border-b border-gray-200 space-x-2">
                <button onclick="showEditForm(<?= $row['id'] ?>)" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                <a href="manageOrders.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
              </td>
            </tr>

            <!-- Edit row -->
            <tr id="edit_row_<?= $row['id'] ?>" style="display:none;" class="bg-orange-50">
              <form method="post" action="manageOrders.php">
                <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['id']) ?>
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                </td>
                <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['user_name'] ?? 'Unknown') ?></td>
                <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['restaurant_name'] ?? 'Unknown') ?></td>
                <td class="p-3 border-b border-gray-200"><?= number_format($row['total_price'], 2) ?></td>
                <td class="p-3 border-b border-gray-200">
                  <select name="status" class="border rounded px-2 py-1 w-full">
                    <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="completed" <?= $row['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                  </select>
                </td>
                <td class="p-3 border-b border-gray-200"><?= htmlspecialchars($row['created_at']) ?></td>
                <td class="p-3 border-b border-gray-200 space-x-2">
                  <button type="submit" name="update_order" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update</button>
                  <button type="button" onclick="cancelEdit(<?= $row['id'] ?>)" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 ml-2">Cancel</button>
                </td>
              </form>
            </tr>

          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="p-4 text-center text-gray-500">No orders found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

</body>
</html>

<?php $conn->close(); ?>
