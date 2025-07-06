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
                    <span class="pull-right"><a href="<?php echo site_url('vehicle') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_rate">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignor Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignor_name" name="consignor_id">
                                    <option value="">Select Consignor</option>
                                    <?php
                                        foreach ($consignor as $row) {
                                            ?>
                                            <option value="<?=$row['consignor_id']?>"><?=$row['consignor_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignee Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignee_name" name="consignee_id">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            ?>
                                            <option value="<?=$row['consignee_id']?>"><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>                        
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vehicle Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec vehicle_type_id" name="vehicle_type_id">
                                    <option value="">Select Vehicle Type</option>
                                    <?php
                                        foreach ($vehicle_type as $row) {
                                            ?>
                                            <option value="<?=$row['vehicle_type_id']?>"><?=$row['vehicle_type']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Bill Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec bill_type" name="bill_type">
                                    <option value="">Select Bill Type</option>
                                    <option value="0">FTL</option>
                                    <option value="1">Part Load</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Advance</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control advance" name="advance"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Due</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control due" name="due"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Driver Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control driver_price" name="driver_price"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Employee Charge</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control employee_charge" name="employee_charge"> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Payment Mode</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" name="payment_mode">
                                    <option value="">Select Mode</option>
                                    <option value="0">Daily</option>
                                    <option value="1">Monthly</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
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
    
   
    $("#btn_save_vehicle").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('outwardrate/add')?>',
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
 
    $(".consignee_name, .vehicle_type_id, .bill_type").change(getprice);
    function getprice()
    {
        var consignee_id=$(".consignee_name").val();
        var vehicle_type_id=$(".vehicle_type_id").val();
        var bill_type=$(".bill_type").val();
        $(".advance").val("");
        $(".due").val("");
        $(".driver_price").val("");
        $(".employee_price").val("");
        if(consignee_id!="" && vehicle_type_id!=""&& bill_type!="")
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('outwardrate/getprice')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id,'vehicle_type_id':vehicle_type_id,"bill_type":bill_type},
                success: function (data) {
                    var record=JSON.parse(data);
                    if(record.vehicle_price.length>0)
                    {
                        $(".advance").val(record.vehicle_price['0'].advance);
                        $(".due").val(record.vehicle_price['0'].due);
                        $(".driver_price").val(record.vehicle_price['0'].driver_price);                        
                        $(".employee_charge").val(record.vehicle_price['0'].employee_charge);                        
                        $("#btn_save_vehicle").hide();
                    }
                    else
                    {
                        $("#btn_save_vehicle").show();
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

    }
   

</script>
</body>
</html>
