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
                    <h5>staff Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('account') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>
                </div>
                <?php }?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_staff">
                        <div class="form-group  row"><label class="col-sm-3 control-label">staff ID</label>
                            <input type="hidden" name="staff_id" value="<?=$this->input->get('id');?>" />
                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="emp_no" value="<?= $form_data['staff']['0']['emp_no'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">staff Name</label>

                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="staff_name" value="<?= $form_data['staff']['0']['staff_name'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Mobile No</label>

                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="mobile_no" value="<?= $form_data['staff']['0']['mobile_no'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">staff Type</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="employee_type">
                                    <option value="">Department</option>
                                    <?php
                                        foreach ($employee_type as $row) {
                                            if($form_data['staff']['0']['employee_type_id']==$row['employee_type_id'])
                                                echo '<option value="'.$row['employee_type_id'].'" selected="selected">'.$row['type_name'].'</option>';
                                            else
                                                echo '<option value="'.$row['employee_type_id'].'">'.$row['type_name'].'</option>';
                                        }
                                    ?>
                                    
                                        <option value="add_new">Add New</option>
                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Email ID</label>

                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="email_id" value="<?= $form_data['staff']['0']['email_id'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Blood Group</label>
                            <div class="col-sm-9">
                                <select class="form-control rec" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" <?php if($form_data['staff']['0']['blood_group']=="A+") echo 'selected="selected"'?>>A+</option>
                                    <option value="A-" <?php if($form_data['staff']['0']['blood_group']=="A-") echo 'selected="selected"'?>>A-</option>
                                    <option value="B+" <?php if($form_data['staff']['0']['blood_group']=="B+") echo 'selected="selected"'?>>B+</option>
                                    <option value="B-" <?php if($form_data['staff']['0']['blood_group']=="B-") echo 'selected="selected"'?>>B-</option>
                                    <option value="O+" <?php if($form_data['staff']['0']['blood_group']=="O+") echo 'selected="selected"'?>>O+</option>
                                    <option value="O-" <?php if($form_data['staff']['0']['blood_group']=="O-") echo 'selected="selected"'?>>O-</option>
                                    <option value="AB+"  <?php if($form_data['staff']['0']['blood_group']=="AB+") echo 'selected="selected"'?>>AB+</option>
                                    <option value="AB-" <?php if($form_data['staff']['0']['blood_group']=="AB-") echo 'selected="selected"'?>>AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Photo</label>

                            <div class="col-sm-9">
                                <?php
                                if(empty($form_data['staff']['0']['photo']))
                                {
                                    ?>

                                    <img src="uploads/avatar.png" class="img-thumbnail img-thumb" alt="Cinque Terre">
                                <?php
                                }
                                else
                                {
                                   ?>

                                    <img src="uploads/<?=$form_data['staff']['0']['photo']?>" class="img-thumbnail img-thumb" alt="Cinque Terre">
                                <?php 
                                }
                                ?>
                                

                                <input type="file" class="form-control"  name="photo">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">PAN No.</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['staff']['0']['gstin']?>" name="gstin"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Bank Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['staff']['0']['bank_name']?>"  name="bank_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Branch</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['staff']['0']['branch']?>"  name="branch"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Account Number</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['staff']['0']['account_no']?>"  name="account_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">IFSC code</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['staff']['0']['ifsc_code']?>"  name="ifsc_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="submit" class="btn btn-success" id="btn_save_staff">Save</button>
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
    $("#frm_staff").submit(function (e) {
        var ref=$(this);
        e.preventDefault();

        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('staff/edit')?>',
                
                data: new FormData(this),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_staff")[0].reset();
                    $('#staffModal').modal('hide');
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 20000,
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
     $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>
</body>
</html>
