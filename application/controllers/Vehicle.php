<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Vehicle extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="vehicle";
        $this->load->model('Mdl_vehicle');
        $this->load->model('Mdl_owner');
        $this->load->model('Mdl_vehicle_type');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="vehicle";
        $this->load->view('vehicle/vehicle_details',$data);
    }
    public function add()
    {
        if(isset($_POST['vehicle_no']))
        {
            $lastid=$this->Mdl_vehicle->savevehicle($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['owner']=$this->Mdl_owner->getowner("","","","","");
            $data['title']="Add vehicle";
            $this->load->view('vehicle/add_vehicle',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['vehicle_no']))
        {
            $this->Mdl_vehicle->updatevehicle($_POST);

        }
        else {
            $data['title'] = "Edit vehicle";
            $vehicle_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_vehicle->getvehiclebyid($vehicle_id);
            $this->load->view('vehicle/edit_vehicle', $data);
        }
    }
    function deleterecord(){
        $vehicle_id = encryptor("decrypt", $this->input->post('delete'));
        $record=$this->Mdl_vehicle->deletebyid($vehicle_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add vehicle";
        $data['owner']=$this->Mdl_owner->getowner("","","","","");
        $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
        $data['condition']='popup';
        $this->load->view('vehicle/add_vehicle',$data);
    }
    public function editpopup()
    {
        
        $data['title'] = "Edit vehicle";
        $data['condition']='popup';
        $data['owner']=$this->Mdl_owner->getowner("","","","","");
        $vehicle_id = encryptor("decrypt", $this->input->get('id'));
        $data['vehicle_type']=$this->Mdl_vehicle_type->getvehicle_type("","","","","");
        $data['form_data'] = $this->Mdl_vehicle->getvehiclebyid($vehicle_id);
        $this->load->view('vehicle/edit_vehicle', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_vehicle->getvehicle($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['vehicle_no'];
            $arr[]=$row['driver_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['owner_name'];
            $arr[]=$row['vehicle_type'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function validation()
    {
        $vehicle_no=$this->input->post('vehicle_no');
        echo $this->Mdl_vehicle->validation($vehicle_no);
    }
    public function getvehicledetails()
    {
        $vehicle_id=$this->input->post('vehicle_id');
        echo json_encode($this->Mdl_vehicle->getvehicledetails($vehicle_id));
    }

}
?>