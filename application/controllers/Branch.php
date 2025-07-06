<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Branch extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="branch";
        $this->load->model('Mdl_branch');
        $this->load->model('Mdl_setting');
        

    }
    public function index()
    {
        $data['title']="branch";
        $this->load->view('branch/branch_details',$data);
    }
    public function add()
    {
        if(isset($_POST['branch_name']))
        {
            $lastid=$this->Mdl_branch->savebranch($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add branch";
            $this->load->view('branch/add_branch',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['branch_name']))
        {
            $this->Mdl_branch->updatebranch($_POST);

        }
        else {
            $data['title'] = "Edit branch";
            $branch_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_branch->getbranchbyid($branch_id);
            $this->load->view('branch/edit_branch', $data);
        }
    }
    function deleterecord(){
         $branch_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_branch->deletebyid($branch_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add branch";
        $data['condition']='popup';
        $this->load->view('branch/add_branch',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit branch";
        $data['condition']='popup';
        $branch_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_branch->getbranchbyid($branch_id);
        $this->load->view('branch/edit_branch', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_branch->getbranch($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['branch_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['branch_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['branch_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>