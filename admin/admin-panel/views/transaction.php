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
    <title>Transaction Logs</title>
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
            
            <!-- Toggle Buttons -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-success active" id="ordersLogBtn">
                            <i class="bi bi-cart-check me-2"></i>Orders Logs
                        </button>
                        <button type="button" class="btn btn-outline-success" id="prebuiltLogBtn">
                            <i class="bi bi-pc-display me-2"></i>Pre-built Orders Logs
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Row -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="search" class="form-control border-success" id="searchInput" placeholder="Search transactions...">
                </div>
                <div class="col-md-3">
                    <select class="form-select border-success" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="PENDING">Pending</option>
                        <option value="ACCEPTED">Accepted</option>
                        <option value="COMPLETED">Completed</option>
                        <option value="CANCELLED">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control border-success" id="dateFilter">
                </div>
            </div>

            <!-- Orders Log Table -->
            <div class="table-responsive" id="ordersLogTable">
                <table class="table table-hover border" style="min-width: 800px;">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-3">Order ID</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Action</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody id="ordersLogBody">
                        <!-- Will be populated by AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Pre-built Orders Log Table -->
            <div class="table-responsive" id="prebuiltLogTable" style="display: none;">
                <table class="table table-hover border" style="min-width: 800px;">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-3">Order ID</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Action</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody id="prebuiltLogBody">
                        <!-- Will be populated by AJAX -->
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

<!-- Add this before closing body tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ordersLogBtn = document.getElementById('ordersLogBtn');
    const prebuiltLogBtn = document.getElementById('prebuiltLogBtn');
    const ordersLogTable = document.getElementById('ordersLogTable');
    const prebuiltLogTable = document.getElementById('prebuiltLogTable');

    // Load orders log by default
    console.log('Page loaded, attempting to load order logs...');
    loadOrdersLog();

    ordersLogBtn.addEventListener('click', function() {
        ordersLogBtn.classList.add('active');
        ordersLogBtn.classList.remove('btn-outline-success');
        ordersLogBtn.classList.add('btn-success');
        prebuiltLogBtn.classList.remove('active');
        prebuiltLogBtn.classList.add('btn-outline-success');
        prebuiltLogBtn.classList.remove('btn-success');
        ordersLogTable.style.display = 'block';
        prebuiltLogTable.style.display = 'none';
        loadOrdersLog();
    });

    prebuiltLogBtn.addEventListener('click', function() {
        prebuiltLogBtn.classList.add('active');
        prebuiltLogBtn.classList.remove('btn-outline-success');
        prebuiltLogBtn.classList.add('btn-success');
        ordersLogBtn.classList.remove('active');
        ordersLogBtn.classList.add('btn-outline-success');
        ordersLogBtn.classList.remove('btn-success');
        prebuiltLogTable.style.display = 'block';
        ordersLogTable.style.display = 'none';
        loadPrebuiltLog();
    });

    // Add event listeners for filters
    document.getElementById('searchInput').addEventListener('input', handleFilters);
    document.getElementById('statusFilter').addEventListener('change', handleFilters);
    document.getElementById('dateFilter').addEventListener('change', handleFilters);
});

function handleFilters() {
    if (document.getElementById('ordersLogTable').style.display !== 'none') {
        loadOrdersLog();
    } else {
        loadPrebuiltLog();
    }
}

function loadOrdersLog() {
    const searchValue = document.getElementById('searchInput').value;
    const statusValue = document.getElementById('statusFilter').value;
    const dateValue = document.getElementById('dateFilter').value;

    // Add loading indicator
    const tbody = document.getElementById('ordersLogBody');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';

    fetch(`../database/Controllers/get_order_logs.php?search=${searchValue}&status=${statusValue}&date=${dateValue}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Orders Log Data:', data);
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No records found</td></tr>';
                return;
            }
            
            data.forEach(log => {
                tbody.innerHTML += `
                    <tr>
                        <td>#${log.order_id}</td>
                        <td>${log.username || 'N/A'}</td>
                        <td><span class="badge bg-${getActionBadgeColor(log.action_type)}">${log.action_type}</span></td>
                        <td><span class="badge bg-${getStatusBadgeColor(log.shipping_status)}">${log.shipping_status}</span></td>
                        <td>₱${parseFloat(log.total_amount).toLocaleString()}</td>
                        <td>${formatDate(log.action_timestamp)}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading data: ${error.message}</td></tr>`;
        });
}

function getActionBadgeColor(action) {
    switch(action) {
        case 'CREATED': return 'success';
        case 'UPDATED': return 'info';
        case 'DELETED': return 'danger';
        default: return 'secondary';
    }
}

function getStatusBadgeColor(status) {
    switch(status) {
        case 'PENDING': return 'warning';
        case 'ACCEPTED': return 'info';
        case 'COMPLETED': return 'success';
        case 'CANCELLED': return 'danger';
        default: return 'secondary';
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: '2-digit',
        hour: '2-digit', 
        minute: '2-digit'
    });
}

function loadPrebuiltLog() {
    const searchValue = document.getElementById('searchInput').value;
    const statusValue = document.getElementById('statusFilter').value;
    const dateValue = document.getElementById('dateFilter').value;

    // Add loading indicator
    const tbody = document.getElementById('prebuiltLogBody');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';

    fetch(`../database/Controllers/get_prebuilt_logs.php?search=${searchValue}&status=${statusValue}&date=${dateValue}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Prebuilt Log Data:', data);
            tbody.innerHTML = '';
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No records found</td></tr>';
                return;
            }
            
            data.forEach(log => {
                tbody.innerHTML += `
                    <tr>
                        <td>#${log.order_id}</td>
                        <td>${log.username || 'N/A'}</td>
                        <td><span class="badge bg-info">${log.action}</span></td>
                        <td><span class="badge bg-${getStatusBadgeColor(log.status)}">${log.status}</span></td>
                        <td>₱${parseFloat(log.total_price).toLocaleString()}</td>
                        <td>${formatDate(log.timestamp)}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading data: ${error.message}</td></tr>`;
        });
}
</script>
</body>
</html>