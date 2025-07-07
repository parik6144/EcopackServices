<?php
/**
 * Employee CI_Controller Class
 *
 * Handles all employee-related operations including CRUD, dynamic data fetching,
 * and AJAX submissions for the multi-tabbed employee profile form.
 *
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Upload $upload
 * @property CI_Security $security
 * @property CI_Form_validation $form_validation
 * @property Mdl_employee $mdl_employee
 * @property Mdl_consignor $mdl_consignor
 * @property Mdl_setting $Mdl_setting
 * @property Mdl_place $Mdl_place
 */
class Employee extends CI_Controller
{
	/**
	 * Constructor
	 * Loads necessary helpers, libraries, and models.
	 * Enforces user session.
	 */
	function __construct()
	{
		parent::__construct();
		// Redirect to login if user is not logged in
		if($this->session->userdata('user_id') == '') {
			redirect(base_url(), 'refresh');
		}

		// Load helpers and libraries
		$this->load->helper('url'); // For base_url()
		$this->load->helper('encryptor'); // Assuming you have an encryptor helper
		$this->load->library('upload'); // For photo uploads
		$this->load->library('form_validation'); // For server-side validation

		// Load models
		$this->load->model('mdl_employee');
		$this->load->model('mdl_consignor'); // Used by old methods or potentially elsewhere
		$this->load->model('Mdl_setting'); // Assuming Mdl_setting is used elsewhere or for general settings
		$this->load->model('Mdl_place'); // For city/place data
		// Load the database library explicitly if not autoloaded
		$this->load->database();

		// Set default title for views (can be overridden by methods)
		$this->data['title'] = "Employee Management"; // Using $this->data for common view variables
	}

	/**
	 * Displays the list of employees.
	 * Fetches all employees from `employee_profile` and loads the employee_list view.
	 */
	public function index()
	{
		// For the initial display, it's better to let DataTables handle the data fetch.
		// So, no need to pre-fetch $this->data['employees'] here for DataTables.
		// $this->data['employees'] = $this->mdl_employee->get_all_employees_profile();
		$this->load->view('employee/employee_list', $this->data);
	}

