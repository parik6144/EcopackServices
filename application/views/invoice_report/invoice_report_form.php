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
        <h2>Invoice Report</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Invoice Report Form</h5>
            
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('invoice_report/getreport')?>">
            <div class="row">
                <div class="col-sm-3">
                   <div class="form-group" id="data_1">
                        <label class="font-noraml">From</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_from" class="form-control purchase_date rec" value="<?=date('01-m-Y')?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                   <div class="form-group" id="data_2">
                        <label class="font-noraml">To</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_to" class="form-control purchase_date rec" value="<?=date('d-m-Y')?>" required>
                        </div>
                    </div>
                </div>
               
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
    
    //$('.vehicle_inward_id').select2();
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $('#data_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
</script>
