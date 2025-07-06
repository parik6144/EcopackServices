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
        <h2>Delivery Challan</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <?php if($this->session->flashdata('update')) {?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button> <?=$this->session->flashdata('update')?>
                </div>
            <?php } if($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button> <?=$this->session->flashdata('error')?>
                </div>
            <?php } ?>

            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"><label>Consignee Name</label>
                                    <select class="consignee_name form-control"  name="consignee" id="consigneeid" required="required">
                                        <option value="">select consignee</option>
                                        <?php
                                        foreach ($consignee as $row){ ?>
                                        <option value="<?=encryptor("encrypt",$row['consignee_id']);?>"><?=$row['consignee_name'];?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" style="margin-top: 30px;">Get Record</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Delivery Challan Records</h5>
            <div class="ibox-tools">
                <a href="<?= base_url('Deliverychallan/add')?>"><button class="btn btn-danger btn-circle btn-outline" id="btn_addrecord1" type="button"><i class="fa fa-plus-circle"></i>
                </button></a>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>

                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>

                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo site_url('consignee/add')?>">Add Record</a>
                    </li>
                </ul>

                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
        <style>td{ text-align: center; }</style>
        <div class="table-responsive">
            <form action="<?=base_url('invoice/boxrent')?>" method="POST">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th class="text-center"></th>
                    <!--<th class="text-center">Sl.No</th>-->
                    <th class="text-center">DC No.</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Consignor</th>
                    <th class="text-center">Consignee</th>
<!--                    <th class="text-center">Bill Type</th>-->
                    <th class="text-center">Vehicle No</th>
                    <th class="text-center">Driver Name</th>
					<th class="text-center">Warehouse</th>
                    <th class="text-center">DC Status</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Assets-Qty</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
            </table>

            <?php $consignee=$this->input->get('consignee'); if(!empty($consignee)){ ?>
            <table>
            <thead>
            <tr><td><button id="makeinvoicesubmitBtn" type="submit" class="btn btn-info" disabled>Make Invoice</button></td><td colspan="10"></td> </tr>
            </thead>
            </table>
            <?php } ?>
            </form>
            </div>

            <div class="modal inmodal" id="consignmentModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Consignment Form</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body" id="consignment_modal_content">
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
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        getrecord();
        $("#btn_addrecord").click(function () {
            //alert("ok");
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('consignment/addpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup'},
                success: function (data) {
                    $("#consignment_modal_content").html(data);
                    $("#consignmentModal").modal();
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
        
        
          $(document).ready(function() {
            // Monitor checkbox state changes using event delegation
            $(document).on("change", "input[type='checkbox']", function() {
                // Count checked checkboxes
                var checkedCount = $("input[type='checkbox']:checked").length;
                // Log the count to the console
                console.log("Number of checkboxes checked: " + checkedCount);

                if (checkedCount > 0) {
                    // Enable the button if one or more checkboxes are checked
                    $("#makeinvoicesubmitBtn").prop("disabled", false);
                } else {
                    // Disable the button if no checkbox is checked
                    $("#makeinvoicesubmitBtn").prop("disabled", true);
                }
            });
        });

        $(document).on("click",".btn_editrecord",function () {

            var  refid=$(this).attr('refid');
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('consignment/editpopup')?>',
                cache: false,
                async: false,
                data: {popup:'popup',id:refid},
                success: function (data) {
                    $("#consignement_modal_content").html(data);
                    $("#consignmentModal").modal();

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
                   url: '<?php echo site_url('consignment/deleterecord')?>',
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

        // Ajax post
        $(document).ready(function() {
            $(".submit").click(function(event) {
                event.preventDefault();
                var user_name = $("input#name").val();
                var password = $("input#pwd").val();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/ajax_post_controller/user_data_submit",
                    dataType: 'json',
                    data: {name: user_name, pwd: password},
                    success: function(res) {
                        if (res)
                        {
        // Show Entered Value
                            jQuery("div#result").show();
                            jQuery("div#value").html(res.username);
                            jQuery("div#value_pwd").html(res.pwd);
                        }
                    }
                });
            });
        });

    function getrecord() {
        // if(consigneeid!=''){ alert(consignee_id); new_con_id = consigneeid;  } else { new_con_id = ''; }
         var consignee_id =$('#consigneeid').val(); if(consignee_id!=''){   }

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "DESC" ]],
             type: "post",
             data: {"consignee": consignee_id},
             "ajax": "<?php echo site_url('Deliverychallan/getrecord?consignee=').$this->input->get('consignee')?>",
             dom: '<"html5buttons"B>lTfgitr<"pull-right"p>',
             "tableTools": {
              "sSwfPath": "<?php echo base_url() ?>assets/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
              },
               buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Delivery Challan Data Records'},
                    {extend: 'pdf', title: 'Delivery Challan Data Records'},
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

<script>
    //    get_records_by_consignee(){  alert(544);
    //        var consignee_id =$('#consigneeid').val();
    //        alert(consignee_id);
    //        getrecord(consignee_id);
    //    }

   $('#consigneeid').on('change', function() {
      //  getrecord();
//      var consignee_id =$('#consigneeid').val(); if(consignee_id!='')
//       {
//           getrecord(consignee_id);
//       }
        //alert(consignee_id);
     //getrecord(consignee_id);
    });
</script>
