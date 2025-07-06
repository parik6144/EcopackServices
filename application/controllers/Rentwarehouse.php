<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Rentwarehouse extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $data['title']="warehouse";
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        //$this->load->model('mdl_warehouse');
        $this->load->model('mdl_rent_warehouse');
        $this->load->model('mdl_consignee');
        //$this->load->model('mdl_tax');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="warehouse";
        $this->load->view('rent_warehouse/rent_warehouse_details',$data);
    }
    public function add()
    {
        if(isset($_POST['rent_warehouse_area']))
        {
            $lastid=$this->mdl_rent_warehouse->saverentwarehouse($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add warehouse";
            $start="";
            $length="";
            $searchstr="";  
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");         
            $this->load->view('rent_warehouse/add_rent_warehouse',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['rent_warehouse_area']))
        {
            return $this->mdl_rent_warehouse->updaterentwarehouse($_POST);

        }
        else {
            $data['title'] = "Edit warehouse";
            $rent_warehouse_id = encryptor("decrypt", $this->input->get('id'));
            $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
            $data['form_data'] = $this->mdl_rent_warehouse->getrentwarehousebyid($rent_warehouse_id);

            $this->load->view('rent_warehouse/edit_rent_warehouse', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add warehouse";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $this->load->view('rent_warehouse/add_rent_warehouse',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit warehouse";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $rent_warehouse_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignee']=$this->mdl_consignee->getconsignee("","","","","");
        //$data['tax']=$this->mdl_tax->gettax("","","","","");
        $data['form_data'] = $this->mdl_rent_warehouse->getrentwarehousebyid($rent_warehouse_id);
        $this->load->view('rent_warehouse/edit_rent_warehouse', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_rent_warehouse->getrentwarehouse($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignee_name'];            
            $arr[]=$row['price'];                      
            $arr[]=$row['rent_warehouse_area'];            
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_warehouse_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['rent_warehouse_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
         $rent_warehouse_id = encryptor("decrypt", $this->input->post('delete'));
         
         $record=$this->mdl_rent_warehouse->deletebyid($rent_warehouse_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function getrentwarehouseByConsigneeId()
    {
        echo json_encode($this->mdl_rent_warehouse->getrent_warehouseByConsignee($this->input->post('consignee_id')));
    }
}
?>