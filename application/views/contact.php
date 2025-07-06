    <div class="banner-multi">
        
    </div>
	<div class="about-breadcrumb">
		<div class="container">
			<ul>
				<li><a href="<?= base_url();?>Home">Home</a><i>|</i></li>
				<li>Contact Us</li>
			</ul>
		</div>
	</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="signin-form profile">
                <h3 class="agileinfo_sign">Sign In</h3>
                        <div class="login-form">
                            <form action="#" method="post">
                                <input type="email" name="email" placeholder="E-mail" required="">
                                <input type="password" name="password" placeholder="Password" required="">
                                <div class="tp">
                                    <input type="submit" value="Sign In">
                                </div>
                            </form>
                        </div>
                        <!--<div class="login-social-grids">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss"></i></a></li>
                            </ul>
                        </div>-->
                        <p><a href="#" data-toggle="modal" data-target="#myModal3" > Don't have an account?</a></p>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- //Modal1 -->
													
<!-- //bootstrap-pop-up -->
<!-- contact -->
	<div class="contact jarallax">
		<div class="container">
			<div class="w3-headings-all">
				<h3>Contact Us</h3>
			
			</div> 
			<div class="contact-grids">
				<div class="col-md-5 address">
					<h4>Get in touch with us</h4>
					<!--<p class="cnt-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit,sheets containing Lorem Ipsum passages sed do </p>-->
					<!--<div class="agileits-social1 top_content">
						<ul>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-rss"></i></a></li>
							<li><a href="#"><i class="fa fa-vk"></i></a></li>
						</ul>
					</div>-->
						<div class="agileits-social-address">
						<p>15A,A ROAD,ZONE NO-1B,BIRSANAGAR,jamshedpur<br/>jharkhand-831019</p>
					<p>Telephone : +91 725-098-0021     </p>
					<p>Email : <a href="mailto:saroj@ecopackservices.com">saroj@ecopackservices.com</a></p>
					</div>
					
				</div>
				<div class="col-md-7 contact-form">
                    <?php echo form_open('Sendemail/mail');?>
						<input type="text" name="name" placeholder="Name" required="required">
						<input class="email" type="email" name="email" placeholder="Email" required="required">
						<textarea placeholder="Message" name="message" required="required"></textarea>
						<input type="submit" value="SUBMIT">
					</form>
				</div>
				<div class="clearfix"> </div>	
			</div>
		</div>
	</div>
	<!---728x90--->
	<!-- /contact map -->
	<div class="map2">
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3678.4622679948375!2d86.24009121573053!3d22.78532888507383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f5e2bc13c9b359%3A0x5288f9708dd6b59e!2s15%2C+Birsanagar%2C+Jamshedpur%2C+Jharkhand+831001!5e0!3m2!1sen!2sin!4v1530532434245" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
        <iframe src="https://www.google.com/maps/d/embed?mid=1n6TBmrJzUlm9oZ_zi_C30e52XwaQ_OPA" width="640" height="480"></iframe>
	</div>
<!-- //contact map -->
<!-- /footer-contact -->
<div class="w3-footer-contact">
	<div class="container">
		<div class="col-md-4 w3-footer-contact-left">
			<h3>Trucking</h3>
			<p>Mauris nec consequat nisi. Donec tempus porttitor mollis. Nam tincidunt nulla vel malesuada vestibulum. Nullam tempus, mauris et malesuada sodales, arcu erat vestibulum nulla.</p>
		</div>
		<div class="col-md-4 w3-footer-contact-middle">
		<img src="<?= base_url();?>siteassets/images/v1.jpg" alt="img">
		</div>
		<div class="col-md-4 w3-footer-contact-right">
			<div class="col-md-2 w3-footer-contact-icon1">
			<i class="fa fa-map-marker" aria-hidden="true"></i>	
			</div>
			<div class="col-md-10 w3-footer-contact-info">
			<p>Location:</p>
			<h4>15A,A ROAD,ZONE NO-1B,BIRSANAGAR,jamshedpur<br/>jharkhand-831019</h4>
					
			</div>
			<div class="clearfix"></div>
			<div class="col-md-2 w3-footer-contact-icon1">
		<i class="fa fa-volume-control-phone" aria-hidden="true"></i>
			</div>
			<div class="col-md-10 w3-footer-contact-info">
			<p>call:</p>
			<h4>+91 725-098-0021     </h4>
					
			</div>
			<div class="clearfix"></div>
			<div class="col-md-2 w3-footer-contact-icon1">
			<i class="fa fa-envelope" aria-hidden="true"></i>

			</div>
			<div class="col-md-10 w3-footer-contact-info">
			<p>Email:</p>
			<h4><a href="mailto:saroj@ecopackservices.com"> saroj@ecopackservices.com</a></h4>
					
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<!---728x90--->
	<!-- partners -->
        <div class="team gallery-ban" id="team">
            <ul id="flexiselDemo1">
                <?php
                $count=1;
                for ($count = 1; $count <= 13;) {
                    ?>
                    <li>
                        <div class="wthree_testimonials_grid_main">
                            <img src="<?= base_url(); ?>siteassets/images/c<?= $count ?>.png" alt=" " class="img-responsive"/>
                        </div>
                    </li>
                    <?php
                    $count++;
                }

                ?>
                <!--<li>
                    <div class="wthree_testimonials_grid_main">
                        <img src="<?/*= base_url();*/?>siteassets/images/f2.png" alt=" " class="img-responsive" />
                    </div>
                </li>
                <li>
                    <div class="wthree_testimonials_grid_main">
                        <img src="<?/*= base_url();*/?>siteassets/images/f3.png" alt=" " class="img-responsive" />
                    </div>
                </li>
                <li>
                    <div class="wthree_testimonials_grid_main">

                        <img src="<?/*= base_url();*/?>siteassets/images/f51.png" alt=" " class="img-responsive" />

                    </div>
                </li>
                <li>
                    <div class="wthree_testimonials_grid_main">

                        <img src="<?/*= base_url();*/?>siteassets/images/f5.png" alt=" " class="img-responsive" />

                    </div>
                </li>
                <li>
                    <div class="wthree_testimonials_grid_main">
                        <img src="<?/*= base_url();*/?>siteassets/images/f6.png" alt=" " class="img-responsive" />
                    </div>
                </li>-->
            </ul>
        </div>
	</div>
<!-- //partners -->
</div>
    <script type="text/javascript">
        $(window).load(function(){
            //alert("ok");
            <?php
           if($this->session->userdata('send'))
           {
           ?>
            swal(
                'Mail Send To the client!',
                '',
                'success'
            )
            <?php
           $this->session->unset_userdata('send');
            }
            else if($this->session->userdata('notsend')) { ?>
            swal(
                'Mail Not Send To the client!',
                '',
                'error'
            )
            <?php
             $this->session->unset_userdata('notsend');
            }
            ?>

        });
    </script>