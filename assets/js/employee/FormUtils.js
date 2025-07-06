// assets/js/employee/FormUtils.js
// Minimal utility functions for employee form tabs

var FormUtils = {
    showSwal: function(type, title, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: title,
                html: message,
                confirmButtonColor: '#6c63ff',
                customClass: { popup: 'swal2-emp-popup' }
            });
        } else {
            alert(title + '\n' + message);
        }
    },
    showError: function(fieldId, message) {
        var errorId = '#error_' + fieldId.replace(/^#/, '');
        $(errorId).text(message);
        $('#' + fieldId).addClass('is-invalid');
    },
    showGlobalAlert: function(type, message) {
        var $alert = $('#globalFormAlert');
        $alert.removeClass().addClass('alert alert-' + type).html(message).show();
        setTimeout(function() { $alert.fadeOut(); }, 4000);
    },
    validateField: function($inputElement) {
        var value = $inputElement.val();
        var valid = value && value.trim() !== '';
        var errorId = '#error_' + $inputElement.attr('id');
        if (!valid) {
            $(errorId).text('This field is required');
            $inputElement.addClass('is-invalid');
        } else {
            $(errorId).text('');
            $inputElement.removeClass('is-invalid');
        }
        return valid;
    },
    clearError: function(fieldId) {
        var errorId = '#error_' + fieldId.replace(/^#/, '');
        $(errorId).text('');
        $('#' + fieldId).removeClass('is-invalid');
    },
    updateProfileProgress: function() {
        // Dummy: implement as needed
    },
    saveDraft: function() {
        // Dummy: implement as needed
    },
    handleAddDynamicRecord: function($formRow, $tableBody, requiredFields, getRowHtml) {
        let valid = true;
        // Clear previous errors
        $formRow.find('.form-error').text('');
        $formRow.find('.form-control').removeClass('is-invalid');

        requiredFields.forEach(function(fieldId) {
            const $input = $('#' + fieldId);
            if (!$input.val() || $input.val().trim() === '') {
                $('#error_' + fieldId).text('This field is required');
                $input.addClass('is-invalid');
                valid = false;
            }
        });

        // Only allow 4-digit years for from/to year if those fields exist
        ['academic_from_year', 'academic_to_year'].forEach(function(fieldId) {
            const $input = $('#' + fieldId);
            if ($input.length && $input.val() && !/^\d{4}$/.test($input.val())) {
                $input.addClass('is-invalid');
                $('#error_' + fieldId).text('Enter a valid 4-digit year');
                valid = false;
            }
        });

        if (!valid) {
            FormUtils.showSwal('error', 'Validation Error', 'Please correct the errors before adding.');
            return;
        }

        // If valid, add the row
        $tableBody.append(getRowHtml());

        // Optionally, clear the input fields after adding
        $formRow.find('input[type="text"], input[type="number"], input[type="date"], select').val('').removeClass('is-invalid filled');
        $formRow.find('.form-error').text('');
    }
}; 