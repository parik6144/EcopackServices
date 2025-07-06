<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Payment_booking extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_id') == '')
			redirect(base_url(), 'refresh');
		$data['title']="payment_booking";
		$this->load->model('Mdl_payment_booking');
		$this->load->model('Mdl_setting');
	}

	public function index()
	{
		$data['title']="Payment Booking";
		$this->load->view('payment_booking/payment_booking_details',$data);
	}

	public function add()
	{
		if(isset($_POST['amount']))
		{
			$lastid=$this->Mdl_payment_booking->savebooking($_POST);
			if(isset($_POST['loan_id']))
			{
				redirect(base_url('payment_booking'), 'refresh');
			}
			else
				echo encryptor("encrypt",$lastid);
		}
		else
		{
			$data['title']="Add payment_booking";
			$this->load->model('Mdl_expense_head');
			$this->load->model('Mdl_staff');
			$this->load->model('Mdl_employee');
			$this->load->model('Mdl_inward_owner');
			$this->load->model('Mdl_account');
			$this->load->model('Mdl_expense_head');
			$this->load->model('Mdl_item_master');
			$this->load->model('Mdl_vehicle_inward');
			$this->load->model('Mdl_warehouse');
			$this->load->model('Mdl_branch');
			$data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
			$data['staff']=$this->Mdl_staff->getstaff("","","","","");
			$data['employee']=$this->Mdl_employee->getemployee("","","","","");
			$data['account']=$this->Mdl_account->getaccount("","","","","");
			$data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
			$data['item']=$this->Mdl_item_master->getitem("","","","","");
			$data['vehicle_no']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
			$data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
			$data['branch']=$this->Mdl_branch->getbranch("","","","","");
			$this->load->view('payment_booking/add_payment_booking',$data);
		}
	}
	public function edit()
	{
		if(isset($_POST['amount']))
		{
			$this->Mdl_payment_booking->updatepayment_booking($_POST);

		}
		else {
			$data['title'] = "Edit payment_booking";
			$this->load->model('Mdl_expense_head');
			$this->load->model('Mdl_staff');
			$this->load->model('Mdl_employee');
			$this->load->model('Mdl_inward_owner');
			$this->load->model('Mdl_account');
			$this->load->model('Mdl_expense_head');
			$this->load->model('Mdl_item_master');
			$this->load->model('Mdl_branch');
			$data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
			$data['staff']=$this->Mdl_staff->getstaff("","","","","");
			$data['employee']=$this->Mdl_employee->getemployee("","","","","");
			$data['account']=$this->Mdl_account->getaccount("","","","","");
			$data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
			$payment_booking_id = encryptor("decrypt", $this->input->get('id'));
			$data['item']=$this->Mdl_item_master->getitem("","","","","");

			$data['form_data'] = $this->Mdl_payment_booking->getpayment_bookingbyid($payment_booking_id);
			if($data['form_data']['payment_booking']['0']['expense_head_id']=="16")
			{
				$data['purchase_item']=$this->Mdl_payment_booking->getpurchase_stock_item($payment_booking_id);
			}
			$this->load->view('payment_booking/edit_payment_booking', $data);
		}
	}
	function deleterecord(){
		$payment_booking_id = encryptor("decrypt", $this->input->post('delete'));
		$record=$this->Mdl_payment_booking->deletebyid($payment_booking_id);
		if($record==1)
			echo "true";
		else
			echo "false";
	}

	public function addpopup()
	{
		$data['title']="Add payment_booking";
		$this->load->model('Mdl_expense_head');
		$this->load->model('Mdl_staff');
		$this->load->model('Mdl_employee');
		$this->load->model('Mdl_inward_owner');
		$this->load->model('Mdl_account');
		$this->load->model('Mdl_expense_head');
		$this->load->model('Mdl_item_master');
		$data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
		$data['staff']=$this->Mdl_staff->getstaff("","","","","");
		$data['employee']=$this->Mdl_employee->getemployee("","","","","");
		$data['account']=$this->Mdl_account->getaccount("","","","","");
		$data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
		$data['item']=$this->Mdl_item_master->getitem("","","","","");
		$data['condition']='popup';
		$this->load->view('payment_booking/add_payment_booking',$data);
	}

	public function editpopup()
	{
		$data['title'] = "Edit payment_booking";
		$data['condition']='popup';
		$this->load->model('Mdl_expense_head');
		$this->load->model('Mdl_staff');
		$this->load->model('Mdl_employee');
		$this->load->model('Mdl_inward_owner');
		$this->load->model('Mdl_account');
		$this->load->model('Mdl_expense_head');
		$data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
		$data['staff']=$this->Mdl_staff->getstaff("","","","","");
		$data['employee']=$this->Mdl_employee->getemployee("","","","","");
		$data['account']=$this->Mdl_account->getaccount("","","","","");
		$data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
		$payment_booking_id = encryptor("decrypt", $this->input->get('id'));
		$data['form_data'] = $this->Mdl_payment_booking->getpayment_bookingbyid($payment_booking_id);
		$this->load->view('payment_booking/edit_payment_booking', $data);
	}

	public function getrecord()
	{
		$data['draw']=$this->input->get('draw');
		$start=$this->input->get('start');
		$length=$this->input->get('length');
		$searchstr=$this->input->get('search');
		$orderfield=$this->input->get('order');
		$temp=$this->Mdl_payment_booking->getpayment_booking($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
		echo json_encode($temp);
	}

	public function confirm_booking() // This function now acts as 'Accept'
	{
		$payment_booking_id = encryptor("decrypt", $this->input->post('booking_id'));
		$record=$this->Mdl_payment_booking->confirmbyid($payment_booking_id);
		if($record==1)
			echo "true";
		else
			echo "false";
	}

	public function verify_user2() // New function for Aakash's verification
	{
		$payment_booking_id = encryptor("decrypt", $this->input->post('refid'));
		$record = $this->Mdl_payment_booking->verify_by_user2($payment_booking_id);
		if ($record == 1) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	public function loanbooking($loan_id,$loan_date)
	{
		$loanid=encryptor("decrypt",$loan_id );
		$this->load->model('Mdl_loan');

		$data['form_data']=$this->Mdl_loan->getloanbyid($loanid);
		// print_r($data['form_data']); exit();
		$booking_date=$data['form_data']['loan'][0]['booking_date'];
		$data['booking_date'] = date('d-m-Y',strtotime($booking_date));
		$data['loan_id']=$loanid;
		$data['loan_date']=$loan_date;

		$data['title'] = "Edit payment_booking";
		$this->load->model('Mdl_expense_head');
		$this->load->model('Mdl_account');
		$this->load->model('Mdl_expense_head');
		$data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
		$data['account']=$this->Mdl_account->getaccount("","","","","");

		$this->load->view('payment_booking/loan_payment_booking', $data);

	}
}
?>
