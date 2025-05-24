<?php
session_start();
require_once '../config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate required fields
        if (empty($_POST['product_name']) || empty($_POST['brand_id']) || 
            empty($_POST['category_id']) || !isset($_POST['price'])) {
            throw new Exception('Please fill in all required fields');
        }

        // Check for duplicate product name
        $check = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = ?");
        $check->execute([$_POST['product_name']]);
        if ($check->fetchColumn() > 0) {
            throw new Exception('A product with this name already exists');
        }

        // Validate price format
        if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
            throw new Exception('Invalid price value');
        }

        // Handle image upload if present
        $image_path = null;
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../../uploads/products/';
            
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
        $stmt = $pdo->prepare("CALL sp_add_product(?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['product_name'],                    // name
            $_POST['brand_id'],                        // brand_id
            $_POST['category_id'],                     // category_id
            $_POST['stocks'] ?: null,                  // stocks (null if empty or 0)
            $_POST['price'],                           // price
            $_POST['description'] ?: null,             // description
            $image_path                                // image
        ]);

        $_SESSION['alert'] = [
            'type' => 'success',
            'message' => 'Product added successfully!'
        ];
    }
} catch (PDOException $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => 'Error adding product: ' . $e->getMessage()
    ];
} catch (Exception $e) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => $e->getMessage()
    ];
}

header('Location: ../../views/products.php');
exit;