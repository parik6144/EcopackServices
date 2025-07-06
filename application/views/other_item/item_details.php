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
        <h2>Other Item</h2>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>other item Records</h5>
            <div class="ibox-tools">
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button>
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord1" type="button" style="display:none"><i class="fa fa-plus-circle"></i>
                </button>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo site_url('account/add')?>">Add Record</a>
                    </li>

                </ul>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="panel blank-panel">

                        <div class="panel-heading">
                            
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                                            <thead>
                                            <tr role="row">
                                                <th>Sl. No</th>
                                                <th>other_item Name</th>
                                                <th>Consignee Name</th>
                                                <th>Opening Stock</th>
                                                <th>#</th>

                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                            </div>

                        </div>

                    </div>

            

            <div class="modal inmodal" id="other_itemModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">other item Form</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="modal_content">
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
                url: '<?php echo site_url('other_item/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#other_itemModal").modal();

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
                url: '<?php echo site_url('other_item/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid,type:'transport'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#other_itemModal").modal();

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
                   url: '<?php echo site_url('other_item/deleterecord')?>',
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
            "processing": true,
            "serverSide": true,
            "order": [[ 2, "asc" ]],
            "ajax": "<?php echo site_url('other_item/getrecord')?>",
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
    
    $("#other_itemModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
     

    
</script>
