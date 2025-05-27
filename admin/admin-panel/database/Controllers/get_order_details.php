<?php
require_once '../config.php';

try {
    if (!isset($_GET['id'])) {
        throw new Exception('Order ID is required');
    }

    $stmt = $pdo->prepare("SELECT * FROM vw_orders WHERE order_id = ?");
    $stmt->execute([$_GET['id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($order);

} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}