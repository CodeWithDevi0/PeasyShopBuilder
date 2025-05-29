<?php
require_once '../database/config.php';

function getPreBuiltOrders() {
    try {
        $conn = getDBConnection();
        
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Updated SQL query to join with users_profile
        $sql = "SELECT po.*, u.username, u.email, up.contact_number as phone 
                FROM pre_built_orders po
                JOIN users u ON po.user_id = u.id
                LEFT JOIN users_profile up ON u.id = up.users_id
                ORDER BY po.created_at DESC";
                
        $result = $conn->query($sql);
        
        if (!$result) {
            throw new Exception("Query failed: " . $conn->error);
        }
        
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        
        // Debug order count
        error_log("Found " . count($orders) . " orders");
        
        return $orders;
        
    } catch (Exception $e) {
        error_log("Error in getPreBuiltOrders: " . $e->getMessage());
        return [];
    } finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

// Get status badge color helper function
function getStatusBadgeColor($status) {
    $colors = [
        'PENDING' => 'warning',
        'ACCEPTED' => 'success',
        'COMPLETED' => 'primary',
        'CANCELLED' => 'danger'
    ];
    return $colors[$status] ?? 'secondary';
}

// Get the orders
$preBuiltOrders = getPreBuiltOrders();

// Debug output
if (empty($preBuiltOrders)) {
    echo "<!-- Debug: No orders found -->";
} else {
    echo "<!-- Debug: Found " . count($preBuiltOrders) . " orders -->";
    echo "<!-- Debug Data: " . htmlspecialchars(json_encode($preBuiltOrders)) . " -->";
}
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
                                <?php if (empty($preBuiltOrders)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
                                        No pre-built orders found
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($preBuiltOrders as $order): ?>
                                    <tr>
                                        <td class="ps-4 align-middle"><?= htmlspecialchars($order['id']) ?></td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <span class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                    <i class="bi bi-person-fill text-success"></i>
                                                </span>
                                                <?= htmlspecialchars($order['username']) ?>
                                            </div>
                                        </td>
                                        <td class="align-middle">Custom Build</td>
                                        <td class="align-middle"><?= date('d-m-Y', strtotime($order['created_at'])) ?></td>
                                        <td class="align-middle">₱<?= number_format($order['total_price'], 2) ?></td>
                                        <td class="align-middle">
                                            <span class="badge bg-<?= getStatusBadgeColor($order['status']) ?>">
                                                <?= htmlspecialchars($order['status']) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-end pe-4">
                                            <button class="btn btn-outline-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewModal"
                                                    onclick="viewPreBuiltOrder(<?= $order['id'] ?>)">
                                                <i class="bi bi-eye-fill me-1"></i>View
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
                        <p class="mb-1"><strong>Name:</strong> </p>
                        <p class="mb-1"><strong>Email:</strong> </p>
                        <p class="mb-1"><strong>Phone:</strong> </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Order Information</h6>
                        <p class="mb-1"><strong>Order ID:</strong> </p>
                        <p class="mb-1"><strong>Date:</strong> </p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning"></span></p>
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
            <div class="modal-footer justify-content-between">
    <div class="d-flex align-items-center" id="statusUpdateSection">
        <select class="form-select me-2" id="statusSelect" style="width: auto;">
            <option value="">Update Status</option>
            <option value="PENDING">Revert to Pending</option>
            <option value="ACCEPTED">Accept Order</option>
            <option value="COMPLETED">Mark as Completed</option>
            <option value="CANCELLED">Reject Order</option>
        </select>
        <button type="button" class="btn btn-success" onclick="updatePreBuiltOrderStatus()">
            <i class="bi bi-check-lg me-2"></i>Update
        </button>
    </div>
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

<script>
function viewPreBuiltOrder(orderId) {
    const modal = document.getElementById('viewModal');
    modal.setAttribute('data-order-id', orderId);

    fetch(`../database/Controllers/get_prebuilt_order.php?id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            // Update customer information
            const customerInfo = modal.querySelector('.col-md-6:first-child');
            const name = data.f_name && data.l_name ? 
                        `${data.f_name} ${data.l_name}` : 
                        data.username;
            
            customerInfo.innerHTML = `
                <h6 class="text-muted">Customer Information</h6>
                <p class="mb-1"><strong>Name:</strong> ${name}</p>
                <p class="mb-1"><strong>Email:</strong> ${data.email || 'N/A'}</p>
                <p class="mb-1"><strong>Phone:</strong> ${data.contact_number || 'N/A'}</p>
            `;

            // Update order information
            const orderInfo = modal.querySelector('.col-md-6:last-child');
            orderInfo.innerHTML = `
                <h6 class="text-muted">Order Information</h6>
                <p class="mb-1"><strong>Order ID:</strong> #${data.id}</p>
                <p class="mb-1"><strong>Date:</strong> ${new Date(data.created_at).toLocaleDateString('en-GB')}</p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-${getStatusBadgeColor(data.status)}">${data.status}</span></p>
                <p class="mb-1"><strong>Total Price:</strong> ₱${parseFloat(data.total_price).toLocaleString('en-PH', {minimumFractionDigits: 2})}</p>
            `;

            // Update PC specifications
            const specTable = modal.querySelector('.table tbody');
            if (data.items && data.items.length > 0) {
                specTable.innerHTML = data.items.map(item => `
                    <tr>
                        <th style="width: 150px;">${item.category_name}</th>
                        <td>
                            ${item.product_name}
                            <br>
                            <small class="text-muted">₱${parseFloat(item.price).toLocaleString('en-PH', {minimumFractionDigits: 2})}</small>
                        </td>
                    </tr>
                `).join('');
            } else {
                specTable.innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center">No components found</td>
                    </tr>
                `;
            }

            // Set current status in select
            document.getElementById('statusSelect').value = data.status;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading order details');
        });
}

