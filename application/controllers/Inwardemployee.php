<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Inwardemployee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Inward employee";
        //$this->load->model('mdl_inward_employee');
        $this->load->model('mdl_inward_employee');
        $this->load->model('mdl_consignor');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Inward employee";
        $this->load->view('inward_employee/inward_employee_details',$data);
    }
    public function add()
    {
        if(isset($_POST['employee_name']))
        {
            $lastid=$this->mdl_inward_employee->saveinward_employee($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Inward employee";
            $start="";
            $length="";
            $searchstr="";
            $data['consignor']=$this->mdl_consignor->getconsignor("","","","","");
            $this->load->view('inward_employee/add_inward_employee',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['employee_name']))
        {
            return $this->mdl_inward_employee->updateinward_employee($_POST);
        }
        else {
            $data['title'] = "Edit Inward employee";
            $inward_employee_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_inward_employee->getinward_employeebyid($inward_employee_id);
            $this->load->view('inward_employee/edit_inward_employee', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Inward Employee";
        $data['condition']='popup';
        $start="";
        $length="";
        $data['consignor']=$this->mdl_consignor->getconsignor("","","","","");
        $this->load->view('inward_employee/add_inward_employee',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Inward employee";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $inward_employee_id = encryptor("decrypt", $this->input->get('id'));
        $data['consignor']=$this->mdl_consignor->getconsignor("","","","","");
        $data['form_data'] = $this->mdl_inward_employee->getinward_employeebyid($inward_employee_id);
        $this->load->view('inward_employee/edit_inward_employee', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_inward_employee->getinward_employee($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['employee_name'];
            $arr[]=$row['consignor_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['employee_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['employee_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
        $inward_employee_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->mdl_inward_employee->deletebyid($inward_employee_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }
    function getEmployeeByConsignorId()
    {
        echo json_encode($this->mdl_inward_employee->getEmployeeByConsignor($this->input->post('consignor_id')));
    }

}
?>