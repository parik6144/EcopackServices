<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Place extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        /*if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');*/
        $data['title']="Place";
        $this->load->model('Mdl_place');
        header("Access-Control-Allow-Origin: *");
        $this->load->model('Mdl_setting');
    }
    
    public function index()
    {
        
        $data['title']="Place";
        $this->load->view('place/place_details',$data);
    }
    public function add()
    {
        if(isset($_POST['place_name']))
        {
            $lastid=$this->Mdl_place->saveplace($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add place";
            $this->load->view('place/add_place',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['place_name']))
        {
            $this->Mdl_place->updateplace($_POST);

        }
        else {
            $data['title'] = "Edit place";
            $place_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_place->getplacebyid($place_id);
            $this->load->view('place/edit_place', $data);
        }
    }
    function deleterecord(){
         $place_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_place->deletebyid($place_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add place";

        $data['condition']='popup';
        $this->load->view('place/add_place',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit place";
        $data['condition']='popup';
        $place_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_place->getplacebyid($place_id);
        $this->load->view('place/edit_place', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_place->getplace($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$this->input->get('start')+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['place_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['place_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['place_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    public function getac()
    {
        $data=$this->Mdl_place->getnotification();
        $response["notification_text"]=$data['0']["notification_text"];
        $response["notification_heading"]=$data['0']["notification_heading"];
        echo json_encode($response);
    }
}
?>