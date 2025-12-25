<?php
session_start();
require_once 'db.php';

if (isset($_POST['register'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $email_address=$_POST['email_address'];
    $date_of_birth=$_POST['date_of_birth'];
    $search="SELECT * FROM users WHERE email_address='$email_address'";
    $result=mysqli_query($conn,$search);
    $affrows=mysqli_num_rows($result);
        if ($affrows==0){
          $sql="INSERT INTO users (username,password,email_address,date_of_birth) VALUES ('$username','$hash','$email_address','$date_of_birth')";
          $data=mysqli_query($conn,$sql);
                if($data){
                    echo "<script> 
                            alert('You have registered successfully');
                            alert('PLease Log in');
                            window.location.href='login.php';
                          </script>";
     }}
    else{
        echo "<script> 
                    alert('This email is currently in use');
                    alert('Please Log in');
                    window.location.href = 'login.php';
              </script>";
    }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | DRiVE</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>

    <!-- NAVBAR -->
   

       <nav class="navbar">
    <a href="home2.html" class="logo">DRIVE</a>

      <ul class="nav-links">
                <li><a href="home2.html">Home</a></li>
       <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="car_details.html">Car Details</a></li>
        <li><a href="Reservations.html">Reservation</a></li>
        <li><a href="myReservations.html">My Reservations</a></li>
    </ul>


    </nav>

    <!-- REGISTER CARD -->
    <div id="outdiv">
        <p id="p1">Create Your Account</p>
        <p id="p2">Join our car rental system</p>

        <form action="register.php" method="post">

            <div id="indivs">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div id="indivs">
                <label>Email Address</label>
                <input type="email" name="email_address" required>
            </div>

            <div id="indivs">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div id="indivs">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" required>
            </div>

            <input type="submit" id="register" name="register" value="Register">
        </form>

        <input
            type="button"
            id="login"
            value="Already have an account? Login"
            onclick="window.location.href='login.php'">
    </div>

</body>
</html>
