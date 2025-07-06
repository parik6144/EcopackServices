<?php
class Place_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Place Report";
       $this->load->model('Mdl_setting'); 
    }
    public function index()
    {
        $this->load->model('Mdl_place');
        $data['title']="place Report";
        $data['consignee']=$this->Mdl_place->getplace("","","","","");
        $this->load->view('place_report/place_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_followup');
        $data['form_data']=$this->Mdl_followup->getreportByPlace();
        $data['title'] = "place Report";
        $this->load->view('place_report/display_place_report',$data);
    }
}
?>