<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .sidebar {
      width: 200px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #007BFF;
      padding-top: 20px;
      color: white;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #0056b3;
    }

    .main {
      margin-left: 220px;
      padding: 20px;
      transition: background-color 0.3s ease;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2 style="text-align: center;">eLibrary</h2>
    <a href="library.html">📚 Library</a>
    <a href="search.html">🔎 Search</a>
    <a href="profile.html">👤 Profile</a>
    <a href="logout.php">🚪 Logout</a>
    <br><br>
    <button id="dark-mode-toggle" style="margin-left: 20px;">🌓 Toggle Dark Mode</button>
  </div>

  <div class="main">
    <div class="header">
      <h1>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h1>
    </div>
    <p>This is your dashboard. Use the sidebar to navigate.</p>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
