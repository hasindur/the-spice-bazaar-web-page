<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Access denied.");
}

$sql = "SELECT p.*, u.name AS seller FROM products p JOIN users u ON p.seller_id = u.id";
$result = $conn->query($sql);

echo "<h2>All Products</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            {$row['name']} | Rs. {$row['price']} | Qty: {$row['quantity']}<br />
            Seller: {$row['seller']}<br />
          </div><hr />";
}
$conn->close();
?>
