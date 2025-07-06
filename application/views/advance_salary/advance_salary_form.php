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
        <h2>Advance Salary Reports</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
   
<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Advance Salary</h5>
        </div>
        
        <div class="ibox-content">
              <form method="post" action="<?=base_url('advance_salary/getreport')?>">
            <div class="row">
               
                    <div class="col-sm-4">
                        <div class="form-group  row"><label>Month</label>
                            <select class="vehicle_inward_id form-control"  name="month" required="required">
                                <option value=''>--Select Month--</option>
                                <option value='1'>Janaury</option>
                                <option value='2'>February</option>
                                <option value='3'>March</option>
                                <option value='4'>April</option>
                                <option value='5'>May</option>
                                <option value='6'>June</option>
                                <option value='7'>July</option>
                                <option value='8'>August</option>
                                <option value='9'>September</option>
                                <option value='10'>October</option>
                                <option value='11'>November</option>
                                <option value='12'>December</option>
                            </select>
                            
                        </div>
                    </div>
                    
                   
                    <div class="col-sm-4">
                        <div class="form-group  row"><label>Month</label>
                            <select class="vehicle_inward_id form-control"  name="year" required="required">
                                <option value=''>--Select Year--</option>
                                <?php for($i=2019; $i<=2030; $i++){ ?>
                                <option value='<?=$i?>'><?=$i?></option>
                                 <?php } ?>
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
