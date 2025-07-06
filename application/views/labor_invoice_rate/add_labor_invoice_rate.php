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
                        <div class="form-group  row"><label class="col-sm-2 control-label">Billing Address</label>
                            <div class="col-sm-10">
                                <select class="form-control rec consignee_name" name="consignee_billing_id">
                                    <option value="">Select Billing Address</option>
                                    <?php
                                        foreach ($billing_address as $row) {
                                            ?>
                                            <option value="<?=$row['consignee_billing_id']?>"><?=$row['consignee_billing_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Charge</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="amount">
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
    
   $(".item_table").hide();
   $(".vehicle_table").hide();
    $("#btn_save_vehicle").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('labor_invoice_rate/add')?>',
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
 
    $(".consignee_name, .consignor_name").change(checkrecord);
    function checkrecord()
    {
        var consignor_id=$(".consignor_name").val();
        var consignee_id=$(".consignee_name").val();
        
        
        if(consignor_id!="" && consignee_id!="" )
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('labor_invoice_rate/isexist')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id,'consignor_id':consignor_id,'invoice_type':invoice_type,'data_type':data_type},
                success: function (data) {
                    var record=parseInt(data);
                    if(record>0)
                    {
                        alert("Record Already Exist");
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
