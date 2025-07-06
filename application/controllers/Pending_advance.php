<?php
class Pending_advance extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_pending_advance');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Consignment";
        $data['total']=$this->Mdl_pending_advance->gettotaladvance();
        $this->load->view('pending_advance/pending_advance_details',$data);
    }
    public function changestatus()
    {
        $refid=encryptor("decrypt",$_POST['refid']);
        $this->Mdl_pending_advance->changestatus($refid);
        echo "true";
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_pending_advance->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['owner_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['bank_name'];
            $arr[]=$row['account_no'];            
            $arr[]=$row['ifsc_code']; 
            $totalpay=0;
            $advance=0;
            if($row['bill_type']=="1")
            {
//                $arr[]=$row['qty']*$row['advance'];
//                $totalpay+=$row['qty']*$row['advance'];
//                $advance+=$row['qty']*$row['advance'];
//                $totalpay+=$row['qty']*$row['due'];

                $arr[] = $row['advance'];
                $totalpay+=$row['advance'];
                $advance+=$row['advance'];
                $totalpay+=$row['due'];
            }
            else           
            {
                $arr[]=$row['advance']; 
                $totalpay+=$row['advance'];
                $advance+=$row['advance'];
                $totalpay+=$row['due'];
            }
            $tds=($totalpay*2)/100;
            $arr[]=$tds;
            $arr[]=round($advance-$tds);
            $arr[]="<select class='form-control payment_mode'>
            <option value=''>Select Mode</option>
            <option value='0'>Neft</option>
            <option value='1'>Cheque</option>
            <option value='2'>Cash</option>
            <option value='3'>Neft With TDS</option>
            <option value='4'>Cheque With TDS</option>
            <option value='5'>Cash With TDS</option>
            </select>";            
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignment_id'])."' class='btn_deleterecord'>Pay</a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>