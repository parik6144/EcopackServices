// assets/js/employee/personal_attachments.js
// This file handles the specific logic for the "Attachments" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalAttachmentsForm = $('#personalAttachmentsForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $attachmentFile = $('#attachment_file');
	const $attachmentRecordsTableBody = $('#attachmentRecordsTable tbody');

	// Set the employee_id_hidden_field value on this form
	$personalAttachmentsForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalAttachmentsForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Add Attachment Record functionality
	$('#addAttachmentRecord').on('click', function() {
		let attachmentValid = true;
		const description = $('#attachment_description').val();
		const fileInput = $('#attachment_file')[0];
		let fileName = '';

		FormUtils.clearError('attachment_file');

		if (fileInput.files.length > 0) {
			fileName = fileInput.files[0].name;
		} else {
			FormUtils.showError('attachment_file', 'Please select a file.');
			attachmentValid = false;
		}

		if (!attachmentValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please select a file for attachment.');
			if (fileInput.files.length === 0) {
				fileInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
			}
			return;
		}

		const dateAdded = new Date().toLocaleDateString('en-CA'); // YYYY-MM-DD for consistency or any preferred format

		const newRow = `
            <tr data-description="${description}" data-file-name="${fileName}" data-date-added="${dateAdded}">
                <td>${dateAdded}</td>
                <td>${description}</td>
                <td>${fileName}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
            </tr>
        `;
		$attachmentRecordsTableBody.append(newRow);

		// Clear input fields for new entry
		$('#attachment_description').val('').removeClass('filled');
		$('#attachment_file').val(''); // Clear the file input
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft(); // Save draft after adding a row
	});

	$personalAttachmentsForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalAttachmentsForm.find('.form-error').text('');
		$personalAttachmentsForm.find('.form-control').removeClass('is-invalid');

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate attachment data.');
			return;
		}

		const attachmentRecords = [];
		$attachmentRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			attachmentRecords.push({
				description: row.data('description'),
				fileName: row.data('file-name'),
				date: row.data('date-added') // Make sure this matches backend expectation
			});
		});

		const formData = new FormData();
		formData.append('employee_id_hidden_field', employeeId);
		formData.append('attachmentRecordsJson', JSON.stringify(attachmentRecords));

		// Note: Actual file upload needs to be handled separately if you want files to persist.
		// For existing files, you'd list them and potentially add a separate upload field for new ones.
		// If files are part of this submission, you'd need to append them here.
		// Example for a single new file:
		// if ($attachmentFile[0].files.length > 0) {
		//     formData.append('new_attachment_file', $attachmentFile[0].files[0]);
		// }


		const $submitBtn = $personalAttachmentsForm.find('button[type="submit"]');
		$submitBtn.prop('disabled', true).text('Saving...');

		$.ajax({
			url: '<?= base_url("employee/save_personal_data"); ?>', // This endpoint handles all personal sub-tabs data
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				$submitBtn.prop('disabled', false).text('Save Attachments Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Saved!', response.message);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					console.error("Server-side errors for attachment data:", response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Attachments Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$personalAttachmentsForm.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
