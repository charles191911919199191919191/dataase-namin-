<?php
include "config.php";
session_start();
if ($_SESSION["role"] !== "admin") header("Location: login.php");

$result = $conn->query("SELECT id, username, role FROM users");
echo "<h2>Admin Dashboard</h2><table border='1'>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['role']}</td></tr>";
}
echo "</table><a href='logout.php'>Logout</a>";
?>
