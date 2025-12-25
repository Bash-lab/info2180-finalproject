<?php
session_start();
require 'host.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['contact_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE contacts SET assigned_to = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$user_id, $contact_id])) {
        echo "success";
    } else {
        echo "error";
    }
}
?>