<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/table1.css">
    <link rel="stylesheet" href="../css/style-sidebar.css">
    <title>Document</title>
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
          <a class="nav-link text-white" href="transaction.php" style="font-weight: 700; background-color:rgb(26, 175, 106);">
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
            <h2 class="text-center mb-4">Transaction History</h2>
            
            <!-- Search and Filter Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="search" class="form-control border-success" placeholder="Search transactions...">
                </div>
                <div class="col-md-3">
                    <select class="form-select border-success">
                        <option value="">All Status</option>
                        <option value="accepted">Accepted</option>
                        <option value="deleted">Deleted</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control border-success">
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="table-responsive">
                <table class="table table-hover border" style="min-width: 800px;">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-3" style="width: 10%">Order ID</th>
                            <th class="py-3" style="width: 20%">Name</th>
                            <th class="py-3" style="width: 20%">Date & Status</th>
                            <th class="py-3" style="width: 15%">Contact</th>
                            <th class="py-3" style="width: 15%">Total Price</th>
                            <th class="py-3 text-end" style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">#1</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill text-success"></i>
                                    </span>
                                    Kenneth Lico
                                </div>
                            </td>
                            <td class="align-middle">
                                19-03-2024
                                <br>
                                <span class="badge bg-success">Accepted</span>
                            </td>
                            <td class="align-middle">0983 0962 971</td>
                            <td class="align-middle">₱36,000</td>
                            <td class="align-middle text-end">
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-eye-fill me-1"></i>View Details
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">#2</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill text-success"></i>
                                    </span>
                                    Herald Elivira
                                </div>
                            </td>
                            <td class="align-middle">
                                25-03-2024
                                <br>
                                <span class="badge bg-danger">Rejected</span>
                            </td>
                            <td class="align-middle">0920 3994 929</td>
                            <td class="align-middle">₱25,000</td>
                            <td class="align-middle text-end">
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-eye-fill me-1"></i>View Details
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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