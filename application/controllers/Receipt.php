<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Receipt extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('Mdl_receipt');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Receipt";
        $this->load->view('receipt/receipt_details',$data);
    }
    
    public function add()
    {
        if(isset($_POST['amount']))
        {
            $lastid=$this->Mdl_receipt->savereceipt($_POST);
            echo "true";
        }
        else
        {
            
            $data['title']="Add payment booking";
            $this->load->model('Mdl_consignee_billing');
            $data['consignee']=$this->Mdl_consignee_billing->getconsignee_billing("","","","",""); 
            // echo 2112; exit();
            $this->load->view('receipt/select_receipt_company',$data); 
        }
    }
    public function getPendingInvoice()
    {
        $this->load->model('Mdl_invoice');
        $data['form_data']=$this->Mdl_invoice->getPendingInvoiceByConsignee();
        $data['billing_id']=$_POST['consignee_billing_id'];
        $data['title']="Select Consignee";
        $this->load->view('receipt/add_receipt',$data);
    }
    
    function deleterecord(){
         $payment_booking_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_receipt->deletebyid($payment_booking_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_receipt->getreceipt($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-Y",strtotime($row['receipt_date']));
            $arr[]=$row['consignee_billing_name'];
            $arr[]=$row['invoice_no'];
            $arr[]=$row['invoice_total'];
            $arr[]=$row['amount'];
            $arr[]=$row['tds'];
            if($row['invoice_status']=="0")
                 $arr[]="pending";
            else
                $arr[]="cleared";
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['receipt_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['receipt_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function confirm_booking()
    {
        $payment_booking_id = encryptor("decrypt", $this->input->post('booking_id'));
        $record=$this->Mdl_payment_booking->confirmbyid($payment_booking_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>