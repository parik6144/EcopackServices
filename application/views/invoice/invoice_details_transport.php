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
        <h2>Transportation Invoice</h2>
    </div>
    <div class="col-lg-2">
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Transportation Invoice Records</h5>
            <div class="ibox-tools">
                <a href="<?= base_url('invoice/TransportAdd')?>"><button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord1" type="button"><i class="fa fa-plus-circle"></i>
                </button></a>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>

                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo site_url('invoice/add')?>">Add Record</a></li>
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
                    <th>&nbsp;</th>
                    <th>Invoice No.</th>
                    <th>Date</th>
                    <th>Billing Name</th>
                    <!-- <th>Consignor Name</th>
                    <th>Consignee Name</th> -->
                    <th>Total Tax</th>
                    <th>Round Off</th>
                    <th>Invoice Total</th>
                    <th>Invoice Type</th>
                    <th>Status</th>
                    <th>Receipt Date</th>
                    <th>#</th>
                </tr
                </thead>

            </table>

            </div>
            <div class="modal inmodal" id="consigneeModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">Tracking Details</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="consignee_modal_content">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<?php $this->load->view('footer'); ?>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        getrecord();
    });

    function getrecord() {
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "order": [[ 0, "DESC" ]],
            "ajax": "<?php echo site_url('invoice/getrecordtransport')?>",
            dom : '<"html5buttons"B>lTfgitr<"pull-right"p>',
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

    $("#consignmentModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });

    $(document).on("click",".btn_invoice_sent",function(e){
        var ref=$(this);
        var invoice_id=$(this).attr("refid");
        swal({
          title: "Courier Details!",
          text: "Enter Tracking No:",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          inputPlaceholder: "Write something"
        }, function (inputValue) {
          if (inputValue === false) return false;
          var tracking_no=inputValue;
          //swal("Nice!", "You wrote: " + inputValue, "success");
          $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('invoice/changeSentStatus')?>",
                    cache: false,
                    async: false,
                    data: {invoice_id:invoice_id,tracking_no:tracking_no},
                    success: function (data) {
                        if(tracking_no!="")
                        {
                            $(ref).parent().html("<a style='color:green; font-size:15px' href='#' class='btn_tracking' tracking_no='"+tracking_no+"' courier_name='dtdc'><i class='fa fa-map-marker fa-2x'></i></a>");
                        }
                        else
                        {
                            $(ref).parent().html("<span style='color:green'>&#10003;</span>");
                        }
                      swal("success!", "Your record has been Sent!", "success");
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




        /*swal({

                title: "Are you sure?",

                text: "You want to Send this invoice!",

                type: "warning",

                showCancelButton: true,

                confirmButtonClass: 'btn-danger',

                cancelButtonClass: 'btn-success',

                confirmButtonText: 'Yes, close it!',

                closeOnConfirm: false,

                closeOnCancel: false

            },

            function(){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('invoice/changeSentStatus')?>",
                    cache: false,
                    async: false,
                    data: {invoice_id:invoice_id},
                    success: function (data) {
                      $(ref).parent().html("<span style='color:green'>&#10003;</span>");
                      swal("Deleted!", "Your record has been Sent!", "success");
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

        });
    $(document).on('click','.btn_tracking',function(){
        var tracking_no=$(this).attr('tracking_no');
        var courier_name=$(this).attr('courier_name');
        var url="https://track.aftership.com/"+courier_name+"/"+tracking_no;
        //var url="https://corp.onlinesbi.com/saral/login.htm";
        window.open(url, "_blank", "toolbar=no,scrollbars=yes,resizable=no,top=100,left=350,width=600,height=600");

        /*$.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('invoice/track')?>",
                    cache: false,
                    async: false,
                    data: {courier_name:courier_name,tracking_no:tracking_no},
                    success: function (data) {
                        $("#consignee_modal_content").text(data);
                        $("#consigneeModal").modal();
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

                });*/

    })

</script>

