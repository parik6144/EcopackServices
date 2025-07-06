<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Owner extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="owner";
        //$this->load->model('mdl_owner');
        $this->load->model('mdl_owner');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="owner";
        $this->load->view('owner/owner_details',$data);
    }
    public function add()
    {
        if(isset($_POST['owner_name']))
        {
            $lastid=$this->mdl_owner->saveowner($_POST);
            echo $lastid;
        }
        else
        {
            $data['title']="Add owner";
            $start="";
            $length="";
            $searchstr="";
            $data['uom']=$this->mdl_uom->getuom($start,$length,"","0","Asc");
            $this->load->view('owner/add_owner',$data);
        }
    }
   
    public function edit()
    {

        if(isset($_POST['owner_name']))
        {
            return $this->mdl_owner->updateowner($_POST);
        }
        else {
            $data['title'] = "Edit owner";
            $owner_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->mdl_owner->getownerbyid($owner_id);
            $this->load->view('owner/edit_owner', $data);
        }
    }

    public function addpopup()
    {
        $data['title']="Add owner";
        $data['condition']='popup';
        $start="";
        $length="";
        $this->load->view('owner/add_owner',$data);
    }
    public function editpopup()
    {
        $data['title'] = "Edit owner";
        $data['condition']='popup';
        $start="";
        $length="";
        $searchstr="";
        $owner_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->mdl_owner->getownerbyid($owner_id);
        $this->load->view('owner/edit_owner', $data);
    }
    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->mdl_owner->getowner($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
        $owner_id = encryptor("decrypt", $this->input->post('delete'));

        $record=$this->mdl_owner->deletebyid($owner_id);
        if($record==1)
            echo "true";
        else
            echo "false";
    }

}
?>