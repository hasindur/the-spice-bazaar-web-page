<?php
$host = "localhost";
$user = "root";
$pass = ""; // your MySQL password
$db = "spice_bazaar";


$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
