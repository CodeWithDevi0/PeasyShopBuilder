<?php
require_once '../config.php';
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT p.*, b.brand_name, c.category_name 
            FROM products p
            LEFT JOIN brands b ON p.brand_id = b.brand_id
            LEFT JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id = ?
        ");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>