<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
include 'includes/db_connect.php';

// Fetch user's reservations
$user_id = $_SESSION["user_id"];
$reservations_query = "SELECT * FROM reservations INNER JOIN books ON reservations.book_id = books.id WHERE reservations.user_id = '$user_id'";
$reservations_result = $conn->query($reservations_query);

// Fetch unread notifications
$notifications_query = "SELECT * FROM notifications WHERE user_id = '$user_id' AND is_read = 0";
$notifications_result = $conn->query($notifications_query);

// Mark notification as read
if (isset($_GET['notification_id']) && is_numeric($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];
    
    // Sanitize notification ID
    $notification_id = $conn->real_escape_string($notification_id);

    // Update query
    $update_query = "UPDATE notifications SET is_read = 1 WHERE id = '$notification_id' AND user_id = '$user_id'";
    
    if ($conn->query($update_query)) {
        // Redirect back to profile page after updating
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating notification: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="sidebar">
        <h2 style="text-align: center;">eLibrary</h2>
        <a href="library.php">📚 Library</a>
        <a href="search.php">🔎 Search</a>
        <a href="profile.php">👤 Profile</a>
        <a href="logout.php">🚪 Logout</a>
        <br><br>
        <button id="dark-mode-toggle" style="margin-left: 20px;">🌓 Toggle Dark Mode</button>
    </div>

    <div class="main">
        <div class="header">
            <h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h1>
        </div>

        <h2>Reservations</h2>
        <ul>
            <?php while ($reservation = $reservations_result->fetch_assoc()): ?>
                <li>
                    <?= htmlspecialchars($reservation['title']) ?> (Due: <?= htmlspecialchars($reservation['due_date']) ?>)
                </li>
            <?php endwhile; ?>
        </ul>

        <h2>Notifications</h2>
        <ul>
            <?php while ($notification = $notifications_result->fetch_assoc()): ?>
                <li style="color: <?= $notification['is_read'] ? 'gray' : 'black' ?>;">
                    <?= htmlspecialchars($notification['message']) ?>
                    <?php if (!$notification['is_read']): ?>
                        <a href="profile.php?notification_id=<?= $notification['id'] ?>" style="color: #007BFF; text-decoration: none;">Mark as Read</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
