<?php
class Transport_invoice_rate extends CI_Controller
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
        $this->load->model('Mdl_transport_invoice_rate');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Transport Invoice Rate";
        $this->load->view('transport_invoice_rate/transport_invoice_rate_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_transport_invoice_rate->saveinvoicerate($_POST);
            //redirect(base_url('inward'));
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
            $this->load->model('Mdl_consignee_billing');
            $data['billing_address']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
            $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
            $data['condition']='popup';
            $this->load->view('transport_invoice_rate/add_transport_invoice_rate',$data);
        }
    }
    public function editpopup()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_inwardrate->saveinwardrate($_POST);
        }
        else
        {
            $data['title']="Add Rate";
            $data['edit_data']=$this->Mdl_transport_invoice_rate->gettransportinvoiceratebyid($this->input->get('id'));
            $this->load->model('Mdl_consignee_billing');
            $data['billing_address']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
            $data['condition']='popup';
            $this->load->view('transport_invoice_rate/edit_transport_invoice_rate',$data);
        }
    }
    public function edit()
    {
        
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_transport_invoice_rate->updatetransportinvoicerate($_POST);
            echo $lastid;
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
        $temp=$this->Mdl_transport_invoice_rate->getinwardrate($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['consignee_billing_name'];
            if($row['bill_type']=="0")
                $arr[]="FTL";
            else
                $arr[]="Per Piece";
            if($row['data_type']=="0")
                $arr[]="Outward";
            else
                $arr[]="Inward";
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['transport_invoice_rate_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['transport_invoice_rate_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    
    public function deleterecord()
    {
        $transport_invoice_rate_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_transport_invoice_rate->deletebyid($transport_invoice_rate_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function isexist()
    {
        $consignor_id=$_POST['consignor_id'];
        $consignee_id=$_POST['consignee_id'];
        $invoice_type=$_POST['invoice_type'];
        $data_type=$_POST['data_type'];
        $record=$this->Mdl_transport_invoice_rate->checkrecord($consignor_id,$consignee_id,$invoice_type,$data_type);
        echo $record;
    }
}
?>