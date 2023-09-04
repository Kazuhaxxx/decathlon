<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $AdminEmailAddress = mysqli_real_escape_string($conn, $_POST['AdminEmailAddress']);
   $AdminPassword = md5($_POST['AdminPassword']);
   $cpass = md5($_POST['cpassword']);
   $AdminName = mysqli_real_escape_string($conn, $_POST['AdminName']);
   $AdminPhoneNum = mysqli_real_escape_string($conn, $_POST['AdminPhoneNum']);

   $select = " SELECT * FROM admin WHERE AdminEmailAddress = '$AdminEmailAddress' && AdminPassword = '$AdminPassword' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'Admin already exists!';
   }else{
      if($AdminPassword != $cpass){
         $error[] = 'Passwords do not match!';
      }else{
         $insert = "INSERT INTO admin(AdminEmailAddress, AdminPassword, AdminName, AdminPhoneNum) VALUES('$AdminEmailAddress','$AdminPassword','$AdminName','$AdminPhoneNum')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Registration Form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Admin Registration</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="AdminEmailAddress" required placeholder="Enter your email">
      <input type="password" name="AdminPassword" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <input type="text" name="AdminName" required placeholder="Enter your name">
      <input type="text" name="AdminPhoneNum" required placeholder="Enter your phone number">

      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login Now</a></p>
   </form>

</div>

</body>
</html>
