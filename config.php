<?php
$host = "localhost";
$db = "receipt_system";
$user = "root"; // replace with your MySQL username
$pass = "";     // replace with your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>