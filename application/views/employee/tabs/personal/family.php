<?php
// application/views/employee/tabs/personal/family.php
// This view contains the form elements and dynamic table for "Family" sub-tab under the Personal tab.
// $employee_data is passed from the main employee_form.php
$family_data = $employee_data['family_data'] ?? [];
$encrypted_staff_id = isset($employee_data['master_data']['staff_id']) ? encryptor('encrypt', $employee_data['master_data']['staff_id']) : '';
?>

<div class="employee-family-container">
    <h3 class="page-title">Employee Family</h3>

    <form id="personalFamilyForm" data-tab-form="true" novalidate>
        <input type="hidden" name="employee_id_hidden_field" value="<?php echo $encrypted_staff_id; ?>">

        <div class="card-custom mb-4">
            <div class="card-header-custom">Basic Details</div>
            <div class="card-body-custom">
                <fieldset class="fieldset-no-border">
                    <div class="form-row family-form-row">
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_first_name" name="family_first_name" placeholder=" " required>
                            <label for="family_first_name">First Name *</label>
                            <div class="form-error" id="error_family_first_name"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_middle_name" name="family_middle_name" placeholder=" ">
                            <label for="family_middle_name">Middle Name</label>
                            <div class="form-error" id="error_family_middle_name"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_last_name" name="family_last_name" placeholder=" " required>
                            <label for="family_last_name">Last Name *</label>
                            <div class="form-error" id="error_family_last_name"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <select class="form-control" id="family_relationship" name="family_relationship" required>
                                <option value="" selected disabled>Select Relation *</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Spouse">Spouse</option>
                                <option value="Son">Son</option>
                                <option value="Daughter">Daughter</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="family_relationship">Relation *</label>
                            <div class="form-error" id="error_family_relationship"></div>
                        </div>
                    </div>
                    <div class="form-row family-form-row">
                        <div class="form-group col-md-3 form-floating">
                            <select class="form-control" id="family_gender" name="family_gender" required>
                                <option value="" selected disabled>Select Gender *</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="family_gender">Gender *</label>
                            <div class="form-error" id="error_family_gender"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="date" class="form-control" id="family_dob" name="family_dob" placeholder=" " required>
                            <label for="family_dob">Date of Birth *</label>
                            <div class="form-error" id="error_family_dob"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_contact_no" name="family_contact_no" placeholder=" ">
                            <label for="family_contact_no">Contact No.</label>
                            <div class="form-error" id="error_family_contact_no"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <select class="form-control" id="residing_with_employee" name="residing_with_employee" required>
                                <option value="" selected disabled>Residing With Employee *</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="residing_with_employee">Residing With Employee *</label>
                            <div class="form-error" id="error_residing_with_employee"></div>
                        </div>
                    </div>
                    <div class="form-row family-form-row">
                        <div class="form-group col-md-3 form-floating">
                            <select class="form-control" id="family_is_dependent" name="family_is_dependent" required>
                                <option value="" selected disabled>Is Dependent *</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            <label for="family_is_dependent">Is Dependent *</label>
                            <div class="form-error" id="error_family_is_dependent"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_address_line1" name="family_address_line1" placeholder=" ">
                            <label for="family_address_line1">Address Line 1</label>
                            <div class="form-error" id="error_family_address_line1"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_address_line2" name="family_address_line2" placeholder=" ">
                            <label for="family_address_line2">Address Line 2</label>
                            <div class="form-error" id="error_family_address_line2"></div>
                        </div>
                        <div class="form-group col-md-3 form-floating">
                            <select class="form-control" id="family_country_state" name="family_country_state">
                                <option value="" selected disabled>Country / State</option>
                                </select>
                            <label for="family_country_state">Country / State</label>
                            <div class="form-error" id="error_family_country_state"></div>
                        </div>
                    </div>
                    <div class="form-row family-form-row">
                        <div class="form-group col-md-3 form-floating">
                            <input type="text" class="form-control" id="family_city_zip" name="family_city_zip" placeholder=" ">
                            <label for="family_city_zip">City / Zip Code</label>
                            <div class="form-error" id="error_family_city_zip"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-primary" id="addFamilyMemberBtn">
                            <i class="fas fa-plus"></i> Add Record
                        </button>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="card-custom mt-4">
            <div class="card-header-custom">Family Records</div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="familyRecordsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Contact No</th>
                                <th>Dependent</th>
                                <th>Residing With Employee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Populate existing family data if available
                            if (!empty($family_data)) {
                                foreach ($family_data as $record) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($record['family_first_name']) . " " . htmlspecialchars($record['family_last_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['family_relationship']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['family_gender']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['family_dob']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['family_contact_no']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['family_is_dependent']) . "</td>";
                                    echo "<td>" . htmlspecialchars($record['residing_with_employee'] ?? '') . "</td>";
                                    // You might need a way to pass the actual ID for deletion from the DB
                                    echo "<td><button type='button' class='btn btn-danger btn-sm delete-family-record' data-family-id='" . htmlspecialchars($record['id']) . "'>Delete</button></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-secondary" id="prevFamilyBtn">
                <i class="fas fa-arrow-left"></i> Previous
            </button>
            <button type="submit" class="btn btn-success" id="saveNextFamilyBtn">
                Save & Next <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('personalFamilyForm');
        const addFamilyMemberBtn = document.getElementById('addFamilyMemberBtn');
        const familyRecordsTableBody = document.querySelector('#familyRecordsTable tbody');
        const saveNextFamilyBtn = document.getElementById('saveNextFamilyBtn');
        const employeeIdHiddenField = document.getElementById('employee_id_hidden_field');

        function showError(elementId, message) {
            const errorDiv = document.getElementById(`error_${elementId}`);
            if (errorDiv) {
                errorDiv.textContent = message;
                const inputElement = document.getElementById(elementId);
                if (inputElement) {
                    inputElement.classList.add('is-invalid');
                }
            }
        }

        function clearError(elementId) {
            const errorDiv = document.getElementById(`error_${elementId}`);
            if (errorDiv) {
                errorDiv.textContent = '';
                const inputElement = document.getElementById(elementId);
                if (inputElement) {
                    inputElement.classList.remove('is-invalid');
                }
            }
        }

        function validateField(fieldId, errorMessage) {
            const field = document.getElementById(fieldId);
            if (!field) return true;

            if (field.type !== 'radio' && field.value.trim() === '') {
                showError(fieldId, errorMessage);
                return false;
            } else if (field.type === 'radio') {
                const radioGroup = document.querySelectorAll(`input[name="${field.name}"]`);
                let isChecked = false;
                radioGroup.forEach(radio => {
                    if (radio.checked) {
                        isChecked = true;
                    }
                });
                if (!isChecked) {
                    showError(field.name + '_error_wrapper', errorMessage);
                    return false;
                } else {
                    clearError(field.name + '_error_wrapper');
                }
            }
            clearError(fieldId);
            return true;
        }

        const requiredFields = [
            'family_first_name', 'family_last_name', 'family_relationship',
            'family_gender', 'family_dob', 'family_is_dependent'
        ];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    validateField(fieldId, 'This field is required.');
                });
                if (field.tagName === 'SELECT') {
                     field.addEventListener('change', function() {
                        validateField(fieldId, 'Please select an option.');
                    });
                }
                if (field.type === 'date') {
                    field.addEventListener('input', function() {
                        validateField(fieldId, 'Date of Birth is required.');
                    });
                }
            }
        });

        document.getElementById('residing_with_employee').addEventListener('change', function() {
            validateField('residing_with_employee', 'Please select an option.');
        });

        function validateFormForAdd() {
            let isValid = true;
            isValid = validateField('family_first_name', 'First Name is required.') && isValid;
            isValid = validateField('family_last_name', 'Last Name is required.') && isValid;
            isValid = validateField('family_relationship', 'Relationship is required.') && isValid;
            isValid = validateField('family_gender', 'Gender is required.') && isValid;
            isValid = validateField('family_dob', 'Date of Birth is required.') && isValid;
            isValid = validateField('residing_with_employee', 'This field is required.') && isValid;
            isValid = validateField('family_is_dependent', 'Dependent status is required.') && isValid;
            return isValid;
        }


        addFamilyMemberBtn.addEventListener('click', function(event) {
            event.preventDefault();

            if (!validateFormForAdd()) {
                const firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField.focus();
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: 'Please fill in all required fields correctly.'
                });
                return;
            }

            const familyFirstName = document.getElementById('family_first_name').value;
            const familyMiddleName = document.getElementById('family_middle_name').value;
            const familyLastName = document.getElementById('family_last_name').value;
            const familyRelationship = document.getElementById('family_relationship').value;
            const familyGender = document.getElementById('family_gender').value;
            const familyDob = document.getElementById('family_dob').value;
            const familyContactNo = document.getElementById('family_contact_no').value;
            const residingWithEmployee = document.getElementById('residing_with_employee').value;
            const familyIsDependent = document.getElementById('family_is_dependent').value;
            const familyAddressLine1 = document.getElementById('family_address_line1').value;
            const familyAddressLine2 = document.getElementById('family_address_line2').value;
            const familyCountryState = document.getElementById('family_country_state').value;
            const familyCityZip = document.getElementById('family_city_zip').value;

            const newRow = familyRecordsTableBody.insertRow();
            newRow.innerHTML = `
                <td>${familyFirstName} ${familyLastName}</td>
                <td>${familyRelationship}</td>
                <td>${familyGender}</td>
                <td>${familyDob}</td>
                <td>${familyContactNo}</td>
                <td>${familyIsDependent}</td>
                <td>${residingWithEmployee}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-dynamic-record"><i class="fas fa-trash-alt"></i> Delete</button>
                </td>
            `;

            const rowData = {
                family_first_name: familyFirstName,
                family_middle_name: familyMiddleName,
                family_last_name: familyLastName,
                family_relationship: familyRelationship,
                family_gender: familyGender,
                family_dob: familyDob,
                family_contact_no: familyContactNo,
                residing_with_employee: residingWithEmployee,
                family_is_dependent: familyIsDependent,
                family_address_line1: familyAddressLine1,
                family_address_line2: familyAddressLine2,
                family_country_state: familyCountryState,
                family_city_zip: familyCityZip
            };
            newRow.dataset.rowData = JSON.stringify(rowData);

            form.reset();
            requiredFields.forEach(fieldId => clearError(fieldId));
            clearError('residing_with_employee');
            form.classList.remove('was-validated');

            newRow.querySelector('.delete-dynamic-record').addEventListener('click', function() {
                newRow.remove();
            });
        });

        saveNextFamilyBtn.addEventListener('click', function(event) {
            event.preventDefault();

            const familyRecords = [];
            familyRecordsTableBody.querySelectorAll('tr').forEach(row => {
                const existingId = row.dataset.familyId;
                const rowData = row.dataset.rowData ? JSON.parse(row.dataset.rowData) : null;

                if (rowData) {
                    familyRecords.push({ ...rowData, id: existingId || null });
                }
            });

            const employeeId = employeeIdHiddenField.value;

            const formData = new FormData();
            formData.append('employee_id', employeeId);
            formData.append('family_records', JSON.stringify(familyRecords));

            fetch('path/to/your/save_family_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Server error occurred.');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        didClose: () => {
                            // window.location.href = 'next_tab_url_or_dashboard.php';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to save family details.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error!',
                    text: error.message || 'Could not connect to the server.'
                });
            });
        });

        document.getElementById('prevFamilyBtn').addEventListener('click', function() {
            console.log('Navigating to previous tab...');
        });

        familyRecordsTableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-family-record')) {
                const familyIdToDelete = e.target.dataset.familyId;
                const rowToRemove = e.target.closest('tr');

                if (familyIdToDelete) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('path/to/your/delete_family_data.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ id: familyIdToDelete })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Deleted!', data.message, 'success');
                                    rowToRemove.remove();
                                } else {
                                    Swal.fire('Failed!', data.message || 'Could not delete the record.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting record:', error);
                                Swal.fire('Error!', 'Could not connect to the server to delete.', 'error');
                            });
                        }
                    });
                } else {
                    rowToRemove.remove();
                }
            } else if (e.target.classList.contains('delete-dynamic-record')) {
                 e.target.closest('tr').remove();
            }
        });
    });
</script>