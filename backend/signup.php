<?php
// Include config file
require "connection.php";

// Get form data
$user_name = $_POST['username'];
$first_name = $_POST['fristname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $link->prepare("INSERT INTO signup (username, fristname, lastname, email, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $user_name, $first_name, $last_name, $email, $hashed_password);

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
