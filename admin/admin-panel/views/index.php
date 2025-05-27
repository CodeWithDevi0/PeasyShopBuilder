<?php
session_start();
require '../database/config.php';

try {
    // Get dashboard stats
    $stmt = $pdo->query("CALL sp_get_dashboard_stats()");
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // Important: close the cursor for next query

    // Get recent products
    $stmt = $pdo->query("CALL sp_get_recent_products()");
    $recentProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // Get weekly orders for chart
    $stmt = $pdo->query("CALL sp_get_weekly_orders()");
    $weeklyOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

} catch (PDOException $e) {
    error_log("Error fetching dashboard data: " . $e->getMessage());
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
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <!-- Total Sales Card -->
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Sales</h6>
                        <h4 class="mb-0 text-success">₱<?php echo number_format($stats['total_sales'], 2); ?></h4>
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
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-box-seam-fill text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Products</h6>
                        <?php
                        $productCount = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
                        ?>
                        <h4 class="mb-0 text-success"><?php echo number_format($productCount); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card border-success shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Orders This Week</h5>
        </div>
        <div class="card-body" style="padding-bottom: 40px;"> <!-- Added padding-bottom -->
            <div class="chart-container">
                <div class="bar-chart" id="barChart"></div>
            </div>
        </div>
    </div>

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

<!-- bar chart -->
<script>
    const data = <?php echo json_encode($weeklyOrders); ?>;
    const maxVal = Math.max(...data.map(d => d.value));
    const chart = document.getElementById("barChart");

    data.forEach(item => {
        const heightPercent = (item.value / maxVal) * 100;
        const height = (heightPercent * (chart.clientHeight - 60)) / 100; 

        const barItem = document.createElement("div");
        barItem.className = "bar-item";

        const bar = document.createElement("div");
        bar.className = "bar";
        bar.style.height = `${height}px`;

        const barValue = document.createElement("div");
        barValue.className = "bar-value";
        barValue.textContent = item.value;

        const barLabel = document.createElement("div");
        barLabel.className = "bar-label";
        barLabel.textContent = item.date;

        barItem.appendChild(bar);
        barItem.appendChild(barValue);
        barItem.appendChild(barLabel);
        chart.appendChild(barItem);
    });
</script>

</body>
</html>