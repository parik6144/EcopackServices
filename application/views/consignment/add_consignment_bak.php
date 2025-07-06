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
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Consignmant</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>consignment  Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('consignment') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form id="testform" method="POST">
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group  row" id="data_1">
                                    <label class="font-noraml">consignment Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control purchase_date" value="<?=date("d-m-Y");?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" style="margin-top:  29px;">                                
                                <label>Consignment No</label>: <span>001</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignor Name</label>
                                            <select class="consignor_name form-control"  name="consignor_name">
                                            </select>
                                            <label>Address: </label><span id="consignor_address"></span><br/>
                                            <label>Phone no:</label><span id="consignor_no"></span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignee Name</label>
                                            <select class="consignee_name form-control"  name="consignee_name">
                                            </select>
                                            <label>Address</label><span id="consignee_address"></span><br/>
                                            <label>Phone no:</label><span id="consignee_no"></span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group  row">
                                    <label>Source Place</label>
                                       <select class="consignor_place form-control"  name="consignor_place" >
                                        <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {
                                                ?>
                                                <option value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group  row">
                                    <label>Destination Place</label>

                                        <select class="consignee_place form-control"  name="consignee_place">
                                            <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {
                                                ?>
                                                <option value="<?=$row['place_id']?>"><?=$row['place_name']?></option>
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
                                        <th>No. Of Package</th>
                                        <th>
                                            Item Name
                                        </th>
                                        <th>
                                            Weight
                                        </th>
                                        <th>
                                            Fright Rate
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
                                        <td></td>
                                        <td><select class="itemName form-control" name="itemName">
                                            <option value="">Select Item</option>
                                            <?php
                                            foreach ($item as $row) {
                                                echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>";
                                            }
                                            ?>
                                        </select></td>
                                        <td><input type="text" name="" class="form-control qty" placeholder="Weight"></td>
                                        <td><input type="text" name="" class="form-control purchase_price" placeholder="Fright Price"></td>
                                        <td><input type="text" name="" class="form-control total_price" placeholder="Total Price"></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding-right: 6px;"><label>St. Charges</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control other_amount" placeholder="Other amount" value="0"></td>
                                    </tr> 
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding-right: 6px;"><label>Loading Charges</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control final_total_amount" placeholder="Total amount"></td>
                                    </tr>                                                                       
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding-right: 6px;"><label>Total</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control bill_discount" placeholder="Bill Discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right; padding-right: 6px;"><label>Less Advance</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control tax_amount" placeholder="tax Discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;  padding-right: 6px;"><label>Balance Rs</label></td>
                                        <td colspan="2"><input type="text" name="" class="form-control round_off" placeholder="Round Off"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="6"><label>Narration</label><textarea rows="3" class="form-control narretion" placeholder="Narration" ></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align: right;  padding-right: 6px;"><button type="button" class="btn btn-info btn_save">Save</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger">Reset</button></td>
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
<script src="<?php echo base_url() ?>assets/js/plugins/chosen/chosen.jquery.js"></script>


<script type="text/javascript">
    var lastid="";
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
                        str+="<option value='"+v['consignee_id']+"' address='"+v['address']+"' city='"+v['city']+"' state='"+v['state']+"' phone='"+v['phone_no']+"' pincode='"+v['pincode']+"'>"+v['consignee_name']+"</option>";
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
        $("#consignor_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
        $("#consignor_no").html($(this).find("option:selected").attr("phone"));
     });
     $(".consignee_name").change(function(){
        $("#consignee_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
        $("#consignee_no").html($(this).find("option:selected").attr("phone"));
     });
    $(document).ready(function () {

    });

    $("#btn_save_consignee").click(function () {
        var ref=$(this);
        if(validate(ref))
        {

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignee/add')?>',
                cache: false,
                async: false,
                data: $("#frm_consignee").serialize(),
                success: function (data) {
                    //swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_consignee")[0].reset();
                    $('#consigneeModal').modal('hide');
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
    $(document).on("click",".add_new",function () {
        
        var myvar =   '<tr>   <td></td>  '  + 
 '                                           <td><select class="itemName form-control" name="itemName">'; 
                                                <?php  
                                                foreach ($item as $row) {
                                                    ?>
                                                    myvar+="<option value=''>Select Item</option>";
                                                    myvar+="<option value='<?=$row['item_id']?>'><?=$row['item_name']?></option>";
                                                <?php  
                                                    } 
                                               ?>  
 myvar+='                                           </select></td>  '  + 
 '                                           <td><input type="text" name="" class="form-control qty" placeholder="Weight"></td>  '  + 
 '                                           <td><input type="text" name="" class="form-control purchase_price" placeholder="Fright Price"></td>  '  + 
 '                                           <td><input type="text" name="" class="form-control total_price" placeholder="Total Price"></td>  '  + 
 '                                           <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>  '  + 
 '                                           </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  + 
 '                                          </button></td> </tr> ' ; 


        $("#product_td").append(myvar);
        $(".add_new").hide();
        $(".add_new:last").show();
        $(".btn_delete").show();
        $(".btn_delete:last").hide();
        
    });

    $(document).on("click",".btn_delete",function () {
        var ref=$(this);
        /*swal({
          title: "Are you sure?",
          text: "You want to delete this record!",
          type: "danger",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(){
          $(ref).parent().parent().remove();
        });*/
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
</script>
</body>
</html>
