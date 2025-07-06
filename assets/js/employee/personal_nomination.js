// assets/js/employee/personal_nomination.js
// This file handles the specific logic for the "Nomination" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalNominationForm = $('#personalNominationForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $nominationFormRow = $('#nomination-form-row');
	const $nomineeRecordsTableBody = $('#nomineeRecordsTable tbody');

	// Set the employee_id_hidden_field value on this form
	$personalNominationForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalNominationForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Add Nominee Record functionality
	$('#addNomineeRecord').on('click', function() {
		const requiredFields = ['nominee_name', 'nominee_relation', 'nominee_percentage'];

		const getRowHtml = function() {
			const name = $('#nominee_name').val();
			const relation = $('#nominee_relation').val();
			const percentage = $('#nominee_percentage').val();
			const contact = $('#nominee_contact').val();
			const address = $('#nominee_address').val(); // Capture address too

			return `
                <tr data-name="${name}" data-relation="${relation}" data-percentage="${percentage}"
                    data-contact="${contact}" data-address="${address}">
                    <td>${name}</td>
                    <td>${relation}</td>
                    <td>${percentage}%</td>
                    <td>${contact}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
		};
		FormUtils.handleAddDynamicRecord($nominationFormRow, $nomineeRecordsTableBody, requiredFields, getRowHtml);
	});

	$personalNominationForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalNominationForm.find('.form-error').text('');
		$personalNominationForm.find('.form-control').removeClass('is-invalid');

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate nomination data.');
			return;
		}

		const nomineeRecords = [];
		$nomineeRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			nomineeRecords.push({
				name: row.data('name'),
				relation: row.data('relation'),
				percentage: row.data('percentage'),
				contact: row.data('contact'),
				address: row.data('address') // Ensure this matches DB column if applicable
			});
		});

		const formData = new FormData();
		// formData.append('employee_id_hidden_field', employeeId);
		formData.append('nomineeRecordsJson', JSON.stringify(nomineeRecords));

		const $submitBtn = $personalNominationForm.find('button[type="submit"]');
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
				$submitBtn.prop('disabled', false).text('Save Nomination Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Saved!', response.message);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					console.error("Server-side errors for nomination data:", response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Nomination Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$nominationFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
