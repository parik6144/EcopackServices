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
                    <span class="pull-right"><a href="<?php echo site_url('account') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                    <?php }  ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_consignee">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Billing Name</label>
                            <div class="col-sm-9">
                                <select class="form-control rec" name="billing_id">
                                    <option value="">Select Billing Name</option>
                                    <?php
                                        foreach ($billing as $row) {
                                            $str="";
                                            if($form_data['consignee']['0']['billing_id']==$row['consignee_billing_id'])
                                                $str="selected='selected'";
                                            echo "<option ".$str." value='".$row['consignee_billing_id']."'>".$row['consignee_billing_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignee Name</label>
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="consignee_id">
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?php if(isset($form_data['consignee']['0']['consignee_name'])) echo $form_data['consignee']['0']['consignee_name'];?>" name="consignee_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Party Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?php if(isset($form_data['consignee']['0']['party_name'])) echo $form_data['consignee']['0']['party_name'];?>" name="party_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9"><textarea class="form-control " name="address"><?php if(isset($form_data['consignee']['0']['address'])) echo $form_data['consignee']['0']['address'];?></textarea></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?php if(isset($form_data['consignee']['0']['city'])) echo $form_data['consignee']['0']['city'];?>" name="city"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?php if(isset($form_data['consignee']['0']['state'])) echo $form_data['consignee']['0']['state'];?>" name="state"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">State Code</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  value="<?php if(isset($form_data['consignee']['0']['state_code'])) echo $form_data['consignee']['0']['state_code'];?>" name="state_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Pincode</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?php if(isset($form_data['consignee']['0']['pincode'])) echo $form_data['consignee']['0']['pincode'];?>" name="pincode"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Phone Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?php if(isset($form_data['consignee']['0']['phone_no'])) echo $form_data['consignee']['0']['phone_no'];?>" name="phone_no"></div>
                        </div>
                        <div class="hr-line-dashed" ></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?php if(isset($form_data['consignee']['0']['mobile_no'])) echo $form_data['consignee']['0']['mobile_no'];?>" name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Mobile Number 1</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?php if(isset($form_data['consignee']['0']['mobile_no1'])) echo $form_data['consignee']['0']['mobile_no1'];?>" name="mobile_no1"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Party Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?php if(isset($form_data['consignee']['0']['party_mobile_no'])) echo $form_data['consignee']['0']['party_mobile_no'];?>" name="party_mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed" ></div>
                        <div class="form-group  row" ><label class="col-sm-3 control-label">Place Name</label>
                        <div class="col-sm-9"><select class="form-control m-b" name="place_id">
                                <?php
                                foreach ($place as $row) {
                                    if(isset($form_data['consignee']['0']['place_id']) && $form_data['consignee']['0']['place_id']==$row['place_id'])
                                        echo "<option value='".$row['place_id']."' selected='selected'>".$row['place_name']."</option>";
                                    else
                                        echo "<option value='".$row['place_id']."'>".$row['place_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">GSTIN</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?php if(isset($form_data['consignee']['0']['gstin'])) echo $form_data['consignee']['0']['gstin'];?>" name="gstin"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_consignee">Save</button>
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
    $("#btn_save_consignee").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignee/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_consignee").serialize(),
                success: function (data) {
                    swal("","Record updated.","success");
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
    });
</script>
</body>
</html>
