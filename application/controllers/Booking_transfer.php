<?php

class Booking_transfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="payment_booking";
        $this->load->model('Mdl_payment_booking');
        $this->load->model('Mdl_setting');
        

    }
    public function index()
    {
        $data['title']="Payment Booking";
        $data['total_outstanding']=$this->Mdl_payment_booking->getTotalOutstanding();
        $this->load->view('booking_transfer/booking_transfer_details',$data);
    }
    
    function deleterecord(){
         $payment_booking_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_payment_booking->deletebyid($payment_booking_id);
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
        $temp=$this->Mdl_payment_booking->getpending_booking($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        
        echo json_encode($temp);
    }
    public function confirm_payment()
    {
        $payment_booking_id = encryptor("decrypt", $this->input->post('booking_id'));
        $payment_mode= $this->input->post('payment_mode');
        $record=$this->Mdl_payment_booking->paybyid($payment_booking_id,$payment_mode);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
}
?>