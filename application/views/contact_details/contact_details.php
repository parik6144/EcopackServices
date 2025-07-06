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
        <h2>Contact Details</h2>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Contact Records</h5>
            <div class="ibox-tools">
                <a href="<?=base_url('contactDetails/add')?>"><button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button></a>
                
            </div>
        </div>
        <div class="ibox-content">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                    <thead>
                    <tr role="row">
                        <th>Sl. No</th>
                        <th>Company Name</th>                        
                        <th>Purpose</th>                        
                        <th>Person name</th>                        
                        <th>Mobile No</th>                        
                        <th>Email ID</th>                        
                        <th>#</th>

                    </tr>
                    </thead>
                </table>
            </div>
            <div class="modal inmodal" id="_contactDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">Contact Form</h4>
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

        /*$("#btn_addrecord").click(function () {
            //alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('contactDetails/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#_contactDetailsModal").modal();

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
        });*/

        // $(document).on("click",".btn_editrecord",function () {

        //     var  refid=$(this).attr('refid');
        //     $.ajax({
        //         type: 'GET',
        //         url: '<?php echo site_url('contactDetails/editpopup')?>',
        //         cache: false,
        //         async: false,
        //         data: {popup:'popup',id:refid},
        //         success: function (data) {
        //             $("#modal_content").html(data);
        //             $("#_contactDetailsModal").modal();

        //         },
        //         error: function (data) {
        //             // alert("error");
        //         },
        //         timeout: 5000,
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             swal("","Please check your internet connection.","error");
        //         }
        //     });
        // });

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
                   url: '<?php echo site_url('contactDetails/deleterecord')?>',
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
            "ajax": "<?php echo site_url('contactDetails/getrecord')?>",
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
    $("#_contactDetailsModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
     

    
</script>
