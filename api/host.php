<?php
$host = 'localhost';
$dbname = 'dolphin_crm';
$username = 'root'; // Update appropriately
$password = '';     // Update appropriately

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>