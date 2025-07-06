// assets/js/employee/personal_emergency.js
// This file handles the specific logic for the "Emergency" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalEmergencyForm = $('#personalEmergencyForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $emergencyFormRow = $('#emergency-form-row');
	const $emergencyRecordsTableBody = $('#emergencyRecordsTable tbody');

	// Set the employee_id_hidden_field value on this form
	$personalEmergencyForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalEmergencyForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Add Emergency Record functionality
	$('#addEmergencyRecord').on('click', function() {
		const requiredFields = ['emergency_name', 'emergency_relation', 'emergency_contact1'];

		const getRowHtml = function() {
			const name = $('#emergency_name').val();
			const relation = $('#emergency_relation').val();
			const contact1 = $('#emergency_contact1').val();
			const contact2 = $('#emergency_contact2').val();
			const contact3 = $('#emergency_contact3').val();

			return `
                <tr data-name="${name}" data-relation="${relation}" data-contact1="${contact1}"
                    data-contact2="${contact2}" data-contact3="${contact3}">
                    <td>${name}</td>
                    <td>${relation}</td>
                    <td>${contact1}</td>
                    <td>${contact2}</td>
                    <td>${contact3}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
		};
		FormUtils.handleAddDynamicRecord($emergencyFormRow, $emergencyRecordsTableBody, requiredFields, getRowHtml);
	});

	$personalEmergencyForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalEmergencyForm.find('.form-error').text('');
		$personalEmergencyForm.find('.form-control').removeClass('is-invalid');

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate emergency data.');
			return;
		}

		const emergencyRecords = [];
		$emergencyRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			emergencyRecords.push({
				name: row.data('name'),
				relation: row.data('relation'),
				contact1: row.data('contact1'),
				contact2: row.data('contact2'),
				contact3: row.data('contact3')
			});
		});

		const formData = new FormData();
		// formData.append('employee_id_hidden_field', employeeId);
		formData.append('emergencyRecordsJson', JSON.stringify(emergencyRecords));

		const $submitBtn = $personalEmergencyForm.find('button[type="submit"]');
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
				$submitBtn.prop('disabled', false).text('Save Emergency Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Saved!', response.message);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					console.error("Server-side errors for emergency data:", response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Emergency Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$emergencyFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
