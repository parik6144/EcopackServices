<?php
class Followup_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Consigment";
        $this->load->model('Mdl_followup');
        $this->load->model('Mdl_consignee');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Followup Report";
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->view('followup_report/followup_report_form',$data);
    }
    
    public function getreport(){
        $data['title'] = "Followup Report";
        if($_POST['consignee_name']=="9")
        {
            $data['form_data']=$this->Mdl_followup->getReport();
            $this->load->view('followup_report/display_reps_report',$data);
        }
        else
        {
            $data['form_data']=$this->Mdl_followup->getReport();
            $this->load->view('followup_report/display_report',$data);
        }
        
    }
}
?>