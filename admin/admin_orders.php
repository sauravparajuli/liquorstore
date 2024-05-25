<?php
session_start();
include("../connection.php");
include("../functions.php");

// Check if the admin is logged in
$admin_data = check_login($conn);
$admin_id = $admin_data['id'];

// Fetch all orders data
$query = "SELECT id, user_id, product_name, price, order_quantity FROM ordered_products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

if (isset($_POST["ConfirmCancelOrderBtn"])) {
    // Delete the specific order from the ordered_products table
    $order_id = $_POST['order_id'];
    echo $order_id;
    $deleteQuery = "DELETE FROM ordered_products WHERE id = $order_id";
    if (mysqli_query($conn, $deleteQuery)) {
        $_SESSION['order_message'] = "Order cancelled successfully.";
        $_SESSION['order_message_class'] = "alert-success";
    } else {
        $_SESSION['order_message'] = "Error: " . mysqli_error($conn);
        $_SESSION['order_message_class'] = "alert-danger";
    }

    // Redirect to refresh the page and reflect the changes
    header("Location: admin_orders.php");
    exit(); // Ensure that no further code is executed after the redirection
}

// Display order message if it exists
if (isset($_SESSION['order_message'])) {
    echo "<div class='alert " . $_SESSION['order_message_class'] . "' id='order-message'>" . $_SESSION['order_message'] . "</div>";
    // Clear the message after displaying it
    unset($_SESSION['order_message']);
    unset($_SESSION['order_message_class']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h2 class="text-center">Orders</h2>

                    <?php
                    $output = "";
                    $total = 0;

                    if (mysqli_num_rows($result) > 0) {
                        $output .= "
                        <table class='table table-bordered table-striped'>
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        ";

                        while ($row = mysqli_fetch_assoc($result)) {
                            $total_price = $row['price'] * $row['order_quantity'];
                            $output .= "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['user_id']}</td>
                                <td>" . htmlspecialchars($row['product_name']) . "</td>
                                <td>Rs." . number_format($row['price'], 2) . "</td>
                                <td>{$row['order_quantity']}</td>
                                <td>Rs." . number_format($total_price, 2) . "</td>
                                <td>  
                                    <input type='hidden' name='order_id' value='{$row['id']}'>
                                    <a href='admin_orders.php?action=cancel_order'>
                                        <button id='cancelorderBtn' name='cancelorderBtn' class='btn btn-danger'>Cancel Order</button>
                                    </a>
                                    
                                </td>
                            </tr>
                            ";

                            $total += $total_price;
                        }

                        $output .= "
                            <tr>
                                <td colspan='5'></td>
                                <td><b>Total</b></td>
                                <td>Rs." . number_format($total, 2) . "</td>
                            </tr>
                        ";

                        $output .= "</table>";
                    } else {
                        $output .= "<h4 class='text-center'>No orders found.</h4>";
                    }

                    echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>


<?php

if(isset($_GET["action"]) && $_GET['action'] == "cancel_order") {
?>
    <div id="popup" class="popup">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >
            <div class="popup-content">
                <h2>Order Cancel</h2>
                <label for="cancelreason">Reason for cancelling:</label>
                <select id="cancelreason" name="cancelreason">
                    <option value="blah blah 1">blah blah 1</option>
                    <option value="blah blah 2">blah blah 2</option>
                    <option value="blah blah 3">blah blah 3</option>
                    <option value="blah blah 4">blah blah 4</option>
                    <option value="blah blah 5">blah blah 5</option>
                </select>
                <button id="ConfirmCancelOrderBtn" name="ConfirmCancelOrderBtn" class="btn btn-primary"> Confirm Cancel</button>
            </div>
        </form>

    </div> 

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.5);
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            z-index: 9999;
            text-align: center;
        }

        .popup-content {
            color: white;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("cancelorderBtn").addEventListener("click", function(event) {
                // Prevent the default behavior (page refresh) when clicking the cancel order button
                event.preventDefault();
                // Display the pop-up
                document.getElementById("popup").style.display = "block";
            });

            document.getElementById("ConfirmCancelOrderBtn").addEventListener("click", function() {
                var cancelReason = document.getElementById("cancelreason").value;
                // Perform further actions based on the selected cancel reason
                // alert("Your order has been canceled. Reason: " + cancelReason);
                // Close the pop-up
                document.getElementById("popup").style.display = "none";
            });
        });
    </script>
<?php
}
?>


<script>
// JavaScript code to hide the alert after a few seconds
setTimeout(function() {
    document.getElementById('order-message').style.display = 'none';
}, 2000); // Adjust the time (in milliseconds) as needed
</script>


</body>
</html>