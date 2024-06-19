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
    $total_price = $total_row["total_price"] ?? 0;
    
    // Return the new total price as a JSON response
    echo json_encode(["total_price" => $total_price]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const name = btn.dataset.name;
                    
                    // Use AJAX to send a request to the server
                    fetch('your_script.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({ name: name })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update the total price on the page
                        document.getElementById('total-price').textContent = `Total: $${data.total_price}`;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</head>
<body>
    <h1>Cart</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Fetch cart items from the database and display them
                $cart_items = $link->query("SELECT * FROM cart");
                while ($item = $cart_items->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $item['name'] . "</td>";
                    echo "<td>$" . $item['price'] . "</td>";
                    echo "<td>" . $item['quantity'] . "</td>";
                    echo "<td><button class='delete-btn' data-name='" . $item['name'] . "'>Remove</button></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <p id="total-price">Total: $0</p>
</body>
</html>