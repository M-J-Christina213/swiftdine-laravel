<?php include '../../config/db.php'; ?>
<?php include '../components/sidebarOwner.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SwiftDine Owner Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-gray-800">
<div class="flex min-h-screen">

  <!-- Main Content -->
  <main class="flex-1 p-8 ml-64">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Welcome, Restaurant Owner!</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
      <?php
      $income = 400230;
      $expenses = 2000100;
      $dineIn = 210;
      $delivery = 180;
      $takeaway = 145;
      ?>
      <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500 transition-transform hover:scale-105">
        <h2 class="text-gray-600">Monthly Income</h2>
        <p class="text-2xl font-bold text-orange-600">Rs<?= number_format($income) ?></p>
      </div>
      <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500 transition-transform hover:scale-105">
        <h2 class="text-gray-600">Monthly Expenses</h2>
        <p class="text-2xl font-bold text-orange-600">Rs<?= number_format($expenses) ?></p>
      </div>
      <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500 transition-transform hover:scale-105">
        <h2 class="text-gray-600">Dine-In Orders</h2>
        <p class="text-2xl font-bold text-orange-600"><?= $dineIn ?></p>
      </div>
      <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500 transition-transform hover:scale-105">
        <h2 class="text-gray-600">Delivery Orders</h2>
        <p class="text-2xl font-bold text-orange-600"><?= $delivery ?></p>
      </div>
      <div class="bg-white p-5 rounded-xl shadow border-l-4 border-orange-500 transition-transform hover:scale-105">
        <h2 class="text-gray-600">Takeaway Orders</h2>
        <p class="text-2xl font-bold text-orange-600"><?= $takeaway ?></p>
      </div>
    </div>

    <!-- Income Chart -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
      <h2 class="text-xl font-semibold text-orange-600 mb-4">Income Over the Past 6 Months</h2>
      <canvas id="incomeChart" height="100"></canvas>
    </div>

    <!-- CTA -->
    <div class="text-center mt-10 text-gray-600">
      Manage your restaurant, menus, orders, staff and suppliers from the sidebar.
    </div>
  </main>
</div>

<script>
  const ctx = document.getElementById('incomeChart').getContext('2d');
  const incomeChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Monthly Income (Rs)',
        data: [320000, 350000, 400000, 420000, 460000, 480000],
        borderColor: 'rgb(234, 88, 12)',
        backgroundColor: 'rgba(234, 88, 12, 0.1)',
        fill: true,
        tension: 0.3,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
</body>
</html>
