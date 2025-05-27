<?php
require_once '../config.php';
header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('Order ID is required');
    }

    // Get main order details
    $stmt = $pdo->prepare("SELECT * FROM vw_orders WHERE order_id = ?");
    $stmt->execute([$_GET['id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        // Convert comma-separated strings to arrays
        $order['product_names'] = explode(', ', $order['product_names']);
        $order['quantities'] = explode(', ', $order['quantities']);
        $order['unit_prices'] = explode(', ', $order['unit_prices']);
        $order['item_totals'] = explode(', ', $order['item_totals']);

        // Create items array
        $order['items'] = array_map(function($name, $qty, $price, $total) {
            return [
                'name' => $name,
                'quantity' => $qty,
                'unit_price' => $price,
                'total' => $total
            ];
        }, $order['product_names'], $order['quantities'], $order['unit_prices'], $order['item_totals']);

        // Remove the arrays we no longer need
        unset($order['product_names']);
        unset($order['quantities']);
        unset($order['unit_prices']);
        unset($order['item_totals']);
    }

    echo json_encode($order);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}