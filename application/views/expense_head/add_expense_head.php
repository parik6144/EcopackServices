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
                    <h5>Expense Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('expense_head') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_expense_head">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Expense Head Name</label>

                            <div class="col-sm-10"><input type="text" class="form-control rec"  name="expense_head_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_expense_head">Save</button>
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

    $("#btn_save_expense_head").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('expense_head/add')?>',
                cache: false,
                async: false,
                data: $("#frm_expense_head").serialize(),
                success: function (data) {
                    //swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_expense_head")[0].reset();
                    $('#expense_headModal').modal('hide');
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
