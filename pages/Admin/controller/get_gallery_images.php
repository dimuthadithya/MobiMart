<?php
require_once('../../../config/database.php');

header('Content-Type: application/json');

// Handle DELETE request for deleting a gallery image
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['image_id'])) {
    $image_id = intval($_GET['image_id']);
    try {
        // Get the image URL to delete the file
        $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE id = :id");
        $stmt->execute([':id' => $image_id]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($image) {
            $file_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($image['image_url'], PHP_URL_PATH);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            // Delete the database record
            $stmt = $conn->prepare("DELETE FROM product_images WHERE id = :id");
            $stmt->execute([':id' => $image_id]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Failed to delete image']);
            }
        } else {
            echo json_encode(['error' => 'Image not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

if (!isset($_GET['product_id'])) {
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

$product_id = intval($_GET['product_id']);

try {
    // Check if product_images table exists, if not create it
    $sql = "CREATE TABLE IF NOT EXISTS product_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )";
    $conn->exec($sql);

    // Get gallery images for the product
    $stmt = $conn->prepare("SELECT id, image_url FROM product_images WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($images);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
