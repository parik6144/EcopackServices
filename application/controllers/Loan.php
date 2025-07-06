<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Loan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        
        $this->load->model('Mdl_loan');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="loan";
        $this->load->view('loan/loan_details',$data);
    }
    public function add()
    {
        if(isset($_POST['account_id']))
        {
            $lastid=$this->Mdl_loan->saveloan($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Inward loan";
            $this->load->model('Mdl_account');
            $data['account']=$this->Mdl_account->getaccount("","","","","");
            $this->load->view('loan/add_loan',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['account_id']))
        {
            return $this->Mdl_loan->updateloan($_POST);
        }
        else {
            $data['title'] = "Edit Inward loan";
            $loan_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_loan->getloanbyid($loan_id);
            $this->load->view('loan/edit_loan', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Inward loan";
        $data['condition']='popup';
        
        $this->load->model('Mdl_account');
        $data['account']=$this->Mdl_account->getaccount("","","","","");
        $this->load->view('loan/add_loan',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit loan";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $loan_id = encryptor("decrypt", $this->input->get('id'));
        $this->load->model('Mdl_account');
        $data['account']=$this->Mdl_account->getaccount("","","","","");
        $data['form_data'] = $this->Mdl_loan->getloanbyid($loan_id);
        $this->load->view('loan/edit_loan', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_loan->getloan($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {

            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['party_name'];
            $arr[]=date("d-m-y",strtotime($row['loan_date']));
            $arr[]=$row['loan_amount'];
            $arr[]=$row['due_amount'];
            $arr[]=$row['interest_rate'];
            $arr[]=$row['monthly_emi'];
            $arr[]=$row['loan_time'];
            if($row['loan_type']=="1")
                $arr[]="EMI";
            else if($row['loan_type']=="2")
                $arr[]="Interest";
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['loan_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['loan_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
        $loan_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->Mdl_loan->deletebyid($loan_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>