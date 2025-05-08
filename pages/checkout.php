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
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/vendor.css">
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
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
      <a class="navbar-brand" href="#">
        <img src="./assets/images/main-logo.png" alt="Mobile Shop">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto w-100 d-flex justify-content-end p-3">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
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
          <a href="#" class="nav-icon">
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

    <div class="row">
      <!-- Checkout Form Column -->
      <div class="col-lg-8 mb-4">

        <!-- Shipping Address Section -->
        <div class="checkout-section">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="section-title">Shipping Address</h3>
            <a href="#" class="edit-link">+ Add New Address</a>
          </div>

          <div class="address-select selected">
            <input class="form-check-input" type="radio" name="address" id="address1" checked>
            <div class="address-title">Home</div>
            <div class="address-details">
              <p class="mb-1">John Doe</p>
              <p class="mb-1">123 Main Street, Apt 4B</p>
              <p class="mb-1">New York, NY 10001</p>
              <p class="mb-0">United States</p>
            </div>
          </div>

          <div class="address-select">
            <input class="form-check-input" type="radio" name="address" id="address2">
            <div class="address-title">Office</div>
            <div class="address-details">
              <p class="mb-1">John Doe</p>
              <p class="mb-1">456 Business Ave, Suite 200</p>
              <p class="mb-1">New York, NY 10002</p>
              <p class="mb-0">United States</p>
            </div>
          </div>
        </div>

        <!-- Delivery Method Section -->
        <div class="checkout-section">
          <h3 class="section-title">Delivery Method</h3>

          <div class="delivery-method selected">
            <div class="method-details">
              <div class="method-icon">
                <i class="fas fa-truck"></i>
              </div>
              <div class="method-info">
                <div class="method-title">Standard Delivery</div>
                <div class="method-description">Delivery within 3-5 business days</div>
              </div>
            </div>
            <div class="method-price">Free</div>
          </div>

          <div class="delivery-method">
            <div class="method-details">
              <div class="method-icon">
                <i class="fas fa-shipping-fast"></i>
              </div>
              <div class="method-info">
                <div class="method-title">Express Delivery</div>
                <div class="method-description">Delivery within 1-2 business days</div>
              </div>
            </div>
            <div class="method-price">$12.99</div>
          </div>

          <div class="delivery-method">
            <div class="method-details">
              <div class="method-icon">
                <i class="fas fa-store-alt"></i>
              </div>
              <div class="method-info">
                <div class="method-title">Store Pickup</div>
                <div class="method-description">Pickup from our nearest store</div>
              </div>
            </div>
            <div class="method-price">Free</div>
          </div>
        </div>

        <!-- Payment Method Section -->
        <div class="checkout-section">
          <h3 class="section-title">Payment Method</h3>

          <div class="payment-option selected">
            <div class="payment-title">
              <i class="fab fa-cc-visa payment-icon" style="color: #1a1f71;"></i>
              Credit/Debit Card
            </div>
            <div class="payment-details">
              <div class="row g-3">
                <div class="col-12">
                  <label for="cardName" class="form-label">Name on Card</label>
                  <input type="text" class="form-control" id="cardName" placeholder="John Doe">
                </div>
                <div class="col-12">
                  <label for="cardNumber" class="form-label">Card Number</label>
                  <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                </div>
                <div class="col-md-6">
                  <label for="cardExpiry" class="form-label">Expiration Date</label>
                  <input type="text" class="form-control" id="cardExpiry" placeholder="MM/YY">
                </div>
                <div class="col-md-6">
                  <label for="cardCvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cardCvv" placeholder="123">
                </div>
              </div>
            </div>
          </div>

          <div class="payment-option">
            <div class="payment-title">
              <i class="fab fa-paypal payment-icon" style="color: #003087;"></i>
              PayPal
            </div>
            <div class="payment-details">
              <p class="text-muted">You will be redirected to PayPal to complete your payment.</p>
            </div>
          </div>

          <div class="payment-option">
            <div class="payment-title">
              <i class="fab fa-apple payment-icon"></i>
              Apple Pay
            </div>
            <div class="payment-details">
              <p class="text-muted">Pay securely using Apple Pay.</p>
            </div>
          </div>
        </div>

        <!-- Billing Address -->
        <div class="checkout-section">
          <h3 class="section-title">Billing Address</h3>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="sameAsShipping" checked>
            <label class="form-check-label" for="sameAsShipping">
              Same as shipping address
            </label>
          </div>
        </div>

        <!-- Contact Information -->
        <div class="checkout-section">
          <h3 class="section-title">Contact Information</h3>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="emailAddress" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="emailAddress" placeholder="your@email.com">
            </div>
            <div class="col-md-6">
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phoneNumber" placeholder="(123) 456-7890">
            </div>
          </div>
        </div>

      </div>

      <!-- Order Summary Column -->
      <div class="col-lg-4">
        <div class="order-summary">
          <h3 class="summary-title">Order Summary <span class="text-muted fs-6">(3 items)</span></h3>

          <!-- Order Items -->
          <div class="mb-4">
            <?php
            $totalPrice = 0;

            foreach ($cartItems as $item) {
              $productId = $item['product_id'];

              $productSql = "SELECT * FROM products WHERE product_id = :product_id";
              $productStmt = $conn->prepare($productSql);
              $productStmt->execute(['product_id' => $productId]);
              $product = $productStmt->fetch(PDO::FETCH_ASSOC);

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

              $totalPrice += $productPrice;

              include '../includes/orderSummaryItem.php';
            }
            ?>

          </div>

          <!-- Order Totals -->
          <div class="summary-item">
            <span>Subtotal</span>
            <span>LKR <?php echo $totalPrice ?></span>
          </div>
          <div class="summary-item">
            <span>Shipping</span>
            <span>LKR 0.00</span>
          </div>
          <div class="summary-item">
            <span>Tax</span>
            <span>LKR 0.00</span>
          </div>

          <div class="summary-total">
            <span>Total</span>
            <span>LKR <?php echo $totalPrice ?>.00</span>
          </div>

          <!-- Promo Code Section -->
          <div class="promo-code">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Promo code">
              <button class="btn btn-outline-dark" type="button">Apply</button>
            </div>
          </div>

          <!-- Complete Order Button -->
          <form action="../controller/checkout_process.php" method="post">
            <button class="btn btn-dark w-100 checkout-btn" type="submit">Complete Order</button>
          </form>

          <!-- Secure Payment Info -->
          <div class="text-center mt-3">
            <div class="d-flex align-items-center justify-content-center">
              <i class="fas fa-lock me-2"></i>
              <span class="small">Secure Checkout</span>
            </div>
            <div class="mt-3">
              <i class="fab fa-cc-visa fa-2x me-2" style="color: #1a1f71;"></i>
              <i class="fab fa-cc-mastercard fa-2x me-2" style="color: #eb001b;"></i>
              <i class="fab fa-cc-amex fa-2x me-2" style="color: #006fcf;"></i>
              <i class="fab fa-cc-paypal fa-2x" style="color: #003087;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb-4 mb-md-0">
          <h5 class="footer-title">Mobile Shop</h5>
          <p class="text-muted">The best place to buy the latest smartphones and accessories at competitive prices.</p>
          <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <h5 class="footer-title">Quick Links</h5>
          <ul class="footer-links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">FAQs</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4 mb-md-0">
          <h5 class="footer-title">Customer Service</h5>
          <ul class="footer-links">
            <li><a href="#">Shipping Policy</a></li>
            <li><a href="#">Returns & Refunds</a></li>
            <li><a href="#">Order Tracking</a></li>
            <li><a href="#">Warranty & Support</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5 class="footer-title">Contact Info</h5>
          <ul class="footer-links">
            <li><i class="fas fa-map-marker-alt me-2"></i> 123 Tech Street, City, Country</li>
            <li><i class="fas fa-phone-alt me-2"></i> +1 (555) 123-4567</li>
            <li><i class="fas fa-envelope me-2"></i> support@mobileshop.com</li>
          </ul>
        </div>
      </div>
      <div class="copyright">
        <p>&copy; 2025 Mobile Shop. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Simple script to handle interactions - in a real application, this would be more comprehensive
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

      // Delivery method selection
      const deliveryOptions = document.querySelectorAll('.delivery-method');
      deliveryOptions.forEach(option => {
        option.addEventListener('click', function() {
          deliveryOptions.forEach(opt => opt.classList.remove('selected'));
          this.classList.add('selected');
        });
      });

      // Payment method selection
      const paymentOptions = document.querySelectorAll('.payment-option');
      paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
          paymentOptions.forEach(opt => opt.classList.remove('selected'));
          this.classList.add('selected');
        });
      });
    });
  </script>
</body>

</html>