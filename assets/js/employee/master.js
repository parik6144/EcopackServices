// assets/js/employee/master.js
// This file handles the specific logic for the Master tab.
console.log('master.js loaded and executing.'); // Added for debugging

$(document).ready(function() {
	console.log('master.js: Document ready.'); // Added for debugging
	const $masterForm = $('#masterForm');
	const $employeeIdHiddenField = $('#employee_id_hidden_field'); // Global hidden field
	const $masterEmployeeIdHiddenField = $('#master_employee_id_hidden_field'); // Tab-specific hidden field (kept for consistency)
	const $oldPhotoFilenameHidden = $('#master_old_photo_filename_hidden');
	const photoInput = $('#photo'); // Still needed for submission logic
	const photoPreviewImg = $('#photoPreview'); // Still needed for submission logic

	// --- Initial Photo Display State ---
	// This runs on document.ready to set the initial visibility of photo elements
	const photoDropArea = $('#photoDropArea'); // Need to define this here too
	const photoPreviewContainer = $('#photoPreviewContainer'); // Need to define this here too

	console.log('master.js: Initial photo display check. Current src:', photoPreviewImg.attr('src'));
	if (photoPreviewImg.attr('src') && photoPreviewImg.attr('src') !== '#') {
		photoDropArea.hide();
		photoPreviewContainer.show();
	} else {
		photoDropArea.show();
		photoPreviewContainer.hide();
	}


	// --- Dynamic Data Fetching (Employment Types, Designations, Employee Code) ---

	// Fetch Employment Types and populate dropdown
	console.log('master.js: Fetching employment types.');
	$.ajax({
		url: BASE_URL + "employee/get_employment_types",
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('master.js: Employment types fetched:', response);
			let options = '<option value="">Select Employment Type *</option>';
			response.forEach(function(type) {
				options += `<option value="${type.employee_type_id}">${type.type_name}</option>`;
			});
			$('#employment_type').html(options);

			const initialEmploymentType = $('#employment_type').data('current-value');
			if (initialEmploymentType) {
				console.log('master.js: Setting initial employment type:', initialEmploymentType);
				$('#employment_type').val(initialEmploymentType).trigger('change');
			}
		},
		error: function(xhr, status, error) {
			console.error("master.js: Error fetching employment types:", error);
			FormUtils.showGlobalAlert('danger', 'Error loading employment types. Please refresh.');
		}
	});

	// On Employment Type change, fetch Designations
	$('#employment_type').on('change', function() {
		let employeeTypeId = $(this).val();
		console.log('master.js: Employment type changed to:', employeeTypeId);
		$('#designation').html('<option value="">Select Designation *</option>').trigger('change');
		if(employeeTypeId) {
			$.ajax({
				url: BASE_URL + "employee/get_designations",
				type: 'GET',
				data: { employee_type_id: employeeTypeId },
				dataType: 'json',
				success: function(response) {
					console.log('master.js: Designations fetched:', response);
					let options = '<option value="">Select Designation *</option>';
					response.forEach(function(designation) {
						options += `<option value="${designation.designation_id}">${designation.designation_name}</option>`;
					});
					$('#designation').html(options);

					const initialDesignation = $('#designation').data('current-value');
					if (initialDesignation) {
						console.log('master.js: Setting initial designation:', initialDesignation);
						$('#designation').val(initialDesignation).trigger('change');
						$('#designation').removeData('current-value');
					}
				},
				error: function(xhr, status, error) {
					console.error("master.js: Error fetching designations:", error);
					FormUtils.showGlobalAlert('danger', 'Error loading designations.');
				}
			});
		}
	});

	// Fetch Posting Cities and populate dropdown
	console.log('master.js: Fetching posting cities.');
	$.ajax({
		url: BASE_URL + "employee/get_places",
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('master.js: Posting cities fetched:', response);
			let options = '<option value="">Select Posting City *</option>';
			response.forEach(function(place) {
				options += `<option value="${place.place_id}" data-state="${place['state_code'] ?? ''}">${place.place_name}</option>`;
			});
			$('#posting_city').html(options);

			const initialPostingCity = $('#posting_city').data('current-value');
			if (initialPostingCity) {
				console.log('master.js: Setting initial posting city:', initialPostingCity);
				$('#posting_city').val(initialPostingCity).trigger('change');
			}
		},
		error: function(xhr, status, error) {
			console.error("master.js: Error fetching posting cities:", error);
			FormUtils.showGlobalAlert('danger', 'Error loading posting cities.');
		}
	});

	// On Posting City change, generate Employee Code
	$('#posting_city').on('change', function() {
		var state_code = $(this).find(':selected').data('state');
		console.log('master.js: Posting city changed. State code:', state_code);

		// Only auto-generate for NEW employee (when $employeeIdHiddenField is empty)
		if (state_code && !$employeeIdHiddenField.val()) {
			console.log('master.js: Attempting to generate new employee code.');
			$.ajax({
				url: BASE_URL + "employee/get_next_employee_code",
				type: 'POST',
				data: { state_code: state_code },
				dataType: 'json',
				success: function(response) {
					console.log('master.js: Employee code generated:', response.employee_code);
					$('#employee_code').val(response.employee_code).addClass('filled').prop('readonly', true);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				},
				error: function(xhr, status, error) {
					console.error("master.js: Error generating employee code:", status, error, xhr.responseText);
					FormUtils.showGlobalAlert('danger', 'Error generating employee code.');
					$('#employee_code').val('').removeClass('filled').prop('readonly', false);
				}
			});
		} else if (!$employeeIdHiddenField.val()) { // If state_code is empty and it's a new employee
			console.log('master.js: Clearing employee code (new employee, no state code).');
			$('#employee_code').val('').removeClass('filled').prop('readonly', false);
			FormUtils.saveDraft();
			FormUtils.updateProfileProgress();
		}
	});

	// For existing employees, if employee_code is present on load, make it readonly
	console.log('master.js: Initial employee_code check. Value:', $('#employee_code').val(), 'Employee ID:', $employeeIdHiddenField.val());
	if ($employeeIdHiddenField.val()) { // If an employee ID is present (existing employee)
		console.log('master.js: Employee ID present, setting employee_code to readonly.');
		$('#employee_code').prop('readonly', true);
	} else { // It's a new employee
		console.log('master.js: Employee ID NOT present, setting employee_code to editable.');
		$('#employee_code').prop('readonly', false);
		// Also, if it's a new employee, clear employee code on load if for some reason it has a value
		if ($('#employee_code').val()) {
			$('#employee_code').val('');
		}
	}

	// --- Photo Upload Logic: REMOVED FROM HERE. IT IS NOW HANDLED SOLELY IN employee_form.js ---
	// The photo related event listeners and handlers for drag/drop/change are now central in employee_form.js
	// Only the initial display logic and references for form submission remain.


	// --- Master Form Reset Function (This one is triggered by #resetMasterForm) ---
	function resetMasterFormFields() {
		console.log('master.js: resetMasterFormFields called.');

		// AJAX call to clear the server-side session
		$.ajax({
			url: BASE_URL + 'employee/clear_employee_session',
			type: 'POST',
			dataType: 'json',
			success: function(response) {
				console.log('master.js: Server session cleared.', response);
			},
			error: function(xhr) {
				console.error('master.js: Failed to clear server session.', xhr.responseText);
			}
		});

		// Manually reset all fields in the Master form to their default state
		$masterForm.find('input[type="text"], input[type="email"], textarea').val('');
		$masterForm.find('select').prop('selectedIndex', 0).removeClass('filled');
		$masterForm.find('input').removeClass('filled');

		// Specifically handle the photo preview
		FormUtils.resetPhotoDisplay();
		$oldPhotoFilenameHidden.val(''); // Clear old photo filename on reset

		// Clear validation errors specific to Master form
		$masterForm.find('.form-error').text('');
		$masterForm.find('.is-invalid').removeClass('is-invalid');

		// After clearing dropdowns, trigger change to reset dependent fields
		console.log('master.js: Triggering employment_type change after reset.');
		$('#employment_type').val('').trigger('change');
		console.log('master.js: Triggering posting_city change after reset.');
		$('#posting_city').val('').trigger('change');

		if (!$employeeIdHiddenField.val()) {
			console.log('master.js: Clearing employee_code for new employee on master reset.');
			$('#employee_code').val('').removeClass('filled').prop('readonly', false);
		} else {
			console.log('master.js: Retaining employee_code for existing employee on master reset.');
		}

		if (!$employeeIdHiddenField.val()) {
			$masterEmployeeIdHiddenField.val('');
		}

		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	}

	// --- Form Reset for Master Tab (This is the correct one with Swal Alert) ---
	$masterForm.on('click', '#resetMasterForm', function() {
		console.log('master.js: #resetMasterForm button clicked.');
		Swal.fire({
			title: 'Are you sure?',
			text: "This will clear all unsaved changes in this Master tab!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, reset it!'
		}).then((result) => {
			if (result.isConfirmed) {
				resetMasterFormFields(); // Call the defined function to reset master fields
				FormUtils.showSwal('success', 'Reset!', 'The Master form fields have been cleared.');
			}
		});
	});


	// --- Master Form Submission ---
	$masterForm.on('submit', function(e) {
		e.preventDefault();
		e.stopPropagation();
		console.log('master.js: Master form submission initiated.');

		$masterForm.find('.form-error').text('');
		$masterForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		$masterForm.find('input[required]:not([readonly]), select[required]').each(function() {
			const $inputElement = $(this);
			if (!FormUtils.validateField($inputElement)) {
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		// Photo validation (if photo input has 'required' attribute)
		// Check if the HTML input for photo has 'required' attribute.
		// If the photo is not actually required for existing records, make sure 'required' is removed in PHP.
		const currentPhotoSrc = photoPreviewImg.attr('src');
		// Determine if there's an actual image displayed (not a placeholder '#' or a default 'profile_small.jpg' if it's used as placeholder)
		const hasMeaningfulDisplayedPhoto = (currentPhotoSrc && currentPhotoSrc !== '#' && !currentPhotoSrc.includes('profile_small.jpg'));
		// Check if the hidden field contains a filename from the database
		const hasOldPhotoFilename = $oldPhotoFilenameHidden.val() && $oldPhotoFilenameHidden.val() !== '';

		if (photoInput.prop('required')) { // If the HTML input has the 'required' attribute
			// The photo is considered "present" if either a new file is selected OR an old photo filename exists.
			if (!photoInput[0].files.length && !hasOldPhotoFilename) { // If no new file AND no old file exists
				formValid = false;
				FormUtils.showError('photo', 'Employee photo is required.');
				if (!firstInvalidFieldId) firstInvalidFieldId = 'photo';
			}
		}


		if (!formValid) {
			console.log('master.js: Master form validation failed. First invalid field:', firstInvalidFieldId);
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Master tab.');
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

		const formData = new FormData(this);
		formData.append('employee_id_hidden_field', $employeeIdHiddenField.val());

		if (photoInput[0].files.length > 0) {
			console.log('master.js: Appending new photo to formData.');
			formData.append('photo', photoInput[0].files[0]);
		} else if ($oldPhotoFilenameHidden.val() === '') {
			console.log('master.js: Photo explicitly removed, adding photo_clear_flag.');
			formData.append('photo_clear_flag', 'true');
		}

		$.ajax({
			url: BASE_URL + 'employee/save_master_data',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			beforeSend: function() {
				console.log('master.js: Showing saving Swal.');
				Swal.fire({
					title: 'Saving...',
					text: 'Please wait while we save the employee data.',
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
					}
				});
			},
			success: function(response) {
				console.log('master.js: Save master data success response:', response);
				if (response.status === 'success') {
					const isNewEmployee = !$employeeIdHiddenField.val();

					// After a successful save, update the hidden fields immediately
					if (response.employee_id_encoded) {
						$employeeIdHiddenField.val(response.employee_id_encoded);
						$masterEmployeeIdHiddenField.val(response.employee_id_encoded);
					}
					if (response.new_photo_filename !== undefined) {
						$oldPhotoFilenameHidden.val(response.new_photo_filename || '');
					}

					// Now, decide whether to reload or just show a message
					if (isNewEmployee && response.employee_id_encoded) {
						// This was a new employee, reload to the edit page for a seamless workflow
						FormUtils.showSwal('success', 'Created!', 'Employee created successfully. Loading full profile...', () => {
							window.location.href = BASE_URL + 'employee/add/' + response.employee_id_encoded;
						});
					} else {
						// This was an update for an existing employee
						FormUtils.showSwal('success', 'Success!', response.message);
						FormUtils.saveDraft(); // Save the updated state
						$(document).trigger('employeeSaved'); // Trigger event for other components
					}

					if ($('#employeeModal').length) {
						console.log('master.js: Closing employee modal.');
						$('#employeeModal').modal('hide');
					}
				} else {
					if (response.errors) {
						let errorMessages = 'Please correct the following errors:<br><ul>';
						$.each(response.errors, function(key, value) {
							console.error(`master.js: Server validation error for ${key}: ${value}`);
							$('#error_' + key).text(value);
							$('#' + key).addClass('is-invalid');
							errorMessages += `<li>${value}</li>`;
						});
						errorMessages += '</ul>';
						FormUtils.showSwal('error', 'Validation Error', errorMessages);
					} else {
						console.error('master.js: Server error:', response.message || 'An unknown error occurred.');
						FormUtils.showSwal('error', 'Error!', response.message || 'An unknown error occurred.');
					}
				}
			},
			error: function(xhr, status, error) {
				console.error("master.js: AJAX Request Failed:", xhr.responseText);
				FormUtils.showSwal('error', 'Request Failed', 'An error occurred during submission. Please check your internet connection and try again. ' + xhr.responseText);
			},
			complete: function() {
				console.log('master.js: AJAX request complete.');
			}
		});
	});

	// Manually trigger initial change for employment_type and posting_city
	setTimeout(function() {
		console.log('master.js: Triggering initial changes for selects after small delay.');
		const initialEmploymentType = $('#employment_type').data('current-value');
		if (initialEmploymentType) {
			$('#employment_type').val(initialEmploymentType).trigger('change');
		}
		const initialPostingCity = $('#posting_city').data('current-value');
		if (initialPostingCity) {
			$('#posting_city').val(initialPostingCity).trigger('change');
		}
	}, 150);

})(jQuery);
