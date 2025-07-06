<?php
class Ledger extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
         $data['title']="Driver Report";
         //$this->load->model('Mdl_setting');
         $this->load->model('Mdl_setting');
         $this->load->model('Mdl_consignee');
         $this->load->model('Mdl_ledger');
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
        //print_r($record); exit();
        foreach ($record as $row) { $consignment_id = $row['consignment_id'];
                $str.="<tr>";
                $str.= "<td class='text-center'>".date("d-m-Y",strtotime($row['date']))."</td>";

                // GET CONSIGNMENT NUMBER DATE STARTS HERE.
                $consignment_id=$row['consignment_id'];
                $this->db->select('`consignment_no`,`consignment_date`');
                $this->db->from('tbl_consignment');
                $this->db->where('consignment_id', $consignment_id);
                $result=$this->db->get();
                //echo $this->db->last_query();
                $res = $result->row();
                $consignment_no= $res->consignment_no;
                $consignment_date= $res->consignment_date;
                //print_r($res);
                // GET CONSIGNMENT NUMBER DATE STARTS ENDS.

                $str.= "<td class='text-center'>".$consignment_no."</td>";
                $str.= "<td class='text-center'>".$consignment_date."</td>";
                if($row['transaction_type']=="0")
                    $str.= "<td class='text-center'>Payment</td>";
                else
                    $str.= "<td class='text-center'>Receipt</td>";
                $str.= "<td class='text-center'>".$row['consignment_id']."</td>";
                $str.= "<td class='text-center'>".$row['perticular']."</td>";
                if(empty($row['ref_id']))
                {
                    $str.= "<td class='text-center'>".$row['account_name']."</td>";
                }
                else
                {
                    $rec=$this->Mdl_payment_booking->getUserName($row['receiver_type'],$row['ref_id']);
                    $str.= "<td class='text-center'>".$rec->ref_name."</td>";
                }
                $str.= "<td class='text-center'>".$mode[$row['payment_mode']]."</td>";
                if($row['transaction_type']=="0")
                {
                    $str.= "<td class='text-center'>0</td>";
                    $str.= "<td class='text-center'>".$row['amount']."</td>";
                    $drtotal+=$row['amount'];
                }
                else
                {
                    $str.= "<td class='text-center'>".$row['amount']."</td>";
                    $str.= "<td class='text-center'>0</td>";
                    $crtotal+=$row['amount'];
                }
                $str.="</tr>";
            # code...
        }
        $str.="<tr>";
        $str.="<td></td><td></td>";
        $str.="<td class='text-right' colspan='6'>Total</td>";
        $str.="<td class='text-center'>".$crtotal."</td>";
        $str.="<td class='text-center'>".$drtotal."</td>";
        $str.="<tr>";
        $data['html']=$str;
        $this->load->view('ledger/display_ledger',$data);
    }
    
     public function PartyLedger()
    {
        $data['title']="Party Ledger";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        //echo '<pre>'; print_r($data); exit();
        $this->load->view('ledger/consignee_ledger_form',$data);
    }
    
     public function show_consignee_details($id) {
        $data['consignee'] = $this->Mdl_consignee->getconsigneebyid($id);
        return $data;
    }
    
      public function getconsigneeledgerreport(){
        $data['title'] = "Consignee Ledger Report";
        $consigneeId = $_REQUEST['consignee_id'];
        $data['from_date'] = $from_date = date('Y-m-d', strtotime($_REQUEST['date_from']));
        $data['to_date'] = $to_date = date('Y-m-d', strtotime($_REQUEST['date_to']));
        $data['ledger_date'] = $ledger_date = date('Y-m-d');
        $data['consigneeDetails'] = $this->show_consignee_details($consigneeId);
        $consigneebilling_id = $data['consigneeDetails']['consignee']['consignee'][0]['billing_id'];  
        $data['ledger_records'] = $this->Mdl_ledger->getconsigneeledgerbybillingid($consigneebilling_id,$from_date,$to_date);
       //  echo "<pre>"; print_r($data['ledger_records']); exit();
        $this->load->view('ledger/consignee_ledger_records',$data);
    }
}
?>