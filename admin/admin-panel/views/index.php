<?php
session_start();
require '../database/config.php';
require '../database/Controllers/get_dashboard_stats.php';

try {
    // Get all dashboard stats
    $dashboardStats = getAllDashboardStats();
    if (!$dashboardStats) {
        throw new Exception("Failed to get dashboard stats");
    }

    // Get recent products
    $stmt = $pdo->query("CALL sp_get_recent_products()");
    $recentProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // Get weekly orders for chart
    $stmt = $pdo->query("CALL sp_get_weekly_orders()");
    $weeklyOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

} catch (Exception $e) {
    error_log("Error in dashboard: " . $e->getMessage());
    die("An error occurred while loading the dashboard.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style-index.css">
    <title>Admin Panel</title>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar bg-success text-white" id="sidebar">
  <div class="sidebar-header p-3 border-bottom border-light-subtle">
    <h5><i class="bi bi-gear-fill me-2"></i>Admin Panel</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link text-white bg-success-emphasis" href="../views/index.php" style="font-weight: 700; background-color:rgb(26, 175, 106);">
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
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Order Type Filter -->
        <div class="col-12 mb-3">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <label class="me-3 mb-0">Filter Stats:</label>
                        <select id="orderTypeFilter" class="form-select w-auto" onchange="updateStatsDisplay()">
                            <option value="regular">Regular Orders</option>
                            <option value="prebuilt">Pre-Built Orders</option>
                        </select>
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
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats">₱<?php echo number_format($dashboardStats['orders']['total_revenue'], 2); ?></span>
                            <span class="prebuilt-stats" style="display: none;">₱<?php echo number_format($dashboardStats['pre_built']['total_revenue'], 2); ?></span>
                        </h4>
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
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats"><?php echo number_format($dashboardStats['orders']['total_orders']); ?></span>
                            <span class="prebuilt-stats" style="display: none;"><?php echo number_format($dashboardStats['pre_built']['total_count']); ?></span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-box-seam-fill text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Products</h6>
                        <h4 class="mb-0 text-success"><?php echo number_format($dashboardStats['products']['total_products']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats"><?php echo number_format($dashboardStats['orders']['pending_orders']); ?></span>
                            <span class="prebuilt-stats" style="display: none;"><?php echo number_format($dashboardStats['pre_built']['pending_count']); ?></span>
                        </h4>
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
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats"><?php echo number_format($dashboardStats['orders']['accepted_orders']); ?></span>
                            <span class="prebuilt-stats" style="display: none;"><?php echo number_format($dashboardStats['pre_built']['accepted_count']); ?></span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-all text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Completed Orders</h6>
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats"><?php echo number_format($dashboardStats['orders']['completed_orders']); ?></span>
                            <span class="prebuilt-stats" style="display: none;"><?php echo number_format($dashboardStats['pre_built']['completed_count']); ?></span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-x-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Cancelled Orders</h6>
                        <h4 class="mb-0 text-success">
                            <span class="regular-stats"><?php echo number_format($dashboardStats['orders']['cancelled_orders']); ?></span>
                            <span class="prebuilt-stats" style="display: none;"><?php echo number_format($dashboardStats['pre_built']['cancelled_count']); ?></span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-people-fill text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Users</h6>
                        <h4 class="mb-0 text-success"><?php echo number_format($dashboardStats['users']['total_users']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-person-fill-gear text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Admins</h6>
                        <h4 class="mb-0 text-success"><?php echo number_format($dashboardStats['users']['total_admins']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card border-success shadow-sm mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Completed Orders This Week</h5>
            <div class="d-flex align-items-center">
                <small class="text-light me-3" id="lastUpdate"></small>
                <div class="chart-type-toggle">
                    <button class="btn btn-outline-light btn-sm active" onclick="toggleChartData('regular')">Regular Orders</button>
                    <button class="btn btn-outline-light btn-sm" onclick="toggleChartData('prebuilt')">Pre-Built Orders</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
    let weeklyStats = <?php echo json_encode($dashboardStats['weekly_stats']); ?>;
    let currentChart = null;
    let currentType = 'regular';

    function createChart(type) {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const data = weeklyStats[type];
        
        // If there's an existing chart, destroy it
        if (currentChart) {
            currentChart.destroy();
        }

        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.date),
                datasets: [{
                    label: type === 'regular' ? 'Completed Regular Orders' : 'Completed Pre-Built Orders',
                    data: data.map(item => item.count),
                    backgroundColor: 'rgba(25, 135, 84, 0.2)',
                    borderColor: 'rgb(25, 135, 84)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Completed Orders (Last 7 Days)',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Completed Orders: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Update last update time
        const lastUpdate = new Date(weeklyStats.last_update);
        document.getElementById('lastUpdate').textContent = `Last updated: ${lastUpdate.toLocaleTimeString()}`;
    }

    function toggleChartData(type) {
        currentType = type;
        // Update button states
        document.querySelectorAll('.chart-type-toggle button').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        // Update chart
        createChart(type);
    }

    // Function to refresh chart data
    async function refreshChartData() {
        try {
            const response = await fetch('../database/Controllers/get_weekly_stats.php');
            const newData = await response.json();
            weeklyStats = newData;
            createChart(currentType);
        } catch (error) {
            console.error('Error refreshing chart data:', error);
        }
    }

    // Initialize with regular orders
    createChart('regular');

    // Refresh data every 5 minutes
    setInterval(refreshChartData, 300000);

    // Refresh on window focus
    window.addEventListener('focus', refreshChartData);

    // Handle responsive resize
    window.addEventListener('resize', () => {
        if (currentChart) {
            currentChart.resize();
        }
    });
    </script>

    <!-- Products Table -->
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Products</h5>
            <a href="products.php" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Product</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-4">ID</th>
                            <th class="py-3">Product Name</th>
                            <th class="py-3">Brand</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Stocks</th>
                            <th class="py-3 text-center pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentProducts as $row): ?>
                            <?php
                            $stockStatus = ($row['stocks'] > 0) ? 
                                '<span class="badge bg-success">In Stock</span>' : 
                                '<span class="badge bg-danger">Out of Stock</span>';
                            
                            $brandName = $row['brand_name'] ?? 'N/A';
                            $categoryName = $row['category_name'] ?? 'N/A';
                            ?>
                            <tr>
                                <td class='ps-4 text-success'><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($brandName); ?></td>
                                <td><?php echo htmlspecialchars($categoryName); ?></td>
                                <td><?php echo $row['stocks']; ?></td>
                                <td class='text-center pe-3'><?php echo $stockStatus; ?></td>
                            </tr>
                        <?php endforeach; ?>
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

<script>
function updateStatsDisplay() {
    const filterValue = document.getElementById('orderTypeFilter').value;
    
    // Hide all stats first
    document.querySelectorAll('.regular-stats, .prebuilt-stats').forEach(el => {
        el.style.display = 'none';
    });
    
    // Show the selected stats
    const statsToShow = filterValue === 'regular' ? '.regular-stats' : '.prebuilt-stats';
    document.querySelectorAll(statsToShow).forEach(el => {
        el.style.display = 'inline';
    });
}
</script>

</body>
</html>