<?php
// Include config file
require "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input values
    $name = $_POST["name"];
    $size = $_POST["size"];
    $color = $_POST["color"];
    $quantity = $_POST["quantity"];

    // Retrieve the current price of the item from the database
    $price_query = "SELECT price FROM cart WHERE name = '$name'";
    $price_result = $link->query($price_query);
    $price_row = $price_result->fetch_assoc();
    $current_price = $price_row["price"];

    // Calculate the new price based on the updated quantity
    $new_price = $current_price * $quantity;

    // Update the item's details in the database, including the new price
    $update_query = "UPDATE cart SET size = '$size', color = '$color', quantity = '$quantity', price = '$new_price' WHERE name = '$name'";
    if ($link->query($update_query) === TRUE) {
        // Redirect back to the cart page
        header("Location: display_cart.php");
        exit;
    } else {
        echo "Error updating record: " . $link->error;
    }
}

// Retrieve the item name from the URL parameter
$name = $_GET["name"];

// Fetch the item details from the database
$sql = "SELECT * FROM cart WHERE name = '$name'";
$result = $link->query($sql);

$row = $result->fetch_assoc();

// Close the database connection
$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cart Item</title>
</head>
<body>
    <h2>Edit Cart Item</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="max-width: 400px; margin: 0 auto; background-color: #f2f2f2; padding: 20px; border-radius: 4px;">

<input type="hidden" name="name" value="<?php echo $row['name']; ?>">

<div style="margin-bottom: 10px;">
    <label for="size" style="display: block; font-weight: bold;">Size:</label>
    <input type="text" id="size" name="size" value="<?php echo $row['size']; ?>" style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
</div>

<div style="margin-bottom: 10px;">
    <label for="color" style="display: block; font-weight: bold;">Color:</label>
    <input type="text" id="color" name="color" value="<?php echo $row['color']; ?>" style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
</div>

<div style="margin-bottom: 10px;">
    <label for="quantity" style="display: block; font-weight: bold;">Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;">
</div>

<div>
    <input type="submit" value="Update" style="width: 100%; background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
</div>
</form>
</body>
</html>