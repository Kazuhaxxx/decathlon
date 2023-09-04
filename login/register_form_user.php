<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $UserEmailAddress = mysqli_real_escape_string($conn, $_POST['UserEmailAddress']);
   $UserPassword = md5($_POST['UserPassword']);
   $cpass = md5($_POST['cpassword']);
   $UserFirstName = mysqli_real_escape_string($conn, $_POST['UserFirstName']);
   $UserLastName = mysqli_real_escape_string($conn, $_POST['UserLastName']);
   $UserPhoneNum = mysqli_real_escape_string($conn, $_POST['UserPhoneNum']);
   $UserBirthDate = $_POST['UserBirthDate'];
   $UserGender = $_POST['UserGender'];
   $UserAddress = mysqli_real_escape_string($conn, $_POST['UserAddress']);

   $select = " SELECT * FROM user WHERE UserEmailAddress = '$UserEmailAddress' && UserPassword = '$UserPassword' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   }else{
      if($UserPassword != $cpass){
         $error[] = 'Passwords do not match!';
      }else{
         $insert = "INSERT INTO user(UserEmailAddress, UserPassword, UserFirstName, UserLastName, UserPhoneNum, UserBirthDate, UserGender, UserAddress) VALUES('$UserEmailAddress','$UserPassword','$UserFirstName','$UserLastName','$UserPhoneNum','$UserBirthDate','$UserGender','$UserAddress')";
         mysqli_query($conn, $insert);
         header('location:../Admin/index.html');
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
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>User Registration</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="UserEmailAddress" required placeholder="Enter your email">
      <input type="password" name="UserPassword" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <input type="text" name="UserFirstName" required placeholder="Enter your first name">
      <input type="text" name="UserLastName" required placeholder="Enter your last name">
      <input type="text" name="UserPhoneNum" required placeholder="Enter your phone number">
      <input type="date" name="UserBirthDate" required placeholder="Select your date of birth">
      <select name="UserGender" required>
         <option value="male">Male</option>
         <option value="female">Female</option>
      </select>
      <input type="text" name="UserAddress" required placeholder="Enter your address">

      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="../Admin/index.html">Login Now</a></p>
   </form>

</div>

</body>
</html>
