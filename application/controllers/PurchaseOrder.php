<?php
class PurchaseOrder extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Purchase Order";
        $this->load->model('Mdl_consigment');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_consignor');
        $this->load->model('Mdl_vehicle_inward');
        $this->load->model('Mdl_place');
        $this->load->model('Mdl_item');
        $this->load->model('Mdl_employee');
        $this->load->model('Mdl_setting');
    }

    public function add()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_DeliveryChallan->saveconsignment($_POST);
            redirect(base_url('PurchaseOrder'));
        }
        else
        {
            $data['title']="Add Purchase Order";
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $data['item']=$this->Mdl_item->getitem("","","","","");
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->view('purchase_order/add_purchaseorder',$data);
        }
    }

    // public function edit($id="")
    // {
    //     if(isset($_POST['consignment_id']))
    //     {
    //         $this->Mdl_consigment->updateconsignment($_POST);
    //         redirect(base_url('consignment'));
    //     }
    //     else
    //     {
    //         $data['title'] = "Edit consignment";
    //         $consignment_id = encryptor("decrypt", $id);
    //         $data['place']=$this->Mdl_place->getplace("","","","","");
    //         $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
    //         $data['employee']=$this->Mdl_employee->getemployee("","","","","");
    //         $data['form_data'] = $this->Mdl_consigment->getconsignmentbyid($consignment_id);
    //         $data['consignor']=$this->Mdl_consignor->getConsignorByPlace($data['form_data']['consignment']->source_id);
    //         $data['consignee']=$this->Mdl_consignee->getConsigneeByPlace($data['form_data']['consignment']->destination_id);
    //         $this->load->model('Mdl_warehouse');
    //         $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
    //         if($data['form_data']['consignment']->consignment_type=="0")
    //             $data['item']=$this->Mdl_item->getItemByConsignee($data['form_data']['consignment']->consignee_id);
    //         else{
    //             $this->load->model('Mdl_rent_item');
    //             $data['item']=$this->Mdl_rent_item->getrentitemByConsignee($data['form_data']['consignment']->consignee_id);
    //             $data['rent_stock_item']=$this->Mdl_item->getRentItemByConsignee($data['form_data']['consignment']->consignee_id);
    //         }
            
    //         $this->load->view('consignment/edit_consignment', $data);
    //     }
    // }
    
     public function edit($id="")
    {
        if(isset($_POST['consignment_id']))
        {
            $this->Mdl_consigment->updateconsignment($_POST);
            $this->session->set_flashdata('update', 'Delivery Challan Updated Successfully.');
            redirect(base_url('Deliverychallan'));
        }
        else
        {
            $data['title'] = "Edit Delivery Challan";
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
            $this->load->view('deliverychallan/edit_deliverychallan', $data);
        }
    }
    
    public function printDC($id="")
        {
        $data['title'] = "DC Print";
        $consignment_id = encryptor("decrypt", $id);
        //echo $consignment_id;
        $data['form_data'] = $this->Mdl_DeliveryChallan->getconsignmentforprint($consignment_id);
        // print_r($data['form_data']); exit();
        $this->load->view('deliverychallan/deliverychallannew', $data);
        }

  public function printDeliveryChallan($id="")
    {
        $data['title'] = "DC Print";
        $consignment_id = encryptor("decrypt", $id);
        // echo $consignment_id; exit();
        // $data['form_data'] = $this->Mdl_DeliveryChallan->getconsignmentforprint($consignment_id);
        $data['form_data'] = $this->Mdl_consigment->getconsignmentforprint($consignment_id);
        // print_r($data['consignment_item']); exit();
       // print_r($data['form_data']); exit();
        // $this->load->view('deliverychallan/deliverychallannew', $data);
        $this->load->view('deliverychallan/PrintDC', $data);
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

}
?>