<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */

$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Receipt</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Receipt Form</h5>
            
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('receipt/getPendingInvoice')?>">
            <div class="row">
                    
                    
                    <div class="col-sm-4">
                        <div class="form-group"><label>Consignee Name</label>
                            <select class="vehicle_inward_id form-control"  name="consignee_billing_id" required="required">
                                <option value="">select Consignee</option>
                                <?php
                                    foreach ($consignee as $row) {
                                        echo "<option value='".$row['consignee_billing_id']."' >".$row['consignee_billing_name']."</option>";
                                    }
                                ?>
                                <option value="all">All</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">Get Record</button>
                    </div>
            </div>
                </form> 
        </div>
    </div>
</div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
<script>
    
    $('.vehicle_inward_id').select2();
</script>
