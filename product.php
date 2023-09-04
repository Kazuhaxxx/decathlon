<?php
// product.php


// Include functions and start session
require 'functions.php';
session_start();

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    
    // Establish a database connection
    $host = 'localhost';
    $db = 'DecathlonSystem';
    $user = 'root';
    $password = '';
    
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID = :id');
    $stmt->bindParam(':id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exist (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?=template_header('Product')?>

<div class="product content-wrapper">
    <a href="product.php?page=product&id=<?= $product['ProductID'] ?>">
        <img src="images/<?= $product['ProductImage'] ?>" width="500" height="500" alt="<?= $product['ProductName'] ?>">
    </a>
    <div>
        <h1 class="ProductName"><?=$product['ProductName']?></h1>
        <span class="ProductPrice">
            &dollar;<?=$product['ProductPrice']?>
        </span>
        <form action="cart.php" method="post" id="cart-form">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['ProductQuantity']?>" placeholder="ProductQuantity" required>
            <input type="hidden" name="product_id" value="<?=$product['ProductID']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product['ProductDesc']?>
        </div>
    </div>
</div>

<?=template_footer()?>

<script>
    document.getElementById('cart-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        var form = this;
        var formData = new FormData(form);
        
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(function (response) {
            if (response.ok) {
                location.href = 'cart.php'; // Redirect to cart.php if successful
            } else {
                alert('An error occurred. Please try again.'); // Display error message if request fails
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.'); // Display error message if an exception occurs
        });
    });
</script>