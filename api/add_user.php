<?php
session_start();
require 'host.php';

// Security Check: Only Admins can add users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "Access Denied";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$firstname, $lastname, $email, $password, $role])) {
        echo "success";
    } else {
        echo "error";
    }
}
?>