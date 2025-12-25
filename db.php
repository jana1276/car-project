<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "car_project_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Connection failed");
}
?>
