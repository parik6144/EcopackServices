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
                    <form method="POST" class="form-horizontal" id="frm_working_day">
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="working_day_id">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Working Day Name</label>

                            <div class="col-sm-10"><input type="text" class="form-control rec" value="<?php if(isset($form_data['working_day']['0']['working_day_name'])) echo $form_data['working_day']['0']['working_day_name'];?>" name="working_day_name"></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                        <label class="col-sm-2">Working Day Date</label>
                                    <div class="input-group date col-sm-10 " id="data_1">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="working_day_date" class="form-control stock_date rec" value="<?=date("d-m-Y", strtotime($form_data['working_day']['0']['working_day_date']))?>">
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
$(document).ready(function () {

    });
    $('#data_1').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $(".stock_date").focus(function(){
        setTimeout(function(){
            $(document).find(".datepicker").css('z-index','1000000');
        },50);
    });
    $("#data_1").click(function(){
        setTimeout(function(){
            $(document).find(".datepicker").css('z-index','1000000');
        },50);
    });
    $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('working_day/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_working_day").serialize(),
                success: function (data) {
                    //alert("Record Saved Successfully");
                    $("#frm_working_day")[0].reset();
                    $('#working_dayModal').modal('hide');
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
