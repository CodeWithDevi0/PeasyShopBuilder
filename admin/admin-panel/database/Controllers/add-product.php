<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_product'])) {
    try {
        $pdo->beginTransaction();

        // Handle image upload
        $image_path = null;
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
            $upload_dir = '../../images/products/';
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
            
            if (!move_uploaded_file($_FILES['product_image']['tmp_name'], '../../' . $image_path)) {
                throw new Exception('Failed to upload image.');
            }
        }

        // Insert product
        $stmt = $pdo->prepare("
            INSERT INTO products (
                product_name, 
                brand_id,
                category_id,
                description,
                price,
                stocks,
                image_path,
                status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 1)
        ");

        $stmt->execute([
            $_POST['product_name'],
            $_POST['brand'],
            $_POST['category'],
            $_POST['description'],
            $_POST['price'],
            $_POST['stocks'],
            $image_path
        ]);

        $pdo->commit();
        $_SESSION['success'] = "Product added successfully!";

    } catch (PDOException $e) {
        $pdo->rollBack();
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['error'] = "A product with this name already exists!";
        } else {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
        }
        error_log($e->getMessage());
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = $e->getMessage();
        error_log($e->getMessage());
    }

    header('Location: ../../views/products.php');
    exit;
}
?>