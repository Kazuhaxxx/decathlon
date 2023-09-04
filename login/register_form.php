<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <script>
      function redirectToForm() {
         var userType = document.getElementById("user_type").value;
         if (userType === "user") {
            window.location.href = "register_form_user.php";
         } else if (userType === "admin") {
            window.location.href = "register_form_admin.php";
         }
      }
   </script>

</head>
<body>
   
   <div class="form-container">
   
      <form>
         <h3>register now</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         <select id="user_type" name="user_type">
            <option value="user">user</option>
            <option value="admin">admin</option>
         </select>
         <input type="button" onclick="redirectToForm()" value="register now" class="form-btn">
         <p>Already have an account? <a href="login_form.php">Login Now</a></p>
      </form>
   
   </div>

</body>
</html>
