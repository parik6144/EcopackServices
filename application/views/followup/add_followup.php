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
<style>
    .table > tfoot > tr > td{
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
    }
    .table > thead > tr > th{
        text-align: center;
    }
    .custom_control{
        margin-bottom: 15px;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Consignmant</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>consignment  Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('consignment') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Day</td>
                                        <td>Date</td>
                                        <td>Location</td>
                                        <td>Remarks</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ctr=1;
                                        foreach ($form_data as $row) {
                                            ?>
                                            <form class="frm_update">
                                            <tr>
                                                <td><?=$ctr?></td>
                                                <td>
                                                    <input type="hidden" name="followup_id" value="<?=$row['followup_id']?>" class="followup_id">
                                                    <input type="date" class="form-control followup_date" name="followup_date" value="<?=$row['followup_date']?>"></td>
                                                <td><select class="form-control dlr_status" id="" name="dlr_status">
                                                        <option value="0">InTransit</option>
                                                        <option value="1">Delivered</option>
                                                    </select>
                                                    <input type="text" class="form-control location" name="location" placeholder="Location" value="<?=$row['vehicle_location']?>">
                                                </td>
                                                
                                                <td>
                                                    <textarea class="form-control remarks" name="remarks" placeholder="remarks" rows="2"><?=$row['remarks']?></textarea>
                                                </td>
                                                <td>
                                                    
                                                    <button type="button" class="btn btn-success btn_edit_save" id="btn_edit_save"><i class="fa fa-save"></i></button>
                                                </td>
                                            </tr>
                                            </form>
                                            <?php
                                            $ctr++;
                                        }
                                    ?>
                                    <tr>
                                    <form id="frm_followup" method="POST" action="<?=base_url('consignment/add')?>">
                                        <td><?=$ctr?></td>
                                        <td>
                                            <input type="hidden" name="consignment_id" value="<?=$this->input->get('id')?>" id="consignment_id">
                                            <input type="date" class="form-control" name="followup_date" value="<?=date('Y-m-d')?>" id="followup_date"></td>
                                        <td><select class="form-control" id="dlr_status" name="dlr_status">
                                                <option value="0">InTransit</option>
                                                <option value="1">Delivered</option>
                                            </select>
                                            <input type="text" class="form-control location" name="location" id="location" placeholder="Location">
                                        </td>
                                        
                                        <td>
                                            <textarea class="form-control" name="remarks" placeholder="remarks" id="remarks" rows="2"></textarea>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn_save" id="btn_save"><i class="fa fa-save"></i></button>
                                        </td>
                                    </form>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    
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
<script src="<?php echo base_url() ?>assets/js/plugins/chosen/chosen.jquery.js"></script>

<script type="text/javascript">
   $("#dlr_status").change(function(){
    if($(this).val()=="1")
        $(".location").hide();
    else
        $(".location").show();
   });
   $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('followup/editpopup')?>',
                cache: false,
                async: false,
                data: {'consignment_id':$("#consignment_id").val(),'followup_date':$("#followup_date").val(),'dlr_status':$("#dlr_status").val(),'location':$("#location").val(),'remarks':$("#remarks").val()},
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_followup")[0].reset();
                    $('#consignmentModal').modal('hide');
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
$(".btn_edit_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('followup/editpopup')?>',
                cache: false,
                async: false,
                data: {'consignment_id':$("#consignment_id").val(),'followup_id':$(ref).closest("tr").find(".followup_id").val(),'followup_date':$(ref).closest("tr").find(".followup_date").val(),'dlr_status':$(ref).closest("tr").find(".dlr_status").val(),'location':$(ref).closest("tr").find(".location").val(),'remarks':$(ref).closest("tr").find(".remarks").val()},
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $('#consignmentModal').modal('hide');
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
