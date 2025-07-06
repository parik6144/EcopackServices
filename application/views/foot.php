<!-- //footer-contact -->
<div class="footer-final">
    <div class="copyw3-agile">
        <div class="container">
            <p>&copy; 2018 Ecopack | Designed & Developed by <a href="http://www.aashvitech.com/">Aashvi Innovations Pvt Ltd</a></p>
        </div>
    </div>
</div>

<!-- js -->
<script type="text/javascript" src="<?= base_url();?>siteassets/js/jquery-2.1.4.min.js"></script>
<!-- //js -->
<script src="<?= base_url();?>siteassets/js/mainScript.js"></script>
<script src="<?= base_url();?>siteassets/js/rgbSlide.min.js"></script>
<script src="<?= base_url();?>siteassets/js/lightbox-plus-jquery.min.js"> </script>
<!-- //light box js-->
<!-- bar-js -->
<script src="<?= base_url();?>siteassets/js/bars.js"></script>
<!-- bar-js -->
<!--  light box js -->
<!--team-->
<script type="text/javascript">
    $(window).load(function() {
        $("#flexiselDemo1").flexisel({
            visibleItems:4,
            animationSpeed: 1000,
            autoPlay: true,
            autoPlaySpeed: 3000,
            pauseOnHover: true,
            enableResponsiveBreakpoints: true,
            responsiveBreakpoints: {
                portrait: {
                    changePoint:480,
                    visibleItems: 1
                },
                landscape: {
                    changePoint:640,
                    visibleItems:2
                },
                tablet: {
                    changePoint:768,
                    visibleItems: 3
                }
            }
        });

    });
</script>
<script type="text/javascript" src="<?= base_url();?>siteassets/js/jquery.flexisel.js"></script>
<!--team-->
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="<?= base_url();?>siteassets/js/move-top.js"></script>
<script type="text/javascript" src="<?= base_url();?>siteassets/js/easing.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>
<!-- start-smooth-scrolling -->

<!-- here stars scrolling icon -->
<script type="text/javascript">
    $(document).ready(function() {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */

        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>
<!-- //here ends scrolling icon -->
<!-- ResponsiveTabs -->
<script src="<?= base_url();?>siteassets/js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true   // 100% fit in a container
        });
    });
</script>
<!-- //ResponsiveTabs -->
<script type="text/javascript">
    $(document).ready(function() {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */
        $().UItoTop({ easingType: 'easeOutQuart' });
    });
</script>
<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<script src="<?= base_url();?>siteassets/js/SmoothScroll.min.js"></script>
<script src="<?= base_url();?>siteassets/js/sweetalert.min.js" type="text/javascript"></script>

<script src="<?= base_url();?>siteassets/js/ui-sweetalert.min.js" type="text/javascript"></script>
<!-- for bootstrap working -->
<script src="<?= base_url();?>siteassets/js/bootstrap.js"></script>
<!-- //for bootstrap working -->

<!--slider js start -->
    <script type="text/javascript" src="<?= base_url();?>siteassets/slider/js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $('#slider').nivoSlider();
        });
    </script>
<!-- slider -->
</body>

</html>