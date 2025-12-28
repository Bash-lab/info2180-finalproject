<?php
session_start();
// Redirect to login if not logged in [cite: 25-26]
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <img src="images/dolphin3.png" alt="Dolphin Logo">
        <h1>Dolphin CRM</h1>
    </header>

    <div class="container">
        <aside>
            <button onclick="loadPage('dashboard')" class="nav-btn active">Home</button>
            <button onclick="loadPage('new_contact')" class="nav-btn">New Contact</button>
            <?php if ($_SESSION['role'] === 'Admin'): ?>
                 <button onclick="loadPage('users')" class="nav-btn">Users</button>
            <?php endif; ?>
            <hr>
            <button onclick="window.location.href='api/logout.php'" class="nav-btn">Logout</button>
        </aside>

        <main id="result">
            </main>
    </div>

    <script src="webapp.js"></script>
</body>
</html>