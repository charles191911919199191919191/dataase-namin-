<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      $_SESSION["user_id"] = $row["id"];
      $_SESSION["username"] = $row["username"];
      $_SESSION["role"] = $row["role"];
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "No such user.";
  }
}
?>
