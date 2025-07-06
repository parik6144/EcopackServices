// assets/js/employee/payment.js
// This file handles the specific logic for the Payment tab.

$(document).ready(function() {
	const $paymentForm = $('#paymentForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');

	// Set the employee_id_hidden_field value on this form
	// This ensures that when the tab is loaded, its hidden field gets the current employee ID
	$paymentForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$paymentForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	$paymentForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$paymentForm.find('.form-error').text('');
		$paymentForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		// Validate all fields in the payment form
		$paymentForm.find('input[required], select[required], input[type="number"]').each(function() {
			const $inputElement = $(this);
			if (!FormUtils.validateField($inputElement)) {
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		if (!formValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Payment tab.');
			if (firstInvalidFieldId) {
				// Scroll to the first invalid field
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
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate payment data.');
			return;
		}

		const formData = new FormData(this);
		formData.append('employee_id_hidden_field', employeeId);

		const $submitBtn = $paymentForm.find('button[type="submit"]');
		$submitBtn.prop('disabled', true).text('Saving...');

		$.ajax({
			url: '<?= base_url("employee/save_payment_data"); ?>', // Your CodeIgniter controller method
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function(response) {
				$submitBtn.prop('disabled', false).text('Save Payment Data');
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
				$submitBtn.prop('disabled', false).text('Save Payment Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$paymentForm.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
