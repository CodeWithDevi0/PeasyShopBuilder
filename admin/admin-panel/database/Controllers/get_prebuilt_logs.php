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
error_log("Executing prebuilt orders log query with parameters: search=$search, status=$status, date=$date");

$query = "SELECT 
            pl.log_id,
            pl.order_id,
            u.username,
            pl.action,
            pl.status,
            pl.total_price,
            pl.timestamp
          FROM prebuilt_order_logs pl
          LEFT JOIN users u ON pl.user_id = u.id
          WHERE 1=1";

if (!empty($search)) {
    $search = "%$search%";
    $query .= " AND (pl.order_id LIKE ? OR u.username LIKE ? OR pl.action LIKE ? OR pl.status LIKE ?)";
}

if (!empty($status)) {
    $query .= " AND pl.status = ?";
}

if (!empty($date)) {
    $query .= " AND DATE(pl.timestamp) = ?";
}

$query .= " ORDER BY pl.timestamp DESC";

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