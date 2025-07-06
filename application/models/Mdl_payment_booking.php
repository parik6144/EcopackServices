<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_payment_booking extends CI_Model{

	public function savebooking($post)
	{
		//`id`, `place_name`, `mobile`, `mobile2`, `phone`, `phone2`
		if(empty($_POST['amount']))
			$amount="";
		else
			$amount=$_POST['amount'];

		if(empty($_POST['remarks']))
			$remarks="";
		else
			$remarks=trim($_POST['remarks']," ");

		if(empty($_POST['expense_head']))
			$expense_head="";
		else
			$expense_head=$_POST['expense_head'];

		if(empty($_POST['receiver_type']))
			$receiver_type="";
		else
			$receiver_type=$_POST['receiver_type'];

		if(empty($_POST['vehicle_id']))
			$vehicle_id="";
		else
			$vehicle_id=$_POST['vehicle_id'];

		if(empty($_POST['taxable_value']))
			$taxable_value="";
		else
			$taxable_value=$_POST['taxable_value'];

		if(empty($_POST['purchase_tax']))
			$tax="";
		else
			$tax=$_POST['purchase_tax'];

		if(empty($_POST['branch_id']))
			$branch_id="";
		else
			$branch_id=$_POST['branch_id'];

		//$booking_date=date('Y-m-d h:i:s');

		if($receiver_type=="1")
			$ref_id=$_POST['staff_id'];
		else if($receiver_type=="4")
			$ref_id=$_POST['employee_id'];
		else if($receiver_type=="2")
			$ref_id=$_POST['account_id'];
		else if($receiver_type=="3")
			$ref_id=$_POST['owner_id'];
		$booked_by=$this->session->userdata('user_id');
		if(empty($_POST['booking_date']))
			$booking_date="";
		else
			$booking_date=$_POST['booking_date'];

		$is_tds=$_POST['is_tds'];

		if(empty($_POST['tds_amount']))
			$tds_amount="";
		else
			$tds_amount=$_POST['tds_amount'];

		$data=array("amount"=>$amount,"remarks"=>$remarks,"booked_by"=>$booked_by,"booking_date"=>$booking_date,'expense_head_id'=>$expense_head,'receiver_type'=>$receiver_type,'ref_id'=>$ref_id,"tds_amount"=>$tds_amount,"is_tds"=>$is_tds,'taxable_value'=>$taxable_value,"tax"=>$tax,'branch_id'=>$branch_id, 'approved_by_user2' => 0); // Initialize approved_by_user2 to 0
		$this->db->insert('tbl_payment_booking',$data);

		$lastid=$this->db->insert_id();
		if($expense_head=="16")
		{
			for($i=0;$i<sizeof($_POST['item_id']);$i++)
			{

				if(!empty($_POST['item_id'][$i]) && !empty($_POST['qty'][$i]))
				{

					$data=array("item_id"=>$_POST['item_id'][$i],"qty"=>$_POST['qty'][$i],"tax"=>$_POST['tax'][$i],"booking_id"=>$lastid,"warehouse_id"=>$_POST['warehouse_id']);
					$this->db->insert('purchase_stock_item',$data);
				}

			}
		}
		else if ($expense_head=="26") {
			# code...
			$employee_id=$_POST['staff_id'];
			$month_id=$_POST['advance_salary_month'];
			$year_id=date("Y");
			$data= array('advance_salary' => $amount, 'employee_id' => $employee_id, 'month_id' => $month_id,  'year_id' => $year_id, 'booking_id' => $lastid);
			$this->db->insert("tbl_advance_salary",$data);
		}
		/*else if($expense_head=="24")
		{
			$data=array("purchase_date"=>$booking_date,"amount"=>$amount,"booking_id"=>$lastid);
			$this->db->insert("tbl_diesel",$data);
		}*/

		if(!empty($vehicle_id))
		{
			$data=array("expense_date"=>$booking_date,"vehicle_id"=>$vehicle_id,"expense_type_id"=>$expense_head,"remarks"=>$remarks,"booking_id"=>$lastid);
			$this->db->insert("tbl_vehicle_expense",$data);
		}

		if(isset($_POST['loan_id']))
		{
			$payment_date=date('Y-m-d',strtotime($_POST['payment_date']));
			$data=array("booking_date"=>$payment_date,"booking_id"=>$lastid,"loan_id"=>$_POST['loan_id']);
			$this->db->insert("loan_booking",$data);
		}
		return $lastid;

	}
	public function getUserName($receiver_type,$ref_id)
	{
		if($receiver_type=="1")
		{
			$query=$this->db->select('staff_name as ref_name,"employee" as receiver_type,gstin')
				->from('staff')
				->where('staff_id',$ref_id)->get();
		}
		elseif($receiver_type=="2")
		{
			$query=$this->db->select('party_name as ref_name,"Other Party" as receiver_type,GSTIN as gstin')
				->from('tbl_account')
				->where('account_id',$ref_id)->get();
		}
		elseif($receiver_type=="3")
		{
			$query=$this->db->select('owner_name as ref_name, "Transporter" as receiver_type,GSTIN as gstin')
				->from('tbl_inward_owner')
				->where('owner_id',$ref_id)->get();
		}
		elseif($receiver_type=="4")
		{
			$query=$this->db->select('employee_name as ref_name,"Other Employee" as receiver_type')
				->from('tbl_employee')
				->where('employee_id',$ref_id)->get();
		}
		return $query->row();

	}

	public function getUserBannkDetails($receiver_type,$ref_id)
	{
		if($receiver_type=="1")
		{
			$query=$this->db->select('staff_name as ref_name,"employee" as receiver_type,`bank_name`, `branch`, `account_no`, `ifsc_code`')
				->from('staff')
				->where('staff_id',$ref_id)->get();
		}
		elseif($receiver_type=="2")
		{
			$query=$this->db->select('party_name as ref_name,"Other Party" as receiver_type,`bank_name`, `branch`, `account_no`, `ifsc_code`')
				->from('tbl_account')
				->where('account_id',$ref_id)->get();
		}
		elseif($receiver_type=="3")
		{
			$query=$this->db->select('owner_name as ref_name, "Transporter" as receiver_type,`bank_name`, `branch`, `account_no`, `ifsc_code`')
				->from('tbl_inward_owner')
				->where('owner_id',$ref_id)->get();
		}
		elseif($receiver_type=="4")
		{
			$query=$this->db->select('employee_name as ref_name,"Other Employee" as receiver_type,`bank_name`, `branch`, `account_no`, `ifsc_code`')
				->from('tbl_employee')
				->where('employee_id',$ref_id)->get();
		}
		return $query->row();

	}

	public function getpayment_booking($start = "", $length = "", $searchstr = "", $column, $type)
	{
		$col = (int)$column;
		$arr = array("booking_id", "booking_date", "full_name", "expense_head_name", "amount", "remarks");

		if ($start == '' && $length == '' && $searchstr == '') {
			$query = $this->db->select('booking_id,`booked_by`, `expense_head_id`, `amount`, `booking_date`, `payment_date`, `confirm_by`, `is_confirm`, `remarks`, approved_by_user2')
				->from('tbl_payment_booking')
				->where('tbl_payment_booking.is_deleted', '0')
				->get();
			return $query->result_array();
		} else {
			$this->db->select('booking_id,`booked_by`,booking_date,full_name, `expense_head_name`, `amount`, `payment_date`, `is_confirm`, `remarks`,receiver_type,ref_id,tds_amount,is_tds, approved_by_user2');
			$this->db->where('tbl_payment_booking.is_deleted', '0');
			if (!empty($searchstr)) {
				$this->db->group_start();
				$this->db->or_like('full_name', $searchstr);
				$this->db->or_like('expense_head_name', $searchstr);
				$this->db->or_like('amount', $searchstr);
				$this->db->or_like('booking_date', $searchstr);
				$this->db->group_end();
			}

			$tempdb = clone $this->db;
			$this->db->order_by($arr[$col], $type);
			$num_rows = $tempdb->from('tbl_payment_booking')
				->join('tbl_user', 'tbl_user.user_id=tbl_payment_booking.booked_by', 'left')
				->join('tbl_expense_head', 'tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id', 'left')
				->where('is_confirm', '0')
				->count_all_results();

			if ($length > 0) $this->db->limit($length, $start);

			$this->db->from('tbl_payment_booking');
			$this->db->join('tbl_user', 'tbl_user.user_id=tbl_payment_booking.booked_by', 'left');
			$this->db->join('tbl_expense_head', 'tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id', 'left');
			$this->db->where('is_confirm', '0');

			$query = $this->db->get();
			$response['data'] = $query->result_array();

			$data['recordsTotal'] = $num_rows;
			$data['recordsFiltered'] = $num_rows;
			$data["data"] = array();
			$ctr = $this->input->get('start') + 1;

			$current_user = $this->session->userdata('user_id');

			foreach ($response['data'] as $row) {
				$arr = [];
				$arr[] = $ctr;
				$arr[] = date('d-m-Y', strtotime($row['booking_date']));
				$arr[] = $row['full_name'];
				$arr[] = $row['expense_head_name'];
				$arr[] = $row['amount'];
				$arr[] = $row['tds_amount'];
				$arr[] = $row['amount'] - $row['tds_amount'];

				$refdata = $this->getUserName($row['receiver_type'], $row['ref_id']);
				$arr[] = $refdata->receiver_type;
				$arr[] = $refdata->ref_name;
				$arr[] = $row['remarks'];

				$arr[] = "<div class='col-sm-6'><a href='" . base_url('payment_booking/edit?id=') . encryptor("encrypt", $row['booking_id']) . "'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='" . encryptor("encrypt", $row['booking_id']) . "' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";

				// Approval Logic
				if ($current_user == "2") { // Aakash
					if ($row['approved_by_user2'] == 0) {
						$arr[] = "<a href='#' refid='" . encryptor("encrypt", $row['booking_id']) . "' class='btn_verify_user2 btn btn-sm btn-primary'>Verify</a>";
					} else {
						$arr[] = "<span class='badge bg-success'>Verified by Aakash</span>";
					}
				} elseif ($current_user == "1") { // Other User (who will accept)
					if ($row['approved_by_user2'] == 0) {
						$arr[] = "<span class='badge bg-warning' title='Approval pending from Aakash'>Pending Aakash's Approval</span>";
					} else {
						// This button will now 'confirm' the booking after Aakash verifies
						$arr[] = "<a href='#' refid='" . encryptor("encrypt", $row['booking_id']) . "' class='btn_accept btn btn-sm btn-success'>Accept</a>";
					}
				} else {
					$arr[] = "-"; // For other users
				}

				array_push($data['data'], $arr);
				$ctr++;
			}
			return $data;
		}
	}


	public function getpending_booking($start="",$length="",$searchstr="",$column,$type)
	{
		$col = (int)$column;
		$arr=array("booking_date","full_name","expense_head_name","amount","remarks");
		if($start=='' && $length=='' && $searchstr=='')
		{

			$query=$this->db->select('booking_id,`booked_by`, `expense_head_id`, `amount`, `booking_date`, `payment_date`, `confirm_by`, `is_confirm`, `remarks`')
				->from('tbl_payment_booking')
				->where('tbl_payment_booking.is_deleted', '0')
				->get();
			return $query->result_array();
		}
		else
		{
			$this->db->select('booking_id,`booked_by`,booking_date,full_name, `expense_head_name`, `amount`,tds_amount,is_tds, `payment_date`, `is_confirm`, `remarks`,receiver_type,ref_id');
			$this->db->where('tbl_payment_booking.is_deleted', '0');
			if(!empty($searchstr))
			{
				$this->db->or_like('full_name', $searchstr);
				$this->db->or_like('expense_head_name', $searchstr);
				$this->db->or_like('amount', $searchstr);
				$this->db->or_like('booking_date', $searchstr);

			}
			$tempdb = clone $this->db;
			$this->db->order_by($arr[$col],$type);
			$num_rows = $tempdb->from('tbl_payment_booking')
				->join('tbl_user','tbl_user.user_id=tbl_payment_booking.booked_by','left')
				->join('tbl_expense_head','tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id','left')
				->where('is_confirm','1')
				->count_all_results();
			if($length>0)
				$this->db->limit($length, $start);
			$this->db->from('tbl_payment_booking');
			$this->db->join('tbl_user','tbl_user.user_id=tbl_payment_booking.booked_by','left');
			$this->db->join('tbl_expense_head','tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id','left');
			$this->db->where('is_confirm','1');

			$query=$this->db->get();

			$response['data']=$query->result_array();
			$data['recordsTotal']=$num_rows;
			$data['recordsFiltered']=$num_rows;
			$data["data"]=array();
			$ctr=$this->input->get('start')+1;
			foreach ($response['data'] as $row)
			{
				//full_name, `expense_head_name`, `amount`, `booking_date`, `payment_date`, `is_confirm`, `remarks`
				$arr=[];
				$arr[]=$row['booking_id']; //$$ctr
				$arr[]=date('d-m-Y',strtotime($row['booking_date']));
				$arr[]=$row['full_name'];
				$arr[]=$row['expense_head_name'];
				$arr[]=$row['amount'];
				$arr[]=$row['tds_amount'];
				$arr[]=$row['amount']-$row['tds_amount'];
				$refdata=$this->getUserBannkDetails($row['receiver_type'],$row['ref_id']);

				$arr[]=$refdata->receiver_type;
				$arr[]=$refdata->ref_name;
				$arr[]=$refdata->bank_name;
				$arr[]=$refdata->branch;
				$arr[]=$refdata->account_no;
				$arr[]=$refdata->ifsc_code;
				$arr[]=$row['remarks'];
				//$arr[]=$row['is_confirm'];
				$arr[]="<div class='col-sm-12'><a href='#' refid='".encryptor("encrypt",$row['booking_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
				$arr[]="<select class='form-control payment_mode'>
                <option value=''>Select Mode</option>
                <option value='0'>Neft</option>
                <option value='1'>Cheque</option>
                <option value='2'>Cash</option>
                </select>";

				$arr[]="<a href='#' refid='".encryptor("encrypt",$row['booking_id'])."' class='btn_accept btn btn-sm btn-success'>Pay</a></div>";
				array_push($data['data'],$arr);
				$ctr++;
			}




			return $data;
		}
	}
	public function getpayment_bookingbyid($booking_id)
	{
		$query=$this->db->select('`booking_id`, `booked_by`, `expense_head_id`, `amount`, `booking_date`, `payment_date`, `confirm_by`, `is_confirm`, `remarks`, `receiver_type`, `ref_id`,branch_id, approved_by_user2')
			->from('tbl_payment_booking')
			->where(array("booking_id"=>$booking_id))
			->get();
		$record['payment_booking']=$query->result_array();

		return $record;
	}
	public function updatepayment_booking($post)
	{
		if(empty($_POST['amount']))
			$amount="";
		else
			$amount=$_POST['amount'];

		if(empty($_POST['remarks']))
			$remarks="";
		else
			$remarks=$_POST['remarks'];

		if(empty($_POST['expense_head']))
			$expense_head="";
		else
			$expense_head=$_POST['expense_head'];

		if(empty($_POST['receiver_type']))
			$receiver_type="";
		else
			$receiver_type=$_POST['receiver_type'];

		if(empty($_POST['branch_id']))
			$branch_id="";
		else
			$branch_id=$_POST['branch_id'];




		//$booking_date=date('Y-m-d h:i:s');

		if($receiver_type=="1")
			$ref_id=$_POST['staff_id'];
		else if($receiver_type=="4")
			$ref_id=$_POST['employee_id'];
		else if($receiver_type=="2")
			$ref_id=$_POST['account_id'];
		else if($receiver_type=="3")
			$ref_id=$_POST['owner_id'];
		$booked_by=$this->session->userdata('user_id');
		$user_id=$this->session->userdata('user_id');
		$datetime=date('Y-m-d h:i:s');
		$data=array("amount"=>$amount,"remarks"=>$remarks,'expense_head_id'=>$expense_head,"receiver_type"=>$receiver_type,"ref_id"=>$ref_id,"updated_datetime"=>$datetime,"updated_by"=>$user_id,"branch_id"=>$branch_id);
		$booking_id=encryptor("decrypt",$post['booking_id']);
		$this->db->where('booking_id',$booking_id);
		$this->db->update('tbl_payment_booking',$data);
		$this->db->where('booking_id',$booking_id);
		$this->db->delete('purchase_stock_item');

		$this->db->where('booking_id',$booking_id);
		$this->db->delete('tbl_advance_salary');


		//$lastid=$this->db->insert_id();
		if($expense_head=="16")
		{
			for($i=0;$i<sizeof($_POST['item_id']);$i++)
			{

				if(!empty($_POST['item_id'][$i]) && !empty($_POST['qty'][$i]))
				{
					$data=array("item_id"=>$_POST['item_id'][$i],"qty"=>$_POST['qty'][$i],"tax"=>$_POST['tax'][$i],"booking_id"=>$booking_id);
					$this->db->insert('purchase_stock_item',$data);
				}

			}
		}
		else if ($expense_head=="26") {
			# code...
			$employee_id=$_POST['staff_id'];
			$month_id=$_POST['advance_salary_month'];
			$year_id=date("Y");
			$data= array('advance_salary' => $amount, 'employee_id' => $employee_id, 'month_id' => $month_id,  'year_id' => $year_id, 'booking_id' => $booking_id);
			$this->db->insert("tbl_advance_salary",$data);
		}
		// else if($expense_head=="24")
		// {
		//     $bookingdate=date('Y-m-d');
		//     $data=array("purchase_date"=>$bookingdate,"amount"=>$amount,"booking_id"=>$booking_id);
		//     $this->db->insert("tbl_diesel",$data);
		// }

		return $booking_id;

	}
	public function deletebyid($booking_id)
	{
		$data=array("is_deleted"=>'1');
		$this->db->where('booking_id', $booking_id);
		$this->db->update('tbl_payment_booking',$data);
		$numrows=$this->db->affected_rows();
		$this->db->where('booking_id',$booking_id);
		$this->db->delete('purchase_stock_item');

		$this->db->where('booking_id',$booking_id);
		$this->db->delete('tbl_advance_salary');

		$this->db->where('booking_id',$booking_id);
		$this->db->delete('loan_booking');
		return $numrows;
	}
	public function confirmbyid($booking_id)
	{
		// This function should now only set is_confirm to 1 if approved_by_user2 is 1
		$data=array("is_confirm"=>'1',"confirm_by"=>$this->session->userdata('user_id'));
		$this->db->where('booking_id', $booking_id);
		$this->db->where('approved_by_user2', '1'); // Only confirm if Aakash has approved
		$this->db->update('tbl_payment_booking',$data);
		return $this->db->affected_rows();
	}

	public function verify_by_user2($booking_id) // New function for Aakash's verification
	{
		$data=array("approved_by_user2"=>'1');
		$this->db->where('booking_id', $booking_id);
		$this->db->update('tbl_payment_booking',$data);
		return $this->db->affected_rows();
	}

	public function paybyid($booking_id,$payment_mode)
	{
		//$data=array("is_confirm"=>'2',"confirm_by"=>,"payment_mode"=>$payment_mode);
		$datetime=date('Y-m-d h:i:s');
		$date=date('Y-m-d');
		$data=array("is_confirm"=>'2',"confirm_by"=>$this->session->userdata('user_id'),"payment_mode"=>$payment_mode,"payment_date"=>$datetime);
		$this->db->where('booking_id', $booking_id);
		$this->db->update('tbl_payment_booking',$data);
		$updatedrows=$this->db->affected_rows();
		$sql=$this->db->select('expense_head_id,amount,tds_amount,is_tds,ref_id,receiver_type')
			->from('tbl_payment_booking')
			->where('booking_id', $booking_id)
			->get();
		$row=$sql->row();
		if($row->expense_head_id=="24")
		{
			$bookingdate=date('Y-m-d');
			$data=array("purchase_date"=>$datetime,"amount"=>$row->amount,"booking_id"=>$booking_id);
			$this->db->insert("tbl_diesel",$data);
		}
		else if($row->expense_head_id=="26")
		{
			$bookingdate=date('Y-m-d');
			$data=array("payment_date"=>$bookingdate);
			$this->db->where('booking_id', $booking_id);
			$this->db->update('tbl_advance_salary',$data);

		}
		if($row->tds_amount>0)
		{
			$data=array("payment_date"=>$date,"tds_amount"=>$row->tds_amount,"ref_id"=>$row->ref_id,"ref_type"=>$row->receiver_type);
			$this->db->insert("tbl_tds",$data);
		}
		return $updatedrows;
	}
	public function getpurchase_stock_item($payment_booking_id)
	{
		$query=$this->db->select('`item_id`, `qty`, `tax`')
			->from('purchase_stock_item')
			->where(array("booking_id"=>$payment_booking_id))
			->get();
		$record=$query->result_array();
		return $record;
	}
	public function getTotalOutstanding()
	{
		$sql=$this->db->select('sum(amount) as total_outstanding')
			->from('tbl_payment_booking')
			->where('is_confirm','1')
			->where('is_deleted','0')
			->get();
		$data=$sql->row();
		return $data->total_outstanding;
	}
}
?>
