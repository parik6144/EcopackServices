<?php
Class diesel_expense extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('Mdl_diesel_expense');
        $this->load->model('Mdl_setting');
	}
	public function index()
	{
		$data['title']="Diesel Expense";
        $this->load->view('diesel_expense/diesel_expense_details',$data);
	}
	public function add()
    {
        if(isset($_POST['booking_date']))
        {
            $lastid=$this->Mdl_diesel_expense->savediesel_expense($_POST);
            redirect(base_url('diesel_expense'));
        }
        else
        {
            $data['title']="Add diesel_expense";
            $this->load->model('Mdl_vehicle_inward');
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $this->load->view('diesel_expense/add_diesel_expense',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['booking_date']))
        {
            $this->Mdl_diesel_expense->updatediesel_expense($_POST);
            redirect(base_url('diesel_expense'));
        }
        else {
            $data['title'] = "Edit diesel_expense";
            $this->load->model('Mdl_vehicle_inward');
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $diesel_expense_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_diesel_expense->getdiesel_expensebyid($diesel_expense_id);
            $this->load->view('diesel_expense/edit_diesel_expense', $data);
        }
    }
    function deleterecord(){
         $diesel_expense_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_diesel_expense->deletebyid($diesel_expense_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    
   
	public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_diesel_expense->getdiesel_expense($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-Y",strtotime($row['expense_date']));
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['amount'];
             $arr[]="<div class='col-sm-6'><a href='".base_url('diesel_expense/edit?id=').encryptor("encrypt",$row['expense_id'])."'  class=''><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#'  class=''><i class='fa fa-trash'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
	
}