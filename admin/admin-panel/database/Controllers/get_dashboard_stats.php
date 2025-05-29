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

function getWeeklyOrderStats() {
    global $pdo;
    
    // Get dates for the last 7 days
    $dates = [];
    for ($i = 6; $i >= 0; $i--) {
        $dates[] = date('Y-m-d', strtotime("-$i days"));
    }
    
    // Get completed regular orders
    $regularOrders = $pdo->query("
        WITH LatestStatus AS (
            SELECT 
                order_id,
                shipping_status,
                DATE(action_timestamp) as order_date,
                ROW_NUMBER() OVER (PARTITION BY order_id ORDER BY action_timestamp DESC) as rn
            FROM orders_logs
            WHERE action_timestamp >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
        )
        SELECT 
            order_date,
            COUNT(DISTINCT order_id) as count
        FROM LatestStatus
        WHERE rn = 1 
        AND shipping_status = 'COMPLETED'
        GROUP BY order_date
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Get completed pre-built orders
    $prebuiltOrders = $pdo->query("
        WITH LatestStatus AS (
            SELECT 
                order_id,
                status,
                DATE(timestamp) as order_date,
                ROW_NUMBER() OVER (PARTITION BY order_id ORDER BY timestamp DESC) as rn
            FROM prebuilt_order_logs
            WHERE timestamp >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
        )
        SELECT 
            order_date,
            COUNT(DISTINCT order_id) as count
        FROM LatestStatus
        WHERE rn = 1 
        AND status = 'COMPLETED'
        GROUP BY order_date
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Convert to lookup arrays
    $regularLookup = array_column($regularOrders, 'count', 'order_date');
    $prebuiltLookup = array_column($prebuiltOrders, 'count', 'order_date');

    // Build final arrays with all dates
    $regularData = [];
    $prebuiltData = [];
    foreach ($dates as $date) {
        $displayDate = date('M d', strtotime($date));
        $regularData[] = [
            'date' => $displayDate,
            'count' => isset($regularLookup[$date]) ? (int)$regularLookup[$date] : 0
        ];
        $prebuiltData[] = [
            'date' => $displayDate,
            'count' => isset($prebuiltLookup[$date]) ? (int)$prebuiltLookup[$date] : 0
        ];
    }

    return [
        'regular' => $regularData,
        'prebuilt' => $prebuiltData,
        'last_update' => date('Y-m-d H:i:s')
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
        'products' => getProductStats(),
        'weekly_stats' => getWeeklyOrderStats()
    ];
}
?> 