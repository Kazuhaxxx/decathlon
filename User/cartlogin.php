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
require_once 'functions.php';

$allItems = []; // Initialize $allItems as an empty array
$subtotal = 0.00;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        include 'db_connect.php';
        $productID = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $cartID = $_POST['cart_id'];

        // Add the product to the cart
        $_SESSION['cart'][$productID] = $quantity;
        $query= "INSERT INTO cart_product(CartID,ProductID,ItemQuantity) VALUES ('$cartID','$productID','$quantity')" ;		
	   $result = mysqli_query( $link,$query) or die("Query failed");
        // Redirect the user back to the product page or any other desired page
    }
}

// If the user clicked the add to cart button on the product page, check for the form data
if (isset($_POST['ProductID'], $_POST['ProductQuantity']) && is_numeric($_POST['ProductID']) && is_numeric($_POST['ProductQuantity'])) {
    // Set the post variables so we can easily identify them, also make sure they are integers
    $product_id = (int)$_POST['ProductID'];
    $quantity = (int)$_POST['ProductQuantity'];

    // Establish a database connection
    $pdo = pdo_connect_mysql();

    // Prepare the SQL statement, checking if the product exists in the database
    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID = ?');
    $stmt->execute([$product_id]);

    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in the database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart, so just update the quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart, so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in the cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }

    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}


// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
    foreach ($_POST as $key => $value) {
        include 'db_connect.php';
        if (strpos($key, 'quantity-') !== false) {
            $productID = str_replace('quantity-', '', $key);
            $quantity = (int) $value;

            if (is_numeric($productID) && isset($_SESSION['cart'][$productID]) && $quantity > 0) {
                $_SESSION['cart'][$productID] = $quantity;

                $query="Update cart_product set ItemQuantity='$quantity' where ProductID='$productID'" ;
                $result = mysqli_query( $link,$query) or die("Query failed");
            }
        }
    }

    // Redirect to cart.php to prevent form resubmission
    header('Location: cartlogin.php');
    exit;
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo '';
} else {
    // Check if the remove parameter is set in the URL
    if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
        // Get the product ID to remove
        $remove_id = (int)$_GET['remove'];

        // Check if the product ID exists in the cart session
        if (isset($_SESSION['cart'][$remove_id])) {
            // Remove the product from the cart
            unset($_SESSION['cart'][$remove_id]);
        }
    }

    // Cart is not empty, display the cart items
    // Get the product IDs from the session cart array
    $product_ids = array_keys($_SESSION['cart']);

    // Establish a database connection
    $pdo = pdo_connect_mysql();

    // Prepare the SQL statement, we are using a WHERE IN clause to select multiple product IDs
    $stmt = $pdo->prepare('SELECT * FROM product WHERE ProductID IN (' . implode(',', $product_ids) . ')');
    $stmt->execute();

    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the subtotal
    foreach ($products as $product) {
        $productID = $product['ProductID'];
        $quantity = $_SESSION['cart'][$productID];

        // Calculate the subtotal for the item (price * quantity)
        $subtotalItem = $product['ProductPrice'] * $quantity;

        // Add the item and its subtotal to the $allItems array
        $allItems[] = [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotalItem
        ];

        // Add the subtotal for this item to the grand total
        $subtotal += $subtotalItem;
    }
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Establish a database connection
    $pdo = pdo_connect_mysql();

    // Update the cart table with the ProductID and ProductQuantity
    $stmt = $pdo->prepare('UPDATE cart SET ProductID = ?, ProductQuantity = ? WHERE CartID = ? AND UserID = ?');
    $cartID = uniqid();
    $userID = $_SESSION['user']['UserID'];
    foreach ($products as $product) {
        $productID = $product['ProductID'];
        $quantity = (int)$_SESSION['cart'][$productID];
        $stmt->execute([$productID, $quantity, $cartID, $userID]);
    }

    // Clear the cart
    $_SESSION['cart'] = array();

    // Redirect to the place order page
    header('Location: placeorderlogin.php');
    exit;
}

?>

<?=template_header2('Cart')?>

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
</body>
</html>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form method="post" action="cartlogin.php">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>

            

            <?php
// Include the database connection file
include 'db_connect.php';

// Retrieve the CartID from the session
$cart_id = $_SESSION['CartID'];

