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
        <h2>Designations</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Designations Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('designations') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_designations">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Department</label>
                            <input type="hidden" name="designation_id" value="<?=$this->input->get('id');?>">
                            <div class="col-sm-10">
                                <select class="form-control rec" name="employee_type_id" required>
                                    <option value="">Select Department</option>
                                    <?php
                                        foreach ($employee_type as $row) {
                                            if($form_data['designations']['0']['employee_type_id']==$row['employee_type_id'])
                                                echo '<option value="'.$row['employee_type_id'].'" selected="selected">'.$row['type_name'].'</option>';
                                            else
                                                echo '<option value="'.$row['employee_type_id'].'">'.$row['type_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Designation Name</label>
                            <div class="col-sm-10"><input type="text" class="form-control rec"  name="designation_name" value="<?=$form_data['designations']['0']['designation_name']?>" required></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_designations">Update</button>
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

    $("#btn_save_designations").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('designations/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_designations").serialize(),
                success: function (data) {
                    swal("","Record Updated Successfully","success");
                    lastid=data;
                    $("#frm_designations")[0].reset();
                    $('#designationsModal').modal('hide');
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