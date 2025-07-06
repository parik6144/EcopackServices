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
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Pending DUE of Consignment</h2>

    </div>
    <div class="col-lg-2">
        <h2>Rs <?=$total?><h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Pending Consignment Records</h5>
            
        </div>
        <div class="ibox-content">

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th>&nbsp;</th>
                    <th>Consignment No.</th>
                    <th>Date</th>
                    <th>Vehicle No</th>
                    <th>Owner Name</th>
                    <th>Mobile No</th>
                    <th>Bank Name</th>
                    <th>Branch</th>
                    <th>Account No.</th>
                    <th>IFSC</th>
                    <th>due</th>
                    <th>Payment Mode</th>
                    <th>#</th>
                </tr>
                </thead>
            </table>
            </div>
            <div class="modal inmodal" id="consignmentModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">Followup Form</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="consignement_modal_content">
                        </div>

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
        $(document).on("click",".btn_deleterecord",function (e) {
            e.preventDefault();
            var ref=$(this);
            var refid=$(this).attr('refid');
            var payment_mode=$(this).closest("tr").find('.payment_mode').val();
            if(payment_mode=="")
            {
                alert("please select payment mode");
            }
            else
            {
                swal({
                    title: "Are you sure?",
                    text: "You want to finsish this payment!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-success',
                    cancelButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes, Complete LR!',
                    closeOnConfirm: false
                    //closeOnCancel: false
                },
                function(){

                    $.ajax({
                        type: 'POST',
                       url: '<?php echo site_url('pending_due/changestatus')?>',
                        cache: false,
                        data: {"refid": refid,"payment_mode":payment_mode},
                        success: function (data) {
                            if(data=="true")
                            {
                                ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
                                swal("Completed!", "Your LR has been Completed!", "success");
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
        
            }
            });
                

    });
    function getrecord() {
        $('#example').DataTable( {
            
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "DESC" ]],
            "ajax": "<?php echo site_url('pending_due/getrecord')?>"
        });
    }
    $("#consignmentModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
</script>
