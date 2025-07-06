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
<style type="text/css">
.right{
    text-align: right;
}

</style>
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
                    <form action="<?=base_url('invoice/warehouserent')?>" method="POST">
                        <input type="hidden" name="consignee_name" value="<?=$consignee_name?>">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="table-responsive">
                                    <table class="table table-stripped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL. No</th>
                                                <th>Consignee Name</th>
                                                <th>Amount</th>
                                                <th>Area</th>
                                                <th>Total</th>
                                                <th>Select Month</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>1</td>
                                            <td><?=$record->consignee_name?></td>
                                            <td><?=$record->price?></td>
                                            <td><?=$record->rent_warehouse_area?></td>
                                            <td><?=($record->rent_warehouse_area*$record->price)?></td>
                                            <td>
                                                <select id='gMonth2' name="month" class="form-control" onchange="show_month()">
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
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-info">Create Invoice</button>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
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
function show_month()
{
    //alert("call");
}
</script>
