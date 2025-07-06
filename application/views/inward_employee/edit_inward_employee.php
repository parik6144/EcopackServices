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

//var_dump($form_data['employee']['0']['employee_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>inward_employee</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Inward employee Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('inward_employee') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_inward_employee">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Employee Name</label>
                        <input type="hidden" name="employee_id" value="<?=encryptor("encrypt",$form_data['employee']['0']['employee_id']);?>">
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['employee']['0']['employee_name']?>"  name="employee_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignor Name</label>
                            <div class="col-sm-9">
                                <select name="consignor_id" class="form-control">
                                    <option value="">Select Consignor</option>
                                    <?php
                                        foreach ($consignor as $row) {
                                            $str="";
                                            if($row['consignor_id']==$form_data['employee']['0']['consignor_id'])
                                                $str="selected='selected'";
                                            echo "<option value='".$row['consignor_id']."' ".$str.">".$row['consignor_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <button type="button" class="btn btn-success" id="btn_save_inward_employee">Save</button>
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
   
    $("#btn_save_inward_employee").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('inwardemployee/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_inward_employee").serialize(),
                success: function (data) {
                    swal("","Please check your internet connection.","success");
                    $("#frm_inward_employee")[0].reset();
                    $('#inward_employeeModal').modal('hide');
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
