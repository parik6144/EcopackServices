<?php
// application/views/employee/tabs/personal/address.php
// This view contains the form elements for the "Address" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$current_address = $employee_data['current_address'] ?? [];
$permanent_address = $employee_data['permanent_address'] ?? [];
$current_address_data = $employee_data['current_address_data'] ?? [];
$permanent_address_data = $employee_data['permanent_address_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
// Full list of Indian states
$states = [
    'Andhra Pradesh' => 'Andhra Pradesh',
    'Arunachal Pradesh' => 'Arunachal Pradesh',
    'Assam' => 'Assam',
    'Bihar' => 'Bihar',
    'Chhattisgarh' => 'Chhattisgarh',
    'Goa' => 'Goa',
    'Gujarat' => 'Gujarat',
    'Haryana' => 'Haryana',
    'Himachal Pradesh' => 'Himachal Pradesh',
    'Jharkhand' => 'Jharkhand',
    'Karnataka' => 'Karnataka',
    'Kerala' => 'Kerala',
    'Madhya Pradesh' => 'Madhya Pradesh',
    'Maharashtra' => 'Maharashtra',
    'Manipur' => 'Manipur',
    'Meghalaya' => 'Meghalaya',
    'Mizoram' => 'Mizoram',
    'Nagaland' => 'Nagaland',
    'Odisha' => 'Odisha',
    'Punjab' => 'Punjab',
    'Rajasthan' => 'Rajasthan',
    'Sikkim' => 'Sikkim',
    'Tamil Nadu' => 'Tamil Nadu',
    'Telangana' => 'Telangana',
    'Tripura' => 'Tripura',
    'Uttar Pradesh' => 'Uttar Pradesh',
    'Uttarakhand' => 'Uttarakhand',
    'West Bengal' => 'West Bengal',
    'Andaman and Nicobar Islands' => 'Andaman and Nicobar Islands',
    'Chandigarh' => 'Chandigarh',
    'Dadra and Nagar Haveli and Daman and Diu' => 'Dadra and Nagar Haveli and Daman and Diu',
    'Delhi' => 'Delhi',
    'Jammu and Kashmir' => 'Jammu and Kashmir',
    'Ladakh' => 'Ladakh',
    'Lakshadweep' => 'Lakshadweep',
    'Puducherry' => 'Puducherry',
];
// Country array
$countries = ['India' => 'India', 'USA' => 'USA', 'UK' => 'UK'];
?>

<form id="personalAddressForm" data-tab-form="true" novalidate>
	<input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Current Address</legend>
		<div class="form-row">
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="current_house_no" name="current_house_no" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['house_no'] ?? $current_address['house_no'] ?? '')); ?>" required>
				<label for="current_house_no">House No *</label>
				<div class="form-error" id="error_current_house_no"></div>
			</div>
			<div class="form-group col-md-4">
				<input type="text" class="form-control" id="current_street" name="current_street" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['street'] ?? $current_address['street'] ?? '')); ?>" required>
				<label for="current_street">Street / Locality *</label>
				<div class="form-error" id="error_current_street"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="current_landmark" name="current_landmark" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['landmark'] ?? $current_address['landmark'] ?? '')); ?>">
				<label for="current_landmark">Landmark</label>
				<div class="form-error" id="error_current_landmark"></div>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="current_post_office" name="current_post_office" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['post_office'] ?? $current_address['post_office'] ?? '')); ?>" required>
				<label for="current_post_office">Post Office *</label>
				<div class="form-error" id="error_current_post_office"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="current_police_station" name="current_police_station" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['police_station'] ?? $current_address['police_station'] ?? '')); ?>">
				<label for="current_police_station">Police Station</label>
				<div class="form-error" id="error_current_police_station"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="current_city" name="current_city" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['city'] ?? $current_address['city'] ?? '')); ?>" required>
				<label for="current_city">City *</label>
				<div class="form-error" id="error_current_city"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="current_zip_code" name="current_zip_code" placeholder=" " value="<?php echo htmlspecialchars(($current_address_data['zip_code'] ?? $current_address['zip_code'] ?? '')); ?>" required>
				<label for="current_zip_code">Zip Code *</label>
				<div class="form-error" id="error_current_zip_code"></div>
			</div>
			<div class="form-group col-md-3">
				<select class="form-control" id="current_state" name="current_state" required>
					 <option value="">Select State</option>
					<?php foreach ($states as $key => $value): ?>
						<option value="<?php echo $key ?>" <?php if ((isset($current_address_data['state']) && $current_address_data['state'] == $key) || (isset($current_address['state']) && $current_address['state'] == $key)): ?>selected<?php endif; ?>><?php echo $value ?></option>
					<?php endforeach; ?>
				</select>
				<label for="current_state">State *</label>
				<div class="form-error" id="error_current_state"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<select class="form-control" id="current_country" name="current_country" required>
					<option value="">Select Country</option>
					<?php foreach ($countries as $key => $value): ?>
						<option value="<?php echo $key ?>" <?php if ((isset($current_address_data['country']) && $current_address_data['country'] == $key) || (isset($current_address['country']) && $current_address['country'] == $key)): ?>selected<?php endif; ?>><?php echo $value ?></option>
					<?php endforeach; ?>
				</select>
				<label for="current_country">Country *</label>
				<div class="form-error" id="error_current_country"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="current_period_from" name="current_period_from" value="<?php echo htmlspecialchars(($current_address_data['period_from'] ?? $current_address['period_from'] ?? '')); ?>" required />
				<label for="current_period_from">Period of Stay (From) *</label>
				<div class="form-error" id="error_current_period_from"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="current_period_to" name="current_period_to" value="<?php echo htmlspecialchars(($current_address_data['period_to'] ?? $current_address['period_to'] ?? '')); ?>" required />
				<label for="current_period_to">Period of Stay (To) *</label>
				<div class="form-error" id="error_current_period_to"></div>
			</div>
		</div>
	</fieldset>

	<hr>
	<div class="form-check mb-3">
		<input class="form-check-input" type="checkbox" id="sameAsCurrent">
		<label class="form-check-label" for="sameAsCurrent">
			Permanent Address is the same as Current Address
		</label>
	</div>

	<fieldset class="fieldset-border">
		<legend class="fieldset-border">Permanent Address</legend>
		<div class="form-row">
			<div class="form-group col-md-2">
				<input type="text" class="form-control" id="permanent_house_no" name="permanent_house_no" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['house_no'] ?? $permanent_address['house_no'] ?? '')); ?>" required>
				<label for="permanent_house_no">House No *</label>
				<div class="form-error" id="error_permanent_house_no"></div>
			</div>
			<div class="form-group col-md-4">
				<input type="text" class="form-control" id="permanent_street" name="permanent_street" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['street'] ?? $permanent_address['street'] ?? '')); ?>" required>
				<label for="permanent_street">Street / Locality *</label>
				<div class="form-error" id="error_permanent_street"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="permanent_landmark" name="permanent_landmark" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['landmark'] ?? $permanent_address['landmark'] ?? '')); ?>">
				<label for="permanent_landmark">Landmark</label>
				<div class="form-error" id="error_permanent_landmark"></div>
			</div>
			 <div class="form-group col-md-3">
				<input type="text" class="form-control" id="permanent_post_office" name="permanent_post_office" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['post_office'] ?? $permanent_address['post_office'] ?? '')); ?>" required>
				<label for="permanent_post_office">Post Office *</label>
				<div class="form-error" id="error_permanent_post_office"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="permanent_police_station" name="permanent_police_station" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['police_station'] ?? $permanent_address['police_station'] ?? '')); ?>">
				<label for="permanent_police_station">Police Station</label>
				<div class="form-error" id="error_permanent_police_station"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="permanent_city" name="permanent_city" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['city'] ?? $permanent_address['city'] ?? '')); ?>" required>
				<label for="permanent_city">City *</label>
				<div class="form-error" id="error_permanent_city"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="text" class="form-control" id="permanent_zip_code" name="permanent_zip_code" placeholder=" " value="<?php echo htmlspecialchars(($permanent_address_data['zip_code'] ?? $permanent_address['zip_code'] ?? '')); ?>" required>
				<label for="permanent_zip_code">Zip Code *</label>
				<div class="form-error" id="error_permanent_zip_code"></div>
			</div>
			<div class="form-group col-md-3">
				<select class="form-control" id="permanent_state" name="permanent_state" required>
					<option value="">Select State</option>
					<?php foreach ($states as $key => $value): ?>
						<option value="<?php echo $key ?>" <?php if ((isset($permanent_address_data['state']) && $permanent_address_data['state'] == $key) || (isset($permanent_address['state']) && $permanent_address['state'] == $key)): ?>selected<?php endif; ?>><?php echo $value ?></option>
					<?php endforeach; ?>
				</select>
				<label for="permanent_state">State *</label>
				<div class="form-error" id="error_permanent_state"></div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<select class="form-control" id="permanent_country" name="permanent_country" required>
					 <option value="">Select Country</option>
					<?php foreach ($countries as $key => $value): ?>
						<option value="<?php echo $key ?>" <?php if ((isset($permanent_address_data['country']) && $permanent_address_data['country'] == $key) || (isset($permanent_address['country']) && $permanent_address['country'] == $key)): ?>selected<?php endif; ?>><?php echo $value ?></option>
					<?php endforeach; ?>
				</select>
				<label for="permanent_country">Country *</label>
				<div class="form-error" id="error_permanent_country"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="permanent_period_from" name="permanent_period_from" value="<?php echo htmlspecialchars(($permanent_address_data['period_from'] ?? $permanent_address['period_from'] ?? '')); ?>" required />
				<label for="permanent_period_from">Period of Stay (From) *</label>
				<div class="form-error" id="error_permanent_period_from"></div>
			</div>
			<div class="form-group col-md-3">
				<input type="date" class="form-control" id="permanent_period_to" name="permanent_period_to" value="<?php echo htmlspecialchars(($permanent_address_data['period_to'] ?? $permanent_address['period_to'] ?? '')); ?>" required />
				<label for="permanent_period_to">Period of Stay (To) *</label>
				<div class="form-error" id="error_permanent_period_to"></div>
			</div>
		</div>
	</fieldset>

	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Address</button>
        <button type="button" class="btn btn-warning reset-tab-form">Reset</button>
	</div>
</form>
