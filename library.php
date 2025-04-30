<?php
include 'includes/db_connect.php';
$query = "SELECT * FROM books";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Library</title>
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
      <h1>Available Books</h1>
    </div>

    <div class="book-list">
      <?php while ($book = $result->fetch_assoc()): ?>
        <div class="book-item">
          <h3><?= htmlspecialchars($book['title']) ?></h3>
          <p>Author: <?= htmlspecialchars($book['author']) ?></p>
          <p>Status: <?= $book['availability'] ? 'Available' : 'Not Available' ?></p>
          
          <?php if ($book['availability']): ?>
            <form method="POST" action="reserve.php">
              <input type="hidden" name="book_id" value="<?= $book['id'] ?>" />
              <button type="submit">Reserve</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
