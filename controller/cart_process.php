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
$quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

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

    // Check product availability
    $productSql = "SELECT quantity, price FROM products WHERE product_id = :product_id AND quantity >= :needed_quantity";
    $stmt = $conn->prepare($productSql);
    $stmt->execute([
        'product_id' => $productId,
        'needed_quantity' => $quantity
    ]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(['status' => 'fail', 'message' => 'Product is out of stock']);
        exit();
    }

    // Check if product already exists in cart
    $checkCartSql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($checkCartSql);
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    // Begin transaction
    $conn->beginTransaction();

    if ($existing) {
        // If exists, update quantity
        $newQuantity = $existing['quantity'] + $quantity;

        // Verify new quantity is available
        if ($newQuantity > $product['quantity']) {
            echo json_encode(['status' => 'fail', 'message' => 'Not enough stock available']);
            exit();
        }

        $updateSql = "UPDATE cart SET quantity = :quantity WHERE cart_id = :cart_id";
        $stmt = $conn->prepare($updateSql);
        $stmt->execute([
            'quantity' => $newQuantity,
            'cart_id' => $existing['cart_id']
        ]);
    } else {
        // If not, insert new record
        $insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $conn->prepare($insertSql);
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

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
        'message' => 'Product added to cart successfully',
        'cartCount' => (int)$cartInfo['count'],
        'cartTotal' => number_format($cartInfo['total'], 2)
    ]);
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode([
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
