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
        <h2>Expense Booking</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Payment Booking Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('payment_booking') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_payment_booking">

                        <div class="form-group  row"><label class="col-sm-2 control-label">Booking Date</label>
                            <div class="col-sm-10"><input type="date" class="form-control rec"  name="booking_date"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-10"><input type="number" class="form-control rec"  name="amount"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Expense Head</label>
                            <div class="col-sm-10">
                                <select class="form-control rec expense_head"  name="expense_head">
                                    <option value="">Select Expense Type</option>
                                    <?php
                                    foreach ($expense_head as $row){
                                        ?>
                                        <option value="<?=$row['expense_head_id']?>"><?=$row['expense_head_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Receiver Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" id="receiver_type"  name="receiver_type">
                                    <option value="">Select Receiver Type</option>
                                    <option value="1">Ecopack Employee</option>
                                    <option value="4">Other Employee</option>
                                    <option value="2">Other Party</option>                                    
                                    <option value="3">Transporter</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row staff_name select_user"><label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control"  name="staff_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach ($staff as $row){
                                        ?>
                                        <option value="<?=$row['staff_id']?>"><?=$row['emp_no']." ".$row['staff_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="form-group  row account_name select_user"><label class="col-sm-2 control-label">Party Name</label>
                            <div class="col-sm-10">
                                <select class="form-control"  name="account_id">
                                    <option value="">Select Party Name</option>
                                    <?php
                                    foreach ($account as $row){
                                        ?>
                                        <option value="<?=$row['account_id']?>"><?=$row['party_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group  row transporter_name select_user"><label class="col-sm-2 control-label">Transporter Name</label>
                            <div class="col-sm-10">
                                <select class="form-control"  name="owner_id">
                                    <option value="">Select Transporter</option>
                                    <?php
                                    foreach ($owner as $row){
                                        ?>
                                        <option value="<?=$row['owner_id']?>"><?=$row['owner_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  row employee_name select_user"><label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control"  name="employee_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    foreach ($employee as $row){
                                        ?>
                                        <option value="<?=$row['employee_id']?>"><?=$row['employee_name']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="table-responsive">
                            <table class="table table stripped item_table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Tax%</th>
                                        <th>Total</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="item_table_tbody">
                                    <tr>
                                        <td>
                                            <select class="form-control item_name"  name="item_id[]">
                                                <option value="">Select Item</option>
                                                <?php
                                                foreach ($item as $row){
                                                    ?>
                                                    <option value="<?=$row['master_item_id']?>" price="<?=$row['price']?>"><?=$row['item_code']."-".$row['item_name']?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control qty" name="qty[]"></td>
                                        <td><span class="price">0.00</span></td>
                                        <td><input type="number" class="form-control tax" name="tax[]"></td>
                                        <td><span class="total">0.00</span></td>
                                        <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>
                                    </tr>
                                </tbody>        
                            </table>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-10">
                                <textarea class="form-control rec"  name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_payment_booking">Save</button>
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
    $(document).ready(function () {
        $(".select_user, .item_table").hide();
    });

    $("#btn_save_payment_booking").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('payment_booking/add')?>',
                cache: false,
                async: false,
                data: $("#frm_payment_booking").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_payment_booking")[0].reset();
                    $("#extra_address").remove();
                    $('#payment_bookingModal').modal('hide');
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
    $("#receiver_type").change(function(){
        var reftype=$(this).val();
        $(".select_user").hide();
        if(reftype=="1")
        {
            $(".staff_name").show();
        }
        else if(reftype=="2")
        {
            $(".account_name").show();
        }
        else if(reftype=="3")
        {
            $(".transporter_name").show();
        }
        else if(reftype=="4")
        {
            $(".employee_name").show();
        }
    });

    $(document).on("click",".add_new_default",function () {
        var select=$(".item_name:first").html();
        
        var myvar =   '<tr>'; 
        myvar +=   '<td><select class="form-control item_name" name="item_id[]">'+select; 
        myvar +=    '                                           </td>  '  + 
 '                                           <td><input type="number" class="form-control qty" name="qty[]"></td>  '  + 
 '                                           <td><span class="price">0.00</span></td>  '  + 
 '                                           <td><input type="number" class="form-control tax" name="tax[]"></td>  '  + 
 '                                           <td><span class="total">0.00</span></td>  '  + 
 '                                           <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new"><i class="fa fa-plus"></i>  '  + 
 '                                           </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  + 
 '                                           </button></td>  '  + 
 '                                      </tr>  ' ; 


        $("#item_table_tbody").append(myvar);
        $(".add_new_default").hide();
        $(".add_new_default:last").show();
        $(".btn_delete_default").show();
        $(".btn_delete_default:last").hide();
        
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
$(document).on("change",".item_name",function(){
    var price=$(this).find("option:selected").attr("price");
    $(this).closest("tr").find(".price").html(price);
});
$(document).on("change",".tax",function(){
    var ref=$(this);
    calculate(ref);
});
$(document).on("change",".qty",function(){
    var ref=$(this);
    calculate(ref); 
});
function calculate(ref)
{  
    if($(ref).closest("tr").find(".item_name").val()!="")
    {
        var tax=parseFloat($(ref).closest("tr").find(".tax").val());
        var qty=parseFloat($(ref).closest("tr").find(".qty").val());
        var price=parseFloat($(ref).closest("tr").find(".price").html());
        var total=(price*qty)+(((price*qty)*tax)/100);
        if(!isNaN(total))
            $(ref).closest("tr").find(".total").html(total);
        else
            $(ref).closest("tr").find(".total").html("0.00");
    }
    else{
        swal("please select an Item First");
    }

}
$(".expense_head").change(function(){
    if($(this).val()=="16")
    {
        $(".item_table").show();
    }
    else
    {
        $(".item_table").hide();
    }
});
</script>
</body>
</html>
