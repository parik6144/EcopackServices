// assets/js/employee/personal_academic.js
// This file handles the specific logic for the "Academic" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalAcademicForm = $('#personalAcademicForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $academicFormRow = $('#academic-form-row');
	const $academicRecordsTableBody = $('#academicRecordsTable tbody');
	let editRowIndex = null;

	// --- Always set the hidden employee_id in the academic form from the global hidden field (strict like address tab) ---
	function syncAcademicEmployeeId() {
		const globalId = $globalEmployeeIdHiddenField.val();
		$personalAcademicForm.find('input[name="employee_id_hidden_field"]').val(globalId);
	}
	syncAcademicEmployeeId();

	// Also resync on tab shown (in case master is saved after tab load)
	$('a[data-toggle="tab"][href="#personal-academic"]').on('shown.bs.tab', function() {
		syncAcademicEmployeeId();
	});

	// Event listener for input/change to update progress and save draft
	$personalAcademicForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		// Note: For dynamic tables, saveDraft is also triggered by add/remove row buttons.
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Add Academic Record functionality
	$('#addEducationBtn').on('click', function() {
		const requiredFields = [
			'academic_from_year', 'academic_to_year', 'academic_examination',
			'academic_institute', 'academic_subject', 'academic_grade', 'academic_university'
		];

		const getRowHtml = function() {
			const fromYear = $('#academic_from_year').val();
			const toYear = $('#academic_to_year').val();
			const examination = $('#academic_examination').val();
			const certificationType = $('#academic_cert_type').val();
			const certification = $('#academic_certification').val();
			const institute = $('#academic_institute').val();
			const program = $('#academic_program').val();
			const subject = $('#academic_subject').val();
			const registrationNo = $('#academic_registration_no').val();
			const rollNo = $('#academic_roll_no').val();
			const grade = $('#academic_grade').val();
			const university = $('#academic_university').val();
			const universityCountry = $('#academic_university_country').val();
			const universityState = $('#academic_university_state').val();
			const universityCity = $('#academic_university_city').val();
			const educatedInOverseas = $('#academic_educated_in_overseas').val();
			const collegeContactNo = $('#academic_college_contact_no').val();
			const collegeAddress = $('#academic_college_address').val();

			return `
                <tr data-from-year="${fromYear}" data-to-year="${toYear}" data-examination="${examination}"
                    data-certification-type="${certificationType}" data-certification="${certification}"
                    data-institute="${institute}" data-program="${program}" data-subject="${subject}"
                    data-registration-no="${registrationNo}" data-roll-no="${rollNo}" data-grade="${grade}"
                    data-university="${university}" data-university-country="${universityCountry}"
                    data-university-state="${universityState}" data-university-city="${universityCity}"
                    data-educated-in-overseas="${educatedInOverseas}" data-college-contact-no="${collegeContactNo}"
                    data-college-address="${collegeAddress}">
                    <td>${fromYear}</td>
                    <td>${toYear}</td>
                    <td>${examination}</td>
                    <td>${certificationType}</td>
                    <td>${certification}</td>
                    <td>${institute}</td>
                    <td>${program}</td>
                    <td>${subject}</td>
                    <td>${registrationNo}</td>
                    <td>${rollNo}</td>
                    <td>${grade}</td>
                    <td>${university}</td>
                    <td>${universityCountry}</td>
                    <td>${universityState}</td>
                    <td>${universityCity}</td>
                    <td>${educatedInOverseas}</td>
                    <td><button type="button" class="btn btn-info btn-sm edit-row">Edit</button> <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
		};
		FormUtils.handleAddDynamicRecord($academicFormRow, $academicRecordsTableBody, requiredFields, getRowHtml);
	});

	// Remove row with SweetAlert confirmation
	$('#academicRecordsTable').on('click', '.remove-row', function() {
		const $row = $(this).closest('tr');
		Swal.fire({
			title: 'Are you sure?',
			text: 'This will delete the entire row. You will have to re-enter the details if needed.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				$row.remove();
				FormUtils.saveDraft();
				FormUtils.updateProfileProgress();
			}
		});
	});

	// Edit row functionality
	$('#academicRecordsTable').on('click', '.edit-row', function() {
		const $row = $(this).closest('tr');
		editRowIndex = $row.index();
		// Populate form fields from row data attributes
		$('#academic_from_year').val($row.data('from-year'));
		$('#academic_to_year').val($row.data('to-year'));
		$('#academic_examination').val($row.data('examination'));
		$('#academic_cert_type').val($row.data('certification-type'));
		$('#academic_certification').val($row.data('certification'));
		$('#academic_institute').val($row.data('institute'));
		$('#academic_college_contact_no').val($row.data('college-contact-no'));
		$('#academic_college_address').val($row.data('college-address'));
		$('#academic_program').val($row.data('program'));
		$('#academic_subject').val($row.data('subject'));
		$('#academic_registration_no').val($row.data('registration-no'));
		$('#academic_roll_no').val($row.data('roll-no'));
		$('#academic_grade').val($row.data('grade'));
		$('#academic_university').val($row.data('university'));
		$('#academic_university_country').val($row.data('university-country'));
		$('#academic_university_state').val($row.data('university-state'));
		$('#academic_university_city').val($row.data('university-city'));
		$('#academic_educated_in_overseas').val($row.data('educated-in-overseas'));
		// Switch Add to Update
		$('#addEducationBtn').hide();
		if ($('#updateEducationBtn').length === 0) {
			$('<button type="button" class="btn btn-success" id="updateEducationBtn">Update Record</button>')
				.insertAfter('#addEducationBtn');
		}
	});

	// Update row functionality with SweetAlert confirmation
	$('#personalAcademicForm').on('click', '#updateEducationBtn', function() {
		if (editRowIndex !== null) {
			Swal.fire({
				title: 'Are you sure?',
				text: 'This will update the selected record with the new values.',
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: 'Yes, update it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {
					const $rows = $('#academicRecordsTable tbody tr');
					const $row = $rows.eq(editRowIndex);
					// Update data attributes
					$row.data('from-year', $('#academic_from_year').val());
					$row.data('to-year', $('#academic_to_year').val());
					$row.data('examination', $('#academic_examination').val());
					$row.data('certification-type', $('#academic_cert_type').val());
					$row.data('certification', $('#academic_certification').val());
					$row.data('institute', $('#academic_institute').val());
					$row.data('college-contact-no', $('#academic_college_contact_no').val());
					$row.data('college-address', $('#academic_college_address').val());
					$row.data('program', $('#academic_program').val());
					$row.data('subject', $('#academic_subject').val());
					$row.data('registration-no', $('#academic_registration_no').val());
					$row.data('roll-no', $('#academic_roll_no').val());
					$row.data('grade', $('#academic_grade').val());
					$row.data('university', $('#academic_university').val());
					$row.data('university-country', $('#academic_university_country').val());
					$row.data('university-state', $('#academic_university_state').val());
					$row.data('university-city', $('#academic_university_city').val());
					$row.data('educated-in-overseas', $('#academic_educated_in_overseas').val());
					// Update visible table cells
					$row.find('td').eq(0).text($('#academic_from_year').val());
					$row.find('td').eq(1).text($('#academic_to_year').val());
					$row.find('td').eq(2).text($('#academic_examination').val());
					$row.find('td').eq(3).text($('#academic_cert_type').val());
					$row.find('td').eq(4).text($('#academic_certification').val());
					$row.find('td').eq(5).text($('#academic_institute').val());
					$row.find('td').eq(6).text($('#academic_program').val());
					$row.find('td').eq(7).text($('#academic_subject').val());
					$row.find('td').eq(8).text($('#academic_registration_no').val());
					$row.find('td').eq(9).text($('#academic_roll_no').val());
					$row.find('td').eq(10).text($('#academic_grade').val());
					$row.find('td').eq(11).text($('#academic_university').val());
					$row.find('td').eq(12).text($('#academic_university_country').val());
					$row.find('td').eq(13).text($('#academic_university_state').val());
					$row.find('td').eq(14).text($('#academic_university_city').val());
					$row.find('td').eq(15).text($('#academic_educated_in_overseas').val());
					// Reset form and buttons
					$('#personalAcademicForm')[0].reset();
					$('#updateEducationBtn').remove();
					$('#addEducationBtn').show();
					editRowIndex = null;
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
					Swal.fire('Updated!', 'The record has been updated.', 'success');
				}
			});
		}
	});

	// --- Academic Tab Validation Function ---
	function validateAcademicForm() {
		let valid = true;
		// Clear previous errors
		$('#personalAcademicForm .form-error').text('');
		$('#personalAcademicForm .form-control').removeClass('is-invalid');

		// 1. Check employee_id_hidden_field strictly (like address tab)
		const empId = $personalAcademicForm.find('input[name="employee_id_hidden_field"]').val();
		if (!empId || empId.trim() === '') {
			FormUtils.showSwal('error', 'Validation Error', 'Employee ID is missing. Please save Master tab first.');
			valid = false;
		}

		// Required fields for adding a record (Education section)
		const requiredFields = [
			{ id: '#academic_from_year', error: '#error_academic_from_year', label: 'From Year' },
			{ id: '#academic_to_year', error: '#error_academic_to_year', label: 'To Year' },
			{ id: '#academic_examination', error: '#error_academic_examination', label: 'Examination' },
			{ id: '#academic_cert_type', error: '#error_academic_cert_type', label: 'Type of Certification' },
			{ id: '#academic_institute', error: '#error_academic_institute', label: 'Institute' },
			{ id: '#academic_program', error: '#error_academic_program', label: 'Program' },
			{ id: '#academic_subject', error: '#error_academic_subject', label: 'Subject' },
			{ id: '#academic_university', error: '#error_academic_university', label: 'University' }
		];

		requiredFields.forEach(function(field) {
			const value = $(field.id).val();
			if (!value || value.trim() === '' || value === '') {
				$(field.error).text(field.label + ' is required');
				$(field.id).addClass('is-invalid');
				valid = false;
			}
		});

		// Only allow 4-digit years
		['#academic_from_year', '#academic_to_year'].forEach(function(id) {
			const val = $(id).val();
			if (val && !/^\d{4}$/.test(val)) {
				$(id).addClass('is-invalid');
				$(id.replace('#academic', '#error_academic')).text('Enter a valid 4-digit year');
				valid = false;
			}
		});

		// At least one academic record should be present in the table before submit
		if ($('#academicRecordsTable tbody tr').length === 0) {
			FormUtils.showSwal('error', 'Validation Error', 'Please add at least one academic record before saving.');
			valid = false;
		}

		return valid;
	}

	$personalAcademicForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalAcademicForm.find('.form-error').text('');
		$personalAcademicForm.find('.form-control').removeClass('is-invalid');

		let formValid = true;
		let firstInvalidFieldId = null;

		// Validate all required fields in the academic form (like address tab)
		$personalAcademicForm.find('input[required], select[required]').each(function() {
			const $inputElement = $(this);
			if (!$inputElement.val() || $inputElement.val().trim() === '') {
				const errorId = '#error_' + $inputElement.attr('id');
				$(errorId).text('This field is required');
				$inputElement.addClass('is-invalid');
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $inputElement.attr('id');
				}
			}
		});

		// Only allow 4-digit years for from/to year
		['#academic_from_year', '#academic_to_year'].forEach(function(id) {
			const val = $(id).val();
			if (val && !/^\d{4}$/.test(val)) {
				$(id).addClass('is-invalid');
				$(id.replace('#academic', '#error_academic')).text('Enter a valid 4-digit year');
				formValid = false;
				if (!firstInvalidFieldId) {
					firstInvalidFieldId = $(id).attr('id');
				}
			}
		});

		// At least one academic record should be present in the table before submit
		if ($('#academicRecordsTable tbody tr').length === 0) {
			FormUtils.showSwal('error', 'Validation Error', 'Please add at least one academic record before saving.');
			console.warn('Validation failed: No academic records present.');
			formValid = false;
		}

		// Employee ID check (like address tab)
		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate academic data.');
			console.warn('Validation failed: Employee ID missing.');
			return;
		}

		if (!formValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors in the Academic tab.');
			if (firstInvalidFieldId) {
				setTimeout(() => {
					const $errorField = $('#' + firstInvalidFieldId);
					if ($errorField.length) {
						$errorField[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
					}
				}, 100);
			}
			console.warn('Validation failed in Academic tab. Not submitting AJAX.');
			return;
		}

		// Collect academic records from table
		const academicRecords = [];
		$academicRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			academicRecords.push({
				fromYear: row.data('from-year'),
				toYear: row.data('to-year'),
				examination: row.data('examination'),
				certificationType: row.data('certification-type'),
				certification: row.data('certification'),
				institute: row.data('institute'),
				subject: row.data('subject'),
				grade: row.data('grade'),
				university: row.data('university'),
				collegeContactNo: row.data('college-contact-no'),
				collegeAddress: row.data('college-address'),
				program: row.data('program'),
				registrationNo: row.data('registration-no'),
				rollNo: row.data('roll-no'),
				universityCountry: row.data('university-country'),
				universityState: row.data('university-state'),
				universityCity: row.data('university-city'),
				universityContactNo: row.data('university-contact-no'),
				educatedInOverseas: row.data('educated-in-overseas')
			});
		});

		const formData = new FormData();
		formData.append('employee_id_hidden_field', employeeId);
		formData.append('academicRecordsJson', JSON.stringify(academicRecords));

		const $submitBtn = $personalAcademicForm.find('button[type="submit"]');
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
				$submitBtn.prop('disabled', false).text('Save Academic Data');
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
					console.error('Server-side errors for academic data:', response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Academic Data');
				console.error('AJAX Error (Academic):', status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels (for input fields for adding a record)
	$academicFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
