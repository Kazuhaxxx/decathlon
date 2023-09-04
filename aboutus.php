<?php
    require 'functions.php';
    session_start();
?>

<?=template_header('Product')?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="aboutus.css">
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Pullo About Us</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
 <!-- header section start -->
    <!-- New Arrivals section start -->
    <div class="collection_text" style=" background-color: #007dbc;">About Us</div>
  <div class="collection_section layout_padding">
      <div class="container">
          <h1 class="new_text"><strong>About Us Info</strong></h1>
          <p class="consectetur_text" style="text-align: justify;">Welcome to our baseball equipment store, where passion and expertise unite! Our website is the brainchild of five dedicated founders from CS110 Diploma in Computer Science, Group JCS1104E, who share a deep love for the game. Each founder brings a unique set of skills and knowledge to the table, ensuring that our store offers top-notch products and exceptional customer service. From equipment selection to expert advice, we're committed to helping you find the perfect gear that enhances your performance and enjoyment of the sport.</p>
      </div>c
  </div>
  <div class="layout_padding gallery_section" style=" background-color: #007dbc;">
      <div class="container">
          <div class="row">
          <div class="profile-card">
                <div class="image">
                    <img src="images/Naim-removebg-preview.png" alt="" class="profile-img">
                </div>
                <h2 class="text"></h2>
                <div class="text-data">
                    <span class="name">Muhammad Naim bin Salehuddin</span>
                    <span class="id">2021891618</span>
                    <span class="ic">030313-10-2065</span>
                    <span class="email">2021891618@student.uitm.edu.my</span>
                </div>
            </div>
            <div class="profile-card">
                <div class="image">
                    <img src="images/khairi-removebg-preview.png" alt="" class="profile-img">
                </div>
    
                <div class="text-data">
                    <span class="name">Muhamad Khairi bin Mohd Sayuti</span>
                    <span class="id">2021863268</span>
                    <span class="ic">030509-10-0117</span>
                    <span class="email">2021863268@student.uitm.edu.my</span>
                </div>
            </div>
            <div class="profile-card">
                <div class="image">
                <img src="images/hafiq-removebg-preview.png" alt="" class="profile-img">
                </div>
    
                <div class="text-data">
                    <span class="name">Muhammad Hafiq bin Kharul Nizam</span>
                    <span class="id">2021205418</span>
                    <span class="ic">030122-05-0487</span>
                    <span class="email">2021205418@student.uitm.edu.my</span>
                </div>
            </div>
            <div class="profile-card">
                <div class="image">
                    <img src="images/aleya-removebg-preview.png" alt="" class="profile-img">
                </div>
    
                <div class="text-data">
                    <span class="name">Nur Aleya binti Mohamad Faizal</span>
                    <span class="id">2021625376</span>
                    <span class="ic">031126-01-0880</span>
                    <span class="email">2021625376@student.uitm.edu.my</span>
                </div>
            </div>
            <div class="profile-card">
                <div class="image">
                    <img src="images/afiqah-removebg-preview.png" alt="" class="profile-img">
                </div>
    
                <div class="text-data">
                    <span class="name">Nur Afiqah binti Rizal</span>
                    <span class="id">2021479816</span>
                    <span class="ic">030522-10-0824</span>
                    <span class="email">2021479816@student.uitm.edu.my</span>
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
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
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