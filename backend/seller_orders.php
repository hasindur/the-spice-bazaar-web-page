<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    die("Only sellers can view this page.");
}

$seller_id = $_SESSION['user_id'];

$sql = "SELECT o.id, u.name AS buyer_name, p.name AS product_name, o.quantity, o.status, o.created_at 
        FROM orders o
        JOIN products p ON o.product_id = p.id
        JOIN users u ON o.buyer_id = u.id
        WHERE p.seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Orders Received</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            <strong>Product:</strong> " . $row['product_name'] . "<br />
            <strong>Buyer:</strong> " . $row['buyer_name'] . "<br />
            <strong>Quantity:</strong> " . $row['quantity'] . "<br />
            <strong>Status:</strong> " . $row['status'] . "<br />
            <strong>Date:</strong> " . $row['created_at'] . "<br />
            <form method='POST' action='update_order_status.php'>
                <input type='hidden' name='order_id' value='" . $row['id'] . "' />
                <select name='status'>
                    <option value='pending'>Pending</option>
                    <option value='shipped'>Shipped</option>
                    <option value='delivered'>Delivered</option>
                </select>
                <button type='submit'>Update</button>
            </form>
          </div><hr />";
}

$stmt->close();
$conn->close();
?>
