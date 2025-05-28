<?php
session_start();
require_once '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Begin transaction
        $conn->beginTransaction();

        // Validate required fields
        $requiredFields = ['productName', 'productBrand', 'productDescription', 'productPrice', 'productSKU', 'productStock'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        // Basic product information
        $productName = trim($_POST['productName']);
        $brandId = (int)$_POST['productBrand'];
        $description = trim($_POST['productDescription']);
        $price = (float)$_POST['productPrice'];
        $sku = trim($_POST['productSKU']);
        $quantity = (int)$_POST['productStock'];
        $status = isset($_POST['productStatus']) ? $_POST['productStatus'] : 'available';

        if ($price <= 0) {
            throw new Exception("Price must be greater than 0");
        }

        if ($quantity < 0) {
            throw new Exception("Stock quantity cannot be negative");
        }

        // Insert product
        $productSql = "INSERT INTO products (product_name, brand_id, description, price, sku, quantity, status) 
                       VALUES (:name, :brand_id, :description, :price, :sku, :quantity, :status)";

        $stmt = $conn->prepare($productSql);
        $stmt->execute([
            ':name' => $productName,
            ':brand_id' => $brandId,
            ':description' => $description,
            ':price' => $price,
            ':sku' => $sku,
            ':quantity' => $quantity,
            ':status' => $status
        ]);

        $productId = $conn->lastInsertId();

        // Handle main image upload
        if (isset($_FILES['mainImage']) && $_FILES['mainImage']['error'] == 0) {
            $mainImage = $_FILES['mainImage'];
            $imageFileType = strtolower(pathinfo($mainImage['name'], PATHINFO_EXTENSION));

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($imageFileType, $allowedTypes)) {
                throw new Exception("Sorry, only JPG, JPEG, PNG & WEBP files are allowed for the main image.");
            }

            // Validate file size (max 5MB)
            if ($mainImage['size'] > 5 * 1024 * 1024) {
                throw new Exception("Sorry, main image file is too large. Maximum size is 5MB.");
            }

            // Generate unique filename
            $mainImageName = 'product_' . $productId . '_main_' . time() . '.' . $imageFileType;

            // Create upload directory if it doesn't exist
            $uploadDir = '../../../assets/uploads/products/';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception("Failed to create upload directory");
                }
                chmod($uploadDir, 0777);
            }

            $uploadPath = $uploadDir . $mainImageName;

            // Move uploaded file
            if (!move_uploaded_file($mainImage['tmp_name'], $uploadPath)) {
                throw new Exception("Failed to save main image");
            }

            // Update main image in products table
            $updateSql = "UPDATE products SET image_url = :image_url WHERE product_id = :product_id";
            $stmt = $conn->prepare($updateSql);
            $stmt->execute([
                ':image_url' => $mainImageName,
                ':product_id' => $productId
            ]);
        }

        // Handle gallery images
        if (isset($_FILES['galleryImages']) && !empty($_FILES['galleryImages']['name'][0])) {
            $galleryImages = $_FILES['galleryImages'];
            $galleryUploadDir = '../../../assets/uploads/products/gallery/';

            // Create gallery directory if it doesn't exist
            if (!is_dir($galleryUploadDir)) {
                if (!mkdir($galleryUploadDir, 0777, true)) {
                    throw new Exception("Failed to create gallery upload directory");
                }
                chmod($galleryUploadDir, 0777);
            }

            // Create product_images table if it doesn't exist
            $createTableSql = "CREATE TABLE IF NOT EXISTS product_images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                image_url VARCHAR(255) NOT NULL,
                is_main TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
            )";
            $conn->exec($createTableSql);

            $totalFiles = count($galleryImages['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                if ($galleryImages['error'][$i] == 0) {
                    $imageFileType = strtolower(pathinfo($galleryImages['name'][$i], PATHINFO_EXTENSION));

                    // Validate file type
                    if (!in_array($imageFileType, $allowedTypes)) {
                        continue; // Skip invalid file types
                    }

                    // Validate file size (max 5MB)
                    if ($galleryImages['size'][$i] > 5 * 1024 * 1024) {
                        continue; // Skip files that are too large
                    }

                    $galleryImageName = 'product_' . $productId . '_gallery_' . time() . '_' . $i . '.' . $imageFileType;
                    $uploadPath = $galleryUploadDir . $galleryImageName;

                    if (move_uploaded_file($galleryImages['tmp_name'][$i], $uploadPath)) {
                        // Insert into product_images table
                        $imageSql = "INSERT INTO product_images (product_id, image_url, is_main) VALUES (:product_id, :image_url, 0)";
                        $stmt = $conn->prepare($imageSql);
                        $stmt->execute([
                            ':product_id' => $productId,
                            ':image_url' => 'gallery/' . $galleryImageName
                        ]);
                    }
                }
            }
        }

        // Commit transaction
        $conn->commit();

        $_SESSION['success'] = "Product added successfully!";
        header("Location: ../product.php?success=1");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error, only if active
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $_SESSION['error'] = "Error adding product: " . $e->getMessage();
        header("Location: ../product-add.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

header("Location: ../product-add.php");
exit();
