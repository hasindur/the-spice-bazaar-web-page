<?php
session_start();
require 'db.php';

// Make sure only logged-in sellers can access this
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    die("Access denied. Only sellers can add products.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_SESSION['user_id'];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image = ""; // For now we leave image empty, can be updated later with file upload

    $sql = "INSERT INTO products (seller_id, name, description, price, quantity, image)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdis", $seller_id, $name, $description, $price, $quantity, $image);

    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
