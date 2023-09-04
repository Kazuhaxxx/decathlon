<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
   header('location: login_form.php');
}

if (isset($_GET['id'])) {
   $productID = $_GET['id'];

   // Delete the product from the database
   $stmt = $conn->prepare("DELETE FROM product WHERE ProductID = ?");
   $stmt->bind_param("i", $productID);
   $stmt->execute();

   // Check if the product is deleted successfully
   if ($stmt->affected_rows > 0) {
      // Product deleted successfully, redirect to a different page
      header('location: admin_page.php');
      exit(); // Stop further execution of the current script
   } else {
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
      
      <div class="form-container">
         <!-- Display the list of products -->
         <?php
         // Fetch all products from the database
         $query = "SELECT * FROM product";
         $result = mysqli_query($conn, $query);

         if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               $productID = $row['ProductID'];
               $productName = $row['ProductName'];
               $productCategory = $row['ProductCategory'];
               $productPrice = $row['ProductPrice'];
               $productQuantity = $row['ProductQuantity'];
               $productImage = $row['ProductImage'];  
               $productDateAdded = $row['ProductDateAdded'];
               ?>
               <div class="product-item">
                  <h4><?php echo $productName; ?></h4>
                  <p>Name: <?php echo $productName; ?></p>
                  <p>Category: <?php echo $productCategory; ?></p>
                  <p>Price: $<?php echo $productPrice; ?></p>
                  <p>Quantity: <?php echo $productQuantity; ?></p>
                  <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" width="100">
                  <p>Date Added: <?php echo $productDateAdded; ?></p>
                  <a href="admin_page_delete.php?id=<?php echo $productID; ?>" class="btn">Delete</a>
               </div>
               <?php
            }
         } else {
            echo "No products found.";
         }
         ?>
      </div>

      <a href="admin_page.php" class="btn">Back to Admin Page</a>
   </div>
</div>

</body>
</html>
