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
                    <span class="pull-right"><a href="<?php echo site_url('inwardrate') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_rate">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignor Name</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="rate_id" value="<?=$this->input->get('id')?>">
                                <input type="hidden" name="consignor_id" value="<?=$edit_data->consignor_id?>">
                                <input type="hidden" name="consignee_id" value="<?=$edit_data->consignee_id?>">
                                <input type="hidden" name="vehicle_type_id" value="<?=$edit_data->vehicle_type_id?>">
                                <select class="form-control rec consignor_name" name="" disabled="disabled">
                                    <option value="">Select Consignor</option>
                                    <?php
                                        foreach ($consignor as $row) {
                                            $str="";
                                            if($edit_data->consignor_id==$row['consignor_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['consignor_id']?>"><?=$row['consignor_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignee_name" name="" disabled="disabled">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($edit_data->consignee_id==$row['consignee_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['consignee_id']?>"><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>                        
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vehicle Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec vehicle_type_id" name=""  disabled="disabled">
                                    <option value="">Select Vehicle Type</option>
                                    <?php
                                        foreach ($vehicle_type as $row) {
                                             $str="";
                                            if($edit_data->vehicle_type_id==$row['vehicle_type_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['vehicle_type_id']?>"><?=$row['vehicle_type']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Owner Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control owner_price" name="owner_price"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Driver Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control driver_price" name="driver_price"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="employee_list">
                        </div>
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
    $(document).ready(function(){
        getemployee();
    });
    $("#btn_save_vehicle").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardrate/edit')?>',
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
 $(".consignor_name").change(function(){
        getemployee();
     });
    function getemployee()
    {
        var consignor_id=$(".consignor_name").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardemployee/getEmployeeByConsignorId')?>',
                cache: false,
                async: false,
                data: {consignor_id:consignor_id},
                success: function (data) {

                    var rec=JSON.parse(data);
                    var str="";
                    
                    $.each(rec,function(k,v){
                        str+='   <div class="form-group  row"><label class="col-sm-2 control-label">Payment Type</label>  '  + 
 '                               <div class="col-sm-10">  '  +  
 '                                   <select class="form-control rate_type" name="rate_type[]">'+
                                    '<option value="0">Per Consigment/Per Trip</option>'+
                                    '<option value="1">Per Qty/Per Piece</option>'+
                                    '</select>   '  + 
 '                               </div>  '  + 
 '                           </div>  '  + 
 '                          <div class="hr-line-dashed"></div>  '+
                        '   <div class="form-group  row"><label class="col-sm-2 control-label">'+v["employee_name"]+'</label>  '  + 
 '                               <div class="col-sm-10">  '  + 
 '                                   <input type="text" class="form-control employee_rate" name="employee_rate[]">   '  + 
 '                                   <input type="hidden" class="form-control" name="employee_id[]" value="'+v["employee_id"]+'">   '  + 
 '                               </div>  '  + 
 '                           </div>  '  + 
 '                          <div class="hr-line-dashed"></div>  ' ; 
                    });
                    $(".employee_list").html(str);
                    getprice();
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
    $(".consignee_name, .vehicle_type_id").change(getprice);
    function getprice()
    {
        var consignor_id=$(".consignor_name").val();
        var consignee_id=$(".consignee_name").val();
        var vehicle_type_id=$(".vehicle_type_id").val();
        $(".driver_price").val("");
        $(".owner_price").val("");
        $(document).find(".rate_type").val("0");
        $(document).find(".employee_rate").val("");
        if(consignor_id!="" && consignee_id!="" && vehicle_type_id!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardrate/getprice')?>',
                cache: false,
                async: false,
                data: {'consignor_id':consignor_id,'consignee_id':consignee_id,'vehicle_type_id':vehicle_type_id},
                success: function (data) {
                    var record=JSON.parse(data);
                    console.log(record.vehicle_price['0'].driver_price);
                    $(".driver_price").val(record.vehicle_price['0'].driver_price);
                    $(".owner_price").val(record.vehicle_price['0'].owner_price);
                    var ctr=0;
                    $.each(record.employee_price,function(k,v){
                        $(document).find(".rate_type:eq("+ctr+")").val(v['rate_type']);
                        $(document).find(".employee_rate:eq("+ctr+")").val(v['amount']);
                        ctr++;
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
        }

    }
   

</script>
</body>
</html>
