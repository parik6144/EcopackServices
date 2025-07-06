<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Expense_head extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="expense_head";
        $this->load->model('Mdl_expense_head');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="expense_head";
        $this->load->view('expense_head/expense_head_details',$data);
    }
    public function add()
    {
        if(isset($_POST['expense_head_name']))
        {
            $lastid=$this->Mdl_expense_head->saveexpense_head($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add expense_head";
            $this->load->view('expense_head/add_expense_head',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['expense_head_name']))
        {
            $this->Mdl_expense_head->updateexpense_head($_POST);

        }
        else {
            $data['title'] = "Edit expense_head";
            $expense_head_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_expense_head->getexpense_headbyid($expense_head_id);
            $this->load->view('expense_head/edit_expense_head', $data);
        }
    }
    function deleterecord(){
         $expense_head_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_expense_head->deletebyid($expense_head_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add expense head";
        $data['condition']='popup';
        $this->load->model('Mdl_account');
        $this->load->model('Mdl_staff');
        $this->load->view('expense_head/add_expense_head',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit expense_head";
        $data['condition']='popup';
        $expense_head_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_expense_head->getexpense_headbyid($expense_head_id);
        $this->load->view('expense_head/edit_expense_head', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_expense_head->getexpense_head($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['expense_head_name'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['expense_head_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['expense_head_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>