<?php
session_start();
require "db_connection.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

function error_alert($url){
  echo "
  <script>
    alert('Incorrect username/password. Please try again.');
    document.location = '$url';
  </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $con->prepare(
    "SELECT id, name FROM users WHERE email = ? AND password = ?"
  );
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name);
    $stmt->fetch();

    $_SESSION['user_id'] = $id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    header("Location: dashboard.php");
    exit();
  } else {
    error_alert("index.php");
  }
}
?>