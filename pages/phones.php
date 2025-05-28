<?php
require_once '../config/db.php';

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
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <?php
    include '../includes/nav.php';
    ?>

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
                        <option selected>Price Range</option>
                        <option>Under $500</option>
                        <option>$500 - $800</option>
                        <option>$800 - $1200</option>
                        <option>Above $1200</option>
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
        </script>

        <!-- Pagination -->
        <nav class="mt-5 mb-5">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <?php
    include '../includes/footer.php';
    ?>

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