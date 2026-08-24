<?php
$servername = "localhost";
$username   = "root";   // default XAMPP user
$password   = "";       // default XAMPP has no password
$database   = "mpumalanga_tourism";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
