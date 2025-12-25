<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
   $email_entered=$_POST['email_address'];
   $password_entered=$_POST['password'];
   $sql="SELECT * FROM users WHERE email_address='$email_entered'";
   $result=mysqli_query($conn,$sql);
   $affrows=mysqli_num_rows($result);
     if($affrows==1){
        $user = mysqli_fetch_assoc($result);
           if(password_verify($password_entered, $user['password'])){
               $_SESSION['user_id'] = $user['user_id'];
               $_SESSION['username'] = $user['username'];
               $_SESSION['email'] = $user['email_address'];
               echo "<script>
                       alert('You logged in successfully');
                       window.location.href = 'home2.html';
                    </script>";
        } else {
            echo "<script>
                alert('Your password is incorrect');
                window.location.href = window.location.href;
                  </script>";
        }} else {
        echo "<script>
            alert('You have not registered before');
            alert('Please register first');
            window.location.href = 'register.php';
        </script>";
}}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CarGo</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">CarGo</div>
    <ul class="nav-links">
        <li><a href="home2.html">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="car_details.html">Car Details</a></li>
        <li><a href="Reservations.html">Reservation</a></li>
        <li><a href="myReservations.html">My Reservations</a></li>
    </ul>
</nav>

<!-- LOGIN FORM -->
<div class="login-container">
    <h1>Welcome Back</h1>

    <form>
        <label>Email</label>
        <input type="email" required>

        <label>Password</label>
        <input type="password" required>

        <button type="submit">Login</button>
    </form>

    <p class="register-text">
        Don’t have an account?
        <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>
