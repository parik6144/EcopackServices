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
<style>
    .table > tfoot > tr > td{
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
    }
    .table > thead > tr > th{
        text-align: center;
    }
    .custom_control{
        margin-bottom: 15px;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10"><h2>Consignment</h2></div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-title">
                    <h5>Consignment  Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('consignment') ?>"><i class="fa fa-angle-left"></i>Back</a></span>
                </div>

                <?php } ?>
                <div class="ibox-content">
                    <form id="frm_consignment" method="POST" action="<?=base_url('consignment/edit')?>">
                        <input type="hidden" name="consignment_id" value="<?=encryptor('encrypt',$form_data['consignment']->consignment_id)?>">
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group  row" id="data_1">
                                    <label class="font-noraml">consignment Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="consignment_date" class="form-control purchase_date rec" value="<?=date("d-m-Y",strtotime($form_data['consignment']->consignment_date))?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">                                
                                <label>Consignment No</label>: <span><?=$form_data['consignment']->consignment_no?></span>
                                <div class="form-group  row"><label>Consignment Type</label>
                                    <select class="rec form-control consignment_type"  name="consignment_type">
                                        <option value="0" <?php if($form_data['consignment']->consignment_type=="0") echo "selected='selected'"; ?>>Transport</option>
                                        <option value="1" <?php if($form_data['consignment']->consignment_type=="1") echo "selected='selected'"; ?>>Rent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignor Name</label>
                                            <select class="consignor_name rec form-control"  name="consignor_id">
                                                <option value="">Select Consignor</option>
                                                <?php
                                                    foreach ($consignor as $row) {
                                                        $str="";
                                                        if($row['consignor_id']==$form_data['consignment']->consignor_id)
                                                        {
                                                            $str="selected='selected'";
                                                            $address=$row['address']." , ".$row['city'].", ".$row['state'].", ".$row['pincode'];
                                                            $mobile_no=$row['mobile_no'];
                                                        }
                                                        echo "<option ".$str." value='".$row['consignor_id']."' address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['mobile_no']."' pincode='".$row['pincode']."'>".$row['consignor_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label>Address: </label><span id="consignor_address"><?=$address?></span><br/>
                                            <label>Phone no:</label><span id="consignor_no"><?=$mobile_no?></span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignee Name</label>
                                            <select class="consignee_name rec form-control"  name="consignee_id" id="consignee_id">
                                                <option value="">Select Consignee</option>
                                                <?php
                                                $address="";
                                                        $mobile_no="";
                                                        $gstno="";
                                                    foreach ($consignee as $row) {
                                                        $str="";
                                                        if($row['consignee_id']==$form_data['consignment']->consignee_id)
                                                        {
                                                            $str="selected='selected'";
                                                            $address=$row['address']." , ".$row['city'].", ".$row['state'].", ".$row['pincode'];
                                                            $mobile_no=$row['mobile_no'];
                                                            $gstno=$row['gstin'];
                                                        }
                                                        echo "<option ".$str." value='".$row['consignee_id']."' address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['mobile_no']."' pincode='".$row['pincode']."'>".$row['consignee_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label>Address</label><span id="consignee_address"><?=$address?></span><br/>
                                            <label>Phone no:</label><span id="consignee_no"><?=$mobile_no?></span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group  row">
                                    <label>Source Place</label>
                                       <select class="consignor_place rec form-control"  name="source_id" >
                                        <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {
                                                $str="";
                                                if($form_data['consignment']->source_id==$row['place_id'])
                                                    $str="selected='selected'";
                                                ?>
                                                <option <?=$str?> value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group  row">
                                    <label>Destination Place</label>
                                        <select class="consignee_place rec form-control"  name="destination_id">
                                            <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {
                                                $str="";
                                                    if($form_data['consignment']->destination_id==$row['place_id'])
                                                        $str="selected='selected'";
                                                ?>
                                                <option <?=$str?> value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group  row warehouse_id">
                                    <label>WareHouse</label>

                                        <select class=" form-control"  name="warehouse_id">
                                            <option value="">Select warehouse</option>
                                            <?php
                                            foreach ($warehouse as $row) {
                                                $str="";
                                                if($row['warehouse_id']==$form_data['consignment']->consignment_warehouse_id)
                                                    $str="selected='selected'";
                                                ?>
                                                <option <?=$str?> value="<?=$row['warehouse_id']?>"><?=$row['warehouse_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                                 
                            </div>
                        </div>
                        <div class="row">
                        <div class="table-responsive">
                            <table class="table table-stripped table-bordered">
                                <thead>
                                    <tr>                                        
                                        <th>
                                            Item Name
                                        </th>                               
                                        <th>
                                            Qty
                                        </th>
                                        <th>
                                            #
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="other_product_td">
                                    
                                    <tr  class="rent_stock_tr">
                                        <td colspan="3"><h4 class="text-center">Rent Stock Item</h4></td>
                                    </tr>
                                    <tr class="rent_stock_tr">
                                        <td colspan="3">
                                            <table class="table table-stripped table-bordered">
                                                <tbody  class="rent_stock_row">
                                                    <?php
                                        if(isset($form_data['rent_stock_item']))
                                        {

                                        foreach ($form_data['rent_stock_item'] as $row) {
                                    ?>
                                    <tr class="rent_stock_tr">                                        
                                        <td><select class="RentitemName form-control" name="rent_stock_item_id[]">
                                            <option value="">Select Rent Item</option>
                                            <?php
                                            foreach ($rent_stock_item as $stockitem) {
                                                $str="";
                                                if($stockitem['item_id']==$row['item_id'])
                                                    $str="selected='selected'";
                                                echo "<option ".$str." value='".$stockitem['item_id']."'>".$stockitem['item_name']."</option>";
                                            }
                                            ?>
                                        </select></td>
                                        
                                        <td><input type="text" name="rent_stock_item_qty[]" class="form-control qty" placeholder="Qty" autocomplete="off" value="<?=$row['qty']?>"></td>
                                        <td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new" style="display: none;"><i class="fa fa-plus"></i>
                                                </button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete" ><i class="fa fa-trash"></i>
                                                </button></td> 
                                    </tr>
                                    <?php
                                        }
                                         
                                        }
                                    ?>


                                                    <tr>
                                                <td><select class="RentitemName form-control" name="rent_stock_item_id[]">
                                                    <option value="">Select Rent Item</option>
                                                    <?php
                                            foreach ($rent_stock_item as $stockitem) {
                                                echo "<option  value='".$stockitem['item_id']."'>".$stockitem['item_name']."</option>";
                                            }
                                            ?>
                                                </select></td>
                                                
                                                <td><input type="text" name="rent_stock_item_qty[]" class="form-control qty" placeholder="Qty" autocomplete="off"></td>
                                                <td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>
                                                </button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                                </button></td>  
                                            </tr>
                                                </tbody>
                                            </table>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                        foreach ($form_data['consignment_item'] as $row) {
                                    ?>
                                    <tr>                                        
                                        <td><input class="form-control" name="item_name[]"  value="<?=$row['item_name']?>"></td>
                                        <td><input type="text" name="other_qty[]" class="form-control total_other_qty" placeholder="Qty" value="<?=$row['qty']?>"></td>
                                        <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>                                        
                                        <td><input class="form-control" name="item_name[]"  value=""></td>
                                        <td><input type="text" name="other_qty[]" class="form-control total_other_qty" placeholder="Qty" value=""></td>
                                        <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                </tbody>
                                <tfoot id="product_td">
                                    <tr>
                                        <td colspan="3"><h4 class="tet-center">Billing Item</h4></td>
                                    </tr>
                                    <?php
                                        foreach ($form_data['consignment_stock_item'] as $row) {
                                    ?>
                                    <tr>                                        
                                        <td><select class="itemName form-control" name="item_id[]">
                                            <option value="">Select Item</option>
                                            <?php
                                            foreach ($item as $stockitem) {
                                                $str="";
                                                if($stockitem['item_id']==$row['item_id'])
                                                    $str="selected='selected'";
                                                echo "<option ".$str." value='".$stockitem['item_id']."'>".$stockitem['item_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <input type='hidden' name='itemPrice' class='itemPrice'>
                                        <input type="hidden" name="itemadvPrice" class="itemadvPrice">
                                        <input type="hidden" name="itemduePrice" class="itemduePrice">
                                        </td>
                                        
                                        <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" value="<?=$row['qty']?>"></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new" style="display: none;"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  ><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                    <?php } ?>
                                    <tr>                                        
                                        <td><select class="itemName form-control" name="item_id[]">
                                            <option value="">Select Item</option>
                                            <?php
                                            foreach ($item as $stockitem) {
                                                echo "<option value='".$stockitem['item_id']."'>".$stockitem['item_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                            <input type='hidden' name='itemPrice' class='itemPrice'>
                                            <input type="hidden" name="itemadvPrice" class="itemadvPrice">
                                            <input type="hidden" name="itemduePrice" class="itemduePrice">
                                        </td>

                                        <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" value=""></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                </tfoot>
                                
                            </table>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label ">Bill Type</label>
                                <div class="col-sm-9">
                                    <select name="bill_type" class="form-control  rec bill_type custom_control">
                                        <option value="">Select Bill Type</option>
                                        <option value="0" <?php if($form_data['consignment']->bill_type=="0") echo "selected='selected'"; ?>>FTL</option>
                                        <option value="1" <?php if($form_data['consignment']->bill_type=="1") echo "selected='selected'"; ?>>Part Load</option>
                                        <option value="2" <?php if($form_data['consignment']->bill_type=="2") echo "selected='selected'"; ?>>Skip</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label ">Value</label>
                                <div class="col-sm-9"><input type="text" class="form-control custom_control" value="<?=$form_data['consignment']->consignment_value?>"  name="consignment_value"></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">D.C No.</label>
                                <div class="col-sm-9"><input type="text" class="form-control custom_control" value="<?=$form_data['consignment']->d_c_no?>"  name="d_c_no"></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">Party GST No.</label>
                                <div class="col-sm-9"><input type="text" class="form-control custom_control consignee_gst_no"  name="party_gst_no" readonly="readonly" value="<?=$gstno?>"></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">Vehicle No</label>
                                <div class="col-sm-9"><select class="form-control rec custom_control js-example-basic-single" name="vehicle_id" id="vehicle_no">
                                <option value="">Select Vehicle</option>
                                <?php
                                    foreach ($vehicle as $row) {
                                        $str="";
                                        if($form_data['consignment']->vehicle_id== $row['vehicle_inward_id'])
                                            $str="selected='selected'";
                                        echo "<option ".$str." value='".$row['vehicle_inward_id']."'>".$row['vehicle_inward_no']."</option>";
                                    }
                                ?>                                    
                                </select> </div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">Way Bill No.</label>
                                <div class="col-sm-9"><input type="text" class="form-control custom_control" value="<?=$form_data['consignment']->way_bill_no ?>"  name="way_bill_no"></div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">Driver's name</label>
                                <div class="col-sm-9"><input type="text" readonly="readonly" class="form-control rec custom_control driver_name" value="<?=$form_data['consignment']->driver_name ?>" name="driver_name"></div>
                            </div>
                           
                            <div class="form-group  row"><label class="col-sm-3 control-label">Driver Mobile No.</label>
                                <div class="col-sm-9"><input type="text" readonly="readonly" class="form-control driver_mobile_no"  name="driver_mobile_no"></div>
                            </div>

                        </div>
                        <div class="col-sm-7">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Advance</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control rec custom_control advance"  name="advance" value="<?=$form_data['consignment']->advance ?>"  readonly="readonly">
                                    <input type="hidden" class="hidden_advance"  name="" readonly="readonly" value="<?=$form_data['consignment']->advance ?>" >
                                </div>
                            </div>
                            <div class="form-group  row"><label class="col-sm-3 control-label">Due</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control rec custom_control due"  name="due"  value="<?=$form_data['consignment']->due ?>" readonly="readonly">
                                    <input type="hidden" class="hidden_due"  name="" readonly="readonly" value="<?=$form_data['consignment']->due ?>">
                                    <input type="hidden" name="driver_price" id="driver_price" value="<?=$form_data['consignment']->driver_price ?>">
                                </div>
                            </div>
                           
                            <div class="form-group  row"><label class="col-sm-3 control-label">Employee</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="employee_rate" id="employee_rate" class="employee_rate" value="<?php if(isset($form_data['consignment_details']['0']['amount'])) echo $form_data['consignment_details']['0']['amount']; ?>">
                                    <?php
                                    $ctr=0;
                                    foreach ($employee as $row) {
                                        $str="";
                                        if(isset($form_data['consignment_details'][$ctr]['employee_id']))
                                        {
                                           if($form_data['consignment_details'][$ctr]['employee_id']==$row["employee_id"])
                                           {
                                                $str="checked='checked'";
                                           }
                                        }

                                        ?>
                                    <div class="checkbox i-checks"><label> <input type="checkbox" value="<?=$row["employee_id"]?>" name="employee_id[]" refid="$ctr" class="chkbox" <?=$str?>> <i></i><?=$row["employee_name"]?> </label></div>
                                    <?php
                                        $ctr++;
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="form-group  row"><label class="col-sm-3 control-label">vehicle Owner</label>
                                <div class="col-sm-9"><input type="text" readonly="readonly" class="form-control custom_control owner_name" id="vehicle_owner"></div>
                            </div>
                            <div class="pull-right">
                                <button type="button" class="btn btn-info" id="btn_save_consignment">Save</button>
                                <button type="button" class="btn btn-default">Cancel</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    var lastid="";
    $(document).ready(function(){
        
        $('.js-example-basic-single').select2();
         $(".itemName").change();
        
       
       
        if($(".consignment_type").val()=="1")
        {
            $(".rent_stock_tr, .warehouse_id").show();
        }
        else
        {
            $(".rent_stock_tr, .warehouse_id").hide();
        }
    });
    $(".consignee_place").change(function(){
        var place_id=$(this).val();

         $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignee/getConsigneeByPlace')?>',
                cache: false,
                async: false,
                data: {place:place_id},
                success: function (data) {
                    //swal("","Record Saved Successfully","success");
                   var record=JSON.parse(data);
                   var str="<option value=''>Select Consignee</option>";
                   $.each(record,function(k,v){
                        str+="<option value='"+v['consignee_id']+"' address='"+v['address']+"' city='"+v['city']+"' state='"+v['state']+"' phone='"+v['phone_no']+"' pincode='"+v['pincode']+"' gstin='"+v['gstin']+"'>"+v['consignee_name']+"</option>";
                   });
                   $(".consignee_name").html(str);
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
    });
    $(".consignor_place").change(function(){
        var place_id=$(this).val();
         $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignor/getConsignorByPlace')?>',
                cache: false,
                async: false,
                data: {place:place_id},
                success: function (data) {
                   var record=JSON.parse(data);
                   var str="<option value=''>Select Consignor</option>";
                   $.each(record,function(k,v){
                        str+="<option value='"+v['consignor_id']+"' address='"+v['address']+"' city='"+v['city']+"' state='"+v['state']+"' phone='"+v['phone_no']+"' pincode='"+v['pincode']+"'>"+v['consignor_name']+"</option>";
                   });
                   $(".consignor_name").html(str);
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
    });
     $(document).find(".itemName").change(function(){
            getItemPricebyConsingee(this);
        });
$(document).on("change",".qty",function(){
        
            var qty=0;
            var dueamount=0;
            $(".qty").each(function(){
                var tempqty=parseInt($(this).val());
                // console.log(tempqty);
                var amt =  parseInt($(this).closest("tr").find("input[name='itemadvPrice']").val());
                //console.log(amt);
                var dueamt =  parseInt($(this).closest("tr").find("input[name='itemduePrice']").val());
                if(!isNaN(tempqty))
                {
                    qty+=(tempqty*amt);
                   // console.log(qty);
                    dueamount+=(tempqty*dueamt);
                }
            });
            advance=qty;
            //console.log(advance);
            $(".advance").val(advance);
            $(".hidden_advance").val(advance);
            $(".due").val(dueamount);
            //console.log(dueamount);
            $(".hidden_due").val(dueamount);
    });
     $("#vehicle_no").change(function(){
        var vehicle_id=$(this).val();
        var consignee_id=$(".consignee_name").val();
        var consignor_id=$(".consignor_name").val();
        var bill_type=$(".bill_type").val();
        if(vehicle_id!="" && consignee_id!="" && bill_type!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('vehicle_inward/getvehicledetailsoutward')?>',
                cache: false,
                async: false,
                data: {vehicle_id:vehicle_id,consignee_id:consignee_id,consignor_id:consignor_id,bill_type:bill_type},
                success: function (data) {
                    var rec=JSON.parse(data);
                    $(".driver_name").val(rec.vehicle['0'].driver_name);
                    $(".driver_mobile_no").val(rec.vehicle['0'].mobile_no);
                    $(".owner_name").val(rec.vehicle['0'].owner_name);
                    $(".owner_address").val(rec.vehicle['0'].address);
                    if(rec.amount.vehicle_price.length>0)
                    {
                        var advance=rec.amount.vehicle_price['0'].advance;
                        var due=rec.amount.vehicle_price['0'].due;
                        if(advance!=""){
                            advance=parseInt(advance);
                        }
                        if(due!=""){
                            due=parseInt(due);
                        }
                        // if($(".bill_type").val()=="1")
                        // {
                        //     var qty=0;
                        //     $(".qty").each(function(){
                        //         var tempqty=parseInt($(this).val());
                        //         if(!isNaN(tempqty))
                        //         {
                        //             qty+=tempqty;
                        //         }
                        //     });
                        //     advance=advance*qty;
                        //     due=due*qty;
                        // }
                        // $(".advance").val(advance);
                        // $(".hidden_advance").val(rec.amount.vehicle_price['0'].advance);
                        // $(".due").val(due);
                        // $(".hidden_due").val(rec.amount.vehicle_price['0'].due);
                        // $("#employee_rate").val(rec.amount.vehicle_price['0'].employee_charge);
                        // $("#driver_price").val(rec.amount.vehicle_price['0'].driver_price);
                        if($(".bill_type").val()=="1")
                        {
                            var qty=0;
                            var dueamount=0;
                            $(".qty").each(function(){
                                var tempqty=parseInt($(this).val());
                                var amt =  parseInt($(this).closest("tr").find("input[name='itemadvPrice']").val());
                                var dueamt =  parseInt($(this).closest("tr").find("input[name='itemduePrice']").val());
                               
                                if(!isNaN(tempqty))
                                {
                                    qty+=(tempqty*amt);
                                    dueamount+=(tempqty*dueamt);
                                }
                            });
                            advance=qty;
                            $(".advance").val(advance);
                            $(".hidden_advance").val(advance);
                            $(".due").val(dueamount);
                            $(".hidden_due").val(dueamount);
                            $("#employee_rate").val(rec.amount.vehicle_price['0'].employee_charge);
                            $("#driver_price").val(rec.amount.vehicle_price['0'].driver_price);
                        }
                        else
                        { 
                        $(".advance").val(advance);
                        $(".hidden_advance").val(advance);
                        $(".due").val(due);
                        $(".hidden_due").val(due);
                        $("#employee_rate").val(rec.amount.vehicle_price['0'].employee_charge);
                        $("#driver_price").val(rec.amount.vehicle_price['0'].driver_price);
                        }
                    }
                    else
                    {
                        $(".advance").val("0");
                        $(".hidden_advance").val("0");
                        $(".due").val("0");
                        $(".hidden_due").val("0");
                        $("#employee_rate").val("0");
                        $("#driver_price").val("0");
                    }
                    
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
        }
         
    });

     $(".consignor_name").change(function(){
        if($(this).val()!="")
        {
            $("#consignor_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
            $("#consignor_no").html($(this).find("option:selected").attr("phone"));
            $("#vehicle_no").trigger("change");
        }
        else
        {
             $("#consignor_address").html("");
             $("#consignor_no").html("");
        }
        
     });
     $(".consignment_type").change(function(){
        if($(".consignment_type").val()=="1")
        {
            $(".rent_stock_tr, .warehouse_id").show();
        }
        else
        {
            $(".rent_stock_tr, .warehouse_id").hide();
        }
        $(".consignee_name").trigger("change");
     });
     function getRentStockItem()
     {
        var consignee_id=$(".consignee_name").val();
        var consignment_type=$(".consignment_type").val();
        if(consignee_id!="")
        {
            //alert(consignee_id);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getrentstockitem')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"'>"+v['item_name']+"</option>";
                    });
                    $(".RentitemName").html(str);
                    $("#loaded_by").show();
                    //$("#vehicle_no").trigger("change");

                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
        }
        
     }
     $(".consignee_name").change(function(){
         if($(this).val()!="")
        {
            $("#consignee_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
            $("#consignee_no").html($(this).find("option:selected").attr("phone"));
            $(".consignee_gst_no").val($(this).find("option:selected").attr("gstin"));
        }
        else
        {
            ("#consignee_address").html("");
            $("#consignee_no").html("");
        }
        if($(".consignment_type").val()=="1")
        {
            getRentStockItem();
        }
        var consignee_id=$(this).val();
        var consignment_type=$(".consignment_type").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getItemByConsigneeId')?>',
                cache: false,
                async: false,
                data: {consignee_id:consignee_id,'consignment_type':consignment_type},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"'>"+v['item_name']+"</option>";
                    });
                    $(".itemName").html(str);
                    $("#loaded_by").show();
                    $("#vehicle_no").trigger("change");

                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
     });
    $(document).ready(function () {

    });

    $("#btn_save_consignment").click(function () {
        var ref=$(this);
        if(validate(ref))
        {

            $("#frm_consignment").submit();
        }
        else
        {

        }

    });
    $(document).on("click",".add_new",function () {
        
 //        var myvar =   '<tr>'; 
 //        myvar +=   '<td><select class="itemName form-control" name="item_id[]">'; 
 //        myvar +=   $(".itemName:first").html()+"</select>"; 
 //        myvar +=   '</td>'+
 // '                                           <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty"></td>  '  + 
 // '                                           <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>  '  + 
 // '                                           </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  + 
 // '                                          </button></td> </tr>';
        var myvar = '<tr>'+
                    '<td><select class="itemName form-control" name="item_id[]">'+
                    $(".itemName:first").html()+
                    '</select>'+
                    '<input type="hidden" name="itemPrice" class="itemPrice">'+
                    '<input type="hidden" name="itemadvPrice" class="itemadvPrice">'+
                    '<input type="hidden" name="itemduePrice" class="itemduePrice">'+
                    '</td>'+
                    '<td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" autocomplete="off"></td>'+
                    '<td>'+
                    '<button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>'+
                    '</button>'+
                    '<button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>'+
                    '</button>'+
                    '</td>'+
                    '</tr>';


        $("#product_td").append(myvar);
        $(".add_new").hide();
        $(".add_new:last").show();
        $(".btn_delete").show();
        $(".btn_delete:last").hide();
        
    });
$(document).on("click",".add_new_rent_stock_item",function () {
            
            var myvar =   '<tr>'; 
            myvar +=   '<td><select class="itemName form-control" name="rent_stock_item_id[]" onchange="getItemPricebyConsingee(this);">';
            myvar +=   $(".RentitemName:first").html()+"</select><input type='hidden' name='itemadvPrice' class='itemadvPrice'>";
            myvar +=   '<input type="hidden" name="itemduePrice" class="itemduePrice"></td>'+
     ' <td><input type="text" name="rent_stock_item_qty[]" class="form-control qty" placeholder="Qty"></td>  '  +
     ' <td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>  '  +
     '</button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  +
     '</button></td> </tr>';


            $(".rent_stock_row").append(myvar);
            $(".add_new_rent_stock_item").hide();
            $(".add_new_rent_stock_item:last").show();
            $(".btn_delete_rent_stock_item").show();
            $(".btn_delete_rent_stock_item:last").hide();

    });
    $(document).on("click",".add_new_default",function () {
        
        var myvar =   '<tr>'; 
        myvar +=   '<td><input type="text" name="item_name[]" class="form-control">'; 
        myvar +=   '</td>'+
 '                                           <td><input type="text" name="other_qty[]" class="form-control other_qty" placeholder="Qty"></td>  '  + 
 '                                           <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>  '  + 
 '                                           </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  + 
 '                                          </button></td> </tr>';


        $("#other_product_td").append(myvar);
        $(".add_new_default").hide();
        $(".add_new_default:last").show();
        $(".btn_delete_default").show();
        $(".btn_delete_default:last").hide();
        
    });

    $(document).on("click",".btn_delete",function () {
        var ref=$(this);
        swal({
      title: "Are you sure?",
      text: "You want to delete this record!",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: true
    },
    function(){
      //swal("Deleted!", "Your imaginary file has been deleted.", "success");
      $(ref).parent().parent().remove();
    });
        
    });
    $(document).on("click",".btn_delete_rent_stock_item",function () {
        var ref=$(this);
        swal({
      title: "Are you sure?",
      text: "You want to delete this record!",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: true
    },
    function(){
      //swal("Deleted!", "Your imaginary file has been deleted.", "success");
      $(ref).parent().parent().remove();
    });
        
    });
    $(document).on("click",".btn_delete_default",function () {
        var ref=$(this);
        swal({
      title: "Are you sure?",
      text: "You want to delete this record!",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: true
    },
    function(){
      //swal("Deleted!", "Your imaginary file has been deleted.", "success");
      $(ref).parent().parent().remove();
    });
        
    });
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $(document).on("change",".qty",function(){
            var qty=0;
            var dueamount=0;
            $(".qty").each(function(){
                var tempqty=parseInt($(this).val());
                //alert(tempqty);
                //console.log(tempqty);
                var amt =  parseInt($(this).closest("tr").find("input[name='itemadvPrice']").val());
                var dueamt =  parseInt($(this).closest("tr").find("input[name='itemduePrice']").val());
                if(!isNaN(tempqty))
                {
                    console.log(tempqty);
                    console.log(amt);
                    qty+=(tempqty*amt);
                    dueamount+=(tempqty*dueamt);
                    //console.log(qty);
                }
            });
            advance=qty;
            //console.log(advance);
            $(".advance").val(advance);
            $(".hidden_advance").val(advance);
            $(".due").val(dueamount);
            //console.log(dueamount);
            $(".hidden_due").val(dueamount);
    });

    $(".bill_type").change(function(){
        if($(this).val()!="")
        {
            $("#vehicle_no").change();
        }
        else
        {
            $(".advance, .due").val("0");
        }
    });

    function getItemPricebyConsingee(ref){
        var itemid = $(ref).val();
        var consignee_id=$("#consignee_id").val();
         console.log(consignee_id);
         console.log(itemid);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('item/getpricebyconsigneeID')?>',
            cache: false,
            async: false,
            data: {'consignee_id':consignee_id,'itemid':itemid},
            success: function (data) {
                var rec=JSON.parse(data);
                //$(ref).parent("td").find(".itemPrice").val(rec['price']);
                $(ref).parent("td").find(".itemadvPrice").val(rec['advance']);
                $(ref).parent("td").find(".itemduePrice").val(rec['due']);
                //alert($(ref).parent("td").find(".itemPrice").val());
                $("#vehicle_no").change();

            },
            error: function (data) {
                // alert("error");
            },
            timeout: 5000,
            error: function(jqXHR, textStatus, errorThrown) {
                swal("","Please check your internet connection.","error");
            }
        });
        //alert(y);
    }
</script>
</body>
</html>
