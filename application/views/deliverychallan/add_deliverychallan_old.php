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
<link rel="stylesheet" href="https://harvesthq.github.io/chosen/chosen.css">
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
        .ibox-tools a {
            cursor: pointer;
            margin-left: 5px;
            color: #fefefe !important;
            font-size: 16px;
            background: #1ab394;
            padding: 3px 10px;
            border-radius: 3px;
        }
        .output-data-by {
            padding: 10px 0 0;
        }

        .output-data-by label.ad {
            font-weight: 600;
            font-size: 14px;
        }

        .output-data-by label.ph {
            font-weight: 600;
            font-size: 14px;
        }
        .i-checks {
            padding-left: 0;
            display: inline-block;
            margin-right: 10px;
        }
    </style>

<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h1>Delivery Challan</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"></li>
            </ol>
        </div>

        <div class="col-lg-2"></div>
    </div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Delivery Challan<small></small></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('Deliverychallan') ?>"><i class="fa fa-angle-left"></i> Back</a>
                    </div>
                </div>
                <?php } ?>

                <form id="frm_consignment" method="POST" action="<?=base_url('Deliverychallan/add')?>">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group" id="data_1">
                                    <label class="font-noraml">Delivery Challan Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="consignment_date" class="form-control purchase_date rec" value="<?=date("d-m-Y");?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"><label>Delivery Challan Type</label>
                                    <select class="rec form-control consignment_type" id="consignment_type" name="consignment_type">
                                        <option value="2" >Rental</option>
                                        <option value="1" >Rental</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group warehouse_id">
                                    <label>Warehouse</label>
                                    <select class=" form-control"  id="warehouse_id" name="warehouse_id">
                                        <option value="">Select Warehouse</option>
                                        <?php
                                        foreach ($warehouse as $row) {
                                            ?>
                                            <option value="<?=$row['warehouse_id']?>"><?=$row['warehouse_name']?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Source Place</label>
                                    <select class="consignor_place rec form-control"  name="source_id" id="source_id">
                                        <option value=''>Select Place</option>
                                        <?php foreach ($place as $row) { ?>
                                            <option value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Destination Place</label>
                                    <select class="consignee_place rec form-control"  name="destination_id" id="destination_id">
                                        <option value="">Select Place</option>
                                        <?php foreach ($place as $row) { ?>
                                            <option value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group"><label>Consignor Name</label>
                                            <select class="consignor_name rec form-control"  name="consignor_id" id="consignor_id">
                                                <option value="">Select Consignor</option>
                                            </select>
                                            <div class="output-data-by" id="dispconsignor" style="display: none;">
                                                <label class="ad">Address&nbsp;: </label>&nbsp;&nbsp;<span id="consignor_address"></span><br/>
                                                <label class="ph">Phone-No&nbsp;:</label>&nbsp;&nbsp;<span id="consignor_no"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Consignee Name</label>
                                            <select class="consignee_name rec form-control" name="consignee_id" id="consignee_id">
                                                <option value="">Select Consignee</option>
                                            </select>

                                            <div class="output-data-by" id="dispconsignee" style="display: none;">
                                                <label class="ad">Address&nbsp;&nbsp;:</label>&nbsp;&nbsp;&nbsp;<span id="consignee_address"></span><br/>
                                                <label class="ph">Phone No&nbsp;&nbsp;:</label>&nbsp;&nbsp;&nbsp;<span id="consignee_no"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
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
                                        <tr>
                                            <td><input class="form-control" name="item_name[]"></td>
                                            <td><input type="text" name="other_qty[]" class="form-control total_other_qty" placeholder="Qty" autocomplete="off"></td>
                                            <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>
                                                </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                                </button></td>
                                        </tr>
                                        <tr class="rent_stock_tr">
                                            <td colspan="3"><h4 class="text-center">Rent Stock Item</h4></td>
                                        </tr>
                                        <tr class="rent_stock_tr">
                                            <td colspan="3">
                                                <table class="table table-stripped table-bordered">
                                                    <tbody  class="rent_stock_row">
                                                    <tr>
                                                        <td>
                                                            <select class="RentitemName form-control" name="rent_stock_item_id[]">
                                                                <option value="">Select Rent Item</option>
                                                            </select>
                                                        </td>

                                                        <td><input type="text" name="rent_stock_item_qty[]" class="form-control rent_stock_item_qty qty" placeholder="Qty" autocomplete="off"></td>
                                                        <td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>
                                                            </button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                                            </button></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>

                                        <tfoot id="product_td">
                                        <tr>
                                            <td colspan="3"><h4 class="text-center">Billing Item</h4></td>
                                        </tr>
                                        <tr>

                                            <td><select class="itemName form-control" name="item_id[]" onchange="getItemPricebyConsingee(this);">
                                                    <option value="">Select Item</option>
                                                </select>
                                                <input type='hidden' name='itemPrice' class='itemPrice'>
                                                <input type="hidden" name="itemadvPrice" class="itemadvPrice">
                                                <input type="hidden" name="itemduePrice" class="itemduePrice">
                                            </td>

                                            <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" autocomplete="off"></td>
                                            <td>
                                                <button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                                </button>
                                                <button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"><label class="control-label ">Bill Type</label>
                                    <div class="">
                                        <select name="bill_type" class="form-control  rec bill_type custom_control">
                                            <option value="">Select Bill Type</option>
                                            <option value="0">FTL</option>
                                            <option value="1">Part Load</option>
                                            <option value="2">Skip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"><label class="control-label ">Value</label>
                                    <div class=""><input type="text" class="form-control custom_control" value="Not For Sale Material" name="consignment_value"></div>
                                </div>
                                <div class="form-group"><label class=" control-label">D.C No.</label>
                                    <div class=""><input type="text" class="form-control custom_control"  name="d_c_no"></div>
                                </div>
                                <div class="form-group"><label class=" control-label">Party GST No.</label>
                                    <div class=""><input type="text" class="form-control custom_control consignee_gst_no"  name="party_gst_no" readonly="readonly"></div>
                                </div>

                                <div class="form-group"><label class=" control-label">Driver's name</label>
                                    <div class=""><input type="text" readonly="readonly" class="form-control rec custom_control driver_name"  name="driver_name"></div>
                                </div>

                                <div class="form-group"><label class=" control-label">Driver Mobile No.</label>
                                    <div class=""><input type="text" readonly="readonly" class="form-control rec driver_mobile_no"  name="driver_mobile_no"></div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"><label class="control-label">Advance</label>
                                    <div class="">
                                        <input type="text" class="form-control custom_control advance"  name="advance" value="0" readonly="readonly">
                                        <input type="hidden" class="hidden_advance"  name="" readonly="readonly" value="0">
                                    </div>
                                </div>
                                <div class="form-group"><label class=" control-label">Due</label>
                                    <div class="">
                                        <input type="text" class="form-control rec custom_control due"  name="due" value="0" readonly="readonly">
                                        <input type="hidden" class="hidden_due"  name="" readonly="readonly" value="0">
                                        <input type="hidden" name="driver_price" id="driver_price" value="0">
                                    </div>
                                </div>
                                <!-- <div class="form-group  row"><label class="col-sm-3 control-label">To Pay Rs</label>
                                    <div class="col-sm-9"><input type="text" class="form-control rec custom_control to_pay"  name="to_pay_rs"  readonly="readonly"></div>
                                </div> -->
                                <div class="form-group"><label class="control-label">Employee</label>
                                    <div class="">
                                        <input type="hidden" name="employee_rate" id="employee_rate" class="employee_rate">
                                        <?php
                                        $ctr=0;
                                        foreach ($employee as $row) { ?>
                                            <div class="checkbox i-checks"><label> <input type="checkbox" value="<?=$row["employee_id"]?>" name="employee_id[]" refid="$ctr" class="chkbox"> <i></i><?=$row["employee_name"]?> </label></div>
                                            <?php $ctr++; } ?>
                                    </div>
                                </div>
                                <div class="form-group"><label class=" control-label">Vehicle No</label>
                                    <div class="">
                                        <select style="width:100%" class="form-control rec custom_control js-example-basic-single" name="vehicle_id" id="vehicle_no">
                                            <option value="">Select Vehicle</option>
                                            <?php
                                            foreach ($vehicle as $row){
                                                echo "<option value='".$row['vehicle_inward_id']."'>".$row['vehicle_inward_no']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"><label class=" control-label">Way Bill No.</label>
                                    <div class=""><input type="text" class="form-control custom_control"  name="way_bill_no"></div>
                                </div>
                                <div class="form-group"><label class="control-label">vehicle Owner</label>
                                    <div class=""><input type="text" readonly="readonly" class="form-control custom_control owner_name" id="vehicle_owner"></div>
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-info" id="btn_save_consignment">Save</button>
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <?php
                if(!isset($condition)) {
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); } ?>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 3000
            };
            <?php $i=0; if($i==0){ echo "toastr.success('Delivery Challan</br><small>Please select Consignment Type.</small>', 'Welcome to Ecopack Services.')"; $i++; } ?>
            // toastr.info('Please Select Consignment Type.', 'Consignment');
        }, 1300);
    });

    $('#source_id').change(function() {
        if($("#source_id").val()!="" && $("#consignor_id ").val()==""){
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.success('', 'Please Select Consignor.')
                // toastr.info('Please Select Consignment Type.', 'Consignment');
            }, 1300); }
    });


    $('#consignor_id').change(function() {
        if($("#consignor_id ").val()!=""){
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.success('', 'Please Select Consignment Destination.')
                // toastr.info('Please Select Consignment Type.', 'Consignment');
            }, 1300); }
    });

    $('#destination_id').change(function() {
        if($("#destination_id").val()!="" && $("#consignee_id ").val()==""){
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.success('', 'Please Select Consignee.')
                // toastr.info('Please Select Consignment Type.', 'Consignment');
            }, 1300); }
    });

    $('#consignor_id').change(function() {
        if($("#consignor_id").val()!=''){ $("#dispconsignor").show();  }
        if($("#consignor_id").val()==''){ $("#dispconsignor").hide();  }
    });

    $('#consignee_id').change(function() {
        if($("#consignee_id").val()!=''){ $("#dispconsignee").show();  }
        if($("#consignee_id").val()==''){ $("#dispconsignee").hide();  }
    });
