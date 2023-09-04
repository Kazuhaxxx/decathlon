<?php
require_once 'functions.php';

$grand_total = 0;
$allItems = '';



?>

<?=template_header('Place Order')?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Snippet - BBBootstrap</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
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
                        </div> <!-- End -->
                    </div> <!-- End -->
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

        // Redirect to the completion page for net banking
        window.location.href = "completion.php";
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

        // Redirect to the completion page for cash on delivery
        window.location.href = "completion.php";
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