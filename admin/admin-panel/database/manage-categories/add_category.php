<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$_POST['category_name']]);
        $_SESSION['success'] = "Category '{$_POST['category_name']}' added successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding category: " . ($e->errorInfo[1] == 1062 ? "This category already exists!" : $e->getMessage());
    }
    header('Location: ../../views/products.php');
    exit;
}