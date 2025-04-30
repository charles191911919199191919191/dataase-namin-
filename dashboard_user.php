<?php
session_start();
if ($_SESSION["role"] !== "user") header("Location: login.php");
echo "<h2>Welcome, User!</h2>";
?>
<a href="logout.php">Logout</a>
