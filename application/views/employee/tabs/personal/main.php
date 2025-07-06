<?php
// application/views/employee/tabs/personal/main.php
// This view contains the form elements for the "Main" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$personal_main_data = $employee_data['personal_main_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<form id="personalMainForm" data-tab-form="true" novalidate>
	<input type="hidden" id="personal_main_employee_id_hidden_field" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">
	
	<fieldset class="fieldset-border">
		<legend class="fieldset-border">General</legend>
		<div class="form-row">
			<div class="form-group col-md-2">
				<select class="form-control" id="gender" name="gender" required>
					<option value="">Select Gender</option>
					<option value="Male" <?php echo (isset($personal_main_data['gender']) && $personal_main_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
					<option value="Female" <?php echo (isset($personal_main_data['gender']) && $personal_main_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
					<option value="Other" <?php echo (isset($personal_main_data['gender']) && $personal_main_data['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
				</select>
				<label for="gender">Gender *</label>
				<div class="form-error" id="error_gender"></div>
			</div>
			<div class="form-group col-md-2">
				<select class="form-control" id="blood_group" name="blood_group">
					<option value="">Select Blood Group</option>
					<option value="A+ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'A+ve') ? 'selected' : ''; ?>>A+ve</option>
					<option value="B+ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'B+ve') ? 'selected' : ''; ?>>B+ve</option>
					<option value="O+ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'O+ve') ? 'selected' : ''; ?>>O+ve</option>
					<option value="AB+ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'AB+ve') ? 'selected' : ''; ?>>AB+ve</option>
					<option value="A-ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'A-ve') ? 'selected' : ''; ?>>A-ve</option>
					<option value="B-ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'B-ve') ? 'selected' : ''; ?>>B-ve</option>
					<option value="O-ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'O-ve') ? 'selected' : ''; ?>>O-ve</option>
					<option value="AB-ve" <?php echo (isset($personal_main_data['blood_group']) && $personal_main_data['blood_group'] == 'AB-ve') ? 'selected' : ''; ?>>AB-ve</option>
				</select>
				<label for="blood_group">Blood Group</label>
				<div class="form-error" id="error_blood_group"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="date" class="form-control" id="dob" name="dob" required value="<?php echo htmlspecialchars($personal_main_data['dob'] ?? ''); ?>" />
				<label for="dob">Date of Birth *</label>
				<div class="form-error" id="error_dob"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="father_name" name="father_name" placeholder=" " required value="<?php echo htmlspecialchars($personal_main_data['father_name'] ?? ''); ?>" />
				<label for="father_name">Father's Name *</label>
				<div class="form-error" id="error_father_name"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="home_phone_no" name="home_phone_no" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['home_phone_no'] ?? ''); ?>">
				<label for="home_phone_no">Home Phone No</label>
				<div class="form-error" id="error_home_phone_no"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Origin</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="caste" name="caste" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['caste'] ?? ''); ?>">
				<label for="caste">Caste</label>
				<div class="form-error" id="error_caste"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="religion" name="religion" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['religion'] ?? ''); ?>">
				<label for="religion">Religion</label>
				<div class="form-error" id="error_religion"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="citizenship" name="citizenship" placeholder=" " required value="<?php echo htmlspecialchars($personal_main_data['citizenship'] ?? 'India'); ?>">
				<label for="citizenship">Citizenship *</label>
				<div class="form-error" id="error_citizenship"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="disabilities" name="disabilities" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['disabilities'] ?? 'No'); ?>">
				<label for="disabilities">Disabilities</label>
				<div class="form-error" id="error_disabilities"></div>
			</div>
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="birth_place" name="birth_place" placeholder=" " required value="<?php echo htmlspecialchars($personal_main_data['birth_place'] ?? ''); ?>">
				<label for="birth_place">Birth Place *</label>
				<div class="form-error" id="error_birth_place"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Marital</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<select class="form-control" id="marital_status" name="marital_status" required>
					<option value="">Select Status</option>
					<option value="Single" <?php echo (isset($personal_main_data['marital_status']) && $personal_main_data['marital_status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
					<option value="Married" <?php echo (isset($personal_main_data['marital_status']) && $personal_main_data['marital_status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
					<option value="Divorced" <?php echo (isset($personal_main_data['marital_status']) && $personal_main_data['marital_status'] == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
					<option value="Widowed" <?php echo (isset($personal_main_data['marital_status']) && $personal_main_data['marital_status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
				</select>
				<label for="marital_status">Marital Status *</label>
				<div class="form-error" id="error_marital_status"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="marriage_date" name="marriage_date" value="<?php echo htmlspecialchars($personal_main_data['marriage_date'] ?? ''); ?>">
				<label for="marriage_date">Marriage Date</label>
				<div class="form-error" id="error_marriage_date"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="number" class="form-control" id="no_of_children" name="no_of_children" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['no_of_children'] ?? '0'); ?>">
				<label for="no_of_children">No. of Children</label>
				<div class="form-error" id="error_no_of_children"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Passport</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="name_in_passport" name="name_in_passport" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['passport_name'] ?? ''); ?>">
				<label for="name_in_passport">Name in Passport</label>
				<div class="form-error" id="error_name_in_passport"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="passport_no" name="passport_no" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['passport_no'] ?? ''); ?>">
				<label for="passport_no">Passport No</label>
				<div class="form-error" id="error_passport_no"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="passport_validity" name="passport_validity" value="<?php echo htmlspecialchars($personal_main_data['passport_valid_to'] ?? ''); ?>">
				<label for="passport_validity">Validity</label>
				<div class="form-error" id="error_passport_validity"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="passport_issuer" name="passport_issuer" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['passport_issuer'] ?? ''); ?>">
				<label for="passport_issuer">Passport Issuer</label>
				<div class="form-error" id="error_passport_issuer"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Social</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="linkedin" name="linkedin" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['linkedin'] ?? ''); ?>">
				<label for="linkedin">LinkedIn</label>
				<div class="form-error" id="error_linkedin"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="facebook" name="facebook" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['facebook'] ?? ''); ?>">
				<label for="facebook">Facebook</label>
				<div class="form-error" id="error_facebook"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="twitter" name="twitter" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['twitter'] ?? ''); ?>">
				<label for="twitter">Twitter</label>
				<div class="form-error" id="error_twitter"></div>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="instagram" name="instagram" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['instagram'] ?? ''); ?>">
				<label for="instagram">Instagram</label>
				<div class="form-error" id="error_instagram"></div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Others</legend>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="pan_no" name="pan_no" required placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['pan_no'] ?? ''); ?>">
				<label for="pan_no">PAN No*</label>
				<div class="form-error" id="error_pan_no"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="aadhar_no" name="aadhar_no" required placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['aadhar_no'] ?? ''); ?>">
				<label for="aadhar_no">Aadhar No*</label>
				<div class="form-error" id="error_aadhar_no"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="voter_id" name="voter_id" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['voter_id'] ?? ''); ?>">
				<label for="voter_id">Voter ID</label>
				<div class="form-error" id="error_voter_id"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="driving_license_no" name="driving_license_no" placeholder=" " value="<?php echo htmlspecialchars($personal_main_data['driving_license_no'] ?? ''); ?>">
				<label for="driving_license_no">Driving License No</label>
				<div class="form-error" id="error_driving_license_no"></div>
			</div>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Profile</button>
	</div>
</form>
