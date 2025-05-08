<?php

include_once '../config/db.php';

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
} else {
    header("Location: index.php");
    exit();
}

$productSql = "SELECT * FROM products WHERE product_id = $productId";
$stmt = $conn->prepare($productSql);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: index.php");
    exit();
} else {
    $productName = $product['product_name'];
    $productPrice = $product['price'];
    $productDescription = $product['description'];
    $productSku = $product['sku'];
    $productStock = $product['quantity'];
    $productImage = $product['image_url'];
    $productBrandId = $product['brand_id'];
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>MobiMart</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
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
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="star-empty"
            viewBox="0 0 16 16">
            <path
                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
        </symbol>
        <symbol
            xmlns="http://www.w3.org/2000/svg"
            id="star-half"
            viewBox="0 0 16 16">
            <path
                d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z" />
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

    <div class="search-popup">
        <div class="search-popup-container">
            <form role="search" method="get" class="search-form" action="">
                <input
                    type="search"
                    id="search-form"
                    class="search-field"
                    placeholder="Type and press enter"
                    value=""
                    name="s" />
                <button type="submit" class="search-submit">
                    <svg class="search">
                        <use xlink:href="#search"></use>
                    </svg>
                </button>
            </form>

            <h5 class="cat-list-title">Browse Categories</h5>

            <ul class="cat-list">
                <li class="cat-list-item">
                    <a href="#" title="Mobile Phones">Mobile Phones</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Smart Watches">Smart Watches</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Headphones">Headphones</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Accessories">Accessories</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Monitors">Monitors</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Speakers">Speakers</a>
                </li>
                <li class="cat-list-item">
                    <a href="#" title="Memory Cards">Memory Cards</a>
                </li>
            </ul>
        </div>
    </div>

    <header id="header" class="site-header header-scrolled text-black bg-light">
        <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html">
                    <img src="../assets/images/main-logo.png" class="logo" />
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
                                <a class="nav-link me-4 active" href="../index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4" href="#company-services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4" href="#mobile-products">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4" href="#smart-watches">Watches</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4" href="#yearly-sale">Sale</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4" href="#latest-blog">Blog</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link me-4 dropdown-toggle link-dark"
                                    data-bs-toggle="dropdown"
                                    href="#"
                                    role="button"
                                    aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="about.html" class="dropdown-item">About</a>
                                    </li>
                                    <li>
                                        <a href="blog.html" class="dropdown-item">Blog</a>
                                    </li>
                                    <li>
                                        <a href="shop.html" class="dropdown-item">Shop</a>
                                    </li>
                                    <li>
                                        <a href="cart.html" class="dropdown-item">Cart</a>
                                    </li>
                                    <li>
                                        <a href="checkout.html" class="dropdown-item">Checkout</a>
                                    </li>
                                    <li>
                                        <a href="single-post.html" class="dropdown-item">Single Post</a>
                                    </li>
                                    <li>
                                        <a href="single-product.html" class="dropdown-item">Single Product</a>
                                    </li>
                                    <li>
                                        <a href="contact.html" class="dropdown-item">Contact</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <div class="user-items ps-5">
                                    <ul class="d-flex justify-content-end list-unstyled">
                                        <li class="search-item pe-3">
                                            <a href="#" class="search-button">
                                                <svg class="search">
                                                    <use xlink:href="#search"></use>
                                                </svg>
                                            </a>
                                        </li>
                                        <li class="pe-3">
                                            <a href="#">
                                                <svg class="user">
                                                    <use xlink:href="#user"></use>
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="cart.html">
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
            <h1 class="h3">Xiaomi Redmi 14C Smartphone</h1>
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
                <span class="price-text">Rs 45,999.00</span>
                <span class="original-price ms-2">Rs 48,999.00</span>
                <span class="badge bg-danger ms-2">6% OFF</span>
            </div>
        </div>

        <div class="row">
            <!-- Product Gallery -->
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-2 order-md-1 order-2">
                        <div class="d-flex flex-md-column gap-2 mb-3">
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img active"
                                alt="Redmi 14C Front" />
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img"
                                alt="Redmi 14C Back" />
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img"
                                alt="Redmi 14C Side" />
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img"
                                alt="Redmi 14C Camera" />
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img"
                                alt="Redmi 14C Display" />
                            <img
                                src="/api/placeholder/80/80"
                                class="thumbnail-img"
                                alt="Redmi 14C Package" />
                        </div>
                    </div>
                    <div class="col-10 order-md-2 order-1">
                        <div class="bg-light p-2 text-center mb-3">
                            <img
                                src="/api/placeholder/400/400"
                                class="main-img"
                                alt="Xiaomi Redmi 14C" />
                        </div>
                    </div>
                </div>

                <!-- Product Benefits -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body text-center text-muted">
                                <i class="bi bi-truck"></i> 100% Authentic
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
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Immersive 6.88" display
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>50MP
                                high-resolution lens
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>AI-powered photography features
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>5000+
                                mAh mega storage
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Powerful AI dual-camera system
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Helio
                                G85 octa-core processor
                            </li>
                        </ul>
                        <p class="text-muted mt-3 small">
                            Actual product colors may vary slightly from the images shown on
                            our website.
                        </p>
                    </div>
                </div>

                <!-- Color Options -->
                <div class="mb-4">
                    <label class="form-label">Color</label>
                    <div>
                        <span class="color-option blue active" data-color="Blue"></span>
                        <span class="color-option black" data-color="Black"></span>
                        <span class="color-option green" data-color="Green"></span>
                        <span class="color-option purple" data-color="Purple"></span>
                    </div>
                </div>

                <!-- Storage Options -->
                <div class="mb-4">
                    <label class="form-label">Memory 6GB RAM +128GB ROM</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100 active">
                                6GB RAM + 64GB ROM
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100">
                                6GB RAM + 128GB ROM
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label class="form-label">Quantity</label>
                    <div class="input-group" style="max-width: 150px">
                        <button class="btn btn-outline-secondary" type="button">-</button>
                        <input type="text" class="form-control text-center" value="1" />
                        <button class="btn btn-outline-secondary" type="button">+</button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <div class="d-grid mb-4">
                    <button class="btn btn-primary py-2">Add to cart</button>
                </div>

                <!-- Payment Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2">Payment Methods - Cash On Delivery</p>
                                <div class="payment-icons">
                                    <img
                                        src="/api/placeholder/30/20"
                                        alt="Payment Method"
                                        class="me-1" />
                                    <img
                                        src="/api/placeholder/30/20"
                                        alt="Payment Method"
                                        class="me-1" />
                                    <img
                                        src="/api/placeholder/30/20"
                                        alt="Payment Method"
                                        class="me-1" />
                                    <img src="/api/placeholder/30/20" alt="Payment Method" />
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-2">Delivery | Atlas | USPS</p>
                                <div class="delivery-icons">
                                    <img
                                        src="/api/placeholder/30/20"
                                        alt="Delivery Method"
                                        class="me-1" />
                                    <img
                                        src="/api/placeholder/30/20"
                                        alt="Delivery Method"
                                        class="me-1" />
                                    <img src="/api/placeholder/30/20" alt="Delivery Method" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="d-flex align-items-center mb-4">
                    <span class="me-2">Share:</span>
                    <a href="#" class="text-muted me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-muted me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-muted me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-muted"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-4">Product details</h2>

                <!-- Description -->
                <div class="mb-4">
                    <h3 class="h6">Description</h3>
                    <div class="mb-4">
                        <h4 class="h5">Rounded design aesthetic</h4>
                        <p>
                            The rounded design is like a shining star in the night sky,
                            popping out from the device body and creating a sense of visual
                            harmony and elegance.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="h5">The beauty of nature</h4>
                        <p>
                            Inspired by the serene tranquility of nature and crafted with
                            exquisite artistry, carry beauty in the palm of your hand at all
                            times.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="h5">
                            6.88" cinema-view display, immersive large screen
                        </h4>
                        <p>
                            Revel in Redmi Series' first-ever 6.88" display, providing a
                            more cinematic, immersive view for your favorite content. Paired
                            with its auto-adjusting high refresh rate of up to 120Hz, Redmi
                            14C takes your visual experience to the next level.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="h5">Two TÜV Rheinland certifications</h4>
                        <p>
                            Next-generation low blue light display with consistent DC
                            dimming, low blue light, visible flicker-free, and dark mode,
                            both software and hardware provide dual protection for your
                            eyes, effectively reducing eye strain and damage to the eyes
                            from prolonged use.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="h5">Capturing clear images</h4>
                        <p>
                            Powerful AI dual camera system. Capture every frame in stunning
                            detail with an ultra-high-resolution main camera. Paired with
                            the powerful Kairon Imaging Engine, optimize picture quality and
                            speed from the underlying technology to bring every moment to
                            life.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="h5">Massive 5160mAh (typ) battery</h4>
                        <p>
                            With fast charging, a perfect combination of massive battery and
                            fast-charging. Redmi 14C also features Smart Charging Engine and
                            safe battery technology, ensuring a long-lasting and healthy
                            battery.
                        </p>
                    </div>

                    <hr />

                    <div class="mb-4">
                        <p class="text-muted small">Disclaimer:</p>
                        <p class="text-muted small">
                            *Water and dust resistance were tested under controlled lab
                            conditions. Resistance may fail due to wear and tear or over
                            time. Damage caused by immersion in liquid, cosmetic damages
                            such as wear & tear, scratch marks, color fades & others will
                            not be applicable for warranty.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">Customer Reviews</h2>
                    <div>
                        <div class="rating-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span class="text-muted">5.0 out of 5</span>
                        <p class="text-muted small mb-0">Based on 4 reviews</p>
                    </div>
                    <div>
                        <button class="btn btn-primary">Write a review</button>
                        <button class="btn btn-outline-secondary ms-2">
                            Ask a question
                        </button>
                    </div>
                </div>

                <!-- Review List -->
                <div class="review-list">
                    <!-- Review 1 -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="review-avatar me-2">K</div>
                                    <div>
                                        <h5 class="mb-0">
                                            Katherine C.
                                            <span class="verified-badge">Verified</span>
                                        </h5>
                                        <div class="rating-stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted small">05/03/2025</div>
                            </div>
                            <h6 class="fw-bold">Good</h6>
                            <p class="mb-0">
                                The product quality is excellent. Would recommend!
                            </p>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="review-avatar me-2">M</div>
                                    <div>
                                        <h5 class="mb-0">
                                            Michael S. <span class="verified-badge">Verified</span>
                                        </h5>
                                        <div class="rating-stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted small">03/12/2025</div>
                            </div>
                            <h6 class="fw-bold">Super</h6>
                            <p class="mb-0">
                                Amazing product with great features. The camera is excellent!
                            </p>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="review-avatar me-2">A</div>
                                    <div>
                                        <h5 class="mb-0">
                                            Amy R. <span class="verified-badge">Verified</span>
                                        </h5>
                                        <div class="rating-stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted small">03/7/2025</div>
                            </div>
                            <h6 class="fw-bold">Good service</h6>
                            <p class="mb-0">
                                Fast delivery and good packaging. The phone works perfectly!
                            </p>
                        </div>
                    </div>

                    <!-- Review 4 -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="review-avatar me-2">P</div>
                                    <div>
                                        <h5 class="mb-0">
                                            Patrick O. <span class="verified-badge">Verified</span>
                                        </h5>
                                        <div class="rating-stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-muted small">02/28/2025</div>
                            </div>
                            <h6 class="fw-bold">Best overall</h6>
                            <p class="mb-0">
                                I bought many items from this store. Recommended for all kind
                                of modern electric tools. Good customer service. Products also
                                branded and best quality - Thank you simply the best.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="h4 mb-4">Frequently Asked Questions</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                How long does it take for the delivery and what are the
                                charges?
                            </button>
                        </h2>
                        <div
                            id="faq1"
                            class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>
                                    Delivery time depends on your location. For local areas,
                                    delivery takes 1-2 business days. For remote areas, it may
                                    take 3-5 business days. Delivery is free for orders above Rs
                                    5,000.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                What is store/site's return and refund policy?
                            </button>
                        </h2>
                        <div
                            id="faq2"
                            class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>
                                    We offer a 14-day return policy. If you are not satisfied
                                    with your purchase, you can return it within 14 days for a
                                    full refund. The product must be in its original packaging
                                    and condition.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                What is the warranty period for electronics?
                            </button>
                        </h2>
                        <div
                            id="faq3"
                            class="accordion-collapse collapse"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>
                                    All Xiaomi smartphones come with a 1-year manufacturer
                                    warranty. This covers any manufacturing defects but does not
                                    cover physical damage or water damage.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- You May Also Like -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="h4 mb-4">You may also like</h2>
                <p class="text-muted">Combine your style with these products</p>

                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-danger">HOT</span>
                            </div>
                            <img
                                src="/api/placeholder/200/200"
                                class="card-img-top"
                                alt="Smartphone" />
                            <div class="card-body">
                                <h5 class="card-title">Xiaomi Redmi Note 11 4G Smartphone</h5>
                                <p class="card-text text-muted small">From Rs 39,999.00</p>
                                <div class="d-flex align-items-center">
                                    <div class="rating-stars small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <span class="ms-1 text-muted small">(4.5)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-danger">SALE</span>
                            </div>
                            <img
                                src="/api/placeholder/200/200"
                                class="card-img-top"
                                alt="Earbuds" />
                            <div class="card-body">
                                <h5 class="card-title">
                                    Xiaomi Earbuds BDS True Wireless Earbuds
                                </h5>
                                <p class="card-text text-muted small">Rs 8,499.00</p>
                                <div class="d-flex align-items-center">
                                    <div class="rating-stars small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <span class="ms-1 text-muted small">(4.0)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100">
                            <img
                                src="/api/placeholder/200/200"
                                class="card-img-top"
                                alt="Smartphone" />
                            <div class="card-body">
                                <h5 class="card-title">Redmi A2 Smartphone</h5>
                                <p class="card-text text-muted small">From Rs 27,499.00</p>
                                <div class="d-flex align-items-center">
                                    <div class="rating-stars small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <span class="ms-1 text-muted small">(4.5)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100">
                            <img
                                src="/api/placeholder/200/200"
                                class="card-img-top"
                                alt="Earbuds" />
                            <div class="card-body">
                                <h5 class="card-title">Xiaomi Redmi Buds 3 - Earbuds</h5>
                                <p class="card-text text-muted small">Rs 5,999.00</p>
                                <div class="d-flex align-items-center">
                                    <div class="rating-stars small">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <span class="ms-1 text-muted small">(4.0)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            href="https://templatesjungle.com/"
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
                            href="https://templatesjungle.com/"
                            class="image-link position-relative">
                            <img
                                src="../assets/images/insta-item2.jpg"
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
                            href="https://templatesjungle.com/"
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
                            href="https://templatesjungle.com/"
                            class="image-link position-relative">
                            <img
                                src="../assets/images/insta-item4.jpg"
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
                            href="https://templatesjungle.com/"
                            class="image-link position-relative">
                            <img
                                src="../assets/images/insta-item5.jpg"
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

    <footer id="footer" class="overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="footer-top-area">
                    <div class="row d-flex flex-wrap justify-content-between">
                        <div class="col-lg-3 col-sm-6 pb-3">
                            <div class="footer-menu">
                                <img src="../assets/images/main-logo.png" alt="logo" />
                                <p>
                                    Nisi, purus vitae, ultrices nunc. Sit ac sit suscipit
                                    hendrerit. Gravida massa volutpat aenean odio erat nullam
                                    fringilla.
                                </p>
                                <div class="social-links">
                                    <ul class="d-flex list-unstyled">
                                        <li>
                                            <a href="#">
                                                <svg class="facebook">
                                                    <use xlink:href="#facebook" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg class="instagram">
                                                    <use xlink:href="#instagram" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg class="twitter">
                                                    <use xlink:href="#twitter" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg class="linkedin">
                                                    <use xlink:href="#linkedin" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg class="youtube">
                                                    <use xlink:href="#youtube" />
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 pb-3">
                            <div class="footer-menu text-uppercase">
                                <h5 class="widget-title pb-2">Quick Links</h5>
                                <ul class="menu-list list-unstyled text-uppercase">
                                    <li class="menu-item pb-2">
                                        <a href="../index.php">Home</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">About</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Shop</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pb-3">
                            <div class="footer-menu text-uppercase">
                                <h5 class="widget-title pb-2">Help & Info Help</h5>
                                <ul class="menu-list list-unstyled">
                                    <li class="menu-item pb-2">
                                        <a href="#">Track Your Order</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Returns Policies</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Shipping + Delivery</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Contact Us</a>
                                    </li>
                                    <li class="menu-item pb-2">
                                        <a href="#">Faqs</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 pb-3">
                            <div class="footer-menu contact-item">
                                <h5 class="widget-title text-uppercase pb-2">Contact Us</h5>
                                <p>
                                    Do you have any queries or suggestions?
                                    <a href="mailto:">yourinfo@gmail.com</a>
                                </p>
                                <p>
                                    If you need support? Just give us a call.
                                    <a href="">+55 111 222 333 44</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    </footer>

    <div id="footer-bottom">
        <div class="container">
            <div class="row d-flex flex-wrap justify-content-between">
                <div class="col-md-4 col-sm-6">
                    <div class="Shipping d-flex">
                        <p>We ship with:</p>
                        <div class="card-wrap ps-2">
                            <img src="../assets/images/dhl.png" alt="visa" />
                            <img src="../assets/images/shippingcard.png" alt="mastercard" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="payment-method d-flex">
                        <p>Payment options:</p>
                        <div class="card-wrap ps-2">
                            <img src="../assets/images/visa.jpg" alt="visa" />
                            <img src="../assets/images/mastercard.jpg" alt="mastercard" />
                            <img src="../assets/images/paypal.jpg" alt="paypal" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="copyright">
                        <p>
                            © Copyright 2025 MiniStore.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script
        type="text/javascript"
        src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>
</body>

</html>