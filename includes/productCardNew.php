<?php
$product_image = $product['image_url'] ? "../assets/uploads/products/" . htmlspecialchars($product['image_url']) : "../assets/images/product-item1.jpg";
$product_name = htmlspecialchars($product['product_name']);
$brand_name = isset($product['brand_name']) && $product['brand_name'] ? htmlspecialchars($product['brand_name']) : 'Unknown Brand';
$price = number_format($product['price'], 2);
$quantity = (int)$product['quantity'];
$sku = htmlspecialchars($product['sku']);
?>

<div class="col">
    <div class="product-card shadow-sm"> <!-- Product Image -->
        <div class="product-image-wrapper">
            <img src="<?= $product_image ?>"
                class="product-image"
                alt="<?= $product_name ?>"
                loading="lazy">

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button type="button" class="btn btn-sm rounded-circle mb-1"
                    data-bs-toggle="modal"
                    data-bs-target="#quickViewModal"
                    data-product-id="<?= $product['product_id'] ?>"
                    title="Quick View">
                    <i class="fas fa-eye"></i>
                </button>
                <?php if ($quantity > 0): ?>
                    <a href="../pages/product-details.php?id=<?= $product['product_id'] ?>"
                        class="btn btn-sm rounded-circle"
                        title="View Product Details">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                <?php endif; ?>
            </div>

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
                <a href="../pages/product-details.php?id=<?= $product['product_id'] ?>">
                    <?= $product_name ?>
                </a>
            </h3>

            <!-- Price and Add to Cart -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div class="price-wrapper">
                    <span class="fw-bold fs-5">$<?= $price ?></span>
                </div>
                <div>
                    <?php if ($quantity > 0): ?>
                        <button class="btn btn-sm btn-primary add-to-cart"
                            data-product-id="<?= $product['product_id'] ?>"
                            data-product-name="<?= $product_name ?>"
                            data-product-price="<?= $price ?>">
                            <i class="fas fa-shopping-cart me-1"></i>Add
                        </button>
                    <?php else: ?>
                        <button class="btn btn-sm btn-secondary" disabled>
                            Out of Stock
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>