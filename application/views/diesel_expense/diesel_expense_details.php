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
        <h2>Diesel Expense</h2>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Diesel Expense</h5>
            <div class="ibox-tools">
            	<a href="<?=base_url('diesel_expense/add')?>">
                <button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button>
            	</a>
                
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">


            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th>&nbsp;</th>
                    <th>Expense Date</th>
                    <th>Vehicle No</th>
                    <th>Amount</th>
                    <th>#</th>

                </tr>
                </thead>
            </table>

            <div class="modal inmodal" id="diesel_expenseModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            <h4 class="modal-title">Diesel Expense</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="diesel_expense_modal_content">
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


        $(document).on("click",".btn_editrecord",function () {

            var  refid=$(this).attr('refid');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('diesel_expense/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid},
                success: function (data) {
                    $("#diesel_expense_modal_content").html(data);
                    $("#diesel_expenseModal").modal();

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
                   url: '<?php echo site_url('diesel_expense/deleterecord')?>',
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
            "ajax": "<?php echo site_url('diesel_expense/getrecord')?>",
            dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
             "tableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
               buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Diesel Expenses Data Records'},
                    {extend: 'pdf', title: 'Diesel Expenses Data Records'},

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
    $("#diesel_expenseModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
</script>
