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
      <a class="nav-link text-white" href="../views/orders.php" style="transition: all 0.3s ease;">
        <i class="bi bi-cart-fill me-2"></i>Orders
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-white" href="../views/pre-built-orders.php" style="font-weight: 700; background-color:rgb(26, 175, 106);">
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
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Pre-Built PC Orders</h2>
            
            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-success shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-pc-display text-success fs-4"></i>
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
                                <h6 class="card-title text-muted mb-1">Accepted Orders</h6>
                                <h4 class="mb-0 text-success">156</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-x-circle-fill text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Rejected Orders</h6>
                                <h4 class="mb-0 text-success">12</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="search" class="form-control border-success" placeholder="Search orders...">
                </div>
                <div class="col-md-3">
                    <select class="form-select border-success">
                        <option value="">Filter by Status</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control border-success">
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0">Pre-Built Orders List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4">ID</th>
                                    <th class="py-3">Customer Name</th>
                                    <th class="py-3">Build Type</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Total Price</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 align-middle">1</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <i class="bi bi-person-fill text-success"></i>
                                            </span>
                                            Kenneth Lico
                                        </div>
                                    </td>
                                    <td class="align-middle">Gaming PC</td>
                                    <td class="align-middle">20-04-2025</td>
                                    <td class="align-middle">₱25,000</td>
                                    <td class="align-middle">
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td class="align-middle text-end pe-4">
                                        <button class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewModal">
                                            <i class="bi bi-eye-fill me-1"></i>View
                                        </button>
                                        <button class="btn btn-outline-success btn-sm me-1">
                                            <i class="bi bi-check-lg me-1"></i>Accept
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-x-lg me-1"></i>Reject
                                        </button>
                                    </td>
                                </tr>
                                <!-- Add more rows with similar structure -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Pre-Built PC Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> Kenneth Lico</p>
                        <p class="mb-1"><strong>Email:</strong> kenneth@email.com</p>
                        <p class="mb-1"><strong>Phone:</strong> +63 912 345 6789</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Order Information</h6>
                        <p class="mb-1"><strong>Order ID:</strong> #1</p>
                        <p class="mb-1"><strong>Date:</strong> 20-04-2025</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
                    </div>
                </div>
                <h6 class="text-muted">PC Specifications</h6>
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 150px;">CPU</th>
                            <td>AMD Ryzen 5 5600X</td>
                        </tr>
                        <tr>
                            <th>GPU</th>
                            <td>NVIDIA RTX 3060</td>
                        </tr>
                        <tr>
                            <th>RAM</th>
                            <td>16GB DDR4 3200MHz</td>
                        </tr>
                        <tr>
                            <th>Storage</th>
                            <td>1TB NVMe SSD</td>
                        </tr>
                    </tbody>
                </table>
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
                <a href="../../../guest/index.php" class="btn btn-danger">
                    <i class="bi bi-check-lg me-2"></i>Yes, Sign Out
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>