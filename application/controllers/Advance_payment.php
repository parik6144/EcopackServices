<?php
class Advance_payment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_advance_payment');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Consignment";
        $this->load->view('advance_payment/advance_payment_details',$data);
    }
    
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_advance_payment->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignment_no'];
            $arr[]=date("d-m-Y",strtotime($row['consignment_date']));
            $arr[]=$row['owner_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['bank_name'];
            $arr[]=$row['branch'];
            $arr[]=$row['account_no'];            
            $arr[]=$row['ifsc_code']; 
            $arr[]=$row['GSTIN']; 
            $arr[]=$row['amount']; 
            
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>