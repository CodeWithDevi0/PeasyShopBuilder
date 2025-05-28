<?php
session_start();
require_once '../database/config.php';

// Get order statistics for the cards at the top
$statsQuery = $pdo->query("
    SELECT 
        COUNT(CASE WHEN shipping_status = 'PENDING' THEN 1 END) as pending_count,
        COUNT(CASE WHEN shipping_status = 'COMPLETED' THEN 1 END) as completed_count,
        SUM(CASE WHEN shipping_status = 'COMPLETED' THEN total ELSE 0 END) as total_revenue
    FROM orders
");
$stats = $statsQuery->fetch(PDO::FETCH_ASSOC);

// If no stats found, set defaults
if (!$stats) {
    $stats = [
        'pending_count' => 0,
        'completed_count' => 0,
        'total_revenue' => 0
    ];
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
                        <h4 class="mb-0 text-success"><?php echo $stats['pending_count']; ?></h4>
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
                        <h4 class="mb-0 text-success"><?php echo $stats['completed_count']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-cart-fill text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Orders</h6>
                        <?php
                        $orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                        ?>
                        <h4 class="mb-0 text-success"><?php echo number_format($orderCount); ?></h4>
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
                        <input type="search" id="searchInput" class="form-control border-success" placeholder="Search orders...">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select border-success" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="PENDING">Pending</option>
                        <option value="ACCEPTED">Accepted</option>
                        <option value="COMPLETED">Completed</option>
                        <option value="CANCELLED">Cancelled</option>
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
                        <?php
                        require_once '../database/config.php';
                        try {
                            $search = $_GET['search'] ?? '';
                            $status = $_GET['status'] ?? '';
                            
                            $query = "SELECT * FROM vw_orders WHERE 1=1";
                            $params = [];
                            
                            if ($search) {
                                $query .= " AND (
                                    order_id LIKE ? OR 
                                    f_name LIKE ? OR 
                                    l_name LIKE ? OR 
                                    product_name LIKE ? OR
                                    contact_number LIKE ?
                                )";
                                $searchTerm = "%$search%";
                                $params = array_fill(0, 5, $searchTerm);
                            }
                            
                            if ($status) {
                                $query .= " AND shipping_status = ?";
                                $params[] = $status;
                            }
                            
                            $query .= " ORDER BY created_at DESC";
                            
                            $stmt = $pdo->prepare($query);
                            $stmt->execute($params);
                            
                            while ($row = $stmt->fetch()) {
                                // Update the status badge class matching in the table
                                $statusBadgeClass = match($row['shipping_status']) {
                                    'PENDING' => 'bg-warning',
                                    'ACCEPTED' => 'bg-info',
                                    'COMPLETED' => 'bg-success',
                                    'CANCELLED' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                
                                // Replace the table row echo statement with:
                                echo "<tr>
                                    <td class='ps-4 align-middle'>#{$row['order_id']}</td>
                                    <td class='align-middle'>
                                        <div class='d-flex align-items-center'>
                                            <span class='bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-2' style='width: 35px; height: 35px;'>
                                                <i class='bi bi-person-fill text-success'></i>
                                            </span>
                                            " . htmlspecialchars($row['f_name'] . ' ' . $row['l_name']) . "
                                        </div>
                                    </td>
                                    <td class='align-middle'>" . htmlspecialchars($row['product_names'] ?? 'N/A') . "</td>
                                    <td class='align-middle'>" . htmlspecialchars($row['quantities'] ?? '0') . "</td>
                                    <td class='align-middle'>₱" . number_format($row['unit_prices'] ?? 0, 2) . "</td>
                                    <td class='align-middle'>
                                        <span class='badge {$statusBadgeClass}'>" . htmlspecialchars($row['shipping_status']) . "</span>
                                    </td>
                                    <td class='align-middle text-end pe-4'>
                                        <button class='btn btn-sm btn-outline-primary me-1' 
                                            onclick='viewOrder({$row['order_id']})' 
                                            data-bs-toggle='modal' 
                                            data-bs-target='#orderModal'>
                                            <i class='bi bi-eye-fill'>view</i>
                                        </button>
                                    </td>
                                </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='7' class='text-center text-danger'>Error loading orders: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
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
                <h5 class="modal-title">Order Details #<span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-success fw-bold mb-3">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> <span id="customerName"></span></p>
                        <p class="mb-1"><strong>Email:</strong> <span id="customerEmail"></span></p>
                        <p class="mb-1"><strong>Contact:</strong> <span id="customerContact"></span></p>
                        <p class="mb-1"><strong>Address:</strong> <span id="customerAddress"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success fw-bold mb-3">Order Information</h6>
                        <p class="mb-1"><strong>Order Date:</strong> <span id="orderDate"></span></p>
                        <p class="mb-1"><strong>Status:</strong> <span id="orderStatus"></span></p>
                        <p class="mb-1"><strong>Payment Method:</strong> Cash on Delivery</p>
                        <p class="mb-1"><strong>Shipping Method:</strong> <span id="shippingMethod"></span></p>
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
                        <tbody id="orderItems">
                            <!-- Order items will be inserted here -->
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end text-success" id="orderTotal"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- Update the Order Details Modal footer -->
            <div class="modal-footer justify-content-between">
                <div class="d-flex align-items-center" id="statusUpdateSection">
                    <select class="form-select me-2" id="statusSelect" style="width: auto;">
                        <option value="">Update Status</option>
                        <option value="PENDING">Revert to Pending</option>
                        <option value="ACCEPTED">Accept Order</option>
                        <option value="COMPLETED">Mark as Completed</option>
                        <option value="CANCELLED">Reject Order</option>
                    </select>
                    <button type="button" class="btn btn-success" onclick="updateStatus()">
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
// Add this variable to store current order ID
let currentOrderId = null;

function updateOrderStatus(orderId, status) {
    if (!confirm(`Are you sure you want to ${status.toLowerCase()} this order?`)) return;

    fetch('../database/Controllers/update_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${orderId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating order status');
        }
    })
    .catch(error => console.error('Error:', error));
}

function viewOrder(orderId) {
    currentOrderId = orderId;
    fetch(`../database/Controllers/get_order_details.php?id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            // Update modal title and basic info
            document.getElementById('modalOrderId').textContent = data.order_id;
            document.getElementById('customerName').textContent = `${data.f_name} ${data.l_name}`;
            document.getElementById('customerEmail').textContent = data.email;
            document.getElementById('customerContact').textContent = data.contact_number;
            document.getElementById('customerAddress').textContent = data.address;
            document.getElementById('orderDate').textContent = new Date(data.created_at).toLocaleString();
            document.getElementById('shippingMethod').textContent = data.shipping_method || 'Standard Delivery';

            // Update status badge
            const statusClass = data.shipping_status === 'PENDING' ? 'bg-warning' : 
                              data.shipping_status === 'ACCEPTED' ? 'bg-info' :
                              data.shipping_status === 'COMPLETED' ? 'bg-success' : 'bg-danger';
            document.getElementById('orderStatus').innerHTML = 
                `<span class="badge ${statusClass}">${data.shipping_status}</span>`;

            // Create order items table rows
            const itemsHtml = data.items.map(item => `
                <tr>
                    <td>${item.name}</td>
                    <td>₱${Number(item.unit_price).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                    <td>${item.quantity}</td>
                    <td class="text-end">₱${Number(item.total).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                </tr>
            `).join('');
            
            document.getElementById('orderItems').innerHTML = itemsHtml;
            document.getElementById('orderTotal').innerHTML = 
                `₱${Number(data.total).toLocaleString('en-US', {minimumFractionDigits: 2})}`;

            // Show/hide status update section
            const statusUpdateSection = document.getElementById('statusUpdateSection');
            statusUpdateSection.style.display = data.shipping_status !== 'CANCELLED' ? 'flex' : 'none';

            // Update status select options
            const statusSelect = document.getElementById('statusSelect');
            Array.from(statusSelect.options).forEach(option => {
                option.disabled = option.value === data.shipping_status;
            });
        })
        .catch(error => console.error('Error:', error));
}

function updateStatus() {
    const statusSelect = document.getElementById('statusSelect');
    const newStatus = statusSelect.value;
    
    if (!newStatus) {
        alert('Please select a status');
        return;
    }

    if (!confirm(`Are you sure you want to ${newStatus.toLowerCase()} this order?`)) return;

    fetch('../database/Controllers/update_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${currentOrderId}&status=${newStatus}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and reload page
            const modal = bootstrap.Modal.getInstance(document.getElementById('orderModal'));
            modal.hide();
            location.reload();
        } else {
            alert('Error updating order status');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Add this to your existing script section
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    function filterOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const orderText = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.badge');
            const statusText = statusBadge ? statusBadge.textContent : '';
            
            const matchesSearch = orderText.includes(searchTerm);
            const matchesStatus = !statusValue || statusText === statusValue;
            
            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterOrders);
    statusFilter.addEventListener('change', filterOrders);
});
</script>
    
</body>
</html>