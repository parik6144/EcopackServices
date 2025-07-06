<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Warehouse extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        /*if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');*/
        $data['title']="warehouse";
        $this->load->model('Mdl_warehouse');
        header("Access-Control-Allow-Origin: *");
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        
        $data['title']="warehouse";
        $this->load->view('warehouse/warehouse_details',$data);
    }
    public function add()
    {
        if(isset($_POST['warehouse_name']))
        {
            $lastid=$this->Mdl_warehouse->savewarehouse($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add warehouse";
            $this->load->view('warehouse/add_warehouse',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['warehouse_name']))
        {
            $this->Mdl_warehouse->updatewarehouse($_POST);

        }
        else {
            $data['title'] = "Edit warehouse";
            $warehouse_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_warehouse->getwarehousebyid($warehouse_id);
            $this->load->view('warehouse/edit_warehouse', $data);
        }
    }
    function deleterecord(){
         $warehouse_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_warehouse->deletebyid($warehouse_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add warehouse";

        $data['condition']='popup';
        $this->load->view('warehouse/add_warehouse',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit warehouse";
        $data['condition']='popup';
        $warehouse_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_warehouse->getwarehousebyid($warehouse_id);
        $this->load->view('warehouse/edit_warehouse', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_warehouse->getwarehouse($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['warehouse_name'];
            $arr[]=$row['warehouse_address'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['warehouse_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['warehouse_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function getac()
    {
        $data=$this->Mdl_warehouse->getnotification();
        $response["notification_text"]=$data['0']["notification_text"];
        $response["notification_heading"]=$data['0']["notification_heading"];
        echo json_encode($response);
    }
}
?>