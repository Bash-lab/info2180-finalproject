<?php
session_start();
require 'host.php';

// Filter Logic
$filter = $_GET['filter'] ?? 'all';
$current_user = $_SESSION['user_id'];
$sql = "SELECT * FROM contacts ";

if ($filter == 'Sales Lead') { 
    $sql .= "WHERE type = 'Sales Lead'"; 
} 
elseif ($filter == 'Support') { 
    $sql .= "WHERE type = 'Support'"; 
} 
elseif ($filter == 'assigned') { 
    $sql .= "WHERE assigned_to = :id"; 
}

$stmt = $conn->prepare($sql);
if ($filter == 'assigned') { 
    $stmt->bindParam(':id', $current_user); 
}
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Render HTML for the Dashboard
echo '<div class="top-bar">
        <h3>Dashboard</h3>
        <button class="btn-primary" onclick="loadPage(\'new_contact\')">+ Add Contact</button>
      </div>';

echo '<div class="filters">
        <button onclick="filterContacts(\'all\')" class="' . ($filter == 'all' ? 'active' : '') . '">All</button>
        <button onclick="filterContacts(\'Sales Lead\')" class="' . ($filter == 'Sales Lead' ? 'active' : '') . '">Sales Leads</button>
        <button onclick="filterContacts(\'Support\')" class="' . ($filter == 'Support' ? 'active' : '') . '">Support</button>
        <button onclick="filterContacts(\'assigned\')" class="' . ($filter == 'assigned' ? 'active' : '') . '">Assigned to me</button>
      </div>';

echo "<table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
                <th></th>
            </tr>
        </thead>
        <tbody>";

foreach ($contacts as $row) {
    $name = $row['title'] . ' ' . $row['firstname'] . ' ' . $row['lastname'];
    $type_class = ($row['type'] == 'Sales Lead') ? 'badge-sales' : 'badge-support';
    
    echo "<tr>
            <td><strong>{$name}</strong></td>
            <td>{$row['email']}</td>
            <td>{$row['company']}</td>
            <td><span class='badge {$type_class}'>{$row['type']}</span></td>
            <td><a href='#' onclick='viewContact({$row['id']})'>View</a></td>
          </tr>";
}

echo "</tbody></table>";
?>