<?php
include '../../../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name        = $_POST['productName'];
    $brand       = $_POST['productBrand'];
    $description = $_POST['productDescription'];
    $price       = $_POST['productPrice'];
    $sku         = $_POST['productSKU'];
    $stock       = $_POST['productStock'];
    $status      = $_POST['productStatus'];

    $createdAt = date('Y-m-d H:i:s');
    $updatedAt = $createdAt;

    // Upload main image to the correct folder
    $mainImageName = $_FILES['mainImage']['name'];
    $mainImageTmp  = $_FILES['mainImage']['tmp_name'];
    $mainImageUploadPath = '../../../assets/uploads/products/' . $mainImageName;
    move_uploaded_file($mainImageTmp, $mainImageUploadPath);

    // Upload gallery images to the correct folder
    $galleryFilenames = [];
    if (!empty($_FILES['galleryImages']['name'][0])) {
        foreach ($_FILES['galleryImages']['tmp_name'] as $index => $tmpName) {
            $filename = $_FILES['galleryImages']['name'][$index];
            $uploadPath = '../../../assets/uploads/products/gallery/' . $filename;
            move_uploaded_file($tmpName, $uploadPath);
            $galleryFilenames[] = $filename;
        }
    }

    try {
        $sql = "INSERT INTO products 
                (product_name, brand_id, description, price, sku, quantity, status, image_url, gallery_images, created_at, updated_at) 
                VALUES 
                (:name, :brand, :description, :price, :sku, :stock, :status, :main_image, :gallery_images, :created_at, :updated_at)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name'           => $name,
            ':brand'          => $brand,
            ':description'    => $description,
            ':price'          => $price,
            ':sku'            => $sku,
            ':stock'          => $stock,
            ':status'         => $status,
            ':main_image'     => $mainImageName,
            ':gallery_images' => json_encode($galleryFilenames),
            ':created_at'     => $createdAt,
            ':updated_at'     => $updatedAt
        ]);

        echo "<script>alert('Product added successfully'); window.location.href = '../product.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
