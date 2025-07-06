<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Designations extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $data['title']="Designations";
        $this->load->model('mdl_designations');
        $this->load->model('Mdl_setting');
        $this->load->model('mdl_employee_type');
    }
    
    public function index()
    {
        $data['title']="Designations";
        $this->load->view('designations/designations_details',$data);
    }

    public function add()
    {
        if(isset($_POST['designation_name']))
        {
            $lastid=$this->mdl_designations->savedesignations($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add Designations";
            $data['employee_type'] = $this->mdl_employee_type->getemployee_type();
            $this->load->view('designations/add_designations',$data);
        }
    }

    public function edit()
    {
        if(isset($_POST['designation_name']))
        {
            $this->mdl_designations->updatedesignations($_POST);

        }
        else {
            $data['title'] = "Edit Designations";
            $designations_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_designations->getdesignationsbyid($designations_id);
            $data['employee_type'] = $this->mdl_employee_type->getemployee_type();
            $this->load->view('designations/edit_designations', $data);
        }
    }

    function deleterecord(){
         $designations_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_designations->deletebyid($designations_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    
    public function addpopup()
    {
//		echo 77777777777; exit();
        $data['title']="Add Designations";
        $data['condition']='popup';
        $data['employee_type'] = $this->mdl_employee_type->getemployee_type();
        $this->load->view('designations/add_designations',$data);
    }

    public function editpopup()
    {
        $data['title'] = "Edit Designations";
        $data['condition']='popup';
        $designations_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_designations->getdesignationsbyid($designations_id);
        $data['employee_type'] = $this->mdl_employee_type->getemployee_type();
        $this->load->view('designations/edit_designations', $data);
    }

    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_designations->getdesignations($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=1;
        foreach ($temp['data'] as $row)
        {
            $arr = array();
            $arr[] = $ctr;  // SL. No
            $arr[] = $row['designation_name'];  // Designation
            $arr[] = $row['department_name'];  // Department
            $arr[] = "<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['designation_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['designation_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";  // Actions
            array_push($data['data'], $arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    
}
?> 
