<?php
// application/views/employee/tabs/personal/career.php
// This view contains the form elements and dynamic table for "Career" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$career_data = $employee_data['career_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<form id="personalCareerForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Employment Record</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="career_from_date" name="career_from_date" required>
				<label for="career_from_date">From Date *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="career_to_date" name="career_to_date" required>
				<label for="career_to_date">To Date *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_employer" name="career_employer" placeholder=" " required>
				<label for="career_employer">Employer *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_employer_code" name="career_employer_code" placeholder=" ">
				<label for="career_employer_code">Employer Code</label>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<select class="form-control" id="career_employment_status" name="career_employment_status">
					 <option value="">Select Status</option>
				</select>
				<label for="career_employment_status">Employment Status</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_position" name="career_position" placeholder=" " required>
				<label for="career_position">Position *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_department" name="career_department" placeholder=" ">
				<label for="career_department">Department</label>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_address" name="career_address" placeholder=" " required>
				<label for="career_address">Address *</label>
			</div>
		</div>
		<div class="form-row">
			 <div class="form-group col-md-3">
				<input type="number" step="0.01" class="form-control" id="career_starting_salary" name="career_starting_salary" placeholder=" " required>
				<label for="career_starting_salary">Starting Salary *</label>
			</div>
			 <div class="form-group col-md-3">
				<input type="number" step="0.01" class="form-control" id="career_starting_other_comp" name="career_starting_other_comp" placeholder=" ">
				<label for="career_starting_other_comp">Starting Other Compensation</label>
			</div>
			 <div class="form-group col-md-3">
				<input type="number" step="0.01" class="form-control" id="career_final_salary" name="career_final_salary" placeholder=" " required>
				<label for="career_final_salary">Final Salary *</label>
			</div>
			 <div class="form-group col-md-3">
				<input type="number" step="0.01" class="form-control" id="career_final_other_comp" name="career_final_other_comp" placeholder=" " required>
				<label for="career_final_other_comp">Final Other Compensation *</label>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_responsibility" name="career_responsibility" placeholder=" " required>
				<label for="career_responsibility">Responsibility *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_achievement" name="career_achievement" placeholder=" ">
				<label for="career_achievement">Achievement</label>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_reason_for_change" name="career_reason_for_change" placeholder=" " required>
				<label for="career_reason_for_change">Reason for Change *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_contact_person" name="career_contact_person" placeholder=" ">
				<label for="career_contact_person">Contact Person</label>
			</div>
		</div>
		<div class="form-row">
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_contact_person_job_title" name="career_contact_person_job_title" placeholder=" ">
				<label for="career_contact_person_job_title">Contact Person Job Title</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="career_contact_person_dept" name="career_contact_person_dept" placeholder=" ">
				<label for="career_contact_person_dept">Contact Person Department</label>
			</div>
			 <div class="form-group col-md-2">
				<input type="tel" class="form-control" id="career_contact_person_mobile" name="career_contact_person_mobile" placeholder=" ">
				<label for="career_contact_person_mobile">Contact Person Mobile No</label>
			</div>
			 <div class="form-group col-md-2">
				<input type="email" class="form-control" id="career_contact_person_email" name="career_contact_person_email" placeholder=" ">
				<label for="career_contact_person_email">Contact Person Email</label>
			</div>
			 <div class="form-group col-md-2">
				<input type="url" class="form-control" id="career_company_website" name="career_company_website" placeholder=" ">
				<label for="career_company_website">Company Website</label>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Others</legend>
		<div class="form-row">
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_uan_no" name="career_uan_no" placeholder=" ">
				<label for="career_uan_no">UAN No.</label>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_epf_ac_no" name="career_epf_ac_no" placeholder=" ">
				<label for="career_epf_ac_no">EPF A/c No</label>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_epf_region" name="career_epf_region" placeholder=" ">
				<label for="career_epf_region">EPF Region</label>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_esi_ac_no" name="career_esi_ac_no" placeholder=" ">
				<label for="career_esi_ac_no">ESI A/c No</label>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_scheme_cert_no" name="career_scheme_cert_no" placeholder=" ">
				<label for="career_scheme_cert_no">Scheme Certificate No</label>
			</div>
			 <div class="form-group col-md-2">
				<input type="text" class="form-control" id="career_pension_payment_order_no" name="career_pension_payment_order_no" placeholder=" ">
				<label for="career_pension_payment_order_no">Pension Payment Order No</label>
			</div>
		</div>
		 <div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addCareerRecordBtn">Add Record</button>
		</div>
	</fieldset>
	
	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Employment Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="careerRecordsTable">
				<thead>
					<tr>
						<th>From</th>
						<th>To</th>
						<th>Employer</th>
						<th>Position</th>
						<th>Final Salary</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Gap</legend>
		<div class="form-row">
			<div class="form-group col-md-4">
				<input type="date" class="form-control" id="career_gap_from_date" name="career_gap_from_date">
				<label for="career_gap_from_date">From Date</label>
			</div>
			<div class="form-group col-md-4">
				<input type="date" class="form-control" id="career_gap_to_date" name="career_gap_to_date">
				<label for="career_gap_to_date">To Date</label>
			</div>
			<div class="form-group col-md-4">
				<textarea class="form-control" id="career_gap_reason" name="career_gap_reason" placeholder=" " maxlength="200"></textarea>
				<label for="career_gap_reason">Reason</label>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addCareerGapBtn">Add Career Gap</button>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Gap Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="careerGapRecordsTable">
				<thead>
					<tr>
						<th>From</th>
						<th>To</th>
						<th>Reason</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</fieldset>
	
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Career Data</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
