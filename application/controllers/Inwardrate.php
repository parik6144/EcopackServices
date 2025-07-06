<?php
class Inwardrate extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_consignor');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_vehicle_type');
        $this->load->model('Mdl_inwardrate');
        $this->load->model('Mdl_setting');
        
    }
    public function index()
    {
        $data['title']="Inward Rate";
        $this->load->view('inward_rate/inward_rate_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_inwardrate->saveinwardrate($_POST);
            redirect(base_url('inward'));
        }
        else
        {
            $data['title']="Add Rate";
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
            $this->load->view('inward_rate/add_rate',$data);
        }
    }
    public function addpopup()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_inwardrate->saveinwardrate($_POST);
            redirect(base_url('inward'));
        }
        else
        {
            $data['title']="Add Rate";
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
            $data['condition']='popup';
            $this->load->view('inward_rate/add_rate',$data);
        }
    }
    public function editpopup()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_inwardrate->saveinwardrate($_POST);
            redirect(base_url('inward'));
        }
        else
        {
            $data['title']="Add Rate";
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
            $data['edit_data']=$this->Mdl_inwardrate->getinwardratebyid($this->input->get('id'));
            $data['condition']='popup';
            $this->load->view('inward_rate/edit_rate',$data);
        }
    }
    public function edit()
    {
        
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_inwardrate->updateinwardrate($_POST);
            redirect(base_url('inward'));
        }
        else
        {
            $data['title']="Edit Rate";
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
            $data['edit_data']=$this->Mdl_inwardrate->getinwardratebyid($this->input->get('id'));
            $this->load->view('inward_rate/edit_rate',$data);
        }
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_inwardrate->getinwardrate($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
            $arr[]=$row['vehicle_type'];
            $arr[]=$row['owner_price'];
            $arr[]=$row['driver_price'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rate_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rate_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function getprice()
    {
        $consignor_id=$_POST['consignor_id'];
        $consignee_id=$_POST['consignee_id'];
        $vehicle_type_id=$_POST['vehicle_type_id'];
        $record=$this->Mdl_inwardrate->getprice($consignor_id,$consignee_id,$vehicle_type_id);
        echo json_encode($record);
    }
    public function deleterecord()
    {
        $rate_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_inwardrate->deletebyid($rate_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
}
?>