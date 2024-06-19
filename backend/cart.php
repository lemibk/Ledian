<?php
// Include config file
require "connection.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){

// Get form data
$name = $_POST['name'];
$category = $_POST['category'];
$color = $_POST['color'];
$size = $_POST['size'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
}
// Hash the password


// Prepare and bind
$stmt = $link->prepare("INSERT INTO cart (name, category, color, size, price, quantity) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $category, $color, $size, $price, $quantity);

// Execute the statement
if ($stmt->execute()) {
    $stmt->close();
    $link->close();
    echo "<script>document.getElementById('message').innerHTML = 'New record created successfully';</script>";
    echo '<script>window.history.back();</script>';
} else {
    echo "<script>document.getElementById('message').innerHTML = 'Error: " . $stmt->error . "';</script>";
}

?>