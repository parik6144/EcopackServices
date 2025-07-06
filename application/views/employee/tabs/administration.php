<?php
// application/views/employee/tabs/administration.php
// This view contains the form elements for the Administration tab.
// $employee_data is passed from the main employee_form.php
$admin_details = isset($employee_data['admin_details']) ? $employee_data['admin_details'] : [];
?>

<form id="administrationForm" data-tab-form="true">
	<input type="hidden" name="employee_id_hidden_field" value="">

	<h5>Administration Details</h5>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="admin_start_date" name="admin_start_date" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['start_date'] ?? ''); ?>" />
			<label for="admin_start_date">Start Date</label>
			<div class="form-error" id="error_admin_start_date"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_status" name="admin_status" placeholder="e.g., Confirmed, Probation"
				   value="<?= htmlspecialchars($admin_details['status'] ?? ''); ?>" />
			<label for="admin_status">Status</label>
			<div class="form-error" id="error_admin_status"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="number" class="form-control" id="admin_probation_period" name="admin_probation_period" placeholder="e.g., 6"
				   value="<?= htmlspecialchars($admin_details['probation_period'] ?? ''); ?>" />
			<label for="admin_probation_period">Probation Period (Months)</label>
			<div class="form-error" id="error_admin_probation_period"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="admin_confirmation_date" name="admin_confirmation_date" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['confirmation_date'] ?? ''); ?>" />
			<label for="admin_confirmation_date">Confirmation Date</label>
			<div class="form-error" id="error_admin_confirmation_date"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_grade" name="admin_grade" placeholder="e.g., A1, Manager"
				   value="<?= htmlspecialchars($admin_details['grade'] ?? ''); ?>" />
			<label for="admin_grade">Grade</label>
			<div class="form-error" id="error_admin_grade"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_division" name="admin_division" placeholder="e.g., North, South"
				   value="<?= htmlspecialchars($admin_details['division'] ?? ''); ?>" />
			<label for="admin_division">Division</label>
			<div class="form-error" id="error_admin_division"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_job_title" name="admin_job_title" placeholder="e.g., Senior Developer"
				   value="<?= htmlspecialchars($admin_details['job_title'] ?? ''); ?>" />
			<label for="admin_job_title">Job Title</label>
			<div class="form-error" id="error_admin_job_title"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="number" class="form-control" id="admin_notice_period" name="admin_notice_period" placeholder="e.g., 90"
				   value="<?= htmlspecialchars($admin_details['notice_period'] ?? ''); ?>" />
			<label for="admin_notice_period">Notice Period (Days)</label>
			<div class="form-error" id="error_admin_notice_period"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_attendance_cycle" name="admin_attendance_cycle" placeholder="e.g., Monthly"
				   value="<?= htmlspecialchars($admin_details['attendance_cycle'] ?? ''); ?>" />
			<label for="admin_attendance_cycle">Attendance Cycle</label>
			<div class="form-error" id="error_admin_attendance_cycle"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_shift" name="admin_shift" placeholder="e.g., Day, Night"
				   value="<?= htmlspecialchars($admin_details['shift'] ?? ''); ?>" />
			<label for="admin_shift">Shift</label>
			<div class="form-error" id="error_admin_shift"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_manager" name="admin_manager" placeholder="e.g., EMP001"
				   value="<?= htmlspecialchars($admin_details['manager_id'] ?? ''); ?>" />
			<label for="admin_manager">Manager</label>
			<div class="form-error" id="error_admin_manager"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_manager_name" name="admin_manager_name" placeholder="e.g., Alice Smith"
				   value="<?= htmlspecialchars($admin_details['manager_name'] ?? ''); ?>" />
			<label for="admin_manager_name">Name (Manager Name)</label>
			<div class="form-error" id="error_admin_manager_name"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="admin_resignation_date" name="admin_resignation_date" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['resignation_date'] ?? ''); ?>" />
			<label for="admin_resignation_date">Resignation Date</label>
			<div class="form-error" id="error_admin_resignation_date"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_resp_acceptance" name="admin_resp_acceptance" placeholder="e.g., Accepted"
				   value="<?= htmlspecialchars($admin_details['resp_acceptance'] ?? ''); ?>" />
			<label for="admin_resp_acceptance">Resp. Acceptance</label>
			<div class="form-error" id="error_admin_resp_acceptance"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_reason_for_leaving" name="admin_reason_for_leaving" placeholder="e.g., Better opportunity"
				   value="<?= htmlspecialchars($admin_details['reason_for_leaving'] ?? ''); ?>" />
			<label for="admin_reason_for_leaving">Reason for Leaving</label>
			<div class="form-error" id="error_admin_reason_for_leaving"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="admin_last_working_date" name="admin_last_working_date" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['last_working_date'] ?? ''); ?>" />
			<label for="admin_last_working_date">Last Working Date</label>
			<div class="form-error" id="error_admin_last_working_date"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_old_emp_code" name="admin_old_emp_code" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['old_emp_code'] ?? ''); ?>" />
			<label for="admin_old_emp_code">Old Emp Code</label>
			<div class="form-error" id="error_admin_old_emp_code"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="admin_old_emp_code_name" name="admin_old_emp_code_name" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['old_emp_code_name'] ?? ''); ?>" />
			<label for="admin_old_emp_code_name">Name (Old Emp Code Name)</label>
			<div class="form-error" id="error_admin_old_emp_code_name"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="admin_initial_joining_date" name="admin_initial_joining_date" placeholder=" "
				   value="<?= htmlspecialchars($admin_details['initial_joining_date'] ?? ''); ?>" />
			<label for="admin_initial_joining_date">Initial Joining Date</label>
			<div class="form-error" id="error_admin_initial_joining_date"></div>
		</div>
	</div>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Administration Data</button>
	</div>
</form>
