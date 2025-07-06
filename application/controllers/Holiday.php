<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Holiday extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="holiday";
        $this->load->model('Mdl_holiday');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        
        $data['title']="holiday";
        $this->load->view('holiday/holiday_details',$data);
    }
    public function add()
    {
        if(isset($_POST['holiday_name']))
        {
            $lastid=$this->Mdl_holiday->saveholiday($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add holiday";
            $this->load->view('holiday/add_holiday',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['holiday_name']))
        {
            $this->Mdl_holiday->updateholiday($_POST);

        }
        else {
            $data['title'] = "Edit holiday";
            $holiday_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_holiday->getholidaybyid($holiday_id);
            $this->load->view('holiday/edit_holiday', $data);
        }
    }
    function deleterecord(){
         $holiday_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_holiday->deletebyid($holiday_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add holiday";

        $data['condition']='popup';
        $this->load->view('holiday/add_holiday',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit holiday";
        $data['condition']='popup';
        $holiday_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_holiday->getholidaybyid($holiday_id);
        $this->load->view('holiday/edit_holiday', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_holiday->getholiday($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['holiday_name'];
            $arr[]=date("d-m-Y", strtotime($row['holiday_date']));
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['holiday_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['holiday_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>