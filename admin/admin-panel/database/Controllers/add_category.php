<?php
session_start();
require_once '../config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['category_name'])) {
        // Prepare the stored procedure call with output parameters
        $stmt = $pdo->prepare("CALL sp_add_category(?, @success, @message)");
        $stmt->execute([$_POST['category_name']]);
        
        // Get the output parameters
        $result = $pdo->query("SELECT @success as success, @message as message")->fetch();
        
        if ($result['success']) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => $result['message']
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => $result['message']
            ];
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Category name is required!'
        ];
    }
} catch (PDOException $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error adding category: ' . $e->getMessage()
    ];
}

header('Location: ../../views/products.php');
exit;