<?php
session_start();
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: phones.php");
    exit();
}

$productId = $_GET['id'];

// Fetch product details
$sql = "SELECT p.*, b.brand_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.brand_id 
        WHERE p.product_id = :product_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['product_id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: phones.php");
    exit();
}

// Fetch product gallery images
$gallerySql = "SELECT * FROM product_images WHERE product_id = :product_id AND is_main = 0";
$stmt = $conn->prepare($gallerySql);
$stmt->execute(['product_id' => $productId]);
$galleryImages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pass the product data to the details template
include '../includes/productDetails.php';
