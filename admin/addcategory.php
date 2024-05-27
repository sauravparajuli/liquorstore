
<?php

session_start();
include("../connection.php");
include("../functions.php");

function uploadDataToDatabase($tableName, $name, $price, $imageData, $imageType) {

    global $conn;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO $tableName (name, price, image, image_type) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $null = NULL;
    $stmt->bind_param('sdbs', $name, $price, $null, $imageType);
    $stmt->send_long_data(2, $imageData);

    // Execute the statement
    if ($stmt->execute()) {
        // echo "Data and image uploaded successfully.";
        $_SESSION['update_message'] = "Data and image uploaded successfully.";

    } else {
        $_SESSION['update_message'] = "Failed to upload data and image: " . $stmt->error;
        // echo "Failed to upload data and image: " . $stmt->error;
    }
    $_SESSION['update_message_class'] = "alert-success"; // Set the class for styling


    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']['tmp_name'])) {
    $itemType = $_POST['item_type'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['tmp_name'];
    $imageType = $_FILES['image']['type'];
    $imageData = file_get_contents($image);

    uploadDataToDatabase($itemType, $name, $price, $imageData, $imageType);
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
    <title>Upload Liquor Product</title>
</head>
<body>
    <?php include'admin_header.php'; ?>

    <h2>Upload Liquor Product</h2>
    <form target="_blank" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="item_type">Select Liquor Item:</label>
        <select name="item_type" id="item_type">
            <option value="vodka">Vodka</option>
            <option value="whiskey">Whiskey</option>
            <option value="rum">Rum</option>
            <option value="beer">Beer</option>
            <option value="wine">Wine</option>
        </select><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price"><br><br>

        <label for="image">Choose Image:</label>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Upload">
    </form>


<script>
// JavaScript code to hide the alert after a few seconds
setTimeout(function() {
    document.getElementById('update-message').style.display = 'none';
}, 2000); // Adjust the time (in milliseconds) as needed
</script>


</body>
</html>
