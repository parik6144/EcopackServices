<?php
// application/views/employee/tabs/personal/attachments.php
// This view contains the form elements and dynamic table for "Attachments" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$attachments_data = $employee_data['attachments_data'] ?? [];
$attachment_types = [
	'Resume', 'PAN', 'Aadhaar', 'Passport', 'Driving License', 'Voter ID', 
	'10th Marksheet', '12th Marksheet', 'Graduation Certificate', 'Post Graduation Certificate',
	'Offer Letter', 'Relieving Letter', 'Payslips', 'Bank Statement', 'Photo'
];
?>

<form id="personalAttachmentsForm" data-tab-form="true" novalidate>
<form id="personalAttachmentsForm" data-tab-form="true">
	<input type="hidden" name="employee_id_hidden_field" value="">

	<h5>Add Attachment</h5>
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="text" class="form-control" id="attachment_description" name="attachment_description" placeholder="e.g., Resume, ID Proof" />
			<label for="attachment_description">Description</label>
			<div class="form-error" id="error_attachment_description"></div>
		</div>
		<div class="form-group col-md-4">
			<input type="file" class="form-control" id="attachment_file" name="attachment_file" />
			<label for="attachment_file">File</label>
			<div class="form-error" id="error_attachment_file"></div>
		</div>
	</div>
	<button type="button" class="btn btn-info mb-2" id="addAttachmentRecord">Add Attachment</button>
	<h5>Attachments</h5>
	<table class="table table-bordered" id="attachmentRecordsTable">
		<thead>
		<tr>
			<th>Date</th><th>Description</th><th>File Name</th><th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php if (!empty($attachment_records)): ?>
			<?php foreach ($attachment_records as $record): ?>
				<tr>
					<td><?= htmlspecialchars($record['upload_date'] ?? ''); ?></td>
					<td><?= htmlspecialchars($record['description'] ?? ''); ?></td>
					<td><?= htmlspecialchars($record['file_name'] ?? ''); ?></td>
					<td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Attachments</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