// Retrieve the cart products from the cart_product table
$query = "SELECT cp.*, p.ProductImage, p.ProductName, p.ProductPrice, p.ProductQuantity
          FROM cart_product cp
          JOIN product p ON cp.ProductID = p.ProductID
          WHERE cp.CartID = '$cart_id'";
$result = mysqli_query($link, $query) or die("Query failed");

if (mysqli_num_rows($result) > 0) {
    // Display the shopping cart
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td class="img">
                <a href="index.php?page=product&id=<?= $row['ProductID'] ?>">
                    <img src="../images/<?= $row['ProductImage'] ?>" width="50" height="50"
                         alt="<?= $row['ProductName'] ?>">
                </a>
            </td>
            <td>
                <a href="index.php?page=product&id=<?= $row['ProductID'] ?>"><?= $row['ProductName'] ?></a>
                <br>
                <a href="deleteCart.php?remove=<?= $row['ProductID'] ?>" class="remove">Remove</a>
            </td>
            <td class="price">&dollar;<?= $row['ProductPrice'] ?></td>
            <td class="quantity">
                <input type="number" name="quantity-<?= $row['ProductID'] ?>" value="<?= $row['ItemQuantity'] ?>"
                       min="1" max="<?= $row['ProductQuantity'] ?>" placeholder="Quantity" required>
            </td>
            <td class="price">&dollar;<?= number_format($row['ItemQuantity'] * $row['ProductPrice'], 2) ?></td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
    </tr>
    <?php
}
?>


            </tbody>
        </table>

        <div class="subtotal">
            <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
            <td class="text-right"><span id="subtotal"></span></td>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <input type="button" value="Check Out" onclick="location.href='placeorderlogin.php'" />
            <?php else: ?>
                <input type="button" value="Check Out" onclick="location.href='cartlogin.php'" />
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- section footer start -->
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
    // Function to clear the cart using JavaScript
    function clearCart() {
        // Clear the cart form by resetting its HTML content
        document.getElementById('cart-form').innerHTML = '';

        // Clear the cart in the session
        fetch('clear_cart.php')
            .then(response => {
                if (response.ok) {
                    // Update the cart count in the header
                    var numItemsInCart = 0; // Set the number of items in cart to 0
                    var cartCountElement = document.querySelector('.link-icons span');
                    cartCountElement.innerHTML = numItemsInCart;
                }
            })
            .catch(error => {
                console.error('Error clearing cart:', error);
            });
    }
</script>

<script>
    $(document).ready(function () {
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });

        $('#myCarousel').carousel({
            interval: false
        });

        // Scroll slides on swipe for touch-enabled devices
        $("#myCarousel").on("touchstart", function (event) {
            var yClick = event.originalEvent.touches[0].pageY;
            $(this).one("touchmove", function (event) {
                var yMove = event.originalEvent.touches[0].pageY;
                if (Math.floor(yClick - yMove) > 1) {
                    $(".carousel").carousel('next');
                } else if (Math.floor(yClick - yMove) < -1) {
                    $(".carousel").carousel('prev');
                }
            });
        });

        $(".carousel").on("touchend", function () {
            $(this).off("touchmove");
        });
    });
</script>

<script>
    // Calculate and display the subtotal dynamically
    function updateSubtotal() {
        let subtotal = 0;

        // Iterate through each row in the table body
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row) => {
            // Get the quantity and price from each row
            const quantity = parseInt(row.querySelector('.quantity input').value);
            const price = parseFloat(row.querySelector('.price').innerText.replace('$', ''));

            // Calculate the subtotal for the row
            const rowSubtotal = quantity * price;

            // Add the row subtotal to the overall subtotal
            subtotal += rowSubtotal;
        });

        // Update the total subtotal in the table footer
        document.getElementById('subtotal').innerText = `$${subtotal.toFixed(2)}`;
    }

    // Attach event listener to the Update button
    const updateButton = document.querySelector('input[name="update"]');
    updateButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission
        updateSubtotal(); // Update the subtotal
        this.closest('form').submit(); // Submit the form
    });

    // Call the updateSubtotal function initially
    window.addEventListener('DOMContentLoaded', updateSubtotal);
</script>


<?=template_footer()?>