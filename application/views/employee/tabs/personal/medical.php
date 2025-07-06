<?php
// application/views/employee/tabs/personal/medical.php
// This view contains the form elements for "Medical" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$medical_data = $employee_data['medical_data'] ?? [];
?>

<form id="personalMedicalForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?= isset($medical_data[0]['employee_id']) ? encryptor('encrypt', $medical_data[0]['employee_id']) : ''; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Medical History</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="medical_checkup_date" name="medical_checkup_date" required>
				<label for="medical_checkup_date">Checkup Date *</label>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="medical_height" name="medical_height" placeholder=" " required>
				<label for="medical_height">Height *</label>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="medical_weight" name="medical_weight" placeholder=" " required>
				<label for="medical_weight">Weight *</label>
			</div>
			<div class="form-group col-md-2">
				 <select class="form-control" id="medical_disease" name="medical_disease" required>
					<option value="No">No</option>
					<option value="Yes">Yes</option>
				</select>
				<label for="medical_disease">Disease *</label>
			</div>
			 <div class="form-group col-md-2">
				<textarea class="form-control" id="medical_details" name="medical_details" placeholder=" " required></textarea>
				<label for="medical_details">Details *</label>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addMedicalRecordBtn">Add Record</button>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Medical Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="medicalRecordsTable">
				<thead>
					<tr>
						<th>Checkup Date</th>
						<th>Height</th>
						<th>Weight</th>
						<th>Disease</th>
						<th>Details</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- Medical records will be added here -->
				</tbody>
			</table>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Medical Data</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
