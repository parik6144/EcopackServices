<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Monthly_salary extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Monthly Salary";
        $this->load->view('salary/select_month',$data);
    }
    public function getsalary()
    {
        //echo system('cmd /c F:\xampp\mysql_start.bat');

        $month=$_POST['monthly_salary'];
        $this->load->model('Mdl_employee_salary');
        $this->Mdl_employee_salary->getmonthlysalary($month);
    }
    
}
?>