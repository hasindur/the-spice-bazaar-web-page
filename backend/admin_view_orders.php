<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Access denied.");
}

$sql = "SELECT o.id, o.quantity, o.status, p.name AS product, b.name AS buyer 
        FROM orders o
        JOIN products p ON o.product_id = p.id
        JOIN users b ON o.buyer_id = b.id";

$result = $conn->query($sql);

echo "<h2>All Orders</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            Order ID: {$row['id']} | Product: {$row['product']}<br />
            Buyer: {$row['buyer']} | Qty: {$row['quantity']} | Status: {$row['status']}
          </div><hr />";
}
$conn->close();
?>
