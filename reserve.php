<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION["user_id"])) {
  header("Location: login.html");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book_id = $_POST["book_id"];
  $user_id = $_SESSION["user_id"];
  
  // Get today's date and calculate the due date (7 days from now)
  $reserved_at = date("Y-m-d H:i:s");
  $due_date = date("Y-m-d", strtotime("+7 days"));

  // Insert the reservation into the database
  $stmt = $conn->prepare("INSERT INTO reservations (user_id, book_id, reserved_at, due_date) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iiss", $user_id, $book_id, $reserved_at, $due_date);
  $stmt->execute();
  
  // Update book availability
  $stmt = $conn->prepare("UPDATE books SET availability = 0 WHERE id = ?");
  $stmt->bind_param("i", $book_id);
  $stmt->execute();

  // Create a notification
  $message = "Your reservation for the book has been confirmed! Due Date: $due_date";
  $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
  $stmt->bind_param("is", $user_id, $message);
  $stmt->execute();

  // Redirect to the profile page
  header("Location: profile.php");
  exit();
}
?>
