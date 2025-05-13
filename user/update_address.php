<?php
session_start();
require_once '../database/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $address = trim($_POST['address'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');

    if ($user_id && !empty($address) && !empty($contact_number)) {
        $conn = getDBConnection();
        $stmt = $conn->prepare("UPDATE users_profile SET address = ?, contact_number = ? WHERE users_id = ?");
        $stmt->bind_param("ssi", $address, $contact_number, $user_id);
        $stmt->execute();
    }

    header("Location: profile.php#addresses");
    exit();
}
?>

