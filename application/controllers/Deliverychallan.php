<?php
class Deliverychallan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Delivery Challan";
        //$this->load->model('Mdl_DeliveryChallan');
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
        //echo $this->input->get('consignee'); exit();
        $data['title']="Delivery Challan";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->view('deliverychallan/deliverychallan_details',$data);
    }

    public function getrecord()
    {
        $consignee=$this->input->get('consignee');
        //echo $this->uri->segment(3); exit;
        // if($this->input->post('consignee')){ echo "<script>alert($this->input->post('consignee'))</script>";  }
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');

        // $temp=$this->Mdl_consigment->getconsignmentdc($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir'],$new_consignee_id);
        $temp=$this->Mdl_consigment->getconsignmentdc($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir'],$consignee);
        //echo $temp; exit();
		$data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr = $this->input->get('start')+1;
        $billtype=["FTL","Part Load","Skip"];
//		echo '<pre>';
//		print_r($temp['data']); exit();
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            if($row['invoice_id']==0) {
              if(!empty($consignee)){ $arr[] = "<input type='checkbox' name='consignment_id[]' value='$row[consignment_id]'><input type='hidden' name='consignee_name' value='$row[consignee_id]'><input type='hidden' name='bill_type' value='" . $row['bill_type'] . "'>"; } else { $arr[] ="<span class='label label-danger'>Invoice Pending</span>"; }
            } else { $arr[]="<div class='col-sm-6'><a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."'  class='' target='_blank'><span class='label label-primary'>View Invoice</span></a></div>"; }
            // $arr[]=$ctr;
            $arr[]=$row['dc_no'];
            $arr[]=date("d-m-Y",strtotime($row['consignment_date']));
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
//          $arr[]=$billtype[$row['bill_type']];
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
			// Fetching warehouse name
			$warehouse_name = $row['warehouse_city'] ?? 'N/A';
			$arr[] = $warehouse_name;
            if($row['consignment_status']=="0") $arr[]="Pending";
            else $arr[]="Completed";
            $arr[]="<div class='col-sm-6'><a href='".base_url('Deliverychallan/printDeliveryChallan/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'>
            <span class='label label-warning'>View Challan</span></a></div>";


          
            //FINDING ASSETS QUANTITY STARTS HERE.
            $query=$this->db->select('`qty`,rent_item_name as item_name,tbl_consignment_rent_item.item_id')
                ->from('tbl_consignment_rent_item')
                ->join('tbl_rent_item', 'tbl_rent_item.rent_item_id = tbl_consignment_rent_item.item_id', 'left')
                ->where(array("consignment_id"=>$row['consignment_id']))
                ->get();
            $record['asstes_qty']=$query->row();
            $arr[]=$record['asstes_qty']->qty;
            //FINDING ASSETS QUANTITY ENDS HERE.
          
            $arr[]="<div class='col-sm-6'><a href='".base_url('Deliverychallan/edit/').encryptor("encrypt",$row['consignment_id'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''>
            <i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('consignment/printLR/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'>
            <i class='fa fa-print'></i></a></div>";
            //$arr[]="<div class='col-sm-6'><a href='".base_url('consignment/printvehicle/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'><i class='fa fa-car'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

//    public function getrecord()
//    {
//        // echo 6676; exit();
//        $data['draw']=$this->input->get('draw');
//        $start=$this->input->get('start');
//        $length=$this->input->get('length');
//        $searchstr=$this->input->get('search');
//        $orderfield=$this->input->get('order');
//        $temp=$this->Mdl_DeliveryChallan->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
//        $data['recordsTotal']=$temp['count'];
//        $data['recordsFiltered']=$temp['count'];
//        $data["data"]=array();
//        $ctr=$this->input->get('start')+1;
//        $billtype=["FTL","Part Load","Skip"];
//        foreach ($temp['data'] as $row)
//        {
//            $arr=[];
//            $arr[]="<input type='checkbox' name='consignment_id[]' value='$row[consignment_no]'>";
//            $arr[]=$ctr;
////            $arr[]=$row['consignment_no'];
////            $arr[]=date("d-m-Y",strtotime($row['consignment_date']));
////            $arr[]=$row['consignor_name'];
////            $arr[]=$row['consignee_name'];
//////            $arr[]=$billtype[$row['bill_type']];
////            $arr[]=$row['vehicle_inward_no'];
////            $arr[]=$row['driver_name'];
////            if($row['consignment_status']=="0")
////                $arr[]="Pending";
////            else
////                $arr[]="Completed";
////            if($row['invoice_done_status']=="0")
////               // $arr[]="Pending";
////               // $arr[]="<a href='".base_url('Deliverychallan/addInvoice/').encryptor("encrypt",$row['consignee_id']).'/'.encryptor("encrypt",$row['bill_type'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''><button type='button' class='btn btn-warning btn-xs'>Make Invoice</button>";
////                $arr[]="<a target='_blank' href='".base_url('Invoice/addRentInvoice/').encryptor("encrypt",$row['consignment_id']).'/'.encryptor("encrypt",$row['consignee_id']).'/'.encryptor("encrypt",$row['bill_type'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''><button type='button' class='btn btn-warning btn-xs'>Make Invoice</button>";
////            else
////                $arr[]="<a href='".base_url('Deliverychallan/viewInvoice/').encryptor("encrypt",$row['consignee_id'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''><button type='button' class='btn btn-primary btn-xs'>View Invoice</button>";
////            //    $arr[]=$row['invoice_done_status'];
//
//
//           /// $arr[]="<div class='col-sm-6'><a href='".base_url('Deliverychallan/edit/').encryptor("encrypt",$row['consignment_id'])."' refid='".encryptor("encrypt",$row['consignment_id'])."' class=''><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('Deliverychallan/printDC/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'><i class='fa fa-eye'></i></a></div>";
//          //  $arr[]="<div class='col-sm-6'><a href='".base_url('Deliverychallan/printDeliveryChallan/').encryptor("encrypt",$row['consignment_id'])."'  class='' target='_blank'><i class='fa fa-print'></i></a></div>";
//            array_push($data['data'],$arr);
//            $ctr++;
//        }
//        echo json_encode($data);
//    }
    
    public function add()
    {
        if(isset($_POST['consignor_id']))
        {
            $lastid=$this->Mdl_DeliveryChallan->saveconsignment($_POST);
            redirect(base_url('DeliveryChallan'));
        }
        else
        {
            $data['title']="Add Delivery Challan";
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $data['item']=$this->Mdl_item->getitem("","","","","");
            $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $this->load->model('Mdl_warehouse');
            $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
            $this->load->view('deliverychallan/add_deliverychallan',$data);
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
