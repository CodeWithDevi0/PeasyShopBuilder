<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/get_dashboard_stats.php';

header('Content-Type: application/json');

try {
    $stats = getWeeklyOrderStats();
    echo json_encode($stats);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch weekly stats']);
} 