<?php
// application/views/employee/tabs/personal/family.php
// This view contains the form elements and dynamic table for "Family" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$family_data = $employee_data['family_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<form id="personalFamilyForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Basic</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_first_name" name="family_first_name" placeholder=" " required>
				<label for="family_first_name">First Name *</label>
				<div class="form-error" id="error_family_first_name"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_middle_name" name="family_middle_name" placeholder=" ">
				<label for="family_middle_name">Middle Name</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_last_name" name="family_last_name" placeholder=" " required>
				<label for="family_last_name">Last Name *</label>
				<div class="form-error" id="error_family_last_name"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_relation" name="family_relation" placeholder=" " required>
				<label for="family_relation" class="form-label form-label-blue">Relation *</label>
				<div class="form-error" id="error_family_relation"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-2">
				<select class="form-control" id="family_gender" name="family_gender" required>
					<option value="">Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
				<label for="family_gender">Gender *</label>
				<div class="form-error" id="error_family_gender"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="date" class="form-control" id="family_dob" name="family_dob" required>
				<label for="family_dob">DOB *</label>
				<div class="form-error" id="error_family_dob"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="family_contact_no" name="family_contact_no" placeholder=" ">
				<label for="family_contact_no">Contact No</label>
				<div class="form-error" id="error_family_contact_no"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="email" class="form-control" id="family_email_id" name="family_email_id" placeholder=" ">
				<label for="family_email_id">Email Id</label>
				<div class="form-error" id="error_family_email_id"></div>
			</div>
			<div class="form-group col-md-3">
				<select class="form-control" id="family_dependent" name="family_dependent" required>
					<option value="">Select</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
				</select>
				<label for="family_dependent">Dependent *</label>
				<div class="form-error" id="error_family_dependent"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<label for="residing_with_employee" class="form-label form-label-blue">Residing With Employee *</label>
				<div class="radio-group mt-1">
					<label class="radio-inline">
						<input type="radio" class="form-check-input" name="residing_with_employee" id="residing_yes" value="Yes" required> Yes
					</label>
					<label class="radio-inline">
						<input type="radio" class="form-check-input" name="residing_with_employee" id="residing_no" value="No" required> No
					</label>
				</div>
				<div class="form-error" id="error_residing_with_employee"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_aadhar_no" name="family_aadhar_no" placeholder=" " maxlength="12">
				<label for="family_aadhar_no" class="form-label form-label-blue">Aadhar No</label>
				<div class="form-error" id="error_family_aadhar_no"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Address</legend>
		<div class="form-row">
			 <div class="form-group col-md-2">
				<input type="text" class="form-control" id="family_house_no" name="family_house_no" placeholder=" ">
				<label for="family_house_no">House No</label>
				<div class="form-error" id="error_family_house_no"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="family_street_no" name="family_street_no" placeholder=" ">
				<label for="family_street_no">Street No</label>
				<div class="form-error" id="error_family_street_no"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="family_block_no" name="family_block_no" placeholder=" ">
				<label for="family_block_no">Block No</label>
				<div class="form-error" id="error_family_block_no"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_street" name="family_street" placeholder=" ">
				<label for="family_street">Street</label>
				<div class="form-error" id="error_family_street"></div>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_landmark" name="family_landmark" placeholder=" ">
				<label for="family_landmark">LandMark</label>
				<div class="form-error" id="error_family_landmark"></div>
			</div>
		</div>
		 <div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_police_station" name="family_police_station" placeholder=" ">
				<label for="family_police_station">Police Station</label>
				<div class="form-error" id="error_family_police_station"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="family_post_office" name="family_post_office" placeholder=" ">
				<label for="family_post_office">Post Office</label>
				<div class="form-error" id="error_family_post_office"></div>
			</div>
			<div class="form-group col-md-3">
				<select class="form-control" id="family_country_state" name="family_country_state" >
					<option value="">Country / State</option>
				</select>
				<label for="family_country_state">Country / State</label>
				<div class="form-error" id="error_family_country_state"></div>
			</div>
			<div class="form-group col-md-3">
				 <input type="text" class="form-control" id="family_city_zip" name="family_city_zip" placeholder=" ">
				<label for="family_city_zip">City / Zip Code</label>
				<div class="form-error" id="error_family_city_zip"></div>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addFamilyMemberBtn">Add Record</button>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Family Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="familyRecordsTable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Relation</th>
						<th>Gender</th>
						<th>DOB</th>
						<th>Contact No</th>
						<th>Dependent</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- Records will be added here dynamically -->
				</tbody>
			</table>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Family Data</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
