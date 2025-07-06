<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Employee_type extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $data['title']="Employee Type";
        $this->load->model('mdl_employee_type');
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        $data['title']="Employee Type";
        $this->load->view('employee_type/employee_type_details',$data);
    }
    public function add()
    {
        if(isset($_POST['type_name']))
        {
            $lastid=$this->mdl_employee_type->saveemployee_type($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add Employee Type";
            $this->load->view('employee_type/add_employee_type',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['type_name']))
        {
            $this->mdl_employee_type->updateemployee_type($_POST);

        }
        else {
            $data['title'] = "Edit Employee Type";
            $employee_employee_type_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_employee_type->getemployee_typebyid($employee_employee_type_id);
            $this->load->view('employee_type/edit_employee_type', $data);
        }
    }
    function deleterecord(){
         $employee_employee_type_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_employee_type->deletebyid($employee_employee_type_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add Employee_Type";

        $data['condition']='popup';
        $this->load->view('employee_type/add_employee_type',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Employee Type";
        $data['condition']='popup';
        $employee_employee_type_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_employee_type->getemployee_typebyid($employee_employee_type_id);
        $this->load->view('employee_type/edit_employee_type', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_employee_type->getemployee_type($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
         $ctr=1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['type_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['employee_type_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['employee_type_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    

}
?>