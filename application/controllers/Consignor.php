<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Consignor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="consignor";
        $this->load->model('Mdl_consignor');
        $this->load->model('Mdl_place');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="consignor";
        $this->load->view('consignor/consignor_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignor_name']))
        {
            $lastid=$this->Mdl_consignor->saveconsignor($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add consignor";
            $this->load->view('consignor/add_consignor',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['consignor_name']))
        {
            $this->Mdl_consignor->updateconsignor($_POST);

        }
        else {
            $data['title'] = "Edit consignor";
            $consignor_id = encryptor("decrypt", $this->input->get('id'));
            $data["place"]=$temp=$this->Mdl_place->getplace("","","","","","");
            $data['form_data'] = $this->Mdl_consignor->getconsignorbyid($consignor_id);
            $this->load->view('consignor/edit_consignor', $data);
        }
    }
    function deleterecord(){
        $consignor_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_consignor->deletebyid($consignor_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add consignor";
        $data['condition']='popup';
        $data["place"]=$temp=$this->Mdl_place->getplace("","","","","","");
        $this->load->view('consignor/add_consignor',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit consignor";
        $data['condition']='popup';
        $consignor_id = encryptor("decrypt", $this->input->get('id'));
        $data["place"]=$temp=$this->Mdl_place->getplace("","","","","","");
        $data['form_data'] = $this->Mdl_consignor->getconsignorbyid($consignor_id);
        $this->load->view('consignor/edit_consignor', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_consignor->getconsignor($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignor_name'];
            $arr[]=$row['party_name'];
            $arr[]=$row['address'];
            $arr[]=$row['city'];
            $arr[]=$row['state'];
            $arr[]=$row['pincode'];
            //$arr[]=$row['phone_no'];
            $arr[]=$row['mobile_no'];
            // $arr[]=$row['mobile_no1'];
            // $arr[]=$row['party_mobile_no'];
            $arr[]=$row['place_name'];
            $arr[]=$row['gstin'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignor_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignor_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function getConsignorByPlace()
    {
        $place_id=$this->input->post('place');
        echo json_encode($this->Mdl_consignor->getConsignorByPlace($place_id));
    }
}
?>