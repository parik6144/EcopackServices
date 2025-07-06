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
        <h2>inward_owner</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Inward Owner Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('inward_owner') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>
                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_inward_owner">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Inward Owner Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="owner_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <!-- <div class="form-group  row"><label class="col-sm-3 control-label">Mobile Number 1</label>
                            <div class="col-sm-9"><input type="number" class="form-control "  name="mobile_no1"></div>
                        </div>
                        <div class="hr-line-dashed"></div> -->

                        <!-- <div class="form-group  row"><label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9"><textarea class="form-control"  name="address"></textarea></div>
                        </div>
                        <div class="hr-line-dashed"></div> -->
                        <div class="form-group  row"><label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="city"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Pincode</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="pincode"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">GST No/ PAN No.</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="gstin"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Bank Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="bank_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Branch</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="branch"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Account Number</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="account_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">IFSC code</label>
                            <div class="col-sm-9"><input type="text" class="form-control "  name="ifsc_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_inward_owner">Save</button>
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
   
    
    $("#btn_save_inward_owner").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardowner/add')?>',
                cache: false,
                async: false,
                data: $("#frm_inward_owner").serialize(),
                success: function (data) {
                    swal("","Reord Saved Successfully","success");
                    $("#frm_inward_owner")[0].reset();
                    $('#inward_ownerModal').modal('hide');
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
