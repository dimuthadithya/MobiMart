<?php
$product_image = $productImage;
$product_name = htmlspecialchars($product['product_name']);
$brand_id = $product['brand_id'];
$price = number_format($product['price'], 2);
$quantity = (int)$product['quantity'];
$sku = htmlspecialchars($product['sku']);
$stmt = $conn->prepare("SELECT brand_name FROM brands WHERE brand_id = :brand_id");
$stmt->execute(['brand_id' => $brand_id]);
$brand = $stmt->fetch(PDO::FETCH_ASSOC);
if ($brand) {
    $brand_name = htmlspecialchars($brand['brand_name']);
} else {
    $brand_name = 'Unknown';
}

?>

<div class="col">
    <a href="<?php echo $productDetailsPage ?>" class="text-decoration-none text-dark">
        <div class="product-card shadow-sm">
            <!-- Product Image -->
            <div class="product-image-wrapper">
                <img src="<?= $product_image ?>"
                    class="product-image"
                    alt="<?= $product_name ?>"
                    loading="lazy">
                <!-- Stock Badge -->
                <?php if ($quantity <= 0): ?>
                    <div class="stock-badge bg-danger text-white">
                        Out of Stock
                    </div>
                <?php elseif ($quantity <= 5): ?>
                    <div class="stock-badge bg-warning">
                        Low Stock
                    </div>
                <?php endif; ?>
            </div> <!-- Card Body -->
            <div class="p-3"> <!-- Brand -->
                <div class="text-muted text-uppercase small mb-1"><?= $brand_name ?></div>
                <!-- Product Name -->
                <h3 class="product-title mb-2">
                    <a href="<?php echo $productDetailsPage ?>">
                        <?= $product_name ?>
                    </a>
                </h3>
                <!-- Price and Add to Cart -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="price-wrapper">
                        <span class="fw-bold fs-5 text-white">LKR<?= $price ?></span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>