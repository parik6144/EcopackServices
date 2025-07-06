<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Vehicle_inward extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="vehicle_inward";
        $this->load->model('Mdl_vehicle_inward');
        $this->load->model('Mdl_inward_owner');
        $this->load->model('Mdl_vehicle_type');
        $this->load->model('Mdl_inwardrate');
        $this->load->model('Mdl_outwardrate');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="vehicle_inward";
        $this->load->view('vehicle_inward/vehicle_inward_details',$data);
    }
    public function add()
    {
        if(isset($_POST['vehicle_inward_no']))
        {
            $lastid=$this->Mdl_vehicle_inward->savevehicle_inward($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add vehicle_inward";
            $data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
            $this->load->view('vehicle_inward/add_vehicle_inward',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['vehicle_inward_no']))
        {
            $this->Mdl_vehicle_inward->updatevehicle_inward($_POST);

        }
        else {
            $data['title'] = "Edit vehicle_inward";
            $vehicle_inward_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_vehicle_inward->getvehicle_inwardbyid($vehicle_inward_id);
            $this->load->view('vehicle_inward/edit_vehicle_inward', $data);
        }
    }
    function deleterecord(){
        $vehicle_inward_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_vehicle_inward->deletebyid($vehicle_inward_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add vehicle_inward";
        $data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
        $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
        $data['condition']='popup';
        $this->load->view('vehicle_inward/add_vehicle_inward',$data);
    }
    public function editpopup()
    {
        
        $data['title'] = "Edit vehicle_inward";
        $data['condition']='popup';
        $data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
        $vehicle_inward_id = encryptor("decrypt", $this->input->get('id'));
        $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
        $data['form_data'] = $this->Mdl_vehicle_inward->getvehicle_inwardbyid($vehicle_inward_id);
        $this->load->view('vehicle_inward/edit_vehicle_inward', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_vehicle_inward->getvehicle_inward($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['owner_name'];
            $arr[]=$row['vehicle_type'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_inward_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_inward_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function validation()
    {
        $vehicle_inward_no=$this->input->post('vehicle_inward_no');
        echo $this->Mdl_vehicle_inward->validation($vehicle_inward_no);
    }
    public function getvehicledetails()
    {
        $vehicle_id=$this->input->post('vehicle_id');
        $consignor_id=$this->input->post('consignor_id');
        $consignee_id=$this->input->post('consignee_id');
        $response['vehicle']=$this->Mdl_vehicle_inward->getvehicledetails($vehicle_id);
        
        $response['amount']=$this->Mdl_inwardrate->getprice($consignor_id,$consignee_id,$response['vehicle']['0']['vehicle_type_id']);
        echo json_encode($response);
    }

    public function getvehicledetailsoutward()
    {
        $vehicle_id=$this->input->post('vehicle_id');
        $consignee_id=$this->input->post('consignee_id');
        $consignor_id=$this->input->post('consignor_id');
        $bill_type=$this->input->post('bill_type');
        $response['vehicle']=$this->Mdl_vehicle_inward->getvehicledetails($vehicle_id);
        $response['amount']=$this->Mdl_outwardrate->getprice($consignee_id,$consignor_id,$response['vehicle']['0']['vehicle_type_id'],$bill_type);
        echo json_encode($response);
    }
    public function getVehivleByOwnerId(){
        echo json_encode($this->Mdl_vehicle_inward->getVehicleByOwner());

    }

}
?>