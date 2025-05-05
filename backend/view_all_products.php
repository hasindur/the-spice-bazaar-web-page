<?php
session_start();
require 'db.php';

$sql = "SELECT p.*, u.name AS seller_name FROM products p JOIN users u ON p.seller_id = u.id";
$result = $conn->query($sql);

echo "<h2>Available Spices</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
            <strong>" . $row['name'] . "</strong> by " . $row['seller_name'] . "<br />
            " . $row['description'] . "<br />
            Rs. " . $row['price'] . " | Qty: " . $row['quantity'] . "<br />
            <form action='place_order.php' method='POST'>
                <input type='hidden' name='product_id' value='" . $row['id'] . "' />
                <input type='number' name='quantity' min='1' max='" . $row['quantity'] . "' value='1' required />
                <button type='submit'>Buy</button>
            </form>
          </div><hr />";
}
$conn->close();
?>
