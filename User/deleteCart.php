<?php 
	include 'db_connect.php';

	//delete data
	$delete_id=$_GET['remove']; 
	$query = "DELETE FROM  cart_product WHERE ProductID='$delete_id'";
	$result = mysqli_query( $link,$query) or die("Query failed");
	if ($result)
	header("location:cartLogin.php?remove=$delete_id"); 
		else
	echo "Problem occured !"; 
	
	mysqli_close($link);   
?>