	/**
	 * Displays the employee add/edit form.
	 * Fetches all necessary static data (places, employee types) and, if editing, existing employee data.
	 *
	 * @param string|null $encoded_id Optional encoded employee ID for editing an existing employee.
	 */
	public function add($encoded_id = null)
	{
		$this->load->model('Mdl_place');
		$this->load->library('form_validation');
		$this->load->library('upload');

		// If no ID is passed in URL, check if one exists in session from a previous new entry
		if (!$encoded_id && $this->session->has_userdata('current_staff_id_encoded')) {
			$encoded_id = $this->session->userdata('current_staff_id_encoded');
		}

		$data = [];

		// Load common data for forms
		$data['places'] = $this->Mdl_place->get_places();
		$data['employee_types'] = $this->db->select('employee_type_id, type_name')->from('employee_type')->where('is_deleted', 0)->get()->result_array();

		if ($encoded_id) {
			// EDIT MODE
			$data['title'] = "Edit Employee";
			$staff_id = encryptor("decrypt", $encoded_id);
			if (!$staff_id) {
				show_error('Invalid Employee ID provided.');
				return;
			}
			
			// Fetch all employee data using the new model function
			$employee_data = $this->mdl_employee->get_full_employee_data_by_staff_id($staff_id);

			if ($employee_data) {
				$data['employee_data'] = $employee_data;
				$data['employee_id_encoded'] = $encoded_id; // This is staff_id encoded

				// Set session data for the currently edited employee
				$this->session->set_userdata('current_staff_id_encoded', $encoded_id);
				if (isset($employee_data['master_data']['profile_id'])) {
					$profile_id_encoded = encryptor('encrypt', $employee_data['master_data']['profile_id']);
					$this->session->set_userdata('current_profile_id_encoded', $profile_id_encoded);
				}


				// Load designations based on employee type for the dropdown
				if (isset($employee_data['master_data']['employee_type_id'])) {
					$employee_type_id = $employee_data['master_data']['employee_type_id'];
					$data['designations'] = $this->db->select('designation_id, designation_name')->from('designations')->where('employee_type_id', $employee_type_id)->where('is_deleted', 0)->get()->result_array();
				}
			} else {
				show_error('Employee not found or data could not be loaded.');
				return;
			}
		} else {
			// ADD MODE
			$data['title'] = "Add Employee";
			
			// Generate a new employee code by getting the last one and incrementing
			$this->db->select('emp_no');
			$this->db->from('staff');
			$this->db->order_by('staff_id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$last_employee = $query->row();
			
			$next_number = 1;
			if ($last_employee && !empty($last_employee->emp_no)) {
				// Use regex to extract the numeric part of the code and increment it
				if (preg_match('/[A-Z]+(\d+)-(\d+)/', $last_employee->emp_no, $matches) || preg_match('/-(\d+)$/', $last_employee->emp_no, $matches)) {
					$last_number_part = intval(end($matches));
					$next_number = $last_number_part + 1;
				}
			}

			// Format the new employee code, e.g., ESPL-001, ESPL-012
			$new_employee_code = 'ESPL-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
			
			// Initialize empty data structure for the form
			$data['employee_data']['master_data'] = [
				'emp_no' => $new_employee_code,
			];
			$data['designations'] = []; // Initially empty for a new employee
		}

		$this->load->view('employee/employee_form', $data);
	}

	/**
	 * Handles AJAX submission for the Master form data.
	 * Inserts/updates `staff` table.
	 *
	 * @return JSON response indicating success or failure.
	 */
	public function save_master_data()
	{
		$this->load->library('upload'); // Ensure upload library is loaded
		$this->load->library('form_validation'); // Ensure form validation library is loaded

		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo json_encode(['status' => 'error', 'message' => 'No direct script access allowed.']);
			return;
		}

		$employee_id_encoded = $this->input->post('employee_id_hidden_field');
		$employee_id = ($employee_id_encoded) ? encryptor("decrypt", $employee_id_encoded) : null;

		// Server-side validation rules for master form
		$this->form_validation->set_rules('employee_code', 'Employee Code', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('employment_type', 'Employment Type', 'required|integer');
		$this->form_validation->set_rules('posting_city', 'Posting City', 'required|integer');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('designation', 'Designation', 'required|integer');
		$this->form_validation->set_rules('company', 'Company Name', 'required|trim|max_length[255]');
		$this->form_validation->set_rules('salary_branch', 'Salary Branch', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('attendance_type', 'Attendance Type', 'required|trim|max_length[100]');

		$this->form_validation->set_message('is_unique', 'The {field} provided already exists in the system. Please use a different one.');
		
		if (!$employee_id) { // Only check uniqueness on insert (new employee)
			$this->form_validation->set_rules('employee_code', 'Employee Code', 'required|trim|max_length[50]|is_unique[staff.emp_no]');
		} else {
			// If editing, check for uniqueness only if the employee code has changed
			$current_employee_code = $this->db->select('emp_no')->from('staff')->where('staff_id', $employee_id)->get()->row('emp_no');
			if ($this->input->post('employee_code') !== $current_employee_code) {
				$this->form_validation->set_rules('employee_code', 'Employee Code', 'required|trim|max_length[50]|is_unique[staff.emp_no]');
			}
		}

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Validation failed for Master data.', 'errors' => $this->form_validation->error_array()]);
			return;
		}

		$post_data = $this->input->post();

		// Prepare staff data
		$name_parts = array_filter([
			$post_data['first_name'] ?? '',
			$post_data['middle_name'] ?? '',
			$post_data['last_name'] ?? ''
		]);
		$staff_name = implode(' ', $name_parts);

		$staff_data = [
			'emp_no' => $post_data['employee_code'],
			'staff_name' => $staff_name,
			'company' => $post_data['company'],
			'employee_type_id' => $post_data['employment_type'],
			'designation_id' => $post_data['designation'],
			'attendance_type' => $post_data['attendance_type'],
			'location' => $post_data['posting_city'],
			'salary_branch' => $post_data['salary_branch'],
			'email_id' => $post_data['email'] ?? '',
			'mobile_no' => $post_data['mobile'] ?? '',
			'is_deleted' => 0
		];

		// Data for employee_profile table
		$profile_data = [
			'employee_code' => $post_data['employee_code'],
			'employment_type' => $post_data['employment_type'],
			'posting_city' => $post_data['posting_city'],
			'posting_branch' => '', // Assuming not in form, can be added
			'first_name' => $post_data['first_name'] ?? '',
			'middle_name' => $post_data['middle_name'] ?? '',
			'last_name' => $post_data['last_name'] ?? '',
			'company' => $post_data['company'],
			'salary_branch' => $post_data['salary_branch'],
			'department' => '', // Assuming not in form
			'designation' => $post_data['designation'],
			'attendance_type' => $post_data['attendance_type'],
			'photo' => '' // This will be updated after upload
		];

		// Handle photo upload logic
		$old_photo = $this->input->post('old_photo');
		if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK && $_FILES['photo']['size'] > 0) {
			$config['upload_path'] = './uploads/employee_photos/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 2048; // 2MB
			$config['encrypt_name'] = TRUE;

			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}
			$this->upload->initialize($config);

			if ($this->upload->do_upload('photo')) {
				$upload_data = $this->upload->data();
				$new_photo_filename = $upload_data['file_name'];

				// Delete old photo if new one uploaded and different
				if (!empty($old_photo) && $old_photo !== $new_photo_filename && file_exists($config['upload_path'] . $old_photo)) {
					unlink($config['upload_path'] . $old_photo);
				}
				$staff_data['photo'] = $new_photo_filename;
				$profile_data['photo'] = $new_photo_filename;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Photo upload failed: ' . strip_tags($this->upload->display_errors())]);
				return;
			}
		} else {
			// If no new photo, keep the old one
			$staff_data['photo'] = $old_photo;
			$profile_data['photo'] = $old_photo;
		}

		$this->db->trans_begin();

		try {
			if ($employee_id) { // This is an UPDATE
				$this->db->where('staff_id', $employee_id);
				$this->db->update('staff', $staff_data);

				// For profile, check if a record exists. If so, update; otherwise, insert.
				$profile_exists = $this->db->where('staff_id', $employee_id)->count_all_results('employee_profile') > 0;
				if ($profile_exists) {
					$this->db->where('staff_id', $employee_id);
					$this->db->update('employee_profile', $profile_data);
				} else {
					$profile_data['staff_id'] = $employee_id; // Set staff_id for insert
					$this->db->insert('employee_profile', $profile_data);
				}
				$message = 'Employee master data updated successfully.';
				$new_employee_id = $employee_id;
			} else { // This is an INSERT
				$this->db->insert('staff', $staff_data);
				$new_staff_id = $this->db->insert_id();

				$profile_data['staff_id'] = $new_staff_id;
				$this->db->insert('employee_profile', $profile_data);
				$new_profile_id = $this->db->insert_id(); // Get the new profile ID

				$message = 'Employee master data saved successfully.';
				$new_employee_id = $new_staff_id; // for the response
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Database transaction failed.']);
				return;
			} else {
				$this->db->trans_commit();
				
				// Set the employee ID in the session
				$new_staff_id_encoded = encryptor('encrypt', $new_employee_id);
				$this->session->set_userdata('current_staff_id_encoded', $new_staff_id_encoded);

				// If it was a new insert, set the new profile ID in session
				if (isset($new_profile_id)) {
					$this->session->set_userdata('current_profile_id_encoded', encryptor('encrypt', $new_profile_id));
				}
				
				echo json_encode([
					'status' => 'success',
					'message' => $message,
					'employee_id_encoded' => $new_staff_id_encoded,
					'new_photo_filename' => $profile_data['photo'] ?? ''
				]);
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', 'Exception in save_master_data: ' . $e->getMessage());
			echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
		}
	}

