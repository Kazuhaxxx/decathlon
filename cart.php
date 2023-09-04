<?php
require_once 'functions.php';
@include 'config.php';
session_start();
// Establish a database connection
$pdo = pdo_connect_mysql();
$allItems = []; // Initialize $allItems as an empty array
$subtotal = 0.00;



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $productID = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        
        // Add the product to the cart
        $_SESSION['cart'][$productID] = $quantity;
        
        // Redirect the user back to the product page or any other desired page
        header('Location: index.php?page=product&id=' . $productID);
        exit;
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
        if (strpos($key, 'quantity-') !== false) {
            $productID = str_replace('quantity-', '', $key);
            $quantity = (int) $value;

            if (is_numeric($productID) && isset($_SESSION['cart'][$productID]) && $quantity > 0) {
                $_SESSION['cart'][$productID] = $quantity;
            }
        }
    }
    
    // Redirect to cart.php to prevent form resubmission
    header('Location: cart.php');
    exit;
}

// Function to get the number of items in the cart
function get_num_items_in_cart() {
    if (isset($_SESSION['cart'])) {
        $num_items = array_sum($_SESSION['cart']);
        return $num_items;
    } else {
        return 0;
    }
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
    header('Location: placeorder.php');
    exit;
}
?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form method="post" action="cart.php">
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
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=product&id=<?=$product['ProductID']?>">
                                    <img src="images/<?=$product['ProductImage']?>" width="50" height="50" alt="<?=$product['ProductName']?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=product&id=<?=$product['ProductID']?>"><?=$product['ProductName']?></a>
                                <br>
                                <a href="cart.php?remove=<?=$product['ProductID']?>" class="remove">Remove</a>
                            </td>
                            <td class="price">&dollar;<?=$product['ProductPrice']?></td>
                            <td class="quantity">
                                <input type="number" name="quantity-<?=$product['ProductID']?>" value="<?=$_SESSION['cart'][$product['ProductID']]?>" min="1" max="<?=$product['ProductQuantity']?>" placeholder="Quantity" required>
                            </td>
                            <td class="price">&dollar;<?=number_format($_SESSION['cart'][$product['ProductID']] * $product['ProductPrice'], 2)?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="button" value="Check Out" onclick="checkOut()"/>
        </div>
    </form>

    <script>
    function checkOut() {
        // Check if the user is logged in
        // Replace the condition below with your login check logic
        var isLoggedIn = false; // Change this to true if the user is logged in

        if (isLoggedIn) {
            // User is logged in, proceed to checkout
            location.href = 'cart.php';
        } else {
            // User is not logged in, display error pop-up message
            alert('You must login first in order to check out the cart!');
        }
    }
</script>

</div>

<?=template_footer()?>


