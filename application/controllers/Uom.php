<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Uom extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="UOM";
        $this->load->model('mdl_uom');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="UOM";
        $this->load->view('uom/uom_details',$data);
    }
    public function add()
    {
        if(isset($_POST['full_name']))
        {
            $lastid=$this->mdl_uom->saveuom($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add UOM";
            $this->load->view('uom/add_uom',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['full_name']))
        {
            $this->mdl_uom->updateuom($_POST);

        }
        else {
            $data['title'] = "Edit UOM";
            $uom_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_uom->getuombyid($uom_id);
            $this->load->view('uom/edit_uom', $data);
        }
    }
    function deleterecord(){
         $uom_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->mdl_uom->deletebyid($uom_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add UOM";

        $data['condition']='popup';
        $this->load->view('uom/add_uom',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit UOM";
        $data['condition']='popup';
        $uom_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_uom->getuombyid($uom_id);
        $this->load->view('uom/edit_uom', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_uom->getuom($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
         $ctr=1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['full_name'];
            $arr[]=$row['short_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['uom_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['uom_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>