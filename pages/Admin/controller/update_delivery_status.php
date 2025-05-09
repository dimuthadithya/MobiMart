<?php
session_start();
include_once '../../../config/db.php';

// Only allow admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../../login.php?error=unauthorized');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
    $deliveryStatus = $_POST['delivery_status'] ?? '';

    $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
    if (!$orderId || !in_array($deliveryStatus, $validStatuses)) {
        $_SESSION['error'] = "Invalid input";
        header('Location: ../../Admin/orders.php');
        exit();
    }

    try {
        // Update orders table status column
        $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
        $stmt->execute([
            'status' => $deliveryStatus,
            'order_id' => $orderId
        ]);

        $_SESSION['success'] = "Order status updated successfully.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header('Location: ../../Admin/orders.php?updated');
    exit();
}

header('Location: ../../Admin/orders.php');
exit();
