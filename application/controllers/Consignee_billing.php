<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Consignee_billing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="consignee_billing";
        $this->load->model('Mdl_consignee_billing');
        $this->load->model('Mdl_place');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="consignee_billing";
        $this->load->view('consignee_billing/consignee_billing_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignee_billing_name']))
        {
            $lastid=$this->Mdl_consignee_billing->saveconsignee_billing($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add consignee_billing";
            $this->load->view('consignee_billing/add_consignee_billing',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['consignee_billing_name']))
        {
            $this->Mdl_consignee_billing->updateconsignee_billing($_POST);
            return "true";

        }
        else {
            $data['title'] = "Edit consignee_billing";
            $consignee_billing_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_consignee_billing->getconsignee_billingbyid($consignee_billing_id);
            $this->load->view('consignee_billing/edit_consignee_billing', $data);
        }
    }
    function deleterecord(){
        $consignee_billing_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_consignee_billing->deletebyid($consignee_billing_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add consignee_billing";
        $data['condition']='popup';
        $data["place"]=$temp=$this->Mdl_place->getplace("","","","","","");
        $this->load->view('consignee_billing/add_consignee_billing',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit consignee_billing";
        $data['condition']='popup';
        $consignee_billing_id = encryptor("decrypt", $this->input->get('id'));
        $data["place"]=$temp=$this->Mdl_place->getplace("","","","","","");
        $data['form_data'] = $this->Mdl_consignee_billing->getconsignee_billingbyid($consignee_billing_id);
        $this->load->view('consignee_billing/edit_consignee_billing', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_consignee_billing->getconsignee_billing($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignee_billing_name'];
            $arr[]=$row['address'];
            $arr[]=$row['city'];
            $arr[]=$row['state'];
            $arr[]=$row['pincode'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['gstin'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignee_billing_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignee_billing_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function getconsignee_billingByPlace()
    {
        $place_id=$this->input->post('place');
        echo json_encode($this->Mdl_consignee_billing->getconsignee_billingByPlace($place_id));
    }

}
?>