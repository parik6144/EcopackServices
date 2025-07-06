<?php
class Inward extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_consignor');
        $this->load->model('mdl_vehicle_inward');
        $this->load->model('Mdl_item');
        $this->load->model('Mdl_inward_employee');
        $this->load->model('Mdl_inward');
        $this->load->model('Mdl_setting');

    }

    
    public function index()
    {
        $data['title']="inward";
        $this->load->view('inward/inward_details',$data);
    }
    
  
   public function add()
    {
        if(isset($_POST['consignor_name']))
        {
            $lastid=$this->Mdl_inward->saveinward($_POST);
            //echo "<script type='text/javascript'> window.open('".base_url('inward/printinward/').encryptor("encrypt",$lastid)."','_blank')</script>";
            redirect(base_url('inward'));
        }
        else
        {
            $data['title']="Add Inward";
            $data['item']=$this->Mdl_item->getitem("","","","","");
            $data['vehicle']=$this->mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['employee']=$this->Mdl_inward_employee->getinward_employee("","","","","");
            $this->load->model('Mdl_rentstocktransfer');
            $data['consignment_id']=$this->Mdl_rentstocktransfer->transitconsignment();
            $this->load->model('Mdl_staff');
            $data['staff']=$this->Mdl_staff->getstaff("","","","","");
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->view('inward/add_inward',$data);
        }
    }
  
    public function edit()
    {
        if(isset($_POST['consignor_name']))
        {
            $lastid=$this->Mdl_inward->updateinward($_POST);
            //echo "<script type='text/javascript'> window.open('".base_url('inward/printinward/').encryptor("encrypt",$lastid)."','_blank')</script>";
            redirect(base_url('inward'));
            //redirect(base_url('Inward/print/').$lastid);
        }
        else
        {
            $data['title']="Edit Inward";
            $data['edit_data']=$this->Mdl_inward->getinwardbyid($this->input->get('id'));
            if($data['edit_data']['row']->inward_type=="0")
                $data['item']=$this->Mdl_item->getItemByConsignee($data['edit_data']['row']->destiantion_id);
            else
                $data['item']=$this->Mdl_item->getRentItemByConsignee($data['edit_data']['row']->rent_consignee_id);
            $data['vehicle']=$this->mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
            $data['consignor']=$this->Mdl_consignor->getconsignor("","","","","");
            $data['employee']=$this->Mdl_inward_employee->getEmployeeByConsignor($data['edit_data']['row']->source_id);
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->model('Mdl_staff');
            $data['staff']=$this->Mdl_staff->getstaff("","","","","");
            $this->load->view('inward/edit_inward',$data);
        }
    }
    
    // public function getrecord()
    // {
    //     $data['draw']=$this->input->get('draw');
    //     $start=$this->input->get('start');
    //     $length=$this->input->get('length');
    //     $searchstr=$this->input->get('search');
    //     $orderfield=$this->input->get('order');
    //     $temp=$this->Mdl_inward->getinward($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
    //     $data['recordsTotal']=$temp['count'];
    //     $data['recordsFiltered']=$temp['count'];
    //     $data["data"]=array();
    //     $ctr=$this->input->get('start')+1;
    //     foreach ($temp['data'] as $row)
    //     {
    //         $arr=[];
    //         $arr[]=$row['inward_id'];
    //         $arr[]=date("d-m-Y",strtotime($row['inward_date']));
    //         $arr[]=$row['consignor_name'];
    //         $arr[]=$row['consignee_name'];
    //         $arr[]=$row['vehicle_inward_no'];
    //         $arr[]=$row['driver_name'];
    //         $arr[]=$row['mobile_no'];
    //         $arr[]="<div class='col-sm-6'><a href='".base_url('inward/edit?id=').encryptor("encrypt",$row['inward_id'])."' refid='".encryptor("encrypt",$row['inward_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('inward/printinward/').encryptor("encrypt",$row['inward_id'])."' target='_blank'><i class='fa fa-print'></i></a></div>";
    //         array_push($data['data'],$arr);
    //         $ctr++;
    //     }
    //     echo json_encode($data);
    // }
    
       public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_inward->getinward($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$row['inward_id'];
            $arr[]=$row['inward_no'];
            $arr[]=date("d-m-Y",strtotime($row['inward_date']));
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
            $arr[]=$row['mobile_no'];
            $arr[]="<div class='col-sm-6'><a href='".base_url('inward/edit?id=').encryptor("encrypt",$row['inward_id'])."' refid='".encryptor("encrypt",$row['inward_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('inward/printinward/').encryptor("encrypt",$row['inward_id'])."' target='_blank'><i class='fa fa-print'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    

    public function printinward($id="")
    {   
        if(empty($id)){
            redirect(base_url('inward'));
        }
        else
        {
            //echo 56456; exit();
            $refid=encryptor('decrypt',$id);
            $data['title']="Print Challan";
            $data['data']=$this->Mdl_inward->getinwardForPrint($refid);
            $this->load->view('inward/print',$data);
        }
    }
    public function getconsignment()
    {
        if(isset($_POST['consignment_id']))
        {
            $consignment_id=$_POST['consignment_id'];

            $this->load->model('mdl_consigment');
            $this->load->model('mdl_rentstocktransfer');
            $data['consignment']=$this->mdl_consigment->getconsignmentbyid($consignment_id,'inward');
            $data['stock']=$this->mdl_rentstocktransfer->getStockByConsignment($consignment_id);
            echo json_encode($data);
        }
        
    }
}
?>