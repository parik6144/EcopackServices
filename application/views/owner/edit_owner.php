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

//var_dump($form_data['owner']['0']['owner_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Owner</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Owner Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('owner') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_owner">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Owner Name</label>
                        <input type="hidden" name="owner_id" value="<?=encryptor("encrypt",$form_data['owner']['0']['owner_id']);?>">
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['owner_name']?>"  name="owner_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Mobile Number</label>
                            <div class="col-sm-9"><input type="number" class="form-control rec" value="<?=$form_data['owner']['0']['mobile_no']?>"  name="mobile_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['city']?>"  name="city"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">pincode</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['pincode']?>"  name="pincode"></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">GST No/ PAN No.</label>
                            <div class="col-sm-9"><input type="text" class="form-control " value="<?=$form_data['owner']['0']['gstin']?>" name="gstin"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Bank Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['bank_name']?>"  name="bank_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-3 control-label">Branch</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['branch']?>"  name="branch"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Account Number</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['account_no']?>"  name="account_no"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">IFSC code</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec" value="<?=$form_data['owner']['0']['ifsc_code']?>"  name="ifsc_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_owner">Save</button>
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
   
    $("#btn_save_owner").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('owner/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_owner").serialize(),
                success: function (data) {
                    swal("","Record Updated Successfully","success");
                    $("#frm_owner")[0].reset();
                    $('#ownerModal').modal('hide');
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
    $(".uom").change(function(){        
        if($(this).val()=="add_new")
        {
           $.ajax({
                type: 'POST',
                url: '<?php echo site_url('uom/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#uom_modal_content").html(data);
                    $("#uomModal").modal();

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
     $("#uomModal").on("hidden.bs.modal", function () {
       $('#loader').hide();
       if(lastid!="")
       {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('owner/getlastuom')?>',
                cache: false,
                async: false,
                data: {id:lastid},
                success: function (data) {
                    var record=JSON.parse(data);
                    $(".uom").append("<option value='"+record.uom[0]['uom_id']+"'>"+record.uom[0]['short_name']+"</option>");
                    $(".uom").val(record.uom[0]['uom_id']);
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
       lastid="";
        
    });
</script>
</body>
</html>
