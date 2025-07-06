<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Account extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Inward account";
        //$this->load->model('Mdl_account');
        $this->load->model('Mdl_account');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Inward account";
        $this->load->view('account/account_details',$data);
    }
    public function add()
    {
        if(isset($_POST['party_name']))
        {
            $lastid=$this->Mdl_account->saveaccount($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Inward account";
            $start="";
            $length="";
            $searchstr="";
            $this->load->view('account/add_account',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['party_name']))
        {
            return $this->Mdl_account->updateaccount($_POST);
        }
        else {
            $data['title'] = "Edit Inward account";
            $account_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_account->getaccountbyid($account_id);
            $this->load->view('account/edit_account', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Inward account";
        $data['condition']='popup';
        $start="";
        $length="";
        $this->load->view('account/add_account',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit account";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $account_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_account->getaccountbyid($account_id);
        $this->load->view('account/edit_account', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_account->getaccount($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['party_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['gstin'];
            $arr[]=$row['bank_name'];
            $arr[]=$row['branch'];
            $arr[]=$row['account_no'];
            $arr[]=$row['ifsc_code'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['account_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['account_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
        $account_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->Mdl_account->deletebyid($account_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>