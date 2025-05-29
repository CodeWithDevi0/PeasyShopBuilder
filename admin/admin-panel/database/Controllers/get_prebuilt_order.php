<?php
require_once '../config.php';

if (!isset($_GET['id'])) {
    die(json_encode(['error' => 'No order ID provided']));
}

$orderId = $_GET['id'];
$conn = getDBConnection();

try {
    // Get order details with user info - updated to match database structure
    $stmt = $conn->prepare("
        SELECT po.*, 
               u.username, u.email, u.f_name, u.l_name,
               up.contact_number
        FROM pre_built_orders po
        JOIN users u ON po.user_id = u.id
        LEFT JOIN users_profile up ON u.id = up.users_id
        WHERE po.id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Get order items with full details
    $stmt = $conn->prepare("
        SELECT poi.*, 
               p.name as product_name,
               p.price,
               c.category_name
        FROM pre_built_order_items poi
        JOIN products p ON poi.product_id = p.id
        JOIN categories c ON poi.category_id = c.category_id
        WHERE poi.pre_built_order_id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $order['items'] = $items;
    
    // Debug output
    error_log("Order details: " . print_r($order, true));
    
    echo json_encode($order);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}