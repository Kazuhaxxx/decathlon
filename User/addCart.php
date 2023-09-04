<?php 
include 'db_connect.php';
           //assign textbox to variable
	   $add_cartID=$_POST['cart_id']; 
       $add_productID=$_POST['product_id']; 
       $add_quantity=$_POST['quantity'];
 
                //insert data
	   $query= "INSERT INTO cart_product(CartID,ProductID,ItemQuantity) VALUES ('$add_cartID','$add_productID','$add_quantity')" ;		
	   $result = mysqli_query( $link,$query) or die("Query failed");	// SQL statement for checking
         //checking either success or not
                 if ($result)
                 header("location:cartlogin.php");	
		 
		else
		 echo "Problem occured !"; 	
	    mysqli_close($link);
?>