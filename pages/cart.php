<?php
include_once '../config/db.php';

session_start();

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
  header("Location: ./sign_in.php");
  exit();
}

$cartItemsSql = "SELECT * FROM cart WHERE user_id = :user_id";
$stmt = $conn->prepare($cartItemsSql);
$stmt->execute(['user_id' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$cartCount = count($cartItems);

$sql = "SELECT * FROM cart WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $userId]);
$carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPrice = 0;
foreach ($carts as $cart) {
  $productsql = "SELECT * FROM products WHERE product_id = :product_id";
  $stmt = $conn->prepare($productsql);
  $stmt->execute(['product_id' => $cart['product_id']]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  $totalPrice += $product['price'] * $cart['quantity'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile Shop - Shopping Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/vendor.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f4f6f9;
      color: #333;
    }

    .cart-container {
      padding: 30px 0;
      min-height: 100vh;
    }

    .cart-header {
      margin-bottom: 30px;
    }

    .cart-item {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      padding: 15px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
    }

    .cart-item:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transform: translateY(-2px);
    }

    .item-image {
      max-width: 100px;
      height: auto;
      object-fit: contain;
    }

    .item-title {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .item-variant {
      font-size: 14px;
      color: #666;
    }

    .item-price {
      font-weight: 600;
      color: #000;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      overflow: hidden;
      width: fit-content;
    }

    .quantity-btn {
      border: none;
      background-color: #f0f0f0;
      padding: 5px 12px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .quantity-btn:hover {
      background-color: #e0e0e0;
    }

    .quantity-input {
      width: 40px;
      border: none;
      text-align: center;
      font-weight: 600;
      background-color: transparent;
    }

    .remove-btn {
      color: #dc3545;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
      padding: 5px;
      transition: all 0.2s;
    }

    .remove-btn:hover {
      color: #c82333;
    }

    .cart-summary {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      padding: 20px;
      position: sticky;
      top: 20px;
    }

    .summary-title {
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .summary-total {
      display: flex;
      justify-content: space-between;
      font-weight: 700;
      font-size: 18px;
      padding-top: 10px;
      margin-top: 10px;
      border-top: 1px solid #eee;
    }

    .checkout-btn {
      margin-top: 20px;
      font-weight: 600;
      padding: 12px;
    }

    .continue-shopping {
      display: inline-block;
      margin-top: 15px;
      color: #333;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.2s;
    }

    .continue-shopping:hover {
      color: #000;
    }

    .promo-code {
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px solid #eee;
    }

    .nav-pills .nav-link.active {
      background-color: #212529;
    }

    .payment-icon {
      height: 24px;
      margin-right: 8px;
    }

    .recommendations {
      margin-top: 40px;
    }

    .recommendation-title {
      font-weight: 600;
      margin-bottom: 20px;
    }

    .recommended-item {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      padding: 15px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .recommended-item:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transform: translateY(-2px);
    }

    .recommended-image {
      height: 120px;
      object-fit: contain;
      margin-bottom: 10px;
    }

    .add-to-cart-btn {
      margin-top: 10px;
      width: 100%;
      font-size: 14px;
    }

    .badge-sale {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }

    /* .navbar {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
      height: 40px;
    }

    .navbar-nav .nav-link {
      font-weight: 500;
    }

    .nav-icon {
      font-size: 1.2rem;
      color: #333;
      margin-left: 15px;
      position: relative;
    } */

    .cart-count {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: #dc3545;
      color: white;
      font-size: 10px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>

  <!-- navbar -->
  <header
    id="header"
    class="site-header header-scrolled text-black">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
          <img src="../assets/images/download.png" class="logo" width="80px" height="80px" />
        </a>
        <button
          class="navbar-toggler d-flex d-lg-none order-3 p-2"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#bdNavbar"
          aria-controls="bdNavbar"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <svg class="navbar-icon">
            <use xlink:href="#navbar-icon"></use>
          </svg>
        </button>
        <div
          class="offcanvas offcanvas-end"
          tabindex="-1"
          id="bdNavbar"
          aria-labelledby="bdNavbarOffcanvasLabel">
          <div class="offcanvas-header px-4 pb-0">
            <a class="navbar-brand" href="index.html">
              <img src="../assets/images/main-logo.png" class="logo" />
            </a>
            <button
              type="button"
              class="btn-close btn-close-black"
              data-bs-dismiss="offcanvas"
              aria-label="Close"
              data-bs-target="#bdNavbar"></button>
          </div>
          <div class="offcanvas-body">
            <ul
              id="navbar"
              class="navbar-nav text-uppercase justify-content-end align-items-center flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link me-4" href="../index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link me-4 active" href="../pages/phones.php">Phones</a>
              </li>
              <?php
              if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="./pages/Admin/dashboard.php">Dashboard</a>
                                  </li>';
              } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') {
                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="../pages/User/dashboard.php">Dashboard</a>
                                  </li>';
              } else if (!isset($_SESSION['user_type'])) {
                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="../pages/sign_in.php">Sign In</a>
                                  </li>';
              } else if (isset($_SESSION['user_type'])) {
                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="../controller/user_logout_process.php">Log out</a>
                                  </li>';
              }
              ?>

              <li class="nav-item">
                <div class="user-items ps-5">
                  <ul class="d-flex justify-content-end list-unstyled">
                    <!-- <li class="search-item pe-3">
                      <a href="#" class="search-button text-dark">
                        <i class="fas fa-search"></i>
                      </a>
                    </li> -->

                    <li class="pe-3">
                      <a href="<?php

                                if (isset($_SESSION['user_type'])) {
                                  echo $_SESSION['user_type'] === 'admin' ? '../pages/Admin/dashboard.php' : '../pages/User/dashboard.php';
                                } else {
                                  echo '../pages/sign_in.php';
                                }
                                ?>" class="text-dark">
                        <i class="fas fa-user"></i>
                      </a>
                    </li>

                    <li>
                      <a href="../pages/cart.php" class="text-dark">
                        <i class="fas fa-shopping-cart"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <!-- end navbar -->



  <!-- Cart Content -->
  <div class="container cart-container">
    <div class="cart-header">
      <h1 class="fw-bold">Shopping Cart <span class="text-muted fs-6">(<?php echo $cartCount ?>)</span></h1>
    </div>

    <div class="row">
      <!-- Cart Items Column -->
      <div class="col-lg-8 mb-4">
        <?php
        foreach ($cartItems as $item) {

          $productId = $item['product_id'];

          $productSql = "SELECT * FROM products WHERE product_id = :product_id";
          $stmt = $conn->prepare($productSql);
          $stmt->bindParam(':product_id', $productId);
          $stmt->execute();
          $product = $stmt->fetch(PDO::FETCH_ASSOC);

          $productName = $product['product_name'];
          $productPrice = $product['price'];
          // $productImage = $product['image_url'];
          $productSku = $product['sku'];
          $productDetailsPage = "../includes/productDetails.php?product_id=" . $productId;

          $brandSql = "SELECT * FROM brands WHERE brand_id = :brand_id";
          $stmt = $conn->prepare($brandSql);
          $stmt->bindParam(':brand_id', $product['brand_id']);
          $stmt->execute();
          $brand = $stmt->fetch(PDO::FETCH_ASSOC);

          $brandName = $brand['brand_name'];

          $qty = $item['quantity'];


          include "../includes/cartItem.php";
        }
        ?>




      </div>

      <!-- Order Summary Column -->
      <div class="col-lg-4">
        <div class="cart-summary">
          <h3 class="summary-title">Order Summary</h3>

          <div class="summary-item">
            <span>Subtotal</span>
            <span>LKR <?php echo $totalPrice ?>.00</span>
          </div>
          <div class="summary-total">
            <span>Total</span>
            <span>LKR <?php echo $totalPrice ?>.00</span>
          </div>

          <!-- Checkout Button -->
          <a href="./checkout.php"><button class="btn btn-dark w-100 checkout-btn">Proceed to Checkout</button></a>
          <a href="#" class="continue-shopping d-block text-center">
            <i class="fas fa-long-arrow-alt-left me-1"></i> Continue Shopping
          </a>

          <!-- Delivery Information -->
          <div class="mt-4 pt-3 border-top">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-truck me-2"></i>
              <span class="fw-bold">Free Shipping</span>
            </div>
            <p class="text-muted small mb-2">Orders over $100 qualify for free shipping</p>

            <div class="d-flex align-items-center mb-2 mt-3">
              <i class="fas fa-shield-alt me-2"></i>
              <span class="fw-bold">Secure Checkout</span>
            </div>
            <p class="text-muted small mb-0">100% Protected and Secure</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <footer id="footer" class="overflow-hidden" style="color: #000; padding-top: 3rem; padding-bottom: 2rem;">
    <div class="container">
      <div class="row footer-top-area d-flex flex-wrap justify-content-between">
        <div class="col-lg-4 col-sm-6 mb-4">
          <div class="footer-menu">
            <img src="../assets/images/download.png" class="logo" width="80px" height="80px" />
            <p>
              Find the latest smartphones, accessories, and great deals all in one place.<br>
              <span style="color: #0dcaf0;">Quality phones with reliable service just for you!</span>
            </p>
          </div>
        </div>
        <div class="col-lg-2 col-sm-6 mb-4">
          <div class="footer-menu text-uppercase">
            <h5 class="widget-title pb-2" style="color:#000;">Quick Links</h5>
            <ul class="menu-list list-unstyled text-uppercase">
              <li class="menu-item pb-2">
                <a href="../index.php" class="text-dark text-decoration-none">Home</a>
              </li>
              <li class="menu-item pb-2">
                <a href="../pages/phones.php" class="text-dark text-decoration-none">Phones</a>
              </li>
              <li class="menu-item pb-2">
                <a href="../pages/phones.php" class="text-dark text-decoration-none">Shop</a>
              </li>
              <li class="menu-item pb-2">
                <a href="../pages/sign_in.php" class="text-dark text-decoration-none">Sign In</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mb-4">
          <div class="footer-menu contact-item">
            <h5 class="widget-title text-uppercase pb-2" style="color:#000;">Contact Us</h5>
            <ul class="list-unstyled">
              <li class="mb-2">
                <i class="fas fa-envelope me-2"></i>
                <a href="mailto:mobimart@info.com" class="text-dark text-decoration-none">mobimart@info.com</a>
              </li>
              <li class="mb-2">
                <i class="fas fa-phone me-2"></i>
                <a href="tel:+9477177111" class="text-dark text-decoration-none">+94 764975098</a>
              </li>
              <li>
                <i class="fas fa-map-marker-alt me-2"></i>
                <span>No. 123, Main Street, Kegalle, Sri Lanka</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <hr />

      <div id="footer-bottom">
        <div class="container">
          <div class="row d-flex flex-wrap justify-content-between">

            <div>
              <div class="copyright">
                <p class="justify-content-center text-center">
                  © Copyright 2023 MobiMart.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- end footer  -->

  <script type="text/javascript" src="../assets/js/ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>