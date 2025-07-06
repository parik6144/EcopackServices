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

	// Add Family Record functionality
	$('#addFamilyMemberBtn').on('click', function() {
		const requiredFields = [
			'family_first_name', 'family_last_name', 'family_relation',
			'family_gender', 'family_dob', 'family_dependent'
		];

		// Clear previous errors
		requiredFields.forEach(function(field) {
			$('#error_' + field).text('');
			$('#' + field).removeClass('is-invalid');
		});
		$('#error_residing_with_employee').text('');
		$('input[name="residing_with_employee"]').removeClass('is-invalid');

		let isValid = true;

		// Validate required fields
		requiredFields.forEach(function(field) {
			const value = $('#' + field).val();
			if (!value || value.trim() === '') {
				$('#error_' + field).text('This field is required.');
				$('#' + field).addClass('is-invalid');
				isValid = false;
			}
		});

		// Validate residing_with_employee radio buttons
		if (!$('input[name="residing_with_employee"]:checked').val()) {
			$('#error_residing_with_employee').text('Please select an option.');
			$('input[name="residing_with_employee"]').addClass('is-invalid');
			isValid = false;
		}

		if (!isValid) {
			return;
		}

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

	$personalFamilyForm.on('submit', function(e) {
		e.preventDefault();

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
					FormUtils.showSwal('success', 'Saved!', response.message);
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

	// Initial check for 'filled' state for labels
	$familyFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
