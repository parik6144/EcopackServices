<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Tax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Tax";
        $this->load->model('Mdl_tax');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Tax";
        $this->load->view('tax/tax_details',$data);
    }
    public function add()
    {
        if(isset($_POST['tax_name']))
        {
            $lastid=$this->Mdl_tax->savetax($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add tax";
            $this->load->view('tax/add_tax',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['tax_name']))
        {
            $this->Mdl_tax->updatetax($_POST);

        }
        else {
            $data['title'] = "Edit tax";
            $tax_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_tax->gettaxbyid($tax_id);
            $this->load->view('tax/edit_tax', $data);
        }
    }
    function deleterecord(){
         $tax_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_tax->deletebyid($tax_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add tax";

        $data['condition']='popup';
        $this->load->view('tax/add_tax',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit tax";
        $data['condition']='popup';
        $tax_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_tax->gettaxbyid($tax_id);
        $this->load->view('tax/edit_tax', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_tax->gettax($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        //var_dump($temp);
        //exit;
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        $data["data"]=array();
         $ctr=1;
        foreach ($temp['data'] as $row)
        {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['tax_name'];
            $arr[]=$row['tax_rate'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['tax_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['tax_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>