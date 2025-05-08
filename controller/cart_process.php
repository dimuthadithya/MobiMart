<?php
include_once '../config/db.php';
session_start();

header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'fail', 'message' => 'Login required']);
    exit();
}

if (!isset($_POST['product_id'])) {
    echo json_encode(['status' => 'fail', 'message' => 'Product ID is required']);
    exit();
}

$email = $_SESSION['email'];
$productId = $_POST['product_id'];

try {
    // Find user by email
    $findUserSql = "SELECT user_id FROM users WHERE email = :email";
    $stmt = $conn->prepare($findUserSql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'fail', 'message' => 'User not found']);
        exit();
    }

    $userId = $user['user_id'];

    // Optional: check if the product already exists in cart (to increment quantity)
    $checkCartSql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($checkCartSql);
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // If exists, update quantity
        $updateSql = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = :cart_id";
        $stmt = $conn->prepare($updateSql);
        $stmt->execute(['cart_id' => $existing['cart_id']]);
        echo json_encode(['status' => 'success', 'message' => 'Quantity updated']);
    } else {
        // If not, insert new record
        $insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
        $stmt = $conn->prepare($insertSql);
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $cartId = $conn->lastInsertId();

        if ($cartId) {
            echo json_encode(['status' => 'success', 'cart_id' => $cartId]);
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Failed to add to cart']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'fail', 'message' => 'Database error: ' . $e->getMessage()]);
}
