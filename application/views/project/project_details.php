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
<style type="text/css">
    .btn_savestatus{
        font-size: 18px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Project Details</h2>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Project Records</h5>
            <div class="ibox-tools">
                <a href="<?=base_url('project/add')?>"><button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord" type="button"><i class="fa fa-plus-circle"></i>
                </button></a>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo site_url('project/add')?>">Add Record</a>
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
                    <th>&nbsp;</th>
                    <th>Starting Date</th>
                    <th>Project Name</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Project Costing</th>
                    <th>Project Status</th>
                    <th>Remarks</th>
                    <th>#</th>
                    <th>#</th>
                    <th>#</th>

                </tr>
                </thead>
            </table>

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
                   url: '<?php echo site_url('project/deleterecord')?>',
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
            "order": [[ 0, "asc" ]],
            "ajax": "<?php echo site_url('project/getrecord')?>",
            dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
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
    $(document).on("click",".btn_savestatus",function (e) {
        e.preventDefault();
        var refid=$(this).attr('refid');
        var ref=$(this);
        var projectstatus=parseInt($(this).closest("tr").find(".project_status").val());
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('project/changestatus')?>',
            cache: false,
            data: {projectstatus:projectstatus,refid: refid},
            success: function (data) {
                if(data=="true")
                {
                    //ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
                    swal("Updated!", "Project Status Changed!", "success");
                    if(projectstatus>1)
                        ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
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
    
</script>
