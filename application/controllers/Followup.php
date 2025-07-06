<?php
class Followup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_followup');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Consignment";
        $this->load->view('followup/followup_consignment_details',$data);
    }
    public function editpopup()
    {

        if(isset($_POST['consignment_id']))
        {
            $lastid=$this->Mdl_followup->savefollowup($_POST);
            //redirect(base_url('consignment'));
        }
        else if(isset($_POST['followup_id']))
        {
            $lastid=$this->Mdl_followup->savefollowup($_POST);
            exit;
        }
        else
        {
            $data['title'] = "Edit consignment";
            $data['condition'] = "popup";
            $consignment_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data']=$this->Mdl_followup->getfollowupbyid($consignment_id);
            $this->load->view('followup/add_followup', $data);
        }
    }
    
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_followup->getconsignment($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['consignor_name'];
            $arr[]=$row['consignee_name'];
            $arr[]=$row['vehicle_inward_no'];
            $arr[]=$row['driver_name'];
            $arr[]=$row['mobile_no'];            
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['consignment_id'])."' class='btn_editrecord'><i class='fa fa-map-marker fa-2x'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>