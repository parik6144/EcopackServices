<?php
// application/views/employee/tabs/master.php
// This view contains the form elements for the Master tab.
// $employee_data is passed from the main employee_form.php
$employee_data = $employee_data ?? [];
$master_data = $employee_data['master_data'] ?? [];
$places = $places ?? [];
$employee_types = $employee_types ?? [];
$designations = $designations ?? [];
?>

<form id="masterForm" data-tab-form="true" novalidate>
	<input type="hidden" id="master_employee_id_hidden_field" name="employee_id_hidden_field" value="<?= isset($master_data['staff_id']) ? encryptor("encrypt", $master_data['staff_id']) : ''; ?>">
	<input type="hidden" id="master_old_photo_filename_hidden" name="old_photo" value="<?= htmlspecialchars($master_data['photo'] ?? ''); ?>">

	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="employee_code" name="employee_code" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['emp_no'] ?? ''); ?>" />
			<label for="employee_code">Employee Code *</label>
			<div class="form-error" id="error_employee_code"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="company" name="company" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['company'] ?? ''); ?>" />
			<label for="company">Company Name *</label>
			<div class="form-error" id="error_company"></div>
		</div>
		<div class="form-group col-md-3">
			<select class="form-control" id="employment_type" name="employment_type" required
					data-current-value="<?= htmlspecialchars($master_data['employee_type_id'] ?? ''); ?>">
				<option value="">Select Employment Type *</option>
				<?php foreach($employee_types as $type): ?>
					<option value="<?= $type['employee_type_id']; ?>"
						<?= (isset($master_data['employee_type_id']) && $master_data['employee_type_id'] == $type['employee_type_id']) ? 'selected' : ''; ?>>
						<?= htmlspecialchars($type['type_name']); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<div class="form-error" id="error_employment_type"></div>
		</div>
		<div class="form-group col-md-3">
			<select class="form-control" id="designation" name="designation" required
					data-current-value="<?= htmlspecialchars($master_data['designation_id'] ?? ''); ?>">
				<option value="">Select Designation *</option>
				<?php
				if (isset($designations) && !empty($designations)) {
					foreach($designations as $designation): ?>
						<option value="<?= $designation['designation_id']; ?>"
							<?= (isset($master_data['designation_id']) && $master_data['designation_id'] == $designation['designation_id']) ? 'selected' : ''; ?>>
							<?= htmlspecialchars($designation['designation_name']); ?>
						</option>
					<?php endforeach;
				}
				?>
			</select>
			<div class="form-error" id="error_designation"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="first_name" name="first_name" required placeholder=" "
				   value="<?= htmlspecialchars(explode(' ', $master_data['staff_name'] ?? '')[0] ?? ''); ?>" />
			<label for="first_name">First Name *</label>
			<div class="form-error" id="error_first_name"></div>
		</div>
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="middle_name" name="middle_name" placeholder=" "
				   value="<?= htmlspecialchars(explode(' ', $master_data['staff_name'] ?? '')[1] ?? ''); ?>" />
			<label for="middle_name">Middle Name</label>
		</div>
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="last_name" name="last_name" required placeholder=" "
				   value="<?= htmlspecialchars(explode(' ', $master_data['staff_name'] ?? '')[2] ?? ''); ?>" />
			<label for="last_name">Last Name *</label>
			<div class="form-error" id="error_last_name"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<select class="form-control" id="posting_city" name="posting_city" required
					data-current-value="<?= htmlspecialchars($master_data['location'] ?? ''); ?>">
				<option value="">Select Posting City *</option>
				<?php foreach($places as $place): ?>
					<option value="<?= $place['place_id']; ?>" data-state="<?= $place['state_code'] ?? ''; ?>"
						<?= (isset($master_data['location']) && $master_data['location'] == $place['place_id']) ? 'selected' : ''; ?>>
						<?= htmlspecialchars($place['place_name']); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<div class="form-error" id="error_posting_city"></div>
		</div>
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="salary_branch" name="salary_branch" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['salary_branch'] ?? ''); ?>" />
			<label for="salary_branch">Salary Branch *</label>
			<div class="form-error" id="error_salary_branch"></div>
		</div>
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="attendance_type" name="attendance_type" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['attendance_type'] ?? ''); ?>" />
			<label for="attendance_type">Attendance Type *</label>
			<div class="form-error" id="error_attendance_type"></div>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-6">
			<input type="email" class="form-control" id="email" name="email" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['email_id'] ?? ''); ?>" />
			<label for="email">Email *</label>
			<div class="form-error" id="error_email"></div>
		</div>
		<div class="form-group col-md-6">
			<input type="text" class="form-control" id="mobile" name="mobile" required placeholder=" "
				   value="<?= htmlspecialchars($master_data['mobile_no'] ?? ''); ?>" />
			<label for="mobile">Mobile Number *</label>
			<div class="form-error" id="error_mobile"></div>
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-4">
			<label for="photo">Photo *</label>
			<?php $has_photo = isset($master_data['photo']) && !empty($master_data['photo']); ?>
			<div style="display: flex; align-items: flex-start; gap: 32px;">
				<!-- Upload Box -->
				<div class="photo-upload-container" id="photoDropArea" style="display: <?= $has_photo ? 'none' : 'block' ?>; min-width: 180px;">
					<input type="file" id="photo" name="photo" accept="image/*" <?= $has_photo ? '' : 'required'; ?> />
					<div class="photo-upload-inner">
						<div class="photo-upload-icon">&#x2B;</div>
						<div class="photo-upload-text">Drag & Drop or Click to Upload</div>
					</div>
				</div>
				<!-- Preview Box -->
				<?php if ($has_photo): ?>
				<div>
					<div class="photo-preview-rect" style="width:120px;height:150px;border:2px solid #ccc;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f8f8f8;margin-bottom:10px;">
						<img src="<?= base_url('uploads/employee_photos/' . $master_data['photo']) ?>" alt="Photo Box Preview" style="width:100%;height:100%;object-fit:cover;" />
					</div>
					<div class="photo-actions mt-2" style="text-align:center;">
						<button type="button" class="btn btn-sm btn-info" id="changePhotoBtn" onclick="$('#photoDropArea').show();$(this).closest('div').parent().hide();$('#photo').val('');">Change Photo</button>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="form-error" id="error_photo"></div>
		</div>
	</div>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Master Data</button>
		<button type="button" id="resetMasterForm" class="btn btn-warning">Reset</button>
	</div>
