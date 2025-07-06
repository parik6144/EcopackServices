<?php
// application/views/employee/tabs/personal/emergency.php
// This view contains the form elements and dynamic table for "Emergency" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$emergency_data = $employee_data['emergency_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<form id="personalEmergencyForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Emergency Contact</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="emergency_name" name="emergency_name" placeholder=" " required>
				<label for="emergency_name">Name *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="emergency_relation" name="emergency_relation" placeholder=" " required>
				<label for="emergency_relation">Relation *</label>
			</div>
			<div class="form-group col-md-2">
				<input type="tel" class="form-control" id="emergency_contact_1" name="emergency_contact_1" placeholder=" " required>
				<label for="emergency_contact_1">Contact No 1 *</label>
			</div>
			<div class="form-group col-md-2">
				<input type="tel" class="form-control" id="emergency_contact_2" name="emergency_contact_2" placeholder=" ">
				<label for="emergency_contact_2">Contact No 2</label>
			</div>
			<div class="form-group col-md-2">
				<input type="tel" class="form-control" id="emergency_contact_3" name="emergency_contact_3" placeholder=" ">
				<label for="emergency_contact_3">Contact No 3</label>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addEmergencyContactBtn">Add Record</button>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Emergency Contact Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="emergencyContactRecordsTable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Relation</th>
						<th>Contact No 1</th>
						<th>Contact No 2</th>
						<th>Contact No 3</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- Emergency contact records will be added here -->
				</tbody>
			</table>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Emergency Data</button>
		<button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
