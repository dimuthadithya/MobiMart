<?php
$product_image = $product['image_url'] ? "../assets/uploads/products/" . htmlspecialchars($product['image_url']) : "../assets/images/product-item1.jpg";
$product_name = htmlspecialchars($product['product_name']);
$brand_name = htmlspecialchars($product['brand_name']);
$price = number_format($product['price'], 2);
$quantity = (int)$product['quantity'];
$sku = htmlspecialchars($product['sku']);
?>

<div class="col">
    <div class="card h-100 product-card border-0 shadow-sm">
        <!-- Product Image -->
        <div class="position-relative">
            <img src="<?= $product_image ?>" class="card-img-top product-image" alt="<?= $product_name ?>">

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
                    <button type="button"
                        class="btn btn-sm rounded-circle add-to-cart"
                        data-product-id="<?= $product['product_id'] ?>"
                        title="Add to Cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Stock Badge -->
            <?php if ($quantity <= 0): ?>
                <span class="position-absolute top-0 start-0 m-3 badge bg-danger">
                    Out of Stock
                </span>
            <?php elseif ($quantity <= 5): ?>
                <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark">
                    Low Stock
                </span>
            <?php endif; ?>
        </div>

        <!-- Card Body -->
        <div class="card-body p-3">
            <!-- Brand -->
            <p class="text-muted text-uppercase small mb-1"><?= $brand_name ?></p>

            <!-- Product Name -->
            <h5 class="product-title mb-2">
                <a href="./product-details.php?id=<?= $product['product_id'] ?>"
                    class="text-decoration-none text-dark stretched-link">
                    <?= $product_name ?>
                </a>
            </h5>

            <!-- Price and Status -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="price-wrapper">
                    <span class="fw-bold text-primary">$<?= $price ?></span>
                </div>
                <small class="text-muted">SKU: <?= $sku ?></small>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-white border-top-0 p-3">
            <?php if ($quantity > 0): ?>
                <button class="btn btn-primary w-100 add-to-cart"
                    data-product-id="<?= $product['product_id'] ?>"
                    data-product-name="<?= $product_name ?>"
                    data-product-price="<?= $price ?>">
                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                </button>
            <?php else: ?>
                <button class="btn btn-secondary w-100" disabled>
                    <i class="fas fa-times-circle me-2"></i>Out of Stock
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>