<?php
require 'api/host.php';
$stmt = $conn->query("SELECT id, firstname, lastname FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="contact-form-container">
    <h2>New Contact</h2>
    <form id="new-contact-form" onsubmit="submitNewContact(event)">
        
        <label for="title">Title</label>
        <select id="title" name="title">
            <option value="Mr.">Mr.</option>
            <option value="Ms.">Ms.</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Dr.">Dr.</option>
        </select>

        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Jane" required>
            </div>
            <div style="flex: 1;">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Doe" required>
            </div>
        </div>

        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="something@example.com" required>
            </div>
            <div style="flex: 1;">
                <label for="telephone">Telephone</label>
                <input type="tel" id="telephone" name="telephone" placeholder="876-123-4567">
            </div>
        </div>

        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="company">Company</label>
                <input type="text" id="company" name="company" placeholder="Dolphin Tech">
            </div>
            <div style="flex: 1;">
                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="Sales Lead">Sales Lead</option>
                    <option value="Support">Support</option>
                </select>
            </div>
        </div>

        <label for="assigned_to">Assigned To</label>
        <select id="assigned_to" name="assigned_to">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id']; ?>">
                    <?= $user['firstname'] . ' ' . $user['lastname']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn-primary">Save</button>
        </div>
    </form>
</div>