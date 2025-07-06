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
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_warehouse">
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="warehouse_id">
                        <div class="form-group  row"><label class="col-sm-2 control-label">warehouse Code</label>

                            <div class="col-sm-10"><input type="text" class="form-control rec" value="<?php if(isset($form_data['warehouse']['0']['warehouse_name'])) echo $form_data['warehouse']['0']['warehouse_name'];?>" name="warehouse_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-10"><textarea class="form-control " name="warehouse_address" ><?php if(isset($form_data['warehouse']['0']['warehouse_name'])) echo $form_data['warehouse']['0']['warehouse_address'];?></textarea></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">GST No</label>

                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php if(isset($form_data['warehouse']['0']['warehouse_gst_no'])) echo $form_data['warehouse']['0']['warehouse_gst_no'];?>"  name="warehouse_gst_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" id="btn_save" class="btn btn-success">Save</button>
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
    $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('warehouse/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_warehouse").serialize(),
                success: function (data) {
                    //alert("Record Saved Successfully");
                    $("#frm_warehouse")[0].reset();
                    $('#warehouseModal').modal('hide');
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
