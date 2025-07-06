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
        <h2>Ledger Report</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Consignment Report Form</h5>
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('ledger/getreport')?>">
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

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="font-noraml">Name</label>
                            <select class="form-control rec" id="receiver_type"  name="receiver_type">
                                <option value="">Select Name </option>
                                <option value="1">Ecopack Employee</option>
                                <option value="4">Other Employee</option>
                                <option value="2">Other Party</option>                                    
                                <option value="3">Transporter</option> 
                                <option value="all">All</option>                                   
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                    <div class="form-group staff_name select_user"><label >Employee Name</label>
                            <div>
                                <select class="form-control js-example-basic-single"  style="width:100%"  name="staff_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach ($staff as $row){
                                        ?>
                                        <option value="<?=$row['staff_id']?>"><?=$row['emp_no']." ".$row['staff_name']?></option>
                                    <?php
                                    }
                                    ?>
                                    <option value="all">All</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group account_name select_user"><label >Party Name</label>
                            <div>
                                <select class="form-control js-example-basic-single"  style="width:100%" name="account_id">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($account as $row){
                                        ?>
                                        <option value="<?=$row['account_id']?>"><?=$row['party_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group transporter_name select_user"><label >Transporter Name</label>
                            <div>
                                <select class="form-control js-example-basic-single"  style="width:100%" name="owner_id">
                                    <option value="">Select Transporter</option>
                                    <?php
                                    foreach ($owner as $row){
                                        ?>
                                        <option value="<?=$row['owner_id']?>"><?=$row['owner_name']?></option>
                                    <?php
                                    }
                                    ?>
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group employee_name select_user"><label >Employee Name</label>
                            <div>
                                <select class="form-control js-example-basic-single"  style="width:100%" name="employee_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach ($employee as $row){
                                        ?>
                                        <option value="<?=$row['employee_id']?>"><?=$row['employee_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-2">
                        <button type="submit" target="_blank" class="btn btn-success">Get Record</button>
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
$(document).ready(function () {
        $(".select_user, .item_table, .advance_salary").hide();
        $('.js-example-basic-single').select2();
    });
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
    $("#receiver_type").change(function(){
        var reftype=$(this).val();
        $(".select_user").hide();
        if(reftype=="1")
        {
            $(".staff_name").show();
            $(".staff_name").css('width','100%');
        }
        else if(reftype=="2")
        {
            $(".account_name").show();
        }
        else if(reftype=="3")
        {
            $(".transporter_name").show();
        }
        else if(reftype=="4")
        {
            $(".employee_name").show();
        }
    }); 
</script>
