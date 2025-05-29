<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';

// Verify database connection
if (!isset($pdo)) {
    http_response_code(500);
    die(json_encode(['error' => 'Database connection not established']));
}

header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Debug log
error_log("Executing orders log query with parameters: search=$search, status=$status, date=$date");

$query = "SELECT 
            ol.log_id,
            ol.order_id,
            u.username,
            ol.action_type,
            ol.total_amount,
            ol.shipping_status,
            ol.shipping_address,
            ol.contact_number,
            ol.shipping_method,
            ol.action_timestamp
          FROM orders_logs ol
          LEFT JOIN users u ON ol.user_id = u.id
          WHERE 1=1";

if (!empty($search)) {
    $search = "%$search%";
    $query .= " AND (ol.order_id LIKE ? OR u.username LIKE ? OR ol.action_type LIKE ? OR ol.shipping_status LIKE ?)";
}

if (!empty($status)) {
    $query .= " AND ol.shipping_status = ?";
}

if (!empty($date)) {
    $query .= " AND DATE(ol.action_timestamp) = ?";
}

$query .= " ORDER BY ol.action_timestamp DESC";

try {
    $stmt = $pdo->prepare($query);
    
    $paramIndex = 1;
    if (!empty($search)) {
        $stmt->bindValue($paramIndex++, $search);
        $stmt->bindValue($paramIndex++, $search);
        $stmt->bindValue($paramIndex++, $search);
        $stmt->bindValue($paramIndex++, $search);
    }
    if (!empty($status)) {
        $stmt->bindValue($paramIndex++, $status);
    }
    if (!empty($date)) {
        $stmt->bindValue($paramIndex++, $date);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug log
    error_log("Query returned " . count($results) . " results");
    
    echo json_encode($results);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 