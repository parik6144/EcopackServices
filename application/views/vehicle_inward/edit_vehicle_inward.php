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
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>vehicle_inward</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>vehicle_inward Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('vehicle_inward') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_vehicle_inward">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vehicle No.</label>
                            <input type="hidden" name="vehicle_inward_id" value="<?=encryptor("encrypt",$form_data['vehicle_inward']['0']['vehicle_inward_id']);?>">
                            <div class="col-sm-10"><input type="text" class="form-control rec" value="<?php if(isset($form_data['vehicle_inward']['0']['vehicle_inward_no'])) echo $form_data['vehicle_inward']['0']['vehicle_inward_no'];?>"  name="vehicle_inward_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Driver Name</label>
                            <div class="col-sm-10"><input type="text" class="form-control " value="<?php if(isset($form_data['vehicle_inward']['0']['driver_name'])) echo $form_data['vehicle_inward']['0']['driver_name'];?>"  name="driver_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Mobile Number</label>
                            <div class="col-sm-10"><input type="number" class="form-control " value="<?php if(isset($form_data['vehicle_inward']['0']['mobile_no'])) echo $form_data['vehicle_inward']['0']['mobile_no'];?>"  name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row" style="display:none;"><label class="col-sm-2 control-label">License Number</label>
                            <div class="col-sm-10"><input type="number" class="form-control " value="<?php if(isset($form_data['vehicle_inward']['0']['license_no'])) echo $form_data['vehicle_inward']['0']['license_no'];?>"  name="license_no"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Owner Name</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" name="owner_id">
                                    <option value="">Select Owner</option>
                                    <?php
                                        foreach ($owner as $row) {
                                            $str='';
                                            if(isset($form_data['vehicle_inward']['0']['owner_id']) && $form_data['vehicle_inward']['0']['owner_id']==$row['owner_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option value="<?=$row['owner_id']?>" <?=$str ?>><?=$row['owner_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vehicle Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" name="vehicle_type">
                                    <option value="">Select Vehicle Type</option>
                                    <?php
                                        foreach ($vehicle_type as $row) {
                                            $str='';
                                            if(isset($form_data['vehicle_inward']['0']['vehicle_type_id']) && $form_data['vehicle_inward']['0']['vehicle_type_id']==$row['vehicle_type_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option value="<?=$row['vehicle_type_id']?>" <?=$str ?>><?=$row['vehicle_type']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_vehicle_inward">Save</button>
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

    });
    $(document).on('click','.add',function(){
        $(this).val('Delete');
        $(this).attr('class','del btn btn-danger');
        var appendTxt = "<tr><td><input type='text' class='form-control' name='attribute[]' placeholder='Color' /></td> <td><input type='text' name='value[]' class='form-control' placeholder='Blue'/></td> <td><input type='button' class='add btn btn-info' value='Add More' /></td></tr>";
        $("tr:last").after(appendTxt);          
    });
    $("#btn_save_vehicle_inward").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('vehicle_inward/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_vehicle_inward").serialize(),
                success: function (data) {
                    swal("","Record updated successfully.","success");
                    $("#frm_vehicle_inward")[0].reset();
                    $('#vehicle_inwardModal').modal('hide');
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
