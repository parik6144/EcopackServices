<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_ledger extends CI_Model{
    public function getledger()
    {
    	$date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        if($_POST['receiver_type']=="all")
        {
        	$query=$this->db->query("SELECT consignment_no as consignment_id,amount,tbl_payment_advance.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type, payment_mode  FROM `tbl_payment_advance` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_advance.owner_id LEFT JOIN tbl_consignment on tbl_consignment.consignment_id=tbl_payment_advance.consignment_id where DATE(tbl_payment_advance.created_datetime)>='".$date_from."' and DATE(tbl_payment_advance.created_datetime)<='".$date_to."'
union

SELECT consignment_no as consignment_id,amount,tbl_payment_due.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type,payment_mode  FROM `tbl_payment_due` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_due.owner_id LEFT JOIN tbl_consignment on tbl_consignment.consignment_id=tbl_payment_due.consignment_id where DATE(tbl_payment_due.created_datetime)>='".$date_from."' and DATE(tbl_payment_due.created_datetime)<='".$date_to."'
union

SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."'
union SELECT invoice_no as consignment_id,amount,receipt_date as date,'receipt' as perticular,consignee_billing_name as account_name,'' as ref_id,'' as receiver_type,'1' as transaction_type,payment_mode FROM `tbl_receipt` LEFT JOIN tbl_invoice on tbl_invoice.invoice_id=tbl_receipt.invoice_id
LEFT JOIN tbl_consignee_billing on tbl_consignee_billing.consignee_billing_id=tbl_invoice.billing_address_id
WHERE DATE(receipt_date)>='".$date_from."' and DATE(receipt_date)<='".$date_to."'
 order by date");
        }
//         elseif($_POST['receiver_type']=="1")
//         {
//         	//ecopack employee
//         	$staff_id=$_POST['staff_id'];
//         	$query=$this->db->query("
// SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.ref_id=".$staff_id." and tbl_payment_booking.receiver_type='1' order by date
// ");


//         }

// RECEVIER
        // elseif($_POST['receiver_type']=="1")
        // {
        // 	//ecopack employee
        // 	$staff_id=$_POST['staff_id'];
        //     if(is_int($_POST['staff_id']))
        //     {
        //      $query=$this->db->query("SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.ref_id=".$staff_id." and tbl_payment_booking.receiver_type='1' order by date
        //     ");
        //                 }
            
        //                 if($_POST['staff_id']=='all')
        //                 {
        //              $query=$this->db->query("SELECT '' as consignment_id, amount, payment_date as date,
        //      concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,
        //      '0' as transaction_type,payment_mode FROM `tbl_payment_booking`
        //      LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id
        //      WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2
        //      and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."'
        //      and tbl_payment_booking.receiver_type='1' order by date
        //     ");
        //     }
        // }
        
           // Query getting for Employee Ledger starts.
        elseif($_POST['receiver_type']=="1") {
         $staff_id = $_POST['staff_id'];

            // FOR SINGLE EMPLOYEE LEDGER STARTS
            if(is_numeric($staff_id))
            {
                $query=$this->db->query("SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',
                TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode
                 FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id
                 WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and
                 DATE(payment_date)<='".$date_to."' and tbl_payment_booking.ref_id=".$staff_id." and tbl_payment_booking.receiver_type='1'
                 order by date");
            }

        // FOR ALL EMPLOYEE LEDGER STARTS
            if($_POST['staff_id']=='all')
            {
                $query=$this->db->query("SELECT '' as consignment_id, amount, payment_date as date,
             concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,
             '0' as transaction_type,payment_mode FROM `tbl_payment_booking`
             LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id
             WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2
             and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."'
             and tbl_payment_booking.receiver_type='1' order by date
            ");
            }
        }
        // Query getting for Employee Ledger starts ends.
        
        
        
        
        
        elseif($_POST['receiver_type']=="2")
        {
        	//other party
        	$staff_id=$_POST['account_id'];

        	$query=$this->db->query("
SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.receiver_type='2' and tbl_payment_booking.ref_id='".$staff_id."' order by date
");

        }
        
//         elseif($_POST['receiver_type']=="3")
//         {
//         	//ecopack transporter
//         	$owner_id=$_POST['owner_id'];

//         	$query=$this->db->query("
// SELECT consignment_id,amount,tbl_payment_advance.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type, payment_mode  FROM `tbl_payment_advance` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_advance.owner_id where DATE(tbl_payment_advance.created_datetime)>='".$date_from."' and DATE(tbl_payment_advance.created_datetime)<='".$date_to."' and tbl_payment_advance.owner_id=".$owner_id."
// union

// SELECT consignment_id,amount,tbl_payment_due.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type,payment_mode  FROM `tbl_payment_due` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_due.owner_id where DATE(tbl_payment_due.created_datetime)>='".$date_from."' and DATE(tbl_payment_due.created_datetime)<='".$date_to."' and tbl_payment_due.owner_id=".$owner_id."
// union

// SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.receiver_type='3' and tbl_payment_booking.ref_id='".$owner_id."' order by date
// ");

//         }

     elseif($_POST['receiver_type']=="3")
        {
        	//ecopack transporter
        	$owner_id=$_POST['owner_id'];

            if(is_numeric(($_POST['owner_id'])))
            {
            $query=$this->db->query("
            SELECT consignment_id,amount,tbl_payment_advance.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type, payment_mode  FROM `tbl_payment_advance` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_advance.owner_id where DATE(tbl_payment_advance.created_datetime)>='".$date_from."' and DATE(tbl_payment_advance.created_datetime)<='".$date_to."' and tbl_payment_advance.owner_id=".$owner_id."
            union

            SELECT consignment_id,amount,tbl_payment_due.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type,payment_mode  FROM `tbl_payment_due` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_due.owner_id where DATE(tbl_payment_due.created_datetime)>='".$date_from."' and DATE(tbl_payment_due.created_datetime)<='".$date_to."' and tbl_payment_due.owner_id=".$owner_id."
            union

            SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.receiver_type='3' and tbl_payment_booking.ref_id='".$owner_id."' order by date
            ");
            }

            if($_POST['owner_id']=='all')
            {
            $query=$this->db->query("
            SELECT consignment_id,amount,tbl_payment_advance.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type, payment_mode  FROM `tbl_payment_advance` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_advance.owner_id where DATE(tbl_payment_advance.created_datetime)>='".$date_from."' and DATE(tbl_payment_advance.created_datetime)<='".$date_to."'
            union

            SELECT consignment_id,amount,tbl_payment_due.created_datetime as date,'Transportation' as perticular,tbl_inward_owner.owner_name as account_name,'' as ref_id,'' as receiver_type,'0' as transaction_type,payment_mode  FROM `tbl_payment_due` LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_payment_due.owner_id where DATE(tbl_payment_due.created_datetime)>='".$date_from."' and DATE(tbl_payment_due.created_datetime)<='".$date_to."'
            union

            SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.receiver_type='3' order by date
            ");
             // echo $this->db->last_query(); exit();
            }
        }
        
        elseif($_POST['receiver_type']=="4")
        {
        	//ecopack employee
        	$staff_id=$_POST['staff_id'];

        	$query=$this->db->query("
SELECT '' as consignment_id, amount, payment_date as date, concat(expense_head_name,'->',TRIM(remarks)) as perticular,'' as account_name,tbl_payment_booking.ref_id,tbl_payment_booking.receiver_type,'0' as transaction_type,payment_mode FROM `tbl_payment_booking` LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id WHERE tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and DATE(payment_date)>='".$date_from."' and DATE(payment_date)<='".$date_to."' and tbl_payment_booking.receiver_type='4' and tbl_payment_booking.ref_id='".$staff_id."' order by date
");

        }



return $query->result_array();
    }
    
      function get_invoice_data($date_from, $date_to, $consignee_billing_id) {
        $sql = "SELECT `tbl_invoice`.`invoice_id` AS `transaction_id`,
              `tbl_invoice`.`invoice_no` AS `transaction_inv_no`,
              `tbl_invoice`.`invoice_date` AS `transaction_date`,
              `tbl_consignee`.`consignee_name`,
              `tbl_consignee_billing`.`consignee_billing_name`,
              `tbl_invoice_category`.`category_name` AS `transaction_category`,
              `tbl_invoice`.`invoice_total` AS `transaction_amt`,
              `tbl_invoice`.created_datetime AS `createdatetime`,
              'invoice' AS `record_type`
      FROM `tbl_invoice`
      LEFT JOIN `tbl_consignee` ON `tbl_consignee`.`consignee_id` = `tbl_invoice`.`consignee_id`
      LEFT JOIN `tbl_consignee_billing` ON `tbl_consignee_billing`.`consignee_billing_id` = `tbl_invoice`.`billing_address_id`
      LEFT JOIN `invoice_details` ON `invoice_details`.`invoice_id` = `tbl_invoice`.`invoice_id`
      LEFT JOIN `tbl_invoice_category` ON `tbl_invoice_category`.`category_id` = `tbl_invoice`.`invoice_type_id`
      WHERE `tbl_invoice`.`invoice_date` >= '$date_from'
          AND `tbl_invoice`.`invoice_date` <= '$date_to'
          AND `tbl_invoice`.`billing_address_id` = '$consignee_billing_id'";

        $query = $this->db->query($sql);
        $invoice_records = $query->result_array();
        return $invoice_records;
    }

    public function get_payment_records($date_from, $date_to, $consignee_billing_id) {
        $sql ="SELECT 
        `tbl_receipt`.`receipt_id` AS `transaction_inv_no`,
        `tbl_receipt`.`receipt_date` AS `transaction_date`,
        `tbl_invoice`.`invoice_no` AS `transaction_id`,
        (`amount` + `tds`) AS `transaction_amt`,
        `consignee_name`, `consignee_billing_name`,
        `tbl_receipt`.created_datetime AS `createdatetime`,
        'payment' AS `record_type`
        FROM `tbl_receipt`
        LEFT JOIN `tbl_invoice` ON `tbl_receipt`.`invoice_id` = `tbl_invoice`.`invoice_id`
        LEFT JOIN `tbl_consignee` ON `tbl_consignee`.`consignee_id` = `tbl_invoice`.`consignee_id`
        LEFT JOIN `tbl_invoice_category` ON `tbl_invoice_category`.`category_id` = `tbl_invoice`.`invoice_type_id`
        LEFT JOIN `tbl_consignee_billing` ON `tbl_consignee_billing`.`consignee_billing_id` = `tbl_invoice`.`billing_address_id`
        WHERE 
         `tbl_receipt`.`receipt_date` BETWEEN '$date_from' AND '$date_to' 
          AND `tbl_receipt`.`billing_id` = $consignee_billing_id
        GROUP BY `tbl_receipt`.`invoice_id`;";
        // echo $sql; exit();
        $result = $this->db->query($sql);
        $payment_records = $result->result_array();
        return $payment_records;
    }
    
    public function getconsigneeledgerbybillingid($consignee_billing_id, $date_from, $date_to) {
        $combined_array = array();
        $opening_balance = 0;
        $manual_outstanding_balance =0;

        // Fetch previous outstanding balance
        $opening_balance = $this->get_outstanding_balance($date_from, $consignee_billing_id, $manual_outstanding_balance);

        // Fetch invoice data
        $invoice_array = $this->get_invoice_data($date_from, $date_to, $consignee_billing_id);
        if(!empty($invoice_array)) {
            $combined_array = array_merge($combined_array, $invoice_array);
        }

        // Fetch payment data
        $payment_array = $this->get_payment_records($date_from, $date_to,$consignee_billing_id);
        if(!empty($payment_array)) {
            $combined_array = array_merge($combined_array, $payment_array);
        }

        // Sort combined array by createdatetime
        usort($combined_array, function($a, $b) {
            return strtotime($a['createdatetime']) - strtotime($b['createdatetime']);
        });

        $opening_balance_date = date('Y-m-d', strtotime('-1 day', strtotime($date_from)));
        // Add opening balance to the beginning of the array.
        // echo "<pre>"; print_r($combined_array); exit();
        $opening_balance_array = array(
            'transaction_id' => '-',
            'transaction_inv_no' => '-',
            'transaction_type' => 'Opening Balance',
            'transaction_date' => $opening_balance_date,
            'consignee_name' => '-',
            'consignee_billing_name' => '-',
            'transaction_category' => '-',
            'credit_amount' => ($opening_balance < 0) ? $opening_balance : 0,
            'debit_amount' => ($opening_balance > 0) ? abs($opening_balance) : 0,
            'createdatetime' => date('Y-m-d H:i:s'),
            'record_type' => 'Opening_Balance'
        );

        $data = array(
            'combined_array' => $combined_array,
            'opening_balance_array' => $opening_balance_array
        );

        return $data;
    }

    public function get_outstanding_balance($date_from, $consignee_billing_id, $manual_outstanding_balance) {

        // Calculate outstanding invoices
        $date_from = date('Y-m-d', strtotime('2011-04-23'));
        $invoices = $this->get_invoice_data($date_from, date('Y-m-d', strtotime('-1 day')), $consignee_billing_id);
        $invoice_total = 0;
        foreach ($invoices as $invoice) {
            $invoice_total += $invoice['transaction_amt'];
        }

        // Calculate outstanding payments
        $payments = $this->get_payment_records($date_from, date('Y-m-d', strtotime('-1 day')), $consignee_billing_id);
        $payment_total = 0;
        foreach ($payments as $payment) {
            $payment_total += $payment['transaction_amt'];
        }

        // Calculate opening balance
        $outstanding_balance = $manual_outstanding_balance + $invoice_total - $payment_total;

        return $outstanding_balance;
    }
}
?>