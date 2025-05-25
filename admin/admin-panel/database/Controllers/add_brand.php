<?php
session_start();
require_once '../config.php';

try {
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['brand_name'])) {
        // Prepare the stored procedure call with output parameters
        $stmt = $pdo->prepare("CALL sp_add_brand(?, @success, @message)");
        $stmt->execute([$_POST['brand_name']]);
        
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
        // Set error message if no data received
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Brand name is required!'
        ];
    }
} catch (PDOException $e) {
    // Set error message
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error adding brand: ' . $e->getMessage()
    ];
}

// Redirect back to products page
header('Location: ../../views/products.php');
exit;