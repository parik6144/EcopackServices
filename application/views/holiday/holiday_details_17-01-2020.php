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
        <h2>holiday</h2>
    </div>
    <div class="col-lg-2"></div>
</div>
<style> td{  text-align:center; }</style>

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>holiday Records</h5>
            <div class="ibox-tools">
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo site_url('holiday/add')?>">Add Record</a>
                    </li>

                </ul>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th class="text-center">&nbsp;Sl No.</th>
                    <th class="text-center">holiday Name</th>
                    <th class="text-center">holiday Date</th>
                    <th class="text-center">#</th>
                </tr>
                </thead>
            </table>

            <div class="modal inmodal" id="holidayModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">holiday Form</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="holiday_modal_content">
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

        $("#btn_addrecord").click(function () {
            //alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('holiday/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#holiday_modal_content").html(data);
                    $("#holidayModal").modal();

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
        });

        $(document).on("click",".btn_editrecord",function () {

            var  refid=$(this).attr('refid');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('holiday/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid},
                success: function (data) {
                    $("#holiday_modal_content").html(data);
                    $("#holidayModal").modal();

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
                   url: '<?php echo site_url('holiday/deleterecord')?>',
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

    });
    function getrecord() {
        $('#example').DataTable( {
            responsive: true,
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "asc" ]],
            "ajax": "<?php echo site_url('holiday/getrecord')?>",
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'}
            ],
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        });
    }
    $("#holidayModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
</script>
