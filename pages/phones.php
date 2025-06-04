<?php
require_once '../config/db.php';
session_start();
// Fetch all phones from the database with brand information
$query = "SELECT p.*, b.brand_name 
          FROM products p 
          LEFT JOIN brands b ON p.brand_id = b.brand_id 
          WHERE p.status = 'available' 
          ORDER BY p.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobiMart - Mobile Phones</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        type="text/css"
        href="./assets/css/bootstrap.min.css" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/banner-image.png');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            margin-bottom: 40px;
            color: white;
            text-align: center;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 250px;
            object-fit: contain;
            background: #f8f9fa;
            padding: 20px;
        }

        .filters {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .form-select {
            border-radius: 10px;
            padding: 12px;
            border-color: #e9ecef;
        }

        .form-select:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        .btn-filter {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .price-tag {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 15px 0;
            color: #2c3e50;
        }

        .product-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 25px;
            font-size: 0.9rem;
        }

        .pagination .page-link {
            border-radius: 50%;
            margin: 0 5px;
            color: #2c3e50;
            border: none;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            padding: 0;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: white;
        }

        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 180px;
            object-fit: contain;
            background: #f8f9fa;
            padding: 1rem;
        }

        .quick-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .product-card:hover .quick-actions {
            opacity: 1;
        }

        .quick-actions .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .quick-actions .btn:hover {
            background: #007bff;
            color: white;
        }

        .product-title {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.5rem;
            font-size: 0.9rem;
            color: #2c3e50;
        }

        .price-wrapper {
            font-size: 0.9rem;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet" />

    <script src="js/modernizr.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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


    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Discover Latest Smartphones</h1>
            <p class="lead mb-0">Find the perfect phone that matches your style and needs</p>
        </div>
    </div>

    <div class="container">
        <!-- Filters Section -->
        <div class="filters">
            <div class="filter-title mb-4">Filter & Sort Products</div>
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Select Brand</option>
                        <option>Apple</option>
                        <option>Samsung</option>
                        <option>Google</option>
                        <option>Xiaomi</option>
                        <option>OnePlus</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Sort By</option>
                        <option>Newest First</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Most Popular</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-filter w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div> <!-- Products Grid -->


        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-4">
            <?php foreach ($products as $product):
                $productName = $product['product_name'];
                $productPrice = $product['price'];
                $productDescription = $product['description'];
                $productId = $product['product_id'];
                $productImage = "../assets/uploads/products/" . $product['image_url'];
                $productDetailsPage = '../includes/productDetails.php?product_id=' . $productId;

                include '../includes/productCardNew.php';
            endforeach; ?>
        </div>

        <!-- Quick View Modal -->
        <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Quick View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="" alt="Product Image" class="img-fluid" id="modalProductImage">
                            </div>
                            <div class="col-md-6">
                                <h4 id="modalProductName"></h4>
                                <p class="text-muted mb-2" id="modalProductBrand"></p>
                                <p class="text-muted mb-2">SKU: <span id="modalProductSku"></span></p>
                                <h5 class="mb-3">Price: $<span id="modalProductPrice"></span></h5>
                                <p id="modalProductDescription"></p>
                                <div class="mt-3">
                                    <button class="btn btn-primary add-to-cart">
                                        <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Quick View Modal
            const quickViewModal = document.getElementById('quickViewModal');
            quickViewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');

                // Here you would typically make an AJAX call to get the product details
                // For now, we'll use the data attributes from the card
                const card = button.closest('.product-card');
                const name = card.querySelector('.product-title').textContent;
                const brand = card.querySelector('.text-uppercase').textContent;
                const price = card.querySelector('.price-wrapper span').textContent.replace('$', '');
                const image = card.querySelector('.product-image').src;
                const sku = card.querySelector('small.text-muted').textContent.replace('SKU: ', '');

                // Update modal content
                document.getElementById('modalProductName').textContent = name;
                document.getElementById('modalProductBrand').textContent = brand;
                document.getElementById('modalProductPrice').textContent = price;
                document.getElementById('modalProductSku').textContent = sku;
                document.getElementById('modalProductImage').src = image;
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Add to cart functionality
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    // Add your cart functionality here

                    // Show toast
                    const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                    toast.show();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Get filter elements
                const brandSelect = document.querySelector('.filters select:nth-child(1), .filters .col-md-3:nth-child(1) select');
                const sortSelect = document.querySelector('.filters select:nth-child(2), .filters .col-md-3:nth-child(2) select');
                const filterBtn = document.querySelector('.btn-filter');
                const productCards = document.querySelectorAll('.product-card');

                // Filtering function
                function filterProducts() {
                    const brand = brandSelect.value;
                    const sort = sortSelect.value;

                    let filtered = Array.from(productCards);

                    // Filter by brand
                    if (brand !== 'Select Brand') {
                        filtered = filtered.filter(card => {
                            const cardBrand = card.querySelector('.text-uppercase')?.textContent.trim();
                            return cardBrand && cardBrand.toLowerCase().includes(brand.toLowerCase());
                        });
                    }

                    // Hide all cards first
                    productCards.forEach(card => card.parentElement.style.display = 'none');

                    // Show filtered cards
                    filtered.forEach(card => card.parentElement.style.display = '');

                    // Sort
                    if (sort === 'Price: Low to High') {
                        filtered.sort((a, b) => {
                            const aPrice = parseInt(a.querySelector('.price-tag, .price-wrapper span')?.textContent.replace(/[^\d]/g, ''), 10);
                            const bPrice = parseInt(b.querySelector('.price-tag, .price-wrapper span')?.textContent.replace(/[^\d]/g, ''), 10);
                            return aPrice - bPrice;
                        });
                    } else if (sort === 'Price: High to Low') {
                        filtered.sort((a, b) => {
                            const aPrice = parseInt(a.querySelector('.price-tag, .price-wrapper span')?.textContent.replace(/[^\d]/g, ''), 10);
                            const bPrice = parseInt(b.querySelector('.price-tag, .price-wrapper span')?.textContent.replace(/[^\d]/g, ''), 10);
                            return bPrice - aPrice;
                        });
                    } else if (sort === 'Newest First') {
                        // Assuming cards are already in newest order
                    }

                    // Reorder DOM for sorting
                    const grid = document.querySelector('.row.row-cols-2');
                    if (grid && (sort === 'Price: Low to High' || sort === 'Price: High to Low')) {
                        filtered.forEach(card => grid.appendChild(card.parentElement));
                    }
                }

                filterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    filterProducts();
                });
            });
        </script>
    </div>


    <!-- footer -->
    <footer id="footer" class="overflow-hidden" style="color: #000; padding-top: 3rem; padding-bottom: 2rem;">
        <div class="container">
            <div class="row footer-top-area d-flex flex-wrap justify-content-between">
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="footer-menu">
                        <img src="../assets/images/download.png" alt="MobiMart Logo" width="80px" height="80px" class="mb-3" />
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


    <!-- Scripts -->
    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        // Add active class to current navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const shopLink = document.querySelector('a[href="#"].nav-link');
            if (shopLink) {
                shopLink.classList.add('active');
            }
        });
    </script>
</body>

</html>