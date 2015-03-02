<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Globalnews - Home</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<!-- bootstrap styles-->
<link href="<?php echo layTuyChon("urlChinh"); ?>css/bootstrap.min.16.css" rel="stylesheet">
<!-- google font -->
<link rel="stylesheet" type="text/css" href="<?php echo layTuyChon("urlChinh"); ?>css/font-opensans.css">
<!-- ionicons font -->
<link href="<?php echo layTuyChon("urlChinh"); ?>css/ionicons.min.css" rel="stylesheet">
<!-- animation styles -->
<link rel="stylesheet" href="<?php echo layTuyChon("urlChinh"); ?>css/animate.css" />
<!-- custom styles -->
<link href="<?php echo layTuyChon("urlChinh"); ?>css/custom-red.css" rel="stylesheet" id="style">
<!-- owl carousel styles-->
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/owl.transitions.css">
<!-- magnific popup styles -->
<link rel="stylesheet" href="css/magnific-popup.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>

<!-- wrapper start -->
<div class="wrapper"> 
  <!-- sticky header start -->
  <div class="sticky-header"> 
    <!-- header start -->
    <div class="container header">
      <div class="row">
        <div class="col-sm-5 col-md-5 wow fadeInUpLeft animated"><a class="navbar-brand" href="index.html">globalnews</a></div>
        <div class="col-sm-11 col-md-11 hidden-xs text-right"><img src="images/ads/468-60-ad.gif" width="468" height="60" alt=""/></div>
      </div>
    </div>
    <!-- header end --> 
    <!-- nav and search start -->
    <div class="nav-search-outer"> 
      <!-- nav start -->
      
      <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
          <div class="row">
            <div class="col-sm-16"> <a href="javascript:;" class="toggle-search pull-right"><span class="ion-ios7-search"></span></a>
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav text-uppercase main-nav ">
                    <?php echo hienThiTopMenu(); ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- nav end --> 
        <!-- search start -->
        
        <div class="search-container ">
          <div class="container">
            <form action="" method="" role="search">
              <input id="search-bar" placeholder="Type & Hit Enter.." autocomplete="off">
            </form>
          </div>
        </div>
        <!-- search end --> 
      </nav>
      <!--nav end--> 
    </div>
    <!-- nav and search end--> 
  </div>
  <!-- sticky header end --> 
  
  <!-- data start -->
  
  <div id="main" class="container ">
    <div class="row "> 
      <!-- left sec start -->
      <div class="col-md-11 col-sm-11">
<?php include("./tp/".$cauHinhChucNang[$_GET["chucnang"]]["tpFile"]); ?>
      </div>
      <!-- left sec end --> 
      <!-- right sec start -->
      <div class="col-sm-5 hidden-xs right-sec">
        <div class="bordered">
          <div class="row ">
            <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="50"> <img class="img-responsive" src="images/ads/336-280-ad.gif" width="336" height="280" alt=""/> <a href="#" class="sponsored">sponsored advert</a> </div>
            <?php include("./tp/tp-core-topBaiViet.php"); ?>
            <!-- calendar start
            <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="50">
              <div class="single pull-left"></div>
            </div>
            <!-- calendar end --> 
          </div>
        </div>
      </div>
      <!-- right sec end --> 
    </div>
  </div>
  <!-- data end --> 
  
  <!-- Footer start -->
  <footer>
    <div class="btm-sec" style="text-align:center">
      <div class="container">
        <div class="row">
          <div class="col-sm-16">
            <div class="row">
              <div data-wow-delay="0.5s" data-wow-offset="10">© 2014 GLOBALNEWS THEME - ALL RIGHTS RESERVED</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer end -->
</div>
<!-- wrapper end --> 

<!-- jQuery --> 
<script src="js/jquery.min.js"></script> 
<!--jQuery easing--> 
<script src="js/jquery.easing.1.3.js"></script>
<!--jQuery timeago--> 
<script src="js/jquery.timeago.js"></script> 
<!-- bootstrab js --> 
<script src="js/bootstrap.min.js"></script> 
<!--wow animation--> 
<script src="js/wow.min.js"></script> 
<!-- calendar--> 
<script src="js/jquery.pickmeup.js"></script> 
<!-- go to top --> 
<script src="js/jquery.scrollUp.js"></script> 
<!-- scroll bar --> 
<script src="js/jquery.nicescroll.js"></script> 
<script src="js/jquery.nicescroll.plus.js"></script> 
<!--media queries to js--> 
<script src="js/enquire.js"></script> 
<!--custom functions--> 
<script src="js/custom-fun.js"></script>
</body>
</html>