<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['CartID'])) {
    // Redirect to the login page
  header('Location: index.html');
  exit();
}

?>

<?php
// Include functions and start session
require 'functions.php';


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

<?=template_header2('Product')?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- mobile metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!-- site metas -->
        <title>Bats</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- style css -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="aboutus.css">
        <!-- Responsive-->
        <link rel="stylesheet" href="../css/responsive.css">
        <!-- fevicon -->
        <link rel="icon" href="../images/fevicon.png" type="image/gif" />
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
        <!-- Tweaks for older IEs-->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <!-- owl stylesheets --> 
        <link rel="stylesheet" href="../css/owl.carousel.min.css">
        <link rel="stylesheet" href="../css/owl.theme.default.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <body>
        <div class="product content-wrapper">
            <a href="product.php?page=product&id=<?= $product['ProductID'] ?>">
                <img src="../images/<?= $product['ProductImage'] ?>" width="500" height="500" alt="<?= $product['ProductName'] ?>">
            </a>
            <div>
                <h1 class="ProductName"><?=$product['ProductName']?></h1>
                <span class="ProductPrice">
                    &dollar;<?=$product['ProductPrice']?>
                </span>
                <form action="cartLogin.php" method="post" id="cart-form">
                    <input type="number" name="quantity" value="1" min="1" max="<?=$product['ProductQuantity']?>" placeholder="ProductQuantity" required>
                    <input type="hidden" name="product_id" value="<?=$product['ProductID']?>">
                    <input type="hidden" name="cart_id" value="<?=$_SESSION['CartID']; ?>">
                    <input type="submit" onclick="addToCart()" value="Add To Cart">
                </form>
                <div class="description">
                    <?=$product['ProductDesc']?>
                </div>
            </div>
        </div>
        
    </body>
    <!-- section footer start -->
    <footer>
        <div class="copyright" style="background-color: #007dbc;">2023 All Rights Reserved. <a href="https://decathlon.com">Decathlon Baseball Store</a></div>
    </footer>
</html>

    <!-- section footer end -->

    <!-- Javascript files-->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.0.0.min.js"></script>
    <script src="../js/plugin.js"></script>
    <!-- sidebar -->
    <!-- javascript --> 
    <script src="../js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function(){
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $('#myCarousel').carousel({
        interval: false
    });

    // Scroll slides on swipe for touch-enabled devices
    $("#myCarousel").on("touchstart", function(event){
        var yClick = event.originalEvent.touches[0].pageY;
        $(this).one("touchmove", function(event){
            var yMove = event.originalEvent.touches[0].pageY;
            if (Math.floor(yClick - yMove) > 1) {
                $(".carousel").carousel('next');
            } else if (Math.floor(yClick - yMove) < -1) {
                $(".carousel").carousel('prev');
            }
        });
    });

    $(".carousel").on("touchend", function(){
        $(this).off("touchmove");
    });
    });

    </script> 

<script>
function addToCart() {
  alert('Item has been added to cart!');
}
</script>
