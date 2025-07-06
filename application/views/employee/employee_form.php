<?php
// application/views/employee/employee_form.php

// Check if this is being loaded as a popup
$is_popup = isset($condition) && $condition === 'popup';

// Load Header, Left Sidebar, Topbar only if not popup
if (!$is_popup) {
	$this->load->view('header');
	$this->load->view('left_sidebar');
	$this->load->view('topbar');
}
?>

	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/css/employee/employee_form.css'); ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/css/employee/personal_tabs.css'); ?>" rel="stylesheet" />

	<script type="text/javascript">
		// Define BASE_URL as a global JavaScript variable for AJAX calls
		const BASE_URL = '<?= base_url(); ?>';
	</script>

	<style>
		.compact-form .form-group {
			margin-bottom: 0.5rem;
		}
		.compact-form .form-control,
		.compact-form .custom-file-label,
		.compact-form .btn {
			font-size: 0.875rem; /* 14px */
			height: auto;
			padding: 0.375rem 0.75rem;
		}
		.compact-form label:not(.form-check-label):not(.custom-file-label) {
			font-size: 0.875rem;
			font-weight: 600;
		}
		.compact-form .fieldset-border {
			padding: 1rem;
		}
	</style>

	<div class="emp-profile-container">
		<?php if (!$is_popup): ?>
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h2 class="emp-profile-heading flex-grow-1 text-center m-0">Employee Profile</h2>
			<div class="profile-progress-container ml-3" style="min-width:220px;">
				<div id="profile-progress-text" style="font-weight:600; color:gold;"></div>
				<div class="progress" style="background:black; border-radius:8px;">
					<div id="profile-progress-bar" class="progress-bar" role="progressbar" style="width:0%; background:linear-gradient(90deg, gold, orange); color:black; font-weight:bold;">0%</div>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h4 class="emp-profile-heading flex-grow-1 text-center m-0"><?= $title ?? 'Employee Form' ?></h4>
		</div>
		<?php endif; ?>

		<div id="globalFormAlert" class="mb-3" style="display: none;"></div>

		<input type="hidden" id="employee_id_hidden_field" name="employee_id_hidden_field" value="<?= isset($employee_id_encoded) ? $employee_id_encoded : ''; ?>">

		<?php if (!$is_popup): ?>
		<ul class="nav nav-tabs" id="mainTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="master-tab" data-toggle="tab" href="#master" role="tab" aria-controls="master" aria-selected="true" data-tab-name="master">Master</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false" data-tab-name="personal">Personal</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false" data-tab-name="payment">Payment</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false" data-tab-name="administration">Administration</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="statutory-tab" data-toggle="tab" href="#statutory" role="tab" aria-controls="statutory" aria-selected="false" data-tab-name="statutory">Statutory</a>
			</li>
		</ul>

		<div class="tab-content" id="mainTabContent">
			<div class="tab-pane fade show active" id="master" role="tabpanel" aria-labelledby="master-tab">
				<?php
				$this->load->view('employee/tabs/master', [
					'employee_data' => $employee_data ?? [],
					'places' => $places ?? [],
					'employee_types' => $employee_types ?? [],
					'designations' => $designations ?? []
				]);
				?>
			</div>

			<div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
				<div class="pt-3">
					<ul class="nav nav-tabs" id="personalSubTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="personal-main-tab" data-toggle="tab" href="#personal-main" role="tab" aria-controls="personal-main" aria-selected="true">Main</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-address-tab" data-toggle="tab" href="#personal-address" role="tab" aria-controls="personal-address" aria-selected="false">Address</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-academic-tab" data-toggle="tab" href="#personal-academic" role="tab" aria-controls="personal-academic" aria-selected="false">Academic</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-family-tab" data-toggle="tab" href="#personal-family" role="tab" aria-controls="personal-family" aria-selected="false">Family</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-nomination-tab" data-toggle="tab" href="#personal-nomination" role="tab" aria-controls="personal-nomination" aria-selected="false">Nomination Details</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-career-tab" data-toggle="tab" href="#personal-career" role="tab" aria-controls="personal-career" aria-selected="false">Career</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-medical-tab" data-toggle="tab" href="#personal-medical" role="tab" aria-controls="personal-medical" aria-selected="false">Medical History</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-emergency-tab" data-toggle="tab" href="#personal-emergency" role="tab" aria-controls="personal-emergency" aria-selected="false">Emergency Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="personal-attachments-tab" data-toggle="tab" href="#personal-attachments" role="tab" aria-controls="personal-attachments" aria-selected="false">Attachments</a>
						</li>
					</ul>

					<div class="tab-content pt-3" id="personalSubTabContent">
						<div class="tab-pane fade show active" id="personal-main" role="tabpanel" aria-labelledby="personal-main-tab">
							<?php $this->load->view('employee/tabs/personal/main', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-address" role="tabpanel" aria-labelledby="personal-address-tab">
							<?php $this->load->view('employee/tabs/personal/address', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-academic" role="tabpanel" aria-labelledby="personal-academic-tab">
							<?php $this->load->view('employee/tabs/personal/academic', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-family" role="tabpanel" aria-labelledby="personal-family-tab">
							<?php $this->load->view('employee/tabs/personal/family', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-nomination" role="tabpanel" aria-labelledby="personal-nomination-tab">
							<?php $this->load->view('employee/tabs/personal/nomination', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-career" role="tabpanel" aria-labelledby="personal-career-tab">
							<?php $this->load->view('employee/tabs/personal/career', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-medical" role="tabpanel" aria-labelledby="personal-medical-tab">
							<?php $this->load->view('employee/tabs/personal/medical', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-emergency" role="tabpanel" aria-labelledby="personal-emergency-tab">
							<?php $this->load->view('employee/tabs/personal/emergency', isset($employee_data) ? $employee_data : []); ?>
						</div>
						<div class="tab-pane fade" id="personal-attachments" role="tabpanel" aria-labelledby="personal-attachments-tab">
							<?php $this->load->view('employee/tabs/personal/attachments', isset($employee_data) ? $employee_data : []); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
				<?php
				$this->load->view('employee/tabs/payment', isset($employee_data) ? $employee_data : []);
				?>
			</div>

			<div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
				<?php
				$this->load->view('employee/tabs/administration', isset($employee_data) ? $employee_data : []);
				?>
			</div>

			<div class="tab-pane fade" id="statutory" role="tabpanel" aria-labelledby="statutory-tab">
				<?php
				$this->load->view('employee/tabs/statutory', isset($employee_data) ? $employee_data : []);
				?>
			</div>
		</div>

		<?php else: ?>
		<!-- Simplified form for popup - only Master tab -->
		<div class="tab-content">
			<div class="tab-pane fade show active" id="master" role="tabpanel">
				<?php
				$this->load->view('employee/tabs/master', [
					'employee_data' => $employee_data ?? [],
					'places' => $places ?? [],
					'employee_types' => $employee_types ?? [],
					'designations' => $designations ?? []
				]);
				?>
			</div>
		</div>

		<div class="d-flex justify-content-end gap-2 mt-3">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" id="saveMasterBtn" class="btn btn-primary">Save Employee</button>
		</div>
		<?php endif; ?>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="<?= base_url('assets/js/employee/FormUtils.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/employee_form.js'); ?>"></script>

	<script src="<?= base_url('assets/js/employee/master.js'); ?>"></script>
	<?php if (!$is_popup): ?>
	<script src="<?= base_url('assets/js/employee/personal_main.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_address.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_academic.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_family.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_nomination.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_career.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_medical.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_emergency.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/personal_attachments.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/payment.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/administration.js'); ?>"></script>
	<script src="<?= base_url('assets/js/employee/statutory.js'); ?>"></script>
	<?php endif; ?>

<?php
// Load Footer only if not popup
if (!$is_popup) {
	$this->load->view('footer');
}
?>
