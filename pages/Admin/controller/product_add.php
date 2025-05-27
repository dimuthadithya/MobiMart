<?php
session_start();
require_once '../../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Begin transaction
        $conn->beginTransaction();

        // Basic product information
        $productName = $_POST['productName'];
        $brandId = $_POST['productBrand'];
        $description = $_POST['productDescription'];
        $price = $_POST['productPrice'];
        $sku = $_POST['productSKU'];
        $quantity = $_POST['productStock'];
        $status = $_POST['productStatus'];

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

            // Generate unique filename
            $mainImageName = 'product_' . $productId . '_main_' . time() . '.' . $imageFileType;
            $uploadPath = '../../../assets/uploads/products/' . $mainImageName;

            // Move uploaded file
            if (move_uploaded_file($mainImage['tmp_name'], $uploadPath)) {
                // Insert into product_images table as main image
                $imageSql = "INSERT INTO product_images (product_id, image_url, is_main) VALUES (:product_id, :image_url, 1)";
                $stmt = $conn->prepare($imageSql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':image_url' => $mainImageName
                ]);

                // Update main image in products table
                $updateSql = "UPDATE products SET image_url = :image_url WHERE product_id = :product_id";
                $stmt = $conn->prepare($updateSql);
                $stmt->execute([
                    ':image_url' => $mainImageName,
                    ':product_id' => $productId
                ]);
            }
        }

        // Handle gallery images
        if (isset($_FILES['galleryImages'])) {
            $galleryImages = $_FILES['galleryImages'];
            $totalFiles = count($galleryImages['name']);

            for ($i = 0; $i < $totalFiles; $i++) {
                if ($galleryImages['error'][$i] == 0) {
                    $imageFileType = strtolower(pathinfo($galleryImages['name'][$i], PATHINFO_EXTENSION));
                    $galleryImageName = 'product_' . $productId . '_gallery_' . time() . '_' . $i . '.' . $imageFileType;
                    $uploadPath = '../../../assets/uploads/products/' . $galleryImageName;

                    if (move_uploaded_file($galleryImages['tmp_name'][$i], $uploadPath)) {
                        // Insert into product_images table
                        $imageSql = "INSERT INTO product_images (product_id, image_url, is_main) VALUES (:product_id, :image_url, 0)";
                        $stmt = $conn->prepare($imageSql);
                        $stmt->execute([
                            ':product_id' => $productId,
                            ':image_url' => $galleryImageName
                        ]);
                    }
                }
            }
        }

        // Commit transaction
        $conn->commit();

        $_SESSION['success'] = "Product added successfully!";
        header("Location: ../product.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        $_SESSION['error'] = "Error adding product: " . $e->getMessage();
        header("Location: ../product-add.php");
        exit();
    }
}

header("Location: ../product-add.php");
exit();
