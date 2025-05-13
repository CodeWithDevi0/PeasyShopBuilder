<?php
require_once '../database/database.php';
session_start();

$conn = getDBConnection();

// ✅ Validate order_id from URL
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "<div style='padding: 2rem; font-family: sans-serif; color: red;'>❌ Invalid or missing Order ID.</div>";
    exit;
}

$order_id = intval($_GET['order_id']);

// ✅ Fetch order
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
if (!$order) {
    echo "<div style='padding: 2rem; font-family: sans-serif; color: red;'>❌ Order not found for ID: $order_id</div>";
    exit;
}

// ✅ Fetch order items
$items = $conn->query("
    SELECT p.name, oi.quantity, oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Receipt #<?= $order_id ?></title>
    <link rel="stylesheet" href="../guest/index.css">
    <link rel="stylesheet" href="../guest/priceList.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>@media print { .no-print { display: none; } }</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-success px-4 py-2">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="">
                <img src="../assets/nobg.png" alt="Logo" width="60" height="60" class="me-2">
                <strong class="text-white">PEasy</strong>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="userCart.php"><i class="bi bi-cart fs-4"></i></a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="printReceipt.php"><i class="bi bi-chat-left fs-4"></i></a>
                    </li>
                    <li class="nav-item mx-2 ">
                        <a class="nav-link text-white d-flex align-items-center just"
                            href="<?php echo isset($_SESSION['user_logged_in']) ? 'profile.php' : '/Authentication/signIn/login.php'; ?>">
                            <i class="bi bi-person-circle fs-4 mx-2"></i>
                            <span>
                                <?php
            if (isset($_SESSION['user_logged_in']) && isset($_SESSION['user_firstname'])) {
                echo htmlspecialchars($_SESSION['user_firstname']);
            } else {
                echo 'Login';
            }
            ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
</nav>

<div class="container my-4">
    <div class="card p-4">
        <h3 class="bi bi-calendar text-center text-success"> Order Receipt</h3>
        <p class="text-end"><strong>Order ID:</strong> <?= $order_id ?></p>
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>

        <table class="table table-bordered mt-3">
            <thead>
                <tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
            <?php while ($row = $items->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>₱<?= number_format($row['price'], 2) ?></td>
                    <td>₱<?= number_format($row['quantity'] * $row['price'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h5 class="mt-4 text-end">Total: ₱<?= number_format($order['total'], 2) ?></h5>

        <div class="mt-4 text-end">
            <a href="index.php" class="btn btn-danger no-print">Back to Shop</a>
            <button onclick="window.print()" class="btn btn-success no-print">Print Receipt</button>
        </div>
    </div>
</div>
</body>
</html>
