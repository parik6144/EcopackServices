<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Monthly_booking_list extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="monthly_booking_list";
        $this->load->model('Mdl_monthly_booking_list');
        header("Access-Control-Allow-Origin: *");
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['employee']=$this->Mdl_monthly_booking_list->getmonthly_booking_list('1');
        $data['transporter']=$this->Mdl_monthly_booking_list->getmonthly_booking_list('3');
        $data['other_party']=$this->Mdl_monthly_booking_list->getmonthly_booking_list('2');
        $data['title']="monthly_booking_list";
        $this->load->view('monthly_booking_list/monthly_booking_list_details',$data);
    }
    public function add()
    {
        if(isset($_POST['receiver_type']))
        {
            $lastid=$this->Mdl_monthly_booking_list->savemonthly_booking_list($_POST);
            redirect(base_url('monthly_booking_list'), 'refresh');
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
            $data['expense_head']=$this->Mdl_expense_head->getexpense_head('','','','','');
            $data['staff']=$this->Mdl_staff->getstaff("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $data['account']=$this->Mdl_account->getaccount("","","","","");
            $data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
            $data['title']="Add monthly_booking_list";
            $this->load->view('monthly_booking_list/add_monthly_booking_list',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['party_name']))
        {
            $this->Mdl_monthly_booking_list->updatemonthly_booking_list($_POST);

        }
        else {
            $data['title'] = "Edit monthly_booking_list";
            $monthly_booking_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_monthly_booking_list->getmonthly_booking_listbyid($monthly_booking_id);
            $this->load->view('monthly_booking_list/edit_monthly_booking_list', $data);
        }
    }
    function deleterecord(){
         $monthly_booking_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_monthly_booking_list->deletebyid($monthly_booking_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add monthly_booking_list";

        $data['condition']='popup';
        $this->load->view('monthly_booking_list/add_monthly_booking_list',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit monthly_booking_list";
        $data['condition']='popup';
        $monthly_booking_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_monthly_booking_list->getmonthly_booking_listbyid($monthly_booking_id);
        $this->load->view('monthly_booking_list/edit_monthly_booking_list', $data);
    }
    public function getrecord()
    {

        $temp=$this->Mdl_monthly_booking_list->getmonthly_booking_list();
        var_dump($temp);
        exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['party_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['monthly_booking_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['monthly_booking_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    // public function getac()
    // {
    //     $data=$this->Mdl_monthly_booking_list->getnotification();
    //     $response["notification_text"]=$data['0']["notification_text"];
    //     $response["notification_heading"]=$data['0']["notification_heading"];
    //     echo json_encode($response);
    // }
}
?>