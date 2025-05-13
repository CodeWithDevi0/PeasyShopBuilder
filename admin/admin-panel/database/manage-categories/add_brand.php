<?php
require_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO brands (brand_name) VALUES (?)");
        $stmt->execute([$_POST['brand_name']]);
        $_SESSION['success'] = "Brand '{$_POST['brand_name']}' added successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error adding brand: " . ($e->errorInfo[1] == 1062 ? "This brand already exists!" : $e->getMessage());
    }
    header('Location: ../../views/products.php');
    exit;
}