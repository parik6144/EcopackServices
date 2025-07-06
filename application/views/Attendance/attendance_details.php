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
$Months = array(
    '1'=>'January',
    '2'=>'February',
    '3'=>'March',
    '4'=>'April',
    '5'=>'May',
    '6'=>'June',
    '7'=>'July',
    '8'=>'August',
    '9'=>'September',
    '10'=>'October',
    '11'=>'November',
    '12'=>'December');
?>

<style type="text/css">
    .img-thumb{
        width: 150px;
    }
    .td{ text-align: center;  }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Attendance</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php if($this->session->flashdata('update')) {?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button> <?=$this->session->flashdata('update')?>
                </div>
            <?php } if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button> <?=$this->session->flashdata('error')?>
                </div>
            <?php } ?>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Attendance Records</h5>
                    <div class="ibox-tools">
                        <!--                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>-->
                        <!--                </button>-->
                        <button type="button" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#empattendancemodal">
                            <i class="fa fa-plus-circle"></i>
                        </button>




                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Add Record</a>
                            </li>

                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                            <thead>
                            <tr role="row">
                                <th class="text-center">SL.No</th>
                                <th class="text-center">Employee</th>
                                <th class="text-center">Contact</th>
                                <th class="text-center">Month</th>
                                <th class="text-center">Year</th>
                                <th class="text-center">Days</th>
                                <th class="text-center">OT(in Hrs.)</th>
                                <th class="text-center">Holidays</th>
                                <th class="text-center">Leaves</th>
                                <th class="text-center">Loan Emi</th>
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Payslip</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal inmodal" id="empattendancemodal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated flipInY">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Attendance</h4>
                                </div>

                                <div class="modal-body">
                                    <form method="POST" action="<?=base_url('Attendance/add')?>" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Employee</label>
                                            <div class="col-sm-9">
                                                <select name="attend_employee" class="form-control" required="required">
                                                    <option value=''>select Employee</option>
                                                    <?php
                                                    $result = $this->db->select('`staff_id`,`staff_name`')->from('staff')->get();
                                                    foreach($result->result_array() as $res):
                                                        echo "<option value='$res[staff_id]'>$res[staff_name]</option>";
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">For Month </label>
                                            <div class="col-sm-9">
                                                <select name="attend_month" class="form-control" required="required">
                                                    <option value=''>select Month</option>
                                                    <?php
                                                    for($i=1; $i<=12; $i++){ ?>
                                                        <option value='<?=$i?>' <?php if(date('F')==$Months[$i]){ echo 'selected'; } ?>><?=$Months[$i]?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">For Year </label>
                                            <div class="col-sm-9">
                                                <select name="attend_year" class="form-control" required="required">
                                                    <option value=''>select Year</option>
                                                    <?php
                                                    for($i=2018; $i<=2030; $i++){ ?>
                                                        <option value='<?=$i?>' <?php if(date('Y')==$i){ echo 'selected'; } ?>><?=$i?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Attend Days</br>(in Nos.)</label>
                                            <div class="col-sm-9">
                                                <input name="attendance_days" type="number" class="form-control" required="required">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">OT (in Hrs.)</label>
                                            <div class="col-sm-9">
                                                <input name="attendance_ot" type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Holidays</br>(in Nos.)</label>
                                            <div class="col-sm-9">
                                                <input name="holidays_days" type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Leave </br>(in Nos.)</label>
                                            <div class="col-sm-9">
                                                <input name="leave_days" type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Loan Amount </br>(in INR)</label>
                                            <div class="col-sm-9">
                                                <input name="loan_amt" type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label">Remarks</label>
                                            <div class="col-sm-9">
                                                <textarea name="attnRemarks" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal inmodal" id="empattendancemodaledit" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated flipInY">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Attendance</h4>
                                </div>

                                <div class="modal-body" id="attendance_edit_content">

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        getrecord();
        $("#btn_addrecord").click(function () {
            // alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('Attendance/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    console.log(data);
                    $("#attendance_content").html(123);
                    $("#attendanceModal").modal();
                },
                error: function (data) { // alert("error");
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
        });
    });
</script>

<script>
    function getrecord() {
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo site_url('attendance/getrecord')?>",
            dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
            "tableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '12px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    }

    $("#attendanceModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
</script>

<script>
    $(document).on("click",".btn_editrecord",function () {
        var  refid=$(this).attr('refid');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('Attendance/editpopup')?>',
            cache: false,
            async: false,
            data: {popup:'popup',id:refid},
            success: function (data) {
                $("#attendance_edit_content").html(data);
                $("#empattendancemodaledit").modal();
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

    $(document).on("click",".btn_deleterecord",function (e) {
        e.preventDefault();
        var ref=$(this);
        var refid=$(this).attr('refid');
        swal({
                title: "Are you sure?",
                text: "You want to delete this post!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-success',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: false
                //closeOnCancel: false
            },
            function(){

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('Attendance/deleterecord')?>',
                    cache: false,
                    data: {delete: refid},
                    success: function (data) {
                        if(data=="true")
                        {
                            ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
                            swal("Deleted!", "Your record has been deleted!", "success");
                        }
                    },
                    error: function (data) {
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
            });
    });
</script>
