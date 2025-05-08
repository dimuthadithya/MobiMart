<?php
include_once '../config/db.php';
session_start();

// Validate session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];
$productId = $_POST['remove_product_id'] ?? null;

if (!$productId) {
    echo json_encode(['status' => 'fail', 'message' => 'No product ID provided']);
    exit();
}

// Prepare and execute delete query
try {
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([
        'user_id' => $userId,
        'product_id' => $productId
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Product not found in cart']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'fail', 'message' => 'Database error: ' . $e->getMessage()]);
}
