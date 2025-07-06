<?php
class Consignment_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Driver Report";
        $this->load->model('Mdl_setting');
        
    }
    public function index()
    {
        $this->load->model('Mdl_consignee');
        $data['title']="Consignment Report";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->view('consignment_report/consignment_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_consigment');
        $data['form_data']=$this->Mdl_consigment->getreportByconsigneeId();
        $data['title'] = "Consignment Report";
        $this->load->view('consignment_report/display_consignment_report',$data);
    }
}
?>