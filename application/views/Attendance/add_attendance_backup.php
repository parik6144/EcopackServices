<script>
  //  alert("676755");
</script>
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
 if(!isset($condition)) { ?>
<script>
    alert("23123");
</script>
<?php
     $this->load->view('header');
     $this->load->view('left_sidebar');
     $this->load->view('topbar');
//  var_dump($form_data['account']['0']['account_name']);
//  exit;
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
        <h2>Employee</h2>
    </div>
    <div class="col-lg-2"></div>
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
                <script>
                    alert("98766");
                </script>

                <div class="ibox-content">
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal" id="frm_staff">

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Employee ID</label>
                            <div class="col-sm-3"><input type="readonly" class="form-control readonly rec" value="ESPL" disabled="disabled"></div>
                            <div class="col-sm-3"><input type="text" class="form-control rec" id="state_code" placeholder='state code'></div>
                            <div class="col-sm-3"><input type="readonly" class="form-control readonly rec" id="state_code" disabled="disabled" value="<?=$last_id?>"></div>
                            <input type="hidden" class="form-control emp_no"  name="emp_no" >
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-3 control-label">Full Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control rec"  name="staff_name">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Mobile No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control rec"  name="mobile_no">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="employee_type">
                                    <option value="">select Department</option>
                                    <?php
//                                        foreach ($employee_type as $row) {
//                                            echo '<option value="'.$row['employee_type_id'].'">'.$row['type_name'].'</option>';
//                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Email ID</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="email_id"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Blood Group</label>
                            <div class="col-sm-9">
                                <select class="form-control rec" name="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Photo</label>

                            <div class="col-sm-9"><input type="file" class="form-control"  name="photo"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                       <div class="form-group  row"><label class="col-sm-3 control-label">PAN No.</label>
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
                        <div class="form-group  row"><label class="col-sm-3 control-label">Location</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="location">
                                    <option value=''>Select Location</option>
                                    <?php
//                                    $query=$this->db->select('*')
//                                        ->from('cities')
//                                        ->get();
//                                    $records =$query->result_array();
//                                    foreach ($records as $row){
//                                      echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
//                                    }
                                    ?>
                                </select>
                            </div>
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
                        <button type="submit" class="btn btn-success" id="btn_save_staff">Save</button>
                    </form>
                </div>
                <?php if(!isset($condition)){ ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); } ?>

<script type="text/javascript">
    var lastid="";
    $(document).ready(function () {
        $("#state_code").change(function(){
            var state_code=$(this).val();
            $(".emp_no").val("ESPL"+state_code+"-<?=$last_id?>");
        })
    });
    $("#frm_staff").submit(function (e) {
        var ref=$(this);
        e.preventDefault();

        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('staff/add')?>',
                
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
