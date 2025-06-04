<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete - MiniStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/vendor.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
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
        } */

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

    <!-- nav -->
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

    <main class="container p-3">
        <h1>Order Complete</h1>

        <div class="checkout-steps mt-5">
            <div class="step completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">Shopping Cart</div>
                <!-- <div class="step-line"></div> -->
            </div>
            <div class="step completed">
                <div class="step-circle">2</div>
                <div class="step-title">Checkout</div>
                <!-- <div class="step-line"></div> -->
            </div>
            <div class="step active">
                <div class="step-circle">3</div>
                <div class="step-title">Order Complete</div>
                <!-- <div class="step-line"></div> -->
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

            <!-- <div class="delivery-info">
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
        </div> -->

            <!-- <div class="order-grid">
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
            </div> -->

            <div class="actions">
                <a href="./User/dashboard.php" class="btn btn-outline">View Order History</a>
                <a href="../index.php" class="btn btn-primary">Continue Shopping</a>
            </div>
    </main>

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

</body>

</html>