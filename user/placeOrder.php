<?php
require_once '../database/database.php';
session_start();

$conn = getDBConnection();
$user_id = $_SESSION['user_id'] ?? 0;

if (!$user_id) {
    die("Unauthorized access. Please log in.");
}

// Handle checkout form submission (from userCart.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $address = $_POST['address'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';

    if (empty($address) || empty($contact_number)) {
        die("Missing required checkout fields.");
    }

    // Get cart items
    $cartItems = [];
    $total = 0;
    $stmt = $conn->prepare("SELECT p.*, uc.quantity FROM user_cart uc JOIN products p ON uc.product_id = p.id WHERE uc.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $cartItems[] = $row;
        $total += $row['subtotal'];
    }
    $stmt->close();

    if (empty($cartItems)) {
        die("Your cart is empty.");
    }

    // Save order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, address, contact_number, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("idss", $user_id, $total, $address, $contact_number);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Save items
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmtItem->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmtItem->execute();
    }
    $stmtItem->close();

    // Clear user's cart
    $stmt = $conn->prepare("DELETE FROM user_cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to receipt
    header("Location: placeOrder.php?order_id=" . $order_id);
    exit;
}

// Show receipt if redirected
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Fetch order
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$order) {
        die("Order not found.");
    }

    // Fetch items
    $stmt = $conn->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $deliveryDate = date("F j, Y", strtotime($order['created_at'] . " +3 days"));
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Order Receipt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
    <div class="container mt-5" style="width: 40%;">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="text-center">Thank you for your order!</h3>
            </div>
            <div class="card-body">
                <p style="display: flex; justify-content: space-between; width: 100%;"><strong>Order ID:</strong> <?= $order['id'] ?></p>
                <p style="display: flex; justify-content: space-between; width: 100%;"><strong>Total:</strong> ₱<?= number_format($order['total'], 2) ?></p>
                <p style="display: flex; justify-content: space-between; width: 100%;"><strong>Delivery Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p style="display: flex; justify-content: space-between; width: 100%;"><strong>Contact Number:</strong> <?= htmlspecialchars($order['contact_number']) ?></p>
                <p style="display: flex; justify-content: space-between; width: 100%;"><strong>Estimated Delivery Date:</strong> <?= $deliveryDate ?></p>

                <h5 class="mt-4">Order Summary:</h5>
                <table class="table table-bordered mt-3">
                    <thead class="table-success">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>₱<?= number_format($item['price'], 2) ?></td>
                                <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-end">
                    <a href="userCart.php" class="btn btn-outline-danger mt-3">Back to Shop</a>
                    <a href="profile.php" class="btn btn-outline-success mt-3">Show All Orders</a>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// fallback: show orders list (optional)
header("Location: printReceipt.php"); // or your original order history page
exit;
