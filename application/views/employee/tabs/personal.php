<div class="panel-body compact-form">
	<div class="tabs-container">
		<ul class="nav nav-pills mb-3" id="personalSubTab" role="tablist"> <li class="nav-item" role="presentation">
				<a class="nav-link active" id="personal-main-tab" data-toggle="pill" href="#personal-main" role="tab" aria-controls="personal-main" aria-selected="true">Main</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-address-tab" data-toggle="pill" href="#personal-address" role="tab" aria-controls="personal-address" aria-selected="false">Address</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-academic-tab" data-toggle="pill" href="#personal-academic" role="tab" aria-controls="personal-academic" aria-selected="false">Academic</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-family-tab" data-toggle="pill" href="#personal-family" role="tab" aria-controls="personal-family" aria-selected="false">Family</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-nomination-tab" data-toggle="pill" href="#personal-nomination" role="tab" aria-controls="personal-nomination" aria-selected="false">Nomination Details</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-career-tab" data-toggle="pill" href="#personal-career" role="tab" aria-controls="personal-career" aria-selected="false">Career</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-medical-tab" data-toggle="pill" href="#personal-medical" role="tab" aria-controls="personal-medical" aria-selected="false">Medical History</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-emergency-tab" data-toggle="pill" href="#personal-emergency" role="tab" aria-controls="personal-emergency" aria-selected="false">Emergency Contact</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="personal-attachments-tab" data-toggle="pill" href="#personal-attachments" role="tab" aria-controls="personal-attachments" aria-selected="false">Attachments</a>
			</li>
		</ul>
		<div class="tab-content" id="personalSubTabContent"> <div id="personal-main" class="tab-pane fade show active" role="tabpanel" aria-labelledby="personal-main-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/main', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-address" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-address-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/address', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-academic" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-academic-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/academic', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-family" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-family-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/family', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-nomination" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-nomination-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/nomination', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-career" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-career-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/career', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-medical" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-medical-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/medical', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-emergency" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-emergency-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/emergency', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
			<div id="personal-attachments" class="tab-pane fade" role="tabpanel" aria-labelledby="personal-attachments-tab">
				<div class="panel-body">
					<?php $this->load->view('employee/tabs/personal/attachments', isset($employee_data) ? $employee_data : []); ?>
				</div>
			</div>
		</div>
	</div>
</div>
