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
		<h2>Payment/Expense Booking</h2>
	</div>
	<div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Payment/Expese Record</h5>
					<div class="ibox-tools">
						<a href="<?=base_url('payment_booking/add')?>"><button class="btn btn-danger btn-circle btn-outline" id="" type="button"><i class="fa fa-plus-circle"></i>
							</button></a>
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="<?php echo site_url('place/add')?>">Add Record</a>
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
							<?php
							$user_id = $this->session->userdata('user_id');
							?>
							<thead>
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Booked By</th>
								<th>Expense Head</th>
								<th>Amount</th>
								<th>TDS</th>
								<th>Payable</th>
								<th>Receiver Type</th>
								<th>Receiver Name</th>
								<th>Remarks</th>
								<th>Actions</th>
								<?php if($user_id == 1 || $user_id == 2): // Only show approval column for user 1 (accept) and user 2 (Aakash - verify)?>
									<th>Approval</th>
								<?php endif; ?>
							</tr>
							</thead>
						</table>
					</div>

					<div class="modal inmodal" id="payment_bookingModal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content animated bounceInRight">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

									<h4 class="modal-title">Payment Booking Form</h4>
									<small class="font-bold"></small>
								</div>
								<div class="modal-body" id="payment_booking_modal_content">
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
				url: '<?php echo site_url('payment_booking/addpopup')?>',
				cache: false,
				async: false,
				data: {popup:'popup'},
				success: function (data) {
					$("#payment_booking_modal_content").html(data);
					$("#payment_bookingModal").modal();
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
				url: '<?php echo site_url('payment_booking/editpopup')?>',
				cache: false,
				async: false,
				data: {popup:'popup',id:refid},
				success: function (data) {
					$("#payment_booking_modal_content").html(data);
					$("#payment_bookingModal").modal();
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
			"ajax": "<?php echo site_url('payment_booking/getrecord')?>",
			dom: 'ltr<"pull-right"p>',
		});
	}
	$("#payment_bookingModal").on("hidden.bs.modal", function () {
		$('#example').DataTable().ajax.reload(null, false);
	});

	// This event handler is now for 'Accept' (user_id = 1)
	$(document).on("click",".btn_accept",function (e) {
		e.preventDefault();
		var ref=$(this);
		var refid=$(this).attr('refid');
		swal({
				title: "Are you sure?",
				text: "You want to accept this payment! It will be moved to the Account Section.",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: 'btn-success',
				cancelButtonClass: 'btn-danger',
				confirmButtonText: 'Yes, Accept!',
				cancelButtonText: 'No, cancel!',
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					type: 'POST',
					url: '<?php echo site_url('payment_booking/confirm_booking')?>', // This now acts as the 'accept' action
					cache: false,
					data: {booking_id: refid},
					success: function (data) {
						if(data=="true")
						{
							ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
							swal("Accepted!", "Record Moved to Account Section!", "success");
						} else {
							swal("Rejected!", "Aakash's verification is pending for this record.", "error"); // Added feedback if Aakash hasn't verified
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

	// New event handler for 'Verify' (user_id = 2 - Aakash)
	$(document).on('click', '.btn_verify_user2', function (e) {
		e.preventDefault();
		let refid = $(this).attr('refid');
		swal({
				title: "Are you sure?",
				text: "You want to verify this payment booking?",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: 'btn-primary',
				cancelButtonClass: 'btn-danger',
				confirmButtonText: 'Yes, Verify!',
				cancelButtonText: 'No, cancel!',
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					type: 'POST',
					url: '<?= base_url('payment_booking/verify_user2') ?>',
					cache: false,
					data: { refid: refid },
					dataType: 'json', // Expect JSON response
					success: function (res) {
						if (res.status == 'success') {
							swal("Verified!", "Payment booking verified by Aakash!", "success");
							$('#example').DataTable().ajax.reload(null, false); // Reload the table to reflect changes
						} else {
							swal("Error!", "Failed to verify payment booking.", "error");
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						swal("Error!", "Please check your internet connection or try again later.", "error");
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


</script>
