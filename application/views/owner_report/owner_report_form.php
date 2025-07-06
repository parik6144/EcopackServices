<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */

$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Owner Report</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Owner Report Form</h5>
            
        </div>
        <div class="ibox-content">
            <div class="row">
                <form method="post" action="<?=base_url('owner_report/getreport')?>">
                    <div class="col-sm-10">
                    <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group" id="data_1">
                            <label class="font-noraml">From</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_from" class="form-control purchase_date rec" value="<?=date('01-m-Y')?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group" id="data_2">
                            <label class="font-noraml">TO</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="date_to" class="form-control purchase_date rec" value="<?=date('d-m-Y')?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group"><label>Owner Name</label>
                            <select class="owner_id form-control"  name="owner_id" required="required">
                                <option value="">select Owner</option>
                                <?php
                                    foreach ($consignee as $row) {
                                        echo "<option value='".$row['owner_id']."' >".$row['owner_name']."</option>";
                                    }
                                ?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group"><label>Vehicle Number</label>
                            <select class="vehicle_inward_id form-control"  name="vehicle_id" required="required">
                                <option value="">select Vehicle No</option>
                                
                                <option value="all">All</option>
                            </select>
                            
                        </div>
                    </div>
                    </div>
                    </div>

                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">Get Record</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>
<script>
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $('#data_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    
    $('.owner_id').select2();
    $(".owner_id").change(function(){
        var owner_id=$(this).val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('Vehicle_inward/getVehivleByOwnerId')?>',
                cache: false,
                async: false,
                data: {owner_id:owner_id},
                success: function (data) {
                    var data=JSON.parse(data);
                    //swal("","Record Saved Successfully","success");
                    var str="<option value=''>Select Vehicle</option>";
                    $.each(data,function(k,v){
                        str+="<option value='"+v['vehicle_inward_id']+"'>"+v['vehicle_inward_no']+"</option>";
                    });
                    str+="<option value='all'>All</option>";
                    $(".vehicle_inward_id").html(str);
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
    });
</script>
