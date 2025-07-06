<?php
// application/views/employee/tabs/personal/nomination.php
// This view contains the form elements and dynamic table for "Nomination" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$nomination_records = isset($employee_data['nomination_records']) ? $employee_data['nomination_records'] : [];
$nomination_data = $employee_data['nomination_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<form id="personalNominationForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

	<h5>Add Nominee</h5>
	<div id="nomination-form-row" class="form-row">
		<div class="form-group col-md-2">
			<input type="text" class="form-control" id="nominee_name" name="nominee_name" required placeholder=" " />
			<label for="nominee_name">Nominee Name *</label>
			<div class="form-error" id="error_nominee_name"></div>
		</div>
		<div class="form-group col-md-2">
			<input type="text" class="form-control" id="nominee_relation" name="nominee_relation" required placeholder="e.g., Mother, Brother" />
			<label for="nominee_relation">Relation *</label>
			<div class="form-error" id="error_nominee_relation"></div>
		</div>
		<div class="form-group col-md-2">
			<input type="number" class="form-control" id="nominee_percentage" name="nominee_percentage" min="0" max="100" required placeholder="e.g., 100" />
			<label for="nominee_percentage">Percentage *</label>
			<div class="form-error" id="error_nominee_percentage"></div>
		</div>
		<div class="form-group col-md-2">
			<input type="text" class="form-control" id="nominee_address" name="nominee_address" placeholder=" " />
			<label for="nominee_address">Address</label>
			<div class="form-error" id="error_nominee_address"></div>
		</div>
		<div class="form-group col-md-2">
			<input type="text" class="form-control" id="nominee_contact" name="nominee_contact" placeholder="e.g., +91-9876543210" />
			<label for="nominee_contact">Contact</label>
			<div class="form-error" id="error_nominee_contact"></div>
		</div>
	</div>
	<button type="button" class="btn btn-info mb-2" id="addNomineeRecord">Add Nominee</button>
	<h5>Nominee Records</h5>
	<table class="table table-bordered" id="nomineeRecordsTable">
		<thead>
		<tr>
			<th>Name</th><th>Relation</th><th>Percentage</th><th>Contact</th><th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php if (!empty($nomination_records)): ?>
			<?php foreach ($nomination_records as $record): ?>
				<tr>
					<td><?php echo htmlspecialchars($record['nominee_name'] ?? ''); ?></td>
					<td><?php echo htmlspecialchars($record['nominee_relation'] ?? ''); ?></td>
					<td><?php echo htmlspecialchars($record['nominee_percentage'] ?? '') . '%'; ?></td>
					<td><?php echo htmlspecialchars($record['nominee_contact'] ?? ''); ?></td>
					<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Nomination Data</button>
	</div>
</form>
