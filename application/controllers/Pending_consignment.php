<?php
class Pending_consignment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_pending_consignment');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Consignment";
        $this->load->view('pending_consignment/pending_consignment_details',$data);
    }
    public function changestatus()
    {
        $refid=encryptor("decrypt",$_POST['refid']);
        $this->Mdl_pending_consignment->changestatus($refid);
        echo "true";
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_pending_consignment->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $data["sql"]=$temp['qry'];
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['consignment_no'];
            $arr[]=date("d-m-Y",strtotime($row['consignment_date']));
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
            $arr[]=$row['mobile_no'];            
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignment_id'])."' class='btn_deleterecord'>Pending</a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>