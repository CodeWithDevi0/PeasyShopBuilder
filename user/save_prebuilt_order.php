<?php
require_once '../database/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

// Get JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    die(json_encode(['success' => false, 'message' => 'Invalid data received']));
}

try {
    $conn = getDBConnection();
    
    // Calculate total price
    $totalPrice = array_sum(array_column($data, 'price'));
    
    // Create main order using stored procedure
    $stmt = $conn->prepare("CALL sp_create_prebuilt_order(?, ?)");
    $stmt->bind_param("id", $_SESSION['user_id'], $totalPrice);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $orderId = $row['order_id'];
    $stmt->close();
    
    // Add order items using stored procedure
    $stmt = $conn->prepare("CALL sp_add_prebuilt_order_item(?, ?, ?, ?)");
    
    foreach ($data as $categoryId => $item) {
        $stmt->bind_param("iiid", 
            $orderId, 
            $item['productId'], 
            $categoryId, 
            $item['price']
        );
        $stmt->execute();
    }
    
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();