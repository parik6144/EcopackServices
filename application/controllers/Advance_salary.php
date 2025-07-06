<?php
class Advance_salary extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        /*if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');*/
        $data['title']="Advance Salary";
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        //$this->load->model('Mdl_consignee_billing');
        $data['title']="Advance Salary";
        $this->load->view('advance_salary/advance_salary_form',$data);
    }
    
    public function getreport(){
        $this->load->model('Mdl_advance_salary');
        $data['form_data']=$this->Mdl_advance_salary->getAdvanceSalary();
        $data['title'] = "Advance Salary";
        $this->load->view('advance_salary/display_advance_salary',$data);
    }
}
?>