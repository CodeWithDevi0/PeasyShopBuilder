<?php
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['orderId']) || !isset($data['status'])) {
    die(json_encode(['success' => false, 'message' => 'Missing required data']));
}

try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE pre_built_orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $data['status'], $data['orderId']);
    $success = $stmt->execute();

    echo json_encode(['success' => $success]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}