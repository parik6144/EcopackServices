<?php
/**
 * Mdl_employee CI_Model
 *
 * This model handles all database interactions for employee management,
 * including primary employee data (staff, employee_profile) and
 * related sub-sections (personal, address, academic, family, etc.).
 *
 */
class Mdl_employee extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrieves all employees from `employee_profile` for display.
	 *
	 * @return array An array of employee records.
	 */
	public function get_all_employees_profile()
	{
		// This method is primarily for a general list if not using DataTables directly.
		// For DataTables, `get_employee_for_datatables` is used.
		return $this->db->get('employee_profile')->result_array();
	}

	/**
	 * Retrieves an employee's master profile by their ID.
	 *
	 * @param int $employee_id The ID of the employee (from employee_profile).
	 * @return array|null An associative array of the employee's master profile, or null if not found.
	 */
	public function get_master_profile_by_id($employee_id)
	{
		return $this->db->get_where('employee_profile', ['employee_id' => $employee_id])->row_array();
	}

	/**
	 * Retrieves full employee profile for editing, joining relevant tables.
	 * This method needs to fetch data for all sections of the form.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @return array An associative array containing employee data from various tables.
	 */
	public function get_employee_full_profile($employee_id) {
		$data = [];

		// Fetch Master data from employee_profile and staff
		$master = $this->db->select('ep.*, s.emp_no, s.staff_name, s.email_id, s.mobile_no')
			->from('employee_profile ep')
			->join('staff s', 'ep.employee_id = s.staff_id', 'left')
			->where('ep.employee_id', $employee_id)
			->get()->row_array();
		if ($master) {
			$data['master_data'] = $master;
		}

		// Fetch Personal Main data
		$personal_main = $this->db->get_where('employee_personal', ['staff_id' => $employee_id])->row_array();
		if ($personal_main) {
			$data['personal_main_data'] = $personal_main;
		}

		// Fetch Address data (current and permanent)
		$address = $this->db->get_where('employee_address', ['employee_id' => $employee_id])->result_array();
		if (!empty($address)) {
			foreach ($address as $addr) {
				if ($addr['type'] == 'current') {
					$data['current_address'] = $addr;
				} else if ($addr['type'] == 'permanent') {
					$data['permanent_address'] = $addr;
				}
			}
		}

		// Fetch Academic Records (multiple rows)
		$data['academic_records'] = $this->db->get_where('employee_academic', ['employee_id' => $employee_id])->result_array();

		// Fetch Family Records (multiple rows)
		$data['family_records'] = $this->db->get_where('employee_family', ['employee_id' => $employee_id])->result_array();

		// Assuming tables exist for these, you'd add similar fetches:
		$data['nomination_records'] = $this->db->get_where('employee_nomination', ['employee_id' => $employee_id])->result_array();
		$data['career_records'] = $this->db->get_where('employee_career', ['employee_id' => $employee_id])->result_array();
		$data['medical_data'] = $this->db->get_where('employee_medical', ['employee_id' => $employee_id])->row_array();
		$data['emergency_records'] = $this->db->get_where('employee_emergency', ['employee_id' => $employee_id])->result_array();
		$data['attachment_records'] = $this->db->get_where('employee_attachments', ['employee_id' => $employee_id])->result_array();
		$data['payment_details'] = $this->db->get_where('employee_payment_details', ['employee_id' => $employee_id])->row_array();
		$data['admin_details'] = $this->db->get_where('employee_administration', ['employee_id' => $employee_id])->row_array();
		$data['pf_details'] = $this->db->get_where('employee_provident_fund', ['employee_id' => $employee_id])->row_array();
		$data['eps_details'] = $this->db->get_where('employee_eps', ['employee_id' => $employee_id])->row_array();
		$data['esi_details'] = $this->db->get_where('employee_esi', ['employee_id' => $employee_id])->row_array();
		$data['ptax_details'] = $this->db->get_where('employee_professional_tax', ['employee_id' => $employee_id])->row_array();

		return $data;
	}

	/**
	 * Retrieves complete employee data for editing, using staff_id as the entry point.
	 * This is the corrected version for fetching all related data.
	 *
	 * @param int $staff_id The ID from the `staff` table.
	 * @return array An associative array containing all employee data.
	 */
	public function get_full_employee_data_by_staff_id($staff_id) {
		$data = [];

		// 1. Fetch Master and Profile data
		$profile_query = $this->db->select('s.*, ep.employee_id as profile_id, ep.posting_city, ep.department, ep.project')
			->from('staff s')
			->join('employee_profile ep', 's.staff_id = ep.staff_id', 'left')
			->where('s.staff_id', $staff_id)
			->get();

		if ($profile_query->num_rows() === 0) {
			return null; // Employee not found
		}

		$master_data = $profile_query->row_array();
		$employee_profile_id = $master_data['profile_id'];

		// Split name for the form
		$name_parts = explode(' ', $master_data['staff_name'], 3);
		$master_data['first_name'] = $name_parts[0] ?? '';
		$master_data['middle_name'] = count($name_parts) > 2 ? $name_parts[1] : '';
		$master_data['last_name'] = count($name_parts) > 2 ? $name_parts[2] : ($name_parts[1] ?? '');

		$data['master_data'] = $master_data;

		if (!$employee_profile_id) {
			// Profile record might not exist yet, which is a possible state.
			// The calling controller should handle this.
			return $data;
		}

		// 2. Fetch all other data using the employee_profile_id
		// NOTE: The foreign key in `employee_personal` is confusingly named `staff_id`,
		// but it correctly refers to `employee_profile.employee_id`.
		$data['personal_main_data'] = $this->db->get_where('employee_personal', ['staff_id' => $employee_profile_id])->row_array();

		// Address data
		$addresses = $this->db->get_where('employee_address', ['staff_id' => $staff_id])->result_array();
		foreach ($addresses as $addr) {
			if ($addr['type'] === 'current') {
				$data['current_address_data'] = $addr;
			} else if ($addr['type'] === 'permanent') {
				$data['permanent_address_data'] = $addr;
			}
		}

		// Family records
		$data['family_records'] = $this->db->get_where('employee_family', ['employee_id' => $employee_profile_id])->result_array();

		// Academic records
		$data['academic_records'] = $this->db->get_where('employee_academic', ['staff_id' => $staff_id])->result_array();
		
		// Add other fetches as needed, e.g., nomination, career, etc.
		// These tables might not exist yet based on the provided SQL dump, so check before adding.
		if ($this->db->table_exists('employee_nomination')) {
			$data['nomination_records'] = $this->db->get_where('employee_nomination', ['employee_id' => $employee_profile_id])->result_array();
		}
		if ($this->db->table_exists('employee_career')) {
			$data['career_records'] = $this->db->get_where('employee_career', ['employee_id' => $employee_profile_id])->result_array();
		}
		if ($this->db->table_exists('employee_medical')) {
			$data['medical_data'] = $this->db->get_where('employee_medical', ['employee_id' => $employee_profile_id])->row_array();
		}
		if ($this->db->table_exists('employee_emergency_contacts')) {
			$data['emergency_records'] = $this->db->get_where('employee_emergency_contacts', ['employee_id' => $employee_profile_id])->result_array();
		}
		// ... and so on for other tables ...

		return $data;
	}

	/**
	 * Inserts master employee data into `employee_profile` and `staff` tables.
	 *
	 * @param array $master_data Data for `employee_profile`.
	 * @param array $staff_data Data for `staff` table.
	 * @return int|bool The newly inserted employee_id (staff_id) on success, or false on failure.
	 */
	public function insert_master_data($master_data, $staff_data)
	{
		$this->db->trans_begin();

		$this->db->insert('staff', $staff_data);
		$new_staff_id = $this->db->insert_id();

		if ($new_staff_id) {
			$master_data['employee_id'] = $new_staff_id; // Link employee_profile to staff
			$this->db->insert('employee_profile', $master_data);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return false;
			} else {
				$this->db->trans_commit();
				return $new_staff_id;
			}
		} else {
			$this->db->trans_rollback();
			return false;
		}
	}

	/**
	 * Updates master employee data in `employee_profile` and `staff` tables.
	 *
	 * @param int $employee_id The ID of the employee to update.
	 * @param array $master_data Data for `employee_profile`.
	 * @param array $staff_data Data for `staff` table.
	 * @return bool True on success, false on failure.
	 */
	public function update_master_data($employee_id, $master_data, $staff_data)
	{
		$this->db->trans_begin();

		$this->db->where('staff_id', $employee_id)->update('staff', $staff_data);
		$this->db->where('employee_id', $employee_id)->update('employee_profile', $master_data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

	/**
	 * Private helper function to perform an "upsert" (update or insert) operation.
	 * Checks if a record exists based on a condition and updates it, otherwise inserts.
	 * Used for single-row sections like Personal Main, Payment, Admin, Statutory sub-sections.
	 *
	 * @param string $table_name The name of the table.
	 * @param array $condition Associative array for the WHERE clause (e.g., ['employee_id' => 1]).
	 * @param array $data Associative array of data to insert or update.
	 * @return bool True on success, false on failure.
	 */
	private function _upsert_single_record($table_name, $condition, $data) {
		$this->db->where($condition);
		$query = $this->db->get($table_name);

		if ($query->num_rows() > 0) {
			// Record exists, update it
			$this->db->where($condition);
			return $this->db->update($table_name, $data);
		} else {
			// Record does not exist, insert it
			$data_to_insert = array_merge($condition, $data);
			return $this->db->insert($table_name, $data_to_insert);
		}
	}

	/**
	 * Checks if a medical record exists for a given employee.
	 *
	 * @param int $employee_id The employee's ID.
	 * @return bool True if a record exists, false otherwise.
	 */
	public function medical_record_exists($employee_id) {
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_medical');
		return $query->num_rows() > 0;
	}

	/**
	 * Private helper function to synchronize dynamic records (e.g., academic, family).
	 * It deletes all existing records for the given employee_id and then inserts the new set.
	 * This assumes the frontend sends the *complete* current state of the dynamic table.
	 *
	 * @param string $table_name The name of the table.
	 * @param string $fk_field The foreign key field linking to the employee (e.g., 'employee_id').
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of associative arrays, each representing a row to be inserted.
	 * @return bool True on success, false on failure.
	 */
	private function _sync_dynamic_records($table_name, $fk_field, $employee_id, $records) {
		// Delete all existing records for this employee for the given table
		$this->db->where($fk_field, $employee_id)->delete($table_name);

		if (!empty($records)) {
			$insert_batch_data = [];
			foreach ($records as $record) {
				// Ensure the foreign key is set for each record
				$record[$fk_field] = $employee_id;
				$insert_batch_data[] = $record;
			}
			if (!empty($insert_batch_data)) {
				return $this->db->insert_batch($table_name, $insert_batch_data);
			}
		}
		return true; // No records to insert, or delete was successful
	}

	/**
	 * Saves or updates the main personal details.
	 *
	 * @param int $employee_profile_id The ID of the employee from `employee_profile` table (PK).
	 * @param array $data The data for `employee_personal`.
	 * @return bool True on success, false on failure.
	 */
	public function save_personal_main($employee_profile_id, $data) {
		// This logic handles both insert and update (upsert)
		// It checks if a record for the given employee_profile_id already exists.
		// NOTE: The column in `employee_personal` is `staff_id` but it holds `employee_profile_id`.
		$this->db->where('staff_id', $employee_profile_id);
		$q = $this->db->get('employee_personal');

		if ($q->num_rows() > 0) {
			// Record exists, so update it
			$this->db->where('staff_id', $employee_profile_id);
			return $this->db->update('employee_personal', $data);
		} else {
			// No record, so insert a new one
			$data['staff_id'] = $employee_profile_id; // Ensure the ID is in the data array for insert
			return $this->db->insert('employee_personal', $data);
		}
	}

	/**
	 * Saves or updates employee address details (current/permanent).
	 *
	 * @param int $staff_id The ID of the employee.
	 * @param string $type The type of address ('current' or 'permanent').
	 * @param array $data The data for `employee_address`.
	 * @return bool True on success, false on failure.
	 */
	public function save_address_data($staff_id, $type, $data) {
		$data['staff_id'] = $staff_id;
		return $this->_upsert_single_record('employee_address', ['staff_id' => $staff_id, 'type' => $type], $data);
	}

	/**
	 * Synchronizes academic records for an employee.
	 *
	 * @param int $staff_id The ID of the employee.
	 * @param array $records An array of academic record data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_academic_records($staff_id, $records) {
		// Frontend data names to DB column names mapping
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'staff_id' => $staff_id,
				'from_year' => $rec['fromYear'] ?? null,
				'to_year' => $rec['toYear'] ?? null,
				'examination' => $rec['examination'] ?? null,
				'certification_type' => $rec['certificationType'] ?? null,
				'certification' => $rec['certification'] ?? null,
				'institute' => $rec['institute'] ?? null,
				'subject' => $rec['subject'] ?? null,
				'grade' => $rec['grade'] ?? null,
				'university' => $rec['university'] ?? null,
				'college_contact_no' => $rec['collegeContactNo'] ?? null,
				'college_address' => $rec['collegeAddress'] ?? null,
				'program' => $rec['program'] ?? null,
				'registration_no' => $rec['registrationNo'] ?? null,
				'roll_no' => $rec['rollNo'] ?? null,
				'university_country' => $rec['universityCountry'] ?? null,
				'university_state' => $rec['universityState'] ?? null,
				'university_city' => $rec['universityCity'] ?? null,
				'university_contact_no' => $rec['universityContactNo'] ?? null,
				'educated_in_overseas' => $rec['educatedInOverseas'] ?? null,
			];
		}
		return $this->_sync_dynamic_records('employee_academic', 'staff_id', $staff_id, $mapped_records);
	}

	/**
	 * Synchronizes family records for an employee.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of family record data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_family_records($employee_id, $records) {
		// Get staff_id from employee_profile
		$profile = $this->db->select('staff_id')->from('employee_profile')->where('employee_id', $employee_id)->get()->row();
		$staff_id = $profile ? $profile->staff_id : null;
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'employee_id' => $employee_id,
				'staff_id' => $staff_id,
				'first_name' => $rec['firstName'] ?? null,
				'middle_name' => $rec['middleName'] ?? null,
				'last_name' => $rec['lastName'] ?? null,
				'relation' => $rec['relation'] ?? null,
				'gender' => $rec['gender'] ?? null,
				'dob' => $rec['dob'] ?? null,
				'contact_no' => $rec['contactNo'] ?? null,
				'dependent' => $rec['dependent'] ?? null,
				'residing_with_employee' => $rec['residingWithEmployee'] ?? null,
				'email_id' => $rec['emailId'] ?? null,
				'address' => $rec['address'] ?? null,
				'aadhar_no' => $rec['aadharNo'] ?? null,
			];
		}
		return $this->_sync_dynamic_records('employee_family', 'employee_id', $employee_id, $mapped_records);
	}

	/**
	 * Synchronizes nominee records for an employee.
	 * Assumes 'employee_nomination' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of nominee record data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_nominee_records($employee_id, $records) {
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'employee_id' => $employee_id,
				'nominee_name' => $rec['name'] ?? null,
				'nominee_relation' => $rec['relation'] ?? null,
				'nominee_percentage' => (float)str_replace('%', '', $rec['percentage'] ?? 0), // Remove % and convert to float
				'nominee_contact' => $rec['contact'] ?? null,
				'nominee_address' => $rec['address'] ?? null,
			];
		}
		return $this->_sync_dynamic_records('employee_nomination', 'employee_id', $employee_id, $mapped_records);
	}

	/**
	 * Synchronizes career/employment records for an employee.
	 * Assumes 'employee_career' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of career record data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_career_records($employee_id, $records) {
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'employee_id' => $employee_id,
				'from_date' => $rec['fromDate'] ?? null,
				'to_date' => $rec['toDate'] ?? null,
				'employer' => $rec['employer'] ?? null,
				'employer_code' => $rec['employerCode'] ?? null,
				'employment_status' => $rec['employmentStatus'] ?? null,
				'position' => $rec['position'] ?? null,
				'address' => $rec['address'] ?? null,
				'starting_salary' => $rec['startingSalary'] ?? null,
				'starting_other_compensation' => $rec['startingOtherComp'] ?? null,
				'final_salary' => $rec['finalSalary'] ?? null,
				'final_other_compensation' => $rec['finalOtherComp'] ?? null,
				'responsibility' => $rec['responsibility'] ?? null,
				'achievement' => $rec['achievement'] ?? null,
				'reason_for_change' => $rec['reasonForChange'] ?? null,
				'contact_person' => $rec['contactPerson'] ?? null,
				'contact_person_job_title' => $rec['contactPersonJobTitle'] ?? null,
				'contact_person_department' => $rec['contactPersonDepartment'] ?? null,
				'contact_person_mobile_no' => $rec['contactPersonMobileNo'] ?? null,
				'contact_person_email' => $rec['contactPersonEmail'] ?? null,
				'company_website' => $rec['companyWebsite'] ?? null,
				'uan_no' => $rec['uanNo'] ?? null,
				'epf_ac_no' => $rec['epfAcNo'] ?? null,
				'epf_region' => $rec['epfRegion'] ?? null,
				'esi_ac_no' => $rec['esiAcNo'] ?? null,
				'scheme_certificate_no' => $rec['schemeCertificateNo'] ?? null,
				'pension_payment_order_no' => $rec['pensionPaymentOrderNo'] ?? null,
			];
		}
		return $this->_sync_dynamic_records('employee_career', 'employee_id', $employee_id, $mapped_records);
	}

	/**
	 * Synchronizes emergency contact records for an employee.
	 * Assumes 'employee_emergency' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of emergency contact data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_emergency_records($employee_id, $records) {
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'employee_id' => $employee_id,
				'contact_name' => $rec['name'] ?? null,
				'relation' => $rec['relation'] ?? null,
				'contact_no_1' => $rec['contact1'] ?? null,
				'contact_no_2' => $rec['contact2'] ?? null,
				'contact_no_3' => $rec['contact3'] ?? null,
			];
		}
		return $this->_sync_dynamic_records('employee_emergency', 'employee_id', $employee_id, $mapped_records);
	}

	/**
	 * Synchronizes attachment records for an employee.
	 * Assumes 'employee_attachments' table exists.
	 * Note: This only saves metadata. Actual file upload must be handled separately.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $records An array of attachment record data.
	 * @return bool True on success, false on failure.
	 */
	public function sync_attachment_records($employee_id, $records) {
		$mapped_records = [];
		foreach ($records as $rec) {
			$mapped_records[] = [
				'employee_id' => $employee_id,
				'description' => $rec['description'] ?? null,
				'file_name' => $rec['fileName'] ?? null, // Store filename (assuming it's already uploaded or will be)
				'upload_date' => date('Y-m-d', strtotime($rec['date'] ?? date('Y-m-d'))), // Convert date format
			];
		}
		return $this->_sync_dynamic_records('employee_attachments', 'employee_id', $employee_id, $mapped_records);
	}

	/**
	 * Saves or updates medical history for an employee.
	 * Assumes 'employee_medical' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_medical`.
	 * @return bool True on success, false on failure.
	 */
	public function save_medical_data($employee_id, $data) {
		return $this->_upsert_single_record('employee_medical', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates payment details for an employee.
	 * Assumes 'employee_payment_details' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_payment_details`.
	 * @return bool True on success, false on failure.
	 */
	public function save_payment_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_payment_details', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates administration details for an employee.
	 * Assumes 'employee_administration' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_administration`.
	 * @return bool True on success, false on failure.
	 */
	public function save_admin_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_administration', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates provident fund details for an employee.
	 * Assumes 'employee_provident_fund' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_provident_fund`.
	 * @return bool True on success, false on failure.
	 */
	public function save_pf_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_provident_fund', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates EPS details for an employee.
	 * Assumes 'employee_eps' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_eps`.
	 * @return bool True on success, false on failure.
	 */
	public function save_eps_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_eps', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates ESI details for an employee.
	 * Assumes 'employee_esi' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_esi`.
	 * @return bool True on success, false on failure.
	 */
	public function save_esi_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_esi', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Saves or updates professional tax details for an employee.
	 * Assumes 'employee_professional_tax' table exists.
	 *
	 * @param int $employee_id The ID of the employee.
	 * @param array $data The data for `employee_professional_tax`.
	 * @return bool True on success, false on failure.
	 */
	public function save_ptax_details($employee_id, $data) {
		return $this->_upsert_single_record('employee_professional_tax', ['employee_id' => $employee_id], $data);
	}

	/**
	 * Retrieves employee records for DataTables display from staff table.
	 *
	 * @param int $start Starting record number
	 * @param int $length Number of records to fetch
	 * @param string $search_value Search term
	 * @param string $order_field Field to order by
	 * @param string $order_dir Order direction (asc/desc)
	 * @return array Array with recordsTotal, recordsFiltered, and data
	 */
	public function get_employee_for_datatables($start, $length, $search_value, $order_field, $order_dir) {
		// First, let's check if there are any records in staff table
		$total_staff_count = $this->db->count_all('staff');
		
		if ($total_staff_count == 0) {
			return [
				'recordsTotal' => 0,
				'recordsFiltered' => 0,
				'data' => []
			];
		}

		$this->db->select("
            s.staff_id as employee_id,
            s.emp_no as employee_code,
            s.staff_name as full_name,
            et.type_name as employment_type_name,
            (SELECT d.designation_name FROM designations d WHERE d.designation_id = s.designation_id) as designation_name,
            (SELECT p.place_name FROM place p WHERE p.place_id = s.location) as posting_city_name
        ");
		$this->db->from('staff s');
		$this->db->join('employee_type et', 's.employee_type_id = et.employee_type_id', 'left');
		$this->db->where('s.is_deleted', 0);

		// Apply search filter
		if (!empty($search_value)) {
			$this->db->group_start();
			$this->db->like('s.emp_no', $search_value);
			$this->db->or_like('s.staff_name', $search_value);
			$this->db->or_like('et.type_name', $search_value);
			$this->db->group_end();
		}

		// Get total records count without filtering
		$total_records = $this->db->count_all_results('', false);

		// Get filtered records count (already applied filters from above)
		$filtered_records = $this->db->count_all_results('', false);

		// Apply ordering
		if ($order_field == 'employment_type') $order_field = 'et.type_name';
		else if ($order_field == 'designation') $order_field = 'designation_name';
		else if ($order_field == 'posting_city') $order_field = 'posting_city_name';
		else if ($order_field == 'full_name') $order_field = 's.staff_name';
		else if ($order_field == 'employee_code') $order_field = 's.emp_no';
		else $order_field = 's.staff_id'; // Default ordering

		$this->db->order_by($order_field, $order_dir);

		// Apply limit and offset
		if ($length > 0) {
			$this->db->limit($length, $start);
		}

		$query = $this->db->get();

		return [
			'recordsTotal' => $total_records,
			'recordsFiltered' => $filtered_records,
			'data' => $query->result_array()
		];
	}


	// --- Old methods from original model. Keep if still used elsewhere, otherwise remove. ---

	/**
	 * Saves an employee record (from tbl_employee).
	 * @deprecated Use `insert_master_data` for new form flow.
	 */
	public function saveemployee($post) {
		$employee_name = empty($post['employee_name']) ? "" : $post['employee_name'];
		$user_id = $this->session->userdata('user_id');
		$datetime = date('Y-m-d H:i:s'); // Changed to 24-hour format

		$data = [
			"employee_name" => $employee_name,
			"created_by" => $user_id,
			"created_datetime" => $datetime
		];
		$this->db->insert('tbl_employee', $data);
		return $this->db->insert_id();
	}

	/**
	 * Retrieves employee records for DataTables (from tbl_employee).
	 * @deprecated Use `get_employee_for_datatables` for new form flow if list needs to reflect combined data.
	 */
	public function getemployee($start="",$length="",$searchstr="",$column,$type)
	{
		$arr = ["employee_id", "employee_name"];
		$col_index = (int)$column; // Cast column to integer for array access

		$this->db->select('`employee_id`, `employee_name`')
			->from('tbl_employee')
			->where('is_deleted', '0');

		if (!empty($searchstr)) {
			$this->db->group_start(); // Start grouping for OR conditions
			$this->db->like('employee_name', $searchstr);
			// Add other searchable fields from tbl_employee here if needed
			$this->db->group_end(); // End grouping
		}

		// Clone DB object to get total count before limit/offset
		$tempdb = clone $this->db;
		$num_rows = $tempdb->count_all_results();

		// Apply ordering
		if (isset($arr[$col_index])) {
			$this->db->order_by($arr[$col_index], $type);
		} else {
			$this->db->order_by('employee_id', 'desc'); // Default order if column is invalid
		}

		// Apply limit and offset
		if ($length > 0) {
			$this->db->limit($length, $start);
		}

		$query = $this->db->get();
		$response['count'] = $num_rows;
		$response['data'] = $query->result_array();
		return $response;
	}

	/**
	 * Retrieves an employee record by ID (from tbl_employee).
	 * @deprecated Use `get_employee_full_profile` for new form flow.
	 */
	public function getemployeebyid($employeeid)
	{
		$query=$this->db->select('`employee_id`, `employee_name`')
			->from('tbl_employee')
			->where(array("employee_id"=>$employeeid))
			->get();
		$record['employee']=$query->result_array();
		return $record;
	}

	/**
	 * Updates an employee record (from tbl_employee).
	 * @deprecated Use `update_master_data` for new form flow.
	 */
	public function updateemployee($post)
	{
		$employee_name = empty($post['employee_name']) ? "" : $post['employee_name'];
		$user_id = $this->session->userdata('user_id');
		$datetime = date('Y-m-d H:i:s');

		$data = [
			"employee_name" => $employee_name,
			"updated_datetime" => $datetime,
			"updated_by" => $user_id
		];
		$employee_id = encryptor("decrypt", $post['employee_id']);
		$this->db->where('employee_id', $employee_id);
		$this->db->update('tbl_employee', $data);
		return $employee_id;
	}

	/**
	 * Deletes an employee by ID (soft delete from tbl_employee).
	 * @deprecated Use comprehensive `delete_employee` for new form flow.
	 */
	public function deletebyid($employeeid)
	{
		$data=array("is_deleted"=>'1');
		$this->db->where('employee_id', $employeeid);
		$this->db->update('tbl_employee',$data);
		return $this->db->affected_rows();
	}

	/**
	 * Retrieves employees by consignor (from tbl_employee).
	 * @deprecated Verify if this is still relevant or if employee-consignor link should be elsewhere.
	 */
	public function getEmployeeByConsignor($consignor_id)
	{
		$query=$this->db->select('`employee_id`, `employee_name`')
			->from('tbl_employee')
			->where(array("consignor_id"=>$consignor_id)) // Assumes consignor_id column in tbl_employee
			->get();
		return $query->result_array();
	}

	/**
	 * Comprehensive method to delete an employee and all related records.
	 *
	 * @param int $employee_id The ID of the employee to delete.
	 * @return bool True on success, false on failure.
	 */
	public function delete_employee($employee_id) {
		$this->db->trans_begin();

		// Delete from primary tables first (e.g., staff, employee_profile, tbl_employee)
		$this->db->where('staff_id', $employee_id)->delete('staff');
		$this->db->where('employee_id', $employee_id)->delete('employee_profile');
		$this->db->where('employee_id', $employee_id)->update('tbl_employee', ['is_deleted' => 1]); // Soft delete from old tbl_employee

		// Delete from all related tables that use 'employee_id' or 'staff_id'
		$this->db->where('staff_id', $employee_id)->delete('employee_personal'); // Use staff_id for employee_personal
		$this->db->where('employee_id', $employee_id)->delete('employee_address');
		$this->db->where('employee_id', $employee_id)->delete('employee_academic');
		$this->db->where('employee_id', $employee_id)->delete('employee_family');

		// Assuming these tables exist based on controller logic
		$this->db->where('employee_id', $employee_id)->delete('employee_nomination');
		$this->db->where('employee_id', $employee_id)->delete('employee_career');
		$this->db->where('employee_id', $employee_id)->delete('employee_medical');
		$this->db->where('employee_id', $employee_id)->delete('employee_emergency');
		$this->db->where('employee_id', $employee_id)->delete('employee_attachments');
		$this->db->where('employee_id', $employee_id)->delete('employee_payment_details');
		$this->db->where('employee_id', $employee_id)->delete('employee_administration');
		$this->db->where('employee_id', $employee_id)->delete('employee_provident_fund');
		$this->db->where('employee_id', $employee_id)->delete('employee_eps');
		$this->db->where('employee_id', $employee_id)->delete('employee_esi');
		$this->db->where('employee_id', $employee_id)->delete('employee_professional_tax');
		// Add any other related tables that use employee_id / staff_id as FK

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}
}
