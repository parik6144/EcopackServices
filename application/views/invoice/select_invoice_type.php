<?php

/**

 * Created by PhpStorm.

 * User: admin

 * Date: 16/08/2017

 * Time: 14:52

 */

if(!isset($condition))

{

    $this->load->view('header');

    $this->load->view('left_sidebar');

    $this->load->view('topbar');



//var_dump($form_data['account']['0']['account_name']);

//exit;

?>

<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Invoice</h2>



    </div>

    <div class="col-lg-2">



    </div>

</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-12">

            <div class="ibox float-e-margins">

                <div class="ibox-title">

                    <h5>Invoice  Form</h5>

                    <span class="pull-right"><a href="<?php echo site_url('invoice') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>



                </div>

                <?php } ?>

                <div class="ibox-content">

                    <form id="testform" action="<?=base_url('Invoice/getconsignment')?>" method="POST">

                        <div class="row">

                            

                            <div class="col-sm-4 b-r">

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group  row"><label>Invoice Type</label>

                                            <select class="invoice_type form-control"  name="invoice_type">

                                                <option value="">select Invoice Type</option>

                                                <?php

                                                    foreach ($invoice_type as $row) {

                                                        echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";

                                                    }

                                                ?>

                                            </select>

                                        </div> 

                                    </div>

                                </div>                         

                            </div>

                            <div class="col-sm-4 consignee_name_div" >

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group  row"><label>Consignee Name</label>

                                            <select class="consignee_name form-control" name="consignee_name">

                                                <option value="">select consignee</option>

                                                <?php

                                                    foreach ($consignee as $row) {

                                                        echo "<option value='".$row['consignee_id']."'  address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['mobile_no']."' pincode='".$row['pincode']."'>".$row['consignee_name']."</option>";

                                                    }

                                                ?>

                                            </select>

                                        </div> 

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-4 consignee_billing_address_div" >

                                <div class="row">

                                    <div class="col-sm-12">

                                        <div class="form-group  row"><label>Billing Address</label>

                                            <select class="consignee_billing_name form-control" name="consignee_billing_name">

                                                <option value="">select consignee</option>

                                                <?php

                                                    foreach ($consignee_billing as $row) {

                                                        echo "<option value='".$row['consignee_billing_id']."'>".$row['consignee_billing_name']."</option>";

                                                    }

                                                ?>

                                            </select>

                                        </div> 

                                    </div>

                                </div>

                            </div>

                            <div class="col-sm-4" style="margin-top:18px;">

                                <button type="submit" class="btn btn-info">Get Record</button>

                            </div>

                        </div>

                        </form>

                    </div>

                    

                <?php

                if(!isset($condition)) {

                    ?>

            </div>

        </div>

    </div>

</div>

<?php

    $this->load->view('footer');

}

?>

<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>





<script type="text/javascript">

$('.consignee_name, .consignee_billing_name').select2();

$(".consignee_name_div").hide();

$(".consignee_billing_address_div").hide();

$(".invoice_type").change(function(){

    if($(this).val()=="3" || $(this).val()=="4")

    {

        $(".consignee_name_div").show();

    }

    else if($(this).val()=="5" || $(this).val()=="6")

    {

        $(".consignee_billing_address_div").show();

    }



    else

    {

        $(".consignee_name_div").hide();

    }

});

</script>

