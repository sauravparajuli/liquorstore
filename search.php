
<?php
session_start();
    include("connection.php");
    include("functions.php");

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <!-- main styles -->
    <link rel="stylesheet" href="newstyles.css">
    <link rel="stylesheet" href="styles.css"> 


</head>
<body>

    <?php include ('header.php');?>
    <h2>Searched items: </h2>
    <?php
        // Check if the search form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $searchTerm = $_POST['search_term'];

        // SQL query to search for the product across all tables
        $query = "
            (SELECT 'vodka' AS table_name, name, price FROM vodka WHERE name LIKE '%$searchTerm%')
            UNION
            (SELECT 'whiskey' AS table_name, name, price FROM whiskey WHERE name LIKE '%$searchTerm%')
            UNION
            (SELECT 'rum' AS table_name, name, price FROM rum WHERE name LIKE '%$searchTerm%')
            UNION
            (SELECT 'beer' AS table_name, name, price FROM beer WHERE name LIKE '%$searchTerm%')
            UNION
            (SELECT 'wine' AS table_name, name, price FROM wine WHERE name LIKE '%$searchTerm%')
        ";
    
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) { 
        ?>
        <div class="col-md-4">
            <form action="cart.php?name=<?=$row['name']?>" method="post">
                <?php
                $imageData = $row['image'];

                // Output the image data with appropriate MIME type
                $imageSrc = 'data:image/png;base64,' . base64_encode($imageData);
                ?>
                
                <img src="<?= $imageSrc ?>" style="height: 150px;" alt="<?= $row['name']; ?>">
                <h5><?= $row['name']; ?></h5>
                <h5>Rs.<?= number_format($row['price'], 2); ?></h5>

                <input type="hidden" name="name" value="<?= $row['name'] ?>">
                <input type="hidden" name="price" value="<?= $row['price'] ?>">
                <input type="number" name="quantity" value="1" class="form-control">

                <input type="submit" name="add_to_cart" class="btn btn-warning btn-block" value="Add to Cart">
            </form>
        </div>
        <?php } ?>
    <?php } ?>

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