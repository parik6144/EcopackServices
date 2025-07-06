<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Invoicetype extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="invoicetype";
        $this->load->model('Mdl_invoicetype');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {
        $data['title']="invoicetype";
        $this->load->view('invoicetype/invoicetype_details',$data);
    }
    public function add()
    {
        if(isset($_POST['category_name']))
        {
            $lastid=$this->Mdl_invoicetype->saveinvoicetype($_POST);
            echo encryptor("encrypt",$lastid);
        }
        else
        {
            $data['title']="Add invoicetype";
            $this->load->view('invoicetype/add_invoicetype',$data);
        }
    }
    public function edit()
    {
        if(isset($_POST['category_id']))
        {
            $this->Mdl_invoicetype->updateinvoicetype($_POST);

        }
        else {
            $data['title'] = "Edit invoicetype";
            $category_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_invoicetype->getinvoicetypebyid($category_id);
            $this->load->view('invoicetype/edit_invoicetype', $data);
        }
    }
    function deleterecord(){
         $category_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_invoicetype->deletebyid($category_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add invoicetype";

        $data['condition']='popup';
        $this->load->view('invoicetype/add_invoicetype',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit invoicetype";
        $data['condition']='popup';
        $category_id = encryptor("decrypt", $this->input->get('id'));
        $data['form_data'] = $this->Mdl_invoicetype->getinvoicetypebyid($category_id);
        $this->load->view('invoicetype/edit_invoicetype', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_invoicetype->getinvoicetype($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['category_name'];
            $arr[]=$row['hsn_code'];
            $arr[]=$row['tax_rate'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['category_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['category_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>