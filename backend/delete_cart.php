<?php
// Include config file
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $sql = "DELETE FROM cart WHERE name = ?";
    
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
    }

    // Calculate the new total price
    $total_result = $link->query("SELECT SUM(price * quantity) AS total_price FROM cart");
    $total_row = $total_result->fetch_assoc();
    $total_price = $total_row["total_price"] ? $total_row["total_price"] : 0;

    // Return the new total price
    echo json_encode(["total_price" => $total_price]);
    
}
?>
