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
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rate</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Rate Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('vehicle') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php }  ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_rate">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignor Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignor_name" name="consignor_id">
                                    <option value="<?=$edit_data['form_data']->consignor_id?>"><?=$edit_data['form_data']->consignor_name?></option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignee_name" name="consignee_id">
                                    <option value="<?=$edit_data['form_data']->consignee_id?>"><?=$edit_data['form_data']->consignee_name?></option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Billing Address</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignee_name" name="consignee_billing_id">
                                    <?php
                                        foreach ($billing_address as $row) {
                                            $str="";
                                            if($edit_data['form_data']->billing_address_id==$row['consignee_billing_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option value="<?=$row['consignee_billing_id']?>" <?=$str?>><?=$row['consignee_billing_name']?></option>
                                            <?php
                                        }
                                    ?>


                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 control-label">Invoice Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec invoice_type" name="invoice_type">
                                    <?php 
                                        if($edit_data['form_data']->bill_type=="0"){
                                            echo '<option value="0">FTL</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="1">Per Piece Rate</option>';
                                        }

                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Data Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" name="data_type">
                                    <?php 
                                        if($edit_data['form_data']->data_type=="0"){
                                            echo '<option value="0">Outward</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="1">Inward</option>';
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php 
                            if($edit_data['form_data']->bill_type=="0"){
                        ?>
                        <table class="table table-bordered table vehicle_table">
                            <thead>
                                <tr>
                                    <th>Vehicle Type</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($edit_data['data'] as $row) {
                                    ?>
                                    <tr>
                                        <td><input type="hidden" name="vehicle_type_id[]" value="<?=$row['ref_id']?>">
                                            <label><?=$row['vehicle_type']?></label></td>
                                        <td><input type="text" name="vehicle_price[]" class="form-control" value="<?=$row['amount']?>"> </td>
                                    <?php
                                    }
                                    foreach ($edit_data['other'] as $row) {
                                    ?>
                                    <tr>
                                        <td><input type="hidden" name="vehicle_type_id[]" value="<?=$row['ref_id']?>">
                                            <label><?=$row['vehicle_type']?></label></td>
                                        <td><input type="text" name="vehicle_price[]" class="form-control" value="<?=$row['amount']?>"> </td>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table> 
                        <?php
                        }
                        else
                        {
                            ?>

                        <table class="table table-bordered table item_table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($edit_data['data'] as $row) {
                                    ?>
                                    <tr>
                                        <td><input type="hidden" name="item_id[]" value="<?=$row['ref_id']?>">
                                            <label><?=$row['item_name']?></label></td>
                                        <td><input type="text" name="item_price[]" class="form-control" value="<?=$row['amount']?>"> </td>
                                    <?php
                                    }
                                    foreach ($edit_data['other'] as $row) {
                                    ?>
                                    <tr>
                                        <td><input type="hidden" name="item_id[]" value="<?=$row['ref_id']?>">
                                            <label><?=$row['item_name']?></label></td>
                                        <td><input type="text" name="item_price[]" class="form-control" value="<?=$row['amount']?>"> </td>
                                    <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }   
                        ?>
                        <button type="button" class="btn btn-success" id="btn_save_vehicle">Save</button>
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


<script type="text/javascript">
    var lastid="";
    
   //$(".item_table").hide();
   //$(".vehicle_table").hide();
    $("#btn_save_vehicle").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('transport_invoice_rate/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_rate").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_rate")[0].reset();
                    $('#vehicleModal').modal('hide');
                },
                error: function (data) {
                    // alert("error");
                },
            timeout: 5000,
            error: function(jqXHR, textStatus, errorThrown) {
                swal("","Please check your internet connection.","error");
            },
             beforeSend: function() {
                 $('#loader').show();
              },
              complete: function(){                
                 $('#loader').hide();
              }
            });
        }
        else
        {

        }

    });
</script>
</body>
</html>
