<?php
require 'functions.php';

session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_POST['add_to_cart'])) {
        $productID = $_POST['product_id'];
        
        // Add the product to the cart array in $_SESSION
        $_SESSION['cart'][] = $productID;
        
        // Redirect to the same page or any other page as needed
        header('Location: bats.php');
        exit;
    }
    
// The amounts of products to show on each page
$num_products_on_each_page = 12;
// The current page - in the URL, will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

// Establish a database connection
$host = 'localhost';
$db = 'DecathlonSystem';
$user = 'root';
$password = '';

$conn = mysqli_connect('localhost','root','','DecathlonSystem');

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

// Select products ordered by the date added and filtered by category
$category = 'gloves'; // Filter by the category 'gloves'

// Build the query based on the selected category
$query = 'SELECT * FROM product';
if (!empty($category)) {
    // Use a prepared statement to avoid SQL injection
    $query .= " WHERE ProductCategory = :category";
}

$query .= ' ORDER BY ProductDateAdded DESC LIMIT :offset, :limit';

$stmt = $pdo->prepare($query);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':offset', ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products for pagination
$total_products = $pdo->prepare("SELECT COUNT(*) FROM product WHERE ProductCategory = :category");
$total_products->bindValue(':category', $category, PDO::PARAM_STR);
$total_products->execute();
$total_products = $total_products->fetchColumn();
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
    <?=generateSearchForm()?>

<div class="products content-wrapper">
    <h1>Gloves Products</h1>
    <p><?= $total_products ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
            <a href="productlogin.php?id=<?= $product['ProductID'] ?>" class="product">

                <img src="../images/<?= $product['ProductImage'] ?>" width="200" height="200" alt="<?= $product['ProductName'] ?>">
                <span class="name"><?= $product['ProductName'] ?></span>
                <span class="price">
                    &dollar;<?= $product['ProductPrice'] ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
            <a href="index.php?page=products&p=<?= $current_page - 1 ?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
            <a href="index.php?page=products&p=<?= $current_page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<!-- section footer start -->
<div class="copyright" style="background-color: #007dbc;">2023 All Rights Reserved. <a href="https://decathlon.com">Decathlon Baseball Store</a></div>
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
        
    </body>
    </html>