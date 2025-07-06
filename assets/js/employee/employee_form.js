// assets/js/employee/employee_form.js
// This file contains common functions and initializations for the employee form.
console.log('employee_form.js loaded and executing. (No localStorage Draft)'); // Added for debugging

// Global variables to store common utility functions
var FormUtils = {};

$(document).ready(function() {
	console.log('employee_form.js: Document ready.'); // Added for debugging

	// Check if this is a popup form
	const isPopup = $('.emp-profile-container').length > 0 && $('.emp-profile-container').find('.btn-secondary[data-dismiss="modal"]').length > 0;
	
	// Popup-specific functionality
	if (isPopup) {
		console.log('employee_form.js: Running in popup mode.'); // Added for debugging
		// Handle save button in popup
		$('#saveMasterBtn').on('click', function() {
			console.log('employee_form.js: saveMasterBtn clicked in popup.'); // Added for debugging
			// Trigger the master form submission
			$('#masterForm').submit();
		});
		
		// Override the default form submission to handle popup
		$('#masterForm').on('submit', function(e) {
			e.preventDefault();
			console.log('employee_form.js: Master form submitted in popup.'); // Added for debugging
			
			const formData = new FormData(this);
			
			$.ajax({
				url: BASE_URL + 'employee/save_master_data',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					console.log('employee_form.js: Popup save success response:', response); // Added for debugging
					try {
						const result = JSON.parse(response);
						if (result.status === 'success') {
							FormUtils.showSwal('success', 'Success!', result.message); // Using FormUtils.showSwal
							// For popup specific actions, we might need a callback
							setTimeout(() => { // Small delay to allow Swal to display
								// Close the modal and refresh the parent page's DataTable
								$('#employeeModal').modal('hide');
								// Trigger a custom event to refresh the parent page
								$(document).trigger('employeeSaved');
							}, 500); // 500ms delay
						} else {
							FormUtils.showSwal('error', 'Error!', result.message); // Using FormUtils.showSwal
						}
					} catch (e) {
						console.error('employee_form.js: Error parsing popup save response:', e); // Added for debugging
						FormUtils.showSwal('error', 'Error!', 'An unexpected error occurred.'); // Using FormUtils.showSwal
					}
				},
				error: function(xhr, status, error) {
					console.error('employee_form.js: AJAX Error during popup save:', status, error, xhr.responseText); // Added for debugging
					FormUtils.showSwal('error', 'Error!', 'Could not connect to the server. Please try again.'); // Using FormUtils.showSwal
				}
			});
		});
	}
	
	// General form functionality (for both popup and full page)
	
	// Photo upload functionality
	const photoDropArea = document.getElementById('photoDropArea');
	const photoInput = document.getElementById('photo');
	const photoPreview = document.getElementById('photoPreview');
	const photoPreviewContainer = document.getElementById('photoPreviewContainer');
	const changePhotoBtn = document.getElementById('changePhotoBtn');
	
	if (photoDropArea && photoInput) {
		console.log('employee_form.js: Photo upload elements found.'); // Added for debugging
		// Drag and drop functionality
		photoDropArea.addEventListener('dragover', (e) => {
			e.preventDefault();
			photoDropArea.classList.add('dragover');
		});
		
		photoDropArea.addEventListener('dragleave', () => {
			photoDropArea.classList.remove('dragover');
		});
		
		photoDropArea.addEventListener('drop', (e) => {
			e.preventDefault();
			photoDropArea.classList.remove('dragover');
			const files = e.dataTransfer.files;
			if (files.length > 0) {
				photoInput.files = files;
				FormUtils.updatePhotoDisplay(files[0]); // Using FormUtils function
				// FormUtils.saveDraft(); // Removed local storage call
			}
		});
		
		// Click to upload
		photoDropArea.addEventListener('click', (e) => {
			// This check prevents a double-trigger if the file input itself is clicked.
			if (e.target !== photoInput) {
			photoInput.click();
			}
		});
		
		// File input change
		photoInput.addEventListener('change', (e) => {
			if (e.target.files.length > 0) {
				FormUtils.updatePhotoDisplay(e.target.files[0]); // Using FormUtils function
				// FormUtils.saveDraft(); // Removed local storage call
			}
		});
		
		// Change photo button
		if (changePhotoBtn) {
			changePhotoBtn.addEventListener('click', () => {
				photoInput.click();
			});
		}
		
		// Remove photo functionality
		$(document).on('click', '.remove-photo-btn-overlay', function() {
			console.log('employee_form.js: Remove photo button clicked.'); // Added for debugging
			FormUtils.resetPhotoDisplay(); // Using FormUtils function
			// $('#master_old_photo_filename_hidden').val(''); // This is handled by master.js's reset
			// FormUtils.saveDraft(); // Removed local storage call
		});
	}

	// handlePhotoSelection is now FormUtils.updatePhotoDisplay

	// Employment type change handler - (This is also handled in master.js for master tab)
	// The master.js handler should be the primary for master tab, but keeping this for general cases or other forms
	$('#employment_type').on('change', function() {
		console.log('employee_form.js: Employment type changed.'); // Added for debugging
		const employeeTypeId = $(this).val();
		const designationSelect = $('#designation');
		
		if (employeeTypeId) {
			$.ajax({
				url: BASE_URL + 'employee/get_designations', // Check this URL against master.js
				type: 'GET',
				data: { employee_type_id: employeeTypeId },
				success: function(response) {
					try {
						const designations = JSON.parse(response);
						designationSelect.empty();
						designationSelect.append('<option value="">Select Designation *</option>');
						
						designations.forEach(function(designation) {
							designationSelect.append(
								'<option value="' + designation.designation_id + '">' + 
								designation.designation_name + '</option>'
							);
						});
					} catch (e) {
						console.error('employee_form.js: Error parsing designations:', e); // Added for debugging
					}
				},
				error: function(xhr, status, error) {
					console.error('employee_form.js: Error fetching designations:', error); // Added for debugging
				}
			});
		} else {
			designationSelect.empty();
			designationSelect.append('<option value="">Select Designation *</option>');
		}
		// FormUtils.saveDraft(); // Removed local storage call
		FormUtils.updateProfileProgress(); // Update progress after change
	});
	
	// Posting city change handler for employee code generation - (This is also handled in master.js for master tab)
	// The master.js handler should be the primary for master tab
	$('#posting_city').on('change', function() {
		console.log('employee_form.js: Posting city changed.'); // Added for debugging
		const selectedOption = $(this).find('option:selected');
		const stateCode = selectedOption.data('state');
		
		if (stateCode && !$('#employee_code').val()) {
			$.ajax({
				url: BASE_URL + 'employee/get_next_employee_code',
				type: 'POST',
				data: { state_code: stateCode },
				success: function(response) {
					try {
						const result = JSON.parse(response);
						if (result.employee_code) {
							$('#employee_code').val(result.employee_code);
						}
					} catch (e) {
						console.error('employee_form.js: Error parsing employee code response:', e); // Added for debugging
					}
				},
				error: function(xhr, status, error) {
					console.error('employee_form.js: Error generating employee code:', error); // Added for debugging
				}
			});
		}
		// FormUtils.saveDraft(); // Removed local storage call
		FormUtils.updateProfileProgress(); // Update progress after change
	});
	
	// Form validation and submission (for full page)
	if (!isPopup) {
		// The form submission logic is now exclusively handled by assets/js/employee/master.js
		// to prevent double submissions and conflicts. This block is intentionally left empty.
	}

	// Progress tracking function - now integrated into FormUtils

	// The reset functionality is now handled by assets/js/employee/master.js (for master tab)
	// and global reset by FormUtils.clearDraft()

	// --- Global Utility Functions (Accessible via FormUtils) ---

	// Regex definitions
	FormUtils.emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	FormUtils.urlRegex = /^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/[a-zA-Z0-9]+\.[^\s]{2,}|[a-zA-Z0-9]+\.[^\s]{2,})$/i;
	FormUtils.mobileNoRegex = /^[6-9]\d{9}$/; // Assumes 10-digit Indian mobile number starting with 6-9
	FormUtils.panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/; // Standard PAN format

	/**
	 * Shows an error message for a given form field.
	 * @param {string} fieldId The ID of the input field.
	 * @param {string} message The error message to display.
	 */
	FormUtils.showError = function(fieldId, message) {
		$(`#error_${fieldId}`).text(message);
		$(`#${fieldId}`).addClass('is-invalid');
	};

	/**
	 * Clears any error message and invalid state for a given form field.
	 * @param {string} fieldId The ID of the input field.
	 */
	FormUtils.clearError = function(fieldId) {
		$(`#error_${fieldId}`).text('');
		$(`#${fieldId}`).removeClass('is-invalid');
	};

	/**
	 * Displays a global form alert message using Bootstrap's alert.
	 * @param {string} type The alert type (e.g., 'success', 'danger', 'info', 'warning').
	 * @param {string} message The message to display.
	 */
	FormUtils.showGlobalAlert = function(type, message) {
		const $alertDiv = $('#globalFormAlert');
		const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
		$alertDiv.html(alertHtml).show();
		setTimeout(function() { $alertDiv.find(".alert").alert('close'); }, 7000); // Increased timeout for visibility
	};

	/**
	 * Displays a SweetAlert2 popup for success or error.
	 * @param {string} icon 'success' or 'error'.
	 * @param {string} title The title for the popup.
	 * @param {string} text The main text content.
	 * @param {function} [callback] Optional callback function to execute after Swal is closed
	 */
	FormUtils.showSwal = function(icon, title, text, callback = null) {
		Swal.fire({
			icon: icon,
			title: title,
			text: text,
			showConfirmButton: (icon === 'error'), // Show confirm button for errors
			timer: (icon === 'success' || icon === 'info') ? 2500 : undefined, // Auto close for success/info
			customClass: {
				popup: 'rounded-lg shadow-xl',
				title: 'text-lg font-semibold',
				content: 'text-sm'
			}
		}).then((result) => {
			if (callback && (result.isConfirmed || result.dismiss === Swal.DismissReason.timer)) {
				callback(); // Execute callback if confirmed or timer dismisses
			}
		});
	};

	/**
	 * Validates a single form field based on its type and required status.
	 * This function should be called by individual tab's JS files.
	 * @param {jQuery} $inputElement The jQuery object for the input element.
	 * @returns {boolean} True if valid, false otherwise.
	 */
	FormUtils.validateField = function($inputElement) {
		const fieldId = $inputElement.attr('id');
		const value = $inputElement.val() ? $inputElement.val().trim() : '';
		const isRequired = $inputElement.prop('required');
		let isValid = true;
		let errorMessage = '';

		FormUtils.clearError(fieldId); // Always clear before re-validating

		if ($inputElement.is('select')) {
			if (isRequired && (value === '' || value === null)) {
				isValid = false;
				errorMessage = 'This field is required.';
			}
		} else if (isRequired && value === '') {
			isValid = false;
			errorMessage = 'This field is required.';
		} else if (value !== '') { // Only apply specific format validation if value is not empty
			switch (fieldId) {
				case 'email':
					if (!FormUtils.emailRegex.test(value)) {
						isValid = false;
						errorMessage = 'Please enter a valid email address (e.g., example@domain.com).';
					}
					break;
				case 'mobile':
				case 'mobile_no': // Added for clarity, as the name attribute might be mobile_no
					if (!FormUtils.mobileNoRegex.test(value)) {
						isValid = false;
						errorMessage = 'Please enter a valid 10-digit mobile number (starts with 6-9).';
					}
					break;
				case 'pan_no':
					if (!FormUtils.panRegex.test(value)) {
						isValid = false;
						errorMessage = 'Please enter a valid PAN (e.g., ABCDE1234F).';
					}
					break;
				case 'aadhar_no':
					if (value.length !== 12 || !/^\d{12}$/.test(value)) {
						isValid = false;
						errorMessage = 'Aadhar No must be exactly 12 digits.';
					}
					break;
				case 'linkedin':
				case 'facebook':
				case 'twitter':
				case 'instagram':
				case 'career_company_website':
					if (!FormUtils.urlRegex.test(value)) {
						isValid = false;
						errorMessage = 'Please enter a valid URL (e.g., https://www.example.com).';
					}
					break;
				case 'academic_from_year':
				case 'academic_to_year':
					const year = parseInt(value);
					if (isNaN(year) || year < 1900 || year > new Date().getFullYear() + 5) {
						isValid = false;
						errorMessage = 'Please enter a valid year (1900-Current Year + 5).';
					}
					break;
				case 'nominee_percentage':
				case 'payment_percent':
				case 'payment_percent2':
					const percent = parseFloat(value);
					if (isNaN(percent) || percent < 0 || percent > 100) {
						isValid = false;
						errorMessage = 'Please enter a percentage between 0 and 100.';
					}
					break;
				case 'admin_probation_period':
				case 'admin_notice_period':
				case 'career_starting_salary':
				case 'career_starting_other_comp':
				case 'career_final_salary':
				case 'career_final_other_comp':
				case 'no_of_children':
					const num = parseFloat(value);
					if (isNaN(num) || num < 0) {
						isValid = false;
						errorMessage = 'Please enter a non-negative number.';
					}
					break;
				case 'home_phone_no':
				case 'family_contact_no':
				case 'career_contact_person_mobile_no':
				case 'emergency_contact1':
				case 'emergency_contact2':
				case 'emergency_contact3':
				case 'academic_college_contact_no':
				case 'academic_university_contact_no':
					if (value !== '' && !/^\+?\d{6,15}$/.test(value)) { // General phone number validation (6-15 digits, optional +)
						isValid = false;
						errorMessage = 'Please enter a valid contact number.';
					}
					break;
				// Add more specific validations as needed
			}
		}

		if (!isValid) {
			FormUtils.showError(fieldId, errorMessage);
		}
		return isValid;
	};

	// --- Tab Management (No Local Storage) ---
	FormUtils.lastMainTabHref = '#master'; // Always default to Master on load
	FormUtils.lastSubTabHref = null; // No sub-tab preference on reload

	/**
	 * Activates a specific main tab and optionally a sub-tab, then scrolls to a field.
	 * @param {string} mainTabHref The href of the main tab to activate (e.g., '#master').
	 * @param {string|null} subTabHref The href of the sub-tab to activate (e.g., '#personal-main').
	 * @param {string|null} fieldToScrollTo The ID of the field to scroll into view.
	 */
	FormUtils.activateTabAndScroll = function(mainTabHref, subTabHref = null, fieldToScrollTo = null) {
		console.log(`employee_form.js: Activating main tab: ${mainTabHref}, sub-tab: ${subTabHref}`); // Added for debugging
		// Activate main tab
		$('#mainTab a[href="' + mainTabHref + '"]').tab('show');
		// localStorage.setItem('employeeFormActiveMainTab', mainTabHref); // Removed localStorage interaction

		// If there's a sub-tab to activate
		if (subTabHref) {
			const $subTabsContainer = $(mainTabHref).find('.nav-pills');
			if ($subTabsContainer.length && $subTabsContainer.find('a[href="' + subTabHref + '"]').length) {
				$subTabsContainer.find('a[href="' + subTabHref + '"]').tab('show');
				// localStorage.setItem('employeeFormActiveSubTab', subTabHref); // Removed localStorage interaction
			} else {
				// If stored sub-tab doesn't exist under this main tab, default to first sub-tab
				const firstSubTabLink = $subTabsContainer.find('.nav-link').first();
				if (firstSubTabLink.length) {
					firstSubTabLink.tab('show');
					// localStorage.setItem('employeeFormActiveSubTab', firstSubTabLink.attr('href')); // Removed localStorage interaction
				} else {
					// localStorage.removeItem('employeeFormActiveSubTab'); // Removed localStorage interaction
				}
			}
		} else {
			// localStorage.removeItem('employeeFormActiveSubTab'); // Removed localStorage interaction
		}

		// Scroll to the specific field after tabs are active, with a slight delay
		if (fieldToScrollTo) {
			setTimeout(() => {
				const $field = $('#' + fieldToScrollTo);
				if ($field.length) {
					$field[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
				}
			}, 150); // Small delay to allow tab content to become visible
		}
	};

	// On page load, activate the default Master tab
	FormUtils.activateTabAndScroll(FormUtils.lastMainTabHref, FormUtils.lastSubTabHref);

	// Store main tab changes
	$('#mainTab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		const newMainTabHref = $(e.target).attr('href');
		// localStorage.setItem('employeeFormActiveMainTab', newMainTabHref); // Removed localStorage interaction

		// When main tab changes, activate its first sub-tab by default if it has sub-tabs
		const $subTabsContainer = $(newMainTabHref).find('.nav-pills');
		if ($subTabsContainer.length) {
			const firstSubTabLink = $subTabsContainer.find('.nav-link').first();
			if (firstSubTabLink.length) {
				firstSubTabLink.tab('show');
				// localStorage.setItem('employeeFormActiveSubTab', firstSubTabLink.attr('href')); // Removed localStorage interaction
			}
		} else {
			// If no sub-tabs, clear sub-tab storage
			// localStorage.removeItem('employeeFormActiveSubTab'); // Removed localStorage interaction
		}
		FormUtils.updateProfileProgress(); // Update progress on tab change
		// FormUtils.saveDraft(); // Removed local storage call
	});

	// Store sub-tab changes
	$('.tab-pane.fade .nav-pills a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
		// localStorage.setItem('employeeFormActiveSubTab', $(e.target).attr('href')); // Removed localStorage interaction
		FormUtils.updateProfileProgress(); // Update progress on sub-tab change
		// FormUtils.saveDraft(); // Removed local storage call
	});

	// --- Floating Labels & Real-time Validation (Delegated for dynamically loaded content) ---
	// Apply initial 'filled' class if input has value on load for existing elements
	setTimeout(function() {
		console.log('employee_form.js: Applying initial "filled" classes.'); // Added for debugging
		$('.form-control').each(function() {
			if($(this).val()) {
				$(this).addClass('filled');
			}
		});
	}, 100); // Small delay to let initial value population happen


	// Real-time validation and 'filled' class toggling on blur (user finishes interaction)
	$(document).on('blur', '.form-control', function() {
		// console.log('employee_form.js: Field blurred:', $(this).attr('id')); // Debugging
		FormUtils.validateField($(this)); // Validate when field loses focus
		if($(this).val()) {
			$(this).addClass('filled');
		} else {
			$(this).removeClass('filled');
		}
		FormUtils.updateProfileProgress();
		// FormUtils.saveDraft(); // Removed local storage call
	});

	// Handle input/change for non-file controls to update progress and save draft
	$(document).on('input change', 'form[data-tab-form="true"] input:not([type="file"]), form[data-tab-form="true"] select, form[data-tab-form="true"] textarea', function() {
		// console.log('employee_form.js: Input/change event on form field:', $(this).attr('name')); // Debugging
		FormUtils.updateProfileProgress();
		// FormUtils.saveDraft(); // Removed local storage call
	});


	// --- Profile Progress Bar Logic ---
	/**
	 * Updates the profile completion progress bar.
	 * This function needs to be aware of all fields across all tabs.
	 * For now, it will look at all relevant fields loaded in the DOM.
	 * In a more complex scenario, you might pass data about all fields
	 * from the backend or maintain a global state.
	 */
	FormUtils.updateProfileProgress = function() {
		// console.log('employee_form.js: Updating profile progress.'); // Debugging
		// Define all fields that contribute to overall progress, including those within dynamic tables.
		const allRequiredFieldsInFixedSections = [
			'employee_code', 'employment_type', 'posting_city', 'posting_branch', 'first_name',
			'last_name', 'company', 'salary_branch', 'designation', 'attendance_type',
			'gender', 'dob', 'email', 'mobile', 'pan_no', 'marital_status',
			'permanent_country', 'permanent_state' // from Address tab
			// Add other "required" fields from non-dynamic sections if they contribute to overall progress
		];

		let totalProgressPoints = allRequiredFieldsInFixedSections.length;
		let filledProgressPoints = 0;

		// Check fixed section fields
		$.each(allRequiredFieldsInFixedSections, function(index, fieldId) {
			const $input = $('#' + fieldId);
			if ($input.length) { // Ensure field exists
				if ($input.is('select') && $input.val() !== null && $input.val() !== '') {
					filledProgressPoints++;
				} else if (!$input.is('select') && $input.val() && $input.val().trim() !== '') {
					filledProgressPoints++;
				}
			}
		});

		// Add points for photo
		if ($('#photoPreviewContainer').is(':visible') && $('#photoPreview').attr('src') && $('#photoPreview').attr('src') !== '#') {
			filledProgressPoints++;
		}
		totalProgressPoints++; // Add 1 for the photo slot

		// Add points for dynamic sections if at least one record exists
		if ($('#academicRecordsTable tbody tr').length > 0) filledProgressPoints++;
		if ($('#familyRecordsTable tbody tr').length > 0) filledProgressPoints++;
		if ($('#nomineeRecordsTable tbody tr').length > 0) filledProgressPoints++;
		if ($('#careerRecordsTable tbody tr').length > 0) filledProgressPoints++;
		if ($('#emergencyRecordsTable tbody tr').length > 0) filledProgressPoints++;
		if ($('#attachmentRecordsTable tbody tr').length > 0) filledProgressPoints++;

		totalProgressPoints += 6; // Add 1 point for each of these 6 dynamic sections to the total

		let percent = (totalProgressPoints > 0) ? Math.round((filledProgressPoints / totalProgressPoints) * 100) : 0; // Avoid division by zero

		// Ensure percentage is between 0 and 100
		percent = Math.max(0, Math.min(100, percent));

		$('#profile-progress-bar').css('width', percent + '%').text(percent + '%');
		// Motivational message
		let msg = '';
		if(percent < 30) msg = 'Let\'s get started!';
		else if(percent < 60) msg = 'Good going!';
		else if(percent < 90) msg = 'Almost there!';
		else if(percent < 100) msg = 'You are awesome! Just a few steps left to achieve milestone.';
		else if (percent === 100) msg = 'Congratulations! Profile complete!';
		else msg = 'Keep pushing!'; // Fallback

		$('#profile-progress-text').text(msg);
	};

	// Initial update
	FormUtils.updateProfileProgress();

	// --- Local Storage for Draft (Global) --- REMOVED
	// const FORM_KEY = 'employeeFormDraft';
	// FormUtils.saveDraft and FormUtils.loadDraft removed.
	// FormUtils.clearDraft functionality integrated into specific reset handlers where applicable.

	// Reset button functionality (global reset) - This will now trigger FormUtils.clearDraft() from a global perspective.
	// FormUtils.clearDraft is redefined below to only clear visible inputs without localStorage interaction.
	$('#resetFormBtn').on('click', function() {
		console.log('employee_form.js: Global resetFormBtn clicked.'); // Debugging
		FormUtils.clearAllFormsAndErrors(); // Call the new function
		FormUtils.showSwal('info', 'Form Reset!', 'All data has been cleared.');
	});

	/**
	 * New function: Clears all form data and errors across all forms (no localStorage interaction).
	 */
	FormUtils.clearAllFormsAndErrors = function() {
		console.log('employee_form.js: clearAllFormsAndErrors called (no localStorage).');
		// Reset all forms within the main container
		$('.emp-profile-container').find('form[data-tab-form="true"]').each(function() {
			this.reset();
		});

		// Clear visual states
		$('.form-control').removeClass('filled is-invalid');
		$('.form-error').text('');

		// Clear dynamic tables (tbody content)
		$('#academicRecordsTable tbody').empty();
		$('#familyRecordsTable tbody').empty();
		$('#nomineeRecordsTable tbody').empty();
		$('#careerRecordsTable tbody').empty();
		$('#emergencyRecordsTable tbody').empty();
		$('#attachmentRecordsTable tbody').empty();

		FormUtils.resetPhotoDisplay(); // Reset photo upload area
		// Also clear the hidden employee ID fields and old photo filename
		$('#employee_id_hidden_field').val('');
		$('#master_employee_id_hidden_field').val('');
		$('#master_old_photo_filename_hidden').val('');

		FormUtils.updateProfileProgress(); // Update progress bar

		// Re-trigger dropdown changes to reset dependent fields
		$('#employment_type').trigger('change');
		$('#posting_city').trigger('change');

		// Force employee code to be editable and empty on full reset if it was not already
		$('#employee_code').val('').removeClass('filled').prop('readonly', false);
	};

	/**
	 * Resets the photo display area (clears preview and shows drop area).
	 */
	FormUtils.resetPhotoDisplay = function() {
		const photoInput = $('#photo');
		const photoDropArea = $('#photoDropArea');
		const photoPreviewContainer = $('#photoPreviewContainer');
		const photoPreviewImg = $('#photoPreview');

		console.log('employee_form.js: resetPhotoDisplay called.'); // Debugging

		// Reset the file input element to clear any selected files
		photoInput.val('');
		// To ensure the file input is completely cleared and allows re-selection of the same file
		photoInput.replaceWith(photoInput.val('').clone(true));

		photoPreviewImg.attr('src', '#'); // Clear preview image src
		photoPreviewContainer.hide(); // Hide preview container
		photoDropArea.show(); // Show drag & drop area
		FormUtils.clearError('photo'); // Clear any error messages for photo
	};

	// Helper for photo upload display (moved from master.js for global access)
	FormUtils.updatePhotoDisplay = function(file) {
		const photoInput = $('#photo');
		const photoDropArea = $('#photoDropArea');
		const photoPreviewContainer = $('#photoPreviewContainer');
		const photoPreviewImg = $('#photoPreview');

		console.log('employee_form.js: updatePhotoDisplay called with file:', file); // Debugging

		if (file && file.type.startsWith('image/')) {
			const reader = new FileReader();
			reader.onload = function(e) {
				photoPreviewImg.attr('src', e.target.result);
				photoDropArea.hide();
				photoPreviewContainer.show();
			};
			reader.readAsDataURL(file);
			FormUtils.clearError('photo');
		} else {
			FormUtils.resetPhotoDisplay();
			// Only show error if a file was *attempted* to be selected and was invalid
			if (photoInput[0].files.length > 0 && file && !file.type.startsWith('image/')) {
				FormUtils.showError('photo', 'Please select a valid image file (e.g., JPG, PNG).');
			}
		}
		FormUtils.updateProfileProgress();
	};

	// --- Dynamic Table Row Management (Generic) ---
	/**
	 * Generic function to handle adding records to dynamic tables.
	 * @param {jQuery} $formRowContainer The jQuery object for the form row containing inputs for a single record.
	 * @param {jQuery} $tableBody The jQuery object for the tbody of the target table.
	 * @param {string[]} requiredFieldIds An array of IDs of fields that are required for adding a record.
	 * @param {function(): string} getRowHtml A function that returns the HTML string for a new table row.
	 */
	FormUtils.handleAddDynamicRecord = function($formRowContainer, $tableBody, requiredFieldIds, getRowHtml) {
		console.log('employee_form.js: handleAddDynamicRecord called.'); // Debugging
		let recordValid = true;
		let firstInvalidRecordField = null;

		$formRowContainer.find('.form-error').text('');
		$formRowContainer.find('.form-control').removeClass('is-invalid');

		$.each(requiredFieldIds, function(index, fieldId) {
			const $input = $formRowContainer.find('#' + fieldId);
			if ($input.length) {
				if (!FormUtils.validateField($input)) {
					recordValid = false;
					if (!firstInvalidRecordField) {
						firstInvalidRecordField = fieldId;
					}
				}
			}
		});

		if (!recordValid) {
			FormUtils.showSwal('error', 'Validation Error', 'Please fill all required fields correctly before adding this record.');
			if (firstInvalidRecordField) {
				setTimeout(() => {
					const $errorField = $('#' + firstInvalidFieldId);
					if ($errorField.length) {
						$errorField[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
					}
				}, 100);
			}
			return false; // Indicate failure
		}

		// Append new row
		const newRow = getRowHtml();
		$tableBody.append(newRow);

		// Clear form fields after adding
		$formRowContainer.find('input:not([type="file"]), select, textarea').val('').removeClass('filled');
		$formRowContainer.find('.form-error').text('');
		$formRowContainer.find('.form-control').removeClass('is-invalid');
		FormUtils.updateProfileProgress();
		// FormUtils.saveDraft(); // Removed local storage call
		return true; // Indicate success
	};

	// Remove row functionality for all tables (delegated)
	$(document).on('click', '.remove-row', function() {
		console.log('employee_form.js: remove-row clicked.'); // Debugging
		$(this).closest('tr').remove();
		FormUtils.updateProfileProgress();
		// FormUtils.saveDraft(); // Removed local storage call
	});

	// --- Tab-specific Submit Handlers (To be called from individual tab JS files) ---
	// This function will be defined in each specific tab's JS, but the concept is global.
	// Example:
	// FormUtils.submitTab = function(formId, apiUrl, successMessage, errorMessage, callback) { ... }

	// Any other general logic for the employee form can go here.
});
