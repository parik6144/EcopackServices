// assets/js/employee/personal_medical.js
// This file handles the specific logic for the "Medical" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalMedicalForm = $('#personalMedicalForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');

	// Set the employee_id_hidden_field value on this form
	$personalMedicalForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalMedicalForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	$personalMedicalForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalMedicalForm.find('.form-error').text('');
		$personalMedicalForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		// Validate all fields in the medical form (add required fields if necessary)
		$personalMedicalForm.find('input[required], select[required]').each(function() {
			const $inputElement = $(this);
			if (!FormUtils.validateField($inputElement)) {
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		if (!formValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Medical tab.');
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
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate medical data.');
			return;
		}

		const formData = new FormData(this);
		formData.append('employee_id_hidden_field', employeeId);

		const $submitBtn = $personalMedicalForm.find('button[type="submit"]');
		$submitBtn.prop('disabled', true).text('Saving...');

		$.ajax({
			url: '<?= base_url("employee/save_personal_data"); ?>', // This endpoint handles all personal sub-tabs data
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				$submitBtn.prop('disabled', false).text('Save Medical Data');
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
				$submitBtn.prop('disabled', false).text('Save Medical Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$personalMedicalForm.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
