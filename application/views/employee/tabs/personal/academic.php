<?php
// application/views/employee/tabs/personal/academic.php
// This view contains the form elements and dynamic table for "Academic" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$academic_data = $employee_data['academic_records'] ?? [];
// Placeholder data, should be populated from helpers/models
$examinations = ['10th', '12th', 'Diploma', 'Graduation', 'Post Graduation', 'PhD', 'Other'];
$cert_types = ['Academic', 'Professional', 'Technical', 'Vocational'];
$programs = ['Full Time', 'Part Time', 'Correspondence', 'Distance Learning'];
$subjects = ['Maths', 'Science', 'Commerce', 'Arts', 'Engineering', 'Medical', 'Law', 'Management', 'Other'];
$countries = ['India', 'USA', 'UK', 'Australia', 'Canada', 'Germany', 'France', 'Japan', 'China', 'Other'];
$states = [
    'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Jammu and Kashmir', 'Ladakh', 'Lakshadweep', 'Puducherry'
];
?>

<form id="personalAcademicForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?= isset($academic_data[0]['employee_id']) ? encryptor('encrypt', $academic_data[0]['employee_id']) : ''; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Education</legend>
		<div class="form-row">
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_from_year" name="academic_from_year" placeholder=" " required>
				<label for="academic_from_year">From Year *</label>
				<div class="form-error" id="error_academic_from_year"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_to_year" name="academic_to_year" placeholder=" " required>
				<label for="academic_to_year">To Year *</label>
				<div class="form-error" id="error_academic_to_year"></div>
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" id="academic_examination" name="academic_examination" required>
					<option value="">Select Examination</option>
					<?php foreach($examinations as $exam): ?>
						<option value="<?= $exam ?>"><?= $exam ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_examination">Examination *</label>
				<div class="form-error" id="error_academic_examination"></div>
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" id="academic_cert_type" name="academic_cert_type" required>
					 <option value="">Select Type</option>
					 <?php foreach($cert_types as $type): ?>
						<option value="<?= $type ?>"><?= $type ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_cert_type">Type of Certification *</label>
				<div class="form-error" id="error_academic_cert_type"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_certification" name="academic_certification" placeholder=" ">
				<label for="academic_certification">Certification</label>
				<div class="form-error" id="error_academic_certification"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_institute" name="academic_institute" placeholder=" " required>
				<label for="academic_institute">Institute *</label>
				<div class="form-error" id="error_academic_institute"></div>
			</div>
		</div>
		<div class="form-row">
			 <div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_college_contact_no" name="academic_college_contact_no" placeholder=" ">
				<label for="academic_college_contact_no">College Contact No</label>
				<div class="form-error" id="error_academic_college_contact_no"></div>
			</div>
			 <div class="form-group col-md-4">
				<input type="text" class="form-control" id="academic_college_address" name="academic_college_address" placeholder=" ">
				<label for="academic_college_address">College Address</label>
				<div class="form-error" id="error_academic_college_address"></div>
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" id="academic_program" name="academic_program" required>
					<option value="">Select Program</option>
					<?php foreach($programs as $prog): ?>
						<option value="<?= $prog ?>"><?= $prog ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_program">Program *</label>
				<div class="form-error" id="error_academic_program"></div>
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" id="academic_subject" name="academic_subject" required>
					<option value="">Select Subject</option>
					<?php foreach($subjects as $sub): ?>
						<option value="<?= $sub ?>"><?= $sub ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_subject">Subject *</label>
				<div class="form-error" id="error_academic_subject"></div>
			</div>
			 <div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_registration_no" name="academic_registration_no" placeholder=" ">
				<label for="academic_registration_no">Registration No</label>
				<div class="form-error" id="error_academic_registration_no"></div>
			</div>
		</div>
		 <div class="form-row">
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_roll_no" name="academic_roll_no" placeholder=" ">
				<label for="academic_roll_no">Roll No</label>
				<div class="form-error" id="error_academic_roll_no"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_grade" name="academic_grade" placeholder=" ">
				<label for="academic_grade">Grade</label>
				<div class="form-error" id="error_academic_grade"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_university" name="academic_university" placeholder=" " required>
				<label for="academic_university">University *</label>
				<div class="form-error" id="error_academic_university"></div>
			</div>
			 <div class="form-group col-md-2">
				<select class="form-control" id="academic_university_country" name="academic_university_country">
					<option value="">Select Country</option>
					<?php foreach($countries as $country): ?>
						<option value="<?= $country ?>"><?= $country ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_university_country">University Country</label>
				<div class="form-error" id="error_academic_university_country"></div>
			</div>
			 <div class="form-group col-md-2">
				<select class="form-control" id="academic_university_state" name="academic_university_state">
					<option value="">Select State</option>
					<?php foreach($states as $state): ?>
						<option value="<?= $state ?>"><?= $state ?></option>
					<?php endforeach; ?>
				</select>
				<label for="academic_university_state">University State</label>
				<div class="form-error" id="error_academic_university_state"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="academic_university_city" name="academic_university_city" placeholder=" ">
				<label for="academic_university_city">University City</label>
				<div class="form-error" id="error_academic_university_city"></div>
			</div>
		</div>
		<div class="form-row">
			 <div class="form-group col-md-2">
				<select class="form-control" id="academic_educated_in_overseas" name="academic_educated_in_overseas">
					<option value="No">No</option>
					<option value="Yes">Yes</option>
				</select>
				<label for="academic_educated_in_overseas">Educated In Overseas</label>
				<div class="form-error" id="error_academic_educated_in_overseas"></div>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addEducationBtn">Add Record</button>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Education Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="academicRecordsTable">
				<thead>
					<tr>
						<th>From Year</th>
						<th>To Year</th>
						<th>Examination</th>
						<th>Type of Certification</th>
						<th>Certification</th>
						<th>Institute</th>
						<th>Program</th>
						<th>Subject</th>
						<th>Registration No</th>
						<th>Roll No</th>
						<th>Grade</th>
						<th>University</th>
						<th>University Country</th>
						<th>University State</th>
						<th>University City</th>
						<th>Educated In Overseas</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($academic_data)): ?>
						<?php foreach ($academic_data as $row): ?>
							<tr
								data-from-year="<?= htmlspecialchars($row['from_year'] ?? '') ?>"
								data-to-year="<?= htmlspecialchars($row['to_year'] ?? '') ?>"
								data-examination="<?= htmlspecialchars($row['examination'] ?? '') ?>"
								data-certification-type="<?= htmlspecialchars($row['certification_type'] ?? '') ?>"
								data-certification="<?= htmlspecialchars($row['certification'] ?? '') ?>"
								data-institute="<?= htmlspecialchars($row['institute'] ?? '') ?>"
								data-program="<?= htmlspecialchars($row['program'] ?? '') ?>"
								data-subject="<?= htmlspecialchars($row['subject'] ?? '') ?>"
								data-registration-no="<?= htmlspecialchars($row['registration_no'] ?? '') ?>"
								data-roll-no="<?= htmlspecialchars($row['roll_no'] ?? '') ?>"
								data-grade="<?= htmlspecialchars($row['grade'] ?? '') ?>"
								data-university="<?= htmlspecialchars($row['university'] ?? '') ?>"
								data-university-country="<?= htmlspecialchars($row['university_country'] ?? '') ?>"
								data-university-state="<?= htmlspecialchars($row['university_state'] ?? '') ?>"
								data-university-city="<?= htmlspecialchars($row['university_city'] ?? '') ?>"
								data-educated-in-overseas="<?= htmlspecialchars($row['educated_in_overseas'] ?? '') ?>"
								data-college-contact-no="<?= htmlspecialchars($row['college_contact_no'] ?? '') ?>"
								data-college-address="<?= htmlspecialchars($row['college_address'] ?? '') ?>"
							>
								<td><?= htmlspecialchars($row['from_year'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['to_year'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['examination'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['certification_type'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['certification'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['institute'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['program'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['subject'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['registration_no'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['roll_no'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['grade'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['university'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['university_country'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['university_state'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['university_city'] ?? '') ?></td>
								<td><?= htmlspecialchars($row['educated_in_overseas'] ?? '') ?></td>
								<td><button type="button" class="btn btn-info btn-sm edit-row">Edit</button> <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</fieldset>

	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Gap</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="gap_from_year" name="gap_from_year" placeholder=" " required>
				<label for="gap_from_year">From Year *</label>
				<div class="form-error" id="error_gap_from_year"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="gap_to_year" name="gap_to_year" placeholder=" " required>
				<label for="gap_to_year">To Year *</label>
				<div class="form-error" id="error_gap_to_year"></div>
			</div>
			<div class="form-group col-md-6">
				<textarea class="form-control" id="gap_reason" name="gap_reason" placeholder=" " required maxlength="200"></textarea>
				<label for="gap_reason">Reason *</label>
				<div class="form-error" id="error_gap_reason"></div>
			</div>
		</div>
		<div class="d-flex justify-content-start gap-2 mt-3">
			<button type="button" class="btn btn-primary" id="addEducationGapBtn">Add Education Gap</button>
		</div>
	</fieldset>
	
	<fieldset class="fieldset-border mt-3">
		<legend class="fieldset-border">Gap Records</legend>
		<div class="table-responsive">
			<table class="table table-striped table-bordered" id="gapRecordsTable">
				<thead>
					<tr>
						<th>From Year</th>
						<th>To Year</th>
						<th>Reason</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- Gap records will be added here dynamically -->
				</tbody>
			</table>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Academic Data</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
