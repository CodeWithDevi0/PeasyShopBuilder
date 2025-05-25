<?php
session_start();
require_once '../config.php';

try {
    // Handle image upload if present
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../../../uploads/";
        $fileName = time() . '_' . basename($_FILES["image"]["name"]);
        $targetPath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            $imagePath = "uploads/" . $fileName;
        }
    }

    // Call the stored procedure
    $stmt = $pdo->prepare("CALL sp_update_product(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $status = isset($_POST['status']) ? 1 : 0;
    
    $stmt->execute([
        $_POST['id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['brand_id'],
        $_POST['category_id'],
        $_POST['stocks'],
        $imagePath,
        $status
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Product updated successfully'
    ]);

} catch (PDOException $e) {
    error_log("Error updating product: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Failed to update product'
    ]);
}
?>