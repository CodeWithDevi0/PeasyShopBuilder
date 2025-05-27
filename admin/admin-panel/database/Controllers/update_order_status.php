<?php
require_once '../config.php';
header('Content-Type: application/json');

try {
    // Check if required parameters are present
    if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
        throw new Exception('Order ID and status are required');
    }

    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Validate status values
    $allowedStatuses = ['PENDING', 'ACCEPTED', 'COMPLETED', 'CANCELLED'];
    if (!in_array($status, $allowedStatuses)) {
        throw new Exception('Invalid status value');
    }

    // Update the order status - logging will be handled by trigger
    $stmt = $pdo->prepare("UPDATE orders SET shipping_status = ? WHERE id = ?");
    $result = $stmt->execute([$status, $orderId]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>