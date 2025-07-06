<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>Ecopack</title>
    <!-- custom-theme -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo base_url() ?>uploads/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url() ?>uploads/favicon.ico" type="image/x-icon">
    <!-- //custom-theme -->
    <link href="<?= base_url();?>siteassets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= base_url();?>siteassets/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="<?= base_url();?>siteassets/css/lightbox.css">
    <link rel="stylesheet" href="<?= base_url();?>siteassets/css/mainStyles.css" />
    <link rel='stylesheet' href='<?= base_url();?>siteassets/css/dscountdown.html' type='text/css' media='all' />

    <link rel="stylesheet" href="<?= base_url();?>siteassets/css/flexslider.html" type="text/css" media="screen" property="" />
    <!-- gallery -->
    <link href="<?= base_url();?>siteassets/css/lsb.html" rel="stylesheet" type="text/css">

    <!-- //gallery -->
    <!-- font-awesome-icons -->
    <link href="<?= base_url();?>siteassets/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- css slider -->
    <link rel="stylesheet" href="<?= base_url();?>siteassets/slider/css/nivo-slider.css" type="text/css" media="screen" />
    <link href="<?= base_url();?>siteassets/slider/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>siteassets/slider/css/default.css"  rel="stylesheet" type="text/css" media="screen" />
    <link href="<?= base_url();?>siteassets/css/sweetalert.css" rel="stylesheet">
    <!-- css slider end-->

    <!-- js -->
    <script type="text/javascript" src="<?= base_url();?>siteassets/js/jquery-2.1.4.min.js"></script>
    <!-- //js -->

    <!-- start-smooth-scrolling -->
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
    <!--bars -->
    <script type="text/javascript">
        $(function(){
            $("#bars li .bar").each(function(key, bar){
                var percentage = $(this).data('percentage');

                $(this).animate({
                    'height':percentage+'%'
                }, 1000);
            })
        })
    </script>
    <!-- for bootstrap working -->
    <script src="<?= base_url();?>siteassets/js/bootstrap.js"></script>
    <!-- //for bootstrap working -->
    <!-- bars -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121810163-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121810163-1');
</script>

</head>
<body>
<!-- banner -->
<div class="header">
    <div class="w3layouts_header_right">
        <div class="detail-w3l">
            <ul>
                <li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> +91 725-098-0021</li>
            </ul>
        </div>
    </div>
    <!--<div class="w3layouts_header_left">
        <ul>
            <li><a href="<?= base_url();?>siteassets/#" data-toggle="modal" data-target="#myModal2"><i class="fa fa-user" aria-hidden="true"></i>Login</a></li>
        </ul>
    </div>-->
    <!--<div class="agileits-social top_content">
        <ul>
            <li><a href="<?/*= base_url();*/?>siteassets/#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="<?/*= base_url();*/?>siteassets/#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="<?/*= base_url();*/?>siteassets/#"><i class="fa fa-rss"></i></a></li>
            <li><a href="<?/*= base_url();*/?>siteassets/#"><i class="fa fa-vk"></i></a></li>
        </ul>
    </div>-->
    <div class="clearfix"> </div>
</div>
<div class="banner">
    <nav class="navbar navbar-default">
        <div class="navbar-header navbar-left">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h1><a class="navbar-brand" href="<?= base_url();?>Home"><img src="<?= base_url();?>siteassets/images/logo1.png"/></a></h1>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
            <nav class="link-effect-2" id="link-effect-2">
                <ul class="nav navbar-nav">
                    <li class="<?php if($newc=='home'){echo "active";}?>"><a href="<?= base_url();?>home"><span data-hover="Home">Home</span></a></li>
                    <li class="<?php if($newc=='about'){echo "active";}?>"><a href="<?= base_url();?>about"><span data-hover="About Us">About Us</span></a></li>
                    <li class="<?php if($newc=='service'){echo "active";}?>"><a href="<?= base_url();?>services"><span data-hover="Services">Services</span></a></li>
                    <li class="<?php if($newc=='product'){echo "active";}?>"><a href="<?= base_url();?>product"><span data-hover="Products">Products</span></a></li>
                    <li class="<?php if($newc=='contact'){echo "active";}?>"><a href="<?= base_url();?>contact"><span data-hover="Contact Us">Contact Us</span></a></li>
					<li class="<?php if($newc=='contact'){echo "active";}?>"><a href="<?= base_url();?>welcome"><span data-hover="Login">App Login</span></a></li>
                </ul>
            </nav>
        </div>
    </nav>
</div>
<!-- //banner -->