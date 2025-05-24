<?php
session_start();
require_once '../config.php';

try {
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("CALL sp_toggle_category_status(?)");
        $stmt->execute([$_GET['id']]);
        
        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Category status updated successfully!'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Category ID is required!'
        ];
    }
} catch (PDOException $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error updating category status: ' . $e->getMessage()
    ];
}

header('Location: ../../views/products.php');
exit;