<?php
function getDBConnection() {
    $db_host = "127.0.0.1";
    $db_username = "root";
    $db_password = "";
    $db_name = "peasy";
    $db_port = 3306;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    try {
        // ✅ Return the mysqli connection
        return new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
    } catch (Exception $e) {
        die("Database connection error: " . $e->getMessage());
    }
}
