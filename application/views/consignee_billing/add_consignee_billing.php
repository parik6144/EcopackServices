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
                    <h5>consignee billing Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('consignee_billing') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_consignee_billing">
                        <div class="form-group  row"><label class="col-sm-3 control-label">consignee billing Name</label>
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="uom_id">
                            <div class="col-sm-9"><input type="text" class="form-control "  name="consignee_billing_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9"><textarea class="form-control "  name="address"></textarea></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="city"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="state"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">State Code</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="state_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Pincode</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="pincode"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Phone Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="phone_no"></div>
                        </div>
                        <div class="hr-line-dashed" ></div>
                        <div class="form-group  row" ><label class="col-sm-3 control-label">Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Mobile Number 1</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="mobile_no1"></div>
                        </div>
                        <div class="hr-line-dashed" style="display:none;"></div>
                        <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Party Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="party_mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group  row"><label class="col-sm-3 control-label">GSTIN</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="gstin"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                         <div class="form-group  row" style="display:none;"><label class="col-sm-3 control-label">Vendor Code</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="vendor_code"></div>
                        </div>
                        <div class="hr-line-dashed"style="display:none;"></div>
                        <button type="button" class="btn btn-success" id="btn_save_consignee_billing">Save</button>
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

    $("#btn_save_consignee_billing").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignee_billing/add')?>',
                cache: false,
                async: false,
                data: $("#frm_consignee_billing").serialize(),
                success: function (data) {
                    //swal("","ord Saved Successfully","success");
                    lastid=data;
                    $("#frm_consignee_billing")[0].reset();
                    $('#consignee_billingModal').modal('hide');
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
