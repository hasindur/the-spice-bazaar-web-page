<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    die("Only buyers can view orders.");
}

$buyer_id = $_SESSION['user_id'];

$sql = "SELECT o.id, p.name AS product_name, o.quantity, o.status, o.created_at 
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.buyer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>My Orders</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            <strong>Product:</strong> " . $row['product_name'] . "<br />
            <strong>Quantity:</strong> " . $row['quantity'] . "<br />
            <strong>Status:</strong> " . $row['status'] . "<br />
            <strong>Ordered on:</strong> " . $row['created_at'] . "
          </div><hr />";
}

$stmt->close();
$conn->close();
?>