</script>


<script src="<?php echo base_url() ?>assets/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/select2/select2.full.min.js"></script>


<script type="text/javascript">
    var lastid="";
    $(document).ready(function(){
        $(".rent_stock_tr, .warehouse_id").hide();
        $('.js-example-basic-single').select2();
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
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
                $('.consignee_name').select2();
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
            data: { place:place_id },
            success: function (data) {
                //swal("","Record Saved Successfully","success");
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
    $("#vehicle_no").change(function(){
        var vehicle_id=$(this).val();
        var consignee_id=$(".consignee_name").val();
        var consignor_id=$(".consignor_name").val();
        var bill_type=$(".bill_type").val();
        if(vehicle_id!="" && consignee_id!="" && bill_type!="" && consignor_id!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('vehicle_inward/getvehicledetailsoutward')?>',
                cache: false,
                async: false,
                data: { vehicle_id:vehicle_id, consignee_id:consignee_id, consignor_id:consignor_id, bill_type:bill_type},
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
                        if($(".bill_type").val()=="1")
                        {
                            var qty=0;
                            var dueamount=0;
                            $(".qty").each(function(){
                                var tempqty=parseInt($(this).val());
                                // console.log(tempqty);
                                var amt =  parseInt($(this).closest("tr").find("input[name='itemadvPrice']").val());
                                var dueamt =  parseInt($(this).closest("tr").find("input[name='itemduePrice']").val());
                                // console.log(amt);
                                // console.log(dueamt);
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
                        //console.log($(".hidden_advance").val());
                        $(".due").val(due);
                        $(".hidden_due").val(due);
                         //console.log($(".hidden_due").val());
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

    $(".consignment_type").onload(function(){
        $("#warehouse_id").show();
        if($(".consignment_type").val()=="1")
        {

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
        var warehouse_id=$("#warehouse_id").val();
        if(consignee_id!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getrentstockitem')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id,'warehouse_id':warehouse_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"' stock='"+v['crstock']+"'>"+v['item_name']+"</option>";
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

    $("#warehouse_id").change(function(){
        $(".consignee_name").trigger("change");
        // Notification for Source Place Starts.
        if($("#warehouse_id").val()!="" && $("#source_id").val()==""){
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                <?php $i=0; if($i==0){ echo "toastr.success('Consignment', 'Please Select Source Place.')"; $i++; } ?>
                // toastr.info('Please Select Consignment Type.', 'Consignment');
            }, 1300);}
        // Notification for Source Place Ends.
    });

    $(".consignee_name").change(function(){
        if($(".consignment_type").val()=="1")
        {
            if($("#warehouse_id").val()=="")
            {
                //alert("select Werehouse");
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };
                    <?php $i=0; if($i==0){ echo "toastr.success('Consignment', 'Please Select Warehouse.')"; $i++; } ?>
                    // toastr.info('Please Select Consignment Type.', 'Consignment');
                }, 1300);
                $(this).val("");
            }
            else
                getRentStockItem();
        }
        if($(this).val()!="")
        {
            $("#consignee_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
            $("#consignee_no").html($(this).find("option:selected").attr("phone"));
            $(".consignee_gst_no").val($(this).find("option:selected").attr("gstin"));
            var consignee_id=$(this).val();
            var consignment_type=$(".consignment_type").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getItemByConsigneeId')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id,'consignment_type':consignment_type},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        //console.log(v);
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
        }
        else
        {
            $("#consignee_address").html("");
            $("#consignee_no").html("");
        }
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
        var myvar = '<tr>'+
            '<td><select class="itemName form-control" name="item_id[]" onchange="getItemPricebyConsingee(this);">'+
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

    $(document).on("click",".add_new_rent_stock_item",function (){
        var myvar =   '<tr>';
        //myvar +=   '<td><select class="itemName form-control" name="rent_stock_item_id[]">';
        myvar +=   '<td><select class="RentitemName form-control" name="rent_stock_item_id[]">';
        myvar +=   $(".RentitemName:first").html()+"</select>";
        myvar +=   '</td>'+
        '<td><input type="text" name="rent_stock_item_qty[]" class="form-control qty rent_stock_item_qty" placeholder="Qty"></td>  '  +
        '<td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>  '  +
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
        '<td><input type="text" name="other_qty[]" class="form-control other_qty" placeholder="Qty" autocomplete="off"></td>  '  +
        '<td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>  '  +
        '</button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  +
        '</button></td></tr>';
        $(myvar).insertBefore(".rent_stock_tr:first");
        //$("#other_product_td").append(myvar);
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
                // console.log(tempqty);
                var amt =  parseInt($(this).closest("tr").find("input[name='itemadvPrice']").val());
                var dueamt =  parseInt($(this).closest("tr").find("input[name='itemduePrice']").val());
                if(!isNaN(tempqty))
                {
                    qty+=(tempqty*amt);
                    dueamount+=(tempqty*dueamt);
                }
            });
            advance=qty;
            console.log(advance);
            $(".advance").val(advance);
            $(".hidden_advance").val(advance);
            $(".due").val(dueamount);
            console.log(dueamount);
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

    $(document).on("change",".rent_stock_item_qty",function(){
        var iemid=$(this).closest("tr").find(".RentitemName").val();
        if(iemid=="")
        {
            alert("Please Select Item first");
        }
        else
        {
            var crstock=parseInt($(this).closest("tr").find(".RentitemName option:selected").attr("stock"));
            var qty=parseInt($(this).val());
            if(qty>crstock)
            {
                alert("Invalid value: current stock is "+crstock);
                $(this).val("0");
            }
        }
    });

    function getItemPricebyConsingee(ref){

        var itemid = $(ref).val();
        var consignee_id=$("#consignee_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('item/getpricebyconsigneeID')?>',
            cache: false,
            async: false,
            data: {'consignee_id':consignee_id,'itemid':itemid},
            success: function (data) {
                var rec=JSON.parse(data);
                $(ref).parent("td").find(".itemPrice").val(rec['price']);
                $(ref).parent("td").find(".itemadvPrice").val(rec['advance']);
                $(ref).parent("td").find(".itemduePrice").val(rec['due']);
                //alert($(ref).parent("td").find(".itemPrice").val());

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
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js" type="text/javascript"></script>
</body>
</html>
