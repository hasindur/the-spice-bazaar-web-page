<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    die("Access denied.");
}

$seller_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();

$result = $stmt->get_result();

echo "<h2>Your Products</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            <strong>" . $row['name'] . "</strong><br />
            " . $row['description'] . "<br />
            Rs. " . $row['price'] . " | Qty: " . $row['quantity'] . "
          </div><hr />";
}

$stmt->close();
$conn->close();
?>