function updatePreBuiltOrderStatus() {
    const modal = document.getElementById('viewModal');
    const orderId = modal.getAttribute('data-order-id');
    const newStatus = document.getElementById('statusSelect').value;
    
    if (!newStatus) {
        alert('Please select a status');
        return;
    }

    fetch('../database/Controllers/update_prebuilt_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            orderId: orderId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order status updated successfully');
            location.reload();
        } else {
            alert('Error updating order status');
        }
    });
}

function getStatusBadgeColor(status) {
    const colors = {
        'PENDING': 'warning',
        'ACCEPTED': 'success',
        'COMPLETED': 'primary',
        'CANCELLED': 'danger'
    };
    return colors[status] || 'secondary';
}

function filterOrders() {
    const searchInput = document.querySelector('input[type="search"]').value.toLowerCase();
    const statusFilter = document.querySelector('select.form-select').value.toUpperCase();
    const dateFilter = document.querySelector('input[type="date"]').value;
    
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const id = row.querySelector('td:nth-child(1)').textContent;
        const customerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const date = row.querySelector('td:nth-child(4)').textContent;
        const status = row.querySelector('.badge').textContent.toUpperCase();
        
        const matchesSearch = !searchInput || 
            customerName.includes(searchInput) || 
            id.includes(searchInput);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesDate = !dateFilter || date === formatDate(dateFilter);
        
        row.style.display = (matchesSearch && matchesStatus && matchesDate) ? '' : 'none';
    });
}

function formatDate(date) {
    const d = new Date(date);
    return d.toLocaleDateString('en-GB').split('/').join('-');
}

// Add event listeners for filters
document.querySelector('input[type="search"]').addEventListener('input', filterOrders);
document.querySelector('select.form-select').addEventListener('change', filterOrders);
document.querySelector('input[type="date"]').addEventListener('change', filterOrders);
</script>
</body>
</html>