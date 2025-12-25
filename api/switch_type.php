<?php
session_start();
require 'host.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_id = $_POST['contact_id'];

    // Get current type and switch it
    $stmt = $conn->prepare("SELECT type FROM contacts WHERE id = ?");
    $stmt->execute([$contact_id]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $new_type = ($contact['type'] == 'Sales Lead') ? 'Support' : 'Sales Lead';
    
    $sql = "UPDATE contacts SET type = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$new_type, $contact_id])) {
        echo "success";
    } else {
        echo "error";
    }
}
?>