<?php
session_start();
require 'host.php'; // Connect to database

// Get data from the POST request
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Query the database for the user [cite: 24]
$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify password
// Note: The Admin created in schema.sql must be verified here.
if ($user && password_verify($password, $user['password'])) {
    // Set Session Variables [cite: 25]
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    echo "success";
} else {
    echo "failed";
}
?>