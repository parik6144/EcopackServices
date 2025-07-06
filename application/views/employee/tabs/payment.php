<?php
// application/views/employee/tabs/payment.php
$payment_details = isset($employee_data['payment_details']) ? $employee_data['payment_details'] : [];
?>
<form id="paymentForm" data-tab-form="true">
	<input type="hidden" name="employee_id_hidden_field" value="">
	<h5>Payment Details</h5>
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="text" class="form-control" id="payment_type" name="payment_type" placeholder="e.g., Bank Transfer"
				   value="<?= htmlspecialchars($payment_details['payment_type'] ?? ''); ?>" />
			<label for="payment_type">Type</label>
			<div class="form-error" id="error_payment_type"></div>
		</div>
		<!-- ... rest of payment fields ... -->
	</div>
	<div class="d-flex justify-content-start gap-2 mt-3">
		<button type="submit" class="btn btn-success">Save Payment Data</button>
	</div>
</form>
