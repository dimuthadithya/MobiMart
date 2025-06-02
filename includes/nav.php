<header
    id="header"
    class="site-header header-scrolled position-fixed text-black bg-light">
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
                                    <li class="search-item pe-3">
                                        <a href="#" class="search-button">
                                            <svg class="search">
                                                <use xlink:href="#search"></use>
                                            </svg>
                                        </a>
                                    </li>

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