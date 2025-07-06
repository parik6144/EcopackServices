// assets/js/employee/personal_career.js
// This file handles the specific logic for the "Career" sub-tab under the Personal tab.

$(document).ready(function() {
	const $personalCareerForm = $('#personalCareerForm');
	const $globalEmployeeIdHiddenField = $('#employee_id_hidden_field');
	const $careerFormRow = $('#career-form-row');
	const $careerRecordsTableBody = $('#careerRecordsTable tbody');

	// Set the employee_id_hidden_field value on this form
	$personalCareerForm.find('input[name="employee_id_hidden_field"]').val($globalEmployeeIdHiddenField.val());

	// Event listener for input/change to update progress and save draft
	$personalCareerForm.on('input change', 'input:not([type="file"]), select, textarea', function() {
		FormUtils.updateProfileProgress();
		FormUtils.saveDraft();
	});

	// Add Career Record functionality
	$('#addCareerRecord').on('click', function() {
		const requiredFields = [
			'career_from_date', 'career_to_date', 'career_employer',
			'career_position', 'career_address', 'career_responsibility', 'career_reason_for_change'
		];

		const getRowHtml = function() {
			const fromDate = $('#career_from_date').val();
			const toDate = $('#career_to_date').val();
			const employer = $('#career_employer').val();
			const employerCode = $('#career_employer_code').val();
			const employmentStatus = $('#career_employment_status').val();
			const position = $('#career_position').val();
			const address = $('#career_address').val();
			const startingSalary = $('#career_starting_salary').val();
			const startingOtherComp = $('#career_starting_other_comp').val();
			const finalSalary = $('#career_final_salary').val();
			const finalOtherComp = $('#career_final_other_comp').val();
			const responsibility = $('#career_responsibility').val();
			const achievement = $('#career_achievement').val();
			const reasonForChange = $('#career_reason_for_change').val();
			const contactPerson = $('#career_contact_person').val();
			const contactPersonJobTitle = $('#career_contact_person_job_title').val();
			const contactPersonDepartment = $('#career_contact_person_department').val();
			const contactPersonMobileNo = $('#career_contact_person_mobile_no').val();
			const contactPersonEmail = $('#career_contact_person_email').val();
			const companyWebsite = $('#career_company_website').val();
			const uanNo = $('#career_uan_no').val();
			const epfAcNo = $('#career_epf_ac_no').val();
			const epfRegion = $('#career_epf_region').val();
			const esiAcNo = $('#career_esi_ac_no').val();
			const schemeCertificateNo = $('#career_scheme_certificate_no').val();
			const pensionPaymentOrderNo = $('#career_pension_payment_order_no').val();


			return `
                <tr data-from-date="${fromDate}" data-to-date="${toDate}" data-employer="${employer}"
                    data-employer-code="${employerCode}" data-employment-status="${employmentStatus}"
                    data-position="${position}" data-address="${address}" data-starting-salary="${startingSalary}"
                    data-starting-other-comp="${startingOtherComp}" data-final-salary="${finalSalary}"
                    data-final-other-comp="${finalOtherComp}" data-responsibility="${responsibility}"
                    data-achievement="${achievement}" data-reason-for-change="${reasonForChange}"
                    data-contact-person="${contactPerson}" data-contact-person-job-title="${contactPersonJobTitle}"
                    data-contact-person-department="${contactPersonDepartment}"
                    data-contact-person-mobile-no="${contactPersonMobileNo}"
                    data-contact-person-email="${contactPersonEmail}" data-company-website="${companyWebsite}"
                    data-uan-no="${uanNo}" data-epf-ac-no="${epfAcNo}" data-epf-region="${epfRegion}"
                    data-esi-ac-no="${esiAcNo}" data-scheme-certificate-no="${schemeCertificateNo}"
                    data-pension-payment-order-no="${pensionPaymentOrderNo}">
                    <td>${fromDate}</td>
                    <td>${toDate}</td>
                    <td>${employer}</td>
                    <td>${position}</td>
                    <td>${contactPersonDepartment || ''}</td> <td>${reasonForChange}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `;
		};
		FormUtils.handleAddDynamicRecord($careerFormRow, $careerRecordsTableBody, requiredFields, getRowHtml);
	});

	$personalCareerForm.on('submit', function(e) {
		e.preventDefault();

		// Clear errors for this specific form
		$personalCareerForm.find('.form-error').text('');
		$personalCareerForm.find('.form-control').removeClass('is-invalid');

		const employeeId = $globalEmployeeIdHiddenField.val();
		if (!employeeId) {
			FormUtils.showGlobalAlert('danger', 'Employee ID is missing. Please save Master data first.');
			FormUtils.showSwal('info', 'First Step Needed', 'Please complete and save the Master tab first to associate career data.');
			return;
		}

		const careerRecords = [];
		$careerRecordsTableBody.find('tr').each(function() {
			const row = $(this);
			careerRecords.push({
				fromDate: row.data('from-date'),
				toDate: row.data('to-date'),
				employer: row.data('employer'),
				employerCode: row.data('employer-code'),
				employmentStatus: row.data('employment-status'),
				position: row.data('position'),
				address: row.data('address'),
				startingSalary: row.data('starting-salary'),
				startingOtherComp: row.data('starting-other-comp'),
				finalSalary: row.data('final-salary'),
				finalOtherComp: row.data('final-other-comp'),
				responsibility: row.data('responsibility'),
				achievement: row.data('achievement'),
				reasonForChange: row.data('reason-for-change'),
				contactPerson: row.data('contact-person'),
				contactPersonJobTitle: row.data('contact-person-job-title'),
				contactPersonDepartment: row.data('contact-person-department'),
				contactPersonMobileNo: row.data('contact-person-mobile-no'),
				contactPersonEmail: row.data('contact-person-email'),
				companyWebsite: row.data('company-website'),
				uanNo: row.data('uan-no'),
				epfAcNo: row.data('epf-ac-no'),
				epfRegion: row.data('epf-region'),
				esiAcNo: row.data('esi-ac-no'),
				schemeCertificateNo: row.data('scheme-certificate-no'),
				pensionPaymentOrderNo: row.data('pension-payment-order-no')
			});
		});

		const formData = new FormData();
		// formData.append('employee_id_hidden_field', employeeId);
		formData.append('careerRecordsJson', JSON.stringify(careerRecords));

		const $submitBtn = $personalCareerForm.find('button[type="submit"]');
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
				$submitBtn.prop('disabled', false).text('Save Career Data');
				if (response.status === 'success') {
					FormUtils.showSwal('success', 'Saved!', response.message);
					FormUtils.saveDraft();
					FormUtils.updateProfileProgress();
				} else {
					FormUtils.showSwal('error', 'Error!', response.message);
					console.error("Server-side errors for career data:", response.errors);
				}
			},
			error: function(xhr, status, error) {
				$submitBtn.prop('disabled', false).text('Save Career Data');
				console.error("AJAX Error:", status, error, xhr.responseText);
				FormUtils.showSwal('error', 'Network Error', 'Could not connect to the server. Please try again.');
			}
		});
	});

	// Initial check for 'filled' state for labels
	$careerFormRow.find('.form-control').each(function() {
		if($(this).val()) {
			$(this).addClass('filled');
		}
	});
});
