<?php
session_start();
require_once '../config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        if (empty($_POST['product_id']) || empty($_POST['product_name']) || 
            empty($_POST['brand_id']) || empty($_POST['category_id']) || 
            !isset($_POST['price'])) {
            throw new Exception('Please fill in all required fields');
        }

        // Validate price format
        if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
            throw new Exception('Invalid price value');
        }

        // Handle image upload if present
        $image_path = null;
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/products/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            // Validate image file
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($file_extension, $allowed_types)) {
                throw new Exception('Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.');
            }

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path)) {
                $image_path = 'uploads/products/' . $new_filename;
            }
        }

        // Prepare and execute stored procedure
        $stmt = $pdo->prepare("CALL sp_edit_product(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['product_id'],           // id
            $_POST['product_name'],         // name
            $_POST['brand_id'],             // brand_id
            $_POST['category_id'],          // category_id
            $_POST['stocks'] ?: null,       // stocks (null if empty)
            $_POST['price'],                // price
            $_POST['description'] ?: null,   // description (null if empty)
            $image_path,                    // image (null if no new image)
            isset($_POST['status']) ? 1 : 0 // status (1 if checked, 0 if unchecked)
        ]);

        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Product updated successfully!'
        ];
    } else {
        throw new Exception('Invalid request method');
    }
} catch (PDOException $e) {
    if ($e->getCode() == '45000') {  // Custom error from stored procedure
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => $e->getMessage()
        ];
    } else if ($e->getCode() == '23000') {  // Duplicate entry error
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'A product with this name already exists'
        ];
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
} catch (Exception $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error updating product: ' . $e->getMessage()
    ];
}

header('Location: ../../views/products.php');
exit;