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
// var_dump($form_data['account']['0']['account_name']);
// exit;
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
            <h1>Transport Invoice</h1>
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
                    <h5>Transport Invoice<small></small></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('Invoice/Transport') ?>"><i class="fa fa-angle-left"></i> View Records</a>
                    </div>
                </div>
                <?php } ?>

                <form id="frm_consignment" method="POST" action="<?=base_url('Invoice/TransportAddConsignment')?>">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-4" style="display: none;">
                            <div class="form-group"><label>Consignment Type</label>
                                <select class="rec form-control consignment_type" id="consignment_type" name="consignment_type">
                                    <option value="0" selected>Transport</option>
                                    <option value="1">Rent</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <input type="hidden" name="invoice_type" value="5">
                                <select class="consignee_billing_name form-control select2" name="consignee_billing_name">
                                    <option value="">Select Consignee</option>
                                    <?php
                                    foreach ($consignee_billing as $row) { ?>
                                        <option value='<?=$row['consignee_billing_id']?>' <?php if($row['consignee_billing_id']==$consignee_billing_name){ echo 'selected'; } ?>><?=$row['consignee_billing_name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <style>th{ text-align: center; } td { text-align: center; } </style>

<!--                        <form id="frm_consignment" method="POST" action="--><?//=base_url('Invoice/TransportAddConsignment')?><!--">-->
                            <div class="col-sm-12">
                                <input type="hidden" value="<?=$consignee_billing_name?>" name="billing_address_id">
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
                                        foreach ($record as $row){
                                            echo "<tr>";
                                            echo "<td>".$ctr."</td>";
                                            echo "<td>".$row['consignor_name']."</td>";
                                            echo "<td>".$row['consignee_name']."</td>";
                                            echo "<td>".$row['consignee_billing_name']."</td>";
                                            if($row['bill_type']=="0")
                                                echo "<td>"."FTL"."</td>";
                                            else
                                                echo "<td>"."Per Piece"."</td>";

                                            if($row['data_type']=="0") echo "<td>"."Outward"."</td>";

                                            else echo "<td>"."Inward"."</td>"; ?>
                                            <?php
                                                echo "<td><a href='".base_url('Invoice/TransportAddConsignment/').encryptor("encrypt",$row['transport_invoice_rate_id'])."'>Create Invoice</a> </td>";
                                            echo "</tr>";
                                            $ctr++;
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <button type="button" class="btn btn-info" id="btn_save_consignment">Save</button>
                                <button type="button" class="btn btn-default">Cancel</button>

                            </div>
                        </div>
                    </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>



<script src="<?php echo base_url() ?>assets/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/select2/select2.full.min.js"></script>


<script type="text/javascript">
    var lastid="";
    $(document).ready(function(){
        // $(".rent_stock_tr, .warehouse_id").hide();
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
                <?php $i=0; if($i==0){ echo "toastr.success('Delivery Challan', 'Please Select Consignor /Source Place.')"; $i++; } ?>
                // toastr.info('Please Select Consignment Type.', 'Consignment');
            }, 1300);}
        // Notification for Source Place Ends.
    });

    //    $("#warehouse_id").change(function(){
    //        $(".consignee_name").trigger("change");
    //        // Notification for Source Place Starts.
    //        if($("#warehouse_id").val()!="" && $("#source_id").val()==""){
    //            setTimeout(function() {
    //                toastr.options = {
    //                    closeButton: true,
    //                    progressBar: true,
    //                    showMethod: 'slideDown',
    //                    timeOut: 3000
    //                };
    //                <?php //$i=0; if($i==0){ echo "toastr.success('Delivery Challan', 'Please Select Consignor /Source Place.')"; $i++; } ?>
    //                // toastr.info('Please Select Consignment Type.', 'Consignment');
    //            }, 1300);}
    //        // Notification for Source Place Ends.
    //    });

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
                    <?php $i=0; if($i==0){ echo "toastr.success('Delivery Challan', 'Please Select Warehouse.')"; $i++; } ?>
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
        '</button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>'+
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

<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>


<script type="text/javascript">
    $(".chkbox").click(function(){
        var res=$(this).prop('checked');
        $(this).closest("td").find(".hidden").prop("checked",res);
    });
</script>


</body>
</html>
