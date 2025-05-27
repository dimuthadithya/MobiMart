<?php
$product_image = $product['image_url'] ? "../assets/uploads/products/" . htmlspecialchars($product['image_url']) : "../assets/images/product-item1.jpg";
$product_name = htmlspecialchars($product['product_name']);
$brand_name = isset($product['brand_name']) && $product['brand_name'] ? htmlspecialchars($product['brand_name']) : 'Unknown Brand';
$price = number_format($product['price'], 2);
$quantity = (int)$product['quantity'];
$sku = htmlspecialchars($product['sku']);
?>

<style>
    .product-card {
        transition: all 0.3s ease;
        background: #1a1a1a;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .product-image-wrapper {
        position: relative;
        padding-top: 133%;
        /* 4:3 Aspect Ratio */
        background: #111111;
        overflow: hidden;
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
        filter: contrast(1.1) brightness(0.9) saturate(1.1);
        mix-blend-mode: luminosity;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
        filter: contrast(1.2) brightness(1) saturate(1.2);
        mix-blend-mode: normal;
    }

    .quick-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transform: translateX(10px);
        transition: all 0.4s ease;
        z-index: 2;
    }

    .product-card:hover .quick-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .quick-actions .btn {
        width: 40px;
        height: 40px;
        background: rgba(30, 30, 30, 0.85);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .quick-actions .btn:hover {
        background: rgba(40, 40, 40, 0.95);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-2px);
    }

    .product-title {
        font-size: 0.95rem;
        margin: 0;
        line-height: 1.5;
        letter-spacing: 0.01em;
    }

    .product-title a {
        color: #e0e0e0;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .product-title a:hover {
        color: #fff;
    }

    .price-wrapper {
        margin-top: 0.5rem;
    }

    .price {
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.02em;
    }

    .brand-name {
        color: #888;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .product-card .p-3 {
        background: linear-gradient(0deg, #1a1a1a 0%, rgba(26, 26, 26, 0.9) 100%);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Out of Stock and Low Stock badge styles */
    .stock-badge.bg-danger {
        background: rgba(220, 53, 69, 0.9) !important;
        border-color: rgba(220, 53, 69, 0.3);
    }

    .stock-badge.bg-warning {
        background: rgba(255, 193, 7, 0.9) !important;
        border-color: rgba(255, 193, 7, 0.3);
        color: #000;
    }

    .stock-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        z-index: 2;
        background: rgba(30, 30, 30, 0.85);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }
</style>

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
                <div class="stock-badge bg-danger text-white">
                    Out of Stock
                </div>
            <?php elseif ($quantity <= 5): ?>
                <div class="stock-badge bg-warning">
                    Low Stock
                </div>
            <?php endif; ?>
        </div> <!-- Card Body -->
        <div class="p-3">
            <!-- Brand -->
            <div class="text-muted text-uppercase small mb-1"><?= $brand_name ?></div>

            <!-- Product Name -->
            <h3 class="product-title mb-2">
                <a href="./product-details.php?id=<?= $product['product_id'] ?>">
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