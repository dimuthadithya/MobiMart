<?php
include_once '../config/db.php';

session_start();

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: ../pages/sign_in.php");
    exit();
}

// Validate required fields
if (!isset($_POST['fullName']) || !isset($_POST['streetAddress']) || 
    !isset($_POST['city']) || !isset($_POST['district']) || 
    !isset($_POST['phone']) || !isset($_POST['paymentMethod'])) {
    header("Location: ../pages/checkout.php?error=missing_fields");
    exit();
}

// Get cart items
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

// Validate POST data
if (!isset($_POST['fullName']) || !isset($_POST['streetAddress']) || !isset($_POST['city']) || 
    !isset($_POST['district']) || !isset($_POST['phone']) || !isset($_POST['paymentMethod'])) {
    header("Location: ../pages/checkout.php?error=missing_fields");
    exit();
}

// Get and sanitize form data
$fullName = trim($_POST['fullName']);
$streetAddress = trim($_POST['streetAddress']);
$city = trim($_POST['city']);
$district = trim($_POST['district']);
$phone = trim($_POST['phone']);
$paymentMethod = $_POST['paymentMethod'];

// Validate payment method
if (!in_array($paymentMethod, ['cash', 'card'])) {
    header("Location: ../pages/checkout.php?error=invalid_payment_method");
    exit();
}

// Basic validation
if (empty($fullName) || empty($streetAddress) || empty($city) || empty($district) || empty($phone)) {
    header("Location: ../pages/checkout.php?error=empty_fields");
    exit();
}

// Format shipping address
$shippingAddress = json_encode([
    'full_name' => $fullName,
    'street_address' => $streetAddress,
    'city' => $city,
    'district' => $district,
    'phone' => $phone
]);

try {
    // Begin transaction
    $conn->beginTransaction();

    // Save address if it's new
    $addressSql = "INSERT INTO addresses (user_id, full_name, street_address, city, district, phone) 
                  VALUES (:user_id, :full_name, :street_address, :city, :district, :phone)";
    $stmt = $conn->prepare($addressSql);
    $stmt->execute([
        'user_id' => $userId,
        'full_name' => $fullName,
        'street_address' => $streetAddress,
        'city' => $city,
        'district' => $district,
        'phone' => $phone
    ]);

    // Create the order
    $orderSql = "INSERT INTO orders (user_id, total_amount, status, payment_method, shipping_address) 
                VALUES (:user_id, :total_amount, :status, :payment_method, :shipping_address)";
    $stmt = $conn->prepare($orderSql);
    $stmt->execute([
        'user_id' => $userId,
        'total_amount' => $totalPrice,
        'status' => 'pending',
        'payment_method' => $paymentMethod,
        'shipping_address' => $shippingAddress
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
