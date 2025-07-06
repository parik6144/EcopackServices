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
<style type="text/css">
    .field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>staff</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Staff Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('staff') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_employee_salary">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Employee</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="staff_id">
                                    <option value="">select Employee</option>
                                    <?php
                                        foreach ($staff as $row) {
                                            echo '<option value="'.$row['staff_id'].'">'.$row['emp_no']." ".$row['staff_name'].'</option>';
                                        }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">BASIC</label>

                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="basic"></div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">DA</label>

                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="da"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group  row"><label class="col-sm-3 control-label">HRA</label>

                            <div class="col-sm-9"><input type="text" class="form-control"  name="hra"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                       <div class="form-group  row"><label class="col-sm-3 control-label">CEA</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="100" name="cea"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">TPA</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="1600"  name="tpa"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">OT per Hour</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="ot"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_employee_salary">Save</button>
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

    $("#btn_save_employee_salary").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('employee_salary/add')?>',
                cache: false,
                async: false,
                data: $("#frm_employee_salary").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_employee_salary")[0].reset();
                    $('#employee_salaryModal').modal('hide');
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
