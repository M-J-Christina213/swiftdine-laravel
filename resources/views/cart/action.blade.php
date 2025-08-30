<?php 
session_start();
include '../../config/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$session_id = session_id();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $menu_id = intval($_POST['menu_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 1);

    header('Content-Type: application/json');

    if ($action === 'add') {
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE session_id = ? AND menu_id = ?");
        $stmt->bind_param("si", $session_id, $menu_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $new_quantity = $row['quantity'] + $quantity;
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update->bind_param("ii", $new_quantity, $row['id']);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO cart (session_id, menu_id, quantity) VALUES (?, ?, ?)");
            $insert->bind_param("sii", $session_id, $menu_id, $quantity);
            $insert->execute();
        }
        echo json_encode(['status' => 'success', 'message' => 'Added to cart']);
        exit;
    }

    if ($action === 'remove') {
        $delete = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND menu_id = ?");
        $delete->bind_param("si", $session_id, $menu_id);
        $delete->execute();
        echo json_encode(['status' => 'success', 'message' => 'Removed from cart']);
        exit;
    }

    if ($action === 'update') {
        if ($quantity <= 0) {
            $delete = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND menu_id = ?");
            $delete->bind_param("si", $session_id, $menu_id);
            $delete->execute();
        } else {
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE session_id = ? AND menu_id = ?");
            $update->bind_param("isi", $quantity, $session_id, $menu_id);
            $update->execute();
        }
        echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}
?>
