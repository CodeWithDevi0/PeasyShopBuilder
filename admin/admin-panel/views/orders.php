<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style-sidebar.css">
    <title>Orders</title>
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
      <a class="nav-link text-white" href="../views/products.php" style="transition: all 0.3s ease;">
        <i class="bi bi-box-seam-fill me-2"></i>Products
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white" href="../views/orders.php" style="font-weight: 700; background-color:rgb(26, 175, 106);">
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
    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-hourglass-split text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Pending Orders</h6>
                        <h4 class="mb-0 text-success">25</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle-fill text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Completed Orders</h6>
                        <h4 class="mb-0 text-success">156</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Revenue</h6>
                        <h4 class="mb-0 text-success">₱74,000</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card border-success shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-success text-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" class="form-control border-success" placeholder="Search orders...">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select border-success">
                        <option value="">Filter by Status</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Orders List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">ID</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Product</th>
                            <th class="py-3">Quantity</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 align-middle">#1</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill text-success"></i>
                                    </span>
                                    Ryzen 69
                                </div>
                            </td>
                            <td class="align-middle">Ryzen 5 5600X</td>
                            <td class="align-middle">1</td>
                            <td class="align-middle">₱4,000</td>
                            <td class="align-middle">
                                <span class="badge bg-warning">Pending</span>
                            </td>
                            <td class="align-middle text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="bi bi-eye-fill">view</i>
                                </button>
                                <button class="btn btn-sm btn-outline-success me-1">
                                    <i class="bi bi-check-lg">accept</i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-x-lg">reject</i>
                                </button>
                            </td>
                        </tr>
                        <!-- Add more rows with similar structure -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <nav class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">Showing 1 to 10 of I miss you</p>
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link bg-success border-success" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Order Details #1</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-success fw-bold mb-3">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> Ryzen 69</p>
                        <p class="mb-1"><strong>Email:</strong> ryzen69@email.com</p>
                        <p class="mb-1"><strong>Contact:</strong> +63 912 345 6789</p>
                        <p class="mb-1"><strong>Address:</strong> Pob. Centro, Clarin, Bohol</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success fw-bold mb-3">Order Information</h6>
                        <p class="mb-1"><strong>Order Date:</strong> 2025-05-01</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
                        <p class="mb-1"><strong>Payment Method:</strong> Cash on Delivery</p>
                        <p class="mb-1"><strong>Shipping Method:</strong> Third Party</p>
                    </div>
                </div>

                <h6 class="text-success fw-bold mb-3">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            <i class="bi bi-cpu-fill text-success"></i>
                                        </span>
                                        Ryzen 5 5600X
                                    </div>
                                </td>
                                <td>₱4,000</td>
                                <td>1</td>
                                <td class="text-end">₱4,000</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end text-success"><strong>₱4,100</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
    
</body>
</html>