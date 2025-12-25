<?php
session_start();
require 'host.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['contact_id'];
    $comment = $_POST['comment'];
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO notes (contact_id, comment, created_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$contact_id, $comment, $created_by])) {
        // Update the contact's updated_at timestamp
        $update = $conn->prepare("UPDATE contacts SET updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $update->execute([$contact_id]);
        echo "success";
    } else {
        echo "error";
    }
}
?>