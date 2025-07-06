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
                    <h5>monthly booking list Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('monthly_booking_list') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" action="<?=base_url('monthly_booking_list/add')?>" id="frm_monthly_booking_list">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Receiver Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" id="receiver_type"  name="receiver_type" required>
                                    <option value="">Select Receiver Type</option>
                                    <option value="1">Ecopack Employee</option>
                                    <option value="2">Other Party</option>                                    
                                    <option value="3">Transporter</option>                                    
                                </select>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row staff_name select_user"><label class="col-sm-2 control-label">Employee Name</label>
                            <div class="col-sm-10">
                                    <?php
                                    foreach ($staff as $row){
                                        ?>
                                        <div class="checkbox">
                                          <label><input type="checkbox" class="chkbox" name="ref_id[]" value="<?=$row["staff_id"]?>"><?=$row['emp_no']." ".$row['staff_name']?></label>
                                        </div>

                                    <?php
                                    }
                                    ?>

                            </div>
                        </div>

                        <div class="form-group  row account_name select_user"><label class="col-sm-2 control-label">Party Name</label>
                            <div class="col-sm-10">
                               
                                    <?php
                                    foreach ($account as $row){
                                        ?>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="ref_id[]" class="chkbox" value="<?=$row["account_id"]?>"><?=$row['party_name']?></label>
                                        </div>
                                        
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>

                        <div class="form-group  row transporter_name select_user"><label class="col-sm-2 control-label">Transporter Name</label>
                            <div class="col-sm-10">
                                
                                    <?php
                                    foreach ($owner as $row){
                                        ?>
                                        <div class="checkbox">
                                          <label><input type="checkbox" name="ref_id[]" class="chkbox" value="<?=$row["owner_id"]?>"><?=$row['owner_name']?></label>
                                        </div>
                                        
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="submit" class="btn btn-success">Save</button>
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
        $(".select_user").hide();
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
        $(".chkbox").prop("checked",false);
    });

    $("#btn_save_monthly_booking_list").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('monthly_booking_list/add')?>',
                cache: false,
                async: false,
                data: $("#frm_monthly_booking_list").serialize(),
                success: function (data) {
                    //swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_monthly_booking_list")[0].reset();
                    $("#extra_address").remove();
                    $('#monthly_booking_listModal').modal('hide');
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
</script>
</body>
</html>
