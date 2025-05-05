<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Access denied.");
}

$result = $conn->query("SELECT id, name, email, role FROM users");

echo "<h2>All Users</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>ID: {$row['id']} | {$row['name']} ({$row['role']}) - {$row['email']}</div><hr />";
}
$conn->close();
?>
