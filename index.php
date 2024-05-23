<?php
session_start();
    include("connection.php");
    include("functions.php");
    $user_data = check_login($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- main styles -->
    <!-- <link rel="stylesheet" href="newstyles.css"> -->
    <link rel="stylesheet" href="styles.css"> 


</head>
<body>

    <!-- <a href="logout.php">Logout</a>
    <h1>This is the main page</h1>
    <?php include 'header.php'; ?>


    <?php include 'main.php';?>
    <?php include 'footer.php';?>


    

</body>
</html>