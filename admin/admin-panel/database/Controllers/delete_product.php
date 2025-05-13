<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    try {
        $pdo->beginTransaction();

        // Get product info for image deletion
        $stmt = $pdo->prepare("SELECT image_path FROM products WHERE product_id = ?");
        $stmt->execute([$_POST['product_id']]);
        $product = $stmt->fetch();

        // First delete related inventory logs
        $stmt = $pdo->prepare("DELETE FROM inventory_logs WHERE product_id = ?");
        $stmt->execute([$_POST['product_id']]);

        // Then delete the product
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$_POST['product_id']]);

        // Delete image file if exists
        if ($product && $product['image_path']) {
            $image_path = '../../../' . $product['image_path'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $pdo->commit();
        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);

    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log('Delete product error: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Database error: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log('Delete product error: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request'
    ]);
}