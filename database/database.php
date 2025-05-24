<?php
function getDBConnection($type = 'mysqli') {
    $db_host = "127.0.0.1";
    $db_username = "root";
    $db_password = "";
    $db_name = "peasy";  // We'll use one database name
    $db_port = 3306;

    try {
        if ($type === 'pdo') {
            // Return PDO connection (for admin panel)
            $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_username, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } else {
            // Return mysqli connection (for user/guest pages)
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            return new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
        }
    } catch (Exception $e) {
        die("Database connection error: " . $e->getMessage());
    }
}
