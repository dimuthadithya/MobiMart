<?php

include_once '../config/db.php';

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
} else {
    header("Location: index.php");
    exit();
}

// Get product details
$productSql = "SELECT p.*, b.brand_name 
            FROM products p 
            LEFT JOIN brands b ON p.brand_id = b.brand_id 
            WHERE p.product_id = :product_id";
$stmt = $conn->prepare($productSql);
$stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: index.php");
    exit();
}

// Get product images
$imagesSql = "SELECT image_url FROM product_images WHERE product_id = :product_id ORDER BY created_at";
$stmt = $conn->prepare($imagesSql);
$stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
$stmt->execute();
$productImages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set up variables
$productName = $product['product_name'];
$productPrice = $product['price'];
$productDescription = $product['description'];
$productSku = $product['sku'];
$productStock = $product['quantity'];
$productImage = $product['image_url'];
$productBrandId = $product['brand_id'];
$brandName = $product['brand_name'];

// Format price and discount
$discountPercent = 6; // This could come from the database in the future
$originalPrice = $productPrice + ($productPrice * ($discountPercent / 100));

// Create description points from product description
$descriptionPoints = array_filter(array_map('trim', explode('.', $productDescription)));
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($productName); ?> - MobiMart</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="author" content="" />
    <meta name="keywords" content="<?php echo htmlspecialchars($productName) . ',' . htmlspecialchars($brandName); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars(substr($productDescription, 0, 160)); ?>" />

    <!-- Structured Data for Product -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "<?php echo htmlspecialchars($productName); ?>",
            "image": "<?php echo '../assets/uploads/products/' . htmlspecialchars($productImage); ?>",
            "description": "<?php echo htmlspecialchars($productDescription); ?>",
            "brand": {
                "@type": "Brand",
                "name": "<?php echo htmlspecialchars($brandName); ?>"
            },
            "sku": "<?php echo htmlspecialchars($productSku); ?>",
            "offers": {
                "@type": "Offer",
                "url": "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
                "priceCurrency": "LKR",
                "price": "<?php echo number_format($productPrice, 2); ?>",
                "availability": "<?php echo ($productStock > 0) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'; ?>",
                "seller": {
                    "@type": "Organization",
                    "name": "MobiMart"
                }
            }
        }
    </script>
    <link
        rel="stylesheet"
        type="text/css"
        href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet" />
    <!-- script
    ================================================== -->
    <script src="../assets/js/modernizr.js"></script>

    <style>
        .thumbnail-img {
            cursor: pointer;
            border: 1px solid #dee2e6;
            height: 80px;
            width: 80px;
            object-fit: cover;
        }

        .thumbnail-img.active {
            border: 2px solid #0d6efd;
        }

        .main-img {
            height: 400px;
            object-fit: contain;
        }

        .color-option {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            margin-right: 5px;
            border: 1px solid #dee2e6;
        }

        .color-option.active {
            border: 2px solid #0d6efd;
        }

        .blue {
            background-color: #4a69bd;
        }

        .black {
            background-color: #000000;
        }

        .green {
            background-color: #218c74;
        }

        .purple {
            background-color: #9980fa;
        }

        .rating-stars {
            color: #ffc107;
        }

        .price-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .original-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 1rem;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f5f5f5;
            color: #333;
            box-shadow: none;
        }

        .review-avatar {
            width: 40px;
            height: 40px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #6c757d;
        }

        .verified-badge {
            font-size: 0.7rem;
            padding: 2px 5px;
            background-color: #e3f2fd;
            color: #0d6efd;
            border-radius: 3px;
            margin-left: 5px;
        }
    </style>
</head>

