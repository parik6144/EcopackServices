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
        <h2>Stock Report</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Stock Report Form</h5>
            
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('co_stock_report/getreport')?>">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group" id="data_1">
                            <label class="font-noraml">From</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_from" class="form-control purchase_date rec" value="<?=date('01-m-Y')?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group" id="data_2">
                            <label class="font-noraml">TO</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_to" class="form-control purchase_date rec" value="<?=date('d-m-Y')?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group"><label>Consignee Name</label>
                            <select class="consignee_name form-control"  name="consignee_name" required="required">
                                <option value="">select consignee</option>
                                <?php
                                    foreach ($consignee as $row) {
                                        echo "<option value='".$row['consignee_id']."'  address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['phone_no']."' pincode='".$row['pincode']."'>".$row['consignee_name']."</option>";
                                    }
                                ?>
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
    $(document).ready(function(){
        $('.consignee_name').select2();
    });
    
</script>
