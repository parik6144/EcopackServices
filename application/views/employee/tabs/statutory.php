<?php
// application/views/employee/tabs/statutory.php
// This view contains the form elements for the Statutory tab.
// $employee_data is passed from the main employee_form.php
$pf_details = isset($employee_data['pf_details']) ? $employee_data['pf_details'] : [];
$eps_details = isset($employee_data['eps_details']) ? $employee_data['eps_details'] : [];
$esi_details = isset($employee_data['esi_details']) ? $employee_data['esi_details'] : [];
$ptax_details = isset($employee_data['ptax_details']) ? $employee_data['ptax_details'] : [];
?>

<form id="statutoryForm" data-tab-form="true">
	<input type="hidden" name="employee_id_hidden_field" value="">

	<h5>Statutory Details</h5>
	<h6>Provident Fund</h6>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_pf_ac_no" name="stat_pf_ac_no" placeholder=" "
				   value="<?= htmlspecialchars($pf_details['pf_ac_no'] ?? ''); ?>" />
			<label for="stat_pf_ac_no">A/C No</label>
			<div class="form-error" id="error_stat_pf_ac_no"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="stat_pf_joining_date" name="stat_pf_joining_date" placeholder=" "
				   value="<?= htmlspecialchars($pf_details['pf_joining_date'] ?? ''); ?>" />
			<label for="stat_pf_joining_date">Joining Date</label>
			<div class="form-error" id="error_stat_pf_joining_date"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_pf_uan" name="stat_pf_uan" placeholder=" "
				   value="<?= htmlspecialchars($pf_details['pf_uan'] ?? ''); ?>" />
			<label for="stat_pf_uan">Universal A/C No (UAN)</label>
			<div class="form-error" id="error_stat_pf_uan"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_pf_settlement" name="stat_pf_settlement" placeholder=" "
				   value="<?= htmlspecialchars($pf_details['pf_settlement'] ?? ''); ?>" />
			<label for="stat_pf_settlement">Settlement</label>
			<div class="form-error" id="error_stat_pf_settlement"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_eps_ac_no" name="stat_eps_ac_no" placeholder=" "
				   value="<?= htmlspecialchars($eps_details['eps_ac_no'] ?? ''); ?>" />
			<label for="stat_eps_ac_no">EPS A/C No</label>
			<div class="form-error" id="error_stat_eps_ac_no"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="stat_eps_joining_date" name="stat_eps_joining_date" placeholder=" "
				   value="<?= htmlspecialchars($eps_details['eps_joining_date'] ?? ''); ?>" />
			<label for="stat_eps_joining_date">EPS Joining Date</label>
			<div class="form-error" id="error_stat_eps_joining_date"></div>
		</div>
	</div>
	<h6>ESI</h6>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_esi_ac_no" name="stat_esi_ac_no" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_ac_no'] ?? ''); ?>" />
			<label for="stat_esi_ac_no">A/C No</label>
			<div class="form-error" id="error_stat_esi_ac_no"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="date" class="form-control" id="stat_esi_joining_date" name="stat_esi_joining_date" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_joining_date'] ?? ''); ?>" />
			<label for="stat_esi_joining_date">Joining Date</label>
			<div class="form-error" id="error_stat_esi_joining_date"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_esi_locality" name="stat_esi_locality" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_locality'] ?? ''); ?>" />
			<label for="stat_esi_locality">Locality</label>
			<div class="form-error" id="error_stat_esi_locality"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_esi_dispensary" name="stat_esi_dispensary" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_dispensary'] ?? ''); ?>" />
			<label for="stat_esi_dispensary">Dispensary</label>
			<div class="form-error" id="error_stat_esi_dispensary"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_esi_doctor_code" name="stat_esi_doctor_code" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_doctor_code'] ?? ''); ?>" />
			<label for="stat_esi_doctor_code">Doctor Code</label>
			<div class="form-error" id="error_stat_esi_doctor_code"></div>
		</div>
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_esi_doctor_name" name="stat_esi_doctor_name" placeholder=" "
				   value="<?= htmlspecialchars($esi_details['esi_doctor_name'] ?? ''); ?>" />
			<label for="stat_esi_doctor_name">Doctor Name</label>
			<div class="form-error" id="error_stat_esi_doctor_name"></div>
		</div>
	</div>
	<h6>Professional Tax</h6>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="stat_ptax_region" name="stat_ptax_region" placeholder=" "
				   value="<?= htmlspecialchars($ptax_details['ptax_region'] ?? ''); ?>" />
			<label for="stat_ptax_region">P. Tax Region</label>
			<div class="form-error" id="error_stat_ptax_region"></div>
		</div>
	</div>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Statutory Data</button>
	</div>
</form>
