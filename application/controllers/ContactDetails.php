<?php

class ContactDetails extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="contact";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_contact');
        $this->load->model('Mdl_contact_details');
        $this->load->model('Mdl_setting');
    
    }
    public function index()
    {
        $data['title']="contact";
        $this->load->view('contact_details/contact_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignee_id']))
        {
            $lastid=$this->Mdl_contact_details->savecontact($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add contact";
            $start="";
            $length="";
            $searchstr="";
            $this->load->model('Mdl_consignee');
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $this->load->model('Mdl_consignor');
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $this->load->view('contact_details/add_contact_master',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['consignee_id']))
        {
            return $this->Mdl_contact_details->updatecontact($_POST);

        }
        else
        {
            $data['title'] = "Edit contact";
            $start="";
            $length="";
            $searchstr="";
            $contact_id = encryptor("decrypt", $this->input->get('id'));
            $this->load->model('Mdl_consignee');
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $this->load->model('Mdl_consignor');
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['form_data'] = $this->Mdl_contact_details->getcontactbyid($contact_id);
            $this->load->view('contact_details/edit_contact_master', $data);
        }
        
    }

    public function addpopup()
    {
        $data['title']="Add contact";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $this->load->model('Mdl_consignee');
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->model('Mdl_consignor');
        $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
        $this->load->view('contact_details/add_contact_master',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit contact";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $contact_id = encryptor("decrypt", $this->input->get('id'));
        $this->load->model('Mdl_consignee');
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $data['form_data'] = $this->Mdl_contact_details->getcontactbyid($contact_id);
        $this->load->view('contact_details/edit_contact_master', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_contact_details->getcontact($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            //`contact_id`, `email_id`, `person_name`, `mobile_no`, `reason`,`consignee_name`
            if($row['contact_type']=="0")
                $arr[]=$row['consignee_name'];
            else
                $arr[]=$row['consignor_name'];        
            $arr[]=$row['reason']; 
            $arr[]=$row['person_name']; 
            $arr[]=$row['mobile_no']; 
            $arr[]=$row['email_id']; 
                                
            $arr[]="<div class='col-sm-6'><a href='".base_url('ContactDetails/edit?id=').encryptor("encrypt",$row['contact_id'])."' refid='".encryptor("encrypt",$row['contact_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['contact_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
         $contact_id = encryptor("decrypt", $this->input->post('delete'));
         
         $record=$this->Mdl_contact_details->deletebyid($contact_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getrentcontactByConsigneeId()
    {
        echo json_encode($this->Mdl_contact_details->getcontact_masterByConsignee($this->input->post('consignee_id')));
    }
}
?>