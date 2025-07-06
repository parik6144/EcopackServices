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
                    <form action="<?=base_url('invoice/transportinvoice')?>" method="POST">
                        <input type="hidden" value="<?=$consignee_billing_name?>" name="billing_address_id">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="table-responsive">
                                    <table class="table table-stripped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl. No</th>
                                                <th>Consignor Name</th>
                                                <th>Consignee Name</th>
                                                <th>Billing Address</th>
                                                <th>Invoice Type</th>
                                                <th>Data Type</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ctr=1;
                                            $total=0;
                                            foreach ($record as $row)
                                            {
                                                echo "<tr>";
                                                echo "<td>".$ctr."</td>";
                                                echo "<td>".$row['consignor_name']."</td>";
                                                echo "<td>".$row['consignee_name']."</td>";
                                                echo "<td>".$row['consignee_billing_name']."</td>";
                                                if($row['bill_type']=="0")
                                                    echo "<td>"."FTL"."</td>";
                                                else
                                                    echo "<td>"."Per Piece"."</td>";

                                                if($row['data_type']=="0")
                                                    echo "<td>"."Outward"."</td>";
                                                else
                                                    echo "<td>"."Inward"."</td>";
                                                echo "<td><input type='checkbox' class='chkbox' name='transport_invoice_rate_id[]' value='".$row['transport_invoice_rate_id']."'>
                                                    <input type='checkbox' class='hidden' name='consignor_id[]' value='".$row['consignor_id']."'>
                                                    <input type='checkbox' class='hidden' name='consignee_id[]' value='".$row['consignee_id']."'>
                                                    <input type='checkbox' class='hidden' name='bill_type[]' value='".$row['bill_type']."'>
                                                    <input type='checkbox' class='hidden' name='data_type[]' value='".$row['data_type']."'>
                                                </td>";
                                                echo "</tr>";
                                                $ctr++;
                                            }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-info">Create Invoice</button>
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
$(".chkbox").click(function(){
    var res=$(this).prop('checked');
    $(this).closest("td").find(".hidden").prop("checked",res);
});
</script>
