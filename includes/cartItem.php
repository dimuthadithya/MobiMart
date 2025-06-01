<div class="cart-item border-bottom py-3">
    <div class="row align-items-center">
        <!-- Product Image -->
        <div class="col-md-2 col-12 mb-3 mb-md-0">
            <img src="../assets/images/product-item2.jpg" alt="<?php echo htmlspecialchars($productName) ?>"
                class="img-fluid rounded" style="max-height: 80px; object-fit: contain;">
        </div>

        <!-- Product Details -->
        <div class="col-md-4 col-12 mb-3 mb-md-0">
            <h5 class="item-title mb-1"><?php echo htmlspecialchars($productName) ?></h5>
            <p class="text-muted small mb-0"><?php echo htmlspecialchars($brandName) ?></p>
        </div>

        <!-- Price -->
        <div class="col-md-2 col-4 text-md-center mb-2 mb-md-0">
            <span class="fw-semibold">LKR <?php echo number_format($productPrice, 2) ?></span>
        </div>

        <!-- Quantity -->
        <div class="col-md-1 col-4 text-md-center mb-2 mb-md-0">
            <span class="badge bg-secondary"><?php echo $qty ?></span>
        </div>

        <!-- Total -->
        <div class="col-md-2 col-4 text-md-center mb-2 mb-md-0">
            <span class="fw-bold">LKR <?php echo number_format($productPrice * $qty, 2) ?></span>
        </div>

        <!-- Remove Button -->
        <div class="col-md-1 col-12 text-md-end text-center">
            <form action="../controller/cart_remove_process.php" method="POST">
                <input type="hidden" name="remove_product_id" value="<?php echo htmlspecialchars($productId) ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>
</div>