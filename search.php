<?php
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book_id = $_POST["book_id"];
  $query = "SELECT * FROM books WHERE id = '$book_id'";
  $result = $conn->query($query);
  $book = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Book</title>
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
      <h1>Search Book by ID</h1>
    </div>

    <form method="POST">
      <input type="text" name="book_id" placeholder="Book ID" required />
      <button type="submit">Search</button>
    </form>

    <?php if (isset($book)): ?>
      <div class="book-item">
        <h3><?= htmlspecialchars($book['title']) ?></h3>
        <p>Author: <?= htmlspecialchars($book['author']) ?></p>
        <p>Status: <?= $book['availability'] ? 'Available' : 'Not Available' ?></p>
      </div>
    <?php endif; ?>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
