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
            <h5>warehouse Wise Stock Report Form</h5>
            
        </div>
        <div class="ibox-content">
                <form method="post" action="<?=base_url('warehouse_wise_report/getreport')?>">
                    <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="form-group"><label>Warehouse Name</label>
                            <select class="consignee_name form-control"  name="warehouse_id" required="required">
                                <option value="">select warehouse</option>
                                <?php
                                    foreach ($warehouse as $row) {
                                        echo "<option value='".$row['warehouse_id']."'>".$row['warehouse_name']."</option>";
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
    
    $(document).ready(function(){
        $('.consignee_name').select2();
    });
    
</script>
