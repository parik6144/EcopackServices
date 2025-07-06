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
        <h2>Advance Payment of Consignment</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Advance Payment Details</h5>
            
        </div>
        <div class="ibox-content">

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th>&nbsp;</th>
                    <th>Consignment No.</th>
                    <th>Date</th>
                    <th>Owner Name</th>
                    <th>Mobile No</th>
                    <th>Bank Name</th>
                    <th>Branch</th>
                    <th>Account No.</th>
                    <th>IFSC</th>
                    <th>GSTIN/Pan</th>
                    <th>Advance</th>
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
        

    });
    function getrecord() {
        $('#example').DataTable( {
            
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "DESC" ]],
            "ajax": "<?php echo site_url('advance_payment/getrecord')?>",dom: '<"html5buttons"B>lTfgitp',
             dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
             "tableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
               buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Advance Payments Data Records'},
                    {extend: 'pdf', title: 'Advance Payments Data Records'},

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
</script>
