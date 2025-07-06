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
        <h2>GST Report</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>GST Report Form</h5>
            
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('gst_report/getreport')?>">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group"><label>Year</label>
                       <select class="vehicle_inward_id form-control" name="year" required="required">
                            <option value=''>--Select Year--</option>
                            <option value='2020' selected>2020</option>
                            <option value='2019'>2019</option>
                            <option value='2018'>2018</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group"><label>Month</label>
                        <select class="vehicle_inward_id form-control"  name="month" required="required">
                            <option value=''>--Select Month--</option>
                            <option selected value='01'>Janaury</option>
                            <option value='02'>February</option>
                            <option value='03'>March</option>
                            <option value='04'>April</option>
                            <option value='05'>May</option>
                            <option value='06'>June</option>
                            <option value='07'>July</option>
                            <option value='08'>August</option>
                            <option value='09'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
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
