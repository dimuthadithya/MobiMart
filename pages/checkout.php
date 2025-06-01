<?php
include_once '../config/db.php';
session_start();


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: ./sign_in.php?error=not_logged_in");
  exit();
}


// Fetch cart items from the database
$sql = "SELECT * FROM cart WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cartItems) == 0) {
  header("Location: ./cart.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile Shop - Checkout</title>
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

    .checkout-container {
      padding: 30px 0;
      min-height: 100vh;
    }

    .checkout-header {
      margin-bottom: 30px;
    }

    .checkout-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      width: 33.33%;
    }

    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #e9ecef;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      margin-bottom: 10px;
      z-index: 2;
    }

    .step.active .step-circle {
      background-color: #212529;
      color: white;
    }

    .step.completed .step-circle {
      background-color: #198754;
      color: white;
    }

    .step-title {
      font-size: 14px;
      text-align: center;
    }

    .step-line {
      position: absolute;
      top: 20px;
      height: 2px;
      background-color: #e9ecef;
      width: 100%;
      left: 50%;
      z-index: 1;
    }

    .step:first-child .step-line {
      width: 50%;
      left: 50%;
    }

    .step:last-child .step-line {
      width: 50%;
      right: 50%;
    }

    .step.completed .step-line {
      background-color: #198754;
    }

    .checkout-section {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      padding: 25px;
      margin-bottom: 20px;
    }

    .section-title {
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .form-label {
      font-weight: 500;
      font-size: 14px;
    }

    .address-select {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      cursor: pointer;
      position: relative;
      transition: all 0.2s;
    }

    .address-select:hover {
      border-color: #adb5bd;
    }

    .address-select.selected {
      border-color: #212529;
      background-color: #f8f9fa;
    }

    .address-select .form-check-input {
      position: absolute;
      top: 15px;
      right: 15px;
    }

    .address-select .address-title {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .address-select .address-details {
      font-size: 14px;
      color: #6c757d;
    }

    .payment-option {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .payment-option:hover {
      border-color: #adb5bd;
    }

    .payment-option.selected {
      border-color: #212529;
      background-color: #f8f9fa;
    }

    .payment-option .payment-title {
      font-weight: 600;
      display: flex;
      align-items: center;
    }

    .payment-icon {
      margin-right: 10px;
      font-size: 24px;
    }

    .payment-details {
      padding-top: 15px;
      margin-top: 15px;
      border-top: 1px solid #eee;
      display: none;
    }

    .payment-option.selected .payment-details {
      display: block;
    }

    .order-summary {
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

    .summary-product {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      padding-bottom: 10px;
      border-bottom: 1px solid #f0f0f0;
    }

    .summary-product:last-child {
      border-bottom: none;
    }

    .summary-product-image {
      width: 50px;
      height: 50px;
      object-fit: contain;
      margin-right: 10px;
    }

    .summary-product-title {
      font-size: 14px;
      font-weight: 500;
    }

    .summary-product-variant {
      font-size: 12px;
      color: #6c757d;
    }

    .summary-product-price {
      font-weight: 600;
      margin-left: auto;
      padding-left: 10px;
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

    .promo-code {
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px solid #eee;
    }

    .edit-link {
      font-size: 14px;
      color: #0d6efd;
      text-decoration: none;
    }

    .edit-link:hover {
      text-decoration: underline;
    }

    .delivery-method {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .delivery-method:hover {
      border-color: #adb5bd;
    }

    .delivery-method.selected {
      border-color: #212529;
      background-color: #f8f9fa;
    }

    .delivery-method .method-details {
      display: flex;
      align-items: center;
    }

    .delivery-method .method-icon {
      font-size: 24px;
      margin-right: 15px;
    }

    .delivery-method .method-info {
      display: flex;
      flex-direction: column;
    }

    .delivery-method .method-title {
      font-weight: 600;
    }

    .delivery-method .method-description {
      font-size: 12px;
      color: #6c757d;
    }

    .delivery-method .method-price {
      font-weight: 600;
    }

    .navbar {
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
    }

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

    footer {
      background-color: #212529;
      color: white;
      padding: 40px 0 20px;
    }

    .footer-title {
      font-weight: 600;
      margin-bottom: 20px;
    }

    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-links li {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: #adb5bd;
      text-decoration: none;
      transition: all 0.2s;
    }

    .footer-links a:hover {
      color: white;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-icon {
      color: white;
      font-size: 18px;
      transition: all 0.2s;
    }

    .social-icon:hover {
      color: #adb5bd;
    }

    .copyright {
      padding-top: 20px;
      margin-top: 30px;
      border-top: 1px solid #495057;
      text-align: center;
      font-size: 14px;
      color: #adb5bd;
    }

    @media (max-width: 767px) {
      .step-title {
        font-size: 12px;
      }

      .step-circle {
        width: 30px;
        height: 30px;
        font-size: 14px;
      }

      .step-line {
        top: 15px;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
      <a class="navbar-brand" href="../index.php">
        <img src="../assets/images/main-logo.png" alt="Mobile Shop">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto w-100 d-flex justify-content-end p-3">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Deals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Support</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <a href="#" class="nav-icon">
            <i class="fas fa-search"></i>
          </a>
          <a href="#" class="nav-icon">
            <i class="fas fa-user"></i>
          </a>
          <a href="#" class="nav-icon">
            <i class="fas fa-heart"></i>
          </a>
          <a href="../cart.php" class="nav-icon">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count">3</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Checkout Content -->
  <div class="container checkout-container">
    <div class="checkout-header">
      <h1 class="fw-bold mb-4">Checkout</h1>

      <!-- Checkout Progress Steps -->
      <div class="checkout-steps">
        <div class="step completed">
          <div class="step-circle"><i class="fas fa-check"></i></div>
          <div class="step-title">Shopping Cart</div>
          <div class="step-line"></div>
        </div>
        <div class="step active">
          <div class="step-circle">2</div>
          <div class="step-title">Checkout</div>
          <div class="step-line"></div>
        </div>
        <div class="step">
          <div class="step-circle">3</div>
          <div class="step-title">Order Complete</div>
          <div class="step-line"></div>
        </div>
      </div>
    </div>

    <div class="row">      <!-- Checkout Form Column -->
      <div class="col-lg-8 mb-4">
        <form action="../controller/checkout_process.php" method="post" id="checkoutForm">
          <!-- Delivery Address Section -->
          <div class="checkout-section">
            <h3 class="section-title">Delivery Address</h3>

            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullName" required>
              </div>
              <div class="col-12">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control" name="streetAddress" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">District</label>
                <input type="text" class="form-control" name="district" required>
              </div>
              <div class="col-12">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone" required>
              </div>
            </div>
          </div>
        <!-- Payment Method Section -->
        <div class="checkout-section">
          <h3 class="section-title">Payment Method</h3>          <div class="mb-4">
            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" value="cash" checked>
              <label class="form-check-label" for="cashOnDelivery">
                <i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="cardPayment" value="card">
              <label class="form-check-label" for="cardPayment">
                <i class="fas fa-credit-card me-2"></i>Credit/Debit Card
              </label>
            </div>
          </div>

          <!-- Card Payment Details (Hidden by default) -->
          <div id="cardDetails" style="display: none;">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Name on Card</label>
                <input type="text" class="form-control" placeholder="John Doe">
              </div>
              <div class="col-12">
                <label class="form-label">Card Number</label>
                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
              </div>
              <div class="col-md-6">
                <label class="form-label">Expiration Date</label>
                <input type="text" class="form-control" placeholder="MM/YY">
              </div>
              <div class="col-md-6">
                <label class="form-label">CVV</label>
                <input type="text" class="form-control" placeholder="123">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Summary Column -->
      <div class="col-lg-4">
        <div class="order-summary">
          <h3 class="summary-title">Order Summary <span class="text-muted fs-6"></span></h3>

          <!-- Order Items -->
          <div class="mb-4">
            <?php
            $totalPrice = 0;
            $qty = 0;

            foreach ($cartItems as $item) {
              $productId = $item['product_id'];

              $productSql = "SELECT * FROM products WHERE product_id = :product_id";
              $productStmt = $conn->prepare($productSql);
              $productStmt->execute(['product_id' => $productId]);
              $product = $productStmt->fetch(PDO::FETCH_ASSOC);
              $qty += $item['quantity'];

              $productName = $product['product_name'];
              $productPrice = $product['price'];
              $productImage = $product['image_url'] ? "../assets/uploads/products/" . htmlspecialchars($product['image_url']) : "../assets/images/product-item1.jpg";
              // $productImage = $product['image_url'];
              $productSku = $product['sku'];
              $productDetailsPage = "../includes/productDetails.php?product_id=" . $productId;

              $brandSql = "SELECT * FROM brands WHERE brand_id = :brand_id";
              $stmt = $conn->prepare($brandSql);
              $stmt->bindParam(':brand_id', $product['brand_id']);
              $stmt->execute();
              $brand = $stmt->fetch(PDO::FETCH_ASSOC);

              $brandName = $brand['brand_name'];

              $totalPrice += $productPrice;

              include '../includes/orderSummaryItem.php';
            }
            ?>

          </div>

          <!-- Order Total -->
          <div class="summary-total">
            <span>Total</span>
            <span>LKR <?php echo $totalPrice * $qty; ?>.00</span>
          </div>          <!-- Complete Order Button -->
          <button class="btn btn-dark w-100 checkout-btn" type="submit" form="checkoutForm">Complete Order</button>

          <!-- Secure Payment Info -->
          <div class="text-center mt-3">
            <div class="d-flex align-items-center justify-content-center">
              <i class="fas fa-lock me-2"></i>
              <span class="small">Secure Checkout</span>
            </div>
            <div class="mt-3">
              <i class="fab fa-cc-visa fa-2x me-2" style="color: #1a1f71;"></i>
              <i class="fab fa-cc-mastercard fa-2x me-2" style="color: #eb001b;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Address selection
      const addressOptions = document.querySelectorAll('.address-select');
      addressOptions.forEach(option => {
        option.addEventListener('click', function() {
          addressOptions.forEach(opt => opt.classList.remove('selected'));
          this.classList.add('selected');
          this.querySelector('input').checked = true;
        });
      });

      // Payment method toggle
      const cardPayment = document.getElementById('cardPayment');
      const cardDetails = document.getElementById('cardDetails');

      function toggleCardDetails() {
        cardDetails.style.display = cardPayment.checked ? 'block' : 'none';
      }

      cardPayment.addEventListener('change', toggleCardDetails);
      document.getElementById('cashOnDelivery').addEventListener('change', toggleCardDetails);
    });
  </script>
</body>

</html>