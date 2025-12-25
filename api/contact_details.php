<?php
session_start();
require 'host.php';

$contact_id = $_GET['id'] ?? null;

if (!$contact_id) {
    echo "<p>Invalid contact ID</p>";
    exit;
}

// Fetch contact details
$stmt = $conn->prepare("SELECT c.*, u.firstname as assigned_firstname, u.lastname as assigned_lastname, 
                        creator.firstname as creator_firstname, creator.lastname as creator_lastname
                        FROM contacts c
                        LEFT JOIN users u ON c.assigned_to = u.id
                        LEFT JOIN users creator ON c.created_by = creator.id
                        WHERE c.id = ?");
$stmt->execute([$contact_id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
    echo "<p>Contact not found</p>";
    exit;
}

// Fetch notes for this contact
$stmt = $conn->prepare("SELECT n.comment, n.created_at, u.firstname, u.lastname 
                        FROM notes n 
                        JOIN users u ON n.created_by = u.id 
                        WHERE n.contact_id = ? 
                        ORDER BY n.created_at DESC");
$stmt->execute([$contact_id]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display contact details
$fullname = $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname'];
$assigned_to = $contact['assigned_firstname'] . ' ' . $contact['assigned_lastname'];
$created_by = $contact['creator_firstname'] . ' ' . $contact['creator_lastname'];

// Determine badge color based on type
$badge_class = ($contact['type'] == 'Sales Lead') ? 'badge-sales' : 'badge-support';

echo "<div class='contact-details'>
        <div class='contact-header'>
            <div>
                <h2>{$fullname}</h2>
                <p class='contact-meta'>Created on " . date('F j, Y', strtotime($contact['created_at'])) . " by {$created_by}</p>
            </div>
            <span class='badge {$badge_class}'>{$contact['type']}</span>
        </div>
        
        <div class='contact-info'>
            <p><strong>Email:</strong> {$contact['email']}</p>
            <p><strong>Telephone:</strong> {$contact['telephone']}</p>
            <p><strong>Company:</strong> {$contact['company']}</p>
            <p><strong>Assigned To:</strong> {$assigned_to}</p>
        </div>
        
        <div class='actions'>
            <button class='btn-action' onclick='assignToMe({$contact_id})'>Assign to me</button>
            <button class='btn-action' onclick='switchType({$contact_id})'>Switch to " . ($contact['type'] == 'Sales Lead' ? 'Support' : 'Sales Lead') . "</button>
        </div>
        
        <hr>
        
        <h3>Notes</h3>
        <div class='notes-section'>";

foreach ($notes as $note) {
    $note_author = $note['firstname'] . ' ' . $note['lastname'];
    $note_date = date('F j, Y \a\t g:ia', strtotime($note['created_at']));
    echo "<div class='note'>
            <p><strong>{$note_author}</strong> <span class='note-date'>{$note_date}</span></p>
            <p>{$note['comment']}</p>
          </div>";
}

echo "  <form id='add-note-form' onsubmit='addNote(event, {$contact_id})'>
            <label for='note-comment'>Add a note about {$contact['firstname']}:</label>
            <textarea id='note-comment' name='comment' rows='4' required></textarea>
            <button type='submit' class='btn-primary'>Add Note</button>
        </form>
      </div>
</div>";
?>