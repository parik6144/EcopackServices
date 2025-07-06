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
            <h2> Employee</h2>
        </div>
        <div class="col-lg-2"></div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Employee Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('_employee') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>
                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm__employee">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Employee Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" name="employee_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save__employee">Save</button>
                    </form>
                </div>

                <?php
                if(!isset($condition)) {
                ?>
            </div>
        </div>
    </div>
</div>

<script>alert('its ok')</script>
<?php $this->load->view('footer'); } ?>

<script type="text/javascript">
    $("#attendance_staff").submit(function (e) {
        var ref=$(this);
        e.preventDefault();

        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('Attendance/add')?>',
                data: new FormData(this),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_attendance")[0].reset();
                    $('#attendanceModal').modal('hide');
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
