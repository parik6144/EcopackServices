<?php
/**
 * Created by PhpStorm.
 * User: Bipin Kumar
 * Date: 12-06-2017
 * Time: 04:51 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
$pageheader['title'] = 'Error Page';
$this->load->view('top_navbar');
$this->load->view('header',$pageheader);
?>
<div class="container-fluid">
    <div class="row">
        <style>
            .page_error{
                padding:50px;
                text-align: center;
            }
            .page_error img{
                height: 350px;
            }
        </style>
        <div class="col-sm-9 col-md-10  main" id="page_error">
            <div class="page_error">
                <div class="row">
                    <div class="col-xs-12">
                        <img src="<?php echo base_url(); ?>assets/img/404-opt.png" class="img-responaive" />
                    </div>
                    <div class="col-xs-12">
                        <h2>This page isn't available</h2>
                        <h4>
                            The link you followed may be broken, or the page may have been removed.
                        </h4>
                    </div>
                </div>
            </div>




</div>


<?php
$this->load->view('right_sidebar');
?>
</div>
</div>
<?php
$this->load->view('footer.php');
?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/friends.js"></script>
<?php
$this->load->view('html_close.php');
?>

