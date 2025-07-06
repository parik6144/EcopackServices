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
    <div class="col-lg-8">
        <h2>Due Booking Pending Transfer</h2>
        
    </div>
    <div class="col-lg-4">
        <h2>Total Outstanding 
        <?php echo $total_outstanding; ?></h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Payment/Expese Record</h5>
            
        </div>
        <div class="ibox-content">

            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th>&nbsp;</th>
                    <th>Booking Date</th>
                    <th>Booked By</th>
                    <th>Expense Type</th>
                    <th>Amount</th>
                    <th>TDS</th>
                    <th>Net Pay</th>
                    <th>Recever Type</th>
                    <th>Receved By</th>
                    <th>Bank Name</th>
                    <th>Branch</th>
                    <th>Account No</th>
                    <th>IFSC</th>
                    <th>Remarks</th>
                    <th>#</th>
                    <th>Mode</th>
                    <th>#</th>
                    
                </tr>
                </thead>
            </table>
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
                   url: '<?php echo site_url('payment_booking/deleterecord')?>',
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
            "order": [[ 1, "asc" ]],
            "ajax": "<?php echo site_url('booking_transfer/getrecord')?>",
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
    $("#payment_bookingModal").on("hidden.bs.modal", function () {
        $(".pagination .active").click();
    });

    $(document).on("click",".btn_accept",function (e) {
        e.preventDefault();
        var ref=$(this);
        var refid=$(this).attr('refid');
		var payment_mode=$(this).closest("tr").find('.payment_mode').val();
		if(payment_mode=="")
		{
			alert("select payment mode");
		}
		else
		{
			
			swal({
					title: "Are you sure?",
					text: "You want to Finish this payment!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: 'btn-success',
					cancelButtonClass: 'btn-danger',
					confirmButtonText: 'Yes, Confirm!',
					cancelButtonText: 'No, cancel!',
					closeOnConfirm: false
					//closeOnCancel: false
				},
				function(){

					$.ajax({
						type: 'POST',
						url: '<?php echo site_url('booking_transfer/confirm_payment')?>',
						cache: false,
						data: {booking_id: refid,payment_mode:payment_mode},
						success: function (data) {
							if(data=="true")
							{
								ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
								swal("Confirmed!", "Record Moved to Account Section!", "success");
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
		}
    });

</script>
