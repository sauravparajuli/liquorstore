
<?php

session_start();
    include("connection.php");
    include("functions.php");

    // Check if the user is logged in
    $user_data = check_login($conn);
    $user_id = $user_data['id'];

    // Fetch order data for the logged-in user
    $query = "SELECT id, product_name, price, order_quantity FROM ordered_products WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }


    if(isset($_POST["ConfirmCancelOrderBtn"])){
        // Delete the rows from the ordered_products table where user_id matches the logged-in user
        $deleteQuery = "DELETE FROM ordered_products WHERE user_id = $user_id";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "Order cancelled successfully.";
            // Redirect to the same page to refresh and reflect the changes
            header("Location: orders.php");
            exit(); // Ensure that no further code is executed after the redirection
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        unset($_SESSION['cart']); //clears the cart while cancelling the order
        $_SESSION['order_message'] = "Your order has been canceled.";
        $_SESSION['order_message_class'] = "alert-danger";
    }
    // Display order message if it exists
    if (isset($_SESSION['order_message'])) {
        echo "<div class='alert " . $_SESSION['order_message_class'] . "' id='order-message'>" . $_SESSION['order_message'] . "</div>";
        
        // Clear the message after displaying it
        unset($_SESSION['order_message']);
        unset($_SESSION['order_message_class']);
    }


?>
<?php

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include'header.php'; ?>
    <!-- <h2>Vodka</h2>
    <div id="vodkaList">
        Product list will be displayed here
    </div> -->

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h2 class="text-center">Orders</h2>

                    <?php
                        // var_dump($_SESSION['cart']);
                        $total = 0;
                        $output = "";
                        // $output .= "
                        // <table class='table table-bordered table-striped'>
                        //     <tr>
                        //     <th>ID</th>
                        //     <th>Name</th>
                        //     <th>Price</th>
                        //     <th>Quantity</th>
                        //     <th>Price</th>
                        //     <th>Action</th>
                        //     </tr>
                        
                        // ";

                        if (mysqli_num_rows($result) > 0) {
                            $output .= "
                            <table class='table table-bordered table-striped'>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            ";
                        
                            while ($row = mysqli_fetch_assoc($result)) {
                                $output .= "
                                <tr>
                                    <td>{$row['id']}</td>
                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['order_quantity']}</td>
                                    <td>Rs." . number_format($row['price'] * $row['order_quantity'], 2) . "</td>
                                </tr>
                                ";
                        
                                $total += $row['price'] * $row['order_quantity'];
                            }
                        
                            $output .= "
                                <tr>
                                    <td colspan='3'></td>
                                    <td><b>Total Price</b></td>
                                    <td>Rs." . number_format($total, 2) . "</td>
                                </tr>
                            ";
                        
                            $output .= "
                                <tr>
                                    <td colspan='4'></td>
                                    <td>
                                        <a href='orders.php?action=cancel_order'>
                                            <button id='cancelorderBtn' class='btn btn-warning btn-block'>Cancel Order</button>
                                        </a> 
                                    </td>
                                </tr>
                            ";
                        
                            $output .= "</table>";
                        } else {
                            ?>
                                <h4 class="text-center">You haven't ordered yet.</h2>
                            <?php
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