	/**
	 * Clears the currently active employee ID from the session.
	 * This is typically called when a user resets the main employee form.
	 *
	 * @return JSON response indicating success.
	 */
	public function clear_employee_session()
	{
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed.');
			return;
		}
		
		$this->session->unset_userdata('current_staff_id_encoded');
		$this->session->unset_userdata('current_profile_id_encoded');
		$this->session->unset_userdata('current_employee_id_encoded'); // Also clear the old one
		echo json_encode(['status' => 'success', 'message' => 'Session cleared.']);
	}

	/**
	 * Handles AJAX submission for the Personal form data.
	 * This method serves as a centralized endpoint for saving data from all sub-tabs
	 * under the "Personal" section. It inspects the POST data to determine which
	 * form was submitted and processes the data accordingly.
	 *
	 * @param string|null $encoded_staff_id The encrypted staff_id from the URL.
	 */
	public function save_personal_data($encoded_staff_id = null)
	{
		// 1. Get Employee ID from URL and validate
		$employee_id = 0;
		if ($encoded_staff_id) {
			$employee_id = encryptor('decrypt', $encoded_staff_id);
		}

		if (empty($employee_id) || !is_numeric($employee_id)) {
			// If no valid ID is found in the URL, as a fallback, check the hidden field from POST.
			$encoded_from_post = $this->input->post('employee_id_hidden_field');
			if ($encoded_from_post) {
				$employee_id = encryptor('decrypt', $encoded_from_post);
			}
		}
		
		// Final check, if still no valid ID, exit with error
		if (empty($employee_id) || !is_numeric($employee_id)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid or missing Employee ID.']);
			return;
		}

		$post_data = $this->input->post();

		// Ensure that the model is loaded.
		$this->load->model('mdl_employee');

		// Start transaction for atomicity
		$this->db->trans_begin();

		// Set data for validation (important when using multiple forms into one controller method)
		$this->form_validation->set_data($post_data);

		// Flag to check if any data was processed
		$data_processed = false;

		// --- 1. Save/Update Main Personal Details (employee_personal table) ---
		// Only validate if these fields are present in the POST data (i.e., submitted from personal_main.js)
		if (isset($post_data['gender'])) {
			$data_processed = true;
			// The ID from the form is the *staff_id*. We need the *employee_profile_id* for this table.
			$staff_id = $employee_id; // For clarity
			$profile = $this->db->select('employee_id')->from('employee_profile')->where('staff_id', $staff_id)->get()->row();
			if (!$profile) {
				echo json_encode(['status' => 'error', 'message' => 'Employee profile not found. Cannot save personal data.']);
				return;
			}
			$employee_profile_id = $profile->employee_id;

			// Reset and set validation rules for this section
			$this->form_validation->reset_validation();
			$this->form_validation->set_data($post_data);
			$this->form_validation->set_rules('gender', 'Gender', 'required|in_list[Male,Female,Other]');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
			$this->form_validation->set_rules('pan_no', 'PAN No', 'required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
			$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|in_list[Single,Married,Divorced,Widowed]');
			$this->form_validation->set_rules('father_name', "Father's Name", 'required|trim|max_length[100]');
			$this->form_validation->set_rules('citizenship', "Citizenship", 'required|trim|max_length[50]');
			$this->form_validation->set_rules('birth_place', "Birth Place", 'required|trim|max_length[100]');


			if ($this->form_validation->run() == FALSE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Validation failed for Personal Main data.', 'errors' => $this->form_validation->error_array()]);
				return;
			}

			$personal_main_data = [
				// staff_id in this table is FK to employee_profile.employee_id
				// This is handled by the model, which receives the correct profile ID
				'gender' => $post_data['gender'],
				'blood_group' => $post_data['blood_group'] ?? null,
				'dob' => $post_data['dob'],
				'father_name' => $post_data['father_name'] ?? null,
				'home_phone_no' => $post_data['home_phone_no'] ?? null,
				'caste' => $post_data['caste'] ?? null,
				'religion' => $post_data['religion'] ?? null,
				'citizenship' => $post_data['citizenship'] ?? null,
				'country_of_birth' => $post_data['country_of_birth'] ?? null,
				'disabilities' => $post_data['disabilities'] ?? null,
				'birth_place' => $post_data['birth_place'] ?? null,
				'marital_status' => $post_data['marital_status'],
				'marriage_date' => !empty($post_data['marriage_date']) ? $post_data['marriage_date'] : null,
				'no_of_children' => $post_data['no_of_children'] ?? null,
				'passport_name' => $post_data['name_in_passport'] ?? null,
				'passport_no' => $post_data['passport_no'] ?? null,
				'passport_valid_from' => $post_data['passport_valid_from'] ?? null,
				'passport_valid_to' => $post_data['passport_validity'] ?? null,
				'passport_issuer' => $post_data['passport_issuer'] ?? null,
				'linkedin' => $post_data['linkedin'] ?? null,
				'facebook' => $post_data['facebook'] ?? null,
				'twitter' => $post_data['twitter'] ?? null,
				'instagram' => $post_data['instagram'] ?? null,
				'pan_no' => $post_data['pan_no'],
				'aadhar_no' => $post_data['aadhar_no'] ?? null,
				'voter_id' => $post_data['voter_id'] ?? null,
				'driving_license_no' => $post_data['driving_license_no'] ?? null,
			];
			// NOTE: Email and Mobile are intentionally omitted as they are now managed
			// exclusively in the Master tab to avoid data duplication.

			if (!$this->mdl_employee->save_personal_main($employee_profile_id, $personal_main_data)) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to save Main Personal data.']);
				return;
			}
			
			// The update to staff table for email/mobile is removed from here. It's done in save_master_data.
		}


		// --- 2. Save/Update Address Details (employee_address table) ---
		if (isset($post_data['permanent_country'])) { // Check if address data is sent
			$data_processed = true;
			$this->form_validation->reset_validation(); // Reset rules for next section
			$this->form_validation->set_rules('permanent_country', 'Permanent Country', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('permanent_state', 'Permanent State', 'required|trim|max_length[100]');

			if ($this->form_validation->run() == FALSE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Validation failed for Address data.', 'errors' => $this->form_validation->error_array()]);
				return;
			}

			// Use staff_id for address tables
			$staff_id_for_address = $employee_id;

			// Current Address
			$current_address_data = [
				'staff_id' => $staff_id_for_address,
				'type' => 'current',
				'house_no' => $post_data['current_house_no'] ?? null,
				'street_no' => $post_data['current_street_no'] ?? null,
				'block_no' => $post_data['current_block_no'] ?? null,
				'period_from' => $post_data['current_period_from'] ?? null,
				'period_to' => $post_data['current_period_to'] ?? null,
				'street' => $post_data['current_street'] ?? null,
				'landmark' => $post_data['current_landmark'] ?? null,
				'post_office' => $post_data['current_post_office'] ?? null,
				'police_station' => $post_data['current_police_station'] ?? null,
				'zip_code' => $post_data['current_zip_code'] ?? null,
				'city' => $post_data['current_city'] ?? null,
				'country' => $post_data['current_country'] ?? null,
				'state' => $post_data['current_state'] ?? null,
			];
			if (!$this->mdl_employee->save_address_data($staff_id_for_address, 'current', $current_address_data)) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to save Current Address data.']);
				return;
			}

			// Permanent Address
			$permanent_address_data = [
				'staff_id' => $staff_id_for_address,
				'type' => 'permanent',
				'house_no' => $post_data['permanent_house_no'] ?? null,
				'street_no' => $post_data['permanent_street_no'] ?? null,
				'block_no' => $post_data['permanent_block_no'] ?? null,
				'period_from' => $post_data['permanent_period_from'] ?? null,
				'period_to' => $post_data['permanent_period_to'] ?? null,
				'street' => $post_data['permanent_street'] ?? null,
				'landmark' => $post_data['permanent_landmark'] ?? null,
				'post_office' => $post_data['permanent_post_office'] ?? null,
				'police_station' => $post_data['permanent_police_station'] ?? null,
				'zip_code' => $post_data['permanent_zip_code'] ?? null,
				'city' => $post_data['permanent_city'] ?? null,
				'country' => $post_data['permanent_country'],
				'state' => $post_data['permanent_state'],
			];
			if (!$this->mdl_employee->save_address_data($staff_id_for_address, 'permanent', $permanent_address_data)) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to save Permanent Address data.']);
				return;
			}
		}

		// --- 3. Save/Update Dynamic Tables via JSON data ---
		// Academic Records
		if ($this->input->post('academicRecordsJson')) {
			$data_processed = true;
			$academic_records = json_decode($this->input->post('academicRecordsJson'), true);
			if ($academic_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Academic Records data format.']);
				return;
			}
			if (!$this->mdl_employee->sync_academic_records($employee_id, $academic_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Academic Records.']);
				return;
			}
		}

		// Family Records
		if ($this->input->post('familyRecordsJson')) {
			$data_processed = true;
			$family_records = json_decode($this->input->post('familyRecordsJson'), true);
			if ($family_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Family Records data format.']);
				return;
			}
			if (!$this->mdl_employee->sync_family_records($employee_id, $family_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Family Records.']);
				return;
			}
			// Success response for SweetAlert2
			$this->db->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'Employee family details saved successfully!']);
			return;
		}

		// Nomination Records
		if ($this->input->post('nomineeRecordsJson')) {
			$data_processed = true;
			$nominee_records = json_decode($this->input->post('nomineeRecordsJson'), true);
			if ($nominee_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Nomination Records data format.']);
				return;
			}
			if (!$this->mdl_employee->sync_nominee_records($employee_id, $nominee_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Nomination Records.']);
				return;
			}
		}

		// Career Records
		if ($this->input->post('careerRecordsJson')) {
			$data_processed = true;
			$career_records = json_decode($this->input->post('careerRecordsJson'), true);
			if ($career_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Career Records data format.']);
				return;
			}
			if (!$this->mdl_employee->sync_career_records($employee_id, $career_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Career Records.']);
				return;
			}
		}

		// Emergency Records
		if ($this->input->post('emergencyRecordsJson')) {
			$data_processed = true;
			$emergency_records = json_decode($this->input->post('emergencyRecordsJson'), true);
			if ($emergency_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Emergency Records data format.']);
				return;
			}
			if (!$this->mdl_employee->sync_emergency_records($employee_id, $emergency_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Emergency Records.']);
				return;
			}
		}

		// Medical History (Single row)
		if (isset($post_data['medical_chronic_conditions']) || isset($post_data['medical_allergies']) || isset($post_data['medical_medications']) || isset($post_data['medical_past_surgeries']) || isset($post_data['medical_emergency_contact_name'])) {
			$data_processed = true;
			$this->form_validation->reset_validation();
			// Add any specific validation rules for medical data here if necessary

			if ($this->form_validation->run() == FALSE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Validation failed for Medical data.', 'errors' => $this->form_validation->error_array()]);
				return;
			}

			$medical_data = [
				'employee_id' => $employee_id,
				'chronic_conditions' => $post_data['medical_chronic_conditions'] ?? null,
				'allergies' => $post_data['medical_allergies'] ?? null,
				'medications' => $post_data['medical_medications'] ?? null,
				'past_surgeries' => $post_data['medical_past_surgeries'] ?? null,
				'emergency_contact_name' => $post_data['medical_emergency_contact_name'] ?? null,
				'emergency_contact_number' => $post_data['medical_emergency_contact_number'] ?? null,
			];
			// Only save if at least one non-employee_id field is not empty, to avoid inserting empty rows unless explicitly desired
			if (array_filter($medical_data, function($value, $key) { return $key !== 'employee_id' && !empty($value); }, ARRAY_FILTER_USE_BOTH)) {
				if (!$this->mdl_employee->save_medical_data($employee_id, $medical_data)) {
					$this->db->trans_rollback();
					echo json_encode(['status' => 'error', 'message' => 'Failed to save Medical History.']);
					return;
				}
			} else if ($this->mdl_employee->medical_record_exists($employee_id)) {
				// If all fields are empty but a record exists, consider deleting it or clearing fields
				$this->db->where('employee_id', $employee_id)->delete('employee_medical');
			}
		}


		// Attachment Records
		if ($this->input->post('attachmentRecordsJson')) {
			$data_processed = true;
			$attachment_records = json_decode($this->input->post('attachmentRecordsJson'), true);
			if ($attachment_records === null && json_last_error() !== JSON_ERROR_NONE) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invalid Attachment Records data format.']);
				return;
			}
			// NOTE: Actual file upload for attachments is NOT handled here.
			// It's assumed either they are uploaded separately, or your JS logic for 'addAttachmentRecord'
			// will handle individual file uploads to a temporary location and send the path/name.
			// For now, this just saves the metadata sent from JS.
			if (!$this->mdl_employee->sync_attachment_records($employee_id, $attachment_records ?? [])) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to sync Attachment Records.']);
				return;
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save personal data due to a transaction error.']);
		} else {
			if ($data_processed) {
				$this->db->trans_commit();
				echo json_encode(['status' => 'success', 'message' => 'Personal data sections saved successfully!']);
			} else {
				$this->db->trans_rollback(); // No data was processed, so nothing to commit.
				echo json_encode(['status' => 'info', 'message' => 'No personal data submitted for saving.']);
			}
		}
	}

	/**
	 * Handles AJAX submission for the Payment form data.
	 * Inserts/updates `employee_payment_details` table.
	 *
	 * @return JSON response indicating success or failure.
	 */
	public function save_payment_data()
	{
		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo json_encode(['status' => 'error', 'message' => 'No direct script access allowed.']);
			return;
		}

		$employee_id_encoded = $this->input->post('employee_id_hidden_field');
		$employee_id = ($employee_id_encoded) ? encryptor("decrypt", $employee_id_encoded) : null;
		if (!$employee_id) {
			echo json_encode(['status' => 'error', 'message' => 'Employee ID is missing. Please save Master data first.']);
			return;
		}

		$post_data = $this->input->post();

		$this->form_validation->set_data($post_data);
		$this->form_validation->set_rules('payment_percent', 'Payment Percent 1', 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		$this->form_validation->set_rules('payment_percent2', 'Payment Percent 2', 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		// Add more validation rules as per your business logic and table constraints for other fields

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Validation failed for Payment data.', 'errors' => $this->form_validation->error_array()]);
			return;
		}

		$payment_data = [
			'employee_id' => $employee_id,
			'payment_type' => $post_data['payment_type'] ?? null,
			'payment_percent' => $post_data['payment_percent'] ?? 0,
			'payment_type2' => $post_data['payment_type2'] ?? null,
			'payment_percent2' => $post_data['payment_percent2'] ?? 0,
			'bank_name' => $post_data['payment_bank_name'] ?? null,
			'branch' => $post_data['payment_branch'] ?? null,
			'ifsc_code' => $post_data['payment_ifsc_code'] ?? null,
			'account_no' => $post_data['payment_account_no'] ?? null,
			'beneficiary_name' => $post_data['payment_beneficiary_name'] ?? null,
			'name_in_bank' => $post_data['payment_name_in_bank'] ?? null,
		];

		$this->db->trans_begin();
		if (!$this->mdl_employee->save_payment_details($employee_id, $payment_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Payment data.']);
			return;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Payment data due to a transaction error.']);
		} else {
			$this->db->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'Payment data saved successfully!']);
		}
	}

	/**
	 * Handles AJAX submission for the Administration form data.
	 * Inserts/updates 'employee_administration' table.
	 *
	 * @return JSON response indicating success or failure.
	 */
	public function save_admin_data()
	{
		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo json_encode(['status' => 'error', 'message' => 'No direct script access allowed.']);
			return;
		}

		$employee_id_encoded = $this->input->post('employee_id_hidden_field');
		$employee_id = ($employee_id_encoded) ? encryptor("decrypt", $employee_id_encoded) : null;
		if (!$employee_id) {
			echo json_encode(['status' => 'error', 'message' => 'Employee ID is missing. Please save Master data first.']);
			return;
		}

		$post_data = $this->input->post();

		$this->form_validation->set_data($post_data);
		$this->form_validation->set_rules('admin_probation_period', 'Probation Period', 'numeric|greater_than_equal_to[0]');
		$this->form_validation->set_rules('admin_notice_period', 'Notice Period', 'numeric|greater_than_equal_to[0]');
		// Add more validation rules as needed

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Validation failed for Administration data.', 'errors' => $this->form_validation->error_array()]);
			return;
		}

		$admin_data = [
			'employee_id' => $employee_id,
			'start_date' => $post_data['admin_start_date'] ?? null,
			'status' => $post_data['admin_status'] ?? null,
			'probation_period' => $post_data['admin_probation_period'] ?? null,
			'confirmation_date' => $post_data['admin_confirmation_date'] ?? null,
			'grade' => $post_data['admin_grade'] ?? null,
			'division' => $post_data['admin_division'] ?? null,
			'job_title' => $post_data['admin_job_title'] ?? null,
			'notice_period' => $post_data['admin_notice_period'] ?? null,
			'attendance_cycle' => $post_data['admin_attendance_cycle'] ?? null,
			'shift' => $post_data['admin_shift'] ?? null,
			'manager_id' => $post_data['admin_manager'] ?? null,
			'manager_name' => $post_data['admin_manager_name'] ?? null,
			'resignation_date' => $post_data['admin_resignation_date'] ?? null,
			'resp_acceptance' => $post_data['admin_resp_acceptance'] ?? null,
			'reason_for_leaving' => $post_data['admin_reason_for_leaving'] ?? null,
			'last_working_date' => $post_data['admin_last_working_date'] ?? null,
			'old_emp_code' => $post_data['admin_old_emp_code'] ?? null,
			'old_emp_code_name' => $post_data['admin_old_emp_code_name'] ?? null,
			'initial_joining_date' => $post_data['admin_initial_joining_date'] ?? null,
		];

		$this->db->trans_begin();
		if (!$this->mdl_employee->save_admin_details($employee_id, $admin_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Administration data.']);
			return;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Administration data due to a transaction error.']);
		} else {
			$this->db->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'Administration data saved successfully!']);
		}
	}

	/**
	 * Handles AJAX submission for the Statutory form data.
	 * Inserts/updates various statutory tables (PF, ESI, PT).
	 *
	 * @return JSON response indicating success or failure.
	 */
	public function save_statutory_data()
	{
		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo json_encode(['status' => 'error', 'message' => 'No direct script access allowed.']);
			return;
		}

		$employee_id_encoded = $this->input->post('employee_id_hidden_field');
		$employee_id = ($employee_id_encoded) ? encryptor("decrypt", $employee_id_encoded) : null;
		if (!$employee_id) {
			echo json_encode(['status' => 'error', 'message' => 'Employee ID is missing. Please save Master data first.']);
			return;
		}

		$post_data = $this->input->post();

		// No specific validation rules for statutory section provided in original form, add as needed.
		$this->form_validation->set_data($post_data);
		// Example: $this->form_validation->set_rules('stat_pf_ac_no', 'PF A/C No', 'alpha_numeric|max_length[50]');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Validation failed for Statutory data.', 'errors' => $this->form_validation->error_array()]);
			return;
		}

		$this->db->trans_begin();

		// Provident Fund Details
		$pf_data = [
			'employee_id' => $employee_id,
			'pf_ac_no' => $post_data['stat_pf_ac_no'] ?? null,
			'pf_joining_date' => $post_data['stat_pf_joining_date'] ?? null,
			'pf_uan' => $post_data['stat_pf_uan'] ?? null,
			'pf_settlement' => $post_data['stat_pf_settlement'] ?? null,
		];
		if (!$this->mdl_employee->save_pf_details($employee_id, $pf_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Provident Fund data.']);
			return;
		}

		// EPS Details
		$eps_data = [
			'employee_id' => $employee_id,
			'eps_ac_no' => $post_data['stat_eps_ac_no'] ?? null,
			'eps_joining_date' => $post_data['stat_eps_joining_date'] ?? null,
		];
		if (!$this->mdl_employee->save_eps_details($employee_id, $eps_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save EPS data.']);
			return;
		}

		// ESI Details
		$esi_data = [
			'employee_id' => $employee_id,
			'esi_ac_no' => $post_data['stat_esi_ac_no'] ?? null,
			'esi_joining_date' => $post_data['stat_esi_joining_date'] ?? null,
			'esi_locality' => $post_data['stat_esi_locality'] ?? null,
			'esi_dispensary' => $post_data['stat_esi_dispensary'] ?? null,
			'esi_doctor_code' => $post_data['stat_esi_doctor_code'] ?? null,
			'esi_doctor_name' => $post_data['stat_esi_doctor_name'] ?? null,
		];
		if (!$this->mdl_employee->save_esi_details($employee_id, $esi_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save ESI data.']);
			return;
		}

		// Professional Tax Details
		$ptax_data = [
			'employee_id' => $employee_id,
			'ptax_region' => $post_data['stat_ptax_region'] ?? null,
		];
		if (!$this->mdl_employee->save_ptax_details($employee_id, $ptax_data)) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Professional Tax data.']);
			return;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to save Statutory data due to a transaction error.']);
		} else {
			$this->db->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'Statutory data saved successfully!']);
		}
	}


	/**
	 * Handles deletion of an employee and all their associated records.
	 *
	 * @param string $encoded_id The encoded employee ID to delete.
	 * @return JSON response indicating success or failure.
	 */
	public function delete($encoded_id)
	{
		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo json_encode(['status' => 'error', 'message' => 'No direct script access allowed.']);
			return;
		}

		$employee_id = encryptor("decrypt", $encoded_id);
		if (!$employee_id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid employee ID provided for deletion.']);
			return;
		}

		if ($this->mdl_employee->delete_employee($employee_id)) {
			echo json_encode(['status' => 'success', 'message' => 'Employee and all associated data deleted successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to delete employee data.']);
		}
	}


	/**
	 * Retrieves employee records for DataTables display.
	 *
	 * @return JSON response with DataTables formatted data.
	 */
	public function getrecord()
	{
		// DataTables parameters
		$draw = $this->input->get('draw');
		$start = $this->input->get('start');
		$length = $this->input->get('length');
		$search_value = $this->input->get('search')['value'] ?? '';
		$order_column_index = $this->input->get('order')[0]['column'] ?? 0;
		$order_dir = $this->input->get('order')[0]['dir'] ?? 'asc';

		// Map DataTables column index to actual database column name for ordering.
		$orderable_columns = [
			'staff_id',      // For Sr. No. (not a DB column, but index 0 in DT)
			'emp_no',        // Employee Code
			'staff_name',    // Name
			'employment_type', // Employment Type
			'designation',   // Designation
			'posting_city'   // Posting City
		];
		$order_field = $orderable_columns[$order_column_index] ?? 'staff_id'; // Default to staff_id if not found

		$temp = $this->mdl_employee->get_employee_for_datatables($start, $length, $search_value, $order_field, $order_dir);

		$data_output = [];
		$sl_no = $start;

		// Check if we have any data
		if (empty($temp['data'])) {
			// No employees found
			echo json_encode([
				"draw" => $draw,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => [],
				"message" => "No employees found"
			]);
			return;
		}

		foreach ($temp['data'] as $row) {
			$encoded_id = encryptor("encrypt", $row['employee_id']);
			$action_buttons = '<div class="btn-group">
				<a href="' . site_url('employee/add/' . $encoded_id) . '" class="btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
				<button type="button" class="btn btn-danger btn-sm btn_deleterecord" refid="' . $encoded_id . '" title="Delete"><i class="fa fa-trash"></i></button>
			</div>';
			
			$data_output[] = [
				++$sl_no,
				$row['employee_code'] ?? 'N/A',
				$row['full_name'] ?? 'N/A',
				$row['employment_type_name'] ?? 'N/A',
				$row['designation_name'] ?? 'N/A',
				$row['posting_city_name'] ?? 'N/A',
				$action_buttons
			];
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $temp['recordsTotal'],
			"recordsFiltered" => $temp['recordsFiltered'],
			"data" => $data_output
		]);
	}


	/**
	 * Fetches all places (cities) from the database for dropdowns.
	 *
	 * @return JSON response of places.
	 */
	public function get_places() {
		if(!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$places = $this->Mdl_place->get_places(); // Mdl_place should fetch place_id, place_name, state_code
		echo json_encode($places);
	}

	/**
	 * Fetches all employment types from the database for dropdowns.
	 *
	 * @return JSON response of employment types.
	 */
	public function get_employment_types() {
		if(!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$types = $this->db->select('employee_type_id, type_name')
			->from('employee_type')
			->where('is_deleted', 0)
			->get()
			->result_array();
		echo json_encode($types);
	}

	/**
	 * Fetches designations based on a given employee type ID.
	 *
	 * @return JSON response of designations.
	 */
	public function get_designations() {
		if(!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$employee_type_id = $this->input->get('employee_type_id');
		if(!$employee_type_id) {
			echo json_encode([]);
			return;
		}
		$designations = $this->db->select('designation_id, designation_name')
			->from('designations')
			->where('employee_type_id', $employee_type_id)
			->where('is_deleted', 0)
			->get()
			->result_array();
		echo json_encode($designations);
	}

	/**
	 * Fetches designations based on a given employee type ID.
	 *
	 * @return JSON response of designations.
	 */
	public function get_designations_by_type()
	{
		$type_id = $this->input->post('employee_type_id');
		if (!$type_id) {
			echo json_encode([]);
			return;
		}
		
		$designations = $this->db
			->select('designation_id, designation_name')
			->from('designations')
			->where('employee_type_id', $type_id)
			->where('is_deleted', 0)
			->get()
			->result_array();
			
		echo json_encode($designations);
	}

	/**
	 * Generates the next employee code based on the state code and last employee number.
	 *
	 * @return JSON response with the generated employee code.
	 */
	public function get_next_employee_code()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		$state_code = $this->input->post('state_code'); // This should be a 2-letter state code like 'JH', 'UP' etc.

		$next_number = 1;
		$prefix = "ESPL"; // Default prefix

		// Get the last employee number from the `staff` table.
		// It's assumed that `emp_no` is in the format 'ESPL[STATE_CODE]-[NUMBER]' or 'ESPLYY-NUMBER'
		$this->db->select('emp_no');
		$this->db->from('staff');
		$this->db->order_by('staff_id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$last_employee = $query->row();

		if ($last_employee && !empty($last_employee->emp_no)) {
			// Use regex to extract the numeric part of the employee code, even with prefixes like ESPL, ESPLUP-, etc.
			if (preg_match('/[A-Z]+(\d+)-(\d+)/', $last_employee->emp_no, $matches) || preg_match('/-(\d+)$/', $last_employee->emp_no, $matches)) {
				$last_number_part = intval(end($matches));
				$next_number = $last_number_part + 1;
			} else {
				$next_number = 1; // Fallback if no number is found
			}
		}


		// Construct the new employee code using the provided state_code (if available)
		if (!empty($state_code)) {
			$employee_code = 'ESPL' . strtoupper($state_code) . '-' . str_pad($next_number, 3, '0', STR_PAD_LEFT); // e.g. ESPLJH-001
		} else {
			// Fallback: use a generic prefix if no state code is provided.
			$employee_code = 'ESPL-' . str_pad($next_number, 3, '0', STR_PAD_LEFT); // e.g., ESPL-001
		}

		echo json_encode(['employee_code' => $employee_code]);
	}

	/**
	 * Handles AJAX deletion of employee records.
	 * This method is called from the employee list page.
	 *
	 * @return string "true" on success, "false" on failure.
	 */
	public function deleterecord()
	{
		if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
			echo "false";
			return;
		}

		$encoded_id = $this->input->post('delete');
		if (!$encoded_id) {
			echo "false";
			return;
		}

		$employee_id = encryptor("decrypt", $encoded_id);
		if (!$employee_id) {
			echo "false";
			return;
		}

		// Soft delete from staff table
		$this->db->where('staff_id', $employee_id);
		$result = $this->db->update('staff', ['is_deleted' => 1]);
		
		if ($result) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/**
	 * Displays the add employee form in a modal popup.
	 * Used by the employee list page.
	 */
	public function addpopup() {
		$data['title'] = "Add Employee";
		$data['condition'] = 'popup';
		
		// Load necessary data for dropdowns
		$data['places'] = $this->Mdl_place->get_places();
		$data['employee_types'] = $this->db->select('employee_type_id, type_name')
			->from('employee_type')
			->where('is_deleted', 0)
			->get()
			->result_array();
		
		// Generate new employee code for the popup form
		$this->db->select_max('staff_id');
		$query = $this->db->get('staff');
		$last_id_row = $query->row();
		$last_id = $last_id_row ? (int)$last_id_row->staff_id : 0;
		$new_id = $last_id + 1;
		$new_employee_code = 'ESPL-' . str_pad($new_id, 3, '0', STR_PAD_LEFT);
		
		// Initialize empty employee data for new employee
		$data['employee_data'] = [
			'master_data' => [
				'staff_id' => '',
				'emp_no' => $new_employee_code,
				'staff_name' => '',
				'employee_type_id' => '',
				'location' => '',
				'email_id' => '',
				'mobile_no' => ''
			]
		];
		
		$this->load->view('employee/employee_form', $data);
	}

	/**
	 * Displays the edit employee form in a modal popup.
	 * Used by the employee list page.
	 */
	public function editpopup() {
		$data['title'] = "Edit Employee";
		$data['condition'] = 'popup';
		
		$encoded_id = $this->input->get('id');
		if (!$encoded_id) {
			echo "Invalid employee ID";
			return;
		}
		
		$employee_id = encryptor("decrypt", $encoded_id);
		if (!$employee_id) {
			echo "Invalid employee ID";
			return;
		}
		
		// Load necessary data for dropdowns
		$data['places'] = $this->Mdl_place->get_places();
		$data['employee_types'] = $this->db->select('employee_type_id, type_name')
			->from('employee_type')
			->where('is_deleted', 0)
			->get()
			->result_array();
		
		// Load employee data from staff table
		$staff_data = $this->db->select('*')
			->from('staff')
			->where('staff_id', $employee_id)
			->where('is_deleted', 0)
			->get()
			->row_array();
		
		if ($staff_data) {
			// Split the full name into parts
			$name_parts = explode(' ', $staff_data['staff_name'], 3);
			$staff_data['first_name'] = $name_parts[0] ?? '';
			$staff_data['middle_name'] = count($name_parts) > 2 ? $name_parts[1] : '';
			$staff_data['last_name'] = count($name_parts) > 2 ? $name_parts[2] : ($name_parts[1] ?? '');

			$data['employee_data'] = [
				'master_data' => $staff_data
			];
			$data['employee_id_encoded'] = $encoded_id;
			
			// Load designations based on employee type
			if (isset($staff_data['employee_type_id'])) {
				$employee_type_id = $staff_data['employee_type_id'];
				$data['employee_data']['designations'] = $this->db->select('designation_id, designation_name')
					->from('designations')
					->where('employee_type_id', $employee_type_id)
					->where('is_deleted', 0)
					->get()
					->result_array();
			}
		} else {
			echo "Employee not found";
			return;
		}
		
		$this->load->view('employee/employee_form', $data);
	}

	// --- Old methods from original controller, likely deprecated. ---
	public function edit($id) {
		$this->add($id);
	}
	public function update_master($id) {
		echo json_encode(['status' => 'error', 'message' => 'This method is deprecated. Use save_master_data.']);
	}
	public function deletebyid() {
		echo json_encode(['status' => 'error', 'message' => 'This method is deprecated. Use the delete route.']);
	}
	public function getEmployeeByConsignorId() {
		if(!$this->input->is_ajax_request()) exit('No direct script access allowed');
		echo json_encode($this->mdl_employee->getEmployeeByConsignor($this->input->post('consignor_id')));
	}
	public function get_last_emp_no() {
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		
		// A more robust way to get the next employee code
		$this->db->select('emp_no');
		$this->db->from('staff');
		$this->db->order_by('staff_id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$last_employee = $query->row();

		$next_number = 1;
		if ($last_employee && !empty($last_employee->emp_no)) {
			// Regex to find the numeric part of the employee code
			if (preg_match('/(\d+)$/', $last_employee->emp_no, $matches)) {
				$last_number_part = intval($matches[1]);
				$next_number = $last_number_part + 1;
			}
		}
		
		// Format the new employee code, e.g., ESPL-012
		$new_employee_code = 'ESPL-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);

		echo json_encode(['status' => 'success', 'employee_code' => $new_employee_code]);
	}
	public function save_all() {
		echo json_encode(['status' => 'error', 'message' => 'This method is deprecated.']);
	}
	public function save() {
		echo json_encode(['status' => 'error', 'message' => 'This method is deprecated.']);
	}

	public function log_family_form_activity() {
		$logDir = APPPATH . 'logs/';
		if (!is_dir($logDir)) mkdir($logDir, 0777, true);
		$date = date('Y-m-d');
		$logFile = $logDir . 'form_validation_' . $date . '.log';
		$logData = $this->input->post('log');
		$entry = '[' . date('Y-m-d H:i:s') . '] ' . $logData . "\n";
		file_put_contents($logFile, $entry, FILE_APPEND);
		echo json_encode(['status' => 'success']);
	}
}
