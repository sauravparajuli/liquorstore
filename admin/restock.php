
<?php

session_start();
    include("../connection.php");
    include("../functions.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_stock'])) {
        $itemType = $_POST['item_type'];
        $productId = $_POST['product_type'];
    
        // Update the database to mark the product as in stock
        $sql = "UPDATE $itemType SET stock = 'Yes' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            echo "Stock updated successfully.";
        } else {
            echo "Error updating stock: " . $conn->error;
        }
    }   
    


    if(isset($_POST["update_stock"])){
        // Set a session variable to store the message
        $_SESSION['stockupdate_message'] = "Stock updated successfully.";
        $_SESSION['stockupdate_message_class'] = "alert-success"; // Set the class for styling
    
    }
    // Display cart message if it exists
    if (isset($_SESSION['stockupdate_message'])) {
        echo "<div class='alert " . $_SESSION['stockupdate_message_class'] . "' id='stockupdate-message'>" . $_SESSION['stockupdate_message'] . "</div>";
        
        // Clear the message after displaying it
        unset($_SESSION['stockupdate_message']);
        unset($_SESSION['stockupdate_message_class']);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restock Product</title>
</head>
<body>
    <?php include'admin_header.php'; ?>

    <h2>Restock Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="item_type">Select Liquor Item:</label>
        <select name="item_type" id="item_type">
            <option value="vodka" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'vodka') echo 'selected'; ?>>Vodka</option>
            <option value="whiskey" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'whiskey') echo 'selected'; ?>>Whiskey</option>
            <option value="rum" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'rum') echo 'selected'; ?>>Rum</option>
            <option value="beer" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'beer') echo 'selected'; ?>>Beer</option>
            <option value="wine" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'wine') echo 'selected'; ?>>Wine</option>
        </select>
        <input type="submit" value="Check">

    </form>

    <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_type'])) {

            $itemType = $_POST['item_type'];

            // Query the corresponding table in the database based on the selected item_type
            $sql = "SELECT * FROM $itemType WHERE stock = 'No'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="product_type">Select Product:</label>
                        <select name="product_type" id="product_type">
                        <?php
                        // Display the products retrieved from the database in another form
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            
                        }
                        ?>
                        </select>
                        <input type="hidden" name="item_type" value="<?php if(isset($_POST['item_type'])) echo $_POST['item_type']; ?>">
                        <br><br>
                    <input type="submit" name="update_stock" id="update_stock" value="Update Stock">
                </form>
                <?php
            } else { ?>
            <h5>No Products Out Of Stock</h5>
            <?php
            }
        }
        ?>

<script>
// JavaScript code to hide the alert after a few seconds
setTimeout(function() {
    document.getElementById('stockupdate-message').style.display = 'none';
}, 2000); // Adjust the time (in milliseconds) as needed
</script>



</body>
</html>

