<?php

session_start();
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_POST['email'];

        $password = $_POST['password'];

        if(!empty($email) && !empty($password)){
            
            //read from database
            $query = "select * from users where email = '$email' limit 1";

            $result = mysqli_query( $conn, $query );
            if($result){
                if($result && mysqli_num_rows($result) > 0){
                    $user_data = mysqli_fetch_assoc($result);
                    if($user_data['password'] === $password){
                        $_SESSION['email'] = $user_data['email'];
                        header("Location: index.php");
                        die;
                    }
                }
            }
            echo"Wrong email or password!";
        } else {
            echo"Please enter some valid information!";
        }
    }
    // // Check if the admin is already logged in
    // if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    //     // Redirect to admin page if already logged in
    //     header("Location: admin/admin_page.php");
    //     exit;
    // }

    // Check if login form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        // Check if email and password are provided
        if(isset($_POST['email']) && isset($_POST['password'])) {
            // Validate admin credentials (this is a basic example, you should use a secure method like password hashing)
            $admin_email = "admin@example.com"; // Admin email
            $admin_password = "admin123"; // Admin password (hashed password should be used in production)

            // Check if provided email and password match the admin credentials
            if($_POST['email'] == $admin_email && $_POST['password'] == $admin_password) {
                // Admin login successful, set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_email'] = $admin_email;

                // Redirect to admin page
                header("Location: admin/admin_page.php");
                exit;
            } else {
                // Invalid email or password
                $error_message = "Invalid email or password.";
            }
        } else {
            // Email or password not provided
            $error_message = "Please enter both email and password.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup</title>
    <link rel="stylesheet" href="newstyles.css">
</head>
<body>
    <div class="container">
        <div id="login-form">
            <form method="post" action="login.php">
                <h2>Login</h2>
                <input type="email" id="login-email" name="email" placeholder="Email">
                <input type="password" id="login-password" name="password" placeholder="Password">
                <input type="submit" name="login" value="Login">
                <!-- <button onclick="login()">Login</button> <br> -->
                <a href="signup.php">Don't have an account?</a>
            </form>

        </div>
        
    </div>
    <!-- <script src="script.js"></script> -->
</body>
</html>
