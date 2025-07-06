<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Vehicletype extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="vehicle_type";
        $this->load->model('mdl_vehicle_type');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="vehicle_type";
        $this->load->view('vehicle_type/vehicle_type_details',$data);
    }
    public function add()
    {
        if(isset($_POST['vehicle_type']))
        {
            $lastid=$this->mdl_vehicle_type->savevehicle_type($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add vehicle_type";
            $this->load->view('vehicle_type/add_vehicle_type',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['vehicle_type']))
        {
            $this->mdl_vehicle_type->updatevehicle_type($_POST);

        }
        else {
            $data['title'] = "Edit vehicle_type";
            $vehicle_type_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_vehicle_type->getvehicle_typebyid($vehicle_type_id);
            $this->load->view('vehicle_type/edit_vehicle_type', $data);
        }
    }
    function deleterecord(){
         $vehicle_type_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_vehicle_type->deletebyid($vehicle_type_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add vehicle_type";

        $data['condition']='popup';
        $this->load->view('vehicle_type/add_vehicle_type',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit vehicle_type";
        $data['condition']='popup';
        $vehicle_type_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_vehicle_type->getvehicle_typebyid($vehicle_type_id);
        $this->load->view('vehicle_type/edit_vehicle_type', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_vehicle_type->getvehicle_type($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['vehicle_type'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_type_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['vehicle_type_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>