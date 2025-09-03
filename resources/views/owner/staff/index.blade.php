<?php
require_once '../../config/db.php';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_staff'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $conn->query("INSERT INTO staff (name, email, role, phone) VALUES ('$name', '$email', '$role', '$phone')");
    header("Location: manageStaff.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM staff WHERE id=$id");
    header("Location: manageStaff.php");
    exit();
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_staff'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $conn->query("UPDATE staff SET name='$name', email='$email', role='$role', phone='$phone' WHERE id=$id");
    header("Location: manageStaff.php");
    exit();
}

$result = $conn->query("SELECT * FROM staff ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Staff - SwiftDine Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showEditForm(id) {
      document.getElementById('row_' + id).style.display = 'none';
      document.getElementById('edit_' + id).style.display = 'table-row';
    }

    function cancelEdit(id) {
      document.getElementById('edit_' + id).style.display = 'none';
      document.getElementById('row_' + id).style.display = 'table-row';
    }
  </script>
</head>
<body class="flex font-sans text-gray-900 min-h-screen">

  <!-- Sidebar Include -->
  <?php include('../components/sidebarOwner.php'); ?>

  <!-- Main Content -->
  <main class="flex-1 bg-white p-10 ml-64 overflow-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Manage Staff</h1>
    </div>

    <!-- Add New Staff Form -->
    <form method="POST" class="mb-6 bg-orange-50 p-4 rounded-lg shadow">
      <div class="grid grid-cols-2 gap-4">
        <input type="text" name="name" placeholder="Full Name" required class="border p-2 rounded" />
        <input type="email" name="email" placeholder="Email" required class="border p-2 rounded" />
        <input type="text" name="role" placeholder="Role (e.g. Chef)" required class="border p-2 rounded" />
        <input type="text" name="phone" placeholder="Phone Number" class="border p-2 rounded" />
      </div>
      <button type="submit" name="add_staff" class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Add Staff</button>
    </form>

    <!-- Staff Table -->
    <table class="w-full text-left border border-orange-300 rounded-lg overflow-hidden">
      <thead class="bg-orange-100 text-orange-800 font-semibold">
        <tr>
          <th class="p-3 border-b border-orange-300">Name</th>
          <th class="p-3 border-b border-orange-300">Email</th>
          <th class="p-3 border-b border-orange-300">Role</th>
          <th class="p-3 border-b border-orange-300">Phone</th>
          <th class="p-3 border-b border-orange-300">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <!-- Normal Row -->
          <tr id="row_<?= $row['id'] ?>" class="hover:bg-orange-50">
            <td class="p-3 border-b"><?= htmlspecialchars($row['name']) ?></td>
            <td class="p-3 border-b"><?= htmlspecialchars($row['email']) ?></td>
            <td class="p-3 border-b"><?= htmlspecialchars($row['role']) ?></td>
            <td class="p-3 border-b"><?= htmlspecialchars($row['phone']) ?></td>
            <td class="p-3 border-b space-x-2">
              <button onclick="showEditForm(<?= $row['id'] ?>)" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
              <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this staff member?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
            </td>
          </tr>

          <!-- Edit Row -->
          <tr id="edit_<?= $row['id'] ?>" style="display:none;" class="bg-orange-50">
            <form method="POST">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <td class="p-2 border-b"><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="role" value="<?= htmlspecialchars($row['role']) ?>" class="border p-1 w-full rounded" required></td>
              <td class="p-2 border-b"><input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="border p-1 w-full rounded"></td>
              <td class="p-2 border-b space-x-2">
                <button type="submit" name="update_staff" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Update</button>
                <button type="button" onclick="cancelEdit(<?= $row['id'] ?>)" class="bg-gray-400 text-white px-3 py-1 rounded hover:bg-gray-500">Cancel</button>
              </td>
            </form>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

<?php $conn->close(); ?>
