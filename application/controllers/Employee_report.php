<?php
class Employee_report extends CI_Controller
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
        $this->load->model('Mdl_employee');
        $this->load->model('mdl_inward_employee');
        $data['title']="Employee Report";
        //$data['consignee']=$this->Mdl_employee->getemployee("","","","","");
        $data['inward_employee']=$this->mdl_inward_employee->getinward_employee("","","","","");
        $this->load->view('employee_report/employee_report_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_inwardrate');
        $data['form_data']=$this->Mdl_inwardrate->getreportByEmployeeId();
        $data['title'] = "Employee Report";
        $this->load->view('employee_report/display_employee_report',$data);
    }
}
?>