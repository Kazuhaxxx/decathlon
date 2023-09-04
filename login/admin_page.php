<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
   header('location: login_form.php');
   exit();
}

// Check if the form is submitted for adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit'])) {
   // Get the form data
   $productName = $_POST['ProductName'];
   $productCategory = $_POST['ProductCategory'];
   $productPrice = $_POST['ProductPrice'];
   $productQuantity = $_POST['ProductQuantity'];
   $productImage = $_POST['ProductImage'];
   $productDateAdded = $_POST['ProductDateAdded'];

   // Prepare and execute the SQL query to insert data into the database
   $stmt = $conn->prepare("INSERT INTO product (ProductName, ProductCategory, ProductPrice, ProductQuantity, ProductImage, ProductDateAdded) VALUES (?, ?, ?, ?, ?, ?)");
   $stmt->bind_param("ssdiss", $productName, $productCategory, $productPrice, $productQuantity, $productImage, $productDateAdded);

   // Check if the data is inserted successfully
   if ($stmt->execute()) {
      echo "Data inserted successfully.";
   } else {
      echo "Error inserting data.";
   }

   // Close the statement
   $stmt->close();
}

// Check if the product ID is provided for deletion
if (isset($_GET['id'])) {
   $productID = $_GET['id'];

   // Prepare and execute the SQL query to delete the product from the database
   $stmt = $conn->prepare("DELETE FROM product WHERE ProductID = ?");
   $stmt->bind_param("i", $productID);

   if ($stmt->execute()) {
      // Product deleted successfully
      header('location: admin_page.php');
      exit();
   } else {
      // Failed to delete product
      echo "Failed to delete product. Please try again.";
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
      
      <a href="admin_page_add.php" class="btn">Add Item</a>
      <a href="admin_page_delete.php" class="btn">Delete Item</a>

      <p>This is an admin page</p>
      <a href="login_form.php" class="btn">Login</a>
      <a href="register_form.php" class="btn">Register</a>
      <a href="logout.php" class="btn">Logout</a>
   </div>
</div>

</body>
</html>
