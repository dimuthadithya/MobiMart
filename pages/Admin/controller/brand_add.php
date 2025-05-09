<?php
include '../../../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandName = trim($_POST['brandName']);

    if (!empty($brandName)) {
        try {
            $stmt = $conn->prepare("INSERT INTO brands (brand_name) VALUES (:brand_name)");
            $stmt->bindParam(':brand_name', $brandName);
            $stmt->execute();

           
            header("Location: ../brands.php?success=1");
            exit();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    } else {
        echo "Brand name is required.";
    }
} else {
    echo "Invalid request.";
}
