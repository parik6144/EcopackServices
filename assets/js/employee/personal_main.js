// assets/js/employee/personal_main.js
// This file handles the specific logic for the "Main" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalMainForm = $('#personalMainForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');

	// Set the employee_id_hidden_field value on this form
	$personalMainForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalMainForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	$personalMainForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalMainForm.find('.form-error').text('');
		$personalMainForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		// Validate all required fields in the personal main form
		// Also validate email, mobile, and URL/PAN/Aadhar as per your common validation rules
		$personalMainForm.find('input[required], select[required], input[type="email"], input[type="url"], input[type="number"], #pan_no, #aadhar_no').each(function() {
			const $inputElement = $(this);
			if (!FormUtils.validateField($inputElement)) {
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		if (!formValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Personal Main tab.');
			if (firstInvalidFieldId) {
				setTimeout(() => {
					const $errorField = $('#' + firstInvalidFieldId);
					if ($errorField.length) {
						$errorField[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
					}
				}, 100);
			}
			return;
		}

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate personal main data.');
			return;
		}

		const formData = new FormData(this);

		const $submitBtn = $personalMainForm.find('button[type="submit"]');
		$submitBtn.prop('disabled', true).text('Saving...');
		const formUrl = BASE_URL + 'employee/save_personal_data/' + employeeId;

		$.ajax({
			url: formUrl,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				$submitBtn.prop('disabled', false).text('Save Personal Main Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Saved!', response.message);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					if (response.errors) {
						for (const fieldId in response.errors) {
							FormUtils.showError(fieldId, response.errors[fieldId]);
						}
					}
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Personal Main Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$personalMainForm.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
