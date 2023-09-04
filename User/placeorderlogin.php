<?php
require_once 'functions.php';
session_start();
// Check if the user is logged in
if (!isset($_SESSION['CartID'])) {
    // Redirect to the login page
  header('Location: index.html');
  exit();

}
// Check if the "clear" parameter is set and equals 1
if (isset($_GET['clear']) && $_GET['clear'] == 1) {
    // Clear the cart in the database
    include 'db_connect.php';
    $cartID = $_SESSION['CartID'];
    $query = "DELETE FROM cart_product WHERE CartID = '$cartID'";
    $result = mysqli_query($link, $query) or die("Query failed");

    // Clear the cart in the session
    $_SESSION['cart'] = array();
}

// Clear the cart if the user clicks the "Clear Cart" button
if (isset($_POST['clearcart'])) {
    // Clear the cart in the session
    $_SESSION['cart'] = array();
    
    // Clear the cart in the database (optional)
    include 'db_connect.php';
    $query = "DELETE FROM cart_product WHERE CartID = '$cart_id'";
    $result = mysqli_query($link, $query) or die("Query failed");
    
    // Redirect back to the cart page
    header('Location: cartlogin.php');
    exit();
}




$grand_total = 0;
$allItems = '';

?>

<?=template_header2('Place Order')?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Payment Forms</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
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
    <style>
        /* CSS styles */
    </style>
</head>
<body>
<div class="container py-5">
    <!-- For demo purpose -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">Payment Forms</h1>
            <!-- For demo purpose
            <div class="jumbotron p-3 mb-2 text-center">
                <h5><b>Product(s) : </b><?= $allItems; ?></h6>
                <h5><b>Total Amount Payable : </b><?= number_format($grand_total,2) ?>/-</h5>
            </div>
            -->
        </div>
    </div> <!-- End -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item">
                                <a data-toggle="pill" href="#net-banking" class="nav-link">
                                    <i class="fas fa-mobile-alt mr-2"></i> Net Banking
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="pill" href="#credit-card" class="nav-link active">
                                    <i class="fas fa-credit-card mr-2"></i> Cash On Delivery
                                </a>
                            </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- bank transfer info -->
                        <div id="net-banking" class="tab-pane fade pt-3">
                            <div class="form-group">
                                <label for="Select Your Bank">
                                    <h6>Select your Bank</h6>
                                </label>
                                <select class="form-control" id="ccmonth" required>
                                    <option value="" selected disabled>--Please select your Bank--</option>
                                    <option>Bank Islam</option>
                                    <option>Bank Muamalat</option>
                                    <option>Bank Rakyat</option>
                                    <option>Maybank</option>
                                    <option>Hong Leong Bank</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <p>
                                    <button type="button" class="btn btn-primary" onclick="proceedNetBankingPayment()">
                                        <i class="fas fa-mobile-alt mr-2"></i> Proceed Payment
                                    </button>
                                </p>
                            </div>
                            <p class="text-muted">Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order.</p>
                        </div> <!-- End -->
                        <!-- cash on delivery info -->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form role="form" onsubmit="event.preventDefault()">
                                <div class="form-group">
                                    <label for="username">
                                        <h6>Address Line 1</h6>
                                    </label>
                                    <input type="text" name="address_line_1" required placeholder="Address Line 1" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber">
                                        <h6>Address Line 2 (optional)</h6>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="address_line_2" placeholder="Address Line 2" class="form-control">
                                        <div class="input-group-append"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username">
                                        <h6>Postal Code</h6>
                                    </label>
                                    <input type="text" name="postal_code" required placeholder="Postal Code" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="username">
                                        <h6>State</h6>
                                    </label>
                                    <input type="text" name="state" required placeholder="State" class="form-control">
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="subscribe btn btn-primary btn-block shadow-sm" onclick="proceedCashOnDeliveryPayment()">Confirm Payment</button>
                                </div>
                            </form>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function proceedNetBankingPayment() {
        // Get the selected bank value
        var selectedBank = document.getElementById("ccmonth").value;

        // Check if a bank is selected
        if (selectedBank === "") {
            alert("Please select your bank.");
            return;
        }

        // Clear the cart by redirecting to the completion page with the "clear" parameter
        window.location.href = "completionlogin.php?clear=1";

        
    }

    function proceedCashOnDeliveryPayment() {
        // Get the input values
        var addressLine1 = document.querySelector('input[name="address_line_1"]').value;
        var postalCode = document.querySelector('input[name="postal_code"]').value;
        var state = document.querySelector('input[name="state"]').value;

        // Check if required fields are filled
        if (addressLine1 === "" || postalCode === "" || state === "") {
            alert("Please fill in all the required fields.");
            return;
        }

        // Clear the cart by redirecting to the completion page with the "clear" parameter
        window.location.href = "completionlogin.php?clear=1";
        
    }
</script>

<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript' src='#'></script>
<script type='text/javascript'>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script type='text/javascript'>
    var myLink = document.querySelector('a[href="#"]');
    myLink.addEventListener('click', function (e) {
        e.preventDefault();
    });
</script>

</body>
</html>

<?=template_footer()?>