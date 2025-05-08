<div class="product-card position-relative">
    <div class="image-holder">
        <a href="<?php echo $productDetailsPage ?>">
            <img src="../assets/images/product-item2.jpg" alt="product-item" class="img-fluid" />
        </a>
    </div>
    <div class="cart-concern position-absolute">
        <div class="cart-button d-flex">
            <p class="btn btn-medium btn-black" onclick="addToCart(<?php echo $productId ?>)">
                Add to Cart<svg class="cart-outline">
                    <use xlink:href="#cart-outline"></use>
                </svg>
            </p>
        </div>
    </div>
    <div class="card-detail pt-3">
        <h3 class="card-title text-uppercase ">
            <a href="#"><?php echo $productName ?></a>
        </h3>
        <span class="item-price text-primary ">LKR <?php echo $productPrice ?></span>
    </div>
</div>