<body
    data-bs-spy="scroll"
    data-bs-target="#navbar"
    data-bs-root-margin="0px 0px -40%"
    data-bs-smooth-scroll="true"
    tabindex="0">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
        <symbol
            id="search"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 32 32">
            <title>Search</title>
            <path
                fill="currentColor"
                d="M19 3C13.488 3 9 7.488 9 13c0 2.395.84 4.59 2.25 6.313L3.281 27.28l1.439 1.44l7.968-7.969A9.922 9.922 0 0 0 19 23c5.512 0 10-4.488 10-10S24.512 3 19 3zm0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8s-8-3.57-8-8s3.57-8 8-8z" />
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 16 16">
            <path
                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 16 16">
            <path
                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            id="chevron-left"
            viewBox="0 0 16 16">
            <path
                fill-rule="evenodd"
                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
        </svg>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="chevron-right"
            viewBox="0 0 16 16">
            <path
                fill-rule="evenodd"
                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="cart-outline"
            viewBox="0 0 16 16">
            <path
                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="quality"
            viewBox="0 0 16 16">
            <path
                d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z" />
            <path
                d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="price-tag"
            viewBox="0 0 16 16">
            <path
                d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
            <path
                d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="shield-plus"
            viewBox="0 0 16 16">
            <path
                d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
            <path
                d="M8 4.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V9a.5.5 0 0 1-1 0V7.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="star-fill"
            viewBox="0 0 16 16">
            <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327l4.898.696c.441.062.612.636.282.95l-3.522 3.356l.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="star-empty"
            viewBox="0 0 16 16">
            <path
                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256l4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73l3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356l-.83 4.73zm4.905-2.767l-3.686 1.894l.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575l-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957l-3.686-1.894a.503.503 0 0 0-.461 0z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="star-half"
            viewBox="0 0 16 16">
            <path
                d="M5.354 5.119L7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327l4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356l.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894l-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77l-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z" />
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="quote" viewBox="0 0 24 24">
            <path
                fill="currentColor"
                d="m15 17l2-4h-4V6h7v7l-2 4h-3Zm-9 0l2-4H4V6h7v7l-2 4H6Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="facebook"
            viewBox="0 0 24 24">
            <path
                fill="currentColor"
                d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="youtube"
            viewBox="0 0 32 32">
            <path
                fill="currentColor"
                d="M29.41 9.26a3.5 3.5 0 0 0-2.47-2.47C24.76 6.2 16 6.2 16 6.2s-8.76 0-10.94.59a3.5 3.5 0 0 0-2.47 2.47A36.13 36.13 0 0 0 2 16a36.13 36.13 0 0 0 .59 6.74a3.5 3.5 0 0 0 2.47 2.47c2.18.59 10.94.59 10.94.59s8.76 0 10.94-.59a3.5 3.5 0 0 0 2.47-2.47A36.13 36.13 0 0 0 30 16a36.13 36.13 0 0 0-.59-6.74ZM13.2 20.2v-8.4l7.27 4.2Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="twitter"
            viewBox="0 0 256 256">
            <path
                fill="currentColor"
                d="m245.66 77.66l-29.9 29.9C209.72 177.58 150.67 232 80 232c-14.52 0-26.49-2.3-35.58-6.84c-7.33-3.67-10.33-7.6-11.08-8.72a8 8 0 0 1 3.85-11.93c.26-.1 24.24-9.31 39.47-26.84a110.93 110.93 0 0 1-21.88-24.2c-12.4-18.41-26.28-50.39-22-98.18a8 8 0 0 1 13.65-4.92c.35.35 33.28 33.1 73.54 43.72V88a47.87 47.87 0 0 1 14.36-34.3A46.87 46.87 0 0 1 168.1 40a48.66 48.66 0 0 1 41.47 24H240a8 8 0 0 1 5.66 13.66Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="instagram"
            viewBox="0 0 256 256">
            <path
                fill="currentColor"
                d="M128 80a48 48 0 1 0 48 48a48.05 48.05 0 0 0-48-48Zm0 80a32 32 0 1 1 32-32a32 32 0 0 1-32 32Zm48-136H80a56.06 56.06 0 0 0-56 56v96a56.06 56.06 0 0 0 56 56h96a56.06 56.06 0 0 0 56-56V80a56.06 56.06 0 0 0-56-56Zm40 152a40 40 0 0 1-40 40H80a40 40 0 0 1-40-40V80a40 40 0 0 1 40-40h96a40 40 0 0 1 40 40ZM192 76a12 12 0 1 1-12-12a12 12 0 0 1 12 12Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="linkedin"
            viewBox="0 0 24 24">
            <path
                fill="currentColor"
                d="M6.94 5a2 2 0 1 1-4-.002a2 2 0 0 1 4 .002zM7 8.48H3V21h4V8.48zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="nav-icon"
            viewBox="0 0 16 16">
            <path
                d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5z" />
        </symbol>
        <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 16 16">
            <path
                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="navbar-icon"
            viewBox="0 0 16 16">
            <path
                d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5z" />
        </symbol>
    </svg>


    <!-- Navbar -->

    <header
        id="header"
        class="site-header header-scrolled text-black bg-light">
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
                            <img src="./assets/images/main-logo.png" class="logo" />
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
                                <a class="nav-link me-4 active" href="./index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 active" href="./pages/phones.php">Phones</a>
                            </li>
                            <?php
                            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="./pages/Admin/dashboard.php">Dashboard</a>
                                  </li>';
                            } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') {
                                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="./pages/User/dashboard.php">Dashboard</a>
                                  </li>';
                            } else {
                                echo '<li class="nav-item">
                                    <a class="nav-link me-4" href="./pages/sign_in.php">Sign In</a>
                                  </li>';
                            }
                            ?>

                            <li class="nav-item">
                                <div class="user-items ps-5">
                                    <ul class="d-flex justify-content-end list-unstyled">
                                        <!-- <li class="search-item pe-3">
                                            <a href="#" class="search-button">
                                                <svg class="search">
                                                    <use xlink:href="#search"></use>
                                                </svg>
                                            </a>
                                        </li> -->

                                        <li class="pe-3">
                                            <a href="<?php

                                                        if (isset($_SESSION['user_type'])) {
                                                            echo $_SESSION['user_type'] === 'admin' ? './pages/Admin/dashboard.php' : './pages/User/dashboard.php';
                                                        } else {
                                                            echo './pages/sign_in.php';
                                                        }
                                                        ?>">
                                                <svg class="user">
                                                    <use xlink:href="#user"></use>
                                                </svg>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="./pages/cart.php">
                                                <svg class="cart">
                                                    <use xlink:href="#cart"></use>
                                                </svg>
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




    <div class="container py-4">
        <!-- Product Header - Mobile -->
        <div class="d-block d-md-none mb-3">
            <h1 class="h3"><?php echo htmlspecialchars($productName); ?></h1>
            <div class="d-flex align-items-center mb-2">
                <div class="rating-stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <span class="ms-2 text-muted">(4 reviews)</span>
            </div>
            <div class="mb-2">
                <span class="price-text">Rs <?php echo number_format($productPrice, 2); ?></span>
                <span class="original-price ms-2">Rs <?php echo number_format($originalPrice, 2); ?></span>
                <span class="badge bg-danger ms-2"><?php echo $discountPercent; ?>% OFF</span>
            </div>
            <p class="text-<?php echo ($productStock > 0) ? 'success' : 'danger'; ?>">
                <i class="bi bi-<?php echo ($productStock > 0) ? 'check-circle-fill' : 'x-circle-fill'; ?>"></i>
                <?php echo ($productStock > 0) ? 'In stock (' . $productStock . ')' : 'Out of stock'; ?>
            </p>
        </div>

        <div class="row">
            <!-- Product Gallery -->
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-2 order-md-1 order-2">
                        <div class="d-flex flex-md-column gap-2 mb-3">
                            <!-- Main product image thumbnail -->
                            <img
                                src="../assets/uploads/products/<?php echo htmlspecialchars($productImage); ?>"
                                class="thumbnail-img active"
                                data-full="../assets/uploads/products/<?php echo htmlspecialchars($productImage); ?>"
                                alt="<?php echo htmlspecialchars($productName); ?>" />

                            <!-- Gallery images thumbnails -->
                            <?php foreach ($productImages as $image): ?>
                                <img
                                    src="../assets/uploads/products/<?php echo htmlspecialchars($image['image_url']); ?>"
                                    class="thumbnail-img"
                                    data-full="../assets/uploads/products/<?php echo htmlspecialchars($image['image_url']); ?>"
                                    alt="<?php echo htmlspecialchars($productName); ?>" />
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-10 order-md-2 order-1">
                        <div class="bg-light p-2 text-center mb-3">
                            <img
                                src="../assets/uploads/products/<?php echo htmlspecialchars($productImage); ?>"
                                class="main-img"
                                alt="<?php echo htmlspecialchars($productName); ?>"
                                id="mainProductImage" />
                        </div>
                    </div>
                </div>

                <!-- Product Benefits -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body text-center text-muted">
                                <i class="bi bi-truck"></i> 100% Authentic |
                                <i class="bi bi-clock"></i> 24/7 Support |
                                <i class="bi bi-shield-check"></i> Warranty
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center text-muted">
                                <i class="bi bi-box-seam"></i> Secure onsite delivery
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <!-- Product Header - Desktop -->
                <div class="d-none d-md-block mb-4">
                    <h1 class="h3"> <?php echo $productName ?></h1>
                    <div class="d-flex align-items-center mb-2">
                        <div class="rating-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span class="ms-2 text-muted">(4 reviews)</span>
                    </div>
                    <div class="mb-3">
                        <span class="price-text">Rs <?php echo $productPrice  ?></span>
                        <span class="original-price ms-2">Rs <?php echo $productPrice + 12500 ?></span>
                        <span class="badge bg-danger ms-2">6% OFF</span>
                    </div>
                    <p class="text-success">
                        <i class="bi bi-check-circle-fill"></i> In stock (<?php echo $productStock ?>)
                    </p>
                </div>

                <!-- Short Description -->
                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between">
                        <span>Short Description</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <!-- productDescription -->
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($descriptionPoints as $point): ?>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i><?php echo $point ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="text-muted mt-3 small">
                            Actual product colors may vary slightly from the images shown on
                            our website.
                        </p>
                    </div>
                </div>


                <!-- Quantity -->
                <div class="mb-4">
                    <label class="form-label">Quantity</label>
                    <form action="../controller/cart_process.php" method="post">
                        <div class="input-group" style="max-width: 150px">
                            <button class="btn btn-outline-secondary" type="button" id="decrementBtn">-</button>
                            <input type="number" class="form-control text-center" name="quantity" id="quantityInput" value="1" min="1" max="<?php echo $productStock; ?>" readonly />
                            <button class="btn btn-outline-secondary" type="button" id="incrementBtn">+</button>
                        </div>
                        <small class="text-muted">Available stock: <?php echo $productStock; ?></small>

                        <!-- Add to Cart Button -->
                        <div class="d-grid mt-3 mb-4">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>" />
                            <button type="submit" class="btn btn-primary btn-lg">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>

                <!-- quantity java -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get elements
                        const quantityInput = document.getElementById('quantityInput');
                        const decrementBtn = document.getElementById('decrementBtn');
                        const incrementBtn = document.getElementById('incrementBtn');
                        const maxStock = <?php echo $productStock; ?>;

                        // Function to update quantity
                        function updateQuantity(newValue) {
                            // Ensure value is within bounds
                            newValue = Math.max(1, Math.min(newValue, maxStock));
                            quantityInput.value = newValue;

                            // Update button states
                            decrementBtn.disabled = newValue <= 1;
                            incrementBtn.disabled = newValue >= maxStock;
                        }

                        // Decrement button click
                        decrementBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const currentValue = parseInt(quantityInput.value) || 1;
                            updateQuantity(currentValue - 1);
                        });

                        // Increment button click
                        incrementBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const currentValue = parseInt(quantityInput.value) || 1;
                            updateQuantity(currentValue + 1);
                        });

                        // Handle direct input
                        quantityInput.addEventListener('input', function() {
                            let value = parseInt(this.value);
                            if (isNaN(value) || value < 1) {
                                value = 1;
                            } else if (value > maxStock) {
                                value = maxStock;
                            }
                            updateQuantity(value);
                        });

                        // Initialize button states
                        updateQuantity(1);

                        // Rest of your existing JavaScript code...
                        // Gallery Image Handling
                        const thumbnails = document.querySelectorAll('.thumbnail-img');
                        const mainImage = document.querySelector('.main-img');

                        thumbnails.forEach(thumb => {
                            thumb.addEventListener('click', function() {
                                mainImage.src = this.dataset.full;
                                mainImage.alt = this.alt;
                                thumbnails.forEach(t => t.classList.remove('active'));
                                this.classList.add('active');
                            });
                        });
                    });
                </script>
            </div>

            <div>
                <section
                    id="instagram"
                    class="padding-large overflow-hidden no-padding-top">
                    <div class="container">
                        <div class="row">
                            <div class="display-header text-uppercase text-dark text-center pb-3">
                                <h2 class="display-7">Shop Our Insta</h2>
                            </div>
                            <div class="d-flex flex-wrap">
                                <figure class="instagram-item pe-2">
                                    <a
                                        href=""
                                        class="image-link position-relative">
                                        <img
                                            src="../assets/images/insta-item1.jpg"
                                            alt="instagram"
                                            class="insta-image" />
                                        <div
                                            class="icon-overlay position-absolute d-flex justify-content-center">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </figure>
                                <figure class="instagram-item pe-2">
                                    <a
                                        href=""
                                        class="image-link position-relative">
                                        <img
                                            src="../assets/images/cart-item1.jpg"
                                            alt="instagram"
                                            class="insta-image" />
                                        <div
                                            class="icon-overlay position-absolute d-flex justify-content-center">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </figure>
                                <figure class="instagram-item pe-2">
                                    <a
                                        href=""
                                        class="image-link position-relative">
                                        <img
                                            src="../assets/images/insta-item3.jpg"
                                            alt="instagram"
                                            class="insta-image" />
                                        <div
                                            class="icon-overlay position-absolute d-flex justify-content-center">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </figure>
                                <figure class="instagram-item pe-2">
                                    <a
                                        href=""
                                        class="image-link position-relative">
                                        <img
                                            src="../assets/images/product-item3.jpg"
                                            alt="instagram"
                                            class="insta-image" />
                                        <div
                                            class="icon-overlay position-absolute d-flex justify-content-center">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </figure>
                                <figure class="instagram-item pe-2">
                                    <a
                                        href=""
                                        class="image-link position-relative">
                                        <img
                                            src="../assets/images/single-image1.png"
                                            alt="instagram"
                                            class="insta-image" />
                                        <div
                                            class="icon-overlay position-absolute d-flex justify-content-center">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </figure>
                            </div>
                        </div>
                    </div>
                </section>
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


            <script src="../assets/js/jquery-1.11.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
            <script
                type="text/javascript"
                src="../assets/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript" src="../assets/js/plugins.js"></script>
            <script type="text/javascript" src="../assets/js/script.js"></script>
            <!-- Product Details Specific Script -->
            <script type="text/javascript" src="../assets/js/product-details.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Gallery Image Handling
                    const thumbnails = document.querySelectorAll('.thumbnail-img');
                    const mainImage = document.querySelector('.main-img');

                    thumbnails.forEach(thumb => {
                        thumb.addEventListener('click', function() {
                            mainImage.src = this.dataset.full;
                            mainImage.alt = this.alt;
                            thumbnails.forEach(t => t.classList.remove('active'));
                            this.classList.add('active');
                        });
                    });

                    // Quantity Controls
                    const quantityInput = document.querySelector('input[type="text"].form-control');
                    const decrementBtn = quantityInput.previousElementSibling;
                    const incrementBtn = quantityInput.nextElementSibling;
                    const maxStock = <?php echo $productStock; ?>;

                    function updateQuantity(newValue) {
                        newValue = Math.max(1, Math.min(newValue, maxStock));
                        quantityInput.value = newValue;
                    }

                    decrementBtn.addEventListener('click', () => {
                        updateQuantity(parseInt(quantityInput.value) - 1);
                    });

                    incrementBtn.addEventListener('click', () => {
                        updateQuantity(parseInt(quantityInput.value) + 1);
                    });

                    // Add to Cart
                    const addToCartBtn = document.getElementById('addToCartBtn');
                    const cartMessage = document.getElementById('cartMessage');

                    addToCartBtn.addEventListener('click', function() {
                        const productId = this.getAttribute('data-product-id');
                        const productName = this.getAttribute('data-product-name');
                        const productPrice = this.getAttribute('data-product-price');
                        const quantity = quantityInput.value;

                        // AJAX request to add the product to the cart
                        fetch('../api/add_to_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: productId,
                                    product_name: productName,
                                    product_price: productPrice,
                                    quantity: quantity
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    cartMessage.classList.remove('d-none', 'alert-danger');
                                    cartMessage.classList.add('alert-success');
                                    cartMessage.innerHTML = 'Product added to cart successfully!';
                                } else {
                                    cartMessage.classList.remove('d-none', 'alert-success');
                                    cartMessage.classList.add('alert-danger');
                                    cartMessage.innerHTML = 'Failed to add product to cart. Please try again.';
                                }

                                // Optionally, update the cart icon/badge here
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                cartMessage.classList.remove('d-none', 'alert-success');
                                cartMessage.classList.add('alert-danger');
                                cartMessage.innerHTML = 'An error occurred. Please try again.';
                            });
                    });

                    // Initialize Bootstrap tooltips
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>
        </div>
    </div>

</body>

</html>