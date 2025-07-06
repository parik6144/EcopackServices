// assets/js/employee/employee_list.js

$(document).ready(function() {
	// Initialize DataTables with AJAX data and Buttons for export
	$('#employee_data_table').DataTable({
		"processing": true, // Show processing indicator
		"serverSide": true, // Enable server-side processing
		"ajax": {
			"url": BASE_URL + "employee/getrecord", // Your controller method to fetch data
			"type": "GET",
			"dataSrc": "data" // The key in the JSON response that contains the data array
		},
		"columns": [
			{ "data": null, "orderable": false, "searchable": false, "className": "text-center" }, // Sr. No. (handled by DataTables or server-side)
			{ "data": "employee_code" },
			{ "data": "full_name" }, // Assuming you return 'full_name' or combine first/last name
			{ "data": "employment_type" },
			{ "data": "designation" },
			{ "data": "posting_city" },
			{ "data": null, "orderable": false, "searchable": false, "className": "text-center" } // Action buttons
		],
		"columnDefs": [
			{
				"render": function (data, type, row, meta) {
					// This generates the action buttons for each row
					const encodedId = row.employee_id_encoded; // Assuming your server sends back encoded ID

					const editUrl = BASE_URL + 'employee/add/' + encodedId; // Use encodedId directly
					const deleteId = encodedId; // Use encodedId directly

					const action_buttons = `
                        <div class='btn-group action-icons' role='group'>
                            <a href='${editUrl}' class='btn btn-info btn-sm' title='Edit'><i class='fa fa-pencil-square-o'></i></a>
                            <button type='button' class='btn btn-danger btn-sm btn_deleterecord' data-id='${deleteId}' title='Delete'><i class='fa fa-trash-o'></i></button>
                        </div>
                    `;
					return action_buttons;
				},
				"targets": -1 // Apply to the last column (Action)
			},
			{
				"render": function (data, type, row, meta) {
					// Combines first_name and last_name into full name for display
					// Added a sample checkmark icon for visual resemblance
					const hasCheckmark = Math.random() > 0.5; // Example: Add checkmark randomly
					const checkmarkHtml = hasCheckmark ? '<i class="fa fa-check-circle clients-status-icon"></i> ' : '';
					return checkmarkHtml + row.full_name;
				},
				"targets": 2 // Apply to the Name column
			},
			{
				"render": function (data, type, row, meta) {
					// For Sr. No.
					return meta.row + meta.settings._iDisplayStart + 1;
				},
				"targets": 0 // Apply to the first column (Sr. No.)
			}
		],
		// Updated DOM to match the layout of the example image more closely
		// 'l' - Length changing input control
		// 'B' - Buttons
		// 'f' - Filtering input (search box)
		// 't' - The table
		// 'i' - Table information summary
		// 'p' - Pagination
		"dom": '<"row"<"col-sm-12 col-md-auto"l><"col-sm-12 col-md-auto"B><"col-sm-12 col-md-auto ml-md-auto"f>>' + // Top row with length, buttons, search
			'<"row"<"col-sm-12"tr>>' + // Table row
			'<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>', // Bottom row with info and pagination
		"buttons": [
			// Standard individual buttons
			// 'copy', 'csv', 'excel', 'pdf', 'print'
			// For 'Export' dropdown as seen in the example:
			{
				extend: 'collection',
				text: 'Export <span class="caret"></span>', // caret is Bootstrap's dropdown arrow
				className: 'btn-export-dropdown', // Custom class for styling
				buttons: [
					'copyHtml5',
					'csvHtml5',
					'excelHtml5',
					'pdfHtml5',
					'print'
				]
			}
		],
		"language": {
			"emptyTable": "No employees available in the list.",
			"search": "", // Clear default 'Search:' label
			"searchPlaceholder": "Search customer..." // Custom placeholder
		},
		"initComplete": function () {
			// After DataTables is fully initialized, modify the search input placeholder
			$('.dataTables_filter input').attr('placeholder', 'Search customer...');
			// Add custom icon inside search input if needed (requires more advanced CSS/JS or a custom search element)
			// Example:
			// $('.dataTables_filter input').wrap('<div class="input-group"></div>').after('<div class="input-group-append"><span class="input-group-text"><i class="fa fa-search"></i></span></div>');
		}
	});

	// Delete functionality using SweetAlert2
	$(document).on('click', '.btn_deleterecord', function() {
		const encoded_id = $(this).data('id');
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
				$.ajax({
					url: BASE_URL + "employee/delete/" + encoded_id,
					type: 'POST',
					dataType: 'json',
					success: function(response) {
						if (response.status === 'success') {
							Swal.fire('Deleted!', response.message, 'success')
								.then(() => {
									$('#employee_data_table').DataTable().ajax.reload();
								});
						} else {
							Swal.fire('Error!', response.message, 'error');
						}
					},
					error: function(xhr, status, error) {
						console.error("AJAX Error:", status, error, xhr.responseText);
						Swal.fire('Error!', 'Could not connect to the server. Please try again.', 'error');
					}
				});
			}
		});
	});
});
