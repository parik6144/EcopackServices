<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Project extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="project";
        $this->load->model('Mdl_project');
        header("Access-Control-Allow-Origin: *");
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        
        $data['title']="project";
        $this->load->view('project/project_details',$data);
    }
    public function add()
    {
        if(isset($_POST['project_name']))
        {
            $lastid=$this->Mdl_project->saveproject($_POST);
            redirect(base_url('project'));
        }
        else
        {
            $data['title']="Add project";
            $this->load->model('Mdl_place');
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $this->load->view('project/add_project',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['project_name']))
        {
            $this->Mdl_project->updateproject($_POST);
            redirect(base_url('project'));

        }
        else {
            $data['title'] = "Edit project";
            $this->load->model('Mdl_place');
            $data['place']=$this->Mdl_place->getplace("","","","","");
            $project_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_project->getprojectbyid($project_id);
            $this->load->view('project/edit_project', $data);
        }
    }
    function deleterecord(){
         $project_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_project->deletebyid($project_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_project->getproject($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            //project_id,project_name,`quotation_date`, p.place_name as source, pa.place_name as destination,total_costing,remarks
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-Y",strtotime($row['quotation_date']));
            $arr[]=$row['project_name'];
            $arr[]=$row['source'];
            $arr[]=$row['destination'];
            $arr[]=$row['total_costing'];
            $str="<select class='form-control sm project_status'>";
            $tmpstr='';
            if($row['project_status']=='0')
                $tmpstr="selected='selected'";
            $str.="<option value='0' ".$tmpstr.">Pending</option>";
            $tmpstr='';
            if($row['project_status']=='1')
                $tmpstr="selected='selected'";
            $str.="<option value='1'  ".$tmpstr.">Waiting for PO</option>";
            $tmpstr='';
            if($row['project_status']=='2')
                $tmpstr="selected='selected'";
            $str.="<option value='2' ".$tmpstr.">Started</option>";
            $tmpstr='';
            if($row['project_status']=='3')
                $tmpstr="selected='selected'";
            $str.="<option value='3' ".$tmpstr.">Rejected</option>";
            $str.="</select>";
            $arr[]="Pending";
            $arr[]=$str;
             $arr[]="<a refid='".encryptor("encrypt",$row['project_id'])."' href='#' class='btn_savestatus'><i class='fa fa-save fa-1x'></i></a>";

            $arr[]="<div class='col-sm-6'><a href='".base_url('project/edit?id=').encryptor("encrypt",$row['project_id'])."' refid='".encryptor("encrypt",$row['project_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['project_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            $arr[]="<a  href='".base_url('project/printletter?id=').encryptor("encrypt",$row['project_id'])."' target ='_blank' class=''><i class='fa fa-print fa-1x'></i></a>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function getac()
    {
        $data=$this->Mdl_project->getnotification();
        $response["notification_text"]=$data['0']["notification_text"];
        $response["notification_heading"]=$data['0']["notification_heading"];
        echo json_encode($response);
    }
    public function changestatus(){
        $project_id = encryptor("decrypt", $this->input->post('refid'));
         $record=$this->Mdl_project->updateprojectstatus($project_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function ongoing()
    {
        $data['title']="project";
        $this->load->view('project/project_onging_details',$data);
    }
    public function running()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_project->getrunningproject($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            //project_id,project_name,`quotation_date`, p.place_name as source, pa.place_name as destination,total_costing,remarks
            $arr=[];
            $arr[]=$ctr;
            $arr[]=date("d-m-Y",strtotime($row['quotation_date']));
            $arr[]=$row['project_name'];
            $arr[]=$row['source'];
            $arr[]=$row['destination'];
            $arr[]=$row['total_costing'];
            $str="<select class='form-control sm project_status'>";
            $tmpstr='';
            if($row['project_status']=='2')
                $tmpstr="selected='selected'";
            $str.="<option value='2' ".$tmpstr.">Started</option>";
            $tmpstr='';
            if($row['project_status']=='3')
                $tmpstr="selected='selected'";
            $str.="<option value='3' ".$tmpstr.">Rejected</option>";
            $str.="</select>";
            $arr[]="Pending";
            $arr[]=$str;
             $arr[]="<a refid='".encryptor("encrypt",$row['project_id'])."' href='#' class=''><i class='fa fa-print fa-1x'></i></a>";

            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function printletter()
    {
        //$this->load->view('print_letter');
        $data['title'] = "Edit project";
        // $this->load->model('Mdl_place');
        // $data['place']=$this->Mdl_place->getplace("","","","","");
         $project_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_project->getprojectbyid($project_id);
        $this->load->view('project/printletter', $data);
    }
}
?>