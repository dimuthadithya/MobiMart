<?php
include_once '../config/db.php';

session_start();

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: ./sign_in.php");
    exit();
}

$cartItemsSql = "SELECT c.*, p.price FROM cart c 
                JOIN products p ON c.product_id = p.product_id 
                WHERE c.user_id = :user_id";
$stmt = $conn->prepare($cartItemsSql);
$stmt->execute(['user_id' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if cart is empty
if (empty($cartItems)) {
    header("Location: ./cart.php?error=empty_cart");
    exit();
}

$totalPrice = 0;

foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

try {
    // Begin transaction
    $conn->beginTransaction();

    $orderSql = "INSERT INTO orders (user_id, total_amount, status, payment_method, shipping_address) 
                VALUES (:user_id, :total_amount, :status, :payment_method, :shipping_address)";
    $stmt = $conn->prepare($orderSql);
    $stmt->execute([
        'user_id' => $userId,
        'total_amount' => $totalPrice,
        'status' => 'pending',
        'payment_method' => 'online',
        'shipping_address' => 'abc'
    ]);

    $orderId = $conn->lastInsertId();

    foreach ($cartItems as $item) {
        $orderItemsSql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                         VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $conn->prepare($orderItemsSql);
        $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);

        // Update product quantity
        $updateProductSql = "UPDATE products SET quantity = quantity - :item_quantity 
                            WHERE product_id = :product_id AND quantity >= :item_quantity";
        $stmt = $conn->prepare($updateProductSql);
        $stmt->execute([
            'item_quantity' => $item['quantity'],
            'product_id' => $item['product_id']
        ]);

        // Check if update was successful (adequate inventory)
        if ($stmt->rowCount() == 0) {
            throw new Exception("Not enough inventory for product ID: " . $item['product_id']);
        }
    }

    // Delete all cart items for this user
    $deleteCartSql = "DELETE FROM cart WHERE user_id = :user_id";
    $stmt = $conn->prepare($deleteCartSql);
    $stmt->execute(['user_id' => $userId]);

    // Commit the transaction
    $conn->commit();

    header("Location: ../pages/orderComplete.php?order=success&total_price=$totalPrice");
    exit();
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollBack();
    header("Location: ./cart.php?error=checkout_failed&message=" . urlencode($e->getMessage()));
    exit();
}
