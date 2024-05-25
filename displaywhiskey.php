<?php
// Retrieve the image ID from the query parameter
$id = $_GET['id'];

// Establish a database connection
$conn = new mysqli('localhost', 'root', '', 'Store');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute a query to select the image data based on the ID
$stmt = $conn->prepare("SELECT image, image_type FROM whiskey WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData, $imageType);
$stmt->fetch();

// Set the appropriate content type header based on the image type
header("Content-type: $imageType");

// Output the image data
echo $imageData;

// Close the statement and database connection
$stmt->close();
$conn->close();
?>