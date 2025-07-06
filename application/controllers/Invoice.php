<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Invoice extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // if($this->session->userdata('user_id') == '')
        //     redirect(base_url(), 'refresh');
        $data['title']="consignee";
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_invoice');
        $this->load->model('Mdl_setting');
        $this->load->model('Mdl_place'); 
        $this->load->model('Mdl_item'); 
        $this->load->model('Mdl_vehicle_inward'); 
        $this->load->model('Mdl_employee'); 
        $this->load->model('Mdl_warehouse');
        $this->load->model('Mdl_consignee_billing');
    }

    public function index()
    {
        $data['title']="Invoice";
        $this->load->view('invoice/invoice_details',$data);
    }
    
    public function Rent()
    {
        $data['title']="Rent Invoices || Ecopack Services";
        $this->load->view('invoice/invoice_details_rent',$data);
    }
    
     public function Transport()
    {
        $data['title']="Transportation Invoices || Ecopack Services";
        $this->load->view('invoice/invoice_details_transport',$data);
    }

    public function TransportAdd()
    {
        //var_dump($_POST); exit();
        if(isset($_POST['consignee_billing_name']) && (isset($_POST['invoice_type'])))
        {
            //echo 34432; exit();
            //echo $_POST['consignee_billing_name']; exit();
            //echo $_POST['invoice_type']; exit();
            $data['title']="Invoice || Consignments";
            $this->load->model('Mdl_consignee_billing');
            $data['consignee_billing']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
            $this->load->model('Mdl_transport_invoice_rate');
            $data['record']=$this->Mdl_transport_invoice_rate->getTransportInvoiceRecordByBillingID($_POST['consignee_billing_name']);
            $data['consignee_billing_name']=$_POST['consignee_billing_name'];
            $this->load->view('invoice/add_transport_consignment_invoice',$data);
        }
      else
      {
          $data['title']="Transportation Invoice";
          $data['place']=$this->Mdl_place->getplace("","","","","");
          $data['item']=$this->Mdl_item->getitem("","","","","");
          $data['vehicle']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
          $data['employee']=$this->Mdl_employee->getemployee("","","","","");
          $this->load->model('Mdl_warehouse');
          $data['warehouse']=$this->Mdl_warehouse->getwarehouse("","","","","");
          $this->load->model('Mdl_consignee_billing');
          $data['consignee_billing']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
          $this->load->view('invoice/add_transport_invoice',$data);
      }

    }

    public function TransportAddConsignment($transport_invoice_rate_id)
    {
        if (!empty($transport_invoice_rate_id))
        {
            $this->load->model('Mdl_consignee_billing');
            $transport_invoice_rate_id=encryptor("decrypt",$transport_invoice_rate_id);

            $data['transport_consignments']=$this->Mdl_invoice->getpendingtransportconsignments($transport_invoice_rate_id);
            $data['transport_invoice_rate_id']=$transport_invoice_rate_id;
            //print_r($data['transport_consignments']); exit();
            $this->load->view('invoice/records_transport_consignment_invoice',$data);
        }
        else
        {
           redirect(base_url('Invoice/TransportAdd'), 'refresh');
        }
    }
    public function TransportCreateConsignmentInvoice()
    {
        if(isset($_POST['transport_invoice_rate_id']))
        {
            $this->Mdl_invoice->TransportCreateConsignmentInvoice($_POST);
            $this->session->set_flashdata('update','Invoice Created Successfully.');
            redirect('Invoice/Transport');
        }
        else
        {
            $this->session->set_flashdata('update','Invoice Creation Failed.');
            redirect($this->agent->referrer());
        }
    }

    
    public function add()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Invoice";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->model('Mdl_consignee_billing');
        $data['consignee_billing']=$this->Mdl_consignee_billing->getconsignee_billing("","","","","");
        $this->load->model('Mdl_invoicetype');
        $data['invoice_type']=$this->Mdl_invoicetype->getinvoicetype("","","","","");
        $this->load->view('invoice/select_invoice_type',$data);
    }
    public function getconsignment()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $invoice_type=$_POST['invoice_type'];
        

        if(isset($_POST['consignee_name']) && $invoice_type=="3")
        {

           $data['title']="Invoice";           
           $this->load->model('mdl_rent_item');
           $record=$this->mdl_rent_item->getrentitemByConsignee($_POST['consignee_name']);
           $data['bill_type']=$record['0']['rent_type'];
           $this->load->model('Mdl_consigment');
           if($data['bill_type']=="1")
           {
            $_POST['bill_type']=$data['bill_type'];
            $this->Mdl_invoice->saverentinvoice($_POST);
           }
           else
           {            
            $data['record']=$this->Mdl_consigment->getPendingRentConsignment($_POST['consignee_name']);
            $data['consignee_name']=$_POST['consignee_name'];
            $this->load->view('invoice/consignment_record',$data);
           }
           
        }
        else if(isset($_POST['consignee_billing_name']) && $invoice_type=="5")
        {
           $data['title']="Invoice";
           $this->load->model('Mdl_transport_invoice_rate');
           $data['record']=$this->Mdl_transport_invoice_rate->getTransportInvoiceRecordByBillingID($_POST['consignee_billing_name']);
           $data['consignee_billing_name']=$_POST['consignee_billing_name'];
           $this->load->view('invoice/transport_invoice_rate',$data);
        }
        else if(isset($_POST['consignee_name']) && $invoice_type=="4")
        {
           $data['title']="Invoice";
           $this->load->model('Mdl_rent_warehouse');
           $data['record']=$this->Mdl_rent_warehouse->getrentwarehousebyconsigneeid($_POST['consignee_name']);
           $data['consignee_name']=$_POST['consignee_name'];
           $this->load->view('invoice/warehouse_invoice_rate',$data);
        }
        else if(isset($_POST['consignee_billing_name']) && $invoice_type=="6")
        {
           $data['title']="Invoice";
           $this->load->model('Mdl_labor_invoice_rate');
           $data['record']=$this->Mdl_labor_invoice_rate->getLaborInvoiceRecordByBillingID($_POST['consignee_billing_name']);
           $data['consignee_billing_name']=$_POST['consignee_billing_name'];
           $this->load->view('invoice/labor_invoice_rate',$data);
        }

    }
    public function edit($id)
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $invoice_id=encryptor("decrypt",$id);
        $data['title']="Invoice";
        $record=$this->Mdl_invoice->getConsigneebyinvoiceid(encryptor('decrypt',$id));
        $data['consignee_name']=$record->consignee_id;
        $data['invoice_id']=$id;
        $this->load->model('Mdl_consigment');
        $data['invoice']=$this->Mdl_consigment->getConsignmentByInvoiceID($invoice_id);
        $data['record']=$this->Mdl_consigment->getPendingRentConsignment($data['consignee_name']);
        $this->load->view('invoice/edit_consignment_record',$data);
    }
    public function boxrent()
    {
//		print_r($_POST); exit();
        if($this->session->userdata('user_id') == '')
         redirect(base_url(), 'refresh');
        $this->Mdl_invoice->saverentinvoice($_POST);
        redirect(base_url('invoice'));
    }

    public function warehouserent()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->Mdl_invoice->savewarehouserentinvoice($_POST);
        redirect(base_url('invoice'));
    }
    public function transportinvoice()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->Mdl_invoice->savetransportinvoice($_POST);
        redirect(base_url('invoice'));
    }
    public function laborinvoice()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->Mdl_invoice->savelaborinvoice($_POST);
        redirect(base_url('invoice'));
    }
    public function boxrentupdate()
    {
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->Mdl_invoice->updaterentinvoice($_POST);
        redirect(base_url('invoice'));
    }
    
    public function printinvoice($id="")
    {
        if(empty($id))
            redirect('invoice');
        else
        {
            $data['record']=$this->Mdl_invoice->getinvoicebyid(encryptor('decrypt',$id));
            
            $data['extra']=$this->Mdl_invoice->getextraparam(encryptor('decrypt',$id));
            
            if($data['record']['invoice']->invoice_type_id=="3")
            {
//				echo $data['record']['invoice']->consignee_id; exit;
                if(empty($data['extra']))
                {

                   // echo $data['record']['invoice']->consignee_id; exit;
                    if($data['record']['invoice']->consignee_id=="1")
                    {

                        $this->load->view('invoice/print_jmt_invoice',$data);
                    }
                    else if($data['record']['invoice']->consignee_id=="2")
                    {

                        $this->load->view('invoice/print_rsb_invoice',$data);
                    }

                    elseif ($data['record']['invoice']->consignee_id=="13" || $data['record']['invoice']->consignee_id=="50" || $data['record']['invoice']->consignee_id=="86"
                    || $data['record']['invoice']->consignee_id=="126"
                    || $data['record']['invoice']->consignee_id=="60"
                    || $data['record']['invoice']->consignee_id=="142"
                    || $data['record']['invoice']->consignee_id=="81"
                    || $data['record']['invoice']->consignee_id=="139"
                    ) {
                        $data['consignee']=$this->Mdl_invoice->getshippingAddress($data['record']['annexure']['0']['consignee_id']);
                        $this->load->view('invoice/print_seco_invoice',$data);
                    }
                    else
                    $this->load->view('invoice/print_invoice',$data);
                }
                    
                else

                    $this->load->view('invoice/print_invoice_param',$data);
            }
            else if($data['record']['invoice']->invoice_type_id=="4")
            {

                $this->load->view('invoice/print_warehouse_invoice',$data);
            }
            else if($data['record']['invoice']->invoice_type_id=="5" || $data['record']['invoice']->invoice_type_id=="2")
            {

                //var_dump($data['record']['invoice']->consignee_id);

                if($data['record']['invoice']->billing_address_id=="12")
                {  
                    $this->load->view('invoice/print_transport_caparo_invoice',$data);
                }
                else if($data['record']['invoice']->billing_address_id=="14" && isset($data['record']['location'])  && $data['record']['location']->source_id==2 && $data['record']['location']->destination_id==13)
                {  
                    $this->load->view('invoice/print_transport_reps_invoice',$data);
                }
                else   
                    $this->load->view('invoice/print_transport_invoice',$data);
            }
            else
            {    
                $this->load->view('invoice/print_labor_invoice',$data);
            }    
        }
    }
    
    
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_invoice->getinvoice($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['invoice_no'];
            $arr[]=date('d-m-Y',strtotime($row['invoice_date']));
            if(empty($row['consignee_billing_name']))
                $arr[]=$row['consignee_name'];
            else
                $arr[]=$row['consignee_billing_name'];
            $arr[]=$row['total_tax'];
            $arr[]=$row['round_off'];
            $arr[]=$row['invoice_total'];
            $arr[]=$row['category_name'];
            $str="";
            if($row['is_invoice_sent']=="0")
                $str="<a href='#' class='btn btn-success btn_invoice_sent' refid='".$row['invoice_id']."'>Pending</a>";
            else if(!empty($row['tracking_no']))
            {
                $str="<a style='color:green' href='#'  class='btn_tracking' tracking_no='".$row['tracking_no']."' courier_name='".$row['courier_name']."'><i class='fa fa-map-marker fa-2x'></i></a>";
            }
            else
            {
                $str="<span style='color:green'>&#10003;</span>";
            }
            if($row['invoice_status']=="1")
            {
                $str.="<span style='color:green'>&nbsp;&nbsp; &#10003;</span>";
            }
            $arr[]=$str;
            if(!empty($row['receipt_date']))
                $arr[]=date('d-m-Y',strtotime($row['receipt_date']));
            else
                $arr[]=" ";
            $arr[]="<div class='col-sm-6'><a style='display:none;' href='".base_url('invoice/edit/').encryptor("encrypt",$row['invoice_id'])."'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."' class=''  target='_blank'><i class='fa fa-print'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    
       public function getrecordrent()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_invoice->getinvoicerent($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['invoice_no'];
            $arr[]=date('d-m-Y',strtotime($row['invoice_date']));
            if(empty($row['consignee_billing_name']))
                $arr[]=$row['consignee_name'];
            else
                $arr[]=$row['consignee_billing_name'];
            $arr[]=$row['total_tax'];
            $arr[]=$row['round_off'];
            $arr[]=$row['invoice_total'];
            $arr[]=$row['category_name'];
            $str="";
            if($row['is_invoice_sent']=="0")
                $str="<a href='#' class='btn btn-success btn_invoice_sent' refid='".$row['invoice_id']."'>Pending</a>";
            else if(!empty($row['tracking_no']))
            {
                $str="<a style='color:green' href='#'  class='btn_tracking' tracking_no='".$row['tracking_no']."' courier_name='".$row['courier_name']."'><i class='fa fa-map-marker fa-2x'></i></a>";
            }
            else
            {
                $str="<span style='color:green'>&#10003;</span>";
            }
            if($row['invoice_status']=="1")
            {
                $str.="<span style='color:green'>&nbsp;&nbsp; &#10003;</span>";
            }
            $arr[]=$str;
            if(!empty($row['receipt_date']))
                $arr[]=date('d-m-Y',strtotime($row['receipt_date']));
            else
                $arr[]=" ";
            $arr[]="<div class='col-sm-6'><a style='display:none;' href='".base_url('invoice/edit/').encryptor("encrypt",$row['invoice_id'])."'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."' class=''  target='_blank'><i class='fa fa-print'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

    public function getrecordtransport()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_invoice->getinvoicetransport($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['invoice_no'];
            $arr[]=date('d-m-Y',strtotime($row['invoice_date']));
            if(empty($row['consignee_billing_name']))
                $arr[]=$row['consignee_name'];
            else
                $arr[]=$row['consignee_billing_name'];
            $arr[]=$row['total_tax'];
            $arr[]=$row['round_off'];
            $arr[]=$row['invoice_total'];
            $arr[]=$row['category_name'];
            $str="";
            if($row['is_invoice_sent']=="0")
                $str="<a href='#' class='btn btn-success btn_invoice_sent' refid='".$row['invoice_id']."'>Pending</a>";
            else if(!empty($row['tracking_no']))
            {
                $str="<a style='color:green' href='#'  class='btn_tracking' tracking_no='".$row['tracking_no']."' courier_name='".$row['courier_name']."'><i class='fa fa-map-marker fa-2x'></i></a>";
            }
            else
            {
                $str="<span style='color:green'>&#10003;</span>";
            }
            if($row['invoice_status']=="1")
            {
                $str.="<span style='color:green'>&nbsp;&nbsp; &#10003;</span>";
            }
            $arr[]=$str;
            if(!empty($row['receipt_date']))
                $arr[]=date('d-m-Y',strtotime($row['receipt_date']));
            else
                $arr[]=" ";
            $arr[]="<div class='col-sm-6'><a style='display:none;' href='".base_url('invoice/edit/').encryptor("encrypt",$row['invoice_id'])."'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."' class=''  target='_blank'><i class='fa fa-print'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    } 
    
    
    public function bookdebts()
    {
        $this->load->view('invoice_report/bookdebts_form');
    }
    public function getbookdebts()
    {
        
        $data['form_data']=$this->Mdl_invoice->bookdebts();
        $data['title'] = "invoice Report";
        $this->load->view('invoice_report/display_bookdebts',$data);
    }
    function changeSentStatus()
    {
        $invoice_id=$_POST['invoice_id'];
        $this->Mdl_invoice->changeSentStatus($invoice_id);
    }
    public function track()
    {
        $courier_name=$_POST['courier_name'];
        $tracking_no=$_POST['tracking_no'];
        $url="https://track.aftership.com/".$courier_name."/".$tracking_no;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://track.aftership.com/dtdc/K18153926",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: fc9b96cf-5b99-246d-5b30-1403857c48b0"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }

    }
}
