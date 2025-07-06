<?php
// application/views/employee/tabs/personal/main_personal.php
?>
<ul class="nav nav-pills mb-3" id="personalSubTab" role="tablist">
	<li class="nav-item" role="presentation">
		<a class="nav-link active" id="personal-main-tab" data-toggle="pill" href="#personal-main" role="tab" aria-controls="personal-main" aria-selected="true">Main</a>
	</li>
	<li class="nav-item" role="presentation">
		<a class="nav-link" id="personal-address-tab" data-toggle="pill" href="#personal-address" role="tab" aria-controls="personal-address" aria-selected="false">Address</a>
	</li>
	<!-- ... other personal sub-tabs ... -->
</ul>
<div class="tab-content" id="personalSubTabContent">
	<div class="tab-pane fade show active" id="personal-main" role="tabpanel" aria-labelledby="personal-main-tab">
		<?php $this->load->view('employee/tabs/personal/main', isset($employee_data) ? $employee_data : []); ?>
	</div>
	<div class="tab-pane fade" id="personal-address" role="tabpanel" aria-labelledby="personal-address-tab">
		<?php $this->load->view('employee/tabs/personal/address', isset($employee_data) ? $employee_data : []); ?>
	</div>
	<!-- ... load other personal sub-tabs ... -->
</div>
