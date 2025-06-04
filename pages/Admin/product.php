<?php
session_start();
include_once('../../config/db.php');

$productSql = "SELECT * FROM products ORDER BY RAND()";
$stmt = $conn->prepare($productSql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($products); // Debugging line to check the fetched products


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobiMart - Admin Dashboard</title>
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
                <!-- <div class="d-flex align-items-center">
                    <i class="fa fa-phone"></i>
                </div> -->
            </div>
        </div>
    </nav>
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
                                <a href="./product.php" class="active">
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
                                    <i class="fas fa-cog"></i>
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
            <!-- Main Content - Products Table -->
            <div class="col-lg-9 col-xl-10">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="page-title">Products</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Home</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="./product-add.php"><button class="btn dark-btn" id="addProductBtn"><i class="fas fa-plus me-2"></i>Add Product</button></a>
                    </div>
                </div>

                <!-- Alert for successful product addition -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Product has been added successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Filter and Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select" id="brandFilter">
                                    <option value="">All Brands</option>
                                    <option value="apple">Apple</option>
                                    <option value="samsung">Samsung</option>
                                    <option value="xiaomi">Xiaomi</option>
                                    <option value="google">Google</option>
                                    <option value="oneplus">OnePlus</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>

                                        <th width="60">Image</th>
                                        <th>Product</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr class="table-light">
                                            <td>
                                                <img src="../../assets/uploads/products/<?= htmlspecialchars($product['image_url']) ?>" class="product-img" alt="<?= htmlspecialchars($product['product_name']) ?>" width="40" height="40">
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($product['product_name']) ?></div>
                                                <div class="small text-muted">SKU: <?= htmlspecialchars($product['sku']) ?></div>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($product['brand_id']) ?> <!-- Optional: replace with actual brand name if needed -->
                                            </td>
                                            <td>
                                                <div class="fw-bold">$<?= htmlspecialchars($product['price']) ?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-dark"><?= htmlspecialchars($product['quantity']) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $product['status'] === 'available' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst(htmlspecialchars($product['status'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-sm btn-outline-primary me-1"
                                                        title="Edit"
                                                        onclick="editProduct(<?= htmlspecialchars(json_encode($product)) ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="./controller/product_delete.php" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm" action="./controller/product_update.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="edit_product_id" name="product_id">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name*</label>
                                <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Brand*</label>
                                <select class="form-select" id="edit_brand_id" name="brand_id" required>
                                    <?php
                                    $brandsSql = "SELECT * FROM brands ORDER BY brand_name";
                                    $stmt = $conn->prepare($brandsSql);
                                    $stmt->execute();
                                    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($brands as $brand): ?>
                                        <option value="<?= $brand['brand_id'] ?>"><?= htmlspecialchars($brand['brand_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description*</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Price*</label>
                                <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">SKU*</label>
                                <input type="text" class="form-control" id="edit_sku" name="sku" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quantity*</label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="edit_status" name="status">
                                    <option value="available">Available</option>
                                    <option value="out_of_stock">Out of Stock</option>
                                    <option value="discontinued">Discontinued</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Main Product Image</label>
                                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewMainImage(this)">
                            </div>
                        </div>

                        <!-- Main Image Preview -->
                        <div id="currentImagePreview" class="text-center mb-3">
                            <h6 class="mb-2">Current Main Image</h6>
                            <img src="" alt="Current Product Image" style="max-height: 200px;">
                        </div>

                        <!-- Gallery Images Section -->
                        <div class="mb-4">
                            <h6 class="mb-3">Gallery Images</h6>
                            <input type="file" class="form-control mb-2" id="gallery_images" name="gallery_images[]" accept="image/*" multiple onchange="previewGalleryImages(this)">
                            <div id="galleryPreview" class="row g-2 mt-2">
                                <!-- Gallery images will be previewed here -->
                            </div>
                            <div id="existingGallery" class="row g-2 mt-2">
                                <!-- Existing gallery images will be shown here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize edit modal
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));

        function editProduct(product) {
            // Populate form fields
            document.getElementById('edit_product_id').value = product.product_id;
            document.getElementById('edit_product_name').value = product.product_name;
            document.getElementById('edit_brand_id').value = product.brand_id;
            document.getElementById('edit_description').value = product.description;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_sku').value = product.sku;
            document.getElementById('edit_quantity').value = product.quantity;
            document.getElementById('edit_status').value = product.status;

            // Show current image
            const imagePreview = document.querySelector('#currentImagePreview img');
            imagePreview.src = '../../assets/uploads/products/' + product.image_url;

            // Show modal
            editModal.show();
        }

        // Preview main image before upload
        function previewMainImage(input) {
            const preview = document.querySelector('#currentImagePreview img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGalleryImages(input) {
            const preview = document.getElementById('galleryPreview');
            preview.innerHTML = '';

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.insertAdjacentHTML('beforeend', `
                            <div class="col-md-3 col-6 mb-2">
                                <div class="position-relative border rounded p-1">
                                    <img src="${e.target.result}" class="img-fluid" style="height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        `);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        // Function to delete a gallery image
        function deleteGalleryImage(imageId, element) {
            if (confirm('Are you sure you want to delete this image?')) {
                fetch(`./controller/delete_gallery_image.php?image_id=${imageId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            element.remove();
                        } else {
                            alert(data.error || 'Failed to delete image');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to delete image');
                    });
            }
        }

        // Update the loadProductData function to include gallery images
        function loadProductData(productId) {
            // ... existing code for loading basic product data ...

            // Clear existing previews
            document.getElementById('galleryPreview').innerHTML = '';
            document.getElementById('existingGallery').innerHTML = '';

            // Load gallery images
            fetch(`./controller/get_gallery_images.php?product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    const existingGallery = document.getElementById('existingGallery');
                    if (Array.isArray(data)) {
                        data.forEach(image => {
                            existingGallery.insertAdjacentHTML('beforeend', `
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="position-relative border rounded p-1">
                                        <img src="${image.image_url}" class="img-fluid" style="height: 100px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                                                onclick="deleteGalleryImage(${image.id}, this.parentElement.parentElement)">×</button>
                                    </div>
                                </div>
                            `);
                        });
                    } else if (data.error) {
                        console.error('Error loading gallery images:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Auto-dismiss success alert
        setTimeout(() => {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.remove();
            }
        }, 5000);
    </script>
</body>

</html>