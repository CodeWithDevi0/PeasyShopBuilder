<?php
require_once __DIR__ . '/../config.php';

function getTotalUsers() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 0")->fetchColumn();
}

function getTotalAdmins() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1")->fetchColumn();
}

function getOrderStats() {
    global $pdo;
    
    // Get the latest status for each order
    $stats = $pdo->query("
        WITH LatestStatus AS (
            SELECT 
                order_id,
                shipping_status,
                total_amount,
                ROW_NUMBER() OVER (PARTITION BY order_id ORDER BY action_timestamp DESC) as rn
            FROM orders_logs
        )
        SELECT 
            COUNT(DISTINCT order_id) as total_orders,
            COUNT(DISTINCT CASE WHEN shipping_status = 'PENDING' THEN order_id END) as pending_orders,
            COUNT(DISTINCT CASE WHEN shipping_status = 'ACCEPTED' THEN order_id END) as accepted_orders,
            COUNT(DISTINCT CASE WHEN shipping_status = 'COMPLETED' THEN order_id END) as completed_orders,
            COUNT(DISTINCT CASE WHEN shipping_status = 'CANCELLED' THEN order_id END) as cancelled_orders,
            COALESCE(SUM(DISTINCT CASE WHEN shipping_status = 'COMPLETED' THEN total_amount ELSE 0 END), 0) as total_revenue
        FROM LatestStatus
        WHERE rn = 1
    ")->fetch(PDO::FETCH_ASSOC);

    return $stats ?: [
        'total_orders' => 0,
        'pending_orders' => 0,
        'accepted_orders' => 0,
        'completed_orders' => 0,
        'cancelled_orders' => 0,
        'total_revenue' => 0
    ];
}

function getPreBuiltStats() {
    global $pdo;
    
    // Get the latest status for each pre-built order
    $stats = $pdo->query("
        WITH LatestStatus AS (
            SELECT 
                order_id,
                status,
                total_price,
                ROW_NUMBER() OVER (PARTITION BY order_id ORDER BY timestamp DESC) as rn
            FROM prebuilt_order_logs
        )
        SELECT 
            COUNT(DISTINCT order_id) as total_count,
            COUNT(DISTINCT CASE WHEN status = 'PENDING' THEN order_id END) as pending_count,
            COUNT(DISTINCT CASE WHEN status = 'ACCEPTED' THEN order_id END) as accepted_count,
            COUNT(DISTINCT CASE WHEN status = 'COMPLETED' THEN order_id END) as completed_count,
            COUNT(DISTINCT CASE WHEN status = 'CANCELLED' THEN order_id END) as cancelled_count,
            COALESCE(SUM(DISTINCT CASE WHEN status = 'COMPLETED' THEN total_price ELSE 0 END), 0) as total_revenue
        FROM LatestStatus
        WHERE rn = 1
    ")->fetch(PDO::FETCH_ASSOC);

    return $stats ?: [
        'total_count' => 0,
        'pending_count' => 0,
        'accepted_count' => 0,
        'completed_count' => 0,
        'cancelled_count' => 0,
        'total_revenue' => 0
    ];
}

function getProductStats() {
    global $pdo;
    return [
        'total_products' => $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn()
    ];
}

function getAllDashboardStats() {
    return [
        'users' => [
            'total_users' => getTotalUsers(),
            'total_admins' => getTotalAdmins()
        ],
        'orders' => getOrderStats(),
        'pre_built' => getPreBuiltStats(),
        'products' => getProductStats()
    ];
}
?> 