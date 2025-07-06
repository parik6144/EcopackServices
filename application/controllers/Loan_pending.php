<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Loan_pending extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        
        $this->load->model('Mdl_loan');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="loan Pending";
        $data['data']=$this->Mdl_loan->getPendingloan();
        $this->load->view('loan_pending/loan_pending_details',$data);
    }
    
    
    public function getrecord()
    {
        $current_month=date('m');
        $current_year=date('Y');
        $current_day=date('d');
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_loan->getPendingloan($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
        // $current_month=date('m');
        // $current_year=date('Y');
        // $current_day=date('d');
            if(date("m",strtotime($row['booking_date']))<$current_month)
            {
                $bookingday=date("d",strtotime($row['loan_date']));
                $bookingday=$bookingday-4;
                if($bookingday<=$current_day)
                {
                    $arr=[];
                    $arr[]=$ctr;
                    $arr[]=$row['party_name'];
                    $arr[]=date("d-m-y",strtotime($row['loan_date']));
                    //$arr[]=$row['loan_amount'];
                    //$arr[]=$row['due_amount'];
                    //$arr[]=$row['interest_rate'];
                    $arr[]=$row['monthly_emi'];
                    //$arr[]=$row['loan_time'];
                    if($row['loan_type']=="1")
                        $arr[]="EMI";
                    else if($row['loan_type']=="2")
                        $arr[]="Interest";
                    $arr[]="<div class='col-sm-6'><a href='".base_url('payment_booking/loanbooking/').encryptor("encrypt",$row['loan_id'])."' class='btn_book'>book</a></div>";
                    array_push($data['data'],$arr);
                    $ctr++;
                }
                
            }

        }
        echo json_encode($data);
    }
    function deleterecord(){
        $loan_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->Mdl_loan->deletebyid($loan_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>