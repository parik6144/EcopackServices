<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Staff extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $data['title']="staff";
        $this->load->model('mdl_staff');

    }
    public function index()
    {
        $data['title']="staff";
        $this->load->view('staff/staff_details',$data);
    }
    public function add()
    {
        if(isset($_POST['staff_name']))
        {
            $now = new DateTime();
            $filenm=$now->format('Y-m-d__H_i_s').".jpg";
            $config['upload_path']="./uploads";
            $config['allowed_types']='gif|jpg|png';
            $config['max_size'] = '1024';
            $config['file_name'] = $filenm;
            $this->load->library('upload',$config);
            if($this->upload->do_upload("photo")){
                
                $lastid=$this->mdl_staff->savestaff($_POST,$filenm);
                echo "true";
            }
            else
            {
                $lastid=$this->mdl_staff->savestaff($_POST,"");
                echo $this->upload->display_errors();
            }
        }
        else
        {
            $data['title']="Add staff Type";
            $this->load->model('mdl_employee_type');
            $data['employee_type']=$this->mdl_employee_type->getemployee_type("","","","","");
            $this->load->view('staff/add_staff',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['staff_name']))
        {
            
            $now = new DateTime();
            $filenm=$now->format('Y-m-d__H_i_s').".jpg";
            $config['upload_path']="./uploads";
            $config['allowed_types']='gif|jpg|png';
            $config['max_size'] = '1024';
            $config['file_name'] = $filenm;
            $this->load->library('upload',$config);
            if($this->upload->do_upload("photo")){
                
                $this->mdl_staff->updatestaff($_POST,$filenm);
                echo "true";
            }
            else
            {
                $this->mdl_staff->updatestaff($_POST);
            }

        }
        else {
            $data['title'] = "Edit staff Type";
            $staff_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_staff->getstaffbyid($staff_id);

            $this->load->view('staff/edit_staff', $data);
        }
    }
    function deleterecord(){
         $staff_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_staff->deletebyid($staff_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add staff";
        $this->load->model('mdl_employee_type');
        $data['employee_type']=$this->mdl_employee_type->getemployee_type("","","","","");
        $data['condition']='popup';
        $data['last_id']=$this->mdl_staff->getLastId();
        $this->load->view('staff/add_staff',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit staff Type";
        $data['condition']='popup';
        $staff_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_staff->getstaffbyid($staff_id);
        $this->load->model('mdl_employee_type');
        $data['employee_type']=$this->mdl_employee_type->getemployee_type("","","","","");
        $this->load->view('staff/edit_staff', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_staff->getstaff($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
         $ctr=1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['emp_no'];
            if(empty($row['photo']))
            {
                $arr[]="<img src='uploads/avatar.png' class='img-thumb'/>";
            }
            else
            {
                $arr[]="<img src='".base_url('uploads/'.$row['photo'])."' class='img-thumb'/>";
            }

            $arr[]=$row['staff_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['type_name'];
            $arr[]=$row['email_id'];
            $arr[]=$row['blood_group'];
             $arr[]=$row['gstin'];
            $arr[]=$row['bank_name'];
            $arr[]=$row['branch'];
            $arr[]=$row['account_no'];
            $arr[]=$row['ifsc_code'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['staff_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['staff_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function login()
    {
        $temp=$this->mdl_staff->getstafflogin();
        if(sizeof($temp)==0)
            echo "false";
        else
            echo json_encode($temp);
    }
    

}
?>