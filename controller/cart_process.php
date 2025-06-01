<?php

require_once '../config/db.php';
session_start();


$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$productAlreadyInCartSql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
$stmtCheck = $conn->prepare($productAlreadyInCartSql);
$stmtCheck->execute([
    ':user_id' => $userId,
    ':product_id' => $_POST['product_id']
]);
if ($stmtCheck->rowCount() > 0) {
    $sql = "UPDATE cart SET quantity = quantity + :quantity
    WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $userId,
        ':product_id' => $_POST['product_id'],
        ':quantity' => $_POST['quantity']
    ]);

    header('location: ../pages/cart.php?success=added');
    exit();
} else {
    $sql = "INSERT INTO cart (user_id, product_id, quantity)
    VALUES (:user_id, :product_id, :quantity)
   ;";



    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $userId,
        ':product_id' => $_POST['product_id'],
        ':quantity' => $_POST['quantity']
    ]);


    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Product added to cart successfully.']);
        header('location: ../pages/cart.php?success=added');
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add product to cart.']);
    }
}
