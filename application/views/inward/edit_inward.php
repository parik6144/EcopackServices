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
<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Inward</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Inward  Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('inward') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form id="testform" method="POST">
                        <input type="hidden" name="inward_id" value="<?=$this->input->get('id')?>">
                        <div class="row">
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignor Name</label>
                                            <select class="consignor_name form-control"  name="consignor_name">
                                                <option value="">select consignor</option>
                                                <?php
                                                    foreach ($consignor as $row) {
                                                        $str="";
                                                        if($row['consignor_id']==$edit_data['row']->source_id)
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
                                            <label>Phone no: </label><span id="consignor_no"><?=$mobile_no?></span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row rent_item_div">
                                    <div class="col-sm-12">
                                        <div class="form-group  row warehouse_id">
                                            <label>WareHouse</label>

                                                <select class=" form-control"  name="warehouse_id">
                                                    <option value="">Select warehouse</option>
                                                    <?php
                                                    foreach ($warehouse as $row) {
                                                        $str="";
                                                        if($edit_data['row']->inward_warehouse_id==$row['warehouse_id'])
                                                        {
                                                            $str="selected='selected'";
                                                        }
                                                        ?>
                                                        <option value="<?=$row['warehouse_id']?>" <?=$str?>><?=$row['warehouse_name']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 b-r">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Consignee Name</label>
                                            <select class="consignee_name form-control"  name="consignee_name">
                                                <option value="">select consignee</option>
                                                <?php
                                                    foreach ($consignee as $row) {
                                                        $str="";
                                                        if($row['consignee_id']==$edit_data['row']->destiantion_id)
                                                        {
                                                            $str="selected='selected'";
                                                            $address=$row['address']." , ".$row['city'].", ".$row['state'].", ".$row['pincode'];
                                                            $mobile_no=$row['mobile_no'];

                                                        }
                                                        echo "<option ".$str." value='".$row['consignee_id']."'  address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['mobile_no']."' pincode='".$row['pincode']."'>".$row['consignee_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label>Address: </label><span id="consignee_address"><?=$address?></span><br/>
                                            <label>Phone no: </label><span id="consignee_no"><?=$mobile_no?></span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row rent_item_div">
                                    <div class="col-sm-12">
                                        <div class="form-group  row"><label>Party Name</label>
                                            <select class="rent_consignee_name form-control"  name="rent_consignee_id">
                                                <option value="">select consignee</option>
                                                <?php
                                                    foreach ($consignee as $row) {
                                                        $str="";
                                                        if($row['consignee_id']==$edit_data['row']->rent_consignee_id)
                                                        {
                                                            $str="selected='selected'";
                                                           

                                                        }
                                                        echo "<option ".$str." value='".$row['consignee_id']."'  address='".$row['address']."' city='".$row['city']."' state='".$row['state']."' phone='".$row['phone_no']."' pincode='".$row['pincode']."'>".$row['consignee_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                            
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group  row"><label>Inward Type</label>
                                    <select class="rec form-control inward_type"  name="inward_type">
                                        <option value="0" <?php if($edit_data['row']->inward_type=="0") echo "selected='selected'"; ?>>Transport</option>
                                        <option value="1" <?php if($edit_data['row']->inward_type=="1") echo "selected='selected'"; ?>>Rent</option>
                                    </select>
                                </div> 
                                <div class="form-group  row" id="data_1">
                                    <label class="font-noraml">Inward Date</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="inward_date" class="form-control purchase_date" value="<?=date("d-m-Y", strtotime($edit_data['row']->inward_date))?>">
                                    </div>
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
                                <tbody id="product_td">
                                    <?php
                                    foreach ($edit_data['record'] as $editrow) {
                                        # code...
                                    ?>
                                    <tr>                                        
                                        <td><select class="itemName form-control" name="itemName[]">
                                            <option value="">Select Item</option>
                                            <?php
                                            foreach ($item as $row) {
                                                $str="";
                                                if($row['item_id']==$editrow['item_id'])
                                                    $str="selected='selected'";
                                                echo "<option value='".$row['item_id']."' ".$str.">".$row['item_name']."</option>";
                                            }
                                            ?>
                                        </select></td>
                                        <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" value="<?=$editrow['qty']?>"></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>                                        
                                        <td><select class="itemName form-control" name="itemName[]">
                                            <option value="">Select Item</option>
                                            <?php
                                            foreach ($item as $row) {
                                                $str="";
                                                echo "<option value='".$row['item_id']."' ".$str.">".$row['item_name']."</option>";
                                            }
                                            ?>
                                        </select></td>
                                        <td><input type="text" name="qty[]" class="form-control qty" placeholder="Qty" value=""></td>
                                        <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>
                                        </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>
                                        </button></td>  
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Vehicle No</label>
                                <div class="col-sm-9"><select class="form-control custom_control vehicle_no" id="vehicle_no" name="vehicle_id" style="width:100%;">
                                    <option value="">Select Vehicle</option>
                                <?php
                                    foreach ($vehicle as $row) {
                                        $str="";
                                        if($row['vehicle_inward_id']==$edit_data['row']->vehicle_id)
                                            $str="selected='selected'";
                                        echo "<option ".$str." value='".$row['vehicle_inward_id']."'>".$row['vehicle_inward_no']."</option>";
                                    }
                                ?>                                    
                                </select> </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group  row"><label class="col-sm-12 control-label">Loaded By</label>
                                <div class="col-sm-12" id="loaded_by">
                                    
                                    <?php
                                        foreach ($employee as $row) {
                                            $str="";
                                            $loaded_name="";
                                            $loaded_type_name="";
                                            $ctr=0;
                                            if (in_array($row['employee_id'], $edit_data['loaded_by']))
                                            {
                                              $str="checked='checked'";
                                              $loaded_name="name='loaded_by_rate[]'";
                                              $loaded_type_name="name='loaded_by_rate_type[]'";
                                            }
                                            
                                            echo '<div class="checkbox i-checks"><label> <input '.$str.' type="checkbox" value="'.$row["employee_id"].'" name="loaded_by[]" refid="'.$ctr.'" > <i></i>'.$row["employee_name"].' </label></div>';
                                            echo '<input type="hidden" '.$loaded_name.' class="loaded_by_rate" value="0">';
                                            echo '<input type="hidden" '.$loaded_type_name.' class="loaded_by_rate_type" value="0">';
                                            $ctr++;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row table_div">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Gatepass No.</label>
                                <div class="col-sm-9"><input type="text" class="form-control custom_control gatepass_no" value="<?=$edit_data['row']->gatepass_no?>" name="gatepass_no">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="col-sm-12">
                                <div class="form-group  row"><label class="col-sm-3 control-label">Ecopack Employee</label>
                                <div class="col-sm-9">
                                    <select class="form-control loaded_staff" name="loaded_staff_id[]" multiple="multiple"  style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($staff as $row) {
                                        $str='';
                                        if (in_array($row['staff_id'], $edit_data['loaded_by_employee']))
                                        {
                                            $str="selected='selected'";
                                        }
                                        echo "<option value='".$row['staff_id']."' ".$str.">".$row['staff_name']."</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Driver's name</label>
                                <div class="col-sm-9"><input type="text" readonly="readonly" class="form-control rec custom_control driver_name"  name="owner_name">
                                    <input type="hidden" name="driver_id" id="driver_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Driver Mobile No.</label>
                                <div class="col-sm-9"><input type="text" readonly="readonly" class="form-control rec custom_control driver_mobile_no"  name="driver_mobile_no"></div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group  row"><label class="col-sm-3 control-label">Owner Name</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly="readonly" class="form-control  custom_control rec owner_name"  name="owner_name">
                                    <input type="hidden" name="owner_id" id="owner_id" value="">
                                    <input type="hidden" name="driver_rate" id="driver_rate">
                                    <input type="hidden" name="owner_rate" id="owner_rate">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-info">Update</button>
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
<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.vehicle_no').select2();
        $("#vehicle_no").change();
        $('.loaded_staff').select2();
        $(".add_new").hide();
        $(".add_new:last").show();
        $(".btn_delete").show();
        $(".btn_delete:last").hide();
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.vehicle_no').select2();
        $('.consignee_name').select2();
        $('.consignor_name').select2();
        $('.rent_consignee_name').select2();
        if($(".inward_type").val()=="0")
            $(".rent_item_div").hide();

    });
    $('input').on('ifChanged', function(event){
      console.log(event.currentTarget.checked);
      var refid=$(this).attr('refid');
      if(event.currentTarget.checked){
        $(document).find(".loaded_by_rate:eq("+refid+")").attr("name","loaded_by_rate[]");
        $(document).find(".loaded_by_rate_type:eq("+refid+")").attr("name","loaded_by_rate_type[]");
        }
        else
        {
            $(document).find(".loaded_by_rate:eq("+refid+")").attr("name","");
            $(document).find(".loaded_by_rate_type:eq("+refid+")").attr("name","");
        }
        
    });
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
                        str+="<option value='"+v['consignee_id']+"' address='"+v['address']+"' city='"+v['city']+"' state='"+v['state']+"' phone='"+v['mobile_no']+"' pincode='"+v['pincode']+"'>"+v['consignee_name']+"</option>";
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
                        str+="<option value='"+v['consignor_id']+"' address='"+v['address']+"' city='"+v['city']+"' state='"+v['state']+"' phone='"+v['mobile_no']+"' pincode='"+v['pincode']+"'>"+v['consignor_name']+"</option>";
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
         $.ajax({
                type: 'POST',
                url: '<?php echo site_url('vehicle_inward/getvehicledetails')?>',
                cache: false,
                async: false,
                data: {vehicle_id:vehicle_id,consignor_id:$(".consignor_name").val(),consignee_id:$(".consignee_name").val()},
                success: function (data) {
                    var rec=JSON.parse(data);
                    $(".driver_name").val(rec.vehicle['0'].driver_name);
                    $(".driver_mobile_no").val(rec.vehicle['0'].mobile_no);
                    $(".owner_name").val(rec.vehicle['0'].owner_name);
                    $(".owner_address").val(rec.vehicle['0'].address);
                    $("#driver_id").val(rec.vehicle['0'].driver_id);
                    $("#owner_id").val(rec.vehicle['0'].owner_id);
                    var ctr=0;
                    console.log(rec.amount.vehicle_price);

                    $.each(rec.amount.employee_price,function(k,v){
                        $(".loaded_by_rate:eq("+ctr+")").val(v['amount']);
                        $(".loaded_by_rate_type:eq("+ctr+")").val(v['rate_type']);
                        ctr++;
                    });
                    if(rec.amount.vehicle_price.length>0)
                    {
                        $("#driver_rate").val(rec.amount.vehicle_price['0'].driver_price);
                        $("#owner_rate").val(rec.amount.vehicle_price['0'].owner_price);
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
    });

     $(".consignor_name").change(function(){
        if($(this).val()!="")
        {
            $("#consignor_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
            $("#consignor_no").html($(this).find("option:selected").attr("phone"));
        }
        else
        {
             $("#consignor_address").html("");
             $("#consignor_no").html("");
        }
        var consignor_id=$(this).val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardemployee/getEmployeeByConsignorId')?>',
                cache: false,
                async: false,
                data: {consignor_id:consignor_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="";
                    var ctr=0;
                    $.each(rec,function(k,v){
                        str+='<div class="checkbox i-checks"><label> <input type="checkbox" value="'+v["employee_id"]+'" name="loaded_by[]" refid="'+ctr+'" class="chkbox"> <i></i>'+v["employee_name"]+' </label></div>';
                        str+="<input type='hidden' class='loaded_by_rate' value='0'>";
                        str+="<input type='hidden' class='loaded_by_rate_type' value='0'>";
                        ctr++;
                    });
                    $("#loaded_by").html(str);
                    $("#loaded_by").show();
                    $('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });

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
     $(".inward_type").change(function(){
        $(".consignee_name").change();

    })
     $(".consignee_name, .rent_consignee_name").change(function(){
        
        
        //showhidetable();
        if($(".inward_type").val()=="0"){
            $(".rent_item_div").hide();
            var consignee_id=$(".consignee_name").val();
            var url='<?php echo site_url('item/getItemByConsigneeId')?>';
            $("#product_td tr:not(:last-child)").empty();
             if($(this).val()!="")
            {
                $("#consignee_address").html($(this).find("option:selected").attr("address")+"<br/>"+$(this).find("option:selected").attr("city")+", "+$(this).find("option:selected").attr("state")+", "+$(this).find("option:selected").attr("pincode"));
                $("#consignee_no").html($(this).find("option:selected").attr("phone"));
            }
            else
            {
                ("#consignee_address").html("");
                $("#consignee_no").html("");
            }
        }
            
        else{
            $(".rent_item_div").show();
            var consignee_id=$(".rent_consignee_name").val();
            var url='<?php echo site_url('item/getrentstockitem')?>';
        }
        if(consignee_id!="")
        {
            $.ajax({
                type: 'POST',
                url: url,
                cache: false,
                async: false,
                data: {consignee_id:consignee_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"'>"+v['item_name']+"</option>";
                    });
                    $(".itemName").html(str);
                    $("#loaded_by").show();

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
        
        var myvar =   '<tr>'; 
        myvar +=   '<td><select class="itemName form-control" name="itemName[]">'; 
        myvar +=   $(".itemName:first").html()+"</select>"; 
        myvar +=   '</td>'+
 '                                           <td><input type="text" name="qty[]" class="form-control total_price" placeholder="Qty"></td>  '  + 
 '                                           <td><button class="btn btn-info btn-circle add_new" type="button" title="Add new"><i class="fa fa-plus"></i>  '  + 
 '                                           </button><button class="btn btn-danger btn-circle btn_delete" type="button" title="Delete"  style="display: none;"><i class="fa fa-trash"></i>  '  + 
 '                                          </button></td> </tr> ' ; 


        $("#product_td").append(myvar);
        $(".add_new").hide();
        $(".add_new:last").show();
        $(".btn_delete").show();
        $(".btn_delete:last").hide();
        $(document).find(".itemName:last").focus();
        
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
