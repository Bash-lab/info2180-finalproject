<?php
session_start();
require 'host.php';

// Security Check: Only allow Admins to view this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "<p style='color:red;'>Access Denied: Administrator privileges required.</p>";
    exit;
}

// Fetch all users from the database
$stmt = $conn->query("SELECT firstname, lastname, email, role, created_at FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="top-bar">
        <h3>Users</h3>
        <button class="btn-primary" onclick="loadPage(\'add_user\')">+ Add User</button>
      </div>';

echo "<table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>";

foreach ($users as $user) {
    $fullname = $user['firstname'] . ' ' . $user['lastname'];
    echo "<tr>
            <td><strong>{$fullname}</strong></td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
            <td>{$user['created_at']}</td>
          </tr>";
}

echo "</tbody></table>";
?>