<?php
session_start();
require_once '../config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_id'])) {
        $stmt = $pdo->prepare("CALL sp_delete_product(?)");
        $stmt->execute([$_POST['product_id']]);
        
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Product deleted successfully!'
        ];
    } else {
        throw new Exception('Invalid request');
    }
} catch (PDOException $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error deleting product: ' . $e->getMessage()
    ];
}

header('Location: ../../views/products.php');
exit;