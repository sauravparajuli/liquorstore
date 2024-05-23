
<?php
session_start();
    include("../connection.php");
    // include("../functions.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- main styles -->
    <link rel="stylesheet" href="../newstyles.css">
    <link rel="stylesheet" href="../styles.css"> 


</head>
<body>

    <!-- <a href="logout.php">Logout</a>
    <h1>This is the main page</h1> -->

    <?php include ('admin_header.php');?>
    <h2>This is the Admin Panel</h2>

    <!-- <script src="script.js"></script>
    <script src="displayproduct.js"></script> -->

</body>
</html>