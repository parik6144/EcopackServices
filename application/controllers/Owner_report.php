<?php
class Owner_report extends CI_Controller
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
        $this->load->model('Mdl_inward_owner');
        $data['title']="Owner Report";
        $data['consignee']=$this->Mdl_inward_owner->getinward_owner("","","","","");
        $this->load->view('owner_report/owner_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_inwardrate');
        $data['form_data']=$this->Mdl_inwardrate->getreportByOwnerId();
        $data['title'] = "Owner Report";
        $this->load->view('owner_report/display_owner_report',$data);
    }
}
?>