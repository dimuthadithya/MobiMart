<?php
require_once('../../../config/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_GET['image_id'])) {
    echo json_encode(['error' => 'Image ID is required']);
    exit;
}

$image_id = intval($_GET['image_id']);

try {
    // Get the image URL first to delete the file
    $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE id = :id");
    $stmt->execute([':id' => $image_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image) {
        // Delete the physical file
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
