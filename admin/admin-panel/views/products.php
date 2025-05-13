<?php
session_start();
require_once '../database/config.php';

// For edit modal
$currentBrandId = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;
$currentCategoryId = isset($_GET['category_id']) ? $_GET['category_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style-sidebar.css">
    <link rel="stylesheet" href="../css/style-alert.css">
    <title>Products</title>

</head>
<body>
<!-- Sidebar -->
<div class="sidebar bg-success text-white" id="sidebar">
  <div class="sidebar-header p-3 border-bottom border-light-subtle">
    <h5><i class="bi bi-gear-fill me-2"></i>Admin Panel</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-white bg-success-emphasis" href="../views/index.php" style="transition: all 0.3s ease;">
        <i class="bi bi-house-door-fill me-2"></i>Home
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white" href="../views/products.php" style="font-weight: 700; background-color:rgb(26, 175, 106);">
        <i class="bi bi-box-seam-fill me-2"></i>Products
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white" href="../views/orders.php" style="transition: all 0.3s ease;">
        <i class="bi bi-cart-fill me-2"></i>Orders
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white" href="../views/pre-built-orders.php" style="transition: all 0.3s ease;">
        <i class="bi bi-pc-display me-2"></i>Pre-Built Orders
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white dropdown-toggle" href="#logsSubmenu" data-bs-toggle="collapse" style="transition: all 0.3s ease;">
        <i class="bi bi-journal-text me-2"></i>Logs
      </a>
      <ul class="collapse nav flex-column ms-3" id="logsSubmenu">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" style="transition: all 0.3s ease;">
            <i class="bi bi-person-fill-lock me-2"></i>Login Logs
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="transaction.php" style="transition: all 0.3s ease;">
            <i class="bi bi-receipt me-2"></i>Transaction Logs
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item mt-auto">
      <button class="btn btn-outline-light m-3" data-bs-toggle="modal" data-bs-target="#signOutModal">
            <i class="bi bi-box-arrow-right me-2"></i>Sign out
        </button>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div class="container-fluid" style="margin-left: 250px; padding: 20px; max-width: calc(100% - 250px);">
    <!-- Alert Container -->
    <div id="alertContainer">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Product List</h2>
            
            <!-- Search and Filter Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-2">
                    <input type="search" class="form-control border-success" placeholder="Search products...">
                </div>
                <div class="col-md-2">
                    <select class="form-select border-success">
                        <option value="">Filter by Brand</option>
                        <?php
                        $brandStmt = $pdo->query("SELECT * FROM brands WHERE status = 1 ORDER BY brand_name");
                        while ($brand = $brandStmt->fetch()) {
                            echo "<option value='" . htmlspecialchars($brand['brand_id']) . "'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#manageCategoriesModal">
                        <i class="bi bi-gear-fill me-2"></i>Manage Categories & Brands
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#productModal">
                        <i class="bi bi-plus-circle me-2"></i>Add Product
                    </button>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card border-success shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">Products List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="py-3 px-4" style="width: 5%">ID</th>
                                    <th class="py-3 px-4" style="width: 30%">Product Name</th>
                                    <th class="py-3 px-4" style="width: 15%">Brand</th>
                                    <th class="py-3 px-4" style="width: 15%">Stocks</th>
                                    <th class="py-3 px-4" style="width: 15%">Price</th>
                                    <th class="py-3 px-4 text-end" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("
                                    SELECT p.*, b.brand_name, c.category_name 
                                    FROM products p
                                    LEFT JOIN brands b ON p.brand_id = b.brand_id
                                    LEFT JOIN categories c ON p.category_id = c.category_id
                                    ORDER BY p.product_id DESC
                                ");
                                while ($row = $stmt->fetch()) {
                                    echo "<tr>
                                        <td class='px-4'>
                                            <span class='fw-bold text-success'>#{$row['product_id']}</span>
                                        </td>
                                        <td class='px-4'>
                                            <div class='d-flex align-items-center'>
                                                <div class='bg-success-subtle rounded-3 p-2 me-3'>
                                                    " . ($row['image_path'] ? 
                                                    "<img src='../{$row['image_path']}' alt='{$row['product_name']}' style='width: 40px; height: 40px; object-fit: contain;'>" :
                                                    "<i class='bi bi-box-seam text-success fs-4'></i>") . "
                                                </div>
                                                <div>
                                                    <h6 class='mb-0'>{$row['product_name']}</h6>
                                                    <small class='text-muted'>{$row['category_name']}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class='px-4'>
                                            <span class='badge bg-success-subtle text-success px-3 py-2'>{$row['brand_name']}</span>
                                        </td>
                                        <td class='px-4'>
                                            <div class='d-flex align-items-center'>
                                                <div class='me-3'>{$row['stocks']}</div>
                                            </div>
                                        </td>
                                        <td class='px-4'>
                                            <span class='fw-semibold'>₱" . number_format($row['price'], 2) . "</span>
                                        </td>
                                        <td class='px-4 text-end'>
                                            <button class='btn btn-outline-success btn-sm me-1' onclick='editProduct({$row['product_id']})'>
                                                <i class='bi bi-pencil-fill'></i>
                                            </button>
                                            <button class='btn btn-outline-danger btn-sm' onclick='deleteProduct({$row['product_id']})'>
                                                <i class='bi bi-trash-fill'></i>
                                            </button>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Featured Products Grid -->
            <h2 class="mb-4">Featured Products</h2>
            <div class="row g-4">
                <?php
                $stmt = $pdo->query("
                    SELECT p.*, b.brand_name, c.category_name 
                    FROM products p
                    LEFT JOIN brands b ON p.brand_id = b.brand_id
                    LEFT JOIN categories c ON p.category_id = c.category_id
                    WHERE p.status = 1
                    ORDER BY p.created_at DESC
                    LIMIT 6
                ");
                while ($row = $stmt->fetch()) {
                    echo "<div class='col-md-4'>
                        <div class='card h-100 border-success'>
                            <div class='p-3' style='height: 200px;'>
                                " . ($row['image_path'] ? 
                                "<img src='../{$row['image_path']}' class='card-img-top h-100' alt='{$row['product_name']}' style='object-fit: contain;'>" :
                                "<div class='h-100 d-flex align-items-center justify-content-center bg-light rounded'>
                                    <i class='bi bi-box-seam text-success' style='font-size: 3rem;'></i>
                                </div>") . "
                            </div>
                            <div class='card-body'>
                                <h5 class='card-title text-success'>{$row['product_name']}</h5>
                                <p class='card-text text-muted'>{$row['brand_name']} {$row['category_name']}</p>
                                <div class='d-flex justify-content-between align-items-center'>
                                    <span class='h5 mb-0'>₱" . number_format($row['price'], 2) . "</span>
                                    <span class='badge " . ($row['stocks'] > 0 ? 'bg-success' : 'bg-danger') . "'>" . 
                                    ($row['stocks'] > 0 ? 'In Stock' : 'Out of Stock') . "</span>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modals starts here -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="../database/Controllers/add-product.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="position-relative mb-3">
                                <div class="bg-light rounded p-3 mb-3" style="min-height: 200px;">
                                    <img id="productImagePreview" src="../images/logo.png" alt="Product Preview" 
                                         class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                </div>
                                <div class="d-grid">
                                    <label class="btn btn-outline-success">
                                        <i class="bi bi-upload me-2"></i>Upload Image
                                        <input type="file" name="product_image" class="d-none" 
                                               accept="image/*" onchange="previewImage(event)">
                                    </label>
                                </div>
                            </div>
                            <div class="form-check form-switch d-flex justify-content-center align-items-center mb-3">
                                <input class="form-check-input me-2" type="checkbox" id="productVisibility" checked>
                                <label class="form-check-label" for="productVisibility">
                                    Product Visibility
                                </label>
                            </div>
                            <div class="badge bg-success-subtle text-success p-2">
                                <i class="bi bi-box-seam me-1"></i>
                                New Product
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control border-success" 
                                           placeholder="Enter product name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Brand</label>
                                    <select name="brand" class="form-select border-success" required>
                                        <option value="">Select brand</option>
                                        <?php
                                        $brandStmt = $pdo->query("SELECT * FROM brands WHERE status = 1 ORDER BY brand_name");
                                        while ($brand = $brandStmt->fetch()) {
                                            echo "<option value='" . htmlspecialchars($brand['brand_id']) . "'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select border-success" required>
                                        <option value="">Select category</option>
                                        <?php
                                        $categoryStmt = $pdo->query("SELECT * FROM categories WHERE status = 1 ORDER BY category_name");
                                        while ($category = $categoryStmt->fetch()) {
                                            echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Price (₱)</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-success bg-success text-white">₱</span>
                                        <input type="number" name="price" class="form-control border-success" 
                                               step="0.01" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Initial Stock</label>
                                    <div class="input-group">
                                        <input type="number" name="stocks" class="form-control border-success" 
                                               placeholder="0" required>
                                        <span class="input-group-text border-success">units</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Product Description</label>
                                    <textarea name="description" class="form-control border-success" 
                                              rows="3" placeholder="Enter product description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_product" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Add Product
                    </button>
                </div>
                <div class="div">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editproductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="position-relative">
                                <img src="../images/logo.png" alt="Product Image" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: contain;">
                                <div class="mt-2">
                                    <label class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-upload me-1"></i>Change Image
                                        <input type="file" name="product_image" class="d-none" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success mb-2">Current Status: Active</span>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="productStatus" checked>
                                    <label class="form-check-label" for="productStatus">Product Visibility</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control border-success" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Brand</label>
                                    <select name="brand" class="form-select border-success" required>
                                        <?php
                                        $brandStmt = $pdo->query("SELECT * FROM brands WHERE status = 1 ORDER BY brand_name");
                                        while ($brand = $brandStmt->fetch()) {
                                            echo "<option value='" . htmlspecialchars($brand['brand_id']) . "'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select border-success" required>
                                        <?php
                                        $categoryStmt = $pdo->query("SELECT * FROM categories WHERE status = 1 ORDER BY category_name");
                                        while ($category = $categoryStmt->fetch()) {
                                            echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Price (₱)</label>
                                    <input type="number" step="1" name="price" class="form-control border-success" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" name="stocks" class="form-control border-success" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Description</label>
                                <textarea name="description" class="form-control border-success" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Product Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <img src="../images/logo.png" alt="Product Image" class="rounded me-3" style="height: 60px; width: 60px; object-fit: contain;">
                    <div>
                        <h5 class="mb-1">Ryzen 69</h5>
                        <p class="text-muted mb-0">AMD Processor</p>
                    </div>
                </div>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    This action cannot be undone. The product will be permanently removed from the system.
                </div>
                <div class="mb-3">
                    <label class="form-label">Type "DELETE" to confirm</label>
                    <input type="text" class="form-control" id="deleteConfirmation" placeholder="DELETE">
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete" disabled>
                    <i class="bi bi-trash-fill me-1"></i>Delete Product
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Manage Categories & Brands Modal -->
<div class="modal fade" id="manageCategoriesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Manage Categories & Brands</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="brands-tab" data-bs-toggle="tab" data-bs-target="#brands" type="button">Brands</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button">Categories</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <!-- Brands Tab -->
                    <div class="tab-pane fade show active" id="brands">
                        <form method="POST" action="../database/manage-categories/add_brand.php" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="brand_name" class="form-control border-success" placeholder="Enter brand name" required>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add Brand
                                </button>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Brand Name</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once '../database/config.php';
                                    $stmt = $pdo->query("SELECT * FROM brands ORDER BY brand_name");
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>
                                            <td>{$row['brand_name']}</td>
                                            <td>" . ($row['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') . "</td>
                                            <td class='text-end'>
                                                <button class='btn btn-sm btn-outline-danger' onclick='toggleBrandStatus({$row['brand_id']})'>
                                                    " . ($row['status'] ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>') . "
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Categories Tab -->
                    <div class="tab-pane fade" id="categories">
                        <form method="POST" action="../database/manage-categories/add_category.php" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="category_name" class="form-control border-success" placeholder="Enter category name" required>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-plus-lg me-1"></i>Add Category
                                </button>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>
                                            <td>{$row['category_name']}</td>
                                            <td>" . ($row['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') . "</td>
                                            <td class='text-end'>
                                                <button class='btn btn-sm btn-outline-danger' onclick='toggleCategoryStatus({$row['category_id']})'>
                                                    " . ($row['status'] ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>') . "
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Sign Out Confirmation Modal -->
<div class="modal fade" id="signOutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Sign Out Confirmation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="bi bi-question-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <h5 class="mb-3">Are you sure you want to sign out?</h5>
                <p class="text-muted mb-0">You will be redirected to the home page.</p>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Cancel
                </button>
                <a href="../../../guest/sample.php" class="btn btn-danger">
                    <i class="bi bi-check-lg me-2"></i>Yes, Sign Out
                </a>
            </div>
        </div>
    </div>
</div>



<script>
// Add this JavaScript for delete confirmation
document.getElementById('deleteConfirmation').addEventListener('input', function() {
    document.getElementById('confirmDelete').disabled = this.value !== 'DELETE';
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('productImagePreview');
        preview.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function addSpecField() {
    const container = document.getElementById('specificationFields');
    const newField = document.createElement('div');
    newField.className = 'input-group mb-2';
    newField.innerHTML = `
        <input type="text" name="spec_key[]" class="form-control border-success" placeholder="Specification name">
        <input type="text" name="spec_value[]" class="form-control border-success" placeholder="Value">
        <button type="button" class="btn btn-outline-danger" onclick="removeSpec(this)">
            <i class="bi bi-dash-lg"></i>
        </button>
    `;
    container.appendChild(newField);
}

function removeSpec(button) {
    button.closest('.input-group').remove();
}

function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alert);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 150);
    }, 5000);
}

function toggleBrandStatus(brandId) {
    fetch('../database/manage-categories/toggle_brand_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `brand_id=${brandId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Brand status updated successfully');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(data.error || 'Error updating brand status', 'danger');
        }
    });
}

function toggleCategoryStatus(categoryId) {
    fetch('../database/manage-categories/toggle_category_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `category_id=${categoryId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Category status updated successfully');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(data.error || 'Error updating category status', 'danger');
        }
    });
}

