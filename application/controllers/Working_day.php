<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Working_day extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="working_day";
        $this->load->model('Mdl_working_day');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        
        $data['title']="working_day";
        $this->load->view('working_day/working_day_details',$data);
    }
    public function add()
    {
        if(isset($_POST['working_day_name']))
        {
            $lastid=$this->Mdl_working_day->saveworking_day($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add working_day";
            $this->load->view('working_day/add_working_day',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['working_day_name']))
        {
            $this->Mdl_working_day->updateworking_day($_POST);

        }
        else {
            $data['title'] = "Edit working_day";
            $working_day_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_working_day->getworking_daybyid($working_day_id);
            $this->load->view('working_day/edit_working_day', $data);
        }
    }
    function deleterecord(){
         $working_day_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_working_day->deletebyid($working_day_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add working_day";

        $data['condition']='popup';
        $this->load->view('working_day/add_working_day',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit working_day";
        $data['condition']='popup';
        $working_day_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_working_day->getworking_daybyid($working_day_id);
        $this->load->view('working_day/edit_working_day', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_working_day->getworking_day($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['working_day_name'];
            $arr[]=date("d-m-Y", strtotime($row['working_day_date']));
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['working_day_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['working_day_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>