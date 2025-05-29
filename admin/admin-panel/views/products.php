<?php
session_start();
require '../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

<!-- Main Content Container -->
<div class="container-fluid" style="margin-left: 250px; padding: 20px; max-width: calc(100% - 250px);">
    <h1 class="text-center">Product List</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form class="d-flex" style="max-width: 350px;">
            <input class="form-control me-2" type="search" placeholder="Search products..." aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <div>
            <button class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#manageCategoriesBrandsModal">
                <i class="bi bi-tags-fill me-1"></i> Manage Categories & Brands
            </button>
            <button class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Add Product
            </button>
        </div>
    </div>

    <!-- Alert Message -->
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['alert']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product List</h5>
            <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-1"></i>Add Product
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">ID</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Brand</th>         
                            <th class="py-3">Category</th>
                            <th class="py-3">Stocks</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("CALL sp_get_products()");
                            while ($row = $stmt->fetch()) {
                                $stockStatus = is_null($row['stocks']) ? 
                                    '<span class="badge bg-success">Unlimited</span>' : 
                                    intval($row['stocks']);
                                
                                $status = $row['status'] ? 
                                    '<span class="badge bg-success">Active</span>' : 
                                    '<span class="badge bg-danger">Inactive</span>';

                                // Replace the problematic table row code with this fixed version
                                echo "<tr>
                                    <td class='ps-4 text-success'>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['brand_name']) . "</td>
                                    <td>" . htmlspecialchars($row['category_name']) . "</td>
                                    <td>{$stockStatus}</td>
                                    <td>₱" . number_format($row['price'], 2) . "</td>
                                    <td class='text-center'>{$status}</td>
                                    <td class='text-end pe-4'>
                                        <button class='btn btn-sm btn-outline-success me-1' 
                                                onclick='editProduct(" . json_encode($row) . ")' 
                                                title='Edit'>
                                            <i class='bi bi-pencil-square'></i>
                                        </button>
                                        <button class='btn btn-sm btn-outline-danger' 
                                                onclick='showDeleteModal(" . $row['id'] . ", \"" . htmlspecialchars($row['name']) . "\")' 
                                                title='Delete'>
                                            <i class='bi bi-trash'></i>
                                        </button>
                                    </td>
                                </tr>";
                            }
                            $stmt->closeCursor();
                        } catch (PDOException $e) {
                            echo '<tr><td colspan="8" class="text-center text-danger">Error loading products: ' . 
                                htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <h2 class="mt-5 mb-4 text-center">Featured Products</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    try {
        $stmt = $pdo->query("CALL sp_get_products()");
        while ($row = $stmt->fetch()) {
            echo '<div class="col">';
            echo '  <div class="card h-100 shadow-sm">';
            if (!empty($row['image'])) {
                // Fix the image path by removing the additional 'uploads/products' since it's already in the path
                echo '<img src="../../admin-panel/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '" style="object-fit:cover; height:200px;">';
            } else {
                echo '<div class="text-center py-5 bg-light">
                        <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                      </div>';
            }
            echo '    <div class="card-body">';
            echo '      <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
            echo '      <p class="card-text mb-1"><strong>Brand:</strong> ' . htmlspecialchars($row['brand_name']) . '</p>';
            echo '      <p class="card-text mb-1"><strong>Category:</strong> ' . htmlspecialchars($row['category_name']) . '</p>';
            echo '      <p class="card-text mb-1"><strong>Stocks:</strong> ' . (is_null($row['stocks']) ? '<span class="badge bg-success">Unlimited</span>' : intval($row['stocks'])) . '</p>';
            echo '      <p class="card-text mb-1"><strong>Price:</strong> ₱' . number_format($row['price'], 2) . '</p>';
            echo '      <p class="card-text"><strong>Status:</strong> ' . ($row['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>') . '</p>';
            if (!empty($row['description'])) {
                echo '  <p class="card-text small text-muted">' . htmlspecialchars($row['description']) . '</p>';
            }
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo '<div class="col-12 text-center text-danger">Error loading featured products: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    ?>
    </div>
</div>

<!-- Modals -->
<!-- Manage Categories & Brands Modal -->
<div class="modal fade" id="manageCategoriesBrandsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-tags-fill me-2"></i>Manage Categories & Brands
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Categories Section -->
                    <div class="col-md-6 border-end">
                        <h6>Categories</h6>
                        <!-- Update the category form -->
                        <form action="../database/Controllers/add_category.php" method="POST" class="d-flex mb-3" id="addCategoryForm">
                            <input type="text" class="form-control me-2" placeholder="Add new category" name="category_name" required>
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Add this before your queries
                                    try {
                                        $stmt = $pdo->query("CALL sp_get_categories()");
                                        if (!$stmt) {
                                            throw new PDOException("Error executing query");
                                        }
                                        while ($row = $stmt->fetch()) {
                                            // Update the category toggle button code
                                            echo "<tr>
                                                <td>{$row['category_name']}</td>
                                                <td>" . ($row['status'] ? 
                                                    '<span class="badge bg-success">Active</span>' : 
                                                    '<span class="badge bg-danger">Inactive</span>') . "</td>
                                                <td class='text-end'>
                                                    <button type='button' class='btn btn-sm btn-outline-" . 
                                                    ($row['status'] ? 'danger' : 'success') . " me-1' 
                                                    onclick='window.location.href=\"../database/Controllers/toggle_category_status.php?id=" . 
                                                    $row['category_id'] . "\"'>
                                                        <i class='bi bi-" . ($row['status'] ? 'eye-slash' : 'eye') . "'></i>
                                                    </button>
                                                    <button type='button' class='btn btn-sm btn-outline-danger'>
                                                        <i class='bi bi-trash'></i>
                                                    </button>
                                                </td>
                                            </tr>";
                                        }
                                        $stmt->closeCursor();
                                    } catch (PDOException $e) {
                                        echo "Database error: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Brands Section -->
                    <div class="col-md-6">
                        <h6>Brands</h6>
                        <!-- Update the brand form -->
                        <form action="../database/Controllers/add_brand.php" method="POST" class="d-flex mb-3" id="addBrandForm">
                            <input type="text" class="form-control me-2" placeholder="Add new brand" name="brand_name" required>
                            <button type="submit" class="btn btn-success btn-sm">Add</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("CALL sp_get_brands()");
                                    while ($row = $stmt->fetch()) {
                                        echo "<tr>
                                            <td>{$row['brand_name']}</td>
                                            <td>" . ($row['status'] ? 
                                                '<span class="badge bg-success">Active</span>' : 
                                                '<span class="badge bg-danger">Inactive</span>') . "</td>
                                            <td class='text-end'>
                                                <button type='button' class='btn btn-sm btn-outline-" . 
                                                ($row['status'] ? 'danger' : 'success') . " me-1' 
                                                onclick='window.location.href=\"../database/Controllers/toggle_brand_status.php?id=" . 
                                                $row['brand_id'] . "\"'>
                                                    <i class='bi bi-" . ($row['status'] ? 'eye-slash' : 'eye') . "'></i>
                                                </button>
                                                <button type='button' class='btn btn-sm btn-outline-danger'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                    $stmt->closeCursor();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="../database/Controllers/add_product.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Add Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <div id="productImagePreview" class="mb-2" style="height:200px;">
                                <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                                    <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                                </div>
                            </div>
                            <input type="file" class="form-control" name="product_image" accept="image/*" onchange="previewProductImage(event)">
                            <small class="text-muted">Image is optional</small>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productName" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="productBrand" class="form-label">Brand <span class="text-danger">*</span></label>
                                <select class="form-select" id="productBrand" name="brand_id" required>
                                    <option value="" disabled selected>Select brand</option>
                                    <?php
                                    try {
                                        $stmt = $pdo->query("CALL sp_get_brands()");
                                        while ($row = $stmt->fetch()) {
                                            if ($row['status']) {
                                                echo "<option value=\"{$row['brand_id']}\">" . htmlspecialchars($row['brand_name']) . "</option>";
                                            }
                                        }
                                        $stmt->closeCursor();
                                    } catch (PDOException $e) {
                                        echo "<option disabled>Error loading brands</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="productCategory" name="category_id" required>
                                    <option value="" disabled selected>Select category</option>
                                    <?php
                                    try {
                                        $stmt = $pdo->query("CALL sp_get_categories()");
                                        while ($row = $stmt->fetch()) {
                                            if ($row['status']) {
                                                echo "<option value=\"{$row['category_id']}\">" . htmlspecialchars($row['category_name']) . "</option>";
                                            }
                                        }
                                        $stmt->closeCursor();
                                    } catch (PDOException $e) {
                                        echo "<option disabled>Error loading categories</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productStocks" class="form-label">Stocks</label>
                                <input type="number" class="form-control" id="productStocks" name="stocks" min="0" placeholder="Leave blank if unlimited">
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productPrice" name="price" min="0" step="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="3" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Product</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="../database/Controllers/edit_product.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="editProductId">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Edit Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <div id="editProductImagePreview" class="mb-2" style="height:200px;">
                                <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                                    <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                                </div>
                            </div>
                            <input type="file" class="form-control" name="product_image" accept="image/*" onchange="previewEditImage(event)">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="editProductName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editProductName" name="product_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductBrand" class="form-label">Brand <span class="text-danger">*</span></label>
                                <select class="form-select" id="editProductBrand" name="brand_id" required>
                                    <option value="" disabled selected>Select brand</option>
                                    <?php
                                    try {
                                        $stmt = $pdo->query("CALL sp_get_brands()");
                                        while ($row = $stmt->fetch()) {
                                            if ($row['status']) {
                                                echo "<option value=\"{$row['brand_id']}\">" . htmlspecialchars($row['brand_name']) . "</option>";
                                            }
                                        }
                                        $stmt->closeCursor();
                                    } catch (PDOException $e) {
                                        echo "<option disabled>Error loading brands</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editProductCategory" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="editProductCategory" name="category_id" required>
                                    <option value="" disabled selected>Select category</option>
                                    <?php
                                    try {
                                        $stmt = $pdo->query("CALL sp_get_categories()");
                                        while ($row = $stmt->fetch()) {
                                            if ($row['status']) {
                                                echo "<option value=\"{$row['category_id']}\">" . htmlspecialchars($row['category_name']) . "</option>";
                                            }
                                        }
                                        $stmt->closeCursor();
                                    } catch (PDOException $e) {
                                        echo "<option disabled>Error loading categories</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editProductStocks" class="form-label">Stocks</label>
                                <input type="number" class="form-control" id="editProductStocks" name="stocks" min="0" placeholder="Leave blank if unlimited">
                            </div>
                            <div class="mb-3">
                                <label for="editProductPrice" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="editProductPrice" name="price" min="0" step="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="editProductDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editProductDescription" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editProductStatus" name="status">
                                    <label class="form-check-label" for="editProductStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<span id="deleteProductName" class="fw-bold"></span>"?</p>
                <p class="text-muted mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <form action="../database/Controllers/delete_product.php" method="POST">
                    <input type="hidden" id="deleteProductId" name="product_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
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
                <a href="../../../guest/index.php" class="btn btn-danger">
                    <i class="bi bi-check-lg me-2"></i>Yes, Sign Out
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Update the previewProductImage function
function previewProductImage(event) {
    const preview = document.getElementById('productImagePreview');
    const [file] = event.target.files;
    
    if (file) {
        preview.innerHTML = `<img src="${URL.createObjectURL(file)}" class="img-fluid rounded" style="max-height:200px;" alt="Product preview">`;
    } else {
        preview.innerHTML = `
            <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
            </div>`;
    }
}

// Attach modal trigger to Add Product button
document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.querySelector('button.btn-success i.bi-plus-circle')?.parentElement;
    if (addProductBtn) {
        addProductBtn.setAttribute('data-bs-toggle', 'modal');
        addProductBtn.setAttribute('data-bs-target', '#addProductModal');
    }
});

// Preview function for edited product image
function previewEditImage(event) {
    const preview = document.getElementById('editProductImagePreview');
    const [file] = event.target.files;
    
    if (file) {
        preview.innerHTML = `<img src="${URL.createObjectURL(file)}" class="img-fluid rounded" style="max-height:200px;" alt="Product preview">`;
    } else {
        preview.innerHTML = `
            <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
            </div>`;
    }
}

// Populate edit product modal with existing data
document.addEventListener('DOMContentLoaded', function() {
    const editProductModal = document.getElementById('editProductModal');
    
    editProductModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const productId = button.getAttribute('data-id'); // Extract info from data-* attributes
        
        // Fetch product details using AJAX
        fetch(`../database/Controllers/get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.product;
                    
                    // Populate fields
                    document.getElementById('editProductId').value = product.id;
                    document.getElementById('editProductName').value = product.name;
                    document.getElementById('editProductStocks').value = product.stocks || '';
                    document.getElementById('editProductPrice').value = product.price;
                    document.getElementById('editProductDescription').value = product.description || '';
                    document.getElementById('editProductStatus').checked = product.status;
                    
                    // Update brand and category selects
                    updateBrandAndCategorySelects(product.brand_id, product.category_id);
                    
                    // Preview existing image
                    if (product.image) {
                        document.getElementById('editProductImagePreview').innerHTML = `<img src="${product.image}" class="img-fluid rounded" style="max-height:200px;" alt="Product image">`;
                    } else {
                        document.getElementById('editProductImagePreview').innerHTML = `
                            <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                                <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
                            </div>`;
                    }
                } else {
                    // Handle error (e.g., product not found)
                    console.error('Product not found:', data.message);
                }
            })
            .catch(error => console.error('Error fetching product details:', error));
    });
});

// Function to update brand and category selects in the edit product modal
function updateBrandAndCategorySelects(selectedBrandId, selectedCategoryId) {
    const editProductBrand = document.getElementById('editProductBrand');
    const editProductCategory = document.getElementById('editProductCategory');
    
    // Clear existing options
    editProductBrand.innerHTML = '<option value="" disabled selected>Select brand</option>';
    editProductCategory.innerHTML = '<option value="" disabled selected>Select category</option>';
    
    // Fetch and populate brands
    fetch(`../database/Controllers/get_brands.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.brands.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand.brand_id;
                    option.textContent = brand.brand_name;
                    if (brand.brand_id == selectedBrandId) {
                        option.selected = true;
                    }
                    editProductBrand.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error fetching brands:', error));
    
    // Fetch and populate categories
    fetch(`../database/Controllers/get_categories.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.category_id;
                    option.textContent = category.category_name;
                    if (category.category_id == selectedCategoryId) {
                        option.selected = true;
                    }
                    editProductCategory.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error fetching categories:', error));
}

// Modify the editProduct function
function editProduct(product) {
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductPrice').value = product.price;
    document.getElementById('editProductStocks').value = product.stocks;
    document.getElementById('editProductDescription').value = product.description;
    document.getElementById('editProductStatus').checked = product.status == 1;
    
    // Set selected values for dropdowns
    document.getElementById('editProductBrand').value = product.brand_id;
    document.getElementById('editProductCategory').value = product.category_id;
    
    // Update image preview with correct path
    const imagePreview = document.getElementById('editProductImagePreview');
    if (product.image) {
        imagePreview.innerHTML = `<img src="../${product.image}" class="img-fluid rounded" style="max-height:200px;" alt="Product preview">`;
    } else {
        imagePreview.innerHTML = `
            <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded">
                <i class="bi bi-box-seam text-muted" style="font-size: 5rem;"></i>
            </div>`;
    }
    
    // Show the modal
    new bootstrap.Modal(document.getElementById('editProductModal')).show();
}

function confirmDelete(id, name) {
    const deleteProductId = document.getElementById('deleteProductId');
    const deleteProductName = document.getElementById('deleteProductName');
    
    deleteProductId.value = id;
    deleteProductName.textContent = name;
    
    // Show the modal
    new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
}

async function populateSelect(elementId, selectedValue) {
    const select = document.getElementById(elementId);
    const type = elementId.includes('Brand') ? 'brands' : 'categories';
    
    try {
        const response = await fetch(`../database/Controllers/get_${type}.php`);
        const data = await response.json();
        
        select.innerHTML = `<option value="" disabled>Select ${type.slice(0, -1)}</option>`;
        data.forEach(item => {
            if (item.status) {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                option.selected = item.id == selectedValue;
                select.appendChild(option);
            }
        });
    } catch (error) {
        console.error('Error loading ' + type + ':', error);
    }
}

// Add this to your existing script section
function showDeleteModal(productId, productName) {
    document.getElementById('deleteProductId').value = productId;
    document.getElementById('deleteProductName').textContent = productName;
    new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the modal element
        const modal = document.getElementById('manageCategoriesBrandsModal');
        
        // Add event listener for when modal is hidden
        modal.addEventListener('hidden.bs.modal', function () {
            // Remove modal-backdrop if it exists
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            // Remove modal-open class from body
            document.body.classList.remove('modal-open');
            // Remove inline styles from body
            document.body.removeAttribute('style');
        });
    });
</script>

<!-- Bootstrap Bundle includes Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>