</form>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const employeeTypeId = $('#employment_type').data('current-value');
		const designationId = $('#designation').data('current-value');

		function fetchDesignations(typeId, selectedId = null) {
			const $designationSelect = $('#designation');
			if (!typeId) {
				$designationSelect.html('<option value="">Select Designation *</option>').val('').trigger('change');
				return;
			}

			$.ajax({
				url: '<?= base_url('employee/get_designations_by_type') ?>',
				type: 'POST',
				data: { employee_type_id: typeId },
				dataType: 'json',
				beforeSend: function() {
					$designationSelect.prop('disabled', true).html('<option value="">Loading...</option>');
				},
				success: function(response) {
					let options = '<option value="">Select Designation *</option>';
					if (response && response.length > 0) {
						response.forEach(function(designation) {
							const isSelected = selectedId && designation.designation_id == selectedId ? 'selected' : '';
							options += `<option value="${designation.designation_id}" ${isSelected}>${designation.designation_name}</option>`;
						});
					}
					$designationSelect.html(options);
					if (selectedId) {
						$designationSelect.val(selectedId);
					}
				},
				error: function() {
					$designationSelect.html('<option value="">Could not load designations</option>');
				},
				complete: function() {
					$designationSelect.prop('disabled', false);
				}
			});
		}

		if (employeeTypeId) {
			fetchDesignations(employeeTypeId, designationId);
		}

		$('#employment_type').on('change', function() {
			const newTypeId = $(this).val();
			fetchDesignations(newTypeId);
		});
	});
</script>
