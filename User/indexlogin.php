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
    require 'functions.php';

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

    // Check the cart items
    $cart_items = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    // Select products ordered by the date added and filtered by category
    $category = 'bats'; // Filter by the category 'bats'

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
        <title>Pullo Equipment</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- style css -->
        <link rel="stylesheet" href="../css/style.css">
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
    <!-- body -->
    <body class="main-layout">
    <!-- header section start -->
        <div class="header_section">
            
        <div class="banner_section">
            <div class="container-fluid">
                <section class="slide-wrapper">
                    <div class="container-fluid">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                                <li data-target="#myCarousel" data-slide-to="3"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                    <div class="col-sm-2 padding_0">
                                        <p class="mens_taital">LTD Bats</p>
                                        <div class="page_no">1/4</div>
                                        <p class="mens_taital_2">LTD Bats</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="banner_taital">
                                            <h1 class="banner_text">LTD Bats </h1>
                                            <h1 class="mens_text"><strong style="font-size: revert;">DeMarini 2022 The Goods -3 BBCOR</strong></h1>
                                            <p class="lorem_text" style="text-align: justify;">The Direct Connection system of this 2-Piece Hybrid construction is crafted to deliver a stiff feel and maximum energy transfer, and a newly redesigned Tremor End Cap is built with lightweight materials to optimize barrel performance and unlock your raw power at the plate.</p>
                                            <a href="batslogin.php"><button class="buy_bt">See More</button></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="shoes_img"><img src="../images/bat1.png" style="margin-top: 11%;"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                    <div class="col-sm-2 padding_0">
                                        <p class="mens_taital">LTD Bats</p>
                                        <div class="page_no">2/4</div>
                                        <p class="mens_taital_2">LTD Bats</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="banner_taital">
                                            <h1 class="banner_text">LTD Bats </h1>
                                            <h1 class="mens_text"><strong style="font-size: revert;">DeMarini The Goods -3 BBCOR</strong></h1>
                                            <p class="lorem_text" style="text-align: justify;">Introducing the 2022 The Goods One Piece (-3) BBCOR Baseball Bat. The stiff one-piece design mirrors the feel of wood while delivering explosive energy transfer. The newly redesigned Tremor End Cap is composed of stronger materials to maintain barrel performance so you can demolish incoming pitches.</p>
                                            <a href="batslogin.php"><button class="buy_bt">See More</button></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="shoes_img"><img src="../images/bat2.png" style="margin-top: 11%;"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                    <div class="col-sm-2 padding_0">
                                        <p class="mens_taital">LTD Gloves</p>
                                        <div class="page_no">3/4</div>
                                        <p class="mens_taital_2">LTD Gloves</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="banner_taital">
                                            <h1 class="banner_text">LTD Gloves </h1>
                                            <h1 class="mens_text"><strong style="font-size: revert;">Rawlings Horween Limited Edition</strong></h1>
                                            <p class="lorem_text" style="text-align: justify;">These gloves are built with traditional grey split welting, vegas gold stitching, tan laces, black embroidery, black ink indent, special gold lined Rawlings patch, and mustard hand sewn welt on select models.</p>
                                            <a href="gloveslogin.php"><button class="buy_bt">See More</button></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="shoes_img"><img src="../images/gloves1.png" style="margin-top: 10%;"></div>
                                    </div>
                                </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row">
                                    <div class="col-sm-2 padding_0">
                                        <p class="mens_taital">LTD Gloves</p>
                                        <div class="page_no">4/4</div>
                                        <p class="mens_taital_2">LTD Gloves</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="banner_taital">
                                            <h1 class="banner_text">LTD Gloves </h1>
                                            <h1 class="mens_text"><strong style="font-size: revert;">Rawlings Heart Of The Hide PRO</strong></h1>
                                            <p class="lorem_text" style="text-align: justify;">More pros trust Rawlings than all other brands combined. The 2021 Rawlings Heart of the Hide 11.5-inch infield glove is a testament to that quality that defines greatness.</p>
                                            <a href="gloveslogin.php"><button class="buy_bt">See More</button></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="shoes_img"><img src="../images/gloves2.png" style="margin-top: 10%;"></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>			
                </div>
            </div>
        </div>
        <!-- header section end -->
        <!-- new collection section start -->
        <div class="layout_padding collection_section">
            <div class="container">
                <h1 class="new_text"><strong style="font-size: revert;">Trending  Collection</strong></h1>
                <p class="consectetur_text" style="text-align: justify;">Stay ahead of the curve with the latest innovations and trends in baseball equipment, ensuring you're equipped for success on the field. Discover the must-have items that are revolutionizing the way players approach the game and elevate your baseball journey to new heights.</p>
                <div class="collection_section_2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-img">
                                <button class="new_bt">Hot</button>
                                <div class="shoes-img"><img src="../images/bat3.png"></div>
                                <p class="sport_text">Louisville Slugger</p>
                                <div class="dolar_text">$<strong style="color: #f12a47;font-size: revert;">399.95</strong> </div>
                                <div class="star_icon">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <a href="batslogin.php"><button class="seemore_bt">See More</button></a>
                        </div>
                        <div class="col-md-6">
                            <div class="about-img2">
                                <div class="shoes-img2"><img src="../images/bat4.png"></div>
                                <p class="sport_text">DeMarini 2021</p>
                                <div class="dolar_text">$<strong style="color: #f12a47;font-size: revert;">349.95</strong> </div>
                                <div class="star_icon">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collection_section">
            <div class="container">
                <h1 class="new_text"><strong style="font-size: revert;">Helmets</strong></h1>
                <p class="consectetur_text" style="text-align: justify;">Explore our range of helmets that combine superior impact resistance with lightweight construction, ensuring both safety and agility on the field. Stay ahead of the game and discover the latest advancements in baseball helmet technology, providing you with peace of mind as you focus on your performance.</p>
            </div>
        </div>
        <div class="collectipn_section_3 layout_padding">
            <div class="container">
                <div class="racing_shoes">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="shoes-img3"><img src="../images/helm1.png"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="sale_text"><strong style="font-size: revert;">ON-GOING <br><span style="color: #0a0506;font-size: revert;">HELMETS</span> <br>SALES</strong></div>
                            <div class="number_text"><strong style="font-size: revert;">$ <span style="color: #0a0506;font-size: revert;">35.95</span></strong></div>
                            <a href="helmetslogin.php"><button class="seemore">See More</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="collection_section layout_padding">
        <div class="container">
        <h1 class="new_text"><strong style="font-size: revert;">Promotional Video</strong></h1>
        <iframe width="1100" height="600" src="https://www.youtube.com/embed/vP0H2OU0Mi4" title="MLB 9Innings - &quot;The Kid&quot; (Official Trailer)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>
        </div>
        </div>

        <div class="collection_section layout_padding">
            <div class="container">
                <h1 class="new_text"><strong style="font-size: revert;">New Arrivals Products</strong></h1>
                <p class="consectetur_text" style="text-align: justify;">Stay ahead of the competition with our handpicked selection of new arrivals, designed to enhance your performance and take your game to the next level. Explore our latest offerings and be among the first to get your hands on the hottest gear in the world of baseball.</p>
            </div>
        </div>
        <!-- new collection section end -->
        <!-- New Arrivals section start -->
        <!-- New Arrivals section start -->

        <div class="collection_section">
            <div class="container">
            <div class="racing_shoes" style="background-color: eae7e7;padding-left: 12px;padding-top: 6px;padding-bottom: 6px;padding-right: 12px;">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Bats </p>
                            <div class="shoes_icon"><img src="../images/bat5.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">499.95</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Gloves </p>
                            <div class="shoes_icon"><img src="../images/gloves3.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">379.95</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Helmets </p>
                            <div class="shoes_icon"><img src="../images/helm2.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">22.88</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Bats</p>
                            <div class="shoes_icon"><img src="../images/bat6.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">289.95</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Gloves</p>
                            <div class="shoes_icon"><img src="../images/gloves4.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">299.95</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="best_shoes">
                            <p class="best_text">New Helmets</p>
                            <div class="shoes_icon"><img src="../images/helm3.png"></div>
                            <div class="star_text">
                                <div class="left_part">
                                    <ul>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                        <li><a href="#"><img src="../images/star-icon.png"></a></li>
                                    </ul>
                                </div>
                                <div class="right_part">
                                    <div class="shoes_price">$ <span style="color: #ff4e5b;font-size: revert;">43.95</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Arrivals section end -->

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

            //scroll slides on swipe for touch enabled devices

            $("#myCarousel").on("touchstart", function(event){

                var yClick = event.originalEvent.touches[0].pageY;
                $(this).one("touchmove", function(event){

                    var yMove = event.originalEvent.touches[0].pageY;
                    if( Math.floor(yClick - yMove) > 1 ){
                        $(".carousel").carousel('next');
                    }
                    else if( Math.floor(yClick - yMove) < -1 ){
                        $(".carousel").carousel('prev');
                    }
                });
                $(".carousel").on("touchend", function(){
                    $(this).off("touchmove");
                });
            });
        </script> 

        
    </body>
    </html>
    
    
