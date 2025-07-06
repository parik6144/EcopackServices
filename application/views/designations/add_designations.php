<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
if(!isset($condition))
{
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');

?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2>Designations</h2>
		</div>
		<div class="col-lg-2">
		</div>
	</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Designations Form</h5>
					<span class="pull-right"><a href="<?php echo site_url('designations') ?>"><i class="fa fa-angle-left"></i> Back</a> </span>
				</div>
				<?php } ?>
				<div class="ibox-content">
					<form method="POST" class="form-horizontal" id="frm_designations">
						<div class="form-group row">
							<label class="col-sm-2 control-label">Department</label>
							<div class="col-sm-10">
								<select class="rec select2-enabled" name="employee_type_id" required>
									<option value="">Select Department</option>
									<?php
									foreach ($employee_type as $row) {
										echo '<option value="'.$row['employee_type_id'].'">'.$row['type_name'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Designation Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control rec" name="designation_name" required>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group row">
							<div class="col-sm-4 col-sm-offset-2">
								<button type="button" class="btn btn-primary" id="btn_save_designations"><i class="fa fa-save"></i> Save</button>
							</div>
						</div>
					</form>
				</div>
				<?php
				if(!isset($condition)) {
				?>
			</div>
		</div>
	</div>
</div>
<?php
$this->load->view('footer'); // Your footer likely includes jQuery
}
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script type="text/javascript">
	var lastid="";
	$(document).ready(function () {
		// Initialize Select2 for the department dropdown
		$('.select2-enabled').select2({
			placeholder: "Select a Department",
			allowClear: true, // Option to clear the selection
			theme: "bootstrap" // Use this if you included the Select2 Bootstrap theme CSS
		});
	});

	$("#btn_save_designations").click(function () {
		var ref=$(this);
		if(validate(ref))
		{
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('designations/add')?>',
				cache: false,
				async: false,
				data: $("#frm_designations").serialize(),
				success: function (data) {
					swal("","Record Saved Successfully","success");
					lastid=data;
					$("#frm_designations")[0].reset();
					$('.select2-enabled').val(null).trigger('change');
					$('#designationsModal').modal('hide');
				},
				error: function (data) {
					swal("Error!", "An error occurred while saving the record.", "error");
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
		}
		else
		{
			swal("Validation Error!", "Please fill all required fields.", "warning");
		}
	});

	function validate(ref) {
		let isValid = true;
		$("#frm_designations .rec").each(function() {
			if ($(this).hasClass('select2-enabled')) {
				if ($(this).val() === "" || $(this).val() === null) {
					$(this).next('.select2-container').find('.select2-selection--single').addClass("is-invalid");
					isValid = false;
				} else {
					$(this).next('.select2-container').find('.select2-selection--single').removeClass("is-invalid");
				}
			} else if ($(this).val() === "" || $(this).val() === null) {
				$(this).addClass("is-invalid");
				isValid = false;
			} else {
				$(this).removeClass("is-invalid");
			}
		});
		return isValid;
	}
</script>
<style>
	/* Custom CSS to fix double border if it persists or to style Select2 better */
	.select2-container .select2-selection--single {
		height: 34px !important; /* Adjust height to match other form inputs if needed */
		/* border: 1px solid #ccc !important; Standard border - let Select2 theme handle if theme is used */
		border-radius: 4px; /* Standard border-radius */
		padding-top: 2px; /* Adjust padding if text looks off-center */
	}

	.select2-container .select2-selection--single .select2-selection__rendered {
		padding-left: 12px; /* Adjust as needed */
		line-height: 28px; /* Vertically align text */
	}

	.select2-container--open .select2-dropdown .select2-search__field {
		border: 1px solid #ccc;
		padding: 6px 12px;
		height: 34px; /* Match standard input height */
	}

	/* Validation styling for Select2 */
	.select2-container--default .select2-selection--single.is-invalid {
		border-color: #dc3545 !important;
	}

	/* Basic styling for other invalid inputs if not handled by your theme */
	.is-invalid {
		border-color: #dc3545 !important;
	}
</style>
</body>
</html>
