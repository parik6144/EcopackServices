<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class VehicleTransportitem extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="Vehicle Transport Item";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_item');
        $this->load->model('Mdl_transportvehicle_item');
        $this->load->model('mdl_consignee');
        //$this->load->model('mdl_tax');
        $this->load->model('Mdl_setting');
    }

    public function index()
    {
        $data['title']="Vehicle Transport Item";
        $this->load->view('vehicle_transport_item/vehicle_transport_item_details',$data);
    }

    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_transportvehicle_item->getrentitem($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['rent_item_name'];
            //$arr[]=$row['consignee_name'];
            $arr[]=$row['adv_price'];
            $arr[]=$row['due_price'];
//            if($row['rent_type']=="0")
//                $arr[]="Per Consignment";
//            else
//                $arr[]="Per month";
            //$arr[]=$row['opening_stock'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_item_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_item_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }


    public function add()
    {
        if(isset($_POST['rent_item_name']))
        {
            $lastid=$this->Mdl_transportvehicle_item->saverentitem($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Transport Vehicle Item";
            $start="";
            $length="";
            $searchstr="";  
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");         
            $this->load->view('vehicle_transport_item/add_vehicle_transport_item',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['rent_item_name']))
        {
            return $this->Mdl_transportvehicle_item->updaterentitem($_POST);

        }
        else {
            $data['title'] = "Edit Item";
            $rent_item_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->Mdl_transportvehicle_item->getrentitembyid($rent_item_id);
            $this->load->view('vehicle_transport_item/edit_vehicle_transport_item', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $this->load->view('vehicle_transport_item/add_vehicle_transport_item',$data);
    }

    public function editpopup()
    {
        $data['title'] = "Edit Item";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $rent_item_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $data['form_data'] = $this->Mdl_transportvehicle_item->getrentitembyid($rent_item_id);
        $this->load->view('vehicle_transport_item/edit_vehicle_transport_item', $data);
    }

    function deleterecord(){
         $rent_item_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_transportvehicle_item->deletebyid($rent_item_id);
         if($record==1) echo "true"; else echo "false";
    }

    public function getrentitemByConsigneeId()
    {
        echo json_encode($this->Mdl_transportvehicle_item->getrent_itemByConsignee($this->input->post('consignee_id')));
    }
}
?>