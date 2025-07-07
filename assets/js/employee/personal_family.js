// assets/js/employee/personal_family.js
// This file handles the specific logic for the "Family" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalFamilyForm = $('#personalFamilyForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $familyFormRow = $('#family-form-row');
	const $familyRecordsTableBody = $('#familyRecordsTable tbody');

	// Set the employee_id_hidden_field value on this form
	$personalFamilyForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalFamilyForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// --- Enhanced Real-time Validation for Family Form ---
	function validateFamilyField(fieldId) {
		const $input = $('#' + fieldId);
		const value = $input.val();
		let isValid = true;
		let errorMsg = '';
		if (!value || value.trim() === '') {
			isValid = false;
			errorMsg = 'This field is required.';
		} else if (fieldId === 'family_email_id' && value) {
			// Simple email regex
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(value)) {
				isValid = false;
				errorMsg = 'Please enter a valid email.';
			}
		} else if (fieldId === 'family_contact_no' && value) {
			// Simple phone regex
			if (!/^\+?\d{6,15}$/.test(value)) {
				isValid = false;
				errorMsg = 'Please enter a valid contact number.';
			}
		}
		if (!isValid) {
			$input.addClass('is-invalid');
			$('#error_' + fieldId).text(errorMsg);
		} else {
			$input.removeClass('is-invalid');
			$('#error_' + fieldId).text('');
		}
		return isValid;
	}

	function validateResidingWithEmployee() {
		const $inputs = $('input[name="residing_with_employee"]');
		const checked = $inputs.filter(':checked').val();
		if (!checked) {
			$inputs.addClass('is-invalid');
			$('#error_residing_with_employee').text('Please select an option.');
			return false;
		} else {
			$inputs.removeClass('is-invalid');
			$('#error_residing_with_employee').text('');
			return true;
		}
	}

	// Real-time validation events
	$('#family-form-row').on('blur keyup change', 'input, select, textarea', function() {
		const id = $(this).attr('id');
		if (id) validateFamilyField(id);
	});
	$('input[name="residing_with_employee"]').on('change', validateResidingWithEmployee);

	// --- Enhanced Robust Client-Side Validation & Logging ---
	function logFormActivity(logData) {
		// Send log to backend for writing to file
		$.ajax({
			url: BASE_URL + 'employee/log_family_form_activity',
			type: 'POST',
			data: { log: JSON.stringify(logData) },
			dataType: 'json'
		});
	}

	function validateFamilyForm(showSwal = false) {
		const requiredFields = [
			'family_first_name', 'family_last_name', 'family_relation',
			'family_gender', 'family_dob', 'family_dependent'
		];
		let isValid = true;
		let errors = [];
		requiredFields.forEach(function(field) {
			if (!validateFamilyField(field)) {
				isValid = false;
				errors.push(field);
			}
		});
		if (!validateResidingWithEmployee()) {
			isValid = false;
			errors.push('residing_with_employee');
		}
		if (!isValid && showSwal) {
			FormUtils.showSwal('error', 'Please correct highlighted errors before submitting.', '');
		}
		return { isValid, errors };
	}

	// Live validation on input/blur
	$('#family-form-row').on('input blur change', 'input, select, textarea', function() {
		const id = $(this).attr('id');
		if (id) validateFamilyField(id);
	});
	$('input[name="residing_with_employee"]').on('change', validateResidingWithEmployee);

	// Prevent direct form submit without validation
	$personalFamilyForm.on('submit', function(e) {
		const logData = { time: new Date().toISOString(), event: 'Form Submission Started', fields: {}, errors: [] };
		$personalFamilyForm.find('input, select, textarea').each(function() {
			const id = $(this).attr('id');
			if (id) logData.fields[id] = $(this).val();
		});
		const validation = validateFamilyForm(true);
		if (!validation.isValid) {
			e.preventDefault();
			logData.errors = validation.errors;
			logData.result = 'Submission Blocked';
			logFormActivity(logData);
			return false;
		}
		logData.result = 'Submission Allowed';
		logFormActivity(logData);

		// Clear errors for this specific form
		$personalFamilyForm.find('.form-error').text('');
		$personalFamilyForm.find('.form-control').removeClass('is-invalid');

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate family data.');
			return;
		}

		const familyRecords = [];
		$familyRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			familyRecords.push({
				firstName: row.data('first-name'),
				middleName: row.data('middle-name'),
				lastName: row.data('last-name'),
				relation: row.data('relation'),
				gender: row.data('gender'),
				dob: row.data('dob'),
				contactNo: row.data('contact-no'),
				dependent: row.data('dependent'),
				residingWithEmployee: row.data('residing'),
				emailId: row.data('email-id'),
				address: row.data('address'),
				aadharNo: row.data('aadhar-no')
			});
		});

		const formData = new FormData();
		formData.append('familyRecordsJson', JSON.stringify(familyRecords));

		const $submitBtn = $personalFamilyForm.find('button[type="submit"]');
		$submitBtn.prop('disabled', true).text('Saving...');
		const formUrl = BASE_URL + 'employee/save_personal_data/' + employeeId;

		$.ajax({
			url: formUrl, // This endpoint handles all personal sub-tabs data
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				$submitBtn.prop('disabled', false).text('Save Family Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Success!', response.message, function() {
						// Optionally reset form/table after success
						$familyRecordsTableBody.empty();
						$personalFamilyForm[0].reset();
					});
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					console.error("Server-side errors for family data:", response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Family Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Add Family Record functionality
	$('#addFamilyMemberBtn').on('click', function() {
		const validation = validateFamilyForm(true);
		if (!validation.isValid) return;

		const requiredFields = [
			'family_first_name', 'family_last_name', 'family_relation',
			'family_gender', 'family_dob', 'family_dependent'
		];
		let isValid = true;
		requiredFields.forEach(function(field) {
			if (!validateFamilyField(field)) isValid = false;
		});
		if (!validateResidingWithEmployee()) isValid = false;
		if (!isValid) return;

		const getRowHtml = function() {
			const firstName = $('#family_first_name').val();
			const middleName = $('#family_middle_name').val();
			const lastName = $('#family_last_name').val();
			const relation = $('#family_relation').val();
			const gender = $('#family_gender').val();
			const dob = $('#family_dob').val();
			const contactNo = $('#family_contact_no').val();
			const dependent = $('#family_dependent').val();
			const residing = $('input[name="residing_with_employee"]:checked').val();
			const emailId = $('#family_email_id').val();
			const address = $('#family_address').val();
			const aadharNo = $('#family_aadhar_no').val();

			return `
                <tr data-first-name="${firstName}" data-middle-name="${middleName}" data-last-name="${lastName}"
                    data-relation="${relation}" data-gender="${gender}" data-dob="${dob}"
                    data-contact-no="${contactNo}" data-dependent="${dependent}"
                    data-residing="${residing}" data-email-id="${emailId}"
                    data-address="${address}" data-aadhar-no="${aadharNo}">
                    <td>${firstName} ${middleName} ${lastName}</td>
                    <td>${relation}</td>
                    <td>${gender}</td>
                    <td>${dob}</td>
                    <td>${contactNo}</td>
                    <td>${dependent}</td>
                    <td>${residing}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
		};
		FormUtils.handleAddDynamicRecord($familyFormRow, $familyRecordsTableBody, requiredFields, getRowHtml);
	});

	// Initial check for 'filled' state for labels
	$familyFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
