<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
   header('location: login_form.php');
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get the form data
   $productName = $_POST['ProductName'];
   $productCategory = $_POST['ProductCategory'];
   $productPrice = $_POST['ProductPrice'];
   $productQuantity = $_POST['ProductQuantity'];
   $productImage = "../images/" . $_POST['ProductImage']; // Prepend 'images/' to the image filename
   $productDateAdded = $_POST['ProductDateAdded'];

   // Prepare and execute the SQL query to insert data into the database
   $stmt = $conn->prepare("INSERT INTO product (ProductName, ProductCategory, ProductPrice, ProductQuantity, ProductImage, ProductDateAdded) VALUES (?, ?, ?, ?, ?, ?)");
   $stmt->bind_param("ssdiss", $productName, $productCategory, $productPrice, $productQuantity, $productImage, $productDateAdded);
   $stmt->execute();

   // Check if the data is inserted successfully
   if ($stmt->affected_rows > 0) {
      // Data inserted successfully, redirect to a different page
      header('location: admin_page.php');
      exit(); // Stop further execution of the current script
   } else {
      echo "Error inserting data.";
   }

   // Close the statement
   $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .centered-input {
         text-align: center;
      }
   </style>
</head>
<body>
   
<div class="container">
   <div class="content">
      <h3>Hi, <span>admin</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      <div class="form-container">
         <form name="addProduct" method="post" action="">
            <label for="ProductName">Product Name:</label>
            <input name="ProductName" type="text" id="ProductName" class="centered-input" required>
            
            <label for="ProductCategory">Product Category:</label>
            <input name="ProductCategory" type="text" id="ProductCategory" class="centered-input" required>
            
            <label for="ProductPrice">Product Price:</label>
            <input name="ProductPrice" type="number" step="0.01" id="ProductPrice" class="centered-input" required>
            
            <label for="ProductQuantity">Product Quantity:</label>
            <input name="ProductQuantity" type="number" id="ProductQuantity" class="centered-input" required>
            
            <label for="ProductImage">Product Image:</label>
            <input name="ProductImage" type="text" id="ProductImage" class="centered-input" required>
            
            <label for="ProductDateAdded" class="faded-text">Product Date Added:</label>
            <input name="ProductDateAdded" type="datetime-local" id="ProductDateAdded" class="centered-input" required>

            <input type="submit" name="Submit" value="Submit">
         </form>
      </div>

      <a href="admin_page.php" class="btn">Back to Admin Page</a>
   </div>
</div>

</body>
</html>
