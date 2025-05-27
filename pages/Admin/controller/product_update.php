<?php
session_start();
require_once '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Begin transaction
        $conn->beginTransaction();

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $brand_id = $_POST['brand_id'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $sku = $_POST['sku'];
        $quantity = $_POST['quantity'];
        $status = $_POST['status'];

        // Update product basic information
        $updateSql = "UPDATE products SET 
            product_name = :product_name,
            brand_id = :brand_id,
            description = :description,
            price = :price,
            sku = :sku,
            quantity = :quantity,
            status = :status
            WHERE product_id = :product_id";

        $stmt = $conn->prepare($updateSql);
        $stmt->execute([
            ':product_name' => $product_name,
            ':brand_id' => $brand_id,
            ':description' => $description,
            ':price' => $price,
            ':sku' => $sku,
            ':quantity' => $quantity,
            ':status' => $status,
            ':product_id' => $product_id
        ]);

        // Handle main image upload if provided
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../../uploads/products/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_path)) {
                // Get and delete old image if exists
                $stmt = $conn->prepare("SELECT image_url FROM products WHERE product_id = :product_id");
                $stmt->execute([':product_id' => $product_id]);
                $old_image = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($old_image && $old_image['image_url']) {
                    $old_file_path = $_SERVER['DOCUMENT_ROOT'] . parse_url($old_image['image_url'], PHP_URL_PATH);
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // Update image URL in database
                $image_url = '/uploads/products/' . $new_filename;
                $stmt = $conn->prepare("UPDATE products SET image_url = :image_url WHERE product_id = :product_id");
                $stmt->execute([
                    ':image_url' => $image_url,
                    ':product_id' => $product_id
                ]);
            }
        }

        // Handle gallery images upload if provided
        if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            $upload_dir = '../../../uploads/products/gallery/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Create product_images table if it doesn't exist
            $sql = "CREATE TABLE IF NOT EXISTS product_images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                image_url VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
            )";
            $conn->exec($sql);

            $gallery_images = $_FILES['gallery_images'];
            $total_images = count($gallery_images['name']);

            for ($i = 0; $i < $total_images; $i++) {
                if ($gallery_images['error'][$i] === UPLOAD_ERR_OK) {
                    $file_extension = strtolower(pathinfo($gallery_images['name'][$i], PATHINFO_EXTENSION));
                    $new_filename = uniqid() . '_gallery_' . $i . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;

                    if (move_uploaded_file($gallery_images['tmp_name'][$i], $upload_path)) {
                        $image_url = '/uploads/products/gallery/' . $new_filename;
                        $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)");
                        $stmt->execute([
                            ':product_id' => $product_id,
                            ':image_url' => $image_url
                        ]);
                    }
                }
            }
        }

        $conn->commit();
        $_SESSION['success'] = "Product updated successfully!";
        header("Location: ../product.php?success=updated");
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['error'] = "Error updating product: " . $e->getMessage();
        header("Location: ../product.php?error=update_failed&message=" . urlencode($e->getMessage()));
        exit();
    }
}

header("Location: ../product.php");
exit();
