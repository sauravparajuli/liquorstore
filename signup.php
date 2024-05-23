<?php
session_start();
    include("connection.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $dob = $_POST['dob'];
        $password = $_POST['password'];

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($phone) && !empty($dob) && !empty($password) && !empty($password)){
            
            //save to database
            $query = "INSERT INTO Users (firstname, lastname, email, phone_number, address, date_of_birth, password)
            VALUES ('$firstname', '$lastname', '$email', '$phone', '$address', '$dob', '$password')";

            mysqli_query( $conn, $query );

            header("Location: index.php");
            die;
        } else {
            echo"Please enter some valid information!";
        }
    }


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="newstyles.css">
</head>
<body>
    <div class="container">
        <div id="signup-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h2>Signup</h2>
                <input type="text" id="signup-firstname" name="firstname" placeholder="First Name">
                <input type="text" id="signup-lastname" name="lastname" placeholder="Last Name">
                <input type="email" id="signup-email" name="email" placeholder="Email">
                <input type="tel" id="signup-phone" name="phone" placeholder="Phone Number">
                <input type="text" id="signup-address" name="address" placeholder="Address">
                <input type="date" id="signup-dob" name="dob" placeholder="Date of Birth">
                <input type="password" id="signup-password" name="password" placeholder="Password">
                <input type="password" id="signup-confirm-password" name="password" placeholder="Confirm Password">
                <input type="submit" name="signup" value="Signup">
                <!-- <button onclick="signup()">Signup</button> -->
            </form>

        </div>
    </div>
</body>
</html>