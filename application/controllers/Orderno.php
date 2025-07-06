<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Orderno extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $data['title']="Place";
        $this->load->model('Mdl_order_no');
        $this->load->model('Mdl_setting');
    }
    public function index()
    {
        $data['title']="Order No";
        $this->load->view('order_no/order_no_details',$data);
    }
    public function add()
    {
        if(isset($_POST['consignee_id']))
        {
            $lastid=$this->Mdl_order_no->saveorderno($_POST);
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
        if(isset($_POST['consignee_id']))
        {
            $this->Mdl_order_no->updateorderno($_POST);

        }
        else {
            $data['title'] = "Edit place";
            $order_no_id = encryptor("decrypt", $this->input->get('id'));
            $data['form_data'] = $this->Mdl_order_no->getplacebyid($order_no_id);
            $this->load->view('place/edit_place', $data);
        }
    }
    function deleterecord(){
         $order_no_id = encryptor("decrypt", $this->input->post('delete'));
         $record=$this->Mdl_order_no->deletebyid($order_no_id);
         if($record==1)
            echo "true";
        else
            echo "false";
    }
    public function addpopup()
    {
        $data['title']="Add place";

        $data['condition']='popup';
        $this->load->model('Mdl_consignee');
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->model('Mdl_invoicetype');
        $data['invoicetype']=$this->Mdl_invoicetype->getinvoicetype("","","","","");
        $this->load->view('order_no/add_order_no',$data);
    }
    public function editpopup()
    {

        $data['title'] = "Edit Order No";
        $data['condition']='popup';
        $order_no_id = encryptor("decrypt", $this->input->get('id'));
        $this->load->model('Mdl_consignee');
        $data['consignee']=$this->Mdl_consignee->getconsignee("","","","","");
        $this->load->model('Mdl_invoicetype');
        $data['invoicetype']=$this->Mdl_invoicetype->getinvoicetype("","","","","");
        $data['form_data'] = $this->Mdl_order_no->getordernobyid($order_no_id);
        $this->load->view('order_no/edit_order_no', $data);
    }
    public function getrecord()
    {

        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp=$this->Mdl_order_no->getplace($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
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
            $arr[]=$row['consignee_name'];
            $arr[]=$row['category_name'];
            $arr[]=$row['order_no'];
            $arr[]=$row['vendor_code'];
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['order_no_id'])."' class='btn_editrecord'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['order_no_id'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            array_push($data['data'],$arr);
            $ctr++;
        }
        echo json_encode($data);
    }

}
?>