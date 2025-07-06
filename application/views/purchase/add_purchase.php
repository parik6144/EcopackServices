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
<link href="<?php echo base_url() ?>assets/css/plugins/chosen/chosen.css" rel="stylesheet">
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
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Purchase</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Purchase Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('purchase') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form id="testform" method="POST">
                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <div class="form-group  row"><label>Account Name</label> <select class="accountName form-control"  name="accountName"></select></div> 
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 23px;padding: 0px;">
                                        <button class="btn btn-danger btn-circle" type="button" title="Add new customer"><i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                                
                                    
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group  row" id="data_1">
                                    <label class="font-noraml">Purchase Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control purchase_date" value="<?=date("d-m-Y");?>">
                                    </div>
                                </div>
                                 <div class="form-group  row"><label>Purchase No</label> <input type="text" class="form-control purchase_no" id="purchase_no"></div> 

                                <div class="form-group  row"><label>Mobile No : </label><span id="mobile_no"></div>

                                <div class="form-group  row"><label>Address : </label><span id="address"></div>
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
                                            price
                                        </th>                                        
                                        <th>
                                            Tax
                                        </th>
                                        <th>
                                            Discount (%)
                                        </th>
                                        <th>
                                            Total Price
                                        </th>
                                        <th>
                                            #
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="product_td">
                                    <tr>
                                        <td><select class="itemName form-control" style="width:300px" name="itemName"></select></td>
                                        <td><input type="text" name="" class="form-control qty" placeholder="Qty"></td>
                                        <td><input type="text" name="" class="form-control purchase_price" placeholder="purchase Price"></td>
                                        
                                        <td>
                                            <div class="input-group">
                                                <select data-placeholder="Select Tax" class="form-control tax">
                                                    <option value="0">Select tax</option>
                                                     <?php
                                                        foreach ($tax as $row)
                                                                echo "<option value='" . $row['tax_percent'] . "' tax='".$row['tax_percent']."'>" . $row['tax_name'] . "</option>";
                                                    ?>
                                                </select>
                                            </div>                                      
                                        </td>
                                        <td><input type="text" name="" class="form-control discount" placeholder="Discount"></td>
                                        <td><input type="text" name="" class="form-control total_price" placeholder="Total Price"></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right; padding-right: 6px;"><label>Other Chargers</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control other_amount" placeholder="Other amount" value="0"></td>
                                    </tr> 
                                    <tr>
                                        <td colspan="5" style="text-align: right; padding-right: 6px;"><label>Total amount</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control final_total_amount" placeholder="Total amount"></td>
                                    </tr>                                                                       
                                    <tr>
                                        <td colspan="5" style="text-align: right; padding-right: 6px;"><label>Bill Discount</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control bill_discount" placeholder="Bill Discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; padding-right: 6px;"><label>Tax amount</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control tax_amount" disabled="disabled" placeholder="tax Discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;  padding-right: 6px;"><label>Round Off</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control round_off" placeholder="Round Off"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;  padding-right: 6px;"><label>Grand Total</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control grand_total" placeholder="Grand Total"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"><label>Narration</label><textarea rows="3" class="form-control narretion" placeholder="Narration" ></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" style="text-align: right;  padding-right: 6px;"><button type="button" class="btn btn-info btn_save">Save</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger">Reset</button></td>
                                    </tr>
                                </tfoot>
                            </table>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        $('.accountName').select2({
            placeholder: '--- Select Party Name ---',
            ajax: {
              url: '<?php echo base_url() ?>account/getname',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                return {
                  results: data
                };
              },
              cache: true
            }
          });
        $('.itemName').select2({
        placeholder: '--- Select Item ---',
        ajax: {
          url: '<?php echo base_url() ?>item/getname',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
    });
    $(".accountName").change(function(){
        var accountid=$(this).val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('account/getaccountbyid')?>',
                cache: false,
                async: false,
                data: {id:accountid},
                success: function (data) {
                    //alert("Record Saved Successfully");
                    var record=JSON.parse(data);
                    alert(record['account']['0']['mobile']);
                    $("#mobile_no").html(record['account']['0']['mobile']);
                    //console.log(record['address'].length);
                    $.each(record.address,function(k,v){
                        //alert(v['address_id']);
                        $("#address").html(v['address_line1']+v['address_line2']+", "+v['city_name']+", "+v['state_name']+", "+v['country_name']);

                    })
                    
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
    $(document).on("click",".add_new",function () {
        
        var myvar =  '   <tr>  '  + 
                     '      <td><select class="itemName form-control"  name="itemName"></select></td>  '  + 
                     '      <td><input type="text" name="" class="form-control qty" placeholder="Qty"></td>  '  + 
                     '      <td><input type="text" name="" class="form-control purchase_price" placeholder="purchase Price"></td>  '  + 
                      '<td>   <div class="form-group  row">  '  + 
 '                                                     '  + 
 '                                                   <div class="input-group">  '  + 
 '                                                       <select data-placeholder="Select Tax" class="form-control tax" ><option value="0">Select Tax</option>  '  + 
 '                                                             '; 
                                                            <?php 
                                                                foreach ($tax as $row){
                                                                    ?>
                                                                     myvar+='<option value=" <?= $row["tax_percent"] ?>" tax=" <?= $row["tax_percent"]?>">  <?=$row["tax_name"]?></option>';   
                                                                <?php
                                                                } 
                                                                       
                                                            ?> 
 myvar+='                                                       </select>  '  + 
 '                                                   </div>  '  + 
 '                                              </div></td>          '  + 
                     '      <td><input type="text" name="" class="form-control discount" placeholder="Discount"></td>  '  + 
                     '      <td><input type="text" name="" class="form-control total_price" placeholder="Total Price"></td>  '  +
                     '      <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>    </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"><i class="fa fa-trash"></i></button></td>    '  + 
                     '  </tr>  ' ;


        $("#product_td").append(myvar);
        $(".add_new").hide();
        $(".add_new:last").show();
        $(".btn_delete").show();
        $(".btn_delete:last").hide();
        $('.itemName').select2({
        placeholder: '--- Select Item ---',
        ajax: {
          url: '<?php echo base_url() ?>item/getname',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

    });

    $(document).on("click",".btn_delete",function () {
        $(this).parent().parent().remove();
    });
    $("#btn_save").click(function () {
       var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('account/add')?>',
                cache: false,
                async: false,
                data: $("#frm_account").serialize(),
                success: function (data) {
                    //alert("Record Saved Successfully");
                    
                    $("#frm_account")[0].reset();
                    $("#extra_address").remove();
                    $('#myModal').modal('hide');
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
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $(document).on("change",".itemName",function(){
        var itemid=$(this).val();
        var ref=$(this);
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getitembyid')?>',
                cache: false,
                async: false,
                data: {itemid:itemid},
                success: function (data) {
                    var record=JSON.parse(data);
                    console.log(record.item['0']['purchase_price']);
                    ref.parent().parent().find(".purchase_price").val(record.item['0']['purchase_price']);

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

    $(document).on("change",".tax",function(){
         //var ref=$(this);
        calculatefinal();
    });
    $(document).on("keyup",".qty",function(e){
        var ref=$(this);
       calculatetotal(ref); 
    });
    $(document).on("keyup",".purchase_price",function(e){
        var ref=$(this);
       calculatetotal(ref); 
    });
    $(document).on("keyup",".discount",function(e){
        var ref=$(this);
       calculatetotal(ref); 
    });
    $(document).on("keyup",".other_amount",function(e){
         calculatefinal();
    });
    $(document).on("keyup",".bill_discount",function(e){
         calculatefinal();
    });

    function calculatefinal()
    {
        var total=0;
        var taxamount=0;
        $(".total_price").each(function(){
            if(!isNaN(parseFloat($(this).val())))
            {
                total+=parseFloat($(this).val());
                var x=parseFloat($(this).val());;
                var tax=parseFloat($(this).closest("tr").find(".tax").val());
                if(tax>0)
                {

                    taxamt=((x*tax)/100);
                    taxamount+=taxamt;
                }
            }
        });
        if(!isNaN(parseFloat($(".other_amount").val())))
        {
            total+=parseFloat($(".other_amount").val());
        }
        $(".final_total_amount").val(total);
        total+=taxamount;
        if(!isNaN(parseFloat($(".bill_discount").val())))
        {
            total-=parseFloat($(".bill_discount").val());
        }
        $(".tax_amount").val(taxamount);

        var grandtotal=Math.round(total);
        $(".round_off").val(grandtotal-total);
        $(".grand_total").val(grandtotal);
    }


    function calculatetotal(ref)
    {
        var qty=parseFloat(ref.closest('tr').find(".qty").val()).toFixed(2);
        var price=parseFloat(ref.closest('tr').find(".purchase_price").val()).toFixed(2);
        var tax=0;
        /*ref.closest('tr').find(".tax option:selected").each(function(){
            tax+=parseFloat($(this).attr("tax"));
        });*/
        var discount=parseFloat(ref.closest('tr').find(".discount").val()).toFixed(2);
        var taxableamt=0;
        if(!isNaN(qty*price))
        {
            taxableamt=qty*price;
            if(!isNaN(discount))
            {
                var totaldiscount=(taxableamt*discount)/100;
                taxableamt=taxableamt-totaldiscount;
            }
            
            var totaltax=(taxableamt*tax)/100;
            var totalamount=taxableamt+totaltax;
            ref.closest('tr').find(".total_price").val(totalamount);
            calculatefinal();
        }
        else
        {
            ref.closest('tr').find(".total_price").val('0');
            calculatefinal();
        }
    }
    $(".btn_save").click(function(){
        var products   =   {"productData":[],"purchasedate":[]};
        //products           =   {"invoicedata":[]};
        $('#product_td tr').each(function(index)
        {
            if($(this).find('.itemName').val()!="")
            {
                products.productData.push({
                    "item_id": $(this).find('.itemName').val(), 
                    "qty":$(this).find('.qty').val(), 
                    "purchase_price":$(this).find('.purchase_price').val(), 
                    "tax":$(this).find('.tax').val(), 
                    "discount":$(this).find('.discount').val(), 
                    "total_price":$(this).find('.total_price').val()
                });
            }
          
        });
        products.purchasedate.push({
            "account_id": $(".accountName").val(),
            "purchase_date": $(".purchase_date").val(),
            "other_amount": $(".other_amount").val(),
            "final_total_amount": $(".final_total_amount").val(),
            "bill_discount": $(".bill_discount").val(),
            "grand_total": $(".grand_total").val(),
            "narretion": $(".narretion").val(),
            "purchase_no": $(".purchase_no").val(),
            "round_off": $(".round_off").val()
        });
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('purchase/savepurchase')?>',
                cache: false,
                async: false,
                data: {data:products},
                success: function (data) {
                    // var record=JSON.parse(data);
                    // console.log(record.item['0']['purchase_price']);
                    // ref.parent().parent().find(".purchase_price").val(record.item['0']['purchase_price']);
                    window.location="<?php echo base_url() ?>purchase";

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
        

</script>
</body>
</html>
