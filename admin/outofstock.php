
<?php

session_start();
    include("../connection.php");
    include("../functions.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_stock'])) {
        $itemType = $_POST['item_type'];
        $productId = $_POST['product_type'];
    
        // Update the database to mark the product as out of stock
        $sql = "UPDATE $itemType SET stock = 'No' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            // echo "Stock updated successfully.";
            $_SESSION['update_message'] = "Stock updated successfully.";

        } else {
            // echo "Error updating stock: " . $conn->error;
            $_SESSION['update_message'] = "Error updating stock: " . $conn->error;

        }
        // Set a session variable to store the message
        $_SESSION['update_message_class'] = "alert-success"; // Set the class for styling
    }


?>
<?php
// Display cart message if it exists
if (isset($_SESSION['update_message'])) {
    echo "<div class='alert " . $_SESSION['update_message_class'] . "' id='update-message'>" . $_SESSION['update_message'] . "</div>";
    
    // Clear the message after displaying it
    unset($_SESSION['update_message']);
    unset($_SESSION['update_message_class']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Product OUT-OF-STOCK</title>
    <link rel="stylesheet" href="../newstyles.css">
    <link rel="stylesheet" href="../styles.css"> 
</head>
<body>
    <?php include'admin_header.php'; ?>

    <h2>Set Product OUT-OF-STOCK</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="item_type">Select Liquor Item:</label>
        <select name="item_type" id="item_type">
            <option value="vodka" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'vodka') echo 'selected'; ?>>Vodka</option>
            <option value="whiskey" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'whiskey') echo 'selected'; ?>>Whiskey</option>
            <option value="rum" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'rum') echo 'selected'; ?>>Rum</option>
            <option value="beer" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'beer') echo 'selected'; ?>>Beer</option>
            <option value="wine" <?php if(isset($_POST['item_type']) && $_POST['item_type'] == 'wine') echo 'selected'; ?>>Wine</option>
        </select>
        <input type="submit" value="OK">

    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
        <label for="product_type">Select Product:</label>
            <select name="product_type" id="product_type">
                <?php
                
                // Fetch products based on selected liquor item
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_type'])) {
                    $itemType = $_POST['item_type'];

                    // $sql = "SELECT id, name FROM $itemType"; // Assuming the table names match the liquor item values
                    $sql = "SELECT * FROM $itemType WHERE stock = 'Yes'";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                }

                $conn->close();
                ?>
            </select>
            <input type="hidden" name="item_type" value="<?php if(isset($_POST['item_type'])) echo $_POST['item_type']; ?>">
            <br><br>

        <input type="submit" name="update_stock" value="Update Stock">
    </form>


<script>
// JavaScript code to hide the alert after a few seconds
setTimeout(function() {
    document.getElementById('update-message').style.display = 'none';
}, 2000); // Adjust the time (in milliseconds) as needed
</script>

</body>
</html>

