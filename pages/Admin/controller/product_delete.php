<?php
session_start();
require_once '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    try {
        $conn->beginTransaction();

        $product_id = $_POST['product_id'];

        // First get the product images to delete them from storage
        $stmt = $conn->prepare("SELECT image_url FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get gallery images
        $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $gallery_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Delete the main product image if exists
        if ($product && $product['image_url']) {
            $image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($product['image_url'], PHP_URL_PATH);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete all gallery images
        foreach ($gallery_images as $image) {
            $image_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($image['image_url'], PHP_URL_PATH);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete gallery images from database (will cascade due to foreign key)
        $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);

        // Delete the product
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);

        $conn->commit();
        $_SESSION['success'] = "Product deleted successfully!";
        header('Location: ../product.php?success=deleted');
    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['error'] = "Error deleting product: " . $e->getMessage();
        header('Location: ../product.php?error=delete_failed&message=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: ../product.php?error=invalid_request');
}
exit();
