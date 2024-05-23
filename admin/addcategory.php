
<?php

session_start();
    include("../connection.php");
    include("../functions.php");

    function uploadDataToDatabase($itemType, $name, $price, $imageData){
        global $conn;
        //$imageData = base64_encode($imageData);
        if(!empty($name) && !empty($price) && !empty($imageData)){
            $query = "INSERT INTO $itemType (name, price, image) VALUES ('$name', '$price', $imageData)";

            if ($conn->query($query) === TRUE) {
                echo "Data uploaded successfully.";
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        } else {
            echo"Please enter all the information!";

        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_FILES["image"])){
            $itemType = $_POST["item_type"];
            $name = $_POST["name"];
            $price = $_POST['price'];
//            $imageData = $_FILES['image'];
            $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

            //$imageData = file_get_contents($_FILES["image"]["tmp_name"]);
            // echo $imageData;
            // echo $imageSrc;
            uploadDataToDatabase($itemType, $name, $price, $imageData);
        } else {
            echo"Please select an image file!";
        }
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
</body>
</html>
