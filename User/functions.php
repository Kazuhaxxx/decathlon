

<?php

function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'DecathlonSystem';
    
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}

// Retrieve UserFirstName based on UserID
function getUserFirstName($userID) {
    include '../Admin/db_connect.php';

    // Prepare the SQL query
    $query = "SELECT UserFirstName FROM user WHERE UserID = '$userID'";

    // Execute the query
    $result = mysqli_query($link, $query) or die("Query failed");

    if(mysqli_num_rows($result) > 0) {
        $info = mysqli_fetch_array($result);
        return $info['UserFirstName'];
    } else {
        return null;
    }

    mysqli_close($link);
}

// Handle different actions based on the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'clearCart') {
        // Reset the value of $num_items_in_cart to 0
        $num_items_in_cart = 0;
        echo 'success';
        exit;
    }
}

// Function to clear the cart
function clear_cart() {
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
}



// Template header, feel free to customize this
function template_header($title) {
    include 'db_connect.php';

    $cart_id = $_SESSION['CartID'];
    
    $query = "SELECT COUNT(*) AS total_rows FROM cart_product WHERE CartID = '$cart_id'";
    $result = mysqli_query($link, $query) or die("Query failed");
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_rows = $row['total_rows'];
    } else {
        $total_rows = 0;
    }
    
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $num_items_in_cart = $total_rows;

echo <<<EOT

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="../style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
        <header>
            <div class="content-wrapper">
            <a href="#"><img class="logo" src="../images/decathlon.png" width="50%" style="vertical-align: bottom;" align="left"></a>
            
                
                <nav>
                    <a href="index.php">Home</a>
                    <a href="bats.php">Bats</a>
                    <a href="gloves.php">Gloves</a>
                    <a href="helmets.php">Helmets</a>
                    <a href="aboutus.php">About</a>
                    <a href="../Admin/index.html">Login</a>
                </nav>
                <div class="link-icons">
                    <a href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span>$num_items_in_cart</span>
                    </a>
                </div>
                
            </div>
        </header>
        <main>
EOT;
}

function template_header2($title) {
    include 'db_connect.php';

    $cart_id = $_SESSION['CartID'];
    
    $query = "SELECT COUNT(*) AS total_rows FROM cart_product WHERE CartID = '$cart_id'";
    $result = mysqli_query($link, $query) or die("Query failed");
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_rows = $row['total_rows'];
    } else {
        $total_rows = 0;
    }
    
    // Get the number of items in the shopping cart, which will be displayed in the header.
    $num_items_in_cart = $total_rows;

    $userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
    $userFirstName = getUserFirstName($userID); // Retrieve UserFirstName based on UserID

    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="../style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
            <header>
                <div class="content-wrapper">
                <a href="indexlogin.php"><img class="logo" src="../images/decathlon.png" width="50%" style="vertical-align: bottom;" align="left"></a>
                
                    
                    <nav>
                        <a href="indexlogin.php">Home</a>
                        <a href="batslogin.php">Bats</a>
                        <a href="gloveslogin.php">Gloves</a>
                        <a href="helmetslogin.php">Helmets</a>
                        <a href="aboutuslogin.php">About</a>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">$userFirstName</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../login/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </nav>
                    <div class="link-icons">
                        <a href="cartlogin.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span>$num_items_in_cart</span>
                        </a>
                    </div>
                </div>
            </header>
            <main>
    EOT;
}


// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            
            <!-- section footer start -->
            <div class="copyright" style="background-color: #007dbc;">2023 All Rights Reserved. <a href="https://decathlon.com">Decathlon Baseball Store</a></div>
            <!-- section footer end -->
        </footer>
    </body>
</html>
EOT;
}

function getProductsByCategory($category, $limit) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "DecathlonSystem";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    $sql = "SELECT * FROM product WHERE ProductCategory = '$category' LIMIT $limit";

    // Execute the query
    $result = $conn->query($sql);

    // Fetch the results into an associative array
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Return the products
    return $products;
}

function generateSearchForm() {
    if (isset($_POST['search'])) {
        $search = $_POST['search'];

        // Perform the search query in your database
        $results = performSearch($search);

        // Display the search results
        if (!empty($results)) {
            $output = "<div class='products content-wrapper'>";
            $output .= "<h1>Similar Searched Products</h1>";
            $output .= "<p>" . count($results) . " Products</p>";
            $output .= "<div class='products-wrapper'>";
            foreach ($results as $result) {
                $output .= "<a href='product.php?id={$result['ProductID']}' class='product'>";
                $output .= "<img src='../images/{$result['ProductImage']}' width='200' height='200' alt='{$result['ProductName']}'>";
                $output .= "<span class='name'>{$result['ProductName']}</span>";
                $output .= "<span class='price'>&dollar;{$result['ProductPrice']}</span>";
                $output .= "</a>";
            }
        } else {
            $output = "<div class='products content-wrapper'>";
            $output .= "<h1>Products</h1>";
            $output .= "<p>0 Products</p>";
            $output .= "<div class='products-wrapper'>";
            $output .= "<p>No results found.</p>";
            $output .= "</div>";
            $output .= "<div class='buttons'>";
            $output .= "</div>";
            $output .= "</div>";
        }
    } else {
        $output = "";
    }

    return <<<HTML
    <div class="container" style="text-align: center;">
        <div id="content">
            <form class='form-inline' method="POST">
                <div class="input-group" style="/* display: inline-flex; */margin-bottom: 5px;padding-left: 400px;">
                    <input type='text' name='search' id='search' class="form-control search-form" placeholder="Search for item" style="width: 300px; flex: 1 1 auto;">
                    <span class="input-group-btn" style="width: 39px; display: inline-block;">
                        <button id="search-this" type="submit" class="btn btn-default search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <div class="search-results">
                $output
            </div>
        </div>
    </div>
HTML;
}

// Function to perform the search in the database
function performSearch($search) {
    // Update the database details with your own
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "DecathlonSystem";

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    $search = $conn->real_escape_string($search);
    $sql = "SELECT * FROM product WHERE ProductName LIKE '%$search%'";

    // Execute the query
    $result = $conn->query($sql);

    // Fetch the results into an associative array
    $results = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Return the search results
    return $results;
}


?>