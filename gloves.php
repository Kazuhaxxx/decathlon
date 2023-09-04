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

<?=template_header('Product')?>

<?=generateSearchForm()?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?= $total_products ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
            <a href="product.php?id=<?= $product['ProductID'] ?>" class="product">

                <img src="images/<?= $product['ProductImage'] ?>" width="200" height="200" alt="<?= $product['ProductName'] ?>">
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

<?=template_footer()?>