
<?php

session_start();
    include("../connection.php");
    include("../functions.php");
    
    function uploadDataToDatabase($itemType, $name, $price, $imageData){
        global $conn;
        $imageData = base64_encode($imageData);
        if(!empty($name) && !empty($price) && !empty($imageData)){
            $query = "INSERT INTO $itemType (name, price, image) VALUES ('$name', '$price', '$imageData')";

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
            $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

            uploadDataToDatabase($itemType, $name, $price, $imageData);
        } else {
            echo"Please select an image file!";
        }
    }

?>