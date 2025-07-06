<?php
/**
 * Employee List View
 * Displays all employees in a DataTable format similar to account details page
 */

$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Employee Management</h2>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Employee Records</h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('employee/add'); ?>" class="btn btn-danger btn-circle btn-outline" title="Add New Employee"><i class="fa fa-plus-circle"></i></a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo site_url('employee/add')?>">Add Employee</a>
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
                                <th>Sl. No</th>
                                <th>Employee Code</th>
                                <th>Name</th>
                                <th>Employment Type</th>
                                <th>Designation</th>
                                <th>Posting City</th>
                                <th>#</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal inmodal" id="employeeModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                    <h4 class="modal-title">Employee Form</h4>
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

        $(document).on("click",".btn_editrecord",function () {
            var refid=$(this).attr('refid');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('employee/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid},
                success: function (data) {
                    $("#modal_content").html(data);
                    $("#employeeModal").modal();
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
                text: "You want to delete this employee!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-success',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: false
            },
            function(){
               
                $.ajax({
                    type: 'POST',
                   url: '<?php echo site_url('employee/deleterecord')?>',
                    cache: false,
                    data: {delete: refid},
                    success: function (data) {
                        if(data=="true")
                        {
                            ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
                            swal("Deleted!", "Your employee record has been deleted!", "success");
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
            "order": [[ 1, "asc" ]],
            "ajax": {
                "url": "<?php echo site_url('employee/getrecord')?>",
                "dataSrc": function(json) {
                    // Check if no data is returned
                    if (json.recordsTotal === 0) {
                        // Show a message in the table
                        $('#example tbody').html('<tr><td colspan="7" class="text-center">No employees found</td></tr>');
                    }
                    return json.data || [];
                }
            },
            dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
             "tableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            },
               buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Employee Data Records'},
                    {extend: 'pdf', title: 'Employee Data Records'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '12px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ],
            "language": {
                "emptyTable": "No employees found in the database",
                "zeroRecords": "No employees found matching your search criteria"
            }

            });
    }
    $("#employeeModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });
    
    // Listen for employee saved event from popup
    $(document).on('employeeSaved', function() {
        $('#example').DataTable().ajax.reload();
    });
</script>
