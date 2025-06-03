<?php
session_start();
include '../../config/db.php';


$user_id = $_SESSION['user_id'] ?? null;

$orders = [];

if ($user_id) {

    $orderStmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
    $orderStmt->execute([':user_id' => $user_id]);
    $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($orders as &$order) {
        $itemStmt = $conn->prepare("
    SELECT oi.*, p.product_name 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.product_id 
    WHERE oi.order_id = :order_id
");
        $itemStmt->execute([':order_id' => $order['order_id']]);
        $order['items'] = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shop - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/vendor.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #212529;
            --secondary-color: #343a40;
            --accent-color: #0d6efd;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --grey-color: #6c757d;
        }

        body {
            background-color: #f5f7fb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
        }

        .card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
            padding: 15px;
        }

        .stat-icon {
            font-size: 1.5rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--grey-color);
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
        }

        .order-status {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-delivered {
            background-color: #d1e7dd;
            color: #146c43;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #997404;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #b02a37;
        }

        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            color: #212529;
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .page-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .dark-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .dark-btn:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .alert-stock {
            border-left: 4px solid #ffc107;
            background-color: #fff3cd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .user-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../assets/images/main-logo.png" alt="Mobile Shop">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto w-100 d-flex justify-content-end p-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $_SESSION['email'] ?></a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <i class="fa fa-phone"></i>
                </div>
            </div>
        </div>
    </nav>
    </nav>

    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 d-none d-lg-block">
                <div class="card">
                    <div class="card-body">
                        <ul class="sidebar-menu">


                            <li>
                                <a href="./dashboard.php" class="active">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Orders</span>
                                </a>
                            </li>

                            <li>
                                <a href="./dashboard.php">
                                    <i class="fas fa-th-large"></i>
                                    <span>Profile</span>
                                </a>
                            </li>

                            <li>
                                <a href="../../controller/user_logout_process.php">
                                    <i class="fas fa-cog"></i>
                                    <span>LogOut</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <img src="../../assets/images/user_dashbord01.webp" alt="" class="img-fluid">
                </div>

                <div class="card">
                    <img src="../../assets/images/user_dashbord02.webp" alt="" class="img-fluid">
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="page-title">Orders</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Home</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach ($orders as $order): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-lg rounded-4 bg-white">
                                <div class="card-body px-4 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">Order #<?= htmlspecialchars($order['order_id']) ?></h5>
                                        <span class="badge bg-<?= $order['status'] === 'Pending' ? 'warning text-dark' : 'success' ?> px-3 py-1 rounded-pill">
                                            <i class="fas fa-<?= $order['status'] === 'Pending' ? 'clock' : 'check-circle' ?> me-1"></i>
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
                                    </div>

                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-calendar-alt me-2 text-muted mt-2"></i><strong>Date:</strong> <?= htmlspecialchars(date('Y-m-d', strtotime($order['order_date']))) ?></li>
                                        <li><i class="fas fa-box-open me-2 text-muted mt-2"></i><strong>Items:</strong>
                                            <?= implode(', ', array_column($order['items'], 'product_name')) ?>
                                        </li>
                                        <li><i class="fas fa-dollar-sign me-2 text-muted mt-2"></i><strong>Total:</strong> LKR <?= htmlspecialchars($order['total_amount']) ?></li>
                                    </ul>

                                    <div class="d-flex justify-content-end mt-4">
                                        <form action="cancel_order.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>



            </div>
            <!-- end main  -->

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>