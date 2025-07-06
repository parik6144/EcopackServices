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

//var_dump($form_data['contact']['0']['party_name']);
//exit;
?>
<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>contact</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Contact Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('contactDetails') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>
                </div>
                <?php }  ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_contact">
                        <input type="hidden" value="<?=$_GET['id']?>" name="contact_id"> 
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignee Name</label>
                            <div class="col-sm-9">
                                <input type='hidden' name="contact_type" id="contact_type">
                                <select class="form-control consignee_name rec" name="consignee_id" value="<?=$form_data['contact']['0']['contact_type']?>">
                                    <option value="Select Consignee">
                                <?php
                                foreach ($consignee as $row) {
                                    $str="";
                                    if($form_data['contact']['0']['consignee_id']==$row['consignee_id'] && $form_data['contact']['0']['contact_type']=="0")
                                        $str="selected='selected'";
                                    
                                    ?>
                                    <option value="<?=$row['consignee_id']?>" type="0" <?=$str?>><?=$row['consignee_name']?></option>
                                    <?php
                                }
                                ?>
                                <?php
                                foreach ($consignor as $row) {
                                    $str="";
                                    if($form_data['contact']['0']['consignee_id']==$row['consignor_id'] && $form_data['contact']['0']['contact_type']=="1")
                                        $str="selected='selected'";
                                    ?>
                                    <option value="<?=$row['consignor_id']?>" type="1" <?=$str?>><?=$row['consignor_name']?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Purpose</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['contact']['0']['reason']?>" name="reason"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                         <div class="form-group  row"><label class="col-sm-3 control-label">Person Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['contact']['0']['person_name']?>" name="person_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control " value="<?=$form_data['contact']['0']['mobile_no']?>"  name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Email ID</label>
                            <div class="col-sm-9"><input type="text" class="form-control  rec" value="<?=$form_data['contact']['0']['email_id']?>" name="email_id"></div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        
                        <button type="button" class="btn btn-success" id="btn_save_contact">Save</button>
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

<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
<script type="text/javascript">
    var lastid="";
   $(document).ready(function(){
    $('.consignee_name').select2();
   });
   $(".consignee_name").change(function(){
    var type=$(this).find("option:selected").attr("type");
    $("#contact_type").val(type);
   });   
    
    $("#btn_save_contact").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('contactDetails/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_contact").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_contact")[0].reset();
                    $('#contactModal').modal('hide');
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
