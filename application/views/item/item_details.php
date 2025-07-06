<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/08/2017
 * Time: 14:52
 */
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Item</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Item Records</h5>
            <div class="ibox-tools">
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button>
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord1" type="button" style="display:none"><i class="fa fa-plus-circle"></i>
                </button>
                
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="panel blank-panel">

                        <div class="panel-heading">
                            <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active" id="transport_li" ><a data-toggle="tab" href="#tab-1">Transport Item</a></li>
                                    <li class="" id="rent_li"><a data-toggle="tab" href="#tab-2">Rent Item</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                                            <thead>
                                            <tr role="row">
                                                <th>Sl. No</th>
                                                <th>Item Name</th>
                                                <th>Consignee Name</th>
                                                <th>Opening Stock</th>
                                                <th>#</th>

                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div id="tab-2" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example-rent" id="example_rent" style="width: 100%;">
                                            <thead>
                                            <tr role="row">
                                                <th>Sl. No</th>
                                                <th>Item Name</th>
                                                <th>Consignee Name</th>
                                                <th>Rate/PS</th>
                                                <th>Current Stock</th>
                                                <th>Total</th>
                                                <th>#</th>
                                            </tr>
                                            </thead>
                                            
                                             <tfoot>
                                                <tr>
                                                    <th colspan="5" style="text-align:right">Total :</th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

            

            <div class="modal inmodal" id="itemModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">Item Form</h4>
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
    $("#transport_li").click(function(){
        $("#btn_addrecord").show();
        $("#btn_addrecord1").hide();
    });
    $("#rent_li").click(function(){
        $("#btn_addrecord").hide();
        $("#btn_addrecord1").show();
    });
    $(document).ready(function() {
        getrecord();
        getrentrecord();

        $("#btn_addrecord").click(function () {
            //alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#itemModal").modal();

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

        $("#btn_addrecord1").click(function () {
            //alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/add_rent_stock_popup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#itemModal").modal();

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
                url: '<?php echo site_url('item/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid,type:'transport'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#itemModal").modal();

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

        $(document).on("click",".btn_editrentrecord",function () {

            var  refid=$(this).attr('refid');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('item/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid,type:'rent'},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#itemModal").modal();

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
            //alert(refid);
            swal({
                    title: "Are you sure?",
                    // text: "You want to delete this post!",
                    <?php if($this->session->userdata('user_id')==1){ ?>
                    text: "You want to delete this post!",
                    <?php } ?>
                    <?php if($this->session->userdata('user_id')!=1){ ?>
                    text: "Unauthorized !! You are not authorized to delete this post!",
                    <?php } ?>
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
                        url: '<?php echo site_url('item/deleterecord')?>',
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

        $(document).on("click",".btn_deleterentrecord",function (e) {
            e.preventDefault();
            var ref=$(this);
            var refid=$(this).attr('refid');
            // alert(refid); 
            swal({
                    title: "Are you sure?",
                    // text: "You want to delete this post!",
                    <?php if($this->session->userdata('user_id')==1){ ?>
                    text: "You want to delete this post!",
                    <?php } ?>
                    <?php if($this->session->userdata('user_id')!=1){ ?>
                    text: "Unauthorized !! You are not authorized to delete this post!",
                    <?php } ?>
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
                        url: '<?php echo site_url('item/deleterentrecord')?>',
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
            "ajax": "<?php echo site_url('item/getrecord')?>",
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
    function getrentrecord() {
        $('#example_rent').DataTable( {
            "processing": true,
            "serverSide": true,
            "order": [[ 2, "asc" ]],
            "ajax": "<?php echo site_url('item/getrentrecord')?>",
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'}
            ],
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(
                'Rs: '+ total
            );
        }
        } );
    }
    $("#itemModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
     

    
</script>
