<?php
// Include config file
require "connection.php";

// Get form data
$name = $_POST['name'];
$category = $_POST['category'];
$color = $_POST['color'];
$size = $_POST['size'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

// Hash the password


// Prepare and bind
$stmt = $link->prepare("INSERT INTO cart (name, category, color, size, price,quantity) VALUES (?, ?, ?, ?, ?,?)");
$stmt->bind_param("ssssss", $name, $category, $color, $size, $price,$quantity);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$link->close();
?>
