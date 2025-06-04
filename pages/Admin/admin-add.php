<?php
session_start();
include_once '../../config/db.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../pages/sign_in.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = $_POST['contact'];

    try {
        // Check if username or email already exists
        $checkSql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            $error = "Username or email already exists!";
        } else {            // Insert new admin
            $sql = "INSERT INTO users (username, email, password, phone, role) 
                   VALUES (:username, :email, :password, :contact, 'admin')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':contact', $contact);

            if ($stmt->execute()) {
                $success = "New admin user created successfully!";
            } else {
                $error = "Error creating admin user.";
            }
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin - MobiMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
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

        .form-container {
            max-width: 100%;
            margin: 0;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../assets/images/download.png" alt="Mobile Shop">
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
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-xl-2 d-none d-lg-block">
                <div class="card h-50">
                    <div class="card-body">
                        <ul class="sidebar-menu">
                            <li>
                                <a href="./dashboard.php">
                                    <i class="fas fa-th-large"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="./product.php">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="./brands.php">
                                    <i class="fas fa-users"></i>
                                    <span>Brands</span>
                                </a>
                            </li>
                            <li>
                                <a href="./user.php">
                                    <i class="fas fa-users"></i>
                                    <span>Customers</span>
                                </a>
                            </li>
                            <li>
                                <a href="./orders.php">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                            <li>
                                <a href="../../controller/user_logout_process.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>LogOut</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <img src="../../assets/images/login_banner.webp" alt="" class="img-fluid">
                </div>

                <div class="card">
                    <img src="../../assets/images/register_page_banner.webp" alt="" class="img-fluid">
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="page-title">Add New Admin</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add New Admin</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="form-container bg-white">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" id="contact" name="contact" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Admin Account</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>