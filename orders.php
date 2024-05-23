
<?php

session_start();
    include("connection.php");
    include("functions.php");

    if(isset($_POST["confirmPaymentBtn"])){
        // Set a session variable to store the message
        // $_SESSION['order_message'] = "Your order has been placed.";
        // $_SESSION['order_message_class'] = "alert-success"; // Set the class for styling

        if(isset($_SESSION["cart"])){
            $session_array_id = array_column($_SESSION["cart"],"id");

            if(!in_array($_GET["id"], $session_array_id)){
                $session_array = array(
                    'id' => $_GET['id'],
                    'name' => $_POST['name'],
                    'price' => $_POST['price'], 
                    'quantity' => $_POST['quantity']
                );
                $_SESSION['cart'][] = $session_array;
            }

        } else {
            $session_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'], 
                'quantity' => $_POST['quantity']
            );
            $_SESSION['cart'][] = $session_array;
        }
    } 

    if(isset($_POST["confirmcancelorderBtn"])){
        unset($_SESSION['cart']);
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
                <div class="col-md-6">
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

                        if(!empty($_SESSION["cart"])) {

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

                            foreach($_SESSION["cart"] as $key => $value) {
                                $output .= "
                                <tr>
                                <td>".$value['id']."</td>
                                <td>".$value['name']."</td>
                                <td>".$value['price']."</td>
                                <td>".$value['quantity']."</td>
                                <td>Rs.".number_format($value['price'] * $value['quantity'],2)."</td>

                        
                                </tr>

                        
                                ";

                                $total = $total + $value["price"] * $value["quantity"];
                            }
                            $output .= "
                                <tr>
                                <td colspan='3'></td>
                                <td><b>Total Price</b></td>
                                <td>Rs.".number_format($total,2)."</td>

                                
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

                        } else {
                            ?>
                                <h4>You haven't ordered yet.</h2>
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
                <button id="confirmcancelorderBtn" name="confirmcancelorderBtn" class="btn btn-primary"> Confirm Cancel</button>
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

            document.getElementById("confirmcancelorderBtn").addEventListener("click", function() {
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