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
                    <form action="<?=base_url('invoice/boxrentupdate')?>" method="POST">
                        <input type="hidden" name="consignee_name" value="<?=$consignee_name?>">
                        <input type="hidden" name="invoice_id" value="<?=$invoice_id?>">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="table-responsive">
                                    <table class="table table-stripped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL. No</th>
                                                <th>Consignment No.</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ctr=1;
                                            $total=0;
                                            foreach ($invoice as $row) {
                                                echo "<tr>";
                                                echo "<td>".$ctr."</td>";
                                                echo "<td>".$row['consignment_id']."</td>";
                                                echo "<td>".date('d-m-Y',strtotime($row['consignment_date']))."</td>";
                                                echo "<td class='right'>".$row['price']."</td>";
                                                echo "<td ><input type='checkbox' name='consignment_id[]' value='".$row['consignment_id']."' checked='checked'></td></tr>";
                                                $ctr++;
                                                $total+=$row['price'];
                                            }
                                            foreach ($record as $row) {
                                                echo "<tr>";
                                                echo "<td>".$ctr."</td>";
                                                echo "<td>".$row['consignment_id']."</td>";
                                                echo "<td>".date('d-m-Y',strtotime($row['consignment_date']))."</td>";
                                                echo "<td class='right'>".$row['price']."</td>";
                                                echo "<td ><input type='checkbox' name='consignment_id[]' value='".$row['consignment_id']."'></td></tr>";
                                                $ctr++;
                                                $total+=$row['price'];
                                            }

                                            ?>
                                            <tr>
                                                <td colspan="3">Total</td>
                                                <td colspan="" class='right'><?=number_format((float)$total, 2, '.', '');?></td>
                                                <td><button type="submit" class="btn btn-info">Invoice</button></td>
                                            </tr>
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
$('.consignee_name').select2();
</script>
