<?php
class Diesel_report extends CI_Controller
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
        $data['title']="Diesel Report";
        $this->load->view('diesel_report/diesel_report_form',$data);
    }
    public function getreport(){
        $this->load->model('Mdl_inwardrate');
        $data['form_data']=$this->Mdl_inwardrate->getreportByOwnerId();
        $data['title'] = "Diesel Report";
        $this->load->view('diesel_report/display_diesel_report',$data);
    }
}
?>