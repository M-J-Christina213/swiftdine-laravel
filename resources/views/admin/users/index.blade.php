<?php include '../components/sidebarAdmin.php'; ?>

<?php
error_reporting(E_ALL);
$conn = new mysqli("localhost", "root", "", "swiftdine", 3307);

// Handle delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM users WHERE id=$id");
  header("Location: manageUsers.php");
  exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_user'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $conn->query("UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id");
    header("Location: manageUsers.php");
    exit();
  }

  if (isset($_POST['add_user'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    // Normally you want password hashing here; we skip password for simplicity
    $conn->query("INSERT INTO users (name, email, role, created_at) VALUES ('$name', '$email', '$role', NOW())");
    header("Location: manageUsers.php");
    exit();
  }
}

// Fetch users
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users - SwiftDine Admin</title>
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
      document.getElementById('add_user_form').style.display = 'table-row';
      document.getElementById('add_user_btn').style.display = 'none';
    }
    function cancelAdd() {
      document.getElementById('add_user_form').style.display = 'none';
      document.getElementById('add_user_btn').style.display = 'inline-block';
    }
  </script>
  <style>
    /* Hover styling for links */
    .action-link {
      cursor: pointer;
      transition: color 0.3s ease;
    }
    .action-link:hover {
      color: #fb923c; /* orange-400 */
      text-decoration: underline;
    }
  </style>
</head>
<body class="flex bg-gray-50 min-h-screen font-sans">


  <main class="flex-1 p-10 ml-64 bg-white shadow-lg rounded-lg mx-6 my-6">
    <h1 class="text-3xl font-bold text-orange-600 mb-6">Manage Users</h1>

    <button id="add_user_btn" onclick="showAddForm()" class="mb-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
      + Add New User
    </button>

    <table class="min-w-full border border-gray-300 rounded overflow-hidden">
      <thead class="bg-orange-100">
        <tr>
          <th class="p-3 border-b">ID</th>
          <th class="p-3 border-b">Name</th>
          <th class="p-3 border-b">Email</th>
          <th class="p-3 border-b">Role</th>
          <th class="p-3 border-b">Created At</th>
          <th class="p-3 border-b">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Add User Form Row (hidden by default) -->
        <tr id="add_user_form" style="display:none;" class="bg-green-50">
          <form method="post" action="manageUsers.php" class="w-full">
            <td class="p-2 border-b">New</td>
            <td class="p-2 border-b"><input type="text" name="name" required placeholder="Name" class="border rounded px-2 py-1 w-full" /></td>
            <td class="p-2 border-b"><input type="email" name="email" required placeholder="Email" class="border rounded px-2 py-1 w-full" /></td>
            <td class="p-2 border-b">
              <select name="role" required class="border rounded px-2 py-1 w-full">
                <option value="" disabled selected>Select Role</option>
                <option value="customer">Customer</option>
                <option value="restaurant">Restaurant</option>
                <option value="admin">Admin</option>
              </select>
            </td>
            <td class="p-2 border-b">--</td>
            <td class="p-2 border-b flex gap-2">
              <button type="submit" name="add_user" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Add</button>
              <button type="button" onclick="cancelAdd()" class="bg-gray-400 text-white px-4 py-1 rounded hover:bg-gray-500">Cancel</button>
            </td>
          </form>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
          <!-- Display Row -->
          <tr id="display_row_<?= $row['id'] ?>" class="border-b hover:bg-orange-50 transition-colors">
            <td class="p-2"><?= $row['id'] ?></td>
            <td class="p-2"><?= htmlspecialchars($row['name']) ?></td>
            <td class="p-2"><?= htmlspecialchars($row['email']) ?></td>
            <td class="p-2 capitalize"><?= htmlspecialchars($row['role']) ?></td>
            <td class="p-2"><?= $row['created_at'] ?></td>
            <td class="p-2 flex gap-4">
              <span class="action-link" onclick="showEditForm(<?= $row['id'] ?>)">Edit</span>
              <a href="manageUsers.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')" class="text-red-600 hover:underline">Delete</a>
            </td>
          </tr>

          <!-- Edit Row -->
          <tr id="edit_row_<?= $row['id'] ?>" class="border-b bg-orange-50" style="display: none;">
            <form method="post" action="manageUsers.php">
              <td class="p-2"><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"></td>
              <td class="p-2"><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="border rounded px-2 py-1 w-full" required></td>
              <td class="p-2"><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="border rounded px-2 py-1 w-full" required></td>
              <td class="p-2">
                <select name="role" class="border rounded px-2 py-1 w-full" required>
                  <option value="customer" <?= $row['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                  <option value="restaurant owner" <?= $row['role'] === 'restaurant owner' ? 'selected' : '' ?>>Restaurant</option>
                  <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
              </td>
              <td class="p-2"><?= $row['created_at'] ?></td>
              <td class="p-2 flex gap-2">
                <button type="submit" name="update_user" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Update</button>
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
