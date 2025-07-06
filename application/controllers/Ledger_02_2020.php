<?php
class Ledger extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Driver Report";
        
    }
    public function index()
    {
        $data['title']="Ledger";
        $this->load->model('Mdl_staff');
        $this->load->model('Mdl_employee');
        $this->load->model('Mdl_inward_owner');
        $this->load->model('Mdl_account');
        $data['staff']=$this->Mdl_staff->getstaff("","","","","");
            $data['employee']=$this->Mdl_employee->getemployee("","","","","");
            $data['account']=$this->Mdl_account->getaccount("","","","","");
            $data['owner']=$this->Mdl_inward_owner->getinward_owner("","","","","");
        $this->load->view('ledger/ledger_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_ledger');
        $this->load->model('Mdl_payment_booking');
        $record=$this->Mdl_ledger->getledger();
        $data['title'] = "Ledger Report";
        $str="";
        $drtotal=0;
        $crtotal=0;
        $mode=array('NEFT','CHEQUE','CASH','NEFT','CHEQUE','CASH');
        foreach ($record as $row) {
                $str.="<tr>";
                $str.= "<td>".date("d-m-Y",strtotime($row['date']))."</td>";
                if($row['transaction_type']=="0")
                    $str.= "<td>Payment</td>";
                else
                    $str.= "<td>Receipt</td>";
                $str.= "<td>".$row['consignment_id']."</td>";
                $str.= "<td>".$row['perticular']."</td>";
                if(empty($row['ref_id']))
                {
                    $str.= "<td>".$row['account_name']."</td>";
                }
                else
                {
                    $rec=$this->Mdl_payment_booking->getUserName($row['receiver_type'],$row['ref_id']);
                    $str.= "<td>".$rec->ref_name."</td>";
                }
                $str.= "<td>".$mode[$row['payment_mode']]."</td>";
                if($row['transaction_type']=="0")
                {
                    $str.= "<td>0</td>";
                    $str.= "<td>".$row['amount']."</td>";
                    $drtotal+=$row['amount'];
                }
                else
                {
                    $str.= "<td>".$row['amount']."</td>";
                    $str.= "<td>0</td>";
                    $crtotal+=$row['amount'];
                }
                $str.="</tr>";
            # code...
        }
        $str.="<tr>";
        $str.="<td colspan='6'>Total</td>";
        $str.="<td>".$crtotal."</td>";
        $str.="<td>".$drtotal."</td>";
        $str.="<tr>";
        $data['html']=$str;
        $this->load->view('ledger/display_ledger',$data);
    }
}
?>