// Replace or update these functions in your script section
function editProduct(productId) {
    fetch(`../database/Controllers/get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {
            const form = document.getElementById('editProductForm');
            form.querySelector('input[name="product_id"]').value = product.product_id;
            form.querySelector('input[name="product_name"]').value = product.product_name;
            form.querySelector('select[name="brand"]').value = product.brand_id;
            form.querySelector('select[name="category"]').value = product.category_id;
            form.querySelector('input[name="price"]').value = product.price;
            form.querySelector('input[name="stocks"]').value = product.stocks;
            form.querySelector('textarea[name="description"]').value = product.description || '';
            
            if (product.image_path) {
                form.querySelector('img').src = '../' + product.image_path;
            }
            
            new bootstrap.Modal(document.getElementById('editproductModal')).show();
        })
        .catch(error => {
            showAlert('Error loading product details', 'danger');
        });
}

function deleteProduct(productId) {
    fetch(`../database/Controllers/get_product.php?id=${productId}`)
        .then(response => response.json())
        .then(product => {
            const modal = document.getElementById('staticBackdrop');
            modal.querySelector('.modal-body h5').textContent = product.product_name;
            modal.querySelector('.modal-body p').textContent = `${product.brand_name} ${product.category_name}`;
            
            if (product.image_path) {
                modal.querySelector('.modal-body img').src = '../' + product.image_path;
            }
            
            document.getElementById('confirmDelete').onclick = () => confirmDelete(productId);
            
            new bootstrap.Modal(modal).show();
        })
        .catch(error => {
            showAlert('Error loading product details', 'danger');
        });
}

function confirmDelete(productId) {
    if (document.getElementById('deleteConfirmation').value === 'DELETE') {
        fetch('../database/Controllers/delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                modal.hide();
                showAlert('Product deleted successfully');
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert(data.error || 'Error deleting product', 'danger');
            }
        })
        .catch(error => {
            showAlert('Error deleting product', 'danger');
        });
    }
}

// Update the edit form submission handler
document.getElementById('editProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('../database/Controllers/update_product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editproductModal'));
            modal.hide();
            showAlert(data.message || 'Product updated successfully');
            setTimeout(() => location.reload(), 1000);
        } else {
            showAlert(data.error || 'Error updating product', 'danger');
        }
    })
    .catch(error => {
        showAlert('Error updating product', 'danger');
    });
});
</script>




</body>
</html>