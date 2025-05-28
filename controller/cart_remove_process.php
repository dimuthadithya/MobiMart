<?php
include_once '../config/db.php';
session_start();

header('Content-Type: application/json');

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

try {
    // Begin transaction
    $conn->beginTransaction();

    // Delete the item from cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([
        'user_id' => $userId,
        'product_id' => $productId
    ]);

    if ($stmt->rowCount() > 0) {
        // Get updated cart count and total
        $cartCountSql = "SELECT SUM(c.quantity) as count, SUM(c.quantity * p.price) as total 
                         FROM cart c 
                         JOIN products p ON c.product_id = p.product_id 
                         WHERE c.user_id = :user_id";
        $stmt = $conn->prepare($cartCountSql);
        $stmt->execute(['user_id' => $userId]);
        $cartInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Product removed successfully',
            'cartCount' => (int)($cartInfo['count'] ?? 0),
            'cartTotal' => number_format($cartInfo['total'] ?? 0, 2)
        ]);
    } else {
        $conn->rollBack();
        echo json_encode(['status' => 'fail', 'message' => 'Product not found in cart']);
    }
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(['status' => 'fail', 'message' => 'Database error: ' . $e->getMessage()]);
}
