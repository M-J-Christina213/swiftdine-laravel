<?php include '../components/sidebarAdmin.php'; ?>
<?php

require_once '../../config/db.php';
$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$stmt = $mysqli->prepare("SELECT name, price, quantity, created_at FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Items</title>
    <style>
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px 12px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Order #<?= $orderId ?> - Items</h2>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Price (LKR)</th>
                <th>Quantity</th>
                <th>Subtotal (LKR)</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grandTotal = 0;
            while($row = $result->fetch_assoc()):
                $subtotal = $row['price'] * $row['quantity'];
                $grandTotal += $subtotal;
            ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= number_format($subtotal, 2) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right;">Grand Total:</th>
                <th colspan="2"><?= number_format($grandTotal, 2) ?> LKR</th>
            </tr>
        </tfoot>
    </table>
    <p style="text-align:center;"><a href="manage_orders.php">← Back to Orders</a></p>
</body>
</html>

<?php $stmt->close(); $mysqli->close(); ?>
