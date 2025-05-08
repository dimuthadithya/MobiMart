<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete - MiniStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/vendor.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
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

        main {
            padding: 40px 0;
        }

        .progress-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .progress-bar {
            position: absolute;
            top: 15px;
            left: 0;
            height: 2px;
            width: 100%;
            background-color: #e0e0e0;
            z-index: 1;
        }

        .progress-completed {
            position: absolute;
            top: 15px;
            left: 0;
            height: 2px;
            width: 100%;
            background-color: #4caf50;
            z-index: 2;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 3;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .step-completed .step-circle {
            background-color: #4caf50;
            border-color: #4caf50;
            color: white;
        }

        .step-active .step-circle {
            background-color: white;
            border-color: #4caf50;
            color: #4caf50;
        }

        .step-label {
            font-size: 14px;
            color: #757575;
        }

        .step-completed .step-label,
        .step-active .step-label {
            color: #333;
            font-weight: 500;
        }

        .order-success {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #f0f9f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            color: #4caf50;
        }

        .order-details {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .order-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .order-info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #757575;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }

        .order-summary {
            background-color: white;
            border-radius: 8px;
            box-shadow: la 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .summary-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item-image {
            width: 60px;
            height: 60px;
            background-color: #f5f7fa;
            border-radius: 4px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-variant {
            font-size: 14px;
            color: #757575;
        }

        .item-price {
            font-weight: 500;
        }

        .summary-totals {
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-label {
            color: #757575;
        }

        .total-value {
            font-weight: 500;
        }

        .grand-total {
            font-size: 18px;
            font-weight: 600;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #4caf50;
            color: white;
            border: none;
        }

        .btn-outline {
            background-color: white;
            color: #333;
            border: 1px solid #e0e0e0;
        }

        .order-number {
            background-color: #f5f7fa;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
            display: inline-block;
            margin-top: 10px;
        }

        .delivery-info {
            display: flex;
            align-items: center;
            background-color: #f0f9f0;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .delivery-icon {
            margin-right: 15px;
            color: #4caf50;
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
    </style>
</head>

<body>
    <!-- <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">MiniStore</a>
                <div class="nav-links">
                    <a href="#">Home</a>
                    <a href="#">Shop</a>
                    <a href="#">Deals</a>
                    <a href="#">Support</a>
                </div>
                <div class="header-icons">
                    <a href="#"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></a>
                    <a href="#"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
                    <a href="#"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></a>
                    <a href="#" class="cart-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span class="cart-count">3</span>
                    </a>
                </div>
            </div>
        </div>
    </header> -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="./assets/images/main-logo.png" alt="Mobile Shop">
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
                    <a href="./cart.php" class="nav-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">3</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container p-3">
        <h1>Order Complete</h1>

        <div class="checkout-steps mt-5">
            <div class="step completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">Shopping Cart</div>
                <div class="step-line"></div>
            </div>
            <div class="step completed">
                <div class="step-circle">2</div>
                <div class="step-title">Checkout</div>
                <!-- <div class="step-line"></div> -->
            </div>
            <div class="step active">
                <div class="step-circle">3</div>
                <div class="step-title">Order Complete</div>
                <div class="step-line"></div>
            </div>
        </div>

        <div class="order-success">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h2>Thank You For Your Order!</h2>
            <p>Your order has been placed and is being processed. You will receive an email confirmation shortly.</p>
            <div class="order-number">Order #MNS-78912345</div>

            <div class="delivery-info">
                <div class="delivery-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                </div>
                <div>
                    <p><strong>Estimated delivery:</strong> May 12-15, 2025</p>
                    <p>Your items will be delivered to: 123 Main Street, Apt 4B, New York, NY 10001</p>
                </div>
            </div>
        </div>

        <div class="order-grid">
            <div class="order-details">
                <h3 class="section-title">Order Information</h3>

                <div class="order-info-item">
                    <div class="info-label">Order Date</div>
                    <div class="info-value">May 8, 2025</div>
                </div>

                <div class="order-info-item">
                    <div class="info-label">Order Number</div>
                    <div class="info-value">MNS-78912345</div>
                </div>

                <div class="order-info-item">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">Credit Card (ending in 3456)</div>
                </div>

                <div class="divider"></div>

                <h3 class="section-title">Shipping Information</h3>

                <div class="order-info-item">
                    <div class="info-label">Shipping Address</div>
                    <div class="info-value">
                        John Doe<br>
                        123 Main Street, Apt 4B<br>
                        New York, NY 10001<br>
                        United States
                    </div>
                </div>

                <div class="order-info-item">
                    <div class="info-label">Shipping Method</div>
                    <div class="info-value">Standard Delivery (3-5 business days)</div>
                </div>

                <div class="divider"></div>

                <h3 class="section-title">Contact Information</h3>

                <div class="order-info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">your@email.com</div>
                </div>

                <div class="order-info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">(123) 456-7890</div>
                </div>
            </div>

            <div class="order-summary">
                <h3 class="section-title">Order Summary (3 items)</h3>

                <div class="summary-item">
                    <div class="item-image">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <div class="item-details">
                        <div class="item-name">iPhone 13 Pro</div>
                        <div class="item-variant">Sierra Blue, 256GB</div>
                    </div>
                    <div class="item-price">$999.00</div>
                </div>

                <div class="summary-item">
                    <div class="item-image">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                            <path d="M2 12h1a4 4 0 0 1 4-4h9.5a4 4 0 0 1 0 8H7a4 4 0 0 1-4-4H2z"></path>
                            <circle cx="9" cy="12" r="1"></circle>
                        </svg>
                    </div>
                    <div class="item-details">
                        <div class="item-name">AirPods Pro</div>
                        <div class="item-variant">White, 2nd Generation</div>
                    </div>
                    <div class="item-price">$249.00</div>
                </div>

                <div class="summary-item">
                    <div class="item-image">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <rect x="6" y="8" width="12" height="8" rx="1"></rect>
                        </svg>
                    </div>
                    <div class="item-details">
                        <div class="item-name">Silicone Case</div>
                        <div class="item-variant">Midnight Blue, iPhone 13 Pro</div>
                    </div>
                    <div class="item-price">$49.00</div>
                </div>

                <div class="summary-totals">
                    <div class="total-row">
                        <div class="total-label">Subtotal</div>
                        <div class="total-value">$1,297.00</div>
                    </div>

                    <div class="total-row">
                        <div class="total-label">Shipping</div>
                        <div class="total-value">$0.00</div>
                    </div>

                    <div class="total-row">
                        <div class="total-label">Tax</div>
                        <div class="total-value">$103.76</div>
                    </div>

                    <div class="total-row grand-total">
                        <div class="total-label">Total</div>
                        <div class="total-value">$1,400.76</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="#" class="btn btn-outline">View Order History</a>
            <a href="#" class="btn btn-primary">Continue Shopping</a>
        </div>
    </main>

    <!-- <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Mobile Shop</h3>
                    <p>The best place to buy the latest smartphones and accessories at competitive prices.</p>
                    <div class="social-links">
                        <a href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        <a href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
                        <a href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                        <a href="#"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Customer Service</h3>
                    <ul>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">Order Tracking</a></li>
                        <li><a href="#">Warranty & Support</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <p>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        123 Tech Street, City, Country
                    </p>
                    <p>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        +1 (555) 123 4567
                    </p>
                    <p>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        support@mobileshop.com
                    </p>
                </div>
            </div>
            
            <div class="copyright">
                © 2025 Mobile Shop. All Rights Reserved.
            </div>
        </div>
    </footer> -->
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

</body>

</html>