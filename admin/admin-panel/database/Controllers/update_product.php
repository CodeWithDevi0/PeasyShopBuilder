<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Debug: Log received data
        error_log("Updating product ID: " . $_POST['product_id']);
        error_log("POST data: " . print_r($_POST, true));

        // Handle image upload if provided
        $image_path = null;
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
            $upload_dir = '../../../images/products/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['product_image']['type'], $allowed_types)) {
                throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed.');
            }
            
            $file_extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_extension;
            $image_path = 'images/products/' . $file_name;
            
            if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $file_name)) {
                throw new Exception('Failed to upload image.');
            }

            // Delete old image if exists
            $stmt = $pdo->prepare("SELECT image_path FROM products WHERE product_id = ?");
            $stmt->execute([$_POST['product_id']]);
            $old_image = $stmt->fetchColumn();
            if ($old_image && file_exists('../../../' . $old_image)) {
                unlink('../../../' . $old_image);
            }
        }

        // Verify the product exists
        $checkStmt = $pdo->prepare("SELECT product_id FROM products WHERE product_id = ?");
        $checkStmt->execute([$_POST['product_id']]);
        if (!$checkStmt->fetch()) {
            throw new Exception("Product not found");
        }

        
        // [Update Query] The trigger will handle the inventory logging automatically
        $stmt = $pdo->prepare("
            UPDATE products 
            SET product_name = :name,
                brand_id = :brand,
                category_id = :category,
                description = :description,
                price = :price,
                stocks = :stocks
            WHERE product_id = :id
        ");
        
        // Bind parameters
        $params = [
            ':name' => $_POST['product_name'],
            ':brand' => $_POST['brand'],
            ':category' => $_POST['category'],
            ':description' => $_POST['description'],
            ':price' => $_POST['price'],
            ':stocks' => $_POST['stocks'],
            ':id' => $_POST['product_id']
        ];
        
        if ($image_path !== null) {
            $params[':image'] = $image_path;
        }

        // Execute update
        if (!$stmt->execute($params)) {
            throw new Exception("Failed to update product: " . implode(", ", $stmt->errorInfo()));
        }

        // Verify update was successful
        if ($stmt->rowCount() === 0) {
            throw new Exception("No changes made to the product");
        }

        $pdo->commit();
        echo json_encode([
            'success' => true, 
            'message' => 'Product updated successfully',
            'product_id' => $_POST['product_id']
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Update error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}