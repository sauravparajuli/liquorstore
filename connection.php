
<?php

// Database connection
$servername = "localhost"; // Change it according to your database host
$username = "root"; // Change it according to your database username
$password = ""; // Change it according to your database password
$dbname = "Store"; // Change it according to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo"Connection successful";
}

?>