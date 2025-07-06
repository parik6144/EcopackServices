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
                    <h5>Employee Type Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('account') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_employee_type">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Employee Type Name</label>
                            <input type="hidden" name="employee_type_id" value="<?=$this->input->get('id');?>">
                            <div class="col-sm-10"><input type="text" class="form-control rec"  name="type_name" value="<?=$form_data['employee_type']['0']['type_name']?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_employee_type">Save</button>
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
    $("#btn_save_employee_type").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('employee_type/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_employee_type").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_employee_type")[0].reset();
                    $('#employee_typeModal').modal('hide');
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
