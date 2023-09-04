<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = md5($_POST['password']);

   $selectUser = "SELECT * FROM user WHERE UserEmailAddress = '$email' AND UserPassword = '$password'";
   $selectAdmin = "SELECT * FROM admin WHERE AdminEmailAddress = '$email' AND AdminPassword = '$password'";

   $resultUser = mysqli_query($conn, $selectUser);
   $resultAdmin = mysqli_query($conn, $selectAdmin);

   if(mysqli_num_rows($resultUser) > 0){
      $row = mysqli_fetch_array($resultUser);
      $_SESSION['user_name'] = $row['UserFirstName'];
      header('location: ../indexlogin.php');
   } elseif(mysqli_num_rows($resultAdmin) > 0) {
      $row = mysqli_fetch_array($resultAdmin);
      $_SESSION['admin_name'] = $row['AdminName'];
      header('location: ../Admin/home.php');
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $errorMsg){
            echo '<span class="error-msg">'.$errorMsg.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
   </form>

</div>

</body>
</html>
