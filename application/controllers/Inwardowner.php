<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Inwardowner extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Inward Owner";
        //$this->load->model('mdl_inward_owner');
        $this->load->model('mdl_inward_owner');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Inward Owner";
        $this->load->view('inward_owner/inward_owner_details',$data);
    }
    public function add()
    {
        if(isset($_POST['owner_name']))
        {
            $lastid=$this->mdl_inward_owner->saveinward_owner($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add Inward Owner";
            $start="";
            $length="";
            $searchstr="";
            $this->load->view('inward_owner/add_inward_owner',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['owner_name']))
        {
            return $this->mdl_inward_owner->updateinward_owner($_POST);
        }
        else {
            $data['title'] = "Edit Inward Owner";
            $inward_owner_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_inward_owner->getinward_ownerbyid($inward_owner_id);
            $this->load->view('inward_owner/edit_inward_owner', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add Inward Owner";
        $data['condition']='popup';
        $start="";
        $length="";
        $this->load->view('inward_owner/add_inward_owner',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit Inward Owner";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $inward_owner_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_inward_owner->getinward_ownerbyid($inward_owner_id);
        $this->load->view('inward_owner/edit_inward_owner', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_inward_owner->getinward_owner($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
        $ctr=$start+1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['owner_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$row['city'];
            $arr[]=$row['pincode'];
            $arr[]=$row['gstin'];
            $arr[]=$row['bank_name'];
            $arr[]=$row['branch'];
            $arr[]=$row['account_no'];
            $arr[]=$row['ifsc_code'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['owner_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['owner_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }
    function deleterecord(){
        $inward_owner_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->mdl_inward_owner->deletebyid($inward_owner_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>