
<?php

session_start();
    include("../connection.php");
    include("../functions.php");

    function removeProductFromDatabase($itemType, $productId) {
        global $conn;
    
        // Perform deletion query
        $sql = "DELETE FROM $itemType WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
    
        if ($stmt->execute()) {
            echo "Product removed successfully.";
        } else {
            echo "Error removing product: " . $conn->error;
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['product_type'])) {
            $itemType = $_POST['item_type'];
            $productId = $_POST['product_type'];
    
            removeProductFromDatabase($itemType, $productId);
        } else {
            echo "Please select a product to remove.";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Selection</title>
</head>
<body>
    <?php include'admin_header.php'; ?>

    <h2>Product Selection</h2>
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

                    $sql = "SELECT id, name FROM $itemType"; // Assuming the table names match the liquor item values

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

        <input type="submit" value="Remove">
    </form>



</body>
</html>

