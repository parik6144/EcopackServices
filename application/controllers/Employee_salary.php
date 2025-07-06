<?php
class Employee_salary extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('mdl_employee_salary');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Employee Salary";
        $this->load->view('employee_salary/employee_salary_details',$data);
    }
    public function add()
    {
        if(isset($_POST['staff_id']))
        {
            $this->mdl_employee_salary->save_employee_salary($_POST);
        }
    }
    public function edit()
    {
        if(isset($_POST['staff_id']))
        {
            $this->mdl_employee_salary->update_employee_salary($_POST);
        }
    }
    public function addpopup()
    {
        $data['title']="Add";
        $this->load->model('mdl_staff');
        $data['staff']=$this->mdl_staff->getstaff("","","","","");
        $data['condition']='popup';
        $this->load->view('employee_salary/add_employee_salary',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit staff Type";
        $data['condition']='popup';
        $staff_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_employee_salary->getemployeesalarybyid($staff_id);
        $this->load->model('mdl_staff');
        $data['staff']=$this->mdl_staff->getstaff("","","","","");
        $this->load->view('employee_salary/edit_employee_salary', $data);
        
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_employee_salary->getemployee_salary($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['emp_no'];
            $arr[]=$row['staff_name'];
            $arr[]=$row['basic'];
            $arr[]=$row['da'];
            $arr[]=$row['hra'];
            $arr[]=$row['cea'];
            $arr[]=$row['tpa'];
            $arr[]=$row['ot_per_hour'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['salary_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['salary_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
}
?>