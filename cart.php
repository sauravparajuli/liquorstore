
<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($conn);
global $id;
// echo $user_data['email'];
// echo $user_data['id'];


// If the user is not logged in, redirect to the login page
if (!$user_data) {
    header("Location: login.php");
    exit(); // Stop further execution
}
// Assuming $user_id is set as a global variable

if (isset($_POST["confirmPaymentBtn"])) {
    // Check if the cart is not empty
    if (!empty($_SESSION["cart"])) {
        // Get the user ID from the session
        global $id;
        global $conn;

        // Iterate through each item in the cart
        foreach ($_SESSION["cart"] as $key => $value) {
            // Escape single quotes in the product name
            $productName = mysqli_real_escape_string($conn, $value['name']);
            // Convert price and quantity to appropriate types
            $price = $value['price'];
            $quantity = $value['quantity'];

            $user_id=$user_data['id'];
            // Construct the SQL query with directly inserted values
           $insertOrderQuery = "INSERT INTO ordered_products (user_id, product_name, price, order_quantity, order_date) VALUES ($user_id, '$productName', '$price', '$quantity', NOW())";


            if ($conn->query($insertOrderQuery) === TRUE) {
                echo "Order Placed successfully.";
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }

            // // Execute the SQL query
            // $result = mysqli_query($conn, $sql);
            


            // Check if the query executed successfully
            if (!$result) {
                echo "Error executing query: " . mysqli_error($conn) . "<br>";
                echo "Query: " . $insertOrderQuery;
                // Log the error for debugging purposes
                // For example, you can log to a file or database
                // Log the SQL query, error message, and any relevant variables
            }
        }

        // Clear the cart after inserting the order
        $_SESSION["cart"] = [];

        // Redirect to the orders.php page
        header("Location: orders.php");
        exit(); // Ensure that no further code is executed after the redirection
    
    } else {
        // Handle if the cart is empty
        echo "Cart is empty.";
    }


}






?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
                    <h2 class="text-center">Cart</h2>

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


                        if(!empty($_SESSION["cart"])) {

                            $output .= "
                            <table class='table table-bordered table-striped'>
                                <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                                </tr>
                            
                            ";

                            foreach($_SESSION["cart"] as $key => $value) {
                                $output .= "
                                <tr>
                                <td>".$value['id']."</td>
                                <td>".$value['name']."</td>
                                <td>".$value['price']."</td>
                                <td>".$value['quantity']."</td>
                                <td>Rs.".number_format($value['price'] * $value['quantity'],2)."</td>

                                <td>
                                    <a href='cart.php?action=remove&id=".$value['id']."'>
                                    <button class='btn btn-danger btn-block'>Remove</button>
                                    </a>
                                </td>
                                </tr>

                        
                                ";

                                $total = $total + $value["price"] * $value["quantity"];
                            }
                            $output .= "
                                <tr>
                                <td colspan='3'></td>
                                <td><b>Total Price</b></td>
                                <td>Rs.".number_format($total,2)."</td>

                                

                                <td>
                                    <a href='cart.php?action=clearall'>
                                    <button class='btn btn-warning btn-block'>Clear Cart</button>
                                    </a>
                                </td>
                                </tr>

                            ";

                            $output .= "
                                <tr>
                                <td colspan='5'></td>
                                <td>
                                    <a href='cart.php?action=checkout'>
                                    <button id='checkoutBtn' class='btn btn-warning btn-block'>Checkout</button>
                                    </a> 
                                </td>
                                </tr>
                            
                            ";

                        } else {
                            ?>
                                <h4 class="text-center">Cart is empty.</h2>
                            <?php
                        }




                        echo $output;
                    ?>
                </div>
            </div>
        </div>
    </div>


<?php
if(isset($_GET["action"])){

    //clear cart
    if($_GET['action'] == "clearall"){
        unset($_SESSION['cart']);
    }

    //remove an item from the cart
    if($_GET['action'] == "remove"){
        foreach($_SESSION["cart"] as $key => $value) {
            if($value['id'] == $_GET['id']){
                unset($_SESSION['cart'][$key]);
            }
        }
    }

    if ($_GET['action'] == "checkout") {
        // Check if the user is logged in and user_id is available 

     ?>
        <div id="popup" class="popup">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="popup-content">
                <h2>Select Payment Method</h2>
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod">
                    <option value="cashOnDelivery">Cash On Delivery</option>
                    <option value="onlinePayment">Online Payment</option>
                </select>
                <input id="confirmPaymentBtn" name="confirmPaymentBtn" class="btn btn-primary" type="submit" value="Confirm Payment">
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
                document.getElementById("checkoutBtn").addEventListener("click", function(event) {
                    // Prevent the default behavior (page refresh) when clicking the checkout button
                    event.preventDefault();
                    // Display the pop-up
                    document.getElementById("popup").style.display = "block";
                });

                document.getElementById("confirmPaymentBtn").addEventListener("click", function() {
                    var paymentMethod = document.getElementById("paymentMethod").value;
                    // Perform further actions based on the selected payment method
                    // alert("Payment method selected: " + paymentMethod);
                    // Close the pop-up
                    document.getElementById("popup").style.display = "none";
                });
            });
        
        </script>
        <?php

}
}





?>




</body>
</html>