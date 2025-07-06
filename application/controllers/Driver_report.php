<?php
class Driver_report extends CI_Controller
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
        $this->load->model('Mdl_vehicle_inward');
        $data['title']="Driver Report";
        $data['consignee']=$this->Mdl_vehicle_inward->getvehicle_inward("","","","","");
        $this->load->view('driver_report/driver_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_inwardrate');
        $data['form_data']=$this->Mdl_inwardrate->getreportByVehicleId();
        $data['title'] = "Stock Report";
        $this->load->view('driver_report/display_driver_report',$data);
    }
}
?>