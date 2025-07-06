<?php
class Consignment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_consigment');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_consignor');
        $this->load->model('Mdl_vehicle_inward');
        $this->load->model('Mdl_place');
        $this->load->model('Mdl_item');
        $this->load->model('Mdl_employee');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Consignment";
        $this->load->view('consignment/consignment_details',$data);
    }
    
    public function add()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_consigment->saveconsignment($_POST);
            //redirect(base_url('consignment'));
            if($_POST['is_dc']==0){ redirect(base_url('consignment')); }
            if($_POST['is_dc']==1){ redirect(base_url('Deliverychallan')); }
        }
        else
        {
            $data['title']="Add consignor";
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $data['item']=$this->Mdl_item->getitem("","","","","");
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->view('consignment/add_consignment',$data);
        }
    }
    
    public function edit($id="")
    {
        if(isset($_POST['consignment_id']))
        {
            $this->Mdl_consigment->updateconsignment($_POST);
            redirect(base_url('consignment'));
        }
        else
        {
            $data['title'] = "Edit consignment";
            $consignment_id = encryptor("decrypt", $id);
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $data['form_data'] = $this->Mdl_consigment->getconsignmentbyid($consignment_id);
            $data['consignor']=$this->Mdl_consignor->getConsignorByPlace($data['form_data']['consignment']->source_id);
            $data['consignee']=$this->Mdl_consignee->getConsigneeByPlace($data['form_data']['consignment']->destination_id);
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            if($data['form_data']['consignment']->consignment_type=="0")
                $data['item']=$this->Mdl_item->getItemByConsignee($data['form_data']['consignment']->consignee_id);
            else{
                $this->load->model('Mdl_rent_item');
                $data['item']=$this->Mdl_rent_item->getrentitemByConsignee($data['form_data']['consignment']->consignee_id);
                $data['rent_stock_item']=$this->Mdl_item->getRentItemByConsignee($data['form_data']['consignment']->consignee_id);
            }
            
            $this->load->view('consignment/edit_consignment', $data);
        }
    }
    
    public function printLR($id="")
    {
        $data['title'] = "LR Print";
        $consignment_id = encryptor("decrypt", $id);
        $data['form_data'] = $this->Mdl_consigment->getconsignmentforprint($consignment_id);
        $this->load->view('consignment/print_consignment', $data);
    }
    
    public function printvehicle($id="")
    {
        $data['title'] = "Print Vehicle";
        $consignment_id = encryptor("decrypt", $id);
        $data['form_data'] = $this->Mdl_consigment->getconsignmentforprint($consignment_id);
        $this->load->view('consignment/vehicle_print', $data);
    }
    
     public function Deliverychallan()
    {
        $data['title'] = "Delivery Challan";
        $this->load->view('Challan/deliverychallannew', $data);
    }
    
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_consigment->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        $billtype=["FTL","Part Load","Skip"];
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignment_no'];
            $arr[]=date("d-m-Y",strtotime($row['consignment_date']));
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
            $arr[]=$billtype[$row['bill_type']];
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
            if($row['consignment_status']=="0")
                $arr[]="Pending";
            else
                $arr[]="Completed";
                
            //$arr[]=$row['invoice_id'];
            if($row['invoice_id']=="0")
                $arr[]="<span class='label label-danger'>Pending</span>";
            else
                $arr[]="<a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."'  class='' target='_blank'><span class='label label-primary'>View Invoice</span></a>";

            $arr[]="<div class='col-sm-6'><a href='".base_url('consignment/edit/').encryptor("encrypt",$row['consignment_id'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('consignment/printLR/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'><i class='fa fa-print'></i></a></div>";

            $arr[]="<div class='col-sm-6'><a href='".base_url('consignment/printvehicle/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'><i class='fa fa-car'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>