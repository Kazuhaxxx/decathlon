<?php
    include 'db_connect.php';

    // Get the CartID from the session
    session_start();
    $cartID = $_SESSION['CartID'];

    // Delete all products from the cart with the same CartID
    $query = "DELETE FROM cart_product WHERE CartID='$cartID'";
    $result = mysqli_query($link, $query) or die("Query failed");
    if ($result) {
        header("location: placeorderlogin.php");
    } else {
        echo "Problem occurred!";
    }

    mysqli_close($link);
?>
