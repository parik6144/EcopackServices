<?php
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
            <h1>Purchase Order</h1>
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
                    <h5>Sales Order<small></small></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('PurchaseOrder') ?>"><i class="fa fa-angle-left"></i> View Records</a>
                    </div>
                </div>
                <?php } ?>

                <form id="frm_consignment" method="POST" action="<?=base_url('PurchaseOrder/add')?>">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group" id="data_1">
                                    <label class="font-noraml">Sales Order Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="consignment_date" class="form-control purchase_date rec" value="<?=date("d-m-Y");?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Refrence No <span style="color:#FF0000;">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control user-error" name="purchaseinvoice" required="" tabindex="4" aria-invalid="true">
                                </div>
                            </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Party Place</label>
                                    <select class="consignee_place rec form-control"  name="destination_id" id="destination_id">
                                        <option value="">Select Party Place</option>
                                        <?php foreach ($place as $row) { ?>
                                            <option value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Party Name</label>
                                        <select class="consignee_name rec form-control" name="consignee_id" id="consignee_id">
                                            <option value="">Select Party</option>
                                        </select>

                                        <div class="output-data-by" id="dispconsignee" style="display: none;">
                                            <label class="ad">Address&nbsp;&nbsp;:</label>&nbsp;&nbsp;&nbsp;<span id="consignee_address"></span><br/>
                                            <label class="ph">Phone No&nbsp;&nbsp;:</label>&nbsp;&nbsp;&nbsp;<span id="consignee_no"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group"><label class=" control-label">Party GST No.</label>
                                    <div class=""><input type="text" class="form-control custom_control consignee_gst_no"  name="party_gst_no" readonly="readonly"></div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Subject</label>
                                    <div class="col-sm-12">
                                        <textarea name="purchaseremark" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Contact Person</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="purchasecontactperson" id="purchasecontactperson" required="" tabindex="5">
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
                                                Action
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="other_product_td">

                                        <tr class="rent_stock_tr">
                                            <td colspan="3"><h4 class="text-center">Request Items</h4></td>
                                        </tr>
                                        <tr class="rent_stock_tr">
                                            <td colspan="3">
                                                <table class="table table-stripped table-bordered">
                                                    <tbody  class="rent_stock_row">
                                                    <tr>
                                                        <td>
                                                            <select class="form-control" name="rent_stock_item_id[]" class="RentitemName">
                                                                <option value="">Select Item</option>
                                                                <?php $query=$this->db->select('*')
                                                                    ->from('tbl_rent_item_master')
                                                                    ->get();
                                                                $itemarr = $query->result_array();
                                                                foreach ($itemarr as $row) { ?>
                                                                <option value=''><?=$row['item_name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>

                                                        <td><input type="text" name="rent_stock_item_desc[]" class="form-control rent_stock_item_desc" placeholder="Description" autocomplete="off"></td>
                                                        <td><input type="text" name="rent_stock_item_qty[]" class="form-control rent_stock_item_qty qty" placeholder="Qty" autocomplete="off"></td>
                                                        <td><input type="text" name="rent_stock_item_price[]" class="form-control rent_stock_item_price" placeholder="Unit Price" autocomplete="off"></td>
                                                        <td><input type="text" name="rent_stock_item_sum_price[]" class="form-control rent_stock_item_sum_price" placeholder="Sum Price" autocomplete="off" readonly></td>
                                                        <td>
                                                            <button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>
                                                            </button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"><label class="col-sm-2 control-label">Remarks</label>
                                    <div class="col-sm-10"><textarea rows="3" class="form-control" name="remarks"></textarea></div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group"><label class=" control-label">Total </label>
                                   <div class=""><input type="text" class="form-control custom_control invoice_total" name="invoice_total" readonly="readonly"></div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group"><label class=" control-label">Grand Total </label>
                                    <div class=""><input type="text" class="form-control custom_control invoice_grand_total" name="invoice_grand_total" readonly="readonly"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">
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
    $(document).on('keyup', '.txt_barcode', function(e) {
    $('.txt_barcode').keyup(function(){
        var bar_index = 0;
        var counter = 0;
        var barcode_id = $(this).data("id");
        var barcode_val = $(this).val();
        if($(this).val().length == 4){
            
            if(checkDuplicates() == true ){
                alert("Duplicate value found");
                $('#bar_code'+barcode_id).focus();
                return false;
            }else{
                 bar_index = barcode_id + 1;
                $('#bar_code'+bar_index).focus();
            }
        }
    })
});

function checkDuplicates() {
  
  var $elems = $('.txt_barcode');
  var values = [];
  var isDuplicated = false;
  $elems.each(function () {
    if(!this.value) return true;
    if(values.indexOf(this.value) !== -1) {
       isDuplicated = true;
       return isDuplicated; 
     }
    values.push(this.value);
  });   
return isDuplicated;     
}
</script>

<script>
    var modalitemid='';
    $(document).on("change",".qty",function(){
        modalitemid=$(this).closest("tr").find(".RentitemName").val();
        ref=$(this);
        var no_of_stock=parseInt($(this).val());
        var itemID=parseInt($('.RentitemName').val());
        var crstock = parseInt($(this).closest("tr").find(".RentitemName option:selected").attr("stock"));
        var ctr=1;
    });
</script>

<script>
    $('#source_id').change(function() {
        if($("#source_id").val()!="" && $("#consignor_id ").val()==""){
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.success('','Please Select Consignor.''Welcome to Ecopack Services.')
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
                toastr.success('', 'Please Select Party.')
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

    $(document).on("click",".add_new_rent_stock_item",function (){
        var myvar ='<tr>';
        myvar += '<td><select class="RentitemName form-control" name="rent_stock_item_id[]">';
        myvar +='<?php $itemarr=$this->db->select('*')->from('tbl_rent_item_master')->get()->result_array(); ?>'
        myvar +='<option value=" ">Select Item</option>'
        myvar +='<?php foreach ($itemarr as $row) { ?>'
        myvar +='<option value="<?=$row['master_item_id'] ?>"><?=$row['item_name'] ?></option>'
        myvar +='<?php } ?>'
        myvar +="</select>";
        myvar +='</td>'+
        '<td><input type="text" name="rent_stock_item_desc[]" class="form-control rent_stock_item_desc" placeholder="Description" autocomplete="off"></td>'  +
        '<td><input type="text" name="rent_stock_item_qty[]" class="form-control qty rent_stock_item_qty" placeholder="Qty"></td>  '  +
        '<td><input type="text" name="rent_stock_item_price[]" class="form-control rent_stock_item_price" placeholder="Unit Price" autocomplete="off"></td>'  +
        '<td><input type="text" name="rent_stock_item_sum_price[]" class="form-control rent_stock_item_sum_price" placeholder="Sum Price" autocomplete="off" readonly></td>'  +
        '<td><button class="btn btn-info btn-circle add_new_rent_stock_item" type="button" title="Add new"><i class="fa fa-plus"></i>  '  +
        '</button><button class="btn btn-danger btn-circle btn_delete_rent_stock_item" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  +
        '</button></td> </tr>';
        $(".rent_stock_row").append(myvar);
        $(".add_new_rent_stock_item").hide();
        $(".add_new_rent_stock_item:last").show();
        $(".btn_delete_rent_stock_item").show();
        $(".btn_delete_rent_stock_item:last").hide();
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
        var consignment_type=$('#consignment_type').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('consignee/getConsigneeByPlace')?>',
            cache: false,
            async: false,
            //data: {'place':place_id,'consignment_type':consignment_type},
            data: {'place':place_id,'consignment_type':consignment_type},
            success: function (data) {
                //swal("","Record Saved Successfully","success");
                var record=JSON.parse(data);
                var str="<option value=''>Select Party</option>";
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
       // var warehouse_id=$("#warehouse_id").val();
        if(consignee_id!="" && consignment_type!="" && warehouse_id!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getporentstockitem')?>',
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
            }, 1300);}
        // Notification for Source Place Ends.
    });

    $(document).ready(function () {

    });

    $("#btn_save_consignment").click(function () {
        var ref=$(this);
        //  RentitemName
        if(validate(ref))
        {
            $("#frm_consignment").submit();
        }
        else
        {

        }
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

    $(document).on("change",".rent_stock_item_qty",function(){
        var iemid=$(this).closest("tr").find(".RentitemName").val();
        alert(iemid);
        if(iemid=="")
        {
            swal("Please Select Item first");
        }
        else
        {
            var crstock=parseInt($(this).closest("tr").find(".RentitemName option:selected").attr("stock"));
            var qty=parseInt($(this).val());
            if(qty>crstock)
            {
                alert("Invalid value: current available(with barcode) is "+crstock);
                $(this).val("0");
            }
        }
    });

</script>
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js" type="text/javascript"></script>
</body>
</html>
