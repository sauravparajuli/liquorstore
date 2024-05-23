
<?php

// session_start();
//     include("connection.php");
//     include("functions.php");

    if(isset($_POST["add_to_cart"])){
        // Set a session variable to store the message
        $_SESSION['cart_message'] = "Item added to cart successfully.";
        $_SESSION['cart_message_class'] = "alert-success"; // Set the class for styling

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


?>
<?php
// Display cart message if it exists
if (isset($_SESSION['cart_message'])) {
    echo "<div class='alert " . $_SESSION['cart_message_class'] . "' id='cart-message'>" . $_SESSION['cart_message'] . "</div>";
    
    // Clear the message after displaying it
    unset($_SESSION['cart_message']);
    unset($_SESSION['cart_message_class']);
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>whiksey</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- <h2>beer</h2>
    <div id="beerList">
        Product list will be displayed here
    </div> -->

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <!-- <h2 class="text-center">beer</h2> -->
                    <div class="col-md-12">
                        <div class="row">
                            <?php

                            $query = "select * from beer WHERE stock='Yes' LIMIT 3";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) { 
                            ?>
                            <div class="col-md-4">
                                <?php
                                // Check if the product is out of stock
                               
                                    ?>
                                    <form action="beer.php?id=<?= $row['id'] ?>" method="post">
                                        <?php
                                        $imageData = $row['image'];
                                        $imageSrc = 'data:image/png;base64,' . base64_encode($imageData);
                                        ?>
                                        <img src="<?= $imageSrc ?>" style="height: 150px;" alt="<?= $row['name']; ?>">
                                        <h5><?= $row['name']; ?></h5>
                                        <h5>Rs.<?= number_format($row['price'], 2); ?></h5>
                                        <input type="hidden" name="name" value="<?= $row['name'] ?>">
                                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                                        <input type="number" name="quantity" value="1" class="form-control">
                                        <input type="submit" name="add_to_cart" class="btn btn-warning btn-block" value="Add to Cart">
                                        <!-- <input type="submit" name="add_to_cart" class="btn btn-warning btn-block" value="Add to Cart"> -->
                                    </form>

                            </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

<?php

if(isset($_GET["action"])){
    if($_GET['action'] == "clearall"){
        unset($_SESSION[("cart")]);
    }
}

?>

<script>
// JavaScript code to hide the alert after a few seconds
setTimeout(function() {
    document.getElementById('cart-message').style.display = 'none';
}, 2000); // Adjust the time (in milliseconds) as needed
</script>


</body>
</html>
