// assets/js/employee/personal_address.js
// This file handles the specific logic for the "Address" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalAddressForm = $('#personalAddressForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');

	// Set the employee_id_hidden_field value on this form
	$personalAddressForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalAddressForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Logic for "Permanent Address same as Current Address" checkbox
	$('#sameAsCurrent').on('change', function() {
		const permanentFields = [
			'permanent_house_no', 'permanent_street_no', 'permanent_block_no',
			'permanent_period_from', 'permanent_period_to', 'permanent_street',
			'permanent_landmark', 'permanent_post_office', 'permanent_police_station',
			'permanent_zip_code', 'permanent_city', 'permanent_country', 'permanent_state'
		];

		if ($(this).is(':checked')) {
			permanentFields.forEach(function(field) {
				const currentFieldId = field.replace('permanent_', 'current_');
				const $currentField = $('#' + currentFieldId);
				const $permanentField = $('#' + field);
				$permanentField.val($currentField.val());
				$permanentField.addClass('filled'); // Add filled class for copied values
				FormUtils.clearError(field); // Clear any error if copied value is valid
			});
		} else {
			permanentFields.forEach(function(field) {
				$('#' + field).val('').removeClass('filled');
				FormUtils.clearError(field); // Clear error when clearing field
			});
		}
		FormUtils.updateProfileProgress(); // Update progress bar after copying
		FormUtils.saveDraft(); // Save draft after copying
	});

	// On load, if permanent fields are already filled and match current, check the box.
	// This is for cases where draft is loaded or data is fetched from DB.
	// This should run after loadDraft in employee_form.js has populated fields.
	setTimeout(function() {
		const permanentFields = [
			'permanent_house_no', 'permanent_street_no', 'permanent_block_no',
			'permanent_period_from', 'permanent_period_to', 'permanent_street',
			'permanent_landmark', 'permanent_post_office', 'permanent_police_station',
			'permanent_zip_code', 'permanent_city', 'permanent_country', 'permanent_state'
		];
		let allMatched = true;
		for (let i = 0; i < permanentFields.length; i++) {
			const permanentFieldId = permanentFields[i];
			const currentFieldId = permanentFieldId.replace('permanent_', 'current_');
			if ($('#' + permanentFieldId).val() !== $('#' + currentFieldId).val()) {
				allMatched = false;
				break;
			}
		}
		if (allMatched && permanentFields.every(fieldId => $('#' + fieldId).val() !== '')) {
			$('#sameAsCurrent').prop('checked', true);
		} else {
			$('#sameAsCurrent').prop('checked', false);
		}
	}, 200); // Small delay to ensure draft is loaded

	$personalAddressForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalAddressForm.find('.form-error').text('');
		$personalAddressForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		// Validate all required fields in the address form (permanent_country, permanent_state)
		$personalAddressForm.find('input[required], select[required]').each(function() {
			const $inputElement = $(this);
			if (!FormUtils.validateField($inputElement)) {
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		if (!formValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Address tab.');
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
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate address data.');
			return;
		}

		const formData = new FormData(this);
		// formData.append('employee_id_hidden_field', employeeId);

		const $submitBtn = $personalAddressForm.find('button[type="submit"]');
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
				$submitBtn.prop('disabled', false).text('Save Address Data');
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
				$submitBtn.prop('disabled', false).text('Save Address Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$personalAddressForm.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
