<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
if(!isset($condition)) {
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Account Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('payment_booking') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php }
                    //echo print_r($form_data['payment_booking']['0']);
                ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_payment_booking">
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="booking_id">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-10"><input type="text" class="form-control rec" value="<?php if(isset($form_data['payment_booking']['0']['amount'])) echo $form_data['payment_booking']['0']['amount'];?>" name="amount"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Expense Head</label>
                            <div class="col-sm-10">
                                <select class="form-control expense_head rec"  name="expense_head">
                                    <option value="">Select Expense Type</option>
                                    <?php

                                    foreach ($expense_head as $row){
                                        $str="";
                                        if(isset($form_data['payment_booking']['0']['expense_head_id']) && $form_data['payment_booking']['0']['expense_head_id']==$row['expense_head_id'])
                                            $str="selected='selected'";
                                        ?>
                                        <option value="<?=$row['expense_head_id']?>" <?=$str?>><?=$row['expense_head_name']?></option>
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
                                    <option value="1" <?php if($form_data['payment_booking']['0']['receiver_type']=="1") echo "selected='selected'"; ?>>Ecopack Employee</option>
                                    <option value="4" <?php if($form_data['payment_booking']['0']['receiver_type']=="4") echo "selected='selected'"; ?>>Other Employee</option>
                                    <option value="2" <?php if($form_data['payment_booking']['0']['receiver_type']=="2") echo "selected='selected'"; ?>>Other Party</option>                                    
                                    <option value="3" <?php if($form_data['payment_booking']['0']['receiver_type']=="3") echo "selected='selected'"; ?>>Transporter</option>                                    
                                </select>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row staff_name select_user"><label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control"  name="staff_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    if($form_data['payment_booking']['0']['receiver_type']=="1")
                                    {
                                        foreach ($staff as $row){
                                            $str="";
                                            if($row['staff_id']==$form_data['payment_booking']['0']['ref_id'])
                                            {
                                                $str="selected='selected'";
                                            }
                                        ?>
                                            <option value="<?=$row['staff_id']?>" <?=$str?>><?=$row['emp_no']." ".$row['staff_name']?></option>
                                        <?php
                                        }
                                    }
                                    else
                                    {
                                        foreach ($staff as $row){
                                        ?>
                                            <option value="<?=$row['staff_id']?>"><?=$row['emp_no']." ".$row['staff_name']?></option>
                                        <?php
                                        }
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
                                    if($form_data['payment_booking']['0']['receiver_type']=="2")
                                    {
                                        foreach ($account as $row){
                                            $str="";
                                            if($row['account_id']==$form_data['payment_booking']['0']['ref_id'])
                                            {
                                                $str="selected='selected'";
                                            }
                                            ?>
                                            <option value="<?=$row['account_id']?>" <?=$str?>><?=$row['party_name']?></option>
                                        <?php
                                        }
                                    }
                                    else{
                                        foreach ($account as $row){
                                        ?>
                                            <option value="<?=$row['account_id']?>"><?=$row['party_name']?></option>
                                        <?php
                                        }
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
                                    if($form_data['payment_booking']['0']['receiver_type']=="3")
                                    {
                                        foreach ($owner as $row){
                                            $str="";
                                            if($row['owner_id']==$form_data['payment_booking']['0']['ref_id'])
                                            {
                                                $str="selected='selected'";
                                            }
                                            ?>
                                            <option value="<?=$row['owner_id']?>" <?=$str?>><?=$row['owner_name']?></option>
                                        <?php
                                        }
                                    }
                                    else{
                                        foreach ($owner as $row){
                                            ?>
                                            <option value="<?=$row['owner_id']?>"><?=$row['owner_name']?></option>
                                        <?php
                                        }
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
                                    if($form_data['payment_booking']['0']['receiver_type']=="4")
                                    {
                                        $str="";
                                        if($row['employee_id']==$form_data['payment_booking']['0']['ref_id'])
                                        {
                                            $str="selected='selected'";
                                        }
                                        foreach ($employee as $row){
                                            ?>
                                            <option value="<?=$row['employee_id']?>" <?=$str?>><?=$row['employee_name']?></option>
                                        <?php
                                        }
                                    }
                                    else
                                    {
                                        foreach ($employee as $row){
                                            ?>
                                            <option value="<?=$row['employee_id']?>"><?=$row['employee_name']?></option>
                                        <?php
                                        }
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
                                    <?php
                                    if(isset($purchase_item))
                                    foreach ($purchase_item as $purchase_row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <select class="form-control item_name"  name="item_id[]">
                                                    <option value="">Select Item</option>
                                                    <?php
                                                    foreach ($item as $row){
                                                        $str="";
                                                        if($row['master_item_id']==$purchase_row['item_id'])
                                                            $str="selected='selected'";
                                                        ?>
                                                        <option value="<?=$row['master_item_id']?>" price="<?=$row['price']?>" <?=$str?>><?=$row['item_code']."-".$row['item_name']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control qty" name="qty[]" value="<?=$purchase_row['qty']?>"></td>
                                            <td><span class="price" >0.00</span></td>
                                            <td><input type="number" class="form-control tax" name="tax[]" value="<?=$purchase_row['tax']?>" ></td>
                                            <td><span class="total">0.00</span></td>
                                            <td><button class="btn btn-info btn-circle add_new_default" type="button" title="Add new" style="display: none;"><i class="fa fa-plus" ></i>
                                            </button><button class="btn btn-danger btn-circle btn_delete_default" type="button" title="Delete"  ><i class="fa fa-trash"></i>
                                            </button></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
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
                        <div class="form-group  row"><label class="col-sm-2 control-label">Branch</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="branch_id">
                                    <option value="">Select Branch</option>
                                <?php
                                foreach ($branch as $row) {
                                    $str='';
                                    if($row['branch_id']==$form_data['payment_booking']['0']['branch_id'])
                                        $str='selected="selected"';
                                    echo "<option value='".$row['branch_id']."' ".$str.">".$row['branch_name']."</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-10">
                                <textarea class="form-control rec"  name="remarks" rows="3">
                                    <?php if(isset($form_data['payment_booking']['0']['remarks'])) echo trim($form_data['payment_booking']['0']['remarks']," ");?>
                                </textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <button type="button" id="btn_save" class="btn btn-success">Save</button>
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
$(document).ready(function () {
        $(".select_user, .item_table").hide();
        if($(".expense_head").val()=="16")
        {
            $(".item_table").show();
        }
        else
        {
            $(".item_table").hide();
        }
        $(".item_name").each(function(){
            $(this).trigger("change");
        }); 
        $(".tax").each(function(){
            if($(this).closest("tr").find(".item_name").val()!="")
                calculate($(this));
        }); 
        var reftype=$("#receiver_type").val();
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
    $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('payment_booking/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_payment_booking").serialize(),
                success: function (data) {
                    $("#frm_payment_booking")[0].reset();
                    $('#payment_bookingModal').modal('hide');
                    swal("","Record Updated Successfully","success");
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
