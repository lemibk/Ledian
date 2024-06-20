<?php
// Include config file
require "connection.php";

// Prepare and execute the SQL query to fetch the cart data
$sql = "SELECT * FROM cart";
$result = $link->query($sql);

// Calculate the total price
$total_result = $link->query("SELECT SUM(price * quantity) AS total_price FROM cart");
$total_row = $total_result->fetch_assoc();
$total_price = $total_row["total_price"] ? $total_row["total_price"] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Table</title>
    <style>
        /* Styling the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        /* Styling the table header */
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        /* Adding background color to table header */
        th {
            background-color: #f2f2f2;
            color: #333;
        }

        /* Adding alternating row colors */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Adding hover effect to table rows */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling the Remove and Edit buttons */
        .remove-btn, .edit-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Adding hover effect to Remove and Edit buttons */
        .remove-btn:hover, .edit-btn:hover {
            background-color: #e60000;
        }

        /* Making table responsive */
        @media screen and (max-width: 600px) {
            table, th, td {
                display: block;
                width: 100%;
            }
            th, td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            th::before, td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 45%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div id="cart-container">
    <?php
    // Check if there are any rows in the result set
    if ($result->num_rows > 0) {
        // Output the data in a table
        echo "<table id='cart-table'>";
        echo "<tr><th>Name</th><th>Category</th><th>Color</th><th>Size</th><th>Price</th><th>Quantity</th><th>Action</th></tr>";

        // Loop through the rows and display the data
        while($row = $result->fetch_assoc()) {
            echo "<tr data-name='" . $row["name"] . "'>";
            echo "<td data-label='Name'>" . $row["name"] . "</td>";
            echo "<td data-label='Category'>" . $row["category"] . "</td>";
            echo "<td data-label='Color'>" . $row["color"] . "</td>";
            echo "<td data-label='Size'>" . $row["size"] . "</td>";
            echo "<td data-label='Price'>" . $row["price"] . "</td>";
            echo "<td data-label='Quantity'>" . $row["quantity"] . "</td>";
            echo "<td data-label='Action'><button class='remove-btn' data-name='" . $row["name"] . "'>Remove</button>
             <button class='edit-btn' data-name='" . $row["name"] . "'>Edit</button></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No orders found.";
    }
    ?>

    <div id="total-price-container">
        <strong>Total Price: $<span id="total-price"><?php echo $total_price; ?></span></strong>
    </div>
</div>

<button onclick="window.location.href='../index1.html';">Back</button>

<script>

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".remove-btn").forEach(function(button) {
        button.addEventListener("click", function() {
            var name = this.getAttribute("data-name");
            var row = this.closest("tr");

            if (confirm("Are you sureyou want to remove this item from the cart?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        row.parentNode.removeChild(row);
                        document.getElementById("total-price").textContent = response.total_price;
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                };
                xhr.send("name=" + encodeURIComponent(name));
            } 
        });
    });

    document.querySelectorAll(".edit-btn").forEach(function(button) {
        button.addEventListener("click", function() {
            var name = this.getAttribute("data-name");
            // Redirect to the edit page passing the item name as a parameter
            window.location.href = "edit_cart.php?name=" + encodeURIComponent(name);
        });
    });
});

</script>

</body>
</html>